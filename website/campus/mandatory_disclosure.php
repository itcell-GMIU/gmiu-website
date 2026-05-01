<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
      <?php $pageTitle = "Mandatory Disclosure of Gyanmanjari Innovative University | GMIU"; 
          $meta_description = "Access GMIU's mandatory disclosures – providing transparent information on academic programs, faculty, infrastructure, and other essential details for prospective students.";
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
        .te-ce{
            text-align: center !important;
            margin: 20px 0 10px 0;
            display: inline-flex;
        }
        h1{
            font-size: 25px !important;
        }
        .flexContainer {
                justify-content: flex-start;
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
                    <h1>Mandatory Disclosure</h1>
                </div>
                <p style="margin-top:5px;">
                 <!--   <span><a href="<?php //echo $base_url_website; 
                                    ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Innovation Cell</a></span>-->
                </p>
                <hr>
            </div>
        </div>
    </section> 

    <div class="flexContainer container">
          <div>
            <section>
                 <div>
                   
                   <?php
                                $status = 0;
                                $cmd = $con->prepare("SELECT file, name FROM tbl_mandatory
                               WHERE is_delete = ?");
                                $cmd->bind_param("i", $status);
                                $cmd->execute();
                                $result = $cmd->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $file = $row['file'];
                                    $file = str_replace(' ','',$file);
                                    $name = $row['name'];
                                    ?>
                        
              
                                        <a href="<?php echo $base_url_website_admin; ?>uploads/mandatory_disclosure/<?php echo $file; ?>" target="_blank" rel="noopener noreferrer" 
                                        class="rgsBtn red-background">
                                            <?php echo $name; ?></a>
                 
                
               
                                    <?php
                                        }
                                    ?>

                </div>
                  </section>
 </div>
       
    </div>
   


    <?php include '../include/importjs.php'; ?>


    <?php include '../include/importfooter.php' ?>


</body>

</html>