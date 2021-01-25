<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotificaiton;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends VerifyEmailNotificaiton
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->from('no_reply@guhsaiyan.com')
            ->subject('Potvrdi Email adresu - ' . config('app.name'))
            ->line('Ovaj e-mail Vam je poslat jer ste kreirali nalog na GuhSaiyan Shop-u, da bi mogli postaviti porudžbu potvrdite nalog klikom na dugme ispod.')
            ->action(Lang::get('Potvrdi email adresu'), $verificationUrl)
            ->salutation('Vaš, GuhSaiyanShop')
            ->line(Lang::get('Ukoliko niste kreirali nalog, ignorišite ovaj email.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
