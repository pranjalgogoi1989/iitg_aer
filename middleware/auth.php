<?php
require_once __DIR__ . '/../config/config.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php");
        exit();
    }
}

function requireRole($roles) {
    requireLogin();

    if (!is_array($roles)) {
        $roles = [$roles];
    }

    if (!in_array($_SESSION['role'], $roles)) {
        header("Location: unauthorized.php");
        exit();
    }
}