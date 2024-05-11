<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product Details</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/edit_product.css') }}">
</head>

<body>
    <div class="topnav">
        <a href="{{ route('homepage') }}"><img src="{{ asset('icons/account_icon.png') }}" alt="Icon 1"></a>
        <a href="{{ route('catalog') }}"><img src="{{ asset('icons/home_icon.png') }}" alt="Icon 2"></a>
    </div>
    
    <div class="product-info">
        <h2>Edit Product Details</h2>
        <form action="{{ route('update_product', $product->name) }}" method="POST">
            @csrf <!-- CSRF Protection -->

            <div class="input-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" class="input-admin" value="{{ $product->name }}" required>
            </div>
            <div class="input-group">
                <label for="productPrice">Product Price:</label>
                <input type="number" id="productPrice" name="productPrice" class="input-admin" value="{{ $product->price }}" min="0" step="0.01" required>
            </div>
            <div class="input-container">
                <label class="label-left" for="productSale">Product Sale:</label>
                <input type="number" id="productSale" name="productSale" min="0" step="0.01" class="input-admin" value="{{ $product->sale_percentage }}" required>
            </div>
            <div class="input-container">
                <label class="label-left" for="productImage">Product Image:</label>
                <input type="text" id="productImage" name="productImage" class="input-admin" value="{{ $product->image_path }}" required>
            </div>
            <div class="input-container">
                <label class="label-left" for="productCategory">Product Category:</label>
                <input type="text" id="productCategory" name="productCategory" class="input-admin" value="{{ $product->category }}" required>
            </div>
            <div class="input-container">
              <label class="label-left" for="productName">Product Description:</label>
              <input type="text" id="productDescription" name="productDescription" class="input-admin" value="{{ $product->description }}" required>
          </div>
          <div class="input-container">
            <label class="label-left" for="productName">Product Availability:</label>
            <input type="number" id="productAvailability" name="productAvailability" class="input-admin" value="{{ $product->availability }}" required>
        </div>
            <button type="submit">Save Changes</button>
        </form>
        <form action="{{ route('delete_product', $product->name) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete Product</button>
        </form>
    </div>

</body>
<script src="{{ asset('js/edit_product.js') }}"></script>
</html>