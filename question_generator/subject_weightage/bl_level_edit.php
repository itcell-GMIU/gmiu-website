<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $subjectId = $_GET['id'];
    $subjectId = only_digits($subjectId); // Corrected variable name

    if ($subjectId === false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_weightage.php'},1000)</script>";
    }

$status = 0;
$cmd = $con->prepare("SELECT * FROM tbl_bl_level WHERE subject_code = ? and is_delete = ? ");
$cmd->bind_param("ii", $subjectId, $status);
$cmd->execute();
$result1 = $cmd->get_result();
while ($row1 = $result1->fetch_assoc()) {
    $id = $row1['id'];
    $subjectCode = $row1['subject_code'];
    $remembering = $row1['remembering'];
    $understanding = $row1['understanding'];
    $applying = $row1['applying'];
    $analyzing = $row1['analyzing'];
    $evaluating = $row1['evaluating'];
    $creating = $row1['creating'];
}
}

// Handle the form submission for updating data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect the data from the form
    $remembering = $_POST['remembering'];
    $understanding = $_POST['understanding'];
    $applying = $_POST['applying'];
    $analyzing = $_POST['analyzing'];
    $evaluating = $_POST['evaluating'];
    $creating = $_POST['creating'];
    $subjectCode = $_POST['id'];

    // Validate the inputs before updating
    $totalWeightage = $remembering + $understanding + $applying + $analyzing + $evaluating + $creating;

    if ($totalWeightage != 100) {
        $_SESSION['status'] = "The total BL Level must be exactly 100.";
        $_SESSION['status_code'] = "error";
        header("Location: {$_SERVER['PHP_SELF']}?id={$subjectId}");
        exit();
    }

    // Update the weightage in the database
    $updateQuery = $con->prepare("UPDATE tbl_bl_level SET remembering = ?, understanding = ?, applying = ?, analyzing = ?, evaluating = ?, creating = ? WHERE id = ?");
    $updateQuery->bind_param("iiiiiii", $remembering, $understanding, $applying, $analyzing, $evaluating, $creating, $subjectCode);
    if ($updateQuery->execute()) {
        $_SESSION['status'] = "BL Level  updated successfully!";
        $_SESSION['status_code'] = "success";
        header("Location: view_weightage.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to update bL Level.";
        $_SESSION['status_code'] = "error";
        header("Location: {$_SERVER['PHP_SELF']}?id={$subjectId}");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Header -->
     <?php include '../include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <style>
        .semester-info {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Arial', sans-serif;
}

.semester-info h5 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.semester-info p {
    font-size: 16px;
    color: #555;
    margin: 5px 0;
}

.semester-info p strong {
    color: #007bff;
}

    </style>
    <!-- /.CKeditor custom script -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Subject Weightage</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Subject Weightage</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Subject Weightage</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="" method="POST" enctype="multipart/form-data" id="weightageForm">
                                    <div class="card-body">

                                        <div class="form-group row">
                                           
                                            <input type="hidden" name="id" value="<?php echo $id; ?>" >

                                            <div class="form-group col-md-12">
                                             
                                                <?php 
                                                     $cmd2 = $con->prepare("SELECT sem,subject_code , subject_name from tbl_std_corner_exam where id = $subjectCode and is_delete= 0 ");
                                                    $cmd2->execute();
                                                    $result1 = $cmd2->get_result();
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        echo "<div class='semester-info card p-3 mb-3'>";
                                                        echo "<h5>Semester: {$row1['sem']}</h5>";
                                                        echo "<p><strong>Subject Code:</strong> {$row1['subject_code']}</p>";
                                                        echo "<p><strong>Subject Name:</strong> {$row1['subject_name']}</p>";
                                                        echo "</div>";
                                                     } ?>
                                                </div>  
                                               
                                            

                                            <!-- BL Levels Section -->
                                            <div class="form-group col-md-2">
                                                <label for="remembering">Remembering (R)<span style="color: red;">*</span></label>
                                                <input type="text" id="remembering" name="remembering" class="form-control bl-level" value="<?php echo $remembering ; ?>" placeholder="Enter Weightage" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="understanding">Understanding (U)<span style="color: red;">*</span></label>
                                                <input type="text" id="understanding" name="understanding" class="form-control bl-level" value="<?php echo $understanding ; ?>" placeholder="Enter Weightage" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="applying">Applying (A)<span style="color: red;">*</span></label>
                                                <input type="text" id="applying" name="applying" class="form-control bl-level" value="<?php echo $applying; ?>" placeholder="Enter Weightage" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="analyzing">Analyzing (N)<span style="color: red;">*</span></label>
                                                <input type="text" id="analyzing" name="analyzing" class="form-control bl-level" value="<?php echo $analyzing; ?>" placeholder="Enter Weightage" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="evaluating">Evaluating (E)<span style="color: red;">*</span></label>
                                                <input type="text" id="evaluating" name="evaluating" class="form-control bl-level" value="<?php echo $evaluating; ?>" placeholder="Enter Weightage" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="creating">Creating (C)<span style="color: red;">*</span></label>
                                                <input type="text" id="creating" name="creating" class="form-control bl-level" value="<?php echo $creating; ?>" placeholder="Enter Weightage" required>
                                            </div>
                                            <!-- /.BL Levels Section -->
                                        </div>
                                        
                                        <div class="card-footer">
                                            <input type="submit" name="submit" id="submit-btn" class="btn btn-primary" value="Submit">
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>
        
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include '../include/importjs.php'; ?>
</body>
</html>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    CKEDITOR.replace('text_editor');

    // Add a submit event listener to the form
    document.getElementById('weightageForm').addEventListener('submit', function(event) {
        // Get the values of the BL levels
        let remembering = parseFloat(document.getElementById('remembering').value);
        let understanding = parseFloat(document.getElementById('understanding').value);
        let applying = parseFloat(document.getElementById('applying').value);
        let analyzing = parseFloat(document.getElementById('analyzing').value);
        let evaluating = parseFloat(document.getElementById('evaluating').value);
        let creating = parseFloat(document.getElementById('creating').value);

        // Check if any of the values are not numbers
        if (isNaN(remembering) || isNaN(understanding) || isNaN(applying) || 
            isNaN(analyzing) || isNaN(evaluating) || isNaN(creating)) {
            // SweetAlert for invalid input
            Swal.fire({
                icon: 'error',
                title: 'Invalid Input',
                text: 'Please enter valid numbers for all BL levels.',
            });
            event.preventDefault();
            return false;
        }

        // Calculate the total
        let total = remembering + understanding + applying + analyzing + evaluating + creating;

        // Check if the total is not equal to 100
        if (total !== 100) {
            // SweetAlert for invalid total
            Swal.fire({
                icon: 'error',
                title: 'Invalid Total',
                text: `The total of all BL levels must be exactly 100. Current total: ${total}`,
            });
            event.preventDefault();
            return false;
        }
    });
});

</script>

