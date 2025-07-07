<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EtatDemandeNotification extends Notification
{
    use Queueable;
    public $statut;
    public $raison;
  

    /**
     * Create a new notification instance.
     */
    public function __construct($statut, $raison = null)
    {
        $this->statut = $statut;
        $this->raison = $raison;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->greeting('Bonjour ' . $notifiable->prenom.' '.$notifiable->nom)
            ->subject('Mise à jour de votre demande')
            ->line('Votre demande de création de compte a été ' . $this->statut . '.');

        if ($this->statut === 'rejeter' && $this->raison) {
            $mail->line('Raison du rejet : ' . $this->raison);
        }

        $mail->action('Accéder à votre espace', url('/dashboard'))
             ->line('Merci d’utiliser notre service.');

        return $mail;
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
