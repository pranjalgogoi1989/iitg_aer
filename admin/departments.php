<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Departments';
require_once 'header.php';

$successMessage="";
if(isset($_GET["successMessage"])){
    $successMessage=$_GET["successMessage"];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $short_name = trim($_POST['short_name']);
    $dept_name = trim($_POST['department']);
    // Validation
    if (strlen($short_name) < 2) {
      $errors[] = "Short Name must be at least 2 characters.";
    }
    if (strlen($dept_name) < 3) {
      $errors[] = "Department Name must be at least 3 characters.";
    }
    // Check duplicates
    $stmt = $pdo->prepare("SELECT id FROM departments WHERE short_name = ? and department_name = ? ");
    $stmt->execute([strtoupper($short_name), $dept_name]);
    if ($stmt->fetch()) {
        $errors[] = "Short Name and Department Name already exists.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO departments (short_name, department_name) VALUES (?,?)"
        );
        $stmt->execute([strtoupper($short_name), $dept_name]);
        $successMessage= "Department Added Successfully";
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
                        <h5 class="card-title text-primary">Department</h5>
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
                                    <td>Department</td>
                                    <td>Updated At</td>
                                    <td><i class="tf-icons bx bx-cog"></i></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM departments order by id asc");
                                $stmt->execute();
                                $sectors = $stmt->fetchAll();
                                foreach ($sectors as $rol) {
                                    echo '<tr>';
                                    echo '<td>' . $rol['id'] . '</td>';
                                    echo '<td>' . $rol['short_name'] . '</td>';
                                    echo '<td>' . $rol['department_name'] . '</td>';
                                    echo '<td>' . $rol['updated_at'] . '</td>';
                                    echo '<td>';
                                        echo '<a href="department/edit_department.php?id='.$rol['id'].'" class="btn btn-sm btn-info">Edit</a>';
                                        echo '<a href="department/delete_department.php?id='.$rol['id'].'"><i class="tf-icons bx bx-trash"></i></a>';
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
                        <h5>Enter New Department</h5>

                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <div class="mb-3">
                                <label for="short_name" class="form-label">Short Name</label>
                                <input type="text" class="form-control" id="short_name" name="short_name" placeholder="Enter Short Name">
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department Name">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
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

<?php require_once 'bottom.php'; ?>