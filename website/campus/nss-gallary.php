    <?php
    include '../../common/importwebsitefile.php';
    ?>
    <!doctype html>
    <html class="no-js" lang="zxx">

    <head>
        <?php $pageTitle = "NSS Gallery | Gyanmanjari Innovative University | GMIU"; 
            $meta_description = "Explore GMIU’s NSS Gallery featuring student-led community service, social initiatives, and impactful moments from National Service Scheme activities.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
        <?php include "../include/importhead.php"; ?>
        <?php include '../include/importcss.php'; ?>
        <style>
            .single-gallery {
                position: relative;
                display: flex;
                flex-direction: column;
                /* Stack the image and title vertically */
                justify-content: space-between;
                /* Ensure there's space between image and title */
                height: 350px;
                /* Set a fixed height for the container (adjust as needed) */
                overflow: hidden;
                /* Prevent overflow */
            }

            .single-gallery figure {
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .single-gallery img {
                height: 245px;
                width: 345px;
                object-fit: cover;
                /* Ensure the image fits well within the container */
            }

            .image-title {
                text-align: center;
                padding-top: 10px;
                padding-bottom: 10px;
                overflow: hidden;
            }

            .image-title h3 {
                font-size: 16px;
                color: #333;
                line-height: 1.4;
                word-wrap: break-word;
                white-space: normal;
                margin: 0;
            }

            @media screen and (max-width: 600px) {
                .single-gallery {
                    height: auto;
                    /* Allow the container to adjust dynamically on small screens */
                }

                .single-gallery img {
                    width: 100%;
                    /* Ensure the image stretches to full width on mobile */
                    height: auto;
                    /* Let the height adjust based on the image aspect ratio */
                }
            }
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
                        <h1>NSS Gallery</h1>
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
                    <div class="row gallery_img_wrapper">
                        <?php
                        $cmd = "SELECT `file_name` as gallery_image_name , title  as title FROM `tbl_nss_gallary` Where is_active=1 AND is_delete=0 ";
                        $stmt = $con->prepare($cmd);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $gallery_img = $row['gallery_image_name'];
                                $image_title = $row['title']; // Assuming you have a column for the title
                                echo '<div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                    <div class="single-gallery">
                                        <figure>
                                            <img style="height: 245px;width: 345px;" src="' . $upload_website_admin_url . 'nss_gallary/image/' . $gallery_img . '" alt=" ' . $image_title . ' ">
                                       
                                        <div class="image-title">
                                            <h3>' . $image_title . '</h3> <!-- Title below the image -->
                                        </div>
                                        <figcaption>
                                            <a href="' . $upload_website_admin_url . 'nss_gallary/image/' . $gallery_img . '" title="' . $image_title . ' "><i class="fa fa-eye"></i>
                                              <span class="' . $image_title . '">View full image</span>
                                              </a>
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