<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_POST['submit'])) {

    //Fetch data from HTML Form
    $program_id = $_POST['program_id'];
    $program_id = implode(',', $program_id);
    $mission = $_POST['mission'];
    $vision = $_POST['vision'];


    // Validate Data
    $mission = validate_data($mission);
    $vision = validate_data($vision);

    // Prepare and execute the SQL statement to insert a record in the tbl_mission_vision 
    $stmt = $con->prepare("INSERT INTO `tbl_mission_vision`(program_id,mission,vision)VALUES (?,?,?)");
    $stmt->bind_param("sss", $program_id, $mission, $vision);
    $result = $stmt->execute();
    if ($result) {
        if ($result) {
            //Sweet Alert of Success Message
            $_SESSION['status'] = "Mission & Vision Inserted Successfully";
            $_SESSION['status_code'] = "success";

            echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000);</script>";
        } else {
            //Sweet Alert of Error Message
            $_SESSION['status'] = "Mission & Vision Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='mission_vision_view.php'},1000)</script>";
        }
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
                            <h1 class="m-0">Add Mission & Vision</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Mission & Vision</li>

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
                                    <h3 class="card-title">Add Mission & Vision</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <!-- <div class="multi-select"> -->
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple" required>

                                                <?php
                                                $cmd = "SELECT pro.id,pro.name,level.name as level_name FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                                ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $program_id = $row['id'];
                                                    $program_name = $row['name'];
                                                    $level_name = $row['level_name'];

                                                ?>
                                                    <option value="<?php echo $program_id; ?>">
                                                        <?php echo $program_name . "(" . $level_name . ")"; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Mission
                                                <span style="color: red;" required>*</span>
                                            </label>
                                            <textarea name="mission" class="ckeditor" id="mission"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Vision
                                                <span style="color: red;" required>*</span>
                                            </label>
                                            <textarea name="vision" class="ckeditor" id="vision"></textarea>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

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
</body>

</html>

<!-- Script for select2 -->
<script>
    $(document).ready(function() {
        $('.select2option').select2();
    });
</script>