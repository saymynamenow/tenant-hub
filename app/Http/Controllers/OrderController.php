<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tenant\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\tenant\Products;
use App\Models\tenant\Order;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    public function checkout(Request $request) {
        $validated = $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|in:creditcard,transfer',
            'idempotency_key' => 'required|string',
        ]);

        $userId = Auth::guard('tenant')->id();
        $cart = Cart::with('items.product')->where('user_id', $userId)->first();

        if(!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $idempKey = $validated['idempotency_key'] ?? null;

        try{
            $order = DB::transaction(function() use ($cart, $userId, $validated, $idempKey) {
          
            if($idempKey){
                $existing = Order::where('user_id', $userId)
                    ->where('idempotency_key', $idempKey)
                    ->first();
                if($existing){
                    return $existing;
                }
            }

          $productIds = $cart->items->pluck('product_id')->unique()->values()->all();
          $products = Products::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');
          
            $total = 0;

            foreach ($cart->items as $item) {
                $product = $products->get($item->product_id);
                if(!$product) {
                    abort(400, "Product not found: " . $item->product_id);
                }
                if($item->quantity > $product->stock){
                    abort(400, "Insufficient stock for product: " . $product->name);
                }
                $total += $item->quantity * $item->price;
            }

            $orderData = [
                'user_id' => $userId,
                'total_amount' => $total,
                'payment_method' => $validated['payment_method'],
                'shipping_address' => $validated['address'],
                'status' => 'pending',
            ];


            if($idempKey){
                $orderData['idempotency_key'] = $idempKey;
            }

            $order = Order::create($orderData);


            foreach ($cart->items as $item) {
                $product = $products->get($item->product_id);
                $order->items()->create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subTotal' => $item->quantity * $item->price,
                ]);

                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
            }
            $cart->items()->delete();
            return $order;

        }, 5);

        if($idempKey && $order && $order->idempotency_key === $idempKey){
            return response()->json(['message' => 'Order already processed'], 200);
        }
        return response()->json(['message' => 'Order placed successfully'], 200);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getOrders(Request $request) {
        $userId = Auth::guard('tenant')->id();
        $orders = Order::with(['items.product', 'user'])->where('user_id', $userId)->get();

        return response()->json(['orders' => $orders], 200);
    }

    public function getAdminOrders(Request $request) {
        $orders = Order::with('items.product', 'user')->get();

        return response()->json(['orders' => $orders], 200);
    }

    public function updateOrderStatus(Request $request, $orderId) {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($orderId);
        $order->status = $validated['status'];
        $order->save();

        return response()->json(['message' => 'Order status updated successfully'], 200);
    }

    public function getOrderDetails(Request $request, $orderId) {
        $userId = Auth::guard('tenant')->id();
        $order = Order::with('items.product')->where('id', $orderId)->where('user_id', $userId)->firstOrFail();

        return response()->json(['order' => $order], 200);
    }
}
