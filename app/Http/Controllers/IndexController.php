<?php

namespace App\Http\Controllers;


use App\Mail\PasswordMade;
use App\Models\AppToOrder;
use App\Models\City;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\Order;
use App\Models\Route;
use App\Models\User;
use App\Services\Calculator;
use App\Services\FileService;
use App\Services\SaveOrderToGoogleService;
use App\Services\TelegramBot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public Order $order;

    public function about() {
        return view('index.about');
    }


    public function prices() {
        return view('index.prices');
    }

    public function docs() {
        return view('index.docs');
    }

    public function order(Request $request) {
        if ($request->data) {
            $data = $request->data;
            return view('index.order_from_index', compact('data'));
        }
        return view('index.order');
    }

    public function order_post(Request $request) {

            $calc = new Calculator();
            $order_id  = $calc->save($request['data']);
            $service = new SaveOrderToGoogleService($order_id);
            $service->send_application();
            return $order_id;

    }

    public function contacts() {
        return view('index.contacts');
    }

    public function save_cities(Request $request) {
        foreach ($request->cities as $city) {
            $new_ct = new City();
            $new_ct->code = $city['code'];
            $new_ct->name = $city['name'];
            $new_ct->save();
        }
        return $new_ct->id;
    }

    public function save_routes(Request $request) {

        try {
            $SPB = City::where('code', '=', 'SPB')->get('id');
            $MSK = City::where('code', '=', 'MSK')->get('id');

            $cities = City::all();

            foreach ($cities as $city) {
                $route = new Route();
                $route->from_city_id = $SPB[0]['id'];
                $route->to_city_id = $city->id;
                $route->save();
            }
            foreach ($cities as $city) {
                $route = new Route();
                $route->from_city_id = $MSK[0]['id'];
                $route->to_city_id = $city->id;
                $route->save();
            }
            return Route::all();
        } catch (\Exception $exception) {
            return json_encode([$exception->getMessage(), $SPB, $MSK]);
        }

    }

    public function status(Request $request) {

        $order = Order::where('order_num', '=', $request->order_num)->first();
        $order_num = $request->order_num;

        if ($order) {
            return view('index.status', compact('order', 'order_num'));
        } else {
            return view('index.status', compact('order_num'))->with(['error' => 'order_not_found']);
        }
    }

    public function success($order_id) {
        $order = Order::find($order_id);
        $telbot = new  TelegramBot($order_id);
        $telbot->new_order();
        return view('index.success', compact('order'));
    }

    public function order_repeat($id) {
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

        return view('index.order_repeat', compact('data'));
    }

    public function order_repeat_save(Request $request) {
            $calc = new Calculator();
            $order_id = $calc->save($request['data']);
            $service = new SaveOrderToGoogleService($order_id);
           $service->send_application();
        return $order_id;

    }

    public function excel_orders() {
        $orders = Order::whereNotNull('order_num')->get();
        $data = [];
        foreach ($orders  as $order) {
            $this->order = $order;

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
                    if ($this->order->$payer_id == $this->order->who_pays->$field) {
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


            $data[] = [
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
                    str($this->order->order_prices->from_addr_price* 100 ?: 0)->value(), str($this->order->order_prices->to_addr_price* 100 ?: 0)->value(),
                    str($this->order->order_prices->prr_from_addr_price* 100 ?: 0)->value(),
                    str($this->order->order_prices->prr_to_addr_price* 100 ?: 0)->value(),
                    str($this->order->order_prices->pac_price* 100 ?: 0)->value(),
                    str($this->order->order_prices->insurance_price* 100 ?: 0)->value(),
                    str(0)->value(),
                    implode('', $matrix),
                    $nds ? "ИСТИНА" : "ЛОЖЬ",
                    $this->order->comment?: "",
                    $this->order->order_num,

            ];


        }

        return $data;
    }
}
