<ul class="menu-inner py-1">

    <?php
    function isActive($pageName) {
        return basename($_SERVER['PHP_SELF']) == $pageName ? 'active' : '';
    }
    ?>
    <!-- Dashboard -->
    <li class="menu-item <?= isActive('index.php') ?>">
        <a href="/admin" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-layout"></i><div data-i18n="Layouts">Applications</div>
        </a>
        <ul class="menu-sub">
            
            <li class="menu-item"><a href="/admin/pending.php" class="menu-link"><div data-i18n="Blank">Pending</div></a></li>
            <li class="menu-item"><a href="/admin/approved.php" class="menu-link"><div data-i18n="Blank">Approved</div></a></li>
            <li class="menu-item"><a href="/admin/rejected.php" class="menu-link"><div data-i18n="Blank">Rejected</div></a></li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-layout"></i><div data-i18n="Layouts">Administration</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item"><a href="/admin/users.php" class="menu-link"><div data-i18n="Blank">Users</div></a></li>
            <li class="menu-item"><a href="/admin/students.php" class="menu-link"><div data-i18n="Blank">Students</div></a></li>
            <li class="menu-item"><a href="/admin/smtp.php" class="menu-link"><div data-i18n="Blank">SMTP</div></a></li>
            <li class="menu-item"><a href="/admin/dean.php" class="menu-link"><div data-i18n="Blank">Dean Sign</div></a></li>
        </ul>
    </li>
    

    <li class="menu-item <?= isActive('/logout.php') ?>">
        <a href="/logout.php" class="menu-link">
            <i class="bx bx-power-off me-2"></i>
            <div data-i18n="Analytics">Logout</div>
        </a>
    </li>
</ul>