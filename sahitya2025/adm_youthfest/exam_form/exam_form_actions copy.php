<?php
// Include the checklogin.php file
include '../include/checklogin.php';
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Exam Forms</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Exam Forms</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Student Corner</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post" class="row">
                                <label class="col-sm-2 pt-2 text-center">Select Exam<span style="color: red;"> *</span></label>
                                <div class="form-group col-sm-10">
                                    <select class="form-control" name="faculty_id" required id="faculty_id">
                                        <option value="">---Select Exam---</option>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.semester as semester, std.is_active as std_is_active, std.type as type , std.session as session , std.start_date as start_date, std.end_date as end_date, std.year as year,
                                                        faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_exam_form as std
                                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                        LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                        LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $level_id = $row['level_id'];
                                            $program_id = $row['program_id'];
                                            $id = $row['id'];
                                            $semester = $row['semester'];

                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $Syllabus = !empty($row['Syllabus']) ? $row['Syllabus'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $sem = !empty($row['semester']) ? $row['semester'] : "<b>N/A</b>";
                                            $std_is_active = $row['std_is_active'];
                                            $exam_type = $row['type'];
                                            $exam_session = $row['session'];
                                            if ($row['type'] == "regular") {
                                                $exam_type = "REGULAR";
                                            } else {
                                                $exam_type = "REMEDIAL";
                                            }
                                        ?>
                                            <option value="<?php echo $id; ?>" class="text-uppercase">
                                                <?php echo $faculty_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </form>
                            <hr>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th style="color:black;"><b>Id</b></th>
                                            <th style="color:black;"><b>Enrollnment No</b></th>
                                            <th style="color:black;"><b>Student Name</b></th>
                                            <th style="color:black;"><b>Exam Sem</b></th>
                                            <th style="color:black;"><b>Status</b></th>
                                            <th style="color:black;"><b>Action</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="level_id" class="tbody">

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th style="color:black;"><b>Id</b></th>
                                            <th style="color:black;"><b>Enrollnment No</b></th>
                                            <th style="color:black;"><b>Student Name</b></th>
                                            <th style="color:black;"><b>Exam Sem</b></th>
                                            <th style="color:black;"><b>Status</b></th>
                                            <th style="color:black;"><b>Action</b></th>
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

    </div>
    <!-- ./wrapper -->
    <!-- footer -->
    <?php include '../include/importjs.php'; ?>
    <script>
        $('#faculty_id').on('change', function() {
            var faculty_id = this.value;
            // alert("hii");
            $.ajax({
                url: 'fetch_exam_data.php',
                type: "POST",
                data: {
                    exam_id: faculty_id
                },
                success: function(result) {
                    $('#level_id').html(result);
                }
            })
        });
    </script>
</body>

</html>