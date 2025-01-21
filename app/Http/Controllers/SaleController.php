<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        // mostrar todos los anuncios (excepto los vendidos)
        $sales = Sale::where('isSold', false)->with('category', 'user')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        // obtener categorías y configuraciones de imagnes
        $categories = Category::all();
        $maxFiles = Setting::first()->maxFiles;
        return view('sales.create', compact('categories', 'maxFiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'images' => 'required|array|max:'.Setting::first()->maxFiles,
            'images.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sale = Sale::create([
            'user_id' => Auth::id(),
            'product' => $request->product,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $this->uploadThumbnail($request->file('images')[0]),
        ]);

        // subir las imagenes
        foreach ($request->file('images') as $image) {
            $route = $this->uploadImage($image);
            Image::create([
                'sale_id' => $sale->id,
                'route' => $route,
            ]);
        }

        return redirect()->route('sales.index');
    }

    private function uploadThumbnail($image)
    {
        return $image->store('thumbnails', 'public');
    }

    private function uploadImage($image)
    {
        return $image->store('sales', 'public');
    }
}
