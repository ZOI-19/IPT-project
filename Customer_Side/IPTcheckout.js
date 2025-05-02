document.addEventListener('DOMContentLoaded', function() {
    console.log('IPTcheckout.js Loaded!');

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const listCart = document.getElementById('listCart');
    const subtotalElement = document.getElementById('subtotal');
    const checkoutBtn = document.querySelector('.payment-button');

    if (!listCart || !subtotalElement) {
        console.error('Cart display elements not found!');
        return;
    }

    function loadCart() {
        listCart.innerHTML = '';
        let subtotal = 0;

        if (cart.length === 0) {
            listCart.innerHTML = '<p>Your cart is empty!</p>';
        } else {
            cart.forEach(item => {
                subtotal += item.price * item.quantity;
                listCart.innerHTML += `
                    <div class="item">
                        <div class="image"><img src="${item.image}" alt=""></div>
                        <div class="name">${item.name}</div>
                        <div class="totalPrice">₱${item.price * item.quantity}</div>
                        <div class="quantity">${item.quantity}</div>
                    </div>
                `;
            });
        }

        subtotalElement.innerHTML = `<strong>Subtotal:</strong> ₱${subtotal}`;
    }

    function selectPayment(method) {
        document.getElementById('payment_method').value = method;
        alert("Payment method selected: " + method);
    }

    function checkout() {
        const paymentMethod = document.getElementById('payment_method').value;
        if (!paymentMethod) {
            alert('Please select a payment method!');
            return;
        }

        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        const formData = new FormData(document.getElementById('checkoutForm'));
        formData.append('cart', JSON.stringify(cart));

        fetch('checkout.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                alert('Checkout Successful!');
                localStorage.removeItem('cart');
                window.location.href = 'order_success.php';
            } else {
                alert('Checkout Failed: ' + response.message);
            }
        })
        .catch(error => {
            console.error('Error during checkout:', error);
            alert('Checkout failed. Try again.');
        });
    }

    loadCart();

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', checkout);
    } else {
        console.warn('Checkout button not found!');
    }

    // Make selectPayment function globally available
    window.selectPayment = selectPayment;
});
