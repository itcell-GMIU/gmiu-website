<?php
include '../../common/importwebsitefile.php';
include '../database/connect.php';
include '../common/validation.php';
include '../common/globalvariable.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php 
        $meta_description = "Watch GMIU's videos – showcasing campus life, events, achievements, and student experiences, offering a glimpse into the vibrant academic community at GMIU.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
     <style>
     .container .reel{
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .reel-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .reel-container {
            flex: 0 0 calc(33.333% - 20px); /* Each reel takes up 1/3 of the row minus the gap */
            max-width: calc(33.333% - 20px);
            height: 250px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .reel-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        @media (max-width: 767px) { /* Mobile screens */
            .reel-container {
                flex: 0 0 100%; /* Each reel takes up 100% of the row */
                max-width: 100%;
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
                    <h1>MEDIA COVERAGE</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a><i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">MEDIA COVERAGE</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
              
                  <div class="reel-wrapper">
                        <?php
                            $cmd = "SELECT `file_type`, `file` FROM `tbl_media_coverage` WHERE file_type = 'video' AND is_active = 1 AND is_delete = 0 ORDER BY id DESC";
                
                            $stmt = $con->prepare($cmd);
                            $stmt->execute();
                            $result = $stmt->get_result();
                
                            while ($row = $result->fetch_assoc()) { ?>
                               
                                 <div class="reel-container">
                                    <iframe src="<?php echo $row['file']; ?>" title="YouTube video player" frameborder="0"></iframe>
                                    </div>
                            <?php   }  ?>
                        </div>
                <br><br>
            </div>
        </div>
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