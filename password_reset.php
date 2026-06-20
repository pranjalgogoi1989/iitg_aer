<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/security/csrf.php';
require_once __DIR__ . '/mails/master.php';
$error = [];
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userCaptcha = trim($_POST['captcha'] ?? '');
    if (isset($_SESSION['captcha']) && strtoupper($userCaptcha) === $_SESSION['captcha']) {

    } else {
        $error[]= "Invalid CAPTCHA.";
    }
    csrf_validate($_POST['csrf_token']);
    $email = trim($_POST['email']);
    $otp = trim($_POST['verification_code']);
    $password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    if( empty($email) || empty($password) || empty($confirm_password) || empty($otp)){
        $error[] = "All fields are required";
    }
    if ($password !== $confirm_password) {
        $error[] = "Passwords do not match";
    }
    if (strlen($password) < 8) {
        $error[] = "Password must be at least 8 characters";
    }
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? limit 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user) {
        $stms = $pdo->prepare("select * from password_resets where email=? and verification_code=? limit 1");
        $stms->execute([$email,$otp]);
        $user1 = $stms->fetch();
        if($user1){
            $stmt = $pdo->prepare("update users set password = ? where email = ?");
            $stmt->execute([password_hash($password, PASSWORD_DEFAULT), $email]);
            $stmt = $pdo->prepare("delete from password_resets where email = ?");
            $stmt->execute([$email]);
            $successMessage = "Password reset successful";
            $result = sendHTMLMail($email,$user['name'],$successMessage,'templates/password_change.html',['name' => $user['name'],'password'=> $password]);
        }else{
            $error[] = "Invalid OTP or email";
        }
    } else {
        $error[] = "User not found";
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
    <title>Sign Up</title>
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
    <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y w-500">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.php" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="assets/images/logo.jpg" alt class="w-px-100 h-auto rounded-circle" />
                  </span>
                  
                </a>
              </div>
              <!-- /Logo -->
              <div class="row"><div class="col-12 mb-3">
                <h5 class="text-center"><b>Reset Password</b></h5>
                <small>Enter your details to create a new password</small>
            </div><hr> </div>
              
              <?php
              if (!empty($error)) {
                  echo '<div class="alert alert-danger" role="alert">';
                  echo '<ul>';
                  foreach ($error as $error) {
                      echo '<li>' . $error . '</li>';
                  }
                  echo '</ul>';
                  echo '</div>';
              }
              if($successMessage){
                echo '<div class="alert alert-success" role="alert">' . $successMessage . '. Redirecting...</div>';
                echo '<meta http-equiv="refresh" content="3;url=index.php">';
                echo '<center><a class="btn btn-primary" href="index.php">Login</a></center>';
              }else{
              ?>
              <form id="formAuthentication" class="mb-3" method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter registered email" required onblur="checkEmailAvailability(this.value)">
                    <div id="emailAvailabilityMessage" class="small mt-1"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Verification Code</label>
                    <input type="text" name="verification_code" class="form-control" placeholder="Enter verification code" maxlength="6" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required>
                    <div id="passwordMatchMessage" class="small mt-1"></div>
                </div>
                <div class="mb-3">
                  <p>
                    <img src="config/captcha.php?<?php echo time(); ?>" alt="CAPTCHA">
                    <a href="" onclick="location.reload(); return false;">Refresh</a>
                  </p>
                  <input type="text" class="form-control" name="captcha" placeholder="Enter CAPTCHA" required>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
                </div>
              </form>
              <?php } ?>
              <div class="row">
                <div class="col-sm-12">
                    Changed your mind? <a href="index.php" class="btn btn-sm btn-outline-primary"><b>Sign in</b></a>
                    <br><strong>Note: </strong>On click of Sign in button, you will receive an email to validate your email id. In case you don't see our mail in your inbox. Kindly check for<b class="text-danger"> junk/spam folder.</b> </b>                </div>
              </div>
              
              
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>
    <script>
        function checkEmailAvailability(email) {
            $.ajax({
                type: "POST",
                url: "request_otp_reset.php",
                data: { email: email },
                success: function(response) {
                    $("#emailAvailabilityMessage").html(response);
                }
            });
        }
    </script>
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>

