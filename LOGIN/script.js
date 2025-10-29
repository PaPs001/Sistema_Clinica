document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // Mostrar/ocultar contraseña
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    // Manejar envío del formulario
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const remember = document.getElementById('remember').checked;

        // Validación básica
        if (!username || !password) {
            showAlert('Por favor, completa todos los campos', 'error');
            return;
        }

        // Simular proceso de login
        simulateLogin(username, password, remember);
    });

    function simulateLogin(username, password, remember) {
        // Mostrar loading
        const loginBtn = loginForm.querySelector('.login-btn');
        const originalText = loginBtn.innerHTML;
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Iniciando sesión...';
        loginBtn.disabled = true;

        // Simular petición al servidor
        setTimeout(() => {
            // Aquí normalmente harías una petición AJAX a tu backend
            if (username === 'admin' && password === 'admin') {
                showAlert('¡Login exitoso! Redirigiendo...', 'success');
                // Redirigir al dashboard
                setTimeout(() => {
                    window.location.href = 'dashboard.html';
                }, 2000);
            } else {
                showAlert('Usuario o contraseña incorrectos', 'error');
                loginBtn.innerHTML = originalText;
                loginBtn.disabled = false;
            }
        }, 2000);
    }

    function showAlert(message, type) {
        // Remover alerta anterior si existe
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <span>${message}</span>
            <button class="alert-close">&times;</button>
        `;

        // Estilos para la alerta
        alert.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 300px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease;
        `;

        // Colores según el tipo
        const colors = {
            success: '#4CAF50',
            error: '#f44336',
            warning: '#ff9800'
        };

        alert.style.background = colors[type] || colors.success;

        // Botón cerrar
        const closeBtn = alert.querySelector('.alert-close');
        closeBtn.style.cssText = `
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: 15px;
        `;

        closeBtn.addEventListener('click', () => {
            alert.remove();
        });

        document.body.appendChild(alert);

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Animación para la alerta
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);
});