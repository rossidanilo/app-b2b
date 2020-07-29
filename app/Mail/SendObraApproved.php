<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendObraApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $obra_id;

    public $adress;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obra_id, $adress)
    {
        $this->obra_id = $obra_id;
        $this->adress = $adress;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Obra aprobada')->view('emails.obraapproved');
    }
}
