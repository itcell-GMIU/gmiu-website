<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "BKSVE Cell Gallery at Gyanmanjari Innovative University | GMIU"; 
    $meta_description = "Explore the IKSVE Cell Gallery at GMIU, showcasing initiatives that celebrate India’s rich knowledge heritage, cultural values, and traditional wisdom through engaging projects.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
    .flexContainer {
        gap:0px;
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
                    <h1>BKSVE CELL Gallery</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/nss.php">Gallery</a></span>
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
                        <section class="about-cards">
                            <!-- Motto of University card  -->
                            <div class="about-card" style="display: flex; align-items: center;">
                                <div class="section-paddings gallery-images event-01" style="padding-top: 0px;">
                                    <!--<div class="container">-->
                                        <div class="row gallery_img_wrapper">
                                            <?php
                                            $cmd = "SELECT    img_name FROM `tbl_iksve_cell` Where is_active=1 AND is_delete=0 ";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $gallery_img = $row['img_name'];
                                                    echo '<div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="single-gallery">
                                                                <figure>
                                                              
                                                                    <img style="height: 245px;width: 345px;" src="' . $upload_website_admin_url . '../uploads/iksve_cell/' . $gallery_img . '" alt="gallery">
                                                                    <figcaption>
                                                                        <a href="' . $upload_website_admin_url . '../uploads/iksve_cell/' . $gallery_img . '" title=""><i class="fa fa-eye"></i></a>
                                                                    </figcaption>
                                                                </figure>
                                                            </div>
                                                        </div>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    <!--</div>-->
                                </div>
                            </div>
                        </section>
                        <!-- Faculty about  -->

                    </div>
                </div>
            </div>
        </div>
        <!-- left bar end -->
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
    </div>
    </div>
     <?php include "../include/importfooter.php"; ?>

    <?php include "../include/importjs.php"; ?>
</body>

</html>