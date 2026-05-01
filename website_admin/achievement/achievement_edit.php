<?php
include '../include/checklogin.php';

// Check if ach_id is provided
if (isset($_GET['ach_id'])) {
    $ach_id = mysqli_real_escape_string($con, $_GET['ach_id']);
    
    // Fetch existing achievement data
    $stmt = $con->prepare("SELECT * FROM `tbl_achievement` WHERE id = ? AND is_delete = 0");
    $stmt->bind_param("i", $ach_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $achievement = $result->fetch_assoc();
        $existing_program_id = explode(',', $achievement['program_id']);
        $existing_type = $achievement['type'];
    } else {
        $_SESSION['status'] = "Achievement not found";
        $_SESSION['status_code'] = "error";
        header("Location: achievement_view.php");
        exit();
    }
} else {
    header("Location: achievement_view.php");
    exit();
}

// Handle Update
if (isset($_POST['submit'])) {
    $ach_id = $_POST['ach_id'];
    $program_id = $_POST['program_id'];
    $program_id_str = implode(',', $program_id);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $type = validate_data($type);

    // Update tbl_achievement
    $stmt = $con->prepare("UPDATE `tbl_achievement` SET program_id = ?, type = ? WHERE id = ?");
    $stmt->bind_param("ssi", $program_id_str, $type, $ach_id);
    $result = $stmt->execute();

    if ($result) {
        // Handle image updates if new ones are uploaded
        if (isset($_FILES['images']['tmp_name'][0]) && !empty($_FILES['images']['tmp_name'][0])) {
            $targetDirectory = "../uploads/achievement/";
            $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

            if ($uploaded_images['status'] == 200) {
                // Delete old photos from tbl_site_photos
                $photo_type = "achievement";
                $del_stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE type_id = ? AND type = ?");
                $del_stmt->bind_param("is", $ach_id, $photo_type);
                $del_stmt->execute();

                // Insert new photos
                foreach ($uploaded_images['message'] as $file_name_arr) {
                    $file_type = "image";
                    $type1 = "achievement";
                    $file_name = implode("", $file_name_arr);
                    $ins_stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                    $ins_stmt->bind_param("isss", $ach_id, $type1, $file_name, $file_type);
                    $ins_stmt->execute();
                }
            } else {
                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
                header("Location: achievement_edit.php?ach_id=" . $ach_id);
                exit();
            }
        }

        $_SESSION['status'] = "Achievement Updated Successfully";
        $_SESSION['status_code'] = "success";
        header("Location: achievement_view.php");
        exit();
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

    <style>
    p { margin: 0; }
    .upload__img-wrap { display: flex; flex-wrap: wrap; margin: 0 -10px; }
    .upload__img-box { width: 200px; padding: 0 10px; margin-bottom: 12px; }
    .existing-images-wrap { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
    .existing-image-box { position: relative; width: 150px; height: 150px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
    .existing-image-box img { width: 100%; height: 100%; object-fit: cover; }
    </style>

    <script type="text/javascript" src="../admin_assets/ckeditor/ckeditor.js"></script>
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
                            <h1 class="m-0">Edit Achievement</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Achievement</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Achievement</h3>
                                </div>
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="ach_id" value="<?php echo $ach_id; ?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple" required>
                                                <?php
                                                $cmd = "SELECT pro.id,pro.name,level.name as level_name FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                                ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $p_id = $row['id'];
                                                    $p_name = $row['name'];
                                                    $l_name = $row['level_name'];
                                                    $selected = in_array($p_id, $existing_program_id) ? "selected" : "";
                                                ?>
                                                    <option value="<?php echo $p_id; ?>" <?php echo $selected; ?>>
                                                        <?php echo $p_name . "(" . $l_name . ")"; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Achievement<span style="color: red;"> *</span></label>
                                            <select id="type" class="form-control" name="type" required>
                                                <option value="">---Select Achievement---</option>
                                                <option value="student" <?php echo ($existing_type == 'student') ? "selected" : ""; ?>>Student Achievement</option>
                                                <option value="faculty" <?php echo ($existing_type == 'faculty') ? "selected" : ""; ?>>Faculty Achievement</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Existing Images</label>
                                            <div class="existing-images-wrap">
                                                <?php
                                                $img_stmt = $con->prepare("SELECT file_name FROM `tbl_site_photos` WHERE type = 'achievement' AND type_id = ?");
                                                $img_stmt->bind_param("i", $ach_id);
                                                $img_stmt->execute();
                                                $img_res = $img_stmt->get_result();
                                                while ($img_row = $img_res->fetch_assoc()) {
                                                    echo '<div class="existing-image-box"><img src="../uploads/achievement/' . $img_row['file_name'] . '" alt=""></div>';
                                                }
                                                ?>
                                            </div>
                                            <p class="text-muted mt-2"><small>* Uploading new images will replace all existing images.</small></p>
                                        </div>

                                        <label for="exampleInputFile">Upload New Images (Optional)</label>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="imgInp" name="images[]" multiple>
                                                <label class="custom-file-label" for="exampleInputFile">Choose Image</label>
                                            </div>
                                        </div>
                                        <div class="input-group" id="imgPrev"></div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Update Achievement</button>
                                            <a href="achievement_view.php" class="btn btn-default">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>
</body>

</html>

<script>
    $(document).ready(function() {
        $('.select2option').select2();
    });

    const input = document.getElementById('imgInp');
    const preview = document.getElementById('imgPrev');

    input.addEventListener('change', () => {
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        const files = input.files;
        if (!files) return;

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
                img.style.borderRadius = '8px';
                img.style.border = '1px solid #ddd';
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
</script>
