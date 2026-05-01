<?php
include '../include/checklogin.php';

if (!isset($_GET['tt_id'])) {
    header("Location: timetable_view.php");
    exit;
}

$timetable_id = intval($_GET['tt_id']);

/* =========================
   FETCH EXISTING DATA
========================= */
$stmt = $con->prepare("SELECT * FROM tbl_timetable WHERE id = ?");
$stmt->bind_param("i", $timetable_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: timetable_view.php");
    exit;
}

$faculty_id = $data['faculty_id'];
$level_id   = $data['level_id'];
$program_id = $data['program_id'];
$sem_id     = $data['sem_id'];
$old_image  = $data['img_name'];

/* =========================
   UPDATE LOGIC
========================= */
if (isset($_POST['update'])) {

    $faculty_id = validate_data($_POST['faculty_id']);
    $level_id   = validate_data($_POST['level_id']);
    $program_id = validate_data($_POST['program_id']);
    $sem_id     = validate_data($_POST['sem_id']);

    $file_name = $old_image;

    if (!empty($_FILES['image_upload']['name'])) {

        $targetDirectory = "../uploads/timetable/";
        $upload = upload_single_file($_FILES["image_upload"], $targetDirectory, 1);

        if ($upload['status'] == 200) {
            $file_name = $upload['message'];

            if ($old_image && file_exists($targetDirectory . $old_image)) {
                unlink($targetDirectory . $old_image);
            }
        } else {
            $_SESSION['status'] = $upload['message'];
            $_SESSION['status_code'] = "error";
            header("Location: timetable_edit.php?id=" . $timetable_id);
            exit;
        }
    }

    $stmt = $con->prepare(
        "UPDATE tbl_timetable 
         SET faculty_id=?, level_id=?, program_id=?, sem_id=?, img_name=? 
         WHERE id=?"
    );
    $stmt->bind_param(
        "iiiisi",
        $faculty_id,
        $level_id,
        $program_id,
        $sem_id,
        $file_name,
        $timetable_id
    );

    if ($stmt->execute()) {
        $_SESSION['status'] = "Time Table Updated Successfully";
        $_SESSION['status_code'] = "success";
        header("Location: timetable_view.php");
        exit;
    } else {
        $_SESSION['status'] = "Update Failed";
        $_SESSION['status_code'] = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>

    <link rel="stylesheet" href="../../admin_assets/plugins/dropzone/min/dropzone.min.css">
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
                            <h1 class="m-0">Edit Time Table</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Time Table</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <div class="card card-gmiu">
                        <div class="card-header">
                            <h3 class="card-title">Edit Time Table</h3>
                        </div>

                        <form method="POST" enctype="multipart/form-data">
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

                                            <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                            echo "selected";
                                                                                        } ?>>
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
                                    <label>Select Program<span style="color: red;"> *</span></label>
                                    <select name="program_id" id="program_id" class="form-control" required>
                                        <option value="">---Select Program---</option>
                                    </select>
                                </div>
                                <!-- SEM -->
                                <div class="form-group">
                                    <label>Select Sem <span style="color:red">*</span></label>
                                    <select name="sem_id" class="form-control" required>
                                        <?php
                                        $res = $con->query("SELECT id,sem FROM tbl_sem WHERE is_active='1'");
                                        while ($row = $res->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $row['id']; ?>"
                                                <?= ($sem_id == $row['id']) ? 'selected' : ''; ?>>
                                                <?= $row['sem']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- IMAGE -->

                                <div name="image2" id="image2" class="form-group">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload Image<span
                                                style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">

                                                <input type="file" class="custom-file-input" id="image_upload"
                                                    name="image_upload">
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($old_image) { ?>
                                    <div class="form-group">
                                        <label>Current Image</label><br>
                                        <img src="../uploads/timetable/<?= $old_image; ?>" width="150" height="150">
                                    </div>
                                <?php } ?>

                            </div>

                            <div class="card-footer">
                                <button type="submit" name="update" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="timetable_view.php" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>
    <script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <script>
        const input = document.getElementById('imgInp');
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
            //call for listing the dropdown and select by default
            load_level();
            load_program();
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

        function load_program() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;
            var program_id = <?php echo $program_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_data: level_id,
                    program_id: program_id,
                    api_for: api_for
                },
                success: function(result) {
                    $('#program_id').html(result);
                }
            });

        }
    </script>
    <script type="text/javascript">
        $('#faculty_id').on('change', function() {
            var path = '<?php echo "$base_url_api"; ?>';
            var faculty_id = this.value;
            // alert("hii");
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function(result) {
                    $('#level_id').html(result);

                    // console.log(result);
                }
            })
        });

        $('#level_id').on('change', function() {
            var path = '<?php echo "$base_url_api"; ?>';
            var level_id = this.value;
            var faculty_id = $("select#faculty_id option:checked").val();
            /*  alert(level_id); */

            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    level_data: level_id,
                    faculty_data: faculty_id
                },
                cache: false,
                success: function(data) {
                    $('#program_id').html(data);
                    // console.log(data);
                }
            })
        });
    </script>
</body>

</html>