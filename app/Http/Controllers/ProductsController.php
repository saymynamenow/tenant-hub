<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tenant\Products;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('tenant')->user(); 
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if($user->role === 'admin' || $user->role === 'manager'){
        $products = Products::with('category')->get();
        } else {
            $products = Products::select('id', 'name', 'price', 'stock', 'imageUrl', 'category_id')
                ->with(['category' => function ($q) {
                    $q->select('id', 'name', 'icon', 'color', 'slug');
                }])->get();        }
        return response()->json(['products' => $products], 200);
    }

    public function show($id)
    {
        $product = Products::findOrFail($id);
        return response()->json(['product' => $product], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'slug' => 'required|string|unique:product,slug',
            'category_id' => 'required|integer',
            'imageUrl' => 'nullable|string',
        ]);

        $product = Products::create($request->all());
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $product->update($request->all());
        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

}
