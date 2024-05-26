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
        $validatedData = Validator::make($request->all(), [
            'kostid' => "required",
            'name' => "required",
            'category' => "required",
            'fasilitas' => "required|min:1",
            'image' => "array|nullable",
            'price' => "required",
            'time' => "required",
            'availability' => "required",
        ]);
        if ($validatedData->fails()) {
            return $this->invalidRes($validatedData->getMessageBag());
        }

        $input = $request->all();

        if (!is_array($input['fasilitas'])) {
            $input['fasilitas'] = [$input['fasilitas']];
        }
        $input['fasilitas'] = implode(',', $input['fasilitas']);
        if ($request->image != null) {
            $images = [];
            foreach ($request->image as $image) {
                $new_name = rand() . '.' .$image->extension();
                $image->move(public_path('storage/room-images'), $new_name);
                $newImagePath =config('app.url') . '/storage/room-images/' . $new_name;
//                $imageName = time() . '.' . $image->extension();
//                $image->storeAs('public/image_profile', $imageName);
//                $newImagePath = env('APP_URL') . '/storage/app/public/image_profile/' . $imageName;
                $images[] = $newImagePath;
            }
            $input['image'] = implode(',', $images);
        }
        Room::create($input);
        return $this->succesRes([
            'success' => true,
            'message' => 'Product Registered'
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
