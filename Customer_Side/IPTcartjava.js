document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".product-section").forEach(section => {
        const container = section.querySelector(".product-container");
        const leftButton = section.querySelector(".scroll-left");
        const rightButton = section.querySelector(".scroll-right");

        if (container && leftButton && rightButton) {
            leftButton.addEventListener("click", () => {
                container.scrollBy({ left: -200, behavior: "smooth" });
            });

            rightButton.addEventListener("click", () => {
                container.scrollBy({ left: 200, behavior: "smooth" });
            });
        }
    });

    // Search Function
    function search() {
        let searchbox = document.getElementById("search-item").value.toUpperCase();
        let products = document.querySelectorAll(".product-card");

        products.forEach(product => {
            let productName = product.querySelector("h2");
            
            if (productName) {
                let textValue = productName.textContent || productName.innerText;
                if (textValue.toUpperCase().indexOf(searchbox) > -1) {
                    product.style.display = "";
                } else {
                    product.style.display = "none";
                }
            }
        });
    }

    let listProductsHTML = document.querySelector(".product-container"); 
    let listCartHTML = document.querySelector(".Listcart");
    let iconCartSpan = document.querySelector(".Cart span");

    let listProducts = [];
    let carts = []; 

    // Show/Hide Cart
    let cartIcon = document.querySelector(".Cart"); 
    let closeBtn = document.querySelector(".close"); 

    if (cartIcon) {
        cartIcon.addEventListener("click", function () {
            document.body.classList.toggle("showcart");
        });
    } else {
        console.error("Cart button not found");
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            document.body.classList.remove("showcart");
        });
    } else {
        console.error("Close button not found");
    }

    // Fetch Products and Display
    const addDataToHtml = () => {
        listProductsHTML.innerHTML = ""; // Clear existing products

        if (listProducts.length > 0) {
            listProducts.forEach(product => {
                let newProduct = document.createElement('div');
                newProduct.classList.add('item');
                newProduct.dataset.id = product.id; // Ensure dataset id is added
                newProduct.innerHTML = `
                    <img src="${product.image}" alt="${product.name}">
                    <h2>${product.name}</h2>
                    <p>P${product.price}</p>
                    <button class="add-to-cart">Add to Cart</button>
                `;

                listProductsHTML.appendChild(newProduct);
            });
        }
    };

    // Add to Cart Event Listener
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("add-to-cart")) {
            let productElement = event.target.closest(".item"); // Get the parent div with dataset
            if (productElement) {
                let product_id = productElement.dataset.id;
                addToCart(product_id);
            }
        }
    });

    const addToCart = (product_id) => {
        let positionThisProductInCart = carts.findIndex((value) => value.product_id == product_id);

        if (carts.length <= 0) {
            carts = [{
                product_id: product_id,
                quantity: 1 
            }];
        } else if (positionThisProductInCart < 0){
            carts.push({
                product_id: product_id,
                quantity: 1
            });
        } else {
            carts[positionThisProductInCart].quantity = carts[positionThisProductInCart].quantity + 1;
        }
        addCartToHTML();
        addCartToMemory();
    };

    const addCartToMemory = () => {
        localStorage.setItem('cart', JSON.stringify(carts));
    };

    const addCartToHTML = () => {
        listCartHTML.innerHTML = '';
        let totalQuantity = 0;
        if (carts.length > 0) {
            carts.forEach(cart => {
                totalQuantity = totalQuantity + cart.quantity;
                let newCart = document.createElement('div');
                newCart.classList.add('item');
                newCart.dataset.id = cart.product_id;
                let positionProduct = listProducts.findIndex((value) => value.id == cart.product_id);
                let info = listProducts[positionProduct];
                newCart.innerHTML = `
                    <div class="image">
                        <img src="${info.image}" alt="Sweets 1">
                    </div>
                    <div class="name">${info.name}</div>
                    <div class="totalPrice">${info.price * cart.quantity}</div>
                    <div class="quantity">
                        <span class="minus">-</span>
                        <span>${cart.quantity}</span>
                        <span class="plus">+</span>
                    </div>
                `;

                listCartHTML.appendChild(newCart);
            });
        }
        iconCartSpan.innerText = totalQuantity;
    };

    listCartHTML.addEventListener('click', (event) => {
        let positionClick = event.target;
        if (positionClick.classList.contains('minus') || positionClick.classList.contains('plus')) {
            let product_id = positionClick.parentElement.parentElement.dataset.id;
            let type = 'minus'; 
            if (positionClick.classList.contains('plus')) {
                type = 'plus';
            }
            changeQuantity(product_id, type);
        }
    });

    const changeQuantity = (product_id, type) => {
        let positionItemInCart = carts.findIndex((value) => value.product_id == product_id);
        if (positionItemInCart >= 0) {
            switch (type) {
                case 'plus':
                    carts[positionItemInCart].quantity = carts[positionItemInCart].quantity + 1;
                    break;

                default:
                    let valueChange = carts[positionItemInCart].quantity - 1;
                    if (valueChange > 0) {
                        carts[positionItemInCart].quantity = valueChange;
                    } else {
                        carts.splice(positionItemInCart, 1);
                    }
                    break;
            }
        }
        addCartToMemory();
        addCartToHTML();
    };

    const calculateTotal = () => {
        let total = 0;
        carts.forEach(cart => {
            let positionProduct = listProducts.findIndex((value) => value.id == cart.product_id);
            let info = listProducts[positionProduct];
            total += info.price * cart.quantity;
        });
        return total;
    };

    // Show Cart Summary and Checkout
    const displayCheckoutItems = () => {
        const checkoutItemsList = document.querySelector(".checkout-items-list");
        checkoutItemsList.innerHTML = ''; // Clear previous list

        if (carts.length > 0) {
            carts.forEach(cart => {
                let positionProduct = listProducts.findIndex((value) => value.id == cart.product_id);
                let info = listProducts[positionProduct];

                let itemDiv = document.createElement('div');
                itemDiv.classList.add('item');
                itemDiv.innerHTML = `
                    <div class="item-name">${info.name}</div>
                    <div class="item-quantity">Quantity: ${cart.quantity}</div>
                    <div class="item-total">Total: P${info.price * cart.quantity}</div>
                `;
                checkoutItemsList.appendChild(itemDiv);
            });
        }
    };

    // Handle Checkout Form Submission
    document.querySelector("#shipping-form").addEventListener("submit, CheckOut", function (event) {
        event.preventDefault();

        // Get user input
        let name = document.getElementById("name").value;
        let address = document.getElementById("address").value;
        let phone = document.getElementById("phone").value;
        let email = document.getElementById("email").value;

        // Create an order object
        let order = {
            name: name,
            address: address,
            phone: phone,
            email: email,
            items: carts,
            total: calculateTotal()
        };

        // Here you can store the order in a database or send it to a server

        // Reset the cart
        carts = [];
        localStorage.setItem('cart', JSON.stringify(carts));

        // Show a confirmation message
        alert(`Order confirmed! Total: P${order.total}`);
        
        // Clear the checkout form and close the modal
        document.getElementById("shipping-form").reset();
        document.body.classList.remove("showCheckout");
        addCartToHTML();  // Update cart UI
    });

    // Open Checkout Modal
    document.querySelector(".checkout-btn").addEventListener("click", function () {
        document.body.classList.add("showCheckout");
        displayCheckoutItems(); // Display the items in the checkout modal
    });

    // Close Checkout Modal
    document.querySelector(".close-checkout").addEventListener("click", function () {
        document.body.classList.remove("showCheckout");
    });

    // Initialize App
    const initApp = () => {
        fetch('products.json')
            .then(response => response.json())
            .then(data => {
                listProducts = data;
                addDataToHtml();

                // Get cart from memory
                if (localStorage.getItem('cart')) {
                    carts = JSON.parse(localStorage.getItem('cart'));
                    addCartToHTML();
                }
            });
    };

    initApp();
});
