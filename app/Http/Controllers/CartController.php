<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tenant\Cart;
use App\Models\tenant\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\tenant\Products;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::guard('tenant')->id()]);
        $product = Products::find($request->product_id);
        if(!$product){
            return response()->json(['error' => 'Product not found'], 404);
        }
        
        if($request->quantity > $product->stock){
            return response()->json(['error' => 'Requested quantity exceeds available stock'], 400);
        }
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();
        $newQuantity = $cartItem ? $cartItem->quantity + $request->quantity : $request->quantity;
        if($newQuantity > $product->stock){
            return response()->json(['error' => 'Total quantity exceeds available stock'], 400);
        }
        
        
        DB::transaction(function() use ($cart, $request, $product) {
            $cartItem = $cart->items()->where('product_id', $request->product_id)->first();
    
            if($cartItem){
                $newQuantity = $cartItem->quantity + $request->quantity;
                $cartItem->update(['quantity' => $newQuantity]);
            }else{
                $cart->items()->create([
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $product->price,
                ]);
            }
        });
        return response()->json(['message' => 'Product added to cart successfully'], 200);
    }

    public function viewCart()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::guard('tenant')->id())->first();
        if(!$cart){
            return response()->json(['cart' => null], 200);
        }
        return response()->json(['cart' => $cart], 200);
    }

    public function clearCart()
    {
        $cart = Cart::where('user_id', Auth::guard('tenant')->id())->first();
        if($cart){
            $cart->items()->delete();
        }
        return response()->json(['message' => 'Cart cleared successfully'], 200);
    }

    public function removeItem(Request $request, $itemId)
    {
        $cart = Cart::where('user_id', Auth::guard('tenant')->id())->first();
        if(!$cart){
            return response()->json(['error' => 'Cart not found'], 404);
        }
        $cartItem = $cart->items()->where('id', $itemId)->first();
        if(!$cartItem){
            return response()->json(['error' => 'Item not found in cart'], 404);
        }
        $cartItem->delete();
        return response()->json(['message' => 'Item removed from cart successfully'], 200);
    }
    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', Auth::guard('tenant')->id())->first();
        if(!$cart){
            return response()->json(['error' => 'Cart not found'], 404);
        }
        $cartItem = $cart->items()->where('id', $itemId)->first();
        if(!$cartItem){
            return response()->json(['error' => 'Item not found in cart'], 404);
        }

        $product = Products::find($cartItem->product_id);
        if($request->quantity > $product->stock){
            return response()->json(['error' => 'Requested quantity exceeds available stock'], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        return response()->json(['message' => 'Cart item updated successfully'], 200);
    }
}
