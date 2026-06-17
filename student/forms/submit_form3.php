<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('student');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';

$application_id= $_POST['application_id2'];
$stmt=$pdo->prepare('select * from applications where roll_no=? limit 1');
$stmt->execute([$application_id]);
$student = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $terms = trim($_POST['terms']);
    if($terms != 'on') {
        $errors[] = "Please agree to terms and conditions";
    }
    if(empty($errors)) {
        $stmt=$pdo->prepare("update applications set application_status='Submitted',submission_stage='3' where roll_no=?");
        $stmt->execute([$application_id]);
        echo json_encode([
            'status' => 'success',
            'application_id' => $student["roll_no"]
        ]);
    }
}
?>