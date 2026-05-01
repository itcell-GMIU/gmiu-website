<?php
include './include/checklogin.php';


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

        $stmt = $con->prepare("SELECT password FROM tbl_students_2023 WHERE id =  $student_id");
        $stmt->execute();
        $ex = $stmt->get_result();
        $row = mysqli_fetch_array($ex);
        

        if ($current_password == $row['password']) {

            if ($new_password == $confirm_password) {

                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $stmt = $con->prepare("UPDATE tbl_students_2023 SET password = ?  WHERE id = ?");
                $stmt->bind_param("si", $new_password,  $student_id);
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
            echo "<script>setTimeout(function(){window.location='change_password.php'},1000)</script>";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>

    <style>
        .login{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Profile Settings</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                                <div class="container">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="" class="learnpro-register-form text-center" method="POST">
                                                <p class="lead"><i class="nav-icon fa-solid fa-key"></i> Change Password</p>
                                                <div class="form-group">
                                                    <input autocomplete="off" class="required form-control" placeholder="Current Password *" name="current_password" type="password" maxlength="20" minlength="6" required>
                                                </div>
                                                <div class="form-group">
                                                    <input class="required form-control" placeholder="New Password *" name="new_password" type="password" maxlength="20" minlength="6" required>
                                                </div>
                                                <div class="form-group">
                                                    <input class="required form-control" placeholder="Confirm Password *" name="confirm_password" type="password" maxlength="20" minlength="6" required>
                                                </div>
                                                <div class="form-group register-btn">
                                                    <button type="submit" name="submit" class="btn btn-primary btn-lg">Update
                                                        Password</button>
                                                </div>
                                                <!-- <a href="forgot_password.html"><strong>Forgot password?</strong></a>		
					<p>Not a member? <a href="register.html"><strong>Join today</strong></a></p>	 -->
                                            </form>
                                        </div>
                                    </div>
                                </div>
            </div>
            <!-- /.content-header -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>
</body>

</html>