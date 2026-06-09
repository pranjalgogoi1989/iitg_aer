<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('staff');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Project Details';
require_once 'header.php';

$errors = [];
$successMessage = '';
$project_id= $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$project) {
    $errors[] = "Project details not found";
    exit();
}

?>


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary text-center">Project Details</h5>

<fieldset>
    <div class="row">
        <div class="col-sm-3">
            <label for="">Ref. No. </label> : <strong><?=$project["ref_no"]?></strong>
        </div>
        <div class="col-sm-3">
            <label>Project Category</label>
            : <strong><?=$project["project_type"]?></strong>
            
        </div>
        <div class="col-sm-3">
            <label>Project Title</label>
            : <strong><?=$project["project_title"]?></strong>
        </div>
        <div class="col-sm-3">
            <label for="initiating_engineer">Name of Initiating Engineer</label>
            : <strong><?=$project["initiating_engineer"]?></strong>
        </div>
    </div>
    <br>
    <legend>Controlling Engineer(s)</legend>
      
    <?php
    $stm = $pdo->prepare("select * from controlling_engineers where project_id=? order by sl_no asc");
    $stm->execute([$project["id"]]);
    $controlling_engineers = $stm->fetchAll();
    if(!empty($controlling_engineers)){
        echo '<strong><div class="row bordered" >
            <div class="col-sm-1 font-weight-bold">Sl. No.</div>
            <div class="col-sm-5">Engineer Name</div>
            <div class="col-sm-3">Email</div>
            <div class="col-sm-3">Phone</div>
        </div></strong>';
    }else{
        echo '<div class="row bordered">
        <div class="col-sm-12 font-weight-bold">No Controlling Engineer Added</div>
        </div>';
    }
    foreach($controlling_engineers as $ce){
        echo '<div class="row bordered" >
            <div class="col-sm-1">'.$ce["sl_no"].'</div>
            <div class="col-sm-5">'.$ce["engineer_name"].'</div>
            <div class="col-sm-3">'.$ce["email"].'</div>
            <div class="col-sm-3">'.$ce["phone"].'</div>
        </div>';
    }
    ?>
    <br>
    <legend>Sector/Site Details</legend>
    <div class="row">
        <div class="col-sm-4">
            <label>Sector No</label>
            : <strong><?=$project["sector_no"]?></strong>
        </div>
        <div class="col-sm-4">
            <label>Site Location</label>
            : <strong><?=$project["site_location"]?></strong>
        </div>
        <div class="col-sm-4">
            <label>Description of Work</label>
            : <strong><?=$project["work_description"]?></strong>
        </div>
        
    </div>
    <br>
    <legend>Work Details</legend>
    <div class="row">
        <div class="col-sm-4">
            <label>Type of Work</label>
            : <strong><?=$project["work_type"]?></strong>
        </div>
        <div class="col-sm-4">
            <label>Estimated Value of the project</label>
            : <strong><?=$project["estimated_cost"]?></strong>
        </div>
        <div class="col-sm-4">
            <label>Proposal sent to HOS(m)</label>
            : <strong><?=$project["project_sent_to_hos"]?></strong>
            <?php
                if($project["project_sent_to_hos"] == "Yes"){
                    echo '<a href="/uploads/project/'.$project["ref_no"].'/Project_Proposal.pdf" target="_blank" class="btn btn-primary">Download</a>';
                }
            ?>
        </div>
    </div>
    <br>
    <legend>Milestone(s)</legend>
    <?php
    $stm = $pdo->prepare("select * from milestones where project_id=? order by sl_no asc");
    $stm->execute([$project["id"]]);
    $milestones = $stm->fetchAll();
    if(!empty($milestones)){
        echo '<strong><div class="row">
        <div class="col-sm-1 font-weight-bold">Sl. No.</div>
        <div class="col-sm-3 font-weight-bold">Milestone Name</div>
        <div class="col-sm-2 font-weight-bold">Duration</div>
        <div class="col-sm-2 font-weight-bold">Description</div>
        <div class="col-sm-2 font-weight-bold">Completion Date</div>
        <div class="col-sm-1 font-weight-bold">Bill Date</div>
        <div class="col-sm-1 font-weight-bold">Bill</div>
        </div></strong>';
    }else{
        echo '<div class="row">
        <div class="col-sm-12 font-weight-bold">No Milestone Added</div>
        </div>';
    }
    foreach($milestones as $milestone){
        if($milestone['bill_file']!='-'){
            echo '<div class="row">
                <div class="col-sm-1">'.$milestone["sl_no"].'</div>
                <div class="col-sm-3">'.$milestone["milestone_name"].'</div>
                <div class="col-sm-2">'.$milestone["year"].' year '.$milestone["month"].' month '.$milestone["date"].' day</div>
                <div class="col-sm-2">'.$milestone["description"].'</div>
                <div class="col-sm-2">'.$milestone["milestone_date"].'</div>
                <div class="col-sm-1">'.$milestone["bill_date"].'</div>
                <div class="col-sm-1"><a href="'.$milestone["bill_file"].'" class="btn btn-info" target="_blank">View</a></div>
            </div>';
        }else{
            echo '<div class="row">
                <div class="col-sm-1">'.$milestone["sl_no"].'</div>
                <div class="col-sm-3">'.$milestone["milestone_name"].'</div>
                <div class="col-sm-2">'.$milestone["year"].' year '.$milestone["month"].' month '.$milestone["date"].' day</div>
                <div class="col-sm-2">'.$milestone["description"].'</div>
                <div class="col-sm-2">'.$milestone["milestone_date"].'</div>
                <div class="col-sm-1">'.$milestone["bill_date"].'</div>
                <div class="col-sm-1">'.$milestone["bill_file"].'</div>
            </div>';
        }
    }
    ?>

    <?php
        if($project["submission_stage"]>1){
            echo '<br><legend>Budget & Allocation Details</legend>
            <div class="row">
                <div class="col-sm-6">
                    <label>Budget Booked</label>
                    : <strong>'.$project["budget_booked"].'</strong>
                </div>
                <div class="col-sm-6">
                    <label>Tender/Direct Allotment</label>
                    : <strong>'.$project["tender_direct"].'</strong>
                </div>
            </div>';
        }
    ?>
    <?php
        if($project["submission_stage"]>2){
            echo '<div class="row">
                <div class="col-sm-12">
                    <label>Budget Amount Booked</label>
                    : <strong>'.$project["booked_amount"].'</strong>
                </div>
            </div>';
            if($project["tender_direct"] == "Tender"){
                echo '<div class="row">
                    <div class="col-sm-2">
                        <label>Tender Publish Date</label>
                        : <strong>'.$project["tender_publish_date"].'</strong>
                    </div>
                    <div class="col-sm-2">
                        <label for="bid_opening_date">Date of Technical Bid Opening</label>
                        : <strong>'.$project["bid_opening_date"].'</strong>
                    </div>
                    <div class="col-sm-2">
                        <label for="bid_closing_date">Date of Technical Bid Closing</label>
                        : <strong>'.$project["bid_closing_date"].'</strong>
                    </div>
                    <div class="col-sm-2">
                        <label for="bid_evaluation_date">Date of Technical Bid Evaluation</label>
                        : <strong>'.$project["bid_evaluation_date"].'</strong>
                    </div>
                    <div class="col-sm-2">
                        <label for="price_bid_evaluation_date">Date of Price Bid Evaluation</label>
                        : <strong>'.$project["price_bid_evaluation_date"].'</strong>
                    </div>
                    <div class="col-sm-2">
                        <label for="loi_issue_date">Date of Issue of LOI</label>
                        : <strong>'.$project["loi_issue_date"].'</strong>
                    </div>
                </div>';
                echo '
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="tender_type">Tender Template</label>
                            : <a href="/uploads/project/'.$project["ref_no"].'/tender_document.docx" target="_blank" class="btn btn-primary">Download</a>
                        </div>
                        <div class="col-sm-3">
                            <label for="tender_type">Tender Template(Offline)</label>
                            : <a href="/uploads/project/'.$project["ref_no"].'/offline_tender_document.docx" target="_blank" class="btn btn-primary">Download</a>
                        </div>
                    </div>
                ';
                echo '<br><legend>Technical Bid Details</legend>';
                echo '<strong><div class="row">
                        <div class="col-sm-2">Bider Name</div>
                        <div class="col-sm-2">Address</div>
                        <div class="col-sm-1">Phone</div>
                        <div class="col-sm-2">Email</div>
                        <div class="col-sm-2">GST</div>
                        <div class="col-sm-1">EMD Amount</div>
                        <div class="col-sm-2">EMD Details</div>
                    </div></strong>
                    ';
                               
                $stmt2 = $pdo->prepare("select * from bid_document_details where project_id = ?");
                $stmt2->execute([$project["id"]]);
                $result = $stmt2->fetchAll();     
                foreach($result as $row){
                    echo '<div class="row">';
                    echo '<div class="col-sm-2">' . $row['bider_name'] . '</div>';
                    echo '<div class="col-sm-2">' . $row['bider_address'] . '</div>';
                    echo '<div class="col-sm-1">' . $row['bider_phone'] . '</div>';
                    echo '<div class="col-sm-2">' . $row['bider_email'] . '</div>';
                    echo '<div class="col-sm-2">' . $row['bider_gst'] . '</div>';
                    echo '<div class="col-sm-1">' . $row['emd_amount'] . '</div>';
                    echo '<div class="col-sm-2">' . $row['emd_details'] . '</div>';
                    echo '</div>';
                }
            }
            if($project["tender_direct"] == "Direct"){
                echo '<div class="row">
                    <div class="col-sm-6">
                        <label>Project Duration</label>
                        : <strong>'.$project["project_duration"].'</strong>
                    </div>
                    <div class="col-sm-6">
                        <label>Work Order File</label>
                        : <a href="'.$project["work_order"].'" target="_blank" class="btn btn-primary">Download</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label>Contractor Name</label>
                        : <strong>'.$project["contractor_name"].'</strong>
                        
                    </div>
                    <div class="col-sm-3">
                        <label>Contractor Address</label>
                        : <strong>'.$project["contractor_address"].'</strong>
                        
                    </div>
                    <div class="col-sm-3">
                        <label>Contractor Contact</label>
                        : <strong>'.$project["contractor_phone"].'</strong>
                    </div>
                    <div class="col-sm-3">
                        <label>Contractor Email</label>
                        : <strong>'.$project["contractor_email"].'</strong>
                    </div>
                </div>';
            }


            if($project["submission_stage"] >= "5" && $project["tender_direct"]=="Tender"){
                echo '<div class="row">
                        <div class="col-sm-2">
                            <label>Project Duration</label>
                            : <strong>'.$project["project_duration"].'</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Work Order</label>
                            : <a href="'.$project["work_order"].'" target="_blank" class="btn btn-primary">Download</a>
                        </div>
                        <div class="col-sm-3">
                            <label>LOI Format</label>
                            : <a href="/uploads/project/'.$project["ref_no"].'/LOI_Format.pdf" target="_blank" class="btn btn-primary">Download</a>
                        </div>
                        <div class="col-sm-3">
                            <label>Note Sheet</label>
                            : <a href="/uploads/project/'.$project["ref_no"].'/Note_Sheet.pdf" target="_blank" class="btn btn-primary">Download</a>
                        </div>
                        <div class="col-sm-3">
                            <label> Performance_Guarentee</label>
                            : <a href="/uploads/project/'.$project["ref_no"].'/Performance_Guarentee.pdf" target="_blank" class="btn btn-primary">Download</a>
                        </div>
                    </div>

                <div class="row">
                    <div class="col-sm-3">
                        <label>Contractor Name</label>
                        : <strong>'.$project["contractor_name"].'</strong>
                        
                    </div>
                    <div class="col-sm-3">
                        <label>Contractor Address</label>
                        : <strong>'.$project["contractor_address"].'</strong>
                        
                    </div>
                    <div class="col-sm-3">
                        <label>Contractor Contact</label>
                        : <strong>'.$project["contractor_phone"].'</strong>
                    </div>
                    <div class="col-sm-3">
                        <label>Contractor Email</label>
                        : <strong>'.$project["contractor_email"].'</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label>GST Details</label> : <strong>'.$project["gst_details"].'</strong>
                    </div>
                    <div class="col-sm-3">
                        <label>EMD Amount</label>: <strong>'.$project["emd_amount"].'</strong>
                    </div>
                    <div class="col-sm-6">
                        <label>EMD Details</label>: <strong>'.$project["emd_details"].'</strong>
                    </div>
                </div>
                ';
            }
        }
    ?>
   
