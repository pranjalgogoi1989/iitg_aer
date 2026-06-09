<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';

if (isset($_POST['search_criteria']) && isset($_POST['search_text'])) {
    $search_criteria = $_POST['search_criteria'];
    $search_text = $_POST['search_text'];

    $stmt = $pdo->prepare("SELECT * FROM land_allotment WHERE $search_criteria LIKE ?");
    $stmt->execute(["%$search_text%"]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $html ="<table class='table table-primary'>";
        $html .="<tr>";
        $html .="<th>Unique ID</th>";
        $html .="<th>Allotment No</th>";
        $html .="<th>Allotee Name</th>";
        $html .="<th>Mobile No</th>";
        $html .="<th>Land Type</th>";
        $html .= "<th>Dag No</th>";
        $html .= "<th>Sheet No</th>";
        $html .= "<th>Paid upto</th>";

        $html .= "<th>Actions</th></tr>";
        
        foreach ($result as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['unique_id'] . '</td>';
            $html .= '<td>' . $row['allotment_no'] . '</td>';
            $html .= '<td>' . $row['allotee_name'] . '</td>';
            $html .= '<td>' . $row['mobile_no'] . '</td>';
            $html .= '<td>' . $row['land_type'] . '</td>';
            $html .= '<td>' . $row['dag_no'] . '</td>';
            $html .= '<td>' . $row['sheet_no'] . '</td>';
            $html .= '<td>' . $row['paid_upto'] . '</td>';

            $html .= '<td>';
                $html .= '<a href="land_record_details.php?id=' . $row['id'] . '" class="btn btn-primary">View</a>';
                $html .= '<a href="edit_land_record.php?id=' . $row['id'] . '" class="btn btn-info">Edit</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= "</table>";
        echo $html;
    } else {
        echo "No matching records found.";
    }
} else {
    echo "Invalid request.";
}
?>