<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
$title='Apply for Alumni Card';
require_once 'header.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';

$rollno='';
if(isset($_GET['roll_no'])){
    $rollno= $_GET['roll_no'];
}

$user_name= $_SESSION['email'];
$stmt=$pdo->prepare('select * from users where email=?');
$stmt->execute([$user_name]);
$row = $stmt->fetch();

$stmt3=$pdo->prepare('select * from students where alt_email=?');
$stmt3->execute([$user_name]);
$row3 = $stmt3->fetch();

if(isset($_GET['roll_no'])){
    $stmt = $pdo->prepare("select * from applications where roll_no=?");
    $stmt->execute([$rollno]);
    $student = $stmt->fetch();
}
?>

<style>
    .wizard-container{
        margin:auto;
    }
    .tab-content{
        border:1px solid #dee2e6;
        border-top:none;
        padding:20px;
        border-radius:0 0 10px 10px;
    }
    .nav-pills .nav-link{
        border-radius:0;
        padding:15px;
    }
</style>
<div class="container-fluid wizard-container flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        
        <?Php if($row3['profile_status']=='CMP'){?>
            <div class="card">
                <div class="d-flex align-items-end row">
                 <div class="card-body">

                     <div class="row"> <div class="col-sm-12 alert alert-primary"><h4> Apply New Card </h4> </div>  </div>

                    
                    <ul class="nav nav-pills nav-fill mb-0" id="wizardTabs">
                        <li class="nav-item">
                            <button class="nav-link active" id="step1-tab" data-bs-toggle="pill" data-bs-target="#step1"> <?= ($rollno && $student['submission_stage']>='1') ? '✓ Step 1 - Basic Details' : 'Step 1 - Basic Details'?></button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="step2-tab" data-bs-toggle="pill" data-bs-target="#step2" <?= ($rollno && $student['submission_stage']>='1') ? '' : 'disabled' ?> > <?= ($rollno && $student['submission_stage']>='2') ? '✓ Step 2 - Documents Upload' : 'Step 2 - Documents Upload'?> </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="step3-tab" data-bs-toggle="pill" data-bs-target="#step3" <?= ($rollno && $student['submission_stage']>='2') ? '' : 'disabled' ?>><?= ($rollno && $student['submission_stage']>='3') ? '✓ Step 3 - Preview and Submit' : 'Step 3 - Preview and Submit'?>  </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="step1">
                            <form id="step1Form">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                                <?php include('forms/form1.php'); ?>
                                <br>
                                <center>
                                <button type="submit" class="btn btn-primary">Save & Continue</button>
                                </center>
                            </form>
                        </div>
                        <!-- STEP 2 -->
                        <div class="tab-pane fade" id="step2">
                            <form id="step2Form" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                <input type="hidden" name="application_id" id="application_id" value="<?= $student['application_id'] ?? (isset($_GET['roll_no'])?$_GET['roll_no']:'') ?>">
                                <?php include('forms/upload_form.php'); ?>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="step3">
                            <form id="step3Form">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                <input type="hidden" name="application_id2" id="application_id2" value="<?= $student['application_id'] ?? (isset($_GET['roll_no'])?$_GET['roll_no']:'') ?>">
                            <?php include('forms/preview.php'); ?>

                            <br>
                            <center>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </center>
                            </form>
                        </div>
                    </div>
                   </div> 
                </div>
            </div>
            
            <?Php }else{?>
            <div class="card">
            <div class="d-flex align-items-end row">
                 <div class="card-body">
                 <h4 class="alert alert-warning"> Please Update Your Profile First! <a href="profile.php" class="btn btn-sm btn-danger"><b>Click here</b></a></h4>
                 </div>
                 </div>
            </div>
            
            <?Php }?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

document.getElementById("step1Form").addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(this);
    console.log(formData);
    fetch("forms/submit_form1.php",{
        method:"POST",
        body:formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === "success"){
            document.getElementById("step2-tab").removeAttribute("disabled");
            document.getElementById("application_id").value = data.application_id;
            document.getElementById("step1-tab").innerHTML ='✓ Step 1 - Basic Details';
            bootstrap.Tab.getOrCreateInstance(document.getElementById('step2-tab')).show();
        }else{
            alert(data.message);
        }
    });
});
document.getElementById("step2Form").addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(this);
    fetch("forms/submit_form2.php",{
        method:"POST",
        body:formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === "success"){
            document.getElementById("step3-tab").removeAttribute("disabled");
            document.getElementById("application_id2").value = data.application_id;
            document.getElementById("step2-tab").innerHTML ='✓ Step 2 - Documents Upload';
            bootstrap.Tab.getOrCreateInstance(document.getElementById('step3-tab')).show();
        }else{
            alert(data.message);
        }
    });
});
document.getElementById("step3Form").addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(this);
    fetch("forms/submit_form3.php",{
        method:"POST",
        body:formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === "success"){
            document.getElementById("step3-tab").innerHTML ='✓ Step 3 - Preview and Submit';
            alert("Application Submitted successfully");
            window.location.href='index.php';
        }else{
            alert(data.message);
        }
    });
});
</script>
<?php require_once 'bottom.php'; ?>