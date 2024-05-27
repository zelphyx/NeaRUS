<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Room::all();
        return  response()->json([
            "message" => "success get all product",
            "data" => RoomResource::collection($properties)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $kostid = $user->ownerId;

        if (!$kostid) {
            return response()->json([
                'success' => false,
                'message' => 'kostid is required for this user'
            ], 400);
        }

        $request->merge(['ownerId' => $kostid]);

        $validatedData = $request->validate([
            'ownerId' => 'required',
            'name' => 'required',
            'category' => 'required',
            'fasilitas' => 'required|array|min:1',
            'image' => 'array|nullable',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required',
            'time' => 'required',
            'availability' => 'required',
        ]);

        $validatedData['fasilitas'] = implode(',', $validatedData['fasilitas']);

        if (!empty($validatedData['image'])) {
            $images = [];
            foreach ($validatedData['image'] as $image) {
                $new_name = rand() . '.' . $image->extension();
                $image->move(public_path('storage/room-images'), $new_name);
                $newImagePath = config('app.url') . '/storage/room-images/' . $new_name;
                $images[] = $newImagePath;
            }
            $validatedData['image'] = implode(',', $images);
        } else {
            $validatedData['image'] = null;
        }

        Room::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Rooms Registered'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
