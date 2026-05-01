<?php
include '../../common/importwebsitefile.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "BKSVE Gallery And Report - Gyanmanjari Innovative University | GMIU"; ?>
    <?php $meta_description = "Browse event highlights and activities from B.K.S.V.E. at GMIU. See how we promote skill development through engaging programs."; ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">

    <style>
        .swiper-container {
            width: 100%;
            height: 250px;
            overflow: hidden;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-button-next,
        .swiper-button-prev {
            position: absolute;
            top: 25%;
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

        .swiper-pagination {
            position: absolute;
            bottom: unset !important;
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
            margin: 35px 0;
            font-size: 18px;
            height:20px;
            color: #333;
        }
        .swiper-wrapper {
            height: 100% !important;
            padding-top: 10px;
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

        .tabBtn-active {
            background-color: #007bff;
            color: white;
        }
         .popup-modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
    }
    .popup-content {
        position: absolute;
        top: 25%;
        left: 25%;
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }
    .close-popup {
        position: absolute;
        top: 25%;
        right: 20%;
        color: white;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1001;
    }
    .popup-modal .popup-content {
        animation: zoom 0.6s;
    }
    @media screen and (max-width: 768px) {
    .popup-content {
        top: 40%;
        left: 5%;
        width: 90%;
    }
}
    @keyframes zoom {
        from { transform: scale(0) }
        to { transform: scale(1) }
    }
    </style>
</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>BKSVE Gallery And Report</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/sports_report.php">BKSVE Gallery And Report</a></span>
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

                        <section class="events-list-03">
                         

                            <?php
                            // Query for sports activity report data based on year
                            $cmd = $con->prepare("SELECT iksve.id as iksve_id, iksve.type_id as iksve_type, iksve.name as iksve_name, iksve.description as iksve_description, iksve.participants as iksve_participants, iksve.report as iksve_report  FROM tbl_iksve_cell as iksve WHERE iksve.is_delete = ?");
                            $status = 0;
                            $event_type = 'Sports';

                            // Query for distinct years
                            // $stmt_years = $con->prepare("SELECT DISTINCT YEAR(date) as year FROM tbl_ssports WHERE is_delete = 0 ORDER BY year DESC");
                            // $stmt_years->execute();
                            // $years = $stmt_years->get_result();

                            // $year_row = $years->fetch_assoc();
                            //     $sem_btn = $year_row['year'];

                                // Bind parameters for the main query
                                // $cmd->bind_param("isi", );
                                $cmd->bind_param("i", $status);

                                $cmd->execute();
                                $result = $cmd->get_result();
                            ?>
                                <div class="row">
                                    <div class="semester-content" id="sem-<?php echo $sem_btn; ?>" style="display: none;">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $iksve_id = $row['iksve_id'];
                                                $iksve_name = !empty($row['iksve_name']) ? $row['iksve_name'] : "<b>N/A</b>";
                                                $iksve_description = !empty($row['iksve_description']) ? $row['iksve_description'] : "<b></b>";

                                                // Query to fetch images for the report
                                                $img_query = $con->prepare("SELECT image FROM tbl_iksve_cell_images WHERE iksve_cell_id = ?");
                                                $img_query->bind_param("i", $iksve_id);
                                                $img_query->execute();
                                                $img_result = $img_query->get_result();
                                        ?>
                                                <div class="col-sm-6">
                                                    <div class="brochure-card-gmiu">
                                                        <div class="swiper-container">
                                                            <div class="swiper-wrapper">
                                                                <?php while ($img_row = $img_result->fetch_assoc()) { ?>
                                                                    <div class="swiper-slide">
                                                                        <img alt="Image" src="<?php echo "../../website_admin/uploads/iksve_cell/" . $img_row['image']; ?>" class="popup-image" 
                                                                            onclick="openPopup(this.src)">
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="swiper-pagination"></div>
                                                            <div class="swiper-button-next"></div>
                                                            <div class="swiper-button-prev"></div>
                                                        </div>
                                                         <!-- Popup Modal -->
                                                        <div id="imagePopup" class="popup-modal">
                                                            <span class="close-popup" onclick="closePopup()">&times;</span>
                                                            <img class="popup-content" id="popupImage" style="max-height: 80vh;">
                                                        </div>
                                                        <div>
                                                            <h4><?php echo $iksve_name; ?></h4>
                                                        </div>
                                                        <div>
                                                            <p><?php echo $iksve_description; ?></p>
                                                        </div>
                                                        <?php if (!empty($row['iksve_report'])) { // Check if the report is available ?>
                                                            <a target="_blank" href="<?php echo "../../website_admin/uploads/iksve_cell/" . $row['iksve_report']; ?>">
                                                                <button class="download-btn">Download Report</button>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>


                        </section>
                    </div>
                </div>
            </div>
           
        </div>
        <!-- right bar start  -->
        <div class="col-sm-4 sidebar-right">
            <div class="sidebar-content">
                <div class="sideBar">
                    <div class="sticky">
                        <ul>
                            <li>BKSVE CELL</li>
                            <li><a href="about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                            <li><a href="vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                            <li><a data-toggle="collapse" target="#collapse2" href="#collapse2" class="borAct collapsed" aria-expanded="false">
                                         <i class="fa fa-long-arrow-right"></i>Activities
                                         <span class="icon">
                                         <i class="fa fa-angle-down"> </i>
                                         </span>
                                         </a>  
                                         <div routerlinkactive="in" class="navSubDiv collapse"
                                            id="collapse2" aria-expanded="false" style="height: 0px;">
                                            <ul class="navSub">
                                               <li style="padding: 0px 0px;"><a href="fdp.php" ><i class="fa fa-long-arrow-right"></i>FDP</a></li>
                                               <li style="padding: 0px 0px;"><a href="sdp.php" ><i class="fa fa-long-arrow-right"></i>SDP</a></li>
                                               <li><a href="workshop_seminars.php"><i class="fa fa-long-arrow-right"></i>Workshop</a></li>
                                               <li><a href="other_activities.php" > <i class="fa fa-long-arrow-right"></i>Other Activity</a></li>
                                              </ul>
                                         </div>
                                    </li>   
                            <li><a href="gallery_bksve_cell.php" class="active"><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                            <li><a href="contact_us_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- right bar end  -->
    </div>

    <?php include '../include/importjs.php'; ?>
    <?php include '../include/importfooter.php'; ?>

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
            for (var i = 0; i < semesterDivs.length; i++) {
                semesterDivs[i].style.display = 'none';
            }

            // Remove "active" class from all buttons
            for (var i = 0; i < semesterButtons.length; i++) {
                semesterButtons[i].classList.remove('tabBtn-active');
            }

            // Show the selected semester div
            var semesterDiv = document.getElementById('sem-' + semesterId);
            semesterDiv.style.display = 'block';

            // Add "active" class to the clicked button
            document.querySelector('button[data-semester="' + semesterId + '"]').classList.add('tabBtn-active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var firstSemesterDiv = document.querySelector('.semester-content');
            if (firstSemesterDiv) {
                var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
                showSemester(firstSemesterId);
            }
        });
    </script>
<script>
    function openPopup(src) {
        var popup = document.getElementById("imagePopup");
        var popupImg = document.getElementById("popupImage");
        popup.style.display = "block";
        popupImg.src = src;
    }

    function closePopup() {
        var popup = document.getElementById("imagePopup");
        popup.style.display = "none";
    }
</script>
</body>

</html>
