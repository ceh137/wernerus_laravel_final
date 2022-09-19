<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;
    public Order $order;
    public string $who_is_user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $who_is_user)
    {
        $this->order = $order;
        $this->who_is_user = $who_is_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->who_is_user == 'receiver' ?
            $this->view('email.invoice')
                ->subject('Счет по заказу '.$this->order->order_num)
                ->attachFromStorageDisk('public', $this->order->files->PE)->attachFromStorageDisk('public', json_decode($this->order->files->check, true)[$this->who_is_user])
            :
            $this->view('email.invoice')
                ->subject('Счет по заказу '.$this->order->order_num)
                ->attachFromStorageDisk( 'public' ,json_decode($this->order->files->check, true)[$this->who_is_user]);
    }
}
