<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function beforecheckout(Request $request)
    {
        $uniqueTransactionRef = $this->generateUniqueTransactionRef();
        $request->request->add(['status' => 'Unpaid','refnumber' => $uniqueTransactionRef]);

        $order = Order::create($request->all());
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $uniqueTransactionRef = $this->generateUniqueTransactionRef();

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $order->price,
                'refnumber' => $uniqueTransactionRef,
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
            'refnumber' => $uniqueTransactionRef
        ]);
    }

    private function generateUniqueTransactionRef()
    {
        do {
            $transactionRef = random_int(1000000000, 9999999999);
        } while (Order::where('refnumber', $transactionRef)->exists());

        return $transactionRef;
    }

    public function callback(Request $request)
    {
        $serverkey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverkey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement' || $request->transaction_status == 'complete') {
                $order = Order::find($request->order_id);
                $order->update(['status' => 'Paid']);

                return response()->json([
                    'success' => true,
                    'refnumber' => $order->refnumber,
                    'payment_time' => $request->transaction_time,
                    'payment_method' => $request->payment_type,
                ]);
            }
        }
        return response()->json([
            'success' => true
        ]);
    }

    public function getpaidbuyer(Request $request){
        $ownerId = auth()->user()->ownerId;

        $orders = Order::where('ownerId', $ownerId)
            ->where('status', 'Paid')
            ->get();

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }
    public function getPaidBuyerCount(Request $request)
    {
        $ownerId = auth()->user()->ownerId;

        $uniqueBuyerCount = Order::where('ownerId', $ownerId)
            ->where('status', 'Paid')
            ->distinct('phonenumber')
            ->count('phonenumber');

        return response()->json([
            'success' => true,
            'uniqueBuyerCount' => $uniqueBuyerCount,
            'userregistered' => $ownerId,
        ]);
    }

    public function passingowner(Request $request){
        $ownerId = auth()->user()->ownerId;
        $passdata = Order::where('ownerId',$ownerId)
                    ->where('websiterole','Owner')
                    ->where('status','Paid');

        return response()->json([
            'success' => true,
            'data' => $passdata
            ]);
    }
    public function passingbuyer(Request $request){
        $ownerId = auth()->user()->ownerId;
        $passdata = Order::where('ownerId',$ownerId)
            ->where('websiterole','User')
            ->where('status','Paid');

        return response()->json([
            'success' => true,
            'data' => $passdata
        ]);
    }
}
