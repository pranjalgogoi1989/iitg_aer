<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';

$user_id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);
header("Location: users.php");
exit();
?>
