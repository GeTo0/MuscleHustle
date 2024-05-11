function fetchCartItems() {
    return fetch('/cart/items') // Adjust the URL endpoint based on your Laravel routes
        .then(response => response.json())
        .then(data => {
            // Assign fetched cart items to cartData
            cartData = data;
            // Update cart counter after fetching cart items
            updateCartCounter();
        })
        .catch(error => {
            console.error('Error fetching cart items:', error);
        });
}

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

window.onload = function () {
    fetchCartItems(); // Fetch cart items when the window loads
};
