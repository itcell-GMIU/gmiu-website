<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Grievance Redressal at Gyanmanjari Innovative University | Student Support"; 
    $meta_description = "Access GMIU's grievance redressal system – providing students with a platform to voice concerns, ensuring fair resolution and a supportive campus environment.";
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
        /* Add CSS for the white border after the first tr in thead */
thead tr:first-child {
    border-bottom: 2px solid white;
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
                    <h1>Grievances Committee</h1>
                </div>
                <p style="margin-top:5px;">
                    <!--<span><a href="<?php //echo $base_url_website;    ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>-->
                    <!--<span class="b-active"><a href="#">Innovation Cell</a></span>-->
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
                    <p> UGC (Redressal of Grievances of Students) Regulations, 2023 stipulate that every university shall constitute Students' Grievance Redressal Committee in the university to
                        provide opportunities for redressal of certain grievances of students already enrolled in any institution, as well as those seeking admission to the university. To provide students with the most effective learning environment, we have put together a system of grievance redressal that allows them to gain effective online solutions. Through our personalized classroom atmosphere, we focus on you, to ensure the most enriching learning experience. Beyond simply giving you the knowledge, we inspire you to seek more knowledge.

                </div>

                <div >
                    <a href="<?php echo $website_assets_url; ?>pdf/SGRC_Committee_GMIU.pdf" target="_blank" rel="noopener noreferrer" class="rgsBtn red-background">Grievance Redressal Committee</a>
                </div>
                <hr>
                <div>
                    <h3 class="gradText">Fill in the Form below to your grievance</h3>
                    <a href="https://forms.gle/iiJnKM8dJFWsZr5W6" target="_blank" rel="noopener noreferrer" class="rgsBtn red-background">Share Your Grievance</a>
                </div>
            </section>


            <div style="padding-top: 20px;">
                <h3 class="gradText">Grievance Redressal Committee</h3>
                <hr>
                <table>
                    <thead class="red-background">
                    <tr>
                            <th colspan="4" style="border-radius: 0px 0px 0px 0px;">Particulars of OMBUDSMAN</th>
                        </tr>
                        <tr>
                            <th style="border-radius: 0px 0px 0px 10px;">#</th>
                            <th>Particulars of Member(s)</th>
                            <th>Designation</th>
                            <th style="border-radius: 0px 0px 10px 0px;">Contact Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Dr. K.R.Zanzrukiya</td>
                            <td>OMBUDSMAN</td>
                            <td><a href="mailto:drzanzrukiya@gmail.com">drzanzrukiya@gmail.com</a> <br>9909970295</td>
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