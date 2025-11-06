<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tenant\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('tenant')->user(); 

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $categories = Category::withCount('products')->orderBy('name')->get();


        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('tenant')->user(); 

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'slug' => 'required|string|unique:categories,slug',
        ]);

        try {
            $category = Category::create($validated);

            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create category',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
