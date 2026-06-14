<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Approved Application for Alumni card';
require_once 'header.php';

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?=$title?></h5>
                        <form action="generateZip.php" method="post">
                            <table id="example" class="table table-hover table-display" style="width:100%">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" id="selectAll"></td>
                                        <td>Roll No</td>
                                        <td>Alt Email</td>
                                        <td>Name</td>
                                        <td>Mobile No</td>
                                        <td>Department</td>
                                        <td>Programme</td>
                                        <td>Card Type</td>
                                        <td>Updated At</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT * FROM students where application_status='Applied' and roll_no in (select roll_no from accepted_applications) order by roll_no asc");
                                    $stmt->execute();
                                    $students = $stmt->fetchAll();
                                    foreach ($students as $stud) {
                                        echo '<tr>';
                                        echo '<td><input type="checkbox" class="student-checkbox" name="student_ids[]" value="' . $stud['roll_no'] . '"></td>';
                                        echo '<td>' . $stud['roll_no'] . '</td>';
                                        echo '<td>' . $stud['alt_email'] . '</td>';
                                        echo '<td>'.$stud['salutation'] .' '. $stud['first_name'] .' '. $stud['last_name'].'</td>';
                                        echo '<td>' . $stud['mobile_number'] . '</td>';
                                        echo '<td>' . $stud['department'] . '</td>';
                                        echo '<td>' . $stud['programme'] . '</td>';
                                        if($stud['receipt']!=''){
                                            echo '<td>Offline</td>';
                                        }else{
                                            echo '<td>e-Card</td>';
                                        }
                                        echo '<td>' . $stud['updated_at'] . '</td>';
                                        $alumni_card = __DIR__ . '/../alumni_cards/' . $stud['roll_no'] . '.pdf';
                                        if(file_exists($alumni_card)){
                                            echo '<td><a href="/alumni_cards/' . $stud['roll_no'] . '.pdf" target="_blank" class="btn btn-primary">Download</a></td>';
                                        }else{
                                            echo '<td>-</td>';
                                        }
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <br>
                            <center>
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <button type="submit" id="generateZipBtn" class="btn btn-primary" disabled> Generate and DownloadZIP </button>
                            </center>
                        </form>
                    </div>
                </div>
                
            
            </div>
        </div>
    </div>
</div>
<script>
    
    $('#selectAll').on('change', function () {
        $('.student-checkbox').prop(
            'checked',
            this.checked
        );
        toggleGenerateButton();
    });
    function toggleGenerateButton() {
        if ($('.student-checkbox:checked').length > 0) {
            $('#generateZipBtn').prop('disabled', false);
        } else {
            $('#generateZipBtn').prop('disabled', true);
        }
    }
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
    $(document).on('change', '.student-checkbox', function () {
        toggleGenerateButton();
    });
</script>

<?php require_once 'bottom.php'; ?>