</fieldset>
<br>
<legend>IA Details</legend>
<?php
if($project["ia_vetting"]!="No"){
    $stm = $pdo->prepare("select * from ia_vetting where project_ref_no=? order by in_date asc");
    $stm->execute([$project["ref_no"]]);
    $project_ia = $stm->fetchAll();
    if(!empty($project_ia)){
        echo '<div class="row">
            <div class="col-sm-3">IA Description</div>
            <div class="col-sm-3">IA Date</div>
            <div class="col-sm-3">IA Status</div>
            <div class="col-sm-3">IA Remarks</div>
        </div>';
    }
    if(empty($project_ia)){
        echo '<div class="row">
            <div class="col-sm-12 font-weight-bold">No IA Vetting Carried Out till now.</div>
            </div>';
    }
    foreach($project_ia as $ia){
        echo '<div class="row">
            <div class="col-sm-3">'.$ia["description"].'</div>
            <div class="col-sm-3">'.$ia["in_date"].'</div>
            <div class="col-sm-3">'.$ia["status"].'</div>
            <div class="col-sm-3">'.$ia["remarks"].'</div>
        </div>';
    }
}else{
    echo '<div class="row">
        <div class="col-sm-12 font-weight-bold">No IA Vetting Required</div>
        </div>';
}
?>
<br>
<legend>Project Remarks</legend>
<?php
$stm = $pdo->prepare("select * from project_remarks where project_id=? order by id asc");
$stm->execute([$project["id"]]);
$project_remarks = $stm->fetchAll();
if(!empty($project_remarks)){
    echo '<strong><div class="row">
    <div class="col-sm-1 font-weight-bold">Sl. No.</div>
    <div class="col-sm-3 font-weight-bold">Date</div>
    <div class="col-sm-2 font-weight-bold">Remark By</div>
    <div class="col-sm-6 font-weight-bold">Remark</div>
    </div></strong>';
}else{
    echo '<div class="row">
    <div class="col-sm-12 font-weight-bold">No Remarks Added</div>
    </div>';
}
$count = 0;
foreach($project_remarks as $pr){
    $count++;
    echo '<div class="row">
        <div class="col-sm-1">'.$count.'</div>
        <div class="col-sm-3">'.$pr["created_at"].'</div>
        <div class="col-sm-2">'.$pr["submitted_by"].'</div>
        <div class="col-sm-6">'.$pr["remarks"].'</div>
    </div>';
}
?>
<br>
<center>
    <a href="all_projects.php" class="btn btn-primary">Back</a>
</center>


                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>
<script>

</script>
<?php require_once 'bottom.php'; ?>
