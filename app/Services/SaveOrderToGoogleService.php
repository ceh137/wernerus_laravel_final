<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        foreach ($fields as $k => $field) {
            foreach ($payers as $payer) {
                $payer_id =  $payer.'_id';
                if (!is_null($this->order->$payer_id) && $this->order->$payer_id == $this->order->who_pays->$field) {
                    if ($payer == 'sender') {
                        $matrix[$k] = "S";
                        if ($this->order->sender_comp && $this->order->sender_comp->with_nds) {
                            $nds = true;
                        }
                    } elseif ($payer == 'receiver') {
                        $matrix[$k] = "A";
                        if ($this->order->receiver_comp && $this->order->receiver_comp->with_nds) {
                            $nds = true;
                        }
                    } elseif ($payer == 'tp') {
                        $matrix[$k] = "T";
                        if ($this->order->tp_comp && $this->order->tp_comp->with_nds) {
                            $nds = true;
                        }
                    }
                }
            }
            if (!array_key_exists($k, $matrix)) {
                $matrix[$k] = "0";
            }
        }
        $content = Storage::get('tracknums.txt');
        $data = json_decode($content);
        $number = array_search($this->order->order_num, $data);

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
            str(number_format($this->order->weight, 2, ',' , ''))->value(),
            str(number_format($this->order->volume, 2, ',' , ''))->value(),
            str(number_format($this->order->pieces, 2, ',' , ''))->value(),
            str(number_format($this->order->heaviest, 2, ',' , ''))->value(),
            str(number_format($this->order->longest, 2, ',' , ''))->value(),
            str($package)->value(),
            $this->order->prr_from_addr? "ИСТИНА" : "ЛОЖЬ",
            $this->order->prr_to_addr? "ИСТИНА" : "ЛОЖЬ",
            $this->order->insurance? "ИСТИНА" : "ЛОЖЬ",
            str(number_format($this->order->worth, 2, ',' , ''))->value(),
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
            str($number)->value(),
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
            $this->order->comment ?: "",
            $this->order->order_num ?: "",
            auth()->user()->email,



        ]
        ];

        return $data;
    }


    public function send_application() {
        $service = new GoogleService(true, 'application');
        $service->saveDataToSheet($this->getReadyDataApplication());
    }

    public function getReadyDataApplication() {

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
            foreach ($fields as $k => $field) {
                foreach ($payers as $payer) {
                    $payer_id =  $payer.'_id';
                    if (!is_null($this->order->$payer_id) && $this->order->$payer_id == $this->order->who_pays->$field) {
                        if ($payer == 'sender') {
                            $matrix[$k] = "Отправитель";
                        } elseif ($payer == 'receiver') {
                            $matrix[$k] = "Получатель";
                        } elseif ($payer == 'tp') {
                            $matrix[$k] = "Третье Лицо";
                        }
                    }
                }
                if (!array_key_exists($k, $matrix)) {
                    $matrix[$k] = "";
                }

            }
            $data = [
                [
                    str(Carbon::parse($this->order->created_at)->format('Y-m-d H:i'))->value(),
                    $this->order->method->name,
                    $this->order->route->city_from->name ?: "",
                    $this->order->route->city_to->name ?: "",
                    $this->order->address_from ?: "",
                    $this->order->address_to ?: "",
                    str(Carbon::parse($this->order->date_del_from_addr)->format('Y-m-d'))->value(),
                    str(Carbon::parse($this->order->date_del_to_addr)->format('Y-m-d'))->value(),
                    str($this->order->del_from_addr_time_from)->value(),
                    str($this->order->del_from_addr_time_to)->value(),
                    str($this->order->del_to_addr_time_from)->value(),
                    str($this->order->del_to_addr_time_to)->value(),
                    number_format($this->order->weight, 2, ',', ''),
                    number_format($this->order->volume, 2, ',', ''),
                    number_format($this->order->pieces, 2, ',', ''),
                    number_format($this->order->heaviest, 2, ',', ''),
                    number_format($this->order->longest, 2, ',', ''),

                    number_format($this->order->order_prices->TT_price ?: 0, 2, ',', ''),
                    number_format($this->order->order_prices->from_addr_price ?: 0, 2, ',', ''),
                    number_format($this->order->order_prices->to_addr_price ?: 0, 2, ',', ''),
                    number_format($this->order->order_prices->pac_price ?: 0, 2, ',', ''),
                    str(0)->value(),
                    str(0)->value(),
                    number_format($this->order->order_prices->insurance_price ?: 0, 2, ',', ''),
                    number_format($this->order->order_prices->prr_from_addr_price ?: 0, 2, ',', ''),
                    number_format($this->order->order_prices->prr_to_addr_price ?: 0, 2, ',', ''),
                    number_format($this->order->worth ?: 0, 2, ',', ''),

                    str($this->order->sender_comp ? $this->order->sender_comp->INN : 0)->value(),
                    $this->order->sender ? $this->order->sender->name : "",
                    str($this->order->sender ? $this->order->sender->telnum : 0)->value(),
                    str($this->order->sender ? $this->order->sender->email : 0)->value(),

                    str($this->order->receiver_comp ? $this->order->receiver_comp->INN : 0)->value(),
                    $this->order->receiver ? $this->order->receiver->name : "",
                    str($this->order->receiver ? $this->order->receiver->telnum : 0)->value(),
                    str($this->order->receiver ? $this->order->receiver->email : 0)->value(),


                    str($this->order->tp_comp ? $this->order->tp_comp->INN : 0)->value(),
                    $this->order->tp ? $this->order->tp->name : "",
                    str($this->order->tp ? $this->order->tp->telnum : 0)->value(),
                    str($this->order->tp ? $this->order->tp->email : 0)->value(),

                    $matrix[7] ?: "", // all
                    $matrix[0] ?: "", //TT
                    $matrix[1] ?: "", //del to addr
                    $matrix[2] ?: "", //del from addr
                    $matrix[3] ?: "", //pac
                    $matrix[4] ?: "", //insurance
                    $matrix[6] ?: "", //prr from addr
                    $matrix[5] ?: "",// prr to addr
                    number_format($this->order->order_prices->total, 2, ',', ''),
                    $this->order->sender_comp ? $this->order->sender_comp->name : "",
                    $this->order->receiver_comp ? $this->order->receiver_comp->name : "",
                    $this->order->tp_comp ? $this->order->tp_comp->name : "",

                    $this->order->comment?: "",
                    $this->order->cargo_type->name ?: "",
                ]
            ];
            return $data;



    }
}
