<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $newPassword,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperación de contraseña — AdminSystem',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth.forgot-password',
            with: [
                'userName'    => $this->user->name,
                'newPassword' => $this->newPassword,
            ],
        );
    }
}