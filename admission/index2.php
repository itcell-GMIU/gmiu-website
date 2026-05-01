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
    /* if($_SERVER['HT_REFERER'] == "hts://gmiu.edu.in/gmiu/admission/index2.php" || $_SERVER['HT_REFERER'] == " hts://gmiu.edu.in/gmiu/admission/")
        { */

    /*if (isset($_POST['captcha'])) {
        $captcha = mysqli_real_escape_string($con, $_POST['captcha']);
*/
       /* // Check if the user's input matches the stored CAPTCHA text
        if ($captcha == $_SESSION['captcha_sum']) {
            // CAPTCHA verification passed

            // Clear the CAPTCHA text from the session
            unset($_SESSION['captcha_sum']);*/

            $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
            $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
            $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
            // $password = generate_password();
            $password = mysqli_real_escape_string($con, $_POST['mobile_number']);
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
                echo "<script>setTimeout(function(){window.location='index2.php'},1000)</script>";
            } elseif (mysqli_num_rows($mobileResult) > 0) {
                // Mobile number already exists, display an error message
                $_SESSION['status'] = "Mobile Number Already Exist";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='index2.php'},1000)</script>";
            } else {
                if (empty($password_error) && empty($first_name_error) && empty($middle_name_error) && empty($last_name_error) && empty($email_error) && empty($mobile_number_error) && empty($faculty_id_error) && empty($level_id_error) && empty($program_id_error)) {
                    $admission_year = date("Y");
                    $semester = 1;
                    $stmt = $con->prepare("INSERT INTO tbl_admission_student (admission_year,first_name,middle_name,last_name,email,mobile_number,faculty_id,level_id,program_id,password)
                        VALUES (?,?,?,?,?,?,?,?,?,?)");
                    $stmt->bind_param("ssssssiiis", $admission_year, $first_name, $middle_name, $last_name, $email, $mobile_number, $faculty_id, $level_id, $program_id, $password);
                    if ($stmt->execute()) {
                        $admission_student_id = $con->insert_id;
                        // $subject = "Student Registration";
                        // $message = "Dear Applicant, <br>
                        //             Thank you for showing your interest in Gyanmanjari Innovative University. You are just </br>a step
                        //             away from enrolling at GMIU.Login in on hts://gmiu.edu.in/gmiu/admission/ to </br>complete
                        //             your registration process.<br>
                        //             You are advised to change your password Immediately.Keep visiting our website regularly for updates.
                        //             <br>
                        //             <b>Username: {$mobile_number}  <br>
                        //             Password: {$password} </b><br>
                        //             <br>
                        //             -GMIU
                        //             ";
                        // $to = $email;


                        //code for sending sms
                        //  $smsmessage = "Dear Applicant,Thank you for showing interest in Gyanmanjari Innovative University.You are just a step away from enrolling at GMIU.Login on hts://gmiu.edu.in/gmiu/admission/ to complete your Registration process.Username:$mobile_number,Password:$password Note:Do not share your Username and Password with anyone.";
                        //send_mail($to, $subject, $message);

                        // $send_mail_error = send_mail($to, $subject, $message);
                        // if ($send_mail_error == true) {
                        //     $mail_status = "success";
                        // } else {
                        //     $mail_status = $send_mail_error;
                        // }
                        $stmt5 = $con->prepare("INSERT INTO tbl_email_error_log (admission_student_id,first_name,last_name,email,mail_status,mobile_number,faculty_id,level_id,program_id)
                        VALUES (?,?,?,?,?,?,?,?,?)");
                        $stmt5->bind_param("isssssiii", $admission_student_id, $first_name, $last_name, $email, $mail_status, $mobile_number, $faculty_id, $level_id, $program_id);
                        $stmt5->execute();

                        $is_online = 1;
                        $stmt = $con->prepare("INSERT INTO `tbl_inquiry_student`(`inq_student_id`,`admission_student_id`, `first_name`, `middle_name`, `last_name`, `mobile_number`, `email`, `faculty_id`, `level_id`, `program_id`, `is_online`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                        $stmt->bind_param("sisssssiiii",  $inq_student_id_final, $admission_student_id, $first_name, $middle_name, $last_name, $mobile_number, $email, $faculty_id, $level_id, $program_id, $is_online);
                        $result = $stmt->execute();


                        if ($result) {
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
                                    echo "<script>setTimeout(function(){window.location='index2.php'},1000)</script>";
                                }
                            }
                        }


                        // $_SESSION['status'] = "Registered Successfully,You will get Password on your registered mobile number & Email Address.";
                        // $_SESSION['status_code'] = "success";
                        // echo "<script>setTimeout(function(){window.location='index2.php'},2000)</script>";
                        //  send_sms($mobile_number, $smsmessage);


                    } else {
                        $_SESSION['status'] = "Something Went Wrong.";
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='index2.php'},2000)</script>";
                    }
                } else {
                    $_SESSION['status'] = "Invalid Data";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='index2.php'},1000)</script>";
                }
            }
       /* } else {
            // CAPTCHA verification failed
            $_SESSION['status'] = "CAPTCHA verification failed. Please try again.";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='index2.php'},2000)</script>";
        }*/
    /*} else {
        $_SESSION['status'] = "Please Enter Captcha";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='index2.php'},2000)</script>";
    }*/
}

