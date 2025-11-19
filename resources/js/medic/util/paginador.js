export function renderPaginator({
    currentPage,
    totalPages,
    container,
    onPageChange
}) {
    container.innerHTML = "";

    const paginationDiv = document.createElement("div");
    paginationDiv.className = "d-flex justify-content-center align-items-center gap-3 my-3";

    if (currentPage > 1) {
        const btnPrev = document.createElement("button");
        btnPrev.textContent = "Anterior";
        btnPrev.classList.add("btn", "btn-primary", "btn-sm");
        btnPrev.onclick = () => onPageChange(currentPage - 1);
        paginationDiv.appendChild(btnPrev);
    }

    const indicator = document.createElement("span");
    indicator.className = "text-muted mx-2";
    indicator.textContent = `Página ${currentPage} de ${totalPages}`;
    paginationDiv.appendChild(indicator);

    if (currentPage < totalPages) {
        const btnNext = document.createElement("button");
        btnNext.textContent = "Siguiente";
        btnNext.classList.add("btn", "btn-primary", "btn-sm");
        btnNext.onclick = () => onPageChange(currentPage + 1);
        paginationDiv.appendChild(btnNext);
    }

    container.appendChild(paginationDiv);
}

