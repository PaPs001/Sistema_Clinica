<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recordatorio de cita médica</title>
    <style>
        body { background: #f4f4f7; font-family: Arial; padding: 20px; }
        .card {
            max-width: 600px; background: white; padding: 25px;
            border-radius: 10px; margin:auto; border-left: 6px solid #007bff;
        }
    </style>
</head>
<body>
<div class="card">
    <p><strong>{{ $fecha }} - {{ $hora }}</strong></p>

    <h2>Recordatorio de cita médica</h2>

    <p>Hola <strong>{{ $name }}</strong>,</p>

    <p>
        Este es un recordatorio de su cita médica programada para mañana.
    </p>

    <p>
        <strong>Fecha:</strong> {{ $fecha }}<br>
        <strong>Hora:</strong> {{ $hora }}
    </p>

    <p style="margin-top: 30px;">
        Saludos,<br>
        <strong>Clínica UAC</strong>
    </p>
</div>
</body>
</html>