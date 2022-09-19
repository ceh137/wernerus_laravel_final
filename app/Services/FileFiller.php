<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class FileFiller
{

    public Order $order;

    public function __construct($order_id)
    {
        $this->order = Order::find($order_id);
    }

    public function nakladnaya() {
        if ($this->order->receiver_company_id  &&  $this->order->receiver_comp->with_nds) {
            return Pdf::loadView('files.nakladnaya_nds',  ['order' => $this->order]);
        }
        return Pdf::loadView('files.nakladnaya',  ['order' => $this->order]);
    }

    public function PE() {
        $invoice_to_sender = false;
        $invoice_to_receiver = false;
        $who_pays = $this->order->who_pays;
        if ($who_pays->total == $this->order->sender_id || $who_pays->TT == $this->order->sender_id || $who_pays->to_addr == $this->order->sender_id || $who_pays->from_addr == $this->order->sender_id  || $who_pays->package == $this->order->sender_id  || $who_pays->insurance == $this->order->sender_id || $who_pays->prr_to_addr == $this->order->sender_id || $who_pays->prr_from_addr == $this->order->sender_id) {
            $invoice_to_sender = true;
        }
        if ($who_pays->total == $this->order->receiver_id || $who_pays->TT == $this->order->receiver_id || $who_pays->to_addr == $this->order->receiver_id || $who_pays->from_addr == $this->order->receiver_id  || $who_pays->package == $this->order->receiver_id  || $who_pays->insurance == $this->order->receiver_id || $who_pays->prr_to_addr == $this->order->receiver_id || $who_pays->prr_from_addr == $this->order->receiver_id) {
            $invoice_to_receiver = true;
        }
        if ($this->order->receiver_company_id  &&  $this->order->receiver_comp->with_nds) {
            return Pdf::loadView('files.PE_nds',  ['order' => $this->order, 'invoice_to_sender' => $invoice_to_sender,  'invoice_to_receiver' => $invoice_to_receiver]);
        }
        return Pdf::loadView('files.PE',  ['order' => $this->order, 'invoice_to_sender' => $invoice_to_sender,  'invoice_to_receiver' => $invoice_to_receiver]);
    }

    public function UPD() {
        $sender = [];
        $receiver = [];
        $third_party = [];
        $border_height = 400;

        $who_pays = $this->order->who_pays;
        if ($who_pays->TT ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price,];
        } elseif ($who_pays->TT ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];
        } elseif ($who_pays->TT ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];
        }

        if ($who_pays->to_addr ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
        } elseif ($who_pays->to_addr ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
        } elseif ($who_pays->to_addr ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
        }

        if ($who_pays->from_addr ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
        } elseif ($who_pays->from_addr ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
        } elseif ($who_pays->from_addr ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
        }

        if ($who_pays->package ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
        } elseif ($who_pays->package ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
        } elseif ($who_pays->package ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
        }

        if ($who_pays->insurance ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
        } elseif ($who_pays->insurance ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
        } elseif ($who_pays->insurance ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
        }

        if ($who_pays->prr_from_addr ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Погрузочно-разгрузочные работы при заборе груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
        } elseif ($who_pays->prr_from_addr ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Погрузочно-разгрузочные работы при заборе груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
        } elseif ($who_pays->prr_from_addr ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Погрузочно-разгрузочные работы при заборе груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
        }

        if ($who_pays->prr_to_addr ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
        } elseif ($who_pays->prr_to_addr ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
        } elseif ($who_pays->prr_to_addr ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
        }


        if ($who_pays->total ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];

            if ($this->order->to_addr) {
                $sender[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
            }
            if ($this->order->from_addr) {
                $sender[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
            }
            if ($this->order->rig_pac || $this->order->stretch_pac || $this->order->bort_pac) {
                $sender[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
            }
            if ($this->order->insurance) {
                $sender[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
            }
            if ($this->order->prr_to_addr) {
                $sender[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
            }
            if ($this->order->prr_from_addr) {
                $sender[] = ['title' => 'Погрузочно-разгрузочные работы при заборе груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
            }
        } elseif ($who_pays->total ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];

            if ($this->order->to_addr) {
                $receiver[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
            }
            if ($this->order->from_addr) {
                $receiver[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
            }
            if ($this->order->rig_pac || $this->order->stretch_pac || $this->order->bort_pac) {
                $receiver[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
            }
            if ($this->order->insurance) {
                $receiver[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
            }
            if ($this->order->prr_to_addr) {
                $receiver[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
            }
            if ($this->order->prr_from_addr) {
                $receiver[] = ['title' => 'Погрузочно-разгрузочные работы при заборе груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
            }
        } elseif ($who_pays->total ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];

            if ($this->order->to_addr) {
                $third_party[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
            }
            if ($this->order->from_addr) {
                $third_party[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
            }
            if ($this->order->rig_pac || $this->order->stretch_pac || $this->order->bort_pac) {
                $third_party[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
            }
            if ($this->order->insurance) {
                $third_party[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
            }
            if ($this->order->prr_to_addr) {
                $third_party[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
            }
            if ($this->order->prr_from_addr) {
                $third_party[] = ['title' => 'Погрузочно-разгрузочные работы при заборе груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
            }
        }
        $sender_height = count($sender)*12 + $border_height;
        $receiver_height = count($receiver)*12 + $border_height;
        $third_party_height = count($third_party)*12 + $border_height;
        $pdfs = [];
        if (!empty($sender)){
            if ($this->order->sender_company_id  &&  $this->order->sender_comp->with_nds) {
                $pdfs['sender'] =  Pdf::loadView('files.UPD_nds',  ['order' => $this->order, 'payment_rows' => $sender,  'payer' => $this->order->sender, 'height' => $sender_height]);
            } else {
                $pdfs['sender'] =  Pdf::loadView('files.UPD',  ['order' => $this->order, 'payment_rows' => $sender,  'payer' => $this->order->sender, 'height' => $sender_height]);
            }
        }
        if (!empty($receiver)){
            if ($this->order->receiver_company_id  &&  $this->order->receiver_comp->with_nds) {
                $pdfs['receiver'] =  Pdf::loadView('files.UPD_nds',  ['order' => $this->order, 'payment_rows' => $receiver,  'payer' => $this->order->receiver, 'height' => $receiver_height]);
            } else {
                $pdfs['receiver'] =  Pdf::loadView('files.UPD',  ['order' => $this->order, 'payment_rows' => $receiver,  'payer' => $this->order->receiver, 'height' => $receiver_height]);
            }
        }
        if (!empty($third_party) && !is_null($this->order->tp_id)){
            if ($this->order->tp_company_id  &&  $this->order->tp_comp->with_nds) {
                $pdfs['third_party'] =  Pdf::loadView('files.UPD_nds',  ['order' => $this->order, 'payment_rows' => $third_party,  'payer' => $this->order->tp, 'height' => $third_party_height]);
            } else {
                $pdfs['third_party'] =  Pdf::loadView('files.UPD',  ['order' => $this->order, 'payment_rows' => $third_party,  'payer' => $this->order->tp, 'height' => $third_party_height]);
            }
        }
        foreach ($pdfs as $pdf) {
            $pdf->setPaper('A4', 'landscape');
        }

        return $pdfs;

    }

    public function invoice() {
        $sender = [];
        $receiver = [];
        $third_party = [];

        $who_pays = $this->order->who_pays;
        if ($who_pays->TT ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price,];
        } elseif ($who_pays->TT ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];
        } elseif ($who_pays->TT ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];
        }

        if ($who_pays->to_addr ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
        } elseif ($who_pays->to_addr ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
        } elseif ($who_pays->to_addr ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
        }

        if ($who_pays->from_addr ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
        } elseif ($who_pays->from_addr ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
        } elseif ($who_pays->from_addr ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
        }

        if ($who_pays->package ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
        } elseif ($who_pays->package ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
        } elseif ($who_pays->package ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
        }

        if ($who_pays->insurance ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
        } elseif ($who_pays->insurance ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
        } elseif ($who_pays->insurance ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
        }

        if ($who_pays->prr_from_addr ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Погрузочно-разгрузочные работы на адресе забора груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
        } elseif ($who_pays->prr_from_addr ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Погрузочно-разгрузочные работы на адресе забора груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
        } elseif ($who_pays->prr_from_addr ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Погрузочно-разгрузочные работы на адресе забора груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
        }

        if ($who_pays->prr_to_addr ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
        } elseif ($who_pays->prr_to_addr ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
        } elseif ($who_pays->prr_to_addr ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
        }


        if ($who_pays->total ===  $this->order->sender_id) {
            $sender[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];

            if ($this->order->to_addr) {
                $sender[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
            }
            if ($this->order->from_addr) {
                $sender[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
            }
            if ($this->order->rig_pac || $this->order->stretch_pac || $this->order->bort_pac) {
                $sender[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
            }
            if ($this->order->insurance) {
                $sender[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
            }
            if ($this->order->prr_to_addr) {
                $sender[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
            }
            if ($this->order->prr_from_addr) {
                $sender[] = ['title' => 'Погрузочно-разгрузочные работы на адресе забора груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
            }
        } elseif ($who_pays->total ===  $this->order->receiver_id) {
            $receiver[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];

            if ($this->order->to_addr) {
                $receiver[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
            }
            if ($this->order->from_addr) {
                $receiver[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
            }
            if ($this->order->rig_pac || $this->order->stretch_pac || $this->order->bort_pac) {
                $receiver[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
            }
            if ($this->order->insurance) {
                $receiver[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
            }
            if ($this->order->prr_to_addr) {
                $receiver[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
            }
            if ($this->order->prr_from_addr) {
                $receiver[] = ['title' => 'Погрузочно-разгрузочные работы на адресе забора груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
            }
        } elseif ($who_pays->total ===  $this->order->tp_id) {
            $third_party[] = ['title' => 'Доставка '.$this->order->route->city_from->name.' - '.$this->order->route->city_to->name, 'price'  => $this->order->order_prices->TT_price];

            if ($this->order->to_addr) {
                $third_party[] = ['title' => 'Доставка от терминала до адреса', 'price'  => $this->order->order_prices->to_addr_price];
            }
            if ($this->order->from_addr) {
                $third_party[] = ['title' => 'Забор груза с адреса', 'price'  => $this->order->order_prices->from_addr_price];
            }
            if ($this->order->rig_pac || $this->order->stretch_pac || $this->order->bort_pac) {
                $third_party[] = ['title' => 'Упаковка груза', 'price'  => $this->order->order_prices->pac_price];
            }
            if ($this->order->insurance) {
                $third_party[] = ['title' => 'Страховка', 'price'  => $this->order->order_prices->insurance_price];
            }
            if ($this->order->prr_to_addr) {
                $third_party[] = ['title' => 'Погрузочно-разгрузочные работы при доставке', 'price'  => $this->order->order_prices->prr_to_addr_price];
            }
            if ($this->order->prr_from_addr) {
                $third_party[] = ['title' => 'Погрузочно-разгрузочные работы при заборе груза', 'price'  => $this->order->order_prices->prr_from_addr_price];
            }
        }

        $pdfs = [];
        if (!empty($sender)){
            if ($this->order->sender_company_id  &&  $this->order->sender_comp->with_nds) {
                $pdfs['sender'] =  Pdf::loadView('files.invoice_nds',  ['order' => $this->order, 'payment_rows' => $sender,  'payer' => $this->order->sender]);
            } else {
                $pdfs['sender'] =  Pdf::loadView('files.invoice',  ['order' => $this->order, 'payment_rows' => $sender,  'payer' => $this->order->sender]);
            }
        }
        if (!empty($receiver)){
            if ($this->order->receiver_company_id  &&  $this->order->receiver_comp->with_nds) {
                $pdfs['receiver'] =  Pdf::loadView('files.invoice_nds',  ['order' => $this->order, 'payment_rows' => $receiver,  'payer' => $this->order->receiver]);
            } else {
                $pdfs['receiver'] =  Pdf::loadView('files.invoice',  ['order' => $this->order, 'payment_rows' => $receiver,  'payer' => $this->order->receiver]);
            }
        }
        if (!empty($third_party) && !is_null($this->order->tp_id)){
            if ($this->order->receiver_company_id  &&  $this->order->receiver_comp->with_nds) {
                $pdfs['third_party'] =  Pdf::loadView('files.invoice_nds',  ['order' => $this->order, 'payment_rows' => $third_party,  'payer' => $this->order->tp]);
            } else {
                $pdfs['third_party'] =  Pdf::loadView('files.invoice',  ['order' => $this->order, 'payment_rows' => $third_party,  'payer' => $this->order->tp]);
            }
        }
        foreach ($pdfs as $pdf) {
            $pdf->setPaper('A4', 'portrait');
        }

        return $pdfs;
    }

}
