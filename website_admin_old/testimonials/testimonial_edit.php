<?php
include '../include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['testimonial_id'];
    $image_file = $_FILES['img_input'];
    $id = mysqli_real_escape_string($con, $_POST['testimonial_id']);
    $file_type = mysqli_real_escape_string($con, $_POST['file_type']);
    $name = mysqli_real_escape_string($con, $_POST['testinomial_title']);
    $description = mysqli_real_escape_string($con, $_POST['testinomial_description']);
    $testimonial_type = mysqli_real_escape_string($con, $_POST['test_type']);

    if ($file_type == 'image') {
        $targetDirectory = "../uploads/testimonial/";
        $uploaded_images = upload_single_file($_FILES["img_input"], $targetDirectory, 1);
        $file_name = $uploaded_images['message'];

        $stmt = $con->prepare("UPDATE `tbl_testimonial` SET testimonial_type=?, file=?, file_type=?, name=?, description=? WHERE id=?");
        $stmt->bind_param("sssssi", $testimonial_type, $file_name, $file_type, $name, $description, $id);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['status'] = "Testimonial Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='testimonial_view.php'}, 1000);</script>";
        } else {
            $_SESSION['status'] = "Testimonial Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='testimonial_view.php'}, 1000);</script>";
        }
    }
}
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
                            <h1 class="m-0">Edit Testimonial </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Testimonial</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <form id="post" name="post" onsubmit="return validation()" method="POST" enctype="multipart/form-data"
                    action="testimonial_update.php?testimonial_id=<?php echo $_GET['testimonial_id']; ?>">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Testimonial</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                        <?php
                                        if (isset($_GET['testimonial_id']) && !empty($_GET['testimonial_id'])) {
                                            $id= mysqli_real_escape_string($con, $_GET['testimonial_id']);
                                            $id= only_digits($id);
                                            if ($id== false) {
                                                $_SESSION['status'] = "Invalid data in url";
                                                $_SESSION['status_code'] = "error";
                                                echo "<script>setTimeout(function(){window.location='testimonial_view.php'},1000)</script>";
                                            }
                                        }
                                        $stmt = $con->prepare("SELECT * FROM `tbl_testimonial` WHERE id = ?");
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $testimonial = $result->fetch_assoc();
                                        ?>
                                        <input type="hidden" name="testimonial_id"
                                            value="<?php echo $testimonial['id']; ?>">
                                        <div class="form-group">
                                            <label>Select Testimonial Type<span style="color: red;"> </span></label>
                                            <select onchange="insertContactfields()" class="form-control"
                                                name="test_type" required>
                                                <option value="">---Select Testimonial Type---</option>
                                                <option value="student"
                                                    <?php if ($testimonial['testimonial_type'] == 'student') echo 'selected'; ?>>
                                                    Student</option>
                                                <option value="alumni"
                                                    <?php if ($testimonial['testimonial_type'] == 'alumni') echo 'selected'; ?>>
                                                    Alumni</option>
                                                <option value="corporate"
                                                    <?php if ($testimonial['testimonial_type'] == 'corporate') echo 'selected'; ?>>
                                                    Corporate</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Type of file<span style="color: red;"> </span></label>
                                            <select id="type" onchange="insertContactfields()" class="form-control"
                                                name="file_type" required>
                                                <option value="">---Select---</option>
                                                <option value="image"
                                                    <?php if ($testimonial['file_type'] == 'image') echo 'selected'; ?>>
                                                    Image</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="id" value=<?php echo $id; ?>>
                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">File input</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="img_input"
                                                            id="file_input"
                                                            <?php if ($testimonial['file'] != null) echo 'selected'; ?>>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php

                                        $cmd = $con->prepare("SELECT file as image FROM `tbl_testimonial` where id = ?");
                                        $cmd->bind_param("i", $id);
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $image  = !empty($row['image']) ? $row['image'] : "";
                                        ?>
                                        <input type="hidden" name="oldImage" value="<?php echo $image; ?>">
                                        <div class="input-group" id="imgPrev">
                                            <img src="<?php echo "../uploads/testimonial/" . "$image"; ?>" width="150"
                                                height="150">
                                        </div>
                                        <?php
                                        } ?>

                                        <!-- <div class="input-group" id="imgPrev">
                                            <img src="../uploads/testimonial/<?php echo $testimonial['file']; ?>" alt="Preview Image" style="width: 150px; height: 150px; margin-left: 20px; margin-top: 10px;">
                                        </div> -->
                                        <div class="form-group">
                                            <label for="title_id">Name<span style="color: red;"></span></label>
                                            <input type="text" name="testinomial_title" class="form-control"
                                                id="title_id" placeholder="Enter Name"
                                                value="<?php echo $testimonial['name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="text_editor">Detailed Description
                                                <span style="color: red;"></span>
                                            </label><br>
                                            <textarea type="text" name="testinomial_description" class="ckeditor"
                                                placeholder="Enter Description" required
                                                style="height: 100px;"><?php echo htmlspecialchars_decode( $testimonial['description']); ?></textarea>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" id="submit" name="submit"
                                                class="btn btn-primary">Submit</button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="window.location='testimonial_view.php'">Cancel</button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </form>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Control Sidebar -->
        <?php include '../include/importsidebar.php'; ?>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include '../include/importfooter.php'; ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <?php include '../include/importjs.php'; ?>
    <!-- Library for image preview -->
    <script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

    <!-- Custom script for image preview -->
    <script>
    const input = document.getElementById('file_input');
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
</body>

</html>