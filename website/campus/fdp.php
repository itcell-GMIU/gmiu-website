<?php
include "../../common/importwebsitefile.php";
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Faculty Development Program - Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Explore GMIU's FDP program—faculty development initiatives to strengthen teaching, boost research skills, and promote academic excellence.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <style>
        .logo {
            height: 80px;
            width: auto;
            margin-right: 20px;
        }
        
       .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive columns */
            gap: 16px; /* Space between images */
            margin-top: 20px;
        }
        
        .grid-image {
            width: 100%;
            height: 220px;
            object-fit: cover; /* Prevents distortion */
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        
        .grid-image:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
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

        #header {
            z-index: 999;
            /* Ensure the header stays below the modal */
        }

        .modal-content {
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            /*width: 100%;*/
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
                    <h1>Faculty Development Program</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href=""> Faculty Development Program</a></span>
                </p>
            </div>
        </div>
    </section>

    <div class="flexContainer container">
        <div class="cont">
            <!-- left bar start  -->
            <div>
                <?php
                $cmd = "SELECT id,title,description FROM tbl_campus WHERE is_active = 1 AND is_delete = 0 AND type_id = 2";
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $fdp_id = $row["id"];
                        $title = $row["title"];
                        $description = $row["description"];
                ?>
                        <section class="about-cards">
                            <!-- Motto of University card  -->
                            <div class="about-card" style="display: flex; align-items: center;">
                                <div>
                                    <h4 class="gradText" style="margin-bottom: 10px;"><?php echo $title; ?></h4>
                                    <hr>
                                    <div>
                                        <p class="paragraph-text"><?php echo $description; ?></p>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="image-grid">
                            <?php
                            $type = "fdp";
                            $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                            $cmd1->bind_param("is", $fdp_id, $type);
                            $cmd1->execute();
                            $result1 = $cmd1->get_result();
                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {
                                    $file_name1 = $row1['sp_file_name'];
                            ?>
                                    <!--<div class="column">-->
                                        <img class="grid-image" src="<?php echo $upload_website_admin_url . 'fdp/' . $file_name1; ?>" alt="<?php echo htmlspecialchars($title); ?> Photo">
                                    <!--</div>-->
                            <?php
                                }
                            }
                            ?>
                        </section>
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

        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
        </div>
    </div>
    <!-- Footer Area section -->

    <!-- Footer Area section -->
    <?php include "../include/importfooter.php"; ?>
    <!-- ./ End Footer Area -->

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

    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include "../include/importjs.php"; ?>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var images = document.querySelectorAll(".grid-image");
        var modalImg = document.getElementById("img01");

        images.forEach(function(image) {
            image.onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
            }
        });

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>