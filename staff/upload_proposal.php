<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('staff');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';

if(isset($_FILES['document'])) {
    $ref_no=$_POST["ref_no"];
    $doc_from = $_POST["doc_from"];
    $in_time = $_POST["in_time"];

    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/project/" . $ref_no . "/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    //$module_name = $_POST["module_name"];
    
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
    //$uniqueId = bin2hex(random_bytes(16));
    $newFileName = "Project_Proposal." . $fileExt;
    $targetFile = $targetDir . $newFileName;
    if(move_uploaded_file($_FILES["document"]["tmp_name"], $targetFile)) {
        $filePath = "/uploads/project/" . $ref_no . "/" . $newFileName;

        $stmt = $pdo->prepare("INSERT INTO documents_uploaded (ref_no, project_no, document_type,document_title, document_path, doc_from,doc_to,received_by,indate) VALUES (?, ?, ?, ?, ?, ?, ?,?,?)");
        $stmt->execute([$ref_no,$ref_no,'project_proposal' ,"project_proposal",$filePath, $doc_from,"HOS",$_SESSION['username'],$in_time]);

        echo $ref_no;

    } else {
        echo "<span style='color:red;'>Upload failed.</span>";
    }

}
?>