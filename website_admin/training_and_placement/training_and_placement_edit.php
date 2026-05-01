<?php
include '../include/checklogin.php';

// GET faculty id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='training_and_placement_view.php'},1000)</script>";} 

$status = 0;
$cmd = $con->prepare("SELECT training.id as id,training.name as name ,training.department as department ,training.img_name as img_name FROM tbl_tpa_coordinator as training WHERE training.is_delete = ? and training.id= ?" );
$cmd->bind_param("ii", $status,$id);
$cmd->execute();
$result = $cmd->get_result();
while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $name = !empty($row['name']) ? $row['name'] : "<b>N/A</b>";
    $department = !empty($row['department']) ? $row['department'] : "<b>N/A</b>";
    $img_name = !empty($row['img_name']) ? $row['img_name'] : "<b>N/A</b>";}
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
                            <h1 class="m-0">Edit Training and Placement</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Training and Placement</li>

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
                                    <h3 class="card-title">Edit Training and Placement</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="upload" action="training_and_placement_update.php" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">
                                        <input type="hidden" name="id" value="<?php echo $id;?>">
                                        <div class="form-group">
                                            <label for="title_name">Name of staff<span style="color: red;">*</span></label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Enter Name of staff" value="<?php echo $name; ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="title_name">Department<span style="color: red;">*</span></label>
                                            <input type="text" name="department" class="form-control" id="department"
                                                placeholder="Enter Department" value="<?php echo $department; ?>" required>
                                            </div>

                                      

                                        <div name="image1" id="image1" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            name="image_upload" id="image_upload" >
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group" id="imgPrev">
                                        </div>

                                        <div name="image_display_main" id="image_display_main" class="form-group">

<div name="image_display" id="image_display" class="form-group">
    <img src="<?php echo "../uploads/training_and_placement/" . "$img_name"; ?>" width="200" height="200">

</div>

</div>


                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
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

    <!-- dropzonejs -->
    <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
</body>

</html>
<script>
$(function() {
    bsCustomFileInput.init();
});
</script>
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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