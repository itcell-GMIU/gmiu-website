<?php
include '../../common/importwebsitefile.php';

?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "About Provost Message - Gyanmanjari Innovative University"; 
    $meta_description = "Read the Provost's message at GMIU – inspiring students with a vision of academic excellence, innovation, and holistic development for a brighter future.";
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
                    <h1>Provost Message</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a><i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Provost Message</a></span>
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
                            <img src="<?php echo $website_assets_url; ?>images/website about section img/provost.jpg"
                                class="gmiu-img" alt="University Photo">
                        </section>
                        <div class="about-card">

                            <p>Knowledge stands on the key of the creativity to venture the ignited minds of
                                engineers.
                                Gyanmanjari Innovative University is attempting offer a strong support to enlighten
                                students by providing qualitative practical as well as technical education. An
                                attempt
                                lies to modernized students and leads to develop as well as inculcate the value of
                                creativity. Thinking is a key to process to provide lifelong knowledge. An endeavor
                                of
                                students has been set to grab as many opportunities as one can. A practice to make
                                skilled students' enhancement plays key role in teaching. Teaching, learning
                                engineering
                                education. Faculties are meant to play multiple roles like facilitator, moderator
                                and as
                                well as guide to achieve to specific student goal oriented directions. The college
                                has
                                initiated through setting up verities of milestones and attempted to be staircase
                                not
                                only to uplift the students morally but also intellectually also. I admire to all
                                seeking curious engineers to venture to built castle through fulfilling their
                                dreams.
                            </p>
                            <div class="right-end">
                                <h3>- Dr. H. M. Nimbark</h3>
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
                                                    class="fa-solid fa-arrow-right"></i>
                                                About University</a></li>

                                        <li><a href="about_gyanmudra_education_foundation.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> About Gyanmudra Education
                                                Foundation</a></li>
                                        <li><a href="about_leadership.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Leadership</a></li>
                                        <!--  <li><a href="about_chairman_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Chairman Message</a></li> -->
                                        <li><a href="about_chairman_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> President Message</a></li>
                                        <li><a href="about_provost_message.php" class="active"><i
                                                    class="fa-solid fa-arrow-right"></i> Provost Message</a></li>
                                        <li><a href="about_recognition.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i>
                                                Recognition</a></li>
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