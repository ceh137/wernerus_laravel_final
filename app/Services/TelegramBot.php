<?php

namespace App\Services;
use App\Models\Order;
use DefStudio\Telegraph\Models\TelegraphChat;
class TelegramBot
{
    public Order $order;
    public TelegraphChat $chat;

    public function __construct($order_id)
    {
        $this->order  = Order::find($order_id);
        $this->chat = TelegraphChat::find(1);
    }

    public function new_order() {
//        dd($this->chat);
        $sender_comp  =  $this->order->sender_comp ?? '';
        $receiver_comp  =  $this->order->receiver_comp ?? '';
        $delivery_type = 'TT';

        if ($this->order->from_addr && !$this->order->to_addr) {
            $delivery_type = 'AT';
        } elseif ($this->order->from_addr && $this->order->to_addr) {
            $delivery_type = 'AA';
        } elseif (!$this->order->from_addr && $this->order->to_addr) {
            $delivery_type = 'TA';
        }
        $html =     "<strong>{$this->order->route->city_from->name} -> {$this->order->route->city_to->name}\n{$this->order->address_from} -> {$this->order->address_to}\n$delivery_type \n&#128230; {$this->order->pieces} места &#129482; {$this->order->volume}  &#9878;&#65039; {$this->order->weight}</strong>\nОтправитель: $sender_comp->name $sender_comp->INN {$this->order->sender->name} {$this->order->sender->telnum} {$this->order->sender->email}\nПолучатель: $receiver_comp->name $receiver_comp->INN {$this->order->receiver->name} {$this->order->receiver->telnum} {$this->order->receiver->email}";
        $this->chat->html($html)->send();
    }

}
