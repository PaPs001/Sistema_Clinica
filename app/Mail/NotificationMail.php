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
    public $temporalPassword;
    public $name;
    public $fecha;

    public function __construct($temporalPassword, $name, $fecha)
    {
        $this->temporalPassword = $temporalPassword;
        $this->fecha = $fecha;
        $this->name = $name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activacion de cuenta - Clinica UAC',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'plantillas.formularios.correo.notification-email',
        );
    }
}
