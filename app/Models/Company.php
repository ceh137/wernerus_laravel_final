<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'INN',
    ];

    public function ordersSetUp()
    {
        return Order::where(function ($q) {
            return $q->where('sender_company_id', $this->id)
                ->whereHas('who_pays', function ($q) {
                    return $q->whereRaw('who_pays.TT = sender_id')
                        ->orWhereRaw('who_pays.to_addr = sender_id')
                        ->orWhereRaw('who_pays.from_addr = sender_id')
                        ->orWhereRaw('who_pays.package = sender_id')
                        ->orWhereRaw('who_pays.insurance = sender_id')
                        ->orWhereRaw('who_pays.prr_to_addr = sender_id')
                        ->orWhereRaw('who_pays.prr_from_addr = sender_id')
                        ->orWhereRaw('who_pays.total = sender_id');
                })->orWhere(function ($q) {
                    return $q->where('receiver_company_id', $this->id)
                        ->whereHas('who_pays', function ($q) {
                            return $q->whereRaw('who_pays.TT = receiver_id')
                                ->orWhereRaw('who_pays.to_addr = receiver_id')
                                ->orWhereRaw('who_pays.from_addr = receiver_id')
                                ->orWhereRaw('who_pays.package = receiver_id')
                                ->orWhereRaw('who_pays.insurance = receiver_id')
                                ->orWhereRaw('who_pays.prr_to_addr = receiver_id')
                                ->orWhereRaw('who_pays.prr_from_addr = receiver_id')
                                ->orWhereRaw('who_pays.total = receiver_id');
                        });
                })->orWhere(function ($q) {
                    return $q->where('tp_company_id', $this->id)
                        ->whereHas('who_pays', function ($q) {
                            return $q->whereRaw('who_pays.TT = tp_id')
                                ->orWhereRaw('who_pays.to_addr = tp_id')
                                ->orWhereRaw('who_pays.from_addr = tp_id')
                                ->orWhereRaw('who_pays.package = tp_id')
                                ->orWhereRaw('who_pays.insurance = tp_id')
                                ->orWhereRaw('who_pays.prr_to_addr = tp_id')
                                ->orWhereRaw('who_pays.prr_from_addr = tp_id')
                                ->orWhereRaw('who_pays.total = tp_id');
                        });
                });
        })
            ->whereHas('app_to_order')->with('app_to_order');



    }
    public function orders() {
        return $this->ordersSetUp()->get();
    }
}
