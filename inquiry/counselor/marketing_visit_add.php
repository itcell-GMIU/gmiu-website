<?php
include '../include/checklogin.php';
$staff_id = $_SESSION['staff_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    // Validate and sanitize input
    $date_of_visit = isset($_POST['date_of_visit']) ? $_POST['date_of_visit'] : '';
    $name_of_person = isset($_POST['name_of_person']) ? $_POST['name_of_person'] : '';
    $purpose = isset($_POST['purpose']) ? $_POST['purpose'] : '';
    $timing_of_departure = isset($_POST['timing_of_departure']) ? $_POST['timing_of_departure'] : '';
    $timing_of_arrival = isset($_POST['timing_of_arrival']) ? $_POST['timing_of_arrival'] : '';
    $travelling_timing = isset($_POST['travelling_timing']) ? $_POST['travelling_timing'] : '';
    $visit_time = isset($_POST['visit_time']) ? $_POST['visit_time'] : '';
    $contact_info = isset($_POST['contact_info']) ? $_POST['contact_info'] : '';
    $point_discussion = isset($_POST['point_discussion']) ? $_POST['point_discussion'] : '';
    $material_given = isset($_POST['material_given']) ? $_POST['material_given'] : '';
    $response = isset($_POST['response']) ? $_POST['response'] : '';

    // Handle multiple image uploads
    $image_names = [];
    $target_dir = '../uploads/marketing_visit/';

    foreach ($_FILES['images']['name'] as $key => $image_name) {
        if ($image_name != '') {
            $image_tmp_name = $_FILES['images']['tmp_name'][$key];
            $target_file = $target_dir . basename($image_name);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($image_tmp_name);
            if ($check === false) {
                $_SESSION['status'] = "File is not an image.";
                $_SESSION['status_code'] = "error";
                exit();
            }

            // Check file size (5MB max)
            if ($_FILES['images']['size'][$key] > 5000000) {
                $_SESSION['status'] = "Sorry, your file is too large.";
                $_SESSION['status_code'] = "error";
                exit();
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $_SESSION['status'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $_SESSION['status_code'] = "error";
                exit();
            }

            // Check if file already exists, rename if it does
            if (file_exists($target_file)) {
                $image_name = time() . '_' . $image_name;
                $target_file = $target_dir . $image_name;
            }

            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($image_tmp_name, $target_file)) {
                $image_names[] = $image_name;
            } else {
                $_SESSION['status'] = "Sorry, there was an error uploading your file.";
                $_SESSION['status_code'] = "error";
                exit();
            }
        }
    }

    // Convert the array of image names to a comma-separated string
    $image_names_str = implode(',', $image_names);

    // Prepare and bind
    $stmt = $con->prepare("
        INSERT INTO tbl_marketing_visit 
        (staff_id, date_of_visit, name_of_person, image, purpose, timing_of_departure, timing_of_arrival, travelling_timing, visit_time, contact_info, point_discussion, material_given, response) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if ($stmt === false) {
        die('Prepare failed: ' . $con->error);
    }

    $stmt->bind_param(
        'issssssssssss',
        $staff_id,
        $date_of_visit,
        $name_of_person,
        $image_names_str,
        $purpose,
        $timing_of_departure,
        $timing_of_arrival,
        $travelling_timing,
        $visit_time,
        $contact_info,
        $point_discussion,
        $material_given,
        $response
    );

    // Execute and check for success
    if ($stmt->execute()) {
        $_SESSION['status'] = "Form Data Uploaded Successfully !!!";
        $_SESSION['status_code'] = "success";
         echo "<script>setTimeout(function(){window.location='marketing_visit_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Data is not Submitted, Something Went Wrong !!!";
        $_SESSION['status_code'] = "error";
    }

    // Close statement and connection
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;
        </div>
    </div>
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Marketing Visit Data</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Amrketing Visit Data</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <form action="marketing_visit_add.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="date_of_visit">Date of Visit</label>
                                    <input type="date" class="form-control" id="date_of_visit" name="date_of_visit" required>
                                </div>
                                <div class="form-group">
                                    <label for="name_of_person">Name of Person</label>
                                    <input type="text" class="form-control" id="name_of_person" name="name_of_person" required>
                                </div>
                                <div class="form-group">
                                    <label for="imageUpload">Upload Images</label>
                                    <input type="file" class="form-control-file" id="imageUpload" accept="image/*" name="images[]" multiple>
                                </div>
                                <div class="form-group">
                                    <div id="imagePreviewContainer"></div>
                                </div>
                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <textarea class="form-control" id="purpose" name="purpose" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="timing_of_departure">Timing of Departure</label>
                                    <input type="time" class="form-control" id="timing_of_departure" name="timing_of_departure" required>
                                </div>
                                <div class="form-group">
                                    <label for="timing_of_arrival">Timing of Arrival</label>
                                    <input type="time" class="form-control" id="timing_of_arrival" name="timing_of_arrival" required>
                                </div>
                                <div class="form-group">
                                    <label for="travelling_timing">Travelling Timing</label>
                                    <input type="time" class="form-control" id="travelling_timing" name="travelling_timing" required>
                                </div>
                                <div class="form-group">
                                    <label for="visit_time">Visit Time</label>
                                    <input type="time" class="form-control" id="visit_time" name="visit_time" required>
                                </div>
                                <div class="form-group">
                                    <label for="contact_info">Contact Info</label>
                                    <textarea class="form-control" id="contact_info" name="contact_info" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="point_discussion">Points of Discussion</label>
                                    <textarea class="form-control" id="point_discussion" name="point_discussion" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="material_given">Material Given</label>
                                    <textarea class="form-control" id="material_given" name="material_given" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Response</label><br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="hot" name="response" value="hot" required>
                                        <label class="form-check-label" for="hot">HOT</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="warm" name="response" value="warm" required>
                                        <label class="form-check-label" for="warm">Warm</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="cold" name="response" value="cold" required>
                                        <label class="form-check-label" for="cold">Cold</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </form>
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



    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreviewContainer.innerHTML = '';

            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.display = 'block';
                        img.style.height = '100px';
                        img.style.width = '100px';
                        img.style.margin = '5px';
                        imagePreviewContainer.appendChild(img);
                    }

                    reader.readAsDataURL(file);
                }
            }
        });
    </script>

</body>

</html>