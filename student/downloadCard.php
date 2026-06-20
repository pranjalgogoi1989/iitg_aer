<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
require_once __DIR__ . '/../config/config.php';

// Get logged-in student roll number
$user_name= $_SESSION['email'];
$roll_no = $_GET['roll_no'];
$stmt=$pdo->prepare('select * from students where alt_email=? limit 1');
$stmt->execute([$user_name]);
$student = $stmt->fetch();
if (!$student) {
    http_response_code(404);
    exit('Student not found');
}
$filePath = __DIR__ .'/../alumni_cards/' .$roll_no.'.pdf';

if (!file_exists($filePath)) {
    http_response_code(404);
    exit('Card not generated yet');
}
header('Content-Type: application/pdf');
header(
    'Content-Disposition: attachment; filename="AlumniCard.pdf"'
);
header('Content-Length: ' . filesize($filePath));
readfile($filePath);
exit;

?>