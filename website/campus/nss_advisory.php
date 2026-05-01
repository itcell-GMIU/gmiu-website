<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "NSS Advisory at Gyanmanjari Innovative University"; 
         $meta_description = "Learn about GMIU’s NSS Advisory promoting social responsibility, community engagement, and leadership through volunteer-driven initiatives for holistic growth.";
   ?>
     <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
      /* Add CSS for the table */
        table {
            border-collapse: collapse;
            /* Collapse border spacing */
            width: 100% !important;
            /* Make table width 100% */
            border-radius: 10px;
            /* Apply border radius of 10% */
            padding: 10px;
            /*margin-left: 10px;*/
            margin-bottom: 50px;

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
         .single-courses-area .tit-event {
                font-size: 25px;
                font-weight: 500;
                margin-top: 50px;
                margin-left: 20px;
        }
        @media (max-width: 992px) {
            .over-flow {
                overflow-x: auto;
            }
        }
        @media (max-width: 992px) {
            td {
                border: none;
        padding: 8px;
        text-align: center;
        height: 50px;
        width: 0px;
        font-size: 7px;
        padding: 0px 0px 0 7px;
            }
             table {
            border-collapse: collapse;
            /* Collapse border spacing */
            width: 100% !important;
            /* Make table width 100% */
            border-radius: 10px;
            /* Apply border radius of 10% */
            padding: 10px;
            /*margin-left: 10px;*/
            margin-bottom: 50px;

        }
        }
        @media (max-width: 992px) {
           th {
                       /* border: none; */
        padding: 8px;
        text-align: center;
        height: 50px;
        width: 0px;
        font-size: 7px;
        padding: 0px 0px 0 0px;
            }
         
    /*.row {*/
    /*    margin-right: -15px;*/
    /*    margin-left: -15px;*/
    /*}*/
        }
        /* Mobile-specific styling */
        @media (max-width: 992px) {
            table {
                transform: scale(1.2); /* Zoom in the table */
                transform-origin: center; /* Set the zoom origin to center */
                transition: transform 0.3s ease; /* Smooth zoom transition */
             /*   margin-left: -10%; /* Adjust horizontal alignment */
            }
        
            td, th {
                padding: 5px; /* Reduce padding for mobile view */
                font-size: 10px; /* Adjust font size */
                text-align: center;
            }
        
            .over-flow {
                overflow-x: auto;
            }
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
                    <h1>Advisory Committe</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
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
                        <br>
                        <div _ngcontent-mhr-c78=""  style="margin-bottom: 20px;">
                            <div _ngcontent-mhr-c78="" class="col-md-12 col-sm-4">
                                <?php
                                $status = 0;
                                $cmd = $con->prepare("SELECT nss_advisory.id as nss_advisory_id, nss_advisory.description as description FROM tbl_nss_advisory as nss_advisory
                               WHERE nss_advisory.is_delete = ?");
                                $cmd->bind_param("i", $status);
                                $cmd->execute();
                                $result = $cmd->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $nss_advisory_id = $row['nss_advisory_id'];
                                    $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
                                    // Your code to handle each row's data goes here
                                    // Your code to handle each row's data goes here
                                    echo $description;
                                }
                                ?>
                            </div>

                        </div>
                        <!-- Faculty about  -->

                    </div>
                </div>
            </div>
        </div>
        <!-- left bar end -->

        <!-- right ber start -->
        <!--<div style="width: 350px;" class="sideBar">-->
        <!--    <div class="sticky">-->
        <!--        <div>-->
        <!--            <ul>-->
        <!--                <li>Admission</li>-->

        <!--                <li><a href="https://gmiu.edu.in/campus/virtualtour" class=""><i class="fa-solid fa-arrow-right"></i>360 Virtual Tour </a></li>-->
        <!--                <li>-->
        <!--                    <div class="accordion">-->
        <!--                        <a class="accordion-toggle" data-toggle="collapse" href="#news-activities" role="button" aria-expanded="false" aria-controls="news-activities" style="text-decoration-line: none;">-->
        <!--                            <i class="fa-solid fa-arrow-right"></i> NSS-->
        <!--                        </a>-->
        <!--                        <div class="collapse" id="news-activities" style="width: 90%; margin-left:auto;">-->
        <!--                            <a href="about_nss.php"><i class="fa-solid fa-arrow-right"></i> About NSS</a>-->
        <!--                            <a href="nss_unit.php"><i class="fa-solid fa-arrow-right"></i> NSS Units and Program Officers </a>-->
        <!--                            <a href="nss-gallary.php"><i class="fa-solid fa-arrow-right"></i> NSS Gallery</a>-->
        <!--                            <a href="nss_advisory.php"><i class="fa-solid fa-arrow-right"></i> Advisory committe</a>-->
        <!--                            <a href="nss.php"><i class="fa-solid fa-arrow-right"></i> Activities</a>-->
        <!--                            <a href="contact_us.php"><i class="fa-solid fa-arrow-right"></i> Contact Us</a>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </li>-->
        <!--                <li><a href="https://gmiu.edu.in/gmiu/website/campus/gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>-->
        <!--                <li><a href="#" class="active"><i class="fa-solid fa-arrow-right"></i>Infrastructure</a>-->
        <!--                </li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i> Facility</a></li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>Curricular Activities</a>-->
        <!--                </li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>Extra Curricular Activities</a></li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>National/International Association</a>-->
        <!--                </li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>Academic System</a>-->
        <!--                </li>-->
        <!--            </ul>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <!-- right ber start -->
        <?php include "campussidebar.php"; ?>
        <!--  right bar end -->
        <!--  right bar end -->

    </div>
    </div>
    </div>


    <?php include '../include/importjs.php'; ?>
     <?php include '../include/importfooter.php'?>

</body>

</html>