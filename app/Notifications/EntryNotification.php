<?php

namespace App\Notifications;

use App\Models\Entry;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EntryNotification extends Notification
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
            ->line(new HtmlString('<b>Temperatura </b>:' . $entry->employee->rut))
            ->line(new HtmlString('<b>Fecha</b>:' . $date))
            ->line(new HtmlString('<b>Hora</b>:' . $hour))
            ->line(new HtmlString('<b>Tipo</b>:' . $type))
            ->line(new HtmlString('<b>Fuente</b>:' . $source))
            ->line(new HtmlString('</br>'))
            ->line(new HtmlString('</br>'))
            ->line(new HtmlString('<center>Id de validación</center>'))
            ->line(new HtmlString('<center><strong></strong></center>'));
    }
}
