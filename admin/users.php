<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Users';
require_once 'header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Users</h5>
                        <table id="example" class="table table-hover table-display" style="width:100%">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Email</td>
                                    <td>Name</td>
                                    <td>Role</td>
                                    <td>Failed Attempts</td>
                                    <td>Locked Till</td>
                                    <td>Updated At</td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM users order by id asc");
                                $stmt->execute();
                                $districts = $stmt->fetchAll();
                                foreach ($districts as $dist) {
                                    echo '<tr>';
                                    echo '<td>' . $dist['id'] . '</td>';
                                    echo '<td>' . $dist['email'] . '</td>';
                                    echo '<td>' . $dist['name'] . '</td>';
                                    echo '<td>' . $dist['role'] . '</td>';
                                    echo '<td>' . $dist['failed_attempts'] . '</td>';
                                    echo '<td>' . $dist['locked_until'] . '</td>';
                                    echo '<td>' . $dist['updated_at'] . '</td>';
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