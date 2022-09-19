<?php

namespace App\Http\Livewire;

use App\Mail\Invoice;
use App\Mail\PasswordMade;
use App\Mail\UPD;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use LivewireUI\Modal\Modal;
use LivewireUI\Modal\ModalComponent;

class SendEmails extends ModalComponent
{
    public Order $order;
    public string $confirmationTitle = 'Отправка документов';
    public string $trackNum ='';
    public string $nakEmail = '';
    public string $senderUPDEmail = '';
    public string $receiverUPDEmail = '';
    public string $third_partyUPDEmail = '';
    public string $senderInvoiceEmail = '';
    public string $receiverInvoiceEmail = '';
    public string $third_partyInvoiceEmail = '';
    public string $peEmail = '';
    public string $status = '';

    public static function modalMaxWidth(): string{
        return "4xl";
    }

    public function mount($id, $status) {
        $this->order = Order::find($id);

        $this->nakEmail = $this->order->receiver->email;
        $this->senderUPDEmail = $this->order->sender->email;
        $this->receiverUPDEmail = $this->order->receiver->email;
        $this->senderInvoiceEmail = $this->order->sender->email;
        $this->receiverInvoiceEmail = $this->order->receiver->email;

        $this->peEmail = $this->order->receiver->email;
        if (!is_null($this->order->tp_id)) {
            $this->third_partyUPDEmail = $this->order->tp->email;
            $this->third_partyInvoiceEmail = $this->order->tp->email;
        }


        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.send-emails');
    }

    public function cancel() {
        $this->closeModal();
    }

    public function confirm() {

        $files = $this->order->files;

        if ($this->status == 'accepted') {
            $who_pays = $this->order->who_pays->toArray();
            $who_is_user = '';
            $users  = collect(array());
            foreach ($who_pays as  $user_id) {
                $customer = Customer::find($user_id);
                if (!$customer) {
                    continue;
                } else {
                    if ($user_id == $this->order->sender_id) {
                        $who_is_user = 'sender';
                    } elseif ($user_id == $this->order->receiver_id) {
                        $who_is_user = 'receiver';
                    } elseif ($user_id == $this->order->tp_id) {
                        $who_is_user = 'third_party';
                    }
                    $user = User::where('email' ,'=', $customer->email)->first();
                    $users->push(array([
                        'who_is_user' => $who_is_user,
                        'email' => $user->email
                    ]));
                }
            }
            $uniq_users = $users->unique();
//            dd($users->values()->all(), $uniq_users->values()->all());

            foreach ($uniq_users->values()->all() as $user) {
                Mail::to($user[0]['email'])->send(new Invoice($this->order, $user[0]['who_is_user']));
            }

        } elseif ($this->status == 'delivered'){
            $who_pays = $this->order->who_pays->toArray();
            $who_is_user = '';
            $users  = collect(array());
            foreach ($who_pays as  $user_id) {
                $customer = Customer::find($user_id);
                if (!$customer) {
                    continue;
                } else {
                    if ($user_id == $this->order->sender_id) {
                        $who_is_user = 'sender';
                    } elseif ($user_id == $this->order->receiver_id) {
                        $who_is_user = 'receiver';
                    } elseif ($user_id == $this->order->tp_id) {
                        $who_is_user = 'third_party';
                    }
                    $user = User::where('email' ,'=', $customer->email)->first();
                    $users->push(array([
                        'who_is_user' => $who_is_user,
                        'email' => $user->email
                    ]));
                }
            }
            $uniq_users = $users->unique();
//            dd($users->values()->all(), $uniq_users->values()->all());

            foreach ($uniq_users->values()->all() as $user) {
                Mail::to($user[0]['email'])->send(new UPD($this->order, $user[0]['who_is_user']));
            }
        }

        $this->closeModal();



    }

    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


}
