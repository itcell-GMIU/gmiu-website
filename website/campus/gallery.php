<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "Campus Gallery at Gyanmanjari Innovative University"; 
         $meta_description = "Explore GMIU's campus gallery—featuring vibrant images of campus life, events, facilities, and student activities that reflect our dynamic environment.";
   ?>
   <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
    .visually-hidden {
    position: absolute !important;
    width: 1px; 
    height: 1px; 
    padding: 0; 
    margin: -1px; 
    overflow: hidden; 
    clip: rect(0, 0, 0, 0); 
    white-space: nowrap; 
    border: 0;
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
                    <h1>Gallery</h1>
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
                            <!--<div class="about-card" style="display: flex; align-items: center;">-->
                            <div class="about-card" style=" align-items: center;">
                                <div class="section-paddings gallery-images event-01" style="padding-top: 0px; padding: 0px 0px">
                                    <!--<div class="container">-->
                                        <div class="row gallery_img_wrapper">
                                            <?php
                                            $cmd = "SELECT `file_name` as gallery_image_name FROM `tbl_site_photos` Where is_active=1 AND is_delete=0 AND type ='gallery_image'";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $gallery_img = $row['gallery_image_name'];
                                                    echo '<div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                            <div class="single-gallery">
                                                                <figure>
                                                                    <img style="height: 245px;width: 345px;" src="' . $upload_website_admin_url . 'gallery_image/' . $gallery_img . '" 
                                                                         alt="GMIU Gallery Image">
                                                                    <figcaption>
                                                                        <a href="' . $upload_website_admin_url . 'gallery_image/' . $gallery_img . '" title="GMIU Gallery" 
                                                                             aria-label="View full image"><i class="fa fa-eye"></i>
                                                                             <span class="visually-hidden">View full image</span>
                                                                         </a>
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

        <!-- right ber start -->
        <?php include "../campus/campussidebar.php"; ?>
        <!--  right bar end -->

    </div>
    </div>
    </div>
  <!-- Footer Area section -->
    <?php include "../include/importfooter.php"; ?>

    <?php include '../include/importjs.php'; ?>

</body>

</html>