<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'shopping_cart';
    // Model logic here
    public function showCart()
    {
        // Fetch cart items from the database using the Cart model
        $cartItems = Cart::all(); // Assuming you want all items, you can modify this query as needed

        // Pass cart items to the view
        return view('shopping_cart', ['cartItems' => $cartItems]);
    }
}
