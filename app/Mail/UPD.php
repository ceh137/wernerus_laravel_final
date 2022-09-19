<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UPD extends Mailable
{
    use Queueable, SerializesModels;

    public string $order_num;
    public string $who_is_user;
    public Order $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( Order $order, $who_is_user)
    {
        $this->order =  $order;
        $this->order_num = $order->order_num;
        $this->who_is_user = $who_is_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.UPD')
            ->subject('УПД по заказу '.$this->order_num)
            ->attachFromStorageDisk('public', json_decode($this->order->files->UPD, true)[$this->who_is_user]);
    }
}
