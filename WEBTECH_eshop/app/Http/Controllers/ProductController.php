<?php

namespace App\Http\Controllers;

use App\Models\Product; // Import the Product model
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Get all products from the database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($productName)
{
    // Retrieve the product details based on the provided name
    // You can fetch the product from the database or any other source
    $product = Product::where('name', $productName)->first();

    // Check if the product exists
    if (!$product) {
        abort(404); // Product not found, return 404 error
    }

    // Pass the product data to the product detail view
    return view('product', compact('product'));
}

public function show_edit_products($productName)
{
    // Retrieve the product details based on the provided name
    // You can fetch the product from the database or any other source
    $product = Product::where('name', $productName)->first();

    // Check if the product exists
    if (!$product) {
        abort(404); // Product not found, return 404 error
    }

    // Pass the product data to the product detail view
    return view('edit_product', compact('product'));
}

public function update_product(Request $request, $productName)
{
    try {
        // Retrieve the product by its name
        $product = Product::where('name', $productName)->first();

        // Check if the product exists
        if (!$product) {
            abort(404); // Product not found, return 404 error
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'productName' => 'required|string|max:255',
            'productPrice' => 'required|numeric|min:0',
            'productSale' => 'required|numeric|max:255',
            'productImage' => 'required|string',
            'productCategory' => 'required|string|max:255',
            'productDescription' => 'required|string|min:0',
            'productAvailability' => 'required|numeric',
            // Add validation rules for other fields like description, title, etc.
        ]);

        // Update the product details
        $product->name = $request->productName;
        $product->price = $request->productPrice;
        $product->sale_percentage = $request->productSale;
        $product->image_path = $request->productImage;
        $product->description = $request->productDescription;
        $product->category = $request->productCategory;
        $product->availability = $request->productAvailability;
        $product->save();

        return redirect('admin_main');
    } catch (\Exception $e) {
        // Handle any exceptions
        return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage());
    }
}

public function delete_product($productName)
{
    try {
        // Retrieve the product by its name
        $product = Product::where('name', $productName)->first();

        // Check if the product exists
        if (!$product) {
            abort(404); // Product not found, return 404 error
        }

        // Delete the product from the database
        $product->delete();

        // Redirect back to the admin page with success message
        return redirect('admin_main')->with('success', 'Product deleted successfully!');
    } catch (\Exception $e) {
        // Handle any exceptions
        return redirect()->back()->with('error', 'Failed to delete product: ' . $e->getMessage());
    }
}

    
    public function getAllProducts(): JsonResponse
    {
        try {
            // Fetch all products from the database
            $products = Product::all();
    
            // Check if products exist
            if ($products instanceof Collection && $products->isEmpty()) {
                return response()->json(['message' => 'No products found'], 404);
            }
    
            // Return products data in JSON format
            return response()->json($products);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to fetch products: ' . $e->getMessage()], 500);
        }
    }

    public function getAllCategories(): JsonResponse
    {
        try {
            // Fetch all unique category values from the database
            $categories = DB::table('products')->distinct()->pluck('category');
    
            // Check if categories exist
            if ($categories->isEmpty()) {
                return response()->json(['message' => 'No categories found'], 404);
            }
    
            // Return categories data in JSON format
            return response()->json($categories);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to fetch categories: ' . $e->getMessage()], 500);
        }
    }
}

