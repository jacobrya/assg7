<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('categories')->get(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_ids' => 'sometimes|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
        ]);

        if (! empty($data['category_ids'] ?? [])) {
            $product->categories()->sync($data['category_ids']);
        }

        $product->load('categories');

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        $product->load('categories');

        return response()->json($product, 200);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_ids' => 'sometimes|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $product->update([
            'name' => $data['name'],
            'price' => $data['price'],
        ]);

        if ($request->has('category_ids')) {
            $product->categories()->sync($data['category_ids']);
        }

        $product->load('categories');

        return response()->json($product, 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }

    public function categories(Product $product)
    {
        return response()->json($product->categories, 200);
    }
}
