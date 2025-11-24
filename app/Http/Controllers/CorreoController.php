<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CorreoController extends Controller
{
    //
    public function pruebaCorreo()
    {
        // Correo al que quieres enviar la prueba
        $destinatario = "zavalalopezedgarsaul@gmail.com";

        // Datos de prueba
        $paciente = "Paciente de prueba";
        $fecha = "2025-01-01";
        $motivo = "Prueba de funcionamiento del sistema de notificaciones";

        Mail::to($destinatario)
            ->send(new NotificationMail(
                $paciente,
                $fecha,
                $motivo
            ));

        return "Correo de prueba enviado a: " . $destinatario;
    }
}
