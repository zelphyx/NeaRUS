<?php

namespace App\Http\Controllers\API;

use App\Events\RoomCreated;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'kostid' => 'required',
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
        $validatedData['price'] = intval($validatedData['price']);
        $validatedData['totalkamar'] = $validatedData['availability'];
        Room::create($validatedData);


        return response()->json([
            'success' => true,
            'message' => 'Rooms Registered'
        ]);
    }
    public function availability($ownerId)
    {
        $rooms = Room::where('ownerId', $ownerId)->get();

        $roomsAvailability = $rooms->map(function ($room) {
            return [
                'roomName' => $room->name,
                'availability' => $room->availability,
                'status' => $room->availability > 0 ? 'Tersedia' : 'Habis'
            ];
        });

        return response()->json([
            'success' => true,
            'availability' => $roomsAvailability
        ]);
    }

    public function showbyid($ownerId)
    {
        $rooms = Room::where('ownerId', $ownerId)->get();

        if (!$rooms->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Rooms found',
                'data' => RoomResource::collection($rooms)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No rooms found for the specified ownerId'
            ], 404);
        }
    }
    public function showbykostid($kostid)
    {
        $rooms = Room::where('kostid', $kostid)->get();

        if (!$rooms->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Rooms found',
                'data' => RoomResource::collection($rooms)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No rooms found for the specified ownerId'
            ], 404);
        }
    }

    public function showbyownerid()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User is not authenticated'
            ], 401);
        }

        $ownerId = $user->ownerId;
        $rooms = Room::where('ownerId', $ownerId)->get();

        if (!$rooms->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Rooms found',
                'data' => RoomResource::collection($rooms)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No rooms found for the specified ownerId'
            ], 404);
        }
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
    public function edit($id)
    {
        $product = Room::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'ownerId' => '',
            'name' => '',
            'category' => '',
            'fasilitas' => 'array|min:1',
            'image' => 'array|nullable',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => '',
            'time' => '',
            'availability' => '',
        ]);

        if ($validatedData->fails()) {
            return $this->invalidRes($validatedData->getMessageBag());
        }

        $room = Room::findorFail($id);
        $input = $request->all();
        $input['price'] = intval($input['price']);
        $input['ownerId'] = Auth::id();

        if (!is_array($input['fasilitas'])) {
            $input['fasilitas'] = [$input['fasilitas']];
        }
        $input['fasilitas'] = implode(',', $input['fasilitas']);
        if ($request->image != null) {
            $images = [];
            foreach ($request->image as $image) {
                $new_name = rand() . '.' . $image->extension();
                $image->move(public_path('storage/post-images'), $new_name);
                $newImagePath = '/storage/post-images/' . $new_name;
                $images[] = $newImagePath;
            }
            $input['image'] = implode(',', $images);
        }

        $room->update($input);

        return $this->succesRes([
            'success' => true,
            'message' => 'Room Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Room::find($id);

        if (!$product) {
            return $this->invalidRes('Room not found.');
        }

        $product->delete();

        return $this->succesRes([
            'success' => true,
            'message' => 'Room deleted successfully.'
        ]);
    }
}
