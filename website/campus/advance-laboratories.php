<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Advanced Laboratories at Gyanmanjari Innovative University | Campus"; 
    $meta_description = "Explore GMIU's Advanced Laboratories—modern facilities that enhance practical learning and research, empowering students with hands-on technical skills.";
   ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <style>
        .about-card {
            /* margin: 60px 0; */
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        .cont .mu-blog-single-item .mu-blog-single-img img {
            width: 370px;
            height: 229px;
            margin: 10px;
            border-radius: 10px;
        }


        .cont {
            width: 800px;
            margin: 0px 30px 0px 10px;
        }

        .flexContainer .cont .row {
            padding: 10px;
        }
        
        .row {
            display: flex;
            flex-direction: row;
        }

        .sec-con {
            margin: 0px 10px 0px 10px;
        }

        .row .sec-con .image img {
            border-radius: 10px;
        }

        .row .sec-con .heading {
            padding: 10px 0px 10px 0px;
        }

        .row .sec-con .heading h3 {
            color: #ba2a21;
            text-transform: uppercase;
            padding: 15px 0px 15px 0px;
        }

        .row .sec-con .para p {
            line-height: 30px;
        }

        .flexContainer .sidebar .sticky {
            width: 150%;
        }

        @media only screen and (max-width: 480px) {


            .flexContainer {
                box-sizing: border-box;
                margin: 0px;
                padding: 0px;
                gap: 0px;
            }

            .flexContainer .cont .row {
                display: flex;
                flex-direction: column;
                width: 100%;
                justify-content: center;
                align-items: center;
            }

            .flexContainer .cont {
                margin: 0px;
                padding: 0px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }


            .row .sec-con .image img {
                justify-content: center;
                align-items: center;
                border-radius: 10px;
                width: 330px;
                height: auto;
            }

            .row .sec-con .heading h3 {
                width: 330px;
                height: auto;
            }

            .row .sec-con .para p {
                width: 330px;
                height: auto;
            }

            .row .sec-con .image,
            .row .sec-con .para {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .flexContainer {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .sec-con {
                justify-content: center;
                align-items: center;
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

            .hero .container .cont {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            .hero .container .cont .top {
                width: 330px;
                height: auto;
            }

            .hero .container .cont .top h1 {
                font-size: 36px;
            }

        }

        img {
            width: 300px;
            height: auto;
        }

        /* .para {
            width: 300px;
        } */

        .cont {
            display: flex;
            flex-direction: column;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .about-card {
            /* width: calc(50% - 20px); */
            /* Adjust card width according to your preference */
            margin-bottom: 20px;
        }

        @media only screen and (max-width: 480px) {
            .about-card {
                width: 100%;
                /* Make cards full width on smaller screens */
            }
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

        .image-grid {
            column-count: 2;
            /* Display images in three columns */
            column-gap: 10px;
            /* Adjust the gap between images */
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
    </style>

</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Advance Laboratories</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/nss.php">Advance Laboratories</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="flexContainer container">
        <div class="cont">
        <!-- <div class="row"> -->
        <div class="image-grid">
            <?php
            // Ensure $con is a valid database connection object
            // Define $sid and $type with appropriate values

            $cmd = $con->prepare("SELECT id, title, description FROM tbl_campus WHERE is_delete = 0 AND type_id = 10");
            $cmd->execute();
            $result = $cmd->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $al_id = $row['id'];
                    $type = "advance_laboratories";
                    $cmd1 = $con->prepare("SELECT sp.id as sp_id, sp.file_name as sp_file_name FROM tbl_site_photos as sp WHERE type_id=? AND type='advance_laboratories' AND is_active=1 AND is_delete=0 LIMIT 1");
                    $cmd1->bind_param("i", $al_id);
                    $cmd1->execute();
                    $result1 = $cmd1->get_result();

                    if ($result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        $file_name1 = $row1['sp_file_name'];
            ?>
                        <div class="about-card">
                            <div class="column">
                                <div class="image">
                                    <img src="<?php echo htmlspecialchars($upload_website_admin_url . 'advance_laboratories/' . $file_name1); ?>" class="grid-image"
                                    alt="<?php echo htmlspecialchars($title); ?> at GMIU"  
                                    onclick="openModal('<?php echo htmlspecialchars($upload_website_admin_url . 'advance_laboratories/' . $file_name1); ?>')">
                                </div>
                                <div class="heading">
                                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                </div>
                                <div class="para">
                                    <?php echo $row['description']; ?>
                                </div>
                            </div>
                        </div>
            <?php
                    } else {
                        echo "<p>No labs found.</p>";
                    }
                }
            } else {
                echo "<p>No labs found.</p>";
            }
            ?>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" id="modalImg">
        </div>
        </div>
        <!-- Right sidebar -->
        <?php include "../campus/campussidebar.php"; ?>
    </div>

    <?php include '../include/importjs.php'; ?>
    <?php include '../include/importfooter.php' ?>

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
</body>


</html>