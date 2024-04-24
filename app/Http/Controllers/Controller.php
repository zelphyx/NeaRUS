<?php

namespace App\Http\Controllers;

abstract class Controller
{

    public function succesRes($data)
    {
        return response()->json($data,200);
    }


    public function invalidRes($data)
    {
        return response()->json([
            "message" => "invalid Field",
            "errors" => $data
        ],422);
    }


    public function UnathorizeRes($data)
    {
        return response()->json([
            "message" => $data,
        ],401);
    }

}
