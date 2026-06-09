<?php
require 'config/config.php';
require 'security/csrf.php';
require_once __DIR__ . '/mails/master.php';

$errors = [];
$successMessage = '';
$salutation = "";
$first_name = "";
$last_name = "";
$iitg_email = "";
$alt_email = "";
$country_code = "";
$mobile_number = "";
$roll_number = "";
$department = "";
$programme = "";
$year_of_joining = "";
$graduation_year = "";
$hostel = "";
$country = "";
$state = "";
$city = "";
$address = "";
$pincode = "";
$linkedin = "";
$whatsapp = "";
$organization = "";
$designation = "";
$next_venture = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $salutation = trim($_POST['salutation']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $iitg_email = trim($_POST['iitg_email']);
    $alt_email = trim($_POST['alt_email']);
    $country_code = trim($_POST['country_code']);
    $mobile_number = trim($_POST['mobile']);
    $roll_number = trim($_POST['roll_number']);
    $department = trim($_POST['department']);
    $programme = trim($_POST['programme']);
    $year_of_joining = trim($_POST['joining_year']);
    $graduation_year = trim($_POST['graduation_year']);
    $hostel = trim($_POST['hostel']);
    $country = trim($_POST['country']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $address = trim($_POST['address']);
    $pincode = trim($_POST['pincode']);
    $linkedin = trim($_POST['linkedin']);
    $whatsapp = trim($_POST['whatsapp']);
    $organization = trim($_POST['organization']);
    $designation = trim($_POST['designation']);
    $next_venture = trim($_POST['next_venture']);
    $terms = trim($_POST['terms']);

    if (empty($salutation)) {
        $errors[] = 'Salutation is required';
    }
    if (empty($first_name)) {
        $errors[] = 'First name is required';
    }
    if (empty($iitg_email)){
        $errors[] = 'IITG email is required';
    }
    if (empty($country_code)){
        $errors[] = 'Country code is required';
    }
    if (empty($mobile_number)){
        $errors[] = 'Mobile number is required';
    }
    if(strlen($mobile_number) < 10){
        $errors[] = 'Mobile number should be 10 digits';
    }
    if (empty($roll_number)){
        $errors[] = 'Roll number is required';
    }
    if (empty($department)){
        $errors[] = 'Department is required';
    }
    if (empty($programme)){
        $errors[] = 'Programme is required';
    }
    if (empty($year_of_joining)){
        $errors[] = 'Year of joining is required';
    }
    if (empty($graduation_year)){
        $errors[] = 'Graduation year is required';
    }
    if (empty($country)){
        $errors[] = 'Country is required';
    }
    if (empty($state)){
        $errors[] = 'State is required';
    }
    if (empty($city)){
        $errors[] = 'City/Village is required';
    }
    if (empty($address)){
        $errors[] = 'House/Building No. Street Name and Locality/Area is required';
    }
    if (empty($pincode)){
        $errors[] = 'Pincode is required';
    }
    if (empty($whatsapp)){
        $errors[] = 'Whatsapp number is required';
    }
    if(strlen($whatsapp) < 10){
        $errors[] = 'Whatsapp number should be 10 digits';
    }
    if (empty($terms)){
        $errors[] = 'Please confirm the validation of informations provided';
    }

  if(empty($errors)){
    $successMessage = "Registration successful";

    $uid = uniqid();
    $secureCode = random_int(100000, 999999);

    $stmt3 = $pdo->prepare("select * from students where alt_email=? or iitg_email=? or roll_no=?");
    $stmt3->execute([$alt_email,$iitg_email,$roll_number]);
    $student = $stmt3->fetch();
    if($student){
        $errors[] = 'Student already exists';
    }else{
      $stmt = $pdo->prepare("insert into users(email,name,role,password) values(?,?,?,?)");
      $stmt->execute([$alt_email,$first_name,'student',password_hash($uid, PASSWORD_DEFAULT)]);
  
      $stmt1=$pdo->prepare("insert into email_verification(email,verification_code) values(?,?)");
      $stmt1->execute([$alt_email,$secureCode]);
  
      $stmt2=$pdo->prepare("INSERT INTO students(roll_no,salutation,first_name,last_name,iitg_email,alt_email,country_code,mobile_number,department,programme,joining_year,graduation_year,hostel,country,state,city,address,pincode,linkedin,whatsapp,organization,designation,next_venture,passport_photo,transcript,certificate,email_verified,application_status) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt2->execute([$roll_number,$salutation,$first_name,$last_name,$iitg_email,$alt_email,$country_code,$mobile_number,$department,$programme,$year_of_joining,$graduation_year,$hostel,$country,$state,$city,$address,$pincode,$linkedin,$whatsapp,$organization,$designation,$next_venture,'','','','pending','not submitted']);
  
      $result = sendHTMLMail($alt_email,$first_name,$successMessage,'templates/registration.html',['name' => $first_name,'email'=> $alt_email,'password'=> $uid]);
      $result1 = sendHTMLMail($alt_email,$first_name,'Email Verification','templates/email_verification.html',['name' => $first_name,'email'=> $alt_email,'code' => $secureCode]);
    }
  }

}
?>

<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Register</title>
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

    <div class="container-xxl flex-grow-1 container-p-y">
      
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
               <br>
              <legend class="text-center">Alumni Registration Form</legend>
              
              <?php
              if (!empty($errors)) {
                  echo '<div class="alert alert-danger" role="alert">';
                  echo '<ul>';
                  foreach ($errors as $error) {
                      echo '<li>' . $error . '</li>';
                  }
                  echo '</ul>';
                  echo '</div>';
              }
              if (!empty($successMessage)) {
                  echo '<div class="alert alert-success" role="alert">' . $successMessage . '</div>';
                  echo '<br>';
                  echo '<center>An email with verification code and login credential has been sent to your alternate email. Please verify your email address after login.</center>';
                  echo '<br>';
                  echo '<center><a class="btn btn-primary" href="login.php">Login</a></center>';
              }else{
              ?>
              <small># All Fields marked with <span class="text-danger">*</span> are required.</small>
              <form id="formAuthentication" class="mb-3" method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="row">
                  <div class="col-sm-4">
                    <label for="">Salutation <span class="text-danger">*</span></label>
                    <select name="salutation" id="salutation" class="form-control form-select">
                      <option value="Mr" <?php if($salutation == 'Mr') echo 'selected'; ?>>Mr</option>
                      <option value="Mrs" <?php if($salutation == 'Mrs') echo 'selected'; ?>>Mrs</option>
                      <option value="Miss" <?php if($salutation == 'Miss') echo 'selected'; ?>>Miss</option>
                      <option value="Ms" <?php if($salutation == 'Ms') echo 'selected'; ?>>Ms</option>
                      <option value="Prof" <?php if($salutation == 'Prof') echo 'selected'; ?>>Prof</option>
                      <option value="Dr" <?php if($salutation == 'Dr') echo 'selected'; ?>>Dr</option>
                      <option value="Other" <?php if($salutation == 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $first_name ?>">
                  </div>
                  <div class="col-sm-4">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?= $last_name ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="iitg_email">IITG Email ID <span class="text-danger">*</span></label>
                    <input type="email" name="iitg_email" id="iitg_email" class="form-control" value="<?= $iitg_email ?>">
                  </div>
                  <div class="col-sm-6">
                    <label for="email">Alternate Email ID <span class="text-danger">*</span> <small>(Alumnies need to verify the email address before applying for Alumni Card)</small></label>
                    <input type="email" name="alt_email" id="alt_email" class="form-control" value="<?= $alt_email ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="country_code">Country Code <span class="text-danger">*</span></label>
                    <select name="country_code" id="country_code" class="form-control form-select">
                      <option value="" selected> - Select Country Code - </option>
                    <?php
                      $stmt = $pdo->prepare("SELECT * FROM countries order by country_code");
                      $stmt->execute();
                      $country_codes = $stmt->fetchAll();
                      foreach($country_codes as $cc){
                        if($country_code == $cc["country_code"]){
                          echo '<option value="'.$cc["country_code"].'" selected>'.$cc["country_code"].' - ('.$cc["country_name"].')</option>';
                        }else{
                         echo '<option value="'.$cc["country_code"].'">'.$cc["country_code"].' - ('.$cc["country_name"].')</option>';
                        }  
                      }
                    ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label for="mobile">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" name="mobile" id="mobile" class="form-control" value="<?= $mobile_number ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="roll_number">Roll Number <span class="text-danger">*</span></label>
                    <input type="text" name="roll_number" id="roll_number" class="form-control" value="<?= $roll_number ?>">
                  </div>
                  <div class="col-sm-6">
                    <label for="department">Department <span class="text-danger">*</span></label>
                    <select name="department" id="department" class="form-control form-select">
                      <option value="" selected> - Select Department - </option>
                    <?php
                      $stmt = $pdo->prepare("SELECT * FROM departments");
                      $stmt->execute();
                      $country_codes = $stmt->fetchAll();
                      foreach($country_codes as $cc){
                        if($cc["dept_name"] == $department){
                           echo '<option value="'.$cc["dept_name"].'" selected>'.$cc["dept_name"].'</option>';
                        }else{
                          echo '<option value="'.$cc["dept_name"].'">'.$cc["dept_name"].'</option>';
                        }
                      }
                    ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="programme">Programme <span class="text-danger">*</span></label>
                    <select name="programme" id="programme" class="form-control form-select">
                      <option value="" selected> - Select Programme - </option>
                      <?php
                      $stmt = $pdo->prepare("SELECT * FROM programmes");
                      $stmt->execute();
                      $programmes = $stmt->fetchAll();
                      foreach($programmes as $cc){
                        if ($cc["prog"] == $programme) {
                          echo '<option value="'.$cc["prog"].'" selected>'.$cc["programme_name"].'</option>';
                        }else{
                          echo '<option value="'.$cc["prog"].'">'.$cc["programme_name"].'</option>';
                        }
                      }
                    ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label for="joining_year">Year of Joining <span class="text-danger">*</span></label>
                    <select name="joining_year" id="joining_year" class="form-control form-select">
                      <option value="" selected> - Select Year of Joining - </option>
                      <?php
                      for($year = 1994; $year<=date('Y');$year++){
                        if ($year == $year_of_joining){
                          echo '<option value="'.$year.'" selected>'.$year.'</option>';
                        }else{
                          echo '<option value="'.$year.'">'.$year.'</option>';
                        }
                          
                      }
                    ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="graduation_year">Year of Graduation <span class="text-danger">*</span></label>
                    <select name="graduation_year" id="graduation_year" class="form-control form-select">
                      <option value="" selected> - Select Year of Graduation - </option>
                      <?php
                      for($year = 1994; $year<=date('Y');$year++){
                        if ($year == $graduation_year ){
                          echo '<option value="'.$year.'" selected>'.$year.'</option>';
                        }else{
                          echo '<option value="'.$year.'">'.$year.'</option>';
                        } 
                      }
                    ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label for="hostel">Hostel <span class="text-danger">*</span></label>
                    <select name="hostel" id="hostel" class="form-control form-select">
                      <option value="" selected> - Select Hostel - </option>
                    <?php
                      $stmt = $pdo->prepare("SELECT * FROM hostel");
                      $stmt->execute();
                      $hostels = $stmt->fetchAll();
                      foreach($hostels as $cc){
                        if($cc["hostel_name"]==$hostel){
                          echo '<option value="'.$cc["hostel_name"].'" selected>'.$cc["hostel_name"].'</option>';
                        }else{
                          echo '<option value="'.$cc["hostel_name"].'">'.$cc["hostel_name"].'</option>';
                        }
                      }
                    ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="counry">Country <span class="text-danger">*</span></label>
                    <select name="country" id="country" class="form-control form-select">
                      <option value="" selected> - Select Country - </option>
                    <?php
                      $stmt = $pdo->prepare("SELECT * FROM countries");
                      $stmt->execute();
                      $countries = $stmt->fetchAll();
                      foreach($countries as $cc){
                        if($cc["country_name"] == $country){
                          echo '<option value="'.$cc["country_name"].'" selected>'.$cc["country_name"].'</option>';
                        }else{
                          echo '<option value="'.$cc["country_name"].'">'.$cc["country_name"].'</option>';
                        }
                      }
                    ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label for="state">State <span class="text-danger">*</span></label>
                    <input type="text" name="state" id="state" class="form-control" value="<?= $state ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <label for="city">City/Village <span class="text-danger">*</span></label>
                    <input type="text" name="city" id="city" class="form-control" value="<?= $city ?>">
                  </div>
                  <div class="col-sm-4">
                    <label for="address">House/Building No. Street Name and Locality/Area <span class="text-danger">*</span></label>
                    <input type="text" name="address" id="address" class="form-control" value="<?= $address ?>">
                  </div>
                  <div class="col-sm-4">
                    <label for="pincode">Pincode <span class="text-danger">*</span></label>
                    <input type="text" name="pincode" id="pincode" class="form-control" value="<?= $pincode ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="linkedin">LinkedIn Profile Address</label>
                    <input type="text" name="linkedin" id="linkedin" class="form-control" value="<?= $linkedin ?>">
                  </div>
                  <div class="col-sm-6">
                    <label for="whatsapp">Whatsapp <span class="text-danger">*</span></label>
                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="<?= $whatsapp ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="organization">Organization</label>
                    <input type="text" name="organization" id="organization" class="form-control" value="<?= $organization ?>">
                  </div>
                  <div class="col-sm-6">
                    <label for="designation">Designation</label>
                    <input type="text" name="designation" id="designation" class="form-control" value="<?= $designation ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <label for="next_venture">Details of your next venture or destination (if known)</label>
                    <textarea name="next_venture" id="next_venture" class="form-control" rows="2"><?= $next_venture ?></textarea>
                  </div>
                </div>
                <br>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required onclick="enableButton(this.checked)"/>
                    <label class="form-check-label" for="terms-conditions">
                      I agree that all the informations provided are correct.
                    </label>
                  </div>
                </div>
                <center>
                  <button class="btn btn-primary d-grid" type="submit" id="register" disabled>Sign up</button>
                </center>
              </form>
              <?php 
              }
              ?>

              <p class="text-center">
                <span>Already registered?</span>
                <a href="/">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        
    </div>
    <script>
      function enableButton(checked) {
        document.getElementById("register").disabled = !checked;
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
