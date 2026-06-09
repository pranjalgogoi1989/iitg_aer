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
            <i class="menu-icon tf-icons bx bx-layout"></i><div data-i18n="Layouts">Administration</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item"><a href="/admin/work_master.php" class="menu-link"><div data-i18n="Blank">Work Master</div></a></li>
            <li class="menu-item"><a href="/admin/roles.php" class="menu-link"><div data-i18n="Blank">Roles</div></a></li>
            <li class="menu-item"><a href="/admin/users.php" class="menu-link"><div data-i18n="Blank">Users</div></a></li>
            <li class="menu-item"><a href="/admin/engineers.php" class="menu-link"><div data-i18n="Blank">Engineers</div></a></li>
            <li class="menu-item"><a href="/admin/sectors.php" class="menu-link"><div data-i18n="Blank">Sector</div></a></li>
            <li class="menu-item"><a href="/admin/departments.php" class="menu-link"><div data-i18n="Blank">Department</div></a></li>
            <li class="menu-item"><a href="/admin/work_types.php" class="menu-link"><div data-i18n="Blank">Work Types</div></a></li>
        </ul>
    </li>
    

    <li class="menu-item <?= isActive('/logout.php') ?>">
        <a href="/logout.php" class="menu-link">
            <i class="bx bx-power-off me-2"></i>
            <div data-i18n="Analytics">Logout</div>
        </a>
    </li>
</ul>