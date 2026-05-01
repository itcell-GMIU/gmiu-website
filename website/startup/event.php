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


// Define the unique ID
$unique_id = 'form_1';

// Prepare and execute the query
$stmt = $con->prepare("SELECT list_ename, event_type, month, department FROM tbl_event WHERE unique_id = ?");
$stmt->bind_param('s', $unique_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data
$events = $result->fetch_all(MYSQLI_ASSOC);

// Define the unique ID
$unique_id = 'form_2';

// Prepare and execute the query
$stmt = $con->prepare("SELECT report_ename, company_name, location, date, report FROM tbl_event WHERE unique_id = ?");
$stmt->bind_param('s', $unique_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data
$eventss = $result->fetch_all(MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Startup Events at Gyanmanjari Innovative University"; 
        $meta_description = "Explore GMIU’s startup events featuring innovation challenges, entrepreneurial showcases, and networking to inspire and support student-led ventures.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
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
    </style>
    <style>
        .logo {
            height: 80px;
            width: auto;
            margin-right: 20px;
        }

        .flexContainer {
            display: flex;
            flex-direction: row;
        }

        .cont .curriculum-text-box .main-card .h3 {
            width: 302px;
            height: 26px;
        }

        .main-card {
            width: 800px;
            height: 400px;
            margin-bottom: 20px;
            padding: 20px 20px 20px 20px;
            background-color: #ba2a211a;
            border-radius: 10px;
        }

        .main-card .flex-img {
            width: 680px;
            height: 300px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .main-card .first-div img {
            width: 600px;
            height: 300px;
            border-radius: 5px;
        }

        .main-card .ul {
            width: 680px;
            height: auto;
        }

        .main-card .text li {
            width: 650px;
            height: 20;
            margin: 10px;
        }

        .main-card .ul .ul2 {
            width: 670px;
            height: auto;
            padding-left: 40px;
        }

        table {
            border-collapse: collapse;
            /* Collapse border spacing */
            width: 100%;
            /* Make table width 100% */
            border-radius: 10px;
            /* Apply border radius of 10% */
            padding: 10px;
            margin-left: 10px;
        }

        /* Style table headers */
        th {
            background-color: #ba2a21;
            /* Apply background color to header cells */
            color: white;
            /* Set text color for header cells */
        }

        /* Style table rows */
        tr:nth-child(even) {
            background-color: #ba2a2126;
            /* Apply alternate background color to even rows */
        }

        /* Style table cells */
        td,
        th {
            border: none;
            /* Remove borders from table cells */
            padding: 8px;
            /* Add padding to table cells */
            text-align: left;
            /* Align text to left in table cells */
            height: 50px;
            width: auto;
            font-size: 15px;
            padding: 15px;
        }

        .row {
            margin-right: 10px;
            margin-left: -15px;
        }

        .swiper-wrapper img {
            width: 100%;
            /* Ensure images fill the slider container */
            height: 400px;
            /* Maintain aspect ratio */
            object-fit: cover;
            /* Maintain aspect ratio and cover the entire slide */
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        .mySlides {
            display: none;

        }

        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .aactive {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
            .text {
                font-size: 11px
            }
        }

        .mySlides img {
            height: 400px;
            border-radius: 10px;

        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        .modal {
            display: none;
            /* Hide the modal by default */
            position: fixed;
            /* Stay in place */
            z-index: 999999;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scrolling if needed */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black w/ opacity */
        }

        .modal-content {
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            /* Adjust as needed */
            max-width: 800px;
            /* Maximum width of the modal */
            height: 80%;
            /* Adjust as needed */
        }

        .modal-content img {
            max-width: 100%;
            max-height: 100%;
        }

        /* CSS styles to reduce opacity of navbar when modal is open */
        .modal-open #navbar {
            overflow: auto;
            /* Enable scrolling if needed */
        }

        /* Close button style */
        .close {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #fff;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Center the image vertically */
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #navbar.modal-open {
            position: static;
            height: auto;
            overflow: visible;
        }
    </style>
    <style>
        .about-cards {
            padding: 20px;
            /* Add some padding to the section */
        }

        .events-list-03 {
            overflow-x: auto;
            /* Allows horizontal scrolling on smaller screens */
        }

        table {
            width: 100%;
            /* Box shadow for the table */
            border-collapse: collapse;
            /* Collapses borders between cells */

        }



        th,
        td {
            padding: 12px;
            /* Padding for table cells */
            text-align: left;
            /* Left-align text in cells */

        }



        /* Responsive adjustments */
        @media (max-width: 1200px) {

            th,
            td {
                padding: 10px;
            }
        }

        @media (max-width: 992px) {

            th,
            td {
                padding: 8px;
            }
        }

        @media (max-width: 768px) {


            th,
            td {
                padding: 6px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .col-sm-4 {
                margin-left: 30px;
            }

            .col-sm-8{
                width: 425px;
                margin-left: 25px;
            }

            th,
            td {
                padding: 4px;
                font-size: 12px;
            }
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
                        <!--<section class="about-cards">-->
                        <!--    <div>-->
                        <!--        <br />-->
                        <!--        <h3 class="gradText">GMSEC Event List</h3>-->
                        <!--        <br />-->
                        <!--    </div>-->
                        <!--    <div>-->
                        <!--        <section class="events-list-03">-->
                        <!--            <div class="row" class="card">-->
                        <!--                <table style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">-->
                        <!--                    <thead class="red-background">-->
                        <!--                        <tr>-->
                        <!--                            <th>Sr.No</th>-->
                        <!--                            <th>Event Name</th>-->
                        <!--                            <th>Type of Event</th>-->
                        <!--                            <th>Month</th>-->
                        <!--                            <th>Dept.</th>-->
                        <!--                        </tr>-->
                        <!--                    </thead>-->
                        <!--                    <tbody>-->
                                                <?php
                                                // $sr_no = 1;
                                                // foreach ($events as $event) {
                                                //     echo '<tr>';
                                                //     echo '<td>' . $sr_no++ . '</td>';
                                                //     echo '<td>' . htmlspecialchars($event['list_ename']) . '</td>';
                                                //     echo '<td>' . htmlspecialchars($event['event_type']) . '</td>';
                                                //     echo '<td>' . htmlspecialchars($event['month']) . '</td>';
                                                //     echo '<td>' . htmlspecialchars($event['department']) . '</td>';
                                                //     echo '</tr>';
                                                // }
                                                ?>
                        <!--                    </tbody>-->
                        <!--                </table>-->
                        <!--            </div>-->
                        <!--        </section>-->
                        <!--    </div>-->
                        <!--</section>-->
                        <!-- end of list -->


                        <!-- start of report -->
                        <section class="about-cards">
                            <div>
                                <br />
                                <h3 class="gradText">GMSEC Event Completion Report</h3>
                                <br />
                            </div>
                            <div>
                                <section class="events-list-03">
                                    <div class="row" class="card">
                                        <table style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                            <thead class="red-background">
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th>Event Name</th>
                                                    <th>Company/Institute Name</th>
                                                    <th>Location of Event</th>
                                                    <th>Date</th>
                                                    <th>Report</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sr_no = 1;
                                                foreach ($eventss as $event) {
                                                    // Construct the URL for the report file
                                                    $report_url = $upload_website_admin_url . htmlspecialchars($event['report'], ENT_QUOTES, 'UTF-8');

                                                    echo '<tr>';
                                                    echo '<td>' . $sr_no++ . '</td>';
                                                    echo '<td>' . htmlspecialchars($event['report_ename']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($event['company_name']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($event['location']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($event['date']) . '</td>';
                                                    // Add a button/link for downloading the report
                                                    echo '<td><a href="' . $report_url . '" target="_blank" rel="noopener noreferrer" class="btn-download">Download Report</a></td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                        <hr />
                                    </div>
                                </section>
                            </div>
                        </section>
                        <!-- end of report -->
                    </div>
                </div>
                <!-- left bar end -->
                <!-- right bar start -->
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <div>
                                    <ul>
                                         <li>
                                            STARTUP
                                        </li>
                                         <li>
                                                <a href="about_startup.php" class=""><i class="fa-solid fa-arrow-right"></i> About GMSEC</a>
                                            </li>
                                            <li>
                                                <a href="our_startup.php" class=""><i class="fa-solid fa-arrow-right"></i>Our Startup</a>
                                            </li>
                                            <li>
                                                <a href="ssip.php" class=><i class="fa-solid fa-arrow-right"></i>About SSIP & IPR </a>
                                            </li>
                                                <li>
                                                <a href="event.php" class="active"><i class="fa-solid fa-arrow-right"></i>GMSEC Event list</a>
                                            </li>
                                            <li>
                                                <a href="startupclub.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Incubation and startup club policy </a>
                                            </li>
                                             <li>
                                                <a href="startup_gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Gallery </a>
                                            </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right bar end -->
            </div>
        </div>
    </div>
    <!-- Footer Area section -->
    <?php include "../include/importfooter.php"; ?>
    <!-- ./ End Footer Area -->
    <!-- ============================ JavaScript Files ============================= -->
    <!-- jQuery -->
    <?php include "../include/importjs.php"; ?>


</body>

</html>