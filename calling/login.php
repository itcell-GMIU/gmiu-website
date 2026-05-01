<?php
date_default_timezone_set('Asia/Kolkata');
$currentTime = new DateTime();
$startTime = new DateTime('07:00:00'); // Allowed from
$endTime = new DateTime('18:00:00'); // Allowed till

// If current time is OUTSIDE allowed range
if ($currentTime < $startTime || $currentTime >= $endTime) {
	include 'software_closed.php';
	exit;
}

// LOGIC COPIED DIRECTLY FROM YOUR FIRST SCRIPT
include("../database/connect.php"); // Path adjusted for the new file structure
session_start();

if (isset($_SESSION['staff_id']) && strlen($_SESSION['staff_id']) > 0) {
	header("Location: index.php");
	exit();
}

if (isset($_POST['btn-login'])) { // This now works because name="btn-login" is added to the button

	// Using mysqli_real_escape_string as in the original script
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$role = mysqli_real_escape_string($con, $_POST['role']);

	// Exact prepared statement from the original script, using 'tbl_staff'
	$cmd = $con->prepare("SELECT role_id, `id` as staff_id, `email` as staff_email from tbl_staff WHERE email=? AND password=? AND role_id=? AND is_active=1 AND is_delete=0");
	$cmd->bind_param("ssi", $email, $password, $role);
	$cmd->execute();
	$ex = $cmd->get_result();

	if ($ex->num_rows == 1) {
		$row = mysqli_fetch_array($ex);

		$staff_id = $row['staff_id'];
		$role_id = $row['role_id'];
		// $_SESSION['staff_id'] = $staff_id;
		// $_SESSION['role_id'] = $role_id;
		$_SESSION['user'] = [
			'staff_id' => $staff_id,
			'role_id' => $role_id,
			'email' => $email
		];

		header("Location: otp-verification.php");
		exit();

		// $_SESSION['status'] = "Login Successfully";
		// $_SESSION['status_code'] = "success";
		// $_SESSION['status_redirect'] = 'index.php';
	} else {
		// Failed login: Insert attempt record
		$insert_attempt = $con->prepare("INSERT INTO tbl_login_attempts (staff_id, email) VALUES (?,?)");
		$insert_attempt->bind_param("is", $role, $email);
		$insert_attempt->execute();

		$_SESSION['status'] = "Invalid Username and Password";
		$_SESSION['status_code'] = "error";
		echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<?php include './include/head.php'; ?>
</head>

<body>
	<div class="login-wrap customscroll d-flex align-items-center flex-wrap justify-content-center pd-20">
		<div class="login-box bg-white box-shadow pd-30 border-radius-5">
			<img src="./src/images/logo-single.jpg" alt="login" class="login-img">
			<h2 class="text-center mb-30">Login</h2>
			<form method="POST" action="">
				<div class="input-group custom input-group-lg mb-3">
					<select class="form-control" name="role" required>
						<option value="">--Please select--</option>
						<?php
						// EXACT role query from the first script, using 'tbl_role'
						// $query = "SELECT id,name FROM tbl_role WHERE is_active = 1 and is_delete=0 and id IN (11,12,13,14,15,16,20,21,22,23,25,26)";
						$query = "SELECT id,name FROM tbl_role WHERE is_active = 1 and is_delete=0 AND id IN (11,12,22,57,14,13,16,15,21,25,59,60) ORDER BY FIELD(id,60,11,12,22,57,14,13,16,15,21,25,59)";
						$result = $con->query($query);
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
							}
						}
						?>
					</select>
					<div class="input-group-append custom">
						<span class="input-group-text"><i class="fa fa-users" aria-hidden="true"></i></span>
					</div>
				</div>

				<div class="input-group custom input-group-lg mb-3">
					<input type="email" class="form-control" name="email" placeholder="Email" required>
					<div class="input-group-append custom">
						<span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
					</div>
				</div>

				<div class="input-group custom input-group-lg mb-3">
					<input type="password" class="form-control" name="password" placeholder="**********" required>
					<div class="input-group-append custom">
						<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="input-group">
							<button type="submit" name="btn-login" class="btn btn-outline-primary btn-lg btn-block">Sign
								In</button>
						</div>
					</div>
				</div>
				<p style="color: red;">Note: If you are not receiving the email, please enter any value in the OTP field
					and press Enter, or refresh the page. Thank you for your cooperation — we are working to resolve
					this issue.</p>
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