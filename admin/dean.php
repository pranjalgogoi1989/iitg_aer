<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
$title='Dean Signature Upload';
require_once 'header.php';
require_once __DIR__ . '/../security/csrf.php';
$successMessage = '';
$error='';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_FILES['file'])) {
        csrf_validate($_POST['csrf_token']);
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/dean_sign/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $document_name='sign';
        $originalName = $_FILES["file"]["name"];
        $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedTypes = ["jpg","jpeg"];
        if(!in_array($fileExt, $allowedTypes)) {
            $error="<span style='color:red'>Invalid file type.</span>";
        }
        if ($_FILES["file"]["size"] > 15 * 1024 * 1024) {
            $error = "<span style='color:red'>File too large (Max 15MB).</span>";
        }
        if($error=='') {
            $newFileName = $document_name . ".jpg";
            $targetFile = $targetDir . $newFileName;
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                $successMessage = "<span style='color:green;'>Upload Successful.</span>";
            } else {
                $error = "<span style='color:red;'>Upload failed.</span>";
            }
        }
        
    }
}

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary text-center"><?=$title?></h5>
                            <br>
                            <?=$successMessage?>
                            <?=$error?>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                                        <label for="file">Upload Signature</label>
                                        <input type="file" name="file" class="form-control" accept="image/*" required>
                                        <br>
                                        <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                        $file = '/uploads/dean_sign/sign.jpg';
                                        if($file!='') {
                                            echo '<img src="'.$file.'" class="img-fluid" alt="Responsive image" width="200" height="100">';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'bottom.php'; ?>