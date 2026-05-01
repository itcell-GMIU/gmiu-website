<?php
include '../../common/importwebsitefile.php'; 
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "Hostel Facility at Gyanmanjari Innovative University | GMIU";
      
    $meta_description = "Discover the hostel facilities at GMIU, offering comfortable accommodations with modern amenities for students, ensuring a conducive living environment.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
     <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <style>
    .hostel-page {
        width: 100%;
        height: 500px;
        border-radius: 10px;
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
                    <h1>Hostel facility</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website;?>" style="color:#727272">Home</a><i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Hostel facility</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
            <!-- <div class="row two-colum-section"> -->
            <!-- left bar start  -->
            <!-- <div class="col-sm-8 sidebar-left"> -->
            <div class="single-curses-contert">
                <section>
                    <img src="<?php echo $website_assets_url; ?>images/hostel.webp" alt="" class="hostel-page">
                </section>
                <section style="margin: 30px 5px;">
                    <div class="trausted-content">
                        <div class="row border-box-admission">
                            <div class="col-sm-12 col-md-12">
                                <h3 class="title gradText" style="font-size : 17px;">For Hostel facility regarding query
                                    call
                                </h3>
                                <hr>
                                <h3 class="section-h-medium" style="margin-bottom: 15px;">Contact Us </br> <i
                                        class="fa-solid fa-phone" style="font-size : 15px"></i> <a
                                        href="tel:+91 9099951160" style="color : #333333;"><span class="mobile-number">
                                            +91
                                            9099951160</span></a>
                                        <br>
                                        <i
                                        class="fa-solid fa-phone" style="font-size : 15px"></i> <a
                                        href="tel:+91 7574949494" style="color : #333333;"><span class="mobile-number">
                                            +91
                                            7574949494</span></a></h3>

                            </div>


                        </div>
                    </div>
                </section>
            </div>
            <!-- </div> -->
            <!-- left bar end  -->

            <!-- right bar start  -->
            <!-- <div class="col-sm-4 sidebar-right">
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
                                        <li><a href="about_chairman_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Chairman Message</a></li>
                                        <li><a href="about_provost_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Provost Message</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
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