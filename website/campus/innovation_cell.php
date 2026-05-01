<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Innovation Cell at Gyanmanjari Innovative University | Campus Hub"; ?>
    <?php 
    $meta_description = "Discover GMIU's Innovation Cell – a hub for creativity and entrepreneurship, empowering students to develop innovative ideas, solve real-world challenges, and drive change";
    ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />



    <style>
        .flexContainer .cont section {
            margin: 20px 0;
        }

        ._2[_ngcontent-fmp-c57] .imgGrid[_ngcontent-fmp-c57] {
            display: grid;
            place-items: center;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        .card.imgCard img {
            margin: 0;
        }

        .card.imgCard {
            padding: 0;
            overflow: hidden;
            margin: 20px 0;
        }

        .card {
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        .flexContainer .cont img {
            border-radius: 10px;
            width: 100%;
            margin-bottom: 50px;
        }

        ._2[_ngcontent-fmp-c57] .imgCard[_ngcontent-fmp-c57] div[_ngcontent-fmp-c57] {
            padding: 0 5px;
        }

        ._2 .imgGrid .card div p {
            font-family: Montserrat, sans-serif;
            font-size: 13px;
            color: #727272;
            line-height: 22px;
            text-align: justify;
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

        .red-background {
            background-color: #ba2a21;
            color: white;
        }

        /* Add CSS for the table */
        table {
            border-collapse: collapse;
            /* Collapse border spacing */
            width: 100%;
            /* Make table width 100% */
            border-radius: 10px;
            /* Apply border radius of 10% */
            padding: 10px;

        }

        /* Style table headers */
        th {
            background-color: #ba2a21;
            /* Apply background color to header cells */
            color: white;
            /* Set text color for header cells */

        }

        /* Style table rows */
        tr:nth-child(even) {
            background-color: #ba2a2126;
            /* Apply alternate background color to even rows */
        }

        /* Style table cells */
        td,
        th {
            border: none;
            /* Remove borders from table cells */
            padding: 8px;
            /* Add padding to table cells */
            text-align: left;
            /* Align text to left in table cells */
            height: 50px;
            width: auto;

        }


        .row {
            margin-right: 10px;
            margin-left: -15px;
        }

        a {
            color: #1a1a1a;
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
                    <h1>Innovation Cell</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Innovation Cell</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="flexContainer container">
        <div>
            <section>
                <div>
                    <h3 class="gradText">INTRODUCTION</h3>
                    <hr>
                    <p>The Innovation Cell sources live industry or social projects and helps students to participate and complete these assignments with mentors from Institute, various Agencies and Corporate.</p>

                    <p>The Innovation cell gives students to have their hands on experience on the real corporate world. The kind of work, profiles, and job descriptions of the projects matches to their job profile in various companies and firms during their final year placements. It adds to value to their CV and always gives an edge during job selections during their internships and placement.</p>

                </div>
                <div>
                    <h3 class="gradText">OBJECTIVE</h3>
                    <hr>
                    <ul type="disc" style="padding-left: 40px;">
                        <li>
                            <p>To inculcate a culture of innovation amongst students.</p>
                        </li>
                        <li>
                            <p>To promote innovation, creativity and engagement in science.</p>
                        </li>
                        <li>
                            <p>To foster problem solving ability and project based learning.</p>
                        </li>
                        <li>
                            <p>To help and guide students in their research and project work.</p>
                        </li>
                        <li>
                            <p>To enable them to generate new ideas and become more innovative.</p>
                        </li>
                        <li>
                            <p>To help the society and economy to face future challenges in science & technology.</p>
                        </li>
                    </ul>
                </div>
            </section>


            <div style="padding-top: 10px;">

                <h3 class="gradText" style="padding: 0px;">COMMITTEE MEMBERS</h3>
                <hr>
                <table>

                    <thead class="red-background">          
                        <tr>
                            <th style="border-radius: 10px 0px 0px 0px;">#</th>
                            <th style="border-radius: 0px 0px 0px 0px;">NAME OF COMMITTEE MEMBER</th>
                            <th style="border-radius: 0px 10px 0px 0px;">COMMITTEE DESIGNATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Prof. (Dr.) H.M. Nimbark</td>
                            <td>Principal</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Prof. Anish Vora</td>
                            <td>Club Convener</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Prof. Jay Bhatt</td>
                            <td>Club Coordinator</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Prof. Vimal Jogi</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Prof. Vandan Vyas</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Prof. Prakruti Parmar</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Prof. Prashant Viradiya</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Prof. Kashyap Dave</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Prof. Disha Shukla</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Mr. Karthik Jagad</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Mr. RAMAVAT HIMANSHU R.</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Mr. ANGHAN JAYBHAI C</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Ms. DODIYA DEVKI DIPAKBHAI</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Mr. Anas Saiyad</td>
                            <td>Member</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>Ms. SAPARA KEMI P</td>
                            <td>Member</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- right ber start -->

        <?php //include '../campus/campussidebar.php' 
        ?>

        <!--  right bar end -->
    </div>
    </div>
    </div>


    <?php include '../include/importjs.php'; ?>


    <?php include '../include/importfooter.php' ?>


</body>

</html>