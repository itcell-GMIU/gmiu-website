<?php
include '../include/checklogin.php';

// Get the value of 'id' from the query string
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $brochure_id = mysqli_real_escape_string($con, $_GET['id']);
    $brochure_id = only_digits($brochure_id);
    if ($brochure_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000)</script>";
    }

    $status = 0;
    $cmd = $con->prepare("SELECT brochure.id as brochure_id, brochure.title as brochure_title, brochure.document as brochure_document, brochure.thumbnail as brochure_thumbnail, brochure.is_active as brochure_is_active, brochure.sno FROM tbl_brochure as brochure WHERE brochure.is_delete = ? and brochure.id = ?");

    $cmd->bind_param("ii", $status, $brochure_id); // Bind the parameters for the prepared statement
    $cmd->execute(); // Get the result of the executed query
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        // Loop through the result rows and assign values to variables
        $brochure_title = !empty($row['brochure_title']) ? $row['brochure_title'] : "<b>N/A</b>";
        $brochure_document = !empty($row['brochure_document']) ? $row['brochure_document'] : "<b>N/A</b>";
        $brochure_thumbnail = !empty($row['brochure_thumbnail']) ? $row['brochure_thumbnail'] : "<b>N/A</b>";
        $sno = !empty($row['sno']) ? $row['sno'] : "";
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
                            <h1 class="m-0">Edit E-Brochure & Scope Documents</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit E-Brochure & Scope Documents</li>

                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Edit E-Brochure & Scope Documents</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- form start -->
                                    <form id="quickForm" method="POST" action="brochure_update.php" enctype="multipart/form-data">

                                        <input type="hidden" name="id" value="<?php echo $brochure_id ?>">

                                        <div class="form-group">
                                            <label for="name">Title<span style="color: red;">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title_id" placeholder="Enter E-Brochure & Scope Documents Title" value="<?php echo $brochure_title ?>" required>
                                        </div>

                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Thumbnail</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="oldthumbnail" value="<?php echo $brochure_thumbnail; ?>">
                                        <div class="input-group" id="imgPrev">
                                            <img src="<?php echo "../uploads/brochure/thumbnail/" . "$brochure_thumbnail"; ?>" width="150" height="150">
                                        </div>

                                        <div name="document" id="document" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload document<span style="color: red;"> *</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="document" id="document">
                                                        <label class="custom-file-label" for="exampleInputFile"><?php echo  $brochure_document; ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <input type="hidden" name="olddocument" value="<?php echo $brochure_document; ?>">

                                        <div class="form-group">
                                            <label for="name">Sno<span style="color: red;">*</span></label>
                                            <input type="text" name="sno" class="form-control" placeholder="Enter sno" value="<?php echo $sno ?>" required>
                                        </div>


                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
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
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
    const input = document.getElementById('thumbnail');
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