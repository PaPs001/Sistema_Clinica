<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cita médica</title>
    <style>
        .container {
            width: 100%;
            background: #f4f4f7;
            padding: 30px;
            font-family: Arial, sans-serif;
        }

        .card {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            border-left: 6px solid #007bff;
        }

        h2 {
            margin-top: 0;
            color: #007bff;
        }

        p {
            font-size: 16px;
            color: #333;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: gray;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Recordatorio de Cita Médica</h2>

        <p>Hola <strong>{{ $paciente }}</strong>,</p>

        <p>Te recordamos que tienes una cita programada el día:</p>

        <p><strong>{{ $fecha }}</strong></p>

        <p>Motivo de la cita:</p>
        <p><strong>{{ $motivo }}</strong></p>

        <p>Por favor acude con 10 minutos de anticipación.</p>

        <p>Saludos,  
            <br><strong>Hospital Naval</strong>
        </p>
    </div>

    <div class="footer">
        Este es un correo automático, por favor no respondas.
    </div>
</div>

</body>
</html><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cita médica</title>
    <style>
        .container {
            width: 100%;
            background: #f4f4f7;
            padding: 30px;
            font-family: Arial, sans-serif;
        }

        .card {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            border-left: 6px solid #007bff;
        }

        h2 {
            margin-top: 0;
            color: #007bff;
        }

        p {
            font-size: 16px;
            color: #333;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: gray;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Recordatorio de Cita Médica</h2>

        <p>Hola <strong>{{ $paciente }}</strong>,</p>

        <p>Te recordamos que tienes una cita programada el día:</p>

        <p><strong>{{ $fecha }}</strong></p>

        <p>Motivo de la cita:</p>
        <p><strong>{{ $motivo }}</strong></p>

        <p>Por favor acude con 10 minutos de anticipación.</p>

        <p>Saludos,  
            <br><strong>Hospital Naval</strong>
        </p>
    </div>

    <div class="footer">
        Este es un correo automático, por favor no respondas.
    </div>
</div>

</body>
</html>