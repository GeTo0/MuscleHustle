<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cart_counter.css') }}">
</head>

<body>
    <div class="topnav">
        <a href="{{ route('homepage') }}"><img src="{{ asset('icons/account_icon.png') }}" alt="Icon 1"></a>
        <a href="{{ route('catalog') }}"><img src="{{ asset('icons/home_icon.png') }}" alt="Icon 2"></a>
        <a href="{{ route('shopping_cart') }}"><img src="{{ asset('icons/kosik.png') }}" alt="Icon 3"></a>
        <span id="cartCounter"></span>
    </div>

    <div class="product-info">
        <!-- resources/views/product.blade.php -->
<h1>{{ $product->name }}</h1>
<img id="productImage" src="{{ $product->image_path }}" alt="{{ $product->name }}" onerror="this.onerror=null; this.src='{{ asset('images/error_image.png') }}';">
@if($product->sale_percentage > 0)
    <!-- Display the original price -->
    <p style="color: black; text-decoration: line-through;">{{ $product->price }}$</p>
    <!-- Calculate the sale price and display it -->
    @php
    $salePrice = number_format($product->price - ($product->price * $product->sale_percentage / 100), 2);
    @endphp
    <p style="color: orange;">Sale: {{ $salePrice }}$</p>
@else
    <!-- If no sale percentage, display the regular price -->
    <p>{{ $product->price }}$</p>
@endif
<p>Description: {{ $product->description }}</p>

<form action="{{ route('add_to_cart', ['productId' => $product->id]) }}" method="post">
    @csrf
    <button type="submit">Add to Cart</button>
</form>
    </div>

</body>
<script src="{{ asset('js/product.js') }}"></script>


</html>
