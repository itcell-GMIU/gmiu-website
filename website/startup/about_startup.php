<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "About Startups at Gyanmanjari Innovative University"; 
        $meta_description = "Learn about GMIU's Startup Program—empowering innovation and entrepreneurship with mentorship, resources, and support for student-led ventures.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        .swiper {
            width: 100%;
            height: 100%;
            margin: 20px;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        .swiper {
            width: 100%;
            height: auto;
            aspect-ratio: 16/10;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 80%;
            width: 100%;
        }

        .mySwiper {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
        }

        .events-list-03 .events-single-box img {
            border-radius: 5px;
        }

        .events-list-03 .event-info {
            padding-top: 0;
        }

        .events-list-03 .events-single-box {
            background-color: white;
        }

        #dwn-btn {
            padding: 5px 10px;
            background-color: #ba2a21;
            color: white;
            border: 1px transparent;
            border-radius: 4px;
        }

        #dwn-btn:hover {
            transform: translateY(-5px);
            transition: all .3s ease-in-out;
        }

        .rec-card {
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            max-width: 100%; /* Increased width for better alignment */
            height: fit-content;
            border-radius: 5px;
            border: 1px solid #ba2a21;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px; /* Add some padding for better spacing */
        }

        .rec-card .rec-img {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 15px;
            border-radius: 5px;
        }

        .rec-card .rec-img img {
            width: 150px;
        }

        .rec-card .rec-name {
            display: flex;
            justify-content: center;
            text-align: center;
            margin-top: 10px;
        }

        .rec-card .rec-name h5 {
            color: #ba2a21;
            font-size: 18px;
            font-weight: bold;
        }

        .responsive-paragraph {
            overflow-wrap: break-word;
            word-break: break-word;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .responsive-paragraph {
                font-size: 14px;
                padding: 10px;
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
                    <h1>About GMSEC</h1>
                </div>
                <p style="margin-top:5px;">
                    <span> <a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i> </span>
                    <span>Startup<i class='fa fa-angle-right'></i></span>
                    <span class="b-active">About GMSEC</span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="events-list-03" style="justify-content: center;">
                            <div class="rec-card">
                                <div class="rec-img">
                                    <img src="../../website_assets/images/GMSEC_Logo.png" alt="GMSEC LOGO | GMIU">
                                </div>
                                <div class="rec-name">
                                    <h5>Startup & Entrepreneurship Cell</h5>
                                </div>
                                <div  style="padding: 20px;">
                                    <?php
                                    $status = 0;
                                    $cmd = $con->prepare("SELECT about_startup.id as about_startup_id, about_startup.description as description FROM tbl_about_startup as about_startup 
                                                   WHERE about_startup.is_delete = ?");
                                    $cmd->bind_param("i", $status);
                                    $cmd->execute();
                                    $result = $cmd->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $about_startup_id = $row['about_startup_id'];
                                        $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
                                        echo '<p class="responsive-paragraph">' . htmlspecialchars_decode($description) . '</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
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
                                        <li>
                                            STARTUP
                                        </li>
                                        <li>
                                            <a href="about_startup.php" class="active"><i class="fa-solid fa-arrow-right"></i> About GMSEC</a>
                                        </li>
                                        <li>
                                            <a href="our_startup.php" class=""><i class="fa-solid fa-arrow-right"></i>Our Startup</a>
                                        </li>
                                        <li>
                                            <a href="ssip.php" class=""><i class="fa-solid fa-arrow-right"></i>About SSIP & IPR </a>
                                        </li>
                                        <li>
                                            <a href="event.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Event list</a>
                                        </li>
                                        <li>
                                            <a href="startupclub.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Incubation and startup club policy </a>
                                        </li>
                                        <li>
                                            <a href="startup_gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Gallery </a>
                                        </li>
                                        <!-- <li>-->
                                        <!--    <a href="event_report.php" class=""><i class="fa-solid fa-arrow-right"></i> About Event Report </a>-->
                                        <!--</li>-->
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

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>
