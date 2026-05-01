<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Get program_id from the URL
if (isset($_GET['program_id'])) {
    $program_id = $_GET['program_id'];

    // Fetch program details
    $query = "SELECT * FROM tbl_program WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $program = $result->fetch_assoc();

    if (!$program) {
        die("Program not found!");
    }
} else {
    die("Invalid request!");
}

// Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Collect semester-wise fees from POST
    $sem_fees = [];
    for ($i = 1; $i <= 8; $i++) {
        $sem_fees[$i] = $_POST['sem' . $i];
    }

    // Update query for sem1 to sem8
    $update_query = "
        UPDATE tbl_program 
        SET 
            sem1 = ?, sem2 = ?, sem3 = ?, sem4 = ?, 
            sem5 = ?, sem6 = ?, sem7 = ?, sem8 = ? 
        WHERE id = ?";

    $update_stmt = $con->prepare($update_query);

    // Make sure $program_id is defined
    $update_stmt->bind_param(
        "ssssssssi",
        $sem_fees[1],
        $sem_fees[2],
        $sem_fees[3],
        $sem_fees[4],
        $sem_fees[5],
        $sem_fees[6],
        $sem_fees[7],
        $sem_fees[8],
        $program_id
    );

    $update_stmt->execute();

    // Redirect to view page
    header("Location: view_fee.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1>Edit Program</h1>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <form method="POST">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Program Name</label>
                                    <input type="text" name="program_name" class="form-control"
                                        value="<?php echo $program['name']; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Faculty</label>
                                    <select name="faculty_id" class="form-control" disabled>
                                        <option value="">Select Faculty</option>
                                        <?php
                                        $faculties = $con->query("SELECT * FROM tbl_faculty");
                                        while ($faculty = $faculties->fetch_assoc()) {
                                            $selected = ($faculty['id'] == $program['faculty_id']) ? 'selected' : '';
                                            echo "<option value='" . $faculty['id'] . "' $selected>" . $faculty['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level_id" class="form-control" disabled>
                                        <option value="">Select Level</option>
                                        <?php
                                        $levels = $con->query("SELECT * FROM tbl_level");
                                        while ($level = $levels->fetch_assoc()) {
                                            $selected = ($level['id'] == $program['level_id']) ? 'selected' : '';
                                            echo "<option value='" . $level['id'] . "' $selected>" . $level['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Token</label>
                                    <input type="text" name="program_token" class="form-control" disabled
                                        value="<?php echo $program['token']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Semester-wise Fees</label>

                                    <div class="row">
                                        <?php
                                        // First row: Sem 1, 3, 5, 7
                                        foreach ([1, 3, 5, 7] as $i): ?>
                                            <div class="col-md-3">
                                                <label>Sem <?php echo $i; ?> Fee</label>
                                                <input type="text" name="sem<?php echo $i; ?>" class="form-control"
                                                    value="<?php echo isset($program['sem' . $i]) ? $program['sem' . $i] : ''; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="row mt-3">
                                        <?php
                                        // Second row: Sem 2, 4, 6, 8
                                        foreach ([2, 4, 6, 8] as $i): ?>
                                            <div class="col-md-3">
                                                <label>Sem <?php echo $i; ?> Fee</label>
                                                <input type="text" name="sem<?php echo $i; ?>" class="form-control"
                                                    value="<?php echo isset($program['sem' . $i]) ? $program['sem' . $i] : ''; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label>Status</label>
                                    <input disabled type="checkbox" name="program_is_active" <?php echo ($program['is_active'] == 1) ? 'checked' : ''; ?>> Active
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="program_view.php" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
    </div>
    <?php include '../include/importjs.php'; ?>
</body>

</html>