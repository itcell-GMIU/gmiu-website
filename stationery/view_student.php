<?php
include './include/checklogin.php';
if (isset($_GET['url_level_id']) && $_GET['url_level_id'] != "") {
    $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id);
    $query = "SELECT name as level_name FROM tbl_level WHERE id= $url_level_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $level_name = $row['level_name'];
    } else {
        $level_name = "";
    }
} else {
    $url_level_id = "";
    $level_name = "";
}


if (isset($_GET['url_for'])) {
    $url_for = mysqli_real_escape_string($con, $_GET['url_for']);
    $url_for = validate_data($url_for);
} else {
    $url_for = "";
}

if (isset($_GET['url_faculty_id']) && $_GET['url_faculty_id'] != "") {

    $url_faculty_id = mysqli_real_escape_string($con, $_GET['url_faculty_id']);
    $url_faculty_id = validate_data($url_faculty_id);
    // if (isset($_GET['url_faculty_id'])) {
    $url_faculty_id = $_GET['url_faculty_id'];
    $query = "SELECT name as faculty_name FROM tbl_faculty WHERE id= $url_faculty_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_name = "";
    $url_faculty_id = "";
}






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">



        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                            <h1 class="m-0">View <?php
                                                    if ($url_for == 'pending') {
                                                        echo "Stationery Status Pending";
                                                    } elseif ($url_for == ' approved') {
                                                        echo "Stationery Status Approved";
                                                    } elseif ($url_for == 'all') {
                                                        echo "Total";
                                                    }
                                                    ?>
                                Student

                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View <?php
                                                                        if ($url_for == 'pending') {
                                                                            echo "Stationery Status Pending";
                                                                        } elseif ($url_for == ' approved') {
                                                                            echo "Stationery Status Approved";
                                                                        } elseif ($url_for == 'all') {
                                                                            echo "Total";
                                                                        }
                                                                        ?>
                                    Student</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Default box -->
                    <div class="card mb-3">
                        <div class="card-header">

                            <i class="far fa-hand-pointer"></i>

                            <span> <b>Select Faculty to View Students</b></span>

                        </div>
                        <form method="GET" action="">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-label-group">

                                                <input type="hidden" name="url_for" value="<?php echo $url_for; ?>">
                                                <select id="faculty_id" name="url_faculty_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                    <option value="">---Select Faculty---</option>

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
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-label-group">
                                                <select name="url_level_id" id="level_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>


                    <!--   student list code  -->


                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>
                                            <?php echo $faculty_name . "-" . $level_name; ?>
                                            Students </b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">

                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Student Gr Number</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>Name</b></th>
                                            <th scope="row" style="color: black;"><b>Contact</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Payment Date and Time</b></th> -->
                                            <?php
                                            if ($url_for == "approved") {
                                                echo '<th scope="row" style="color:black;"><b>Approved Date</b></th>';
                                            } else if ($url_for == "pending") {
                                                echo ' <th scope="row" style="color:black;"><b>Uniform Fees Paid</b></th>';
                                            } else if ($url_for == "all") {
                                                echo ' <th scope="row" style="color:black;">Uniform Status</b></th>';
                                            }
                                            ?>

                                            <th scope="row" style="color:black;"><b>Account Offline Comment</b></th>


                                        </tr>

                                    </thead>
                                    <script src="../admin_assets/plugins/jquery/jquery.min.js"></script>
                                    <tbody>
                                        <?php

                                        $cmd = "Select stu.uniform_status, stu.token_amount,stu.id, stu.payment_date_time,stu.account_office_comment,stu.account_office_approve_reject_date,stu.gr_number,stu.first_name,stu.program_id,stu.middle_name,stu.last_name,stu.email,stu.mobile_number,stu.payment_status,stu.payment_mode,stu.account_office_status,stu.created_at,pro.name as program_name,level.name as level_name,faculty.name as faculty_name from tbl_admission_student as stu LEFT JOIN tbl_program pro
                                                ON stu.program_id = pro.id LEFT JOIN tbl_faculty as faculty
                                                ON stu.faculty_id = faculty.id LEFT JOIN tbl_level as level
                                                ON stu.level_id = level.id Where stu.is_active=1 AND stu.is_delete=0";
                                        if ($url_for != "") {
                                            if ($url_for == "pending") {
                                                $cmd = $cmd . " AND stu.uniform_status  = '0'";
                                            } elseif ($url_for == "approved") {
                                                $cmd = $cmd . " AND stu.uniform_status ='1' ";
                                            }
                                        }
                                        if ($url_faculty_id != "") {
                                            $cmd = $cmd . " AND stu.faculty_id = '$url_faculty_id' ";
                                        }
                                        if ($url_level_id != "") {
                                            $cmd = $cmd . " AND stu.level_id = '$url_level_id' ";
                                        }
                                        /*   print_r($cmd);
                                        exit(); */
                                        $stmt = $con->prepare($cmd);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $rows = $result->num_rows;
                                        if ($rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $stu_id = $row['id'];
                                                $stu_gr_number = $row['gr_number'];
                                                $stu_program_id = $row['program_id'];
                                                $stu_first_name = $row['first_name'];
                                                $stu_middle_name = $row['middle_name'];
                                                $stu_last_name = $row['last_name'];
                                                $stu_email = $row['email'];
                                                $stu_mobile_number = $row['mobile_number'];
                                                $register_date = $row['created_at'];
                                                $stu_program_name = $row['program_name'];
                                                $stu_level_name = $row['level_name'];
                                                $account_office_comment = $row['account_office_comment']  ? $row['account_office_comment'] : "<b>N/A</b>";
                                                $uniform_status = $row['uniform_status'];
                                                if ($uniform_status == 0) {
                                                    $status = "Pending";
                                                } else if ($uniform_status == 1) {
                                                    $status = "Completed";
                                                }

                                        ?>
                                                <tr align="center">

                                                    <td scope="row"><?php echo $stu_id; ?></td>
                                                    <td scope="row"><?php echo $stu_gr_number; ?></td>
                                                    <td scope="row"><?php echo $stu_program_name; ?></td>

                                                    <td scope="row"><?php echo $stu_first_name; ?>
                                                        <?php echo $stu_middle_name; ?>
                                                        <?php echo $stu_last_name; ?></td>
                                                    <td scope="row"><?php echo $stu_email; ?>
                                                        <?php echo "<br>"; ?>
                                                        <?php echo $stu_mobile_number; ?>
                                                    </td>
                                                    <?php
                                                    if ($url_for == "approved") {
                                                    ?>
                                                        <td scope="row"><?php echo $stu_id; ?></td>
                                                    <?php
                                                    } else if ($url_for == "pending") {
                                                    ?>
                                                        <td scope="row"><button id="approved<?php echo $stu_id ?>" data-name="1" data-student_id="<?php echo $stu_id ?>" class="btn btn-success approve_reject"><i class="fas fa-check"></i></button>
                                                        </td>
                                                    <?php
                                                    } else if ($url_for == "all") {
                                                    ?>
                                                         <td scope="row"><?php echo $status; ?></td>
                                                    <?php
                                                    }
                                                    ?>


                                                    <td scope="row"><?php echo $account_office_comment; ?></td>
                                                </tr>

                                        <?php
                                            }
                                        }

                                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">

                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Student Gr Number</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>Name</b></th>
                                            <th scope="row" style="color: black;"><b>Contact</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Payment Date and Time</b></th> -->
                                            <?php
                                            if ($url_for == "approved") {
                                                echo '<th scope="row" style="color:black;"><b>Approved Date</b></th>';
                                            } else if ($url_for == "pending") {
                                                echo ' <th scope="row" style="color:black;">Uniform Fees Paid</b></th>';
                                            }   else if ($url_for == "all") {
                                                echo ' <th scope="row" style="color:black;">Uniform Status</b></th>';
                                            }
                                            ?>

                                            <th scope="row" style="color:black;"><b> Account Offline Comment</b></th>


                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <?php

                    ?>
                </div>
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

    <?php include 'include/importjs.php'; ?>

    <script>
        $(".approve_reject").click(function(e) {
            var name = $(this).attr('data-name');
            var student_id = $(this).attr('data-student_id');
            // e.preventDefault();
            var formData = new FormData();
            formData.append('name', name);
            formData.append('student_id', student_id);

            swal({
                title: 'Are you sure?',
                text: "Do you want to continue?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Continue'
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: 'approve_reject_api.php',
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Student is ' + data.message,
                                });
                                var locations = $(location).attr('href');

                                window.location = locations
                                // load_student_data(data.message, student_id);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                });
                            }

                            window.location = locations
                            // load_student_data(data.message, student_id);
                        }
                    });
                }

            });
        });
    </script>



</body>

</html>
<script type="text/javascript">
    $('#faculty_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        // alert("hii");
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        })
    });
</script>