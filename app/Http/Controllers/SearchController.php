<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Room;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $kategori = $request->input('kategori');
        $namakost = $request->input('namakost');
        $waktu_sewa = $request->input('waktu_sewa');

        $query = Room::query();

        if ($kategori) {
            $query->where('category', 'like', '%' . $kategori . '%');
        }

        if ($namakost) {
            $query->where('name', 'like', '%' . $namakost . '%');
        }

        if ($waktu_sewa) {
            $query->where('time', 'like', '%' . $waktu_sewa . '%');
        }

        $results = $query->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
    public function showrefnumber()
    {
        $refnumbers = Order::all();
        return view('refnumber', compact('refnumbers'));
    }

    public function searchrefnumber(Request $request)
    {
        $refnumber = $request->input('refnumber');

        $orders = Order::where('refnumber', 'like', '%' . $refnumber . '%')->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}

