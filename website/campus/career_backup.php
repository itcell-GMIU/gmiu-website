<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Career at GMIU - Gyanmanjari Innovative University | GMIU";
    include "../include/importhead.php"; ?>
    <?php include '../include/importcss.php'; ?>
    <style>
        h3 {
            margin-top: 40px;
        }

        h2 {
            margin-top: 40px;
        }

        p {
            text-align: justify;
        }

        .desSec[_ngcontent-con-c38] a[_ngcontent-con-c38] {
            font-weight: 700 !important;
        }

        .cbtn {
            display: inline-block !important;
            padding: 5px 10px !important;
            border: none !important;
            position: relative !important;
            margin: 10px auto !important;
            /* Updated to auto to center horizontally */
            background: #ba2a21 !important;
            color: #fff !important;
            font-weight: 700 !important;
            border-radius: 5px !important;
            text-transform: uppercase !important;
        }

        .cbtn:hover {
            background-color: gray!important;
            transform: scale(1.1);
        }


        a[href^="mailto"]:link,
        a[href^="mailto"]:visited {
            color: gray;
            /* Default color */
            transition: color 0.3s ease;
            /* Transition effect */
        }

        a[href^="mailto"]:hover {
            color: #ba2a21;
            /* Color on hover */
        }
        .img{
            margin-left: 35%;
            height: 300px;
        }
    </style>
    <!--   -->
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include '../include/importheader.php'; ?>



    <section class="hero">
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Career at GMIU</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Career at GMIU</a></span>
                </p>
            </div>
        </div>
    </section>

    <div _ngcontent-con-c38="" class="container">
        <section _ngcontent-con-c38="" class="desSec" style="padding-bottom: 50px;">
            <h3 _ngcontent-con-c38="" class="gradText">GMIU Recruiting</h3>
            <img _ngcontent-con-c38="" class="img" style="padding-bottom:25px;" src="..\..\website_assets\images\weh.png" alt="">
            <p _ngcontent-con-c38=""> Gyanmanajari Institute of Technology is situated in historical city of Saurastra-Bhavnagar. We have large 5 acres campus at sidsar road in the limits of Bhavnagar Municipal Corporation. We always welcome and offer good to the right one. Interested candidate are requested to send your detailed CV and testimoney on

                <a _ngcontent-con-c38="" href="mailto:hr@gmiu.edu.in" target="_blank">hr@gmiu.edu.in</a>.
            </p>

            <a _ngcontent-con-c38="" href="mailto:hr@gmiu.edu.in" target="_blank" class="cbtn" style="margin-left: 45%!important;">Apply Now</a>
        </section><!---->
    </div>





    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>