<?php include "../../common/importwebsitefile.php"; ?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">
    <head>
        <?php include "../include/importhead.php"; ?>
        <?php include "../include/importcss.php"; ?>
        <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css" />
        
        <!-- Add Swiper CSS -->
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <style>
        .duration-intake p {
            color: #333333;
            margin-top: 4px;
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }
    </style>
        <style>
            .logo {
                height: 80px;
                width: auto;
                margin-right: 20px;
            }
            .flexContainer {
                display: flex;
                flex-direction: row;
            }
            .cont .curriculum-text-box .main-card .h3 {
                width: 302px;
                height: 26px;
            }
            .main-card {
                width: 800px;
                height: 400px;
                margin-bottom: 20px;
                padding: 20px 20px 20px 20px;
                background-color: #ba2a211a;
                border-radius: 10px;
            }
            .main-card .flex-img {
                width: 680px;
                height: 300px;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            
            .main-card .first-div img {
                width: 600px;
                height: 300px;
                border-radius: 5px;
            }
            .main-card .ul {
                width: 680px;
                height: auto;
            }
            .main-card .text li {
                width: 650px;
                height: 20;
                margin: 10px;
            }
            .main-card .ul .ul2 {
                width: 670px;
                height: auto;
                padding-left: 40px;
            }
            
            table {
                border-collapse: collapse; /* Collapse border spacing */
                width: 100%; /* Make table width 100% */
                border-radius: 10px; /* Apply border radius of 10% */
                padding: 10px;
                margin-left: 10px;
            } /* Style table headers */
            th {
                background-color: #ba2a21; /* Apply background color to header cells */
                color: white; /* Set text color for header cells */
            } /* Style table rows */
            tr:nth-child(even) {
                background-color: #ba2a2126; /* Apply alternate background color to even rows */
            } /* Style table cells */
            td,
            th {
                border: none; /* Remove borders from table cells */
                padding: 8px; /* Add padding to table cells */
                text-align: left; /* Align text to left in table cells */
                height: 50px;
                width: auto;
                font-size: 15px;
                padding: 15px;
            }
            .row {
                margin-right: 10px;
                margin-left: -15px;
            }
            .swiper-wrapper img {
            width: 100%; /* Ensure images fill the slider container */
            height: 400px; /* Maintain aspect ratio */
            object-fit: cover; /* Maintain aspect ratio and cover the entire slide */
        }
          /* Slideshow container */
          .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }
        .mySlides {
            display: none;
        
        }
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
        .mySlides img{
            height: 400px;
            border-radius: 10px;
            
        }
        
/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
.modal {
  display: none; /* Hide the modal by default */
  position: fixed; /* Stay in place */
  z-index: 999999; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scrolling if needed */
  background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
}

.modal-content {
  margin: 0 auto;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%; /* Adjust as needed */
  max-width: 800px; /* Maximum width of the modal */
  height: 80%; /* Adjust as needed */
}

.modal-content img {
  max-width: 100%;
  max-height: 100%;
}
/* CSS styles to reduce opacity of navbar when modal is open */
.modal-open #navbar {
    overflow: auto; /* Enable scrolling if needed */
}

/* Close button style */
.close {
  position: absolute;
  top: 15px;
  right: 15px;
  color: #fff;
  font-size: 30px;
  font-weight: bold;
  cursor: pointer;
}

