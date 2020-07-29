<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectObra extends Mailable
{
    use Queueable, SerializesModels;

    public $obra_name;
    public $obra_adress;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obra_name, $obra_adress)
    {
        $this->obra_name = $obra_name;
        $this->obra_adress = $obra_adress;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('La obra '.$this->obra_name.' ha sido rechazada')->view('emails.mail-reject');
    }
}
