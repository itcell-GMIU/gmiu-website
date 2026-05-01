<?php
include "../../common/importwebsitefile.php"; ?>

<!--DOCTYPE html -->
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "International Cell: IRC | Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Learn about GMIU's IRC – fostering international relationships, collaborations, and student exchanges to promote global exposure and academic growth at GMIU.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
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
        .red-background {
    background-color: #ba2a21;
    color: white;
}
        a.rgsBtn {
    display: inline-block;
    position: relative;
    color: #fff;
    min-width: 25rem !important;
    padding: 1rem;
    border-radius: 0.5rem;
    margin: 1rem;
    text-align: center;
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
                height: auto !important; /* Remove fixed height */
                width: 100%; /* Ensure full width */
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
                    <h1>INTERNATIONAL RELATIONS CELL</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">INTERNATIONAL RELATIONS CELL</span>
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
                                $cmd = $con->prepare("SELECT id, title, img_name, description FROM tbl_international_cell WHERE is_delete = ? AND type_id= ?");
                                $cmd->bind_param("ii", $status, $type);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row["id"];
                                        $title = $row["title"];
                                        $img_name = $row["img_name"];
                                        $description =
                                            $row["description"];
                                ?>

                                        <!--<div class="row two-colum-section">-->
                                        <div class="col-sm-12 about-card">
                                            <hr style="margin: 0;">
                                            <div>
                                                <h4 class="gradText"><?php echo $title; ?></h4>
                                            </div>

                                            <hr>
                                            
                                            
                                            <div class="col-sm-12 about-card" style="display: flex; align-items: center; justify-content: center;">
                                                <img style="border-radius: 8px; width: 100%; height:350px; margin-bottom: 23px; object-fit: cover;" src="<?php echo "../../website_admin/uploads/international_cell/" . $img_name; ?>" alt="<?php echo $title; ?>">
                                            </div>
                                             <div >
                                                <a href="<?php echo $website_assets_url; ?>pdf/IEP_Handbook.pdf" target="_blank" rel="noopener noreferrer" class="rgsBtn red-background">IEP handbook</a>
                                            </div>
                                            <div>
                                                <p class="mu-blog-description"><?php echo $description; ?></p>
                                            </div>
                                        </div>
                                        <!--</div>-->

                                <?php
                                    }
                                }
                                ?>
                                
                                
                            </div>
                        </section>
                    </div>
                </div>
                <!-- right bar start  -->
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <ul>
                                    <li>INTERNATIONAL RELATIONS CELL</li>
                                    <li><a href="about_irc.php" class="active"><i class="fa-solid fa-arrow-right"></i>GMIU International Relation Cell</a></li>
                                    <li><a href="about_icm.php" class=""><i class="fa-solid fa-arrow-right"></i>International Initiatives & Collaboration Modes</a></li>
                                    <li><a href="about_admission.php" class=""><i class="fa-solid fa-arrow-right"></i>International Admission </a></li>
                                    <li><a href="about_explosure.php" class=""><i class="fa-solid fa-arrow-right"></i>Global Exposure</a></li>
                                       <li><a href="about_irc_connection.php" class=""><i class="fa-solid fa-arrow-right"></i>Global Connections</a></li>
                                    <li><a href="contact_us.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right bar end  -->
            </div>
        </div>
    </div>

    <?php include "../include/importfooter.php"; ?>

    <?php include "../include/importjs.php"; ?>
</body>

</html>