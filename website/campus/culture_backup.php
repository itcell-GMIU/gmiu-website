<?php
include "../../common/importwebsitefile.php"; ?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include "../include/importhead.php"; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <style>
        .logo {
            height: 80px;
            width: auto;
            margin-right: 20px;
        }
        .flexContainer {
            display: flex;
            /*flex-direction: row;*/
        }
        .center-content {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%; /* Ensure full height */
}

    </style>
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
	<div id="status">&nbsp;</div>
</div> -->
    <?php include "../include/importheader.php"; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Cultural Program</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Cultural Program</a></span>
                </p>
               
            </div>
        </div>
    </section>
    <div class="flexContainer container">
            <div class="cont">
                <!-- left bar start  -->
                <div>                                      
                    <section class="ExtraLinks center-content">
                         <a href="https://kalaamanjari.gmiu.edu.in/" target="_blank">
                            <div class="card backColor">
                                <h4 class="gradText"><br> KALAMANJARI <i class="fa fa-external-link">
                                    </i>
                                </h4>
                             </div>
                         </a>
                     </section>     
                </div>   
                    
            </div>
            <!-- left bar end  -->
                <!-- right bar start  -->
                <?php include "../campus/campussidebar.php"; ?>
                <!-- right bar end  -->            
     </div>
                
    <!-- Footer Area section -->
    <?php include "../include/importfooter.php"; ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include "../include/importjs.php"; ?>

</body>
</html>