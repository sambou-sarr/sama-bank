<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelleDemandeNotification extends Notification
{
    use Queueable;
    protected $user;
    protected $compte;
    /**
     * Create a new notification instance.
     */

    public function __construct($user, $compte)
    {
        $this->user = $user;
        $this->compte = $compte;
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
    public function toMail(object $notifiable): MailMessage
    {
         return (new MailMessage)
            ->subject('Nouvelle demande de création de compte')
            ->greeting('Bonjour Admin')
            ->line('Une nouvelle demande de création de compte a été soumise par : ' . $this->user->name)
            ->line('Type de compte : ' . $this->compte->type_compte)
            ->line('Numéro de compte : ' . $this->compte->numb_compte)
            ->action('Voir les demandes', url('/admin/demande'))
            ->line('Merci de traiter cette demande dès que possible.');
    
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
