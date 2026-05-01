<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Get the form data
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    
    // Handle image upload
    if (isset($_FILES['file_input']) && !empty($_FILES['file_input']['name'][0])) {
        $uploaded_files = [];
        $upload_errors = [];
        
        // Loop through each uploaded file
        foreach($_FILES['file_input']['name'] as $key => $fileName) {
            if(empty($fileName)) continue;
            
            $fileTmpName = $_FILES['file_input']['tmp_name'][$key];
            $fileSize = $_FILES['file_input']['size'][$key];
            
            // Get file extension and base name
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $baseFileName = pathinfo($fileName, PATHINFO_FILENAME);
            
            // Check file type
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'webp');
            if (!in_array($fileExtension, $allowedTypes)) {
                $upload_errors[] = "Invalid file type for $fileName. Allowed types: " . implode(', ', $allowedTypes);
                continue;
            }
            
            // Check file size (5MB limit)
            if ($fileSize > 5 * 1024 * 1024) {
                $upload_errors[] = "File $fileName is too large. Maximum size is 5MB";
                continue;
            }
            
            $targetDirectory = "../../uploads/ugc/";
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            // Clean the filename to remove special characters
            $cleanFileName = preg_replace("/[^a-zA-Z0-9]/", "_", $baseFileName);
            $finalFileName = $cleanFileName . '.' . $fileExtension;
            $targetFilePath = $targetDirectory . $finalFileName;
            
            // If file already exists, add a number suffix
            $counter = 1;
            while (file_exists($targetFilePath)) {
                $finalFileName = $cleanFileName . '_' . $counter . '.' . $fileExtension;
                $targetFilePath = $targetDirectory . $finalFileName;
                $counter++;
            }
            
            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                $uploaded_files[] = $finalFileName;
            } else {
                $upload_errors[] = "Failed to upload $fileName";
            }
        }
        
        if (!empty($uploaded_files)) {
            // First image becomes the main image
            $main_image = $uploaded_files[0];
            
            // Insert into tbl_admission_merit
            $stmt = $con->prepare("INSERT INTO tbl_admission_merit (type, year, image, is_delete) VALUES (?, ?, ?, '0')");
            
            if ($stmt === false) {
                $_SESSION['status'] = "Database prepare error: " . $con->error;
                $_SESSION['status_code'] = "error";
            } else {
                $stmt->bind_param("sis", $type, $year, $main_image);
                
                if ($stmt->execute()) {
                    $merit_id = $con->insert_id;
                    
                    // Insert all images into tbl_admission_merit_images
                    foreach ($uploaded_files as $image) {
                        $stmt2 = $con->prepare("INSERT INTO tbl_admission_merit_images (merit_id, image_path) VALUES (?, ?)");
                        if ($stmt2) {
                            $stmt2->bind_param("is", $merit_id, $image);
                            $stmt2->execute();
                        }
                    }
                    
                    $_SESSION['status'] = " UGC Inserted Successfully";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "Database error: " . $stmt->error;
                    $_SESSION['status_code'] = "error";
                }
            }
        } else {
            $_SESSION['status'] = implode("\n", $upload_errors);
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "Please upload at least one image";
        $_SESSION['status_code'] = "error";
    }
    
    echo "<script>setTimeout(function(){window.location='ugc_view.php'},1000);</script>";
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
                            <h1 class="m-0">Add UGC </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add UGC </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Add UGC </h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Type<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="type" required>
                                                <option value="">---Select Type---</option>
                                                <option value="schedule">Schedule</option>
                                                <option value="advertisement">Advertisement</option>
                                                <option value="merit_list">Merit List</option>
                                     
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Year<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="year" required>
                                                <option value="">---Select Year---</option>
                                                <?php
                                                $current_year = date('Y');
                                                for($year = $current_year; $year >= $current_year - 5; $year--) {
                                                    echo "<option value='$year'>$year</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Upload Images (Multiple Images)<span style="color: red;"> *</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="file_input[]" 
                                                           id="file_input" accept="image/*" required multiple>
                                                    <label class="custom-file-label" for="file_input">Choose files</label>
                                                </div>
                                            </div>
                                            <small class="text-muted">You can select multiple images. The first image will be the main image. Maximum file size: 5MB per image. Allowed formats: jpg, jpeg, png, gif, webp</small>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
    </div>

    <?php include '../include/importjs.php'; ?>

    <script>
        $(document).ready(function() {
            // Show selected file names
            $('#file_input').on('change', function() {
                var files = this.files;
                var fileNames = [];
                
                if (files.length > 0) {
                    for (var i = 0; i < files.length; i++) {
                        if (files[i].size > 5 * 1024 * 1024) {
                            alert('File ' + files[i].name + ' is too large. Maximum size is 5MB');
                            $(this).val('');
                            $(this).next('.custom-file-label').text('Choose files');
                            return;
                        }
                        fileNames.push(files[i].name);
                    }
                    $(this).next('.custom-file-label').text(fileNames.join(', '));
                } else {
                    $(this).next('.custom-file-label').text('Choose files');
                }
            });
        });
    </script>

    <?php if (isset($_SESSION['status'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: '<?php echo $_SESSION['status_code'] == 'success' ? 'Success!' : 'Error!'; ?>',
            text: '<?php echo $_SESSION['status']; ?>',
            icon: '<?php echo $_SESSION['status_code']; ?>',
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['status']); unset($_SESSION['status_code']); ?>
    <?php endif; ?>
</body>

</html>

