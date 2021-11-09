<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EntryNotification extends Notification
{
    /**
     * reportFile
     *
     * @var mixed
     */
    private $reportFile;

    /**
     * __construct
     *
     * @param  mixed $reportFile
     * @return void
     */
    public function __construct($reportFile)
    {
        $this->reportFile = $reportFile;
    }

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
    public function toMail()
    {
        return (new MailMessage)
            ->level('info')
            ->subject('Registro de datos')
            ->greeting("Hola ! 👋🏻")
            ->line(new HtmlString('Te enviamos el reporte semanal'))
            ->line(new HtmlString('</br>'))
            ->line(new HtmlString('</br>'))
            ->line(new HtmlString('</br>'))
            ->attachData($this->reportFile, 'report_' . now()->format('Y_m_d_his') . '.pdf', [
                'mime' => 'text/pdf',
            ]);
    }
}
