// Cargar lista de backups al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    loadBackupsList();
});

function loadBackupsList() {
    fetch('/admin/backup/list')
        .then(response => response.json())
        .then(backups => {
            const tbody = document.getElementById('backupsTableBody');

            if (backups.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No hay backups disponibles</td></tr>';
                return;
            }

            tbody.innerHTML = '';

            backups.forEach(backup => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${backup.name}</td>
                    <td>${backup.date}</td>
                    <td><span class="badge ${backup.type === 'Solo Datos' ? 'badge-info' : 'badge-success'}">${backup.type}</span></td>
                    <td>${backup.size}</td>
                    <td>
                        <button onclick="downloadBackup('${backup.name}')" class="action-btn" title="Descargar">
                            <i class="fas fa-download"></i>
                        </button>
                        <button onclick="confirmRestore('${backup.name}')" class="action-btn" title="Restaurar">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button onclick="confirmDelete('${backup.name}')" class="action-btn delete-btn" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error al cargar backups:', error);
            showNotification('Error al cargar la lista de backups', 'error');
        });
}

function createDataBackup() {
    if (!confirm('¿Crear un backup de SOLO DATOS (sin estructura de tablas)?')) {
        return;
    }

    showLoading('Creando backup de datos...');

    fetch('/admin/backup/data', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
        .then(response => {
            if (response.ok) {
                return response.blob();
            }
            throw new Error('Error al crear backup');
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `data-only-${new Date().toISOString().slice(0, 10)}.zip`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();

            hideLoading();
            showNotification('Backup de datos creado exitosamente', 'success');
            loadBackupsList();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Error al crear backup de datos', 'error');
        });
}

function createFullBackup() {
    if (!confirm('¿Crear un backup COMPLETO (estructura + datos + archivos)?')) {
        return;
    }

    showLoading('Creando backup completo...');

    fetch('/admin/backup/full', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
        .then(response => {
            if (response.ok) {
                return response.blob();
            }
            throw new Error('Error al crear backup');
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `full-${new Date().toISOString().slice(0, 10)}.zip`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();

            hideLoading();
            showNotification('Backup completo creado exitosamente', 'success');
            loadBackupsList();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Error al crear backup completo', 'error');
        });
}


function downloadBackup(filename) {
    window.location.href = `/admin/backup/download/${filename}`;
}

function confirmRestore(filename) {
    const modal = document.getElementById('restoreModal');
    document.getElementById('restoreFilename').textContent = filename;
    document.getElementById('restoreFilenameInput').value = filename;
    modal.style.display = 'flex';
}


function closeRestoreModal() {
    document.getElementById('restoreModal').style.display = 'none';
}

function confirmDelete(filename) {
    if (!confirm(`¿Estás seguro de eliminar el backup "${filename}"?\n\nEsta acción no se puede deshacer.`)) {
        return;
    }

    fetch(`/admin/backup/delete/${filename}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                loadBackupsList();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error al eliminar backup', 'error');
        });
}

function cleanOldBackups() {
    if (!confirm('¿Limpiar backups antiguos según la política de retención?')) {
        return;
    }

    showLoading('Limpiando backups antiguos...');

    fetch('/admin/backup/clean', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            showNotification('Backups antiguos eliminados', 'success');
            loadBackupsList();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Error al limpiar backups', 'error');
        });
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => notification.classList.add('show'), 10);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function showLoading(message = 'Procesando...') {
    const loading = document.createElement('div');
    loading.id = 'loadingOverlay';
    loading.innerHTML = `
        <div class="loading-content">
            <div class="spinner"></div>
            <p>${message}</p>
        </div>
    `;
    document.body.appendChild(loading);
}

function hideLoading() {
    const loading = document.getElementById('loadingOverlay');
    if (loading) {
        loading.remove();
    }
}
