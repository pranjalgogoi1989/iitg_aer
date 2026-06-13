<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
$title='Apply for Alumni Card';
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

$successMessage='';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $stmt = $pdo->prepare("update students set application_status='Applied' where roll_no=?");
    $stmt->execute([$student['roll_no']]);
    $successMessage = "Application submitted successfully";
}

$stmt = $pdo->prepare("select * from students where alt_email=?");
$stmt->execute([$user_name]);
$student = $stmt->fetch();
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary text-center">Apply for Alumni Card</h5>
                            <center>
                                <?php
                                    if($successMessage!='') {
                                        echo '<div class="alert alert-success">'.$successMessage.'</div>';
                                    }
                                ?>
                            </center>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Roll Number </label> : <strong><?=$student['roll_no']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Full Name </label> : <strong><?=$student['first_name']?> <?=$student['last_name']?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Department/Section/Centre </label> : <strong><?=$student['department']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Programme </label> : <strong><?=$student['programme']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">IITG Email ID </label> : <strong><?=$student['iitg_email']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Alternate Email </label> : <strong><?=$student['alt_email']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Country Code </label> : <strong><?=$student['country_code']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Mobile Number </label> : <strong><?=$student['mobile_number']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Whatsapp No. </label> : <strong><?=$student['whatsapp']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Year of Joining </label> : <strong><?=$student['joining_year']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Year of Graduation </label> : <strong><?=$student['graduation_year']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Hostel </label> : <strong><?=$student['hostel']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Country </label> : <strong><?=$student['country']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">State </label> : <strong><?=$student['state']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">City/Village </label> : <strong><?=$student['city']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Zip/Postal Code </label> : <strong><?=$student['pincode']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">House/Building Number, Street Name and Locality/Area </label> : <strong><?=$student['address']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Were you associated with any group (IITG Board/Club/HMC/Student Body)? If yes, write your Position of Responsibility (POR) </label> : <strong><?=$student['por']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="">Linkedin Profile </label> : <strong><?=$student['linkedin']?></strong>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Organization </label> : <strong><?=$student['organization']?> </strong>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Designation </label> : <strong><?=$student['designation']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Details of your next venture or destination (if known) </label> : <strong><?=$student['next_venture']?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="">Photo</label> : <strong><?=$student['photo'] ? 'Uploaded':'Not Uploaded'?></strong>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Transcript</label> : <strong><?=$student['transcript'] ? 'Uploaded':'Not Uploaded'?></strong>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Certificate</label> : <strong><?=$student['certificate'] ? 'Uploaded':'Not Uploaded'?></strong>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Payment Receipt</label> : <strong><?=$student['receipt'] ? 'Uploaded':'Not Uploaded'?></strong>
                                </div>
                            </div>

                            <p class="mb-4">
                            <label>Email Verification Status:</label> <strong><?=$student['email_verified'] ?></strong>
                            <?php
                                $status = $student['email_verified'];
                                if($status != 'Verified'){
                                    echo '<a class="btn btn-primary" href="profile.php">Goto Email Verification</a>';
                                
                                }
                            ?>
                            </p>
                            <?php
                                if($student['email_verified'] == 'Verified' && $student['photo']!=null && $student['transcript']!=null && $student['certificate'] != null && $student['application_status'] != 'Applied' && $student['application_status']!='Rejected'){
                            ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <center>
                                            <form action="" method="post">
                                                <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                                                <input type="submit" name="submit" class="btn btn-primary" value="Apply for Card">
                                            </form>
                                        </center>
                                    </div>
                                </div>

                            <?php
                                }
                                if($student['application_status'] == 'Applied'){
                            ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <center>
                                            <div class="alert alert-success">Your Application is Under Process</div>
                                        </center>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'bottom.php'; ?>