<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
$title='Add Staff';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';

$successMessage='';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?,?)");
    $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), 'staff']);
    $successMessage = "<span class='text-success'>Staff Added Successfully!</span> ";
    header("Location: staff.php");
}
?>