<?php
include './include/config.php'; // Handles session and database connection

// --- START: Merged Logic ---

$page_message = '';
$remarkData = null;

// Sanitize and validate the remark ID from the URL
$remarkId = isset($_GET['remark_id']) ? filter_var($_GET['remark_id'], FILTER_VALIDATE_INT) : false;

// Fetch existing remark data if the ID is valid
if ($remarkId) {
    // Fetch the review and join with the staff table to get the staff member's name for context
    $editQuery = $con->prepare("SELECT 
            dr.*, 
            ts.name as staff_name 
        FROM 
            tbl_daily_review dr
        JOIN
            tbl_staff ts ON dr.staff_id = ts.id
        WHERE 
            dr.id = ?");
    $editQuery->bind_param("i", $remarkId);
    $editQuery->execute();
    $editResult = $editQuery->get_result();

    if ($editResult->num_rows > 0) {
        $remarkData = $editResult->fetch_assoc();
    } else {
        $page_message = "Remark not found. It may have been deleted.";
    }
} else {
    $page_message = "Invalid or missing Remark ID.";
}

// Handle form submission for the update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $remarkId) {
    // Sanitize the submitted rating
    $reviewRating = isset($_POST['review_rating']) ? htmlspecialchars($_POST['review_rating']) : '';

    if (!empty($reviewRating)) {
        // Prepare and execute the update query
        $updateQuery = $con->prepare("UPDATE tbl_daily_review SET comments = ? WHERE id = ?");
        $updateQuery->bind_param("si", $reviewRating, $remarkId);

        if ($updateQuery->execute()) {
            $_SESSION['status'] = "Remark Updated Successfully";
            $_SESSION['status_code'] = "success";
            exit();
        } else {
            $_SESSION['status'] = "Error: Remark Update Failed";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "Please select a rating.";
        $_SESSION['status_code'] = "warning";
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
                                <h4>Edit Daily Task Remark</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="daily-task-report.php">Daily Task Report</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Remark</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Main Form Card -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <?php if ($page_message): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $page_message; ?> <a href="daily-task-report.php" class="alert-link">Return to
                                report</a>.
                        </div>
                    <?php elseif ($remarkData): ?>
                        <h5 class="mb-20 h5">
                            Editing Review for <span
                                class="text-primary"><?php echo htmlspecialchars($remarkData['staff_name']); ?></span>
                            on <span
                                class="text-primary"><?php echo date("F j, Y", strtotime($remarkData['task_date'])); ?></span>
                        </h5>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label class="font-weight-bold">Task Review Rating<span class="text-danger">*</span></label>
                                <?php
                                $ratings = ['excellent', 'very good', 'good', 'average', 'need to improve'];
                                foreach ($ratings as $rating):
                                    $checked = ($remarkData['comments'] == $rating) ? 'checked' : '';
                                    $ratingId = "rating_" . str_replace(' ', '_', $rating);
                                    ?>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="<?php echo $ratingId; ?>" name="review_rating"
                                            class="custom-control-input" value="<?php echo $rating; ?>" <?php echo $checked; ?>
                                            required>
                                        <label class="custom-control-label"
                                            for="<?php echo $ratingId; ?>"><?php echo ucfirst($rating); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="text-right">
                                <a href="dailytask-remark.php" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update
                                    Remark</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>
</body>

</html>