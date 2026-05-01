<?php
include 'include/checklogin.php';


$current_password_error = $new_password_error = $confirm_password_error = "";
$current_password = $new_password = $confirm_password = "";

if (isset($_POST['submit'])) {

	$current_password = mysqli_real_escape_string($con, $_POST['current_password']);
	$new_password = mysqli_real_escape_string($con, $_POST['new_password']);
	$confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

	if (empty($current_password)) {
		$current_password_error = "Please Enter Your Password.";
	} else {
		$current_password = filterString($current_password);
		if ($current_password == FALSE) {
			$current_password_error = "Please Enter valid Password";
		}
	}

	if (empty($new_password)) {
		$new_password_error = "Please Enter Your Password.";
	} else {
		$new_password = filterString($new_password);
		if ($new_password == FALSE) {
			$new_password_error = "Please Enter valid Password";
		}
	}

	if (empty($confirm_password)) {
		$confirm_password_error = "Please Enter Your Password.";
	} else {
		$confirm_password = filterString($confirm_password);
		if ($confirm_password == FALSE) {
			$confirm_password_error = "Please Enter valid Password";
		}
	}

	if (empty($current_password_error) && empty($new_password_error) && empty($confirm_password_error)) {

		$stmt = $con->prepare("SELECT password FROM tbl_admission_student WHERE id = $student_id");
		$stmt->execute();
		$ex = $stmt->get_result();
		$row = mysqli_fetch_array($ex);

		if ($current_password == $row['password']) {

			if ($new_password == $confirm_password) {

				$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

				$stmt = $con->prepare("UPDATE tbl_admission_student SET password = ?  WHERE id = ?");
				$stmt->bind_param("si", $new_password, $student_id);
				if ($stmt->execute()) {
					$_SESSION['status'] = "Password Changed Successfully.";
					$_SESSION['status_code'] = "success";
					echo "<script>setTimeout(function(){window.location='logout.php'},1000)</script>";
				} else {
					$_SESSION['status'] = "Password Not Changed.";
					$_SESSION['status_code'] = "error";
					echo "<script>setTimeout(function(){window.location='change_password.php'},1000)</script>";
				}
			} else {

				$_SESSION['status'] = "New Password And Current Password Do Not Match.";
				$_SESSION['status_code'] = "error";
				echo "<script>setTimeout(function(){window.location='change_password.php'},1000)</script>";
			}
		} else {

			$_SESSION['status'] = "Please Enter Correct Current Password.";
			$_SESSION['status_code'] = "error";
			echo "<script>setTimeout(function(){window.location='../admission/change_password.php'},1000)</script>";
		}
	}
}


?>



<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>

<body>
    <!-- Preloader -->
    <!-- <div id="preloader">
	<div id="status">&nbsp;</div>
</div> -->
    <?php include 'include/importheader.php'; ?>



    <!-- Start Welcome Area section -->
    <div class="login">
        <section class="login-area">
            <div class="container">
                <div class="row">

                    <div class="col-sm-6 col-sm-offset-3">
                        <form action="" class="learnpro-register-form text-center" method="POST">
                            <p class="lead">Change Password</p>
                            <div class="form-group">
                                <input autocomplete="off" class="required form-control" placeholder="Current Password *"
                                    name="current_password" type="password" maxlength="20" minlength="6" required>
                            </div>
                            <div class="form-group">
                                <input class="required form-control" placeholder="New Password *" name="new_password"
                                    type="password" maxlength="20" minlength="6" required>
                            </div>
                            <div class="form-group">
                                <input class="required form-control" placeholder="Confirm Password *"
                                    name="confirm_password" type="password" maxlength="20" minlength="6" required>
                            </div>
                            <div class="form-group register-btn">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg">Update
                                    password</button>
                            </div>
                            <!-- <a href="forgot_password.html"><strong>Forgot password?</strong></a>		
					<p>Not a member? <a href="register.html"><strong>Join today</strong></a></p>	 -->
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- ./ End Welcome Area section -->


    <!-- ./ End Instraction Area section -->

    <!-- Footer Area section -->
    <?php include 'include/importfooter.php'; ?>
    <!-- ./ End Footer Area-->

    <!-- ============================
	JavaScript Files
	============================= -->
    <?php include 'include/importjs.php'; ?>
</body>

</html>