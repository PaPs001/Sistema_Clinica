// gestion-roles.js - Adaptado al diseño del recepcionista

// Datos de ejemplo para roles
let roles = [
    {
        id: 1,
        name: "Administrador",
        description: "Acceso completo al sistema con todos los privilegios",
        permissions: ["usuarios", "roles", "configuracion", "reportes", "auditoria", "backup", "seguridad", "dashboard"],
        users: 3,
        status: "active"
    },
    {
        id: 2,
        name: "Supervisor",
        description: "Gestiona usuarios y visualiza reportes del sistema",
        permissions: ["usuarios", "reportes", "dashboard"],
        users: 5,
        status: "active"
    },
    {
        id: 3,
        name: "Operador",
        description: "Acceso básico para operaciones diarias",
        permissions: ["reportes", "dashboard"],
        users: 12,
        status: "active"
    },
    {
        id: 4,
        name: "Auditor",
        description: "Solo acceso a módulo de auditoría y reportes",
        permissions: ["auditoria", "reportes"],
        users: 2,
        status: "inactive"
    }
];

// Permisos disponibles en el sistema
const availablePermissions = [
    { id: "dashboard", name: "Panel Principal" },
    { id: "usuarios", name: "Gestión de Usuarios" },
    { id: "roles", name: "Gestión de Roles" },
    { id: "configuracion", name: "Configuración del Sistema" },
    { id: "reportes", name: "Generación de Reportes" },
    { id: "auditoria", name: "Módulo de Auditoría" },
    { id: "backup", name: "Respaldos de Datos" },
    { id: "seguridad", name: "Configuración de Seguridad" }
];

// Variables globales
let currentEditingRole = null;

// Inicializar la página
document.addEventListener('DOMContentLoaded', function() {
    loadRolesTable();
    loadPermissionsGrid();
    updateStatistics();
});

