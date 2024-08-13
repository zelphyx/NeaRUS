<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                $roomName = explode(' - ', $order->detail)[0];
                $room = Room::where('ownerId', $order->ownerId)
                    ->where('name', $roomName)
                    ->first();

                if ($room) {
                    $room->availability -= 1;
                    $room->save();
                }

                return response()->json([
                    'success' => true,
                    'refnumber' => $order->refnumber,
                    'payment_time' => $request->transaction_time,
                    'payment_method' => $request->payment_type,
                    'orderId' => $request->order_id,
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

    public function geteachid($orderId){
        $find = Order::find($orderId)
        ->where('status','Paid');
        return response()->json($find);
    }
    public function getbalance(Request $request)
    {
        $ownerId = auth()->user()->ownerId;

        $balance = Order::where('ownerId', $ownerId)
            ->where('status', 'Paid')
            ->sum('price');

        return response()->json([
            'success' => true,
            'Balance Count' => $balance,
            'userregistered' => $ownerId,
        ]);
    }

    public function passingowner(Request $request){
        $ownerId = auth()->user()->ownerId;
        $passdata = Order::where('ownerId', $ownerId)
            ->where('status', 'Paid')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $passdata
        ]);
    }
    public function passingbuyer(Request $request){
        $userName = auth()->user()->name;

        $passdata = Order::where('status', 'Paid')
            ->where('name', $userName)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $passdata,
            'usn' => $userName
        ]);
    }

    public function getRemainingTime($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $roomName = explode(' - ', $order->detail)[0];
        $room = Room::where('name', $roomName)
            ->where('ownerId', $order->ownerId)
            ->first();

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found',
                'Room Name' => $room
            ], 404);
        }

        $duration = Carbon::now();
        IF($room->time == "1 bulan"){
            $duration = Carbon::now()->addMonth();
        }elseif ($room->time == "3 bulan"){
            $duration = Carbon::now()->addMonths(3);
        }elseif ($room->time == "6 bulan"){
            $duration = Carbon::now()->addMonths(6);
        }elseif ($room->time == "1 tahun"){
            $duration = Carbon::now()->addYear();
        }elseif ($room->time == "2 tahun"){
            $duration = Carbon::now()->addYears(2);
        }elseif ($room->time == "3 tahun"){
            $duration = Carbon::now()->addYears(3);
        }
        $now = Carbon::now();
        Log::info('Parsed duration: ' . $duration->toDateTimeString());
        Log::info('Current time: ' . $now->toDateTimeString());

        if ($now->greaterThan($duration)) {
            Log::warning('The time duration has already passed for order: ' . $orderId);
            Order::destroy($orderId);
            return response()->json([
                'success' => false,
                'message' => 'The time duration has already passed,order deleted'
            ]);
        }

        $remainingDurationFormatted = $duration->toDateString();
        $currentTimeFormatted = $now->toDateString();

        Log::info('Remaining time formatted: ' . $remainingDurationFormatted);
        return response()->json([
            'success' => true,
            'start' => $currentTimeFormatted,
            'end' => $remainingDurationFormatted
        ]);
    }
}
