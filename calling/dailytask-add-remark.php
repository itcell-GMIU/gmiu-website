<?php
include './include/config.php'; // Assuming this handles session_start() and db connection ($con)

// --- START: Merged Logic ---

// Variable to hold any error or status messages
$page_message = '';
$remarksResult = null;
$taskIds = [];
$staffName = '';

// Sanitize and validate GET inputs
$taskDate = isset($_GET['task_date']) ? $_GET['task_date'] : '';
$staffId = isset($_GET['staff_id']) ? filter_var($_GET['staff_id'], FILTER_VALIDATE_INT) : false;
// Assumes the logged-in user's ID is stored in the session
$reviewerStaffId = isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : 0;


// Proceed only if we have valid parameters
if ($taskDate && $staffId) {
    // Fetch the tasks for the specified staff and date to display them
    $remarksQuery = $con->prepare("SELECT 
            tdt.id, tdt.task_date, tdt.time_slot, tdt.task_description, 
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

    if ($remarksResult->num_rows === 0) {
        $page_message = "No tasks found for this staff member on the selected date. There is nothing to review.";
    }
} else {
    // Handle invalid or missing GET parameters by setting an error message
    $page_message = "Invalid or missing page parameters. Please return to the report and try again.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize POST inputs
    $dailyTaskIds = isset($_POST['task_ids']) ? htmlspecialchars($_POST['task_ids']) : '';
    $reviewRating = isset($_POST['review_rating']) ? htmlspecialchars($_POST['review_rating']) : '';

    // Hidden inputs from the form to pass along the original context
    $postTaskDate = isset($_POST['task_date']) ? $_POST['task_date'] : '';
    $postStaffId = isset($_POST['staff_id']) ? filter_var($_POST['staff_id'], FILTER_VALIDATE_INT) : false;

    // Validate POST inputs
    if ($dailyTaskIds && $reviewRating && $postTaskDate && $postStaffId && $reviewerStaffId) {
        // Insert the remark into the database
        $stmt = $con->prepare("INSERT INTO tbl_daily_review 
            (reviewer_staff_id, dailytask_id, comments, task_date, staff_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $reviewerStaffId, $dailyTaskIds, $reviewRating, $postTaskDate, $postStaffId);

        if ($stmt->execute()) {
            $_SESSION['status'] = "Remark Added Successfully";
            $_SESSION['status_code'] = "success";
            // Redirect to the report page to see the result
            header("Location: dailytask-report.php");
            exit();
        } else {
            $_SESSION['status'] = "Error: Remark Addition Failed";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "Error: Invalid data submitted. Please try again.";
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
                                <h4>Add Daily Task Remark</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="daily-task-report.php">Daily Task Report</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Remark</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <?php if ($page_message): ?>
                        <div class="alert alert-warning" role="alert">
                            <?php echo $page_message; ?>
                        </div>
                    <?php else: ?>
                        <div class="form-container">
                            <h5 class="mb-20 h5">Reviewing Tasks for Date: <?php echo htmlspecialchars($taskDate); ?></h5>

                            <!-- Display existing tasks in a table for context -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Staff Name</th>
                                            <th>Task Date</th>
                                            <th>Time Slot</th>
                                            <th>Task Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $remarksResult->fetch_assoc()): ?>
                                            <?php
                                            $taskIds[] = $row['id'];
                                            $staffName = $row['staff_name']; // Capture staff name for the title
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['staff_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['task_date']); ?></td>
                                                <td><?php echo htmlspecialchars($row['time_slot']); ?></td>
                                                <td><?php echo htmlspecialchars($row['task_description']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="mb-20 h5">Submit Review for <?php echo htmlspecialchars($staffName); ?></h5>
                            <form name="add_remark_form" action="" method="POST">
                                <!-- Hidden fields to pass necessary IDs and dates -->
                                <input type="hidden" name="task_ids" value="<?php echo implode(',', $taskIds); ?>">
                                <input type="hidden" name="task_date" value="<?php echo htmlspecialchars($taskDate); ?>">
                                <input type="hidden" name="staff_id" value="<?php echo htmlspecialchars($staffId); ?>">

                                <!-- Radio buttons for task review -->
                                <div class="form-group">
                                    <label class="font-weight-bold">Task Review Rating<span
                                            class="text-danger">*</span></label>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="rating_excellent" name="review_rating"
                                            class="custom-control-input" value="excellent" required>
                                        <label class="custom-control-label" for="rating_excellent">Excellent</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="rating_vgood" name="review_rating"
                                            class="custom-control-input" value="very good">
                                        <label class="custom-control-label" for="rating_vgood">Very Good</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="rating_good" name="review_rating"
                                            class="custom-control-input" value="good">
                                        <label class="custom-control-label" for="rating_good">Good</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="rating_avg" name="review_rating"
                                            class="custom-control-input" value="average">
                                        <label class="custom-control-label" for="rating_avg">Average</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="rating_improve" name="review_rating"
                                            class="custom-control-input" value="need to improve">
                                        <label class="custom-control-label" for="rating_improve">Need to Improve</label>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit
                                        Review</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>
</body>

</html>