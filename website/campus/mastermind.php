<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../common/importwebsitefile.php";


?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Mastermind Program at Gyanmanjari University | GMIU"; 
        $meta_description = "Explore GMIU's Mastermind program, designed to foster creativity, critical thinking, and leadership skills, empowering students for success in their careers.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
   <?php include "../include/importcss.php"; ?>
   <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>
<style>
   .logo {
      height: 80px;
      width: auto;
      margin-right: 20px;
   }

   .buttons-container-flex {
      display: flex;
      /* Set to flexbox */
      flex-wrap: wrap;
      justify-content: space-between;
      /* Distribute space between elements */
      align-items: center;
      /* Center items vertically */
      padding: 10px;
   }


   .flex {
      display: flex;
      align-items: flex-start;
      /* Align items at the start of the flex container */
      justify-content: space-between;
      /* Distribute space between items */
   }

   .events-list-03 .events-single-box img {
      border-radius: 5px;
   }

   .events-list-03 .event-info {
      padding-top: 0;
   }

   .events-list-03 .events-single-box {
      background-color: white;
   }

   .profile {
      width: 35%;
      /* Adjust width as needed */
   }

   .mmcont {
      width: calc(65% - 20px);
      /* Adjust width as needed */
      /* Subtract the margin-left value of .mmcont to ensure it fits properly */
      margin-left: 20px;
   }

   .mmcont {
      margin-left: 20px;
   }

   .profile .img {
      height: 260px;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      background-color: lightpink;
   }

   .profile {
      border: 1px solid #dddddd;
      text-align: center;
      border-radius: 5px;
      overflow: hidden;
      height: -moz-fit-content;
      height: fit-content;
   }

   .sub-img {
      width: 155px;
      height: 80px;
      background-size: cover;
      background-position: center;
      border-radius: 5px;
      margin-right: 10px;
      /* Set the right margin */
   }

   /* Hide scrollbar for webkit browsers */
   .flexContainer .cont section:nth-of-type(1) {
      margin-top: 0;
   }

   .flexContainer .cont section {
      margin: 20px 0;
   }

   .flexContainer:after,
   .flexContainer:before {
      content: unset;
   }

   /* .flexContainer{
      content: unset;

   } */

   .flex {
      align-items: center;
      justify-content: center;
   }

   .tabBtn.tabBtn-active {
      background-color: #D3D3D3 !important;
      box-shadow: 0 5px brown !important;
   }



   .tabBtn {
      border: none;
      text-transform: uppercase;
      padding: 5px 10px;
      margin: 10px;
      border-radius: 5px;
      font-weight: 500;
      /* Adjust padding as needed */
      background-color: #D3D3D3;
      /* Example background color */
      border: none;
      /* Add border radius for rounded corners */
      cursor: pointer;
      /* Change cursor on hover */
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

   img {
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
   @media only screen and (max-width: 700px) {
      .modal-content {
         width: 100%;
      }
   }

   .modal {
      display: none;
      /* Hide the modal by default */
      position: fixed;
      /* Stay in place */
      z-index: 999999;
      /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scrolling if needed */
      background-color: rgba(0, 0, 0, 0.9);
      /* Black w/ opacity */
   }

   .modal-content {
      margin: 0 auto;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      /* Adjust as needed */
      max-width: 800px;
      /* Maximum width of the modal */
      height: 80%;
      /* Adjust as needed */
   }

   .modal-content img {
      max-width: 100%;
      max-height: 100%;
   }

   /* CSS styles to reduce opacity of navbar when modal is open */
   .modal-open #navbar {
      overflow: auto;
      /* Enable scrolling if needed */
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
               <h1>Mastermind</h1>
            </div>
            <p style="margin-top:5px;">
               <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
               <span class="b-active"><a href=""> Mastermind</a></span>
            </p>
         </div>
      </div>
   </section>
   <div class="flexContainer container">
      <div class="cont">
         <?php
         $unique_titles = [];
         $cmd = $con->prepare("SELECT DISTINCT title FROM tbl_campus WHERE is_delete = 0 AND type_id = 4");
         $cmd->execute();
         $result = $cmd->get_result();
         while ($row = $result->fetch_assoc()) {
            $unique_titles[] = $row['title'];
         } ?>
         <section>
            <div class="btnGr">
               <?php
               // Loop through the unique_titles array to generate buttons
               $index = 0;
               foreach ($unique_titles as $unique_title) {
               ?>
                  <button class="tabBtn" data-Title="<?php echo $unique_title; ?>" onclick="showTitle('<?php echo $unique_title; ?>')">
                     <?php echo $unique_title; ?> </button>
               <?php  } ?>
            </div>
            <hr>
         </section>
         <?php
         // Fetch and display data for each unique title
         foreach ($unique_titles as $unique_title) {
         ?>
            <section id="Title_<?php echo str_replace(' ', '_', $unique_title); ?>" class="TitleSection" style="display: none;">
               <?php
               // Fetch data related to the current title
               $cmd = $con->prepare("SELECT id, staff_id, subtitle, description FROM tbl_campus WHERE is_delete = 0 AND type_id = 4 AND title = ?");
               $cmd->bind_param("s", $unique_title);
               $cmd->execute();
               $result = $cmd->get_result();
               while ($row = $result->fetch_assoc()) {
                  // Extract data from the row
                  $sid = $row['id'];
                  $staff_id = !empty($row['staff_id']) ? $row['staff_id'] : "<b>N/A</b>";
                  $subtitle = !empty($row['subtitle']) ? $row['subtitle'] : "<b>N/A</b>";
                  $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
               ?>
                  <div class="card">
                     <h3 class="gradText"><?php echo $subtitle; ?> </h3>
                     <div class="flex">
                        <div class="profile">
                           <!--   fetch staff details -->
                           <?php
                           $status = 0;
                           $cmd = $con->prepare("SELECT staff.id as id,staff.image as staff_image, 
                        staff.total_experience as staff_total_experience, staff.name as staff_name, 
                        staff.position as staff_position,staff.work_since as staff_work_since FROM 
                        tbl_staff as staff WHERE id= $staff_id  AND is_delete= ?");
                           $cmd->bind_param("i", $status);
                           $cmd->execute();
                           $result2 = $cmd->get_result();
                           if ($result2->num_rows != 0) {
                              while ($row = $result2->fetch_assoc()) {
                                 $id = $row['id'];
                                 $staff_name = $row['staff_name'];
                                 $staff_position = $row['staff_position'];
                                 $staff_total_experience = $row['staff_total_experience'];
                                 $staff_image = $row['staff_image'];
                                 // get only year 
                                 $staff_work_since = $row['staff_work_since'];
                                 $staff_year = date('Y', strtotime($staff_work_since));

                           ?>
                                 <img src="<?php echo  $upload_website_admin_url . "profile/" . $staff_image; ?>" alt="" class="img-responsive">
                                 <div class="info">
                                    <h3> <?php echo $staff_name; ?></h3>
                                    <span class="color-gmiu">
                                       <?php echo $staff_position; ?>
                                    </span>
                                    <hr>
                                    <p style="height :auto; display: flex;align-items: center;justify-content: center;">
                                       <?php
                                       $cmd1 = $con->prepare("SELECT staff_quali.qualification as staff_quali_qualification,
                               staff_quali.branch as staff_quali_branch from tbl_staff_qualification as staff_quali
                                where staff_id = ? ");
                                       $cmd1->bind_param("i", $id);
                                       $cmd1->execute();
                                       $result1 = $cmd1->get_result();
                                       if ($result1->num_rows != 0) {
                                          while ($row = $result1->fetch_assoc()) {
                                             $staff_quali_qualification = $row['staff_quali_qualification'];
                                             $staff_quali_branch = $row['staff_quali_branch'];

                                             echo $staff_quali_qualification . '(' . $staff_quali_branch . ')
                                      <br>';
                                          }
                                       } else {
                                          echo "Not Available";
                                       }
                                       ?>
                                    </p>
                                    <hr>
                                    <div> Experience : <span class="color-gmiu"> <?php echo $staff_total_experience; ?></span></div>
                                    <div> Working Since :<span class="color-gmiu"> <?php echo $staff_work_since; ?></span></div>
                                    <hr>
                                    <a href="program_faculty_profile.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>&staff_id=<?php echo $id ?>">View
                                       Profile <i class="fa fa-long-arrow-right"></i></a>
                                 </div>
                           <?php
                              }
                           } else {
                              $staff_id = "";
                              $staff_name = "";
                              $staff_position = "";
                              $staff_work_since = "";
                              $staff_total_exprience = "";
                              $staff_image = "";
                           }
                           ?>
                        </div>
                        <div class="mmcont">
                           <div class="slideshow-container">
                              <?php
                              $type = "mastermind";
                              $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp 
                            WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                              $cmd1->bind_param("is", $sid, $type);
                              $cmd1->execute();
                              $result1 = $cmd1->get_result();
                              if ($result1->num_rows > 0) {
                                 while ($row1 = $result1->fetch_assoc()) {
                                    $file_name1 = $row1['sp_file_name'];
                              ?>
                                    <div class="mySlides fade">
                                       <img src="<?php echo $upload_website_admin_url . 'mastermind/' . $file_name1; ?>" style="width:100%">

                                    </div>

                                 <?php  }
                                 ?>
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
                              <?php
                              }  ?>
                           </div>

                           <ul class="ul">
                              <p><?php echo  $description; ?></p>
                              <!---->
                           </ul>
                           <hr>
                        </div>
                     </div>
                  <?php } ?>
            </section>
         <?php } ?>
      </div>
      <!---->
      <!-- left bar end  -->
      <!-- right bar start  -->
      <?php include "../campus/campussidebar.php"; ?>
      <!-- right bar end  -->
      <div id="myModal" class="modal">
         <span class="close">&times;</span>
         <img class="modal-content" id="img01">
      </div>
   </div>
   <!-- Modal for displaying full-size image -->


   <!-- Footer Area section -->
   <!-- Footer Area section -->
   <?php include "../include/importfooter.php"; ?>
   <!-- ./ End Footer Area -->
   <!-- ============================
         JavaScript Files
         ============================= -->
   <!-- Include jQuery -->
   <!-- Include Slick Slider JS -->
   <!-- Swiper JS -->
   <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
   <!-- jQuery -->
   <?php include "../include/importjs.php"; ?>
   <script>
      // JavaScript to enable simultaneous slideshows
      document.addEventListener('DOMContentLoaded', function() {
         initializeSlideshows();
      });

      function initializeSlideshows() {
         // Query all elements with the class 'slideshow-container'
         let slideshowContainers = document.querySelectorAll('.slideshow-container');

         // Initialize slideshows for each container
         slideshowContainers.forEach(function(container, index) {
            initializeSlideshow(container);
         });
      }

      function initializeSlideshow(container) {
         let slides = container.getElementsByClassName("mySlides");
         let dots = container.getElementsByClassName("dot");
         let slideIndex = 0;
         showSlides();

         function showSlides() {
            let i;
            for (i = 0; i < slides.length; i++) {
               slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
               slideIndex = 1
            }
            for (i = 0; i < dots.length; i++) {
               dots[i].className = dots[i].className.replace(" aactive", "");
            }
            slides[slideIndex - 1].style.display = "block";
            if (dots.length > 0) { // Check if there are dots
               dots[slideIndex - 1].className += " aactive";
            }
            setTimeout(showSlides, 2000); // Change image every 2 seconds
         }
      }
   </script>
   <script>
      // Function to show sections based on selected Title
      function showTitle(Title) {
         // Hide all sections initially
         var sections = document.querySelectorAll('.TitleSection');

         sections.forEach(function(section) {
            section.style.display = 'none';
         });
         // Remove 'tabBtn-active' class from all buttons
         var Buttons = document.querySelectorAll('.tabBtn');
         Buttons.forEach(function(button) {
            button.classList.remove('tabBtn-active');
         });
         // Show the section corresponding to the clicked Title
         var selectedSection = document.getElementById('Title_' + Title.replace(/ /g, "_"));
         if (selectedSection) {
            selectedSection.style.display = 'block';
            Buttons.forEach(function(button) {
               if (button.dataset.title === Title) {
                  button.classList.add('tabBtn-active');
               }
            });
         }
      }
      // Set the first button as active by default
      window.onload = function() {
         var firstButton = document.querySelector('.tabBtn');
         if (firstButton) {
            var defaultTitle = firstButton.dataset.title;
            showTitle(defaultTitle);
         }
      };
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