<?php
  include "../../common/importwebsitefile.php"; ?>
<!doctype html>
<html class="no-js" lang="zxx">
  <head>
    <?php $pageTitle = "CWP at Gyanmanjari Innovative University Campus | GMIU"; 
        $meta_description = "Discover GMIU’s CWP program offering career resources, workshops, and training to boost student skills and prepare them for successful careers.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <!-- Add Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
      .logo {
      height: 80px;
      width: auto;
      margin-right: 20px;
      }
      .main-card {
      width: 800px;
      height: 400px;
      margin-bottom: 20px;
      padding: 20px 20px 20px 20px;
      background-color: #BA2A211A;
      border-radius: 10px;
      }
      .main-card .flex-img {
      width: 680px;
      height: 300px;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      }
      body {
      font-family: Verdana, sans-serif;
      }
      .mySlides {
      display: none;
      }
      .mySlides {
      display: none;
      max-width: 100%; /* Set the maximum width */
      max-height: 100%; /* Set the maximum height */
      object-fit: cover; /* Specify how the image should be resized to cover its container */
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
      opacity: 1;
      }
      to {
      opacity: 1;
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
      /* CSS styles for the modal */
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
#header {
  z-index: 999; /* Ensure the header stays below the modal */
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

    
    <!-- Add Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
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
            <h1>Connect With Parents</h1>
          </div>
          <p style="margin-top:5px;">
            <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
              class='fa fa-angle-right'></i></span>
            <span class="b-active"><a href=""> Connect With Parents</a></span>
          </p>
        </div>
      </div>
    </section>
    <div class="flexContainer container">
      <!-- left bar start  -->
      <div class="cont">
        <section>
        <div>
          <?php
            $cmd = "SELECT id,title,description FROM tbl_campus WHERE is_active = 1 AND is_delete = 0 AND type_id = 3";
            $stmt = $con->prepare($cmd);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cwp_id = $row["id"];
                    $title = $row["title"];
                    $description = $row["description"];
            ?>
          <section class="about-cards">
            <!-- Motto of University card  -->
            <h4 class="gradText" style="margin-bottom: 10px;"><?php echo $title; ?></h4>
            <hr>
            <div>
              <p class="paragraph-text"><?php echo $description; ?></p>
            </div>
          </section>
          <section>
            <div class="slideshow-container">
              <?php
                $type = "cwp";
                $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                $cmd1->bind_param("is", $cwp_id, $type);
                $cmd1->execute();
                $result1 = $cmd1->get_result();
                if ($result1->num_rows > 0) {
                    while ($row1 = $result1->fetch_assoc()) {
                        $file_name1 = $row1['sp_file_name'];
                ?>
              <div class="mySlides fade">
                <img  rel="canonical" loading="lazy" src="<?php echo $upload_website_admin_url . 'cwp/' . $file_name1; ?>"  alt="CWP event at GMIU - <?php echo htmlspecialchars($title); ?>" 
                      style="width:100%">
              </div>
              <?php
                }
                }
                ?>
            </div>
            <br>
            <div style="text-align:center">
              <?php
                // Count the number of images and generate corresponding dots
                $numImages = $result1->num_rows;
                for ($i = 0; $i < $numImages; $i++) {
                    echo '<span class="dot"></span>';
                }
                ?>      
            </div>
            <!-- <div class="small-slider">
              <div class="image-wrapper"> -->
            <?php
              // $type = "cwp";
              //         $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
              //         $cmd1->bind_param("is", $cwp_id, $type);
              //         $cmd1->execute();
              //         $result2 = $cmd1->get_result();
              //         if ($result2->num_rows > 0) {
              //             while ($row1 = $result2->fetch_assoc()) {
              //                 $file_name1 = $row1['sp_file_name'];
                      ?>  <!-- <img src="<?php //echo $upload_website_admin_url . 'cwp/' . $file_name1; ?>"> -->
            <?php
              //     }
              // }
              ?>
            <!-- </div>
              </div> -->
          </section>
          <script>
            let slideIndex = 0;
            showSlides();
            
            function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            
            // Hide all slides
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            
            // Increment slide index
            slideIndex++;
            
            // Reset slide index if it exceeds the number of slides
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            
            // Remove active class from all dots
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" aactive", "");
            }
            
            // Display the current slide with a smooth transition
            slides[slideIndex - 1].style.display = "block";
            
            // Add active class to the current dot
            dots[slideIndex - 1].className += " aactive";
            
            // Call showSlides function recursively after 2 seconds
            setTimeout(showSlides, 2000);
            }
            
          </script>
          <?php
            }
            }
            ?>
        </div>
      </div>
      <!-- left bar end  -->
      <!-- right bar start  -->
      <?php include "../campus/campussidebar.php"; ?>
      <!-- right bar end  -->
    </div>

    
    <!-- Modal for displaying full-size image -->
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
    </div>


    <!-- Footer Area section -->
    <?php include "../include/importfooter.php"; ?>
     <!-- ./ End Footer Area -->
    <!-- ============================
      JavaScript Files
      ============================= -->
    <!-- jQuery -->
    <?php include "../include/importjs.php"; ?>

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