/*  }else
    {
        
       
        $_SESSION['status'] = "Other Server Request";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='index2.php'},1000)</script>";

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
            echo "<script>setTimeout(function(){window.location='index2.php'},1000)</script>";
        }
    }
}


?>



<!doctype html>
<html class="no-js" lang="zxx">

<head>

    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>

    <!-- <link href="hts://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" /> -->
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
        @import url('hts://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

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

        . {
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
    <script>
        function changeStyle(n) {

            let a = document.getElementById("setting");
            if (n == 0) {
                a.style.display = "none";
            } else if (n == 1) {
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
                    <div class="col-sm-2">

                    </div>

                    <div class="col-sm-8">
                        <!-- <div class="row"> -->
                        <!-- <div class="form-full-box"> -->

                        <div class="wrapper" id="wrp">
                            <div class="form-container">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="row" style="margin-top : 20px; ">
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">First Name</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" pattern="[a-zA-Z\s]+" minlength="2" maxlength="20" class="form-control " title="Only Alphabets Allowed" placeholder="First Name" name="first_name" id="first_name" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">Middle Name</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" class="form-control " placeholder="Middle Name" name="middle_name" id="middle_name" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">Last Name</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" class="form-control " placeholder="Last Name" name="last_name" id="last_name" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">Email</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="email" class="form-control " placeholder="Email" name="email" id="email" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">Mobile Number</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" pattern="[6-9]{1}[0-9]{9}" title="Invalid Mobile Number, Don't use Country Code" class="form-control " placeholder="Mobile Number" name="mobile_number" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">Select Faculty:</label>
                                                    <span class="text-danger">*</span>
                                                    <select class="form-control " id="faculty_id" name="faculty_id" required>
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
                                                    <a style="color:red;" target="_blank" href="../website_assets/gmiu_doc/gmiuallprogram.pdf">See Detailed
                                                        Course list</a>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">Select Level:</label>
                                                    <span class="text-danger">*</span>
                                                    <select class="form-control " id="level_id" name="level_id" required>
                                                        <option value="">--Please select--</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">Select Program:</label>
                                                    <span class="text-danger">*</span>
                                                    <select class="form-control " id="program_id" name="program_id" required>
                                                        <option value="">--Please select--</option>
                                                    </select>
                                                </div>
                                                <!-- <div class="form-group col-md-12">
                                                    <label class="colorcode" for="token_amount">Token Amount:</label>
                                                    <input type="text" class="form-control" id="token_amount" name="token_amount" readonly>
                                                </div> -->
                                                <!--<div class="form-group col-md-12">
                                                    <label class="colorcode">Password:</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="password" maxlength="20" minlength="6" class="form-control tp" placeholder="Password" name="password" id="password" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="colorcode">Captcha</label>
                                                    <span class="text-danger">*</span>
                                                    <img src="captcha.php" alt="CAPTCHA">
                                                </div>-->
                                               <!-- <div class="form-group col-md-6">
                                                    <!-- <label class="colorcode">&nbsp;</label> -->
                                                    <!--<input type="text" class="form-control " placeholder="Enter Answer" name="captcha" id="captcha" required>
                                                </div>-->


                                                <!--<div class="form-group col-md-12" style="margin-bottom : -10px; font-size : 18px;">-->


                                                    <a style="color:black;" target="_blank" href="terms&condition.php">
                                                        <input type="checkbox" name="is_same_addr" value="1" required class="form-check-input" style="margin-right : 10px ; ">
                                                        *Terms
                                                        And Condition
                                                    </a>
                                                </div>
                                                <div class="field btn">
                                                    <!-- <div class="btn-layer"></div> -->
                                                    <input id="registerbtn" type="submit" value="Submit" name="register" style="background-color: #ba2a21;">
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- </div> -->
                    <!-- </div> -->
                </div>
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

</body>

</html>
<!-- <script>
    $(document).ready(function() {
        $('#program_id').change(function() {
            var program_id = $(this).val();

            $.ajax({
                url: 'get_token_amount.php',
                type: 'POST',
                data: {
                    program_id: program_id
                },
                success: function(response) {
                    $('#token_amount').val(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
        });
    });
</script> -->
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
                api_type: api_type
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