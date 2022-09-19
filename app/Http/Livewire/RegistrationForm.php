<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use function PHPUnit\Framework\assertGreaterThanOrEqual;

class RegistrationForm extends ModalComponent
{
    public string $email = '';
    public string $password  =  "";
    public string $password_confirmation  =  "";
    public string $name = '';
    public ?int $role_id = null;
    public Collection $roles;
    public string $error = '';

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email|unique:App\Models\User,email',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required|min:8',
    ];

    public static function modalMaxWidth(): string{
        return "2xl";
    }

    public function mount() {
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.registration-form');
    }

    public function submit() {
        $this->validate();

        $user = new User([
            'name' => $this->name,
            'email'  => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->role_id,
         ]);
        $user->save();

        $this->closeModal();
    }

    public function check() {

    }
}
