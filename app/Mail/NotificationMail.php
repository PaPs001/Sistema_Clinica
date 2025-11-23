<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    public $paciente;
    public $fecha;
    public $motivo;

    public function __construct($paciente, $fecha, $motivo)
    {
        $this->paciente = $paciente;
        $this->fecha = $fecha;
        $this->motivo = $motivo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recordatorio de Cita Médica',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'plantillas.formularios.correo.notification-email',
        );
    }
}
