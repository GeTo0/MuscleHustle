<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\View\View;

class AdminMainController extends Controller
{
    public function create(): View
    {
        return view('admin_main');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'productName' => 'required|string',
            'productPrice' => 'required|numeric',
            'productSale' => 'numeric',
            'productDescription' => 'required|string',
            'productCategory' => 'required|string',
            'productImage' => 'string',
            'productAvailability' => 'numeric'
        ]);

        // Create a new product instance
        $product = new Product();
        $product->name = $validatedData['productName'];
        $product->price = $validatedData['productPrice'];
        $product->sale_percentage = $validatedData['productSale'];
        $product->category = $validatedData['productCategory'];
        $product->description = $validatedData['productDescription'];
        $product->image_path = $validatedData['productImage'];
        $product->availability = $validatedData['productAvailability'];

        // Save the product to the database
        $product->save();

        // Redirect back to the page with a success message
        return redirect()->back()->with('success', 'Product added successfully!');
    }
}