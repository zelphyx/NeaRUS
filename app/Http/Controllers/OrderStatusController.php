<?php

namespace App\Http\Controllers;
use App\Mail\PeringatanJatuhTempo;
use App\Models\Pencairan;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            'refnumber' => $uniqueTransactionRef,
            'disorder' => $order
        ]);
    }
    public function getPaidBuyerCountByMonth(Request $request)
    {
        $ownerId = auth()->user()->ownerId;

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $uniqueBuyerCount = Order::where('ownerId', $ownerId)
            ->where('status', 'Paid')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->distinct('phonenumber')
            ->count('phonenumber');

        return response()->json([
            'success' => true,
            'uniqueBuyerCount' => $uniqueBuyerCount,
            'month' => $startDate->format('F'), // Nama bulan (January, February)
            'year' => $year,
            'userregistered' => $ownerId,
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
                $orderIdParts = explode(' - ', $request->order_id);
                $orderIds = $orderIdParts[0];
                $order = Order::find($orderIds);

                if ($order->status === 'Paid') {
                    $duration = Carbon::parse($order->duration);
                    $roomName = explode(' - ', $order->detail)[0];
                    $room = Room::where('ownerId', $order->ownerId)
                        ->where('name', $roomName)
                        ->first();

                    $totalMonths = $this->calculateTotalMonths($room->time, $order->quantity);
                    $duration->addMonths($totalMonths);

                    $order->update(['duration' => $duration]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Order already paid and rental extended',
                        'refnumber' => $order->refnumber,
                        'payment_time' => $request->transaction_time,
                        'payment_method' => $request->payment_type,
                        'orderId' => $request->order_id,
                    ]);
                } else {
                    $order->update(['status' => 'Paid']);
                    $roomName = explode(' - ', $order->detail)[0];
                    $room = Room::where('ownerId', $order->ownerId)
                        ->where('name', $roomName)
                        ->first();
                    if ($room) {
                        $room->availability -= 1;
                        $room->save();
                    }
                    $times = strtolower($room->time);
                    $duration = Carbon::now();
                    if ($times == "1 bulan") {
                        $duration = Carbon::now()->addMonth();
                    } elseif ($times == "3 bulan") {
                        $duration = Carbon::now()->addMonths(3);
                    } elseif ($times == "6 bulan") {
                        $duration = Carbon::now()->addMonths(6);
                    } elseif ($times == "1 tahun") {
                        $duration = Carbon::now()->addYear();
                    } elseif ($times == "2 tahun") {
                        $duration = Carbon::now()->addYears(2);
                    } elseif ($times == "3 tahun") {
                        $duration = Carbon::now()->addYears(3);
                    }
                    $order->update(['duration' => $duration]);

                    return response()->json([
                        'success' => true,
                        'refnumber' => $order->refnumber,
                        'payment_time' => $request->transaction_time,
                        'payment_method' => $request->payment_type,
                        'orderId' => $request->order_id,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid signature or status',
        ]);
    }

    private function calculateTotalMonths($timePeriod, $quantity)
    {
        $totalMonths = 0;
        switch (strtolower($timePeriod)) {
            case "1 bulan":
                $totalMonths = 1 * $quantity;
                break;
            case "3 bulan":
                $totalMonths = 3 * $quantity;
                break;
            case "6 bulan":
                $totalMonths = 6 * $quantity;
                break;
            case "1 tahun":
                $totalMonths = 12 * $quantity;
                break;
            case "2 tahun":
                $totalMonths = 24 * $quantity;
                break;
            case "3 tahun":
                $totalMonths = 36 * $quantity;
                break;
        }
        return $totalMonths;
    }

    public function extendOrder(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $transactionOrderId = $order->id . ' - ' . time();
        $transactionDetails = [
            'order_id' => $transactionOrderId,
            'gross_amount' => $order->price * $request->quantity,
        ];
        $customerDetails = [
            'first_name' => $order->name,
            'phone' => $order->phonenumber,
        ];
        $itemDetails = [
            [
                'id' => $order->id,
                'price' => $order->price,
                'quantity' => $request->quantity,
                'name' => "Perpanjangan Sewa untuk " . $order->detail,
            ],
        ];
        $roomName = explode(' - ', $order->detail)[0];
        $room = Room::where('ownerId', $order->ownerId)
            ->where('name', $roomName)
            ->first();
        if ($room) {
            $room->save();
        }

        $totalMonths = $this->calculateTotalMonths($room->time, $request->quantity);

        $transactionPayload = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transactionPayload);

            return response()->json(['snapToken' => $snapToken, 'room' => $room, 'totalMonths' => $totalMonths]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkAndDeleteExpiredOrders()
    {
        $orders = Order::where('status', 'Paid')->get();

        foreach ($orders as $order) {
            if (Carbon::now()->greaterThan(Carbon::parse($order->duration))) {
                Log::info('Deleting expired order with ID: ' . $order->id);
                $roomName = explode(' - ', $order->detail)[0];
                $room = Room::where('ownerId', $order->ownerId)
                    ->where('name',$roomName)
                    ->first();
                if($room){
                    $room->availability += 1;
                    $room->save();
                }
                $order->delete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Expired orders have been deleted',
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
        $find = Order::find($orderId);
        return response()->json($find);
    }
    public function getownereachid($orderId){
        $find = User::find($orderId);
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

    public function requestpencairan(Request $request)
    {
        $ownerId = auth()->user()->ownerId;
        $name = auth()->user()->name;
        $phonenumber = auth()->user()->phonenumber;

        $reqamount = $request->input('amount');

        $currentBalance = Order::where('ownerId', $ownerId)
            ->where('status', 'Paid')
            ->sum('price');

        if ($currentBalance >= $reqamount) {
            Order::where('ownerId', $ownerId)
                ->where('status', 'Paid')
                ->limit(1)
                ->decrement('price', $reqamount);

            $input = $request->all();
            $input['ownerId'] = $ownerId;
            $input['name'] = $name;
            $input['phonenumber'] = $phonenumber;
            $queue = Pencairan::create($input);

            return response()->json([
                'success' => true,
                'message' => 'Request Pencairan Dana Telah Dikirim Ke Admin Kami',
                'requested' => $queue,
                'balance' => $currentBalance
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Saldo tidak mencukupi untuk melakukan penarikan',
            ], 400);
        }
    }

    public function alerttempo(){
        $orders = Order::where('status','Paid')
            ->where('duration', '<=', Carbon::now()->addDays(7))
            ->where('duration', '>=', Carbon::now())
            ->get();
        foreach ($orders as $order) {
            Mail::to($order->email)->send(new PeringatanJatuhTempo($order));
        }
        return response()->json([
            'success' => true,
            'message' => "peringatan jatuh tempo telah dikirim",

        ]);
    }
    public function getandapprove($id)
    {
        try {
            $pencairan = Pencairan::findOrFail($id);
            $withdrawalAmount = $pencairan->amount;
            $ownerId = $pencairan->ownerId;

            $currentBalance = Order::where('ownerId', $ownerId)
                ->where('status', 'Paid')
                ->sum('price');
            if ($currentBalance >= $withdrawalAmount) {
                Order::where('ownerId', $ownerId)
                    ->where('status', 'Paid')
                    ->limit(1)
                    ->decrement('price', $withdrawalAmount);
                $pencairan->delete();

                return redirect()->route('showpencairan')->with('success', 'Approved successfully.');
            } else {
                return redirect()->route('showpencairan')->with('error', 'Insufficient balance.');
            }

        } catch (\Exception $e) {
            return redirect()->route('showpencairan')->with('error', 'Failed to approve request.');
        }
    }



}
