<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('student');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='MyApplications';
require_once 'header.php';


?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-12">
                    <div class="card-body">

 <div class="row">
                           
                           


                                
                               <div class="col-xl-3 col-sm-6">
                               <a href="apply_card.php"> <div class="card bg-primary">
                                    <div class="card-body widget-style-2">
                                        <div class="text-white media">
                                            <div class="media-body align-self-center">
                                                <h3 class="my-0 text-white">Apply New ID Card</h3>
                                                <p class="mb-0"></p>
                                            </div>
                                                                                </div>
                                    </div>
                                </div></a>                            </div>

</div>

 </br> </br>
                        

<h5 class="card-title text-primary">My Application for Alumni card
                           
                        </h5>
                        <table id="example" class="table table-hover table-display" style="width:100%">
                            <thead>
                                <tr>
                                    <td>Roll No</td>
                                    <td>Name</td>
                                    <td>Mobile No</td>
                                    <td>Department</td>
                                    <td>Programme</td>
                                    <td>Card Type</td>
                                    <td>Status</td>
                                    <td>Updated At</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM applications where alt_email=? order by roll_no asc");
                                $stmt->execute([$_SESSION['email']]);
                                $students = $stmt->fetchAll();
                                foreach ($students as $stud) {
                                    echo '<tr>';
                                    echo '<td>' . $stud['roll_no'] . '</td>';
                                    echo '<td>'.$stud['salutation'] .' '. $stud['first_name'] .' '. $stud['last_name'].'</td>';
                                    echo '<td>' . $stud['mobile_number'] . '</td>';
                                    echo '<td>' . $stud['department'] . '</td>';
                                    echo '<td>' . $stud['programme'] . '</td>';
                                    if($stud['application_status']==''){
                                        echo '<td>-</td>';
                                    }else{
                                        if($stud['receipt']!=''){
                                            echo '<td>Offline</td>';
                                        }else{
                                            echo '<td>e-Card</td>';
                                        }
                                    }
                                    echo '<td>' . $stud['application_status'] . '</td>';
                                    echo '<td>' . $stud['updated_at'] . '</td>';
                                    if($stud['submission_stage']<=2){
                                        echo '<td><a href="apply_card.php?roll_no='.$stud['roll_no'].'" class="btn btn-primary">Edit</a></td>';
                                    }else{
                                        if($stud['application_status']=='Approved'){
                                            $stm2 = $pdo->prepare("SELECT * FROM accepted_applications where roll_no=?");
                                            $stm2->execute([$stud['roll_no']]);
                                            $stud2 = $stm2->fetch();
                                            if($stud2['status']=='generated'){
                                                $alumni_card = __DIR__ . '/../alumni_cards/' . $stud2['roll_no'] . '.pdf';
                                                if(file_exists($alumni_card)){
                                                    echo '<td><a href="downloadCard.php?roll_no=' . $stud2['roll_no'] . '" target="_blank" class="btn btn-primary">Download</a></td>';
                                                }
                                            }
                                        }
                                        echo '<td></td>';
                                    }
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