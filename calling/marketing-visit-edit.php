<?php
include './include/config.php';

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

    /* ===== Fetch old images ===== */
    $stmt = $con->prepare("SELECT image FROM tbl_marketing_visit WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $oldData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $images = explode(',', $oldData['image']);

    /* ===== Upload new images if provided ===== */
    if (!empty($_FILES['images']['name'][0])) {

        $target_dir = './uploads/marketing_visit/';
        $uploaded_images = [];

        foreach ($_FILES['images']['name'] as $key => $image_name) {

            $tmp = $_FILES['images']['tmp_name'][$key];
            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            if (!getimagesize($tmp)) {
                $_SESSION['status'] = "Invalid image file";
                $_SESSION['status_code'] = "error";
                exit();
            }

            if ($_FILES['images']['size'][$key] > 5000000) {
                $_SESSION['status'] = "Image too large";
                $_SESSION['status_code'] = "error";
                exit();
            }

            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                $_SESSION['status'] = "Invalid image format";
                $_SESSION['status_code'] = "error";
                exit();
            }

            $newName = time() . '_' . $image_name;
            move_uploaded_file($tmp, $target_dir . $newName);
            $uploaded_images[] = $newName;
        }

        /* Remove old images */
        foreach ($images as $img) {
            if ($img && file_exists($target_dir . $img)) {
                unlink($target_dir . $img);
            }
        }

        $images = $uploaded_images;
    }

    $images_str = implode(',', $images);

    /* ===== Update Record ===== */
    $stmt = $con->prepare("
        UPDATE tbl_marketing_visit SET
        date_of_visit=?, name_of_person=?, image=?, purpose=?,
        timing_of_departure=?, timing_of_arrival=?, travelling_timing=?,
        visit_time=?, contact_info=?, point_discussion=?,
        material_given=?, response=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "ssssssssssssi",
        $date_of_visit,
        $name_of_person,
        $images_str,
        $purpose,
        $timing_of_departure,
        $timing_of_arrival,
        $travelling_timing,
        $visit_time,
        $contact_info,
        $point_discussion,
        $material_given,
        $response,
        $id
    );

    if ($stmt->execute()) {
        $_SESSION['status'] = "Record updated successfully!";
        $_SESSION['status_code'] = "success";
    }

    $stmt->close();
}
?>

<?php
$id = intval($_GET['id'] ?? 0);

$stmt = $con->prepare("SELECT * FROM tbl_marketing_visit WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();
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

            <div class="page-header">
                <h4>Edit Marketing Visit</h4>
            </div>

            <div class="pd-20 bg-white border-radius-4 box-shadow">
                <form method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?= $id ?>">

                    <div class="form-group">
                        <label>Date of Visit</label>
                        <input type="date" class="form-control" name="date_of_visit"
                            value="<?= htmlspecialchars($data['date_of_visit']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Name of Person</label>
                        <input type="text" class="form-control" name="name_of_person"
                            value="<?= htmlspecialchars($data['name_of_person']) ?>" required>
                    </div>

                    <div class="row">
                        <?php foreach (explode(',', $data['image']) as $img): ?>
                            <div class="col-md-3 mb-2">
                                <img src="./uploads/marketing_visit/<?= htmlspecialchars($img) ?>" class="img-fluid">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-group">
                        <label>Upload New Images</label>
                        <input type="file" class="form-control" id="imageUpload" name="images[]" multiple>
                    </div>

                    <div id="imagePreviewContainer" class="mb-3"></div>

                    <div class="form-group">
                        <label>Purpose</label>
                        <textarea class="form-control" name="purpose"
                            required><?= htmlspecialchars($data['purpose']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Departure Time</label>
                            <input type="time" class="form-control" name="timing_of_departure"
                                value="<?= $data['timing_of_departure'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Arrival Time</label>
                            <input type="time" class="form-control" name="timing_of_arrival"
                                value="<?= $data['timing_of_arrival'] ?>" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Travelling Time</label>
                            <input type="time" class="form-control" name="travelling_timing"
                                value="<?= $data['travelling_timing'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Visit Time</label>
                            <input type="time" class="form-control" name="visit_time" value="<?= $data['visit_time'] ?>"
                                required>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Contact Info</label>
                        <textarea class="form-control"
                            name="contact_info"><?= htmlspecialchars($data['contact_info']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Points of Discussion</label>
                        <textarea class="form-control"
                            name="point_discussion"><?= htmlspecialchars($data['point_discussion']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Material Given</label>
                        <textarea class="form-control"
                            name="material_given"><?= htmlspecialchars($data['material_given']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Response</label><br>
                        <label><input type="radio" name="response" value="hot" <?= $data['response'] == 'hot' ? 'checked' : '' ?>> Hot</label>
                        <label class="ml-3"><input type="radio" name="response" value="warm"
                                <?= $data['response'] == 'warm' ? 'checked' : '' ?>> Warm</label>
                        <label class="ml-3"><input type="radio" name="response" value="cold"
                                <?= $data['response'] == 'cold' ? 'checked' : '' ?>> Cold</label>
                    </div>

                    <button class="btn btn-primary">Update</button>
                </form>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function (e) {
            const box = document.getElementById('imagePreviewContainer');
            box.innerHTML = '';
            Array.from(e.target.files).forEach(file => {
                const r = new FileReader();
                r.onload = ev => {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.style.height = '80px';
                    img.style.margin = '5px';
                    box.appendChild(img);
                };
                r.readAsDataURL(file);
            });
        });
    </script>

</body>

</html>