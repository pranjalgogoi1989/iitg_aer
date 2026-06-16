<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('student');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
require_once __DIR__ . '/../../mails/master.php';

$user_name= $_SESSION['email'];
$stmt=$pdo->prepare('select * from students where alt_email=? limit 1');
$stmt->execute([$user_name]);
$student = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $iitg_email = $_POST['iitg_email'];
    $roll_number = $_POST['roll_number'];
    $department = $_POST['department'];
    $programme = $_POST['programme'];
    $joining_year = $_POST['joining_year'];
    $graduation_year = $_POST['graduation_year'];
    $hostel = $_POST['hostel'];
    $linkedin = $_POST['linkedin'];
    $whatsapp = $_POST['whatsapp'];
    $organization = $_POST['organization'];
    $designation = $_POST['designation'];
    $por= $_POST['por'];
    $next_venture = $_POST['next_venture'];

    $stmt=$pdo->prepare("select * from applications where roll_no=?");
    $stmt->execute([$roll_number]);
    $application = $stmt->fetch();
    if(!empty($application)) {
        $stmt=$pdo->prepare("update applications set iitg_email=?,roll_no=?,department=?,programme=?,joining_year=?,graduation_year=?,hostel=?,linkedin=?,whatsapp=?,por=? where roll_no=?");
        $stmt->execute([$iitg_email,$roll_number,$department,$programme,$joining_year,$graduation_year,$hostel,$linkedin,$whatsapp,$por,$roll_number]);
        $successMessage = "Form updated successfully";
        echo json_encode([
            'status' => 'success',
            'application_id' => $roll_number
        ]);
    }else{
        $photo= $student['photo'];
        $studentId = 12345;
        $sourceFile = __DIR__ .''.'/../..'. $student['photo'];
        $targetDir = __DIR__ . '/../../uploads/' . $roll_number . '/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $destinationFile = $targetDir . '/photo.jpg';
        if (copy($sourceFile, $destinationFile)) {
            $photo= '/uploads/'.$roll_number.'/photo.jpg';
            $stmt=$pdo->prepare("INSERT INTO applications(roll_no,salutation,first_name,last_name,iitg_email,alt_email,country_code,mobile_number,department,programme,joining_year,graduation_year,hostel,country,state,city,address,pincode,linkedin,whatsapp,por,organization,designation,next_venture,photo) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$roll_number,$student['salutation'],$student['first_name'],$student['last_name'],$iitg_email,$student['alt_email'],$student['country_code'],$student['mobile_number'],$department,$programme,$joining_year,$graduation_year,$hostel,$student['country'],$student['state'],$student['city'],$student['address'],$student['pincode'],$student['linkedin'],$whatsapp,$por,$organization,$designation,$next_venture,$photo]);
            $successMessage = "Form submitted successfully";
            echo json_encode([
                'status' => 'success',
                'application_id' => $roll_number
            ]);
        }
    }
}
?>