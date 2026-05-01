<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
   <?php $pageTitle = "Training & Placement at Gyanmanjari Innovative University"; 
       $meta_description = "Explore GMIU’s Training and Placement Cell – providing career guidance, skill development, and job placement support to help students succeed in their careers.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
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
                    <h1>Training & Placement Cell</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Training & Placement Cell</a></span>
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
                        <!-- Faculty about  -->
                        <section class="placement-overview">
                            <h3 class="title gradText">CO-ORDINATORS</h3>
                            <hr>

                            <div class="cards-placement-cell-container">
                                <?php
                                $cmd = "SELECT img_name, name, department FROM tbl_tpa_coordinator WHERE is_active = 1 AND is_delete = 0";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $img = $row['img_name'];
                                    $name = $row['name'];
                                    $department = $row['department'];
                                    if ($img == NULL) {
                                        echo '<div class="card">
                                    <div class="content">
                                        <div class="img">
                                            <img src="' . $website_assets_url . 'images/common/user.png" alt="image">
                                        </div>
                                        <div class="details">
                                            <div class="name">' . $name . '</div>
                                        </div>
                                        <div class="media-icons">
                                            <span>' . $department . '</span>
                                        </div>
                                    </div>
                                </div>';
                                    }else{
                                    echo '<div class="card">
                                    <div class="content">
                                        <div class="img">
                                            <img src="' . $upload_website_admin_url . 'training_and_placement/' . $img . '" alt=" tpa image">
                                        </div>
                                        <div class="details">
                                            <div class="name">' . $name . '</div>
                                        </div>
                                        <div class="media-icons">
                                            <span>' . $department . '</span>
                                        </div>
                                    </div>
                                </div>';
                                }
                            }
                                ?>

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
                                                    class="fa-solid fa-arrow-right"></i>GMIU Employability Performance Scale</a></li>

                                        <li><a href="student_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Student Testimonial</a></li>

                                        <li><a href="corporate_testimonial.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Corporate
                                                Testimonial</a></li>

                                        <!--<li><a href="https://gmiu.edu.in/placement/innovation-and-research" class=""><i-->
                                        <!--            class="fa-solid fa-arrow-right"></i> Innovation & Research</a></li>-->

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