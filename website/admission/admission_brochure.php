<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Admission Brochure of Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Download GMIU's admission brochure—get complete details on courses, eligibility, application steps, and campus life to guide your admission journey.";
   ?>
   <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url;?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        .brochure-card-gmiu .brochure-card-gmiu-content img {
          border-radius: 10px 10px 0 0;
          height: 150px !important;
          width: 100% !important;
}
.brochure-card-gmiu .brochure-card-gmiu-content h4 {
  font-size: 15px;
  background-color: #333333;
  padding: 15px;
  display: flex;
  justify-content: center;
  color: white;
  border-radius: 0 0 10px 10px;
      height: 60px;

}
.brochure-card-gmiu{
    height : 220px;
}

@media (max-width: 767.98px) {
      /* Mobile view: Set width to 100% */
       .brochure-card-gmiu .brochure-card-gmiu-content img {
          border-radius: 10px 10px 0 0;
          height: 380px !important;
          width: 100% !important;
}
.brochure-card-gmiu .brochure-card-gmiu-content h4 {
  font-size: 15px;
  background-color: #333333;
  padding: 15px;
  /*display: flex;*/
  /*justify-content: center;*/
  color: white;
  border-radius: 0 0 10px 10px;
}
.brochure-card-gmiu{
    height : 450px;
    width: 400px;
}
.brochure-card-gmiu .brochure-card-gmiu-content {
    width: 90%;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
                    <h1>e-Brochure & Scope Documents</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website;?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">e-Brochure & Scope Documents</a></span>
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
                        <section class="events-list-03">
                            <div class="row text-center">
                                
                                <?php
                            $status = 0;

                            // First query: IDs from 25 to 33
                            $cmd = $con->prepare("SELECT 
                                                    brochure.id AS brochure_id, 
                                                    brochure.title AS brochure_title, 
                                                    brochure.document AS brochure_document, 
                                                    brochure.thumbnail AS brochure_thumbnail, 
                                                    brochure.is_active AS brochure_is_active,
                                                    brochure.sno
                                                FROM tbl_brochure AS brochure 
                                                WHERE brochure.is_delete = ? 
                                                ORDER BY 
                                                    CASE 
                                                        WHEN brochure.sno IS NOT NULL AND brochure.sno > 0 THEN 0 
                                                        ELSE 1  
                                                    END,
                                                    brochure.sno; ");
                            $cmd->bind_param("i", $status);
                            $cmd->execute();
                            $result = $cmd->get_result();
                            while ($row = $result->fetch_assoc()) {
                                $brochure_id = $row['brochure_id'];
                                $brochure_title = !empty($row['brochure_title']) ? $row['brochure_title'] : "<b>N/A</b>";
                                $brochure_document = !empty($row['brochure_document']) ? $row['brochure_document'] : "<b>N/A</b>";
                                $brochure_thumbnail = !empty($row['brochure_thumbnail']) ? $row['brochure_thumbnail'] : "<b>N/A</b>";
                            ?>
                                <div class="col-sm-3 text-center">
                                    <div class="brochure-card-gmiu">
                                    <a target="_blank" href="../../website_admin/uploads/brochure/document/<?php echo $brochure_document; ?>">
                                        <div class="brochure-card-gmiu-content text-center">
                                            <img alt="Image" src="../../website_admin/uploads/brochure/thumbnail/<?php echo $brochure_thumbnail; ?>">
                                            <h4><?php echo $brochure_title; ?></h4>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            <?php
                            }    ?>
                                
                           
                            </div>
                        </section>
                    </div>
                </div>
                <!-- left bar end -->

                <!-- right ber start -->
                <div style="width: 350px;" class="sideBar">
                    <div class="sticky">
                        <div>
                                <ul>
                                <li>Admission</li>
                                <li><a href="<?php echo $base_url_admission; ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                                        Apply Online</a></li>
                                <li><a href="why_gmiu.php" class=""><i class="fa-solid fa-arrow-right"></i> Why GMIU</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php" class=""><i class="fa-solid fa-arrow-right"></i> Courses Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php" class="active"><i class="fa-solid fa-arrow-right"></i> e-Brochure & Scope Documents</a>
                                </li>
                                <li><a href="importantlink.php" class=""><i class="fa-solid fa-arrow-right"></i> Important Links</a></li>
                                <li><a href="education_loan.php" class=""><i class="fa-solid fa-arrow-right"></i> Education Loan Facilites</a>
                                </li>
                                <li><a href="scholarships.php" class=""><i class="fa-solid fa-arrow-right"></i> Scholarships</a></li>
                                <li><a href="transportation.php" class=""><i class="fa-solid fa-arrow-right"></i> Transportation Facilities</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--  right bar end -->

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