<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
                            <h1 class="m-0">Called Student List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Called Student List</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->


            <section class="content">
                <div class="container-fluid">

                    <!--   Faculty list code  -->
                    <div class="card">
                        <div class="card-header">


                            <span>
                                <center>
                                    <h5><b><i class="fa-solid fa-phone-volume"></i> Called Student List</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student ID</b></th>
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                            <th scope="row" style="color:black;"><b>School Name</b></th>
                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                            <th scope="row" style="color:black;"><b>Call Status</b></th>
                                            <th scope="row" style="color:black;"><b>Call Ratings</b></th>
                                            <th scope="row" style="color:black;"><b>Follow Needed</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Date</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Remark</b></th>
                                            <th scope="row" style="color:black;"><b>View Student detail</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = "1";
                                        $cmd = $con->prepare("SELECT 
                                        h.id AS id_h,
                                        h.call_datetime AS date,
                                        R.is_followup_need AS followup,
                                        R.followup_why_input AS followup_why_input,
                                        R.follow_up_date AS followup_date, 
                                        S.mobile_number AS mobile_number, 
                                        S.mobile_number2 AS mobile_number2, 
                                        S.last_school_name as last_school_name, 
                                        S.id AS id, 
                                        R.inq_student_id AS student_id, 
                                        CONCAT(S.first_name, ' ',S.middle_name ,'', S.last_name) AS student_name, 
                                        R.remarks AS call_remarks, 
                                        R.call_status AS call_status,
                                        CS.call_title AS call_status_title,
                                        CR.call_title AS call_rating_title
                                    FROM 
                                        tbl_inquiry_remarks R
                                    JOIN 
                                        tbl_inquiry_student S ON R.inq_student_id = S.inq_student_id
                                    LEFT JOIN 
                                        tbl_call_status CS ON R.call_status = CS.id
                                    LEFT JOIN 
                                        tbl_call_status CR ON R.call_rating = CR.id
                                    LEFT JOIN 
                                        tbl_call_history h ON R.inq_student_id = h.inq_student_id
                                                           AND DATE(h.call_datetime) = DATE(NOW()) 
                                    WHERE 
                                        R.staff_id = ?
                                        and 
                                        DATE(R.created_at) = CURRENT_DATE
                                        and 
                                        h.staff_id = ?;");
                                //         $cmd = $con->prepare("SELECT  R.is_followup_need as followup,
                                //         R.followup_why_input as followup_why_input,
                                //         R.follow_up_date as followup_date, 
                                //         S.mobile_number AS mobile_number, 
                                //         S.mobile_number2 AS mobile_number2, 
                                //         S.id AS id, 
                                //         R.inq_student_id AS student_id, 
                                //         CONCAT(S.first_name, ' ', S.last_name) AS student_name, 
                                //         R.remarks AS call_remarks, 
                                //         R.call_status AS call_status,
                                //         CS.call_title AS call_status_title,
                                //         CR.call_title AS call_rating_title
                                //  FROM tbl_inquiry_remarks R
                                //  JOIN tbl_inquiry_student S ON R.inq_student_id = S.inq_student_id
                                //  LEFT JOIN tbl_call_status CS ON R.call_status = CS.id
                                //  LEFT JOIN tbl_call_status CR ON R.call_rating = CR.id
                                //  LEFT JOIN tbl_call_history h ON R.staff_id = h.staff_id
                                //  WHERE R.staff_id = ? AND DATE(h.call_datetime) = DATE(NOW())");
                                        $cmd->bind_param("ii", $staff_id , $staff_id);  // Assuming $staff_id is an integer
                                        $cmd->execute();

                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $student_id = $row['student_id'];
                                            $student_name = !empty($row['student_name']) ? $row['student_name'] : "<b>N/A</b>";
                                            $call_remarks = !empty($row['call_remarks']) ? $row['call_remarks'] : "<b>N/A</b>";
                                            $mobile_number = !empty($row['mobile_number']) ? $row['mobile_number'] : "<b>N/A</b>";
                                            $mobile_number2 = !empty($row['mobile_number2']) ? $row['mobile_number2'] : "<b>N/A</b>";
                                            $call_status = !empty($row['call_status']) ? $row['call_status'] : "<b>N/A</b>";
                                            $followup = !empty($row['followup']) ? $row['followup'] : "<b>N/A</b>";
                                            $followup_date =  !empty($row['followup_date']) ? $row['followup_date'] : "<b>N/A</b>";
                                            $followup_why_input =  $row['followup_why_input'];
                                            $last_school_name = !empty($row['last_school_name']) ? $row['last_school_name'] : "<b>N/A</b>";
                                            $call_status_title = !empty($row['call_status_title']) ? $row['call_status_title'] : "<b>N/A</b>";
                                            $call_rating_title = !empty($row['call_rating_title']) ? $row['call_rating_title'] : "<b>N/A</b>";

                                            // $faculty_is_active = $row['faculty_is_active'];
                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $student_id; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $student_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $mobile_number; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $mobile_number2; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $last_school_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $call_remarks; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php
                                                    echo $call_status_title
                                                    ?>


                                                </td>
                                                <td scope="row">
                                                    <?php
                                                    echo $call_rating_title
                                                    ?>


                                                </td>
                                                <td scope="row">
                                                    <?php if ($followup == 1) {
                                                        echo 'Yes';
                                                    } else {
                                                        echo "No";
                                                    }
                                                    ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $followup_date; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $followup_why_input; ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="view_student_detail.php?id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student ID</b></th>
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                            <th scope="row" style="color:black;"><b>School Name</b></th>
                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                            <th scope="row" style="color:black;"><b>Call Status</b></th>
                                            <th scope="row" style="color:black;"><b>Call Ratings</b></th>
                                            <th scope="row" style="color:black;"><b>Follow Needed</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Date</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Remark</b></th>
                                            <th scope="row" style="color:black;"><b>View Student detail</b></th>
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

    <?php include '../include/importjs.php'; ?>
</body>

<?php if ($role_id != 11 && $role_id != 12){ ?>

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