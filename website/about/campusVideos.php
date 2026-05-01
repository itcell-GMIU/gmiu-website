<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <style>
        .gmiu-img{
            height : 400px;
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
                    <h1>Campus Videos</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Campus Videos</a></span>
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
                            
                            <iframe width="700" height="480" src="https://www.youtube.com/embed/DPcgsdZ_Ogc" title="GMIU Campus Tour" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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