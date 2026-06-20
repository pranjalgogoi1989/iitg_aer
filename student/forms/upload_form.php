<?php
    $rollNo= '';
    if(isset($_GET['roll_no'])){
        $rollNo = $_GET['roll_no'];
    }
?>  
<div class="row">
    <div class="col-sm-9">
        
        
        <div class="row">
            <div class="col-sm-12 mb-3">
                <label for="photo"><b>Upload Passport Photo </b></label>
                <input type="file" name="photo" class="form-control" accept="image/*" required>
                <?php
                    if(file_exists(__DIR__ . "/../../uploads/".$rollNo."/blank.jpg")){
                        echo '<img src="/uploads/'.$rollNo.'/photo.jpg" class="img-fluid" alt="Responsive image" width="100" height="100">';
                    }
                ?>
                
               <p class="text-dark"> Note: The photograph should be in colour and of the size of 2 inch x 2 inch
(51 mm x 51 mm) and The digital size of file should not exceed 100 KB each and
must not be less than 20 KB. Minimum resolution of the file should be 350 pixels
(Width) X 350 pixels (Height). 

It should have full face, front view, eyes open..The background should be a plain white or off white. </p>
            </div>
            
            <div class="col-sm-12 mb-3">
                <label for="transcript"><b>Upload Transcript/Certificate</b></label>
                <input type="file" name="transcript" class="form-control" accept="application/pdf" required>
                <?php
                    if(file_exists(__DIR__ . "/../../uploads/".$rollNo."/transcript.pdf")){
                        echo '<a href="/uploads/'.$rollNo.'/transcript.pdf" target="_blank" class="btn btn-primary">View Transcript</a>';
                    }
                ?>
            </div>
           
            
        </div>
        
        <div class="row">
        
        <div class="col-sm-12 alert alert-primary"><b> Transaction Details </b></div>
        
        <div class="col-sm-6 mb-3"> <label for=""> Transaction Reference No : </label> <input type='text' name="transaction_ref_no" type="text" class="form-control" required/></div>
        <div class="col-sm-6 mb-3"> <label for=""> Transaction Date : </label> <input type='date' name="transaction_date" type="text" class="form-control" required/></div>
        
         <div class="col-sm-12 mb-3">
                <label for="receipt">Upload Fee Receipt</label>
                <input type="file" name="receipt" class="form-control" accept="application/pdf">
                <?php
                    if(file_exists(__DIR__ . "/../../uploads/".$rollNo."/receipt.pdf")){
                        echo '<a href="/uploads/'.$rollNo.'/receipt.pdf" target="_blank" class="btn btn-primary">View Payment Receipt</a>';
                    }
                ?>
            </div>
        
        
        </div>

        <div class="row">
            <div class="col-sm-12"> <button type="submit" class="btn btn-primary">Upload Documents</button> </div>
       </div>
       
       
    </div>
    
    
    
    <div class="col-sm-3">
    
    
    
    <div style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; background-color:#292174; padding:10px;">
    <h5 class="text-white"> Scan & Pay </h5>
        <img src="/qrcode/qrcode.jpg" alt="Responsive image" class="img img-responsive img-thumbnail">       <br /><b><h4 class="text-white"> INR. 300/-</h4> </b>
<p class="text-white">Bank Account : SBI IITG Branch
<br />
Account Name : Alumni meet IITG
<br />
A/C No : 039117364141
<br />
IFSC : SBIN0014262 </p></div>
  </div>
</div>

 