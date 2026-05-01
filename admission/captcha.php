<?php
session_start();

// Generate a random CAPTCHA code
$randomNumber1 = rand(1, 9);
$randomNumber2 = rand(1, 9);
$sum = $randomNumber1 + $randomNumber2;

// Store the sum in a session variable
$_SESSION['captcha_sum'] = $sum;

// Generate an image with the CAPTCHA code
$captchaImage = imagecreate(100, 30);
$bgColor = imagecolorallocate($captchaImage, 255, 255, 255);
$textColor = imagecolorallocate($captchaImage, 0, 0, 0);
imagestring($captchaImage, 5, 30, 10, $randomNumber1 . ' + ' . $randomNumber2 . ' = ?', $textColor);

// Display the image
header('Content-type: image/png');
imagepng($captchaImage);
imagedestroy($captchaImage);




// Generate a random CAPTCHA code
/* $randomText = generateRandomText(6); // Generate a 6-character random text
$_SESSION['captcha_text'] = $randomText; // Store the CAPTCHA text in a session variable

// Generate an image with the CAPTCHA code
$captchaImage = imagecreatetruecolor(100, 50);
$bgColor = imagecolorallocate($captchaImage, 255, 255, 255);
$textColor = imagecolorallocate($captchaImage, 0, 0, 0);
imagefilledrectangle($captchaImage, 0, 0, 100, 50, $bgColor);
imagestring($captchaImage, 5, 50, 20, $randomText, $textColor);

// Display the image
header('Content-Type: image/png');
imagepng($captchaImage);
imagedestroy($captchaImage);


function generateRandomText($length)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $randomText = '';
    for ($i = 0; $i < $length; $i++) {
        $randomText .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomText;
} */
?>