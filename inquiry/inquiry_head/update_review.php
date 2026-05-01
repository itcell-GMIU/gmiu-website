<?php
include '../include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewId = $_POST['review_id'];
    $reviewText = $_POST['review'];
    $rating = $_POST['review_rating'];

    // Sanitize input
    $reviewText = $con->real_escape_string($reviewText);
   

    // Update query
    $updateQuery = "
        UPDATE tbl_week_review 
        SET review = '$reviewText', review_rating = '$rating' 
        WHERE id = $reviewId AND is_deleted = 0
    ";

    if ($con->query($updateQuery)) {
        echo 'Review updated successfully';
    } else {
        echo 'Error updating review: ' . $con->error;
    }
}
?>
