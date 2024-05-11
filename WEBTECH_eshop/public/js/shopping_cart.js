function clearCart() {
    localStorage.removeItem('cart');
    displayCart(); // Update displayed cart items after clearing
    calculateTotalPrice(); // Update total price after clearing cart
}
function calculateTotalPrice() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalPrice = 0;
    cart.forEach(function (item) {
        // Extract price from each item and add to totalPrice
        totalPrice += parseFloat(item.price);
    });
    document.getElementById('totalPrice').textContent = totalPrice.toFixed(2) + '$'; // Display total price
}


function updateCart() {
    // Fetch all quantity input fields
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const productQuantities = {};

    // Iterate over each quantity input field
    quantityInputs.forEach(input => {
        const productId = input.dataset.productId;
        const quantity = parseInt(input.value);
        productQuantities[productId] = quantity;
    });

    // Send an AJAX request to update cart quantities
    fetch('/update-cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(productQuantities)
    })
    .then(response => {
        console.log('Response:', response);
        if (response.ok) {
            // Cart updated successfully
            // Reload the page to reflect the changes
            location.reload();
        } else {
            // Cart update failed
            console.log('Failed to update cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        console.log('An error occurred while updating cart');
    });
}
