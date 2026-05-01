<?php
include '../../common/importwebsitefile.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "NSS at Gyanmanjari Innovative University | Join Now | GMIU"; 
        $meta_description = "Learn about GMIU’s NSS initiatives that promote community service, leadership, and social responsibility among students.";
   ?>
   <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <style>
        /* Swiper container styling */
        .swiper-container {
            width: 100%;
            height: 250px;
            overflow: hidden;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            /* This will prevent overflow */
            object-fit: cover;
        }



        /* Style for pagination */
        .swiper-pagination {
            position: absolute;
            bottom: unset !important;
            /* Position at the bottom of the container */
            left: 18% !important;
            width: 70% !important;
            /* Center the pagination horizontally */
            z-index: 10;
            /* Ensure it's above the slides */
        }

        .brochure-card-gmiu {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            /*background-color: #f9f9f9;*/
            margin-bottom: 20px;
            border-radius: 10px 10px 10px 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            width: auto;
            /* height: auto; */
            margin: 10px;
            height: 450px;
            /* Adjust based on your layout */
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brochure-card-gmiu h4 {
            margin: 15px 0;
            font-size: 18px;
            color: #333;
        }

        .brochure-card-gmiu p {
            font-size: 14px;
            color: #666;
        }

        .download-btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .download-btn:hover {
            background-color: #0056b3;
        }

        .slider-image {
            display: none;
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .brochure-card-gmiu {
                width: 120% !important;
                /* Adjust width for smaller screens */
                margin-left: -25px;

            }
        }

        .brochure-card-gmiu .brochure-card-gmiu-content {
            width: 100%;
            border-radius: 10px 10px 10px 10px;
            box-shadow: unset;
        }

        @media (max-width: 480px) {
            .brochure-card-gmiu {
                width: 100%;
                /* Even smaller screens */

            }
        }

        .scrollable-description {
            max-height: 100px;
            /* Adjust as needed */
            overflow-y: auto;
            text-align: justify;
            margin-bottom: 10px;
            padding: 8px;
            /* border: 1px solid #ddd; */
            /* Light grey outline */
            border-radius: 5px;
            background-color: #fff;
            /* Optional: makes it look clean */
        }

        .scrollable-description::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable-description::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .scrollable-description::-webkit-scrollbar-thumb {
            background-color: #888;
            /* Grey thumb */
            border-radius: 10px;
        }

        .scrollable-description::-webkit-scrollbar-thumb:hover {
            background: #555;
            /* Darker on hover */
        }
    </style>
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include '../include/importheader.php'; ?>
    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>NSS</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/nss.php">NSS</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>
    <div class="flexContainer container">
        <div class="cont">
            <div class="curriculum-text-box">
                <div class="curriculum-section">
                    <div class="panel-group" id="accordion">
                        <div _ngcontent-mhr-c78="" class="row" style="margin-bottom: 20px;">
                            <div _ngcontent-mhr-c78="" class="col-md-4 col-sm-4">
                                <article _ngcontent-mhr-c78="" class="mu-blog-single-item" style="margin: 0px;">
                                    <figure _ngcontent-mhr-c78="" class="mu-blog-single-img"><a _ngcontent-mhr-c78=""
                                            href="#"><img _ngcontent-mhr-c78=""
                                                src="../../website_assets/images/nss_logo.jpeg" height="200px" alt="img"
                                                style="border-radius: 50%;"></a></figure>
                                </article>
                            </div>
                            <div _ngcontent-mhr-c78="" class="gradText"></div>
                            <div _ngcontent-mhr-c78="" class="col-md-8 col-sm-8">
                                <p _ngcontent-mhr-c78="" align="justify"> NSS was established with the mission for
                                    students. The first duty of the students should be, not to treat their period of
                                    study as one of the opportunities for indulgence in intellectual luxury, but for
                                    preparing themselves for final dedication in the service of those who provided the
                                    sinews of the nation with the national goods &amp; services so essential to society.
                                    Advising them to form a living contact with the community in whose midst their
                                    institution is located, he suggested that instead of undertaking academic research
                                    about economic and social disability, the students should do "something positive so
                                    that the life of the villagers might be raised to a higher material and moral
                                    level". </p>
                            </div>
                        </div>
                        <!-- Faculty about  -->
                        <section class="events-list-03">
                            <div class="buttons-container-flex" style="padding: 10px;">

                                <?php
                                $cmd = "SELECT YEAR(date) FROM tbl_NSS WHERE is_active = 1 AND is_delete = 0 GROUP BY YEAR(date)";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $sem_btn = $row['YEAR(date)'];
                                    echo '<button class="tabBtn" data-semester="' . $sem_btn . '" onclick="showSemester(' . $sem_btn . ')">' . $sem_btn . '</button>';
                                }
                                ?>


                            </div>

                            <div class="row">
                                <?php
                                // Existing query for fetching NSS data
                                $cmd = $con->prepare("SELECT NSS.id as NSS_id, NSS.report_title as NSS_title, NSS.report as NSS_document, NSS.report_thumbnail as NSS_thumbnail, NSS.description as NSS_description, YEAR(date) as NSS_year 
                                                    FROM tbl_NSS as NSS 
                                                    WHERE NSS.is_delete = ? AND YEAR(date) = ?");
                                $status = 0;
                                $stmt_years = $con->prepare("SELECT DISTINCT YEAR(date) as year FROM tbl_NSS WHERE is_delete = 0");
                                $stmt_years->execute();
                                $years = $stmt_years->get_result();

                                while ($year_row = $years->fetch_assoc()) {
                                    $sem_btn = $year_row['year'];
                                    $cmd->bind_param("ii", $status, $sem_btn); // Binding the year and status parameters
                                    $cmd->execute();
                                    $result = $cmd->get_result();
                                ?>
                                    <div class="semester-content" id="sem-<?php echo $sem_btn; ?>" style="display: none;">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $NSS_id = $row['NSS_id'];
                                                $NSS_title = !empty($row['NSS_title']) ? $row['NSS_title'] : "<b>N/A</b>";
                                                $NSS_description = !empty($row['NSS_description']) ? $row['NSS_description'] : "<b></b>";
                                                $NSS_thumbnail = !empty($row['NSS_thumbnail']) ? $row['NSS_thumbnail'] : "<b>N/A</b>";

                                                // Fetching the images from tbl_nss_images
                                                $img_query = $con->prepare("SELECT image FROM tbl_nss_images WHERE nss_id = ?");
                                                $img_query->bind_param("i", $NSS_id);
                                                $img_query->execute();
                                                $img_result = $img_query->get_result();
                                        ?>
                                                <div class="col-sm-6">
                                                    <div class="brochure-card-gmiu">

                                                        <?php
                                                        // Check if there are images available
                                                        $has_images = $img_result->num_rows > 0;
                                                        ?>

                                                        <?php if ($has_images) { ?>
                                                            <!-- Display Swiper Slider -->
                                                            <div class="swiper-container">
                                                                <div class="swiper-wrapper">
                                                                    <?php while ($img_row = $img_result->fetch_assoc()) { ?>
                                                                        <div class="swiper-slide">
                                                                            <img alt="Image" src="<?php echo "../../website_admin/uploads/NSS/report_thumbnail/" . $img_row['image']; ?>">
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="swiper-pagination"></div>
                                                                <!-- <div class="swiper-button-next"></div>
                                                                <div class="swiper-button-prev"></div> -->
                                                            </div>
                                                        <?php } else { ?>
                                                            <!-- Display NSS Thumbnail -->
                                                            <div class="brochure-card-gmiu-content">
                                                                <img alt="Image" src="<?php echo "../../website_admin/uploads/NSS/report_thumbnail/" . "$NSS_thumbnail"; ?>">
                                                            </div>
                                                        <?php } ?>
                                                        <div>
                                                            <h4><?php echo $row['NSS_title']; ?></h4>
                                                        </div>
                                                        <div class="scrollable-description">
                                                            <p><?php echo $NSS_description; ?></p>
                                                        </div>
                                                        <a target="_blank" href="<?php echo "../../website_admin/uploads/NSS/report/" . $row['NSS_document']; ?>">
                                                            <button class="download-btn">Download Report</button>
                                                        </a>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                        </section>
                    </div>
                </div>
            </div>
        </div>


        <!-- right ber start -->
        <?php include "campussidebar.php"; ?>
        <!--  right bar end -->
        <!--  right bar end -->

    </div>
    <?php include '../include/importjs.php'; ?>
    <?php include '../include/importfooter.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper('.swiper-container', {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 3000, // Time between slides in milliseconds (3000ms = 3 seconds)
                    disableOnInteraction: false, // Ensures autoplay continues even after interactions (like swiping manually)
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
    <script>
        function showSemester(semesterId) {
            var semesterDivs = document.querySelectorAll('.semester-content');
            var semesterButtons = document.querySelectorAll('.tabBtn');

            // Hide all semester divs
            for (var i = 0; i < semesterDivs.length; i++) {
                semesterDivs[i].style.display = 'none';
            }

            // Remove "active" class from all buttons
            for (var i = 0; i < semesterButtons.length; i++) {
                semesterButtons[i].classList.remove('tabBtn-active');
            }

            // Show the selected semester div
            var semesterDiv = document.getElementById('sem-' + semesterId);
            if (semesterDiv) {
                semesterDiv.style.display = 'block';
            }

            // Add "active" class to the clicked button
            var clickedButton = document.querySelector('.tabBtn[data-semester="' + semesterId + '"]');
            if (clickedButton) {
                clickedButton.classList.add('tabBtn-active');
            }
        }

        // Show the first semester content by default
        document.addEventListener('DOMContentLoaded', function() {
            var firstSemesterDiv = document.querySelector('.semester-content');
            if (firstSemesterDiv) {
                var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
                showSemester(firstSemesterId);
            }
        });
    </script>
</body>

</html>