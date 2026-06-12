<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
$title='My Profile';
require_once 'header.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';


$user_name= $_SESSION['email'];

$stmt = $pdo->prepare("select * from students where alt_email=?");
$stmt->execute([$user_name]);
$student = $stmt->fetch();

$secureCode = random_int(100000, 999999);

$stmt1=$pdo->prepare("update email_verification set verification_code=? where email=?");
$stmt1->execute([$secureCode,$user_name]);

$result1 = sendHTMLMail($user_name,$student['first_name'],'Email Verification','templates/email_verification.html',['name' => $student['first_name'],'email'=> $user_name,'code' => $secureCode]);

if($result1){
    echo "Email verification code sent successfully";
}else{
    echo "Email verification code could not be sent";
}

?>