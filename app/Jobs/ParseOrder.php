<?php

namespace App\Jobs;

use App\Models\AppToOrder;
use App\Models\City;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\File;
use App\Models\Order;
use App\Models\OrderPrice;
use App\Models\Route;
use App\Models\Type;
use App\Models\User;
use App\Models\WhoPays;
use App\Services\FileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public array $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;

        try {
                $from_c_id = City::where('name', $data[1])->first()->id;
                $to_c_id = City::where('name', $data[2])->first()->id;

                $route_id = Route::where(['to_city_id' => $to_c_id, 'from_city_id' => $from_c_id])->first();

                if (is_null($route_id))
                {
                    return;
                } else {
                    $route_id = $route_id->id;
                }

            $prices = [
                'TT_price' =>   intval($data[37])/100 ?: 0,
                'to_addr_price' => intval($data[39])/100 ?: 0,
                'from_addr_price' => intval($data[38])/100 ?: 0,
                'pac_price' => intval($data[42])/100 ?: 0,
                'insurance_price' => intval($data[43])/100 ?: 0,
                'prr_to_addr_price' =>  intval($data[41])/100 ?: 0,
                'prr_from_addr_price' => intval($data[40])/100 ?: 0,
                'total' => 0,
            ];
            $total = array_sum($prices) + intval($data[44])/100;
            $prices['total'] = $total;

            $order_prices = new OrderPrice($prices);
            $order_prices->save();

            $delivery_type = 'TT';
            if ($data[19] && !$data[18]) {
                $delivery_type = 'AT';
            } elseif ($data[19] && $data[18]) {
                $delivery_type = 'AA';
            } elseif (!$data[19] && $data[18]) {
                $delivery_type = 'TA';
            }

            try {
                $type = Type::where('name', '=', $data[4])->first()->id;
            } catch (\Exception $e) {
                $type = 11;
            }

            $sender =  Customer::create(
                [
                    'name' => $data[27],
                    'email' => $data[33],
                    'telnum' => $data[30],
                ]);

            if ($data[21] != '0') {
                $sender_comp = Company::updateOrCreate([
                    'INN' => $data[21],
                ],[
                    'INN' => $data[21],
                    'name' => $data[24],
                ]);
                $sender->company_id = $sender_comp->id;
                $sender->save();
            }

            $receiver = Customer::create([
                'name' => $data[28],
                'email' => $data[34],
                'telnum' => $data[31],
            ]);
            if ($data[22] != '0') {
                $receiver_comp = Company::updateOrCreate([
                    'INN' => $data[22],
                ],[
                    'INN' => $data[22],
                    'name' => $data[25],
                ]);
                $receiver->company_id = $receiver_comp->id;
                $receiver->save();
            }


            if ($data[36]) {
                $third_party = Customer::create([
                    'name' => $data[29],
                    'email' => $data[35],
                    'telnum' => $data[32],
                ]);
                if ($data[23] != '0') {
                    $third_party_comp = Company::updateOrCreate([
                        'INN' => $data[23],
                    ],[
                        'INN' => $data[23],
                        'name' => $data[26],
                    ]);
                    $third_party->company_id = $third_party_comp->id;
                    $third_party->save();
                }
            }


            $files = new File();
            $files->save();
            $res = [];
            $matrix = str_split($data[45]);
            if (count(array_flip($matrix)) === 1 && (end($matrix) === 'A' || end($matrix) === 'S' || end($matrix) === 'T')) {
                if (end($matrix) === 'A') {
                    $res['pay_all'] = $receiver->id;
                } elseif (end($matrix) === 'S') {
                    $res['pay_all'] = $sender->id;
                } elseif (end($matrix) === 'T') {
                    $res['pay_all'] = $third_party->id;
                }else {
                    $res['pay_all'] = null;
                }

            }
//            $p = [
//                39 => 'pay_all',
//                40 => 'pay_TT',
//                41 => 'pay_del_to_addr',
//                42 => 'pay_del_from_addr',
//                43 => 'pay_pac',
//                44 => 'pay_ins',
//                45 => 'pay_PRR_from_addr',
//                46 => 'pay_PRR_to_addr',
//            ];
//
//            foreach ($p as $k=>$v) {
//                if ($data[$k] == 'Отправитель') {
//                    $res[$v] = $sender->id;
//                } elseif ($data[$k] == 'Получатель') {
//                    $res[$v] = $receiver->id;
//                } elseif ($data[$k] == '3e-лицо') {
//                    $res[$v] = $third_party->id;
//                } else {
//                    $res[$v] = null;
//                }
//            }

            $payments = [
                "TT" => null,
                'to_addr' => null,
                'from_addr' => null,
                'package' => null,
                'insurance' => null,
                'prr_to_addr' => null,
                'prr_from_addr' => null,
                'total' => $res['pay_all']
            ];

            $who_pays = new WhoPays($payments);
            $who_pays->save();

            if ($data[46] == 'TRUE') {
                    $u = Customer::find($res['pay_all']);
                    $c = Company::find($u->company->id);

                    $c->with_nds = true;
                    $c->save();


            }

            if ($data[3] == '0') {
                $method = 2;
            } elseif ($data[3] == '1') {
                $method =  1 ;
            }

            $order = [
                'method_id' => $method,
                'route_id' => $route_id,
                'delivery_type' => $delivery_type,
                'del_from_addr_time_from' => Carbon::createFromTimestamp($data[7] * 24 * 60 * 60 + $data[9] * 60)->format('H:i'),
                'del_from_addr_time_to' => '0',
                'del_to_addr_time_from' => Carbon::createFromTimestamp($data[8] * 24 * 60 * 60 + $data[10] * 60)->format('H:i'),
                'del_to_addr_time_to' => '0',
                'date_del_to_addr' => Carbon::createFromTimestamp($data[8] * 24 * 60 * 60)->toDateTimeString(),
                'date_del_from_addr' => Carbon::createFromTimestamp($data[7] * 24 * 60 * 60)->toDateTimeString(),
                'weight' => toFloat($data[11]),
                'volume' => toFloat($data[12]),
                'pieces' => toFloat($data[13]),
                'heaviest' => toFloat($data[14]),
                'longest' => toFloat($data[15]),
                'worth' => toFloat($data[20]),
                'to_addr' => $data[18] != '',
                'from_addr' => $data[19] != '',
                'rig_pac' => $data[16] == '1',
                'stretch_pac' => $data[16] == '2',
                'bort_pac' => $data[16] == '3',
                'insurance' => $data[19] != 'FALSE',
                'prr_to_addr' => $data[17] != 'FALSE',
                'prr_from_addr' => $data[18] != 'FALSE',
                'type_id' => $type,
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'tp_id' => $third_party->id ?? null,
                'sender_company_id' => $sender_comp->id ?? null,
                'receiver_company_id' => $receiver_comp->id ?? null,
                'tp_company_id' => $third_party_comp->id ?? null,
                'order_price_id' => $order_prices->id,
                'who_pays_id' => $who_pays->id,
                'comment' => $data[47],
                'filled_at_terminal' => false,
                'status_id' => 2,
                'files_id' => $files->id,
                'address_to' => $data[6],
                'address_from'=> $data[5],
                'created_at'  => Carbon::createFromTimestamp($data[0]/1000)->toDateTimeString(),
                'updated_at' => Carbon::createFromTimestamp($data[0]/1000)->toDateTimeString()
            ];

            $norder = new Order($order);
            $norder->save();

            $app_to_order = new AppToOrder();
            $app_to_order->order_id = $norder->id;
            $app_to_order->save();
            $app_to_order->order_num = $data[48];
            $app_to_order->save();
            $norder->status_id = 2;
            $norder->time_to_order = Carbon::createFromTimestamp($data[0]/1000)->toDateTimeString();
            $norder->order_num = $app_to_order->order_num;
            $norder->save();
            $debt = new Debt();
            $debt->order_id = $norder->id;
            $debt->amount = $norder->order_prices->total;
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
                    if ($norder->$payer.'_id' == $norder->who_pays->$field) {
                        $debt_paid[$payer][$field] = false;
                    } else {
                        $debt_paid[$payer][$field] = false;
                    }
                }
            }


            $debt->paid = json_encode($debt_paid);
            $debt->transfer_nums = $data[52] ?: "--";
            $debt->transfer_date = $data[51] ?: null;
            $debt->save();

            $who_pays = $norder->who_pays->toArray();

            $users = [];

            foreach ($who_pays as  $user_id) {
                $customer = Customer::find($user_id);
                if (!$customer) {
                    continue;
                } else {

                    if ($customer->company_id == null && $customer->telnum != null && $customer->email != null) {
                        $pass = strtok($customer->email, '@').substr($customer->telnum, -4);
                    } elseif ($customer->company_id == null && $customer->telnum != null) {
                        $pass = substr(Str::slug($customer->name), 5).substr($customer->telnum, -4);
                    } elseif (!is_null($customer->company_id) && !is_null($customer->email)) {
                        $pass = strtok($customer->email, '@').substr($customer->company->INN, -4);
                    } else {
                        $pass = Str::random(8);
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
                            'company_id'  => $customer->company_id ?: null ,
                            'role_id' => 5,
                        ]);
                    if ($user->wasRecentlyCreated === true) {
                        $users[] = array_merge($user->toArray(), array('pass'=>$pass));
                    }


                }
            }
            $unique = collect($users)->unique('email');
            foreach ($unique->values()->all() as $user) {
//                    Mail::to($user['email'])->send(new PasswordMade($user['pass'], $user, $norder));
            }


        } catch (\Exception $e) {

            dd($e->getMessage(), $e->getLine());
        }
    }
}
