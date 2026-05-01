<?php
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');

//login code
// session_start();
include 'database/connect.php';
include 'common/validation.php';
include 'common/function.php';
include 'common/globalvariable.php';



// Define variables of Academic form and initialize with empty values
$first_name_error =  $mobile_number_error = "";
$faculty_id_error = $level_id_error  = $program_id_error = "";

// check if request is from this url or not



if (isset($_POST['register'])) {
    $cmd = $con->prepare("SELECT COUNT(*) FROM tbl_inquiry_student ");
    $cmd->execute();
    $result = $cmd->get_result();
    $row = $result->fetch_row();
    $inq_student_id = $row[0] + 1;
    $inq_student_id_padded = str_pad($inq_student_id, 3, '0', STR_PAD_LEFT);
    $inq_student_id_final = "INQ" . "$inq_student_id_padded";
    /* if($_SERVER['HTTP_REFERER'] == "https://gmiu.edu.in/gmiu/admission/admission_open.php" || $_SERVER['HTTP_REFERER'] == " https://gmiu.edu.in/gmiu/admission/")
        { */

            $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
            $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            
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
          
            // Check if mobile number exists
            $mobileQuery = $con->prepare("SELECT mobile_number FROM tbl_admission_student WHERE mobile_number = ?");
            $mobileQuery->bind_param("s", $mobile_number);
            $mobileQuery->execute();
            $mobileResult =  $mobileQuery->get_result();
            if (mysqli_num_rows($mobileResult) > 0) {
                // Mobile number already exists, display an error message
                echo "<script>alert('This Mobile Number is already exist');</script>";
                $_SESSION['status'] = "Mobile Number Already Exist";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='admission_open.php'},1000)</script>";
            } else {
                if (empty($first_name_error)  && empty($mobile_number_error) && empty($faculty_id_error) && empty($level_id_error) && empty($program_id_error)) {
                    $admission_year = date("Y");
                    $semester = 1;
                    $stmt = $con->prepare("INSERT INTO tbl_admission_student (admission_year,first_name,mobile_number,email,faculty_id,level_id,program_id)
                        VALUES (?,?,?,?,?,?,?)");
                    $stmt->bind_param("ssssiii", $admission_year, $first_name , $mobile_number,$email, $faculty_id, $level_id, $program_id);
                    if ($stmt->execute()) {
                        $admission_student_id = $con->insert_id;
                        // $subject = "Student Registration";
                        // $message = "Dear Applicant, <br>
                        //             Thank you for showing your interest in Gyanmanjari Innovative University. You are just </br>a step
                        //             away from enrolling at GMIU.Login in on https://gmiu.edu.in/gmiu/admission/ to </br>complete
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
                        //  $smsmessage = "Dear Applicant,Thank you for showing interest in Gyanmanjari Innovative University.You are just a step away from enrolling at GMIU.Login on https://gmiu.edu.in/gmiu/admission/ to complete your Registration process.Username:$mobile_number,Password:$password Note:Do not share your Username and Password with anyone.";
                        //send_mail($to, $subject, $message);

                        // $send_mail_error = send_mail($to, $subject, $message);
                        // if ($send_mail_error == true) {
                        //     $mail_status = "success";
                        // } else {
                        //     $mail_status = $send_mail_error;
                        // }
                       
                        // $is_online = 1;
                        // $stmt = $con->prepare("INSERT INTO `tbl_inquiry_student`(`inq_student_id`,`admission_student_id`, `first_name`, `mobile_number`, `faculty_id`, `level_id`, `program_id`, `is_online`) VALUES (?,?,?,?,?,?,?,?)");
                        // $stmt->bind_param("sissiiii",  $inq_student_id_final, $admission_student_id,$first_name,  $mobile_number,  $faculty_id, $level_id, $program_id, $is_online);
                        // $result = $stmt->execute();




                        $_SESSION['status'] = "Registered Successfully,You will get Password on your registered mobile number & Email Address.";
                        $_SESSION['status_code'] = "success";
                        echo "<script>setTimeout(function(){window.location='payfee.php?admission_student_id=$admission_student_id'},1000)</script>";
                        //  send_sms($mobile_number, $smsmessage);


                    } else {
                        $_SESSION['status'] = "Something Went Wrong.";
                        $_SESSION['status_code'] = "error";
                        echo "<script>setTimeout(function(){window.location='admission_open.php'},2000)</script>";
                    }
                } else {
                    $_SESSION['status'] = "Invalid Data";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='admission_open.php'},1000)</script>";
                }
            }
        }

