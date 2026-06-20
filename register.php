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
  
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);
  $mobile_no = trim($_POST['mobile_no']);
	
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Invalid email address";
	} elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/i', $email)) {
    $error[] = "Only Gmail addresses are allowed";
	} else {

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $error[] = "User already exists";
    }
	}

  if(empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password) || empty($mobile_no)){
      $error[] = "All fields are required";
  }

  if ($password !== $confirm_password) {
      $error[] = "Passwords do not match";
  }
  if (strlen($password) < 8) {
      $error[] = "Password must be at least 8 characters";
  }
  if(strlen($mobile_no) != 10){
      $error[] = "Mobile number must be 10 digits";
  }

  if(empty($error)){
      $stmt = $pdo->prepare("insert into users(email,name,role,password) values(?,?,?,?)");
      $stmt->execute([$email,$first_name.' '.$last_name,'student',password_hash($password, PASSWORD_DEFAULT)]);

      $secureCode = random_int(100000, 999999);
      $stmt1=$pdo->prepare("insert into email_verification(email,verification_code) values(?,?)");
      $stmt1->execute([$email,$secureCode]);

      $stmt2=$pdo->prepare("INSERT INTO students(first_name,last_name,alt_email,mobile_number) values(?,?,?,?)");
      $stmt2->execute([$first_name,$last_name,$email,$mobile_no]);
      $successMessage = "Registration successful";
      $result = sendHTMLMail($email,$first_name,$successMessage,'templates/registration.html',['name' => $first_name,'email'=> $email,'password'=> $password]);
      $result1 = sendHTMLMail($email,$first_name,'Email Verification','templates/email_verification.html',['name' => $first_name,'email'=> $email,'code' => $secureCode]);
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
              <div class="row"><div class="col-12 mb-3"><h5 class="text-center"><b>Alumni, Corporate and International Relations </b></h5></div><hr> </div>
              
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
                echo '<div class="alert alert-success" role="alert">' . $successMessage . '</div>';
                echo '<br>';
                echo '<center>An email with verification code and login credential has been sent to your alternate email. Please verify your email address after login.</center>';
                echo '<br>';
                echo '<center><a class="btn btn-primary" href="login.php">Login</a></center>';
              }
              ?>
              <form id="formAuthentication" class="mb-3" method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="row">
                <div class="col-6 mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control"  autocomplete="off" id="first_name" name="first_name" placeholder="Enter your first name" autofocus />
                </div>
                 <div class="col-6 mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" autocomplete="off" id="last_name" name="last_name" placeholder="Enter your first name" autofocus required/>
                </div>
                </div>
                 <div class="row">
                <div class="col-12 mb-3">
                    <label for="email" class="form-label">Email ID (Only Gmail addresses are allowed)</label>
                    <input type="email" class="form-control" autocomplete="off" id="email" name="email" placeholder="Enter Gmail ID" pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" title="Only Gmail addresses are allowed" required>
                </div>
                </div>
                <div class="row">
                <div class="col-6 mb-3 form-password-toggle">
                  
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" autocomplete="off" class="form-control" name="password" placeholder="********" aria-describedby="password" required/>
                  
                </div>
                <div class="col-6 mb-3 form-password-toggle">
                  
                    <label class="form-label" for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" autocomplete="off" class="form-control" name="confirm_password" placeholder="********" required/>
                  
                </div>
                </div>
                <div class="mb-3 form-password-toggle">
                  
                    <label class="form-label" for="mobile_no">Mobile Number</label>
                    <input type="text" id="mobile_no" autocomplete="off" class="form-control" name="mobile_no" required/>
                  
                </div>
                <div class="mb-3">
                  <p>
                    <img src="config/captcha.php?<?php echo time(); ?>" alt="CAPTCHA">
                    <a href="" onclick="location.reload(); return false;">Refresh</a>
                  </p>
                  <input type="text" class="form-control" name="captcha" placeholder="Enter CAPTCHA" required>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign Up</button>
                </div>
              </form>
              <div class="row">
                <div class="col-sm-12">
                    Already Signed Up? <a href="index.php" class="btn btn-sm btn-outline-primary"><b>Sign in</b></a>
                    <br><strong>Note: </strong>On click of Sign in button, you will receive an email to validate your email id. In case you don't see our mail in your inbox. Kindly check for<b class="text-danger"> junk/spam folder.</b> </b>                </div>
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
