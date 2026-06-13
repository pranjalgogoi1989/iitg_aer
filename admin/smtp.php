<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../security/csrf.php';
$title='SMTP Details';
require_once 'header.php';

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_validate($_POST['csrf_token']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $host = trim($_POST['host']);
    $port = trim($_POST['port']);
    $from = trim($_POST['from']);
    $mailer_name = trim($_POST['mailer_name']);
    $encryption = trim($_POST['encryption']);

    if ($email === '') {
        $errors[] = "Email is required";
    }
    if ($password === '') {
        $errors[] = "Password is required";
    }
    if ($host === '') {
        $errors[] = "Host is required";
    }
    if ($port === '') {
        $errors[] = "Port is required";
    }
    if ($from === '') {
        $errors[] = "From is required";
    }
    if ($mailer_name === '') {
        $errors[] = "Mailer Name is required";
    }
    if ($encryption === '') {
        $errors[] = "Encryption is required";
    }
    if(empty($errors)) {
        $stmt = $pdo->prepare("update smtp_details set email=?, password=?, host=?, port=?, from=?, mail_name=?, smtp_secure=?");
        $stmt->execute([$email, $password, $host, $port, $from, $mailer_name, $encryption]);
        $successMessage = "SMTP details updated successfully";
    }
}

$stmt = $pdo->prepare("SELECT * FROM smtp_details");
$stmt->execute();
$smtp = $stmt->fetchAll();
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card card-lg">
            <div class="d-flex align-items-top row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary text-center">SMTP Details</h5>
                        <?php
                            if($successMessage !== '') {
                                echo '<div class="alert alert-success">' . $successMessage . '</div>';
                            }
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="post">
                                    <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" name="email" value="<?=$smtp[0]['email'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" class="form-control" name="password" value="<?= $smtp[0]['password'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="host">Host</label>
                                                <input type="text" class="form-control" name="host" value="<?= $smtp[0]['host'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="port">Port</label>
                                                <input type="text" class="form-control" name="port" value="<?= $smtp[0]['port'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="from">From</label>
                                                <input type="text" class="form-control" name="from" value="<?= $smtp[0]['from'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mailer_name">Mailer Name</label>
                                                <input type="text" class="form-control" name="mailer_name" value="<?= $smtp[0]['mail_name'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="encryption">Encryption</label>
                                                <select name="encryption" id="encryption" class="form-control form-select">
                                                    <option value="tls" <?= $smtp[0]['smtp_secure'] == 'tls' ? 'selected' : '' ?>>TLS</option>
                                                    <option value="ssl" <?= $smtp[0]['smtp_secure'] == 'ssl' ? 'selected' : '' ?>>SSL</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <br>
                                    <center>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </center>
                                </form>
                            </div>
                        </div>
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