<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Catalog (Admin)</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/cart_counter.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/admin_main.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">
</head>

<body>
  <div class="topnav">
    <a href="{{ route('homepage') }}"><img src="{{ asset('icons/account_icon.png') }}" alt="Icon 1"></a>
    <a href="{{ route('catalog') }}"><img src="{{ asset('icons/home_icon.png') }}" alt="Icon 2"></a>
  </div>

  <div class="catalog">
    <h2>Product Catalog (Admin)</h2>
    <form action="{{ route('admin_page.store') }}" method="POST">
        @csrf <!-- CSRF Protection -->
        <div class="input-group">
            <div class="input-container">
                <label class="label-left" for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" class="input-admin" required>
            </div>
            <div class="input-container">
                <label class="label-left" for="productPrice">Product Price:</label>
                <input type="number" id="productPrice" name="productPrice" min="0" step="0.01" class="input-admin" required>
            </div>
            <div class="input-container">
                <label class="label-left" for="productSale">Product Sale:</label>
                <input type="number" id="productSale" name="productSale" min="0" step="0.01" class="input-admin" required>
            </div>
            <div class="input-container">
                <label class="label-left" for="productImage">Product Image:</label>
                <input type="text" id="productImage" name="productImage" class="input-admin" required>
            </div>
            <div class="input-container">
                <label class="label-left" for="productCategory">Product Category:</label>
                <input type="text" id="productCategory" name="productCategory" class="input-admin" required>
            </div>
            <div class="input-container">
              <label class="label-left" for="productName">Product Description:</label>
              <input type="text" id="productDescription" name="productDescription" class="input-admin" required>
          </div>
          <div class="input-container">
            <label class="label-left" for="productName">Product Availability:</label>
            <input type="number" id="productAvailability" name="productAvailability" class="input-admin" required>
        </div>
          
        </div>
        <button type="submit">Add Product</button>
    </form>

    <hr>
    <div class="body">
      <button onclick="generateProductItemsEdit()">
        <img src="{{ asset('icons/filter.png') }}" alt="Filter Icon" class="negative-img" id="filter-button">
      </button>
      <div class="tabs">
        <input checked="" value="Price" name="filterOption" id="pr" type="radio" class="input" />
        <label for="pr" class="label">Price</label>
        <input value="Alphabet" name="filterOption" id="alpha" type="radio" class="input" />
        <label for="alpha" class="label">Alphabet</label>
      </div>      
      <div id="slider-container">
        <label for="price-slider">Price Interval:</label>
        <!-- Create an empty div for the slider -->
        <div id="price-slider"></div>
        <!-- Display labels for minimum and maximum prices -->
        <span id="min-price">$0</span> - <span id="max-price">$200</span>
      </div>
      <div class="content">
        <label class="checkBox">
          <input id="ch1" type="checkbox">
          <div class="transition"></div>
        </label>
        <span class="checkbox-text">Discounted items</span>
      </div>
    </div>
    <div class="products"></div>
    <div class="navigation">
      <span class="nav-button" onclick="showPreviousProducts()">&#10094;</span>
      <span id="page-counter"></span>
      <span class="nav-button" onclick="showNextProducts()">&#10095;</span>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>
  <script src="{{ asset('js/admin_main.js') }}"></script>
</body>

</html>
