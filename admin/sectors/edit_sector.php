<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
$title='Edit Sectors';
require_once '../header.php';

$successMessage="";
if(isset($_GET["successMessage"])){
    $successMessage= $_GET["successMessage"];
}
$id=$_GET["id"];
$stms = $pdo->prepare("select * from sectors where id=?");
$stms->execute([$id]);
$sectors = $stms->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $sector_id = trim($_POST["sector_id"]);
    $sector_name = trim($_POST['sector_name']);
    $department = trim($_POST['department']);
    // Validation
    if (strlen($sector_name) < 3) {
      $errors[] = "Sector Name must be at least 3 characters.";
    }
    if (strlen($department) < 2) {
      $errors[] = "Department Name must be at of 2 characters.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "update sectors set sector_name=?, department=? where id=?"
        );
        $stmt->execute([$sector_name, $department,$sector_id]);
        $successMessage= "Sector and Department Name Updated Successfully";
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-3">
                    
                </div>
                <div class="col-sm-6 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <h5>Enter New Sector - Department</h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <input type="hidden" name="sector_id" id="sector_id" value="<?=$id?>" />
                            <div class="mb-3">
                                <label for="sector_name" class="form-label">Sector Name</label>
                                <input type="text" class="form-control" id="sector_name" name="sector_name" value="<?=$sectors['sector_name']?>" placeholder="Enter Sector Name">
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" value="<?=$sectors['department']?>" placeholder="Enter Department">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="../sectors.php" class="btn btn-info">Back</a>
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