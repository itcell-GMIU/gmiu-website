<?php
include './include/config.php';
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
</head>

<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Assign Inquiry</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Assign Inquiry</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <?php if ($_SESSION['role_id'] == 12 || $_SESSION['role_id'] == 57 || $_SESSION['role_id'] == 60): ?>
                    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-blue h4">Assign Inquiry by Range</h4>
                            </div>
                        </div>

                        <div class="input-group-append my-2">
                            <button type="button" id="sendOtpBtn" class="btn btn-info">Send OTP</button>
                        </div>

                        <!-- AJAX Assignment Form -->
                        <form id="multiAssignForm" method="POST">
                            <div class="row mt-3">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Starting Inquiry ID <span class="text-danger">*</span></label>
                                        <input type="text" name="starting_inquiry" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Ending Inquiry ID <span class="text-danger">*</span></label>
                                        <input type="text" name="ending_id" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Select Faculty <span class="text-danger">*</span></label>
                                        <select class="custom-select" name="staff_id" id="staff_id" required>
                                            <option value="">Choose...</option>
                                            <?php
                                            $result = $con->query("SELECT id, name FROM tbl_staff WHERE is_delete = '0' and is_active='1' and role_id IN(15,16)");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- ✅ Added Inquiry Type Dropdown -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Add Inquiry Type <span class="text-danger">*</span></label>
                                        <select class="custom-select" name="inquiry_type" required>
                                            <option value="">Select Type</option>
                                            <?php if ($role_id == 12) { ?>
                                                <option value="1">Website</option>
                                                <option value="2">Whatsapp</option>
                                                <option value="3">Other</option>
                                                <option value="4">Walk In</option>
                                                <option value="5">E-Mail</option>
                                            <?php } elseif ($role_id == 57) { ?>
                                                <option value="6">Confidential Data</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- ✅ End Inquiry Type Dropdown -->

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Completed Study <span class="text-danger">*</span></label>
                                        <select id="completedStudy" name="completed_study" class="custom-select">
                                            <option selected="">Choose...</option>
                                            <option value="1">10th</option>
                                            <option value="2">12th Commerce</option>
                                            <option value="3">12th Science (A Group)</option>
                                            <option value="4">12th Science (B Group)</option>
                                            <option value="5">12th Arts</option>
                                            <option value="6">Under Graduate</option>
                                            <option value="7">Post Graduate</option>
                                            <option value="8">Diploma</option>
                                            <option value="9">ITI</option>
                                            <option value="10">Diploma Pharmacy</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Enter OTP <span class="text-danger">*</span></label>
                                        <input type="text" name="sentotp" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>


                    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-blue h4">Assign Single Inquiry</h4>
                            </div>
                        </div>
                        <form method="POST" id="singleAssignForm" class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Inquiry ID:</label>
                                        <input class="form-control" type="text" name="inquiry_id" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Faculty</label>
                                        <select class="custom-select" name="staff_id" required>
                                            <option value="">Choose...</option>
                                            <?php
                                            $result = $con->query("SELECT id, name FROM tbl_staff WHERE is_delete = '0' AND is_active='1' AND role_id IN(15,16)");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right"><button type="submit" name="insert" class="btn btn-primary">Assign
                                    Inquiry</button></div>
                        </form>
                    </div>

                    <?php
                    if ($_SESSION['role_id'] == 60): 
                    ?>
                    <?php 
                    // if (1 != 1):
                    ?>
                        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Reassign All Inquiries</h4>
                                </div>
                            </div>
                            <!-- The form ID must match the one targeted in the JavaScript -->
                            <form method="POST" class="mt-3" id="reassignAllForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>From Faculty (Source)</label>
                                            <select class="custom-select" name="old_staff_id" id="old_staff_id">
                                                <option value="">Choose...</option>
                                                <?php
                                                $result = $con->query("SELECT id, name FROM tbl_staff WHERE is_delete = '0' and is_active='1' and role_id IN(15,16,20)");
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>To Faculty (Destination)</label>
                                            <select class="custom-select" name="new_staff_id" id="new_staff_id">
                                                <option value="">Choose...</option>
                                                <?php
                                                $result = $con->query("SELECT id, name FROM tbl_staff WHERE is_delete = '0' and is_active='1' and role_id IN(15,16,20)");
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-danger" name="reassignsubmit">Reassign All</button>
                                </div>

                            </form>
                        </div>

                        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Reassign Single Inquiry</h4>
                                </div>
                            </div>
                            <form method="POST" id="singleReassignForm" class="mt-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Inquiry ID:</label>
                                            <input class="form-control" type="text" name="inquiry_id" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Faculty</label>
                                            <select class="custom-select" name="staff_id" required>
                                                <option value="">Choose...</option>
                                                <?php
                                                $result = $con->query("SELECT id, name FROM tbl_staff WHERE is_delete = '0' AND is_active='1' AND role_id IN(15,16)");
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right"><button type="submit" name="insert" class="btn btn-danger">Reassign
                                        Single</button></div>
                            </form>
                        </div>

                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $(function () {
            $('#multiAssignForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log(formData);

                swal({
                    title: 'Are you sure?',
                    text: "You want to assign these inquiries?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-danger margin-5',
                    confirmButtonText: 'Yes, assign it!',
                    cancelButtonText: 'No, cancel',
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: './extra/assign-inquiry-by-range.php',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            beforeSend: function () {
                                swal({
                                    title: 'Please wait...',
                                    text: 'Processing your request...',
                                    type: 'info',
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            },
                            success: function (response) {
                                if (response.status === 'exists') {
                                    swal({
                                        title: 'Already Assigned!',
                                        text: 'These inquiries are already assigned: ' + response.assigned_ids.join(', '),
                                        type: 'warning',
                                        confirmButtonClass: 'btn btn-warning margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                } else if (response.status === 'wrongotp') {
                                    swal({
                                        title: 'Invalid OTP!',
                                        text: 'The OTP you entered is incorrect. Please try again.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                } else if (response.status === 'idnotexist') {
                                    swal({
                                        title: 'Invalid Ids!',
                                        text: 'Starting Id or the Ending Id is not Present !!!',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                } else if (response.status === 'success') {
                                    swal({
                                        title: 'Assigned!',
                                        text: 'Inquiries have been assigned successfully.',
                                        type: 'success',
                                        confirmButtonClass: 'btn btn-success margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                    $('#multiAssignForm')[0].reset();
                                } else {
                                    swal({
                                        title: 'Error!',
                                        text: response.message || 'Something went wrong.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                swal({
                                    title: 'Server Error!',
                                    text: 'Unable to complete your request right now.',
                                    type: 'error',
                                    confirmButtonClass: 'btn btn-danger margin-5',
                                    buttonsStyling: false,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        swal({
                            title: 'Cancelled',
                            text: 'No inquiries were assigned.',
                            type: 'error',
                            confirmButtonClass: 'btn btn-danger margin-5',
                            buttonsStyling: false,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });


            $('#singleAssignForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                swal({
                    title: 'Are you sure?',
                    text: "You want to assign this inquiry to the selected faculty?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-danger margin-5',
                    confirmButtonText: 'Yes, assign it!',
                    cancelButtonText: 'No, cancel',
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: './extra/assign-single-inquiry.php', // ✅ your API path
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            beforeSend: function () {
                                swal({
                                    title: 'Please wait...',
                                    text: 'Processing your request...',
                                    type: 'info',
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    swal({
                                        title: 'Assigned!',
                                        text: 'Inquiry has been assigned successfully.',
                                        type: 'success',
                                        confirmButtonClass: 'btn btn-success margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                    $('#singleAssignForm')[0].reset();
                                }
                                else if (response.status === 'exists') {
                                    swal({
                                        title: 'Already Assigned!',
                                        text: response.message || 'This inquiry is already assigned to a staff.',
                                        type: 'warning',
                                        confirmButtonClass: 'btn btn-warning margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                                else if (response.status === 'notfound') {
                                    swal({
                                        title: 'Inquiry Not Found!',
                                        text: response.message || 'This inquiry ID does not exist.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                                else {
                                    swal({
                                        title: 'Error!',
                                        text: response.message || 'Something went wrong.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                swal({
                                    title: 'Server Error!',
                                    text: 'Unable to complete your request right now.',
                                    type: 'error',
                                    confirmButtonClass: 'btn btn-danger margin-5',
                                    buttonsStyling: false,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        swal({
                            title: 'Cancelled',
                            text: 'No inquiry was assigned.',
                            type: 'error',
                            confirmButtonClass: 'btn btn-danger margin-5',
                            buttonsStyling: false,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('#singleReassignForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                swal({
                    title: 'Are you sure?',
                    text: "You want to Reassign this inquiry to the selected faculty?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-danger margin-5',
                    confirmButtonText: 'Yes, assign it!',
                    cancelButtonText: 'No, cancel',
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: './extra/reassign-single-inquiry.php', // ✅ your API path
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            beforeSend: function () {
                                swal({
                                    title: 'Please wait...',
                                    text: 'Processing your request...',
                                    type: 'info',
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    swal({
                                        title: 'Assigned!',
                                        text: 'Inquiry has been assigned successfully.',
                                        type: 'success',
                                        confirmButtonClass: 'btn btn-success margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                    $('#singleAssignForm')[0].reset();
                                }
                                else if (response.status === 'notassigned') {
                                    swal({
                                        title: 'Inquiry Not Assigned!',
                                        text: response.message || 'This inquiry is Not Assigned to any staff.',
                                        type: 'warning',
                                        confirmButtonClass: 'btn btn-warning margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                                else if (response.status === 'notfound') {
                                    swal({
                                        title: 'Inquiry Not Found!',
                                        text: response.message || 'This inquiry ID does not exist.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                                else {
                                    swal({
                                        title: 'Error!',
                                        text: response.message || 'Something went wrong.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                swal({
                                    title: 'Server Error!',
                                    text: 'Unable to complete your request right now.',
                                    type: 'error',
                                    confirmButtonClass: 'btn btn-danger margin-5',
                                    buttonsStyling: false,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        swal({
                            title: 'Cancelled',
                            text: 'No inquiry was assigned.',
                            type: 'error',
                            confirmButtonClass: 'btn btn-danger margin-5',
                            buttonsStyling: false,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('#sendOtpBtn').on('click', function () {
                swal({
                    title: 'Send OTP?',
                    text: 'An OTP will be sent to your registered email address.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-danger margin-5',
                    confirmButtonText: 'Yes, send it!',
                    cancelButtonText: 'Cancel',
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: './extra/send-otp-mail.php', // ✅ your backend file that calls smtp_mailer()
                            type: 'POST',
                            dataType: 'json',
                            beforeSend: function () {
                                swal({
                                    title: 'Sending...',
                                    text: 'Please wait while we send the OTP.',
                                    type: 'info',
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    swal({
                                        title: 'OTP Sent!',
                                        text: 'Check your email inbox for the OTP.',
                                        type: 'success',
                                        confirmButtonClass: 'btn btn-success margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    swal({
                                        title: 'Failed!',
                                        text: response.message || 'Could not send OTP. Please try again.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                swal({
                                    title: 'Server Error!',
                                    text: 'Something went wrong while sending the OTP.',
                                    type: 'error',
                                    confirmButtonClass: 'btn btn-danger margin-5',
                                    buttonsStyling: false,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        swal({
                            title: 'Cancelled',
                            text: 'OTP not sent.',
                            type: 'error',
                            confirmButtonClass: 'btn btn-danger margin-5',
                            buttonsStyling: false,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $(document).ready(function () {
                // Attach a submit event handler to the reassign form
                $('#reassignAllForm').on('submit', function (e) {
                    // Prevent the default form submission (which causes a page reload)
                    e.preventDefault();

                    const formData = $(this).serialize();
                    const oldStaffId = $('#old_staff_id').val();
                    const newStaffId = $('#new_staff_id').val();

                    // --- Basic Validation ---
                    if (!oldStaffId || !newStaffId) {
                        swal({
                            title: 'Missing Information!',
                            text: 'Please select both a source and a destination faculty.',
                            type: 'warning',
                            confirmButtonClass: 'btn btn-warning margin-5',
                            buttonsStyling: false
                        });
                        return; // Stop the function
                    }

                    if (oldStaffId === newStaffId) {
                        swal({
                            title: 'Invalid Selection!',
                            text: 'The source and destination faculty cannot be the same.',
                            type: 'error',
                            confirmButtonClass: 'btn btn-danger margin-5',
                            buttonsStyling: false
                        });
                        return; // Stop the function
                    }

                    // Get the names for the confirmation message
                    const sourceFacultyName = $('#old_staff_id option:selected').text();
                    const destFacultyName = $('#new_staff_id option:selected').text();

                    // --- Confirmation Dialog ---
                    swal({
                        title: 'Are you sure?',
                        html: `You want to reassign all inquiries from <br><b>${sourceFacultyName}</b> to <b>${destFacultyName}</b>?`, // Use html property for line breaks
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-success margin-5',
                        cancelButtonClass: 'btn btn-danger margin-5',
                        confirmButtonText: 'Yes, reassign them!',
                        cancelButtonText: 'No, cancel',
                        buttonsStyling: false
                    }).then(function (result) {
                        if (result.value) {
                            // --- AJAX Request ---
                            $.ajax({
                                // You will need to create this PHP file to handle the backend logic
                                url: './extra/reassign-all-inquiries.php',
                                type: 'POST',
                                data: formData,
                                dataType: 'json',
                                beforeSend: function () {
                                    swal({
                                        title: 'Please wait...',
                                        text: 'Reassigning all inquiries...',
                                        type: 'info',
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });
                                },
                                success: function (response) {
                                    if (response.status === 'success') {
                                        swal({
                                            title: 'Reassigned!',
                                            text: 'All inquiries have been moved successfully.',
                                            type: 'success',
                                            confirmButtonClass: 'btn btn-success margin-5',
                                            buttonsStyling: false
                                        });
                                        // Reset the form after success
                                        $('#reassignAllForm')[0].reset();
                                    } else if (response.status === 'no_inquiries') {
                                        swal({
                                            title: 'No Inquiries Found',
                                            text: 'The source faculty has no inquiries to reassign.',
                                            type: 'warning',
                                            confirmButtonClass: 'btn btn-warning margin-5',
                                            buttonsStyling: false
                                        });
                                    }
                                    else {
                                        swal({
                                            title: 'Error!',
                                            text: response.message || 'Something went wrong on the server.',
                                            type: 'error',
                                            confirmButtonClass: 'btn btn-danger margin-5',
                                            buttonsStyling: false
                                        });
                                    }
                                },
                                error: function (error) {
                                    // console.log(error);
                                    swal({
                                        title: 'Server Error!',
                                        text: 'Unable to connect to the server. Please try again later.',
                                        type: 'error',
                                        confirmButtonClass: 'btn btn-danger margin-5',
                                        buttonsStyling: false
                                    });
                                }
                            });
                        } else if (result.dismiss === 'cancel') {
                            swal({
                                title: 'Cancelled',
                                text: 'The reassignment process was cancelled.',
                                type: 'error',
                                confirmButtonClass: 'btn btn-info margin-5',
                                buttonsStyling: false
                            });
                        }
                    });
                });
            });

        });
    </script>

</body>

</html>