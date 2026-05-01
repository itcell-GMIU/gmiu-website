<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Get the date, type of file, and field name from the form
    // $date = mysqli_real_escape_string($con, $_POST['date']);
    $type_file = mysqli_real_escape_string($con, $_POST['type']);
    $field_name = mysqli_real_escape_string($con, $_POST['field_name']);

    // Extract the year and month from the date
    // $s = $date;
    // $year = strtok($s, '-');
    // $month = strtok('-');

    // Check the type of file selected
    if ($type_file == 'video') {
        // Get the video links (array)
        $video_links = $_POST['videolink'];

        // Prepare statement once
        $stmt = $con->prepare("INSERT INTO tbl_post(date, file_type, file, field_name) VALUES (NOW(),?,?,?)");

        foreach ($video_links as $video_link) {
            // Skip empty inputs
            if (trim($video_link) == '')
                continue;

            // Convert YouTube Shorts URL to Embed Format
            $video_link = str_replace("youtube.com/shorts/", "youtube.com/embed/", $video_link);

            // Bind and execute
            $stmt->bind_param("sss", $type_file, $video_link, $field_name);
            $stmt->execute();
        }

        $_SESSION['status'] = "Post(s) Inserted Successfully";
        $_SESSION['status_code'] = "success";

        // echo "<script>setTimeout(function(){window.location='post_view.php'},1000);</script>";
    } elseif ($type_file == 'image') {
        // Insert into tbl_daily_post table for image
        $stmt = $con->prepare("INSERT INTO tbl_post(date, file_type, field_name) VALUES (?,?,?)");
        $stmt->bind_param("sssii", $date, $type_file, $field_name);
        $result = $stmt->execute();

        // Get last inserted ID
        $type_id = $con->insert_id;

        // Check if files were uploaded
        if (isset($_FILES['file_input'])) {
            $targetDirectory = "../uploads/post/";
            $uploaded_images = upload_multiple_files($_FILES["file_input"], $targetDirectory, 1);

            if ($uploaded_images['status'] == 200) {
                foreach ($uploaded_images['message'] as $file_name) {
                    $file_type = "image";
                    $type = "daily_post";
                    $file_name = implode("", $file_name);
                    $stmt = $con->prepare("INSERT INTO tbl_site_photos (type_id, type, file_name, file_type) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $type_id, $type, $file_name, $file_type);
                    $stmt->execute();
                }

                $_SESSION['status'] = " Post Inserted Successfully";
                $_SESSION['status_code'] = "success";
            } else {
                // Delete entry if there was an error
                $stmt = $con->prepare("DELETE FROM tbl_post WHERE id = ?");
                $stmt->bind_param("i", $type_id);
                $stmt->execute();

                $_SESSION['status'] = $uploaded_images['message'];
                $_SESSION['status_code'] = "error";
            }
            echo "<script>setTimeout(function(){window.location='post_insert.php'},1000);</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
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
                            <h1 class="m-0">Add Post</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Post</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <form method="POST" enctype='multipart/form-data'>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Post</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select Type of File<span style="color: red;"> *</span></label>
                                            <select id="type" onchange="insertContactfields()" class="form-control"
                                                name="type" required>
                                                <option value="">---Select File---</option>
                                                <option value="image">Image</option>
                                                <option value="video">Video</option>
                                            </select>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="level_name">Date<span style="color: red;">*</span></label>
                                            <input type="date" name="date" class="form-control" required>
                                        </div> -->

                                        <div class="form-group">
                                            <label>Field Name<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="field_name" required>
                                                <option value="">---Select Field---</option>
                                                <option value="after10th">After 10th</option>
                                                <option value="after12th_A">After 12th (A Group)</option>
                                                <option value="after12th_B">After 12th (B Group)</option>
                                                <option value="afterGraduation">After Graduation</option>
                                            </select>
                                        </div>

                                        <div name="image" id="image" class="form-group">
                                            <label>Upload Images (Multiple Images)</label><span style="color: red;">
                                                *</span>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="file_input[]"
                                                        id="file_input" multiple>
                                                    <label class="custom-file-label">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="videolink">
                                            <label>Video Link (Embedded YouTube Video Link Only)
                                                <span style="color: red;">*</span>
                                            </label>

                                            <div class="input-group mb-2">
                                                <input type="text" name="videolink[]" class="form-control"
                                                    placeholder="Enter video link">
                                                <button type="button" class="btn btn-success add-field">+</button>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" id="submit" name="submit"
                                                class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </form>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>

    <script>
        $(document).ready(function () {
            $("#image").hide();
            $("#videolink").hide();
            $("#type").change(function () {
                var selectedOption = $(this).val();
                if (selectedOption == "image") {
                    $("#image").show();
                    $("#videolink").hide();
                } else {
                    $("#image").hide();
                    $("#videolink").show();
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const wrapper = document.getElementById("videolink");

            // Handle input with comma separation
            wrapper.addEventListener("input", function (e) {
                if (e.target.tagName === "INPUT") {
                    let values = e.target.value.split(",").map(v => v.trim()).filter(v => v);

                    if (values.length > 1) {
                        // Replace current input with individual fields
                        e.target.closest(".input-group").remove();

                        values.forEach((link, index) => {
                            const newGroup = document.createElement("div");
                            newGroup.className = "input-group mb-2";
                            newGroup.innerHTML = `
                        <input type="text" name="videolink[]" class="form-control" value="${link}" placeholder="Enter video link">
                        <button type="button" class="btn btn-${index === values.length - 1 ? "success add-field" : "danger remove-field"}">
                            ${index === values.length - 1 ? "+" : "-"}
                        </button>
                    `;
                            wrapper.appendChild(newGroup);
                        });
                    }
                }
            });

            // Handle add/remove buttons
            wrapper.addEventListener("click", function (e) {
                if (e.target.classList.contains("add-field")) {
                    const newGroup = document.createElement("div");
                    newGroup.className = "input-group mb-2";
                    newGroup.innerHTML = `
                <input type="text" name="videolink[]" class="form-control" placeholder="Enter video link">
                <button type="button" class="btn btn-danger remove-field">-</button>
            `;
                    wrapper.appendChild(newGroup);
                }

                if (e.target.classList.contains("remove-field")) {
                    e.target.closest(".input-group").remove();
                }
            });
        });
    </script>

</body>

</html>