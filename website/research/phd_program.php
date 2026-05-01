<?php
include '../../common/importwebsitefile.php';
?>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "About Ph.D Programs | Gyanmanjari Innovative University";?>
    <?php $meta_description = "Explore Ph.D. programs at GMIU. Learn about research areas, guides, and the academic environment for doctoral studies."; ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    
    <?php
    include "../include/importhead.php"; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">


    <style>
        hr {
            margin-bottom: 20px;
            border: 0;
            border-top-width: 0px;
            border-top-style: none;
            border-top-color: currentcolor;
            border-top: 1px solid #eee;
        }


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
                width: 370px;
                display: flex;
                padding-left: 20;
                padding-top: 20;
                justify-content: center;
                align-items: center;
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
                    <h1>About Ph.D Programs</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active">About Ph.D Programs</span>
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
                                $type = 3;
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