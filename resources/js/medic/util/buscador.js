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

    contenedor.style.display = "none";

    let timeout = null;

    input.addEventListener("input", () => {
        clearTimeout(timeout);

        timeout = setTimeout(async () => {
            const query = input.value.trim();

            if (query.length < 1) {
                contenedor.innerHTML = "";
                contenedor.style.display = "none";
                return;
            }

            try {
                const finalUrl = (typeof url === "function") ? url(query) : url + query;
                const response = await fetch(finalUrl);
                const data = await response.json();
                contenedor.innerHTML = "";

                if (!Array.isArray(data) || data.length === 0) {
                    contenedor.innerHTML = `
                        <div style="padding: 8px; color: #999;">
                            No se encontraron resultados para "${query}"
                        </div>
                    `;
                    contenedor.style.display = "block";
                    return;
                }

                data.forEach(item => {
                    const div = document.createElement("div");
                    div.classList.add("item-sugerencia");
                    div.textContent = renderItem(item);

                    div.addEventListener("click", () => {
                        onSelect(item);
                        contenedor.innerHTML = "";
                        contenedor.style.display = "none";
                    });

                    contenedor.appendChild(div);
                });

                contenedor.style.display = "block";

            } catch (error) {
                contenedor.innerHTML = `
                    <div style="padding: 8px; color: #999;">
                        Error al buscar resultados
                    </div>
                `;
                contenedor.style.display = "block";
                console.error("Error en crearBuscador:", error);
            }

        }, 300);
    });
}
