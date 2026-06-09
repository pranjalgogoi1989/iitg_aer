<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('staff');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='New Project';
require_once 'header.php';

$errors = [];
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token'] ?? '');
    $project_category = trim($_POST['project_category'] ?? '');
    $project_title = trim($_POST['project_title'] ?? '');
    $initiating_engineer = trim($_POST['initiating_engineer'] ?? '');
    $controlling_engineer_count=trim($_POST['controlling_engineer_count'] ?? '');
    $sector_no=trim($_POST['sector_no'] ?? '');
    $site_location=trim($_POST['site_location'] ?? '');
    $work_description=trim($_POST['work_description'] ?? '');
    $work_type=trim($_POST['work_type'] ?? '');
    $work_estimate=trim($_POST['work_estimate'] ?? '');
    $proposal_sent_hos=trim($_POST['proposal_sent_hos'] ?? '');
    $milestone=trim($_POST['milestone'] ?? '');
    $milestone_count=trim($_POST['milestone_count'] ?? '');

    if ($project_category === '') {
        $errors[] = "Project category is required";
    }
    if ($project_title === '') {
        $errors[] = "Project title is required";
    }
    if ($initiating_engineer === '') {
        $errors[] = "Initiating engineer is required";
    }
    if($controlling_engineer_count>0){
        for($i=1; $i<=$controlling_engineer_count; $i++){
            $engineer1 = trim($_POST['engineer_name_'.$i] ?? '');
            $engineer_email = trim($_POST['engineer_email_'.$i] ?? '');
            $engineer_phone = trim($_POST['engineer_phone_'.$i] ?? '');
            if ($engineer1 === '') {
                $errors[] = "Controlling engineer $i is required";
            }
            if ($engineer_email === '') {
                $errors[] = "Controlling engineer email $i is required";
            }
            if ($engineer_phone === '') {
                $errors[] = "Controlling engineer phone $i is required";
            }
        }
    }
    if($sector_no === ''){
        $errors[] = "Sector no is required";
    }
    if($site_location === ''){
        $errors[] = "Site location is required";
    }
    if($work_description === ''){
        $errors[] = "Work description is required";
    }
    if($work_type === ''){
        $errors[] = "Work type is required";
    }
    if($work_estimate === ''){
        $errors[] = "Work estimate is required";
    }
    if($proposal_sent_hos === ''){
        $errors[] = "Proposal sent hos is required";
    }
    if($milestone >0){
        for($i=1; $i<=$milestone_count; $i++){
            $milestone_name = trim($_POST['milestone_name_'.$i] ?? '');
            $milestone_date = trim($_POST['milestone_date_'.$i] ?? '');
            $milestone_description = trim($_POST['milestone_description_'.$i] ?? '');
            if ($milestone_name === '') {
                $errors[] = "Milestone name $i is required";
            }
            if ($milestone_date === '') {
                $errors[] = "Milestone date $i is required";
            }
            if ($milestone_description === '') {
                $errors[] = "Milestone description $i is required";
            }
        }
    }
    $ref_no = uniqid();
    $submission_stage='1';
    if (empty($errors)) {
        $stmt= $pdo->prepare('INSERT INTO projects(ref_no,project_type,project_title,initiating_engineer,sector_no,site_location,work_description,work_type,estimated_cost,project_sent_to_hos,milestone_available,controlling_engineer,submission_stage)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);;');
        $stmt->execute([$ref_no,$project_category,$project_title,$initiating_engineer,$sector_no,$site_location,$work_description,$work_type,$work_estimate,$proposal_sent_hos,$milestone,$controlling_engineer_count,$submission_stage]);

        $insertId = $pdo->lastInsertId();
        if($controlling_engineer_count>0){
            for($i=1;$i<=$controlling_engineer_count;$i++){
                $engineer1 = trim($_POST['sl_no_'.$i] ?? '');
                $engineer_name = trim($_POST['engineer_name_'.$i] ?? '');
                $engineer_email = trim($_POST['engineer_email_'.$i] ?? '');
                $engineer_phone = trim($_POST['engineer_phone_'.$i] ?? '');
                $stmt = $pdo->prepare(
                    "INSERT INTO controlling_engineers(sl_no,engineer_name,email,phone,project_id)VALUES(?,?,?,?,?);"
                );
                $stmt->execute([$engineer1, $engineer_name,$engineer_email,$engineer_phone,$insertId]);
            }
        }
        if($milestone_count>0){
            for($i=1; $i<=$milestone_count; $i++){
                $milestone_sl_no = trim($_POST['milestone_sl_no_'.$i] ?? '');
                $milestone_name = trim($_POST['milestone_name_'.$i] ?? '');
                $milestone_date = trim($_POST['milestone_date_'.$i] ?? '');
                $milestone_description = trim($_POST['milestone_description_'.$i] ?? '');
                $stmt = $pdo->prepare(
                    "INSERT INTO milestones(sl_no,milestone_name,milestone_date,description,project_id)VALUES(?,?,?,?,?);"
                );
                $stmt->execute([$milestone_sl_no,$milestone_name, $milestone_date,$milestone_description,$insertId]);
            }
        }
        $successMessage = "Project details validated and submitted successfully.";
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

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary text-center">New Project</h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
<fieldset>

    <div class="row">
        <div class="col-sm-4">
            <label>Project Category</label>
            <select class="form-control" name="project_category" id="project_category">
                <option value="Capital">Capital Work</option>
                <option value="Maintenance">MainTenance work</option>
                <option value="AMC">AMC Work</option>
            </select>
            
        </div>
        <div class="col-sm-4">
            <label>Project Title</label>
            <input type="text" class="form-control" name="project_title" />
        </div>
        <div class="col-sm-4">
            <label for="initiating_engineer">Name of Initiating Engineer</label>
            <select class="form-control" name="initiating_engineer" id="initiating_engineer">
                <option value="" selected>-- Select --</option>
                <?php
                    $stmt = $pdo->prepare("select * from users where role=?");
                    $stmt->execute(['engineer']);
                    $engineer = $stmt->fetchAll();
                    foreach($engineer as $en){
                        echo '<option value="'.$en["name"].'">'.$en["name"].'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <br>
    <legend>Controlling Engineer(s)</legend>
    <input type="hidden" id="controlling_engineer_count" name="controlling_engineer_count" class="form-control" value="0">
    <button type="button" class="btn btn-primary btn-sm text-white right" onclick="addControllingEngineer()">Add Controlling Engineer</button>
    <button type="button" class="btn btn-danger btn-sm" onclick="removeControllingEngineer()">Remove Last Row</button>
    <div id="controlling_engineer_header" style="display:none">
        <div class="row" >
            <div class="col-sm-1 font-weight-bold">Sl. No.</div>
            <div class="col-sm-5">Engineer Name</div>
            <div class="col-sm-3">Email</div>
            <div class="col-sm-3">Phone</div>
        </div>
    </div>
    <div id="controlling_engineer">
    </div>
                
    <br>
    <legend>Sector/Site Details</legend>
    <div class="row">
        <div class="col-sm-4">
            <label>Sector No</label>
            <input type="text" class="form-control" name="sector_no" />
        </div>
        <div class="col-sm-4">
            <label>Site Location</label>
            <select class="form-control" name="site_location" id="site_location">
                <option value="" selected>-- Select --</option>
                <option value="site_1">Site 1</option>
            </select>
        </div>
        <div class="col-sm-4">
            <label>Description of Work</label>
            <textarea name="work_description" class="form-control" id="work_description"></textarea>
        </div>
        
    </div>
    <br>
    <legend>Work Details</legend>
    <div class="row">
        <div class="col-sm-4">
            <label>Type of Work</label>
            <select class="form-control" name="work_type" id="work_type">
                <option value="" selected>-- Select --</option>
                <?php
                    $stmt = $pdo->prepare("select * from work_type");
                    $stmt->execute();
                    $work_type = $stmt->fetchAll();
                    foreach($work_type as $wt){
                        echo '<option value="'.$wt["work_type_name"].'">'.$wt["work_type_name"].'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col-sm-4">
            <label>Estimated Value of the project</label>
            <input type="text" class="form-control" name="work_estimate" id="work_estimate" value="0">
        </div>
        <div class="col-sm-4">
            <label>Proposal sent to HOS(m)</label>
            <select class="form-control" name="proposal_sent_hos" id="proposal_sent_hos">
                <option value="" selected>-- Select --</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
    </div>
    <br>
    <legend>Milestone(s)</legend>
    <input type="radio" name="milestone" id="milestone_yes" value="1" onclick="milestone_add(1)"> Yes 
    <input type="radio" name="milestone" id="milestone_no" value="0" onclick="milestone_add(0)" checked> No <br>
    <div id="milestone_header_display_button" style="display:none">
        <input type="hidden" id="milestone_count" name="milestone_count" class="form-control" value="0">
        <button type="button" class="btn btn-primary btn-sm text-white right" onclick="addMilestone()">Add Milestone</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeMilestone()">Remove Last Row</button>
        <div class="row">
            <div class="col-sm-1 font-weight-bold">Sl. No.</div>
            <div class="col-sm-3 font-weight-bold">Milestone Name</div>
            <div class="col-sm-2 font-weight-bold">Completion Date</div>
            <div class="col-sm-6 font-weight-bold">Description</div>
        </div>
        <div class="row" id="milestone_list">
    
        </div>
    </div>
    
</fieldset>
<br>
<center>
    <input type="submit"  class="btn btn-primary" value="Submit" />
</center>
</form>


                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>
<script>


    function addControllingEngineer() {
        var count = parseInt(document.getElementById("controlling_engineer_count").value, 10) || 0;
        count++;
        document.getElementById("controlling_engineer_count").value = count;
        if(count>0){
            document.getElementById("controlling_engineer_header").style.display = "block";
        }
        var object = `
        <div class="row mt-2" id="row_${count}">
            <div class="col-sm-1">
                <input type="text" id="sl_no_${count}" name="sl_no_${count}" class="form-control" readonly value="${count}">
            </div>
            <div class="col-sm-5">
                <input type="text" id="engineer_name_${count}" name="engineer_name_${count}" class="form-control">
            </div>
            <div class="col-sm-3">
                <input type="email" id="engineer_email_${count}" name="engineer_email_${count}" class="form-control">
            </div>
            <div class="col-sm-3">
                <input type="text" id="engineer_phone_${count}" name="engineer_phone_${count}" class="form-control">
            </div>
           
        </div>`;
        document.getElementById("controlling_engineer").insertAdjacentHTML('beforeend', object);
    }
    function removeControllingEngineer(){
        var count = parseInt(document.getElementById("controlling_engineer_count").value, 10) || 0;
        var row = document.getElementById("row_" + count);
        if (row) {
            row.remove();
        }
        count = Math.max(0, count - 1);
        document.getElementById("controlling_engineer_count").value = count;
        if(count == 0){
            document.getElementById("controlling_engineer_header").style.display = "none";
        }

    }
    function milestone_add(val){
        if(val==1){
            document.getElementById("milestone_header_display_button").style.display = "block";
        }
        else{
            document.getElementById("milestone_header_display_button").style.display = "none";
        }
    }
    function addMilestone(){
        var count = parseInt(document.getElementById("milestone_count").value, 10) || 0;
        count++;
        document.getElementById("milestone_count").value = count;
        var object = `
        <div class="row mt-2" id="milestone_row_${count}">
            <div class="col-sm-1">
                <input type="text" id="milestone_sl_no_${count}" name="milestone_sl_no_${count}" class="form-control" readonly value="${count}">
            </div>
            <div class="col-sm-3">
                <input type="text" id="milestone_name_${count}" name="milestone_name_${count}" class="form-control">
            </div>
            <div class="col-sm-2">
                <input type="date" id="milestone_date_${count}" name="milestone_date_${count}" class="form-control">
            </div>
            <div class="col-sm-6">
                <input type="text" id="milestone_description_${count}" name="milestone_description_${count}" class="form-control">
            </div>
        </div>`;
        document.getElementById("milestone_list").insertAdjacentHTML('beforeend', object);
    }
    function removeMilestone(){
        var count = parseInt(document.getElementById("milestone_count").value, 10) || 0;
        var row = document.getElementById("milestone_row_" + count);
        if (row) {
            row.remove();
        }
        count = Math.max(0, count - 1);
        document.getElementById("milestone_count").value = count;
        if(count == 0){
            document.getElementById("milestone_header_display_button").style.display = "none";
            document.getElementById("milestone_no").click();
        }
    }
</script>
<?php require_once 'bottom.php'; ?>
