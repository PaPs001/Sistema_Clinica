import {cargarDatos} from '../medic/util/cargarDatos.js';
import {abrirModalPermisos} from '../generales/abrirModal.js';
document.addEventListener('DOMContentLoaded', function() {
    cargarDatos({
        url: '/cargarDatos/Roles-permisos',
        contenedor: '#rolesTableBody',
        template: '#role-Template',
        paginationContainer: '#paginationContainer-roles',
        campos: {
            '.nombre-rol': item => item.name,
            '.permisos-roles': item => el => {
                el.innerHTML = '';

                let permisosRaw = item.permissions;
                let permisosArray = [];

                if (Array.isArray(permisosRaw)) {
                    permisosArray = permisosRaw;
                } else if (typeof permisosRaw === 'string') {
                    permisosArray = permisosRaw.split(',').map(p => p.trim()).filter(Boolean);
                } else if (permisosRaw != null) {
                    permisosArray = [String(permisosRaw)];
                }

                permisosArray.forEach(perm => {
                    const nombrePermiso = typeof perm === 'string' ? perm : perm.name ?? '';
                    if (!nombrePermiso) return;
                    const span = document.createElement('span');
                    span.classList.add('permission-tag');
                    span.textContent = nombrePermiso;
                    el.appendChild(span);
                });
            },
            '.usuarios-roles': item => item.users_count ?? 'N/A',
        },
        onRender: function() {
            document.querySelector('#rolesTableBody').addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-view-users');
                if (!btn) return;

                const roleId = btn.dataset.roleId;
                console.log("Cargando usuarios del rol:", roleId);
                cargarUsuariosPorRol(roleId);
            });
        }
    });
});

function cargarUsuariosPorRol(roleId) {
    cargarDatos({
        url: `/cargarDatos/Usuarios-por-rol/${roleId}`,
        contenedor: '#usuariosPorRolTableBody',
        template: '#usuarioPorRol-Template',
        paginationContainer: '#paginationContainer-usuarios-por-rol',
        campos: {
            '.nombre-usuario': item => item.name,
            '.rol-usuario': item => item.role,
            '.status-usuario': item => item.status,
        }
    });
}

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-abrir-permisos');
    if (!btn) return;

    console.log("Click detectado en botón permisos");

    const roleId = btn.dataset.id;

    console.log("RoleId:", roleId);

    abrirModalPermisos('#modalPermisos');
    cargarDatosRoles(roleId);
});
let currentRoleId = null;
function cargarDatosRoles(roleId){
    currentRoleId = roleId;
    cargarDatos({
        url: `/cargarDatos/permisos/${roleId}`,
        contenedor: '#permissionsContainer',
        template: '#permiso-Template',
        limpio: true,
        campos: {
            '.perm-check': item => el => {
                el.id = `perm-${item.id}`;
                el.value = item.id;
                if (item.asignado) el.checked = true;
            },
            '.perm-name': item => item.name
        },
        /*onRender: function () {
            document.getElementById("btnGuardarPermisos").onclick = () => {
                guardarPermisos(roleId);
            };
        }*/
    });
}

function cerrarModalPermisos(modalId) {
    const modal = document.querySelector(modalId); 
    if (!modal) {
        console.error(`No se encontró el modal con el ID: ${modalId}`);
        return;
    }

    modal.classList.remove('show');
    modal.style.display = 'none';
    document.body.classList.remove('modal-open');
}

window.cerrarModalPermisos = cerrarModalPermisos; 

document.getElementById("btnGuardarPermisos").addEventListener("click", guardarPermisos);

document.addEventListener('click', function (e) {
    const modal = document.getElementById('modalPermisos');
    if (!modal || !modal.classList.contains('show')) return;

    const isClickInside = e.target.closest('.modal-content');
    const clickedModalBackground = e.target === modal;

    if (!isClickInside && clickedModalBackground) {
        cerrarModalPermisos('#modalPermisos');
    }
});

function guardarPermisos() {
    if (!currentRoleId) {
        console.error("No hay roleId actual");
        return;
    }
    const checked = [...document.querySelectorAll(".perm-check:checked")]
                    .map(ch => ch.value);

    console.log("Permisos seleccionados:", checked);

    fetch(`/permisos/${currentRoleId}/guardar-permisos`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            permisos: checked
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Respuesta:", data);
        alert("Permisos guardados correctamente");
        cerrarModalPermisos('#modalPermisos');
    })
    .catch(err => {
        console.error("Error al guardar:", err);
    });
}
