<?php
include './include/config.php';

if (isset($_POST['submit'])) {

    $errors = [];

    /* -------------------------
       1. BASIC VALIDATION
    -------------------------- */
    $title = trim($_POST['title'] ?? '');
    $inputType = $_POST['input_type'] ?? '';

    if ($title === '') {
        $errors[] = 'Document title is required.';
    }

    if (!in_array($inputType, ['file', 'url'])) {
        $errors[] = 'Invalid document type selected.';
    }

    $filePath = '';
    $fileType = '';

    /* -------------------------
       2. URL HANDLING
    -------------------------- */
    if ($inputType === 'url') {

        $fileUrl = trim($_POST['file_url'] ?? '');

        if ($fileUrl === '') {
            $errors[] = 'Document URL is required.';
        } elseif (!filter_var($fileUrl, FILTER_VALIDATE_URL)) {
            $errors[] = 'Invalid URL format.';
        } else {
            $filePath = mysqli_real_escape_string($con, $fileUrl);
            $fileType = 'url';
        }
    }

    /* -------------------------
       3. FILE HANDLING
    -------------------------- */
    if ($inputType === 'file') {

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Please select a valid file to upload.';
        } else {

            $allowedExt = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExt)) {
                $errors[] = 'Invalid file type. Allowed: jpg, jpeg, png, pdf, docx.';
            } else {

                $uploadDir = 'uploads/documents/';

                if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
                    $errors[] = 'Failed to create upload directory.';
                } else {

                    $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['file']['name']);
                    $fileName = time() . '_' . $safeName;
                    $uploadPath = $uploadDir . $fileName;

                    if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
                        $errors[] = 'File upload failed. Please try again.';
                    } else {
                        $filePath = mysqli_real_escape_string($con, $uploadPath);
                        $fileType = in_array($ext, ['jpg', 'jpeg', 'png']) ? 'image' : 'file';
                    }
                }
            }
        }
    }

    /* -------------------------
       4. DATABASE INSERT
    -------------------------- */
    if (empty($errors)) {

        $titleEsc = mysqli_real_escape_string($con, $title);

        $sql = "INSERT INTO tbl_inquiry_documents (title, file, file_type)
                VALUES ('$titleEsc', '$filePath', '$fileType')";

        if (mysqli_query($con, $sql)) {
            $_SESSION['status'] = 'Document added successfully.';
            $_SESSION['status_code'] = 'success';
        } else {
            $_SESSION['status'] = 'Database error: ' . mysqli_error($con);
            $_SESSION['status_code'] = 'error';
        }

    } else {
        $_SESSION['status'] = implode('<br>', $errors);
        $_SESSION['status_code'] = 'error';
    }
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
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">

                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Add Documents</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Add Documents</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                    <form method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Document Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload Type <span class="text-danger">*</span></label>
                                    <select name="input_type" class="form-control" id="inputType" required>
                                        <option value="">Select Type</option>
                                        <option value="file">Image / File</option>
                                        <option value="url">URL</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 d-none" id="fileBox">
                                <div class="form-group">
                                    <label>Select File</label>
                                    <input type="file" name="file" class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf,.docx">
                                    <small class="text-muted">
                                        Allowed: jpg, jpeg, png, pdf, docx
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6 d-none" id="urlBox">
                                <div class="form-group">
                                    <label>Document URL</label>
                                    <input type="url" name="file_url" class="form-control"
                                        placeholder="https://example.com">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    Save Document
                                </button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        document.getElementById('inputType').addEventListener('change', function () {
            document.getElementById('fileBox').classList.toggle('d-none', this.value !== 'file');
            document.getElementById('urlBox').classList.toggle('d-none', this.value !== 'url');
        });
    </script>

</body>

</html>