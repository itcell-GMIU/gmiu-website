<?php
include "../../common/importwebsitefile.php"; ?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
	<?php $pageTitle = "Cultural Activity - Gyanmanjari Innovative University | GMIU"; 
	    $meta_description = "Experience GMIU’s vibrant campus culture through diverse events that promote creativity, student engagement, and community bonding";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
	<?php include "../include/importhead.php"; ?>
	<?php include "../include/importcss.php"; ?>
	<link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
	<link rel="stylesheet" href="../../website_assets/css/program.css">
	<!-- Link Swiper's CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
	<style>
		/* Modal Styles */
		.modal {
			display: none;
			/* Hide the modal by default */
			position: fixed;
			z-index: 9999;
			height: 100%;
			overflow: auto;
			/* Enable scrolling if needed */
			background-color: rgba(0, 0, 0, 0.9);
			/* Black w/ opacity */
		}

		.modal-content {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			margin: 0 auto;
			background-color: unset !important;
			display: flex;
			justify-content: center;
			align-items: center;
			width: 100%;
			max-width: 800px;
			/* Maximum width of the modal */
			height: 80%;
			/* Adjust as needed */
		}

		.modal-content img {
			max-width: 100%;
			max-height: 100%;
			object-fit: contain;
			/* Ensures full image display */
		}

		.close {
			position: absolute;
			top: 35px;
			right: 15px;
			color: #fff;
			font-size: 30px;
			font-weight: bold;
			cursor: pointer;
		}

		/* Swiper Styles */
		.swiper {
			width: 100%;
			height: auto;
			aspect-ratio: 16 / 10;
			margin: 0 auto;
			overflow: hidden;
			/* Ensures no content spills outside */
		}

		.swiper-slide {
			display: flex;
			justify-content: center;
			align-items: center;
			overflow: hidden;
			/* Ensures no content spills outside */
			background-color: #000;
			/* Optional: Add a background color */
			background-size: cover;
			background-position: center;
		}

		.swiper-slide img {
			display: block;
			width: 100%;
			height: 100%;
			object-fit: cover;
			/* Ensure full coverage of the slide */
			border-radius: 5px;
			cursor: pointer;
		}

		.swiper-wrapper {
			height: 100% !important;
			padding-top: 10px;
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

		/* Event Styles */
		.events-list-03 .events-single-box {
			background-color: white;
		}

		.events-list-03 .events-single-box img {
			border-radius: 5px;
		}

		.events-list-03 .event-info {
			padding-top: 0;
		}

		/* Button Styles */
		#dwn-btn {
			padding: 5px 10px;
			background-color: #ba2a21;
			color: white;
			border: 1px transparent;
			border-radius: 4px;
			transition: all 0.3s ease-in-out;
		}

		#dwn-btn:hover {
			transform: translateY(-5px);
		}

		/* Logo Styles */
		.logo {
			height: 80px;
			width: auto;
			margin-right: 20px;
		}

		/* Flex Container */
		.flexContainer {
			display: flex;
		}

		.flexContainer .cont {
			width: 100%;
		}

		/* Center Content */
		.center-content {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100%;
			/* Ensure full height */
		}

		/* Mobile View Adjustments */
		@media (max-width: 768px) {
			.modal-content {
				max-width: 75%;
				max-height: 75vh;
			}

			.close {
				font-size: 30px;
				/* Adjust the close button size for smaller screens */
			}
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
					<h1>Cultural Activity</h1>
				</div>
				<p style="margin-top:5px;">
					<span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
					<span class="b-active"><a href="">Cultural Activity</a></span>
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
						<a href="https://kalaamanjari.gmiu.edu.in/" target="_blank">
							<div class="card backColor">
								<h4 class="gradText"><br> KALAMANJARI <i class="fa fa-external-link">
									</i>
								</h4>
							</div>
						</a>
					</section>
			</section>
			<section class="placed-students">
				<div class="buttons-container-flex" style="padding: 10px;"> <?php
																			//code for getting year buttons by grouping year in placement table
																			$cmd = "SELECT YEAR(date) FROM tbl_campus WHERE is_active = 1 AND is_delete = 0 AND type_id = 11 GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
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
										?>
				</div>
			</section>
			<!-- Faculty about  -->
			<section class="events-list-03">
				<div class="container"> <?php
										//code for getting year buttons by grouping year in placement table
										$cmd6 = "SELECT YEAR(date) FROM tbl_campus WHERE is_active = 1 AND is_delete = 0 and type_id = 11 GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
										$stmt6 = $con->prepare($cmd6);
										$stmt6->execute();
										$result6 = $stmt6->get_result();

										while ($row6 = $result6->fetch_assoc()) {
											$sem_c = $row6['YEAR(date)'];
										?> <div class="row event-body-content semester-content" id="sem-<?php echo $sem_c; ?>" style="display: none;">
							<?php
											$cmd = $con->prepare("SELECT id , description  FROM tbl_campus WHERE type_id=11 AND is_active=1 AND is_delete=0 AND YEAR(date) = $sem_c");
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
												<h3 class="swiper-title" style="text-align: center; margin-bottom: 15px;">
														<?php
														// Get the CKEditor content
														$description = $row['description'];

														// Remove all HTML tags and only keep the text
														echo strip_tags($description);
														?>
													</h3>




													<div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; padding-bottom:0;height: 400px;" class="swiper swipermain mySwipers<?php echo $sp_id; ?>">
														<div class="swiper-wrapper">

															<?php
															$type = "culture";
															$cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp 
                                                                         WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
															$cmd1->bind_param("is", $sp_id, $type);
															$cmd1->execute();
															$result1 = $cmd1->get_result();
															if ($result1->num_rows > 0) {
																while ($row1 = $result1->fetch_assoc()) {
																	$file_name1 = $row1['sp_file_name'];
															?>

															<div class="swiper-slide">
																<img src="<?php echo $upload_website_admin_url . 'culture/' . $file_name1; ?>" alt = "<?php echo strip_tags($description); ?>">
															</div>

															<?php }
															} ?>
														</div>
														<div class="swiper-button-prev"></div>
														<div class="swiper-button-next"></div>
													</div>

													<div style="height:100px" thumbsSlider="" class="swiper mySwiper<?php echo $sp_id; ?>">
														<div class="swiper-wrapper"> <?php
																						$type = "culture";
																						$cmd2 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp 
                                                                         WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0");
																						$cmd2->bind_param("is", $sp_id, $type);
																						$cmd2->execute();
																						$result2 = $cmd2->get_result();
																						if ($result2->num_rows > 0) {
																							while ($row2 = $result2->fetch_assoc()) {
																								$file_name2 = $row2['sp_file_name'];
																						?> <div class="swiper-slide">
														<img src="<?php echo $upload_website_admin_url . 'culture/' . $file_name2; ?>" alt = "<?php echo strip_tags($description); ?>">
																    </div> <?php }
																						} ?>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div> <?php
												}
											}
											?>
						</div> <?php
										}
								?>
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
				</div>
			</section>
			<!-- </div> -->
		</div>
		<!-- left bar end  -->
		<!-- right bar start  --> <?php include "../campus/campussidebar.php"; ?>
		<!-- right bar end  -->
		<!--</div>-->
	</div>
	<div id="myModal" class="modal">
		<span class="close">&times;</span>
		<img class="modal-content" id="img01">
	</div>
	<!-- </div> -->
	<!-- Footer Area section --> <?php include "../include/importfooter.php"; ?>
	<!-- ./ End Footer Area -->
	<!-- Swiper JS -->
	<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
	<!-- Initialize Swiper --> <?php
								$cmd = $con->prepare("SELECT sp.id as sp_id, sp.description as sp_description FROM tbl_campus as sp  WHERE type_id=11 AND is_active=1 AND is_delete=0 ");

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
	<?php //include "../include/importjs.php"; 
	?>

	<script>
		function showSemester(semesterId) {
			var semesterDivs = document.querySelectorAll('.semester-content');
			var semesterButtons = document.querySelectorAll('.tabBtn');
			// Hide all semester divs
			for (var i = 0; i < semesterDivs.length; i++) {
				semesterDivs[i].style.display = 'none';
			}
			// Remove "active" class from all buttons
			for (var i = 0; i < semesterButtons.length; i++) {
				semesterButtons[i].classList.remove('tabBtn-active');
			}
			// Show selected semester div if it exists, otherwise show the first available semester div
			var semesterDiv = document.getElementById('sem-' + semesterId);
			if (!semesterDiv) {
				for (var i = 0; i < semesterDivs.length; i++) {
					if (semesterDivs[i].style.display !== 'none') {
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
		if (firstSemesterDiv) {
			var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
			showSemester(firstSemesterId);
		}
	</script>
	<script>
		// Get the modal
		var modal = document.getElementById("myModal");

		// Get the modal image element
		var modalImg = document.getElementById("img01");

		// Get all images inside the swiper
		var images = document.querySelectorAll(".swiper-slide img");

		// Loop through each image and add click event listener
		images.forEach(function(image) {
			image.addEventListener("click", function() {
				// Show the modal
				modal.style.display = "block";

				// Set the clicked image's source to the modal image
				modalImg.src = this.src;

				// Ensure the modal image dimensions fit within the modal
				modalImg.style.maxWidth = "100%";
				modalImg.style.maxHeight = "80vh"; // Constrain image height
				modalImg.style.objectFit = "contain"; // Keep aspect ratio
			});
		});

		// Close the modal when the user clicks on the close button
		var closeButton = document.querySelector(".close");

		closeButton.onclick = function() {
			modal.style.display = "none";
		};

		// Close the modal when the user clicks outside of the image
		window.onclick = function(event) {
			if (event.target == modalImg) {
				modal.style.display = "none";
			}
		};
	</script>
	<!-- ============================
    JavaScript Files
    ============================= -->
	<!-- jQuery --> <?php include '../include/importjs.php'; ?>
</body>

</html>