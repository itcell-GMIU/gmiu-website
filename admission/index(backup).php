<?php

//login code
session_start();
include '../database/connect.php';
include '../common/validation.php';
include '../common/function.php';
include '../common/globalvariable.php';
// Define variables of Academic form and initialize with empty values
$first_name_error = $middle_name_error = $last_name_error = $mobile_number_error = $email_error = "";
$faculty_id_error = $level_id_error = $password_error = $program_id_error = "";

// check if request is from this url or not


if (isset($_POST['register'])) {
    
    $cmd = $con->prepare("SELECT COUNT(*) FROM tbl_inquiry_student ");
    $cmd->execute();
    $result = $cmd->get_result();
    $row = $result->fetch_row();
    $inq_student_id = $row[0] + 1;
    $inq_student_id_padded = str_pad($inq_student_id, 3, '0', STR_PAD_LEFT);
    $inq_student_id_final = "INQ" . "$inq_student_id_padded";
    
    /* if($_SERVER['HTTP_REFERER'] == "https://gmiu.edu.in/gmiu/admission/index.php" || $_SERVER['HTTP_REFERER'] == " https://gmiu.edu.in/gmiu/admission/")
        { */

    if (isset($_POST['captcha'])) {
        $captcha = mysqli_real_escape_string($con, $_POST['captcha']);

        // Check if the user's input matches the stored CAPTCHA text
        if ($captcha == $_SESSION['captcha_sum']) {
            // CAPTCHA verification passed

            // Clear the CAPTCHA text from the session
            unset($_SESSION['captcha_sum']);

            $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
            $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
            $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
           // $password = generate_password();
           $password = mysqli_real_escape_string($con, $_POST['password']);
            /*   $hash_password = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                ); */
            $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
            $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
            $program_id = mysqli_real_escape_string($con, $_POST['program_id']);

            if (empty($first_name)) {
                $first_name_error = "Please Enter First Name";
                /*   echo  $first_name_error;
                    exit(); */
            } else {
                $first_name = validate_data($first_name);
            }

            if (empty($middle_name)) {
                $middle_name_error = "Please Enter Middle Name";
                /*   echo  $middle_name_error;
                    exit(); */
            } else {
                $middle_name = validate_data($middle_name);
            }

            if (empty($last_name)) {
                $last_name_error = "Please Enter Last Name";
                /*   echo  $last_name_error;
                    exit(); */
            } else {
                $last_name = validate_data($last_name);
            }
            
            if (empty($password)) {
                $password_error = "Please Enter Valid Password";
              
            } 
            if (empty($email)) {
                $email_error = "Please Enter Email";
            }
            if (empty($mobile_number)) {
                $mobile_number_error = "Please enter your Mobile Number";
            } else {
                $mobile_number = filterMobileNumber($mobile_number);
                if ($mobile_number == FALSE) {
                    $mobile_number_error = "Please enter a valid Mobile Number";
                    /*  echo  $mobile_number_error;
                        exit(); */
                }
            }

            if (empty($faculty_id)) {
                $faculty_id_error = "Please Select Faculty";
                /* echo  $faculty_id_error;
                    exit(); */
            }
            if (empty($level_id)) {
                $level_id_error = "Please Select Level Faculty";
                /* echo  $level_id_error;
                    exit(); */
            }
            if (empty($program_id)) {
                $program_id_error = "Please Select Program Faculty";
                /*  echo  $program_id_error;
                    exit(); */
            }
            // Check if email exists
            $emailQuery = $con->prepare("SELECT email FROM tbl_admission_student WHERE email = ?");
            $emailQuery->bind_param("s", $email);
            $emailQuery->execute();
            $emailResult =  $emailQuery->get_result();

            // Check if mobile number exists
            $mobileQuery = $con->prepare("SELECT mobile_number FROM tbl_admission_student WHERE mobile_number = ?");
            $mobileQuery->bind_param("s", $mobile_number);
            $mobileQuery->execute();
            $mobileResult =  $mobileQuery->get_result();

            if (mysqli_num_rows($emailResult) > 0) {
                // Email already exists, display an error message
                $_SESSION['status'] = "Email Already Exist";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='index.php'},1000)</script>";
            } elseif (mysqli_num_rows($mobileResult) > 0) {
                // Mobile number already exists, display an error message
                $_SESSION['status'] = "Mobile Number Already Exist";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='index.php'},1000)</script>";
            } else {
                if (empty($password_error) && empty($first_name_error) && empty($middle_name_error) && empty($last_name_error) && empty($email_error) && empty($mobile_number_error) && empty($faculty_id_error) && empty($level_id_error) && empty($program_id_error)) {

                    $stmt = $con->prepare("INSERT INTO tbl_admission_student (first_name,middle_name,last_name,email,mobile_number,faculty_id,level_id,program_id,password)
                        VALUES (?,?,?,?,?,?,?,?,?)");
                    $stmt->bind_param("sssssiiis", $first_name, $middle_name, $last_name, $email, $mobile_number, $faculty_id, $level_id, $program_id, $password);
                    if ($stmt->execute()) {
                        $admission_student_id=$con->insert_id;
                        $subject = "Student Registration";
                        $message = "Dear Applicant, <br>
                                    Thank you for showing your interest in Gyanmanjari Innovative University. You are just </br>a step
                                    away from enrolling at GMIU.Login in on https://gmiu.edu.in/gmiu/admission/ to </br>complete
                                    your registration process.<br>
                                    You are advised to change your password Immediately.Keep visiting our website regularly for updates.
                                    <br>
                                    <b>Username: {$mobile_number}  <br>
                                    Password: {$password} </b><br>
                                    <br>
                                    -GMIU
                                    ";
                        $to = $email;


                        //code for sending sms
                        //  $smsmessage = "Dear Applicant,Thank you for showing interest in Gyanmanjari Innovative University.You are just a step away from enrolling at GMIU.Login on https://gmiu.edu.in/gmiu/admission/ to complete your Registration process.Username:$mobile_number,Password:$password Note:Do not share your Username and Password with anyone.";
                        send_mail($to, $subject, $message);

                        $send_mail_error = send_mail($to, $subject, $message);
                        if ($send_mail_error == true) {
                            $mail_status = "success";
                        } else {
                            $mail_status = $send_mail_error;
                        }
                        $stmt5 = $con->prepare("INSERT INTO tbl_email_error_log (admission_student_id,first_name,last_name,email,mail_status,mobile_number,faculty_id,level_id,program_id)
                        VALUES (?,?,?,?,?,?,?,?,?)");
                            $stmt5->bind_param("isssssiii",$admission_student_id,$first_name, $last_name, $email, $mail_status, $mobile_number, $faculty_id, $level_id, $program_id);
                            $stmt5->execute();
                            
                            $is_online = 1;
                            $stmt = $con->prepare("INSERT INTO tbl_inquiry_student(inq_student_id,admission_student_id, first_name, middle_name, last_name, mobile_number, email, faculty_id, level_id, program_id, is_online) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt->bind_param("sisssssiiii",  $inq_student_id_final, $admission_student_id,$first_name, $middle_name, $last_name, $mobile_number, $email, $faculty_id, $level_id, $program_id, $is_online);
                            $result = $stmt->execute();
                            
                        $_SESSION['status'] = "Registered Successfully,You will get Password on your registered mobile number & Email Address.";
                        $_SESSION['status_code'] = "success";
                        echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
                        //  send_sms($mobile_number, $smsmessage);
                     
                    } else {
                        $_SESSION['status'] = "Something Went Wrong.";
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
                    }
                } else {
                    $_SESSION['status'] = "Invalid Data";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='index.php'},1000)</script>";
                }
            }
        } else {
            // CAPTCHA verification failed
            $_SESSION['status'] = "CAPTCHA verification failed. Please try again.";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
        }
    } else {
        $_SESSION['status'] = "Please Enter Captcha";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='index.php'},2000)</script>";
    }
}

