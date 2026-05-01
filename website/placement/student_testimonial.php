<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Student Testimonials | Gyanmanjari Innovative University"; 
        $meta_description = "Read GMIU student testimonials—real stories of successful placements, career growth, and the valuable support provided by the placement cell.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url;?>css/program.css">
    <style>
    .stu-testimonial-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 50px;
    }

    .wel-text-box .wel-text {
        margin-top: -60px;
        padding: 67px 25px 40px;
    }

    .wel-text-box .wel-text p {
        overflow-wrap: break-word;
    }

    .wel-text-box .wel-text h3 {
        font-size: 21px;
        padding-bottom: 15px !important;
        text-transform: uppercase;
    }

    .wel-text-box .wel-icon img {
        height: 121px;
        border-radius: 50%;
        width: 121px;
        margin-top: 0;
    }

    .wel-text-box .wel-text p {
        padding-bottom: 10px;
        margin: 0;
        font-size: 13px;
        text-align: justify;
        /* height: 174px; */
        height: 200px;
        overflow: hidden;
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
                    <h1>Student Testimonial</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website;?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Student Testimonial</a></span>
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

                        <section>
                            <div class="stu-testimonial-grid">

                                <?php
                                $testimonial_type="student";
                                $cmd = "SELECT `name`,`testimonial_type`, `file`, `description` FROM `tbl_testimonial` WHERE is_active = 1 AND is_delete = 0 AND testimonial_type=?";
                               
                                $stmt = $con->prepare($cmd);
                                $stmt->bind_param("s", $testimonial_type);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                  
                                        $file_name= $row['file'];

                                        ?>
                                <!-- <div class="row"> -->
                                <div class="wel-ful-box-2">
                                    <div class="wel-text-box">
                                        <div class="wel-icon">
                                            <img src="<?php echo $upload_website_admin_url."testimonial/".$file_name; ?>"
                                                alt="student testimonial">
                                        </div>
                                        <div class="wel-text">
                                            <h3>
                                                <?php echo $row['name']; ?>
                                            </h3>
                                            <p>
                                                <?php echo $row['description']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                } ?>

                                <!-- </div> -->
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
                                        <!--  <li><a href="placement_overview_and_statistics.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Placement Overview &
                                                Statistics</a></li> -->
                                        <li><a href="placement_overview_and_statistics.php"
                                                class=""><i class="fa-solid fa-arrow-right"></i> Placement Overview &
                                                Statistics</a></li>
                                        <li><a href="geps.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> GMIU Employability Performance Scale</a>
                                        </li>
                                        <li><a href="student_testimonial.php" class="active"><i
                                                    class="fa-solid fa-arrow-right"></i>
                                                Student Testimonial</a>
                                        </li>
                                        <li><a href="corporate_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Corporate
                                                Testimonial</a>
                                        </li>
                                        <!--<li><a href="https://gmiu.edu.in/placement/innovation-and-research" class=""><i-->
                                        <!--            class="fa-solid fa-arrow-right"></i> Innovation &-->
                                        <!--        Research</a></li>-->

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
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>