<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
</head>
<?php

if (isset($_GET['laboratories_id']) && !empty($_GET['laboratories_id'])) {

    $laboratories_id = mysqli_real_escape_string($con, $_GET['laboratories_id']);
    $laboratories_id = only_digits($laboratories_id);
    if ($laboratories_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='laboratories_view.php'},1000)</script>";
    }
    $cmd = "SELECT laboratories.id as laboratories_id, laboratories.faculty_id as faculty_id, laboratories.level_id as level_id, laboratories.program_id  as program_id,laboratories.title as laboratories_title, laboratories.description as laboratories_description, site_photos.file_name as file_name FROM tbl_laboratories as laboratories
LEFT JOIN tbl_site_photos site_photos on laboratories.id = site_photos.type_id WHERE laboratories.id = ?";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param('i', $laboratories_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {

        $laboratories_id = $row['laboratories_id'];
        $laboratories_title = !empty($row['laboratories_title']) ? $row['laboratories_title'] : "<b>N/A</b>";
        $laboratories_description = !empty($row['laboratories_description']) ? $row['laboratories_description'] : "<b>N/A</b>";
        $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
        $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
        $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
        $faculty_id = $row['faculty_id'];
        $level_id = $row['level_id'];
        $laboratories_program_id = $row['program_id'];
        $laboratories_program_id = explode(",", $laboratories_program_id);
        $file_name = $row['file_name'];
    }
}

?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;

        </div>
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
                            <h1 class="m-0">Edit Laboratories</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Laboratories</li>

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
                                    <h3 class="card-title">Edit Laboratories</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="laboratories_update.php" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">

                                        <div class="form-group">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <!-- <div class="multi-select"> -->
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple">
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

                                                    <option value="<?php echo $program_id; ?>" <?php if (in_array($program_id, $laboratories_program_id)) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $program_name . "(" . $level_name . ")"; ?></option>
                                                <?php } ?>

                                            </select>

                                        </div>
                                            <input type="hidden" name="laboratories_id" value="<?php echo $laboratories_id; ?>">

                                            <div class="form-group">
                                                <label for="name">Title <span style="color: red;">*</span></label>
                                                <input type="text" name="title" class="form-control" id="name" placeholder="Enter Name" value="<?php echo $laboratories_title; ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description <span style="color: red;">*</span> </label>
                                                <textarea id="description" class="ckeditor" name="description"><?php echo htmlspecialchars_decode($laboratories_description); ?></textarea>
                                            </div>

                                            <div name="image1" id="image1" class="form-group">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Upload Images<span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="image_upload[]" id="image_upload" multiple>
                                                            <label class="custom-file-label" for="exampleInputFile">
                                                                Choose Images</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group" id="imgPrev">
                                            </div>
                                            <div name="image_display_main" id="image_display_main" class="form-group">
                                                <?php
                                                $status = 0;
                                                $type = "lab";
                                                $cmd = $con->prepare("SELECT photos.file_name as file_name  FROM `tbl_site_photos` as photos  where  photos.type = ? and photos.type_id = ?");
                                                $cmd->bind_param("si", $type, $laboratories_id);
                                                $cmd->execute();
                                                $result = $cmd->get_result();

                                                while ($row = $result->fetch_assoc()) {
                                                    $file_name  = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";



                                                ?>
                                                    <input type="hidden" name="image_uploads" id="id" value="<?php echo $laboratories_id; ?>">
                                                    <div name="image_display" id="image_display" class="form-group">
                                                        <img src="<?php echo "../uploads/laboratory/" . "$file_name"; ?>" width="200" height="200">

                                                    </div>
                                                <?php
                                                } ?>
                                            </div>


                                            <div class="card-footer">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </section>
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

</html>


<script>
    const input = document.getElementById('image_upload');
    const preview = document.getElementById('imgPrev');

    input.addEventListener('change', () => {
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        const files = input.files;
        if (!files) {
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = () => {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.marginLeft = '20px';
                img.style.marginTop = '10px';
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
</script>
<script>
    $(document).ready(function() {
        {

            $("#image_display_main").show();
        }
        $("#image_upload").change(function() {
            var selectedOption = $(this).children("option:selected").val();

            $("#image_display_main").hide();


        });
    });
</script>

<!-- Script for select2 -->
<script> 
$(document).ready(function() {
    $('.select2option').select2();
});
</script>