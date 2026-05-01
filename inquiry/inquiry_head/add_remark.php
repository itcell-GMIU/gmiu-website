<?php
include '../include/checklogin.php';

// Sanitize and validate GET inputs
$taskDate = isset($_GET['task_date']) ? $_GET['task_date'] : '';
$staffId = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';

// Validate staffId and taskDate (if needed)
if (!empty($taskDate) && !empty($staffId) && is_numeric($staffId)) {
    // Fetch existing remarks for the staff member and task date
    $remarksQuery = $con->prepare("SELECT 
            tdt.*, 
            ts.name as staff_name 
        FROM 
            tbl_daily_task tdt
        JOIN 
            tbl_staff ts ON tdt.staff_id = ts.id
        WHERE 
            tdt.staff_id = ? 
            AND tdt.task_date = ? 
            AND tdt.is_active = 1 
            AND tdt.is_delete = 0");
    $remarksQuery->bind_param("is", $staffId, $taskDate);
    $remarksQuery->execute();
    $remarksResult = $remarksQuery->get_result();
    $taskIds = [];
} else {
    // Handle invalid or missing GET parameters
    echo "Invalid parameters.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize POST inputs
    $dailyTaskId = isset($_POST['task_ids']) ? $_POST['task_ids'] : '';
    $reviewRating = isset($_POST['review_rating']) ? filter_var($_POST['review_rating'], FILTER_SANITIZE_STRING) : '';

    // Validate POST inputs
    if (!empty($dailyTaskId) && !empty($reviewRating)) {
        // Insert the remark into the database
        $stmt = $con->prepare("INSERT INTO tbl_daily_review 
            (`reviewer_staff_id`, `dailytask_id`, `comments`, task_date, staff_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $staff_id, $dailyTaskId, $reviewRating, $taskDate, $staffId);
        $result = $stmt->execute();

        if ($result) {
            // Sweet Alert of Success Message
            $_SESSION['status'] = "Remark Added Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='dailytask_report.php'},1000);</script>";
        } else {
            // Sweet Alert of Error Message
            $_SESSION['status'] = "Remark Addition Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
        }
    } else {
        // Handle missing or invalid POST parameters
        echo "Invalid POST data.";
        exit;
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
    <!-- /.CKeditor custom script -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div><!-- /.Preloader -->

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
                            <h1 class="m-0">Add Remark Of Daily Task </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Remark Of Daily Task</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
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
                                    <h3 class="card-title">Add Remark Of Daily Task</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" name="daily_task" action="" method="POST">
                                    <div class="card-body">

                                        <div class="row">                                          

                                            <!-- Display existing remarks in a table -->
                                            <div class="form-group col-sm-12">
                                                <h5>Existing Remarks</h5>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Task ID</th>
                                                            <th>Staff Name</th>                                                           
                                                            <th>Task Date</th>
                                                            <th>Time Slot</th>
                                                            <th>Task Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row = $remarksResult->fetch_assoc()) : ?>
                                                            <tr>  
                                                               <?php  $taskIds[] = $row['id'];   ?>

                                                               <td><?php echo $row['id']; ?> </td>
                                                                <td><?php echo $row['staff_name']; ?></td>
                                                                <td><?php echo $row['task_date']; ?></td>
                                                                <td><?php echo $row['time_slot']; ?></td>
                                                                <td><?php echo $row['task_description']; ?></td>
                                                              
                                                               
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <!-- Hidden input field to pass task IDs -->
                                             <input type="hidden" name="task_ids" value="<?php echo implode(',', $taskIds); ?>">
                                            
                                            <!-- Radio buttons for task review -->
                                            <div class="form-group col-sm-12">
                                              <label>Task Review Rating<span style="color: red;">*</span></label><br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="review_rating" value="excellent" required> Excellent
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="review_rating" value="very good"> Very Good
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="review_rating" value="good"> Good
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="review_rating" value="average"> Average
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="review_rating" value="need to improve"> Need to Improve
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-right">
                                        <button type="submit" name="submit_std" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../include/importfooter.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>
</body>

</html>
