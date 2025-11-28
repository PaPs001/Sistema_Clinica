// Dashboard enfermera - alertas, pacientes activos y tareas del turno
console.log('Script dashboard enfermera cargado');

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

document.addEventListener('DOMContentLoaded', () => {
    inicializarDashboard();
});

function inicializarDashboard() {
    configurarEventos();
    cargarAlertas();
    cargarPacientes();
    cargarTareas();
}

let filtroCriticos = false;
let pacientesCache = [];
let signosCache = [];

function configurarEventos() {
    document.getElementById('filter-alerts')?.addEventListener('click', () =>
        notificar('Filtro de alertas en desarrollo', 'info')
    );
    document.getElementById('mark-all-read')?.addEventListener('click', marcarTodasLeidas);

    const filterBtn = document.getElementById('filter-patients');
    if (filterBtn) {
        filterBtn.addEventListener('click', () => {
            filtroCriticos = !filtroCriticos;
            filterBtn.innerHTML = `<i class="fas fa-filter"></i> ${filtroCriticos ? 'Ver todos' : 'Filtrar'}`;
            renderPacientes(pacientesCache, signosCache);
            notificar(filtroCriticos ? 'Mostrando solo críticos' : 'Mostrando todos', 'info');
        });
    }

    document.getElementById('export-patients')?.addEventListener('click', () => exportarPacientes('pacientes'));

    // Delegación alertas
    document.getElementById('alertas-container')?.addEventListener('click', (e) => {
        if (e.target.closest('.btn-atender')) {
            const card = e.target.closest('.alert-card');
            const paciente = card?.dataset.paciente || 'paciente';
            atenderAlerta(paciente);
        }
        if (e.target.closest('.btn-posponer')) {
            const card = e.target.closest('.alert-card');
            posponerAlerta(card);
        }
    });

    // Delegación pacientes
    document.getElementById('pacientes-body')?.addEventListener('click', (e) => {
        if (e.target.closest('.btn-signos')) window.location.href = '/signos-vitales';
        if (e.target.closest('.btn-medicar')) window.location.href = '/tratamientos';
    });

    // Delegación tareas
    document.getElementById('tareas-container')?.addEventListener('click', (e) => {
        if (e.target.closest('.btn-tarea')) {
            const task = e.target.closest('.task-item');
            realizarTarea(task?.dataset.titulo || 'tarea');
        }
    });
}

// -------- Alertas ----------
async function cargarAlertas() {
    try {
        const res = await fetch('/api/alertas');
        const data = res.ok ? await res.json() : [];
        renderAlertas(data.length ? data : alertasMock());
    } catch (error) {
        console.error(error);
        renderAlertas(alertasMock());
    }
}

function renderAlertas(alertas) {
    const container = document.getElementById('alertas-container');
    if (!container) return;
    container.innerHTML = '';
    if (!alertas.length) {
        container.innerHTML = '<div class="alert-empty">Sin alertas pendientes</div>';
        return;
    }

    alertas.forEach((a) => {
        const card = document.createElement('div');
        card.className = `alert-card ${mapSeveridad(a.severidad)}`;
        card.dataset.paciente = a.paciente;
        card.innerHTML = `
            <div class="alert-header">
                <h3>${a.titulo}</h3>
                <span class="alert-badge">${a.prioridad || 'Urgente'}</span>
            </div>
            <div class="alert-details">
                <p><i class="fas fa-user-injured"></i> <strong>Paciente:</strong> ${a.paciente} - Hab. ${a.habitacion || 'N/D'}</p>
                <p><i class="fas fa-heartbeat"></i> <strong>Lectura:</strong> ${a.lectura || 'N/D'}</p>
                <p><i class="fas fa-clock"></i> <strong>Hora:</strong> ${a.hora || '--:--'}</p>
            </div>
            <div class="alert-actions">
                <button class="btn-view btn-atender" aria-label="Atender alerta">Atender</button>
                <button class="btn-cancel btn-posponer" aria-label="Posponer alerta">Posponer</button>
            </div>
        `;
        container.appendChild(card);
    });
}

