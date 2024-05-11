<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/shopping_cart.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="topnav">
  <a href="{{ route('homepage') }}"><img src="{{ asset('icons/account_icon.png') }}" alt="Icon 1"></a>
  <a href="{{ route('catalog') }}"><img src="{{ asset('icons/home_icon.png') }}" alt="Icon 2"></a>
  <a href="{{ route('shopping_cart') }}"><img src="{{ asset('icons/kosik.png') }}" alt="Icon 3"></a>
</div>
<div class="shopping-cart">
  <h2>Shopping Cart</h2>
<!-- Cart items will be displayed here -->
<div id="cartItems">
  <!-- If cart is empty, display a message -->
  @if(count($cartItems) == 0)
      <p>Your cart is empty</p>
  @endif

  @php
    $totalPrice = 0; // Initialize total price variable
  @endphp

@foreach($cartItems as $item)
    <div class="cart-item">
        <p>{{ $item->name }}</p>
        <!-- Check if the product has a sale percentage -->
        @php
            // Initialize sale price to the regular price by default
            $salePrice = $item->price;
        @endphp
        @if($item->sale_percentage > 0)
            <!-- Display the original price -->
            <span style="color: black; text-decoration: line-through;">{{ $item->price }}$</span>
            <!-- Calculate the sale price and display it -->
            @php
                $salePrice = number_format($item->price - ($item->price * $item->sale_percentage / 100), 2);
            @endphp
            <p style="color: orange;">Sale: {{ $salePrice }}$</p>
        @else
            <!-- If no sale percentage, display the regular price -->
            <p>{{ $item->price }}$</p>
        @endif
        <!-- Input field for quantity adjustment -->
        <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1" data-product-id="{{ $item->product_id }}">
        <!-- Add more details here as needed -->
    </div>
    @php
        // Calculate total price including sale prices
        $totalPrice += $salePrice * $item->quantity;
    @endphp
@endforeach



<!-- Submit button to update cart -->
<button id="updateCartBtn" onclick="updateCart()">Update Cart</button>



</div>
  <!-- Display total price -->
  <div class="total-price">
    Total price: <span id="totalPrice">{{ $totalPrice }}</span>$
  </div>

  <!-- Payment Form -->
  <div class="payment-form">
    <strong>Payment form:</strong><br>
    <ol>
      <li><input type="radio" id="crypto-payment" name="payment" value="crypto-payment" checked>
        <label for="crypto-payment">via Crypto</label></li>
      <li><input type="radio" id="payment-on-delivery" name="payment" value="payment-on-delivery">
        <label for="payment-on-delivery">Payment on delivery</label></li>
    </ol>
  </div>

  <!-- Shipping -->
  <div class="shipping">
    <strong>Shipping:</strong><br>
    <ol>
      <li><input type="radio" id="musclehustle-account-address" name="shipping" value="musclehustle-account-address" checked>
        <label for="musclehustle-account-address">MuscleHustle account address</label></li>
      <li><input type="radio" id="custom-address" name="shipping" value="custom-address">
        <label for="custom-address">Custom address</label></li>
    </ol>
  </div>

  <!-- Checkout Button -->
  <a href="#" class="checkout">Checkout</a>
  <!-- Clear Cart Button -->
  <a href="#" class="clearcart" onclick="clearCart()">Clear Cart</a>
</div>
</body>
<script src="{{ asset('js/shopping_cart.js') }}"></script>
</html>
