<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product; // Assuming you have a Product model

class CartController extends Controller
{
    public function addToCart($productId)
    {
        // Assuming you have a logged-in user, you can get the user ID from the authenticated user
        $userId = auth()->id();

        // Get the product details
        $product = Product::findOrFail($productId);

        // Check if the product already exists in the cart
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            // If the product already exists in the cart, increment its quantity
            $cartItem->quantity += 1; // Assuming you have a 'quantity' column in the carts table
            $cartItem->save();
        } else {
            // If the product doesn't exist in the cart, create a new cart item
            $cartItem = new Cart();
            $cartItem->user_id = $userId;
            $cartItem->product_id = $productId;
            // Add any other relevant fields such as quantity, etc.
            $cartItem->save();
        }

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'Item added to cart successfully']);
    }
}
