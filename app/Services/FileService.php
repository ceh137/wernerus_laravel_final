<?php

namespace App\Services;

use App\Models\Company;
use App\Models\File;
use App\Models\Order;
use CURLFile;
use phpseclib3\Exception\FileNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public Order  $order;
    public FileFiller $filler;
    public File $file;

    public function __construct($id)
    {
        $this->order = Order::find($id);
        $this->file = File::find($this->order->files->id);
        $this->filler = new FileFiller($this->order->id);
        $this->pref = $this->order->order_num;

        $this->getCompanyAddresses();
  }

    public function nakladnaya()  {
        $nakladnaya = $this->filler->nakladnaya();
        $filename = $this->pref.'/nakladnaya_'.$this->order->order_num.'_'.Carbon::now()->timestamp.'.pdf';
        Storage::disk('public')->put($filename, $nakladnaya->output());
        $this->file->nakladnaya = $filename;
        return $this->file->save();

    }

    public function UPD()  {
        $upds = $this->filler->UPD();
        $filename = [];
        if (isset($upds['sender']) && !is_null($this->order->sender_id)) {
            $filename['sender'] = $this->pref.'/UPD_'.$this->order->order_num.'_'.Str::slug($this->order->sender->name).'_'.Carbon::now()->timestamp.'.pdf';
            Storage::disk('public')->put($filename['sender'], $upds['sender']->output());
        }
        if (isset($upds['receiver']) && !is_null($this->order->receiver_id)) {
            $filename['receiver'] = $this->pref . '/UPD_' . $this->order->order_num . '_' . Str::slug($this->order->receiver->name) . '_' . Carbon::now()->timestamp . '.pdf';
            Storage::disk('public')->put($filename['receiver'], $upds['receiver']->output());
        }
        if (isset($upds['third_party']) && !is_null($this->order->tp_id)) {
            $filename['third_party'] = $this->pref . '/UPD_' . $this->order->order_num . '_' . Str::slug($this->order->tp->name) . '_' . Carbon::now()->timestamp . '.pdf';
            Storage::disk('public')->put($filename['third_party'], $upds['third_party']->output());

        }
        $filenamejson = json_encode($filename);
        $this->file->UPD = $filenamejson;
        return $this->file->save();

    }

    public function PE() {
        $pe = $this->filler->PE();
        $filename = $this->pref.'/PE_'.$this->order->order_num.'_'.Carbon::now()->timestamp.'.pdf';
        Storage::disk('public')->put($filename, $pe->output());
        $this->file->PE = $filename;
        return $this->file->save();
    }

    public function invoice()  {
        $upds = $this->filler->invoice();
        $filename = [];
        if (isset($upds['sender']) && !is_null($this->order->sender_id)) {
            $filename['sender'] = $this->pref.'/invoice_'.$this->order->order_num.'_'.Str::slug($this->order->sender->name).'_'.Carbon::now()->timestamp.'.pdf';
            Storage::disk('public')->put($filename['sender'], $upds['sender']->output());
        }
        if (isset($upds['receiver']) && !is_null($this->order->receiver_id)) {
            $filename['receiver'] = $this->pref . '/invoice_' . $this->order->order_num . '_' . Str::slug($this->order->receiver->name) . '_' . Carbon::now()->timestamp . '.pdf';
            Storage::disk('public')->put($filename['receiver'], $upds['receiver']->output());
        }
        if (isset($upds['third_party']) && !is_null($this->order->tp_id)) {
            $filename['third_party'] = $this->pref . '/invoice_' . $this->order->order_num . '_' . Str::slug($this->order->tp->name) . '_' . Carbon::now()->timestamp . '.pdf';
            Storage::disk('public')->put($filename['third_party'], $upds['third_party']->output());

        }
        $filenamejson = json_encode($filename);
        $this->file->check = $filenamejson;
        return $this->file->save();

    }

    public function generateAll() {

        return $this->nakladnaya() && $this->PE() && $this->invoice() && $this->UPD();
    }

    public function getCompanyAddresses() {

        if (!is_null($this->order->sender_company_id)) {
            if (is_null($this->order->sender_comp->address)) {
                $sender_comp = Company::find($this->order->sender_company_id);
                $sender_comp->address = $this->getSenderCompanyAddress();
                $sender_comp->save();
            }
        }
        if (!is_null($this->order->receiver_company_id)) {
            if (is_null($this->order->receiver_comp->address)) {
                $receiver_comp = Company::find($this->order->receiver_company_id);
                $receiver_comp->address = $this->getReceiverCompanyAddress();
                $receiver_comp->save();
            }
        }

        if (!is_null($this->order->tp_company_id)) {
            if (is_null($this->order->tp_comp->address)) {
                $tp_comp = Company::find($this->order->tp_company_id);
                $tp_comp->address = $this->getTpCompanyAddress();
                $tp_comp->save();
            }
        }

    }

    public function getSenderCompanyAddress() {
        $sender_comp = $this->order->sender_company_id;

        if (!is_null($sender_comp))  {
            $dadata = new DadataService($sender_comp);
            $sender_comp_address = $dadata->address();
        } else {
            return "";
        }

        return $sender_comp_address;
    }

    public function getReceiverCompanyAddress() {
        $receiver_comp = $this->order->receiver_company_id;

        if (!is_null($receiver_comp))  {
            $dadata = new DadataService($receiver_comp);
            $receiver_comp_address = $dadata->address();
        }else {
            return "";
        }

        return  $receiver_comp_address;
    }

    public function getTpCompanyAddress() {
        $tp_comp = $this->order->tp_company_id;

        if (!is_null($tp_comp))  {
            $dadata = new DadataService($tp_comp);
            $tp_comp_address = $dadata->address();
        }else {
            return "";
        }
        return $tp_comp_address;
    }
}
