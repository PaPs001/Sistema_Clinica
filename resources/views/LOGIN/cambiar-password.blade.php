@extends('plantillas.dashboard_medico')

@section('title', 'Primer Cambio de Contraseña')

@section('styles')
    @vite(['resources/css/auth_log/change-password.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="password-container">
    <div class="password-card">
        <div class="card-header">
            <h2>Cambia tu contraseña</h2>
            <p>Por seguridad, debes actualizar tu contraseña inicial</p>
        </div>

        <form method="POST" action="{{ route('password.primeravez.update') }}">
            @csrf

            <div class="form-group">
                <label for="password">Nueva contraseña</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Ingresa tu nueva contraseña"
                           required>
                    <i class="fas fa-lock"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar contraseña</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password_confirmation"
                           name="password_confirmation"
                           class="form-control" 
                           placeholder="Repite tu nueva contraseña"
                           required>
                    <i class="fas fa-lock-open"></i>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Guardar contraseña
            </button>
        </form>
    </div>
</div>
@endsection
