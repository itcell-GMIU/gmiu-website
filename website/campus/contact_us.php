<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "Contact Us | Gyanmanjari Innovative University | GMIU"; 
         $meta_description = "Contact GMIU for inquiries, support, or details about programs, admissions, and campus facilities through our easy-to-use contact page.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
     @media screen and (max-width: 600px) {
            table {
                width: 100% !important; /* Full width on mobile screens */
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
                    <h1>Contact Us</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/nss.php">NSS</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="flexContainer container">
        <div class="cont">
            <div class="curriculum-text-box">
                <div class="curriculum-section">
                    <div class="panel-group" id="accordion">
                        <br>
                        <div _ngcontent-mhr-c78="" class="row" style="margin-bottom: 20px;">
                            <div _ngcontent-mhr-c78="" class="col-md-4 col-sm-4">
                                <?php
                                $status = 0;
                                $cmd = $con->prepare("SELECT nss_contact_us.id as nss_contact_us_id, nss_contact_us.description as description FROM tbl_nss_contact_us as nss_contact_us 
                                       WHERE nss_contact_us.is_delete = ?");
                                $cmd->bind_param("i", $status);
                                $cmd->execute();
                                $result = $cmd->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $nss_contact_us_id = $row['nss_contact_us_id'];
                                    $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
                                    // Your code to handle each row's data goes here
                                    echo $description;
                                }
                                ?>
                            </div>

                        </div>
                        <!-- Faculty about  -->

                    </div>
                </div>
            </div>
        </div>
        <!-- left bar end -->

        <!-- right ber start -->
        <?php include "../campus/campussidebar.php"; ?>
        <!--  right bar end -->

    </div>
    </div>
    </div>


    <?php include '../include/importjs.php'; ?>
     <?php include '../include/importfooter.php'?>

</body>

</html>