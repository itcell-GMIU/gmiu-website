<?php
session_start();
include 'database/connect.php';
include 'common/validation.php';
include 'common/function.php';
include 'common/globalvariable.php';
// $student_id = $_SESSION['student_id'];
// Get the admission_student_id from the URL
if (isset($_GET['admission_student_id'])) {
    $admission_student_id = $_GET['admission_student_id'];
} else {
    $_SESSION['status'] = "Invalid Access.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='admission_open.php'},2000)</script>";
    exit();
}

// Fetch student details from the database
$query = $con->prepare("SELECT first_name, mobile_number, faculty_id,level_id,program_id FROM tbl_admission_student WHERE id = ?");
$query->bind_param("i", $admission_student_id);
$query->execute();
$result = $query->get_result();
$student = $result->fetch_assoc();



if (!$student) {
    $_SESSION['status'] = "Student not found.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='admission_open.php'},2000)</script>";
    exit();
}

$cmd = "Select stu.*,pro.name as program_name,clg.clg_name as college_name,level.name as level_name,faculty.shortname as faculty_shortname,faculty.name as faculty_name,stu.account_office_approve_reject_date as account_office_approve_reject_date, stu.transaction_id as transaction_id, stu.payment_id as payment_id from tbl_admission_student as stu LEFT JOIN tbl_program pro
ON stu.program_id = pro.id LEFT JOIN tbl_faculty faculty
ON stu.faculty_id = faculty.id LEFT JOIN tbl_level level
ON stu.level_id = level.id
LEFT JOIN tbl_clg_name clg ON stu.faculty_id = clg.faculty_id AND stu.level_id = clg.level_id where stu.id=? ";
$stmt = $con->prepare($cmd);
$stmt->bind_param("i", $admission_student_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $clg_name = $row['college_name'];
    $stu_first_name = !empty($row['first_name']) ? $row['first_name'] : "";
    $stu_middle_name = !empty($row['middle_name']) ? $row['middle_name'] : "";
    $stu_last_name = !empty($row['last_name']) ? $row['last_name'] : "";
    $stu_email = !empty($row['email']) ? $row['email'] : "";
    $stu_number = !empty($row['mobile_number']) ? $row['mobile_number'] : "";
    $stu_faculty_id = !empty($row['faculty_id']) ? $row['faculty_id'] : "";
    $stu_level_id = !empty($row['level_id']) ? $row['level_id'] : "";
    $stu_program_id = !empty($row['program_id']) ? $row['program_id'] : "";
    $mode = !empty($row['mode']) ? $row['mode'] : "";
    $payment_mode = !empty($row['payment_mode']) ? $row['payment_mode'] : "";
    $payment_status = !empty($row['payment_status']) ? $row['payment_status'] : "";
    $adhar_number = !empty($row['adhar_number']) ? $row['adhar_number'] : "";
    $gender = !empty($row['gender']) ? $row['gender'] : "";
    $dob = !empty($row['dob']) ? $row['dob'] : "";
    $blood_group = !empty($row['blood_group']) ? $row['blood_group'] : "";
    $religion = !empty($row['religion']) ? $row['religion'] : "";
    $caste = !empty($row['caste']) ? $row['caste'] : "";
    $father_name = !empty($row['father_name']) ? $row['father_name'] : "";
    $mother_name = !empty($row['mother_name']) ? $row['mother_name'] : "";
    $parent_mobile_number = !empty($row['parent_mobile_number']) ? $row['parent_mobile_number'] : "";
    $parent_email_id = !empty($row['parent_email_id']) ? $row['parent_email_id'] : "";
    $father_occupation = !empty($row['father_occupation']) ? $row['father_occupation'] : "";
    $mother_occupation = !empty($row['mother_occupation']) ? $row['mother_occupation'] : "";
    $permanent_address = !empty($row['permanent_address']) ? $row['permanent_address'] : "";
    $permanent_pincode = !empty($row['permanent_pincode']) ? $row['permanent_pincode'] : "";
    $address = !empty($row['address']) ? $row['address'] : "";
    $pincode = !empty($row['pincode']) ? $row['pincode'] : "";
    $city = !empty($row['city']) ? $row['city'] : "";
    $state = !empty($row['state']) ? $row['state'] : "";
    $permanent_city = !empty($row['permanent_city']) ? $row['permanent_city'] : "";
    $permanent_state = !empty($row['permanent_state']) ? $row['permanent_state'] : "";
    $is_same_addr = !empty($row['is_same_addr']) ? $row['is_same_addr'] : "";
    $token_amount = !empty($row['token_amount']) ? $row['token_amount'] : "";
    $payment_date_time = !empty($row['payment_date_time']) ? $row['payment_date_time'] : "";
    $gr_number = !empty($row['gr_number']) ? $row['gr_number'] : "";
    $stu_program_name = !empty($row['program_name']) ? $row['program_name'] : "";
    $stu_faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "";
    $stu_faculty_shortname = !empty($row['faculty_shortname']) ? $row['faculty_shortname'] : "";
    $stu_level_name = !empty($row['level_name']) ? $row['level_name'] : "";
    $stu_cluster_status = !empty($row['status']) ? $row['status'] : "";
    $stu_admission_status = !empty($row['admission_status']) ? $row['admission_status'] : "";
    $stu_admission_step = !empty($row['step']) ? $row['step'] : "";
    $comment = !empty($row['comment']) ? $row['comment'] : "";
    $account_office_status = !empty($row['account_office_status']) ? $row['account_office_status'] : "";
    $account_office_approve_reject_date = !empty($row['account_office_approve_reject_date']) ? $row['account_office_approve_reject_date'] : "";
    $transaction_id = !empty($row['transaction_id']) ? $row['transaction_id'] : "";
    $payment_id = !empty($row['payment_id']) ? $row['payment_id'] : "";
} else {
    $stu_first_name = "";
    $stu_middle_name = "";
    $stu_last_name = "";
    $stu_email = "";
    $stu_number = "";
    $stu_faculty_id = "";
    $stu_level_id = "";
    $stu_program_id = "";
    $mode = "";
    $payment_mode = "";
    $adhar_number = "";
    $dob = "";
    $gender = "";
    $blood_group = "";
    $religion = "";
    $caste = "";
    $father_name = "";
    $mother_name = "";
    $parent_mobile_number = "";
    $parent_email_id = "";
    $father_occupation = "";
    $mother_occupation = "";
    $permanent_address = "";
    $permanent_pincode = "";
    $address = "";
    $pincode = "";
    $city = "";
    $state = "";
    $permanent_city = "";
    $permanent_state = "";
    $is_same_addr = "";
    $token_amount = "";
    $payment_date_time = "";
    $gr_number = "";
    $stu_program_name = "";
    $stu_faculty_name = "";
    $stu_faculty_shortname = "";
    $stu_level_name = "";
    $stu_cluster_status = "";
    $stu_admission_status = "";
    $stu_admission_step = "";
    $comment = "";
    $account_office_status = "";
    $account_office_approve_reject_date = "";
    $transaction_id = "";
    $payment_id = "";
}
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pay Fee</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- dashboard css link  -->
    <!-- <link rel="stylesheet" href="website_assets/css/dashboard.css" type="text/css" /> -->
    <!-- <script src="website_assets/js/cities.js"></script> -->

    <?php //include 'admission/include/importcss.php';  
    ?>
    <!-- <script src="website_assets/js/cities.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <?php //include 'admission/form_validate1.php' 
    ?>
    <link rel="stylesheet" href="website_assets/css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ebz-static.s3.ap-south-1.amazonaws.com/easecheckout/easebuzz-checkout.js"></script>

    <style>
        .register {
            background-image: url('website_assets/images/index-02/1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
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
</head>

<body>

    <section class="register">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="wrapper" id="wrp">
                        <div class="form-container">
                            <form id="payment_detail" method="POST">
                                <input type="hidden" name="admission_student_id" value="<?php echo $admission_student_id; ?>">
                                <div class="form-row" style="margin-top: 20px;">
                                    <div class="form-group col-md-6">
                                        <label class="colorcode">First Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control tp" value="<?php echo $student['first_name']; ?>" disabled>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="colorcode">Mobile Number</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control tp" value="<?php echo $student['mobile_number']; ?>" disabled>
                                    </div>
                                    <tr class="dp">

                                        <td class="center"><b>Faculty<span class="form_error_message">*</span></b></b>
                                        </td>
                                        <td><select class="form-control tp" id="faculty_id" name="faculty_id" required>

                                                <?php
                                                $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                                                $result = $con->query($query);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        if ($row['id'] == $stu_faculty_id) {
                                                            echo '<option selected value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                        } else {
                                                            echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </td>

                                    </tr>
                                    <tr class="dp">

                                        <td class="center"><b>Level<span class="form_error_message">*</span></b></td>
                                        <td><select class="form-control tp" id="level_id" name="level_id">
                                                <option value="">--Please select--</option>

                                            </select></span></td>

                                    </tr>
                                    <tr class="dp">

                                        <td class="center"><b>Program<span class="form_error_message">*</span></b></td>
                                        <td>
                                            <select class="form-control tp" id="program_id" name="program_id">
                                                <option value="">--Please select--</option>
                                            </select>

                                        </td>

                                    </tr>
                                    <!-- <td class="center"><b>Mode</b></td> -->
                                    <input type="hidden" id="admission_mode" name="mode" value="regular">
                                    <input type="hidden" name="payment_mode" id="payment_mode" value="online">
                                    <!-- <td><select id="admission_mode" name="mode" class="form-control tp" > -->


                                    <tr>
                                        <!-- <th scope="row">2</th> -->
                                        <td class="center"><b>Token Amount</b></td>
                                        <td> <input type="text" class="form-control inp" name="token_mount" id="token_amount" disabled>
                                        </td>
                                    </tr>
                                    <tr class="online_mode_tr">
                                        <td scope="row"></td>
                                        <td class="center"><button id="ebz-checkout-btn" type="submit" data-form_name="payment_detail">Pay
                                                Now</button></td>
                                    </tr>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js'></script>



    <script type="text/javascript">
        $(document).ready(function() {

            //call for listing the dropdown and select by default
            load_level();
            load_program();
            load_token();
            // load_education_document();

        });
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
            // alert(level_id);
            var faculty_id = $("select#faculty_id option:checked").val();

            // console.log(level_id);
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


        function load_level() {
            // alert("hii");
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $stu_faculty_id; ?>;
            var level_id = <?php echo $stu_level_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: api_for
                },
                success: function(result) {
                    $('#level_id').html(result);
                }
            });

        }

        function load_program() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $stu_faculty_id; ?>;
            var level_id = <?php echo $stu_level_id; ?>;
            var program_id = <?php echo $stu_program_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_data: level_id,
                    program_id: program_id,
                    api_for: api_for
                },
                success: function(result) {
                    $('#program_id').html(result);
                }
            });

        }


        function load_token() {

            var path = '<?php echo "$base_url_api"; ?>';
            var program_id = <?php echo "$stu_program_id"; ?>;
            var selected_mode = "regular";
            // alert(selected_mode);
            var api_for = "token_fee";
            // console.log(level_id);
            $.ajax({
                url: path + 'api2.php',
                type: "POST",
                data: {

                    api_for: api_for,
                    program_id: program_id,
                    // student_id: student_id,
                    admission_mode: selected_mode
                },
                cache: false,
                success: function(data) {
                    var response = JSON.parse(data);
                    $('#token_amount').val(response.token);
                    if (response.genius_mode_status == "no") {
                        //    $('#admission_mode').prop('selectedIndex', 0);
                        $("#admission_mode option[value='genius']").hide();
                    } else {
                        //   $('#admission_mode').prop('selectedIndex', 0);
                        $("#admission_mode option[value='genius']").show();
                    }
                    if (response.minor_mode_status == "no") {
                        //  $('#admission_mode').prop('selectedIndex', 0);
                        $("#admission_mode option[value='minor']").hide();
                    } else {
                        //  $('#admission_mode').prop('selectedIndex', 0);
                        $("#admission_mode option[value='minor']").show();

                    }
                }
            });

        }

        $('#program_id').on('change', function() {
            // alert("hii");
            var path = '<?php echo "$base_url_api"; ?>';
            var selected_mode = "regular";
            var program_id = this.value;
            var api_for = "token_fee";
            // alert(program_id);
            $.ajax({
                url: path + 'api2.php',
                type: "POST",
                data: {
                    program_id: program_id,
                    api_for: api_for,
                    admission_mode: selected_mode
                },
                cache: false,
                success: function(data) {
                    // alert(data);
                    var response = JSON.parse(data);
                    $('#token_amount').val(response.token);
                    if (response.genius_mode_status == "no") {
                        $('#admission_mode').prop('selectedIndex', 0);
                        $("#admission_mode option[value='genius']").hide();


                    } else {
                        $('#admission_mode').prop('selectedIndex', 0);
                        $("#admission_mode option[value='genius']").show();

                    }
                    if (response.minor_mode_status == "no") {
                        $('#admission_mode').prop('selectedIndex', 0);
                        $("#admission_mode option[value='minor']").hide();


                    } else {
                        $('#admission_mode').prop('selectedIndex', 0);
                        $("#admission_mode option[value='minor']").show();

                    }
                }
            })
        });
        // online payment ajax call
        $('#ebz-checkout-btn').on('click', function(e) {
            // alert("hello");
            $('#preloader').show();
            // alert("hii");
            var formData = new FormData(document.getElementById("payment_detail"));
            // var student_id=  <?php //echo "$admission_student_id"; 
                                ?>;
            console.log(formData);

            // $valid_status = $("#payment_detail").valid();
            // if ($valid_status) {
            e.preventDefault();
            var path = '<?php echo "$base_url_api"; ?>';

            $.ajax({
                url: path + 'pay2.php',
                type: 'post',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);

                    $('#preloader').show();
                    var easebuzzCheckout = new EasebuzzCheckout(
                        'CRGPBR3D4U', 'prod');
                    //  var easebuzzCheckout = new EasebuzzCheckout(
                    //   '2PBP7IABZ2', 'test'); 

                    var access_key = JSON.parse(data.data).access_key;
                    // alert(access_key);
                    var options = {
                        access_key: access_key,
                        onResponse: (response) => {
                            $('#preloader').hide();
                            var response = response;
                            var student_id = <?php echo "$admission_student_id"; ?>;
                            $.ajax({
                                url: path + 'checkout2.php',
                                type: 'post',
                                data: {
                                    "response": response,
                                    student_id: student_id
                                },
                                success: function(data) {
                                    // location.reload();
                                    $('#preloader').hide();
                                    // alert("Payment in process");
                                    if (data.status === 1) {
                                        alert("Payment Successfully done");
                                    } else {
                                        alert("Payment In Process. Please Check Your Mail.");
                                    }
                                },
                                fail: function(xhr, textStatus, errorThrown) {
                                    alert('request failed');
                                }
                            });
                        },
                        theme: "#ba2a21"
                    }
                    easebuzzCheckout.initiatePayment(options);
                },


                error: function(xhr, status, error) {
                    console.log('AJAX call error:', status, error);
                    // Handle the error here
                }
            });
            // }
            /*  alert("hii"); */

        });
        // online payment ajax call
        //         $('#ebz-checkout-btn').on('click', function(e) {
        //             $('#preloader').show();
        //             var formData = new FormData(document.getElementById("payment_detail"));
        // //             formData.forEach((value, key) => {
        // //     console.log(key + ": " + value);
        // // });
        //             // $valid_status = $("#payment_detail").valid();
        //             // alert("hello");
        //             // if ($valid_status) {
        //                 e.preventDefault();
        //                 var path = '<?php echo "$base_url_api"; ?>';
        //                 $.ajax({
        //                     url: path + 'pay2.php',
        //                     type: 'post',
        //                     data: formData,
        //                     dataType: 'json',
        //                     cache: false,
        //                     contentType: false,
        //                     processData: false,
        //                     success: function(data) {

        //                         $('#preloader').show();
        //                         var easebuzzCheckout = new EasebuzzCheckout(
        //                             '2PBP7IABZ2', 'test');
        //                         /*   var easebuzzCheckout = new EasebuzzCheckout(
        //                               '10PBP71ABZ2', 'test'); */

        //                         var access_key = JSON.parse(data.data).access_key;
        //                         // alert(access_key);
        //                         var options = {
        //                             access_key: access_key,
        //                             onResponse: (response) => {
        //                                 $('#preloader').hide();
        //                                 var response = response;
        //                                 $.ajax({
        //                                     url: path + 'checkout2.php',
        //                                     type: 'post',
        //                                     data: {
        //                                         "response": response
        //                                     },
        //                                     success: function(data) {

        //                                         location.reload();
        //                                         $('#preloader').hide();

        //                                     },
        //                                     fail: function(xhr, textStatus, errorThrown) {
        //                                         alert('request failed');
        //                                     }
        //                                 });
        //                             },
        //                             theme: "#ba2a21"
        //                         }
        //                         easebuzzCheckout.initiatePayment(options);
        //                     }

        //                 });
        //             // }
        //             /*  alert("hii"); */

        //         });
    </script>

</body>

</html>