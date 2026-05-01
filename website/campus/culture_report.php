<?php
include '../../common/importwebsitefile.php';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
   <?php $pageTitle = "Cultural Report - Gyanmanjari Innovative University | GMIU";
      
    $meta_description = "Explore GMIU's campus culture report – showcasing student engagement, cultural activities, and the vibrant environment that fosters creativity and diversity at the university.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
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

        /* Style for navigation buttons */
        .swiper-button-next,
        .swiper-button-prev {
            position: absolute;
            top: 25%;
            /* Position buttons at the vertical center */
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            color: white;
            z-index: 10;
            border-radius: 50%;
        }

        .swiper-button-next {
            right: 20px;
        }

        .swiper-button-prev {
            left: 40px;
        }

        /* Style for pagination */
        .swiper-pagination {
            position: absolute;
            left: 18% !important;
            width: 70% !important;
            z-index: 10;
        }

        .brochure-card-gmiu {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
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

        .semester-content {
            display: none;
        }
    </style>
</head>

<body class="courses">

    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Cultural Report</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/culture_report.php">Cultural Report</a></span>
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

                        <!-- Faculty about  -->
                        <section class="events-list-03">
                            <div class="buttons-container-flex" style="padding: 10px;">
                                <?php
                                // Fetch distinct years for the buttons
                                $cmd = "SELECT DISTINCT YEAR(date) AS year FROM tbl_ssports WHERE report_type = 'Culture' AND is_active = 1 AND is_delete = 0";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $year = $row['year'];
                                    echo '<button class="tabBtn" data-semester="' . $year . '" onclick="showSemester(' . $year . ')">' . $year . '</button>';
                                }
                                ?>
                            </div>

                            <?php
                            // Fetch report data for each year
                            $cmd = "SELECT ssports.id as ssports_id, ssports.report_type as ssports_type, ssports.report_title as ssports_title, ssports.description as ssports_description, ssports.report as report, ssports.report_thumbnail as report_thumbnail, YEAR(date) as year FROM tbl_ssports as ssports WHERE ssports.is_delete = 0 AND ssports.report_type = 'Culture' ORDER BY year DESC";
                            $stmt = $con->prepare($cmd);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Grouping the reports by year
                            $reports_by_year = [];
                            while ($row = $result->fetch_assoc()) {
                                $year = $row['year'];
                                $reports_by_year[$year][] = $row;
                            }

                            foreach ($reports_by_year as $year => $reports) { ?>
                                <div class="semester-content" id="sem-<?php echo $year; ?>">
                                    <div class="row">
                                        <?php foreach ($reports as $report) {
                                            $ssports_id = $report['ssports_id'];
                                            $ssports_title = $report['ssports_title'];
                                            $ssports_description = $report['ssports_description'];

                                            // Fetch images related to the report
                                            $img_query = $con->prepare("SELECT image FROM tbl_ssports_images WHERE ssports_id = ?");
                                            $img_query->bind_param("i", $ssports_id);
                                            $img_query->execute();
                                            $img_result = $img_query->get_result();
                                        ?>
                                            <div class="col-sm-6">
                                                <div class="brochure-card-gmiu">
                                                    <div class="swiper-container">
                                                        <div class="swiper-wrapper">
                                                            <?php while ($img_row = $img_result->fetch_assoc()) { ?>
                                                                <div class="swiper-slide">
                                                                    <img alt="Image" src="<?php echo "../../website_admin/uploads/ssports/report_thumbnail/" . $img_row['image']; ?>">
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="swiper-pagination"></div>
                                                        <div class="swiper-button-next"></div>
                                                        <div class="swiper-button-prev"></div>
                                                    </div>
                                                    <div>
                                                        <h4><?php echo $ssports_title; ?></h4>
                                                    </div>
                                                    <div>
                                                        <p><?php echo $ssports_description; ?></p>
                                                    </div>
                                                    <a target="_blank" href="<?php echo "../../website_admin/uploads/ssports/report/" . $report['report']; ?>">
                                                        <button class="download-btn">Download Report</button>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
         <?php include "campussidebar.php"; ?>
    </div>

    <?php include '../include/importjs.php'; ?>
         <?php include '../include/importfooter.php'?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var swiper = new Swiper('.swiper-container', {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
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

        function showSemester(semesterId) {
            var semesterDivs = document.querySelectorAll('.semester-content');
            var semesterButtons = document.querySelectorAll('.tabBtn');

            // Hide all semester divs
            semesterDivs.forEach(function(div) {
                div.style.display = 'none';
            });

            // Remove active class from all buttons
            semesterButtons.forEach(function(button) {
                button.classList.remove('active');
            });

            // Show the selected semester and add the active class to the clicked button
            var selectedDiv = document.getElementById('sem-' + semesterId);
            if (selectedDiv) {
                selectedDiv.style.display = 'block';
            }

            document.querySelector('.tabBtn[data-semester="' + semesterId + '"]').classList.add('active');
        }

        // By default, show the content for the first available semester
        document.addEventListener('DOMContentLoaded', function () {
            var firstButton = document.querySelector('.tabBtn');
            if (firstButton) {
                firstButton.click();
            }
        });
    </script>
</body>

</html>
