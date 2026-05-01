<?php
include './include/config.php';

if ($role_id == 57 || $role_id == 12 || $role_id == 11 || $role_id == 60) {

	$sql = "
    SELECT
        COUNT(*) AS total_inquiries,

        -- Inquiry sources
        SUM(CASE WHEN is_online = 6 THEN 1 ELSE 0 END) AS confidential,
        SUM(CASE WHEN is_online = 1 THEN 1 ELSE 0 END) AS website,
        SUM(CASE WHEN is_online = 2 THEN 1 ELSE 0 END) AS whatsapp,
        SUM(CASE WHEN is_online = 3 THEN 1 ELSE 0 END) AS other_source,
        SUM(CASE WHEN is_online = 4 THEN 1 ELSE 0 END) AS walkin,
        SUM(CASE WHEN is_online = 5 THEN 1 ELSE 0 END) AS email,
";

	if ($role_id == 11 || $role_id == 60) {
		// Super admin / lead manager
		$sql .= "
        SUM(
            CASE 
                WHEN staff_id IS NOT NULL 
                     AND staff_id != '' 
                     AND assign_by != '' 
                THEN 1 ELSE 0 
            END
        ) AS assigned_lead_manager,
    ";
	} else {
		// Staff-specific assignments
		$sql .= "
        SUM(
            CASE 
                WHEN staff_id IS NOT NULL 
                     AND staff_id != '' 
                     AND assign_by = {$staff_id}
                THEN 1 ELSE 0 
            END
        ) AS assigned_lead_manager,
    ";
	}

	$sql .= "
        -- Remaining & status counts
        SUM(
            CASE 
                WHEN (staff_id IS NULL OR staff_id = '') 
                     AND assign_by = 0 
                THEN 1 ELSE 0 
            END
        ) AS remaining,

        SUM(CASE WHEN is_admission_confirm = 1  THEN 1 ELSE 0 END) AS confirmed,
        SUM(CASE WHEN is_admission_confirm = -1 THEN 1 ELSE 0 END) AS rejected,
        SUM(CASE WHEN is_closed = 1 THEN 1 ELSE 0 END) AS closed_inquiry

    FROM tbl_inquiry_student
    WHERE is_active = 1
      AND is_delete = 0
";


	$result = mysqli_query($con, $sql);
	$stats = mysqli_fetch_assoc($result);
} elseif ($role_id == 16 || $role_id == 15) {
	$sql = "SELECT
			-- ASSIGNMENTS
			SUM(CASE 
				WHEN tis.staff_id = $staff_id THEN 1 
				ELSE 0 
			END) AS total_assigned,

			(
				SELECT COALESCE(SUM(tial.total), 0)
				FROM tbl_inquiry_assign_log tial
				WHERE tial.staff_id = $staff_id
				AND tial.created_at >= NOW() - INTERVAL 1 DAY
			) AS today_assigned,

			-- CONFIRMATIONS
			SUM(CASE 
				WHEN tis.confirm_by = $staff_id THEN 1 
				ELSE 0 
			END) AS total_confirmed_by_you,

			SUM(CASE 
				WHEN tis.confirm_by = $staff_id 
				AND tis.confirm_on >= CURDATE()
				AND tis.confirm_on < CURDATE() + INTERVAL 1 DAY
				THEN 1 
				ELSE 0 
			END) AS today_confirmed_by_you,

			-- CALLS
			(
				SELECT COUNT(*)
				FROM tbl_inquiry_call_logs ticl
				WHERE ticl.call_by = $staff_id
				AND ticl.is_active = 1
				AND ticl.is_delete = 0
			) AS total_call_count,

			-- CLOSED
			SUM(CASE WHEN tis.is_closed = 1 AND tis.closed_by = $staff_id THEN 1 ELSE 0 END) AS closed_inquiry

		FROM tbl_inquiry_student tis
		WHERE tis.is_active = 1
		AND tis.is_delete = 0
    ";

	$result = mysqli_query($con, $sql);
	$stats = mysqli_fetch_assoc($result);
} elseif ($role_id == 13) {
	$sql = "SELECT
        COUNT(*) AS total_walkin,
        SUM(
            CASE 
                WHEN created_at >= CURDATE()
                AND created_at < CURDATE() + INTERVAL 1 DAY
                THEN 1 ELSE 0
            END
        ) AS today_walkin
    FROM tbl_inquiry_student
    WHERE is_online = 4
    AND is_active = 1
    AND is_delete = 0";

	$result = mysqli_query($con, $sql);
	$walkin = mysqli_fetch_assoc($result);

} elseif ($role_id == 14) {
 
    if (empty($u_staff_id) || $u_staff_id == 'NA') {
        
            $walkin = [
                'assigned_inquiry' => 0,
                'approved_inquiry' => 0,
                'rejected_inquiry' => 0,
                'closed_inquiry' => 0
            ];
    } else {
        	$sql = "SELECT
        			(
        				SELECT COUNT(*)
        				FROM tbl_inquiry_student
        				WHERE staff_id IN ($u_staff_id)
        			) AS assigned_inquiry,
        
        			(
        				SELECT COUNT(*)
        				FROM tbl_inquiry_student
        				WHERE confirm_by IN ($u_staff_id)
        				AND is_admission_confirm = 1
        			) AS approved_inquiry,
        
        			(
        				SELECT COUNT(*)
        				FROM tbl_inquiry_student
        				WHERE staff_id IN ($u_staff_id)
        				AND is_admission_confirm = -1
        			) AS rejected_inquiry,
        
        			(
        				SELECT COUNT(*)
        				FROM tbl_inquiry_student
        				WHERE closed_by IN ($u_staff_id)
        				AND is_closed = 1
        			) AS closed_inquiry
        		";
        
        	$result = mysqli_query($con, $sql);
        	$walkin = mysqli_fetch_assoc($result);
        }
} elseif ($role_id == 25) {
	$sql = "SELECT 
			(SELECT COUNT(*)
			FROM tbl_daily_task
			WHERE staff_id = 1
				AND is_active = 1
				AND is_delete = 0
			) AS total_daily_task,

			(SELECT COUNT(*)
			FROM tbl_daily_task
			WHERE staff_id = 1
				AND is_active = 1
				AND is_delete = 0
				AND created_at >= CURDATE()
				AND created_at < CURDATE() + INTERVAL 1 DAY
			) AS total_today_daily_task";

	$result = mysqli_query($con, $sql);
	$walkin = mysqli_fetch_assoc($result);
}
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

			<?php if ($role_id == 57 || $role_id == 12 || $role_id == 11 || $role_id == 60) { ?>
				<div class="row">

					<!-- TOTAL -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-primary-light">
									<i class="fas fa-users text-primary"></i>
								</div>
								<div>
									<p>Total Inquiries</p>
									<h3><?= $stats['total_inquiries'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- CONFIDENTIAL -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-warning-light">
									<i class="fas fa-lock text-warning"></i>
								</div>
								<div>
									<p>Confidential</p>
									<h3><?= $stats['confidential'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- WEBSITE -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-info-light">
									<i class="fas fa-globe text-info"></i>
								</div>
								<div>
									<p>Website</p>
									<h3><?= $stats['website'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- WHATSAPP -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-success-light">
									<i class="fab fa-whatsapp text-success"></i>
								</div>
								<div>
									<p>WhatsApp</p>
									<h3><?= $stats['whatsapp'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- OTHER SOURCE -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-primary-light">
									<i class="fas fa-random text-primary"></i>
								</div>
								<div>
									<p>Other Source</p>
									<h3><?= $stats['other_source'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- WALK-IN -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-warning-light">
									<i class="fas fa-walking text-warning"></i>
								</div>
								<div>
									<p>Walk-In</p>
									<h3><?= $stats['walkin'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- EMAIL -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-info-light">
									<i class="fas fa-envelope text-info"></i>
								</div>
								<div>
									<p>Email</p>
									<h3><?= $stats['email'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- ASSIGNED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-primary-light">
									<i class="fas fa-user-check text-primary"></i>
								</div>
								<div>
									<p>Assigned <?php echo ($role_id == 11) ? '' : 'By You'; ?></p>
									<h3><?= $stats['assigned_lead_manager'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- REMAINING -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-warning-light">
									<i class="fas fa-user-clock text-warning"></i>
								</div>
								<div>
									<p>Remaining</p>
									<h3><?= $stats['remaining'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- CONFIRMED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-success-light">
									<i class="fas fa-check-circle text-success"></i>
								</div>
								<div>
									<p>Total Confirmed</p>
									<h3><?= $stats['confirmed'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- REJECTED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-danger-light">
									<i class="fas fa-times-circle text-danger"></i>
								</div>
								<div>
									<p>Total Rejected</p>
									<h3><?= $stats['rejected'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- CLOSED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-dark-light">
									<i class="fas fa-lock text-dark"></i>
								</div>
								<div>
									<p>Total Closed</p>
									<h3><?= $stats['closed_inquiry'] ?></h3>
								</div>
							</div>
						</div>
					</div>

				</div>
			<?php } elseif ($role_id == 16 || $role_id == 15) { ?>
				<div class="row">

					<!-- TOTAL ASSIGNED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-primary-light">
									<i class="fas fa-user-check text-primary"></i>
								</div>
								<div>
									<p>Total Assigned</p>
									<h3><?= $stats['total_assigned'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- TODAY ASSIGNED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-info-light">
									<i class="fas fa-calendar-day text-info"></i>
								</div>
								<div>
									<p>Assigned Today</p>
									<h3><?= $stats['today_assigned'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- TOTAL CONFIRMED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-success-light">
									<i class="fas fa-check-circle text-success"></i>
								</div>
								<div>
									<p>Total Confirmed</p>
									<h3><?= $stats['total_confirmed_by_you'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- TODAY CONFIRMED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-success-light">
									<i class="fas fa-calendar-check text-success"></i>
								</div>
								<div>
									<p>Confirmed Today</p>
									<h3><?= $stats['today_confirmed_by_you'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- TOTAL CALLS -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-warning-light">
									<i class="fas fa-phone-alt text-warning"></i>
								</div>
								<div>
									<p>Total Calls</p>
									<h3><?= $stats['total_call_count'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- CLOSED -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-dark-light">
									<i class="fas fa-lock text-dark"></i>
								</div>
								<div>
									<p>Total Closed</p>
									<h3><?= $stats['closed_inquiry'] ?></h3>
								</div>
							</div>
						</div>
					</div>

				</div>
			<?php } elseif ($role_id == 13) { ?>
				<div class="row">

					<!-- TOTAL WALK-IN -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-warning-light">
									<i class="fas fa-walking text-warning"></i>
								</div>
								<div>
									<p>Total Walk-In Inq.</p>
									<h3><?= $walkin['total_walkin'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- TODAY WALK-IN -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-success-light">
									<i class="fas fa-calendar-day text-success"></i>
								</div>
								<div>
									<p>Today Walk-In Inq.</p>
									<h3><?= $walkin['today_walkin'] ?></h3>
								</div>
							</div>
						</div>
					</div>

				</div>
			<?php } elseif ($role_id == 14) { ?>

				<div class="row">

					<!-- ASSIGNED INQUIRY -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-primary-light">
									<i class="fas fa-user-check text-primary"></i>
								</div>
								<div>
									<p>Assigned Inquiry</p>
									<h3><?= $walkin['assigned_inquiry'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- APPROVED INQUIRY -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-success-light">
									<i class="fas fa-check-circle text-success"></i>
								</div>
								<div>
									<p>Approved Inquiry</p>
									<h3><?= $walkin['approved_inquiry'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- REJECTED INQUIRY -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-danger-light">
									<i class="fas fa-times-circle text-danger"></i>
								</div>
								<div>
									<p>Rejected Inquiry</p>
									<h3><?= $walkin['rejected_inquiry'] ?></h3>
								</div>
							</div>
						</div>
					</div>

					<!-- CLOSED INQUIRY -->
					<div class="col-xl-3 col-md-6 mb-4">
						<div class="stat-card-v2">
							<div class="stat-left">
								<div class="stat-icon bg-secondary-light">
									<i class="fas fa-lock text-secondary"></i>
								</div>
								<div>
									<p>Closed Inquiry</p>
									<h3><?= $walkin['closed_inquiry'] ?></h3>
								</div>
							</div>
						</div>
					</div>

				</div>



			<?php }
			if ($role_id == 22 || $role_id == 60) { ?>
				<div class="row">

					<!-- Call Report -->
					<div class="col-xl-3 col-md-6 mb-4">
						<a href="call_report.php" class="text-decoration-none text-dark">
							<div class="stat-card-v2 clickable-card">
								<div class="stat-left">
									<div class="stat-icon bg-primary-light">
										<i class="fas fa-phone-alt text-primary"></i>
									</div>
									<div>
										<p>Call Report</p>
										<h3></h3>
									</div>
								</div>
							</div>
						</a>
					</div>

					<!-- Daily Task Report -->
					<div class="col-xl-3 col-md-6 mb-4">
						<a href="dailytask-report.php" class="text-decoration-none text-dark">
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
					</div>

					<!-- Daily Task Remark -->
					<div class="col-xl-3 col-md-6 mb-4">
						<a href="dailytask-remark.php" class="text-decoration-none text-dark">
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
					</div>

					<!-- Marketing Visit -->
					<div class="col-xl-3 col-md-6 mb-4">
						<a href="marketing-visit-report.php" class="text-decoration-none text-dark">
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
					</div>

				</div>

			<?php } ?>
		</div>
	</div>

	<?php include('./include/script.php'); ?>
</body>

</html>

<!-- CREATE TABLE tbl_inquiry_calling_short_remarks (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	remark VARCHAR(255) NOT NULL,
	category VARCHAR(100) DEFAULT NULL,
	is_active TINYINT(1) NOT NULL DEFAULT 1,
	is_delete TINYINT(1) NOT NULL DEFAULT 0,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); -->