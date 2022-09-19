<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;

class SaveOrderToGoogleService
{
    public Order $order;

    public function __construct($id)
    {
        $this->order = Order::find($id);
    }

    public function send() {

        $service = new GoogleService(true);
        $service->saveDataToSheet($this->getReadyData());
    }

    public function getReadyData() {
        $datetime = now("Europe/Moscow");
        if ($this->order->del_from_addr_time_from) {
            $del_from_addr_time_from = Carbon::parse($this->order->del_from_addr_time_from)->diffInMinutes(Carbon::parse($this->order->del_from_addr_time_from)->startOfDay());
        } else {
            $del_from_addr_time_from = -1;
        }

        if ($this->order->del_to_addr_time_from) {
            $del_to_addr_time_from = Carbon::parse($this->order->del_to_addr_time_from)->diffInMinutes(Carbon::parse($this->order->del_to_addr_time_from)->startOfDay());
        } else {
            $del_to_addr_time_from = -1;
        }

        $package = 0;
        if ($this->order->rig_pac) {
            $package = 1;
        } elseif ($this->order->stretch_pac) {
            $package = 2;
        } elseif ($this->order->bort_pac) {
            $package = 3;
        }

        $matrix = [];
        $payers = ['sender', 'receiver', 'tp'];
        $fields = [
            "TT",
            'to_addr',
            'from_addr',
            'package',
            'insurance',
            'prr_to_addr' ,
            'prr_from_addr' ,
            'total'
        ];
        $nds = false;
        foreach ($fields as $field) {
            foreach ($payers as $payer) {
                $payer_id =  $payer.'_id';
                if (!is_null($this->order->$payer_id) && $this->order->$payer_id == $this->order->who_pays->$field) {
                    if ($payer == 'sender') {
                        $matrix[] = "S";
                        if ($this->order->sender_comp && $this->order->sender_comp->with_nds) {
                            $nds = true;
                        }
                    } elseif ($payer == 'receiver') {
                        $matrix[] = "A";
                        if ($this->order->receiver_comp && $this->order->receiver_comp->with_nds) {
                            $nds = true;
                        }
                    } elseif ($payer == 'tp') {
                        $matrix[] = "T";
                        if ($this->order->tp_comp && $this->order->tp_comp->with_nds) {
                            $nds = true;
                        }
                    }
                }
            }
        }


        $data = [
            [
            str(floor(now("Europe/Moscow")->valueOf()))->value(),
            $this->order->route->city_from->name ?: "",
            $this->order->route->city_to->name ?: "",
            $this->order->method->name == "ЭКСПРЕСС" ? "1" : "0",
            $this->order->cargo_type->name ?: "",
            $this->order->address_from ?: "",
            $this->order->address_to ?: "",
            str(floor(Carbon::parse($this->order->date_del_from_addr)->timestamp  / 60 / 60 / 24) ?: -1)->value(),
            str(floor(Carbon::parse($this->order->date_del_to_addr)->timestamp  / 60 / 60 / 24) ?: -1)->value(),
            str($del_from_addr_time_from)->value(),
            str($del_to_addr_time_from)->value(),
            str($this->order->weight)->value(),
            str($this->order->volume)->value(),
            str($this->order->pieces)->value(),
            str($this->order->heaviest)->value(),
            str($this->order->longest)->value(),
            str($package)->value(),
            $this->order->prr_from_addr? "ИСТИНА" : "ЛОЖЬ",
            $this->order->prr_to_addr? "ИСТИНА" : "ЛОЖЬ",
            $this->order->insurance? "ИСТИНА" : "ЛОЖЬ",
            str($this->order->worth)->value(),
            str($this->order->sender_comp ? $this->order->sender_comp->INN : 0)->value(),
            str($this->order->receiver_comp ? $this->order->receiver_comp->INN : 0)->value(),
            str($this->order->tp_comp ? $this->order->tp_comp->INN : 0)->value(),
            $this->order->sender_comp ? $this->order->sender_comp->name : "Физлицо",
            $this->order->receiver_comp ? $this->order->receiver_comp->name : "Физлицо",
            $this->order->tp_comp ? $this->order->tp_comp->name : "Физлицо",
            $this->order->sender ? $this->order->sender->name : "",
            $this->order->receiver ? $this->order->receiver->name : "",
            $this->order->tp ? $this->order->tp->name : "",
            str($this->order->sender ? $this->order->sender->telnum : 0)->value(),
            str($this->order->receiver ? $this->order->receiver->telnum : 0)->value(),
            str($this->order->tp ? $this->order->tp->telnum : 0)->value(),
            $this->order->sender ? $this->order->sender->email : "",
            $this->order->receiver ? $this->order->receiver->email : "",
            $this->order->tp ? $this->order->tp->email : "",
            $this->order->order_num ?: "",
            str($this->order->order_prices->TT_price * 100 ?: 0)->value(),
            str($this->order->order_prices->from_addr_price * 100 ?: 0)->value(),
            str($this->order->order_prices->to_addr_price * 100 ?: 0)->value(),
            str($this->order->order_prices->prr_from_addr_price * 100 ?: 0)->value(),
            str($this->order->order_prices->prr_to_addr_price * 100 ?: 0)->value(),
            str($this->order->order_prices->pac_price * 100 ?: 0)->value(),
            str($this->order->order_prices->insurance_price * 100 ?: 0)->value(),
            str(0)->value(),
            implode('', $matrix),
            $nds ? "ИСТИНА" : "ЛОЖЬ",
            $this->order->comment?: "",
            $this->order->order_num,



        ]
        ];

        return $data;
    }

}
