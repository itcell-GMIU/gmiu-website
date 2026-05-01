<?php
include '../../common/importwebsitefile.php';


?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "GEPS Placement Opportunities at Gyanmanjari University"; 
    $meta_description = "Discover GMIU's GEPS program – empowering students with career guidance, industry skills, and placement opportunities to ensure successful transitions into the.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

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
                    <h1>Gyanmanjari Employability Performance Scale</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/index.php" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <!--<span class="b-active">-->
                    <!--    <i class='fa fa-angle-right'></i></span>-->
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/placement/geps.php">Gyanmanjari Employability Performance Scale</a></span>
                </p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            
            <div class="row two-colum-section">
                <!-- left bar start  -->
                
                <div class="col-sm-8 sidebar-left">
                    
                    <div class="single-curses-contert">
                        
                        <!-- Faculty about  -->
                        <section class="events-list-03">
                            <div class="container">
                                <div class="col-sm-8 events-full-box">
                                    <h3 style="color: red;">About Gyanmanjari Employability Performance Scale</h3>
                                    <br>
                                    <div style="text-align: justify;">
                                        Gyanmanjari Employability Performance Scale (GEPS) card is issued to every student of GMIU and overall performance which contains academic performance, SDP performance, Co and extra curricular activity performance, Technical and non-technical event participation etc. are carefully tracked and maintained regularly in order to map employability of student. Many times, recruiters choose students from GEPS data base of department
                                    </div>
                                    <br>
                                    <div class="events-single-box">
                                        <div class="" style="display: flex; align-items:center;">

                                        </div>
                                        <hr style="margin: 0;">

                                        <div class="row">
                                            <?php
                                            $status = 0;

                                            $cmd = $con->prepare("SELECT geps.id as geps_id, geps.type_id as type_id,geps.file_name as file_name FROM tbl_site_photos as geps 
                                                               WHERE geps.is_delete = ? AND geps.type_id = 100");
                                            $cmd->bind_param("i", $status);

                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $geps_id = $row['geps_id'];
                                                $file_name = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";

                                            ?>
                                                <div class="col-sm-6" style="padding: 10px;">
                                                   <img src='<?php echo $upload_website_admin_url . 'geps/image/' . $file_name; ?>' alt="Gyanmanjari Employability Performance Scale" style="width: 100%;">
                                                </div>

                                            <?php } ?>
                                        </div>
                                    </div>
                                    <br>
                                    <img src='gmiugepscard.png?v=2' alt="GEPS CARD" style="width: 100%; padding: 10px;"></a>
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
                                            PLACEMENT
                                        </li>
                                        <li><a href="training_and_placement_cell.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i>
                                                Training and Placement Cell</a></li>
                                        <li><a href="placement_overview_and_statistics.php"
                                                class=""><i class="fa-solid fa-arrow-right"></i> Placement Overview &
                                                Statistics</a></li>
                                        <li><a href="geps.php" class="active"><i
                                                    class="fa-solid fa-arrow-right"></i>GMIU Employability Performance Scale</a></li>

                                        <li><a href="student_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Student Testimonial</a></li>

                                        <li><a href="corporate_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Corporate
                                                Testimonial</a></li>

                                        <!--<li><a href="https://gmiu.edu.in/placement/innovation-and-research" class=""><i-->
                                        <!--            class="fa-solid fa-arrow-right"></i> Innovation & Research</a></li>-->

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

    



    <!-- ============================
    JavaScript Files
    ============================= -->
   
    <?php include '../include/importjs.php'; ?>
</body>

</html>