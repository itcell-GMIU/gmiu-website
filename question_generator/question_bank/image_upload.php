<?php
include '../include/checklogin.php';

$resultHTML = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
    $targetDir = __DIR__ . "/uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $uploadedTags = "";
    $previewHTML = "";

    foreach ($_FILES['images']['name'] as $key => $i_name) {
        if ($_FILES['images']['error'][$key] === 0) {
            // Clean file name - remove spaces and replace with _
            $cleanName = preg_replace("/[^A-Za-z0-9\.\-_]/", "_", $i_name);
            // Add prefix in format 2025-08-01-57
            $datePrefix = date("Y-m-d-H-i-s");
            // Final file name
            $fileName = $datePrefix . "-" . $cleanName;
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $targetFile)) {
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
                $host = $_SERVER['HTTP_HOST'];
                $scriptPath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

                $url = $protocol . $host . $scriptPath . "/uploads/" . $fileName;

                // ✅ Insert into Database
                $stmt = $con->prepare("INSERT INTO tbl_question_images (file_name, file_url, uploaded_at) VALUES (?, ?, NOW())");
                $stmt->bind_param("ss", $fileName, $url);
                $stmt->execute();
                $stmt->close();

                $uploadedTags .= "<img>$fileName</img>\n";

                $previewHTML .= "
                    <div style='border:1px solid #ccc;padding:10px;margin:5px;display:inline-block;text-align:center;'>
                        <img src='$url' style='max-width:150px;height:auto;display:block;margin-bottom:5px;border:1px solid #ddd;'>
                        <input type='text' value='$url' class='form-control' readonly>
                    </div>
                ";
            }
        }
    }

    if ($uploadedTags !== "") {
        $resultHTML = "
            <div class='alert alert-success mt-3'>
                <h4>✅ Images Uploaded & Saved in Database!</h4>
                <p><strong>📋 Copy & Paste these tags into CSV:</strong></p>
                <textarea id='copyText' class='form-control' style='height:120px;font-weight:bold;'>$uploadedTags</textarea>
                <button class='btn btn-secondary btn-sm mt-2' onclick='copyToClipboard()'>📋 Copy to Clipboard</button>

                <hr>
                <h5>🖼️ Uploaded Images & URLs:</h5>
                <div>$previewHTML</div>
            </div>
        ";
    } else {
        $resultHTML = "<div class='alert alert-danger mt-3'>❌ Upload Failed.</div>";
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
                            <h1 class="m-0">Upload Images for Question Bank</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Upload Images</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-gmiu">
                        <div class="card-header">
                            <h3 class="card-title">Upload Multiple Images</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Select Images (You can select multiple):</label>
                                    <input type="file" name="images[]" multiple class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>

                            <!-- ✅ Show Upload Result -->
                            <?= $resultHTML ?>
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
    function copyToClipboard() {
        var copyText = document.getElementById("copyText");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("✅ Tags copied to clipboard!");
    }
    </script>

</body>

</html>