<?php
include '../../common/importwebsitefile.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php $pageTitle = "Specific objectives of the Research Grant Cell | GMIU";?>
    <?php $meta_description = "Explore GMRDC at GMIU — fostering interdisciplinary research, publications, and academic excellence across all faculties."; ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php 
    include "../include/importhead.php"; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        .swiper {
            width: 100%;
            height: 100%;
            margin: 20px;

        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            /* background: #fff; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        .swiper {
            width: 100%;
            height: auto;
            aspect-ratio: 16/10;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 80%;
            width: 100%;
        }

        .mySwiper {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
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

        #dwn-btn {
            padding: 5px 10px;
            background-color: #ba2a21;
            color: white;
            border: 1px transparent;
            border-radius: 4px;
        }

        #dwn-btn:hover {
            transform: translateY(-5px);
            transition: all .3s ease-in-out;
        }

        @media (max-width: 768px) {
            .about-card img {
                height: auto !important;
                /* Remove fixed height */
                width: 100%;
                /* Ensure full width */
            }

        }
    </style>
</head>

<body class="courses">
    <?php include "../include/importheader.php"; ?>

    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>About GMRDC</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active">About GMRDC</span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <section class="about-cards">
                            <div class="about-card">
                                <?php
                                $status = 0;
                                $type = 1;
                                $cmd = $con->prepare("SELECT id, title, img_name, description FROM tbl_research WHERE is_active = 1 AND is_delete = 0 AND type_id= ?");
                                $cmd->bind_param("i", $type);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row["id"];
                                        $title = $row["title"];
                                        $img_name = $row["img_name"];

                                        $description = $row["description"];
                                        ?>

                                        <div class="col-sm-12 about-card">
                                            <hr style="margin: 0;">
                                            <div>
                                                <h4 class="gradText"><?php echo $title; ?></h4>
                                            </div>
                                            <hr>
                                            <?php
                                            if ($img_name) {
                                                ?>
                                                <div class="col-sm-12 about-card"
                                                    style="display: flex; align-items: center; justify-content: center;">
                                                    <img style="border-radius: 8px; width: 100%; height:250px; margin-bottom: 23px; object-fit: cover;"
                                                        src="<?php echo "../../website_admin/uploads/international_cell/" . $img_name; ?>"
                                                        alt="<?php echo $title; ?>">
                                                </div>
                                            <?php } ?>
                                            <div>
                                                <p class="mu-blog-description"><?php echo $description; ?></p>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </section>
                    </div>
                </div>
                <?php include "../research/rightbar.php" ?>
            </div>
        </div>
    </div>

    <?php include "../include/importjs.php"; ?>
    <?php include "../include/importfooter.php"; ?>
</body>

</html>