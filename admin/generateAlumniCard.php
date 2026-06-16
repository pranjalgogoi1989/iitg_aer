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
    $pdf->SetXY(50.0,23.1);
    $pdf->Cell(30,4,trim($student['first_name'].' '.$student['last_name']));
    $pdf->SetXY(50.0,27);
    $pdf->Cell(30,4,$student['roll_no']);
    $pdf->SetXY(50.0,30.9);
    $pdf->Cell(25,4,$student['programme']);
    $pdf->SetXY(50.0,34.7);
    $pdf->MultiCell(28,3.5,$student['department']);
    $pdf->SetXY(50.0,38.3);
    $pdf->Cell(15,4,$student['graduation_year']);
    $pdf->SetXY(22.0,49.0);
    $pdf->Cell(18,4,date('d-m-Y'));
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
    $pdf->Cell(30,4,$student['iitg_email']);
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