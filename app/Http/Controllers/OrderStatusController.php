<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function beforecheckout(Request $request){
        $request->request->add(['status' => 'Unpaid']);
        $order = Order::create($request->all());
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $order->price,
            ),
            'customer_details' => array(
                'name' => $request->name,
                'owner_id' => $request->ownerId,
                'detail' => $request->detail,
                'phone' => $request->phonenumber,
                'duration' => $request->duration,
            ),

        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return response()->json([
            'success' => true,
            'message' => 'Barang Berhasil Dicheckout',
            'snapToken' => $snapToken,
        ]);
    }

    public function callback(Request $request){
        $serverkey = config('midtrans.server_key');
        $hashed = hash('sha512',$request->order_id.$request->status_code.$request->gross_amount.$serverkey);
        if($hashed == $request->signature_key){
            if ($request->transaction_status == 'capture'){
                $order = Order::find($request->order_id);
                $order->update(['status' => 'Paid']);
            }
        }
    }
}
