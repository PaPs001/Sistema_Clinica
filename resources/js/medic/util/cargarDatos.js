import { renderPaginator } from "./paginador";

export async function cargarDatos({
    url,
    contenedor,
    template,
    campos = {},
    limpio = true,
    paginationContainer,
    onRender = null
}) {

    const cont = document.querySelector(contenedor);
    const tmplt = document.querySelector(template);
    const pagination = document.querySelector(paginationContainer);

    if (!cont) {
    console.error(`No se encontró el contenedor: ${contenedor}`);
    }

    if (!tmplt) {
        console.error(`No se encontró el template: ${template}`);
    }

    if (!cont || !tmplt) return;


    async function cargarPagina(page = 1) {
        try {
            const res = await fetch(`${url}?page=${page}`);
            const data = await res.json();
            console.log("PAGINACION:", data.pagination);
            const lista = Array.isArray(data) ? data : (data.data || []);

            if (limpio) cont.innerHTML = "";

            lista.forEach(item => {
                console.log("ITEM:", item);
                const nodo = tmplt.content.cloneNode(true).firstElementChild;
                if (item.id) {
                    const btnView = nodo.querySelector('.btn-view-users');
                    const btnEdit = nodo.querySelector('.btn-abrir-permisos');
                    if (btnEdit) btnEdit.dataset.id = item.id;
                    if (btnView) btnView.dataset.roleId = item.id;
                }
                const nombreArchivo = item.file_name || item.nombre || "";
                const fileExt = nombreArchivo.toString().split('.').pop().toLowerCase();
                const nodoCard = nodo.querySelector(".file-card");
                if (nodoCard) {
                    if (["pdf"].includes(fileExt)) nodoCard.classList.add("tipo-pdf");
                    if (["doc", "docx"].includes(fileExt)) nodoCard.classList.add("tipo-word");
                    if (["jpg", "jpeg", "png"].includes(fileExt)) nodoCard.classList.add("tipo-img");
                    if (["xlsx", "xls"].includes(fileExt)) nodoCard.classList.add("tipo-excel");
                }
                for (const selector in campos) {
                    const cmp = campos[selector];
                    const elmt = nodo.querySelector(selector);

                    if (elmt) {
                        if (typeof cmp === "function") {
                            const valor = cmp(item);
                            if (typeof valor === "function") {
                                valor(elmt);
                            } else {
                                elmt.textContent = valor;
                            }
                        } else {
                            elmt.textContent = item[cmp];
                        }
                    }
                }
                cont.appendChild(nodo);
            });
            if (typeof onRender === "function") {
                console.log("Ejecutando onRender...");
                onRender(lista);
            }
            if (data.current_page && data.last_page) {
                pagination.innerHTML = data.pagination;
                activadorLinksPaginador(pagination, cargarPagina);
            }
        } catch (err) {
            console.error("Error cargando datos:", err);
        }
    }
    cargarPagina(1);
    return cargarPagina;
}

function activadorLinksPaginador(contenedor, callback) {
    const links = contenedor.querySelectorAll("a");

    links.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const url = new URL(link.href);
            const page = url.searchParams.get("page");

            if (page) callback(Number(page));
        });
    });
}

window.toggleExpandibleUser = function(header) {
    const item = header.closest(".accordion-item");
    item.classList.toggle("open");

    /*const icon = header.querySelector(".icon");
    icon.classList.toggle("rotate");*/
};

window.toggleExpandibleUser = toggleExpandibleUser; 