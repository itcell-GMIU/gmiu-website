<?php
include("../../database/connect.php");
session_start();
// check hidden filed for bot to prevent multiple entry

if (isset($_POST['btn-login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $role = mysqli_real_escape_string($con, $_POST['role']);

    $cmd = $con->prepare("SELECT role_id, `id` as staff_id, `email` as staff_email from tbl_staff  WHERE email=? AND password= ? AND role_id= ? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("ssi", $email, $password, $role);
    $cmd->execute();
    $ex = $cmd->get_result();
    if ($ex->num_rows == 1) {

        $row = mysqli_fetch_array($ex);

        $staff_id = $row['staff_id'];
        $role_id = $row['role_id'];
        $_SESSION['staff_id'] = $staff_id;
        $_SESSION['role_id'] = $role_id;
       

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

?>
<!DOCTYPE html>
<html oncontextmenu="return false">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GMIU Staff Login | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../admin_assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../admin_assets/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <style>
        .login-page {
            background-image: linear-gradient(0deg,
                    rgba(1, 1, 1, 0.8),
                    rgba(1, 1, 1, 0.3)), url('../../admin_assets/images/clg\ bg\ new.webp');
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
        <div class="card card-outline">
            <div class="card-body login-card-body">
                <div class="login-logo">
                    <h2>GMIU EXAM PORTAL</h2>
                </div>
                <!-- <p class="login-box-msg"></p> -->

                <form action="" method="POST">

                    <div class="input-group mb-3">

                        <select name="role" class="browser-default custom-select" required>
                            <option value="">--Please select--</option>
                            <?php
                            $query = "SELECT id,name FROM tbl_role WHERE is_active = 1 and is_delete=0 and id IN (51) ";
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
                        <input type="text" class="form-control" name="email" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <!--<span class="fas fa-envelope"></span>-->
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="social-auth-links text-center mb-3">

                        <button type="submit" class="btn btn-primary btn-block" name="btn-login" style="background-color: #ba2a21;">Log In</button>

                    </div>
                    <!-- /.social-auth-links -->


            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <!-- jQuery -->
    <script src="../../admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../admin_assets/dist/js/adminlte.min.js"></script>

    <script src="../../admin_assets/js/custom.js"></script>
    <?php

    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    ?>
        <script>
            swal({
                title: "<?php echo $_SESSION['status']; ?>",
                // text: "You clicked the button!",
                icon: "<?php echo $_SESSION['status_code']; ?>",
                // button: "Ok!",
            });
        </script>
    <?php
        unset($_SESSION['status']);
    }
    ?>

</body>

</html>