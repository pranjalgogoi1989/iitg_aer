<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
$title='Apply for Alumni Card';
require_once 'header.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';
$roll_no = $_GET['id'];
$stmt = $pdo->prepare("select * from students where id=?");
$stmt->execute([$roll_no]);
$student = $stmt->fetch();

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary text-center">Student Profile</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Full Name </label> : <strong><?=$student['salutation']?> <?=$student['first_name']?> <?=$student['last_name']?></strong>
                                </div> 
                                <div class="col-sm-6">
                                    <label for="">Alternate Email </label> : <strong><?=$student['alt_email']?> </strong>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="">Whatsapp No. </label> : <strong><?=$student['whatsapp']?></strong>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Country </label> : <strong><?=$student['country']?></strong>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">State </label> : <strong><?=$student['state']?> </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="">City/Village </label> : <strong><?=$student['city']?></strong>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Zip/Postal Code </label> : <strong><?=$student['pincode']?> </strong>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">House/Building Number, Street Name and Locality/Area </label> : <strong><?=$student['address']?></strong>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="">Linkedin Profile </label> : <strong><?=$student['linkedin']?></strong>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Email Verification Status</label> : <strong><?=$student['email_verified']?></strong>
                                </div>
                            </div>
                           
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <center>
                                        <a href="/admin/students.php" class="btn btn-danger">Go Back</a>
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