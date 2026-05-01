<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "NSS Unit | Gyanmanjari Innovative University Campus | GMIU"; 
        $meta_description = "Explore GMIU's NSS Unit—encouraging social responsibility and community service through student-led initiatives that build leadership and compassion.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
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
                    <h1>NSS Units and Program Officers</h1>
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
                        <div _ngcontent-mhr-c78="" class="row" style="margin-bottom: 20px;">
                            <div _ngcontent-mhr-c78="" class="col-md-4 col-sm-4">
                                <?php
                                $status = 0;
                                $cmd = $con->prepare("SELECT nss_unit.id as nss_unit_id, nss_unit.description as description FROM tbl_nss_unit as nss_unit
                                 WHERE nss_unit.is_delete = ?");
                                $cmd->bind_param("i", $status);
                                $cmd->execute();
                                $result = $cmd->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $nss_unit_id = $row['nss_unit_id'];
                                    $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
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

 <?php include '../include/importfooter.php'; ?>
    <?php include '../include/importjs.php'; ?>

</body>

</html>