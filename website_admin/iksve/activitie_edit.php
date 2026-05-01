<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>
<?php
// Fetch program id and level id from display table
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = only_digits($id);

    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='student_corner_view.php'},1000)</script>";
    }
}

$cmd = $con->prepare("SELECT * FROM tbl_iksve_cell  WHERE id = ?");
$cmd->bind_param("i", $id);
$cmd->execute();
$result = $cmd->get_result();

while ($row = $result->fetch_assoc()) {
    // Fetch data from database
    $id = $row['id'];
    $type = $row['type_id'];
    $title = $row['name'];
    $img_name = $row['img_name'];
    $report = $row['report'];
    $description = $row['description'];
    $date = $row['date'];
    $participants = $row['participants'];
    
    
    
    // $name = !empty($row['name']) ? $row['name'] : "<b>N/A</b>";
    // $img_name = !empty($row['img_name']) ? $row['img_name'] : "<b>N/A</b>";
    // $report = !empty($row['report']) ? $row['report'] : "<b>N/A</b>";
    // $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
    // $date = !empty($row['date']) ? $row['date'] : "<b>N/A</b>";
    // $participants = !empty($row['participants']) ? $row['participants'] : "<b>N/A</b>";


      // Fetch related images
      $img_cmd = $con->prepare("SELECT image FROM tbl_iksve_cell_images WHERE iksve_cell_id = ?");
      $img_cmd->bind_param("i", $id);
      $img_cmd->execute();
      $img_result = $img_cmd->get_result();
      $images = [];
      while ($img_row = $img_result->fetch_assoc()) {
          $images[] = $img_row['image'];
      }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header -->
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
    <!-- wrapper -->
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
                            <h1 class="m-0">Edit IKSVE</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit IKSVE</li>

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
                                    <h3 class="card-title">Edit IKSVE</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="activitie_update.php" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        
                                       
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="form-group">
                                            <label for="name">Event Name<span style="color: red;">*</span></label>
                                            <input type="text" name="name" class="form-control" id="name" value="<?php echo $title; ?>" placeholder="Enter Event Name" required>
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
                                            <label for="name">Description<span style="color: red;">*</span></label>
                                            <input type="text" name="description" class="form-control" id="description" value="<?php echo $description; ?>" placeholder="Enter Participants">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Participants<span style="color: red;">*</span></label>
                                            <input type="text" name="participants" class="form-control" id="participants" value="<?php echo $participants; ?>" placeholder="Enter Participants" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Date <span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" id="date" value="<?php echo $date; ?>" placeholder="Enter Date" required>
                                        </div>
                                        <div name="report" id="report" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Report</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="report_upload" id="report_upload">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="card-footer"> -->
                                        <a href="<?php echo '../uploads/iksve_cell/' . $report; ?>" class="btn btn-primary">View Report</a>


                                        <!-- <div name="image" id="image" class="form-group">
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
                                        </div> -->
                                        <!-- <div class="form-group" id="imgPrev">
                                        </div> -->
                                        <div name="image2" id="image2" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Current Image</label><br>
                                                <?php
                                                        foreach ($images as $image) {
                                                            $imagePath = "../uploads/iksve_cell/" . htmlspecialchars($image);
                                                            if (file_exists($imagePath)) {
                                                                echo '<img src="' . $imagePath . '" alt="Image" class="image-preview" style="height:100px; width:100px;">';
                                                            } else {
                                                                echo '<span>No image found</span>';
                                                            }
                                                        }
                                                    ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="image_upload">Upload Image (Multiple Images)<span style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="image_upload[]" id="image_upload" multiple>
                                                        <label class="custom-file-label" for="image_upload">Choose files</label>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>

                                        <div class="input-group" id="imgPrev"></div>


                                        <!-- /.card-body -->
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
    $(document).ready(function() {
        //call for listing the dropdown and select by default
        load_level();
        load_program();
    });

   
</script>
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
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>