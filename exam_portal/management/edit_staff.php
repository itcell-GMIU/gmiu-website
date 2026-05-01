<?php
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $sid = $_GET['id'];
}

if (isset($_POST['submit'])) {
    // Fetch data from HTML Form
    $EXsubject = $_POST['subject'];
    $EXsubject = implode(',', $EXsubject);

    // Insert the JSON data into the database
    $stmt = $con->prepare("UPDATE tbl_exam_staff SET `EXsubject` = ? WHERE id = ?");
    $stmt->bind_param("si", $EXsubject, $sid);
    $result1 = $stmt->execute();

    // Error handling if insertion fails
    if ($result1) {
        $_SESSION['status'] = "Staff Updated Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='add_exam_staff.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Staff Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_exam_staff.php'},1000)</script>";
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
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
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
                            <h1 class="m-0">Update Exam Staff</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Update Exam Staff</li>
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
                                    <h3 class="card-title">Update Exam Staff</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>Select Subjects<span style="color: red;"> *</span></label>
                                                <!-- <div class="multi-select"> -->
                                                <div class="selected-items"></div>
                                                <select class="select2option" style="width: 100%" name="subject[]" multiple="multiple" required>
                                                    <?php
                                                    $cmd = "SELECT `subject_code` FROM `tbl_exam_timetable` WHERE `is_active` = 1 GROUP BY `subject_code`";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $subCode = $row['subject_code'];
                                                        $selected = in_array($subCode, explode(',', $ExsubCode)) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?= $subCode ?>" <?= $selected ?>><?= $subCode ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                    </div>
                            </div>
                        </div>
                        </form>
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
</body>

</html>