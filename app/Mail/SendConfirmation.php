<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order_id;

    public $customer;
    
    public $obra;

    public $obra_name;

    public $items;
    
    public $total;
    
    public $comment;

    public $schedule;

    public $responsibles;
    
    public $company;
    
    public $shipping_cost;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id, $customer, $obra, $obra_name, $items, $total, $comment, $schedule, $responsibles, $company, $shipping_cost)
    {
        $this->order_id = $order_id;
        $this->customer = $customer;
        $this->obra = $obra;
        $this->obra_name = $obra_name;
        $this->items = $items;
        $this->total = $total;
        $this->comment = $comment;
        $this->schedule = $schedule;
        $this->responsibles = $responsibles;
        $this->company = $company;
        $this->shipping_cost = $shipping_cost;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nuevo pedido ingresado en H30 App'.' # '.$this->order_id.' - Obra: '.$this->obra_name)->view('emails.mail-confirmation');
    }
}
