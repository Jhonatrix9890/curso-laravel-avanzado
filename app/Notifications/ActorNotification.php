<?php

namespace App\Notifications;
use App\Actor;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $nombres, $fecha, $asunto, $texto;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Actor $actor,$fechaAct=false)
    {
        $this->nombres = $actor->nombres;
        if ($fechaAct == false) {
            $this->asunto = 'Actor enviado a papelera';
            $this->texto = "envió a papelera";
            $this->fecha = $actor->deleted_at;
        } else {
            $this->asunto = 'Actor restaurado';
            $this->texto = "restauró";
            $this->fecha = $genero->updated_at;
        }

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

         return (new MailMessage)->greeting('Saludos!')
        ->subject($this->asunto)
        ->line("Se " . $this->texto . " el actor " . $this->nombres . "a las " . $this->fecha);
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
