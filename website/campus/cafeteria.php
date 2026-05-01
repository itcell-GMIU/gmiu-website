<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "Cafeteria at Gyanmanjari Innovative University Campus | GMIU"; 
         $meta_description = "Discover GMIU’s cafeteria serving tasty, nutritious meals and snacks in a comfortable space for students and staff to unwind and connect.";
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
            /*transition: background-color 0.6s ease;*/
        }

        .aactive {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            
            animation-name: fade;
            animation-duration: 3s;
        }

        @keyframes fade {
            from {
                opacity: .9
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
            /*transition: all .3s ease-in-out;*/
        }

        /* Six columns side by side */
        .column {
            float: left;
            width: 16.66%;
            border-radius: 10px;
        }

        img {
            height: 400px;
            border-radius: 10px;

        }
        ul{
            padding-left: 30px;
        }
        p{
            padding-left: 20px; 
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
                    <h1>Cafeteria & First Aid</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span>Facility <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href=" <?php echo $base_url_website ?>">Cafeteria & First Aid</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="flexContainer container">
        <div class="cont">

            <div class="slideshow-container">

                <div class="mySlides fade">
                    <!-- <div class="numbertext">1 / 3</div> -->
                    <img src="../../website_assets/images/cafeteria/5.jpeg " style="width:100%" alt="Modern cafeteria space at GMIU Bhavnagar campus">
                    <!-- <div class="text">Caption Text</div> -->
                </div>

                <div class="mySlides fade">
                    <!-- <div class="numbertext">2 / 3</div> -->
                    <img src="../../website_assets/images/cafeteria/1.jpeg" style="width:100%" alt="Students enjoying meals at Gyanmanjari Innovative University cafeteria">
                    <!-- <div class="text">Caption Two</div> --> 
                </div>

                <div class="mySlides fade">
                    <!-- <div class="numbertext">3 / 3</div> -->
                    <img src="../../website_assets/images/cafeteria/2.jpeg" style="width:100%" alt="Clean and spacious dining area at GMIU campus in Gujarat">
                    <!-- <div class="text">Caption Three</div> -->
                </div>
                <div class="mySlides fade">
                    <!-- <div class="numbertext">3 / 3</div> -->
                    <img src="../../website_assets/images/cafeteria/3.jpeg" style="width:100%" alt="Well-maintained food and refreshment area at GMIU Bhavnagar">
                    <!-- <div class="text">Caption Three</div> -->
                </div>
                <div class="mySlides fade">
                    <!-- <div class="numbertext">3 / 3</div> -->
                    <img src="../../website_assets/images/cafeteria/4.jpeg" style="width:100%" alt="Comfortable seating arrangements in the GMIU cafeteria for students">
                    <!-- <div class="text">Caption Three</div> -->
                </div>

            </div>
            <br>
            <div style="text-align:center">
                <span class="dot"></span>
                <span class="dot"></span>
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
                    setTimeout(showSlides, 3000); // Change image every 2 seconds
                }
            </script>
            <section class="about-cards">

                <!-- Motto of University card  -->
                <div class="about-card">
                    <div>
                        <h1 class="gradText">CAFETERIA AND FIRST AID ROOM</h1>
                    </div>
                    <hr>
                    <p>
                        Institute cares for student's health and for that we provides healthy food for all the students as well as staff members in college campus to keep them healthy. A healthy food is much needed for a wealthy mood.

                        We have large capacity area for canteen stuff. So as much as more students can access canteen primices at a time.
                    </p>
                    <div>
                        <h1 class="gradText">FIRST AID:</h1>
                        <p>
                        <ul>
                            <li>"Safety first" is "Safety Always".</li>
                            <li> Due care has been taken for health and small injury of the students.</li>
                        </ul>
                        </p>
                    </div>
            </section>
        </div>


        <!-- left bar end -->

        <!-- right ber start -->
        <?php include "../campus/campussidebar.php"; ?>
       
        <!--  right bar end -->
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

    <?php include '../include/importjs.php'; ?>

</body>

</html>