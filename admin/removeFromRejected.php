<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';

if (isset($_GET['id'])) {
    $studentId = $_GET['id'];
    $stmt = $pdo->prepare('update students set application_status="Applied" WHERE roll_no = ?');
    $stmt->execute([$studentId]);
    header('Location: /admin/rejected.php');
}
?>