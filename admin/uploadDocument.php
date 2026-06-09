<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';

if(isset($_FILES['document'])) {
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/document/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    //$module_name = $_POST["module_name"];
    $document_name=$_POST["document_name"];
    $originalName = $_FILES["document"]["name"];
    $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedTypes = ["pdf","doc","docx","jpg","png","jpeg"];
    if(!in_array($fileExt, $allowedTypes)) {
        echo "<span style='color:red'>Invalid file type.</span>";
        exit;
    }
    if ($_FILES["document"]["size"] > 15 * 1024 * 1024) {
        echo "<span style='color:red'>File too large (Max 15MB).</span>";
        exit;
    }
    $uniqueId = bin2hex(random_bytes(16));
    $newFileName = $uniqueId . "." . $fileExt;
    $targetFile = $targetDir . $newFileName;
    if(move_uploaded_file($_FILES["document"]["tmp_name"], $targetFile)) {
        $filePath = "/uploads/document/" . $newFileName;
        //$stmt = $pdo->prepare("INSERT INTO documents_uploaded (document_details, document_file) VALUES (?, ?)");
        //$stmt->execute([$document_name,$newFileName]);
        echo $document_name."|" . $newFileName;

    } else {
        echo "<span style='color:red;'>Upload failed.</span>";
    }

}
?>