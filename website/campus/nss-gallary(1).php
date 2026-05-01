    <?php
    include '../../common/importwebsitefile.php';
    ?>
    <!doctype html>
    <html class="no-js" lang="zxx">

    <head>
         <?php $pageTitle = "NSS Gallery | Gyanmanjari Innovative University | GMIU";
    include "../include/importhead.php"; ?>
        <?php include '../include/importcss.php'; ?>
        <style>
        @media screen and (max-width: 600px) {
            .gallery_img_wrapper {
                width: auto !important; /* Responsive width for mobile screens */
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
                        <h1>Gallery</h1>
                    </div>
                    <p style="margin-top:5px;">
                        <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                        <span class="b-active"><a href="">Gallery</a></span>
                    </p>
                    <hr>
                </div>
            </div>
        </section>
        <div class="section-paddings gallery-images event-01" style="padding-top: 0px;">
            <div class="flexContainer container">
                <div class="cont">
                    <div class="row gallery_img_wrapper" style="/* width: 900px; */">
                        <?php
                        $cmd = "SELECT `file_name` as gallery_image_name , title as title FROM `tbl_nss_gallary` Where is_active=1 AND is_delete=0 ";
                        $stmt = $con->prepare($cmd);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $gallery_img = $row['gallery_image_name'];
                                echo '<div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                    <div class="single-gallery">
                                        <figure>
                                            <img style="height: 245px;width: 345px;" src="' . $upload_website_admin_url . '../uploads/nss_gallary/image/' . $gallery_img . '" alt="gallery">
                                            <figcaption>
                                                <a href="' . $upload_website_admin_url . '../uploads/nss_gallary/image/' . $gallery_img . '"
                                                    title=""><i class="fa fa-eye"></i></a>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </div>';
                            }
                        }
                        ?>

                    </div>
                </div>
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