/* Center the image vertically */
.modal-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
#navbar.modal-open {
  position: static;
  height: auto;
  overflow: visible;
}

       
        
        </style>
      
    </head>
    <body class="courses">
        <!-- Preloader <div id="preloader"> <div id="status">&nbsp;</div> </div> -->
        <?php include "../include/importheader.php"; ?>
        <!-- box below image -->
        <section class="hero">
            <div class="img"></div>
            <div class="container">
                <div class="cont">
                    <div class="top"><h1>About CED</h1></div>
                    <p style="margin-top: 5px;">
                        <span><a href="<?php echo $base_url_website; ?>" style="color: #727272;">Home</a> <i class="fa fa-angle-right"></i></span> <span class="b-active"><a href="">About CED</a></span>
                    </p>
                </div>
            </div>
        </section>
        <div class="single-courses-area">
            <div class="container">
                <div class="row two-colum-section">
                    <!-- left bar start -->
                    <div class="col-sm-8 sidebar-left">
                        <div class="single-curses-contert">
                            <section><img src="<?php echo $website_assets_url; ?>images/about_ced/ced.jpg" class="gmiu-img" alt="University Photo" /></section>
                            <section class="about-cards">
                                <!-- Motto of University card -->
                                <h4 class="gradText" style="margin-bottom: 10px;">CENTER FOR ENTREPRENEURSHIP DEVELOPMENT</h4>
                                <hr />
                                <div>
                                    <p class="paragraph-text">
                                        The Center for Entrepreneurship Development (CED) is a premier organization of Government of Gujarat engaged in entrepreneurship development training and skill development since 1979. Concept behind
                                        CED is to develop entrepreneurs in the urban as well as rural areas of the state, who established their own manufacturing or service enterprise which in turn aids in economic growth of the state and
                                        also creates employment opportunities for others.
                                    </p>
                                </div>
                                <div class="slideshow-container">
                                   
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/1.jpg" alt="Image 1" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/2.jpg" alt="Image 2" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/3.jpg" alt="Image 3" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/4.jpg" alt="Image 4" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/5.jpg" alt="Image 5" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/6.jpg" alt="Image 6" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/7.jpg" alt="Image 7" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/8.jpg" alt="Image 8" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/9.jpg" alt="Image 9" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/10.jpg" alt="Image 10" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/11.jpg" alt="Image 11" /></div>
                                        <div class="mySlides fade"><img src="/gmiu/website_assets/images/about_ced/12.jpg" alt="Image 12" /></div>
                                        <br>
                                       <div style="text-align:center">
                                           <span class="dot"></span> <span class="dot"></span>
                                           <span class="dot"></span> <span class="dot"></span>
                                           <span class="dot"></span> <span class="dot"></span>
                                           <span class="dot"></span> <span class="dot"></span>
                                           <span class="dot"></span> <span class="dot"></span>
                                           <span class="dot"></span> <span class="dot"></span>
                                        </div>
                                </div>
                                <div id="myModal" class="modal">
                                   <span class="close">&times;</span>
                                   <img class="modal-content" id="img01">
                                </div>
                                <div>
                                    <br />
                                    <h3 class="gradText">16 DAYS E.D.P. MODULE PROGRAM</h3>
                                    <br />
                                </div>
                                <div>
                                    <section class="events-list-03">
                                        <div class="row" class="card">
                                            <table>
                                                <thead class="red-background">
                                                    <tr>
                                                        <th style="border-radius: 25px 0px 0px 0px; width: 30%;">POST</th>
                                                        <th style="border-radius: 0px 25px 0px 0px; width: 60%;">DESCRIPTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>09.09.2019, Day - 1</td>
                                                        <td>1. Registration and Inauguration</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Information about CED.</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>3. Information about entrepreneur</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>4. Microlab and discussion</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10.09.2019, Day - 2</td>
                                                        <td>(Holiday due to Moharam)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>11.09.2019, Day - 3</td>
                                                        <td>1. Industrial Opportunities</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Industrial Opportunities (Functional)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>12.09.2019, Day - 4</td>
                                                        <td>1. Other financial aid program</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Experience of successful entrepreneur</td>
                                                    </tr>
                                                    <tr>
                                                        <td>13.09.2019, Day - 5</td>
                                                        <td>1. Various scheme of DIC</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Market research and survey</td>
                                                    </tr>
                                                    <tr>
                                                        <td>14.09.2019, Day - 6</td>
                                                        <td>(Holiday due to 2nd Saturday)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>15.09.2019, Day - 7</td>
                                                        <td>(Holiday due to Sunday)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>16.09.2019, Day - 8</td>
                                                        <td>1. Whom to contact and why</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Marketing management</td>
                                                    </tr>
                                                    <tr>
                                                        <td>17.09.2019, Day - 9</td>
                                                        <td>1. Project report</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Arrangement of account</td>
                                                    </tr>
                                                    <tr>
                                                        <td>18.09.2019, Day - 10</td>
                                                        <td>1. General management</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Personnel management</td>
                                                    </tr>
                                                    <tr>
                                                        <td>19.09.2019, Day - 11</td>
                                                        <td>1. Financial planning</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Current and fixed assets</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20.09.2019, Day - 12</td>
                                                        <td>1. Computer in business</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>2. Loan application</td>
                                                    </tr>
                                                    <tr>
                                                        <td>21.09.2019, Day - 13</td>
                                                        <td>1. Achievement motivational training (A.M.T.)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>22.09.2019, Day - 14</td>
                                                        <td>(Holiday due Sunday)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>23.09.2019, Day - 15</td>
                                                        <td>1. Factory Visit</td>
                                                    </tr>
                                                    <tr>
                                                        <td>24.09.2019, Day - 16</td>
                                                        <td>1. Ethics and value of Gandhian philosophy in entrepreneurship.</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-radius: 0px 0px 0px 25px; width: 30%;"></td>
                                                        <td style="border-radius: 0px 0px 25px 0px; width: 30%;">2. Feedback</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr />
                                        </div>
                                    </section>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- left bar end -->
                    <!-- right bar start -->
                    <div class="col-sm-4 sidebar-right">
                        <div class="sidebar-content">
                            <div class="sideBar">
                                <div class="sticky">
                                    <div>
                                        <ul>
                                            <li>STARTUP</li>
                                            <li>
                                                <a href="about_startup.php" class=""><i class="fa-solid fa-arrow-right"></i> About Startup</a>
                                            </li>
                                            <li>
                                                <a href="our_startup.php" class=""><i class="fa-solid fa-arrow-right"></i>Our Startup</a>
                                            </li>
                                            <li>
                                                <a href="ssip.php" class=""><i class="fa-solid fa-arrow-right"></i>About SSIP & IPR </a>
                                            </li>
                                            <li>
                                                <a href="about_ced.php" class="active"><i class="fa-solid fa-arrow-right"></i> About CED</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- right bar end -->
                </div>
            </div>
        </div>
        <!-- Footer Area section -->
        <?php include "../include/importfooter.php"; ?>
        <!-- ./ End Footer Area -->
        <!-- ============================ JavaScript Files ============================= -->
        <!-- jQuery -->
        <?php include "../include/importjs.php"; ?>
      

      
    
     <!-- Initialize Swiper -->
     
     <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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
                slideIndex = 1;
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" aactive", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " aactive";
            setTimeout(showSlides, 2000); // Change image every 2 seconds
        }
    </script>
     <script>
 // Get the modal
 var modal = document.getElementById('myModal');

// Get all images with class "mySlides"
var images = document.querySelectorAll('.mySlides');

// Get the modal image element
var modalImg = document.getElementById("img01");

// Loop through each image and attach a click event listener
images.forEach(function(image) {
    image.addEventListener('click', function() {
        // Set the source of the modal image to the clicked image source
        modalImg.src = this.querySelector('img').src;
        // Display the modal
        modal.style.display = "block";
    });
});

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// Close the modal when the user clicks outside of the image
modal.addEventListener('click', function(event) {
    if (event.target == modal && modal.style.display == "block") {
        modal.style.display = "none";
    }
});
// Add event listener to the modal
modal.addEventListener('shown.bs.modal', function() {
  // Add class to the navbar
  var navbar = document.getElementById('navbar');
  navbar.classList.add('modal-open');
});

// Add event listener to the modal close button
document.querySelector('.modal .close').addEventListener('click', function() {
  // Remove class from the navbar
  var navbar = document.getElementById('navbar');
  navbar.classList.remove('modal-open');
});
</script>

  </body>
</html>
