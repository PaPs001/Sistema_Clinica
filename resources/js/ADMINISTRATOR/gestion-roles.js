import {cargarDatos} from '../medic/util/cargarDatos.js';

document.addEventListener('DOMContentLoaded', function() {
    cargarDatos({
        url: '/cargarDatos/Roles-permisos',
        contenedor: '#rolesTableBody',
        template: '#role-Template',
        paginationContainer: '#paginationContainer-roles',
        campos: {
            '.nombre-rol': item => item.name,
            '.permisos-roles': item => item.permissions ?? 'N/A',
            '.usuarios-roles': item => item.users_count ?? 'N/A',
        },
        onRender: function(data) {
            const filas = document.querySelectorAll('.role-row');
            filas.forEach((row, index) => {
                const btn = row.querySelector('.btn-view-users');
                btn.dataset.roleId = data[index].id; 
                btn.addEventListener('click', function() {
                    const roleId = this.dataset.roleId;
                    cargarUsuariosPorRol(roleId);
                });
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