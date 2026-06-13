<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
$title='Upload Documents and Passport size Photo';
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

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary text-center">Upload Documents and Passport size Photo</h5>
                            <br>
                            <small class="text-danger">Once Applied for Alumni Card, You cannot update/upload the documents</small>
                            <div class="row">
                                <div class="col-sm-6">
                                    <form action="uploadDocument.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                                        <input type="hidden" name="doc_type" id="doc_type" value="photo">
                                        <label for="file">Upload Photo</label>
                                        <input type="file" name="file" class="form-control" accept="image/*" required>
                                        <br>
                                        <?php
                                        if($student["application_status"]!="Applied") {
                                            echo '<button type="submit" name="submit" class="btn btn-primary">Upload</button>';
                                        }
                                        ?>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                        $file = $student['photo'];
                                        if($file!='') {
                                            echo '<img src="'.$file.'" class="img-fluid" alt="Responsive image" width="200" height="200">';
                                        }
                                    ?>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <form action="uploadDocument.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                                        <input type="hidden" name="doc_type" id="doc_type" accept="application/pdf" value="transcript">
                                        <label for="file">Upload Transcript</label>
                                        <input type="file" name="file" class="form-control" required>
                                        <br>
                                         <?php
                                        if($student["application_status"]!="Applied") {
                                            echo '<button type="submit" name="submit" class="btn btn-primary">Upload</button>';
                                        }
                                        ?>
                                        
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <br>
                                    <?php
                                        $file = __DIR__ . $student['transcript'];
                                        if($file!='') {
                                            echo '<a href="'.$file.'" target="_blank" class="btn btn-primary">View Transcript</a>';
                                        }
                                    ?>
                                </div>
                            </div>
                            
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <form action="uploadDocument.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                                        <input type="hidden" name="doc_type" id="doc_type" accept="application/pdf" value="certificate">
                                        <label for="file">Upload Certificate</label>
                                        <input type="file" name="file" class="form-control" required>
                                        <br>
                                         <?php
                                        if($student["application_status"]!="Applied") {
                                            echo '<button type="submit" name="submit" class="btn btn-primary">Upload</button>';
                                        }
                                        ?>
                                        
                                    </form>
                                </div>
                                <div class="col-sm-6 " style="align-items: center;">
                                    <br>
                                    <?php
                                        $file =  $student['certificate'];
                                        if($file!='') {
                                            echo '<a href="'.$file.'" target="_blank" class="btn btn-primary">View Certificate</a>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    Students who tend to apply for the offline AlumniCard need to pay the amount using following details.
                                    <img src="/assets/images/account_details.jpeg" class="img img-responsive" alt="Responsive image" width="100%" height="100%">                                   
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <form action="uploadDocument.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                                        <input type="hidden" name="doc_type" id="doc_type" accept="application/pdf" value="receipt">
                                        <label for="file">Upload Payment Receipt</label>
                                        <input type="file" name="file" class="form-control" required>
                                        <br>
                                        <?php
                                        if($student["application_status"]!="Applied") {
                                            echo '<button type="submit" name="submit" class="btn btn-primary">Upload</button>';
                                        }
                                        ?>
                                        
                                    </form>
                                </div>
                                <div class="col-sm-6 " style="align-items: center;">
                                    <br>
                                    <?php
                                        $file =  $student['receipt'];
                                        if($file!='') {
                                            echo '<a href="'.$file.'" target="_blank" class="btn btn-primary">View Receipt</a>';
                                        }
                                    ?>
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