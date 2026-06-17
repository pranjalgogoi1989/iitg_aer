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

$stmt2 = $pdo->prepare("select * from users where email=?");
$stmt2->execute([$user_name]);
$student = $stmt2->fetch();

if($verification){
    $stmt = $pdo->prepare("update users set email_verified='1' where email=?");
    $stmt->execute([$user_name]);
    $result1 = sendHTMLMail($user_name,$student['name'],'Email Verification','templates/email_verified.html',['name' => $student['name'],'email'=> $user_name]);
    echo "Email verified successfully";
    $_SESSION['email_verified'] = true;
}else{
    echo "Invalid email verification code";
}


?>