<div class="notifications" onclick="toggleNotificationDropdown(event)">
    <i class="fas fa-bell"></i>
    <span class="notification-badge" id="header-notification-badge" style="display: none;">0</span>
    
    <div class="notification-dropdown" id="notification-dropdown">
        <div class="dropdown-header">
            <span>Notificaciones</span>
            <a href="{{ route('notifications.index') }}" style="font-size: 0.8rem; color: #3498db;">Ver todas</a>
        </div>
        <div class="dropdown-content" id="notification-list">
            <div style="padding: 20px; text-align: center; color: #999;">
                <i class="fas fa-spinner fa-spin"></i> Cargando...
            </div>
        </div>
        <div class="dropdown-footer">
            <a href="#" onclick="markAllAsRead(event)">Marcar todo como leído</a>
        </div>
    </div>
</div>

<div id="toast-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>

<script>
    let lastCount = 0;
    let isFirstLoad = true;

    function toggleNotificationDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('notification-dropdown');
        const isActive = dropdown.classList.contains('active');
        
        // Close all other dropdowns if any
        document.querySelectorAll('.notification-dropdown').forEach(d => d.classList.remove('active'));
        
        if (!isActive) {
            dropdown.classList.add('active');
            loadRecentNotifications();
        } else {
            dropdown.classList.remove('active');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('notification-dropdown');
        if (dropdown && dropdown.classList.contains('active')) {
            dropdown.classList.remove('active');
        }
    });

    // Prevent closing when clicking inside the dropdown
    document.getElementById('notification-dropdown').addEventListener('click', function(event) {
        event.stopPropagation();
    });

    function loadRecentNotifications() {
        fetch('{{ route("notifications.recent") }}')
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById('notification-list');
                list.innerHTML = '';

                if (data.success && data.notifications.length > 0) {
                    data.notifications.forEach(notification => {
                        const item = document.createElement('a');
                        item.href = '{{ route("notifications.index") }}'; // Or specific link if available
                        item.className = `dropdown-item ${notification.status === 'pending' ? 'unread' : ''}`;
                        item.innerHTML = `
                            <h4>${notification.title}</h4>
                            <p>${notification.message.substring(0, 50)}${notification.message.length > 50 ? '...' : ''}</p>
                            <small>${new Date(notification.created_at).toLocaleString()}</small>
                        `;
                        list.appendChild(item);
                    });
                } else {
                    list.innerHTML = '<div style="padding: 20px; text-align: center; color: #999;">No hay notificaciones recientes.</div>';
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                document.getElementById('notification-list').innerHTML = '<div style="padding: 20px; text-align: center; color: red;">Error al cargar.</div>';
            });
    }

    function updateHeaderBadge() {
        fetch('{{ route("notifications.count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('header-notification-badge');
                const currentCount = data.count;

                if (currentCount > 0) {
                    badge.textContent = currentCount;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }

                // Check for new notifications
                if (!isFirstLoad && currentCount > lastCount) {
                    showToast('Nueva Notificación', 'Tienes ' + (currentCount - lastCount) + ' nueva(s) notificación(es).');
                    // Optional: Play sound
                    // new Audio('/path/to/sound.mp3').play().catch(e => console.log('Audio play failed'));
                }

                lastCount = currentCount;
                isFirstLoad = false;
            })
            .catch(error => console.error('Error fetching count:', error));
    }

    function showToast(title, message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.style.cssText = `
            background: white;
            border-left: 4px solid #3498db;
            padding: 15px 20px;
            margin-top: 10px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease-out forwards;
            min-width: 300px;
        `;
        
        toast.innerHTML = `
            <div style="flex: 1;">
                <h4 style="margin: 0 0 5px 0; color: #333; font-size: 1rem;">${title}</h4>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">${message}</p>
            </div>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #999; cursor: pointer; font-size: 1.2rem;">&times;</button>
        `;

        container.appendChild(toast);

        // Remove after 5 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    function markAllAsRead(event) {
        event.preventDefault();
        // Implement mark all as read logic if needed, or just redirect
        window.location.href = '{{ route("notifications.index") }}';
    }

    // Add keyframes for toast animation
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // Initial load and polling (every 5 seconds)
    document.addEventListener('DOMContentLoaded', function() {
        updateHeaderBadge();
        setInterval(updateHeaderBadge, 5000);
    });
</script>
