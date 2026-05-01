<?php
include '../include/checklogin.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $date_of_visit = $_POST['date_of_visit'];
    $name_of_person = $_POST['name_of_person'];
    $purpose = $_POST['purpose'];
    $timing_of_departure = $_POST['timing_of_departure'];
    $timing_of_arrival = $_POST['timing_of_arrival'];
    $travelling_timing = $_POST['travelling_timing'];
    $visit_time = $_POST['visit_time'];
    $contact_info = $_POST['contact_info'];
    $point_discussion = $_POST['point_discussion'];
    $material_given = $_POST['material_given'];
    $response = $_POST['response'];

    // Fetch the existing data to get the current images paths
    $sql = 'SELECT image FROM tbl_marketing_visit WHERE id = ?';
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    // Set default images to the existing ones
    $images = explode(',', $data['image']);

    // Image upload handling
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $target_dir = '../uploads/marketing_visit/';
        $uploaded_images = [];

        foreach ($_FILES['images']['name'] as $key => $image_name) {
            $target_file = $target_dir . basename($image_name);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($_FILES['images']['tmp_name'][$key]);
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
                $image_name = time() . '_' . basename($image_name);
                $target_file = $target_dir . $image_name;
            }

            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
                $uploaded_images[] = $image_name;
            } else {
                $_SESSION['status'] = "Sorry, there was an error uploading your file.";
                $_SESSION['status_code'] = "error";
                exit();
            }
        }

        // Unlink the old image files if they exist
        foreach ($images as $old_image) {
            if (!empty($old_image) && file_exists($target_dir . $old_image)) {
                unlink($target_dir . $old_image);
            }
        }

        // Update the images array with the new uploaded images
        $images = $uploaded_images;
    }

    // Convert images array to a comma-separated string
    $images_str = implode(',', $images);

    // Prepare the SQL update query
    $sql = 'UPDATE tbl_marketing_visit SET date_of_visit = ?, name_of_person = ?, image = ?, purpose = ?, timing_of_departure = ?, timing_of_arrival = ?, travelling_timing = ?, visit_time = ?, contact_info = ?, point_discussion = ?, material_given = ?, response = ? WHERE id = ?';
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        echo 'Prepare failed: (' . $con->errno . ') ' . $con->error;
        exit();
    }

    $stmt->bind_param('ssssssssssssi', $date_of_visit, $name_of_person, $images_str, $purpose, $timing_of_departure, $timing_of_arrival, $travelling_timing, $visit_time, $contact_info, $point_discussion, $material_given, $response, $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Record updated successfully!";
        $_SESSION['status_code'] = "success";
        header('Location: marketing_visit_view.php');
        exit();
    } else {
        $_SESSION['status'] = "Error updating record: " . $stmt->error;
        $_SESSION['status_code'] = "error";
    }
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
        <div id="status">&nbsp;</div>
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
                                <li class="breadcrumb-item active">Add Marketing Visit Data</li>
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
                            <?php
                            // Fetch the ID from the GET request
                            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                            // Fetch the data for the given ID
                            if ($id) {
                                $sql = 'SELECT * FROM tbl_marketing_visit WHERE id = ?';
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param('i', $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $data = $result->fetch_assoc();
                                $stmt->close();
                            }
                            ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                                <div class="form-group">
                                    <label for="date_of_visit">Date of Visit</label>
                                    <input type="date" class="form-control" id="date_of_visit" name="date_of_visit" value="<?php echo htmlspecialchars($data['date_of_visit']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="name_of_person">Name of Person</label>
                                    <input type="text" class="form-control" id="name_of_person" name="name_of_person" value="<?php echo htmlspecialchars($data['name_of_person']); ?>" required>
                                </div>
                                <!-- Display the current image if it exists -->
                                <?php
                                if (!empty($data['image'])) {
                                    $images = explode(',', $data['image']); // Split the string into an array
                                    foreach ($images as $index => $image) { // Loop through each image
                                ?>
                                        <div class="col-md-4 mb-3"> <!-- Each image takes one-third of the row -->
                                            <img src="../uploads/marketing_visit/<?php echo htmlspecialchars($image); ?>" alt="Image" style="max-width: 50%; height: auto;">
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "No image uploaded";
                                }
                                ?>

                                <!-- Image upload field -->
                                <div class="form-group">
                                    <label for="image">Upload New Images</label>
                                    <input type="file" class="form-control" id="imageUpload" name="images[]" multiple>
                                </div>

                                <div class="form-group">
                                    <div id="imagePreviewContainer"></div>
                                </div>

                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <textarea class="form-control" id="purpose" name="purpose" rows="3" required><?php echo htmlspecialchars($data['purpose']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="timing_of_departure">Timing of Departure</label>
                                    <input type="time" class="form-control" id="timing_of_departure" name="timing_of_departure" value="<?php echo htmlspecialchars($data['timing_of_departure']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="timing_of_arrival">Timing of Arrival</label>
                                    <input type="time" class="form-control" id="timing_of_arrival" name="timing_of_arrival" value="<?php echo htmlspecialchars($data['timing_of_arrival']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="travelling_timing">Travelling Timing</label>
                                    <input type="time" class="form-control" id="travelling_timing" name="travelling_timing" value="<?php echo htmlspecialchars($data['travelling_timing']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="visit_time">Visit Time</label>
                                    <input type="time" class="form-control" id="visit_time" name="visit_time" value="<?php echo htmlspecialchars($data['visit_time']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="contact_info">Contact Info</label>
                                    <textarea class="form-control" id="contact_info" name="contact_info" rows="3"><?php echo htmlspecialchars($data['contact_info']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="point_discussion">Points of Discussion</label>
                                    <textarea class="form-control" id="point_discussion" name="point_discussion" rows="3"><?php echo htmlspecialchars($data['point_discussion']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="material_given">Material Given</label>
                                    <textarea class="form-control" id="material_given" name="material_given" rows="3"><?php echo htmlspecialchars($data['material_given']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Response</label><br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="hot" name="response" value="hot" <?php echo $data['response'] == 'hot' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="hot">HOT</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="warm" name="response" value="warm" <?php echo $data['response'] == 'warm' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="warm">Warm</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="cold" name="response" value="cold" <?php echo $data['response'] == 'cold' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="cold">Cold</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
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