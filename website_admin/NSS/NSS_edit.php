<?php
include '../include/checklogin.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <?php include '../include/importcss.php'; ?>

    <link rel="stylesheet" href="../../admin_assets/plugins/dropzone/min/dropzone.min.css">

    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('text_editor');
        });
    </script>
</head>

<?php
$id = intval($_GET['NSS_id']);

$flag = "";
$flag2 = "";
$flag3 = "";

// Handle Text Field Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $sql = "UPDATE tbl_nss SET report_title = ?, description = ?, date = ? WHERE id = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $title, $description, $date, $id);
        if ($stmt->execute()) {
           $flag = true;
        } else {
            // echo "Error: " . $stmt->error;
            $flag = false;
        }
        $stmt->close(); // Ensure we close the statement after usage
    } else {
        // echo "Error preparing statement: " . $con->error;
        $flag = false;
    }
}

// Handle Image Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image_upload']) && !empty($_FILES['image_upload']['name'][0])) {
    // Folder where images are stored
    $upload_dir = '../uploads/NSS/report_thumbnail/';

    // Retrieve existing images from the database
    $select_images_query = "SELECT image FROM tbl_nss_images WHERE nss_id = ?";
    $stmt1 = $con->prepare($select_images_query);
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $stmt1->bind_result($old_image);

    // Delete old images from the folder
    while ($stmt1->fetch()) {
        $old_image_path = $upload_dir . $old_image;
        if (file_exists($old_image_path)) {
            unlink($old_image_path); // Delete the old image file
        }
    }
    $stmt1->close();

    // Delete old image records from the database
    $delete_images_query = "DELETE FROM tbl_nss_images WHERE nss_id = ?";
    $stmt2 = $con->prepare($delete_images_query);
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->close();

    // Loop through the uploaded files
    $file_count = count($_FILES['image_upload']['name']);
    $upload_success = true;

    for ($i = 0; $i < $file_count; $i++) {
        // Get file information
        $file_name = basename($_FILES['image_upload']['name'][$i]);
        $target_file = $upload_dir . $file_name;

        // Check if file is a valid image
        $check = getimagesize($_FILES['image_upload']['tmp_name'][$i]);
        if ($check !== false) {
            // Attempt to move the file to the uploads directory
            if (move_uploaded_file($_FILES['image_upload']['tmp_name'][$i], $target_file)) {
                // Insert the new image into the database
                $insert_image_query = "INSERT INTO tbl_nss_images (nss_id, image) VALUES (?, ?)";
                $stmt3 = $con->prepare($insert_image_query);
                $stmt3->bind_param("is", $id, $file_name);
                if (!$stmt3->execute()) {
                    $upload_success = false;
                    error_log("Error executing insert query: " . $stmt3->error);
                    break;
                }
                $stmt3->close();
            } else {
                $upload_success = false;
                error_log("Error moving file: " . $_FILES['image_upload']['name'][$i]);
                break;
            }
        } else {
            $upload_success = false;
            error_log("File is not an image: " . $_FILES['image_upload']['name'][$i]);
            break;
        }
    }

    // Check if all uploads were successful
    if ($upload_success) {
        $flag2 = true;
    } else {
        // echo "There was an error updating the images. Please try again.";
        $flag2 = false;
    }
}else{
    $flag2 = true;
}

