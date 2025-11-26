export function abrirModalPermisos(modalId, roleName = null) {
    const modal = document.querySelector(modalId);

    if (!modal) {
        console.error(`No se encontró el modal con el ID: ${modalId}`);
        return;
    }

    if (roleName) {
        const title = modal.querySelector('.modal-title');
        if (title) title.textContent = `Permisos del rol: ${roleName}`;
    }

    modal.classList.add('show');
    modal.style.display = 'block';

    document.body.classList.add('modal-open');
}