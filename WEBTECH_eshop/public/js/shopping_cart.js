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