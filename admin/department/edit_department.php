<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
$title='Departments';
require_once '../header.php';

$successMessage="";
if(isset($_GET["successMessage"])){
    $successMessage=$_GET["successMessage"];
}

$id=$_GET["id"];
$stms= $pdo->prepare("select * from departments where id=?");
$stms->execute([$id]);
$departments = $stms->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $dept_id = trim($_POST["dept_id"]);
    $short_name = trim($_POST['short_name']);
    $dept_name = trim($_POST['department']);
    // Validation
    if (strlen($short_name) < 2) {
      $errors[] = "Short Name must be at least 2 characters.";
    }
    if (strlen($dept_name) < 3) {
      $errors[] = "Department Name must be at least 3 characters.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "update departments set short_name=?, department_name=? where id=?"
        );
        $stmt->execute([strtoupper($short_name), $dept_name, $dept_id]);
        $successMessage= "Department updated Successfully";
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-md-3"></div>
                <div class="col-sm-6 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <h5>Update Department</h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <input type="hidden" name="dept_id" id="dept_id" value="<?=$id?>" />
                            <div class="mb-3">
                                <label for="short_name" class="form-label">Short Name</label>
                                <input type="text" class="form-control" id="short_name" name="short_name" value="<?=$departments['short_name']?>" placeholder="Enter Short Name">
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" value="<?=$departments['department_name']?>" placeholder="Enter Department Name">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="../departments.php" class="btn btn-info">Back</a>
                        </form>
                        <br>
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