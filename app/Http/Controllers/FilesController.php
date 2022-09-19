<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function show($order_id, $file) {

        $order = Order::find($order_id);
        $order_num = $order->order_num;

        return redirect(
            Storage::url($order_num.'/'.$file)
        );
    }
}
