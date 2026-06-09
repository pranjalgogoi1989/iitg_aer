<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Work Types';
require_once 'header.php';

$successMessage="";
if(isset($_GET["successMessage"])){
    $successMessage=$_GET["successMessage"];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $work_type = trim($_POST['work_type']);
    // Validation
    if (strlen($work_type) < 3) {
      $errors[] = "Work Type must be at least 3 characters.";
    }
    // Check duplicates
    $stmt = $pdo->prepare("SELECT id FROM work_type WHERE work_type_name = ? ");
    $stmt->execute([$work_type]);
    if ($stmt->fetch()) {
        $errors[] = "Work Type already exists.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO work_type (work_type_name) VALUES (?)"
        );
        $stmt->execute([$work_type]);
        $successMessage= "Work Type Added Successfully";
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
                        <h5 class="card-title text-primary">Work Types</h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>

                        <table id="example" class="table table-hover table-display" style="width:100%">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Work Type</td>
                                    <td>Created At</td>
                                    <td>Updated At</td>
                                    <td><i class="tf-icons bx bx-cog"></i></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM work_type order by id asc");
                                $stmt->execute();
                                $work_types = $stmt->fetchAll();
                                foreach ($work_types as $rol) {
                                    echo '<tr>';
                                    echo '<td>' . $rol['id'] . '</td>';
                                    echo '<td>' . $rol['work_type_name'] . '</td>';
                                    echo '<td>' . $rol['created_at'] . '</td>';
                                    echo '<td>' . $rol['updated_at'] . '</td>';
                                    echo '<td>';
                                        echo '<a href="work_types/delete.php?id='.$rol['id'].'"><i class="tf-icons bx bx-trash"></i></a>';
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
                        <h5>Enter New Work TYpe</h5>

                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <div class="mb-3">
                                <label for="work_type" class="form-label">Work Type</label>
                                <input type="text" class="form-control" id="work_type" name="work_type" placeholder="Enter Work Type">
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