// Cargar tabla de roles
function loadRolesTable() {
    const tbody = document.getElementById('rolesTableBody');
    tbody.innerHTML = '';

    roles.forEach(role => {
        const row = document.createElement('tr');
        
        // Formatear lista de permisos
        const permissionsHTML = role.permissions.map(perm => 
            `<span class="permission-tag">${getPermissionName(perm)}</span>`
        ).join('');

        row.innerHTML = `
            <td>
                <strong>${role.name}</strong>
            </td>
            <td>${role.description}</td>
            <td><div class="permissions-list">${permissionsHTML}</div></td>
            <td>${role.users} usuario(s)</td>
            <td>
                <span class="status-badge ${role.status}">
                    ${role.status === 'active' ? 'Activo' : 'Inactivo'}
                </span>
            </td>
            <td>
                <button class="btn-action btn-edit" onclick="editRole(${role.id})" title="Editar rol">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action btn-delete" onclick="deleteRole(${role.id})" title="Eliminar rol">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Cargar grid de permisos en el modal
function loadPermissionsGrid() {
    const grid = document.getElementById('permissionsGrid');
    grid.innerHTML = '';

    availablePermissions.forEach(permission => {
        const permissionItem = document.createElement('div');
        permissionItem.className = 'permission-item';
        permissionItem.innerHTML = `
            <input type="checkbox" id="perm_${permission.id}" value="${permission.id}">
            <label for="perm_${permission.id}">${permission.name}</label>
        `;
        grid.appendChild(permissionItem);
    });
}

// Actualizar estadísticas
function updateStatistics() {
    document.getElementById('totalRoles').textContent = roles.length;
    document.getElementById('activeRoles').textContent = roles.filter(r => r.status === 'active').length;
    
    const totalPermissions = roles.reduce((total, role) => total + role.permissions.length, 0);
    document.getElementById('totalPermissions').textContent = totalPermissions;
    
    const totalUsers = roles.reduce((total, role) => total + role.users, 0);
    document.getElementById('totalUsers').textContent = totalUsers;
}

// Buscar roles
function searchRoles() {
    const searchTerm = document.getElementById('searchRoles').value.toLowerCase();
    const filteredRoles = roles.filter(role => 
        role.name.toLowerCase().includes(searchTerm) || 
        role.description.toLowerCase().includes(searchTerm)
    );
    
    const tbody = document.getElementById('rolesTableBody');
    tbody.innerHTML = '';

    filteredRoles.forEach(role => {
        const row = document.createElement('tr');
        const permissionsHTML = role.permissions.map(perm => 
            `<span class="permission-tag">${getPermissionName(perm)}</span>`
        ).join('');

        row.innerHTML = `
            <td>
                <strong>${role.name}</strong>
            </td>
            <td>${role.description}</td>
            <td><div class="permissions-list">${permissionsHTML}</div></td>
            <td>${role.users} usuario(s)</td>
            <td>
                <span class="status-badge ${role.status}">
                    ${role.status === 'active' ? 'Activo' : 'Inactivo'}
                </span>
            </td>
            <td>
                <button class="btn-action btn-edit" onclick="editRole(${role.id})" title="Editar rol">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action btn-delete" onclick="deleteRole(${role.id})" title="Eliminar rol">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// Abrir modal para crear rol
function openCreateRoleModal() {
    currentEditingRole = null;
    document.getElementById('modalTitle').textContent = 'Crear Nuevo Rol';
    document.getElementById('roleForm').reset();
    
    // Limpiar checkboxes
    availablePermissions.forEach(permission => {
        document.getElementById(`perm_${permission.id}`).checked = false;
    });
    
    document.getElementById('roleModal').classList.add('active');
}

// Editar rol
function editRole(roleId) {
    const role = roles.find(r => r.id === roleId);
    if (!role) return;

    currentEditingRole = role;
    document.getElementById('modalTitle').textContent = 'Editar Rol';
    
    // Llenar formulario
    document.getElementById('roleName').value = role.name;
    document.getElementById('roleDescription').value = role.description;
    
    // Marcar permisos
    availablePermissions.forEach(permission => {
        const checkbox = document.getElementById(`perm_${permission.id}`);
        checkbox.checked = role.permissions.includes(permission.id);
    });
    
    document.getElementById('roleModal').classList.add('active');
}

// Cerrar modal
function closeRoleModal() {
    document.getElementById('roleModal').classList.remove('active');
    currentEditingRole = null;
}

// Manejar envío del formulario
document.getElementById('roleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const roleName = document.getElementById('roleName').value;
    const roleDescription = document.getElementById('roleDescription').value;
    
    // Validaciones
    if (!roleName.trim()) {
        alert('El nombre del rol es obligatorio');
        return;
    }
    
    // Obtener permisos seleccionados
    const selectedPermissions = [];
    availablePermissions.forEach(permission => {
        const checkbox = document.getElementById(`perm_${permission.id}`);
        if (checkbox.checked) {
            selectedPermissions.push(permission.id);
        }
    });
    
    if (selectedPermissions.length === 0) {
        alert('Debe seleccionar al menos un permiso');
        return;
    }
    
    if (currentEditingRole) {
        // Actualizar rol existente
        currentEditingRole.name = roleName;
        currentEditingRole.description = roleDescription;
        currentEditingRole.permissions = selectedPermissions;
    } else {
        // Crear nuevo rol
        const newRole = {
            id: Math.max(...roles.map(r => r.id)) + 1,
            name: roleName,
            description: roleDescription,
            permissions: selectedPermissions,
            users: 0,
            status: 'active'
        };
        roles.push(newRole);
    }
    
    loadRolesTable();
    updateStatistics();
    closeRoleModal();
    
    // Mostrar mensaje de éxito
    showNotification(currentEditingRole ? 'Rol actualizado correctamente' : 'Rol creado correctamente', 'success');
});

// Eliminar rol
function deleteRole(roleId) {
    const role = roles.find(r => r.id === roleId);
    if (!role) return;

    if (role.users > 0) {
        showNotification('No se puede eliminar un rol que tiene usuarios asignados', 'error');
        return;
    }
    
    if (confirm(`¿Estás seguro de que deseas eliminar el rol "${role.name}"?`)) {
        roles = roles.filter(r => r.id !== roleId);
        loadRolesTable();
        updateStatistics();
        showNotification('Rol eliminado correctamente', 'success');
    }
}

// Obtener nombre del permiso por ID
function getPermissionName(permissionId) {
    const permission = availablePermissions.find(p => p.id === permissionId);
    return permission ? permission.name : permissionId;
}

// Función de logout
function logout() {
    if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        showNotification('Sesión cerrada correctamente', 'info');
        // En una aplicación real, aquí redirigirías al login
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 1000);
    }
}

// Funciones de las acciones rápidas
function showPermissionsMatrix() {
    showNotification('Mostrando matriz de permisos...', 'info');
    // Implementar lógica para mostrar matriz de permisos
}

function exportRoleReport() {
    showNotification('Generando reporte de roles...', 'info');
    // Implementar lógica para exportar reporte
}

function showRoleAudit() {
    showNotification('Cargando auditoría de roles...', 'info');
    // Implementar lógica para mostrar auditoría
}

function exportRoles() {
    showNotification('Exportando lista de roles...', 'info');
    // Implementar lógica para exportar
}

// Mostrar notificación
function showNotification(message, type = 'info') {
    // En una aplicación real, usarías un sistema de notificaciones más sofisticado
    alert(`${type.toUpperCase()}: ${message}`);
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('roleModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRoleModal();
    }
});