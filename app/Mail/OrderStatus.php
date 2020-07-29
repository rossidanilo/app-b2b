<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $order_id;

    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id, $status)
    {
        $this->order_id = $order_id;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Novedades sobre su pedido')->view('emails.order-status');
    }
}