// Handle PDF Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['report_upload']) && !empty($_FILES['report_upload']['name'])) {
    // Folder where PDFs are stored
    $upload_dir = '../uploads/NSS/report/';

    // Retrieve the existing PDF file name from the database
    $select_pdf_query = "SELECT report FROM tbl_nss WHERE id = ?";
    $stmt = $con->prepare($select_pdf_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($old_pdf);
    $stmt->fetch();
    $stmt->close();

    // Delete the old PDF file if it exists
    if ($old_pdf) {
        $old_pdf_path = $upload_dir . $old_pdf;
        if (file_exists($old_pdf_path)) {
            unlink($old_pdf_path); // Delete the old PDF file
        }
    }

    // Upload success flag
    $upload_success = false;
    $pdf_name = '';

    // Check if a file is uploaded
    if (!empty($_FILES['report_upload']['name'])) {
        $pdf_name = basename($_FILES['report_upload']['name']);
        $target_file = $upload_dir . $pdf_name;

        // Check if file is a valid PDF
        $file_type = mime_content_type($_FILES['report_upload']['tmp_name']);
        if ($file_type == 'application/pdf') {
            // Attempt to move the file to the uploads directory
            if (move_uploaded_file($_FILES['report_upload']['tmp_name'], $target_file)) {
                $upload_success = true; // Set the upload success to true only on successful upload
            } else {
                echo "There was an error uploading the file.";
            }
        } else {
            echo "Only PDF files are allowed.";
        }
    }

    // If the upload was successful, update the database
    if ($upload_success) {
        $update_pdf_query = "UPDATE tbl_nss SET report = ? WHERE id = ?";
        $stmt = $con->prepare($update_pdf_query);
        $stmt->bind_param("si", $pdf_name, $id);
        if ($stmt->execute()) {
            $flag3 = true;
        } else {
            // echo "Error updating PDF: " . $stmt->error;
            $flag3 = false;
        }
        $stmt->close();
    } else {
        // echo "There was an error updating the PDF. Please try again.";
        $flag3 = false;
    }
}else{
    $flag3 = true;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $flag == true && $flag2 == true && $flag3 == true){
    $_SESSION['status'] = "NSS Updated Successfully";
    $_SESSION['status_code'] = "success";
    echo "<script>setTimeout(function(){window.location='NSS_view.php'},1000);</script>";
}else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['status'] = "NSS No Updated Successfully";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='NSS_view.php'},1000);</script>";
}

?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit NSS</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add NSS</li>
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
                                    <h3 class="card-title">Add NSS</h3>
                                </div>
                                <?php
                                $sql = "SELECT * FROM tbl_NSS where id = $id";
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <form id="quickForm" method="POST" enctype="multipart/form-data">
                                            <div class="card-body">

                                                <div class="form-group">
                                                    <label for="name">Report Title<span style="color: red;">*</span></label>
                                                    <input type="text" name="title" class="form-control" id="title_id"
                                                        placeholder="Enter NSS Report Title"
                                                        value="<?php echo $row['report_title']; ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Description<span
                                                            style="color: red;">*</span></label>
                                                    <textarea name="description" class="form-control" id="description"
                                                        placeholder="Enter Report Description"
                                                        required><?php echo $row['description']; ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="date">Date<span style="color: red;">*</span></label>
                                                    <input type="date" name="date" class="form-control" id="date"
                                                        value="<?php echo $row['date']; ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="report_upload">Upload Report<span
                                                            style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="report_upload"
                                                                id="report_upload">
                                                            <label class="custom-file-label" for="report_upload">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                    <?php if ($row['report']) { ?>
                                                        <p class="text-primary"><?php echo $row['report']; ?></p>
                                                    <?php } ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="image_upload">Upload Image (Multiple Images)<span
                                                            style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="image_upload[]"
                                                                id="image_upload" multiple>
                                                            <label class="custom-file-label" for="image_upload">Choose
                                                                files</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-group" id="imgPrev"></div>
                                                <div class="row">
                                                    <?php
                                                    $image_query = "SELECT * FROM tbl_nss_images WHERE nss_id = " . $id . "";
                                                    $image_result = $con->query($image_query);
                                                    while ($image_row = $image_result->fetch_assoc()) {
                                                        echo '<div class="col-md-4 gallery-item">';
                                                        echo '<div class="card">';
                                                        echo '<img src="../uploads/NSS/report_thumbnail/' . htmlspecialchars($image_row['image']) . '" class="card-img-top" alt="Gallery Image">'; // Use htmlspecialchars for security
                                                        echo '</div>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                } else {
                                    echo "No results found.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <?php include '../include/importjs.php'; ?>

    <script src="../../admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
</body>

</html>

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
    $(function () {
        bsCustomFileInput.init();
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>