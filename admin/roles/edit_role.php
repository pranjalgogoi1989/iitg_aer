<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
$title='Roles';
require_once '../header.php';

$get_id=$_GET["id"];
$get_role = $pdo->prepare("select * from roles where id=?");
$get_role->execute([$get_id]);
$role_master = $get_role->fetch(PDO::FETCH_ASSOC);
$successMessage="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $master_id=$_POST["role_id"];
    $rolename = trim($_POST['rolename']);
    // Validation
    if (strlen($rolename) < 3) {
      $errors[] = "Role Name must be at least 3 characters.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "update roles set rolename=? where id = ?"
        );
        $stmt->execute([$rolename,$master_id]);
        $successMessage= "Role Name Updated Successfully";
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <h5>Update Role</h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <input type="hidden" name="role_id" id="role_id" value="<?=$get_id?>">
                            <div class="mb-3">
                                <label for="rolename" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="rolename" name="rolename" value="<?=$role_master["rolename"]?>" placeholder="Enter Role Name">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="../roles.php" class="btn btn-info">Back</a>
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

<?php require_once '../bottom.php'; ?>