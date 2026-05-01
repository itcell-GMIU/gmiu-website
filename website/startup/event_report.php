<?php

include "../../common/importwebsitefile.php";

// Define the directory to store the uploaded files
$upload_dir = '../website_admin/uploads/event_report/';

// Ensure the directory exists and is writable
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Check if a file was uploaded
if (isset($_FILES['report_file']) && $_FILES['report_file']['error'] == UPLOAD_ERR_OK) {
    $report_file = $_FILES['report_file'];
    $report_filename = basename($report_file['name']);
    $report_filepath = $upload_dir . $report_filename;

    // Check if file already exists
    if (file_exists($report_filepath)) {
        echo "File already exists.";
    } else {
        // Move the uploaded file to the desired location
        if (move_uploaded_file($report_file['tmp_name'], $report_filepath)) {
            echo "File uploaded successfully.";
        } else {
            echo "Failed to upload file.";
        }
    }
} else {
    echo "";
}


// // Define the unique ID
// $unique_id = 'form_1';

// // Prepare and execute the query
// $stmt = $con->prepare("SELECT list_ename, event_type, month, department FROM tbl_event WHERE unique_id = ?");
// $stmt->bind_param('s', $unique_id);
// $stmt->execute();
// $result = $stmt->get_result();

// // Fetch data
// $events = $result->fetch_all(MYSQLI_ASSOC);

// // Define the unique ID
// $unique_id = 'form_2';

// // Prepare and execute the query
// $stmt = $con->prepare("SELECT report_ename, company_name, location, date, report FROM tbl_event WHERE unique_id = ?");
// $stmt->bind_param('s', $unique_id);
// $stmt->execute();
// $result = $stmt->get_result();

// // Fetch data
// $eventss = $result->fetch_all(MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <?php include "../include/importhead.php"; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css" />

    <!-- Add Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        .duration-intake p {
            color: #333333;
            margin-top: 4px;
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }
        .two-colum-section {
            display: unset;
        }
        .swiper-container {
        width: 100%;
        /*height: 100%;*/
    }

    .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .swiper-slide img {
        width: 100%;
        /*height: auto;*/
        object-fit: cover;
    }
    </style>


</head>

