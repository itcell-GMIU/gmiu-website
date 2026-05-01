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
if (isset($_GET['ic_id']) && !empty($_GET['ic_id'])) {
    $ic_id = mysqli_real_escape_string($con, $_GET['ic_id']);
    $ic_id = only_digits($ic_id);
    $status = 0;
    $cmd = $con->prepare("SELECT * FROM tbl_iksve_cell WHERE is_delete = ? and id=?");
    $cmd->bind_param("ii", $status,$ic_id); // type_id should be passed as a parameter
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        $type = $row['type_id'];
        // Determine the type based on type_id
        // switch ($row['type_id']) {
        //     case 1:
        //         $type = "FDP";
        //         break;
        //     case 2:
        //         $type = "SDP";
        //         break;
        //     case 3:
        //         $type = "Workshops&Seminars";
        //         break;
        //     case 4:
        //         $type = "Other Activities";
        //         break;
        //     default:
        //         $type = "<b>Unknown</b>";
        //         break;
        // }
       $ic_id = $row['id'];
       $name = !empty($row['name']) ? $row['name'] : "<b>N/A</b>";
       $img_name = !empty($row['img_name']) ? $row['img_name'] : "<b>N/A</b>";
       $date = !empty($row['date']) ? $row['date'] : "<b>N/A</b>";
       $participants = !empty($row['participants']) ? $row['participants'] : "<b>N/A</b>";
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
                            <h1 class="m-0">Edit Acitivites</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Acitivites</li>

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
                                    <h3 class="card-title">Edit Acitivites</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="activities_update.php" enctype="multipart/form-data">

                                    <div class="card-body">
                                        <input type="hidden" name="id" value="<?php echo $ic_id; ?>">
                                        <div class="form-group">
                                            <label for="name">Event Name<span style="color: red;">*</span></label>
                                            <input type="text" name="name" class="form-control" id="name" value="<?php echo $name; ?>" placeholder="Enter Event Name" required>
                                        </div>
                                       <div class="form-group">
                                            <label for="event-type">Event Type<span style="color: red;">*</span></label>
                                            <select name="type" class="form-control" id="event-type" required>
                                                <option value="" disabled>Select Event Type</option>
                                                <option value="1" <?php if ($type == '1') echo 'selected'; ?>>FDP</option>
                                                <option value="2" <?php if ($type == '2') echo 'selected'; ?>>SDP</option>
                                                <option value="3" <?php if ($type == '3') echo 'selected'; ?>>Workshops & Seminars</option>
                                                <option value="4" <?php if ($type == '4') echo 'selected'; ?>>Other Activities</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Participants<span style="color: red;">*</span></label>
                                            <input type="text" name="participants" class="form-control" id="participants" value="<?php echo $participants; ?>" placeholder="Enter Participants" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Date <span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="date" value="<?php echo $date; ?>" placeholder="Enter Date" required>
                                        </div>

                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Image</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image_upload" name="image_upload">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="imgPrev">
                                        </div>
                                        <div name="image2" id="image2" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Current Image</label><br>
                                                <img src="<?php echo "../uploads/iksve_cell/$img_name"; ?>" width="200" height="200">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload New Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image_upload" name="image_upload">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group" id="imgPrev"></div>
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

    <!-- dropzonejs -->
    <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
</body>

</html>


<script>
    const input = document.getElementById('image_uploads');
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
        $("#imgInp").change(function() {
            var selectedOption = $(this).children("option:selected").val();
            $("#image_display_main").hide();
        });
    });
</script>