<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';

if (isset($_POST['search_criteria']) && isset($_POST['search_text'])) {
    $search_criteria = $_POST['search_criteria'];
    $search_text = $_POST['search_text'];

    $stmt = $pdo->prepare("SELECT * FROM land_parcel WHERE $search_criteria LIKE ?");
    $stmt->execute(["%$search_text%"]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $html = '<div class="row" style="font-weight: bold; background: #f1f1f1">';
        $html .= '<div class="col-sm-1">Parcel ID</div>';
        $html .= '<div class="col-sm-2">Pattadar Name</div>';
        $html .= '<div class="col-sm-2">Father/Husband</div>';
        $html .= '<div class="col-sm-1">Ownership Type</div>';
        $html .= '<div class="col-sm-1">Tenure Type</div>';
        $html .= '<div class="col-sm-1">Area</div>';
        $html .= '<div class="col-sm-1">Dag No</div>';
        $html .= '<div class="col-sm-1">Land Use</div>';
        $html .= '<div class="col-sm-1">Updated At</div>';
        $html .= '<div class="col-sm-1">Actions</div>';
        $html .= '</div>';
       
        foreach ($result as $row) {
            $html .= '<div class="row">';
            $html .= '<div class="col-sm-1">' . $row['parcel_id'] . '</div>';
            $html .= '<div class="col-sm-2">' . $row['pattadar_name'] . '</div>';
            $html .= '<div class="col-sm-2">' . $row['father_husband'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['ownership_type'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['tenure_type'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['area'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['dag_no'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['land_use'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['updated_at'] . '</div>';
            $html .= '<div class="col-sm-1"><a href="land_parcel_details.php?id=' . $row['id'] . '" class="btn btn-primary">View</a></div>';
            $html .= '</div>';
        }
        echo $html;
    } else {
        echo "No matching records found.";
    }
} else {
    echo "Invalid request.";
}
?>