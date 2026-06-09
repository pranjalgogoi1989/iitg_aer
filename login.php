<?php
require_once 'config/config.php';
require_once 'security/csrf.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!validateCSRF($_POST['csrf_token'])) {
        die("Invalid CSRF token");
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {

        // Check lockout
        if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
            die("Account locked. Try again later.");
        }

        if (password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Reset failed attempts
            $pdo->prepare("UPDATE users SET failed_attempts = 0, locked_until = NULL WHERE id = ?")
                ->execute([$user['id']]);

            header("Location: dashboard.php");
            exit();

        } else {

            $failed = $user['failed_attempts'] + 1;

            $lockTime = null;
            if ($failed >= 5) {
                $lockTime = date("Y-m-d H:i:s", strtotime("+15 minutes"));
            }

            $pdo->prepare("UPDATE users SET failed_attempts = ?, locked_until = ? WHERE id = ?")
                ->execute([$failed, $lockTime, $user['id']]);

            $error = "Invalid credentials.";
        }
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Login</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="assets/images/logo.jpg" alt class="w-px-100 h-auto rounded-circle" />
                  </span>
                  
                </a>
              </div>
              <!-- /Logo -->
              
              <form id="formAuthentication" class="mb-3" method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="mb-3">
                  <label for="username" class="form-label">Email ID</label>
                  <input
                    type="email"
                    class="form-control"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    value="biswajit"
                    autofocus
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      value="12345678"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>
              <div class="row">
                <div class="col-sm-6">
                  <a href="register.php" class="btn btn-info d-grid w-100">Sign up</a>
                </div>
                <div class="col-sm-6">
                  <a href="forgot-password.php" class="btn btn-info d-grid w-100">Forgot Password</a>
                </div>
              </div>
              
              
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
