<?php

namespace App\Http\Controllers;

use App\Models\Category_product;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(Request $request) {
        $category = Category_product::all();

        $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            $products = Product::where('category_id', $selectedCategory)->get();
        } else {
            $products = Product::all();
        }

        return view('produk', compact('products', 'category', 'selectedCategory'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required'],
            'brand' => ['required'],
            'category_id' => ['required'],
            'qty_instock' => ['required', 'int'],
            'price' => ['required', 'int'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = 'foto_' . time() . '.webp';

            $image_manager = new ImageManager(new Driver());
            $image_content = $image_manager->read($image);
            $resized = $image_content->encode(new WebpEncoder(quality: 60));
            Storage::disk('public')->put('photo/' . $filename, $resized);

            $data['photo'] = 'photo/' . $filename;
        }

        if (Product::create($data)) {
            return back();
        }
        
        return back()->withErrors([

        ]);
    }

    public function update(Request $request) {
        $data = $request->validate([
            'name' => ['required'],
            'brand' => ['required'],
            'category_id' => ['required'],
            'qty_instock' => ['required', 'int'],
            'price' => ['required', 'int'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $product = Product::findOrFail($request->id);

        if ($request->hasFile('photo')) {

            if ($product->photo && Storage::disk('public')->exists($product->photo)) {
                Storage::disk('public')->delete($product->photo);
            }

            $image = $request->file('photo');
            $filename = 'foto_' . time() . '.webp';

            $image_manager = new ImageManager(new Driver());
            $image_content = $image_manager->read($image);
            $resized = $image_content->encode(new WebpEncoder(quality: 60));
            Storage::disk('public')->put('photo/' . $filename, $resized);

            $data['photo'] = 'photo/' . $filename;
        }

        $product->update($data);

        return back();
    }

    public function delete(Request $request) {
        $product = Product::findOrFail($request->id);

        if ($product->photo && Storage::disk('public')->exists($product->photo)) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return back();
    }
}
