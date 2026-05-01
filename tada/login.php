<?php
// LOGIC COPIED DIRECTLY FROM YOUR FIRST SCRIPT
include __DIR__ . "/database/connect.php"; // Path adjusted for the local file structure
session_start();

if (isset($_POST['btn-login'])) { // This now works because name="btn-login" is added to the button

	// Set the timezone to IST (Indian Standard Time)
	date_default_timezone_set('Asia/Kolkata');
	$currentTime = new DateTime();

	// Set the restricted time range: 6:00 PM (18:00) to 7:00 AM
	$startTime = new DateTime('18:00:00');
	$endTime = new DateTime('07:00:00');

	// Check if the current time is between 6:00 PM and 7:00 AM
	// if ($currentTime >= $startTime || $currentTime < $endTime) {
	// 	$_SESSION['status'] = "Login is restricted between 6:00 PM and 7:00 AM.";
	// 	$_SESSION['status_code'] = "error";
	// 	echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
	// 	exit;
	// }

	// Using mysqli_real_escape_string as in the original script
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);

	// Authenticate using only email and password
	$cmd = $con->prepare("SELECT role_id, id as staff_id, email as staff_email, name as staff_name FROM tbl_staff WHERE email=? AND password=? AND is_active=1 AND is_delete=0");
	$cmd->bind_param("ss", $email, $password);
	$cmd->execute();
	$ex = $cmd->get_result();

	if ($ex->num_rows == 1) {
		$row = mysqli_fetch_array($ex);

		$_SESSION['staff_id'] = $row['staff_id'];
		$_SESSION['role_id'] = $row['role_id'];
		$_SESSION['name'] = $row['staff_name'];
		$_SESSION['user_email'] = $row['staff_email']; // Stores email for role-based UI checks

		$_SESSION['status'] = "Login Successfully";
		$_SESSION['status_code'] = "success";
		
		// Redirect logic based on role
		if ($row['role_id'] == 3) { // Role 3 is HOD
			$_SESSION['status_redirect'] = 'tada-form-view.php';
		} else {
			$_SESSION['status_redirect'] = 'index.php';
		}
	} else {
		// Failed login attempt
		$_SESSION['status'] = "Invalid Email or Password";
		$_SESSION['status_code'] = "error";
		echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<?php include './include/head.php'; ?>
	<style>
		.login-wrap {
			background: url('gyanmanjari-innovative-university.webp') no-repeat center center;
			background-size: cover;
			min-height: 100vh;
			width: 100%;
			position: relative;
		}

		.login-wrap::before {
			content: "";
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.4); /* Optional: add a dark overlay for better readability of the login box */
			z-index: 0;
		}

		.login-box {
			z-index: 1;
			position: relative;
			background: rgba(255, 255, 255, 0.9);
			backdrop-filter: blur(10px);
			border: 1px solid rgba(255, 255, 255, 0.2);
			box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
		}

		.login-box h2 {
			font-weight: 700;
			color: #333;
			text-transform: uppercase;
			letter-spacing: 1px;
		}

		.btn-primary {
			background: linear-gradient(45deg, #1b00ff, #00d4ff);
			border: none;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
			transition: all 0.3s ease;
		}

		.btn-primary:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
			background: linear-gradient(45deg, #00d4ff, #1b00ff);
		}
	</style>
</head>

<body>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center pd-20">
		<div class="login-box pd-30 border-radius-10">
			<img src="./src/images/logowithbg.png" alt="login" class="login-img" style="max-width: 100%; height: auto; margin-bottom: 20px; border-radius: 5px;">
			<h2 class="text-center mb-30">TADA Portal</h2>
			<form method="POST" action="">
				<div class="input-group custom input-group-lg mb-3">
					<input type="email" class="form-control" name="email" placeholder="Email Address" required>
					<div class="input-group-append custom">
						<span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
					</div>
				</div>

				<div class="input-group custom input-group-lg mb-3">
					<input type="password" class="form-control" name="password" placeholder="Password" required>
					<div class="input-group-append custom">
						<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="input-group">
							<button type="submit" name="btn-login" class="btn btn-primary btn-lg btn-block">Sign In</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php include './include/script.php'; // This should include the SweetAlert library ?>

	<?php
	if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
		?>
		<script>
			swal({
				title: "<?php echo addslashes($_SESSION['status']); ?>",
				icon: "<?php echo addslashes($_SESSION['status_code']); ?>",
			});
		</script>
		<?php
		unset($_SESSION['status']);
		unset($_SESSION['status_code']);
	}
	?>
</body>

</html>
<?php $con->close(); ?>