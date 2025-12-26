<?php
session_start();
require_once 'db.php';

// When form submitted, check and create user session.
if (isset($_POST['username'])) {
  $username = stripslashes($_REQUEST['username']);
  $username = mysqli_real_escape_string($con, $username);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($con, $password);

  // Using prepared statements to prevent SQL injection
  $query = "SELECT * FROM `users` WHERE username = ?";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($result)) {
    // Verify password using password_verify (assuming passwords are hashed with password_hash())
    if (password_verify($password, $row['password'])) {
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['name'] = $row['name'];

      // Set remember me cookie if checked
      if (isset($_POST['remember'])) {
        $token = bin2hex(random_bytes(32));
        setcookie('remember_token', $token, time() + 60 * 60 * 24 * 30, '/'); // 30 days
        // Update token in database
        $updateQuery = "UPDATE users SET remember_token = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "si", $token, $row['id']);
        mysqli_stmt_execute($updateStmt);
      }

      header("Location: index.php");
      exit;
    } else {
      $error = "Incorrect username or password.";
    }
  } else {
    $error = "Incorrect username or password.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>MotorShop | Login</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

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
        url('https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
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

    /* Right side with login form */
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

    /* Form options */
    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .remember-me {
      display: flex;
      align-items: center;
    }

    .remember-me input {
      margin-right: 8px;
      accent-color: #ff4500;
      width: 18px;
      height: 18px;
      cursor: pointer;
    }

    .remember-me label {
      color: #666;
      font-size: 0.95rem;
      cursor: pointer;
    }

    .forgot-password {
      color: #ff4500;
      text-decoration: none;
      font-size: 0.95rem;
      font-weight: 600;
      transition: all 0.3s ease;
      padding: 5px 10px;
      border-radius: 6px;
    }

    .forgot-password:hover {
      color: #ff8c00;
      background: rgba(255, 69, 0, 0.1);
      text-decoration: none;
    }

    /* Login button */
    .login-button {
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

    .login-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .login-button:hover::before {
      left: 100%;
    }

    .login-button:hover {
      background: linear-gradient(to right, #ff8c00, #ff4500);
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(255, 69, 0, 0.3);
    }

    .login-button:active {
      transform: translateY(0);
    }

    /* Divider */
    .divider {
      display: flex;
      align-items: center;
      margin: 30px 0;
      color: #999;
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #e1e5eb;
    }

    .divider span {
      padding: 0 15px;
      font-size: 0.9rem;
    }

    /* Social buttons */
    .social-buttons {
      display: flex;
      gap: 15px;
      margin-bottom: 25px;
    }

    .social-button {
      flex: 1;
      padding: 16px;
      background: white;
      color: #555;
      border: 2px solid #e1e5eb;
      border-radius: 12px;
      font-size: 0.95rem;
      font-weight: 500;
      font-family: 'Montserrat', sans-serif;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .social-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .social-button.google {
      border-color: #e1e5eb;
    }

    .social-button.google:hover {
      border-color: #db4437;
      background: #fff9f9;
    }

    .social-button.facebook {
      border-color: #e1e5eb;
    }

    .social-button.facebook:hover {
      border-color: #4267B2;
      background: #f5f9ff;
    }

    .social-icon {
      margin-right: 12px;
      font-size: 1.2rem;
    }

    .google-icon {
      color: #db4437;
    }

    .facebook-icon {
      color: #4267B2;
    }

    /* Register link */
    .register-link {
      text-align: center;
      margin-top: 30px;
      color: #666;
      font-size: 0.95rem;
    }

    .register-link a {
      color: #ff4500;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.3s ease;
      padding: 2px 5px;
      border-radius: 4px;
    }

    .register-link a:hover {
      color: #ff8c00;
      background: rgba(255, 69, 0, 0.1);
      text-decoration: none;
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

    /* Input validation styling */
    .form-input.error {
      border-color: #e74c3c;
      background-color: #fff9f9;
    }

    .form-input.success {
      border-color: #2ecc71;
      background-color: #f9fff9;
    }

    .field-error {
      color: #e74c3c;
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
      padding-left: 5px;
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

    /* Modal for forgot password */
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
      max-width: 450px;
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
    }

    .modal-body p {
      color: #666;
      margin-bottom: 20px;
      text-align: center;
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

    .modal-actions .btn-secondary {
      background: #f8f9fa;
      color: #666;
      border: 2px solid #e1e5eb;
    }

    .modal-actions .btn-primary:hover {
      background: linear-gradient(to right, #ff8c00, #ff4500);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 69, 0, 0.3);
    }

    .modal-actions .btn-secondary:hover {
      background: #e9ecef;
      transform: translateY(-2px);
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

      .social-buttons {
        flex-direction: column;
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

      .form-options {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .modal-content {
        padding: 30px 25px;
      }

      .modal-actions {
        flex-direction: column;
      }

      .social-button span {
        display: none;
      }

      .social-button .social-icon {
        margin-right: 0;
        font-size: 1.4rem;
      }
    }

    /* Decorative elements */
    .gear-icon {
      position: absolute;
      font-size: 3rem;
      color: rgba(255, 69, 0, 0.1);
      animation: spin 20s linear infinite;
    }

    .gear-icon:nth-child(1) {
      top: 20px;
      right: 20px;
    }

    .gear-icon:nth-child(2) {
      bottom: 20px;
      left: 20px;
      animation-direction: reverse;
    }
  </style>
</head>

<body>
  <div class="background-pattern"></div>

  <div class="container">
    <!-- Left side: Brand showcase -->
    <div class="left-section">
      <i class="fas fa-cog gear-icon"></i>
      <i class="fas fa-cog gear-icon"></i>

      <div class="brand-intro">
        <h2>MotorShop Pro</h2>
        <p>Your premier destination for automotive excellence. Access premium inventory, connect with car enthusiasts, and accelerate your automotive business with cutting-edge tools.</p>

        <div class="features">
          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-car"></i>
            </div>
            <div>
              <h3>Premium Inventory</h3>
              <p>Access exclusive luxury and performance vehicles</p>
            </div>
          </div>

          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-tools"></i>
            </div>
            <div>
              <h3>Expert Services</h3>
              <p>Professional maintenance and customization services</p>
            </div>
          </div>

          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <div>
              <h3>Market Analytics</h3>
              <p>Real-time market insights and pricing tools</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right side: Login form -->
    <div class="right-section">
      <div class="logo-container">
        <img src="./assets/image/MotorLogo.jpg" alt="MotorShop Logo" class="logo">
        <div class="logo-text">MotorShop</div>
        <div class="tagline">Drive Your Dreams</div>
      </div>

      <div class="form-container">
        <div class="form-header">
          <h1>Welcome Back</h1>
          <p>Sign in to access your MotorShop account</p>
        </div>

        <!-- Error message -->
        <?php if (isset($error)): ?>
          <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            <span><?php echo htmlspecialchars($error); ?></span>
          </div>
        <?php endif; ?>

        <!-- Success message (for password reset, etc.) -->
        <?php if (isset($_GET['reset']) && $_GET['reset'] == 'success'): ?>
          <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <span>Password reset link sent to your email!</span>
          </div>
        <?php endif; ?>

        <!-- Login form -->
        <form class="form" method="post" name="login" id="loginForm">
          <div class="form-group">
            <i class="fas fa-user form-icon"></i>
            <input type="text" class="form-input" name="username" placeholder="Username or Email" required autofocus
              value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            <div class="field-error" id="usernameError">Please enter your username or email</div>
          </div>

          <div class="form-group">
            <i class="fas fa-lock form-icon"></i>
            <input type="password" class="form-input" id="password" name="password" placeholder="Password" required>
            <button type="button" class="password-toggle" id="togglePassword">
              <i class="fas fa-eye"></i>
            </button>
            <div class="field-error" id="passwordError">Please enter your password</div>
          </div>

          <div class="form-options">
            <div class="remember-me">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Remember me for 30 days</label>
            </div>
            <a href="#" class="forgot-password" id="forgotPasswordLink">Forgot password?</a>
          </div>

          <button type="submit" class="login-button" id="loginButton">
            <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Sign In
          </button>
        </form>

        <div class="divider">
          <span>Or continue with</span>
        </div>

        <!-- Social login buttons -->
        <div class="social-buttons">
          <button class="social-button google" onclick="window.location.href='#'">
            <i class="fab fa-google google-icon social-icon"></i>
            <span>Google</span>
          </button>
          <button class="social-button facebook" onclick="window.location.href='#'">
            <i class="fab fa-facebook-f facebook-icon social-icon"></i>
            <span>Facebook</span>
          </button>
        </div>

        <!-- Register link -->
        <div class="register-link">
          New to MotorShop? <a href="registration.php">Create your account!</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal" id="forgotPasswordModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Reset Password</h2>
      </div>
      <div class="modal-body">
        <p>Enter your email address and we'll send you instructions to reset your password.</p>
        <div class="form-group">
          <i class="fas fa-envelope form-icon"></i>
          <input type="email" class="form-input" id="resetEmail" placeholder="Enter your email address">
          <div class="field-error" id="emailError">Please enter a valid email address</div>
        </div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-primary" onclick="sendResetLink()">Send Reset Link</button>
        <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      const icon = this.querySelector('i');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

    // Forgot password modal
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');
    const forgotPasswordModal = document.getElementById('forgotPasswordModal');

    forgotPasswordLink.addEventListener('click', function(e) {
      e.preventDefault();
      forgotPasswordModal.style.display = 'flex';
      document.getElementById('resetEmail').focus();
    });

    function closeModal() {
      forgotPasswordModal.style.display = 'none';
      // Clear email field and error
      document.getElementById('resetEmail').value = '';
      document.getElementById('resetEmail').classList.remove('error');
      document.getElementById('emailError').style.display = 'none';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
      if (e.target === forgotPasswordModal) {
        closeModal();
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && forgotPasswordModal.style.display === 'flex') {
        closeModal();
      }
    });

    // Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const username = this.querySelector('input[name="username"]').value.trim();
      const password = this.querySelector('input[name="password"]').value;
      const loginButton = document.getElementById('loginButton');
      let isValid = true;

      // Reset errors
      document.getElementById('usernameError').style.display = 'none';
      document.getElementById('passwordError').style.display = 'none';
      this.querySelectorAll('.form-input').forEach(input => {
        input.classList.remove('error');
      });

      // Validate username
      if (!username) {
        document.getElementById('usernameError').textContent = 'Please enter your username or email';
        document.getElementById('usernameError').style.display = 'block';
        this.querySelector('input[name="username"]').classList.add('error');
        isValid = false;
      }

      // Validate password
      if (!password) {
        document.getElementById('passwordError').textContent = 'Please enter your password';
        document.getElementById('passwordError').style.display = 'block';
        this.querySelector('#password').classList.add('error');
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
        return false;
      }

      // Show loading state
      const originalText = loginButton.innerHTML;
      loginButton.innerHTML = '<span class="loading"></span> Signing In...';
      loginButton.disabled = true;

      // Allow form submission
      return true;
    });

    // Forgot password function
    function sendResetLink() {
      const email = document.getElementById('resetEmail').value.trim();
      const emailError = document.getElementById('emailError');

      // Reset error
      emailError.style.display = 'none';
      document.getElementById('resetEmail').classList.remove('error');

      // Validate email
      if (!email || !validateEmail(email)) {
        emailError.textContent = 'Please enter a valid email address';
        emailError.style.display = 'block';
        document.getElementById('resetEmail').classList.add('error');
        document.getElementById('resetEmail').focus();
        return;
      }

      // Simulate sending reset link (replace with actual AJAX call)
      const submitBtn = document.querySelector('.modal-actions .btn-primary');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span class="loading"></span> Sending...';
      submitBtn.disabled = true;

      setTimeout(() => {
        // In production, make an AJAX call to your server
        // $.ajax({
        //   type: 'POST',
        //   url: 'forgot_password.php',
        //   data: { email: email },
        //   success: function(response) {
        //     alert('Password reset link sent! Check your email.');
        //     closeModal();
        //   },
        //   error: function() {
        //     alert('Error sending reset link. Please try again.');
        //     submitBtn.innerHTML = originalText;
        //     submitBtn.disabled = false;
        //   }
        // });

        // For demo purposes
        alert('Password reset link has been sent to ' + email);
        closeModal();
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
      }, 1500);
    }

    function validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }

    // Auto-focus username field if there's an error
    document.addEventListener('DOMContentLoaded', function() {
      const errorMessage = document.querySelector('.error-message');
      const successMessage = document.querySelector('.success-message');

      // Fade out messages after 5 seconds
      setTimeout(() => {
        if (errorMessage) {
          errorMessage.style.opacity = '0.7';
          errorMessage.style.transition = 'opacity 0.5s ease';
        }
        if (successMessage) {
          successMessage.style.opacity = '0.7';
          successMessage.style.transition = 'opacity 0.5s ease';
        }
      }, 5000);

      // If there's an error and username field exists, focus it
      if (errorMessage) {
        const usernameInput = document.querySelector('input[name="username"]');
        if (usernameInput) {
          usernameInput.focus();
          if (usernameInput.value) {
            usernameInput.select();
          }
        }
      }
    });

    // Add enter key support for form
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        if (forgotPasswordModal.style.display === 'flex') {
          sendResetLink();
        }
      }
    });
  </script>
</body>

</html>
