<?php
session_start();

$length = 6; // CAPTCHA code length
$captchaCode = substr(str_shuffle("0123456789"), 0, $length);

$_SESSION['captcha_code'] = $captchaCode;

$image = imagecreatetruecolor(120, 40);
$bgColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);

imagefilledrectangle($image, 0, 0, 120, 40, $bgColor);

imagestring($image, 5, 20, 12, $captchaCode, $textColor);

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
