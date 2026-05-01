<?php
include '../include/checklogin.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define a fixed unique ID for the form submission
$fixed_unique_id = 'form_2';  // Change this ID according to your needs

if (isset($_POST['submit'])) {
    // Use the fixed unique ID
    $unique_id = $fixed_unique_id;
    
    // Retrieve form inputs
    $report_ename = $_POST['report_ename'];
    $company_name = $_POST['company_name'];
    $location = $_POST['location'];
    $date_input = $_POST['date'];
    $report_file = $_FILES['report'];

    // Format the date as "03-July-2024 Wednesday"
    $timestamp = strtotime($date_input);
    $date = date('d-F-Y l', $timestamp);

    // Handle file upload
    $upload_dir = '../uploads/event_report/'; // Directory to store the uploaded files
    $report_filename = basename($report_file['name']);
    $report_filepath = $upload_dir . $report_filename;

    // Validate the inputs
    if (!empty($report_ename) && !empty($company_name) && !empty($location) && !empty($date_input) && !empty($report_file['name'])) {
        // Move the uploaded file to the specified directory
        if (move_uploaded_file($report_file['tmp_name'], $report_filepath)) {
            // Insert the form data into the database with the fixed unique ID
            $stmt = $con->prepare("INSERT INTO tbl_event (unique_id, report_ename, company_name, location, date, report) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $unique_id, $report_ename, $company_name, $location, $date, $report_filepath);

            if ($stmt->execute()) {
                $_SESSION['status'] = "Report Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
            } else {
                $_SESSION['status'] = "Report Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
            }

            $stmt->close();
        } else {
            $_SESSION['status'] = "Failed to upload the report file.";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
        }
    } else {
        $_SESSION['status'] = "Please fill in all required fields.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
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
        p {
            margin: 0;
        }

        #upload__inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .upload__btn {
            display: inline-block;
            font-weight: 600;
            color: #fff;
            text-align: center;
            min-width: 116px;
            padding: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid;
            background-color: #4045ba;
            border-color: #4045ba;
            border-radius: 10px;
            line-height: 26px;
            font-size: 14px;
        }

        .upload__btn:hover {
            background-color: unset;
            color: #4045ba;
            transition: all 0.3s ease;
        }

        .upload__btn-box {
            margin-bottom: 10px;
        }

        .upload__img-wrap {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .upload__img-box {
            width: 200px;
            padding: 0 10px;
            margin-bottom: 12px;
        }

        .upload__img-close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 10px;
            right: 10px;
            text-align: center;
            line-height: 24px;
            z-index: 1;
            cursor: pointer;
        }

        .upload__img-close:after {
            content: "✖";
            font-size: 14px;
            color: white;
        }

        .img-bg {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            padding-bottom: 100%;
        }
    </style>

    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../admin_assets/plugins/dropzone/min/dropzone.min.css">
</head>



<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;

        </div>
    </div>
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Event Report</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Event Report</li>

                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Add Event Report</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="report_ename">Report Name<span style="color: red;">*</span></label>
                                            <input type="text" name="report_ename" class="form-control" id="report_ename" placeholder="Enter report name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="company_name">Company Name<span style="color: red;">*</span></label>
                                            <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Enter company name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="location">Location<span style="color: red;">*</span></label>
                                            <input type="text" name="location" class="form-control" id="location" placeholder="Enter location" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="date" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="report">Report File<span style="color: red;">*</span></label>
                                            <input type="file" name="report" class="form-control" id="report" required>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>

    <!-- dropzonejs -->
    <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
</body>

</html>
