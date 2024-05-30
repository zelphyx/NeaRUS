<?php

namespace App\Listeners;

use App\Events\RoomCreated;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateProductRoomId
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RoomCreated $event)
    {
        $room = $event->room;
        $ownerId = $room->ownerId;

        $products = Product::where('ownerId', $ownerId)->get();
        foreach ($products as $product) {
            $roomIds = $product->roomid ? explode(',', $product->roomid) : [];
            $roomIds[] = $room->id;
            $product->roomid = implode(',', $roomIds);
            $product->save();
        }
    }
}
