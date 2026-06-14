<?php
$title='Dashboard';
require_once __DIR__ . '/config/config.php';

$email="admin@gmail.com";
$name="Admin";
$role="admin";
$password="12345678";
$stmt = $pdo->prepare("insert into users(email,name,role,password) values(?,?,?,?)");
$stmt->execute([$email,$name,$role,password_hash($password, PASSWORD_DEFAULT)]);
exit();
?>

