<?php
session_start();

// Generate random captcha text
$captcha = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6);

// Store in session
$_SESSION['captcha'] = $captcha;

// Create image
$width = 180;
$height = 50;

$image = imagecreate($width, $height);

// Colors
$bg = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);
$lineColor = imagecolorallocate($image, 150, 150, 150);

// Add noise lines
for ($i = 0; $i < 8; $i++) {
    imageline(
        $image,
        rand(0, $width),
        rand(0, $height),
        rand(0, $width),
        rand(0, $height),
        $lineColor
    );
}

// Add captcha text
imagestring($image, 5, 40, 15, $captcha, $textColor);

// Output image
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>