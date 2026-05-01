<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "360 Virtual Tour of Gyanmanjari Innovative University Campus"; 
    $meta_description = "Take a 360° virtual tour of GMIU’s campus – explore our state-of-the-art facilities, vibrant student spaces, and scenic grounds from anywhere in the world.";
   ?>
    
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
                    <h1>360 Virtual Tour</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/nss.php">360 Virtual Tour</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>




    <div class="flexContainer container">
        <div _ngcontent-wue-c79="" class="cont">
            <section _ngcontent-wue-c79="">
                <h3 _ngcontent-wue-c79="" class="gradText">College Campus</h3>
                <hr _ngcontent-wue-c79="">
                <div _ngcontent-wue-c79="" class="imgGrid">
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cc1.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186048,72.1220864,3a,75y,356.08h,86.5t/data=!3m6!1e1!3m4!1sAF1QipPK76fGCQyuQJEaS75ZQRyeTgNDIwjJiStZJSHL!2e10!7i12596!8i6298">Campus Enterance</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cc2.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186002,72.1220148,3a,75y,357.65h,95.02t/data=!3m6!1e1!3m4!1sAF1QipNCmRbyETBOWk4aKf6ujr_uqgTLUtt9QsH9aFmA!2e10!7i12614!8i6307">College Surrounding</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cc3.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186429,72.1220128,3a,75y,358.66h,83.22t/data=!3m7!1e1!3m5!1sAF1QipOTAsVT3A1PtCK66xdfCw0WCgNC7Abo5jrITz2S!2e10!3e12!7i12602!8i6301">College Enterance</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cc4.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186215,72.1220136,3a,75y,180.61h,78.37t/data=!3m7!1e1!3m5!1sAF1QipM8tVBlzhO_DI5PXXu3Ldx8uoNcJazoT7MAjWTw!2e10!3e12!7i12598!8i6299">Campus Arena</a></div><!---->
                </div>
            </section>
            <section _ngcontent-wue-c79="">
                <h3 _ngcontent-wue-c79="" class="gradText">Administrative Area</h3>
                <hr _ngcontent-wue-c79="">
                <div _ngcontent-wue-c79="" class="imgGrid">
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa1.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186384,72.1219888,3a,75y,94.44h,72.09t/data=!3m7!1e1!3m5!1sAF1QipPyzDwN8POUjj4zy_BDwfs1GjjR3KTFui16wn3p!2e10!3e12!7i12606!8i6303">Conferance Room</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa2.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186638,72.1219864,3a,75y,281.95h,88.08t/data=!3m7!1e1!3m5!1sAF1QipNTkcE2IaPvGk6CLIGxDTFakQtZthTKXmtZvXN3!2e10!3e12!7i12600!8i6300">Mini Conferance</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa3.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186603,72.1219717,3a,75y,274.78h,88.84t/data=!3m7!1e1!3m5!1sAF1QipMDXC-KRun14mTi-DcgA2K4Vo0ONb7cMnw5u5lX!2e10!3e12!7i12620!8i6310">Trustee Office</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa4.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186347,72.1219748,3a,75y,227.01h,74.05t/data=!3m7!1e1!3m5!1sAF1QipPZPJOICJ1bjEgXFMDU_CtPA47pzZHCeSkfGrIv!2e10!3e12!7i12630!8i6315">Principal Office</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa5.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186441,72.1219593,3a,75y,88.2h,84.13t/data=!3m7!1e1!3m5!1sAF1QipOxEVwnFZmBnLweb4xoN3u0K4k6xP_y2na0Oqks!2e10!3e12!7i12586!8i6293">Internal Admin</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa6.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186568,72.1219574,3a,75y,345.48h,87.47t/data=!3m7!1e1!3m5!1sAF1QipMw_uAd6dHkw1SJoYd-OUdXA5u2gZS3YJULpUzX!2e10!3e12!7i12576!8i6288">TPO &amp; HR</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa7.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186392,72.1219322,3a,75y,80.25h,86.58t/data=!3m7!1e1!3m5!1sAF1QipO8YXBrDrLasmq5RqQbNDPCP_OsZVbXR5z7BlY9!2e10!3e12!7i12600!8i6300">Main Reception</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa8.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186648,72.1219278,3a,75y,347.42h,72.7t/data=!3m6!1e1!3m4!1sAF1QipNymZfPyMCjPWNoc475_MUcnkw1hS3ArTRWuw-s!2e10!7i12616!8i6308">Campus Arena</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa9.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187904,72.1219964,3a,90y,186.29h,79.3t/data=!3m6!1e1!3m4!1sAF1QipMOnYBSDX_W1dwpBkLzKtXOqArDpgqkuigj9HRi!2e10!7i12614!8i6307">Seminar Hall</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa10.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186667,72.1219051,3a,90y,245.44h,79.42t/data=!3m7!1e1!3m5!1sAF1QipNhOiSDIYL_-l4c6y6hsBgdDMgys9daNu21y2zl!2e10!3e12!7i12618!8i6309">Seminar Hall 2</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/aa11.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187609,72.1221004,3a,75y,184.79h,106.3t/data=!3m6!1e1!3m4!1sAF1QipNopfy62ODIEws6CPgVe41mmIy7LoSXF-oh9Ifr!2e10!7i12618!8i6309">Amphi Theatre</a></div><!---->
                </div>
            </section>
            <section _ngcontent-wue-c79="">
                <h3 _ngcontent-wue-c79="" class="gradText">Special Laboratories</h3>
                <hr _ngcontent-wue-c79="">
                <div _ngcontent-wue-c79="" class="imgGrid">
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl1.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186477,72.121972,3a,90y,356.2h,65.99t/data=!3m7!1e1!3m5!1sAF1QipMd0iPg0Z_hwxXUynSLBR0JFK6nTvS6d6XKydsl!2e10!3e12!7i12594!8i6297">Language Lab</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl2.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186024,72.1219548,3a,90y,214.46h,83.12t/data=!3m7!1e1!3m5!1sAF1QipM8Pmg5ECZ7IvxPTfEImokqTd14izzNqIBHaOsf!2e10!3e12!7i12706!8i6353">iOS Lab</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/sl3.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.718578,72.121951,3a,90y,82.5h,77.56t/data=!3m7!1e1!3m5!1sAF1QipMRW-eVyE8-7pPwMuWWHGtZAXnatxNB0oAY6EHB!2e10!3e12!7i12612!8i6306">Computer Center</a></div><!---->
                </div>
            </section>
            <section _ngcontent-wue-c79="">
                <h3 _ngcontent-wue-c79="" class="gradText">ClassRooms &amp; Staff Area</h3>
                <hr _ngcontent-wue-c79="">
                <div _ngcontent-wue-c79="" class="imgGrid">
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cs1.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186068,72.1219212,3a,90y,328.34h,82.45t/data=!3m7!1e1!3m5!1sAF1QipMZNIohOeY0CJ_6qNNungwQFEDGbRh8TXdR-9kU!2e10!3e12!7i12624!8i6312">Staff Room 1</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cs2.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187815,72.1220176,3a,90y,172.5h,79.97t/data=!3m7!1e1!3m5!1sAF1QipNv3qMlFb7rEjJj5ePKxJQTOPZ10SwnARvAEOvN!2e10!3e12!7i12594!8i6297">Staff Room 2</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cs3.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188063,72.1221831,3a,90y,195.89h,90.68t/data=!3m6!1e1!3m4!1sAF1QipMR1dQupfnBCcPE_A8jwz8osyXKT4mEZ4aDqPPm!2e10!7i12592!8i6296">Classroom</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cs4.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185571,72.1218127,3a,90y,209.62h,67.57t/data=!3m7!1e1!3m5!1sAF1QipO3_Inm9ip7jBQYCM6xDlguf49nb8R-h08v2GQ3!2e10!3e12!7i12614!8i6307">Classroom</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cs5.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.718578,72.121951,3a,90y,82.5h,77.56t/data=!3m7!1e1!3m5!1sAF1QipMRW-eVyE8-7pPwMuWWHGtZAXnatxNB0oAY6EHB!2e10!3e12!7i12612!8i6306">Computer Center</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cs6.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185279,72.1218674,3a,90y,193.84h,65.66t/data=!3m6!1e1!3m4!1sAF1QipNpgp1G0fMKgRXMnJkKzfF4-WeA1HNbrHjMUFvt!2e10!7i12628!8i6314">First Floor Drawing Hall 1</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/cs7.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185269,72.1218481,3a,90y,258.67h,57.98t/data=!3m6!1e1!3m4!1sAF1QipPCNptU_A9woDv93EAQ0c557Zd7shn4_5zNMPWz!2e10!7i12616!8i6308">First Floor Drawing Hall 2</a></div><!---->
                </div>
            </section>
            <section _ngcontent-wue-c79="">
                <h3 _ngcontent-wue-c79="" class="gradText">Laboratories</h3>
                <hr _ngcontent-wue-c79="">
                <div _ngcontent-wue-c79="" class="imgGrid">
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l1.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187132,72.1219634,3a,75y,68.24h,83.33t/data=!3m7!1e1!3m5!1sAF1QipN8dJQoIrRvldgm5u2GXtAusanx2PraU73yLaSm!2e10!3e12!7i12620!8i6310">Civil Workshop</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l2.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188069,72.1219441,3a,75y,250.81h,76.92t/data=!3m7!1e1!3m5!1sAF1QipPBdI-OU4Gg60xFdBDjoFIOUerTdrZBU18m-Bzu!2e10!3e12!7i12594!8i6297">Electrical Workshop</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l3.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.718793,72.121981,3a,90y,177.89h,75.45t/data=!3m7!1e1!3m5!1sAF1QipOnmP6wBLCHLZ2nnlM8tnweZ8Retns21hIsp_0H!2e10!3e12!7i12610!8i6305">Lab 1</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l4.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187951,72.1219993,3a,90y,92.27h,81.37t/data=!3m7!1e1!3m5!1sAF1QipOa7DZ2wXTAED2RU20jjb1o340yG5IR4djUw2ka!2e10!3e12!7i12604!8i6302">Lab 2</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l5.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188295,72.1220322,3a,90y,288.4h,79.29t/data=!3m7!1e1!3m5!1sAF1QipN4TdzNesRCuBgfvbvAFvLwC676Ow79TJL-MyL4!2e10!3e12!7i12636!8i6318">ICEngine</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l6.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188381,72.1220663,3a,90y,263.07h,78.82t/data=!3m6!1e1!3m4!1sAF1QipNPgENMECO6_SoGyXv0oi_GdPWWs6ZpXE3IHKVx!2e10!7i12594!8i6297">Mechanical Workshop 1</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l7.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7188429,72.1220298,3a,90y,99.04h,73.2t/data=!3m7!1e1!3m5!1sAF1QipMO2t7KMzuLC_Q78BupKpAOx9NRxv-8dRNl6kvp!2e10!3e12!7i12590!8i6295">Mechanical Workshop 2</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l8.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187675,72.1219761,3a,90y,1.11h,108.74t/data=!3m6!1e1!3m4!1sAF1QipPkiA-RboPfI8MVMoOImbL09afJlbBxApuNEHj3!2e10!7i12602!8i6301">Staffroom Side OT</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l9.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187808,72.1220038,3a,90y,171.32h,80.18t/data=!3m6!1e1!3m4!1sAF1QipPilOmfiweO0Cau84U90uvFTaLCNfY04TjaeqWg!2e10!7i12590!8i6295">Staffroom Lobby</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l10.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186956,72.1220769,3a,90y,293.28h,73.06t/data=!3m6!1e1!3m4!1sAF1QipM-GM5cSQVsbfUNeoIB4OGeLOUHk9Y0jP_RGrOo!2e10!7i12586!8i6293">High Voltage Lab</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l11.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186971,72.122123,3a,90y,73.83h,79.36t/data=!3m6!1e1!3m4!1sAF1QipNV3OKNfmIg6qn65_qVuLA8h1qI1rBalBQ-rkUM!2e10!7i12626!8i6313">Civil Lab</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l12.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187829,72.122166,3a,90y,182.2h,81.75t/data=!3m6!1e1!3m4!1sAF1QipOdIUoiKwAF_b2zV9rHUDbKl6hIpGmixD__vtpq!2e10!7i12598!8i6299">Classroom Lobby</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l13.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7187022,72.1221556,3a,90y,200.05h,76t/data=!3m6!1e1!3m4!1sAF1QipNJJZbu6NoE8uMgy_SoTR-gQOK33aiuKPHPYf2g!2e10!7i12626!8i6313">Machine Lab</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l14.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7186392,72.1219322,3a,90y,166.82h,95.71t/data=!3m7!1e1!3m5!1sAF1QipO8YXBrDrLasmq5RqQbNDPCP_OsZVbXR5z7BlY9!2e10!3e12!7i12600!8i6300">First Floor Reception Area</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l15.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.718615,72.1219517,3a,90y,161.56h,72.98t/data=!3m7!1e1!3m5!1sAF1QipOvQk93fWEMNkHX73WAE3ygyDxofUyI_NTQxJKy!2e10!3e12!7i12602!8i6301">FF COMP LAB</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l16.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185787,72.1219606,3a,90y,344.35h,79.37t/data=!3m7!1e1!3m5!1sAF1QipOb3KbxMicwTC1u-46rS26ovoku3r-urU5zyO7B!2e10!3e12!7i12632!8i6316">FF COMP LAB</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l17.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185843,72.1219876,3a,90y,359.56h,75.5t/data=!3m7!1e1!3m5!1sAF1QipOQPl9wgFf0JX0aZFSJHjZ59rETbDQD_U9B3el3!2e10!3e12!7i12612!8i6306">FF COMP LAB</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l18.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185357,72.1219586,3a,90y,269.94h,76.45t/data=!3m7!1e1!3m5!1sAF1QipNKWDA5ONCUffQdg3vcdwQil8Q4MrDKm2b4h_J9!2e10!3e12!7i12616!8i6308">First Floor Lab 23</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l19.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.7185286,72.1219119,3a,90y,68.53h,59.36t/data=!3m7!1e1!3m5!1sAF1QipPF5S_DwRnfGs1qgcnLePEP2aOsvuVKCWxNk81t!2e10!3e12!7i12620!8i6310">First Floor Lab 19</a></div>
                    <div _ngcontent-wue-c79="" class="imgHoverCard card" style="background-image: url(&quot;../../website_assets/images/360_virtual_tour-img/l20.webp&quot;);"><span _ngcontent-wue-c79="" class="below-title"></span><a _ngcontent-wue-c79="" target="_blank" class="opSelection noTransition" href="https://www.google.com/maps/@21.718529,72.1218906,3a,90y,95.08h,70.23t/data=!3m6!1e1!3m4!1sAF1QipO3eHJpPwElN7h0xVGWNIvqeFGGkR8js3dNtPVO!2e10!7i12620!8i6310">First Floor Lab 18</a></div><!---->
                </div>
            </section><!---->
        </div>



        <!-- right ber start -->
        <?php include "campussidebar.php"; ?>
        <!--  right bar end -->
    </div>
    </div>
    </div>


    <?php include '../include/importjs.php'; ?>


    <?php include '../include/importfooter.php' ?>


</body>

</html>