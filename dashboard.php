<?php
require_once 'middleware/auth.php';
requireLogin();

$myrole = $_SESSION['role'];

if($myrole == 'admin'){
  header("Location: /admin/");
  exit();
}
if($myrole == 'staff'){
  header("Location: /staff/");
  exit();
}
if($myrole == 'student'){
  header("Location: /student/");
  exit();
}

?>
