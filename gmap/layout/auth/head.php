<?php include '../database/connect.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php
    $pageTitle = $pageTitle ?? "GMAP Registration";
    ?>
    <title><?= htmlspecialchars($pageTitle) ?>
    </title>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<style>
    body {
        background: #f4f6fa;
    }

    /* Decorative circles */
    .form-card::before,
    .form-card::after {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        z-index: 0;
    }

    .form-card::before {
        background: rgba(30, 38, 74, 0.1);
        top: -150px;
        left: -150px;
    }

    .form-card::after {
        background: rgba(188, 40, 35, 0.1);
        bottom: -150px;
        right: -150px;
    }

    .form-card>* {
        position: relative;
        z-index: 1;
    }

    .admin-logo {
        position: absolute;
        top: 15px;
        left: 15px;
    }

    .admin-logo img {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }

    /* Marquee Styles */
    .top-marquee {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: #bc2823;
        color: white;
        padding: 10px 0;
        z-index: 1500;
        font-weight: 600;
        overflow: hidden;
        white-space: nowrap;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .marquee-content {
        display: flex;
        width: max-content;
        animation: marquee-animation 60s linear infinite;
        font-size: 1.1rem;
        will-change: transform;
    }

    @keyframes marquee-animation {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    /* Animation for left-to-right */
    .marquee-left-to-right {
        display: inline-block;
        animation: marquee-ltr-animation 20s linear infinite;
        font-size: 1.1rem;
    }

    @keyframes marquee-ltr-animation {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }
</style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100"> <!-- // do not end body tag -->
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $showMarquee = in_array($currentPage, ['login.php', 'registration.php']);
    if ($showMarquee): ?>
        <div class="top-marquee">
            <div class="marquee-content">
                <span>
                    રજીસ્ટ્રેશન પ્રક્રિયા તારીખ 02/04/2026 થી શરુ, હેલ્પલાઈન નંબર : 9099951160 /
                    7574949494&nbsp;|&nbsp;રજીસ્ટ્રેશન
                    પ્રક્રિયા તારીખ 02/04/2026 થી શરુ, હેલ્પલાઈન નંબર : 9099951160 / 7574949494&nbsp;|
                </span>

                <span aria-hidden="true">
                    રજીસ્ટ્રેશન પ્રક્રિયા તારીખ 02/04/2026 થી શરુ, હેલ્પલાઈન નંબર : 9099951160 /
                    7574949494&nbsp;|&nbsp;રજીસ્ટ્રેશન
                    પ્રક્રિયા તારીખ 02/04/2026 થી શરુ, હેલ્પલાઈન નંબર : 9099951160 / 7574949494&nbsp;|
                </span>
            </div>
        </div>
        <style>
            .admin-logo {
                top: 60px !important;
            }

            body {
                padding-top: 50px !important;
            }
        </style>
    <?php endif; ?>