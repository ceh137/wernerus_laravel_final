<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\FileFiller;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PrintController extends Controller
{



    public function reload($id) {
        $files = new FileService($id);
        $files->generateAll();

        return redirect()->back();

    }

    public function show($order_id, $file) {
            $order_num = Order::find($order_id)->order_num;

            return redirect(
                Storage::url($order_num.'/'.$file)
            );
    }
//
//
////        $order  = Order::find(10);
////        $pdf = Pdf::loadView('files.nakladnaya', ['order' => Order::find(10)]);
////        $filename = 'nakladnaya_'.$order->order_num.'_'.Str::slug($order->receiver->name).'_'.Carbon::now()->timestamp.'.pdf';
////        $pdf->setPaper('A4', 'portrait');
////        Storage::disk('local')->put($filename, $pdf->output());
////        return $pdf->stream('invoice.pdf');
//
//    }
//    public function test() {
//        $filler = new FileFiller(441);
//        $order = Order::find(441);
//        $pdfs = $filler->nakladnaya();
//        $filename = 'nakladnaya_'.$order->order_num.'_'.Str::slug($order->receiver->name).'_'.Carbon::now()->timestamp.'.pdf';
//
//        Storage::disk('public')->put($filename, $pdfs->output());
//        return redirect(Storage::url($filename));
//    }

}
