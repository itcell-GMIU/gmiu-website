<?php
include '../include/checklogin.php';

$status = 1;

$cmd = $con->prepare("SELECT 
         doc.id as id, 
         doc.document as document, 
         doc.is_active as doc_is_active 
         FROM tbl_gmiu_doc as doc
         WHERE doc.is_active = ? and doc.id = 1");
$cmd->bind_param("i", $status); // Bind the parameters for the prepared statement
$cmd->execute(); // Get the result of the executed query
$result = $cmd->get_result();
while ($row = $result->fetch_assoc()) {
    $document_id = $row['id'];
    $document = $row['document'];
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
                            <h1 class="m-0">Add Fee Structure Documents</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Fee Structure Documents</li>
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
                                    <h3 class="card-title">Add Fee Structure Documents</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- form start -->
                                    <form id="quickForm" action="fee_structure_update.php" method="POST" enctype="multipart/form-data">

                                        <input type="hidden" name="id" value="1">

                                        <div class="input-group" id="imgPrev">
                                        </div>

                                        <div name="document" id="document" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload document<span style="color: red;"> *</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="document" id="document" required>
                                                        <label class="custom-file-label" for="exampleInputFile"><?php echo  $document; ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            <a href="<?php echo '../uploads/fee_structure/document/' . $document; ?>" class="btn btn-primary" target="_BLANK">View Document</a>
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