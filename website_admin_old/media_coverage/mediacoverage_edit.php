<?php
include '../include/checklogin.php';

// Fetch data from the database
if (isset($_GET['mediacoverage_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['mediacoverage_id']);
    $query = "SELECT * FROM `tbl_media_coverage` WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        $_SESSION['status'] = "Record not found!";
        $_SESSION['status_code'] = "error";
        header('Location: mediacoverage_view.php');
        exit;
    }
} else {
    $_SESSION['status'] = "No ID specified!";
    $_SESSION['status_code'] = "error";
    header('Location: mediacoverage_view.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
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
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Media Coverage </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Media Coverage</li>
                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>

            <section class="content">
                <form id="post" name="post" method="POST" enctype='multipart/form-data'
                    action="mediacoverage_update.php">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Media Coverage</h3>
                                    </div>
                                    <!-- Updated Form Section -->
                                    <div class="card-body">
                                        <input type="hidden" name="id" value="<?= $data['id']; ?>">


                                        <?php if ($data['file_type'] == 'reel') { ?>

                                            <div class="form-group">
                                                <label for="faculty_id">Select Faculty <span
                                                        style="color: red;">*</span></label>
                                                <select name="faculty" class="form-control" id="faculty">
                                                    <option value="">-- Select Faculty --</option>
                                                    <?php
                                                    // Fetch faculty names from the database
                                                    $query = "SELECT id, name FROM tbl_faculty where is_delete = '0' and is_active='1'";
                                                    $result1 = mysqli_query($con, $query);

                                                    // Check if records exist
                                                    if (mysqli_num_rows($result1) > 0) {
                                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                                            $selected = ($data['faculty_id'] == $row1['id']) ? 'selected' : ''; // Check if the faculty_id matches
                                                            echo "<option value='{$row1['id']}' $selected>{$row1['name']}</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="level">Select Level<span style="color: red;">
                                                        *It Will Show In Institude Page(skip for home
                                                        page)</span></label>
                                                <select id="level" name="level" class="form-control">
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="program">Select Program<span style="color: red;">
                                                        *It Will Show In Institude Page(skip for home
                                                        page)</span></label>
                                                <select id="program" name="program" class="form-control">
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="is_common">Is Common ?
                                                    <span style="color: red;">*Optional</span>
                                                </label>
                                                <div class="form-control ml-5" style="border: none; padding: 0;">
                                                    <input class="form-check-input" type="checkbox" id="is_common" <?php echo ($data['is_common_reel'] == 1 ? 'checked' : ''); ?>
                                                        name="is_common">
                                                    <label class="form-check-label" for="is_common">
                                                        Is this Reel is common ???
                                                    </label>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <!-- File Preview Section -->
                                        <div class="form-group">
                                            <label>File Preview</label>
                                            <?php if ($data['file_type'] == 'image'): ?>
                                                <div
                                                    style="max-width: 200px; max-height: 200px; overflow: hidden; margin-top: 10px;">
                                                    <img src="../uploads/media_coverage/<?= $data['file']; ?>"
                                                        alt="<?= $data['alt_text']; ?>"
                                                        style="width: 100%; height: auto; border: 1px solid #ccc; border-radius: 5px;">
                                                </div>
                                            <?php elseif ($data['file_type'] == 'video'): ?>
                                                <div style="margin-top: 10px;">
                                                    <a href="<?= $data['file']; ?>" target="_blank"
                                                        style="color: #007bff; text-decoration: underline; font-size: 14px;"><?= $data['file']; ?></a>
                                                </div>
                                            <?php elseif ($data['file_type'] == 'reel'): ?>
                                                <div style="margin-top: 10px;">
                                                    <a href="<?= $data['file']; ?>" target="_blank"
                                                        style="color: #007bff; text-decoration: underline; font-size: 14px;"><?= $data['file']; ?></a>
                                                </div>
                                                <div class="form-group" name="videolink" id="videolink">
                                                    <label for="name">video link<span style="color: red;">*</span></label>
                                                    <input type="text" name="videolink" class="form-control" id="videolink" value="<?php echo $data['file']; ?>"
                                                        placeholder="Enter video link">
                                                </div>
                                            <?php endif; ?>
                                        </div>


                                        <!-- Alt Text for Image -->
                                        <div class="form-group">
                                            <label for="alt_text">Alt Text for Image(s) <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" name="alt_text" class="form-control" id="alt_text"
                                                value="<?= $data['alt_text']; ?>"
                                                placeholder="Enter alt text for images" required>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" id="submit" name="submit"
                                                class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
         <!-- Control Sidebar -->
   
    </div>

    <?php include '../include/importjs.php'; ?>

    <script>
        $(document).ready(function() {
            var faculty_id = <?php echo isset($data['faculty_id']) ? $data['faculty_id'] : 'null'; ?>;
            var level_id = <?php echo isset($data['level_id']) ? $data['level_id'] : 'null'; ?>;
            var program_id = <?php echo isset($data['program_id']) ? $data['program_id'] : 'null'; ?>;

            // Fetch levels
            $.ajax({
                url: '../include/level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: 'dashboard',
                },
                success: function(result) {
                    $('#level').html(result);
                }
            });

            // Fetch programs
            $.ajax({
                url: '../include/program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_data: level_id,
                    program_id: program_id,
                    api_for: 'dashboard',
                },
                success: function(result) {
                    $('#program').html(result);
                }
            });
        });


        $('#faculty').on('change', function() {
            var faculty_id = this.value;
            $.ajax({
                url: '../include/level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function(result) {
                    $('#level').html(result);
                }
            })
        });

        $('#level').on('change', function() {
            var level_id = this.value;
            var faculty_id = $("select#faculty option:checked").val();

            $.ajax({
                url: '../include/program.php',
                type: "POST",
                data: {
                    level_data: level_id,
                    faculty_data: faculty_id
                },
                cache: false,
                success: function(data) {
                    $('#program').html(data);
                }
            })
        });
    </script>
</body>

</html>