<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('staff');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';

if (!isset($_POST['file'])) {
    echo "Invalid request.";
    exit;
}

$fileName = basename($_POST['file']);
$filePath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/document/" . $fileName;

if (!file_exists($filePath)) {
    echo "File not found.";
    exit;
}

if (!unlink($filePath)) {
    echo "Unable to delete file.";
    exit;
}

echo "File deleted successfully.";
?>
