<?php
include '../include/checklogin.php';

if (isset($_POST["import"])) {
    $filename = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        $skipFirstRow = true;

        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }

            $id = $getData[0];
            $meta_description_csv = trim($getData[1]);
            $meta_keywords_csv = trim($getData[2]);
            $page_title_csv = trim($getData[3]);

            // First, fetch current record from database
            $selectQuery = $con->prepare("SELECT meta_description, meta_keywords, pageTitle FROM tbl_program WHERE id = ?");
            $selectQuery->bind_param("i", $id);
            $selectQuery->execute();
            $result = $selectQuery->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Logic: only update if value is blank or N/A
                $meta_description = $row['meta_description'];
                if ($meta_description == "" || strtolower($meta_description) == "n/a") {
                    $meta_description = $meta_description_csv; // allow update
                }

                $meta_keywords = $row['meta_keywords'];
                if ($meta_keywords == "" || strtolower($meta_keywords) == "n/a") {
                    $meta_keywords = $meta_keywords_csv; // allow update
                }

                $page_title = $row['pageTitle'];
                if ($page_title == "" || strtolower($page_title) == "n/a") {
                    $page_title = $page_title_csv; // allow update
                }

                // Only run UPDATE if any field needs update
                if (
                    $meta_description != $row['meta_description'] ||
                    $meta_keywords != $row['meta_keywords'] ||
                    $page_title != $row['pageTitle']
                ) {
                    $updateQuery = $con->prepare("UPDATE tbl_program SET meta_description = ?, meta_keywords = ?, pageTitle = ? WHERE id = ?");
                    $updateQuery->bind_param("sssi", $meta_description, $meta_keywords, $page_title, $id);
                    $updateQuery->execute();
                }
            }
        }
        fclose($file);
        $_SESSION['status'] = "Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='upload_csv.php'},2000)</script>";
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
                            <h1 class="m-0">Import Program CSV</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Program CSV</li>
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
                                <div class="card-header h-100">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title h-100 mt-1">Update SEO Description</h3>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <a class="btn btn-dark p-1" href="demo_program_csv.csv" download="demo_program_csv.csv"><i class="fa fa-download"></i> Download Sample CSV</a>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="file">Upload CSV<span style="color: red;">*</span></label>
                                            <input type="file" name="file" class="form-control h-100" id="file" accept=".csv" required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <input type="submit" name="import" value="Import" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
    </div>
    <?php include '../include/importjs.php'; ?>
</body>

</html>