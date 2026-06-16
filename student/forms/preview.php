<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('student');
$title='Preview';
require_once 'header.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
require_once __DIR__ . '/../../mails/master.php';

$user_name= $_SESSION['email'];
$stmt=$pdo->prepare('select * from applications where alt_email=? limit 1');
$stmt->execute([$user_name]);
$appl = $stmt->fetch();
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="salutation">Salutation</label>: <strong><?=$appl['salutation'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="first_name">First Name</label>: <strong><?=$appl['first_name'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="last_name">Last Name</label>: <strong><?=$appl['last_name'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="iitg_email">IITG Email ID</label>: <strong><?=$appl['iitg_email'] ?? ''?></strong>
                            </div>
                            <div class="col">
                                <label for="alt_email">Alternate Email ID</label>: <strong><?=$appl['alt_email'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="roll_number">Roll Number</label>: <strong><?=$appl['roll_no'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="department">Department</label>: <strong><?=$appl['department'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="programme">Programme</label>: <strong><?=$appl['programme'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="hostel">Hostel</label>: <strong><?=$appl['hostel'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="joining_year">Year of Joining</label>: <strong><?=$appl['joining_year'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="graduation_year">Year of Graduation</label>: <strong><?=$appl['graduation_year'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="country_code">Country Code</label>: <strong><?=$appl['country_code'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="mobile_no">Mobile Number</label>: <strong><?=$appl['mobile_number'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="whatsapp">Whatsapp</label>: <strong><?=$appl['whatsapp'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="city">City/Village</label>: <strong><?=$appl['city'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="country">Country</label>: <strong><?=$appl['country'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="portfolio">State</label>: <strong><?=$appl['state'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="address">Address</label>: <strong><?=$appl['address'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="pincode">Pincode</label>: <strong><?=$appl['pincode'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="linkedin">LinkedIn Profile Address</label>: <strong><?=$appl['linkedin'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="organization">Organization</label>: <strong><?=$appl['organization'] ?? ''?></strong>
                            </div>
                            <div class="col-md-4">
                                <label for="designation">Designation</label>: <strong><?=$appl['designation'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="por">Were you associated with any group (IITG Board/Club/HMC/Student Body)? If yes, write your Position of Responsibility (POR)</label>: <strong><?=$appl['por'] ?? ''?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="next_venture">Details of your next venture or destination (if known)</label>: <strong><?=$appl['next_venture'] ?? ''?></strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="photo">Photo</label>:<br>
                                <img src="<?=$appl['photo'] ?? ''?>" alt="Photo" width="100px" height="100px">
                            </div>
                            <div class="col-md-3">
                                <label for="transcript">Transcript</label>:<br>
                                <a href="<?=$appl['transcript'] ?? ''?>" target="_blank" class="btn btn-primary">View Transcript</a>
                            </div>
                            <div class="col-md-3">
                                <label for="certificate">Certificate</label>:<br>
                                <a href="<?=$appl['certificate'] ?? ''?>" target="_blank" class="btn btn-primary">View Certificate</a>
                            </div>
                            <div class="col-md-3">
                                <label for="receipt">Payment Receipt</label>:<br>
                                <a href="<?=$appl['receipt'] ?? ''?>" target="_blank" class="btn btn-primary">View Payment Receipt</a>
                            </div>
                        </div>
                        <br>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required onclick="enableButton(this.checked)"/>
                                <label class="form-check-label" for="terms-conditions">
                                I agree that all the informations provided are correct.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>