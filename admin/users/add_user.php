<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
$title='Add User';
require_once '../header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $user_name = trim($_POST['user_name']);
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $mobile_no = trim($_POST['mobile_no']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    // Validation
    if (strlen($user_name) < 3) {
        $errors[] = "User Name must be at least 3 characters.";
    }
    if (strlen($email) < 3) {
        $errors[] = "Email must be at least 3 characters.";
    }
    if (strlen($name) < 3) {
        $errors[] = "Name must be at least 3 characters.";
    }
    if (strlen($password) < 3) {
        $errors[] = "Password must be at least 3 characters.";
    }
    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    // Check duplicates
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? or email = ? or mobile_no = ?");
    $stmt->execute([$user_name, $email, $mobile_no]);
    if ($stmt->fetch()) {
        $errors[] = "User Entry already exists.";
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    // If no errors → insert
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO users (username, email, name, role,mobile_no, password) VALUES (?,?,?,?,?,?)"
        );
        $stmt->execute([$user_name, $email, $name, $role, $mobile_no, $password]);
        echo "<div class='alert alert-success'>User Registered Successfully</div>"; 
    }else{
        echo "<div class='alert alert-warning'>".$errors[0]."</div>"; 
        //echo json_encode($errors);
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-top row">
                
                <div class="col-sm-12 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <h5>Enter New User</h5>

                        <form action="" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"/>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="user_name" class="form-label">UserName </label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User Name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email </label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name </label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role </label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="" selected> -- Select --</option>
                                            <?php
                                                $stmt = $pdo->prepare("SELECT * FROM roles");
                                                $stmt->execute();
                                                $roles = $stmt->fetchAll();
                                                foreach ($roles as $d) {
                                                    echo '<option value="'.$d['rolename'].'">' . $d['rolename'] . '</option>';
                                                }
                                                
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password </label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password </label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="mobile_no" class="form-label">Mobile No </label>
                                        <input type="mobile_no" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter mobile_no">
                                    </div>
                                </div>
                                
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

<?php require_once '../bottom.php'; ?>