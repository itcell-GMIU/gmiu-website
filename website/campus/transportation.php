<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
      <?php $pageTitle = "Transportation Services at Gyanmanjari Innovative University | GMIU"; 
          $meta_description = "Discover GMIU's transportation facilities—safe, convenient travel options for students and staff, with easy access to campus and nearby areas.";
   ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <style>
    img {
    max-width: 100%;
    height: auto;
   /* margin-bottom: 30px; */
   /* Corrected the syntax here  */
}
@media screen and (max-width: 768px) {
    .about-card {
        width: 100%; /* Ensure about-cards take full width on smaller screens */
        margin-bottom: 20px; /* Add some spacing between the cards */
    }
    
    .col-sm-6 {
        width: 100%;
        float: none;
    }

    .container {
        padding-left: 15px;
        padding-right: 15px;
    }
}
.sidebar {
    overflow: auto;
}

/* Hide scrollbar for Chrome, Safari, and Opera */
.sidebar::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge, and Firefox */
.sidebar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
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
                    <h1>Transportation Facility In GMIU</h1>
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

                        <img src="<?php echo $website_assets_url ?>images/transport.webp" alt="TRANSPORTATION FACILITY at Gyanmnjari Innovative University" style="height: 400px; width: auto; margin: bottom 30px; ;"></a>
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
                                    <b>Mr. Kishanbhai Gohel</b>
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
               <div class="col-sm-4 sidebar-left">
                <?php include "campussidebar.php"; ?>
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