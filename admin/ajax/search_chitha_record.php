<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';

if (isset($_POST['search_criteria']) && isset($_POST['search_text'])) {
    $search_criteria = $_POST['search_criteria'];
    $search_text = $_POST['search_text'];

    $stmt = $pdo->prepare("SELECT * FROM chitha_register WHERE $search_criteria LIKE ?");
    $stmt->execute(["%$search_text%"]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $html = '<div class="row" style="font-weight: bold; background: #f1f1f1">';
        $html .= '<div class="col-sm-1">Chitha No</div>';
        $html .= '<div class="col-sm-2">Land Holder Name</div>';
        $html .= '<div class="col-sm-2">Father/Husband Name</div>';
        $html .= '<div class="col-sm-1">Village/Sector</div>';
        $html .= '<div class="col-sm-1">Land Use</div>';
        $html .= '<div class="col-sm-1">Area</div>';
        $html .= '<div class="col-sm-1">Occupancy Date/Year</div>';
        $html .= '<div class="col-sm-1">Updated At</div>';
        $html .= '<div class="col-sm-1">Actions</div>';
        $html .= '</div>';
       
        foreach ($result as $row) {
            $html .= '<div class="row">';
            $html .= '<div class="col-sm-1">' . $row['chitha_no'] . '</div>';
            $html .= '<div class="col-sm-2">' . $row['land_holder'] . '</div>';
            $html .= '<div class="col-sm-2">' . $row['father_husband'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['village_ward'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['land_use'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['area'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['occupy_date'] . '</div>';
            $html .= '<div class="col-sm-1">' . $row['updated_at'] . '</div>';
            $html .= '<div class="col-sm-2">';
            $html .= '<a href="chitha_record_details.php?id=' . $row['id'] . '" class="btn btn-primary">View</a>';
            //$html .= '<a href="edit_chitha.php?id=' . $row['id'] . '" class="btn btn-info">Edit</a>';
            $html .= '</div>';
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