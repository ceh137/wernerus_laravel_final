<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use function PHPUnit\Framework\isEmpty;

class ManagerAccountController extends Controller
{
    public function index() {
        $customers = Customer::where('manager_id', '=', auth()->user()->id)->get();
        $companies = Company::where('manager_id', '=', auth()->user()->id)->get();

        $payers_debt = collect(array());
        $payers = $customers->merge($companies);
        $prs = ['sender', 'receiver', 'tp'];
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


        foreach ($payers as $payer) {
            $sum = 0;
            $debt = 0;
            $is_red  = false;
            $meters = 0;
            $weight_volume = 0;
            $orders_count = 0;

            foreach ($payer->orders() as $order) {

                if ($payer instanceof Customer) {
                    $who = $payer->id == $order->sender_id ? 'sender_id' : ($payer->id == $order->receiver_id ? 'receiver_id' : 'tp_id');
                    $who_payer = $payer->id == $order->sender_id ? 'sender' : ($payer->id == $order->receiver_id ? 'receiver' : 'tp');

                    $paid = json_decode($order->debt->paid, true);

                        foreach ($fields as $field => $price) {
                            if ($order->$who == $order->who_pays->$field) {
                               if (!empty($paid[$who_payer][$field]) && isset($paid[$who_payer][$field]) && $paid[$payer][$field]) {
                                   $sum += $order->order_prices->$price ? : 0;
                               } else {
                                   $sum += $order->order_prices->$price ? : 0;
                                   $debt += $order->order_prices->$price ? : 0;
                                   if ($order->app_to_order->created_at->diffInDays(Carbon::today()->endOfDay()) > $payer->debt_time) {
                                       $is_red = true;
                                   }
                               }

                            }
                        }

                } elseif ($payer instanceof Company) {
                    $who = $payer->id == $order->sender_company_id ? 'sender_id' : ($payer->id == $order->receiver_company_id ? 'receiver_id' : 'tp_id');
                    $who_payer = $payer->id == $order->sender_company_id ? 'sender' : ($payer->id == $order->receiver_company_id ? 'receiver' : 'tp');

                    $paid = json_decode($order->debt->paid, true);

                    foreach ($fields as $field => $price) {
                        if ($order->$who == $order->who_pays->$field) {

                            if (!empty($paid[$who_payer][$field]) && isset($paid[$who_payer][$field]) && $paid[$who_payer][$field]) {
                                $sum += $order->order_prices->$price ? : 0;
                            } else {
                                $sum += $order->order_prices->$price  ? : 0;
                                $debt += $order->order_prices->$price ? : 0;
                                if ($order->app_to_order->created_at->diffInDays(Carbon::today()->endOfDay()) > $payer->debt_time) {
                                    $is_red = true;
                                }

                            }


                        }
                    }
                }

                $meters += $order->volume;
                $weight_volume += $order->weight / 250;
                $orders_count +=1;
            }



            $payers_debt->push([
                'id' => $payer->id,
                'name' => $payer->name,
                'debt' => $debt,
                'sum' => $sum,
                'what' => $payer instanceof Customer ? "customer" : "company",
                'is_red' => $is_red,
                'meters' => $meters,
                'weight_volume' => $weight_volume,
                'orders_count' => $orders_count,
            ]);

        }


        return view('admin.manager_account', ['payers_debt' => json_decode($payers_debt->toJson())]);
    }
}
