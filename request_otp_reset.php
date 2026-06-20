<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/security/csrf.php';
require_once __DIR__ . '/mails/master.php';


$user_name= $_POST['email'];

$stmt = $pdo->prepare("select * from users where email=? limit 1");
$stmt->execute([$user_name]);
$user = $stmt->fetch();
if(empty($user)){
    echo "User not found";
    exit;
}else{
    $secureCode = random_int(100000, 999999);
    
    $stmt1=$pdo->prepare("insert into password_resets(email,verification_code) values(?,?)");
    $stmt1->execute([$user_name,$secureCode]);
    
    $result1 = sendHTMLMail($user_name,$user['name'],'Password Reset','templates/password_reset_code.html',['name' => $user['name'],'email'=> $user_name,'code' => $secureCode]);
    
    if($result1){
        echo "Email verification code sent successfully";
    }else{
        echo "Email verification code could not be sent";
    }
}

?>