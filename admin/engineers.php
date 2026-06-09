<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='Engineers';
require_once 'header.php';

$successMessage="";
if(isset($_GET["successMessage"])){
    $successMessage=$_GET["successMessage"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $eng_name = trim($_POST['eng_name']);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $user_id = trim($_POST["user_id"]);
    $dept_name = trim($_POST['department']);

    // Validation
    if (strlen($eng_name) < 2) {
      $errors[] = "Engineer Name must be at least 2 characters.";
    }
    if (empty($user_id)) {
      $errors[] = "Select Mapped User ID for engineer.";
    }
    if (strlen($email) < 2) {
      $errors[] = "Email is required.";
    }
    if (strlen($phone) < 2) {
      $errors[] = "Phone is required.";
    }
    if (strlen($dept_name) < 1) {
      $errors[] = "Department Name is required.";
    }
    // Check duplicates
    $stmt = $pdo->prepare("SELECT id FROM engineers WHERE engineer_name = ? and user_id=? and email = ? ");
    $stmt->execute([strtoupper($eng_name),$user_id, $email]);
    if ($stmt->fetch()) {
        $errors[] = "Engineer Name and Email already exists.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO engineers (user_id, engineer_name, email, phone, department) VALUES (?,?,?,?,?)"
        );
        $stmt->execute([$user_id, $eng_name, $email, $phone, $dept_name]);
        $successMessage= "Engineer Added Successfully";
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-sm-9">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Engineers</h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>

                        <table id="example" class="table table-hover table-display" style="width:100%">
                            <thead class="text-bold">
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Phone</td>
                                    <td>Department</td>
                                    <td>Last Modified</td>
                                    <td><i class="tf-icons bx bx-cog"></i></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM engineers order by id asc");
                                $stmt->execute();
                                $sectors = $stmt->fetchAll();
                                foreach ($sectors as $rol) {
                                    echo '<tr>';
                                    echo '<td>' . $rol['id'] . '</td>';
                                    echo '<td>' . $rol['engineer_name'] . '</td>';
                                    echo '<td>' . $rol['email'] . '</td>';
                                    echo '<td>' . $rol['phone'] . '</td>';
                                    echo '<td>' . $rol['department'] . '</td>';
                                    echo '<td>' . $rol['updated_at'] . '</td>';
                                    echo '<td>';
                                        echo '<a href="engineer/edit_engineer.php?id='.$rol['id'].'" class="btn btn-sm btn-info">Edit</a>';
                                        echo '<a href="engineer/delete_engineer.php?id='.$rol['id'].'"><i class="tf-icons bx bx-trash"></i></a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-3 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <h5>Enter New Engineer</h5>

                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <div class="mb-3">
                                <label for="eng_name" class="form-label">Engineer Name</label>
                                <input type="text" class="form-control" id="eng_name" name="eng_name" placeholder="Enter Engineer Name">
                            </div>
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User ID</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="" selected> Select UserName </option>
                                    <?php
                                        $stmt = $pdo->prepare("select * from users");
                                        $stmt->execute([]);
                                        $result = $stmt->fetchAll();
                                        foreach ($result as $rol) {
                                            echo '<option value ="' . $rol['id'] . '">' . $rol['username'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone">
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select name="department" id="department" class="form-control">
                                    <option value="" selected> Select Department </option>
                                    <?php
                                        $stmt = $pdo->prepare("select * from departments");
                                        $stmt->execute([]);
                                        $result = $stmt->fetchAll();
                                        foreach ($result as $rol) {
                                            echo '<option value ="' . $rol['short_name'] . '">' . $rol['department_name'] . '</option>';
                                    }
                                    ?>
                                </select>
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