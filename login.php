<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Yanshi School</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="logo.png">
  <style>
    /* Gradient Background */
    body {
      background: linear-gradient(135deg, #ff7e5f, #6a11cb);
      height: 100vh;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    /* Floating Icons */
    .icon {
      position: absolute;
      font-size: 40px;
      opacity: 0.2;
      color: white;
      animation: float 15s infinite linear;
    }
    .icon1 { top: 10%; left: 5%; animation-duration: 18s; }
    .icon2 { top: 70%; left: 10%; animation-duration: 22s; }
    .icon3 { top: 40%; left: 80%; animation-duration: 20s; }
    .icon4 { top: 85%; left: 60%; animation-duration: 25s; }
    .icon5 { top: 20%; left: 90%; animation-duration: 19s; }

    @keyframes float {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-30px) rotate(20deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }

    /* Login Card */
    .login-card {
      background: #fff;
      max-width: 420px;
      width: 100%;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
      z-index: 10;
      animation: fadeIn 1s ease-in-out;
    }

    /* Logo */
    .login-card img {
      width: 90px;
      margin-bottom: 15px;
    }

    /* Heading */
    .login-card h3 {
      background: linear-gradient(135deg, #ff7e5f, #6a11cb);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 800;
      margin-bottom: 25px;
    }

    /* Labels */
    .form-label {
      color: #444;
      font-weight: 600;
    }

    /* Inputs */
    .form-control {
      border-radius: 12px;
      padding: 10px;
      border: 1px solid #ccc;
      transition: 0.3s;
    }
    .form-control:focus {
      border-color: #6a11cb;
      box-shadow: 0 0 10px rgba(106,17,203,0.3);
    }

    /* Button */
    .btn-login {
      background: linear-gradient(135deg, #6a11cb, #ff7e5f);
      border: none;
      border-radius: 12px;
      font-weight: bold;
      color: #fff;
      padding: 12px;
      transition: 0.3s;
    }
    .btn-login:hover {
      transform: scale(1.05);
      background: linear-gradient(135deg, #ff7e5f, #6a11cb);
    }

    /* Footer */
    .footer {
      margin-top: 20px;
      color: #666;
      font-size: 14px;
    }

    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

  <!-- Load Font Awesome for icons -->
  <script src="https://kit.fontawesome.com/4a2e6f5e84.js" crossorigin="anonymous"></script>
</head>
<body>
  <!-- Floating School Icons -->
  <i class="fas fa-book icon icon1"></i>
  <i class="fas fa-graduation-cap icon icon2"></i>
  <i class="fas fa-pencil-alt icon icon3"></i>
  <i class="fas fa-school icon icon4"></i>
  <i class="fas fa-chalkboard-teacher icon icon5"></i>

  <!-- Login Card -->
  <div class="login-card text-center">
    <img src="logo.png" alt="School Logo">
    <h3>Yanshi School Login</h3>

    <!-- Error Message -->
    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($_GET['error']) ?>
      </div>
    <?php endif; ?>

    <form action="req/login.php" method="post">
      <div class="mb-3 text-start">
        <label for="uname" class="form-label">Username</label>
        <input type="text" id="uname" name="uname" class="form-control" required>
      </div>

      <div class="mb-3 text-start">
        <label for="pass" class="form-label">Password</label>
        <input type="password" id="pass" name="pass" class="form-control" required>
      </div>

      <div class="mb-3 text-start">
        <label for="role" class="form-label">Login As</label>
        <select id="role" name="role" class="form-control" required>
          <option value="">-- Select Role --</option>
          <option value="1">Admin</option>
          <option value="2">Principal</option>
          <option value="3">Teacher</option>
          <option value="4">Student</option>
          <option value="5">Registrar Office</option>
        </select>
      </div>

      <button type="submit" class="btn btn-login w-100">Login</button>
      <a href="index.php" class="d-block mt-3 text-decoration-none">← Back to Home</a>
    </form>

    <div class="footer">&copy; 2025 Yanshi School. All rights reserved.</div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
