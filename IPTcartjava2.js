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
});

// Search Function
function search(inputId = "search-item") {
    let searchbox = document.getElementById(inputId).value.toUpperCase();
    let products = document.querySelectorAll(".listProduct .item");

    products.forEach(product => {
        let productName = product.querySelector("h2");

        if (productName) {
            let textValue = productName.textContent || productName.innerText;
            if (textValue.toUpperCase().indexOf(searchbox) > -1) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        }
    });
}

// Categories function
document.addEventListener("DOMContentLoaded", function() {
    const categories = document.querySelectorAll(".categories ul li ");

    categories.forEach(category => {
        category.addEventListener("click", function() {
            categories.forEach(cat => cat.classList.remove("active"));
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    let products = [];

    fetch("products.json")
        .then(response => response.json())
        .then(data => {
            products = data;
            displayProducts(products);
        })
        .catch(error => console.error("Error loading JSON:", error));

    function displayProducts(productList) {
        const productContainer = document.querySelector(".listProduct");
        productContainer.innerHTML = "";

        productList.forEach(product => {
            const productHTML = `
                <div class="item">
                    <img src="${product.image}" alt="${product.name}">
                    <h2>${product.name}</h2>
                    <div class="price">$${product.price}</div>
                    <button class="addcart">Add To Cart</button>
                </div>
            `;
            productContainer.innerHTML += productHTML;
        });
    }

    // Categories filtering
    const categories = document.querySelectorAll(".Categories ul li"); // keep capital C if your HTML uses it

    categories.forEach(category => {
        category.addEventListener("click", function () {
            categories.forEach(cat => cat.classList.remove("active"));
            this.classList.add("active");

            const selectedCategory = this.textContent.trim().toLowerCase();

            if (selectedCategory === "all") {
                displayProducts(products);
            } else {
                const filteredProducts = products.filter(product =>
                    product.categories.toLowerCase() === selectedCategory
                );
                displayProducts(filteredProducts);
            }
        });
    });
});

// Cart Show/Hide
document.addEventListener("DOMContentLoaded", () => {
    let iconCart = document.querySelector('.icon-cart');
    let closeCart = document.querySelector('.close');
    let body = document.querySelector('body');
    let listProductHTML = document.querySelector('.listProduct');
    let listCartHTML = document.querySelector(".listCart");
    let iconCartSpan = document.querySelector(".icon-cart span");
    let checkoutButton = document.querySelector(".checkout");

    let listProducts = [];
    let carts = [];

    iconCart.addEventListener('click', () => {
        body.classList.toggle('showCart');
    });

    closeCart.addEventListener('click', () => {
        body.classList.remove('showCart');
    });

    const addDataToHtml = () => {
        listProductHTML.innerHTML = "";
        if (listProducts.length > 0) {
            listProducts.forEach(product => {
                let newProduct = document.createElement('div');
                newProduct.classList.add('item');
                newProduct.dataset.id = product.id;
                newProduct.innerHTML = `
                    <img src="${product.image}" alt="${product.name}">
                    <h2>${product.name}</h2>
                    <div class="price">${product.price}</div>
                    <button class="addcart">Add To Cart</button>
                `;
                listProductHTML.appendChild(newProduct);
            });
        }
    };

    listProductHTML.addEventListener("click", function (event) {
        let positionClick = event.target;
        if (positionClick.classList.contains('addcart')) {
            let product_id = positionClick.parentElement.dataset.id;
            addToCart(product_id);
        }
    });

    const addToCart = (product_id) => {
        let positionThisProductInCart = carts.findIndex((value) => value.product_id == product_id);
        if (positionThisProductInCart < 0) {
            carts.push({ product_id, quantity: 1 });
        } else {
            carts[positionThisProductInCart].quantity++;
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
                totalQuantity += cart.quantity;
                let newCart = document.createElement('div');
                newCart.classList.add('item');
                newCart.dataset.id = cart.product_id;
                let info = listProducts.find(value => value.id == cart.product_id);
                newCart.innerHTML = `
                    <div class="image"><img src="${info.image}" alt="${info.name}"></div>
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
    listCartHTML.addEventListener("click", function (event) {
        let positionClick = event.target;
        let cartItem = positionClick.closest('.item'); // Get the cart item element
        if (cartItem) {
            let product_id = cartItem.dataset.id;
    
            if (positionClick.classList.contains('plus')) {
                updateCartQuantity(product_id, 1);  // Increase the quantity
            }
    
            if (positionClick.classList.contains('minus')) {
                updateCartQuantity(product_id, -1);  // Decrease the quantity
            }
        }
    });
    
    const updateCartQuantity = (product_id, change) => {
        let positionThisProductInCart = carts.findIndex((value) => value.product_id == product_id);
        if (positionThisProductInCart >= 0) {
            carts[positionThisProductInCart].quantity += change;
    
            // Prevent quantity from going below 1
            if (carts[positionThisProductInCart].quantity <= 0) {
                carts.splice(positionThisProductInCart, 1); // Remove product if quantity is 0
            }
    
            addCartToHTML();  // Update the cart UI
            addCartToMemory();  // Update the localStorage
        }
    };

    if (checkoutButton) {
        checkoutButton.addEventListener("click", function () {
            if (carts.length > 0) {
                alert("Order placed successfully!");
                carts = [];
                addCartToMemory();
                addCartToHTML();
            } else {
                alert("Your cart is empty!");
            }
        });
    }

    const initApp = () => {
        fetch('products.json')
            .then(response => response.json())
            .then(data => {
                listProducts = data;
                addDataToHtml();
                if (localStorage.getItem('cart')) {
                    carts = JSON.parse(localStorage.getItem('cart'));
                    addCartToHTML();
                }
            });
    };

    initApp();
});

document.addEventListener("DOMContentLoaded", function () {
    // Select the Checkout button
    const checkoutBtn = document.querySelector(".CheckOut");

    // Ensure the button exists before adding the event listener
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", function () {
            // Get the cart items
            const cartItems = document.querySelectorAll(".listCart .item");

            // Check if cart is empty
            if (cartItems.length === 0) {
                alert("Your cart is empty! Add items before checkout.");
                return;
            }

            // Collect order details
            let orderDetails = [];
            cartItems.forEach(item => {
                const name = item.querySelector(".name").textContent.trim();
                const price = item.querySelector(".totalPrice").textContent.trim();
                const quantity = item.querySelector(".quantity span:nth-child(2)").textContent.trim();

                orderDetails.push({ name, price, quantity });
            });

            // Convert to JSON (for potential backend use)
            const orderData = JSON.stringify(orderDetails);

            // Simulate Checkout Process (You can replace this with an actual backend request)
            alert("Order placed successfully!\n\n" + orderData);

            // Clear cart after checkout
            document.querySelector(".listCart").innerHTML = "";
            document.querySelector(".icon-cart span").textContent = "0";
        });
    } else {
        console.error("Checkout button not found!");
    }
});
