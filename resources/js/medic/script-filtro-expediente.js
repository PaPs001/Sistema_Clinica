document.addEventListener('DOMContentLoaded', function () {
const inputNombreDiagnostico = document.getElementById('diagnostico');
    const sugerencias_diagnosticoDiv = document.getElementById('sugerencias-diagnosticos');
    const diagnostico_id = document.getElementById('diagnostico_id');
    let timeout = null;
    inputNombreDiagnostico.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(timeout);
        sugerencias_diagnosticoDiv.innerHTML = '';

        if (query.length < 2) return;

        timeout = setTimeout(() => {
            fetch(`/buscar-diagnostico?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    sugerencias_diagnosticoDiv.innerHTML = '';

                    if (data.length === 0) {
                        const item = document.createElement('div');
                        item.classList.add('sugerencia-item', 'text-muted');
                        item.textContent = 'Sin resultados';
                        sugerencias_diagnosticoDiv.appendChild(item);
                        return;
                    }

                    data.forEach(diagnostico => {
                        const item = document.createElement('div');
                        item.classList.add('sugerencia-item');
                        item.textContent = `${diagnostico.name}`;

                        item.addEventListener('click', () => {
                            inputNombreDiagnostico.value = diagnostico.name;
                            diagnostico_id.value = diagnostico.id;
                            sugerencias_diagnosticoDiv.innerHTML = '';
                            console.log("Diagnostico encontrado cargado:", diagnostico);
                        });

                        sugerencias_diagnosticoDiv.appendChild(item);
                    });
                })
                .catch(err => {
                    console.error("Error al buscar:", err);
                });
        }, 400);
    });

    document.addEventListener('click', (e) => {
        if (!sugerencias_diagnosticoDiv.contains(e.target) && e.target !== inputNombreDiagnostico) {
            sugerencias_diagnosticoDiv.innerHTML = '';
        }
    });
});
