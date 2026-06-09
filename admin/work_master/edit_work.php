<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
$title='Work Master';
require_once '../header.php';

$successMessage="";
$get_id=$_GET["id"];
$get_work = $pdo->prepare("select * from work_master where id=?");
$get_work->execute([$get_id]);
$work_master = $get_work->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $master_id = trim($_POST["work_id"]);
    $shorthand = trim($_POST['short_hand']);
    $work_name = trim($_POST['work_name']);
    // Validation
    if (strlen($work_name) < 3) {
      $errors[] = "Work Name must be at least 3 characters.";
    }
    if (strlen($shorthand) < 1 && strlen($shorthand)>2) {
      $errors[] = "Short Name must be at of 2 characters.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "update work_master set shorthand=?, work_name=? where id=?"
        );
        $stmt->execute([strtoupper($shorthand), $work_name,$master_id]);
        $successMessage= "Work Name Updated Successfully";
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <h5>Edit Work </h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <input type="hidden" name="work_id" id="work_id" value="<?=$get_id?>">
                            <div class="mb-3">
                                <label for="short_hand" class="form-label">Short Name</label>
                                <input type="text" class="form-control" id="short_hand" name="short_hand" value="<?= $work_master['shorthand']?>" placeholder="Enter Short Name">
                            </div>
                            <div class="mb-3">
                                <label for="work_name" class="form-label">Work Name</label>
                                <input type="text" class="form-control" id="work_name" name="work_name" value="<?= $work_master['work_name']?>" placeholder="Enter Work Type">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="../work_master.php" class="btn btn-info">Back</a>
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