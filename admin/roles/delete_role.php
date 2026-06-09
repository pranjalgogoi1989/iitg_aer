<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';

$successMessage="";
$get_id = $_GET["id"];
if(isset($_SERVER['HTTP_REFERER'])){
    $get_eng = $pdo->prepare("delete from roles where id=?");
    $get_eng->execute([$get_id]);
}
header('Location: '.$_SERVER['HTTP_REFERER'].'?successMessage=Role Name Deleted');
exit();
?>
