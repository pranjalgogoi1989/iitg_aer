<?php
    $rollNo= '';
    if(isset($_GET['roll_no'])){
        $rollNo = $_GET['roll_no'];
    }
?>  
<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-12">
                Students who tend to apply for the offline AlumniCard need to pay the amount using following details or the QR code.
                <img src="/assets/images/bank_details.jpeg" class="img img-responsive" alt="Responsive image" width="400">                                   
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-3">
                <label for="photo">Upload Photo</label>
                <input type="file" name="photo" class="form-control" accept="image/*" required>
                <?php
                    if(file_exists(__DIR__ . "/../../uploads/".$rollNo."/photo.jpg")){
                        echo '<img src="/uploads/'.$rollNo.'/photo.jpg" class="img-fluid" alt="Responsive image" width="100" height="100">';
                    }
                ?>
            </div>
            <div class="col-sm-3">
                <label for="transcript">Upload Transcript</label>
                <input type="file" name="transcript" class="form-control" accept="application/pdf" required>
                <?php
                    if(file_exists(__DIR__ . "/../../uploads/".$rollNo."/transcript.pdf")){
                        echo '<a href="/uploads/'.$rollNo.'/transcript.pdf" target="_blank" class="btn btn-primary">View Transcript</a>';
                    }
                ?>
            </div>
            <div class="col-sm-3">
                <label for="certificate">Upload Certificate</label>
                <input type="file" name="certificate" class="form-control" accept="application/pdf" required>
                <?php
                    if(file_exists(__DIR__ . "/../../uploads/".$rollNo."/certificate.pdf")){
                        echo '<a href="/uploads/'.$rollNo.'/certificate.pdf" target="_blank" class="btn btn-primary">View Certificate</a>';
                    }
                ?>
            </div>
            <div class="col-sm-3">
                <label for="receipt">Upload Fee Receipt</label>
                <input type="file" name="receipt" class="form-control" accept="application/pdf">
                <?php
                    if(file_exists(__DIR__ . "/../../uploads/".$rollNo."/receipt.pdf")){
                        echo '<a href="/uploads/'.$rollNo.'/receipt.pdf" target="_blank" class="btn btn-primary">View Payment Receipt</a>';
                    }
                ?>
            </div>
        </div>
        <br>
        <center>
            <button type="submit" class="btn btn-primary">Upload Documents</button>
        </center>
    </div>
    <div class="col-sm-4">
        <img src="/assets/images/qr_code.jpeg" class="img img-responsive" alt="Responsive image" width="100%" height="100%"> 
    </div>
</div>

 