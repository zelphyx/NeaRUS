<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Product::all();
        return  response()->json([
            "message" => "success get all product",
            "data" => ProductResource::collection($properties)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'image' => 'array|nullable',
            'productname' => 'required|unique:products,productname',
            'location' => 'required',
            'linklocation' => 'required',
            'category' => 'required',
            'fasilitas' => 'required|min:1',
            'fasilitas.*' => 'string',
            'roomid' => 'nullable|array',
            'about' => 'required',
        ]);

        if ($validatedData->fails()) {
            return $this->invalidRes($validatedData->getMessageBag());
        }

        $input = $request->all();
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
                $newImagePath = config('app.url') . '/storage/post-images/' . $new_name;
                $images[] = $newImagePath;
            }
            $input['image'] = implode(',', $images);
        }
        $product = Product::create($input);
        $roomIds = $request->input('roomid');
        $product->rooms()->attach($roomIds);
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

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('image', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kostid)
    {
        $product = Product::findOrFail($kostid);
        return response()->json($product);
    }
    public function findbyeachid($kostid)
    {
        $product = Product::findOrFail($kostid);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = Validator::make($request->all(), [
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
            'productname' => 'required' . $product->productname,
            'ownerId' => 'required',
            'location' => 'required',
            'linklocation' => 'required',
            'category' => 'required',
            'fasilitas' => 'required|min:1',
            'roomid' => 'required',
            'about' => 'required',
        ]);

        if ($validatedData->fails()) {
            return $this->invalidRes($validatedData->getMessageBag());
        }

        $input = $request->all();

        if (!is_array($input['fasilitas'])) {
            $input['fasilitas'] = [$input['fasilitas']];
        }

        $input['fasilitas'] = implode(' , ', $input['fasilitas']);

        if ($request->hasFile('images')) {
            if ($product->image) {
                $oldImages = explode(',', $product->image);
                foreach ($oldImages as $oldImage) {
                    Storage::delete($oldImage);
                }
            }

            $images = [];
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('public/post-images');
                $images[] = $imagePath;
            }
            $input['image'] = implode(',', $images);
        }

        $product->update($input);

        return $this->succesRes([
            'success' => true,
            'message' => 'Product updated successfully.'
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->invalidRes('Product not found.');
        }

        $product->delete();

        return $this->succesRes([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }


}
