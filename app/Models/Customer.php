<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'telnum',
        'company_id',
        'manager_id'
    ];

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function orders_as_sender() {
        return $this->belongsTo(Order::class, 'id','sender_id');
    }
    public function orders_as_receiver() {
        return $this->belongsTo(Order::class, 'id','receiver_id');
    }
    public function orders_as_tp() {
        return $this->belongsTo(Order::class, 'id','tp_id');
    }

    public function ordersSetUp() {
        return Order::where( function ($query){
            return $query->whereHas('who_pays', function ($q) {
                return $q->where('TT', $this->id)
                    ->orWhere('to_addr', $this->id)
                    ->orWhere('from_addr', $this->id)
                    ->orWhere('package', $this->id)
                    ->orWhere('insurance', $this->id)
                    ->orWhere('prr_to_addr', $this->id)
                    ->orWhere('prr_from_addr', $this->id)
                    ->orWhere('total', $this->id);

                });
            })->whereHas('app_to_order', function ($query){
                    return $query->where('updated_at', '>=', Carbon::now()->startOfMonth()->subMonth()->toDateString());
            });
    }

    public function orders() {
        return $this->ordersSetUp()->get();
    }
}
