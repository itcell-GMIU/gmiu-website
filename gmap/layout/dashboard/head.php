<?php include '../database/connect.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php
    $pageTitle = $pageTitle ?? "GMAP Dashboard";
    ?>
    <title>
        <?= htmlspecialchars($pageTitle) ?>
    </title>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #f4f6fa;
        }

        /* Theme Colors */
        .bg-theme-primary {
            background-color: #bc2823 !important;
        }

        .bg-theme-secondary {
            background-color: #1e264a !important;
        }

        .text-theme-primary {
            color: #bc2823 !important;
        }

        .text-theme-secondary {
            color: #1e264a !important;
        }

        /* Card Accent */
        .card-accent {
            border-left: 4px solid #bc2823;
        }


        /* CUSTOM BOOTSTRAP   */
        .btn-danger {
            color: #fff;
            background-color: #bc2823;
            border-color: #bc2823;
        }

        .btn-danger:hover {
            color: #fff;
            background-color: #a5221e;
            /* darker shade */
            border-color: #9f211d;
        }

        .btn-danger:focus {
            box-shadow: 0 0 0 0.25rem rgba(188, 40, 35, 0.5);
        }

        .btn-danger:active {
            background-color: #9f211d;
            border-color: #951f1b;
        }

        .nav-link {
            color: #1e264a !important;
        }

        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link.show {
            color: #bc2823 !important;
            border-bottom: 3px solid #1e264a !important;
        }

        @media (max-width: 768px) {
            .top-strip a {
                font-size: 0.75rem;
            }
        }
    </style>
</head>