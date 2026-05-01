<?php
include "../../common/importwebsitefile.php"; ?>
<!doctype html>
<html class="no-js" lang="zxx">

<head> 
  <?php $pageTitle = "Sports Facilities at Gyanmanjari Innovative University"; 
      $meta_description = "Experience world-class sports facilities at GMIU Bhavnagar. Join indoor & outdoor sports, fitness programs & campus events promoting healthy student life.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
<?php include "../include/importcss.php"; ?>
	<link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <link rel="stylesheet" href="../../website_assets/css/program.css">
	<!-- Link Swiper's CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
	<style>
	/* .swiper {
            height: auto !important;
        }
        .swipermain{
            height: 200px !important;
        }

        .swiper-slide img {
            display: block;
            width: 80px ;
            height: 80px;
            object-fit: cover;
            border-radius: 5px !important;

            aspect-ratio: 16 / 9 !important;
        } */
	.swiper {
		width: 100%;
		height: 100%;
		margin: 20px;
	}
  .swiper-wrapper {
     height: 100% !important; 
    padding-top: 10px;
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

	.logo {
		height: 80px;
		width: auto;
		margin-right: 20px;
	}

	.flexContainer {
		display: flex;
		/*flex-direction: row;*/
	}
	.flexContainer .cont {
    width: 100%;
    }

	.center-content {
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100%;
		/* Ensure full height */
	}
	</style>
</head>

<body class="courses">
	<!-- Preloader
<div id="preloader">
	<div id="status">&nbsp;</div>
</div> --> <?php include "../include/importheader.php"; ?>
	<!-- box below image  -->
	<section class="hero">
		<div class="img"></div>
		<div class="container">
			<div class="cont">
				<div class="top">
					<h1>Sports Activity</h1>
				</div>
				<p style="margin-top:5px;">
					<span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
					<span class="b-active"><a href="">Sports Activity</a></span>
				</p>
			</div>
		</div>
	</section>
	<!-- <div class="single-courses-area"> -->
		  <div class="flexContainer container">
       
			<!--<div class="row two-colum-section">-->
				<!-- left bar start  -->
				<div class="col-sm-8 sidebar-left">
					<!-- <div class="single-curses-contert"> -->
						<section class="about-cards">
							<div class="cont">
								<section class="ExtraLinks center-content">
									<a href="https://khelmanjari.gmiu.edu.in/newsite/index.php" target="_blank">
										<div class="card backColor">
											<h4 class="gradText"><br> KHELMANJARI <i class="fa fa-external-link">
												</i></h4>
										</div>
									</a>
								</section>
						</section>
						<section class="placed-students">
							<div class="buttons-container-flex" style="padding: 10px;"> <?php
                    //code for getting year buttons by grouping year in placement table
                    $cmd = "SELECT YEAR(date) FROM tbl_campus WHERE is_active = 1 AND is_delete = 0 AND type_id = 1 GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
                    $stmt = $con->prepare($cmd);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $sem_btn = $row['YEAR(date)'];
                    ?>
								<!-- <a href="#s-<?php echo $sem_btn; ?>"> -->
								<button class="tabBtn" data-semester="<?php echo $sem_btn; ?>" onclick="showSemester(<?php echo $sem_btn; ?>)"><?php echo $sem_btn; ?></button>
								<!-- </a> --> <?php
                    }
                    ?> </div>
						</section>
						<!-- Faculty about  -->
						<section class="events-list-03">
							<div class="container"> <?php
                                //code for getting year buttons by grouping year in placement table
                                $cmd6 = "SELECT YEAR(date) FROM tbl_campus WHERE is_active = 1 AND is_delete = 0 and type_id = 1 GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
                                $stmt6 = $con->prepare($cmd6);
                                $stmt6->execute();
                                $result6 = $stmt6->get_result();

                                while ($row6 = $result6->fetch_assoc()) {
                                    $sem_c = $row6['YEAR(date)'];
                                ?> <div class="row event-body-content semester-content" id="sem-<?php echo $sem_c; ?>" style="display: none;">
								 <?php
                                        $cmd = $con->prepare("SELECT id , description  FROM tbl_campus WHERE type_id=1 AND is_active=1 AND is_delete=0 AND YEAR(date) = $sem_c");
                                      //  $cmd->bind_param("i", $program_id);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {                                               
                                                $sp_id = $row['id']; 
                                                
                                        ?> 
										<div class="col-sm-8 events-full-box">
										<div class="events-single-box">
										
											<hr style="margin: 0;">
											<div class="row">
												<div id="img-slider" style="padding: 0px 0px 0px 0px;">
												    <?php
                                                    // Get the CKEditor content
                                                    $description = $row['description'];
                                                    
                                                    // Remove all HTML tags and only keep the text
                                                    $plain_text = strip_tags($description);
                                                    
                                                    // Check if the description is not "n/a" and not empty
                                                    if (strtolower(trim($plain_text)) !== "n/a" && !empty($plain_text)) {
                                                        echo '<h3 class="swiper-title" style="text-align: center; margin-bottom: 15px;">' . $plain_text . '</h3>';
                                                    }
                                                    ?>

													<div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; padding-bottom:0;height: 400px;" class="swiper swipermain mySwipers<?php echo $sp_id; ?>">
														<div class="swiper-wrapper"> <?php
                                                                        $type = "sports";
                                                                        $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp 
                                                                         WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                                        $cmd1->bind_param("is", $sp_id, $type);
                                                                        $cmd1->execute();
                                                                        $result1 = $cmd1->get_result();
                                                                        if ($result1->num_rows > 0) {
                                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                                $file_name1 = $row1['sp_file_name'];
                                                                        ?> <div class="swiper-slide">
																<img src="<?php echo $upload_website_admin_url . 'sports/' . $file_name1; ?>"  alt = "<?php echo $plain_text; ?>">
															</div> <?php }
                                                                        } ?> </div>
																		<div class="swiper-button-prev"></div>
                                                    <div class="swiper-button-next"></div>
													</div>
                                                    
													<div style="height:80px" thumbsSlider="" class="swiper mySwiper<?php echo $sp_id; ?>">
														<div class="swiper-wrapper"> <?php
                                                                        $type = "sports";
                                                                        $cmd2 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp 
                                                                         WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0");
                                                                        $cmd2->bind_param("is", $sp_id, $type);
                                                                        $cmd2->execute();
                                                                        $result2 = $cmd2->get_result();
                                                                        if ($result2->num_rows > 0) {
                                                                            while ($row2 = $result2->fetch_assoc()) {
                                                                                $file_name2 = $row2['sp_file_name'];
                                                                        ?> <div class="swiper-slide">
																<img src="<?php echo $upload_website_admin_url . 'sports/' . $file_name2; ?>" alt = "<?php echo $plain_text; ?>">
															</div> <?php }
                                                                        } ?> </div>
													</div>
												</div>
												
											</div>
										</div>
									</div> <?php
                                            }
                                        }
                                        ?> </div> <?php
                                }
                                ?> </div>
						</section>
					<!-- </div> -->
				</div>
				<!-- left bar end  -->
				<!-- right bar start  --> <?php include "../campus/campussidebar.php"; ?>
				<!-- right bar end  -->
			<!--</div>-->
		</div>
	<!-- </div> -->
	<!-- Footer Area section --> <?php include "../include/importfooter.php"; ?>
	<!-- ./ End Footer Area -->
	<!-- Swiper JS -->
	<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
	<!-- Initialize Swiper --> <?php
    $cmd = $con->prepare("SELECT sp.id as sp_id, sp.description as sp_description FROM tbl_campus as sp  WHERE type_id=1 AND is_active=1 AND is_delete=0 ");
   
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sp_id = $row['sp_id'];

            echo '<script>
                                                        var swiper = new Swiper(".mySwiper' . $sp_id . '", {
                                                            loop: true,
                                                            spaceBetween: 10,
                                                            slidesPerView: 3,
                                                            freeMode: true,
                                                            watchSlidesProgress: true,
                                                        });
                                                        var swiper2 = new Swiper(".mySwipers' . $sp_id . '", {
                                                            loop: true,
                                                            spaceBetween: 10,
                                                            navigation: {
                                                                nextEl: ".swiper-button-next",
                                                                prevEl: ".swiper-button-prev",
                                                            },
                                                            thumbs: {
                                                                swiper: swiper,
                                                            },
                                                        });
                                                        </script>';
        }
    }
    ?>

	<!-- ============================
    JavaScript Files
    ============================= -->
	<!-- jQuery --> 
	<?php //include "../include/importjs.php"; ?>
    <script>
        // JavaScript code to initialize Swiper with navigation and autoplay
