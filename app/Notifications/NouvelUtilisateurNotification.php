<?php
// app/Notifications/NouvelUtilisateurNotification.php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NouvelUtilisateurNotification extends Notification
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvel utilisateur inscrit')
            ->line('Un nouvel utilisateur vient de s’inscrire :')
            ->line("Nom : {$this->user->nom}")
            ->line("Prénom : {$this->user->prenom}")
            ->line("Email : {$this->user->email}");
    }

    public function toArray($notifiable)
    {
        return [
            'nom' => $this->user->nom,
            'prenom' => $this->user->prenom,
            'email' => $this->user->email,
        ];
    }
}
