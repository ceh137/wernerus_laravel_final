<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $companies = Company::query()
            ->leftJoin('users as managers', 'companies.manager_id', '=', 'managers.id')
            ->select(
                'companies.id as id',
                'companies.name as name',
                'companies.INN as INN',
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
                'telnum' => null,
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



        return view('admin.users', ['customers' => $collection]);
    }
}
