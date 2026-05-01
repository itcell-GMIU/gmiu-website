<?php
include './include/config.php';
?>
<?php
$count = mysqli_query($con, "SELECT COUNT(*) AS total FROM m_registrations WHERE is_active = 1 AND is_delete = 0");
$totalRegistrations = mysqli_fetch_assoc($count)['total'] ?? 0;
?>

<!DOCTYPE html>
<html>

<head>
	<?php include('./include/head.php'); ?>
	<style>
		.stat-card-v2 {
			background: #ffffff;
			border-radius: 12px;
			padding: 18px 20px;
			box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
			transition: all 0.25s ease;
			border: 1px solid #f1f1f1;
		}

		.stat-card-v2:hover {
			transform: translateY(-3px);
			box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
		}

		.stat-left {
			display: flex;
			align-items: center;
			gap: 15px;
		}

		.stat-icon {
			width: 48px;
			height: 48px;
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 20px;
		}

		.bg-primary-light {
			background: rgba(0, 123, 255, .12);
		}

		.bg-warning-light {
			background: rgba(255, 193, 7, .15);
		}

		.bg-success-light {
			background: rgba(40, 167, 69, .15);
		}

		.bg-danger-light {
			background: rgba(220, 53, 69, .15);
		}

		.bg-dark-light {
			background: rgba(0, 0, 0, .15);
		}

		.bg-info-light {
			background: rgba(23, 162, 184, .15);
		}

		.stat-left p {
			margin: 0;
			font-size: 13px;
			color: #6c757d;
			font-weight: 500;
		}

		.stat-left h3 {
			margin: 2px 0 0;
			font-size: 26px;
			font-weight: 700;
			color: #212529;
		}
	</style>
</head>

<body>
	<?php include('./include/header.php'); ?>
	<?php include('./include/sidebar.php'); ?>

	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">


			<div class="row">

				<!-- Total Registered Students -->
				<div class="col-xl-3 col-md-6 mb-4">
					<a href="#" class="text-decoration-none text-dark">
						<div class="stat-card-v2 clickable-card">
							<div class="stat-left">
								<div class="stat-icon bg-primary-light">
									<i class="fas fa-user text-primary"></i>
								</div>
								<div>
									<p>Total Registered Students</p>
									<h3>
										<?php echo $totalRegistrations; ?>
									</h3>
								</div>
							</div>
						</div>
					</a>
				</div>

				<!-- Daily Task Report -->
				<!-- <div class="col-xl-3 col-md-6 mb-4">
					<a href="#" class="text-decoration-none text-dark">
						<div class="stat-card-v2 clickable-card">
							<div class="stat-left">
								<div class="stat-icon bg-success-light">
									<i class="fas fa-tasks text-success"></i>
								</div>
								<div>
									<p>Daily Task Report</p>
									<h3></h3>
								</div>
							</div>
						</div>
					</a>
				</div> -->

				<!-- Daily Task Remark -->
				<!-- <div class="col-xl-3 col-md-6 mb-4">
					<a href="#" class="text-decoration-none text-dark">
						<div class="stat-card-v2 clickable-card">
							<div class="stat-left">
								<div class="stat-icon bg-danger-light">
									<i class="fas fa-comment-dots text-danger"></i>
								</div>
								<div>
									<p>Daily Task Remark</p>
									<h3></h3>
								</div>
							</div>
						</div>
					</a>
				</div> -->

				<!-- Marketing Visit -->
				<!-- <div class="col-xl-3 col-md-6 mb-4">
					<a href="#" class="text-decoration-none text-dark">
						<div class="stat-card-v2 clickable-card">
							<div class="stat-left">
								<div class="stat-icon bg-secondary-light">
									<i class="fas fa-map-marked-alt text-secondary"></i>
								</div>
								<div>
									<p>Marketing Visit</p>
									<h3></h3>
								</div>
							</div>
						</div>
					</a>
				</div> -->

			</div>

		</div>
	</div>
	<?php include('./include/script.php'); ?>
</body>

</html>