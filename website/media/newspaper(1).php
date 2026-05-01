<?php
include '../../common/importwebsitefile.php';
// include '../../database/connect.php';
// include '../../common/validation.php';
// include '../../common/globalvariable.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <style>
        .modal {
            display: none !important;
            /* Keeps them hidden */
            opacity: 0;
            visibility: hidden;
        }

        .modal.show {
            display: block !important;
            opacity: 1;
            visibility: visible;
        }

        /* Ensure modal is centered */
        .modal-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) !important;
            width: 80%;
            max-width: 750px;
            /* Adjusted size */
        }

        /* Responsive modal adjustments */
        @media (max-width: 768px) {

            /* Tablets */
            .modal-dialog {
                width: 90%;
                max-width: 600px;
            }
        }

        @media (max-width: 480px) {

            /* Mobile devices */
            .modal-dialog {
                width: 95%;
                max-width: 400px;
            }
        }

        /* Style modal content */
        .modal-content {
            border-radius: 12px;
            border: 3px solid #ff3b3b;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
            background: white;
        }

        /* Style modal header */
        .modal-header {
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /* Style modal image */
        .modal-body img {
            max-height: 70vh;
            /* Adjusted height for better mobile fit */
            width: auto;
            max-width: 100%;
            border-radius: 8px;
            border: 2px solid #ddd;
            padding: 5px;
            background: white;
        }


        /* Style modal content */
        .modal-content {
            border-radius: 12px;
            border: 1px solid #ff3b3b;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
            background: white;
            position: relative;
            z-index: 1055;
        }

        /* Style modal header */
        .modal-header {
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-header .btn-close {
            position: absolute;
            right: 15px;
            top: 15px;
            z-index: 1100;
            /* Ensure close button is above everything */
        }

        /* Style modal image */
        .modal-body img {
            max-height: 80vh;
            width: auto;
            border-radius: 10px;
            border: 2px solid #ddd;
            padding: 5px;
            background: white;
        }
    </style>
</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Newspaper</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a><i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Newspaper</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <!-- Newspaper Media Coverage -->
    <div class="single-courses-area">
        <div class="container">
            <h2 style="text-align: center; font-size: 30px;" class="text-danger">Newspaper Media Coverage</h2>
            <hr>

            <!-- Cards Grid -->
            <div class="row g-4" id="mediaContainer">
                <!-- Media Items will be loaded here via AJAX -->
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <ul class="pagination" id="pagination">
                    <!-- Pagination Links will be generated here -->
                </ul>
            </div>
        </div>
    </div>

    <?php include '../include/importfooter.php'; ?>
     <?php include '../include/importjs.php'; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            function loadMedia(page = 1) {
                $.ajax({
                    url: "fetch_media.php",
                    type: "GET",
                    data: { page: page },
                    success: function (response) {
                        var data = JSON.parse(response);
                        $("#mediaContainer").html(data.cards);
                        $("#pagination").html(data.pagination);
                    }
                });
            }

            // Initial Load
            loadMedia();

            // Handle Pagination Click
            $(document).on("click", ".page-link", function (e) {
                e.preventDefault();
                var page = $(this).data("page");
                loadMedia(page);
            });
        });
    </script>
</body>


</html>