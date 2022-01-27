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
     * entriesCount
     *
     * @var mixed
     */
    private $entriesCount;

    /**
     * __construct
     *
     * @param  mixed $reportFile
     * @return void
     */
    public function __construct($reportFile, $entriesCount)
    {
        $this->reportFile = $reportFile;
        $this->entriesCount = $entriesCount;
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
        $mail = (new MailMessage)
            ->level('info')
            ->from('alertasvacunatorioc5@gmail.com', "Reportes Vacunatorio C5")
            ->subject('Reportes de alertas de vacunatorio')
            ->greeting("Buen Día");

        if ($this->entriesCount > 0) {
            $mail->line(new HtmlString('Te enviamos el reporte semanal'))
                ->attachData($this->reportFile, 'report_' . now()->format('Y_m_d_his') . '.pdf', [
                    'mime' => 'text/pdf',
                ]);
        } else {
            $mail->line(new HtmlString('No hay alertas para este reporte'));
        }

        $mail->line(new HtmlString('</br>'))
            ->line(new HtmlString('</br>'))
            ->line(new HtmlString('</br>'));
        return $mail;
    }
}
