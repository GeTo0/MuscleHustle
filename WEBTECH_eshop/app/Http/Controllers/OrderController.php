<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderHistory;

class OrderController extends Controller
{
    // Method to add a record to order history
    public function addToOrderHistory(Request $request)
    {
        // Assuming you have the necessary fields in your order history table,
        // you can retrieve the data from the request and create a new record

        // Example code to create a new record
        $order = new OrderHistory();
        $order->user_id = auth()->id(); // Assuming you have a user_id column
        $order->product_id = $request->product_id; // Assuming you have a product_id column
        // Add other fields as needed
        $order->save();

        // Return a response indicating success or failure
        return response()->json(['message' => 'Order added to history successfully']);
    }
}

