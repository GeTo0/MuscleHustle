// Function to fetch products from the backend
function fetchProducts() {
    // Make an AJAX request to fetch products from the backend
    return fetch('/catalog/products')
        .then(response => response.json())
        .catch(error => {
            console.error('Error fetching products:', error);
        });
}

function fetchCartItems() {
    return fetch('/cart/items') // Adjust the URL endpoint based on your Laravel routes
        .then(response => response.json())
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
}

let productsData;
let cartData;
let categoriesData;
let currentPage = 1;
const productsPerPage = 6;

// Initialize the slider
const priceSlider = document.getElementById('price-slider');
const minPrice = document.getElementById('min-price');
const maxPrice = document.getElementById('max-price');
const categoryFilter = document.getElementById('category-filter'); // Get the category filter dropdown menu

// Function to open product page with additional information
function openProductPage(productName, productImage, productPrice) {
    // Here you can redirect to product.html and pass the product name as a parameter
    window.location.href = `/product/${productName}?image=${productImage}&price=${productPrice}`;
}

function createFilteredProducts() {
    let filteredProducts = [];
    const minPriceValue = parseFloat(minPrice.textContent.slice(1)); // Extract the minimum price value
    const maxPriceValue = parseFloat(maxPrice.textContent.slice(1)); // Extract the maximum price value
    const saleCheckbox = document.getElementById('ch1'); // Get the sale checkbox element
    const selectedCategory = categoryFilter.value; // Get the selected category from the dropdown menu
    const searchFilter = document.getElementById('search-filter').value.trim().toLowerCase(); // Get the search filter input value

    productsData.forEach((product) => {
        // Calculate the price to be used for filtering
        let priceToUse = product.price; // Default to normal price
        if (product['sale_percentage'] > 0) {
            // If the product is on sale, calculate the discounted price
            const discountedPrice = (product.price - (product.price * product['sale_percentage'] / 100));
            priceToUse = discountedPrice;
        }

        // Check if the sale checkbox is checked and if the product has a sale greater than 0
        // Check if the product's category matches the selected category or if no category is selected
        // Also, check if the product name contains the search filter string
        if ((!saleCheckbox.checked || (saleCheckbox.checked && product['sale_percentage'] > 0)) &&
            priceToUse >= minPriceValue && priceToUse <= maxPriceValue &&
            (selectedCategory === '' || product.category === selectedCategory) &&
            (product.name.toLowerCase().includes(searchFilter))) {
            filteredProducts.push(product);
        }
    });

    return filteredProducts;
}

function updatePageCounter(filteredProducts) {
    const totalPages = Math.max(Math.ceil(filteredProducts.length / productsPerPage), 1);
    const pageCounter = document.getElementById('page-counter');
    pageCounter.textContent = `Page ${currentPage} of ${totalPages}`;
}

// Function to sort products by price
function sortProductsByPrice(filteredProducts) {
    // Sort the filtered products array by price in ascending order
    filteredProducts.sort((a, b) => (a.price - (a.price * a['sale_percentage'] / 100)) - (b.price - (b.price * b['sale_percentage']) / 100));
    return filteredProducts; // Return the sorted array
}

// Function to sort products alphabetically
function sortProductsByAlphabet(filteredProducts) {
    // Sort the filtered products array alphabetically by product name
    filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
    return filteredProducts; // Return the sorted array
}

// Function to sort products based on the selected filter option
function sortProducts(filteredProducts) {
    const filterOption = document.querySelector('input[name="filterOption"]:checked').value;
    if (filterOption === 'Price') {
        filteredProducts = sortProductsByPrice(filteredProducts);
    } else if (filterOption === 'Alphabet') {
        filteredProducts = sortProductsByAlphabet(filteredProducts);
    }
    return filteredProducts;
}

