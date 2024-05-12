<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function addToCart($productId)
    {
        $cartItem = new Cart();
        // Check if the user is authenticated
        if (auth()->check()) {
            // If the user is authenticated, use their user ID
            $userId = auth()->id();
            $sessionId = null; // No need to store session ID for authenticated users
            $cartItem->user_id = $userId;
        } else {
            // If the user is not authenticated, use the session ID
            $userId = null; // No need to store user ID for unauthenticated users
            $sessionId = Session::getId();
            $cartItem->session_id = $sessionId;
        }

        // Create a new cart item
        $cartItem->product_id = $productId;
        // Add any other relevant fields such as quantity, etc.
        $cartItem->save();

        // Redirect back to the previous page
        return back();
    }

    public function getCartItems()
    {
        // Retrieve cart items for the authenticated user
        $userId = auth()->id();
        $cartItems = Cart::where('user_id', $userId)->get();

        // Return the cart items as JSON response
        return response()->json($cartItems);
    }


    public function showCart()
    {
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Fetch cart items associated with the authenticated user
        $cartItems = Cart::where('user_id', $userId)
            ->join('products', 'shopping_cart.product_id', '=', 'products.id')
            ->select('shopping_cart.*', 'products.name', 'products.price', 'products.sale_percentage')
            ->get();

        // Pass cart items to the view
        return view('shopping_cart', ['cartItems' => $cartItems]);
    }

    public function updateCart(Request $request)
    {
        // Log the request data
        Log::info('Request Data:', $request->all());

        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve the updated product quantities from the request
        $productQuantities = $request->all();

        // Loop through each product ID and quantity and update or delete the corresponding cart item
        foreach ($productQuantities as $productId => $quantity) {
            // Find the cart item associated with the user and the product ID
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                if ($quantity == 0) {
                    // If quantity is 0, delete the cart item
                    $cartItem->delete();
                } else {
                    // Update the quantity of the cart item
                    $cartItem->quantity = $quantity;
                    $cartItem->save();
                }
            }
        }

        // Return a response indicating success
        return response()->json(['message' => 'Cart updated successfully']);
    }
}
