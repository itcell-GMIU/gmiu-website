<?php
include '../include/checklogin.php';

$button_echo = "Select Exam Date!";

if (isset($_POST['submit'])) {
    $ex_dt = $_POST['exam_date'];

    $status = 0;
    $cmd = $con->prepare("SELECT * FROM tbl_exam_timetable WHERE is_delete = ? AND date = ?");
    $cmd->bind_param("is", $status, $ex_dt);
    $cmd->execute();
    $result = $cmd->get_result();

    $srCount = 1;
    $blockNo = 0;
    $prevSubCode = null;

    while ($row = $result->fetch_assoc()) {
        $sub_code = $row['subject_code'];

        // Check if subject code has changed or 30 enrollments have been reached
        if ($sub_code != $prevSubCode || $srCount % 30 == 0) {
            $blockNo++;
        }

        $prevSubCode = $sub_code;
        $date = $row['date'];
        $exam_id = $row['exam_id'];

        $cmd2 = $con->prepare("SELECT * FROM tbl_exam_results WHERE is_delete = ? AND exam_id = ? AND subject_code = ?");
        $cmd2->bind_param("iis", $status, $exam_id, $sub_code);
        $cmd2->execute();
        $result2 = $cmd2->get_result();
        $in = 1;
        while ($row2 = $result2->fetch_assoc()) {
            $enr_no = $row2['enrollnment_no'];
            // Update block_id in tbl_exam_results
            $cmd3 = $con->prepare("SELECT enrollnment_no FROM tbl_exam_student WHERE enrollnment_no = ? AND is_delete = ? AND exam_id = ? AND status = 3");
            $cmd3->bind_param("sii", $enr_no,$status, $exam_id);
            $cmd3->execute();
            $result4 = $cmd3->get_result();
            while ($row4 = $result4->fetch_assoc()) {
                $en_no = $row4['enrollnment_no'];
                $stmt = $con->prepare("UPDATE tbl_exam_results SET block_id = ? WHERE exam_id = ? AND subject_code = ? AND enrollnment_no = ?");
                $stmt->bind_param("iiss", $blockNo, $exam_id, $sub_code, $en_no);
                $result3 = $stmt->execute();
                $in++;
                if ($in > 30) {
                    $in = 1;
                    $blockNo++;
                }
            }
        }


        // Update is_completed in tbl_exam_timetable    
        $stt = 1;
        $stmt2 = $con->prepare("UPDATE tbl_exam_timetable SET is_completed = ? WHERE exam_id = ? AND subject_code = ?");
        $stmt2->bind_param("iis", $stt, $exam_id, $sub_code);
        $result3 = $stmt2->execute();

        $srCount++;
    }

    // Redirect to block_arrangement.php after updates
    if ($result2 && $result3) {
        $_SESSION['status'] = "Block Arranged Successfully!";
        $_SESSION['status_code'] = "success";
        // echo "<script>setTimeout(function(){window.location='block_arrangement.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Block Arrangement Failed";
        $_SESSION['status_code'] = "error";
        // echo "<script>setTimeout(function(){window.location='block_arrangement.php'},1000)</script>";
    }
    
    $button_echo = '<div class="col-sm-4">
    <a href="view_block.php?dt='.$ex_dt.'" class="btn btn-success w-100"><i class="fa fa-th"></i> Block Arrangement</a>
    </div>
    <div class="col-sm-4">
        <a href="view_form_one.php?dt='.$ex_dt.'" class="btn btn-success w-100"><i class="fa fa-file"></i> Form 1</a>
    </div>';
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
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label>Select Date <span style="color: red;"> *</span></label>
                                                <div class="form-group">
                                                    <select class="form-control" style="width: 100%" name="exam_date" required>
                                                        <option value="">Select Date</option>
                                                        <?php
                                                        $status = 0;
                                                        $cmd = $con->prepare("SELECT date, exam_id FROM tbl_exam_timetable where is_delete = ? GROUP BY date");
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
                                                            <option value="<?= $date ?>" class="text-uppercase">
                                                                <?= $date . ' [' . $session . '-' . $year . ']' ?>
                                                            </option>
                                                        <?php } ?>
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
                            <div class="card card-gmiu">
                                <div class="card-body">
                                    <div class="row">
                                        <?= $button_echo ?>
                                    </div>
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