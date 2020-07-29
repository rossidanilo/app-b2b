<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewObra extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    public $obra_id;

    public $adress;

    public $obra_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $obra_id, $adress, $obra_name)
    {
        $this->customer = $customer;
        $this->obra_id = $obra_id;
        $this->adress = $adress;
        $this->obra_name = $obra_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nueva obra creada en H30 App')->view('emails.newobra');
    }
}
