<?php
// Start session at the very beginning
session_start();

// Include database connection
require_once 'db.php';

// Check if database connection exists
if (!isset($con)) {
  die("Database connection failed. Please check your db.php file.");
}

// Check if we can connect to database
if (!$con) {
  die("Database connection error: " . mysqli_connect_error());
}

// Registration form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Initialize errors array
  $errors = [];

  // Get form data with proper validation
  $name = isset($_POST['name']) ? mysqli_real_escape_string($con, trim($_POST['name'])) : '';
  $username = isset($_POST['username']) ? mysqli_real_escape_string($con, trim($_POST['username'])) : '';
  $email = isset($_POST['email']) ? mysqli_real_escape_string($con, trim($_POST['email'])) : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
  $terms = isset($_POST['terms']) ? $_POST['terms'] : '';

  // Debug: Log received data (remove in production)
  error_log("Registration attempt: name=$name, username=$username, email=$email");

  // Validate inputs
  if (empty($name) || strlen($name) < 2) {
    $errors[] = "Name must be at least 2 characters";
  }

  if (empty($username) || strlen($username) < 3) {
    $errors[] = "Username must be at least 3 characters";
  } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    $errors[] = "Username can only contain letters, numbers, and underscores";
  } else {
    // Check if username exists
    $checkUserQuery = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($con, $checkUserQuery);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $checkUser = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($checkUser) > 0) {
      $errors[] = "Username already taken";
    }
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
  } else {
    // Check if email exists
    $checkEmailQuery = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $checkEmailQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $checkEmail = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($checkEmail) > 0) {
      $errors[] = "Email already registered";
    }
  }

  if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters";
  }

  if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match";
  }

  if (empty($terms) || $terms !== 'on') {
    $errors[] = "You must accept the terms and conditions";
  }

  // If no errors, create account
  if (empty($errors)) {
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user using prepared statement
    $query = "INSERT INTO users (name, username, email, password, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $email, $hashedPassword);

      if (mysqli_stmt_execute($stmt)) {
        // Get the new user ID
        $userId = mysqli_insert_id($con);

        // Set session
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $userId;
        $_SESSION['name'] = $name;
        $_SESSION['registered'] = true;

        // Redirect to dashboard
        header("Location: index.php");
        exit;
      } else {
        $error = "Registration failed: " . mysqli_error($con);
        error_log("Registration SQL error: " . mysqli_error($con));
      }

      mysqli_stmt_close($stmt);
    } else {
      $error = "Database error: " . mysqli_error($con);
      error_log("Prepare statement failed: " . mysqli_error($con));
    }
  } else {
    $error = implode("<br>", $errors);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>MotorShop | Registration</title>

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      position: relative;
      overflow-x: hidden;
    }

    /* Background pattern */
    .background-pattern {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image:
        radial-gradient(circle at 25% 25%, rgba(255, 69, 0, 0.1) 2px, transparent 2px),
        radial-gradient(circle at 75% 75%, rgba(255, 140, 0, 0.1) 2px, transparent 2px);
      background-size: 60px 60px;
      z-index: -1;
    }

    .container {
      display: flex;
      max-width: 1200px;
      width: 100%;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      overflow: hidden;
      box-shadow:
        0 20px 40px rgba(0, 0, 0, 0.3),
        0 0 0 1px rgba(255, 69, 0, 0.1);
      min-height: 700px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Left side with automotive background */
    .left-section {
      flex: 1;
      background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)),
        url('https://images.unsplash.com/photo-1549399542-7e3f8b79c341?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .left-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 69, 0, 0.1), transparent);
      z-index: 1;
    }

    .brand-intro {
      max-width: 500px;
      position: relative;
      z-index: 2;
    }

    .brand-intro h2 {
      font-family: 'Poppins', sans-serif;
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 20px;
      line-height: 1.2;
      background: linear-gradient(to right, #ff4500, #ff8c00);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-shadow: 0 2px 10px rgba(255, 69, 0, 0.3);
    }

    .brand-intro p {
      font-size: 1.1rem;
      line-height: 1.6;
      opacity: 0.9;
      margin-bottom: 30px;
      color: #e0e0e0;
    }

    .features {
      margin-top: 40px;
    }

    .feature {
      display: flex;
      align-items: center;
      margin-bottom: 25px;
      background: rgba(255, 255, 255, 0.05);
      padding: 20px;
      border-radius: 15px;
      border-left: 4px solid #ff4500;
      transition: transform 0.3s ease, background 0.3s ease;
    }

    .feature:hover {
      transform: translateX(10px);
      background: rgba(255, 69, 0, 0.1);
    }

    .feature-icon {
      background: linear-gradient(135deg, #ff4500, #ff8c00);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      font-size: 1.2rem;
      color: white;
      box-shadow: 0 5px 15px rgba(255, 69, 0, 0.3);
    }

    .feature h3 {
      font-family: 'Poppins', sans-serif;
      font-size: 1.2rem;
      color: white;
      margin-bottom: 5px;
    }

    .feature p {
      font-size: 0.9rem;
      opacity: 0.8;
      margin: 0;
    }

    /* Right side with registration form */
    .right-section {
      flex: 1;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: white;
      position: relative;
    }

    .right-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, #ff4500, #ff8c00);
    }

    .logo-container {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo {
      max-width: 180px;
      height: auto;
      margin-bottom: 15px;
      filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
      border-radius: 10px;
    }

    .logo-text {
      font-family: 'Poppins', sans-serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: #333;
      letter-spacing: 1px;
      text-transform: uppercase;
      background: linear-gradient(to right, #ff4500, #ff8c00);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .tagline {
      color: #666;
      font-size: 0.9rem;
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-top: 5px;
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
      color: #ff4500;
      font-size: 1.1rem;
    }

    .form-input {
      width: 100%;
      padding: 16px 20px 16px 50px;
      border: 2px solid #e1e5eb;
      border-radius: 12px;
      font-size: 1rem;
      font-family: 'Montserrat', sans-serif;
      transition: all 0.3s ease;
      background-color: #f9fafc;
    }

    .form-input:focus {
      outline: none;
      border-color: #ff4500;
      background-color: white;
      box-shadow: 0 0 0 3px rgba(255, 69, 0, 0.1);
    }

    .form-input::placeholder {
      color: #aaa;
    }

    /* Password toggle */
    .password-toggle {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #ff4500;
      cursor: pointer;
      font-size: 1.1rem;
      opacity: 0.7;
      transition: opacity 0.3s;
      z-index: 2;
    }

    .password-toggle:hover {
      opacity: 1;
    }

    /* Submit button */
    .submit-btn {
      width: 100%;
      padding: 17px;
      background: linear-gradient(to right, #ff4500, #ff8c00);
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
      position: relative;
      overflow: hidden;
    }

    .submit-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .submit-btn:hover::before {
      left: 100%;
    }

    .submit-btn:hover {
      background: linear-gradient(to right, #ff8c00, #ff4500);
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(255, 69, 0, 0.3);
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
      color: #ff4500;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s ease;
      padding: 2px 5px;
      border-radius: 4px;
    }

    .login-redirect a:hover {
      color: #ff8c00;
      background: rgba(255, 69, 0, 0.1);
      text-decoration: none;
    }

    /* Password strength indicator */
    .password-strength {
      height: 5px;
      border-radius: 3px;
      margin-top: 8px;
      background-color: #eee;
      overflow: hidden;
      position: relative;
    }

    .strength-bar {
      height: 100%;
      width: 0%;
      border-radius: 3px;
      transition: width 0.3s, background-color 0.3s;
    }

    .strength-text {
      font-size: 0.8rem;
      margin-top: 5px;
      text-align: right;
      color: #666;
      transition: color 0.3s;
    }

    /* Error message styling */
    .error-message {
      background: linear-gradient(135deg, #fff5f5, #ffeaea);
      color: #e74c3c;
      padding: 15px 20px;
      border-radius: 12px;
      margin-bottom: 25px;
      text-align: center;
      border-left: 4px solid #e74c3c;
      animation: fadeIn 0.5s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .error-message i {
      font-size: 1.2rem;
    }

    /* Success message */
    .success-message {
      background: linear-gradient(135deg, #f0fff4, #e6fffa);
      color: #2ecc71;
      padding: 15px 20px;
      border-radius: 12px;
      margin-bottom: 25px;
      text-align: center;
      border-left: 4px solid #2ecc71;
      animation: fadeIn 0.5s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    /* Field error messages */
    .field-error {
      color: #e74c3c;
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
      padding-left: 5px;
    }

    /* Input validation styling */
    .form-input.error {
      border-color: #e74c3c;
      background-color: #fff9f9;
    }

    .form-input.success {
      border-color: #2ecc71;
      background-color: #f9fff9;
    }

    /* Animation for form */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-container {
      animation: fadeIn 0.6s ease-out;
    }

    /* Loading animation */
    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255, 255, 255, .3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 1s ease-in-out infinite;
      margin-right: 10px;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* Terms checkbox */
    .terms-checkbox {
      display: flex;
      align-items: flex-start;
      margin: 20px 0;
      padding: 15px;
      background: #f9fafc;
      border-radius: 10px;
      border: 1px solid #e1e5eb;
    }

    .terms-checkbox input {
      margin-top: 3px;
      margin-right: 12px;
      accent-color: #ff4500;
      width: 18px;
      height: 18px;
      cursor: pointer;
      flex-shrink: 0;
    }

    .terms-checkbox label {
      color: #666;
      font-size: 0.9rem;
      line-height: 1.5;
      cursor: pointer;
    }

    .terms-checkbox a {
      color: #ff4500;
      text-decoration: none;
      font-weight: 600;
    }

    .terms-checkbox a:hover {
      text-decoration: underline;
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
        font-size: 2.5rem;
      }

      .feature {
        justify-content: center;
      }

      .right-section {
        padding: 40px 30px;
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
        font-size: 1.8rem;
      }

      .form-group {
        margin-bottom: 20px;
      }
    }

    /* Modal styling */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      z-index: 1000;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .modal-content {
      background: white;
      padding: 40px;
      border-radius: 20px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      animation: modalFade 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .modal-content::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, #ff4500, #ff8c00);
    }

    @keyframes modalFade {
      from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
      }

      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    .modal-header {
      margin-bottom: 20px;
      text-align: center;
    }

    .modal-header h2 {
      font-family: 'Poppins', sans-serif;
      font-size: 1.8rem;
      color: #333;
      font-weight: 600;
      background: linear-gradient(to right, #ff4500, #ff8c00);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .modal-body {
      margin-bottom: 30px;
      max-height: 400px;
      overflow-y: auto;
      padding: 10px;
    }

    .modal-body p {
      color: #666;
      margin-bottom: 15px;
      line-height: 1.6;
    }

    .modal-actions {
      display: flex;
      gap: 15px;
    }

    .modal-actions button {
      flex: 1;
      padding: 14px;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: 'Montserrat', sans-serif;
      border: none;
    }

    .modal-actions .btn-primary {
      background: linear-gradient(to right, #ff4500, #ff8c00);
      color: white;
    }

    .modal-actions .btn-primary:hover {
      background: linear-gradient(to right, #ff8c00, #ff4500);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 69, 0, 0.3);
    }
  </style>
</head>

<body>
  <div class="background-pattern"></div>

  <div class="container">
    <!-- Left Section: Brand Introduction -->
    <div class="left-section">
      <i class="fas fa-cog gear-icon"></i>
      <i class="fas fa-cog gear-icon"></i>

      <div class="brand-intro">
        <h2>Join MotorShop</h2>
        <p>Become part of the ultimate automotive community. Access premium vehicle listings, connect with car enthusiasts, and unlock exclusive member benefits.</p>

        <div class="features">
          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-car"></i>
            </div>
            <div>
              <h3>Premium Access</h3>
              <p>Browse exclusive luxury and performance vehicles</p>
            </div>
          </div>

          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-tachometer-alt"></i>
            </div>
            <div>
              <h3>Market Insights</h3>
              <p>Get real-time pricing and market analytics</p>
            </div>
          </div>

          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-users"></i>
            </div>
            <div>
              <h3>Community</h3>
              <p>Connect with automotive experts and enthusiasts</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Section: Registration Form -->
    <div class="right-section">
      <div class="logo-container">
        <img src="./assets/image/MotorLogo.jpg" class="logo" alt="MotorShop Logo">
        <div class="logo-text">MotorShop</div>
        <div class="tagline">Accelerate Your Journey</div>
      </div>

      <div class="form-container">
        <div class="form-header">
          <h1>Create Account</h1>
          <p>Join our automotive community and start your journey</p>
        </div>

        <!-- Error message -->
        <?php if (isset($error)): ?>
          <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            <span><?php echo $error; ?></span>
          </div>
        <?php endif; ?>

        <!-- Success message -->
        <?php if (isset($_GET['registered']) && $_GET['registered'] == 'success'): ?>
          <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <span>Registration successful! Please login.</span>
          </div>
        <?php endif; ?>

        <form class="form" method="post" id="registrationForm">
          <div class="form-group">
            <i class="fas fa-user form-icon"></i>
            <input type="text" name="name" class="form-input" placeholder="Full Name" required
              value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            <div class="field-error" id="nameError">Please enter a valid name (at least 2 characters)</div>
          </div>

          <div class="form-group">
            <i class="fas fa-user-circle form-icon"></i>
            <input type="text" name="username" class="form-input" placeholder="Username" required
              value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            <div class="field-error" id="usernameError">Username must be 3-20 characters (letters, numbers, underscores only)</div>
          </div>

          <div class="form-group">
            <i class="fas fa-envelope form-icon"></i>
            <input type="email" name="email" class="form-input" placeholder="Email Address" required
              value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <div class="field-error" id="emailError">Please enter a valid email address</div>
          </div>

          <div class="form-group">
            <i class="fas fa-lock form-icon"></i>
            <input type="password" name="password" class="form-input" id="password" placeholder="Password" required>
            <button type="button" class="password-toggle" id="togglePassword">
              <i class="fas fa-eye"></i>
            </button>
            <div class="password-strength">
              <div class="strength-bar" id="strengthBar"></div>
            </div>
            <div class="strength-text" id="strengthText">Password strength</div>
            <div class="field-error" id="passwordError">Password must be at least 8 characters with uppercase, lowercase, and numbers</div>
          </div>

          <div class="form-group">
            <i class="fas fa-lock form-icon"></i>
            <input type="password" name="confirm_password" class="form-input" id="confirmPassword" placeholder="Confirm Password" required>
            <button type="button" class="password-toggle" id="toggleConfirmPassword">
              <i class="fas fa-eye"></i>
            </button>
            <div class="field-error" id="confirmPasswordError">Passwords do not match</div>
          </div>

          <div class="terms-checkbox">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">
              I agree to the <a href="#" onclick="openTermsModal(event)">Terms of Service</a> and <a href="#" onclick="openPrivacyModal(event)">Privacy Policy</a>. I understand that my data will be processed in accordance with MotorShop's policies.
            </label>
            <div class="field-error" id="termsError">You must accept the terms and conditions</div>
          </div>

          <button type="submit" class="submit-btn" id="submitBtn">
            <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Create Account
          </button>
        </form>

        <div class="login-redirect">
          Already have an account? <a href="login.php">Sign in here</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Terms Modal -->
  <div class="modal" id="termsModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Terms of Service</h2>
      </div>
      <div class="modal-body">
        <h3>Welcome to MotorShop</h3>
        <p>By creating an account, you agree to the following terms and conditions:</p>

        <h4>1. Account Registration</h4>
        <p>You must provide accurate and complete information during registration. You are responsible for maintaining the confidentiality of your account credentials.</p>

        <h4>2. User Conduct</h4>
        <p>Users agree to use MotorShop for lawful purposes only and not to engage in any activity that may harm the platform or other users.</p>

        <h4>3. Content Ownership</h4>
        <p>All vehicle listings and content remain the property of their respective owners. MotorShop acts as a platform for connecting buyers and sellers.</p>

        <h4>4. Privacy</h4>
        <p>Your personal information will be handled in accordance with our Privacy Policy. We do not sell your data to third parties.</p>

        <h4>5. Termination</h4>
        <p>We reserve the right to terminate accounts that violate our terms of service.</p>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-primary" onclick="closeTermsModal()">Close</button>
      </div>
    </div>
  </div>

  <script>
    // Password strength indicator
    const passwordInputs = document.getElementById('password');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    passwordInputs.addEventListener('input', function() {
      const password = passwordInputs.value;
      let strength = 0;
      let message = 'Password strength';

      // Check password length
      if (password.length >= 8) strength += 20;
      if (password.length >= 12) strength += 10;

      // Check for lowercase letters
      if (/[a-z]/.test(password)) strength += 20;

      // Check for uppercase letters
      if (/[A-Z]/.test(password)) strength += 20;

      // Check for numbers
      if (/[0-9]/.test(password)) strength += 15;

      // Check for special characters
      if (/[^A-Za-z0-9]/.test(password)) strength += 15;

      // Update strength bar
      strengthBar.style.width = strength + '%';

      // Update message and color
      if (password.length === 0) {
        message = 'Enter a password';
        strengthBar.style.backgroundColor = '#eee';
      } else if (strength < 40) {
        message = 'Weak';
        strengthBar.style.backgroundColor = '#e74c3c';
      } else if (strength < 70) {
        message = 'Fair';
        strengthBar.style.backgroundColor = '#f39c12';
      } else if (strength < 90) {
        message = 'Good';
        strengthBar.style.backgroundColor = '#3498db';
      } else {
        message = 'Strong';
        strengthBar.style.backgroundColor = '#2ecc71';
      }

      strengthText.textContent = message;
      strengthText.style.color = strengthBar.style.backgroundColor;
    });

    // Password toggle functionality
    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordInputs = document.getElementById('password');
      const icon = this.querySelector('i');

      if (passwordInputs.type === 'password') {
        passwordInputs.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordInputs.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
      const confirmPassword = document.getElementById('confirmPassword');
      const icon = this.querySelector('i');

      if (confirmPassword.type === 'password') {
        confirmPassword.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        confirmPassword.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

    // Form validation
    const form = document.getElementById('registrationForm');
    const nameInput = form.querySelector('input[name="name"]');
    const usernameInput = form.querySelector('input[name="username"]');
    const emailInput = form.querySelector('input[name="email"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmPasswordInput = form.querySelector('input[name="confirm_password"]');
    const termsCheckbox = document.getElementById('terms');

    // Real-time validation
    nameInput.addEventListener('blur', validateName);
    usernameInput.addEventListener('blur', validateUsername);
    emailInput.addEventListener('blur', validateEmail);
    passwordInput.addEventListener('blur', validatePassword);
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);
    termsCheckbox.addEventListener('change', validateTerms);

    function validateName() {
      const name = nameInput.value.trim();
      if (name.length < 2) {
        showError(nameInput, 'nameError', 'Name must be at least 2 characters');
        return false;
      } else {
        clearError(nameInput, 'nameError');
        return true;
      }
    }

    function validateUsername() {
      const username = usernameInput.value.trim();
      const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;

      if (!usernameRegex.test(username)) {
        showError(usernameInput, 'usernameError', 'Username must be 3-20 characters (letters, numbers, underscores only)');
        return false;
      } else {
        clearError(usernameInput, 'usernameError');
        return true;
      }
    }

    function validateEmail() {
      const email = emailInput.value.trim();
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailPattern.test(email)) {
        showError(emailInput, 'emailError', 'Please enter a valid email address');
        return false;
      } else {
        clearError(emailInput, 'emailError');
        return true;
      }
    }

    function validatePassword() {
      const password = passwordInput.value;
      const hasMinLength = password.length >= 8;
      const hasUpperCase = /[A-Z]/.test(password);
      const hasLowerCase = /[a-z]/.test(password);
      const hasNumbers = /\d/.test(password);

      if (!hasMinLength || !hasUpperCase || !hasLowerCase || !hasNumbers) {
        showError(passwordInput, 'passwordError', 'Password must be at least 8 characters with uppercase, lowercase, and numbers');
        return false;
      } else {
        clearError(passwordInput, 'passwordError');
        return true;
      }
    }

    function validateConfirmPassword() {
      const password = passwordInput.value;
      const confirmPassword = confirmPasswordInput.value;

      if (password !== confirmPassword) {
        showError(confirmPasswordInput, 'confirmPasswordError', 'Passwords do not match');
        return false;
      } else {
        clearError(confirmPasswordInput, 'confirmPasswordError');
        return true;
      }
    }

    function validateTerms() {
      if (!termsCheckbox.checked) {
        document.getElementById('termsError').style.display = 'block';
        return false;
      } else {
        document.getElementById('termsError').style.display = 'none';
        return true;
      }
    }

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
      let isValid = true;

      // Validate all fields
      if (!validateName()) isValid = false;
      if (!validateUsername()) isValid = false;
      if (!validateEmail()) isValid = false;
      if (!validatePassword()) isValid = false;
      if (!validateConfirmPassword()) isValid = false;
      if (!validateTerms()) isValid = false;

      if (!isValid) {
        e.preventDefault();
        // Scroll to first error
        const firstError = form.querySelector('.error');
        if (firstError) {
          firstError.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
          firstError.focus();
        }
        return false;
      }

      // Show loading state
      const submitBtn = document.getElementById('submitBtn');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span class="loading"></span> Creating Account...';
      submitBtn.disabled = true;

      // Allow form submission
      return true;
    });

    // Modal functions
    function openTermsModal(e) {
      e.preventDefault();
      document.getElementById('termsModal').style.display = 'flex';
    }

    function closeTermsModal() {
      document.getElementById('termsModal').style.display = 'none';
    }

    function openPrivacyModal(e) {
      e.preventDefault();
      alert('Privacy Policy: We respect your privacy and will handle your personal information in accordance with our privacy policy. We do not share your personal data with third parties without your consent.');
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
      const termsModal = document.getElementById('termsModal');
      if (e.target === termsModal) {
        closeTermsModal();
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        const termsModal = document.getElementById('termsModal');
        if (termsModal.style.display === 'flex') {
          closeTermsModal();
        }
      }
    });

    // Auto-focus first field
    document.addEventListener('DOMContentLoaded', function() {
      const errorMessage = document.querySelector('.error-message');
      if (errorMessage) {
        setTimeout(() => {
          errorMessage.style.opacity = '0.7';
          errorMessage.style.transition = 'opacity 0.5s ease';
        }, 5000);
      }

      // Focus name field if empty
      if (!nameInput.value.trim()) {
        nameInput.focus();
      }
    });

    // Initialize password strength display
    passwordInput.dispatchEvent(new Event('input'));
  </script>
</body>

</html>
