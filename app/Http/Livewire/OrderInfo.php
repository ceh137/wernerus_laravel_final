<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class OrderInfo extends ModalComponent
{

    public Order $order;
    public string $confirmationTitle = 'Информация по заказу';


    public static function modalMaxWidth(): string{
        return "7xl";
    }

    public function mount($id)
    {

        $this->order = Order::find($id);
        $this->confirmationTitle .= " ".$this->order->order_num;
    }

    public function render()
    {
        return view('livewire.order-info');
    }

    public function cancel()
    {
        $this->closeModal();
    }

    public function confirm() {
        //
    }

}
