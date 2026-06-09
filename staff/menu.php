<ul class="menu-inner py-1">

    <?php
    function isActive($pageName) {
        return basename($_SERVER['PHP_SELF']) == $pageName ? 'active' : '';
    }
    ?>
    <!-- Dashboard -->
    <li class="menu-item <?= isActive('index.php') ?>">
        <a href="/staff" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-layout"></i><div data-i18n="Layouts">Projects</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item"><a href="/staff/new_project.php" class="menu-link"><div data-i18n="Blank">New Project</div></a></li>
            <li class="menu-item"><a href="/staff/all_projects.php" class="menu-link"><div data-i18n="Blank">All Projects</div></a></li>
        </ul>
    </li>
    
    <li class="menu-item <?= isActive('/logout.php') ?>">
        <a href="/logout.php" class="menu-link">
            <i class="bx bx-power-off me-2"></i>
            <div data-i18n="Analytics">Logout</div>
        </a>
    </li>
</ul>