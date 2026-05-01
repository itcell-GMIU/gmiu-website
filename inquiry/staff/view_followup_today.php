<?php include "../include/checklogin.php" ?>
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
                            <h1 class="m-0">Follow Up Student Call List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Follow Up Student Call List</li>
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
                                    <h5><b><i class="fa-solid fa-phone-volume"></i> Follow Up Student Call List</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Id</b></th>
                                            <th scope="row" style="color:black;"><b>inquiry Id</b></th>
                                            <th scope="row" style="color:black;"><b>First Name</b></th>
                                            <th scope="row" style="color:black;"><b>middle Name</b></th>
                                            <th scope="row" style="color:black;"><b>Last Name</b></th>
                                            <th scope="row" style="color:black;"><b>Gender</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Date Of Birth</b></th> -->
                                            <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                             <th scope="row" style="color:black;"><b>School Name</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Id</b></th>
                                            <th scope="row" style="color:black;"><b>Program ID</b></th>
                                            <th scope="row" style="color:black;"><b>Last Exam</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Last Exam Mark</b></th> -->
                                            <th scope="row" style="color:black;"><b>Mode</b></th>
                                            <th scope="row" style="color:black;"><b>follow Up Date</b></th>
                                            <th scope="row" style="color:black;"><b>View Old Remarks</b></th>
                                            <th scope="row" style="color:black;"><b>Update student details And Remark</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = 0;
                                        // $cmd = $con->prepare("SELECT R.follow_up_date as followup_date pro.id as id, pro.inq_student_id as inq_student_id, pro.first_name as first_name , pro.middle_name as middle_name, pro.last_name as last_name, pro.gender as gender, pro.dob as dob, pro.mobile_number as mobile_number, pro.mobile_number2 as mobile_number2, pro.email as email, pro.faculty_id as faculty_id,pro.level_id as level_id,pro.program_id as program_id,pro.last_exam as last_exam,pro.last_exam_marks as last_exam_mark,pro.is_online as is_online,
                                        //     faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_inquiry_student as pro
                                        //     LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
                                        //     LEFT JOIN tbl_level level ON pro.level_id = level.id 
                                        //     LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id
                                        //     LEFT JOIN tbl_program program ON pro.program_id = program.id WHERE pro.is_delete = ? AND pro.staff_id = ? AND pro.is_admission_confirm = '0' AND R.is_follow_need = '0' ");
                                        // $cmd->bind_param("ii", $status, $staff_id);
                                        // $cmd->execute();
                                        // $result = $cmd->get_result();
                                        // $cmd = $con->prepare("SELECT R.follow_up_date as followup_date, pro.id as id, pro.inq_student_id as inq_student_id, pro.first_name as first_name, pro.middle_name as middle_name, pro.last_name as last_name, pro.gender as gender, pro.dob as dob, pro.mobile_number as mobile_number, pro.mobile_number2 as mobile_number2, pro.email as email, pro.faculty_id as faculty_id, pro.level_id as level_id, pro.program_id as program_id, pro.last_exam as last_exam, pro.last_exam_marks as last_exam_mark, pro.is_online as is_online, faculty.name as faculty_name, level.name as level_name, program.name as program_name FROM tbl_inquiry_student as pro LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level ON pro.level_id = level.id LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id LEFT JOIN tbl_program program ON pro.program_id = program.id 
                                        // WHERE pro.is_delete = ? AND pro.staff_id = ? AND pro.is_admission_confirm = '0' AND R.is_followup_need = '1' AND DATE(R.follow_up_date) = DATE(NOW())");
                                        $cmd = $con->prepare("SELECT
                                        R.follow_up_date AS followup_date,
                                        pro.id AS id,
                                        pro.inq_student_id AS inq_student_id,
                                        pro.first_name AS first_name,
                                        pro.middle_name AS middle_name,
                                        pro.last_name AS last_name,
                                        pro.gender AS gender,
                                        pro.dob AS dob,
                                        pro.mobile_number AS mobile_number,
                                        pro.mobile_number2 AS mobile_number2,
                                        pro.last_school_name as last_school_name, 
                                        pro.email AS email,
                                        pro.faculty_id AS faculty_id,
                                        pro.level_id AS level_id,
                                        pro.program_id AS program_id,
                                        pro.last_exam AS last_exam,
                                        pro.last_exam_marks AS last_exam_mark,
                                        pro.is_online AS is_online,
                                        faculty.name AS faculty_name,
                                        level.name AS level_name,
                                        program.name AS program_name
                                    FROM
                                        tbl_inquiry_student AS pro
                                    LEFT JOIN
                                        tbl_faculty faculty ON pro.faculty_id = faculty.id
                                    LEFT JOIN
                                        tbl_level level ON pro.level_id = level.id
                                    LEFT JOIN
                                        tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id
                                    LEFT JOIN
                                        tbl_program program ON pro.program_id = program.id
                                    WHERE
                                      R.id = (
                                                SELECT MAX(sub_R.id)
                                                FROM tbl_inquiry_remarks AS sub_R
                                                WHERE sub_R.inq_student_id = pro.inq_student_id
                                            ) AND
                                        DATE(R.follow_up_date) = DATE(NOW()) 
                                        AND R.staff_id = ?
                                        AND R.is_followup_need = '1'
                                        AND pro.is_admission_confirm = '0'
                                        AND pro.is_delete = 0");
                                        $cmd->bind_param("i", $staff_id);
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id'];
                                            $inq_student_id = $row['inq_student_id'];
                                            $first_name  = $row['first_name'];
                                            $middle_name = $row['middle_name'];
                                            $last_name = $row['last_name'];
                                            $gender = $row['gender'];
                                            $dob = $row['dob'];
                                            $mobile_number = $row['mobile_number'];
                                            $mobile_number2 = $row['mobile_number2'];
                                            $email = $row['email'];
                                            $faculty_id = $row['faculty_id'];
                                            $level_id = $row['level_id'];
                                            $program_id = $row['program_id'];
                                            $last_exam = $row['last_exam'];
                                            $last_exam_mark = $row['last_exam_mark'];
                                            $is_online = $row['is_online'];
                                            $followup = $row['followup_date'];

                                            // $program_intake = !empty($row['program_intake']) ? $row['program_intake'] : "<b>N/A</b>";
                                            // $program_title = !empty($row['program_title']) ? $row['program_title'] : "<b>N/A</b>";
                                            // $program_shortname = !empty($row['program_shortname']) ? $row['program_shortname'] : "<b>N/A</b>";
                                            $inq_student_id = !empty($row['inq_student_id']) ? $row['inq_student_id'] : "<b>N/A</b>";
                                            $first_name = !empty($row['first_name']) ? $row['first_name'] : "<b>N/A</b>";
                                            $middle_name = !empty($row['middle_name']) ? $row['middle_name'] : "<b>N/A</b>";
                                            $last_name = !empty($row['last_name']) ? $row['last_name'] : "<b>N/A</b>";
                                            $gender = !empty($row['gender']) ? $row['gender'] : "<b>N/A</b>";
                                            $dob = !empty($row['dob']) ? $row['dob'] : "<b>N/A</b>";
                                            $mobile_number = !empty($row['mobile_number']) ? $row['mobile_number'] : "<b>N/A</b>";
                                            $mobile_number2 = !empty($row['mobile_number2']) ? $row['mobile_number2'] : "<b>N/A</b>";
                                            $last_school_name = !empty($row['last_school_name']) ? $row['last_school_name'] : "<b>N/A</b>";
                                            $email = !empty($row['email']) ? $row['email'] : "<b>N/A</b>";
                                            $faculty_id = !empty($row['faculty_id']) ? $row['faculty_id'] : "<b>N/A</b>";
                                            $level_id = !empty($row['level_id']) ? $row['level_id'] : "<b>N/A</b>";
                                            $program_id = !empty($row['program_id']) ? $row['program_id'] : "<b>N/A</b>";
                                            $last_exam = !empty($row['last_exam']) ? $row['last_exam'] : "<b>N/A</b>";
                                            $last_exam_mark = !empty($row['last_exam_mark']) ? $row['last_exam_mark'] : "<b>N/A</b>";
                                            $is_online = !empty($row['is_online']) ? $row['is_online'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $followup = !empty($row['followup_date']) ? $row['followup_date'] : "<b>N/A</b>";
                                            if ($last_exam == '1') {
                                                $last_exam_name = "SSC";
                                            } elseif ($last_exam == '2') {
                                                $last_exam_name = "HSC(A)";
                                            } elseif ($last_exam == '3') {
                                                $last_exam_name = "HSC(B)";
                                            } elseif ($last_exam == '4') {
                                                $last_exam_name = "UG";
                                            } elseif (!empty($last_exam)) {
                                                $last_exam_name = "<b>N/A</b>";
                                            }



                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $inq_student_id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $first_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $middle_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $last_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $gender; ?>
                                                </td>
                                                <!-- <td scope="row">
                                                    <?php //echo $dob; 
                                                    ?>
                                                </td> -->
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
                                                    <?php echo $email; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $faculty_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $level_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $program_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $last_exam_name; ?>
                                                </td>
                                                <!-- <td scope="row">
                                                    <?php // echo $last_exam_mark; 
                                                    ?>
                                                </td> -->

                                                <td scope="row">
                                                    <?php if ($is_online == 1) {
                                                        echo "Online";
                                                    } else {
                                                        echo "Offline";
                                                    } ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $followup; ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="../common/fetch_remarks.php?id2=<?php echo $inq_student_id ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                                </td>
                                                <td scope="row">
                                                    <a href="student_details_remark.php?id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                </td>
                                                <!-- <td scope="row">
                                                    <a href="student_remark.php?id=<?php // echo $row['id'] 
                                                                                    ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                </td> -->
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Id</b></th>
                                            <th scope="row" style="color:black;"><b>inquiry Id</b></th>
                                            <th scope="row" style="color:black;"><b>First Name</b></th>
                                            <th scope="row" style="color:black;"><b>middle Name</b></th>
                                            <th scope="row" style="color:black;"><b>Last Name</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Gender</b></th> -->
                                            <th scope="row" style="color:black;"><b>Date Of Birth</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                             <th scope="row" style="color:black;"><b>School Name</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Id</b></th>
                                            <th scope="row" style="color:black;"><b>Program ID</b></th>
                                            <th scope="row" style="color:black;"><b>Last Exam</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Last Exam Mark</b></th> -->
                                            <th scope="row" style="color:black;"><b>Mode</b></th>
                                            <th scope="row" style="color:black;"><b>follow Up Date</b></th>
                                            <th scope="row" style="color:black;"><b>View Old Remarks</b></th>
                                            <th scope="row" style="color:black;"><b>Update student details And
                                                    Remarks</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Add Student Remarks</b></th> -->
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div><!-- /.container-fluid -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/importfooter.php'; ?>
        <!-- footer -->
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