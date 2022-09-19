<?php

namespace App\Http\Livewire;

use App\Models\Debt;
use App\Models\DebtStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use function Symfony\Component\Translation\t;

class ChangeDebt extends ModalComponent
{

    public Order $order;
    public string $confirmationTitle = '';
    public string $trackNum ='';
    public string $amount;
    public Collection $debt_statuses;
    public int $debt_status_id;
    public array $paid;
    public string $transfer_nums;
    public string $transfer_date;

    public static function modalMaxWidth(): string{
        return "7xl";
    }

    public function mount($id) {
        $debt = Debt::find($id);
        $order_id = $debt->order_id;
        $this->order = Order::find($order_id);
        $this->amount = $debt->amount;
        $this->debt_status_id = $debt->debt_status_id;
        $this->paid = json_decode($debt->paid, true) ? : array();
        $this->transfer_nums = $debt->transfer_nums  ? : '';
        $this->transfer_date = Carbon::parse($debt->transfer_date)->format('Y-m-d') ? : '';
        $this->debt_statuses = DebtStatus::all();
    }

    public function render()
    {
        return view('livewire.change-debt');
    }

    public function confirm() {
        $debt = Debt::where('order_id', '=', $this->order->id)->first();

        $debt->amount = intval($this->amount);
        if ($this->debt_status_id == 11) {
            $debt->amount = 0.00;
        }
        $debt->debt_status_id = $this->debt_status_id;
        $debt->is_in_debt = $this->debt_status_id != 11;
        if ($this->debt_status_id == 11) {
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
                        $debt_paid[$payer][$field] = true;
                    } else {
                        $debt_paid[$payer][$field] = true;
                    }
                }
            }
            $this->paid = $debt_paid;
        }
        $debt->paid = json_encode($this->paid);
        $debt->transfer_nums = $this->transfer_nums ? :  "--";
        $debt->transfer_date = Carbon::parse($this->transfer_date);
        try {
            $debt->save();
        } catch (\Exception $e ){
            dd($e->getMessage());
        }


        $this->closeModalWithEvents([
            'pg:eventRefresh-debt_table',
        ]);


    }
}
