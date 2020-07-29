<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendProductNotification extends Mailable
{
    use Queueable, SerializesModels;
    
    public $product_code;

    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($product_code, $customer)
    {
        
        $this->product_code = $product_code;
        $this->customer = $customer;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->subject('Solicitud de producto sin stock')->view('emails.outofstock');
    }
}
