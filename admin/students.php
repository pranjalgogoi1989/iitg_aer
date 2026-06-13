<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Students';
require_once 'header.php';


?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Students</h5>
                        <table id="example" class="table table-hover table-display" style="width:100%">
                            <thead>
                                <tr>
                                    <td>Roll No</td>
                                    <td>Alt Email</td>
                                    <td>Name</td>
                                    <td>Mobile No</td>
                                    <td>Department</td>
                                    <td>Programme</td>
                                    <td>Updated At</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM students order by roll_no asc");
                                $stmt->execute();
                                $students = $stmt->fetchAll();
                                foreach ($students as $stud) {
                                    echo '<tr>';
                                    echo '<td>' . $stud['roll_no'] . '</td>';
                                    echo '<td>' . $stud['alt_email'] . '</td>';
                                    echo '<td>'.$stud['salutation'] .' '. $stud['first_name'] .' '. $stud['last_name'].'</td>';
                                    echo '<td>' . $stud['mobile_number'] . '</td>';
                                    echo '<td>' . $stud['department'] . '</td>';
                                    echo '<td>' . $stud['programme'] . '</td>';
                                    echo '<td>' . $stud['updated_at'] . '</td>';
                                    echo '<td><a href="student.php?id='.$stud['roll_no'].'" class="btn btn-primary">View</a></td>';
                                    echo '</tr>';
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
        $('#example').DataTable({
            layout: {
                bottomEnd: {
                    paging: {
                        firstLast: false
                    }
                }
            }
        });
    });
</script>

<?php require_once 'bottom.php'; ?>