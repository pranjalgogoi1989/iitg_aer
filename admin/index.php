<?php
require_once __DIR__ . '/../middleware/auth.php';
requireRole('admin');
$title='Dashboard';
require_once 'header.php';
?>


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <div class="card-body">
                <h5 class="card-title text-primary">Admin Dashboard</h5>
                <p class="mb-4">
                    Welcome to IPM Work Management Portal. 
                </p>
                
                
                </div>
            </div>
            
            </div>
        </div>
    </div>
</div>


<?php require_once 'bottom.php'; ?>