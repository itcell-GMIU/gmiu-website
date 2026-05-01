<?php
include '../../common/importwebsitefile.php';

?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Leadership at Gyanmanjari Innovative University"; 
        $meta_description = "Learn about GMIU's leadership – meet the visionary leaders guiding the university towards academic excellence, innovation, and a commitment to student success.";
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
                    <h1>Leadership</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Leadership</a></span>
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
                        <section class="leadership-cards">
                            <div class="header-card-main">
                                <div class="header-card">
                                    <h4 class="header-name">Mr. M. M. Nakrani</h4>
                                    <p class="header-name-position">Founding Chairman</p>
                                </div>
                                <img src="<?php echo $website_assets_url; ?>images/website about section img/chairman.jpg"
                                    alt="Mr. M. M. Nakrani" class="header-img" />
                            </div>

                            <div class="header-card-main">
                                <div class="header-card">
                                    <h4 class="header-name">Mr. Avinashbhai B. Patel</h4>
                                    <p class="header-name-position">President</p>
                                </div>
                                <img src="<?php echo $website_assets_url; ?>images/website about section img/md.jpg"
                                    alt="Mr. Avinashbhai B. Patel" class="header-img" />

                            </div>

                            <div class="header-card-main">
                                <div class="header-card">
                                    <h4 class="header-name">Mr. V. J. Purohit</h4>
                                    <p class="header-name-position">Director</p>
                                </div>
                                <img src="<?php echo $website_assets_url; ?>images/website about section img/director.jpg"
                                    alt="Mr. V. J. Purohit" class="header-img" />

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
                                        <li>ABOUT</li>
                                        <li><a href="about_university.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> About University</a></li>

                                        <li><a href="about_gyanmudra_education_foundation.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> About Gyanmudra Education
                                                Foundation</a></li>
                                        <li><a href="about_leadership.php" class="active"><i
                                                    class="fa-solid fa-arrow-right"></i> Leadership</a></li>
                                        <!--  <li><a href="about_chairman_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Chairman Message</a></li> -->
                                        <li><a href="about_chairman_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> President Message</a></li>
                                        <li><a href="about_provost_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Provost Message</a></li>
                                        <li><a href="about_recognition.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Recognition</a></li>
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