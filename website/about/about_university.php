<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php 
    $pageTitle = "About Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Learn about GMIU—an innovative educational institution dedicated to academic excellence, holistic development, and shaping future-ready global leaders.";
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
                    <h1>About University</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">About University</a></span>
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
                            <img src="<?php echo $website_assets_url; ?>images/Collage_photo_out.webp" class="gmiu-img"
                                alt="University Photo">
                        </section>

                        <section class="about-cards">

                            <!-- Motto of University card  -->
                            <div class="about-card">
                                <h4 class="gradText">Motto of University</h4>
                                <h4 class="text-center"> दिव्यम्ददामितचक्षु: </h4>
                                <p class="paragraph-text">
                                    (But you cannot see my cosmic form with these physical eyes of yours. Therefore, I
                                    grant you divine vision. Behold my majestic opulence!)
                                </p>
                            </div>

                            <!-- Vision of University card  -->
                            <div class="about-card">
                                <h4 class="gradText">Vision of University</h4>
                                <ul class="paragraph-text">
                                    <li>To produce world class professionals for converting global challenges into
                                        opportunities through “Value Embedded Education”</li>
                                    <li>To provide academic programs, services, facilities and technologies within the
                                        realm of the curricula of the university, that offers diverse opportunities for
                                        learning.</li>
                                    <li>To prepare professionals who are either employable or employer.</li>
                                    <li>To develop critical thinking, effective communication and learning skills in
                                        students and to promote the value of ethical behavior, responsibility and
                                        commitment</li>
                                </ul>
                            </div>

                            <!-- Mission of University card  -->
                            <div class="about-card">
                                <h4 class="gradText">Mission of University</h4>
                                <ul class="paragraph-text">
                                    <li>We at Gyanmanjari Innovative University shall strive continuously to achieve academic excellence and research in the field of Engineering, Technology, Science, Humanities, Commerce, Management, Health care, Design, Marine, Agriculture and Aviation  through dedication to duty, innovation in teaching and faith in human values.</li>
                                    <li>To enable our students to develop into outstanding professionals with high ethical standards to face the challenges of the next millennium
                                        To fulfill the expectations of our society by equipping our students to stride forth as resourceful citizens who are aware of their immense responsibilities to make the world a better place.</li>
                                    <!--<li>To fulfill the expectations of our society by equipping our students to stride-->
                                    <!--    forth as resourceful citizens who are aware of their immense responsibilities to-->
                                    <!--    make the world a better place.</li>-->
                                </ul>
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
                                        <li><a href="about_university.php" class="active"><i
                                                    class="fa-solid fa-arrow-right"></i> About University</a></li>

                                        <li><a href="about_gyanmudra_education_foundation.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> About Gyanmudra Education
                                                Foundation</a></li>
                                        <li><a href="about_leadership.php" class=""><i
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