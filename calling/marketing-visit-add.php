<?php
include './include/config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $date_of_visit = $_POST['date_of_visit'] ?? '';
    $name_of_person = $_POST['name_of_person'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $timing_of_departure = $_POST['timing_of_departure'] ?? '';
    $timing_of_arrival = $_POST['timing_of_arrival'] ?? '';
    $travelling_timing = $_POST['travelling_timing'] ?? '';
    $visit_time = $_POST['visit_time'] ?? '';
    $contact_info = $_POST['contact_info'] ?? '';
    $point_discussion = $_POST['point_discussion'] ?? '';
    $material_given = $_POST['material_given'] ?? '';
    $response = $_POST['response'] ?? '';

    /* ================= IMAGE UPLOAD LOGIC (UNCHANGED) ================= */
    $image_names = [];
    $target_dir = './uploads/marketing_visit/';

    foreach ($_FILES['images']['name'] as $key => $image_name) {
        if ($image_name != '') {
            $tmp = $_FILES['images']['tmp_name'][$key];
            $target_file = $target_dir . basename($image_name);
            $ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (!getimagesize($tmp)) {
                $_SESSION['status'] = "File is not an image.";
                $_SESSION['status_code'] = "error";
                exit();
            }

            if ($_FILES['images']['size'][$key] > 5000000) {
                $_SESSION['status'] = "File too large.";
                $_SESSION['status_code'] = "error";
                exit();
            }

            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                $_SESSION['status'] = "Invalid image format.";
                $_SESSION['status_code'] = "error";
                exit();
            }

            if (file_exists($target_file)) {
                $image_name = time() . '_' . $image_name;
                $target_file = $target_dir . $image_name;
            }

            if (move_uploaded_file($tmp, $target_file)) {
                $image_names[] = $image_name;
            }
        }
    }

    $image_names_str = implode(',', $image_names);

    $stmt = $con->prepare("
        INSERT INTO tbl_marketing_visit
        (staff_id, date_of_visit, name_of_person, image, purpose,
         timing_of_departure, timing_of_arrival, travelling_timing,
         visit_time, contact_info, point_discussion, material_given, response)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "issssssssssss",
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

    if ($stmt->execute()) {
        $_SESSION['status'] = "Marketing Visit Added Successfully!";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "error";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
</head>

<body>

    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>

    <div class="main-container">
        <div class="pd-ltr-20 height-100-p">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Add Marketing Visit</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Marketing Visit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow">
                    <form method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Date of Visit</label>
                            <input type="date" class="form-control" name="date_of_visit" required>
                        </div>

                        <div class="form-group">
                            <label>Name of Person</label>
                            <input type="text" class="form-control" name="name_of_person" required>
                        </div>

                        <div class="form-group">
                            <label>Upload Images</label>
                            <input type="file" class="form-control" id="imageUpload" name="images[]" multiple>
                        </div>

                        <div id="imagePreviewContainer" class="mb-3"></div>

                        <div class="form-group">
                            <label>Purpose</label>
                            <textarea class="form-control" name="purpose" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Departure Time</label>
                                <input type="time" class="form-control" name="timing_of_departure" required>
                            </div>
                            <div class="col-md-6">
                                <label>Arrival Time</label>
                                <input type="time" class="form-control" name="timing_of_arrival" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Travelling Time</label>
                                <input type="time" class="form-control" name="travelling_timing" required>
                            </div>
                            <div class="col-md-6">
                                <label>Visit Time</label>
                                <input type="time" class="form-control" name="visit_time" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Contact Info</label>
                            <textarea class="form-control" name="contact_info"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Points of Discussion</label>
                            <textarea class="form-control" name="point_discussion"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Material Given</label>
                            <textarea class="form-control" name="material_given"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Response</label><br>
                            <label><input type="radio" name="response" value="hot" required> Hot</label>
                            <label class="ml-3"><input type="radio" name="response" value="warm"> Warm</label>
                            <label class="ml-3"><input type="radio" name="response" value="cold"> Cold</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">
                            Submit Marketing Visit
                        </button>

                    </form>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function (e) {
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = '';
            Array.from(e.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = ev => {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.style.height = '100px';
                    img.style.margin = '5px';
                    container.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>

</body>

</html>