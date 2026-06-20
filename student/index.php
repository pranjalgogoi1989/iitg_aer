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
                        ?>
                        <span class="badge bg-label-warning me-1">Please verify your email address. After verification your account will activate.</span>
                        <p><button class="btn btn-primary" onclick="requestOTP()">Request Verification Code</button>
                        <center><span id="response" class="text-success text-center"></span></center>
                        <br><input type="text" id="otp" name="otp" placeholder="Enter Verification Code" class="form-control">
                        <br><button class="btn btn-primary" onclick="verifyOTP()">Verify</button>
                        </p>    
                        <?php     
                            }else{
                                echo '<a href="/student/profile.php" class="btn btn-sm btn-outline-primary">View My Profile</a>';
                            }
                        ?> 
                        </p>
                        
                        <?php
                            $status = $row['email_verified'] ?? '';
                            if($status == 1){
                        ?>
                        <h5 class="card-title text-primary">My Application for Alumni card
                        <hr />
                                
                        </h5>
                            <table id="datatable" class="table table-striped table-bordered  nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                    <tr>
                                    <td>Roll No</td>
                                    <td>Name</td>
                                    <td>Mobile No</td>
                                    <td>Department</td>
                                    <td>Programme</td>
                                    <td>Card Type</td>
                                    <td>Status</td>
                                    <td>Updated At</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                    
                            <?php 
                                $stmt = $pdo->prepare("SELECT * FROM applications where alt_email=? order by roll_no asc");
                                $stmt->execute([$_SESSION['email']]);
                                $students = $stmt->fetchAll();
                                foreach ($students as $stud) {
                            ?>
                                <tr>
                                    <td><?php echo $stud['roll_no']?></td>
                                    <td><?php echo $stud['salutation']?> <?php echo $stud['first_name']?> <?php echo $stud['last_name']?></td>
                                    <td><?php echo $stud['mobile_number']?></td>
                                    <td><?php echo $stud['department']?></td>
                                    <td><?php echo $stud['programme']?></td>
                                    <td><?php if($stud['application_status']==''){
                                        echo '-';
                                    }else{
                                        if($stud['receipt']!=''){
                                            echo 'Offline';
                                        }else{
                                            echo 'e-Card';
                                        }
                                    }?></td>
                                    <td><?php echo $stud['application_status']?></td>
                                    <td><?php echo $stud['updated_at']?></td>
                                    <td>
                                            
                                    <?php 
                                    if($stud['submission_stage']<=2){
                                        echo '<a href="apply_card.php?roll_no='.$stud['roll_no'].'" class="btn btn-primary">Edit</a>';
                                    }else{
                                        if($stud['application_status']=='Approved'){
                                            $stm2 = $pdo->prepare("SELECT * FROM accepted_applications where roll_no=?");
                                            $stm2->execute([$stud['roll_no']]);
                                            $stud2 = $stm2->fetch();
                                            if($stud2['status']=='generated'){
                                                $alumni_card = __DIR__ . '/../alumni_cards/' . $stud2['roll_no'] . '.pdf';
                                                if(file_exists($alumni_card)){
                                                    echo '<a href="downloadCard.php?roll_no=' . $stud2['roll_no'] . '" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-download"></i>Download</a>';
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                    
                            </tbody>
                        </table>
                        <?php }?>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>


<?php require_once 'bottom.php'; ?>