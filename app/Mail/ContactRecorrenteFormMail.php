<?php

namespace App\Mail;

use App\Models\Bloco;
use App\Models\Sala;
use App\Models\Tipo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactRecorrenteFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->info = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $input = $this->info['input'];
        $bloco = Bloco::find($input['bloco_id']);
        $sala = Sala::find($input['sala_id']);
        $tipo = Tipo::find($input['tipo_id']);

        return $this->markdown('template.client.contactformrecorrente')
            ->from('noreply@iced.com')
            ->with([
                'subject' => $this->info['subject'],
                'agendamento' => $this->info['agendamento'],
                'input' => $input, 
                'dias_da_semana' => $this->info['dias_da_semana'],
                'bloco' => $bloco,
                'sala' => $sala,
                'tipo' => $tipo,
            ]);
    }
}
