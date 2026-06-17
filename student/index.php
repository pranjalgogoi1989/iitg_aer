<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
$title='Dashboard';
require_once 'header.php';

require_once __DIR__ . '/../config/config.php';
$user_name= $_SESSION['email'];
$stmt=$pdo->prepare('select * from users where email=?');
$stmt->execute([$user_name]);
$row = $stmt->fetch();
?>

<script>
function requestOTP() {
    $("#response").html("Requesting OTP...");
    $.ajax({
        url: '/student/email_verification.php',
        type: 'POST',
        success: function(data) {
            $("#response").html(data);
        },
        error: function() {
            $("#response").html("Request failed");
        }
    });
}

function verifyOTP() {
    var otp=$('#otp').val();
    $.ajax({
        url: '/student/email_verify.php',
        type: 'POST',
        data: {otp: otp},
        success: function(data) {
            $("#response").html('Account Verified.');
            window.location.reload();
        },
        error: function() {
            $("#response").html("Request failed");
        }
    });
}
</script>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <div class="card-body">
                <h5 class="card-title text-primary">User Dashboard</h5>
                <p class="mb-4">
                    Welcome to IITG Alumni Registration Portal. 
                </p>
                <p>
                    <?php
                        $status = $row['email_verified'] ?? '';
                        if($status == 0){
                            echo '<span class="badge bg-label-warning me-1">Please verify your email address. After verification you can apply for Alumni Card.</span>';
                            echo '<br><button class="btn btn-primary" onclick="requestOTP()">Request Verification Code</button>';
                            echo '<center><span id="response" class="text-success text-center"></span></center>';
                            echo '<input type="text" id="otp" name="otp" placeholder="Enter Verification Code" class="form-control">';
                            echo '<button class="btn btn-primary" onclick="verifyOTP()">Verify</button>';
                        }else{
                            echo '<a href="/student/profile.php" class="btn btn-sm btn-outline-primary">View My Profile</a>';
                        }
                    ?>
                </p>
                </div>
            </div>
            
            </div>
        </div>
    </div>
</div>


<?php require_once 'bottom.php'; ?>