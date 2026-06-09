<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('staff');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
require_once __DIR__.'/../../mails/master.php';
require_once __DIR__ . '/../../config/numbertoword.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;
$template = new TemplateProcessor(__DIR__ . '/../../templates/loi_template.docx');

$errors = [];
$successMessage = '';
$project_id = $_GET["id"] ?? $_POST["project_id"] ?? null;

if (!$project_id) {
    $errors[] = "Project details not found";
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$project) {
    $errors[] = "Project details not found";
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM milestones WHERE project_id=? ORDER BY sl_no ASC");
$stmt->execute([$project_id]);
$milestones = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token'] ?? '');
    $project_duration = trim($_POST["project_duration"] ?? '');
    $contractor_name = trim($_POST["contractor_name"] ?? '');
    $contractor_address = trim($_POST["contractor_address"] ?? '');
    $contractor_contact = trim($_POST["contractor_contact"] ?? '');
    $contractor_email = trim($_POST["contractor_email"] ?? '');
    $gst_details = trim($_POST["gst_details"] ?? '');
    $emd_amount = trim($_POST["emd_amount"] ?? '');
    $emd_details = trim($_POST["emd_details"] ?? '');

    if ($project_duration === '') {
        $errors[] = "Project Duration is required";
    }
    if ($contractor_name === '') {
        $errors[] = "Contractor Name is required";
    }
    if ($contractor_address === '') {
        $errors[] = "Contractor Address is required";
    }
    if ($contractor_contact === '') {
        $errors[] = "Contractor Contact Number is required";
    }
    if ($contractor_email === '') {
        $errors[] = "Contractor Email is required";
    }
    if ($gst_details ==='') {
        $errors[] = "Contractor GST details is required";
    }
    if ($emd_amount ==='') {
        $errors[] = "Contractor EMD amount is required";
    }
    if ($emd_details ==='') {
        $errors[] = "Contractor EMD details is required";
    }

    foreach ($milestones as $milestone) {
        $my_slno = $milestone["sl_no"];
        $milestone_completion_date = trim($_POST["milestone_completion_date_" . $my_slno] ?? '');
        $bill_generation_date = trim($_POST["bill_generation_date_" . $my_slno] ?? '');
        if ($milestone_completion_date === '' || $bill_generation_date === '') {
            $errors[] = "Milestone Completion Date and Bill Generation Date are required for all milestones";
            break;
        }
    }
    //work order file upload

    $template->setValue('ref_no',$project["ref_no"]);
    $template->setValue('date', date('d.m.Y'));
    $template->setValue('contractor_name',$contractor_name);
    $template->setValue('contractor_address',$contractor_address. ", Phone: " . $contractor_contact . ", Email: " . $contractor_email);
    $template->setValue('work_name',$project["project_title"]);
    $template->setValue('work_value',$budget_amount);
    $template->setValue('work_value_words',numberToWords($budget_amount) . ' Only');
    $template->setValue('completion_months',$project_duration);
    $template->setValue('security_deposit',$emd_amount);
    $template->setValue('performance_guarantee',$emd_amount);
    $template->setValue('emd_details',$emd_details);
    $filePath = "/uploads/project/" . $project["ref_no"] . "/LOI.docx";
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/project/" . $project["ref_no"]. "/";
    $tempFile = $targetDir . "LOI.docx";
    if (!file_exists($targetDir) && !mkdir($targetDir, 0755, true)) {
        $errors[] = "Unable to create LOI file";
    }else{
        $template->saveAs($tempFile);
    }
    
    $filelist = ['work_order','loi_format','note_sheet','performance_guarentee'];    
    //echo implode('<br>', array_map('htmlspecialchars', $errors));

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE projects SET project_duration=?, contractor_name=?, contractor_address=?, contractor_phone=?, contractor_email=?,gst_details=?,emd_amount=?,emd_details=?, work_order=?, submission_stage=? WHERE id=?");
        $stmt->execute([$project_duration, $contractor_name, $contractor_address, $contractor_contact, $contractor_email,$gst_details,$emd_amount,$emd_details, $filePath, '5', $project_id]);

        foreach ($milestones as $milestone) {
            $my_slno = $milestone["sl_no"];
            $milestone_completion_date = trim($_POST["milestone_completion_date_" . $my_slno] ?? '');
            $bill_generation_date = trim($_POST["bill_generation_date_" . $my_slno] ?? '');
            $stmt = $pdo->prepare("UPDATE milestones SET completion_date=?, bill_date=? WHERE project_id=? AND sl_no=?");
            $stmt->execute([$milestone_completion_date, $bill_generation_date, $project_id, $my_slno]);
        }

    }

    $initiating_engineer = $project["initiating_engineer"];
    $mailRes = $pdo->prepare("select * from users where name=? and role=?");
    $mailRes->execute([$initiating_engineer,'engineer']);
    $myresult = $mailRes->fetchAll(PDO::FETCH_ASSOC);
    foreach($myresult as $res){
        $result = sendHTMLMail(
            $res["email"],
            $initiating_engineer,
            'Project Approved!',
            'templates/project_approved.html',
            [
                'name'       => $initiating_engineer
            ]
        );
    }

    $successMessage = "Project processed successfully";
    $_SESSION["successMessage"] = $successMessage;
    echo '<script>window.location.href="/staff/process_project.php?id='.$project_id.'";</script>';
}

?>