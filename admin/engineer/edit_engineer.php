<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
$title='Edit Engineers';
require_once '../header.php';

$successMessage="";
$get_id = $_GET["id"];
$get_eng = $pdo->prepare("select * from engineers where id=?");
$get_eng->execute([$get_id]);
$engineer = $get_eng->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $id=trim($_POST["id"]);
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
      $errors[] = "Department is required.";
    }
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "update engineers set user_id=?, engineer_name=?, email=?, phone=?, department=? where id=?"
        );
        $stmt->execute([$user_id, $eng_name, $email, $phone, $dept_name, $id]);
        $successMessage= "Engineer Updated Successfully";
    }
}

?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6  text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <h5>Update Engineer Details</h5>
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
                        <?php elseif ($successMessage !== '') : ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <input type="hidden" name="id" id="id" value="<?=$get_id ?>">
                            <div class="mb-3">
                                <label for="eng_name" class="form-label">Engineer Name</label>
                                <input type="text" class="form-control" id="eng_name" name="eng_name" value="<?=$engineer['engineer_name']?>" placeholder="Enter Engineer Name">
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
                                            if($rol['id'] == $engineer['user_id']){
                                               echo '<option value ="' . $rol['id'] . '" selected>' . $rol['username'] . '</option>';
                                            }else{
                                                echo '<option value ="' . $rol['id'] . '" >' . $rol['username'] . '</option>';
                                            }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?=$engineer['email']?>">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="<?=$engineer['phone']?>">
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
                                            if($rol['short_name'] == $engineer['department']){
                                                echo '<option value ="' . $rol['short_name'] . '" selected>' . $rol['department_name'] . '</option>';
                                            }else{
                                                echo '<option value ="' . $rol['short_name'] . '">' . $rol['department_name'] . '</option>';
                                            }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="../engineers.php" class='btn btn-info'>Back</a>
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