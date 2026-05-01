<?php
// Include the checklogin.php file
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
            $fees = [];

            for ($i = 1; $i <= 8; $i++) {
                $fees[] = ($getData[$i] === '-' || $getData[$i] === '') ? null : $getData[$i];
            }

            $updateQuery = $con->prepare("UPDATE tbl_program SET sem1=?, sem2=?, sem3=?, sem4=?, sem5=?, sem6=?, sem7=?, sem8=? WHERE id=?");
            $updateQuery->bind_param(
                "iiiiiiiii",
                $fees[0],
                $fees[1],
                $fees[2],
                $fees[3],
                $fees[4],
                $fees[5],
                $fees[6],
                $fees[7],
                $id
            );
            $updateQuery->execute();
        }

        fclose($file);
        $_SESSION['status'] = "Program Fees Imported Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='add_sem_fee.php'},2000)</script>";
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
                            <h1 class="m-0">Import Program Fees CSV</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Program Fees CSV</li>
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
                                            <h3 class="card-title h-100 mt-1">Import Fees</h3>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <a class="btn btn-dark p-1" href="demo_program_fee.csv" download="demo_program_fee.csv"><i class="fa fa-download"></i> Download Sample CSV</a>
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
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <?php include '../include/importjs.php'; ?>
</body>

</html>