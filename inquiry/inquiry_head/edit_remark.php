<?php
include '../include/checklogin.php';

$remarkId = isset($_GET['remark_id']) ? $_GET['remark_id'] : '';

// Fetch existing remark data
$editQuery = $con->prepare("SELECT * FROM tbl_daily_review WHERE id = ?");
$editQuery->bind_param("i", $remarkId);
$editQuery->execute();
$editResult = $editQuery->get_result();
$remarkData = $editResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewRating = $_POST['review_rating'];

    // Update the remark
    $updateQuery = $con->prepare("UPDATE tbl_daily_review SET comments = ? WHERE id = ?");
    $updateQuery->bind_param("si", $reviewRating, $remarkId);
    $result = $updateQuery->execute();

    if ($result) {
        $_SESSION['status'] = "Remark Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='dailytask_report.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Remark Update Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>
<body>
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1>Edit Remark</h1>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Review Rating</label><br>
                            <label class="radio-inline">
                                <input type="radio" name="review_rating" value="excellent" <?php echo ($remarkData['comments'] == 'excellent') ? 'checked' : ''; ?>> Excellent
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="review_rating" value="very good" <?php echo ($remarkData['comments'] == 'very good') ? 'checked' : ''; ?>> Very Good
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="review_rating" value="good" <?php echo ($remarkData['comments'] == 'good') ? 'checked' : ''; ?>> Good
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="review_rating" value="average" <?php echo ($remarkData['comments'] == 'average') ? 'checked' : ''; ?>> Average
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="review_rating" value="need to improve" <?php echo ($remarkData['comments'] == 'need to improve') ? 'checked' : ''; ?>> Need to Improve
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
    </div>
    <?php include '../include/importjs.php'; ?>
</body>
</html>
