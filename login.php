<?php
require_once 'db.php';

// When form submitted, check and create user session.
if (isset($_POST['username'])) {
  $username = stripslashes($_REQUEST['username']);
  $username = mysqli_real_escape_string($con, $username);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($con, $password);

  $query = "SELECT * FROM `users` WHERE username='$username' AND password='" . md5($password) . "'";
  $result = mysqli_query($con, $query);
  $rows = mysqli_num_rows($result);

  if ($rows == 1) {
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit;
  } else {
    $error = "Incorrect Username or password.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>MotorStart | Login</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

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

    /* Left side with automotive background */
    .left-section {
      flex: 1;
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
        url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1283&q=80');
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

    /* Right side with login form */
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
      border-radius: 10px;
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
      color: #8b5a2b;
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

    /* Password toggle */
    .password-toggle {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #8b5a2b;
      cursor: pointer;
      font-size: 1.1rem;
      opacity: 0.7;
      transition: opacity 0.3s;
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
      accent-color: #8b5a2b;
      width: 18px;
      height: 18px;
    }

    .remember-me label {
      color: #666;
      font-size: 0.95rem;
      cursor: pointer;
    }

    .forgot-password {
      color: #8b5a2b;
      text-decoration: none;
      font-size: 0.95rem;
      font-weight: 500;
      transition: color 0.2s;
    }

    .forgot-password:hover {
      color: #6f4518;
      text-decoration: underline;
    }

    /* Login button */
    .login-button {
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

    .login-button:hover {
      background: linear-gradient(to right, #6f4518, #5a3712);
      transform: translateY(-2px);
      box-shadow: 0 7px 15px rgba(139, 90, 43, 0.2);
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

    /* Google Sign In */
    .google-signin {
      width: 100%;
      padding: 16px;
      background: white;
      color: #555;
      border: 2px solid #e1e5eb;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 500;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 25px;
    }

    .google-signin:hover {
      background: #f9fafc;
      border-color: #d1d9e6;
    }

    .google-icon {
      margin-right: 12px;
      font-size: 1.2rem;
      color: #db4437;
    }

    /* Register link */
    .register-link {
      text-align: center;
      margin-top: 30px;
      color: #666;
      font-size: 0.95rem;
    }

    .register-link a {
      color: #8b5a2b;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s;
    }

    .register-link a:hover {
      color: #6f4518;
      text-decoration: underline;
    }

    /* Error message styling */
    .error-message {
      background: #fff5f5;
      color: #e74c3c;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 25px;
      text-align: center;
      border-left: 4px solid #e74c3c;
      animation: fadeIn 0.5s ease;
    }

    .error-message i {
      margin-right: 8px;
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
    }

    .field-error {
      color: #e74c3c;
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
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
      background: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .modal-content {
      background: white;
      padding: 40px;
      border-radius: 15px;
      max-width: 450px;
      width: 100%;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      animation: modalFade 0.3s ease;
    }

    @keyframes modalFade {
      from {
        opacity: 0;
        transform: scale(0.9);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .modal-header {
      margin-bottom: 20px;
    }

    .modal-header h2 {
      font-family: 'Poppins', sans-serif;
      font-size: 1.8rem;
      color: #333;
      font-weight: 600;
    }

    .modal-body {
      margin-bottom: 30px;
    }

    .modal-body p {
      color: #666;
      margin-bottom: 20px;
    }

    .modal-actions {
      display: flex;
      gap: 15px;
    }

    .modal-actions button {
      flex: 1;
      padding: 14px;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    .modal-actions .btn-primary {
      background: linear-gradient(to right, #8b5a2b, #6f4518);
      color: white;
      border: none;
    }

    .modal-actions .btn-secondary {
      background: white;
      color: #666;
      border: 2px solid #e1e5eb;
    }

    .modal-actions .btn-primary:hover {
      background: linear-gradient(to right, #6f4518, #5a3712);
      transform: translateY(-2px);
    }

    .modal-actions .btn-secondary:hover {
      background: #f9fafc;
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
        font-size: 1.5rem;
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
    }
  </style>
</head>

<body>


  <div class="container">
    <!-- Left side: Brand showcase -->
    <div class="left-section">
      <div class="brand-intro">
        <h2>Welcome to MotorStart</h2>
        <p>Rev up your automotive experience. Access premium tools, connect with fellow enthusiasts, and accelerate your journey with our exclusive community features.</p>

        <div class="features">
          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-tools"></i>
            </div>
            <div>
              <h3>Premium Tools</h3>
              <p>Advanced automotive diagnostic tools</p>
            </div>
          </div>

          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-users"></i>
            </div>
            <div>
              <h3>Expert Community</h3>
              <p>Connect with automotive professionals</p>
            </div>
          </div>

          <div class="feature">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <div>
              <h3>Performance Analytics</h3>
              <p>Track and optimize vehicle performance</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right side: Login form -->
    <div class="right-section">
      <div class="logo-container">
        <img src="./assets/image/MotorLogo.jpg" alt="MotorStart Logo" class="logo">
        <div class="logo-text">MotorStart</div>
      </div>

      <div class="form-container">
        <div class="form-header">
          <h1>Welcome Back</h1>
          <p>Sign in to access your account</p>
        </div>

        <!-- Error message -->
        <?php if (isset($error)): ?>
          <div class="error-message">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <!-- Login form -->
        <form class="form" method="post" name="login" id="loginForm">
          <div class="form-group">
            <i class="fas fa-user form-icon"></i>
            <input type="text" class="form-input" name="username" placeholder="Username" required autofocus
              value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            <div class="field-error" id="usernameError">Please enter your username</div>
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
              <label for="remember">Remember me</label>
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

        <!-- Google Sign In -->
        <div id="g_id_onload"
          data-client_id="YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com"
          data-context="signin"
          data-ux_mode="popup"
          data-callback="onSignIn"
          data-auto_prompt="false">
        </div>

        <div class="g_id_signin" data-type="standard">
          <button class="google-signin" type="button">
            <i class="fab fa-google google-icon"></i> Sign in with Google
          </button>
        </div>

        <!-- Register link -->
        <div class="register-link">
          Don't have an account? <a href="registration.php">Create one now!</a>
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
        <p>Enter your email address and we'll send you a link to reset your password.</p>
        <div class="form-group">
          <i class="fas fa-envelope form-icon"></i>
          <input type="email" class="form-input" id="resetEmail" placeholder="Enter your email">
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
  <script src="https://accounts.google.com/gsi/client" async defer></script>

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
      document.getElementById('emailError').style.display = 'none';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
      if (e.target === forgotPasswordModal) {
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
        document.getElementById('usernameError').style.display = 'block';
        this.querySelector('input[name="username"]').classList.add('error');
        isValid = false;
      }

      // Validate password
      if (!password) {
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
        return;
      }

      // Here you would typically make an AJAX call to your server
      alert('A password reset link has been sent to ' + email);
      closeModal();
    }

    function validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }

    // Google Sign-In callback
    function onSignIn(googleUser) {
      const loginButton = document.getElementById('loginButton');
      const originalText = loginButton.innerHTML;
      loginButton.innerHTML = '<span class="loading"></span> Signing In...';
      loginButton.disabled = true;

      // Get the user ID token
      var id_token = googleUser.getAuthResponse().id_token;

      // Send the token to the server using AJAX
      $.ajax({
        type: 'POST',
        url: 'set_session.php',
        data: {
          id_token: id_token
        },
        success: function(response) {
          window.location.href = 'index.php';
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          alert('Google sign-in failed. Please try again.');
          loginButton.innerHTML = originalText;
          loginButton.disabled = false;

          // Sign out from Google
          if (typeof google !== 'undefined' && google.accounts) {
            google.accounts.id.revoke(googleUser.getEmail(), function(revoked) {
              console.log('Revoked: ' + revoked);
            });
          }
        }
      });
    }

    // Auto-focus username field if there's an error
    document.addEventListener('DOMContentLoaded', function() {
      const errorMessage = document.querySelector('.error-message');
      if (errorMessage) {
        setTimeout(() => {
          errorMessage.style.opacity = '0.7';
        }, 3000);
      }

      // If there's an error and username field exists, focus it
      if (errorMessage) {
        const usernameInput = document.querySelector('input[name="username"]');
        if (usernameInput) {
          usernameInput.focus();
          usernameInput.select();
        }
      }
    });
  </script>
</body>

</html>
