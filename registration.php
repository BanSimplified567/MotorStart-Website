<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>KapeTann | Registration</title>

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="./assets/css/login.css">
  <link rel="icon" href="./assets/images/favicon.ico">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container {
      display: flex;
      max-width: 1200px;
      width: 100%;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      min-height: 700px;
    }

    /* Left side with coffee background */
    .left-section {
      flex: 1;
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                  url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }

    .brand-intro {
      max-width: 500px;
    }

    .brand-intro h2 {
      font-family: 'Poppins', sans-serif;
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 20px;
      line-height: 1.2;
    }

    .brand-intro p {
      font-size: 1.1rem;
      line-height: 1.6;
      opacity: 0.9;
      margin-bottom: 30px;
    }

    .features {
      margin-top: 40px;
    }

    .feature {
      display: flex;
      align-items: center;
      margin-bottom: 25px;
    }

    .feature-icon {
      background: rgba(255, 255, 255, 0.15);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      font-size: 1.2rem;
    }

    /* Right side with registration form */
    .right-section {
      flex: 1;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo {
      max-width: 180px;
      height: auto;
      margin-bottom: 10px;
    }

    .logo-text {
      font-family: 'Poppins', sans-serif;
      font-size: 1.8rem;
      font-weight: 600;
      color: #5d4037;
      letter-spacing: 1px;
    }

    .form-container {
      max-width: 450px;
      width: 100%;
      margin: 0 auto;
    }

    .form-header {
      text-align: center;
      margin-bottom: 35px;
    }

    .form-header h1 {
      font-family: 'Poppins', sans-serif;
      font-size: 2.2rem;
      color: #333;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .form-header p {
      color: #666;
      font-size: 1rem;
    }

    .form-group {
      position: relative;
      margin-bottom: 25px;
    }

    .form-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
      font-size: 1.1rem;
    }

    .form-input {
      width: 100%;
      padding: 16px 20px 16px 50px;
      border: 2px solid #e1e5eb;
      border-radius: 12px;
      font-size: 1rem;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      background-color: #f9fafc;
    }

    .form-input:focus {
      outline: none;
      border-color: #8b5a2b;
      background-color: white;
      box-shadow: 0 0 0 3px rgba(139, 90, 43, 0.1);
    }

    .form-input::placeholder {
      color: #aaa;
    }

    .submit-btn {
      width: 100%;
      padding: 17px;
      background: linear-gradient(to right, #8b5a2b, #6f4518);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 600;
      font-family: 'Poppins', sans-serif;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      letter-spacing: 0.5px;
    }

    .submit-btn:hover {
      background: linear-gradient(to right, #6f4518, #5a3712);
      transform: translateY(-2px);
      box-shadow: 0 7px 15px rgba(139, 90, 43, 0.2);
    }

    .submit-btn:active {
      transform: translateY(0);
    }

    .login-redirect {
      text-align: center;
      margin-top: 30px;
      color: #666;
      font-size: 0.95rem;
    }

    .login-redirect a {
      color: #8b5a2b;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s;
    }

    .login-redirect a:hover {
      color: #6f4518;
      text-decoration: underline;
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 30px 0;
      color: #999;
    }

    .divider::before, .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #e1e5eb;
    }

    .divider span {
      padding: 0 15px;
      font-size: 0.9rem;
    }

    /* Password strength indicator */
    .password-strength {
      height: 5px;
      border-radius: 3px;
      margin-top: 8px;
      background-color: #eee;
      overflow: hidden;
    }

    .strength-bar {
      height: 100%;
      width: 0%;
      border-radius: 3px;
      transition: width 0.3s, background-color 0.3s;
    }

    /* Responsive design */
    @media (max-width: 992px) {
      .container {
        flex-direction: column;
        max-width: 600px;
      }

      .left-section {
        padding: 40px 30px;
        text-align: center;
      }

      .brand-intro h2 {
        font-size: 2.2rem;
      }

      .feature {
        justify-content: center;
      }
    }

    @media (max-width: 576px) {
      .right-section {
        padding: 40px 25px;
      }

      .form-header h1 {
        font-size: 1.8rem;
      }

      .logo-text {
        font-size: 1.5rem;
      }
    }

    /* Animation for form */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-container {
      animation: fadeIn 0.6s ease-out;
    }

    /* Input validation styling */
    .form-input.error {
      border-color: #e74c3c;
      background-color: #fff9f9;
    }

    .form-input.success {
      border-color: #2ecc71;
    }

    .error-message {
      color: #e74c3c;
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Left Section: Brand Introduction -->
    <div class="left-section">
      <div class="brand-intro">
        <h2>Welcome to KapeTann</h2>
        <p>Join our community of coffee enthusiasts. Discover premium blends, share your coffee experiences, and connect with fellow connoisseurs. Your perfect cup awaits.</p>

        <div class="features">
          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-coffee"></i>
            </div>
            <div>
              <h3>Premium Selection</h3>
              <p>Access exclusive coffee blends from around the world</p>
            </div>
          </div>

          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-users"></i>
            </div>
            <div>
              <h3>Community</h3>
              <p>Connect with fellow coffee lovers and share experiences</p>
            </div>
          </div>

          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-percent"></i>
            </div>
            <div>
              <h3>Member Benefits</h3>
              <p>Enjoy discounts, early access, and special promotions</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Section: Registration Form -->
    <div class="right-section">
      <div class="logo-container">
        <img src="./assets/images/logo.png" class="logo" alt="KapeTann Logo">
        <div class="logo-text">KapeTann</div>
      </div>

      <div class="form-container">
        <div class="form-header">
          <h1>Create Account</h1>
          <p>Join our community and start your coffee journey</p>
        </div>

        <form class="form" method="post" id="registrationForm">
          <div class="form-group">
            <i class="fas fa-user form-icon"></i>
            <input type="text" name="name" class="form-input" placeholder="Full Name" required>
            <div class="error-message" id="nameError">Please enter a valid name</div>
          </div>

          <div class="form-group">
            <i class="fas fa-user-circle form-icon"></i>
            <input type="text" name="username" class="form-input" placeholder="Username" required>
            <div class="error-message" id="usernameError">Username must be at least 3 characters</div>
          </div>

          <div class="form-group">
            <i class="fas fa-envelope form-icon"></i>
            <input type="email" name="email" class="form-input" placeholder="Email Address" required>
            <div class="error-message" id="emailError">Please enter a valid email address</div>
          </div>

          <div class="form-group">
            <i class="fas fa-lock form-icon"></i>
            <input type="password" name="password" class="form-input" id="password" placeholder="Password" required>
            <div class="password-strength">
              <div class="strength-bar" id="strengthBar"></div>
            </div>
            <div class="error-message" id="passwordError">Password must be at least 8 characters</div>
          </div>

          <button type="submit" class="submit-btn">
            <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Create Account
          </button>
        </form>

        <div class="login-redirect">
          Already have an account? <a href="login.php">Sign in here</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('strengthBar');

    passwordInput.addEventListener('input', function() {
      const password = passwordInput.value;
      let strength = 0;

      // Check password length
      if (password.length >= 8) strength += 25;
      if (password.length >= 12) strength += 15;

      // Check for lowercase letters
      if (/[a-z]/.test(password)) strength += 15;

      // Check for uppercase letters
      if (/[A-Z]/.test(password)) strength += 15;

      // Check for numbers
      if (/[0-9]/.test(password)) strength += 15;

      // Check for special characters
      if (/[^A-Za-z0-9]/.test(password)) strength += 15;

      // Update strength bar
      strengthBar.style.width = strength + '%';

      // Change color based on strength
      if (strength < 40) {
        strengthBar.style.backgroundColor = '#e74c3c';
      } else if (strength < 70) {
        strengthBar.style.backgroundColor = '#f39c12';
      } else {
        strengthBar.style.backgroundColor = '#2ecc71';
      }
    });

    // Form validation
    const form = document.getElementById('registrationForm');
    const nameInput = form.querySelector('input[name="name"]');
    const usernameInput = form.querySelector('input[name="username"]');
    const emailInput = form.querySelector('input[name="email"]');

    // Real-time validation
    nameInput.addEventListener('blur', function() {
      if (nameInput.value.trim().length < 2) {
        showError(nameInput, 'nameError', 'Name must be at least 2 characters');
      } else {
        clearError(nameInput, 'nameError');
      }
    });

    usernameInput.addEventListener('blur', function() {
      const username = usernameInput.value.trim();
      if (username.length < 3) {
        showError(usernameInput, 'usernameError', 'Username must be at least 3 characters');
      } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
        showError(usernameInput, 'usernameError', 'Username can only contain letters, numbers, and underscores');
      } else {
        clearError(usernameInput, 'usernameError');
      }
    });

    emailInput.addEventListener('blur', function() {
      const email = emailInput.value.trim();
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailPattern.test(email)) {
        showError(emailInput, 'emailError', 'Please enter a valid email address');
      } else {
        clearError(emailInput, 'emailError');
      }
    });

    passwordInput.addEventListener('blur', function() {
      if (passwordInput.value.length < 8) {
        showError(passwordInput, 'passwordError', 'Password must be at least 8 characters');
      } else {
        clearError(passwordInput, 'passwordError');
      }
    });

    function showError(input, errorId, message) {
      input.classList.add('error');
      input.classList.remove('success');
      const errorElement = document.getElementById(errorId);
      errorElement.textContent = message;
      errorElement.style.display = 'block';
    }

    function clearError(input, errorId) {
      input.classList.remove('error');
      input.classList.add('success');
      document.getElementById(errorId).style.display = 'none';
    }

    // Form submission
    form.addEventListener('submit', function(e) {
      let valid = true;

      // Validate all fields
      if (nameInput.value.trim().length < 2) {
        showError(nameInput, 'nameError', 'Name must be at least 2 characters');
        valid = false;
      }

      if (usernameInput.value.trim().length < 3) {
        showError(usernameInput, 'usernameError', 'Username must be at least 3 characters');
        valid = false;
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(emailInput.value.trim())) {
        showError(emailInput, 'emailError', 'Please enter a valid email address');
        valid = false;
      }

      if (passwordInput.value.length < 8) {
        showError(passwordInput, 'passwordError', 'Password must be at least 8 characters');
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
        return false;
      }

      // Show loading state
      const submitBtn = form.querySelector('.submit-btn');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
      submitBtn.disabled = true;

      // Form will submit normally after validation
    });
  </script>
</body>

</html>
