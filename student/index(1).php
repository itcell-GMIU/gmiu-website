<?php
session_start();
include '../database/connect.php';
include '../common/validation.php';

// Define variables and initialize with empty values
$gr_number_error = $password_error = "";
$gr_number = $password = "";



if (isset($_POST['login'])) {

    $gr_number = mysqli_real_escape_string($con, $_POST['gr_number']);

    $password = mysqli_real_escape_string($con, $_POST['password']);

    if (empty($gr_number)) {
        $gr_number_error = "Please enter your GR Number";
    } else {
        $gr_number = filterString($gr_number);
        if ($gr_number == FALSE) {
            $gr_number_error = "Please enter a valid GR Number";
        }
    }

    if (empty($password)) {
        $password_error = "Please Enter Your Password.";
    } else {
        $password = filterString($password);
        if ($password == FALSE) {
            $password_error = "Please Enter valid Password";
        }
    }

    if (isset($_POST['login'])) {
        // ... your existing code ...

        // CAPTCHA validation
        $userCaptcha = $_POST['captcha'];
        $actualCaptcha = $_SESSION['captcha_code'];

        if ($userCaptcha !== $actualCaptcha) {
            $_SESSION['status'] = "CAPTCHA verification failed.";
            $_SESSION['status_code'] = "error";
            header("Location: index.php");
            exit();
        }
    }
    if (empty($gr_number_error) && empty($password_error)) {

        $cmd = $con->prepare("SELECT stu.id as student_id,stu.first_name,stu.last_name, enrollnment_no from tbl_students_2023 as stu
       WHERE enrollnment_no=? AND password= ? AND is_active=1 AND is_delete=0");
        $cmd->bind_param("ss", $gr_number, $password);
        $cmd->execute();
        $ex = $cmd->get_result();
        if ($ex->num_rows == 1) {

            $row = mysqli_fetch_array($ex);

            $student_id = $row['student_id'];
            $enrollnment_no = $row['enrollnment_no'];
            $_SESSION['student_id'] = $student_id;
            $_SESSION['secretkey'] = "secret";

            if (!(empty($enrollnment_no))) {
                $_SESSION['status'] = "Logged In Successfully.";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='dashboard.php'},1000)</script>";
            } else {
                $_SESSION['status'] = "Logged In Successfully.";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='dashboard.php'},1000)</script>";
            }
        } else {
            $_SESSION['status'] = "Invalid Username or Password.";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='index.php'},1000)</script>";
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
        .login-page {
            background-image: linear-gradient(0deg,
                    rgba(1, 1, 1, 0.8),
                    rgba(1, 1, 1, 0.3)), url('../admin_assets/images/clg\ bg\ new.webp');
            background-size: cover;
        }

        .login-logo {
            color: black;
        }

        .card-outline {
            border-top: 3px solid #ba2a21;
        }

        .card-body {
            border-radius: 10px;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-danger">
            <div class="card-header text-center">
                <h3><b>GMIU STUDENT PORTAL</b></h3>
            </div>
            <div class="card-body">
                <!-- <p class="login-box-msg">Log in to start your session</p> -->

                <form method="POST" id="quickForm">
                    <div class="input-group mb-3">
                        <input type="text" name="gr_number" class="form-control" placeholder="Enter Enrollnment Number" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-edit"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-lock"></span>
                            </div>
                        </div>
                    </div>

                    <!-- CAPTCHA -->
                    <div class="input-group mb-3">
                        <input type="text" name="captcha" class="form-control" placeholder="Enter CAPTCHA" required>
                        <div class="input-group-append">
                            <img src="captcha.php" alt="CAPTCHA Image" id="captcha-img">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="login" class="btn btn-danger btn-block">Log In</button>
                        </div>
                    </div>
                </form>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <?php include 'include/importjs.php'; ?>
</body>



</html>