<?php
include './include/checklogin.php';

if (isset($_POST['update'])) {
    extract($_POST);
    if (isset($_POST['first_name']) && isset($_POST['middle_name']) && isset($_POST['last_name'])) {
        $stmt = $con->prepare("UPDATE tbl_students_2023 SET first_name=?,middle_name=?, last_name=?, email = ?, mobile_number = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $first_name, $middle_name, $last_name, $email, $mobile, $student_id);
        $result = $stmt->execute();
    } else {
        $stmt = $con->prepare("UPDATE tbl_students_2023 SET email = ?, mobile_number = ? WHERE id = ?");
        $stmt->bind_param("sii", $email, $mobile, $student_id);
        $result = $stmt->execute();
    }
    // Error handling if update fails
    if ($result) {
        // If update is successful, redirect
        $_SESSION['status'] = "Update Successfull!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Update Failed!";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
    }
}

if (isset($_POST['update_image'])) {
    if (isset($_FILES['passport_photo']) && $_FILES['passport_photo']['error'] != UPLOAD_ERR_NO_FILE) {
        $enrollment_no = "pro" . $er_no; // Replace with the actual enrollment number

        $targetDir = "../website_assets/images/std_profile/";
        $imageFileType = strtolower(pathinfo($_FILES["passport_photo"]["name"], PATHINFO_EXTENSION));
        $targetFile = $targetDir . $enrollment_no . '.' . $imageFileType;
        $final_file = $enrollment_no . '.' . $imageFileType;

        // Check if the file is an actual image
        $check = getimagesize($_FILES["passport_photo"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit;
        }

        // Check the file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "Invalid file type. Please upload a valid image file.";
            exit;
        }

        // Check if the file already exists
        if (file_exists($targetFile)) {
            // Delete the existing file
            unlink($targetFile);
        }

        // Move uploaded file to the target directory
        if (!move_uploaded_file($_FILES["passport_photo"]["tmp_name"], $targetFile)) {
            echo "Error moving uploaded file.";
            exit;
        }

        // Resize the image (replace with your image processing library or function)
        $originalImage = createImageFromType($imageFileType, $targetFile);
        if (!$originalImage) {
            echo "Error creating image from file.";
            exit;
        }

        list($width, $height) = getimagesize($targetFile);
        $newWidth = 450; // Set the new width as needed
        $newHeight = ($newWidth / $width) * $height;
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save the resized image back to the target file
        saveImageWithType($imageFileType, $resizedImage, $targetFile);

        // Update the database with the new file name
        $stmt = $con->prepare("UPDATE tbl_students_2023 SET profile_image = ? WHERE id = ?");
        $stmt->bind_param("si", $final_file, $student_id);
        $result = $stmt->execute();
        if ($result) {
            // If update is successful, redirect
            $_SESSION['status'] = "Update Successful!";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
        } else {
            $_SESSION['status'] = "Update Failed!";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
        }
    } else {
        $_SESSION['status'] = "File Not Selected";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
    }
}

if (isset($_POST['update_sign'])) {
    if (isset($_FILES['sign_photo']) && $_FILES['sign_photo']['error'] != UPLOAD_ERR_NO_FILE) {
        $enrollment_no = "sign" . $er_no; // Replace with the actual enrollment number

        $targetDir =  "../website_assets/images/std_signature/";
        $imageFileType = strtolower(pathinfo($_FILES["sign_photo"]["name"], PATHINFO_EXTENSION));
        $targetFile = $targetDir . $enrollment_no . '.' . $imageFileType;
        $final_file = $enrollment_no . '.' . $imageFileType;

        // Check if the file is an actual image
        $check = getimagesize($_FILES["sign_photo"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit;
        }

        // Check the file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "Invalid file type. Please upload a valid image file.";
            exit;
        }

        // Resize the image (replace with your image processing library or function)
        $originalImage = createImageFromType($imageFileType, $_FILES["sign_photo"]["tmp_name"]);
        if (!$originalImage) {
            echo "Error creating image from file.";
            exit;
        }

        list($width, $height) = getimagesize($_FILES["sign_photo"]["tmp_name"]);
        $newWidth = 450; // Set the new width as needed
        $newHeight = ($newWidth / $width) * $height;
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save the resized image back to the target file
        saveImageWithType($imageFileType, $resizedImage, $targetFile);

        // Check if the file already exists, and if so, unlink (delete) it
        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        // Move uploaded file to the target directory
        if (!move_uploaded_file($_FILES["sign_photo"]["tmp_name"], $targetFile)) {
            echo "Error moving uploaded file.";
            exit;
        }

        // Update the database with the new file name
        $stmt = $con->prepare("UPDATE tbl_students_2023 SET signature = ? WHERE id = ?");
        $stmt->bind_param("si", $final_file, $student_id);
        $result = $stmt->execute();
        if ($result) {
            // If update is successful, redirect
            $_SESSION['status'] = "Update Successful!";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
        } else {
            $_SESSION['status'] = "Update Failed!";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='editProfile.php'},1000)</script>";
        }
    } else {
        $_SESSION['status'] = "File Not Selected";
        $_SESSION['status_code'] = "error";
    }
}




function createImageFromType($type, $file)
{
    switch ($type) {
        case 'jpg':
        case 'jpeg':
            return imagecreatefromjpeg($file);
        case 'png':
            return imagecreatefrompng($file);
        case 'gif':
            return imagecreatefromgif($file);
        default:
            return false;
    }
}

function saveImageWithType($type, $image, $file)
{
    switch ($type) {
        case 'jpg':
        case 'jpeg':
            return imagejpeg($image, $file);
        case 'png':
            return imagepng($image, $file);
        case 'gif':
            return imagegif($image, $file);
        default:
            return false;
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
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
                            <h1 class="m-0">Edit User Profile</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid ">
                    <div class="card card-primary">

                        <!-- form start -->
                        <form class="form" method="post">
                            <div class="card-body">
                                <?php
                                if ($first_name == "N/A" || $middle_name == "N/A" || $last_name == "N/A") {
                                ?>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="<?php echo $first_name ?>">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="middle_name">Middle Name</label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="<?php echo $middle_name ?>">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php echo $last_name ?>">
                                        </div>
                                    </div>
                                <?php }
                                ?>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo $email ?>">
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile number" value="<?php echo $mobile_number ?>">
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                </div>
                            </div>
                        </form>

                        <hr>
                        <div class="card-header bg-light">
                            <h3 class="card-title">
                                Update Document
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="passport_photo">Choose Passport Photo:</label>
                                    <div class="row">
                                        <div class="col-8">
                                            <input type="file" class="form-control" name="passport_photo" id="passport_photo" accept="image/*">
                                        </div>
                                        <div class="col-4">
                                            <button type="submit" name="update_image" class="btn btn-info"><i class="fa fa-upload"></i> Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="sign_photo">Choose Signature Photo:</label>
                                    <div class="row">
                                        <div class="col-8">
                                            <input type="file" class="form-control" name="sign_photo" id="sign_photo" accept="image/*">
                                        </div>
                                        <div class="col-4">
                                            <button type="submit" name="update_sign" class="btn btn-info"><i class="fa fa-upload"></i> Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>
</body>

</html>