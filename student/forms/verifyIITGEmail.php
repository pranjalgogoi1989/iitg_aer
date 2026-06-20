<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('student');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
require_once __DIR__ . '/../../mails/master.php';

$user_name= $_POST['email'];

$stmt = $pdo->prepare("select * from alumni_list where email=? limit 1");
$stmt->execute([$user_name]);
$user = $stmt->fetch();
if(!$user){
    echo json_encode(array('message' => 'Email not found', 'success' => false));
    exit();
}else{
    $secureCode = random_int(100000, 999999);
    
    $stmt1=$pdo->prepare("insert into email_verification(email, verification_code) values(?,?) on duplicate key update verification_code=?");
    $stmt1->execute([$user_name,$secureCode,$secureCode]);
    
    $result1 = sendHTMLMail($user_name,$user['name'],'Email Verification','templates/email_verification.html',['name' => $user['name'],'email'=> $user_name,'code' => $secureCode]);
    
    if($result1){
        echo json_encode(array('message' => 'Email verification code sent successfully', 'success' => true));
    }else{
        echo json_encode(array('message' => 'Email verification code could not be sent', 'success' => false));
    }
}

?>