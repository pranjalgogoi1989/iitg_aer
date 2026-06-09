<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Roles';
require_once 'header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $rolename = trim($_POST['rolename']);
    // Validation
    if (strlen($rolename) < 3) {
      $errors[] = "Role Name must be at least 3 characters.";
    }
    // Check duplicates
    $stmt = $pdo->prepare("SELECT id FROM roles WHERE rolename = ? ");
    $stmt->execute([$rolename]);
    if ($stmt->fetch()) {
        $errors[] = "Role already exists.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO roles (rolename) VALUES (?)"
        );
        $stmt->execute([$rolename]);
        echo "<div class='alert alert-success'>Role Added Successfully</div>";
        exit();
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Roles</h5>
                        <table id="example" class="table table-hover table-display" style="width:100%">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Role Name</td>
                                    <td>Updated At</td>
                                     <td><i class="tf-icons bx bx-cog"></i></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM roles order by rolename asc");
                                $stmt->execute();
                                $roles = $stmt->fetchAll();
                                foreach ($roles as $rol) {
                                    echo '<tr>';
                                    echo '<td>' . $rol['id'] . '</td>';
                                    echo '<td>' . $rol['rolename'] . '</td>';
                                    echo '<td>' . $rol['updated_at'] . '</td>';
                                    echo '<td>';
                                        echo '<a href="roles/edit_role.php?id='.$rol['id'].'" class="btn btn-sm btn-info">Edit</a>';
                                        echo '<a href="roles/delete_role.php?id='.$rol['id'].'"><i class="tf-icons bx bx-trash"></i></a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <h5>Enter New Role</h5>

                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <div class="mb-3">
                                <label for="rolename" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="rolename" name="rolename" placeholder="Enter Role Name">
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