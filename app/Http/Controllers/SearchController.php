<?php

namespace App\Http\Controllers;

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
}

