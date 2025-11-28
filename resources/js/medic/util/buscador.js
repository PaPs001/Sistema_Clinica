export function crearBuscador({ 
    input, 
    contenedor, 
    url, 
    renderItem, 
    onSelect 
}) {

    input = (input instanceof Element) ? input : document.querySelector(input);
    contenedor = (contenedor instanceof Element) ? contenedor : document.querySelector(contenedor);

    if (!input || !contenedor) {
        console.error("crearBuscador: input o contenedor no encontrados", { input, contenedor });
        return;
    }

    let timeout = null;

    input.addEventListener("input", () => {
        clearTimeout(timeout);

        timeout = setTimeout(async () => {
            const query = input.value.trim();

            if (query.length < 1) {
                contenedor.innerHTML = "";
                return;
            }

            try {
                const finalUrl = (typeof url === "function") ? url(query) : url + query;
                const response = await fetch(finalUrl);
                const data = await response.json();
                contenedor.innerHTML = "";
                if (data.length === 0) {
                    contenedor.innerHTML = `
                        <div style="padding: 8px; color: #999;">
                            No se encontraron pacientes para "${query}"
                        </div>
                    `;
                    return;
                }

                data.forEach(item => {
                    const div = document.createElement("div");
                    div.classList.add("item-sugerencia");
                    div.textContent = renderItem(item);

                    div.addEventListener("click", () => {
                        onSelect(item);
                        contenedor.innerHTML = "";
                    });

                    contenedor.appendChild(div);
                });

            } catch (error) {
                contenedor.innerHTML = `
                    <div style="padding: 8px; color: #999;">
                        Error al buscar pacientes
                    </div>
                `;
                console.error("Error en crearBuscador:", error);
            }

        }, 300);
    });
}
