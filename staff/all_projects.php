<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('staff');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='All Projects';
require_once 'header.php';
?>


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary text-center"><?=$title?></h5>
                        
                        
                        <table class='table table-responsive table-hover' id="dataTable">
                            <thead>
                                <tr>
                                    <td>Ref. No.</td>
                                    <td>Project Title</td>
                                    <td>Initiating Engineer</td>
                                    <td>Sector No</td>
                                    <td>Site Location</td>
                                    <td>Work Type</td>
                                    <td>Estimated Cost</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $stmt = $pdo->prepare("SELECT * FROM projects ");
                                    $stmt->execute();

                                    if ($stmt->rowCount() > 0) {
                                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);                        
                                        foreach ($result as $row) {
                                            echo '<tr>';
                                            echo '<td>' . $row['ref_no'] . '</td>';
                                            echo '<td>' . $row['project_title'] . '</td>';
                                            echo '<td>' . $row['initiating_engineer'] . '</td>';
                                            echo '<td>' . $row['sector_no'] . '</td>';
                                            echo '<td>' . $row['site_location'] . '</td>';
                                            echo '<td>' . $row['work_type'] . '</td>';
                                            echo '<td> ₹ ' . $row['estimated_cost'] . '</td>';
                                            
                                            echo '<td width="20%">';
                                            echo '<a href="view_project.php?id=' . $row['id'] . '" class="btn btn-primary">View</a> ';
                                            if($row['submission_stage'] >= '2'){
                                                echo '<a href="process_project.php?id=' . $row['id'] . '" class="btn btn-info">Process</a>';
                                            }
                                            //echo '<a href="generate_loi.php?id=' . $row['id'] . '" class="btn btn-success">LOI</a>';
                                            //echo '<a href="generate_work_order.php?id=' . $row['id'] . '" class="btn btn-success">WO</a>';
                                            
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo "<tr><td colspan='8'>No matching records found.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        new DataTable('#dataTable');
    });
</script>

<?php require_once 'bottom.php'; ?>