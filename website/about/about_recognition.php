<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "About Recognition | Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Explore GMIU's recognition and achievements—featuring awards, certifications, and accolades that reflect our dedication to excellence and innovation.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <!-- <style>
        .faculty-card .card-image {
            max-width: 100%;
        }

    .department-tab-data .sub-details {
        border: 1px solid #eb6b06;
        padding: 15px 30px;
    }

        .faculty-card .card-image {
            position: relative;
            padding: 0 10px 10px 0;
            
        }

    .faculty-card .card-image:before {
        content: '';
        border: 1.5px solid #ba2a21;
        border-radius: 25% 0 25% 0;
        position: absolute;
        left: 15px;
        right: 0;
        top: 15px;
        bottom: 0;
        z-index: 1;
    }

    @media only screen and (max-width: 600px) {
        .faculty-card .card-image:before {
            content: '';
            border: 1.5px solid #ba2a21;
            border-radius: 25% 0 25% 0;
            position: absolute;
            left: 70px;
            right: 30px;
            top: 15px;
            bottom: 10px;
            z-index: 1;
        }
    }

    .faculty-card .card-image img {
        border: 1.5px solid #ba2a21;
        border-radius: 25% 0 25% 0;
        z-index: 2;
        position: relative;
    }

    .faculty-card1 .card-image img {
        border: 0.5px solid #ba2a21;
        border-radius: 25% 0 25% 0;
        z-index: 2;
        position: relative;
    }

    .faculty-card .name {
        font-size: 19px;
        color: rgb(29, 38, 73);
        font-weight: 600;
        margin: 10px 0 0;
    }

    .faculty-card .designation {
        font-size: 17px;
        color: #eb6b06;
        margin-bottom: 10px;
    }

    .faculty-card .department {
        font-size: 15px;
        color: #143a81;
        position: relative;
        padding-left: 32px;
        margin-bottom: 10px;
    }

    .faculty-card .department:before {
        content: '';
        width: 24px;
        height: 24px;
        background-size: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .faculty-card .study {
        font-size: 15px;
        color: #143a81;
        position: relative;
        padding-left: 32px;
    }

    .faculty-card .study:before {
        content: '';
        width: 24px;
        height: 24px;
        background-size: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .faculty-card .info .btn {
        margin-top: 20px;
    }

    .thumbnail {
        border: none;
    }

    .thumbnail img {
        padding: 20px !important;
        aspect-ratio: 1/1 !important;
    }

        .thumbnail img {
            padding: 20px !important;
            aspect-ratio: 1/1 !important;
        }

        .mb-20 {
            margin-bottom: 20px;
        }
    </style> -->
    <style>
        .rec-card {
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            max-width: 200px;
            height: fit-content;
            border-radius: 5px;
            border: 1px solid #ba2a21;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .rec-card .rec-img {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 15px;
            border-radius: 5px;
        }

        .rec-card .rec-img img {
            width: 150px;
        }

        .rec-card .rec-name {
            border-top: 1px solid #ba2a21;
            display: flex;
            justify-content: center;
            text-align: center;
            background-color: #ba2a21;
            border-radius: 0 0 5px 5px;
        }

        .rec-card .rec-name h5 {
            color: white;
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
                    <h1>Recognition</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Recognition</a></span>
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
                        <p style="padding: 20px;border: 1px solid #ba2a21; border-radius: 5px; margin-bottom:20px; margin-right: 15px; margin-left: 15px;">Gyanmanjari Innovation University is known to be associated with many prestigious bodies. Having been recognized by many governmental bodies, here are all the prestigious associations and certificates that have been bestowed upon us.</p>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="rec-card">
                                    <div class="rec-img">
                                        <img src="../../website_assets/images/recognition/edu.png" alt="All India Council for Technical Education (AICTE)">
                                    </div>
                                    <div class="rec-name">
                                        <h5>All India Council for Technical Education (AICTE)</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="rec-card">
                                    <div class="rec-img">
                                        <img src="../../website_assets/images/recognition/ugc.jpg" alt="University Grants Commission (UGC)">
                                    </div>
                                    <div class="rec-name">
                                        <h5>University Grants Commission (UGC)</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="rec-card">
                                    <div class="rec-img">
                                        <img src="../../website_assets/images/recognition/gaddet.jpg" alt="The Gujarat Government Gazette">
                                    </div>
                                    <div class="rec-name">
                                        <h5>The Gujarat Government Gazette</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="rec-card">
                                    <div class="rec-img">
                                        <img src="../../website_assets/images/recognition/pci.jpg" alt="Pharmacy Council Of India">
                                    </div>
                                    <div class="rec-name">
                                        <h5>Pharmacy Council Of India</h5>
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-4">
                                <div class="rec-card">
                                    <div class="rec-img">
                                        <img src="../../website_assets/images/recognition/download.png" alt="Bar Council of India">
                                    </div>
                                    <div class="rec-name">
                                        <h5>Bar Council of India <br> (BCI) </h5>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <!-- img card Style : 1 -->

                        <!-- <div class="col-sm-4 mb-20">
                            <div class="faculty-card text-center">
                                <div class="card-image">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="../../website_assets/images/recognition/edu.png" alt="" title=""
                                                style=" width: 250px;background-color: white;">
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <h4 class="name">
                                        All India Council for Technical Education (AICTE)
                                    </h4>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-4 mb-20">
                            <div class="faculty-card text-center">
                                <div class="card-image">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="../../website_assets/images/recognition/ugc.jpg" alt="" title=""
                                                style=" width: 250px;background-color: white;">
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <h4 class="name">
                                        University Grants Commission (UGC)
                                    </h4>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-4 mb-20">
                            <div class="faculty-card text-center">
                                <div class="card-image">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="../../website_assets/images/recognition/gaddet.jpg" alt=""
                                                title="" style=" width: 250px;background-color: white;">
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <h4 class="name">
                                        The Gujarat Government Gazette
                                    </h4>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-4 mb-20">
                            <div class="faculty-card text-center">
                                <div class="card-image">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="../../website_assets/images/recognition/pci.jpg" alt="" title=""
                                                style=" width: 250px;background-color: white;">
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <h4 class="name">
                                        Pharmacy Council Of India
                                    </h4>
                                </div>
                            </div>
                        </div> -->

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
                                        <li><a href="about_chairman_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> President Message</a></li>
                                        <li><a href="about_provost_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Provost Message</a></li>
                                        <li><a href="about_recognition.php" class="active"><i
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