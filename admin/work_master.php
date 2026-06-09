<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Work Master';
require_once 'header.php';

$successMessage="";
if(isset($_GET["successMessage"])){
    $successMessage= $_GET["successMessage"];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $shorthand = trim($_POST['short_hand']);
    $work_name = trim($_POST['work_name']);
    // Validation
    if (strlen($work_name) < 3) {
      $errors[] = "Work Name must be at least 3 characters.";
    }
    if (strlen($shorthand) < 1 && strlen($shorthand)>2) {
      $errors[] = "Short Name must be at of 2 characters.";
    }
    // Check duplicates
    $stmt = $pdo->prepare("SELECT id FROM work_master WHERE work_name = ? ");
    $stmt->execute([$work_name]);
    if ($stmt->fetch()) {
        $errors[] = "Work Name already exists.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO work_master (shorthand, work_name) VALUES (?,?)"
        );
        $stmt->execute([strtoupper($shorthand), $work_name]);
        $successMessage= "Work Name Added Successfully";
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
                        <h5 class="card-title text-primary">Work Master</h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>

                        <table id="example" class="table table-hover table-display" style="width:100%">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Short Name</td>
                                    <td>Work Name</td>
                                    <td>Updated At</td>
                                    <td><i class="tf-icons bx bx-cog"></i></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM work_master order by id asc");
                                $stmt->execute();
                                $work_master = $stmt->fetchAll();
                                foreach ($work_master as $rol) {
                                    echo '<tr>';
                                    echo '<td>' . $rol['id'] . '</td>';
                                    echo '<td>' . $rol['shorthand'] . '</td>';
                                    echo '<td>' . $rol['work_name'] . '</td>';
                                    echo '<td>' . $rol['updated_at'] . '</td>';
                                    echo '<td>';
                                        echo '<a href="work_master/edit_work.php?id='.$rol['id'].'" class="btn btn-sm btn-info">Edit</a>';
                                        echo '<a href="work_master/delete_work.php?id='.$rol['id'].'"><i class="tf-icons bx bx-trash"></i></a>';
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
                        <h5>Enter New Work Name</h5>

                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <div class="mb-3">
                                <label for="short_hand" class="form-label">Short Name</label>
                                <input type="text" class="form-control" id="short_hand" name="short_hand" placeholder="Enter Short Name">
                            </div>
                            <div class="mb-3">
                                <label for="work_name" class="form-label">Work Name</label>
                                <input type="text" class="form-control" id="work_name" name="work_name" placeholder="Enter Work Type">
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