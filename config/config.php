<?php
// Force HTTPS in production
define('APP_ENV', 'development');

$secure = (APP_ENV === 'production');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Strict'
]);
if (APP_ENV === 'production') {

    $isSecure = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        $_SERVER['SERVER_PORT'] == 443 ||
        (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    );

    if (!$isSecure) {
        header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }
}


session_start();

// Regenerate session ID periodically
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

$host="localhost";
$user="root";
$pass="@Anjan1989";
$dbname="iitg_aer";
// PDO connection
$pdo = new PDO(
    "mysql:host=".$host.";dbname=".$dbname.";charset=utf8mb4",
    $user,
    $pass,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);