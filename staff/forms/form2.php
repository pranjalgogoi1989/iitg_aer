<legend>Project Processing</legend>
<form action="submit_form/submit_form2.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" name="project_id" value="<?=$project["id"]?>">
    
    # An email will be sent to initiating engineer upon processing

    <div class="row">
        <div class="col-sm-6">
            <label>Project Duration</label>
            <input type="text" class="form-control" name="project_duration" id="project_duration" value="" required>
        </div>
        <div class="col-sm-6">
            <label>Work Order File</label> : <br>
            # work order file will be generated automatically
        </div>
    </div>
    # Selected Bider Details
    <div class="row">
        <div class="col-sm-3">
            <label>Contractor Name</label>
            <input type="text" class="form-control" name="contractor_name" id="contractor_name" required>
        </div>
        <div class="col-sm-3">
            <label>Contractor Address</label>
            <input type="text" class="form-control" name="contractor_address" id="contractor_address" required>
        </div>
        <div class="col-sm-3">
            <label>Contractor Contact</label>
            <input type="text" class="form-control" name="contractor_contact" id="contractor_contact" required>
        </div>
        <div class="col-sm-3">
            <label>Contractor Email</label>
            <input type="text" class="form-control" name="contractor_email" id="contractor_email" required>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label>Contractor GST Details</label>
            <input type="text" class="form-control" name="gst_details" id="gst_details" required>
        </div>
        <div class="col-sm-3">
            <label>EMD Amount</label>
            <input type="text" class="form-control" name="emd_amount" id="emd_amount" required>
        </div>           
        <div class="col-sm-6">
            <label>EMD Details</label>
            <input type="text" class="form-control" name="emd_details" id="emd_details" required>
        </div>
    </div>
    <h5>Milestone Details</h5>
    <?php
        $msts = $pdo->prepare("select * from milestones where project_id=? order by sl_no asc");
        $msts->execute([$project["id"]]);
        $milestones = $msts->fetchAll();
        if(!empty($milestones)){
            echo '<strong><div class="row">
                <div class="col-sm-1 font-weight-bold">Sl. No.</div>
                <div class="col-sm-2 font-weight-bold">Milestone Name</div>
                <div class="col-sm-2 font-weight-bold">Milestone Date</div>
                <div class="col-sm-3 font-weight-bold">Milestone Description</div>
                <div class="col-sm-2 font-weight-bold">Milestone Completion Date</div>
                <div class="col-sm-2 font-weight-bold">Bill Generation Date</div>
            </div></strong>';
        }
        foreach($milestones as $milestone){
            echo '<div class="row">
                <div class="col-sm-1">'.$milestone["sl_no"].'</div>
                <div class="col-sm-2">'.$milestone["milestone_name"].'</div>
                <div class="col-sm-2">'.$milestone["milestone_date"].'</div>
                <div class="col-sm-3">'.$milestone["description"].'</div>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="milestone_completion_date_'.$milestone["sl_no"].'" id="milestone_completion_date_'.$milestone["sl_no"].'" value="" required>
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="bill_generation_date_'.$milestone["sl_no"].'" id="bill_generation_date_'.$milestone["sl_no"].'" value="" required>
                </div>
            </div>';
        }
    ?>
    <br>
    <center>
        <input type="submit"  class="btn btn-primary" value="Submit" /> 
        <a href="all_projects.php" class="btn btn-warning">Back</a>
    </center>

</form>