<?php
// LOGIC COPIED DIRECTLY FROM YOUR FIRST SCRIPT
session_start();
include("./include/db.php"); // Path adjusted for the new file structure

if (isset($_SESSION['staff_id']) && strlen($_SESSION['staff_id']) > 0) {
	header("Location: index.php");
	exit();
}

if (isset($_POST['btn-login'])) { // This now works because name="btn-login" is added to the button

	// Using mysqli_real_escape_string as in the original script
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);

	// Exact prepared statement from the original script, using 'tbl_staff'
	$cmd = $con->prepare("SELECT * FROM tbl_admin WHERE email=? AND password=? AND role_id = 3 AND is_active=1 AND is_delete=0");
	$cmd->bind_param("ss", $email, $password);
	$cmd->execute();
	$ex = $cmd->get_result();

	if ($ex->num_rows == 1) {
		$row = mysqli_fetch_array($ex);

		$_SESSION['staff_id'] = $row['id'];
		$_SESSION['user_email'] = $row['email'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['role_id'] = $row['role_id'];
		$_SESSION['role_name'] = $row['name'];


		$_SESSION['status'] = "Login Successfully";
		$_SESSION['status_code'] = "success";
		$_SESSION['status_redirect'] = 'index.php';
	} else {

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