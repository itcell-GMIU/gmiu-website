<?php

date_default_timezone_set('Asia/Kolkata');
$currentTime = new DateTime();
$startTime = new DateTime('07:00:00'); // Allowed from
$endTime = new DateTime('18:00:00'); // Allowed till

// If current time is WITHIN allowed range → redirect to login
if ($currentTime >= $startTime && $currentTime < $endTime) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Software Closed | Calling Software</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Site favicon -->
    <!-- Standard Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="src/images/fav/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="src/images/fav/favicon-32x32.png">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="src/images/fav/apple-touch-icon.png">
    <!-- Android Chrome Icons -->
    <link rel="icon" type="image/png" sizes="192x192" href="src/images/fav/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="src/images/fav/android-chrome-512x512.png">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0f172a;
            font-family: Arial, sans-serif;
            color: #fff;
            text-align: center;
        }

        .closed-box {
            max-width: 500px;
            padding: 30px;
        }

        .closed-box img {
            width: 420px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        p {
            font-size: 15px;
            color: #cbd5f5;
        }

        .time {
            margin-top: 15px;
            font-size: 14px;
            opacity: 0.8;
        }

        /* ===============================
       MOBILE RESPONSIVE (ONLY)
       =============================== */
        @media (max-width: 576px) {
            body {
                padding: 15px;
                height: 90vh;
            }

            .closed-box {
                max-width: 100%;
                padding: 20px;
            }

            .closed-box img {
                width: 100%;
                max-width: 260px;
                margin-bottom: 16px;
            }

            h1 {
                font-size: 22px;
            }

            p {
                font-size: 14px;
            }

            .time {
                font-size: 13px;
            }
        }
    </style>

</head>

<body>

    <div class="closed-box">
        <img src="./src/images/giphy.gif" alt="Software Closed">

        <h1>Software Closed ⏳</h1>
        <p>
            This system is available only<br>
            <strong>7:00 AM – 6:00 PM</strong>
        </p>

        <div class="time">
            Please come back tomorrow morning 😊
        </div>
    </div>

</body>

</html>