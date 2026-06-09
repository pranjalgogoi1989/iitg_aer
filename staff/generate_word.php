<?php
require __DIR__ . '/../vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Language;

$phpWord = new PhpWord();
$phpWord->getSettings()->setThemeFontLang(
    new Language(Language::EN_US)
);
$properties = $phpWord->getDocInfo();
$properties->setCreator("Pranjal Gogoi");
$properties->setCompany("ABC Technologies");
$properties->setTitle("Offer Letter");
$phpWord->setDefaultFontName('Times New Roman');
$phpWord->setDefaultFontSize(12);

// Add Section
$section = $phpWord->addSection([
    'marginTop' => 1000,
    'marginBottom' => 1000,
    'marginLeft' => 1200,
    'marginRight' => 1200
]);

// HEADER
$header = $section->addHeader();
$headerTable = $header->addTable();
$headerTable->addRow();

$headerTable->addCell(2000)->addImage(
    __DIR__ . '/../assets/images/logo.jpg',
    [
        'width' => 80,
        'height' => 80,
        'alignment' => 'left'
    ]
);

$headerCell = $headerTable->addCell(7000);

$headerCell->addText(
    'ABC TECHNOLOGIES PVT. LTD.',
    [
        'bold' => true,
        'size' => 18
    ],
    ['alignment' => 'center']
);

$headerCell->addText(
    'Silchar, Assam',
    ['size' => 11],
    ['alignment' => 'center']
);

$headerCell->addText(
    'hr@abctech.com | +91-9876543210',
    ['size' => 10],
    ['alignment' => 'center']
);

// Title
$section->addTextBreak(2);

$section->addText(
    'OFFER LETTER',
    [
        'bold' => true,
        'size' => 20,
        'underline' => 'single'
    ],
    ['alignment' => 'center']
);

$section->addTextBreak(1);

// Dynamic Data
$employeeName = 'Rahul Sharma';
$designation = 'Software Engineer';
$salary = '6,00,000';
$date = date('d-m-Y');

// Letter Content
$section->addText("Date: $date");

$section->addTextBreak(1);

$section->addText(
    "To,\n$employeeName",
    ['bold' => true]
);

$section->addTextBreak(1);

$section->addText(
    "Subject: Offer of Employment",
    ['bold' => true]
);

$section->addTextBreak(1);

$section->addText(
    "Dear $employeeName,"
);

$section->addTextBreak(1);

$section->addText(
    "We are pleased to offer you the position of $designation at ABC Technologies Pvt. Ltd. based on your experience and qualifications."
);

$section->addTextBreak(1);

// Salary Table
$section->addText(
    'Compensation Details',
    ['bold' => true, 'size' => 14]
);

$table = $section->addTable([
    'borderSize' => 6,
    'borderColor' => '000000',
    'cellMargin' => 80
]);

$table->addRow();

$table->addCell(5000)->addText(
    'Component',
    ['bold' => true]
);

$table->addCell(3000)->addText(
    'Amount',
    ['bold' => true]
);

$table->addRow();
$table->addCell(5000)->addText('Annual CTC');
$table->addCell(3000)->addText("₹ $salary");

// Terms
$section->addTextBreak(1);

$section->addText(
    "Terms & Conditions",
    ['bold' => true]
);

$section->addListItem(
    'You will be on probation for 6 months.'
);

$section->addListItem(
    'You must follow company policies.'
);

$section->addListItem(
    'Confidentiality must be maintained.'
);

// Closing
$section->addTextBreak(2);

$section->addText(
    "We look forward to having you with us."
);

$section->addTextBreak(2);

// Signature
$section->addText(
    'Authorized Signatory',
    ['bold' => true]
);

$section->addImage(
    __DIR__ . '/../assets/images/signature.png',
    [
        'width' => 120,
        'height' => 50
    ]
);

$section->addText(
    'HR Department'
);

// FOOTER
$footer = $section->addFooter();

$footer->addText(
    'This is system generated offer letter.',
    ['size' => 10],
    ['alignment' => 'center']
);

// DOWNLOAD FILE
$fileName = 'Offer_Letter.docx';

header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

header('Cache-Control: must-revalidate');
header('Pragma: public');

$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save("php://output");

exit;
?>