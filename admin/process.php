<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
$title='Process Alumni Card Request';
require_once 'header.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';
$roll_no = $_GET['id'];
$stmt = $pdo->prepare("select * from applications where roll_no=?");
$stmt->execute([$roll_no]);
$student = $stmt->fetch();
$processed = false;

$successMessage='';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $remarks = $_POST["remarks"];
    $roll_no = $_POST["roll_no"];
    if (isset($_POST['approve'])) {
        $stmt = $pdo->prepare("INSERT INTO accepted_applications (roll_no, remarks) VALUES (?, ?) ON DUPLICATE KEY UPDATE remarks = ?");
        $stmt->execute([$roll_no, $remarks, $remarks]);
        $stmt = $pdo->prepare("update applications set application_status='Approved' where roll_no=?");
        $stmt->execute([$roll_no]);
        $result1 = sendHTMLMail($student['alt_email'],$student['first_name'],'Alumni Card Approved','templates/card_ready.html',['name' => $student['first_name']]);
    }
    if (isset($_POST['reject'])) {
        $stmt = $pdo->prepare("update applications set application_status='Rejected' where roll_no=?");
        $stmt->execute([$roll_no]);
    }
    $successMessage = "<span class='text-success'>Request Processed Successfully!</span> ";
    $processed = true;
}

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary text-center"><?=$title?></h5>
                            <center><?=$successMessage?></center>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Roll Number </label> : <strong><?=$student['roll_no']?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Full Name </label> : <strong><?=$student['salutation']?> <?=$student['first_name']?> <?=$student['last_name']?></strong>
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
                                    <label for="">Photo</label> : <br>
                                    <img src="<?=$student['photo']?>" height="100px" width="100px">
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Transcript</label> : <br>
                                    <a href="<?=$student['transcript']?>" target="_blank" class="btn btn-primary">View Transcript</a>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Certificate</label> : <br>
                                    <a href="<?=$student['certificate']?>" target="_blank" class="btn btn-primary">View Certificate</a>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Payment Receipt</label> : <br>
                                    <a href="<?=$student['receipt']?>" target="_blank" class="btn btn-primary">View Certificate</a>
                                    
                                </div>
                            </div>

                            
                            <?php
                            if($successMessage=='') {
                            ?>
                            <form action="" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="roll_no" value="<?=$student['roll_no']?>">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="">Remarks</label>
                                        <textarea class="form-control" name="remarks" id="remarks" rows="2"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <center>
                                            <button type="submit" class="btn btn-primary" name="approve">Approve</button>
                                            <button type="submit" class="btn btn-danger" name="reject">Reject</button>
                                        </center>
                                    </div>
                                </div>
                            </form>
                            <?php
                            }
                            ?>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <center>
                                        <a href="/admin/pending.php" class="btn btn-info">Go Back</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'bottom.php'; ?>