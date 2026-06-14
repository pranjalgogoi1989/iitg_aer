<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

$directory = __DIR__ . '/../alumni_cards/';
if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}
$studentId = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($studentId === '') {
    http_response_code(400);
    exit('Student roll number is required.');
}

$stmt = $pdo->prepare('SELECT * FROM students WHERE roll_no = ? LIMIT 1');
$stmt->execute([$studentId]);
$student = $stmt->fetch();

if (!$student) {
    http_response_code(404);
    exit('Student not found.');
}

function alumniCardFilePath($path)
{
    if (empty($path)) {
        return '';
    }
    if (strpos($path, '/') === 0) {
        return __DIR__ . '/..' . $path;
    }
    return __DIR__ . '/../' . ltrim($path, '/');
}

$template = __DIR__ . '/../docs/front.jpg';
$back = __DIR__ . '/../docs/back.jpg';
if (!is_file($template)) {
    http_response_code(500);
    exit('Alumni card template not found.');
}

$pdf = new TCPDF('L','mm',array(57, 89),true,'UTF-8',false);

$pdf->SetCreator('IITG');
$pdf->SetAuthor('IITG');
$pdf->SetTitle('Alumni Card');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(false);

$pdf->AddPage();

$pdf->Image($template,0,0,89,57,'JPG');
$photo = alumniCardFilePath($student['photo']);
if ($photo !== '' && is_file($photo)) {
    $x = 7.5;
    $y = 16.5;
    $w = 24;
    $h = 29;
    $r = 12; // corner radius in mm
    $pdf->StartTransform();
    $pdf->RoundedRect($x,$y,$w,$h,$r,'0100','CNZ');
    $pdf->Image($photo,$x,$y,$w,$h,'','','',false,300,'',false,false,0);
    $pdf->StopTransform();
}
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('times', '', 7.5);
$pdf->SetXY(50.0, 23.1);
$pdf->Cell(30,4,trim($student['first_name'].' '.$student['last_name']),0,0);
$pdf->SetXY(50.0, 27);
$pdf->Cell(30,4,$studentId,0,0);
$pdf->SetXY(50.0, 30.9);
$pdf->Cell(25,4,$student['programme'],0,0);
$pdf->SetXY(50.0, 34.7);
$pdf->MultiCell(28, 3.5, $student['department'], 0, 'L', false);
$pdf->SetXY(50.0, 38.3);
$pdf->Cell(15,4,$student['graduation_year'],0,0);
$pdf->SetXY(22.0, 49.0);
$pdf->Cell(18,4,date('d-m-Y'),0,0);

$sign = alumniCardFilePath('/uploads/dean_sign/sign.jpg');
$pdf->SetXY(50.0, 49.0);
$pdf->Image($sign,69,42,14,6,'JPG');

$pdf->AddPage();
$pdf->Image($back,0,0,89,57,'JPG');
$pdf->SetFont('times', '', 5);
$pdf->SetXY(58.0, 3.8);
$pdf->Cell(30,4,'+' .trim($student['country_code']).' '.trim($student['mobile_number']),0,0);
$pdf->SetXY(58.3, 6.2);
$pdf->Cell(30,4,trim($student['iitg_email']),0,0);
$pdf->SetXY(58.3, 9.0);
$pdf->Cell(30,4,$student['city'].', '.$student['state'],0,0);

$fileName = $studentId. '.pdf';
$pdf->Output($fileName,'I');
$filePath = $directory . $fileName;
$pdf->Output($filePath, 'F');
$stmt = $pdo->prepare('update accepted_applications set status="generated" WHERE roll_no = ? ');
$stmt->execute([$studentId]);
?>