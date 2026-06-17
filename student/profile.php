<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
$title='My Profile';
require_once 'header.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';


$user_name= $_SESSION['email'];
$stmt=$pdo->prepare('select * from users where email=? limit 1');
$stmt->execute([$user_name]);
$row = $stmt->fetch();

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
$verification_code = "";
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
$por="";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $salutation = trim($_POST['salutation']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $alt_email = trim($_POST['alt_email']);
    $country_code = trim($_POST['country_code']);
    $mobile_number = trim($_POST['mobile']);
    $country = trim($_POST['country']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $address = trim($_POST['address']);
    $pincode = trim($_POST['pincode']);
    $linkedin = trim($_POST['linkedin']);
    $whatsapp = trim($_POST['whatsapp']);

    if (empty($salutation)) {
        $errors[] = 'Salutation is required';
    }
   
    if(empty($country_code)) {
        $errors[] = 'Country Code is required';
    }
    if(empty($mobile_number)) {
        $errors[] = 'Mobile Number is required';
    }
    
    if(empty($country)) {
        $errors[] = 'Country is required';
    }
    if(empty($state)) {
        $errors[] = 'State is required';
    }
    if(empty($city)) {
        $errors[] = 'City is required';
    }
    if(empty($address)) {
        $errors[] = 'Address is required';
    }
    if(empty($pincode)) {
        $errors[] = 'Pincode is required';
    }
    

    if(empty($errors)) {
        $stmt2=$pdo->prepare("update students set salutation=?,country_code=?,mobile_number=?,country=?,state=?,city=?,address=?,pincode=?,linkedin=?,whatsapp=? where alt_email=?");
        $stmt2->execute([$salutation,$country_code,$mobile_number,$country,$state,$city,$address,$pincode,$linkedin,$whatsapp,$alt_email]);
        $successMessage = "Profile updated successfully";
    }   
}


$stmt = $pdo->prepare("select * from students where alt_email=? limit 1");
$stmt->execute([$user_name]);
$student = $stmt->fetch();


?>


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <h3 class="text-center">My Profile</h3>
                        <div class="card-body">
                            <center>
                            <?php
                            if(!empty($errors)) {
                                foreach($errors as $error) {
                                    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                                }
                            }
                            if($successMessage) {
                                echo '<div class="alert alert-success" role="alert">'.$successMessage.'</div>';
                            }
                            ?>
                            </center>
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
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $student['first_name'] ?>" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?= $student['last_name'] ?>" readonly>
                                </div>
                                </div>
                                <div class="row">
                                
                                    <div class="col-sm-6">
                                        <label for="alt_email">Alternate Email ID : </label> <input type="email" name="alt_email" id="alt_email" class="form-control" value="<?= $student['alt_email'] ?? $_SESSION['user_name'] ?>" readonly>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="country_code">Country Code <span class="text-danger">*</span></label>
                                        <select name="country_code" id="country_code" class="form-control form-select">
                                        <option value="" selected> - Select Country Code - </option>
                                        <?php
                                        $stmt = $pdo->prepare("SELECT * FROM countries order by country_code");
                                        $stmt->execute();
                                        $country_codes = $stmt->fetchAll();
                                        foreach($country_codes as $cc){
                                            if( $cc["country_code"]==$student['country_code']){
                                            echo '<option value="'.$cc["country_code"].'" selected>'.$cc["country_code"].' - ('.$cc["country_name"].')</option>';
                                            }else{
                                            echo '<option value="'.$cc["country_code"].'">'.$cc["country_code"].' - ('.$cc["country_name"].')</option>';
                                            }  
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="mobile">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="text" name="mobile" id="mobile" class="form-control" value="<?= $student['mobile_number'] ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="counry">Country <span class="text-danger">*</span></label>
                                        <select name="country" id="country" class="form-control form-select">
                                        <option value="" selected> - Select Country - </option>
                                        <?php
                                        $stmt = $pdo->prepare("SELECT * FROM countries");
                                        $stmt->execute();
                                        $countries = $stmt->fetchAll();
                                        foreach($countries as $cc){
                                            if($cc["country_name"] == $student['country']){
                                            echo '<option value="'.$cc["country_name"].'" selected>'.$cc["country_name"].'</option>';
                                            }else{
                                            echo '<option value="'.$cc["country_name"].'">'.$cc["country_name"].'</option>';
                                            }
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="state">State <span class="text-danger">*</span></label>
                                        <input type="text" name="state" id="state" class="form-control" value="<?= $student['state'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-sm-4">
                                    <label for="city">City/Village <span class="text-danger">*</span></label>
                                    <input type="text" name="city" id="city" class="form-control" value="<?= $student['city'] ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label for="address">House/Building No. Street Name and Locality/Area <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address" class="form-control" value="<?= $student['address'] ?>">
                                </div>
                                <div class="col-sm-4">
                                    <label for="pincode">Pincode <span class="text-danger">*</span></label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" value="<?= $student['pincode'] ?>">
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-sm-6">
                                    <label for="linkedin">LinkedIn Profile Address</label>
                                    <input type="text" name="linkedin" id="linkedin" class="form-control" value="<?= $student['linkedin'] ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="whatsapp">Whatsapp <span class="text-danger">*</span></label>
                                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="<?= $student['whatsapp'] ?>">
                                </div>
                                

                                </div>
                                
                                <br>
                                <center>
                                <button class="btn btn-primary d-grid" type="submit" id="register">Update</button>
                                </center>
                            </form>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        
    </div>
</div>
<?php require_once 'bottom.php'; ?>