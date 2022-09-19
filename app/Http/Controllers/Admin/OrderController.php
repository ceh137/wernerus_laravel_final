<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PasswordMade;
use App\Models\AppToOrder;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\Order;
use App\Models\User;
use App\Services\Calculator;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index() {
        return view('admin.orders');
    }

    public function repeat($id) {
        $order = Order::with(['route' => function ($q) {
            $q->with(['city_to', 'city_from']);
        }])
            ->with(['sender', 'receiver', 'tp', 'sender_comp', 'receiver_comp', 'tp_comp', 'cargo_type', 'who_pays', 'method'])
            ->find($id);
        $data = [];
        $people = ['sender' => 'sender', 'receiver' => 'receiver', 'third_party' => 'tp'];
        $comps = ['sender' =>'sender_comp', 'receiver' =>'receiver_comp','third_party' => 'tp_comp'];
        try {
            foreach ($people as $k=>$v) {
                if (!is_null($order->{$comps[$k]}) && !is_null($order->{$v}) && !is_null($order->{$v.'_id'}) && !is_null($order->{$comps[$k].'any_id'})) {
                    $data['payments'][$k] = [
                        'INN' => $order->{$comps[$k]}->INN ?? '',
                        'company' => $order->{$comps[$k]}->name ?? '',
                        'name' => $order->{$v}->name ?? '',
                        'tel' => $order->{$v}->telnum,
                        'email' => $order->{$v}->email,
                        'pay_all' => $order->who_pays->total == $order->{$v}->id ?? false,
                        'pay_TT' => $order->who_pays->TT == $order->{$v}->id ?? false,
                        'pay_pac' => $order->who_pays->package == $order->{$v}->id ?? false,
                        'pay_ins' => $order->who_pays->insurance == $order->{$v}->id ?? false,
                        'pay_del_to_addr' => $order->who_pays->to_addr == $order->{$v}->id ?? false,
                        'pay_del_from_addr' => $order->who_pays->from_addr == $order->{$v}->id ?? false,
                        'pay_PRR_to_addr' => $order->who_pays->prr_to_addr == $order->{$v}->id ?? false,
                        'pay_PRR_from_addr' => $order->who_pays->prr_from_addr == $order->{$v}->id ?? false,
                        'subtotal' => 0
                    ];

                    foreach ($data['payments'][$k] as $key => $val) {
                        if ($val == null) {
                            $data['payments'][$k][$key] = '';
                        }
                    }
                } else {
                    if (!is_null($order->{$v}) && !is_null($order->{$v.'_id'})) {
                        $data['payments'][$k] = [
                            'INN' => '',
                            'company' => '',
                            'name' => $order->{$v}->name,
                            'tel' => $order->{$v}->telnum,
                            'email' => $order->{$v}->email,
                            'pay_all' => $order->who_pays->total == $order->{$v}->id ?? false,
                            'pay_TT' => $order->who_pays->TT == $order->{$v}->id ?? false,
                            'pay_pac' => $order->who_pays->package == $order->{$v}->id ?? false,
                            'pay_ins' => $order->who_pays->insurance == $order->{$v}->id ?? false,
                            'pay_del_to_addr' => $order->who_pays->to_addr == $order->{$v}->id ?? false,
                            'pay_del_from_addr' => $order->who_pays->from_addr == $order->{$v}->id ?? false,
                            'pay_PRR_to_addr' => $order->who_pays->prr_to_addr == $order->{$v}->id ?? false,
                            'pay_PRR_from_addr' => $order->who_pays->prr_from_addr == $order->{$v}->id ?? false,
                            'subtotal' => 0
                        ];
                    } else {
                        $data['payments'][$k] = [
                            'INN' => '',
                            'company' => '',
                            'name' => '',
                            'tel' => '',
                            'email' => '',
                            'pay_all' => false,
                            'pay_TT' =>  false,
                            'pay_pac' =>  false,
                            'pay_ins' =>  false,
                            'pay_del_to_addr' =>  false,
                            'pay_del_from_addr' =>  false,
                            'pay_PRR_to_addr' =>  false,
                            'pay_PRR_from_addr' =>  false,
                            'subtotal' => 0
                        ];
                    }


                    foreach ($data['payments'][$k] as $key => $val) {
                        if ($val == null) {
                            $data['payments'][$k][$key] = '';
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            dump($comps[$k]);
            return $e->getMessage();
        }
        $order->toArray();
        $order['payments'] = $data['payments'];
        $data = json_encode($order);
//        dd($id);

        return view('admin.order_application.repeat', compact('data'));
    }

    public function repeat_save(Request $request) {
        try {
            $calc = new Calculator();
            $order_id = $calc->save($request['data']);
            $app_to_order = new AppToOrder();
            $app_to_order->order_id = $order_id;
            $app_to_order->save();
            $app_to_order->order_num = (new \App\Services\TrackNum)->getTrackNum($app_to_order->id);
            $app_to_order->save();
            $order = Order::find($order_id);
            $order->order_num = $app_to_order->order_num;
            $order->status_id = 2;
            $order->time_to_order = now('Europe/Moscow');

            $order->save();
            $debt = new Debt();
            $debt->order_id = $order->id;
            $debt->amount = $order->order_prices->total;
            $debt->debt_status_id = 10;
            $debt->is_in_debt = true;
            $debt_paid = [
                'sender' => [],
                'receiver' => [],
                'tp' => []
            ];
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
            foreach ($payers as $payer) {
                foreach ($fields as $field) {
                    if ($order->$payer.'_id' == $order->who_pays->$field) {
                        $debt_paid[$payer][$field] = false;
                    } else {
                        $debt_paid[$payer][$field] = false;
                    }
                }
            }


            $debt->paid = json_encode($debt_paid);
            $debt->transfer_nums = null;
            $debt->transfer_date = null;
            $debt->save();

            $who_pays = $order->who_pays->toArray();

            $users = [];
//            dd($who_pays);
            foreach ($who_pays as  $user_id) {
                $customer = Customer::find($user_id);
                if (!$customer) {
                    continue;
                } else {

                    if ($customer->company_id == null && $customer->telnum != null && $customer->email != null) {
                        $pass = strtok($customer->email, '@').substr($customer->telnum, -4);
                    } elseif ($customer->company_id == null && $customer->telnum != null) {
                        $pass = substr(str_slug($customer->name), 5).substr($customer->telnum, -4);
                    } elseif (!is_null($customer->company_id) && !is_null($customer->email)) {
                        $pass = strtok($customer->email, '@').substr($customer->company->INN, -4);
                    } else {
                        $pass = str_random(8);
                    }
                    $user = User::firstOrCreate(
                        [
                            'email'  => $customer->email,
                        ],
                        [
                            'name' => $customer->name,
                            'telnum' => $customer->telnum,
                            'email'  => $customer->email,
                            'password' =>  Hash::make($pass),
                            'company_id'  =>$customer->company_id ?: null ,
                            'role_id' => 5,
                        ]);
                    if ($user->wasRecentlyCreated === true) {
                        $users[] = array_merge($user->toArray(), array('pass'=>$pass));
                    }


                }
            }
            $unique = collect($users)->unique('email');

            foreach ($unique->values()->all() as $user) {
                Mail::to($user['email'])->send(new PasswordMade($user['pass'], $user, $order));
            }
            $files = new FileService($order->id);
            $files->generateAll();
            return $order->id;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