<body class="courses">
    <!-- Preloader <div id="preloader"> <div id="status">&nbsp;</div> </div> -->
    <?php include "../include/importheader.php"; ?>
    <!-- box below image -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>About Event</h1>
                </div>
                <p style="margin-top: 5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color: #727272;">Home</a> <i class="fa fa-angle-right"></i></span> <span class="b-active"><a href="">About Event</a></span>
                </p>
            </div>
        </div>
    </section>
    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">

                        <!-- start of list -->
                      
                            <div>
                                <br />
                                <h3 class="gradText">GMSEC Event Report</h3>
                                <br />
                            </div>
                            <div>
                               
                                <div style="padding: 20px 0;" class="row two-colum-section">
                                    <!-- left bar start  -->

                                    <!--<div class="col-sm-8 sidebar-left">-->

                                        <div class="single-curses-contert">
                                            <!-- Faculty about  -->
                                            <section class="events-list-03">
                                                <!--<div class="container">-->
                                                    <?php
                                                    //code for getting year buttons by grouping year in placement table
                                                    $cmd6 = "SELECT YEAR(date) FROM tbl_event_report WHERE is_active = 1 AND is_delete = 0 GROUP BY YEAR(date) ORDER BY YEAR(date)";
                                                    $stmt6 = $con->prepare($cmd6);
                                                    $stmt6->execute();
                                                    $result6 = $stmt6->get_result();

                                                    while ($row6 = $result6->fetch_assoc()) {
                                                        $sem_c = $row6['YEAR(date)'];
                                                    ?>
                                                        <!-- <div class="row event-body-content semester-content" id="sem-<?php //echo $sem_c; 
                                                                                                                            ?>" style="display: none;"> -->
                                                        <?php
                                                        $cmd = $con->prepare("SELECT event_report.id as event_id,event_report.event_name as event_report_title,event_report.report as event_report, event_report.event_description as event_description FROM tbl_event_report as event_report WHERE is_active=1 AND is_delete=0 AND YEAR(date) = $sem_c");
                                                        //  $cmd->bind_param("i", $program_id);
                                                        $cmd->execute();
                                                        $result = $cmd->get_result();
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                $event_report_title = $row['event_report_title'];
                                                                $event_description = $row['event_description'];
                                                                $event_id = $row['event_id'];
                                                                $event_report = $row['event_report'];
                                                        ?>
                                                              <div class="col-sm-12 events-full-box">
                                                                <div class="events-single-box">
                                                                    <div class="" style="display: flex; align-items:center;">
                                                                        <h3 class="color-gmiu" style="padding-top:0; margin-left:20px;">
                                                                            <?php echo $event_report_title; ?>
                                                                        </h3>
                                                                    </div>
                                                                    <hr style="margin: 0;">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 event-content" style="padding-top: 0;">
                                                                            <div class="event-wrapper" style="display: flex; flex-direction: column;">
                                                                                <!-- Image Section -->
                                                                                <div id="img-slider" style="flex: 1; padding-bottom: 20px;">
                                                                                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; padding-bottom: 0; " class="swiper mySwipers">
                                                                                        <div class="swiper-wrapper">
                                                                                            <?php
                                                                                            $type = "event_report";
                                                                                            $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                                                            $cmd1->bind_param("is", $event_id, $type);
                                                                                            $cmd1->execute();
                                                                                            $result1 = $cmd1->get_result();
                                                                                            if ($result1->num_rows > 0) {
                                                                                                while ($row1 = $result1->fetch_assoc()) {
                                                                                                    $file_name1 = $row1['sp_file_name'];
                                                                                            ?>
                                                                                                <div class="swiper-slide">
                                                                                                    <img src="<?php echo $upload_website_admin_url . 'event_report/image/' . $file_name1; ?>">
                                                                                                </div>
                                                                                            <?php }
                                                                                            } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                            
                                                                                <!-- Description Section -->
                                                                                <div class="event-info" style="flex: 1;">
                                                                                    <p class="events-time">
                                                                                        <?php echo htmlspecialchars_decode($event_description); ?>
                                                                                    </p>
                                                                                    <a target="_blank" href="<?php echo $upload_website_admin_url; ?>event_report/report/<?php echo $event_report ?>">
                                                                                        <button id="dwn-btn">
                                                                                            <i class="fa fa-download"></i>
                                                                                            Download Report
                                                                                        </button>
                                                                                    </a>
                                                                                    <br><br>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                               
                                          <?php
                                                    }
                                            ?>
                                             </div>
                                        <!--</div>-->
                                  </section>
                                     <!--</div>-->
                                 </div>
                             </div>
                         </div>
                     </div>
                <!-- left bar end  -->

                <!-- right bar start  -->

                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <div>
                                    <ul>
                                        <li>STARTUP</li>
                                        <li>
                                            <a href="about_startup.php" class=""><i class="fa-solid fa-arrow-right"></i> About Startup</a>
                                        </li>
                                        <li>
                                            <a href="our_startup.php" class=""><i class="fa-solid fa-arrow-right"></i>Our Startup</a>
                                        </li>
                                        <li>
                                            <a href="ssip.php" class=""><i class="fa-solid fa-arrow-right"></i>About SSIP & IPR </a>
                                        </li>
                                        <li>
                                            <a href="event.php" class=""><i class="fa-solid fa-arrow-right"></i> About Event List </a>
                                        </li>
                                         <li>
                                              <a href="startupclub.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Incubation and startup club policy </a>
                                        </li>
                                        <li>
                                            <a href="startup_gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Gallery </a>
                                        </li>
                                        <li>
                                            <a href="event_report.php" class="active"><i class="fa-solid fa-arrow-right"></i> About Event Report </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right bar end  -->
           
           </div>
        </div>
    </div>
     
        <!-- end of list -->

    <!--</div>-->

    <!-- left bar end -->
    <!-- right bar start -->
    <!-- right bar end -->

    <!-- Footer Area section -->
    <?php include "../include/importfooter.php"; ?>

    <!-- ./ End Footer Area -->
    <!-- ============================ JavaScript Files ============================= -->
    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <?php include "../include/importjs.php"; ?>

    <script>
        var swiper = new Swiper('.mySwipers', {
            loop: true, // Loop through slides
            autoplay: {
                delay: 3000, // 3 seconds delay
                disableOnInteraction: false, // Continue autoplay after user interaction
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
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

            // Show selected semester div if it exists, otherwise show the first available semester div
            var semesterDiv = document.getElementById('sem-' + semesterId);
            if (!semesterDiv) {
                for (var i = 0; i < semesterDivs.length; i++) {
                    if (semesterDivs[i].style.display !== 'none') {
                        semesterDiv = semesterDivs[i];
                        semesterId = semesterDiv.getAttribute('id').split('-')[1];
                        break;
                    }
                }
            }

            semesterDiv.style.display = 'block';

            // Add "active" class to the clicked button
            var clickedButton = document.querySelector('.tabBtn[data-semester="' + semesterId + '"]');
            clickedButton.classList.add('tabBtn-active');
        }

        // Find the first available semester div and show it
        var firstSemesterDiv = document.querySelector('.semester-content');
        if (firstSemesterDiv) {
            var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
            showSemester(firstSemesterId);
        }
    </script>


    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    
</body>

</html>
</body>

</html>