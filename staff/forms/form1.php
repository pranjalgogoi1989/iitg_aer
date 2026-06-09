<legend>Project Processing</legend>
<form action="submit_form/submit_form1.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" name="project_id" value="<?=$project["id"]?>">
    <div class="row">
        <div class="col-sm-6">
            <label>Budget Amount Booked</label>
            <input type="number" class="form-control" name="budget_amount" id="budget_amount" value="0" required>
        </div>
        <div class="col-sm-6">
            <label>Tender Work/Direct Allotment</label>
            <input type="text" class="form-control" name="tender_direct" id="tender_direct" value="<?=$project["tender_direct"]?>" readonly>
            
        </div>
    </div>
    <?php
        if($project["tender_direct"] == "Tender"){
            echo '<div class="row">
                <div class="col-sm-2">
                    <label>Tender Publish Date</label>
                    <input type="date" class="form-control" name="tender_publish_date" id="tender_publish_date" value="" required>
                </div>
                <div class="col-sm-2">
                    <label for="bid_opening_date">Date of Technical Bid Opening</label>
                    <input type="date" class="form-control" name="bid_opening_date" id="bid_opening_date" value="" required>
                </div>
                <div class="col-sm-2">
                    <label for="bid_closing_date">Date of Technical Bid Closing</label>
                    <input type="date" class="form-control" name="bid_closing_date" id="bid_closing_date" value="" required>
                </div>
                <div class="col-sm-2">
                    <label for="bid_evaluation_date">Date of Technical Bid Evaluation</label>
                    <input type="date" class="form-control" name="bid_evaluation_date" id="bid_evaluation_date" value="" required>
                </div>
                <div class="col-sm-2">
                    <label for="price_bid_evaluation_date">Date of Price Bid Evaluation</label>
                    <input type="date" class="form-control" name="price_bid_evaluation_date" id="price_bid_evaluation_date" value="" required>
                </div>
                <div class="col-sm-2">
                    <label for="loi_issue_date">Date of Issue of LOI</label>
                    <input type="date" class="form-control" name="loi_issue_date" id="loi_issue_date" value="" required>
                </div>
            </div>';
            echo '<div class="row">
                <div class="col-sm-3">
                    <label>NIT Number</label>
                    <input type="text" class="form-control" name="nit_number" id="nit_number" required>
                </div>
                <div class="col-sm-3">
                    <label>Tender Paper Cost</label>
                    <input type="text" class="form-control" name="tender_paper_cost" id="tender_paper_cost" required>
                </div>
                <div class="col-sm-3">
                    <label>EMD Amount</label>
                    <input type="text" class="form-control" name="emd_amount" id="emd_amount" required>
                </div>
                <div class="col-sm-3">
                    <label>Work Completion Duration/Deadline</label>
                    <input type="text" class="form-control" name="work_completion_deadline" id="work_completion_deadline" placeholder="30 Days" required>
                </div>
            </div>
            ';
        }
        if($project["tender_direct"] == "Direct"){
            echo '<div class="row">
                <div class="col-sm-6">
                    <label>Project Duration</label>
                    <input type="text" class="form-control" name="project_duration" id="project_duration" value="" required>
                </div>
                <div class="col-sm-6">
                    <label>Work Order File will be generated automaticaly</label>
                </div>
            </div>';
            echo '<div class="row">
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
            </div>';
            echo '<div class="row">
                <div class="col-sm-3">
                    <label>GST Details</label>
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
            </div>';
            echo '<br>';
            echo '<h5>Milestone Details</h5>';
            $msts = $pdo->prepare("select * from milestones where project_id=? order by sl_no asc");
            $msts->execute([$project["id"]]);
            $milestones = $msts->fetchAll();
            if(!empty($milestones)){
                echo '<strong><div class="row">
                    <div class="col-sm-1 font-weight-bold">Sl. No.</div>
                    <div class="col-sm-2 font-weight-bold">Milestone Name</div>
                    <div class="col-sm-2 font-weight-bold">Duration</div>
                    <div class="col-sm-3 font-weight-bold">Milestone Description</div>
                    <div class="col-sm-2 font-weight-bold">Milestone Completion Date</div>
                    <div class="col-sm-2 font-weight-bold">Bill Generation Date</div>
                </div></strong>';
            }
            foreach($milestones as $milestone){
                echo '<div class="row">
                    <div class="col-sm-1">'.$milestone["sl_no"].'</div>
                    <div class="col-sm-2">'.$milestone["milestone_name"].'</div>
                    <div class="col-sm-2">'.$milestone["year"].' year '.$milestone["month"].' month '.$milestone["date"].' days</div>
                    <div class="col-sm-3">'.$milestone["description"].'</div>
                    <div class="col-sm-2">
                        <input type="date" class="form-control" name="milestone_completion_date_'.$milestone["sl_no"].'" id="milestone_completion_date_'.$milestone["sl_no"].'" value="" required>
                    </div>
                    <div class="col-sm-2">
                        <input type="date" class="form-control" name="bill_generation_date_'.$milestone["sl_no"].'" id="bill_generation_date_'.$milestone["sl_no"].'" value="" required>
                    </div>
                </div>';
            }

        }
    ?>
    <br>
    <center>
        <input type="submit"  class="btn btn-primary" value="Submit" /> 
        <a href="all_projects.php" class="btn btn-warning">Back</a>
    </center>

</form>