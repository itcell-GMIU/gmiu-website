<?php include '../include/checklogin.php';

if (isset($_POST["submit"])) {
    $id =  mysqli_real_escape_string($con,$_POST["faq_id"]);
       
   $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $faq_description = $_POST['description'];
   
    /// Update tbl_faq_management 
    $stmt = $con->prepare("UPDATE `tbl_faq_management` SET faculty_id = ?, level_id = ?, faq_description = ? WHERE id = ?");
    $stmt->bind_param("iisi", $faculty_id, $level_id, $faq_description, $id);
    $result = $stmt->execute();
    
    if ($result) {
        $_SESSION['status'] = "FAQ Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='faq_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "FAQ Update Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faq_edit.php'},1000)</script>";
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../admin_assets/plugins/dropzone/min/dropzone.min.css">

    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <style>
        #image_display_main {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
    </style>
</head>
<?php

// Retrieving data from the database based on the provided FAQ ID
if (isset($_GET['faq_id'])) {
    // GET faculty id from display table
    if (isset($_GET['faq_id']) && !empty($_GET['faq_id'])) {
        $faq_id = mysqli_real_escape_string($con, $_GET['faq_id']);
        $faq_id = only_digits($faq_id);
        if ($faq_id == false) {
            $_SESSION['status'] = "Invalid data in url";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='faq_view.php'},1000)</script>";
        }
    }
}
$status = 0;
// get data from DB
$cmd = $con->prepare("SELECT level.name as level, faq.id as faq_id, faq.faq_description as faq_description,
                     faculty.name as faculty_name, faq.faculty_id as faculty_id, faq.level_id as level_id
                     FROM tbl_faq_management as faq 
                     LEFT JOIN tbl_faculty faculty ON faq.faculty_id = faculty.id 
                     LEFT JOIN tbl_level level ON faq.level_id = level.id
                     WHERE faq.is_delete =  ? and faq.id = ? ");
$cmd->bind_param("ii", $status, $faq_id);
$cmd->execute();
$result = $cmd->get_result();

while ($row = $result->fetch_assoc()) {

    $faculty_name = $row['faculty_name'];
    $faq_description = $row['faq_description'];
    $faculty_id = $row['faculty_id'];
    $level_id = $row['level_id'];
}

?>

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
                            <h1 class="m-0">Edit FAQ</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active"> Edit FAQ</li>
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
                                    <h3 class="card-title">Edit FAQ</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="updateForm" method="POST" action="" enctype="multipart/form-data">
                                <input type="hidden" name="faq_id" value="<?php echo $faq_id; ?>" /> <!-- Hidden FAQ ID -->
   
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select Faculty</label>
                                            <select class="form-control" name="faculty_id" id="faculty_id">
                                                <?php
                                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                ?>
                                                    <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) { echo "selected"; } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Level</label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">FAQ Description <span style="color: red;">*</span></label>
                                            <textarea name="description" class="ckeditor" id="description" required><?php echo htmlspecialchars_decode($faq_description); ?></textarea>
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
                    </div>
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>

    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>

    <!-- dropzonejs -->
    <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2option').select2();
        });

        $(document).ready(function() {
            load_level();
        });

        function load_level() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: api_for
                },
                success: function(result) {
                    $('#level_id').html(result);
                }
            });
        }

        $('#faculty_id').on('change', function() {
            var path = '<?php echo "$base_url_api"; ?>';
            var faculty_id = this.value;
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function(result) {
                    $('#level_id').html(result);
                }
            })
        });
    </script>
</body>

</html>
