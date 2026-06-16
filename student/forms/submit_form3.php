<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('student');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';

$user_name= $_SESSION['email'];
$stmt=$pdo->prepare('select * from applications where alt_email=? limit 1');
$stmt->execute([$user_name]);
$student = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $terms = trim($_POST['terms']);
    if($terms != 'on') {
        $errors[] = "Please agree to terms and conditions";
    }
    if(empty($errors)) {
        $stmt=$pdo->prepare("update applications set application_status='Submitted' where alt_email=?");
        $stmt->execute([$user_name]);
        echo json_encode([
            'status' => 'success',
            'upload_status' => $uploadStatus,
            'application_id' => $student["roll_no"]
        ]);
    }
}
?>