<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
$title='Remove Staff';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../mails/master.php';

$successMessage='';
if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("delete from users where id=?");
    $stmt->execute([$id]);
    $successMessage = "<span class='text-success'>Staff Removed Successfully!</span> ";
    header("Location: staff.php");
}
?>