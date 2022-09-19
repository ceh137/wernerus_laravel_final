<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class UsersTableCustom extends Component
{
    public Collection $customers;
    public \Illuminate\Database\Eloquent\Collection $managers;
    public string $name_filter = "";
    public string $INN_filter = "";
    public string $tel_filter = "";
    public int|string $manager_filter = 'null';
    public Collection $unchanged_customers;

    protected $listeners = ['refreshComponent' => '$refresh'];


    public function mount() {
        $companies = Company::query()
            ->leftJoin('users as managers', 'companies.manager_id', '=', 'managers.id')
            ->select(
                'companies.id as id',
                'companies.name as name',
                'companies.INN as INN',
                'companies.telnum as telnum',
                'companies.created_at as created_at',
                'companies.with_nds as with_nds',
                'managers.id as managers_id',
                'managers.name as managers_name'
            )->get()->toArray();

        $customers = Customer::query()
            ->whereNull('customers.company_id')
            ->leftJoin('users as managers', 'customers.manager_id', '=', 'managers.id')
            ->select(
                'customers.id as id',
                'customers.name as name',
                'customers.telnum as telnum',
                'customers.created_at as created_at',
                'managers.id as managers_id',
                'managers.name as managers_name'
            )->get()->toArray();
        $collection = collect([]);

        foreach($companies as $item) {
            $collection->push((object)[
                'id' => $item['id'],
                'name' => $item['name'],
                'INN' => $item['INN'],
                'telnum' => $item['telnum'],
                'with_nds' => $item['with_nds'],
                'created_at' => $item['created_at'],
                'manager_id' => $item['managers_id'],
                'manager_name' => $item['managers_name'],
                'what' => 'company'
            ]);
        }
        foreach($customers as $item) {
            $collection->push((object)[
                'id' => $item['id'],
                'name' => $item['name'],
                'INN' => null,
                'telnum' => $item['telnum'],
                'with_nds' => false,
                'created_at' => $item['created_at'],
                'manager_id' => $item['managers_id'],
                'manager_name' => $item['managers_name'],
                'what' => 'customer'

            ]);
        }

        $this->customers = $collection;
        $this->unchanged_customers = $collection;
        $this->managers = User::where('role_id', '=', '2')->get();
    }

    public function render()
    {
        return view('livewire.users-table-custom');
    }

    public function applyFilter() {
        $filtered_customers = collect(array());
        $customers = $this->unchanged_customers;
        if ($this->name_filter !== "" || $this->INN_filter !== "" || $this->tel_filter !== "" || $this->manager_filter !== "null") {
            $name = $this->name_filter;
            $INN = $this->INN_filter;
            $telnum = $this->tel_filter;
            $man_id = $this->manager_filter;
            $filtered_customers  = $customers->filter(function ($item) use ($name,  $INN, $telnum, $man_id) {
                // replace stristr with your choice of matching function
                return (false !== stristr($item['name'], $name)) && (false !== stristr($item['INN'], $INN)) && (false !== stristr($item['telnum'], $telnum)) && ($man_id == 'null' || $man_id == $item['manager_id']);
            })->values();
        } else {
            $filtered_customers = $this->unchanged_customers;
        }


        $this->customers = $filtered_customers;

        $this->emit('refreshComponent');
    }


    public function applyNameFilter() {
        $filtered_customers = collect(array());
        $customers = $this->unchanged_customers;
        if ($this->name_filter !== "") {
            $name = $this->name_filter;

            $filtered_customers  = $customers->filter(function ($item) use ($name) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['name'], $name);
            })->values();
        } else {
            $filtered_customers = $this->unchanged_customers;
        }
        $this->customers = $filtered_customers;

        $this->emit('refreshComponent');
    }

    public function applyINNFilter() {
        $filtered_customers = collect(array());
        $customers = $this->unchanged_customers;
        if ($this->INN_filter !== "") {
            $INN = $this->INN_filter;

            $filtered_customers  = $customers->filter(function ($item) use ($INN) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['INN'], $INN);
            })->values();
        } else {
            $filtered_customers = $this->unchanged_customers;
        }
        $this->customers = $filtered_customers;

        $this->emit('refreshComponent');
    }

    public function applyTelFilter() {
        $filtered_customers = collect(array());
        $customers = $this->unchanged_customers;
        if ($this->tel_filter !== "") {
            $tel = $this->tel_filter;

            $filtered_customers  = $customers->filter(function ($item) use ($tel) {
                // replace stristr with your choice of matching function
                return false !== stristr($item['telnum'], $tel);
            })->values();
        } else {
            $filtered_customers = $this->unchanged_customers;
        }
        $this->customers = $filtered_customers;

        $this->emit('refreshComponent');
    }
}
