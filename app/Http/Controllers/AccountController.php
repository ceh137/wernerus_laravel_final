<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function account() {
        if (!is_null(auth()->user()->company_id)) {
            $customers =  Customer::where('company_id', '=' , auth()->user()->company_id)->get('id')->toArray();
        } else {
            $customers = Customer::where('telnum', '=',  auth()->user()->telnum)->get('id')->toArray();
        }
        $customers_ids = [];
        foreach ($customers as $customer) {
            $customers_ids[] = $customer['id'];
        }

        $orders = Order::leftJoin('who_pays', 'orders.who_pays_id', '=', 'who_pays.id')
            ->whereIn('sender_id', $customers_ids)
            ->orWhereIn('receiver_id', $customers_ids)
            ->orWhereIn('tp_id', $customers_ids)
            ->whereIn('who_pays.TT', $customers_ids)
            ->orWhereIn('who_pays.to_addr', $customers_ids)
            ->orWhereIn('who_pays.from_addr', $customers_ids)
            ->orWhereIn('who_pays.package', $customers_ids)
            ->orWhereIn('who_pays.insurance', $customers_ids)
            ->orWhereIn('who_pays.prr_to_addr', $customers_ids)
            ->orWhereIn('who_pays.prr_from_addr', $customers_ids)
            ->orWhereIn('who_pays.total', $customers_ids)
            ->with([
                'order_prices',
                'route',
                'sender',
                'receiver',
                'tp',
                'sender_comp',
                'receiver_comp',
                'tp_comp',
                'cargo_type',
                'files',
                'method',
                'status',
                'files'
            ])->get([
                'orders.*',
                'who_pays.id as who_pays_id_table'
            ]);
        $who_is_user = [];
        foreach ($orders as $order) {
            if ($order->sender->telnum == auth()->user()->telnum) {
                $who_is_user[$order->id] = 'sender';
            } elseif ($order->receiver->telnum == auth()->user()->telnum) {
                $who_is_user[$order->id] = 'receiver';
            } elseif ($order->tp->telnum == auth()->user()->telnum) {
                $who_is_user[$order->id] = 'tp';
            }
        }
        $fields = [
            "TT" => "TT_price",
            'to_addr' => 'to_addr_price',
            'from_addr' => 'from_addr_price',
            'package' => 'pac_price',
            'insurance' => 'insurance_price',
            'prr_to_addr' => 'prr_to_addr_price',
            'prr_from_addr' => 'prr_from_addr_price' ,
            'total' => 'total'
        ];

        return view('index.account', compact('orders', 'who_is_user', 'fields'));
    }
}
