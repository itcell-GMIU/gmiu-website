<?php
include './include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../admin_assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../admin_assets/dist/css/adminlte.min.css">



</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>

                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>


            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <form action="upload.php" name="upload" onsubmit="return validation()" method="POST" enctype='multipart/form-data'>
                            <div class="card card-warning">
                                <div class="card-body">
                                    <div class="card-header">
                                        <h5 class="card-title">Update Photo</h5>
                                    </div>
                                    <div id="ctl00_ContentPlaceHolder1_tbl_Snphoto">
                                        <div class="btn-theme02 panel-heading">
                                            <!-- form start -->
                                            <form>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Upload Photo</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="imgInp" name="image">
                                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <img id="blah" style="height:150px; width:150px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->

                                                <div class="card-footer">
                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div style="text-align:left;color:black;padding:5px">
                            <h3>PASSPORT PHOTOGRAPH REQUIREMENTS</h3>
                            <br>
                            <h4>ACCEPTABLE:</h4>
                            <ol>
                                <li>Image must be in .jpg format</li>
                                <li>Image Size less then 100KB</li>
                                <li>Photo dimensions: at least 45mm high x 35mm wide (do NOT trim photos
                                    if
                                    bigger)
                                </li>
                                <li>Head size: 32mm to 36mm from top of head (not hair) to bottom of
                                    chin.
                                </li>
                                <li>Neutral expression, mouth closed </li>
                                <li>Good lighting, no shadows behind head or on face </li>
                                <li>Eyes looking directly at camera </li>
                                <li>Plain, light-coloured background </li>
                                <li>High resolution, good quality paper </li>
                            </ol>
                            <br>

                            <h4>NOT ACCEPTABLE:</h4>
                            <ol>
                                <li>Image Size more then 100KB</li>
                                <li>Shadows behind head </li>
                                <li>Red Eye </li>
                                <li>Background not plain </li>
                                <li>Photograph size too small </li>
                                <li>Head size too big or too small </li>
                                <li>Flash reflections from glasses or tinted glasses </li>
                                <li>Glasses frames covering eyes </li>
                                <li>Eyes looking away from the camera </li>
                                <li>Face not front onto the camera </li>
                                <li>Mouth open, unnatural expression </li>
                                <li>Ink marks or indentations </li>
                                <li>Grainy, pixelated or blurry images </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <!-- ./wrapper -->

    <!-- jQuery -->

    <?php include 'include/importjs.php'; ?>
    <!-- jQuery -->
    <script src="../admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../admin_assets/dist/js/adminlte.min.j"></script>
    <!-- AdminLTE for demo purposes -->

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>


</body>

</html>