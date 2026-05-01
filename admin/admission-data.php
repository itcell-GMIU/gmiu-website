<?php
include 'include/checklogin.php';

if (isset($_POST['submit'])) {
    $admission_year = mysqli_real_escape_string($con, $_POST['admission_year']);
    $created_by = $staff_id; // from session

    if (!empty($_POST['program_id'])) {
        $selectedPrograms = $_POST['program_id']; // array of ids
        $successCount = 0;
        $errorCount = 0;

        foreach ($selectedPrograms as $program_id) {
            $program_id = intval($program_id);

            // Check duplicate entry
            $check_stmt = $con->prepare("SELECT id FROM tbl_biannual_programs WHERE program_id=? AND admission_year=?");
            $check_stmt->bind_param("is", $program_id, $admission_year);
            $check_stmt->execute();
            $res = $check_stmt->get_result();

            if ($res->num_rows == 0) {
                $stmt = $con->prepare("INSERT INTO tbl_biannual_programs (program_id, admission_year) VALUES (?, ?)");
                $stmt->bind_param("is", $program_id, $admission_year);

                if ($stmt->execute()) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            } else {
                $errorCount++;
            }
        }

        if ($successCount > 0) {
            $_SESSION['status'] = "$successCount Program(s) added successfully for Biannual admission";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "No new programs added (all duplicates or failed)";
            $_SESSION['status_code'] = "error";
        }

        echo "<script>setTimeout(function(){window.location='admission-data.php'},1000)</script>";
    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'include/importnav.php'; ?>
        <?php include 'include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Referral</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Referral</li>
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
                                <div class="card-header">
                                    <h3 class="card-title">Add Referral</h3>
                                </div>
                                <form method="POST">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select Programs<span style="color:red;">*</span></label>
                                            <select name="program_id[]" id="program_id" class="form-control" multiple
                                                required>
                                                <?php
                                                $programs = $con->query("
            SELECT p.id, p.name as program_name, l.name as level_name
            FROM tbl_program p
            LEFT JOIN tbl_level l ON p.level_id = l.id
            WHERE p.is_active = 1
        ");
                                                while ($row = $programs->fetch_assoc()) {
                                                    echo "<option value='{$row['id']}'>{$row['program_name']} ({$row['level_name']})</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <label>Admission Year<span style="color:red;">*</span></label>
                                            <select name="admission_year" class="form-control" required>
                                                <option value="2026-27_jan">2026-27 (BIANNUAL)</option>
                                                <!-- You can add more years if needed -->
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" name="submit" class="btn btn-primary">Add
                                                Program</button>
                                        </div>
                                    </div>
                                </form>


                            </div> <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include 'include/importfooter.php'; ?>
    <?php include 'include/importjs.php'; ?>
    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#program_id').select2({
            placeholder: "Select Programs",
            allowClear: true
        });
    });
    </script>

</body>

</html>