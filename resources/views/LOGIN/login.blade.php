<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Central - Iniciar Sesión</title>
    @vite(['resources/css/auth_log/login.css'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="background-image"></div>
    <div class="container">
        <div class="login-container">
            <!-- Lado Izquierdo - Información -->
            <div class="left-side">
                <div class="hospital-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <h2>Clinica Ultima Asignatura</h2>
                <p>Cuidando tu salud con excelencia</p>
            </div>

            <!-- Lado Derecho - Formulario -->
            <div class="right-side">
                <form class="login-form" id="loginForm" action="{{ route('login_Attempt') }}" method="post">
                    <h2>Iniciar Sesión</h2>
                    <p class="subtitle">Accede a tu cuenta del sistema</p>
                    @csrf
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-user"></i> Correo Electrónico
                        </label>
                        <input type="email" id="email" name="email" required 
                            placeholder="Ingresa tu Correo Electrónico" value="{{ old('email') }}">
                        @error('email')
                            <span class="error-message" style="color:red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Contraseña
                        </label>
                        <input type="password" id="password" name="password" required 
                               placeholder="Ingresa tu contraseña">
                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" id="remember">
                            <span class="checkmark"></span>
                            Recordarme
                        </label>
                        <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Iniciar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // toggle the eye slash icon
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>