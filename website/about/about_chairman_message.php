<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Chairman's Message | Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Read GMIU Chairman’s message inspiring excellence, innovation, and a commitment to shaping future leaders and global citizens.";
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
                    <h1>President Message</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">President Message</a></span>
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
                            <img src="<?php echo $website_assets_url; ?>images/website about section img/md.jpg"
                                class="gmiu-img" alt="University Photo">
                        </section>
                        <div class="about-card">


                            <p>Our vision is based on hard work, open communication, a strong emphasis on team work
                                and
                                a high level of responsibility. This visionary culture allows and emphasizes our
                                wards
                                not only to adopt the present day challenges but also individual responsibilities to
                                the
                                society and our nation at large. Learning should be based on doing things and not
                                merely
                                knowing things. Until and unless learning solutions relate to real life and motivate
                                the
                                learner to acquire and apply the knowledge, the whole process will remain
                                superficial.
                                Our institution has set specific objectives and planned activities for achieving
                                excellence in all spheres of technical education. The service of the institution in
                                creating personally mature, professionally equipped and service-oriented graduates
                                is
                                really worth mentioning. We strongly believe in academic excellence and do not
                                compromise on teaching standards or discipline. These three things are the
                                springboards
                                on which we operate. People who feel good about themselves produce good results and
                                people who produce good results feel good about themselves. We also believe in total
                                learning and sharing. Students of GMIU either Employable or become a Employer. Have
                                a
                                visit to Gyanmanjari Innovative University and feel good to get good education.</p>
                            <div class="right-end">
                                <h3>- Mr. Avinashbhai B. Patel</h3>
                            </div>


                        </div>
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
                                        <li><a href="about_leadership.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Leadership</a></li>
                                        <!--  <li><a href="about_chairman_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Chairman Message</a></li> -->
                                        <li><a href="about_chairman_message.php" class="active"><i
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