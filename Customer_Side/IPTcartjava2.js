    //add to cart
    document.addEventListener('DOMContentLoaded', () => {
      const cartIcon = document.querySelector('.icon-cart');
      const cartTab = document.querySelector('.cartTab');
      const closeCartBtn = document.querySelector('.close');
      const listCart = document.querySelector('.listCart');
      const cartCount = document.querySelector('.icon-cart span');
      const addToCartButtons = document.querySelectorAll('.addToCartBtn');
      const CART_STORAGE_KEY = 'myCart';
  
      let cart = JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];
  
      // Open cart
      cartIcon.addEventListener('click', () => {
          document.body.classList.add('showCart');
          renderCart();
      });
  
      // Close cart
      closeCartBtn.addEventListener('click', () => {
          document.body.classList.remove('showCart');
      });
  
      // Add to cart buttons
      addToCartButtons.forEach(button => {
          button.addEventListener('click', () => {
              const productElement = button.closest('.item');
              const id = productElement.getAttribute('data-id');
              const name = productElement.querySelector('h2').textContent;
              const price = parseFloat(productElement.querySelector('.price').textContent.replace('₱', ''));
              const image = productElement.querySelector('img').getAttribute('src');
  
              const existingItem = cart.find(item => item.id === id);
              if (existingItem) {
                  existingItem.quantity += 1;
              } else {
                  cart.push({ id, name, price, image, quantity: 1 });
              }
              saveCart();
              renderCart();
          });
      });
  
      function saveCart() {
          localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
      }
  
      function renderCart() {
        listCart.innerHTML = '';
        cart.forEach(item => {
            const totalPrice = item.price * item.quantity;
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('item');
            itemDiv.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <div>${item.name}</div>
                <div>₱${totalPrice.toFixed(2)}</div>
                <div class="quantity">
                    <span class="decrease" data-id="${item.id}">-</span>
                    ${item.quantity}
                    <span class="increase" data-id="${item.id}">+</span>
                </div>
            `;
            listCart.appendChild(itemDiv);
        });
    
        cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
        attachQuantityEvents();
    }
      function attachQuantityEvents() {
          listCart.querySelectorAll('.increase').forEach(btn => {
              btn.addEventListener('click', () => {
                  const item = cart.find(i => i.id === btn.getAttribute('data-id'));
                  item.quantity += 1;
                  saveCart();
                  renderCart();
              });
          });
  
          listCart.querySelectorAll('.decrease').forEach(btn => {
              btn.addEventListener('click', () => {
                  const item = cart.find(i => i.id === btn.getAttribute('data-id'));
                  if (item.quantity > 1) {
                      item.quantity -= 1;
                  } else {
                      cart = cart.filter(i => i.id !== item.id);
                  }
                  saveCart();
                  renderCart();
              });
          });
      }
  
      renderCart(); // initial load
  });
  
      // Fetch products from getProducts.php
      fetch('get_Products.php')
          .then(response => response.json())
          .then(products => {
              const productContainer = document.querySelector('.listProduct');
              products.forEach(product => {
                  const productDiv = document.createElement('div');
                  productDiv.classList.add('item');
                  productDiv.innerHTML = `
                      <img src="../admin_side/uploads/${product.image || 'default.png'}" alt="${product.name}">
                      <h2>${product.name}</h2>
                      <p class="price">$${product.price}</p>
                      <p class="quantity">$${product.quantity}</p>
                      <button onclick="addToCart(${product.id})">Add to Cart</button>
                  `;
                  productContainer.appendChild(productDiv);
              });
          })
          .catch(error => console.error('Error fetching products:', error));
  
          document.getElementById("searchInput").addEventListener("input", function () {
      const searchTerm = this.value;
  
      fetch('get_product.php?search=' + encodeURIComponent(searchTerm))
          .then(response => response.json())
          .then(products => {
              const productList = document.querySelector(".listProduct");
              productList.innerHTML = ""; // Clear current products
  
              if (products.length === 0) {
                  productList.innerHTML = "<p>No products found.</p>";
                  return;
              }
  
              products.forEach(product => {
                  const item = document.createElement("div");
                  item.className = "item";
                  item.innerHTML = `
                      <img src="${product.image}" alt="${product.name}">
                      <h2>${product.name}</h2>
                      <div class="price">₱${product.price}</div>
                      <button onclick="addToCart(${product.id})">Add to Cart</button>
                  `;
                  productList.appendChild(item);
              });
          })
          .catch(error => {
              console.error("Error fetching products:", error);
          });
  });
  
  
  const selectedCategory = this.getAttribute('data-category'); // Get the category
  
              // Show or hide products based on the selected category
              products.forEach(product => {
                  if (selectedCategory === 'all' || product.getAttribute('data-category') === selectedCategory) {
                      product.style.display = 'block';  // Show product
                  } else {
                      product.style.display = 'none';   // Hide product
                  }
              });
          
      
  
      // Optional: highlight the active category
      window.addEventListener('DOMContentLoaded', () => {
          const urlParams = new URLSearchParams(window.location.search);
          const currentCategory = urlParams.get('category');
          categoryItems.forEach(item => {
              if (item.getAttribute('data-category') === currentCategory) {
                  item.style.color = '#007BFF'; // or add a class
              }
          });
      });
     
// Modified checkout function in IPTcartjava2.js
function checkout() {
    const formData = {
        user_id: document.getElementById('user_id').value,
        address: document.getElementById('address').value,
        products: getSelectedProducts(), // Should return an array of product objects
        total_price: calculateTotalPrice() // Calculate the total price dynamically
    };

    fetch('processCheckout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Checkout Successful!');
            // Redirect to ORDERS.php, anchor to the Pending tab
            window.location.href = 'ORDERS.php#Pendin-btn';
        } else {
            alert('Checkout failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Checkout failed. Try again.');
    });
}

function getSelectedProducts() {
    // Implement this function to return an array of products selected in cart
    // e.g., [{id:1, name:'Product 1', price:100, quantity:2, image:'img1.jpg'}, ...]
    // This example is placeholder
    const products = [];
    // Collect product data from cart UI
    // ...
    return products;
}

function calculateTotalPrice() {
    // Implement this function to calculate total price of products in cart
    // This example returns fixed value as placeholder
    let total = 0;
    // sum prices * quantities
    // ...
    return total;
}

