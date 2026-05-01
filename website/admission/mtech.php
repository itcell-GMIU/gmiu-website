<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
     <style>
        @media only screen and (max-width: 767px) {
            .single-gallery img {
                width: 100% !important;
                height: auto;
            }
        }
    </style>
</head>

<body class="courses">
    <!-- Preloader -->
    <!-- <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> -->
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Admission Advertisement</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Admission Advertisement</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="single-courses-area">
        <div class="container">
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-12 sidebar-left"> 
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="events-list-03">
                            <div class="section-paddings gallery-images event-01" style="padding-top: 0px;">
                                <div class="container">
                                    <div class="row gallery_img_wrapper">
                                        <!--<div class="col-sm-6 col-md-6">-->
                                        <!--    <div class="single-gallery" style="display:flex;">-->
                                        <!--        <figure>-->
                                        <!--            <img style="height: auto; width: 100%;" src="../../admin_assets/images/B.TECH(D2D).jpg" alt="gallery">-->
                                        <!--            <figcaption>-->
                                        <!--                <a href="../../admin_assets/images/B.TECH(D2D).jpg" target="_blank" title=""><i class="fa fa-eye"></i></a>-->
                                        <!--            </figcaption>-->
                                        <!--        </figure>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="col-sm-6 col-md-6">
                                            <div class="single-gallery" style="display:flex;">
                                                <figure>
                                                    <img style="height: auto; width: 100%;" src="../../admin_assets/images/m.tech.jpg" alt="gallery">
                                                    <figcaption>
                                                        <a href="../../admin_assets/images/m.tech.jpg" target="_blank" title=""><i class="fa fa-eye"></i></a>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- left bar end -->
                
                
                <!-- right bar end -->
                <!-- right ber start -->
                <!--<div style="width: 350px;" class="sideBar">
                    <div class="sticky">
                        <div>
                            <ul>
                                <li>Admission</li>

                                <li><a href="<?php echo $base_url_admission; ?>" class=""><i class="fa-solid fa-arrow-right"></i> Apply Online</a></li>
                                <li><a href="https://gmiu.edu.in/admission/why-gmiu" class=""><i class="fa-solid fa-arrow-right"></i> Why GMIU</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php" class=""><i class="fa-solid fa-arrow-right"></i> Courses Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php" class="active"><i class="fa-solid fa-arrow-right"></i> e-Brochure & Scope Documents</a>
                                </li>
                                <li><a href="https://gmiu.edu.in/admission/important-links" class=""><i class="fa-solid fa-arrow-right"></i> Important Links</a></li>
                                <li><a href="https://gmiu.edu.in/admission/education-loan-facility" class=""><i class="fa-solid fa-arrow-right"></i> Education Loan Facilites</a>
                                </li>
                                <li><a href="https://gmiu.edu.in/admission/scholarships" class=""><i class="fa-solid fa-arrow-right"></i> Scholarships</a></li>
                                <li><a href="https://gmiu.edu.in/campus/transportation" class=""><i class="fa-solid fa-arrow-right"></i> Transportation Facilities</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
                <!--  right bar end -->

            </div>
        </div>
    </div>




</body>

</html>
