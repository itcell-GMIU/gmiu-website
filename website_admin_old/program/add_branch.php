<?php
// Include the checklogin.php file
include '../include/checklogin.php';
if (isset($_POST["import"])) {
    $filename = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {     
        $file = fopen($filename, "r");
        // Flag to skip the first row
        $skipFirstRow = true;
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Skip the first row
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }
            
            $id = $getData[0]; // Assuming ID is in the first column
            $branch_code = $getData[1]; // Assuming branch_code is in the second column
            
            // Update branch_code where ID matches
            $updateQuery = $con->prepare("UPDATE tbl_program SET branch_code = ? WHERE id = ?");
            $updateQuery->bind_param("si", $branch_code, $id);
            $updateQuery->execute();
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
                                            <h3 class="card-title h-100 mt-1">Update Branch Code</h3>
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
