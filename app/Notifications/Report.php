<?php

namespace App\Notifications;

use App\Models\Entry;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class Report extends Notification
{
    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(Entry $entry)
    {
        return (new MailMessage)
            ->level('info')
            ->subject('Registro de datos')
            ->greeting("Hola ! 👋🏻")
            ->line(new HtmlString('El registro fue registrado desde <strong>DISPOSITIVO</strong>'))
            ->line(new HtmlString('</br>'))
            ->line('Datos del registro :')
            ->line(new HtmlString('</br>'))
            ->line(new HtmlString('<center>Id de validación</center>'))
            ->line(new HtmlString('<center><strong></strong></center>'));
    }
}