var swiper = new Swiper(".mySwiper<?php echo $sp_id; ?>", {
    loop: true,
    spaceBetween: 10,
    slidesPerView: 3,
    freeMode: true,
    watchSlidesProgress: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    autoplay: {
        delay: 5000, // Adjust the delay (in milliseconds) as needed
    },
});

// // JavaScript code to adjust the size of the main Swiper
// var mainSwiper = document.querySelector(".mySwiper<?php echo $sp_id; ?>");
// mainSwiper.style.width = "758px";
// mainSwiper.style.height = "400px";

        </script>
     <script>
	function showSemester(semesterId) {
		var semesterDivs = document.querySelectorAll('.semester-content');
		var semesterButtons = document.querySelectorAll('.tabBtn');
		// Hide all semester divs
		for(var i = 0; i < semesterDivs.length; i++) {
			semesterDivs[i].style.display = 'none';
		}
		// Remove "active" class from all buttons
		for(var i = 0; i < semesterButtons.length; i++) {
			semesterButtons[i].classList.remove('tabBtn-active');
		}
		// Show selected semester div if it exists, otherwise show the first available semester div
		var semesterDiv = document.getElementById('sem-' + semesterId);
		if(!semesterDiv) {
			for(var i = 0; i < semesterDivs.length; i++) {
				if(semesterDivs[i].style.display !== 'none') {
					semesterDiv = semesterDivs[i];
					semesterId = semesterDiv.getAttribute('id').split('-')[1];
					break;
				}
			}
		}
		semesterDiv.style.display = 'block';
		// Add "active" class to the clicked button
		var clickedButton = document.querySelector('.tabBtn[data-semester="' + semesterId + '"]');
		clickedButton.classList.add('tabBtn-active');
	}
	// Find the first available semester div and show it
	var firstSemesterDiv = document.querySelector('.semester-content');
	if(firstSemesterDiv) {
		var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
		showSemester(firstSemesterId);
	}
	</script>
	<!-- ============================
    JavaScript Files
    ============================= -->
	<!-- jQuery --> <?php include '../include/importjs.php'; ?>
</body>

</html>