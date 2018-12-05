<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Consulta;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConsultaEmail extends Notification
{
    use Queueable;

    protected $consulta;
    protected $user;

    public function __construct(Consulta $consulta, $user)
    {
        $this->consulta = $consulta;
        $this->user = $user;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        $data_consulta = dateToView($this->consulta->data_consulta);
        return (new MailMessage)
                    ->subject('Remoção de Consultas')
                    ->line("{$this->user->name}, Você não compareceu a consulta do dia {$data_consulta}, no horario de {$this->consulta->horario_consulta} hora(s), Remarque sua consulta novamente.")
                    ->action('Marcar outra Consulta', url('consulta/logado'))
                    ->line('Abraços []s!');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
