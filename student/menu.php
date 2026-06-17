<ul class="menu-inner py-1">

    <?php
    function isActive($pageName) {
        return basename($_SERVER['PHP_SELF']) == $pageName ? 'active' : '';
    }
    ?>
    <!-- Dashboard -->
    <li class="menu-item <?= isActive('index.php') ?>">
        <a href="/student" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>
    <?php
    if($_SESSION['email_verified'] == 1) {
    ?>
    <li class="menu-item <?= isActive('profile.php') ?>">
        <a href="/student/profile.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">My Profile</div>
        </a>
    </li>
    <li class="menu-item <?= isActive('my_applications.php') ?>">
        <a href="/student/my_applications.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Apply for Alumni Card</div>
        </a>
    </li>
    <?php

    }
    ?>
    
    <li class="menu-item <?= isActive('change_password.php') ?>">
        <a href="/student/change_password.php" class="menu-link">
            <i class="bx bx-power-off me-2"></i>
            <div data-i18n="Analytics">Change Password</div>
        </a>
    </li>
    <li class="menu-item <?= isActive('/logout.php') ?>">
        <a href="/logout.php" class="menu-link">
            <i class="bx bx-power-off me-2"></i>
            <div data-i18n="Analytics">Logout</div>
        </a>
    </li>
    
</ul>