<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Google\Service\Directory\Users;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class UserEdit extends ModalComponent
{
    public  $user;
    public string $telnum;
    public string $name;
    public string $email;
    public string $company_INN;
    public string $company_name;
    public string $what;
    public bool $with_nds;
    public bool $gen_files;
    public $debt_time;
    public Collection $contacts_email;
    public Collection $contacts_telnum;
    public Collection $managers;

    public int $manager_id;

    public string $confirmationTitle = 'Вы уверены, что хотите изменить карточку клиента?';

    public string $confirmationDescription = 'В случае изменения, старые данные будут потеряны безвозвратно.';

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function mount($what, $id)
    {
        $this->what = $what;
        if ($what == 'customer') {
            $this->user = Customer::find($id);
            $this->name = $this->user->name;
            $this->telnum = $this->user->telnum;
            $this->email = $this->user->email;
            $this->debt_time = $this->user->debt_time ?? "5";
            $this->manager_id = $this->user->manager_id ?? 0;
        } elseif ($what == 'company') {
            $this->user = Company::find($id);
            $this->contacts_telnum = Customer::where('company_id', '=', $id)->get()->unique('telnum');
            $this->contacts_email = Customer::where('company_id', '=', $id)->get()->unique('email');
            $this->company_INN = $this->user->INN  ?? "";
            $this->company_name = $this->user->name  ?? "";
            $this->telnum = $this->user->telnum ?? "null";
            $this->email = $this->user->email ?? "null";
            $this->debt_time = $this->user->debt_time ?? "5";
            $this->manager_id = $this->user->manager_id ?? 0;
            $this->with_nds = $this->user->with_nds ?? false;
            $this->gen_files = $this->user->gen_files ?? true;
        }





        $this->managers = User::where('role_id', '=', '2')->get();
    }

    public function render()
    {

        return view('livewire.user-edit');
    }

    public function cancel()
    {
        $this->closeModal();
    }

    public function confirm() {
        if ($this->what == 'customer') {
            $this->user->name = $this->name;
            $this->user->email = $this->email;
            $this->user->telnum = $this->telnum;
            $this->user->manager_id = $this->manager_id;
            $this->user->debt_time = $this->debt_time;
        }

        elseif($this->what == 'company') {
            $this->user->name = $this->company_name;
            $this->user->INN = $this->company_INN;
            $this->user->manager_id = $this->manager_id;
            $this->user->telnum = $this->telnum;
            $this->user->email = $this->email;
            $this->user->debt_time = $this->debt_time;
            $this->user->with_nds = $this->with_nds ?? false;
            $this->user->gen_files = $this->gen_files ?? true;
        }
        $this->user->save();


        return redirect(request()->header('Referer'));


    }


}
