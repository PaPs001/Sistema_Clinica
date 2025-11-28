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

        <p style="font-size: 14px; color: #555;">
            <strong>{{ $fecha }}</strong>
        </p>

        <h2 style="margin-bottom: 20px;">Activación de cuenta</h2>

        <p>Hola <strong>{{ $name }}</strong>,</p>

        <p>
            Su cuenta de paciente ha sido creada. Para activarla e iniciar sesión por primera vez,
            siga los siguientes pasos:
        </p>

        <ol>
            <li>
                Ingrese a la siguiente página:
                <br>
                <strong>
                    <a href="{{ route('login') }}" style="color: #007bff; text-decoration: none;">
                        Iniciar sesión en Clínica UAC
                    </a>
                </strong>
            </li>

            <li>Ingrese su correo electrónico registrado.</li>

            <li>
                Ingrese la siguiente contraseña temporal:
                <br>
                <strong style="font-size: 18px;">{{ $temporalPassword }}</strong>
            </li>

            <li>Una vez dentro, cambie la contraseña por una de su preferencia.</li>
        </ol>

        <p>
            Si usted no solicitó la creación de esta cuenta, por favor ignore este mensaje.
        </p>

        <p style="margin-top: 30px;">
            Saludos,
            <br>
            <strong>Clínica UAC</strong>
        </p>
    </div>

    <div class="footer" style="font-size: 12px; color: #888; margin-top: 20px;">
        Este es un correo automático, por favor no responda.
    </div>
</div>
</body>
</html>