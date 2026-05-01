<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
include '../../../database/connect.php'; // Include your database connection file
include '../../../common/validation.php';

// Define variables and initialize with empty values
$email_error = $password_error = "";
$email = $password = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Validate email
    if (empty($email)) {
        $email_error = "Please enter your Email Address";
    } else {
        $email = filterString($email);
        if ($email == FALSE) {
            $email_error = "Please enter a valid Email Address";
        }
    }

    // Validate password
    if (empty($password)) {
        $password_error = "Please Enter Your Password.";
    } else {
        $password = filterString($password);
        if ($password == FALSE) {
            $password_error = "Please Enter valid Password";
        }
    }

    // If there are no validation errors, proceed with login
    if (empty($email_error) && empty($password_error)) {
        $role = 6; // Assuming role_id for admin is 1
        $stmt = $con->prepare("SELECT `role_id`, `id`, `email` , `name` FROM tbl_admin WHERE role_id = ? AND email = ? AND password = ? AND is_active = 1 AND is_delete = 0");
        $stmt->bind_param("iss", $role, $email, $password );
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Login successful, set session variables and redirect to dashboard
            $row = $result->fetch_assoc();
            $_SESSION['web_admin_id'] = $row['id'];
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['name'] = $row['name']; 
            $_SESSION['status'] = "Login Successfully";
            $_SESSION['status_code'] = "success";

            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid username or password
            $_SESSION['status'] = "Invalid Username and Password";
            $_SESSION['status_code'] = "error";
            header("Location: index.php"); // Redirect back to login page
            exit();
        }        
    }
}

// If the code reaches here, it means there were validation errors, and the login form will be displayed again.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <style>
        .login-page {
            background-image: linear-gradient(0deg, rgba(1, 1, 1, 0.8), rgba(1, 1, 1, 0.3)), url('../../../admin_assets/images/clg\ bg\ new.webp');
            background-size: cover;
        }

        .card-outline {
            border-top: 3px solid #ba2a21;
        }
    </style>
</head>
<body>
    <div id="preloader">
        <div id="status"></div>
    </div>
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline">
                <div class="card-header text-center">
                    <a href="index.php" class="h3"><b>GMIU Paperset Admin</b></a>
                </div>
                <div class="card-body">
                    <form method="POST" id="quickForm">
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
                            <div class="col-12">
                                <button type="submit" name="login" class="btn btn-primary btn-block" style="background-color: #ba2a21;">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include '../include/importjs.php'; ?>
</body>
</html>
