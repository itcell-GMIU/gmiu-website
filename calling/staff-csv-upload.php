<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

include './include/config.php';

// Handle the CSV import logic when the form is submitted
if (isset($_POST["import"])) {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $filename = $_FILES["file"]["tmp_name"];

        // Check if the file is not empty
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");

            // Skip the first row (header)
            fgetcsv($file, 10000, ",");

            // Loop through the remaining rows
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                // Check if row contains the expected number of columns
                if (count($getData) == 5) {
                    $name = $getData[0];
                    $mobile_number = $getData[1];
                    $email = $getData[2];
                    $role = $getData[3];
                    $password = $getData[4];
                    $allowedRoleIds = [12, 13, 14, 15, 16, 21, 22, 25, 57, 59];

                    if (!in_array($role, $allowedRoleIds, true)) {
                        $_SESSION['status'] = "Invalid role selected!";
                        $_SESSION['status_code'] = "warning";
                        // exit;
                    }

                    // Check if a staff member with this email already exists
                    $checkQuery = $con->prepare("SELECT id FROM tbl_staff WHERE email = ? AND role_id = ? AND is_active = 1 AND is_delete = 0");
                    $checkQuery->bind_param("si", $email, $role);
                    $checkQuery->execute();
                    $result = $checkQuery->get_result();

                    if ($result->num_rows > 0) {
                        // Email exists, update the existing record's password and role
                        $updateQuery = $con->prepare("UPDATE tbl_staff SET password = ?, role_id = ? WHERE email = ? AND role_id = ? AND is_active = 1 AND is_delete = 0");
                        $updateQuery->bind_param("sisi", $password, $role, $email ,$role);
                        $updateQuery->execute();
                    } else {
                        // Email does not exist, insert a new record
                        $stmt = $con->prepare("INSERT INTO `tbl_staff`(role_id, name, email, mobile_number, password) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("issss", $role, $name, $email, $mobile_number, $password);
                        $stmt->execute();
                    }
                }
            }
            fclose($file);
            $_SESSION['status'] = "CSV file has been imported successfully.";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "The uploaded file is empty.";
            $_SESSION['status_code'] = "warning";
        }
    } else {
        $_SESSION['status'] = "Invalid file upload. Please try again.";
        $_SESSION['status_code'] = "error";
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
                                <h4>Import Staff CSV</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Import Staff</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <a class="btn btn-dark" href="demo_staff_csv.csv" download="demo_staff_csv.csv">
                                <i class="fa fa-download"></i> Download Sample CSV
                            </a>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="alert alert-info mt-3">
                        <strong>CSV Role Instructions:</strong><br>
                        In your CSV file, the <b>role</b> column must contain the correct <b>role_id</b> number from the list below:
                    
                        <ul style="margin-top:10px;">
                           
                            <li><b>12</b> = Inquiry Admin</li>
                            <li><b>13</b> = Reception</li>
                            <li><b>14</b> = Inquiry Head</li>
                            <li><b>15</b> = Inquiry Faculty</li>
                            <li><b>16</b> = Counselor / Admission Officer</li>
                            <li><b>21</b> = Marketting Visit</li>
                            <li><b>22</b> = Promotional Coordinator</li>
                            <li><b>25</b> = Designer</li>
                            <li><b>57</b> = Lead Manager</li>
                            <li><b>59</b> = Survilence Staff</li>
                        </ul>
                    
                        
                    </div>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="file">Upload CSV File <span style="color: red;">*</span></label>
                            <input type="file" name="file" class="form-control-file form-control-lg" id="file"
                                accept=".csv" required>
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" name="import" value="Import" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>
</body>

</html>