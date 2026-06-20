<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('student');
require_once 'header.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
require_once __DIR__ . '/../../mails/master.php';

$rollNo = '';
if(isset($_GET['roll_no'])){
    $rollNo = $_GET['roll_no'];
}
$user_name= $_SESSION['email'];
if(isset($_GET['roll_no'])){
    $stmt = $pdo->prepare("select * from applications where roll_no=?");
    $stmt->execute([$rollNo]);
    $appl = $stmt->fetch();
}
?>
<small><span class="text-danger">*</span> Marked fields are mandatory</small><br />

<br />

<div class="row">
    <div class="col-sm-3 mb-3">
        <label for="iitg_email">IITG Email/ IITG Alumni Email <span class="text-danger">*</span></label>
        <input type="email" name="iitg_email" id="iitg_email" class="form-control" value="<?=$appl['iitg_email'] ?? ''?>" required onblur="checkEmail(this.value)">
        <div id="email_verification_message"></div>
    </div>
    <div class="col-sm-3 mb-3">
        <label for="verification_code">Verification Code <span class="text-danger">*</span></label>
        <input type="text" name="verification_code" id="verification_code" class="form-control" placeholder="Enter Verification Code" required>
    </div>
    <div class="col-sm-3 mb-3">
        <label for="roll_number">Roll Number <span class="text-danger">*</span></label>
        <input type="text" name="roll_number" id="roll_number" class="form-control" value="<?=$appl['roll_no'] ?? ''?>" required>
    </div>
    <div class="col-sm-3 mb-3">
        <label for="department">Department <span class="text-danger">*</span></label>
        <select name="department" id="department" class="form-control form-select" required>
            <option value="" selected> - Select Department - </option>
            <?php
                $stmt = $pdo->prepare("SELECT * FROM departments");
                $stmt->execute();
                $country_codes = $stmt->fetchAll();
                foreach($country_codes as $cc){
                if($cc["dept_name"] == $appl['department'] ?? ''){
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
    <div class="col-sm-4 mb-3">
        <label for="programme">Programme <span class="text-danger">*</span></label>
        <select name="programme" id="programme" class="form-control form-select required">
            <option value="" selected> - Select Programme - </option>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM programmes");
            $stmt->execute();
            $programmes = $stmt->fetchAll();
            foreach($programmes as $cc){
            if ($cc["prog"] == $appl['programme'] ?? '') {
                echo '<option value="'.$cc["prog"].'" selected>'.$cc["programme_name"].'</option>';
            }else{
                echo '<option value="'.$cc["prog"].'">'.$cc["programme_name"].'</option>';
            }
            }
        ?>
        </select>
    </div>
    <div class="col-sm-4 mb-3">
        <label for="joining_year">Year of Joining <span class="text-danger">*</span></label>
        <select name="joining_year" id="joining_year" class="form-control form-select required">
            <option value="" selected> - Select Year of Joining - </option>
            <?php
            for($year = 1994; $year<=date('Y');$year++){
                if ($year == $appl['joining_year'] ?? ''){
                    echo '<option value="'.$year.'" selected>'.$year.'</option>';
                }else{
                    echo '<option value="'.$year.'">'.$year.'</option>';
                }  
            }
        ?>
        </select>
    </div>
    <div class="col-sm-4 mb-3">
        <label for="graduation_year">Year of Graduation <span class="text-danger">*</span></label>
        <select name="graduation_year" id="graduation_year" class="form-control form-select required">
            <option value="" selected> - Select Year of Graduation - </option>
            <?php
            for($year = 1994; $year<=date('Y');$year++){
                if ($year == $appl['graduation_year'] ?? '' ){
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
    <div class="col-sm-4 mb-3">
        <label for="hostel">Hostel <span class="text-danger">*</span></label>
        <select name="hostel" id="hostel" class="form-control form-select required">
            <option value="" selected> - Select Hostel - </option>
            <?php
                $stmt = $pdo->prepare("SELECT * FROM hostel");
                $stmt->execute();
                $hostels = $stmt->fetchAll();
                foreach($hostels as $cc){
                if($cc["hostel_name"]==$appl['hostel'] ?? ''){
                    echo '<option value="'.$cc["hostel_name"].'" selected>'.$cc["hostel_name"].'</option>';
                }else{
                    echo '<option value="'.$cc["hostel_name"].'">'.$cc["hostel_name"].'</option>';
                }
                }
            ?>
        </select>
    </div>
    <div class="col-sm-4 mb-3">
        <label for="linkedin">LinkedIn Profile Address</label>
        <input type="text" name="linkedin" id="linkedin" class="form-control" value="<?=$appl['linkedin'] ?? ''?>">
    </div>
    <div class="col-sm-4 mb-3">
        <label for="whatsapp">Whatsapp <span class="text-danger">*</span></label>
        <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="<?=$appl['whatsapp'] ?? ''?>" required>
    </div>
</div>
<div class="row">
<div class="col-sm-12 alert alert-primary"><b>Other Details</b> </div>


    <div class="col-sm-6 mb-3">
        <label for="organization">Organization</label>
        <input type="text" name="organization" id="organization" class="form-control" value="<?=$appl['organization'] ?? ''?>" >
    </div>
    <div class="col-sm-6 mb-3">
        <label for="designation">Designation</label>
        <input type="text" name="designation" id="designation" class="form-control" value="<?=$appl['designation'] ?? ''?>">
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mb-3">
        <label for="por">Were you associated with any group (IITG Board/Club/HMC/Student Body)? If yes, write your Position of Responsibility (POR)</label>
        <textarea name="por" id="por" rows="2" class="form-control"><?=$appl['por'] ?? ''?></textarea>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 mb-3">
    <label for="next_venture">Details of your next venture or destination if known(Current Job, Position, Name of Company etc.)</label>
    <textarea name="next_venture" id="next_venture" class="form-control" rows="2"><?=$appl['next_venture'] ?? ''?></textarea>
    </div>
</div>

<script>
    function checkEmail(email) {
        $.ajax({
            url: 'forms/verifyIITGEmail.php',
            type: 'POST',
            data: {email: email},
            success: function(response) {
                response = JSON.parse(response);
                if (response.success === true) {
                    $("#email_verification_message").html('<span class="text-success">'+response.message+'</span><br>');
                }else{
                    $("#email_verification_message").html('<span class="text-danger">'+response.message+'</span><br>');
                }
            },
            error: function(response) {
                $("#email_verification_message").html('<span class="text-danger">'+response.message+'</span><br>');
            }
        });
    }
</script>