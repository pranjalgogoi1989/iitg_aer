<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Office Users';
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
                <div class="col-sm-8">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Office Users</h5>
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
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM users where role='staff' order by id asc");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($users as $u) {
                                    echo '<tr>';
                                    echo '<td>' . $u['id'] . '</td>';
                                    echo '<td>' . $u['email'] . '</td>';
                                    echo '<td>' . $u['name'] . '</td>';
                                    echo '<td>' . $u['role'] . '</td>';
                                    echo '<td>' . $u['failed_attempts'] . '</td>';
                                    echo '<td>' . $u['locked_until'] . '</td>';
                                    echo '<td>' . $u['updated_at'] . '</td>';
                                    echo '<td><a href="remove_staff.php?id=' . $u['id'] . '" class="btn btn-danger">Remove</a></td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Add New Office User</h5>
                        <form action="add_staff.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
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