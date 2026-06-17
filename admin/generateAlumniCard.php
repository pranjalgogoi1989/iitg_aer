<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

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
function generateAlumniCard($studentId, $pdo)
{
    $directory = __DIR__ . '/../alumni_cards/';
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
    $stmt = $pdo->prepare('SELECT * FROM applications WHERE roll_no = ? LIMIT 1');
    $stmt->execute([$studentId]);
    $student = $stmt->fetch();
    if (!$student) {
        return false;
    }
    $template = __DIR__ . '/../docs/front.jpg';
    $back = __DIR__ . '/../docs/back.jpg';
    
    $pdf = new TCPDF('L','mm',array(57,89),true,'UTF-8',false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(0,0,0);
    $pdf->SetAutoPageBreak(false);

    // ===== FRONT =====
    $pdf->AddPage();
    $pdf->Image($template,0,0,89,57,'JPG');
    $photo = alumniCardFilePath($student['photo']);
    if ($photo && is_file($photo)) {
        $pdf->StartTransform();
        $pdf->RoundedRect(7.5,16.5,24,29,12,'0100','CNZ');
        $pdf->Image($photo,7.5,16.5,24,29);
        $pdf->StopTransform();
    }
    $pdf->SetFont('times','',7.5);
    $pdf->SetXY(33.0, 21.1);
    $pdf->Cell(15,4,'Name:');
    $pdf->SetXY(47.0,21.1);
    $pdf->Cell(30,4,trim($student['first_name'].' '.$student['last_name']));
    $pdf->SetXY(33.0, 24.9);
    $pdf->Cell(15,4,'Roll No:');
    $pdf->SetXY(47.0,24.9);
    $pdf->Cell(30,4,$student['roll_no']);
    $pdf->SetXY(33.0, 28.7);
    $pdf->Cell(15,4,'Program:');
    $pdf->SetXY(47.0,28.7);
    $pdf->Cell(25,4,$student['programme']);

    $string_length = strlen(trim($student['department']));
    if($string_length>28){
        $pdf->SetXY(33.0, 32.4);
        $pdf->Cell(15,4,'Course:');
        $pdf->SetXY(47.0,32.4);
        $pdf->Cell(28,3.5,trim(substr($student['department'],0,29)));
        $pdf->SetXY(47.0,35);
        $pdf->Cell(28,4,trim(substr($student['department'],29)));
        $pdf->SetXY(33.0, 38.3);
        $pdf->MultiCell(15,4,'Graduating: Year');
        $pdf->SetXY(47.0,38.3);
        $pdf->Cell(15,4,$student['graduation_year']);
    }else{
        $pdf->SetXY(33.0, 32.4);
        $pdf->Cell(15,4,'Course:');
        $pdf->SetXY(47.0,32.4);
        $pdf->Cell(28,3.5,trim($student['department']));
        $pdf->SetXY(33.0, 36.0);
        $pdf->MultiCell(15,4,'Graduating: Year');
        $pdf->SetXY(47.0,36.0);
        $pdf->Cell(15,4,$student['graduation_year']);
    }
    $pdf->SetXY(22.0,49.0);
    $pdf->Cell(18,4,date('d-m-Y'));
    $sign = alumniCardFilePath('/uploads/dean_sign/sign.jpg');
    $pdf->SetXY(50.0, 49.0);
    $pdf->Image($sign,69,42,14,6,'JPG');
    // ===== BACK =====
    $pdf->AddPage();
    $pdf->Image($back,0,0,89,57,'JPG');

    $style = array(
        'position' => '',
        'align' => 'C',
        'stretch' => false,
        'fitwidth' => true,
        'cellfitalign' => '',
        'border' => false,
        'hpadding' => 'auto',
        'vpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false,
        'text' => false,
        'font' => 'helvetica',
        'fontsize' => 8,
        'stretchtext' => 4
    );
    $pdf->write1DBarcode($studentId,'C128',20,3.8,30,8,0.4,$style,'N');

    $pdf->SetFont('times','',5);
    $pdf->SetXY(58.0,3.8);
    $pdf->Cell(30,4,'+' . trim($student['country_code']) . ' ' . trim($student['mobile_number']));
    $pdf->SetXY(58.3,6.2);
    if($student['iitg_email'] == null){
        $pdf->Cell(30,4,$student['alt_email']);
    }else{
        $pdf->Cell(30,4,$student['iitg_email']);
    }
    $pdf->SetXY(58.3,9.0);
    $pdf->Cell(30,4,$student['city'] . ', ' . $student['state']);
    $stmt = $pdo->prepare('update accepted_applications set status="generated" WHERE roll_no = ? ');
    $stmt->execute([$studentId]);
    $filePath =
        $directory .
        $student['roll_no'] .
        '.pdf';
    $pdf->Output($filePath, 'F');

    
    return $filePath;
}
?>