?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>

    <?php //include 'include/importhead.php'; 
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include 'admission/include/importcss.php'; 
    ?>
    <link rel="stylesheet" href="website_assets/css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ebz-static.s3.ap-south-1.amazonaws.com/easecheckout/easebuzz-checkout.js"></script>

    <style>
        .register {
            background-image: url('website_assets/images/index-02/1.jpg');
            /* padding: 50px 0; */
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
            /* height: 100%; */
            position: absolute;
        }

        .wrapper {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffffc7;
            border: 1px solid #a9a9a9;
            box-shadow: -1px 1px 20px rgb(2 2 2 / 34%);
        }

        .form-container {
            padding: 20px;
        }

        .form-row {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .form-control:focus {
            border-color: #aaa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .btn:hover {
            background-color: #3e8e41;
        }

        .colorcode {
            color: #1D2649;
        }

        .tp {
            background-color: #ffffff;
        }

        .text-danger {
            color: red;
        }

        .register-btn {
            background-color: #4CAF50;
            border: none;
        }

        .note {
            color: #d90909;
            margin-top: 20px;
        }
    </style>

<body>
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <section class="register">

        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="wrapper" id="wrp">
                        <div class="form-container">
                            <form id="register" class="signup" method="POST" action="" id="setting">

                                <div class="form-row" style="margin-top : 20px; ">
                                    <div class="form-group col-md-6">
                                        <label class="colorcode">Full Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" pattern="[a-zA-Z\s]+" minlength="2" maxlength="20" class="form-control tp" title="Only Alphabets Allowed" placeholder="First Name" name="first_name" id="first_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                                <label class="colorcode">Email</label>
                                                <span class="text-danger">*</span>
                                                <input type="email" class="form-control tp" placeholder="Email" name="email" id="email" required>
                                            </div>
                                    <div class="form-group col-md-6">
                                        <label class="colorcode">Mobile Number</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" pattern="[6-9]{1}[0-9]{9}" title="Invalid Mobile Number, Don't use Country Code" class="form-control tp" placeholder="Mobile Number" name="mobile_number" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="colorcode">Select Faculty:</label>
                                        <span class="text-danger">*</span>
                                        <select class="form-control tp" id="faculty_id" name="faculty_id" required>
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
                                        <select class="form-control tp" id="program_id" name="program_id" required>
                                            <option value="">--Please select--</option>

                                        </select>
                                    </div>
                                    </tr>
                                                                                                             
                                    <div class="btn">
                                        <!-- <div class="btn-layer"></div> -->
                                        <input id="registerbtn" class="register-btn" type="submit" value="Register" name="register">
                                    </div>
                                    <!-- <tr class="online_mode_tr">
                                        <td scope="row"></td>
                                        <td class="center"><button class="register-btn" id="ebz-checkout-btn" type="submit" data-form_name="payment_detail">Pay
                                                Now</button></td>
                                    </tr> -->
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
    </section>
</body>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js'></script>

<script type="text/javascript">
    $('#faculty_id').on('change', function() {
        // alert("hii");
        // $('#program_id').prop('selectedIndex', 0);
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        var api_type = "admission";

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

    $('#program_id').on('change', function() {
    var path = '<?php echo "$base_url_api"; ?>';
    var selected_mode = "regular";
    var program_id = this.value;
    var api_for = "token_fee";

    $.ajax({
        url: path + 'api.php',
        type: "POST",
        data: {
            program_id: program_id,
            api_for: api_for,
            admission_mode: selected_mode
        },
        cache: false,
        success: function(data) {
            console.log("Raw Response Data: ", data); // Log the raw response
            try {
                var response = JSON.parse(data);
                console.log("Parsed Response Data: ", response); // Log parsed response
                $('#token_amount').val(response.token);
            } catch (e) {
                console.error("Parsing Error: ", e);
                console.log("Response was not valid JSON:", data);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", status, error);
        }
    });
});


</script>