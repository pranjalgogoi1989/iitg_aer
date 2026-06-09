<?php
require __DIR__ . '/../vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

$template = new TemplateProcessor(__DIR__ . '/../templates/work_order.docx');

$template->setValue('ref_no','IITG/IPM/CAP/FY25-26/LOI/1111');
$template->setValue('date', date('d.m.Y'));
$template->setValue('contractor_name','Shri XYZ');
$template->setValue('contractor_address','North Guwahati-30');
/*
$template->setValue('contractor_name',$row['contractor_name']);
$template->setValue('work_name',$row['work_name']);
$template->setValue('work_value',number_format($row['amount'],2));
*/
$template->setValue('work_name','Repair and Renovation Work');
$template->setValue('work_value','125000');
$template->setValue('work_value_words','One Lakh Twenty Five Thousand Only');
$template->setValue('completion_months','3');
$template->setValue('security_deposit','10000');
$template->setValue('performance_guarantee','5000');
$template->setValue('head_of_account','Maintenance Fund');
$template->setValue('engineer_name','Head Engineering, IPM Section');

$tempFile = __DIR__ . '/../uploads/loi/work_order.docx';
$template->saveAs($tempFile);
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="Work_Order.docx"');
readfile($tempFile);
//unlink($tempFile);
exit;
?>