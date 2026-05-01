<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Check if ID is provided in the URL
if (!isset($_GET['post_id']) || empty($_GET['post_id'])) {
    $_SESSION['status'] = "Invalid Post ID";
    $_SESSION['status_code'] = "error";
    header("Location: post_view.php");
    exit();
} else {
    $id = intval($_GET['post_id']);
}


// Fetch existing post details
$stmt = $con->prepare("SELECT * FROM tbl_post WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    $_SESSION['status'] = "Post Not Found";
    $_SESSION['status_code'] = "error";
    header("Location: post_view.php");
    exit();
}

// Handle form submission
if (isset($_POST['submit'])) {
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $type_file = mysqli_real_escape_string($con, $_POST['type']);
    $field_name = mysqli_real_escape_string($con, $_POST['field_name']);

    $s = $date;
    $year = strtok($s, '-');
    $month = strtok('-');

    if ($type_file == 'video') {
        // Get the video link from the form
        $video_link = $_POST['video_link'];

        // Convert YouTube Shorts URL to Embed Format
        $video_link = str_replace("youtube.com/shorts/", "youtube.com/embed/", $video_link);
        $stmt = $con->prepare("UPDATE tbl_post SET date=?, file_type=?, file=?, field_name=?, year=?, month=? WHERE id=?");
        $stmt->bind_param("ssssiii", $date, $type_file, $video_link, $field_name, $year, $month, $id);
    } elseif ($type_file == 'image') {
        $stmt = $con->prepare("UPDATE tbl_post SET date=?, file_type=?, field_name=?, year=?, month=? WHERE id=?");
        $stmt->bind_param("sssiii", $date, $type_file, $field_name, $year, $month, $id);
    }

    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Post Updated Successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error updating Post";
        $_SESSION['status_code'] = "error";
    }

    echo "<script>setTimeout(function(){window.location='post_view.php'},1000);</script>";
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
                            <h1 class="m-0">Edit Post</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Post</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <form method="POST">
                    <div class="container-fluid">
                        <div class="card card-gmiu">
                            <div class="card-header">
                                <h1 class="card-title">Edit Post</h1>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Type of File</label>
                                    <select id="type" class="form-control" name="type" required>
                                        <option value="image" <?php if ($post['file_type'] == 'image')
                                            echo 'selected'; ?>>Image</option>
                                        <option value="video" <?php if ($post['file_type'] == 'video')
                                            echo 'selected'; ?>>Video</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control"
                                        value="<?php echo $post['date']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Field Name</label>
                                    <select class="form-control" name="field_name" required>
                                        <option value="after10th" <?php if ($post['field_name'] == 'after10th')
                                            echo 'selected'; ?>>After 10th</option>
                                        <option value="after12th_A" <?php if ($post['field_name'] == 'after12th_A')
                                            echo 'selected'; ?>>After 12th (A Group)</option>
                                        <option value="after12th_B" <?php if ($post['field_name'] == 'after12th_B')
                                            echo 'selected'; ?>>After 12th (B Group)</option>
                                        <option value="afterGraduation" <?php if ($post['field_name'] == 'afterGraduation')
                                            echo 'selected'; ?>>After
                                            Graduation</option>
                                    </select>
                                </div>
                                <div id="image_section" class="form-group" <?php if ($post['file_type'] != 'image')
                                    echo 'style="display:none;"'; ?>>
                                    <label>Upload New Images (Optional)</label>
                                    <input type="file" class="form-control" name="file_input[]" multiple>
                                </div>
                                <div id="video_section" class="form-group" <?php if ($post['file_type'] != 'video')
                                    echo 'style="display:none;"'; ?>>
                                    <label>Video Link</label>
                                    <input type="text" name="video_link" class="form-control"
                                        value="<?php echo $post['file']; ?>">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
    </div>

    <script>
        document.getElementById("type").addEventListener("change", function () {
            var selectedOption = this.value;
            document.getElementById("image_section").style.display = selectedOption === "image" ? "block" : "none";
            document.getElementById("video_section").style.display = selectedOption === "video" ? "block" : "none";
        });
    </script>
    <?php include '../include/importjs.php'; ?>
</body>

</html>