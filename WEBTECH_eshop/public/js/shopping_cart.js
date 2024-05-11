function clearCart() {
    // Fetch all quantity input fields
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const productQuantities = {};

    // Iterate over each quantity input field
    quantityInputs.forEach(input => {
        const productId = input.dataset.productId;
        const quantity = parseInt(0);
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
                location.reload()
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

function clearCartCheckout() {
    // Fetch all quantity input fields
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const productQuantities = {};

    // Iterate over each quantity input field
    quantityInputs.forEach(input => {
        const productId = input.dataset.productId;
        const quantity = parseInt(0);
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

function checkout() {
    // Check if "MuscleHustle account address" is selected for shipping
    const muscleHustleShipping = document.getElementById('musclehustle-account-address').checked;

    // Check if the user is logged in
    checkAuthStatus().then(loggedIn => {
        console.log(loggedIn); // Log the value of loggedIn
        // If "MuscleHustle account address" is selected and the user is not logged in
        if (muscleHustleShipping && !loggedIn) {
            // Display an alert message indicating that the user needs to be logged in
            alert('Please log in to proceed with muscleHustle account address checkout.');
            return;
        }

        // Proceed with checkout process
        // Get all quantity input fields
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const productIds = [];

        // Iterate over each quantity input field
        quantityInputs.forEach(input => {
            const productId = input.dataset.productId;
            const quantity = parseInt(input.value);
            // Add the productId to the array as many times as the quantity
            for (let i = 0; i < quantity; i++) {
                productIds.push(productId);
            }
        });

        if (loggedIn && productIds.length > 0) {
            // Make an AJAX request to add each product to the order history
            Promise.all(productIds.map(productId => {
                return fetch('/add-to-order-history', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_id: productId }) // Send the product_id to the server
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to add product to order history');
                    }
                });
            }))
            .then(() => {
                // All products added to order history successfully
                console.log('All products added to order history successfully');
                // Clear the cart after successful checkout
                clearCartCheckout();
                // Redirect to the catalog page
                window.location.href = "/catalog";
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle error
            });
        }
    
});
}


// Function to check authentication status
function checkAuthStatus() {
    return fetch('/auth/status')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            return data.loggedIn;
        })
        .catch(error => {
            console.error('Error checking authentication status:', error);
            // Handle error, display an error message, etc.
            return false; // Return false if there's an error
        });
}


// Function to toggle visibility of card details form based on payment method selection
function toggleCardDetails() {
    const cardPayment = document.getElementById('card-payment');
    const cardDetails = document.querySelector('.card-details');

    // If card payment is selected, show card details form; otherwise, hide it
    if (cardPayment.checked) {
        cardDetails.style.display = 'block';
    } else {
        cardDetails.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Function to toggle visibility of card details form based on payment method selection
    function toggleCardDetails() {
        const cardPayment = document.getElementById('card-payment');
        const cardDetails = document.querySelector('.card-details');

        // If card payment is selected, show card details form; otherwise, hide it
        if (cardPayment.checked) {
            cardDetails.style.display = 'block';
        } else {
            cardDetails.style.display = 'none';
        }
    }

    // Event listener to toggle card details form visibility when payment method changes
    document.querySelectorAll('input[name="payment"]').forEach(radio => {
        radio.addEventListener('change', toggleCardDetails);
    });

    // Function to toggle visibility of custom address form based on selection
    function toggleCustomAddressForm() {
        const customAddressRadio = document.getElementById('custom-address');
        const customAddressForm = document.querySelector('.custom-address');
        const muscleHustleAddressRadio = document.getElementById('musclehustle-account-address');

        // If custom address radio is checked, show the form; otherwise, hide it
        if (customAddressRadio.checked) {
            customAddressForm.style.display = 'block';
        } else if (muscleHustleAddressRadio.checked) {
            customAddressForm.style.display = 'none';
        } else {
            customAddressForm.style.display = 'none';
        }
    }

    // Add event listener to the custom address radio button
    document.getElementById('custom-address').addEventListener('change', toggleCustomAddressForm);
    document.getElementById('musclehustle-account-address').addEventListener('change', toggleCustomAddressForm);
});