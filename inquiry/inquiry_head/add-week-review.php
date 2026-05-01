<?php
include '../include/checklogin.php';

// Initialize filter variables
$startDate = '';
$endDate = '';
$staffId = '';

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
    $staffId = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';
}

// Fetch staff for the dropdown
$staffQuery = "SELECT id, name FROM tbl_staff WHERE role_id IN (20,16, 21) AND is_delete = 0";
$staffResult = $con->query($staffQuery);

// Fetch the specific staff name if a staffId is provided
$staffname = '';
if (!empty($staffId)) {
    $staffnameQuery = "SELECT name FROM tbl_staff WHERE id = ?";
    $stmt = $con->prepare($staffnameQuery);
    $stmt->bind_param('i', $staffId);  // Bind the staffId parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staffData = $result->fetch_assoc();
        $staffname = $staffData['name'];  // Get the staff name
    }
}

// Fetch tasks based on filters
$tasks = [];
if (!empty($startDate) && !empty($endDate) && !empty($staffId)) {
    $query = "
        SELECT 
            staff_id, task_date, time_slot, task_description
        FROM tbl_daily_task
        WHERE staff_id = ? AND task_date BETWEEN ? AND ? AND is_delete = 0
        ORDER BY task_date, time_slot;
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param('iss', $staffId, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $tasks[$row['task_date']][$row['time_slot']] = $row['task_description']; // Group tasks by date and time

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    // Collect POST data
    $staffId = $_POST['staff_id'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $review = $_POST['review'];
    $reviewRating = $_POST['review_rating'];
    
    // Validate required fields
    if (!empty($staffId) && !empty($startDate) && !empty($endDate) && !empty($review) && !empty($reviewRating)) {
        // Check for duplicate entry
        $checkQuery = "
            SELECT id 
            FROM tbl_week_review 
            WHERE staff_id = ? AND start_date = ? AND end_date = ? AND is_deleted = 0
        ";
        $stmt = $con->prepare($checkQuery);
        $stmt->bind_param('iss', $staffId, $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Duplicate review exists
            $_SESSION['status'] = "Feedback for this week has already been added.";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='dailytask_report.php'}, 1000);</script>";
        } else {
            // Insert the new review
            $insertQuery = "
                INSERT INTO tbl_week_review (
                    staff_id, start_date, end_date, review, review_rating, review_by, created_at
                ) VALUES (?, ?, ?, ?, ?, ?, NOW())
            ";
            $stmt = $con->prepare($insertQuery);
            $stmt->bind_param('issssi', $staffId, $startDate, $endDate, $review, $reviewRating, $staff_id);

            if ($stmt->execute()) {
                // SweetAlert Success Message
                $_SESSION['status'] = "Feedback Added Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='week_review.php'}, 1000);</script>";
            } else {
                // SweetAlert Error Message
                $_SESSION['status'] = "Feedback Submission Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='dailytask_report.php'}, 1000);</script>";
            }
        }
    } else {
        // SweetAlert Error Message for Empty Fields
        $_SESSION['status'] = "Please Fill All Required Fields";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='dailytask_report.php'}, 1000);</script>";
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
                <h1>Weekly Task Report</h1>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <!-- Filter Section -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Filter Tasks</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($startDate); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($endDate); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="staff_id">Select Staff:</label>
                                        <select name="staff_id" class="form-control">
                                            <option value="">Select Staff</option>
                                            <?php if ($staffResult->num_rows > 0) : ?>
                                                <?php while ($staff = $staffResult->fetch_assoc()) : ?>
                                                    <option value="<?php echo $staff['id']; ?>" <?php echo $staffId == $staff['id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($staff['name']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Task Display Table -->
                    <?php if (!empty($tasks)) : ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>Staff Tasks</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="color:black;">Staff Name</th>
                                                <th scope="col" style="color:black;">Task Date</th>
                                                <th scope="col" style="color:black;">09:30 AM - 10:30 AM</th>
                                                <th scope="col" style="color:black;">10:30 AM - 11:30 AM</th>
                                                <th scope="col" style="color:black;">11:30 AM - 12:30 PM</th>
                                                <th scope="col" style="color:black;">12:30 PM - 01:30 PM</th>
                                                <th scope="col" style="color:black;">01:30 PM - 02:30 PM</th>
                                                <th scope="col" style="color:black;">02:30 PM - 03:30 PM</th>
                                                <th scope="col" style="color:black;">03:30 PM - 04:30 PM</th>
                                                <th scope="col" style="color:black;">04:30 PM - 05:45 PM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tasks as $date => $taskList) : ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($staffname); ?></td>
                                                    <td><?php echo htmlspecialchars($date); ?></td>
                                                    <td><?php echo isset($taskList['09:30 AM - 10:30 AM']) ? htmlspecialchars($taskList['09:30 AM - 10:30 AM']) : ''; ?></td>
                                                    <td><?php echo isset($taskList['10:30 AM - 11:30 AM']) ? htmlspecialchars($taskList['10:30 AM - 11:30 AM']) : ''; ?></td>
                                                    <td><?php echo isset($taskList['11:30 AM - 12:30 PM']) ? htmlspecialchars($taskList['11:30 AM - 12:30 PM']) : ''; ?></td>
                                                    <td><?php echo isset($taskList['12:30 PM - 01:30 PM']) ? htmlspecialchars($taskList['12:30 PM - 01:30 PM']) : ''; ?></td>
                                                    <td><?php echo isset($taskList['01:30 PM - 02:30 PM']) ? htmlspecialchars($taskList['01:30 PM - 02:30 PM']) : ''; ?></td>
                                                    <td><?php echo isset($taskList['02:30 PM - 03:30 PM']) ? htmlspecialchars($taskList['02:30 PM - 03:30 PM']) : ''; ?></td>
                                                    <td><?php echo isset($taskList['03:30 PM - 04:30 PM']) ? htmlspecialchars($taskList['03:30 PM - 04:30 PM']) : ''; ?></td>
                                                    <td><?php echo isset($taskList['04:30 PM - 05:45 PM']) ? htmlspecialchars($taskList['04:30 PM - 05:45 PM']) : ''; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="card mt-3">
                                <div class="card-body">
                                    <p class="text-center">No tasks found for the selected criteria.</p>
                                </div>
                            </div>
                        <?php endif; ?>

                        </div>

                        <!-- Feedback Section -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>Weekly Feedback</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <input type="hidden" name="staff_id" value="<?php echo htmlspecialchars($staffId); ?>">
                                    <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
                                    <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">

                                    <!-- Feedback Text Area -->
                                    <div class="form-group">
                                        <label for="review">Feedback:</label>
                                        <textarea name="review" class="form-control" rows="4" required></textarea>
                                    </div>

                                    <!-- Radio Button for Review Rating -->
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

                                    <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
                                </form>
                            </div>
                        </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>
</body>

<?php include '../include/importjs.php'; ?>

</html>



<!--

add this for index 

 ALTER TABLE tbl_week_review
ADD UNIQUE KEY unique_review (staff_id, start_date, end_date);
 -->