<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OperationEffectuee extends Notification
{
    use Queueable;
    public $operation;
    public $montant;
    /**
     * Create a new notification instance.
     */
    public function __construct($operation, $montant)
    {
        $this->operation = $operation;
        $this->montant = $montant;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Confirmation de votre opération bancaire")
            ->greeting("Bonjour " . $notifiable->name)
            ->line("Votre opération de **{$this->operation}** d’un montant de **{$this->montant} FCFA** a bien été effectuée.")
            ->line("Merci d'utiliser notre application.");
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
