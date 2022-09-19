<?php

namespace App\Http\Livewire;

use App\Mail\PasswordMade;
use App\Models\AppToOrder;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\Order;
use App\Models\User;
use App\Services\FileService;
use App\Services\SaveOrderToGoogleService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class BulkApplicationToOrderModal extends ModalComponent
{
    public Collection $orders;
    public string $confirmationTitle = '';
    public string $trackNum ='';
    public Order $order;


    public static function modalMaxWidth(): string{
        return "3xl";
    }

    public function mount($ids) {
        $ids = explode(',', $ids);
        $this->orders = Order::findMany($ids);
        $this->confirmationTitle = 'Кол-во выбранных заказов: '.count($this->orders);
    }

    public function render()
    {
        return view('livewire.bulk-application-to-order-modal');
    }

    public function cancel() {
        $this->closeModal();
    }
    public function confirm() {
        foreach ($this->orders  as $order) {
            try {
                $this->order = $order;
                DB::beginTransaction();
                $app_to_order = new AppToOrder();
                $app_to_order->order_id = $this->order->id;
                $app_to_order->save();
                $app_to_order->order_num = (new \App\Services\TrackNum)->getTrackNum($app_to_order->id);
                $app_to_order->save();
                $this->order->status_id = 2;
                $this->order->time_to_order = now('Europe/Moscow');
                $this->order->order_num = $app_to_order->order_num;
                $this->order->save();
                $debt = new Debt();
                $debt->order_id = $this->order->id;
                $debt->amount = $this->order->order_prices->total;
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
                        if ($this->order->$payer.'_id' == $this->order->who_pays->$field) {
                            $debt_paid[$payer][$field] = false;
                        }
                    }
                }


                $debt->paid = json_encode($debt_paid);
                $debt->transfer_nums = '--';;
                $debt->transfer_date = null;
                $debt->save();

                $who_pays = $this->order->who_pays->toArray();

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
//                    Mail::to($user['email'])->send(new PasswordMade($user['pass'], $user, $this->order));
                }
                $files = new FileService($this->order->id);
                $files->generateAll();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e->getMessage());
            }
            $service  = new SaveOrderToGoogleService($order->id);
            $service->send();
        }

        $this->closeModalWithEvents([
            'pg:eventRefresh-application_table',
        ]);
    }
}
