<?php
include("auth_session.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - MotorStart Shop</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to bottom, #020111 10%, #3a3a52 100%);
      color: #ffffff;
      font-family: 'Orbitron', sans-serif;
      position: relative;
      min-height: 100vh;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><circle cx="10" cy="10" r="1" fill="white"/><circle cx="60" cy="20" r="1" fill="white"/><circle cx="30" cy="70" r="1" fill="white"/><circle cx="80" cy="50" r="1" fill="white"/><circle cx="40" cy="40" r="1" fill="white"/></svg>') repeat;
      opacity: 0.3;
      z-index: -1;
    }

    .header {
      background: rgba(0, 0, 0, 0.8);
      border-bottom: 2px solid #00ff00;
    }

    .header a,
    .header .logo {
      color: #ffffff;
    }

    .header .logo i {
      color: #ff00ff;
    }

    .heading {
      color: #00ff00;
      text-shadow: 0 0 15px #ff00ff;
    }

    .card {
      background: rgba(0, 0, 0, 0.7);
      border: 1px solid #00ff00;
      box-shadow: 0 0 20px rgba(0, 255, 0, 0.3);
    }

    .form-control,
    .form-select {
      background: rgba(0, 0, 0, 0.5);
      border: 1px solid #ff00ff;
      color: #ffffff;
    }

    strong,
    span,
    label,
    #checkout-subtotal {
      color: #fff;
    }

    .form-control:focus {
      border-color: #00ff00;
      box-shadow: 0 0 10px #00ff00;
    }

    .btn-primary {
      background: #ff00ff;
      border: none;
      color: #000;
    }

    .btn-primary:hover {
      background: #00ff00;
      box-shadow: 0 0 15px #00ff00;
    }

    .cart-item {
      display: flex;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid #444;
      color: #fff;
    }

    .cart-item img {
      width: 80px;
      margin-right: 15px;
    }

    .total-price {
      font-size: 1.5rem;
      color: #ff00ff;
      text-shadow: 0 0 10px #ff00ff;
    }

    footer {
      background: #000;
      border-top: 1px solid #00ff00;
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <!-- HEADER -->
  <header class="header py-3">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="index.php" class="logo">
        <i class="fa-solid fa-motorcycle fa-2x"></i>
        <h3 class="d-inline ms-2">MotorStart</h3>
      </a>
      <a href="index.php" class="text-decoration-none text-white">← Back to Shop</a>
    </div>
  </header>

  <div class="container my-5">
    <h1 class="heading text-center mb-5">Checkout</h1>

    <div class="row">
      <!-- Order Summary -->
      <div class="col-lg-5 mb-4">
        <div class="card p-4">
          <h3 class="mb-4 text-center" style="color: #ff00ff;">Order Summary</h3>
          <div id="checkout-cart-content">
            <!-- Cart items will be injected here via JS -->
          </div>
          <hr style="border-color: #00ff00;">
          <div class="d-flex justify-content-between">
            <strong>Subtotal</strong>
            <span id="checkout-subtotal">₱0</span>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <strong>Shipping</strong>
            <span>₱500 (Flat Rate)</span>
          </div>
          <div class="d-flex justify-content-between mt-2">
            <strong>Tax (12% VAT)</strong>
            <span id="checkout-tax">₱0</span>
          </div>
          <hr style="border-color: #ff00ff;">
          <div class="d-flex justify-content-between total-price">
            <strong>Total</strong>
            <strong id="checkout-total">₱0</strong>
          </div>
        </div>
      </div>

      <!-- Checkout Form -->
      <div class="col-lg-7">
        <div class="card p-4">
          <h3 class="mb-4 text-center" style="color: #ff00ff;">Billing & Shipping Information</h3>
          <form id="checkout-form">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" class="form-control" required>
              </div>
            </div>

            <div class="mb-3">
              <label>Email</label>
              <input type="email" class="form-control" value="<?php echo $_SESSION['username']; ?>" required>
            </div>

            <div class="mb-3">
              <label>Phone</label>
              <input type="tel" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Address</label>
              <input type="text" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>City</label>
                <input type="text" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Province</label>
                <input type="text" class="form-control" required>
              </div>
            </div>

            <div class="mb-4">
              <label>Payment Method</label>
              <select class="form-select" required>
                <option value="">Select Payment</option>
                <option>Cash on Delivery</option>
                <option>Bank Transfer</option>
                <option>GCash</option>
                <option>Credit/Debit Card (Coming Soon)</option>
              </select>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-lg px-5">Place Order</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="py-4 text-center">
    <p>&copy; 2025 MotorStart Shop. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Load cart from localStorage
    function loadCheckoutCart() {
      let cartContent = document.getElementById('checkout-cart-content');
      let subtotalEl = document.getElementById('checkout-subtotal');
      let taxEl = document.getElementById('checkout-tax');
      let totalEl = document.getElementById('checkout-total');

      let cart = JSON.parse(localStorage.getItem('motorCart') || '[]');

      if (cart.length === 0) {
        cartContent.innerHTML = '<p class="text-center">Your cart is empty.</p>';
        subtotalEl.innerText = '₱0';
        taxEl.innerText = '₱0';
        totalEl.innerText = '₱0';
        return;
      }

      let subtotal = 0;
      cart.forEach(item => {
        subtotal += item.price;

        let div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `
          <img src="${item.img}" alt="${item.title}">
          <div>
            <strong>${item.title}</strong><br>
            <small>₱${item.price.toLocaleString()}</small>
          </div>
        `;
        cartContent.appendChild(div);
      });

      let shipping = 500;
      let tax = subtotal * 0.12;
      let total = subtotal + shipping + tax;

      subtotalEl.innerText = '₱' + subtotal.toLocaleString();
      taxEl.innerText = '₱' + tax.toFixed(0).toLocaleString();
      totalEl.innerText = '₱' + total.toFixed(0).toLocaleString();
    }

    // Simple form submission alert (replace with real processing later)
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Order placed successfully! (Demo - no real processing)');
      localStorage.removeItem('motorCart'); // Clear cart
      window.location.href = 'index.php';
    });

    loadCheckoutCart();
  </script>
</body>

</html>
