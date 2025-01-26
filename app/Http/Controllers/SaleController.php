<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $query = Sale::with(['category', 'images']);
        
        if (!Auth::check()) {
            $query->where('isSold', false);
        } else {
            $query->where(function($q) {
                $q->where('isSold', false)
                  ->orWhere('user_id', Auth::id())
                  ->orWhereHas('purchases', function($q) {
                      $q->where('user_id', Auth::id());
                  });
            });
        }
        
        $sales = $query->latest()->get();
        return view('sales.index', compact('sales'));
    }

    public function purchase($id)
    {
        $sale = Sale::findOrFail($id);
        
        if ($sale->isSold) {
            return back()->with('error', 'Este producto ya ha sido vendido.');
        }

        if ($sale->user_id === Auth::id()) {
            return back()->with('error', 'No puedes comprar tu propio producto.');
        }

        $sale->update(['isSold' => true]);
        
        Purchase::create([
            'sale_id' => $sale->id,
            'user_id' => Auth::id(),
            'purchase_date' => now()
        ]);

        return redirect()->route('sales.show', $sale->id)
                        ->with('success', '¡Producto comprado exitosamente!');
    }

    public function create()
    {
        $categories = Category::all();
        return view('sales.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $maxImages = Setting::where('name', 'maxImages')->value('maxImages') ?? 5;
        $request->validate([
            'product' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|gt:0',
            'category_id' => 'required|exists:categories,id',
            'images' => "array|max:$maxImages",
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $sale = Sale::create([
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'isSold' => false,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                Image::create([
                    'sale_id' => $sale->id,
                    'route' => $path,
                ]);
            }
        }

        return redirect()->route('sales.index')->with('success', 'Anuncio creado exitosamente.');
    }

    public function show($id)
    {
        $sale = Sale::with('category', 'user', 'images')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $categories = Category::all();
        return view('sales.edit', compact('sale', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $maxImages = Setting::where('name', 'maxImages')->value('maxImages') ?? 5;
        $request->validate([
            'product' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'images' => "array|max:$maxImages",
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $sale->update([
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                Image::create([
                    'sale_id' => $sale->id,
                    'route' => $path,
                ]);
            }
        }

        return redirect()->route('sales.index')->with('success', 'Anuncio actualizado.');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Anuncio eliminado.');
    }
}
