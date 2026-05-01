<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "Project Exhibition at Gyanmanjari University | GMIU";
      $meta_description = "Explore GMIU’s Project Exhibition, showcasing innovative student projects and research, providing a platform for creativity and academic growth in various fields.";
      ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />


    <style>
        .flexContainer .cont .about-cards .about-card {
            display: flex;
            justify-content: center;
        }

        .flexContainer .cont .about-cards .about-card h4 {
            text-transform: uppercase;
        }

        .card:hover {
            box-shadow: 0 0 30px #00000021;
        }

        .scrolling-images {
            overflow-x: auto;
            /* Enable horizontal scrolling */
            white-space: nowrap;
            /* Prevent line breaks */
            display: flex;
            /* Use flexbox to arrange images in a row */
        }

        .img-container {
            display: flex;
            animation: scroll 20s linear infinite;
            /* Adjust duration and timing function as needed */
        }

        .about-cards .about-card marquee .img {
            /* width: 300px;
            height: 200px;
            margin-right: 20px;
            background-size: cover;
            background-position: center;
            border-radius: 10px; */

            flex: 0 0 auto;
            width: 300px;
            height: 200px;
            margin-right: 20px;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }


        .tabBtn {
            border: none;
            text-transform: uppercase;
            padding: 5px 10px;
            margin: 10px;
            border-radius: 5px;
            font-weight: 500;
        }

        .tabBtn.active {
            border-bottom: 3px solid #ba2a21;
            margin-bottom: 7px;
        }

        .tabBtn:hover {
            background: rgba(186, 42, 33, 0.2);
            margin: 9px;
            border: 1px solid #ba2a21;
        }

        .imgGrid[_ngcontent-jor-c60] {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .img[_ngcontent-jor-c60] {
            display: inline-block;
            width: 100%;
            aspect-ratio: 1;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            border-radius: 5px;
        }

        .about-cards .news-slider img {
            width: 300px;
            height: 200px;
            margin-right: 20px;
            border-radius: 7px;
            /* Adjust spacing between images */
        }

        .hero .container .cont .top {
            margin-left: 40px;
        }


        /* Media query for screens with a maximum width of 768px */
        @media only screen and (max-width: 768px) {
            .hero .container .cont .top h1 {
                font-size: 36px;
                /* Font size for h1 on mobile */
            }

            .hero .container .cont .top {
                margin: auto;
                width: 100%;
                /* Full width on mobile */
                max-height: 129px;
                /* Height for mobile */
            }

            .hero .container .cont .about-card {
                width: 100%;
                /* Full width on mobile */
                height: 62px;
                /* Height for mobile */
            }

            .ExtraLinks .card {
                min-width: 330px;
                margin: auto;
            }
        }

        /* Media query for screens with a maximum width of 480px */
        @media only screen and (max-width: 480px) {
            .hero .container .cont .top h1 {
                font-size: 36px;
                /* Font size for h1 on smaller mobile devices */
            }

            .hero .container .cont .top {
                height: 200px;
                /* Reset height for smaller mobile devices */
            }

            .hero .container .cont .about-card {
                height: 50px;
                /* Height for smaller mobile devices */
            }

            .ExtraLinks .card {
                min-width: 330px;
                margin: auto;
            }

            .ExtraLinks .about-card {
                margin: auto;
                margin-left: -40px;
            }
        }

        .tabBtn.active {
            border-bottom: 3px solid #ba2a21;
            /* Add border-bottom with specified color */
            margin-bottom: 7px;
            /* Add margin-bottom */
        }


        /* Remove unwanted CSS */

        /* Add CSS for image grid */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            /* Adjust minmax values as needed */
            gap: 20px;
        }

        .image-grid .column {
            width: 100%;
        }

        .image-grid .grid-image {
            width: 100%;
            height: auto;
            /* Maintain aspect ratio */
            border-radius: 10px;
        }

        .image-grid {
            column-count: 3;
            /* Display images in three columns */
            column-gap: 10px;
            /* Adjust the gap between images */
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            display: grid;
        }

        .column .grid-image {
            width: 100%;
            /* Set the width of the image */
            height: auto;
            /* Automatically adjust height to maintain aspect ratio */
            display: block;
            margin-bottom: 10px;
            /* Adjust spacing between images */
            margin-right: 10px;
            /* Adjust spacing between images horizontally */
            border-radius: 5px;

        }


        /* Additional style for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 999999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            max-width: auto;
            max-height: 370px;
        }

        .close {
            position: absolute;
            top: 120px;
            /* Adjust the top position */
            right: 200px;
            /* Adjust the right position */
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            z-index: 9999;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        @media screen and (max-width: 768px) {
            .modal-content {
                width: 90%;
            }

            .close {
                top: 200px;
                right: 0px;
                font-size: 20px;
            }
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
                    <h1>Project Exhibition</h1>
                </div>
                <p style="margin-top:5px; margin-left: 40px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/project_exhibition.php">Project Exhibition</a></span>
                </p>
                <hr style="margin-left: 40px;">
            </div>
        </div>
    </section>


    <div class="flexContainer container">
        <div class="cont">
            <?php
            $unique_titles = [];
            $cmd = $con->prepare("SELECT title FROM tbl_campus WHERE is_delete = 0 AND type_id = 5");
            $cmd->execute();
            $result = $cmd->get_result();
            while ($row = $result->fetch_assoc()) {
                $unique_titles[] = $row['title'];
            } ?>
            <section _ngcontent-eax-c60="">
                <div _ngcontent-eax-c60="" class="btnGr">
                    <?php
                    // Loop through the unique_titles array to generate buttons
                    $index = 0;
                    foreach ($unique_titles as $unique_title) {
                    ?>
                        <button _ngcontent-eax-c60="" class="tabBtn <?php if ($unique_title === $default_title) echo 'active'; ?>" data-semester="<?php echo $unique_title; ?>" onclick="showSemester('<?php echo $unique_title; ?>')">
                            <?php echo $unique_title; ?>
                        </button>

                    <?php  } ?>
                </div>
                <hr>
            </section>
            <?php
            // Fetch and display data for each unique title
            foreach ($unique_titles as $unique_title) {
            ?>
                <section _ngcontent-eax-c60="" id="semester_<?php echo str_replace(' ', '_', $unique_title); ?>" class="semesterSection" style="display: none;">
                    <div> <?php
                            // Fetch data related to the current title
                            $cmd = $con->prepare("SELECT id FROM tbl_campus WHERE is_delete = 0 AND type_id = 5 AND title = ?");
                            $cmd->bind_param("s", $unique_title);
                            $cmd->execute();
                            $result = $cmd->get_result();
                            while ($row = $result->fetch_assoc()) {
                                // Extract data from the row
                                $sid = $row['id'];
                                //   $staff_id = !empty($row['staff_id']) ? $row['staff_id'] : "<b>N/A</b>";
                                //   $subtitle = !empty($row['subtitle']) ? $row['subtitle'] : "<b>N/A</b>";
                                //   $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
                            ?>
                            <section class="image-grid" _ngcontent-jor-c60="" style="padding: 0px 10px;">
                                <?php
                                $type = "project_exhibition";
                                $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                $cmd1->bind_param("is", $sid, $type);
                                $cmd1->execute();
                                $result1 = $cmd1->get_result();
                                if ($result1->num_rows > 0) {
                                    while ($row1 = $result1->fetch_assoc()) {
                                        $file_name1 = $row1['sp_file_name'];
                                ?>
                                        <div _ngcontent-jor-c60="" class="column">
                                            <img class="grid-image" style="height: 220px; width: 220px;" src="<?php echo $upload_website_admin_url . 'project_exhibition/' . $file_name1; ?>" onclick="openModal('<?php echo $upload_website_admin_url . 'project_exhibition/' . $file_name1; ?>')">
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </section>
                    </div>
                </section>
        <?php
                            }
                        }
        ?>
        </div>


        <!-- Modal -->
        <div id="myModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" id="modalImg">
        </div>

        <!-- right ber start -->
        <?php include "../campus/campussidebar.php"; ?>
        <!--  right bar end -->
    </div>




    <?php include '../include/importfooter.php' ?>

    <script>
        // Function to show sections based on selected semester
        function showSemester(semester) {
            // Hide all sections initially
            var sections = document.querySelectorAll('.semesterSection');
            sections.forEach(function(section) {
                section.style.display = 'none';
            });

            // Remove 'active' class from all buttons
            var buttons = document.querySelectorAll('.tabBtn');
            buttons.forEach(function(btn) {
                btn.classList.remove('active');
            });

            // Show the section corresponding to the clicked semester
            var selectedSection = document.getElementById('semester_' + semester.replace(/ /g, "_"));
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }

            // Add 'active' class to the clicked button
            var clickedButton = document.querySelector('.tabBtn[data-semester="' + semester + '"]');
            if (clickedButton) {
                clickedButton.classList.add('active');
            }
        }

        // Function to show the default section (data related to the first unique title)
        function showDefaultSection() {
            var defaultTitle = '<?php echo str_replace(' ', '_', $unique_titles[0]); ?>'; // Get the first unique title
            showSemester(defaultTitle); // Call the showSemester function to display the default section
        }

        // Call the showDefaultSection function when the page is fully loaded
        window.onload = function() {
            showDefaultSection();
        };
    </script>

    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault(); // Prevent the default right-click behavior
        });
    </script>

    <script>
        function openModal(imgSrc) {
            let modal = document.getElementById('myModal');
            let modalImg = document.getElementById("modalImg");
            modal.style.display = "block";
            modalImg.src = imgSrc;
        }

        function closeModal() {
            let modal = document.getElementById('myModal');
            modal.style.display = "none";
        }
    </script>



    <?php include '../include/importjs.php'; ?>

</body>

</html>