<?php
require_once __DIR__ . '/../../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../security/csrf.php';
$title='Edit User';
require_once '../header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $user_id = $_POST['user_id'];
    $user_name = trim($_POST['user_name']);
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $mobile_no = trim($_POST['mobile_no']);
    $password = trim($_POST['password']);
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
    // If no errors → insert
    if (empty($errors)) {
        if(empty($password)){
            $stmt = $pdo->prepare(
                "update users set username=?, email=?, name=?, role=?, mobile_no=? where id=?;"
            );
            $stmt->execute([$user_name, $email, $name, $role, $mobile_no,$user_id]);
        }else{
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(
                "update users set username=?, email=?, name=?, role=?, mobile_no=?, password=? where id=?;"
            );
            $stmt->execute([$user_name, $email, $name, $role, $mobile_no, $password,$user_id]);
        }
        echo "<div class='alert alert-success'>User Updated Successfully</div>";
    }
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_GET['id']]);
$user = $stmt->fetch();
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
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="user_name" class="form-label">UserName </label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User Name" value="<?= $user['username'] ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email </label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $user['email'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name </label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?= $user['name'] ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role </label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="admin">Admin</option>
                                            <option value="staff">Staff</option>
                                            <option value="user">User</option>
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
                                        <span>If the password is not changed, leave it blank</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="mobile_no" class="form-label">Mobile No </label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No" value="<?= $user['mobile_no'] ?>">
                                    </div>
                                </div>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="/admin/users.php" class="btn btn-info">Back</a>
                            </center>

                        </form>
                        <br>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>
<?php require_once '../bottom.php'; ?>