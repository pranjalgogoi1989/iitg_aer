<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
$title='My Profile';
require_once 'header.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';


$user_name= $_SESSION['email'];
$otp = $_POST['otp'];
$stmt = $pdo->prepare("select * from email_verification where email=? and verification_code=?");
$stmt->execute([$user_name,$otp]);
$verification = $stmt->fetch();

if($verification){
    $stmt = $pdo->prepare("update students set email_verified='Verified' where alt_email=?");
    $stmt->execute([$user_name]);
    $result1 = sendHTMLMail($user_name,$student['first_name'],'Email Verification','templates/email_verified.html',['name' => $student['first_name'],'email'=> $user_name]);
    echo "Email verified successfully";
}else{
    echo "Invalid email verification code";
}


?>