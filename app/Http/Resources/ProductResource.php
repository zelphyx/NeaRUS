<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id" => $this->kostid,
            "image" => explode(",", $this->image),
            "productname" => $this->productname,
            "ownerId" => $this->ownerId,
            "location" => $this->location,
            "category" => $this->category,
            "linklocation" => $this->linklocation,
            "price" => $this->price,
            "fasilitas" => explode(",", $this->fasilitas),
            "roomid" => $this->roomid,
            "about" => $this->about,
            "duration" => $this->duration

        ];
    }

//    public function formatImage($images): array
//    {
//        $data = [];
//
//        foreach ($images as $key => $image) {
//            $data[$key] = $image;
//        }
//
//        return $data;
//    }
}
