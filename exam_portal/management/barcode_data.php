<?php
include '../include/checklogin.php';

$button_echo = "Select Exam Date!";

if (isset($_GET['submit'])) {
    $ex_dt = $_GET['exam_date'];

    $dateTime2 = new DateTime($ex_dt);
    $formattedExDate = $dateTime2->format("d-m-Y");

    $shift = $_GET['shift'];

    if ($shift == "am") {
        $shiftQ = "AND start_time BETWEEN '01:00:00' AND '12:01:00'";
    } elseif ($shift == "pm") {
        $shiftQ = "AND start_time BETWEEN '12:01:00' AND '24:00:00'";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <!-- /.CKeditor custom script -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
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
                            <h1 class="m-0">Exam Block Arrangement</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Exam Block Arrangement</li>
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
                                    <h3 class="card-title">Exam Block Arrangement</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="get" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label>Select Date <span style="color: red;"> *</span></label>
                                                <div class="form-group">
                                                    <select class="form-control" style="width: 100%" name="exam_date" required>
                                                        <option value="">Select Date</option>
                                                        <?php
                                                        $status = 0;
                                                        $cmd = $con->prepare("SELECT date, exam_id FROM tbl_exam_timetable where is_delete = ? AND sub_type = 'Theory' GROUP BY date");
                                                        $cmd->bind_param("i", $status);
                                                        $cmd->execute();
                                                        $result = $cmd->get_result();
                                                        while ($row = $result->fetch_assoc()) {
                                                            $ex_id = $row['exam_id'];
                                                            $date = $row['date'];

                                                            $cmd3 = $con->prepare("SELECT session, year FROM tbl_exam_form where  id = ? and is_delete = ?");
                                                            $cmd3->bind_param("ii", $ex_id, $status);
                                                            $cmd3->execute();
                                                            $result3 = $cmd3->get_result();
                                                            while ($row3 = $result3->fetch_assoc()) {
                                                                $session = $row3['session'];
                                                                $year = $row3['year'];
                                                            }
                                                        ?>
                                                            <option value="<?= $date ?>" class="text-uppercase" <?php
                                                                                                                if ($ex_dt == $date) {
                                                                                                                    echo "selected";
                                                                                                                } else {
                                                                                                                    echo " ";
                                                                                                                }
                                                                                                                ?>>
                                                                <?= $date . ' [' . $session . '-' . $year . ']' ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label>Select Shift <span style="color: red;"> *</span></label>
                                                <div class="form-group">
                                                    <select class="form-control" style="width: 100%" name="shift" required>
                                                        <option value="">Select Shift</option>
                                                        <option value="am" <?php
                                                                            if ($shift == "am") {
                                                                                echo "selected";
                                                                            } else {
                                                                                echo " ";
                                                                            }
                                                                            ?>>Morning</option>
                                                        <option value="pm" <?php
                                                                            if ($shift == "pm") {
                                                                                echo "selected";
                                                                            } else {
                                                                                echo " ";
                                                                            }
                                                                            ?>>Afternoon</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card card-gmiu mt-3">
                                <div class="card-body">
                                    <table class="table text-center table-bordered dataTableLoad" id="example">
                                        <thead>
                                            <tr>
                                                <th>Seat No.</th>
                                                <th>Subject Code</th>
                                                <th>Block No.</th>
                                                <th>Barcode Key</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (isset($_GET['submit'])) {
                                                $status = 0;
                                                $cmd = $con->prepare("SELECT * FROM tbl_exam_timetable WHERE is_delete = ? AND sub_type = 'Theory' AND date = ? $shiftQ ;");
                                                $cmd->bind_param("is", $status, $ex_dt);
                                                $cmd->execute();
                                                $result = $cmd->get_result();
                                            ?>
                                                <?php
                                                while ($row = $result->fetch_assoc()) {
                                                    $exam_id = $row['exam_id'];
                                                    $sub_code = $row['subject_code'];
                                                    $sub_name = $row['subject_name'];


                                                    $cmd11 = $con->prepare("SELECT std.type as type, std.year as year, std.semester as sem, std.session as session ,std.faculty_id, std.level_id, std.program_id,faculty.name as faculty_name, program.name as program_name, 
                                        level.name as level_name FROM tbl_exam_form as std
                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id
                                        LEFT JOIN tbl_level level ON std.level_id = level.id
                                        LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.id = ?");
                                                    $cmd11->bind_param("i", $exam_id);
                                                    $cmd11->execute();
                                                    $result11 = $cmd11->get_result();
                                                    while ($row11 = $result11->fetch_assoc()) {
                                                        $semester_ex = $row11['sem'];
                                                        $session = $row11['session'];
                                                        $type = $row11['type'];
                                                        $year = $row11['year'];
                                                        $level_name = $row11['level_name'];
                                                        $program_name = $row11['program_name'];

                                                        $program_id = $row11['program_id'];
                                                        $faculty_id = $row11['faculty_id'];
                                                        $level_id = $row11['level_id'];

                                                        // $status = 0;
                                                        // $cmd12 = $con->prepare("SELECT short_name FROM tbl_short_name WHERE level_id = ? AND faculty_id = ? AND is_delete = ?");
                                                        // $cmd12->bind_param("iii", $level_id, $faculty_id, $status);
                                                        // $cmd12->execute();
                                                        // $result12 = $cmd12->get_result();
                                                        // while ($row12 = $result12->fetch_assoc()) {
                                                        //     $short_name = $row12['short_name'];
                                                        // }

                                                        $examName = $level_name . ' ' . $program_name . ' semester-' . $semester_ex . ' ' . $type . ' ' . $session . '-' . $year;
                                                    }
                                                    $cmd2 = $con->prepare("SELECT * FROM tbl_exam_results WHERE is_delete = ? AND exam_id = ? AND subject_code = ? AND block_id IS NOT NULL");
                                                    $cmd2->bind_param("iis", $status, $exam_id, $sub_code);
                                                    $cmd2->execute();
                                                    $result2 = $cmd2->get_result();
                                                    $in = 1;
                                                    $srCount = 0;
                                                    $blockNo = 0;
                                                    $prevSubCode = null;
                                                    while ($row2 = $result2->fetch_assoc()) {
                                                        $sub_code = $row['subject_code'];
                                                        $enr_no = $row2['enrollnment_no'];
                                                        $seat_no = $row2['seat_no'];
                                                        $blockNo = $row2['block_id'];
                                                        $barcode = $row2['barcode'];
                                                ?>
                                                        <tr>
                                                            <td><?= $seat_no ?></td>
                                                            <td><?= $sub_code ?></td>
                                                            <td class="text-uppercase"><?= $blockNo .' '.$shift?></td>
                                                            <td><?= $barcode ?></td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
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
    <script>
        $(document).ready(function() {
            $('.select2option').select2();
        });
    </script>


    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        document.getElementById('add_entry').addEventListener('click', function() {
            const lateFeeEntries = document.getElementById('late_fee_entries');
            const newEntry = document.querySelector('.late_fee_entry').cloneNode(true);

            // Reset input values in the new entry
            newEntry.querySelectorAll('input').forEach(input => {
                input.value = '';
            });

            lateFeeEntries.appendChild(newEntry);
        });
    </script>
</body>

</html>