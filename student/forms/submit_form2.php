<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('student');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';

$user_name= $_SESSION['email'];
$stmt=$pdo->prepare('select * from applications where alt_email=? limit 1');
$stmt->execute([$user_name]);
$student = $stmt->fetch();

$upload_files=array('transcript','certificate','receipt');
$uploadStatus = [];
foreach ($upload_files as $file) {
    if(isset($_FILES[$file])) {
        csrf_validate($_POST['csrf_token']);
        $targetDir = __DIR__ . "/../../uploads/".$student["roll_no"];
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $document_name=$file;
        $originalName = $_FILES[$file]["name"];
        $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedTypes = ["pdf","doc","docx","jpg","png","jpeg"];
        if(!in_array($fileExt, $allowedTypes)) {
            echo "<span style='color:red'>Invalid file type.</span>";
            exit;
        }
        if ($_FILES[$file]["size"] > 15 * 1024 * 1024) {
            echo "<span style='color:red'>File too large (Max 15MB).</span>";
            exit;
        }
        $newFileName = $document_name . "." . $fileExt;
        $targetFile = $targetDir .'/'. $newFileName;
        if(move_uploaded_file($_FILES[$file]["tmp_name"], $targetFile)) {
            $filePath = "/uploads/".$student["roll_no"]."/" . $newFileName;
            $stmt = $pdo->prepare("update applications set $file=? where roll_no=?");
            $stmt->execute([$filePath,$student["roll_no"]]);
            $uploadStatus[$file] = true;
        } else {
            echo "<span style='color:red;'>Upload failed.</span>";
        }
    }
}
echo json_encode([
    'status' => 'success',
    'upload_status' => $uploadStatus,
    'application_id' => $student["roll_no"]
]);


?>