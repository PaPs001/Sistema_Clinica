@extends('plantillas.dashboard_general')

@section('title', 'Primer Cambio de Contraseña')

@section('content')
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Cambia tu contraseña</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('password.primeravez.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nueva contraseña</label>
                    <input type="password" 
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" 
                           name="password_confirmation"
                           class="form-control" 
                           required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Guardar contraseña
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
