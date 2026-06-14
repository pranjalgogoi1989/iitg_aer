<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
$title='My Profile';
require_once 'header.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';


$user_name= $_SESSION['email'];
$stmt=$pdo->prepare('select * from users where email=?');
$stmt->execute([$user_name]);
$row = $stmt->fetch();


$stmt = $pdo->prepare("select * from students where alt_email=?");
$stmt->execute([$user_name]);
$student = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);

    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validation
    if (strlen($old_password) < 3) {
        $errors[] = "Old Password must be at least 3 characters.";
    }
    if (strlen($new_password) < 3) {
        $errors[] = "New Password must be at least 3 characters.";
    }
    if($old_password == $new_password){
        $errors[] = "Old Password and New Password cannot be same.";
    }
    if ($new_password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if old password is correct
    if (!password_verify($old_password, $row['password'])) {
        $errors[] = "Old Password is incorrect.";
    }
    if (empty($errors)) {
        $stmt = $pdo->prepare("update users set password=? where email=?");
        $stmt->execute([password_hash($new_password, PASSWORD_DEFAULT), $user_name]);
        $successMessage = "Password updated successfully";
        $result = sendHTMLMail($row["email"],$row["name"],$successMessage,'templates/password_change.html',['name' => $row["name"],'email'=> $row["email"],'password'=> $new_password]);

        echo "<div class='alert alert-success'>Password updated successfully</div>";
        exit();
    } else {
        echo "<div class='alert alert-danger'>".implode("<br>", $errors)."</div>";
    }
}
?>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background: #fff;
        margin: auto;
        padding: 20px;
        width: 400px;
        border-radius: 8px;
    }

    .close {
        float: right;
        cursor: pointer;
        font-size: 22px;
    }

    #response {
        margin-top: 10px;
        font-weight: bold;
    }
</style>
<script>
function requestOTP() {
    $("#response").html("Requesting OTP...");
    $.ajax({
        url: 'email_verification.php',
        type: 'POST',
        success: function(data) {
            $("#response").html(data);
            window.location.reload();
        },
        error: function() {
            $("#response").html("Request failed");
        }
    });
}

function verifyOTP() {
    var otp=$('#otp').val();
    $.ajax({
        url: 'email_verify.php',
        type: 'POST',
        data: {otp: otp},
        success: function(data) {
            $("#response").html('Verification Code sen to your email.');
        },
        error: function() {
            $("#response").html("Request failed");
        }
    });
}
</script>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-7 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary text-center">My Profile</h5>
                            <p class="mb-4">
                            <span class="fw-bold">Name:</span> <?=$student['salutation']." ". $student['first_name']." ".$student['last_name'] ?>
                            </p>
                            <p class="mb-4">
                            <span class="fw-bold">Email:</span> <?=$row['email'] ?>
                            </p>
                            <p class="mb-4">
                            <span class="fw-bold">Email Verification Status:</span> <?=$student['email_verified'] ?>
                            <?php
                                $status = $student['email_verified'];
                                if($status == 'pending'){
                                    echo '<button class="btn btn-primary" onclick="requestOTP()">Request Verification Code</button>';
                                
                                }
                            ?>
                            </p>
                            <center><span id='response'class="text-success text-center"></span></center>
                            <?php
                                if($status=='pending'){
                                    echo '<input type="text" id="otp" placeholder="Enter Verification Code" class="form-control"><button class="btn btn-primary" onclick="verifyOTP()" id="verify">Verify</button>';
                                }
                            ?>
                            

                            <?php
                                $stmtls = $pdo->prepare("select * from accepted_applications where roll_no=?");
                                $stmtls->execute([$student['roll_no']]);
                                $ls = $stmtls->fetch();
                                if($ls){
                                    if($ls['status']=='generated'){
                                        echo '<p class="mb-4">
                                        <span class="fw-bold">Alumni Card Status:</span> <a href="downloadCard.php" class="btn btn-primary">Download</a>
                                        </p>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary text-center">Change Password</h5>
                            <form action="" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Old Password</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" required>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                <center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'bottom.php'; ?>