<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Transportation Information | Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Discover GMIU's admission transport services—offering convenient travel options for prospective students to easily reach campus and nearby areas.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
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
                    <h1>Transportation Facility</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Transportation Facility</a></span>
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

                        <img src="<?php echo $website_assets_url ?>images/transport.webp" alt="TRANSPORTATION FACILITY for GMIU students" style="height: 400px; width: auto; margin: bottom 30px; ;"></a>
                        <!-- Motto of University card  -->
                        <div class="about-card">
                            <h4 class="gradText" >TRANSPORTATION FACILITY</h4>
                            <hr>
                            <p _ngcontent-aaf-c81="" align="justify"> For the security and added comfort, Gyanmnjari Institute of Technology provides the Bus facility for the transportation of college students. The The college has its own fleet of buses connecting the campus with different points of Bhavnagar city for the benefit of the students and staff at nominal fares. The route with pick up and dropping point is given when student avail transporation. For the convenience of students comming from diffrent location the college provide bus facilities through third party covering various route. Examtime Bus facility will be as per the student exam suitable schedule. </p>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div class="about-card">
                                    <h4 class="gradText">11 Buses</h4>
                                    <p>
                                        Equipped with <b>GPS Tracking System</b> Providing Transportation Facility from <b>Bhavnagar BMC area</b>.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="about-card">
                                    <h4 class="gradText">TRANSPORTATION OFFICERS</h4>
                                    <hr>
                                    <br>
                                    <!--<b>Mr. Kishanbhai Gohel</b>-->
                                    <p>
                                        <a href="+91 9426662184"><i class="fa fa-phone footer-icon"></i>+91 9426662184</a>
                                    </p>
                                </div>
                            </div>
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
                                        <li>Admission</li>
                                        <li><a href="<?php echo $base_url_admission; ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                                                Apply Online</a></li>
                                        <li><a href="why_gmiu.php" class=""><i class="fa-solid fa-arrow-right"></i> Why GMIU</a></li>
                                        <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php" class=""><i class="fa-solid fa-arrow-right"></i> Courses Offered</a></li>
                                        <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php"><i class="fa-solid fa-arrow-right"></i> e-Brochure & Scope Documents</a>
                                        </li>
                                        <li><a href="importantlink.php" class=""><i class="fa-solid fa-arrow-right"></i> Important Links</a></li>
                                        <li><a href="education_loan.php" class=""><i class="fa-solid fa-arrow-right"></i> Education Loan Facilites</a>
                                        </li>
                                        <li><a href="scholarships.php" class=""><i class="fa-solid fa-arrow-right"></i> Scholarships</a></li>
                                        <li><a href="transportation.php" class="active"><i class="fa-solid fa-arrow-right"></i> Transportation Facilities</a></li>
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