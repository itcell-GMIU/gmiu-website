<?php
// Include the checklogin.php file
include '../include/checklogin.php';
//if (isset($_GET['id2'])) {
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

            <!-- /.content-header -->

            <!-- Main content -->

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Student Inquiry Remark List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Student Inquiry Remark</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Student Inquiry Remark</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if ($role_id == 14) {
                            ?>
                                <a class="btn btn-primary" style="margin-left: 90%;" href="../inquiry_head/assign_student.php"><i class="fa-solid"></i>Student Inquiry</a>
                            <?php
                            } elseif ($role_id == 15) {
                            ?>
                                <a class="btn btn-primary" style="margin-left: 90%;" href="../staff/view_assign_student.php"><i class="fa-solid"></i>Student Inquiry</a>
                            <?php } elseif ($role_id == 16) {
                            ?>
                                <a class="btn btn-primary" style="margin-left: 90%;" href="../counselor/student_list.php"><i class="fa-solid"></i>Student Inquiry</a>
                            <?php } elseif ($role_id == 12) {
                            ?>
                                <a class="btn btn-primary" style="margin-left: 90%;" href="../students/student_view.php"><i class="fa-solid"></i>Student Inquiry</a>
                            <?php } ?>

                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Inquiry ID</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Inquiry Staff</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Inquiry Remark Date</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Call Status</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Call Rating</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                        </tr>
                                    </thead><?php

                                            $inq_student_id2 = $_GET['id2'];
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT pro.id as id, pro.remark_date as date, staff.name as name ,pro.staff_id as staff_id, pro.remarks as remarks, pro.inq_student_id as inq_student_id , pro.call_status as call_status, pro.call_rating as call_rating FROM tbl_inquiry_remarks as pro LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id  LEFT JOIN tbl_call_status CS ON pro.call_status = CS.id
                                            LEFT JOIN tbl_call_status CR ON pro.call_rating = CR.id WHERE pro.is_delete = ? AND pro.inq_student_id = ?");
                                            $cmd->bind_param("is", $status, $inq_student_id2);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id'];
                                                $inq_student_id = $row['inq_student_id'];
                                                $date = $row['date'];
                                                $staff_id = $row['staff_id'];
                                                $staff_name = $row['name'];
                                                $remarks = $row['remarks'];
                                                $call_status_title = !empty($row['call_status']) ? $row['call_status'] : "<b>N/A</b>";
                                                $call_rating_title = !empty($row['call_rating']) ? $row['call_rating'] : "<b>N/A</b>";

                                                // Additional variables can be added here based on your database columns.
                                            ?>
                                        <tbody>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo  $inq_student_id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $staff_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $date; ?>
                                                </td>
                                                 <td scope="row">

                                                    <?php  
                                                    $cmd = $con->prepare("SELECT call_title from tbl_call_status  where id= $call_status_title and call_type=1");
                                                    $cmd->execute();
                                                    $result1 = $cmd->get_result();
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                    echo $row1['call_title']; }?>
                                                </td>
                                                <td scope="row">
                                                <?php  
                                                    $cmd = $con->prepare("SELECT call_title from tbl_call_status  where id= $call_rating_title and call_type=2");
                                                    $cmd->execute();
                                                    $result1 = $cmd->get_result();
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                    echo $row1['call_title']; }?>
                                                </td>

                                                <!--<td scope="row">-->
                                                <!--    <?php //echo $call_status_title ?>-->
                                                <!--</td>-->
                                                <!--<td scope="row">-->
                                                <!--    <?php //echo $call_rating_title ?>-->
                                                <!--</td>-->
                                                <td scope="row">
                                                    <?php echo  $remarks; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php
                                            }                                                       ?>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Inquiry ID</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Inquiry Staff</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Inquiry Remark Date</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Call Status</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Call Rating</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
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


</html>
<?php
//}
?>