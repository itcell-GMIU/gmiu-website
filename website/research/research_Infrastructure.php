<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Research Infrastructure at Gyanmanjari Innovative University";?>
    <?php $meta_description = "Discover state-of-the-art research infrastructure at GMIU. We support innovation through modern labs, resources, and expert guidance."; ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <style>
        :root {
            --grad1: #ba2a21;
            --grad2: #ba2a21;
            --grad1Des: 186, 42, 33;
            --grad2Des: 186, 42, 33
        }

        .imgGrid[_ngcontent-wue-c79] {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        .imgGrid[_ngcontent-wue-c79] .imgHoverCard[_ngcontent-wue-c79] {
            position: relative;
            width: 100%;
            aspect-ratio: 16/9;
            outline: 3px solid rgba(255, 255, 255, 0);
            background-repeat: no-repeat;
            background-size: 100%;
            background-position: center;
            overflow: hidden;
        }

        .imgGrid[_ngcontent-wue-c79] .imgHoverCard[_ngcontent-wue-c79] span[_ngcontent-wue-c79] {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 36px;
            background: linear-gradient(130deg, var(--grad1) 0%, var(--grad2) 100%);
            background-blend-mode: multiply;
            transition: all .3s ease-in-out;
        }



        .imgGrid[_ngcontent-wue-c79] .imgHoverCard[_ngcontent-wue-c79] a[_ngcontent-wue-c79] {
            display: block;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            margin: 0;
            padding: 7px 0;
            text-align: center;
            color: #fff;
            font-size: 16px;
            transition: all .3s ease-in-out;
            outline: none;
        }

        a:focus,
        a:hover {
            color: #23527c;
            /* text-decoration: underline; */
        }


        .imgGrid[_ngcontent-wue-c79] .imgHoverCard[_ngcontent-wue-c79]:hover a[_ngcontent-wue-c79],
        .imgGrid[_ngcontent-wue-c79] .imgHoverCard[_ngcontent-wue-c79]:focus-within a[_ngcontent-wue-c79] {
            padding: 25% 0;
            font-weight: 500;
        }

        a:active,
        a:hover {
            outline: 0;
        }

        .imgHoverCard:hover {
            border: 3px solid #ba2a21;
        }


        /* for temporatry    */
        .imgGrid[_ngcontent-jjx-c79] .imgHoverCard[_ngcontent-jjx-c79]:hover,
        .imgGrid[_ngcontent-jjx-c79] .imgHoverCard[_ngcontent-jjx-c79]:focus-within {
            background-size: 120%;
            outline-color: var(--grad1)
        }

        .imgGrid[_ngcontent-jjx-c79] .imgHoverCard[_ngcontent-jjx-c79]:hover span[_ngcontent-jjx-c79],
        .imgGrid[_ngcontent-jjx-c79] .imgHoverCard[_ngcontent-jjx-c79]:focus-within span[_ngcontent-jjx-c79] {
            background-color: #000c;
            height: 100%;
            opacity: .6
        }

        .imgGrid[_ngcontent-jjx-c79] .imgHoverCard[_ngcontent-jjx-c79]:hover a[_ngcontent-jjx-c79],
        .imgGrid[_ngcontent-jjx-c79] .imgHoverCard[_ngcontent-jjx-c79]:focus-within a[_ngcontent-jjx-c79] {
            padding: 25% 0;
            font-weight: 500
        }

        .imgHoverCard span:hover {
            color: green;
            background-color: green;
        }

        @media only screen and (max-width: 480px) {
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
                    <h1>Research Infrastructure</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/nss.php">Research
                            Infrastructure</a></span>
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
                                $type = 10;
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
                        <div _ngcontent-wue-c79="" class="cont">
                            <section _ngcontent-wue-c79="">
                                <h3 _ngcontent-wue-c79="" class="gradText">Research Infrastructure</h3>
                                <hr _ngcontent-wue-c79="">
                                <div _ngcontent-wue-c79="" class="imgGrid">
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl2.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7186024,72.1219548,3a,90y,214.46h,83.12t/data=!3m7!1e1!3m5!1sAF1QipM8Pmg5ECZ7IvxPTfEImokqTd14izzNqIBHaOsf!2e10!3e12!7i12706!8i6353">iOS
                                            Lab</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl1.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7186477,72.121972,3a,90y,356.2h,65.99t/data=!3m7!1e1!3m5!1sAF1QipMd0iPg0Z_hwxXUynSLBR0JFK6nTvS6d6XKydsl!2e10!3e12!7i12594!8i6297">Language
                                            Lab</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa9.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7187904,72.1219964,3a,90y,186.29h,79.3t/data=!3m6!1e1!3m4!1sAF1QipMOnYBSDX_W1dwpBkLzKtXOqArDpgqkuigj9HRi!2e10!7i12614!8i6307">Seminar
                                            Hall</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l18.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7185357,72.1219586,3a,90y,269.94h,76.45t/data=!3m7!1e1!3m5!1sAF1QipNKWDA5ONCUffQdg3vcdwQil8Q4MrDKm2b4h_J9!2e10!3e12!7i12616!8i6308">First
                                            Floor Lab 23</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l19.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7185286,72.1219119,3a,90y,68.53h,59.36t/data=!3m7!1e1!3m5!1sAF1QipPF5S_DwRnfGs1qgcnLePEP2aOsvuVKCWxNk81t!2e10!3e12!7i12620!8i6310">First
                                            Floor Lab 19</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l20.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.718529,72.1218906,3a,90y,95.08h,70.23t/data=!3m6!1e1!3m4!1sAF1QipO3eHJpPwElN7h0xVGWNIvqeFGGkR8js3dNtPVO!2e10!7i12620!8i6310">First
                                            Floor Lab 18</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l10.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7186956,72.1220769,3a,90y,293.28h,73.06t/data=!3m6!1e1!3m4!1sAF1QipM-GM5cSQVsbfUNeoIB4OGeLOUHk9Y0jP_RGrOo!2e10!7i12586!8i6293">High
                                            Voltage Lab</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l6.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7188381,72.1220663,3a,90y,263.07h,78.82t/data=!3m6!1e1!3m4!1sAF1QipNPgENMECO6_SoGyXv0oi_GdPWWs6ZpXE3IHKVx!2e10!7i12594!8i6297">Mechanical
                                            Workshop 1</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l7.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7188429,72.1220298,3a,90y,99.04h,73.2t/data=!3m7!1e1!3m5!1sAF1QipMO2t7KMzuLC_Q78BupKpAOx9NRxv-8dRNl6kvp!2e10!3e12!7i12590!8i6295">Mechanical
                                            Workshop 2</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l1.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7187132,72.1219634,3a,75y,68.24h,83.33t/data=!3m7!1e1!3m5!1sAF1QipN8dJQoIrRvldgm5u2GXtAusanx2PraU73yLaSm!2e10!3e12!7i12620!8i6310">Civil
                                            Workshop</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l11.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7186971,72.122123,3a,90y,73.83h,79.36t/data=!3m6!1e1!3m4!1sAF1QipNV3OKNfmIg6qn65_qVuLA8h1qI1rBalBQ-rkUM!2e10!7i12626!8i6313">Civil
                                            Lab</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l5.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7188295,72.1220322,3a,90y,288.4h,79.29t/data=!3m7!1e1!3m5!1sAF1QipN4TdzNesRCuBgfvbvAFvLwC676Ow79TJL-MyL4!2e10!3e12!7i12636!8i6318">ICEngine</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl3.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.718578,72.121951,3a,90y,82.5h,77.56t/data=!3m7!1e1!3m5!1sAF1QipMRW-eVyE8-7pPwMuWWHGtZAXnatxNB0oAY6EHB!2e10!3e12!7i12612!8i6306">Computer
                                            Center</a>
                                    </div>
                                    <div _ngcontent-wue-c79="" class="imgHoverCard card"
                                        style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l2.webp&quot;);">
                                        <span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79=""
                                            target="_blank" class="opSelection noTransition"
                                            href="https://www.google.com/maps/@21.7188069,72.1219441,3a,75y,250.81h,76.92t/data=!3m7!1e1!3m5!1sAF1QipPBdI-OU4Gg60xFdBDjoFIOUerTdrZBU18m-Bzu!2e10!3e12!7i12594!8i6297">Electrical
                                            Workshop</a>
                                    </div>

                                </div>
                            </section>
                        </div>
                    </div>

                </div>
                <!-- right bar start  -->
                <?php include "../research/rightbar.php" ?>
                <!-- right bar end  -->
            </div>
        </div>
    </div>
    <!-- img  -->
    <!-- <div class="flexContainer container">
        <div _ngcontent-wue-c79="" class="cont">
        <section _ngcontent-wue-c79="">
                <h3 _ngcontent-wue-c79="" class="gradText">research Infrastructure</h3>
                <hr _ngcontent-wue-c79="">
                <div _ngcontent-wue-c79="" class="imgGrid">
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl2.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186024,72.1219548,3a,90y,214.46h,83.12t/data=!3m7!1e1!3m5!1sAF1QipM8Pmg5ECZ7IvxPTfEImokqTd14izzNqIBHaOsf!2e10!3e12!7i12706!8i6353">iOS Lab</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl1.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186477,72.121972,3a,90y,356.2h,65.99t/data=!3m7!1e1!3m5!1sAF1QipMd0iPg0Z_hwxXUynSLBR0JFK6nTvS6d6XKydsl!2e10!3e12!7i12594!8i6297">Language Lab</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa9.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187904,72.1219964,3a,90y,186.29h,79.3t/data=!3m6!1e1!3m4!1sAF1QipMOnYBSDX_W1dwpBkLzKtXOqArDpgqkuigj9HRi!2e10!7i12614!8i6307">Seminar Hall</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l18.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185357,72.1219586,3a,90y,269.94h,76.45t/data=!3m7!1e1!3m5!1sAF1QipNKWDA5ONCUffQdg3vcdwQil8Q4MrDKm2b4h_J9!2e10!3e12!7i12616!8i6308">First Floor Lab 23</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l19.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185286,72.1219119,3a,90y,68.53h,59.36t/data=!3m7!1e1!3m5!1sAF1QipPF5S_DwRnfGs1qgcnLePEP2aOsvuVKCWxNk81t!2e10!3e12!7i12620!8i6310">First Floor Lab 19</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l20.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.718529,72.1218906,3a,90y,95.08h,70.23t/data=!3m6!1e1!3m4!1sAF1QipO3eHJpPwElN7h0xVGWNIvqeFGGkR8js3dNtPVO!2e10!7i12620!8i6310">First Floor Lab 18</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l10.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186956,72.1220769,3a,90y,293.28h,73.06t/data=!3m6!1e1!3m4!1sAF1QipM-GM5cSQVsbfUNeoIB4OGeLOUHk9Y0jP_RGrOo!2e10!7i12586!8i6293">High Voltage Lab</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l6.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188381,72.1220663,3a,90y,263.07h,78.82t/data=!3m6!1e1!3m4!1sAF1QipNPgENMECO6_SoGyXv0oi_GdPWWs6ZpXE3IHKVx!2e10!7i12594!8i6297">Mechanical Workshop 1</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l7.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188429,72.1220298,3a,90y,99.04h,73.2t/data=!3m7!1e1!3m5!1sAF1QipMO2t7KMzuLC_Q78BupKpAOx9NRxv-8dRNl6kvp!2e10!3e12!7i12590!8i6295">Mechanical Workshop 2</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l1.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187132,72.1219634,3a,75y,68.24h,83.33t/data=!3m7!1e1!3m5!1sAF1QipN8dJQoIrRvldgm5u2GXtAusanx2PraU73yLaSm!2e10!3e12!7i12620!8i6310">Civil Workshop</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l11.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186971,72.122123,3a,90y,73.83h,79.36t/data=!3m6!1e1!3m4!1sAF1QipNV3OKNfmIg6qn65_qVuLA8h1qI1rBalBQ-rkUM!2e10!7i12626!8i6313">Civil Lab</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l5.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188295,72.1220322,3a,90y,288.4h,79.29t/data=!3m7!1e1!3m5!1sAF1QipN4TdzNesRCuBgfvbvAFvLwC676Ow79TJL-MyL4!2e10!3e12!7i12636!8i6318">ICEngine</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl3.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.718578,72.121951,3a,90y,82.5h,77.56t/data=!3m7!1e1!3m5!1sAF1QipMRW-eVyE8-7pPwMuWWHGtZAXnatxNB0oAY6EHB!2e10!3e12!7i12612!8i6306">Computer Center</a></div>
                <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l2.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188069,72.1219441,3a,75y,250.81h,76.92t/data=!3m7!1e1!3m5!1sAF1QipPBdI-OU4Gg60xFdBDjoFIOUerTdrZBU18m-Bzu!2e10!3e12!7i12594!8i6297">Electrical Workshop</a></div>

                </div>
            </section>           
        </div>       
     </div> -->
    </div>
    </div>


    <?php include '../include/importjs.php'; ?>


    <?php include '../include/importfooter.php' ?>


</body>

</html>