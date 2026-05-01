<?php
include './include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">

    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">-->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <!-- wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Student Inquiry List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Student Inquiry</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Program list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Student Inquiry</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Sr.no</b></th>
                                            <th scope="row" style="color:black;"><b>inquiry Id</b></th>
                                            <th scope="row" style="color:black;"><b>First Name</b></th>
                                            <th scope="row" style="color:black;"><b>middle Name</b></th>
                                            <th scope="row" style="color:black;"><b>Last Name</b></th>
                                            <th scope="row" style="color:black;"><b>Gender</b></th>
                                            <th scope="row" style="color:black;"><b>last school name</b></th>
                                            <th scope="row" style="color:black;"><b>Date Of Birth</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Last Exam</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Last Exam Mark</b></th> -->
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Assign Staff</b></th>
                                            <th scope="row" style="color:black;"><b>Call count</b></th>
                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                            <th scope="row" style="color:black;"><b>Action</b></th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Id</b></th>

                                            <th scope="row" style="color:black;"><b>inquiry Id</b></th>
                                            <th scope="row" style="color:black;"><b>First Name</b></th>
                                            <th scope="row" style="color:black;"><b>middle Name</b></th>
                                            <th scope="row" style="color:black;"><b>Last Name</b></th>
                                            <th scope="row" style="color:black;"><b>Gender</b></th>
                                            <th scope="row" style="color:black;"><b>last school name</b></th>
                                            <th scope="row" style="color:black;"><b>Date Of Birth</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Last Exam</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Last Exam Mark</b></th> -->
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Assign Staff</b></th>
                                            <th scope="row" style="color:black;"><b>Call count</b></th>
                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                            <th scope="row" style="color:black;"><b>Action</b></th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- footer -->
    <?php include 'include/importjs.php'; ?>
</body>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "fetch_student_data.php", // Create this file to handle data fetching
                "type": "POST",
                //  "dataType": "json",
                "error": function (xhr, error, code) {
                    console.log("Error details: ", xhr.responseText);
                }
            },
            "pageLength": 100, // Number of records per page
            "lengthMenu": [[100, 200, 500, -1], [100, 200, 500, "All"]], // Customize page length options
            "searching": true,
            "columns": [
                { "data": "sr_no" },
                { "data": "inq_student_id" },
                { "data": "first_name" },
                { "data": "middle_name" },
                { "data": "last_name" },
                { "data": "gender" },
                { "data": "last_school_name" },
                { "data": "dob" },
                { "data": "mobile_number" },
                { "data": "mobile_number2" },
                { "data": "email" },
                { "data": "faculty_name" },
                { "data": "level_name" },
                { "data": "program_name" },
                { "data": "last_exam_name" },
                { "data": "is_online" },
                { "data": "staff_name" },
                { "data": "call_count" },
                { "data": "remarks" },
                { "data": "actions" }
            ]
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.view-remarks').on('click', function () {
            // Get the inquiry ID from the data attribute
            var inquiryId = $(this).data('inquiry-id');

            // Make an AJAX request to fetch the remarks for the selected inquiry ID
            $.ajax({
                url: 'fetch_remarks.php', // Create a PHP script to fetch remarks
                method: 'POST',
                data: {
                    inquiryId: inquiryId
                },
                success: function (response) {
                    // Update the modal content with the fetched remarks
                    $('#modal-lg .modal-body').html(response);
                },
                error: function () {
                    alert('An error occurred while fetching remarks.');
                }
            });
        });
    });
</script>


</html>