<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Product::all();
        return response()->json($properties);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'images.*' => 'image|file',
            'productname' => 'required|unique:products,productname',
            'ownerId' => 'required',
            'location' => 'required',
            'category' => 'required',
            'fasilitas' => 'required|min:1', // Ensure fasilitas is an array
            'fasilitas.*' => 'string', // Validate each fasilitas item as a string
            'roomid' => 'required',
            'about' => 'required',
        ]);

        if ($validatedData->fails()) {
            return $this->invalidRes($validatedData->getMessageBag());
        }

        $input = $request->all();

        // If fasilitas is not an array, convert it to an array with a single value
        if (!is_array($input['fasilitas'])) {
            $input['fasilitas'] = [$input['fasilitas']];
        }

        // Imploding the array into a comma-separated string
        $input['fasilitas'] = implode(',', $input['fasilitas']);

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $new_name = rand() . '.' . $image->getClientOriginalName();
                $image->move(public_path('storage/post-images'), $new_name);
                $newImagePath = '/storage/post-images/' . $new_name;
                $images[] = $newImagePath;
            }
            $input['image'] = implode(',', $images);
        }
        Product::create($input);
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
        $product = Product::findOrFail($id); // Retrieve product data by ID
        return view('image', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
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
            'category' => 'required',
            'fasilitas' => 'required|min:1',
            'roomid' => 'required',
            'about' => 'required',
        ]);

        if ($validatedData->fails()) {
            return $this->invalidRes($validatedData->getMessageBag());
        }

        $input = $request->all();

        // Check if fasilitas is a string, convert it to an array
        if (!is_array($input['fasilitas'])) {
            $input['fasilitas'] = [$input['fasilitas']];
        }

        $input['fasilitas'] = implode(',', $input['fasilitas']);

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