// -------- Pacientes ----------
async function cargarPacientes() {
    try {
        const [pacRes, signosRes, citasRes, tratRes] = await Promise.all([
            fetch('/api/pacientes'),
            fetch('/api/signos-vitales'),
            fetch('/api/citas'),
            fetch('/api/tratamientos'),
        ]);
        pacientesCache = pacRes.ok ? await pacRes.json() : [];
        signosCache = signosRes.ok ? await signosRes.json() : [];
        const citas = citasRes.ok ? await citasRes.json() : [];
        const tratamientos = tratRes.ok ? await tratRes.json() : [];

        const statCitas = document.getElementById('stat-citas');
        const statTrat = document.getElementById('stat-tratamientos');
        if (statCitas) statCitas.textContent = citas.length || 0;
        if (statTrat) statTrat.textContent = tratamientos.length || 0;

        renderPacientes(pacientesCache, signosCache);
    } catch (error) {
        console.error(error);
        pacientesCache = [];
        signosCache = [];
        renderPacientes([], []);
    }
}

function renderPacientes(pacientes, signos) {
    const tbody = document.getElementById('pacientes-body');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (!pacientes.length) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Sin pacientes activos</td></tr>';
        return;
    }

    const ultimos = obtenerUltimosSignos(signos);
    const lista = filtroCriticos
        ? pacientes.filter((p) => {
              const vit = ultimos[p.id] || {};
              return vit.tensionAlerta || vit.tempAlerta;
          })
        : pacientes;

    (lista.length ? lista : pacientes).forEach((pac) => {
        const vitals = ultimos[pac.id] || {};
        const estado = calcularEstado(vitals);

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <div class="patient-info">
                    <div class="patient-avatar"><i class="fas fa-user"></i></div>
                    <div>
                        <strong>${pac.name || 'Paciente'}</strong>
                        <span>${pac.age ? pac.age + ' años' : ''}</span>
                    </div>
                </div>
            </td>
            <td>${pac.room || pac.habitacion || 'N/D'}</td>
            <td><span class="status-badge ${estado.clase}">${estado.texto}</span></td>
            <td>
                <div class="vitals-info">
                    <span class="vital-item ${vitals.tensionAlerta ? 'high' : ''}">TA: ${vitals.ta || 'N/D'}</span>
                    <span class="vital-item">FC: ${vitals.fc || 'N/D'}</span>
                    <span class="vital-item ${vitals.tempAlerta ? 'high' : ''}">Temp: ${vitals.temp || 'N/D'}</span>
                </div>
            </td>
            <td>${vitals.hora || '--:--'}</td>
            <td>
                <button class="btn-view btn-signos" aria-label="Registrar signos">Signos</button>
                <button class="btn-cancel btn-medicar" aria-label="Medicar">Medicar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// -------- Tareas ----------
async function cargarTareas() {
    try {
        const res = await fetch('/api/tareas');
        const tareas = res.ok ? await res.json() : [];
        renderTareas(tareas.length ? tareas : tareasMock());
    } catch (error) {
        console.error(error);
        renderTareas(tareasMock());
    }
}

function renderTareas(tareas) {
    const container = document.getElementById('tareas-container');
    if (!container) return;
    container.innerHTML = '';

    if (!tareas.length) {
        container.innerHTML = '<div class="task-empty">Sin tareas para este turno</div>';
        return;
    }

    tareas.forEach((tarea) => {
        const item = document.createElement('div');
        item.className = `task-item ${tarea.estado || ''}`;
        item.dataset.titulo = tarea.titulo || 'Tarea';
        item.innerHTML = `
            <div class="task-content">
                <h4>${tarea.titulo}</h4>
                <p><i class="fas fa-map-marker-alt"></i> ${tarea.ubicacion || 'Habitación N/D'}</p>
                <p><i class="fas fa-clock"></i> ${tarea.hora || '--:--'} - <span class="task-status ${tarea.estado || ''}">${tarea.estadoLabel || ''}</span></p>
            </div>
            <button class="btn-view btn-tarea" aria-label="Realizar tarea">Realizar</button>
        `;
        container.appendChild(item);
    });
}

// -------- Acciones ----------
function marcarTodasLeidas() {
    document.querySelectorAll('.alert-card').forEach((c) => c.classList.add('is-read'));
    notificar('Alertas marcadas como leídas');
}

function atenderAlerta(paciente) {
    if (confirm(`¿Atender alerta de ${paciente}?`)) {
        window.location.href = '/signos-vitales';
    }
}

function posponerAlerta(card) {
    if (card && confirm('¿Posponer esta alerta?')) {
        card.remove();
        notificar('Alerta pospuesta');
    }
}

function realizarTarea(titulo) {
    const destino = inferirModulo(titulo);
    notificar(`Abriendo módulo para: ${titulo}`, 'info');
    if (destino) {
        setTimeout(() => {
            window.location.href = destino;
        }, 300);
    }
}

function exportarPacientes(tipo) {
    fetch('/api/exportar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ tipo }),
    })
        .then(async (res) => {
            if (!res.ok) throw new Error(`Error ${res.status}`);
            return res.json();
        })
        .then(async (data) => {
            const url = data.url;
            if (!url) throw new Error('Sin URL de descarga');

            try {
                // Intentar descarga directa
                const a = document.createElement('a');
                a.href = url.startsWith('http') ? url : `${window.location.origin}${url}`;
                a.target = '_blank';
                document.body.appendChild(a);
                a.click();
                a.remove();
                notificar('Exportación lista');
            } catch (e) {
                // Fallback: descarga por blob
                const resp = await fetch(url, { credentials: 'include' });
                const blob = await resp.blob();
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = url.split('/').pop() || 'export.xlsx';
                document.body.appendChild(link);
                link.click();
                link.remove();
                notificar('Exportación lista');
            }
        })
        .catch((err) => {
            console.error(err);
            notificar('No se pudo exportar', 'error');
        });
}

// -------- Helpers ----------
function obtenerUltimosSignos(signos) {
    const ult = {};
    signos.forEach((s) => {
        const id = s.patient_id;
        if (!id) return;
        if (!ult[id] || new Date(s.created_at) > new Date(ult[id].created_at)) {
            ult[id] = {
                ta: s.blood_pressure || 'N/D',
                fc: s.heart_rate || 'N/D',
                temp: s.temperature ? `${s.temperature}°C` : 'N/D',
                hora: s.created_at
                    ? new Date(s.created_at).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' })
                    : '--:--',
                tensionAlerta: s.blood_pressure && parseInt((s.blood_pressure || '0').split('/')[0], 10) >= 160,
                tempAlerta: s.temperature && s.temperature >= 38.5,
                created_at: s.created_at,
            };
        }
    });
    return ult;
}

function calcularEstado(vitals) {
    if (vitals.tensionAlerta || vitals.tempAlerta) return { texto: 'Crítico', clase: 'critical' };
    if (vitals.ta || vitals.temp) return { texto: 'Estable', clase: 'warning' };
    return { texto: 'Sin datos', clase: 'info' };
}

function mapSeveridad(severidad = '') {
    const map = {
        critica: 'critical',
        urgente: 'critical',
        alta: 'warning',
        media: 'warning',
        baja: 'info',
    };
    return map[severidad.toLowerCase()] || 'critical';
}

function alertasMock() {
    return [
        {
            titulo: 'Presión Arterial Crítica',
            paciente: 'Carlos Ruiz',
            habitacion: '304',
            lectura: '180/110 mmHg',
            hora: '10:30 AM',
            severidad: 'critica',
            prioridad: 'Urgente',
        },
        {
            titulo: 'Fiebre Elevada',
            paciente: 'Ana López',
            habitacion: '205',
            lectura: '39.2°C',
            hora: '11:15 AM',
            severidad: 'alta',
            prioridad: 'Alta',
        },
    ];
}

function tareasMock() {
    return [
        {
            titulo: 'Administrar insulina - Miguel Torres',
            ubicacion: 'Habitación 102',
            hora: '12:00 PM',
            estado: 'urgent',
            estadoLabel: 'Retrasado 30 min',
        },
        {
            titulo: 'Control signos vitales - Ana López',
            ubicacion: 'Habitación 205',
            hora: '01:15 PM',
            estado: 'pending',
            estadoLabel: 'Pendiente',
        },
    ];
}

function notificar(msg, tipo = 'success') {
    const prev = document.querySelector('.custom-notification');
    prev?.remove();
    const div = document.createElement('div');
    div.className = `custom-notification ${tipo}`;
    div.textContent = msg;
    div.style.cssText =
        'position:fixed;top:20px;right:20px;background:' +
        (tipo === 'error' ? '#dc3545' : tipo === 'info' ? '#0a1fa0' : '#061175') +
        ';color:#fff;padding:10px 15px;border-radius:8px;z-index:9999;';
    document.body.appendChild(div);
    setTimeout(() => div.remove(), 2500);
}

function inferirModulo(titulo = '') {
    const t = titulo.toLowerCase();
    if (t.includes('insulin') || t.includes('medic') || t.includes('administrar')) return '/medicamentos';
    if (t.includes('signos') || t.includes('vital')) return '/signos-vitales';
    if (t.includes('tratamiento')) return '/tratamientos';
    return null;
}
