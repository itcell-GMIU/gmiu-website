<?php
session_start();
include '../../database/connect.php';
include '../../common/validation.php';

// Define variables and initialize with empty values
$email_error = $password_error = $role_error = "";
$email = $password = $role = "";


if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $password = mysqli_real_escape_string($con, $_POST['password']);

    $role = mysqli_real_escape_string($con, $_POST['role']);

    if ($role == "8") {

        if (empty($role)) {
            $role_error = "Please Select a Role";
        } else {
            $role = filterString($role);
            if ($role == FALSE) {
                $role_error = "Please Select a Role";
            }
        }

        if (empty($email)) {
            $mobile_number_error = "Please enter your Mobile Number";
        } else {
            $email = filterString($email);
            if ($email == FALSE) {
                $mobile_number_error = "Please enter a valid Mobile Number";
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
        if (empty($mobile_number_error) && empty($password_error) && empty($role_error)) {

            $cmd = $con->prepare("SELECT `role_id`, `id`, `email`, `password` from tbl_staff WHERE role_id = ? AND email=? AND password= ? AND is_active=1 AND is_delete=0");
            $cmd->bind_param("iss", $role, $email, $password);
            $cmd->execute();
            $ex = $cmd->get_result();
            if ($ex->num_rows == 1) {

                while ($row = mysqli_fetch_array($ex)) {

                    $role_id = $row['role_id'];
                    $web_admin_id = $row['id'];
                    $_SESSION['web_admin_id'] = $web_admin_id;
                    $_SESSION['role_id'] = $role_id;
                }

                //echoalert("Login Successfull");
                $_SESSION['status'] = "Login Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='dashboard.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Invalid Username and Password";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
            }
        }
    } else {
        if (empty($role)) {
            $role_error = "Please Select a Role";
        } else {
            $role = filterString($role);
            if ($role == FALSE) {
                $role_error = "Please Select a Role";
            }
        }

        if (empty($email)) {
            $mobile_number_error = "Please enter your Mobile Number";
        } else {
            $email = filterString($email);
            if ($email == FALSE) {
                $mobile_number_error = "Please enter a valid Mobile Number";
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
        if (empty($mobile_number_error) && empty($password_error) && empty($role_error)) {

            $cmd = $con->prepare("SELECT `role_id`, `id`, `email`, `password` from tbl_admin WHERE role_id = ? AND email=? AND password= ? AND is_active=1 AND is_delete=0");
            $cmd->bind_param("iss", $role, $email, $password);
            $cmd->execute();
            $ex = $cmd->get_result();
            if ($ex->num_rows == 1) {

                while ($row = mysqli_fetch_array($ex)) {

                    $role_id = $row['role_id'];
                    $web_admin_id = $row['id'];
                    $_SESSION['web_admin_id'] = $web_admin_id;
                    $_SESSION['role_id'] = $role_id;
                }

                //echoalert("Login Successfull");
                $_SESSION['status'] = "Login Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='dashboard.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Invalid Username and Password";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
            }
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <style>
        .login-page {
            background-image: linear-gradient(0deg,
                    rgba(1, 1, 1, 0.8),
                    rgba(1, 1, 1, 0.3)), url('../../admin_assets/images/clg\ bg\ new.webp');
            background-size: cover;
        }

        .card-outline {
            border-top: 3px solid #ba2a21;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div id="status">&nbsp;
        </div>
    </div>
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->

            <div class="card card-outline">
                <div class="card-header text-center">
                    <a href="./index.php" class="h3"><b>GMIU Website Portal</b></a>
                </div>
                <div class="card-body">
                    <!-- <p class="login-box-msg">Log in to start your session</p> -->

                    <form method="POST" id="quickForm">

                        <div class="input-group mb-3">

                            <select name="role" class="browser-default custom-select" required>
                                <option value="">--Please select--</option>
                                <?php
                                $query = "SELECT id,name FROM tbl_role WHERE is_active = 1 and is_delete=0 and id IN(5,6,8,9,10,11)";
                                $result = $con->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                    }
                                }
                                ?>

                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" name="login" class="btn btn-primary btn-block" style="background-color: #ba2a21;">Log In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <!-- /.login-box -->

    <?php include '../include/importjs.php'; ?>
</body>



</html>