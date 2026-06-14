<?php
require_once '../config/config.php';
require_once '../vendor/tecnickcom/tcpdf/tcpdf.php';
require_once 'generateAlumniCard.php';
if (empty($_POST['student_ids'])) {
    die('No students selected');
}
$studentIds = $_POST['student_ids'];
$zipDirectory = __DIR__ . '/../downloads/';
if (!is_dir($zipDirectory)) {
    mkdir($zipDirectory, 0777, true);
}
$zipFile =$zipDirectory .'alumni_cards_' .date('YmdHis') .'.zip';
$zip = new ZipArchive();
$zip->open($zipFile,ZipArchive::CREATE | ZipArchive::OVERWRITE);
foreach ($studentIds as $rollNo) {
    $pdfPath =__DIR__ .'/../alumni_cards/' .$rollNo .'.pdf';
    // Generate only if missing
    if (!file_exists($pdfPath)) {
        $pdfPath = generateAlumniCard($rollNo,$pdo);
    }
    if ($pdfPath && file_exists($pdfPath)) {
        $zip->addFile( $pdfPath,basename($pdfPath));
    }
}
$zip->close();
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' .basename($zipFile) .'"');
header('Content-Length: ' .filesize($zipFile));
readfile($zipFile);

unlink($zipFile);
exit;

?>