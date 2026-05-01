<?php
include '../../common/importwebsitefile.php';
?>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Contact Research at Gyanmanjari Innovative University | Get in Touch";?>
    <?php $meta_description = "Contact GMIU's Research Cell for guidance, collaboration, or queries on ongoing and future research initiatives."; ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <style>
        .contact-area {
            background-color: white;
        }

        .contact-area .contact-info h2 {
            font-size: 30px;
            text-align: left;
            padding-bottom: 10px;
        }

        h2 {
            margin: 0;
            text-align: center;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 35px;
            position: relative;
        }

        .contact-area .contact-info .content-sub_p {
            font-size: 15px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        p {
            font-family: Montserrat, sans-serif;
            font-size: 13px;
            color: #727272;
            line-height: 22px;
            text-align: justify;
        }

        .contact-area .contact-info .content-sub_p:before {
            transition: all .3s ease-in-out;
            position: absolute;
            height: 2px;
            width: 50px;
            content: "";
            background: linear-gradient(130deg, #ba2a21 0%, #ba2a21 100%);
            bottom: 0;
            left: 0;
        }

        .contact-area .contact-info .contact-box .single-address-box {
            padding: 30px 0;
            border-top: 1px solid #ba2a21;
        }

        /* .contact-area .contact-info .contact-box .single-address-box .single-address.d-flex {
            display: flex;
        } */


        .contact-area .contact-info .contact-box .single-address-box .single-address i {
            float: left;
            font-size: 25px;
            height: 40px;
            line-height: 30px;
            width: 30px;
            color: #ba2a21;
            margin-right: 15px;
        }

        .contact-area .contact-info .contact-box .single-address-box .single-address {
            display: flex;
        }

        .contact-area .contact-info .contact-box .single-address-box .single-address h4 {
            margin: 0;
            padding-bottom: 5px;
        }

        a {
            color: unset;
            display: inline-block;
            transition: all .3s;
            text-decoration: none !important;
        }

        .contact-area .contact-info .contact-box .single-address-box .single-address .getDirections {
            padding: 10px;
            background: #ba2a21;
            color: #fff;
            font-weight: 500;
            text-transform: uppercase;
            margin-top: 20px;
        }

        .contact-area .contact-info .contact-box .single-address-box ul {
            margin: 0;
        }

        .list-unstyled {
            padding-left: 0;
            list-style: none;
        }

        .contact-area .contact-info .contact-box .single-address-box ul li {
            margin: 0 5px;
            display: inline-block;
        }

        .contact-area .contact-info .contact-box .single-address-box ul li i {
            background: #f9f9f9;
            border: 1px solid #ba2a21;
            border-radius: 100%;
            color: #ba2a21;
            height: 40px;
            padding: 10px;
            width: 40px;
            font-size: 18px;
            text-align: center;
            transition: all .3s ease-in-out;
        }

        .fa {
            display: inline-block;
            font: 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .contact-area .contact-form .contact-title-btm h2 {
            font-size: 30px;
            text-align: left;
            padding-bottom: 10px;
        }

        .contact-area .contact-form .contact-title-btm .content-sub_p {
            font-size: 15px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
            text-align: left;
        }

        .contact-area .contact-form .contact-title-btm .content-sub_p:before {
            position: absolute;
            height: 2px;
            width: 50px;
            content: "";
            background: linear-gradient(130deg, #ba2a21 0%, #ba2a21 100%);
            bottom: 0;
            left: 0;
            transition: all .3s ease-in-out;
        }

        @media (min-width: 768px) {
            .col-sm-6 {
                width: 50%;
            }
        }

        .form-group {
            margin-bottom: 15px;
        }

        .contact-area .contact-form .input-contact-form form input,
        .contact-area .contact-form .input-contact-form form textarea {
            background-color: transparent;
            border-radius: 0;
            box-shadow: none;
            font-size: 15px;
            margin: 10px 0;
            padding: 10px 20px;
            outline: none;
            resize: none;
            border-color: #ba2a21;
        }

        .contact-area .contact-form .input-contact-form form input {
            height: 40px;
            border-color: #ba2a21;
        }

        .contact-area .contact-form .input-contact-form {
            margin-top: 40px;
        }

        form {
            display: block;
            margin-top: 0em;
        }

        .contact-area .contact-form .input-contact-form form input[type=submit] {
            background: #ba2a21;
            border-radius: 0;
            color: #fff;
            border: none;
            font-size: 15px;
            font-weight: 500;
            margin-top: 20px;
            height: 40px;
            text-transform: uppercase;
            transition: all .3s ease-in-out;
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
                    <h1>Contact us For Research Cell</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a><i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Contact us For Research Cell</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- <div class="row two-colum-section"> -->
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <section class="contact-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-5 contact-info">
                                    <div class="col-sm-12 contact-title" style="margin-bottom: 50px;">
                                        <h2>Contact Info</h2>
                                        <p class="content-sub_p"> Welcome to our Website. We are glad to have you
                                            around. </p>
                                    </div>
                                    <div class="col-sm-12 contact-box">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 single-address-box">
                                                <div class="single-address d-flex"><i class="fa fa-phone"></i>
                                                    <div>
                                                        <h4>Phone</h4><a href="tel:7096427987">+91 7096427987</a><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 single-address-box">
                                                <div class="single-address"><i class="fa fa-envelope"></i>
                                                    <div class="">
                                                        <h4>Email</h4>
                                                        <a href="mailto:rvgandhi@gmiu.edu.in">rvgandhi@gmiu.edu.in</a>
                                                        <a
                                                            href="mailto:stewardship@gmiu.edu.in">stewardship@gmiu.edu.in</a>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 single-address-box">
                                                <div class="single-address d-flex"><i class="fa fa-map-marker"></i>
                                                    <div>
                                                        <h4>Location:</h4><a
                                                            href="https://goo.gl/maps/Rew9anmSejXpQ2ucA"
                                                            target="_blank"> Survey No. 30, Sidsar Road, Near Iscon
                                                            Eleven,
                                                            Bhavnagar Gujarat(India) </a><a
                                                            href="https://goo.gl/maps/Rew9anmSejXpQ2ucA" target="_blank"
                                                            class="getDirections"> get direction </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 single-address-box">
                                                <ul class="list-unstyled">
                                                    <li><a href="https://www.facebook.com/GyanmanjariColleges"><i
                                                                class="fa-brands fa-facebook"></i></a></li>
                                                    <li><a href="https://twitter.com/GMGC_Bhavnagar"><i
                                                                class="fa-brands fa-twitter"></i></a></li>

                                                    <li><a href="https://www.linkedin.com/company/gyanmanjari/"><i
                                                                class="fa-brands fa-linkedin"></i></a></li>
                                                    <li><a href="https://www.instagram.com/gyanmanjari_innovative_u/"><i
                                                                class="fa-brands fa-instagram"></i></a></li>


                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>
                </div>
                <!-- sidebar start -->
                <?php include "../research/rightbar.php" ?>
                <!-- sidebar end -->
            </div>
        </div>
    </div>






    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

</body>

</html>