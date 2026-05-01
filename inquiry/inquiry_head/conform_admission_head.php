<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_GET['url_for'])) {
    $url_for = mysqli_real_escape_string($con, $_GET['url_for']);
    $url_for = validate_data($url_for);
} else {
    $url_for = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
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
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

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
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
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
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Sr.no</b></th>
                                            <th scope="row" style="color:black;"><b>GR Number</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <!--<th scope="row" style="color:black;"><b>Mobile Number</b></th>-->
                                            <th scope="row" style="color:black;"><b>Password</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Status</b></th>
                                            <th scope="row" style="color:black;"><b>Account Office Status</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <!--<th scope="row" style="color:black;"><b>Fill Admission Form</b></th>-->
                                        
                                            <!-- <th scope="row" style="color:black;"><b>Edit Documents</b></th> -->
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                       $sql = "SELECT 
                                            stu.password, stu.admission_status, stu.id, stu.gr_number, stu.comment, stu.program_id,
                                            stu.first_name, stu.middle_name, stu.last_name, stu.email, stu.mobile_number,
                                            stu.status, stu.payment_status, stu.payment_mode, stu.account_office_status,
                                            stu.created_at, 
                                            pro.name AS program_name, 
                                            level.name AS level_name, 
                                            faculty.name AS faculty_name 
                                        FROM tbl_admission_student AS stu 
                                        LEFT JOIN tbl_pac_form pac ON stu.id = pac.student_id 
                                        LEFT JOIN tbl_program pro ON stu.program_id = pro.id 
                                        LEFT JOIN tbl_faculty faculty ON stu.faculty_id = faculty.id 
                                        LEFT JOIN tbl_level level ON stu.level_id = level.id 
                                        WHERE 
                                            stu.is_active = 1 AND 
                                            stu.is_delete = 0 AND 
                                            stu.payment_status = 'success'  ";
                                            
                                        if ($role_id == '14' && $user_email != 'dggohil@gmiu.edu.in' ){ 
                                            $sql .= "AND stu.faculty_id = ? AND stu.program_id IN ($program_id)";
                                        }
                                        if ($role_id == '14' && $user_email == 'dggohil@gmiu.edu.in') {
                                             $sql .= " AND EXISTS (
                                                SELECT 1 FROM tbl_pac_form pac 
                                                WHERE pac.student_id = stu.id AND pac.mode = 'SM'
                                             )";
                                         }
                                        // Step 2: Add dynamic conditions
                                        if ($url_for != "") {
                                            if ($url_for == "admission_approved_student") {
                                                $sql .= " AND stu.admission_status = 'approved'";
                                            }
                                        } else {
                                            $sql .= " AND stu.account_office_status != 'rejected'";
                                        }
                                        
                                        // Step 3: Prepare and execute
                                       if ($role_id == '14' && $user_email != 'dggohil@gmiu.edu.in') {
                                            $cmd = $con->prepare($sql);
                                            $cmd->bind_param("i", $faculty_id);
                                        } else {
                                            $cmd = $con->prepare($sql); // No faculty_id binding required
                                        }
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        $sr = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $sr++;
                                            $stu_id = !empty($row['id']) ? $row['id'] : "<b>N/A</b>";
                                            $stu_gr_number = !empty($row['gr_number']) ? $row['gr_number'] : "<b>N/A</b>";
                                            $stu_program_id = !empty($row['program_id']) ? $row['program_id'] : "<b>N/A</b>";
                                            $comment = !empty($row['comment']) ? $row['comment'] : "<b>N/A</b>";
                                            $stu_first_name = !empty($row['first_name']) ? $row['first_name'] : "<b>N/A</b>";
                                            $stu_middle_name = !empty($row['middle_name']) ? $row['middle_name'] : "<b>N/A</b>";
                                            $stu_last_name = !empty($row['last_name']) ? $row['last_name'] : "<b>N/A</b>";
                                            $stu_email = !empty($row['email']) ? $row['email'] : "<b>N/A</b>";
                                            $stu_mobile_number = !empty($row['mobile_number']) ? $row['mobile_number'] : "<b>N/A</b>";
                                            $stu_cluster_status = !empty($row['status']) ? $row['status'] : "<b>N/A</b>";
                                            $register_date = !empty($row['created_at']) ? $row['created_at'] : "<b>N/A</b>";
                                            $stu_payment_status = !empty($row['payment_status']) ? $row['payment_status'] : "<b>N/A</b>";
                                            $stu_account_office_status = !empty($row['account_office_status']) ? $row['account_office_status'] : "<b>N/A</b>";
                                            $stu_payment_mode = !empty($row['payment_mode']) ? $row['payment_mode'] : "<b>N/A</b>";
                                            $stu_program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $stu_level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $stu_faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $stu_admission_status = !empty($row['admission_status']) ? $row['admission_status'] : "<b>N/A</b>";
                                            $password = !empty($row['password']) ? $row['password'] : "<b>N/A</b>";
                                            $name = $stu_first_name . ' ' . $stu_middle_name . ' ' . $stu_last_name;


                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $sr; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $stu_gr_number; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $name; ?>
                                                </td>
                                                <!--<td scope="row">-->
                                                    <?php //echo $stu_mobile_number; ?>
                                                <!--</td>-->

                                                <td scope="row">
                                                    <?php echo $password; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $stu_email; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $stu_payment_status; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $stu_account_office_status; ?>
                                                </td>


                                                <td scope="row">
                                                    <?php echo $stu_faculty_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $stu_level_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $stu_program_name; ?>
                                                </td>
                                                <!--<td scope="row">-->
                                                <!--    <form action="admission_form.php" method="post">-->
                                                <!--        <input type="hidden" name="stu_id" value="<?php echo $stu_id; ?>">-->
                                                <!--        <button type="submit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>-->
                                                <!--    </form>-->
                                                <!--</td>-->
                                                <?php

                                                // if ($stu_account_office_status == "approved") {
                                                ?>

                                                <!-- <td scope="row">
                                                    <a href="student_edit.php?id=<?php //echo $stu_id; 
                                                                                    ?>" class="btn btn-primary" ><i class="fas fa-pencil-alt"></i></a>
                                                </td> -->
                                                <!-- education detail  -->
                                                <!-- <td scope="row">
                                                        <a href="student_edu_edit.php?id=<?php //echo $stu_id; 
                                                                                            ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    </td> -->
                                                <!-- document edit  -->
                                                <!-- <td scope="row">
                                                    <a href="student_document_edit.php?id=<?php // echo $stu_id; 
                                                                                            ?>" class="btn btn-primary"  ><i class="fas fa-pencil-alt"></i></a>
                                              </td> -->
                                                <?php // } else { 
                                                ?>

                                                <!-- <td scope="row">
                                                        <a href="student_edit.php?id=<?php //echo $stu_id; 
                                                                                        ?>" class="btn btn-primary" onclick="return false;"><i class="fas fa-pencil-alt"></i></a>
                                                    </td> -->
                                                <!-- education detail  -->
                                                <!-- <td scope="row">
                                                        <a href="student_edu_edit.php?id=<?php //echo $stu_id; 
                                                                                            ?>" class="btn btn-primary" onclick="return false;"><i class="fas fa-pencil-alt"></i></a>
                                                    </td> -->
                                                <!-- document edit  -->
                                                <!-- <td scope="row">
                                                    <a href="student_document_edit.php?id=<?php //echo $stu_id; 
                                                                                            ?>" class="btn btn-primary" onclick="return false;" ><i class="fas fa-pencil-alt"></i></a>
                                              </td> -->

                                                <?php //} 
                                                ?>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Sr.no</b></th>
                                            <th scope="row" style="color:black;"><b>GR Number</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <!--<th scope="row" style="color:black;"><b>Mobile Number</b></th>-->
                                            <th scope="row" style="color:black;"><b>Password</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Status</b></th>
                                            <th scope="row" style="color:black;"><b>Account Office Status</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <!--<th scope="row" style="color:black;"><b>Fill Admission Form</b></th>-->

                                            <!-- <th scope="row" style="color:black;"><b>Edit Documents</b></th> -->
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
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- footer -->
    <?php include '../include/importjs.php'; ?>
</body>
<script>
    $(document).ready(function() {
        $('.view-remarks').on('click', function() {
            // Get the inquiry ID from the data attribute
            var inquiryId = $(this).data('inquiry-id');

            // Make an AJAX request to fetch the remarks for the selected inquiry ID
            $.ajax({
                url: 'fetch_remarks.php', // Create a PHP script to fetch remarks
                method: 'POST',
                data: {
                    inquiryId: inquiryId
                },
                success: function(response) {
                    // Update the modal content with the fetched remarks
                    $('#modal-lg .modal-body').html(response);
                },
                error: function() {
                    alert('An error occurred while fetching remarks.');
                }
            });
        });
    });
</script>


<?php if ($role_id != 11 && $role_id != 12 && $role_id !=14){ ?>

<script>
  $(document).ready(function() {
    // Check if the DataTable is already initialized
    if ($.fn.DataTable.isDataTable('#acedemic')) {
      $('#acedemic').DataTable().destroy();
    }

    // Initialize the DataTable
    $('#acedemic').DataTable({
      "dom": 'lfrtip',
      "responsive": false,
      "lengthChange": false,
      "autoWidth": false
    });
  });
</script>


<?php } ?>
</html>