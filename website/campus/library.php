<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "Library at Gyanmanjari Innovative University Campus | GMIU"; 
         $meta_description = "Explore GMIU's library—offering books, journals, digital resources, and a quiet, resource-rich space for academic research and student learning.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <style>
        .sticky {
            width: 302px;
            margin-right: 100px;
        }

        .hero .container .cont .top {
            width: 500px;
            margin-left: 120px;
        }

        .flexContainer .cont {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .flexContainer .cont .container {
            justify-content: center;
            margin-left: -150px;
        }

        .flexContainer .cont .container .mySlides img {
            vertical-align: middle;
            width: 798px;
            height: 400px;
            object-fit: cover;            
            border-radius: 10px;
        }

        /* Position the image container (needed to position the left and right arrows) */
        .container {
            position: relative;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Add a pointer when hovering over the thumbnail images */
        .cursor {
            cursor: pointer;
            margin: 10px;
            padding: 0px 10px;
            border-radius: 5px;
            border-spacing: 10px;
        }

        .row {
            display: flex;
            justify-content: space-around;
            margin: auto auto auto -16px;
        }


        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 40%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }


        /* Three columns side by side */
        .column {
            float: left;
            width: 30%;
        }

        .row .column img {
            border: 1px solid red;
            margin: 10px 10px;
            /* margin: 10px; */
            /* padding: 10px 10px; */
            border-radius: 5px;
            border-spacing: 10px;
            box-sizing: border-box;
        }

        /* Add a transparency effect for thumnbail images */
        .demo {
            opacity: 0.6;
            object-fit: cover;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }

        .about-cards {
            border-radius: 10px;
            transition: .4s ease-in-out;
        }

        .about-card {
            margin: 20px 0;
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        .about-cards .about-card ul li p {
            font-family: Montserrat, sans-serif;
            font-size: 13px;
            color: #727272;
            line-height: 22px;
            text-align: justify;
        }

        .about-cards .about-card ul li {
            margin-left: 20px;
            color: #727272;
        }


        hr {
            margin-bottom: 20px;
            border: 0;
            border-top-width: 0px;
            border-top-style: none;
            border-top-color: currentcolor;
            border-top: 1px solid #eee;
        }

        .about-cards:hover {
            box-shadow: 0 0 30px #00000021;
            border-radius: 10px;
        }



        /* Your existing CSS styles here */

        /* Media queries for responsiveness */
        @media screen and (max-width: 768px) {
            .flexContainer .cont {
                flex-direction: column;
            }

            .flexContainer .cont .container {
                margin-left: 0;
            }

            .sideBar {
                width: 100%;
            }
        }

        @media screen and (max-width: 480px) {
            .hero .container .cont .top {
                width: 100%;
                margin-left: 0;
                text-align: center;
            }

            .flexContainer .cont .container .mySlides img {
                width: 100%;
                height: auto;
            }
            .cont {
                min-width: 80%;
            }

            .sticky {
                min-width: 70%;
                margin-right: 30px;
            }
        }

        /* Your existing CSS styles here */

        /* Media queries for responsiveness */
        @media screen and (max-width: 768px) {
            .flexContainer .cont {
                flex-direction: column;
            }

            .flexContainer .cont .container {
                margin-left: 0;
            }

            .sideBar {
                width: 100%;
            }
        }

        @media screen and (max-width: 480px) {
            .hero .container .cont .top {
                width: 100%;
                margin-left: 0;
                text-align: center;
            }

            .flexContainer .cont .container .mySlides img {
                width: 100%;
                height: auto;
            }

            .sticky {
                width: 330px;
                height: auto;
                justify-content: center;
                align-items: center;
            }

            .sideBar {
                width: 350px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }

        /* Add more media queries as needed for different screen sizes */
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
                    <h1>Library</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="modern_class_room.php">Library</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>




    <div class="flexContainer container">
        <div class="cont">




            <div class="container">
               <div class="mySlides">
                    <img src="library-img/1.webp" alt="Spacious library at GMIU with well-organized book collections">
                </div>
                
                <div class="mySlides">
                    <img src="library-img/2.webp" alt="Students studying in the modern reading area of GMIU library">
                </div>
                
                <div class="mySlides">
                    <img src="library-img/3.webp" alt="Computer and digital resource zone inside GMIU library">
                </div>



                <!-- <a class="prev" onclick="plusSlides(-1)">❮</a>
                    <a class="next" onclick="plusSlides(1)">❯</a> -->



                <div class="row">
                    <div class="column">
                        <img class="demo" src="library-img/1.webp" style="width:100%; height: 80px;" onclick="currentSlide(1)" alt="GMIU library main book section">
                    </div>
                    
                    <div class="column">
                        <img class="demo" src="library-img/2.webp" style="width:100%; height: 80px;" onclick="currentSlide(2)" alt="Reading area in GMIU library with students">
                    </div>
                    
                    <div class="column">
                        <img class="demo" src="library-img/3.webp" style="width:100%; height: 80px;" onclick="currentSlide(3)" alt="Digital learning section of GMIU library">
                    </div>


                </div>







                <div class="about-cards">
                    <div class="about-card">
                        <h4 class="gradText">Library</h4>
                        <hr>
                        <ul class="paragraph-text">
                            <li>
                                <p>The library is the heart of an educational institution. Our library fosters the pursuit of academic excellence. The library has a huge collection of books. More than 41000+ books, 65+ Periodicals, Journals and Magazines, more than 400 CDs/DVDs on various subjects such as Engineering, Pharmacy, Science, Computer Science, etc. more than 300+Bound Periodicals (Back volumes of Useful Journals), 4 Newspapers are regularly subscribed library of Gyanmanjari Group of Colleges. Reference section has several Encyclopedias & Books on General Knowledge. In order to enrich the library collection, a number of valuable books on varied topics of study and interests are added every year. The library also has a growing section on digital learning resources in the form of CDs, DVDs, and an INTERNET facility to collect information from the world. The Library has introduced the system of open access where students and staff are allowed to enter the stacks and choose books for themselves. The library has a spacious stock Room, Reading Halls for staff and students. The library hours are extended for the benefit of students from 8:00 a.m. to 6:00 p.m. (Monday to Saturday). The library has initiated the computerization of its services and activities with the implementation of SOUL 2.0 software and follows the Barcode system for issuance of books. It also provides OPAC – “ON LINE PUBLIC ACCESS CATALOUGE” to find the location of books and other materials in the library. The library is an ILL member of DELNET, New Delhi. Optimum and extensive use of these available facilities by staff, students is made feasible by dedicated, well-trained and co- operative library staff. </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>











            <!-- right ber start -->
            <?php include "../campus/campussidebar.php"; ?>

            <!--  right bar end -->

        </div>
    </div>
    </div>


    <!-- below is for the slider  -->
    <div id="caption"></div>



    <?php include '../include/importjs.php'; ?>


    <?php include '../include/importfooter.php' ?>

    <script>
        let slideIndex = 1;

        // Call the showSlides function initially
        showSlides(slideIndex);

        // Set interval to call plusSlides every 3000 milliseconds (3 seconds)
        setInterval(function() {
            plusSlides(1);
        }, 3000);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("demo");
            let captionText = document.getElementById("caption");

            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }

        if (captionText) {
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>

</body>

</html>