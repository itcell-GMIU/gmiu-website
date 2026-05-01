<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "Wi-Fi Campus | Gyanmanjari Innovative University | GMIU"; 
         $meta_description = "Discover GMIU's Wi-Fi campus—offering seamless internet access throughout the campus to keep students and staff connected anytime, anywhere.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Verdana, sans-serif;
        }

        .mySlides {
            display: none;
        
        }

        img {
            vertical-align: middle;
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .aactive {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
            .text {
                font-size: 11px
            }
        }

        .about-card {
            margin: 60px 0;
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        /* Six columns side by side */
        .column {
            float: left;
            width: 16.66%;
            border-radius: 10px;
        }
        img{
            height: 400px;
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
                    <h1>Wi-Fi Campus</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span>Facility <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href=" <?php echo $base_url_website ?>">Wi-Fi Campus</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

<div class="container text-center">
        <h1 class="text-danger">Wifi Campus</h1>
        </div>
    <div class="flexContainer container">
        <div class="cont">

            <div class="slideshow-container">

                <div class="mySlides fade">
                    <!-- <div class="numbertext">1 / 3</div> -->
                    <img src="../../website_assets/images/wificampus/1.webp" style="width:100%"  alt="Students accessing free Wi-Fi on GMIU Bhavnagar campus">
                    <!-- <div class="text">Caption Text</div> -->
                </div>

                <div class="mySlides fade">
                    <!-- <div class="numbertext">2 / 3</div> -->
                    <img src="../../website_assets/images/wificampus/2.webp" style="width:100%" alt="GMIU provides high-speed internet connectivity across the entire campus">
                    <!-- <div class="text">Caption Two</div> -->
                </div>

                <div class="mySlides fade">
                    <!-- <div class="numbertext">3 / 3</div> -->
                    <img src="../../website_assets/images/wificampus/3.webp" style="width:100%" alt="Digital learning environment supported by campus-wide Wi-Fi at Gyanmanjari University">
                    <!-- <div class="text">Caption Three</div> -->
                </div>

            </div>
            <br>
            <div style="text-align:center">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>

            <!-- Next and previous buttons -->
            <!-- <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a> -->

            <!-- Image text -->
            <!-- <div class="caption-container">
                <p id="caption"></p>
            </div> -->

            <!-- Thumbnail images -->
            <!-- <div class="row m-3">
                <div class="column dot">
                    <img class="demo cursor" src="../../website_assets/images/wificampus/1.webp" style="width:100%" onclick="currentSlide(1)">
                </div>
                <div class="column">
                    <img class="demo cursor" src="../../website_assets/images/wificampus/2.webp" style="width:100%" onclick="currentSlide(2)">
                </div>
                <div class="column">
                    <img class="demo cursor" src="../../website_assets/images/wificampus/3.webp" style="width:100%" onclick="currentSlide(3)">
                </div>
            </div> -->

            <script>
                let slideIndex = 0;
                showSlides();

                function showSlides() {
                    let i;
                    let slides = document.getElementsByClassName("mySlides");
                    let dots = document.getElementsByClassName("dot");
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    slideIndex++;
                    if (slideIndex > slides.length) {
                        slideIndex = 1
                    }
                    for (i = 0; i < dots.length; i++) {
                        dots[i].className = dots[i].className.replace("aactive", "");
                    }
                    slides[slideIndex - 1].style.display = "block";
                    dots[slideIndex - 1].className += " aactive";
                    setTimeout(showSlides, 2000); // Change image every 2 seconds
                }
            </script>
            <section class="about-cards">

                <!-- Motto of University card  -->
                <div class="about-card">
                    <div>
                        <h1 class="gradText">WI-FI CAMPUS</h1>
                    </div>
                    <p>
                        The campus is provided with Wi-Fi environment through 4 Mbps network standards. In order to avail local server with e-library and other important software laboratories, students can access all the above lab contents from any place in the campus.

                        The college has spacious air conditioned class rooms, drawing halls, workshops and laboratories that are well ventilated, airy and provided with furniture best suited for academic work. OHP and LCD projector facility is also available.

                        In this advanced technical era, internet is basic need and powerful medium for students to connect them to the world. Understanding the need of internet, campus is provided with high speed 4Mbps WiFi environment available 24x7. Student can also access local server with e-library, FTP etc...
                    </p>
            </section>
        </div>


        <!-- left bar end -->

        <!-- right ber start -->
        <!--<div style="width: 350px;" class="sideBar">-->
        <!--    <div class="sticky">-->
        <!--        <div>-->
        <!--            <ul>-->
        <!--                <li>Admission</li>-->

        <!--                <li><a href="https://gmiu.edu.in/campus/virtualtour" class=""><i class="fa-solid fa-arrow-right"></i>360 Virtual Tour </a></li>-->
        <!--                <li>-->
        <!--                    <div class="accordion">-->
        <!--                        <a class="accordion-toggle" data-toggle="collapse" href="#news-activities" role="button" aria-expanded="false" aria-controls="news-activities" style="text-decoration-line: none;">-->
        <!--                            <i class="fa-solid fa-arrow-right"></i> NSS-->
        <!--                        </a>-->
        <!--                        <div class="collapse" id="news-activities" style="width: 90%; margin-left:auto;">-->
        <!--                            <a href="about_nss.php"><i class="fa-solid fa-arrow-right"></i> About NSS</a>-->
        <!--                            <a href="nss_unit.php"><i class="fa-solid fa-arrow-right"></i> NSS Units and Program Officers </a>-->
        <!--                            <a href="nss_advisory.php"><i class="fa-solid fa-arrow-right"></i> Advisory committe</a>-->
        <!--                            <a href="nss.php"><i class="fa-solid fa-arrow-right"></i> Activities</a>-->
        <!--                            <a href="nss-gallary.php"><i class="fa-solid fa-arrow-right"></i> NSS Gallary</a>-->
        <!--                            <a href="contact_us.php"><i class="fa-solid fa-arrow-right"></i> Contact Us</a>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </li>-->
        <!--                <li><a href="https://gmiu.edu.in/gmiu/website/campus/gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>Infrastructure</a>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <div class="accordion">-->
        <!--                        <a class="accordion-toggle" data-toggle="collapse" href="#Facility" role="button" aria-expanded="false" aria-controls="news-activities" style="text-decoration-line: none;">-->
        <!--                            <i class="fa-solid fa-arrow-right"></i> Facility-->
        <!--                        </a>-->
        <!--                        <div class="collapse" id="Facility" style="width: 90%; margin-left:auto;">-->
        <!--                            <a href="about_nss.php" class="active"><i class="fa-solid fa-arrow-right"></i> Wi-Fi Campus</a>-->
        <!--                            <a href="nss_unit.php"><i class="fa-solid fa-arrow-right"></i>Cafeteria & First Aid Room</a>-->
        <!--                            <a href="nss_advisory.php"><i class="fa-solid fa-arrow-right"></i>Transportation Facilities</a>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>Curricular Activities</a>-->
        <!--                </li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>Extra Curricular Activities</a></li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>National/International Association</a>-->
        <!--                </li>-->
        <!--                <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>Academic System</a>-->
        <!--                </li>-->
        <!--            </ul>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
       <?php include "campussidebar.php"; ?>
        <!--  right bar end -->
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

    <?php include '../include/importjs.php'; ?>

</body>

</html>