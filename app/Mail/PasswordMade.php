<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordMade extends Mailable
{
    use Queueable, SerializesModels;

    public string $pass;
    public array $user;
    public Order $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pass, $user, $order)
    {
        $this->pass = $pass;
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.password')->subject('Данные для входа в ЛК');
    }
}
