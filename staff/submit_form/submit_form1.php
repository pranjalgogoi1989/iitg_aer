<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('staff');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
require_once __DIR__ . '/../../config/numbertoword.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;


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
    $budget_amount = $_POST["budget_amount"];
    if ($project["tender_direct"] === "Tender") {
        $tender_publish_date = trim($_POST["tender_publish_date"] ?? '');
        $bid_opening_date = trim($_POST["bid_opening_date"] ?? '');
        $bid_closing_date = trim($_POST["bid_closing_date"] ?? '');
        $bid_evaluation_date = trim($_POST["bid_evaluation_date"] ?? '');
        $price_bid_evaluation_date = trim($_POST["price_bid_evaluation_date"] ?? '');
        $loi_issue_date = trim($_POST["loi_issue_date"] ?? '');

        $nit_number = trim($_POST["nit_number"] ?? '');
        $tender_paper_cost = trim($_POST["tender_paper_cost"] ?? '');
        $emd_amount = trim($_POST["emd_amount"] ?? '');
        $work_completion_deadline = trim($_POST["work_completion_deadline"] ?? '');

        if ($tender_publish_date === '') {
            $errors[] = "Tender Publish Date is required";
        }
        if ($bid_opening_date === '') {
            $errors[] = "Date of Technical Bid Opening is required";
        }
        if ($bid_closing_date === '') {
            $errors[] = "Date of Technical Bid Closing is required";
        }
        if ($bid_evaluation_date === '') {
            $errors[] = "Date of Technical Bid Evaluation is required";
        }
        if ($price_bid_evaluation_date === '') {
            $errors[] = "Date of Price Bid Evaluation is required";
        }
        if ($loi_issue_date === '') {
            $errors[] = "Date of Issue of LOI is required";
        }

        if ($nit_number === '') {
            $errors[] = "NIT Number is required";
        }
        if ($tender_paper_cost === '') {
            $errors[] = "Tender Paper Cost is required";
        }
        if ($emd_amount === '') {
            $errors[] = "EMD Amount is required";
        }
        if ($work_completion_deadline === '') {
            $errors[] = "Work Completion Deadline is required";
        }

        //generate tender files (online and offline)
        $template = new TemplateProcessor(__DIR__ . '/../../templates/tender_document.docx');
        $template->setValue('ref_no',$project["ref_no"]);
        $template->setValue('nit_number', $nit_number);
        $template->setValue('tender_publish_date', $tender_publish_date);
        $template->setValue('work_name',$project["project_title"]);
        $template->setValue('work_value',$budget_amount);
        $template->setValue('work_value_words',numberToWords($budget_amount) . ' Only');
        $template->setValue('tender_paper_cost', $tender_paper_cost);
        $template->setValue('emd_amount',$emd_amount);
        $template->setValue('bid_opening_date',$bid_opening_date);
        $template->setValue('bid_closing_date',$bid_closing_date);
        $template->setValue('price_bid_evaluation_date',$price_bid_evaluation_date);
        $template->setValue('work_completion_deadline',$work_completion_deadline);
        $template->setValue('work_description',$project["work_description"]);

        $filePath = "/uploads/project/" . $project["ref_no"] . "/tender_document.docx";
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/project/" . $project["ref_no"]. "/";
        $tempFile = $targetDir . "tender_document.docx";
        if (!file_exists($targetDir) && !mkdir($targetDir, 0755, true)) {
            $errors[] = "Unable to create tender document";
        }else{
            $template->saveAs($tempFile);
        }

        $template1 = new TemplateProcessor(__DIR__ . '/../../templates/offline_tender_document.docx');
        $template1->setValue('ref_no',$project["ref_no"]);
        $template1->setValue('nit_number', $nit_number);
        $template1->setValue('tender_publish_date', $tender_publish_date);
        $template1->setValue('work_name',$project["project_title"]);
        $template1->setValue('work_value',$budget_amount);
        $template1->setValue('work_value_words',numberToWords($budget_amount) . ' Only');
        $template1->setValue('tender_paper_cost', $tender_paper_cost);
        $template1->setValue('emd_amount',$emd_amount);
        $template1->setValue('bid_opening_date',$bid_opening_date);
        $template1->setValue('bid_closing_date',$bid_closing_date);
        $template1->setValue('price_bid_evaluation_date',$price_bid_evaluation_date);
        $template1->setValue('work_completion_deadline',$work_completion_deadline);
        $template1->setValue('work_description',$project["work_description"]);

        $filePath = "/uploads/project/" . $project["ref_no"] . "/offline_tender_document.docx";
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/project/" . $project["ref_no"]. "/";
        $tempFile = $targetDir . "offline_tender_document.docx";
        if (!file_exists($targetDir) && !mkdir($targetDir, 0755, true)) {
            $errors[] = "Unable to create offline tender document";
        }else{
            $template1->saveAs($tempFile);
        }


        if (empty($errors)) {
            $stmt = $pdo->prepare("UPDATE projects SET booked_amount=?, tender_publish_date=?, bid_opening_date=?, bid_closing_date=?, bid_evaluation_date=?, price_bid_evaluation_date=?, loi_issue_date=?, submission_stage=? WHERE id=?");
            $stmt->execute([$budget_amount, $tender_publish_date, $bid_opening_date, $bid_closing_date, $bid_evaluation_date, $price_bid_evaluation_date, $loi_issue_date, '3', $project_id]);
            
        }
    }

    if ($project["tender_direct"] === "Direct") {
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
        $template = new TemplateProcessor(__DIR__ . '/../../templates/work_order.docx');
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
        $filePath = "/uploads/project/" . $project["ref_no"] . "/work_order.docx";
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/project/" . $project["ref_no"]. "/";
        $tempFile = $targetDir . "work_order.docx";
        if (!file_exists($targetDir) && !mkdir($targetDir, 0755, true)) {
            $errors[] = "Unable to create Work order file";
        }else{
            $template->saveAs($tempFile);
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("UPDATE projects SET booked_amount=?, project_duration=?, contractor_name=?, contractor_address=?, contractor_phone=?, contractor_email=?,gst_details=?,emd_amount=?,emd_details=?, work_order=?, submission_stage=? WHERE id=?");
            $stmt->execute([$budget_amount, $project_duration, $contractor_name, $contractor_address, $contractor_contact, $contractor_email,$gst_details,$emd_amount,$emd_details, $filePath, '3', $project_id]);

            foreach ($milestones as $milestone) {
                $my_slno = $milestone["sl_no"];
                $milestone_completion_date = trim($_POST["milestone_completion_date_" . $my_slno] ?? '');
                $bill_generation_date = trim($_POST["bill_generation_date_" . $my_slno] ?? '');
                $stmt = $pdo->prepare("UPDATE milestones SET completion_date=?, bill_date=? WHERE project_id=? AND sl_no=?");
                $stmt->execute([$milestone_completion_date, $bill_generation_date, $project_id, $my_slno]);
            }

        }
    }
    $successMessage = "Project processed successfully";
    $_SESSION["successMessage"] = $successMessage;
    echo '<script>window.location.href="/staff/process_project.php?id='.$project_id.'";</script>';

}

?>