/*  }else
    {
        
       
        $_SESSION['status'] = "Other Server Request";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='index.php'},1000)</script>";

    } */



// Define variables and initialize with empty values
$mobile_number_error = $password_error = "";
$mobile_number = $password = "";



if (isset($_POST['login_gmiu'])) {
    /* echo "hii";
exit(); */
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);

    $password = mysqli_real_escape_string($con, $_POST['password']);
    if (empty($mobile_number)) {
        $mobile_number_error = "Please enter your Mobile Number";
    } else {
        $mobile_number = filterMobileNumber($mobile_number);
        if ($mobile_number == FALSE) {
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
    if (empty($mobile_number_error) && empty($password_error)) {
        $cmd = $con->prepare("SELECT stu.step,stu.id as student_id,stu.first_name,stu.last_name from tbl_admission_student as stu
       WHERE mobile_number=? AND password= ? AND is_active=1 AND is_delete=0");
        $cmd->bind_param("ss", $mobile_number, $password);
        $cmd->execute();
        $ex = $cmd->get_result();
        if ($ex->num_rows == 1) {

            $row = mysqli_fetch_array($ex);

            $student_id = $row['student_id'];
            $admission_student_step = $row['step'];
            $_SESSION['student_id'] = $student_id;
            $_SESSION['secretkey'] = "secret";
            // }
            /*  echo $admission_student_step;
           exit(); */
            if ($admission_student_step == 5) {

                $_SESSION['status'] = "Logged In Successfully.";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='application_status.php'},1000)</script>";
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



<!doctype html>
<html class="no-js" lang="zxx">

<head>

    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" /> -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <link rel="stylesheet" href="../website_assets/css/index.css">

    <script type="text/javascript" defer src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" defer src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", () => {

        $(".carouselDiv").slick({
            slidesToShow: 3,
            slidesToScroll: 3,
            autoplay: true,
            rows: 3,
            dots: true,
            // arrows: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    });
    </script>
    <style>
    .card {
        width: 40%;
    }

    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    .wrapper {
        overflow: hidden;
        max-width: 2490px;
        background: rgba(255, 255, 255, 0.5);
        padding: 25px;
        border-radius: 5px;
        box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
    }

    .wrapper .title-text {
        display: flex;
        width: 200%;
    }

    .wrapper .title {
        width: 50%;
        font-size: 35px;
        font-weight: 600;
        text-align: center;
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .wrapper .slide-controls {
        position: relative;
        display: flex;
        height: 50px;
        width: 100%;
        overflow: hidden;
        margin: 30px 0 10px 0;
        justify-content: space-between;
        border: 1px solid lightgrey;
        border-radius: 5px;
    }

    .slide-controls .slide {
        height: 100%;
        width: 100%;
        color: #fff;
        font-size: 18px;
        font-weight: 500;
        text-align: center;
        line-height: 48px;
        cursor: pointer;
        z-index: 1;
        transition: all 0.6s ease;
    }

    .slide-controls label.signup {
        color: #000;
    }

    .slide-controls .slider-tab {
        position: absolute;
        height: 100%;
        width: 50%;
        left: 0;
        z-index: 0;
        border-radius: 5px;
        background: -webkit-linear-gradient(left, #ba2b21ed, #ba2b21ed);
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    input[type="radio"] {
        display: none;
    }

    #signup:checked~.slider-tab {
        left: 50%;
    }

    #signup:checked~label.signup {
        color: #fff;
        cursor: default;
        user-select: none;
    }

    #signup:checked~label.login {
        color: #000;
    }

    #login:checked~label.signup {
        color: #000;
    }

    #login:checked~label.login {
        cursor: default;
        user-select: none;
    }

    .wrapper .form-container {
        width: 100%;
        overflow: hidden;
        margin-bottom: 20px;
        margin-top: -10px;
    }

    .form-container .form-inner {
        display: flex;
        width: 200%;
    }

    .form-container .form-inner form {
        width: 50%;
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .form-inner form .field {
        height: 50px;
        width: 100%;
        margin-top: 20px;
    }

    .form-inner form .field input {
        height: 100%;
        width: 100%;
        outline: none;
        /* background : #000000; */
        background-color: rgba(255, 255, 255, 0.5);
        padding-left: 15px;
        border-radius: 5px;
        border: 1px solid lightgrey;
        border-bottom-width: 2px;
        font-size: 17px;
        transition: all 0.3s ease;
    }

    .form-inner form .field input[placeholder],
    [placeholder],
    *[placeholder] {
        color: #1D2649 !important;
    }


    .form-inner form .field input:focus {
        border-color: #1D2649;
        /* box-shadow: inset 0 0 3px #fb6aae; */
    }

    .form-inner form .field input::placeholder {
        color: #999;
        transition: all 0.3s ease;
    }

    form .field input:focus::placeholder {
        color: #b3b3b3;
    }

    .form-inner form .pass-link {
        margin-top: 5px;
    }

    .form-inner form .signup-link {
        text-align: center;
        margin-top: 30px;
    }

    .form-inner form .pass-link a,
    .form-inner form .signup-link a {
        color: #ba2a21;
        text-decoration: none;
    }

    .form-inner form .pass-link a:hover,
    .form-inner form .signup-link a:hover {
        text-decoration: underline;
    }

    form .btn {
        height: 50px;
        width: 100%;
        border-radius: 5px;
        position: relative;
        overflow: hidden;
    }

    form .btn .btn-layer {
        height: 100%;
        width: 300%;
        position: absolute;
        left: -100%;
        background: -webkit-linear-gradient(left, #ba2b21ed, #ba2b21ed, #ba2b21ed, #ba2b21ed);
        border-radius: 5px;
        transition: all 0.4s ease;
    }

    form .btn:hover .btn-layer {
        left: 0;
    }

    form .btn input[type="submit"] {
        height: 100%;
        width: 100%;
        z-index: 1;
        position: relative;
        background: none;
        border: none;
        color: #fff;
        padding-left: 0;
        border-radius: 5px;
        font-size: 20px;
        font-weight: 500;
        cursor: pointer;
    }

    .colorcode {
        color: #1D2649;
    }

    .tp {
        background-color: rgba(255, 255, 255, 0.5);
    }
    </style>
    <script>
    function changeStyle(n) {

       let a = document.getElementById("setting");
            if (n == 1) {
                a.style.display = "none";
            } else if (n == 0) {
                a.style.display = "block";
            }

    }
    </script>
</head>


<body class="home_version_02" onload="changeStyle(0)">
    <?php include 'include/importheader.php'; ?>
    <!-- Start Welcome Area section -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <section class="register-area" style="margin-top : 101px;">
        <div class="overlay-bg">
            <div class="container">
                <div class="row">

                    <div class="col-sm-5">
                        <!-- <div class="row"> -->
                        <!-- <div class="form-full-box"> -->

                        <div class="wrapper" id="wrp">
                            <div class="form-container">
                                <div class="slide-controls">
                                     <input type="radio" name="slide" id="login" onclick="changeStyle(1)" >
                                    <input type="radio" name="slide" id="signup" onclick="changeStyle(0)" checked>
                                     <label for="login" class="slide login">Login</label>
                                    <label for="signup" class="slide signup">Signup</label>
                                    <div class="slider-tab"></div>
                                </div>
                                <div class="form-inner">
                                   <form action="" method="POST" class="login" style="margin-left: -50%;">
                                        <div class="field">
                                            <label class="colorcode">Mobile Number</label>
                                            <span class="text-danger">*</span>
                                            <input type="text" title="Invalid Mobile Number, Don't use Country Code"
                                                placeholder="Enter Mobile Number" name="mobile_number" required>

                                        </div>
                                        <br>
                                        <div class="field">
                                            <label class="colorcode">Password</label>
                                            <span class="text-danger">*</span>
                                            <input type="password" placeholder="Enter Password" name="password"
                                                required>

                                        </div>
                                        <br>
                                        <!-- <div class="pass-link">
                                                <a href="#">Forgot password?</a>
                                            </div> -->
                                        <div class="field btn">
                                            <div class="btn-layer"></div>
                                            <input type="submit" value="Login" name="login_gmiu">
                                        </div>
                                        <!-- <div class="signup-link">
                                                Not a member? <a href="">Signup now</a>
                                            </div> -->
                                    </form>
                                    <form class="signup" method="POST" id="setting">
                                        <div class="form-row" style="margin-top : 20px; ">
                                            <div class="form-group col-md-6">
                                                <label class="colorcode">First Name</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" pattern="[a-zA-Z\s]+" minlength="2" maxlength="20"
                                                    class="form-control tp" title="Only Alphabets Allowed"
                                                    placeholder="First Name" name="first_name" id="first_name" required>

                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="colorcode">Middle Name</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control tp" placeholder="Middle Name"
                                                    name="middle_name" id="middle_name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="colorcode">Last Name</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control tp" placeholder="Last Name"
                                                    name="last_name" id="last_name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="colorcode">Email</label>
                                                <span class="text-danger">*</span>
                                                <input type="email" class="form-control tp" placeholder="Email"
                                                    name="email" id="email" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="colorcode">Mobile Number</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" pattern="[6-9]{1}[0-9]{9}"
                                                    title="Invalid Mobile Number, Don't use Country Code"
                                                    class="form-control tp" placeholder="Mobile Number"
                                                    name="mobile_number" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="colorcode">Select Faculty:</label>
                                                <span class="text-danger">*</span>
                                                <select class="form-control tp" id="faculty_id" name="faculty_id"
                                                    required>
                                                    <option value="">--Please select--</option>
                                                    <?php
                                                    $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                                                    $result = $con->query($query);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <a style="color:red;" target="_blank"
                                                    href="../website_assets/gmiu_doc/course_deatails.pdf">See Detailed
                                                    Course list</a>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="colorcode">Select Level:</label>
                                                <span class="text-danger">*</span>
                                                <select class="form-control tp" id="level_id" name="level_id" required>
                                                    <option value="">--Please select--</option>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="colorcode">Select Program:</label>
                                                <span class="text-danger">*</span>
                                                <select class="form-control tp" id="program_id" name="program_id"
                                                    required>
                                                    <option value="">--Please select--</option>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="colorcode">Password:</label>
                                                <span class="text-danger">*</span>
                                                <input type="password" maxlength="20" minlength="6"
                                                    class="form-control tp" placeholder="Password" name="password"
                                                    id="password" required>
                                            </div>

                                            <div class="form-group col-md-6">

                                                <label class="colorcode">Captcha</label>
                                                <span class="text-danger">*</span>

                                                <img src="captcha.php" alt="CAPTCHA">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control tp" placeholder="Enter Answer"
                                                    name="captcha" id="captcha" required>
                                            </div>


                                            <div class="form-group col-md-12"
                                                style="margin-bottom : -10px; font-size : 18px;">


                                                <a style="color:black;" target="_blank" href="terms&condition.php">
                                                    <input type="checkbox" name="is_same_addr" value="1" required
                                                        class="form-check-input" style="margin-right : 10px ; ">
                                                    *Terms
                                                    And Condition

                                                </a>

                                            </div>
                                            <div class="field btn">
                                                <div class="btn-layer"></div>
                                                <input id="registerbtn" type="submit" value="Register" name="register">
                                            </div>

                                    </form>



                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                    const loginText = document.querySelector(".title-text .login");
                    const loginForm = document.querySelector("form.login");
                    const loginBtn = document.querySelector("label.login");
                    const signupBtn = document.querySelector("label.signup");
                    const signupLink = document.querySelector("form .signup-link a");
                    signupBtn.onclick = (() => {
                        loginForm.style.marginLeft = "-50%";
                        loginText.style.marginLeft = "-50%";
                    });
                    loginBtn.onclick = (() => {
                        loginForm.style.marginLeft = "0%";
                        loginText.style.marginLeft = "0%";
                    });
                    /*    signupLink.onclick = (() => {
                           signupBtn.click();
                           return false;
                       }); */
                    </script>



                    <!-- </div> -->
                    <!-- </div> -->
                </div>
                <div style="color:white; font-size: medium;" class="col-sm-7">
                    <p style="color:white;">Apply Online for</p>
                    <h1>Admission 2024-25</h1>
                    <div class="row">
                        <div class="col-sm-12 section-header-box">
                            <div class="section-header section-header-l">

                                <script>
                                const loginText = document.querySelector(".title-text .login");
                                const loginForm = document.querySelector("form.login");
                                const loginBtn = document.querySelector("label.login");
                                const signupBtn = document.querySelector("label.signup");
                                const signupLink = document.querySelector("form .signup-link a");
                                signupBtn.onclick = (() => {
                                    loginForm.style.marginLeft = "-50%";
                                    loginText.style.marginLeft = "-50%";
                                });
                                loginBtn.onclick = (() => {
                                    loginForm.style.marginLeft = "0%";
                                    loginText.style.marginLeft = "0%";
                                });
                                /*    signupLink.onclick = (() => {
                                       signupBtn.click();
                                       return false;
                                   }); */
                                </script>


                            </div><!-- ends: .section-header -->
                        </div>
                    </div>
                    <div class="contDiv">

                        <!-- <ul style="columns:2;">
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=1"
                                        target="#">FACULTY
                                        OF ENGINEERING & TECHNOLOGY</a>
                                </li>

                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=2"
                                        target="#">FACULTY OF
                                        PHARMACY</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=3"
                                        target="#">FACULTY OF SCIENCE</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=4"
                                        target="#">FACULTY
                                        OF
                                        COMMERCE</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=5"
                                        target="#">FACULTY OF
                                        MANAGEMENT</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=6"
                                        target="#">FACULTY OF ART</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=8"
                                        target="#">FACULTY
                                        OF COMPUTER SCIENCE</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=9"
                                        target="#">FACULTY OF
                                        DESIGN</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=11"
                                        target="#">FACULTY OF MEDICAL
                                        SCIENCE AND HEALTH CARE</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=12"
                                        target="#">FACULTY OF SOCIAL
                                        WORK</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=14"
                                        target="#">FACULTY OF LIBRARY
                                        SCIENCE</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=15"
                                        target="#">FACULTY OF HOTEL
                                        MANAGEMENT</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=16"
                                        target="#">VOCATIONAL/CERTIFICATE
                                        COURSE</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=18"
                                        target="#">INTEGRATED COURSE</a>
                                </li>
                                <li>
                                    <a style="color:white;" href="https://gmiu.edu.in/gmiu/website/faculty.php?id=19"
                                        target="#">PH.D
                                        (MIN.3-YEARS)</a>
                                </li>



                            </ul> -->

                        <ul style="columns:2;">
                            <?php
                            $query = "SELECT id as faculty_id,name as faculty_name FROM tbl_faculty as faculty WHERE is_active = 1 and is_delete=0";
                            $result = $con->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                            <a style="color:white;"
                                href="../website/faculty/faculty.php?id=<?php echo $row['faculty_id'] ?>">

                                <li>
                                    <?php echo $row['faculty_name']; ?>
                                </li>
                            </a>
                            <?php
                                }
                            }
                            ?>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section style="padding: 20px; padding-bottom: 50px; display: block;" class="howTo">
        <div style="font-size: large;" class="container">
            <h3 style="font-size: 40px; padding-top: 50px;">How to <strong>Apply</strong>?</h3>
            <table class="listTable">
                <tbody style="font-size: 200%;">
                    <tr>
                        <td>
                            <strong style="font-size: 20px;">1</strong>
                        </td>
                        <td>
                            <h5>Applicant Registration</h5>
                            <p>
                                The applicant first needs to register himself/herself before applying to any course,
                                verify their Mobile No. & Email Address and select course. In certain courses where
                                specializations are offered, the candidate is required to fill the choice carefully.
                                after registration one SMS & Email will be sent to applicant of login credential.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong style="font-size: 20px;">2</strong>
                        </td>
                        <td>
                            <h5>Fill Basic Details & pay token fees </h5>
                            <p>
                                It includes your personal details i.e. Full Name, Gender, Birth Date, Communication
                                Address, etc. also pay Token fees of course. Token fees varies based on course. After
                                succefully payment fees receipt will send via registered email id.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong style="font-size: 20px;">3</strong>
                        </td>
                        <td>
                            <h5>Fill Education Details</h5>
                            <p>
                                After verification of your eligibility by University & receiving Provisional admission
                                order via mail, fill educations details. It varies based on the course you selected. It
                                includes SSC, HSC, Entrance Exam Score, etc.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong style="font-size: 20px;">4</strong>
                        </td>
                        <td>
                            <h5>Upload Documents</h5>
                            <p>
                                The candidate is required to upload his/her Photo, Signature, Qualifying & Entrance Exam
                                Mark sheets, etc.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong style="font-size: 20px;">5</strong>
                        </td>
                        <td>
                            <h5>Submit application </h5>
                            <p>
                                After submitting application GR number generated. Further process contact admission cell
                                9099951160
                                For details of each stage see admission procedure guideline.

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong style="font-size: 20px;">6</strong>
                        </td>
                        <td>
                            <h5>Admission Process Guide</h5>
                            <p>
                               <a href="https://gmiu.edu.in/gmiu/website_assets/gmiu_doc/Online-Rregistration1_Process.pdf" target="_blank">Click Here </a>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <!-- Ends: . -->

    <section class="statistics">
        <div class="cont">
            <div>
                <strong class="num" data-val="60">60</strong><strong>+</strong>
                <p>Laboratoriess</p>
            </div>
            <div>
                <strong class="num" data-val="200">200</strong><strong>+</strong>
                <!--<strong>200+</strong>-->
                <p>Faculties</p>
            </div>
            <div>
                <strong class="num" data-val="583">583</strong><strong>+</strong>
                <!--<strong>583+</strong>-->
                <p>Companies Visited For Placement</p>
            </div>

        </div>
    </section>
    <section class="RecAndWhy">
        <div class="container">
            <div class="recruiters">
                <h3>Major <strong>Recruiters</strong></h3>
                <div class="carouselDiv">
                    <?php for ($i = 0; $i <= 25; $i++) { ?>
                    <div class="slide">
                        <div class="card">
                            <div class="img"
                                style="background-image: url(https://www.gmiu.edu.in/gmiu/website_assets/images/associates/<?php echo $i; ?>.png)">
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="why">
                <h3>
                    <strong class="gradText">Why</strong> study at
                    <strong>GMIU</strong>?
                </h3>
                <table class="listTable">
                    <tbody>
                        <tr>
                            <td><strong>1</strong></td>
                            <td>
                                <h5>Best Academic Staff</h5>
                                <p>
                                    Well-Qualified, Experienced, Industry Linked and Dedicated
                                    Academic Staff.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>2</strong></td>
                            <td>
                                <h5>Industry Oriented Curriculum</h5>
                                <p>
                                    Curriculum includes latest technologies as per industry
                                    demands.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>3</strong></td>
                            <td>
                                <h5>Project-based Learning</h5>
                                <p>
                                    Extensive student-corporate interaction through
                                    internships and projects.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>4</strong></td>
                            <td>
                                <h5>Skill Development Programs</h5>
                                <p>
                                    Focus on skill development activities to make students
                                    industry-ready.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>5</strong></td>
                            <td>
                                <h5>Seminars/Workshops</h5>
                                <p>
                                    Exposure to cutting-edge technologies through seminars and
                                    workshops.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>6</strong></td>
                            <td>
                                <h5>Prominent Learning Resources</h5>
                                <p>
                                    Providing world-class study material like video lectures,
                                    e-notes, presentations.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>7</strong></td>
                            <td>
                                <h5>Academics Monitoring</h5>
                                <p>
                                    Continuous assessment of each &amp; every student's
                                    progress.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>8</strong></td>
                            <td>
                                <h5>Extra Curricular Activities</h5>
                                <p>
                                    International Exchange Program, Student Clubs, Technical
                                    and Social Events, etc.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>9</strong></td>
                            <td>
                                <h5>Placement</h5>
                                <p>
                                    MOUs with companies and Excellent placement track record.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer Area section -->
    <?php include 'include/importfooter.php'; ?>
    <!-- ./ End Footer Area-->

    <!-- ============================
    JavaScript Files
    ============================= -->
    <?php include 'include/importjs.php'; ?>
<script>
    let valueDisplays = document.querySelectorAll(".num");
let interval = 4000;

valueDisplays.forEach((valueDisplay) => {
  let startValue = 0;
  let endValue = parseInt(valueDisplay.getAttribute("data-val"));
  let duration = Math.floor(interval / endValue);
  let numberOfIntervals = Math.ceil(interval / duration); // Calculate the number of intervals
  let counter = setInterval(function () {
    startValue += 1;
    valueDisplay.textContent = startValue;
    if (startValue == endValue) {
      clearInterval(counter);
    }
  }, duration);
  
//   console.log(`Number of intervals for ${endValue}: ${numberOfIntervals}`);
});

</script>
</body>

</html>

<script type="text/javascript">
$(document).ready(function() {
    $("#setting").on("submit", function() {
        $("#preloader").show();

    }); //submit
})
$('#faculty_id').on('change', function() {
    $('#program_id').prop('selectedIndex', 0);
    var path = '<?php echo "$base_url_api"; ?>';
    var faculty_id = this.value;
    var api_type = "admission";
    // alert("hii");
    $.ajax({
        url: path + 'level.php',
        type: "POST",
        data: {
            faculty_data: faculty_id,
            api_type:api_type
        },
        success: function(result) {
            $('#level_id').html(result);

            // console.log(result);
        }
    })
});
$('#level_id').on('change', function() {
    var path = '<?php echo "$base_url_api"; ?>';
    var level_id = this.value;
    var faculty_id = $("select#faculty_id option:checked").val();
    /*  alert(level_id); */

    $.ajax({
        url: path + 'program.php',
        type: "POST",
        data: {
            level_data: level_id,
            faculty_data: faculty_id
        },
        cache: false,
        success: function(data) {
            $('#program_id').html(data);
            // console.log(data);
        }
    })
});
</script>