function generateProductItems() {
    // Clear products before generating new
    const productsContainer = document.querySelector('.products');
    productsContainer.innerHTML = ''; // Clear the inner HTML of the products container

    // Filter products by price interval and then sort it
    let filteredProducts = createFilteredProducts();
    filteredProducts = sortProducts(filteredProducts);

    // Calculate the starting and ending index for the current page
    const startIndex = (currentPage - 1) * productsPerPage;
    const endIndex = Math.min(startIndex + productsPerPage, productsData.length);

    // Generate product items for the current page
    for (let i = startIndex; i < endIndex; i++) {
        if (filteredProducts.length > i) {
            const product = filteredProducts[i];
            const productItem = document.createElement('div');
            productItem.classList.add('product');

            let priceDisplay = `${product.price}$`; // Default price display

            // If the product has a sale, calculate the discounted price and display it along with the original price
            if (product['sale_percentage'] > 0) {
                const discountedPrice = (product.price - (product.price * product['sale_percentage'] / 100)).toFixed(2);
                priceDisplay = `<span style="text-decoration: line-through;">${product.price}$</span> <span style="color: orange;">${discountedPrice}$</span>`;
                // Add the sale.png image to the product item
                const saleImage = document.createElement('img');
                saleImage.src = 'icons/sale_icon.png';
                saleImage.alt = 'Sale';
                saleImage.classList.add('sale-image');
                productItem.appendChild(saleImage);
            }

            // Include product name and price display in the product item
            productItem.innerHTML += `
                <a onclick="openProductPage('${product.name}', '${product.image_path}', ${product.price})">
                    <img src="${product.image_path}" onerror="this.src='images/error_image.png'" alt="${product.name}">
                </a>
                <p>${product.name}</p>
                <p>${priceDisplay}</p>
                <button onclick="openProductPage('${product.name}', '${product.image_path}', ${product.price})">Info</button>
            `;
            productsContainer.appendChild(productItem); // Append the product item to the products container
        }
    }
    updatePageCounter(filteredProducts); // Update the page counter after generating product items
}

function showPreviousProducts() {
    currentPage = Math.max(currentPage - 1, 1);
    generateProductItems(); // Regenerate product items for the current page
}

function showNextProducts() {
    currentPage = Math.min(currentPage + 1, Math.ceil(createFilteredProducts().length / productsPerPage));
    generateProductItems(); // Regenerate product items for the current page
}

noUiSlider.create(priceSlider, {
    start: [0, 200], // Initial values for minimum and maximum prices
    connect: true, // Connect the two handles with a line
    range: {
        'min': 0,
        'max': 200 // Adjust the maximum value as per your requirement
    }
});

// Add an event listener to the price slider to trigger the sortAndFilterProducts function when the slider values change
priceSlider.noUiSlider.on('update', function (values) {
    minPrice.textContent = '$' + values[0];
    maxPrice.textContent = '$' + values[1];
});

// Add an event listener to the category filter dropdown menu to trigger the filtering of products when the selected category changes
categoryFilter.addEventListener('change', () => {
    generateProductItems(); // Regenerate product items when the selected category changes
});

function updateCartCounter() {
    let totalQuantity = 0; // Initialize total quantity counter
    // Iterate through the cartData array and sum up the quantities of all products
    cartData.forEach(item => {
        totalQuantity += item.quantity;
    });
    // Update the cartCounter with the total quantity
    let cartCounter = document.getElementById('cartCounter');
    cartCounter.textContent = totalQuantity; // Update counter with the total quantity of items in the fetched cartItems
}

function fetchCategories() {
    return fetch('/catalog/categories')
        .then(response => response.json())
        .catch(error => {
            console.error('Error fetching categories:', error);
            throw error; // Re-throw the error to be caught by the caller
        });
}


function filterByName() {
    currentPage = 1; // Reset the current page to 1 when applying a new filter
    generateProductItems(); // Regenerate product items after applying the filter
}

window.onload = function () {
    // Fetch products, cart items, and categories simultaneously
    Promise.all([fetchProducts(), fetchCartItems(), fetchCategories()])
        .then(([products, cartItems, categories]) => {
            // console.log('Products fetched successfully:', products);
            // console.log('Cart items fetched successfully:', cartItems);
            // console.log('Categories fetched successfully:', categories);

            productsData = products;
            cartData = cartItems;

            // Populate the category filter dropdown menu with retrieved categories
            const categoryFilter = document.getElementById('category-filter');
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category;
                categoryFilter.appendChild(option);
            });

            generateProductItems(); // Generate product items with fetched data
            updateCartCounter(); // Update cart counter
        })
        .catch(error => {
            console.error('Error fetching products, cart items, and/or categories:', error);
        });
};
