<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "UGC Performa - Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Access GMIU’s UGC performance proforma with detailed academic and research info, meeting UGC guidelines for quality and transparency.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">

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
                    <h1>UGC Perfoma</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">UGC Perfoma</a></span>
                </p>

            </div>
        </div>
    </section>
    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">

                        <!-- Motto of University card  -->
                        <!--<div class="about-card">-->
                        <!--    <h4 class="gradText"><a href="../../website_assets/gmiu_doc/ugc_perfoma/3-annexure-signed-combine11zon.pdf" target="_blank"><b>Annexure</b> <i class="fa fa-external-link" aria-hidden="true"></i></h4></a>-->

                        <!--</div>-->
                        <!--<div class="about-card">-->
                        <!--    <h4 class="gradText"><a href="../../website_assets/gmiu_doc/ugc_perfoma/2-appendix-signed-combine.pdf" target="_blank"><b>Appendix</b> <i class="fa fa-external-link" aria-hidden="true"></i></h4></a>-->

                        <!--</div>-->
                        <div class="about-card">
                            <h4 class="gradText"><a href="../../website_assets/gmiu_doc/ugc_perfoma/1-performa-and-forwording-signed.pdf" target="_blank"><b>UGC Perfoma</b> <i class="fa fa-external-link" aria-hidden="true"></i></h4></a>

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
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>