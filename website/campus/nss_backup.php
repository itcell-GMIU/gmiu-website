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
    .brochure-card-gmiu .brochure-card-gmiu-content img {
    border-radius: 10px 10px 0 0;
    height: auto !important;
    width: 100% !important;
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
                    <h1>NSS</h1>
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
                        <div _ngcontent-mhr-c78="" class="row" style="margin-bottom: 20px;">
                            <div _ngcontent-mhr-c78="" class="col-md-4 col-sm-4">
                                <article _ngcontent-mhr-c78="" class="mu-blog-single-item" style="margin: 0px;">
                                    <figure _ngcontent-mhr-c78="" class="mu-blog-single-img"><a _ngcontent-mhr-c78="" href="#"><img _ngcontent-mhr-c78="" src="../../website_assets/images/nss_logo.jpeg" height="200px" alt="img" style="border-radius: 50%;"></a></figure>
                                </article>
                            </div>
                            <div _ngcontent-mhr-c78="" class="gradText"></div>
                            <div _ngcontent-mhr-c78="" class="col-md-8 col-sm-8">
                                <p _ngcontent-mhr-c78="" align="justify"> NSS was established with the mission for students. The first duty of the students should be, not to treat their period of study as one of the opportunities for indulgence in intellectual luxury, but for preparing themselves for final dedication in the service of those who provided the sinews of the nation with the national goods &amp; services so essential to society. Advising them to form a living contact with the community in whose midst their institution is located, he suggested that instead of undertaking academic research about economic and social disability, the students should do "something positive so that the life of the villagers might be raised to a higher material and moral level". </p>
                            </div>
                        </div>
                        <!-- Faculty about  -->
                        <section class="events-list-03">
                            <div class="buttons-container-flex" style="padding: 10px;">

                                <?php
                                //code for getting year buttons by grouping year in placement table
                                $cmd = "SELECT YEAR(date) FROM tbl_NSS WHERE is_active = 1 AND is_delete = 0 GROUP BY YEAR(date) ";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $sem_btn = $row['YEAR(date)'];
                                ?>
                                    <!-- <a href="#s-<?php echo $sem_btn; ?>"> -->
                                    <button class="tabBtn" data-semester="<?php echo $sem_btn; ?>" onclick="showSemester(<?php echo $sem_btn; ?>)"><?php echo $sem_btn; ?></button>
                                    <!-- </a> -->
                                <?php
                                }
                                ?>
                            </div>
                            <div class="row">
                                <?php
                                //code for getting year buttons by grouping year in placement table
                                $cmd6 = "SELECT YEAR(date) FROM tbl_NSS WHERE is_active = 1 AND is_delete = 0  GROUP BY YEAR(date) ORDER BY YEAR(date)";
                                $stmt6 = $con->prepare($cmd6);
                                $stmt6->execute();
                                $result6 = $stmt6->get_result();

                                while ($row6 = $result6->fetch_assoc()) {
                                    $sem_c = $row6['YEAR(date)'];
                                ?>
                                    <div class="row event-body-content semester-content" id="sem-<?php echo $sem_c; ?>" style="display: none;">
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT NSS.id as NSS_id, NSS.report_title as NSS_title,NSS.report as NSS_document,NSS.report_thumbnail as NSS_thumbnail, NSS.is_active as NSS_is_active FROM tbl_NSS as NSS WHERE NSS.is_delete = ? AND YEAR(date) = $sem_c");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $NSS_id = $row['NSS_id'];
                                            $NSS_title = !empty($row['NSS_title']) ? $row['NSS_title'] : "<b>N/A</b>";
                                            $NSS_document = !empty($row['NSS_document']) ? $row['NSS_document'] : "<b>N/A</b>";
                                            $NSS_thumbnail = !empty($row['NSS_thumbnail']) ? $row['NSS_thumbnail'] : "<b>N/A</b>";


                                        ?>
                                            <div class="col-sm-6">
                                                <div class="brochure-card-gmiu">
                                                    <a target="_blank" href="<?php echo "../../website_admin/uploads/NSS/report/" . "$NSS_document"; ?>">
                                                        <div class="brochure-card-gmiu-content">
                                                            <img alt="Image" src="<?php echo "../../website_admin/uploads/NSS/report_thumbnail/" . "$NSS_thumbnail"; ?>">
                                                            <h4><?php echo $NSS_title; ?></h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </section>
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
        <!--                            <a href="nss_advisory.php"><i class="fa-solid fa-arrow-right"></i> Advisory committe</a>-->
        <!--                            <a href="nss-gallary.php"><i class="fa-solid fa-arrow-right"></i> NSS Gallery</a>-->
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
    <script>
        function showSemester(semesterId) {
            var semesterDivs = document.querySelectorAll('.semester-content');
            var semesterButtons = document.querySelectorAll('.tabBtn');

            // Hide all semester divs
            for (var i = 0; i < semesterDivs.length; i++) {
                semesterDivs[i].style.display = 'none';
            }

            // Remove "active" class from all buttons
            for (var i = 0; i < semesterButtons.length; i++) {
                semesterButtons[i].classList.remove('tabBtn-active');
            }

            // Show selected semester div if it exists, otherwise show the first available semester div
            var semesterDiv = document.getElementById('sem-' + semesterId);
            if (!semesterDiv) {
                for (var i = 0; i < semesterDivs.length; i++) {
                    if (semesterDivs[i].style.display !== 'none') {
                        semesterDiv = semesterDivs[i];
                        semesterId = semesterDiv.getAttribute('id').split('-')[1];
                        break;
                    }
                }
            }

            semesterDiv.style.display = 'block';

            // Add "active" class to the clicked button
            var clickedButton = document.querySelector('.tabBtn[data-semester="' + semesterId + '"]');
            clickedButton.classList.add('tabBtn-active');
        }

        // Find the first available semester div and show it
        var firstSemesterDiv = document.querySelector('.semester-content');
        if (firstSemesterDiv) {
            var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
            showSemester(firstSemesterId);
        }
    </script>


    <?php include '../include/importjs.php'; ?>
     <?php include '../include/importfooter.php'?>

</body>

</html>