<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class UserInfoCard extends ModalComponent
{
    public Company|Customer $user ;
    public string  $what;
    public string   $confirmationTitle = "Карточка Клиента";
    public string  $confirmationDescription = "";
    public Collection|array $contacts;
    public static function modalMaxWidth(): string{
        return "7xl";
    }

    public function mount($who_is, $id) {
        if ($who_is == 'company') {
            $this->user  = Company::find($id);
            $this->contacts = Customer::where('company_id', '=', $id)->get()->unique('name');
        } elseif ($who_is == 'customer') {
            $this->user  = Customer::find($id);
            $this->contacts = array();
        }

        $this->what = $who_is;

    }

    public function render()
    {
        return view('livewire.user-info-card');
    }

    public function cancel(){

        $this->closeModal();

    }
}
