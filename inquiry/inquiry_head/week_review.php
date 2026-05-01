<?php
include '../include/checklogin.php';

// Fetch Weekly Reviews
$reviewsQuery = "
    SELECT 
    wr.id, 
    wr.staff_id, 
    wr.start_date, 
    wr.end_date, 
    wr.review, 
    wr.review_rating, 
    wr.review_by, 
    wr.created_at, 
    s.name AS staff_name,
    rb.name AS review_by_name
FROM 
    tbl_week_review wr
JOIN 
    tbl_staff s ON wr.staff_id = s.id
LEFT JOIN 
    tbl_staff rb ON wr.review_by = rb.id
WHERE 
    wr.is_deleted = 0
ORDER BY 
    wr.created_at DESC;

";
$reviewsResult = $con->query($reviewsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Weekly Review Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Weekly Review Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-tasks"></i>View Weekly Review Report</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="add-week-review.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff Name</th>
                                            <th>Week Start</th>
                                            <th>Week End</th>
                                            <th>Review</th>
                                            <th>Rating</th>
                                            <th>Reviewed By</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        while ($review = $reviewsResult->fetch_assoc()) :
                                        ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td><?php echo htmlspecialchars($review['staff_name']); ?></td>
                                                <td><?php echo htmlspecialchars($review['start_date']); ?></td>
                                                <td><?php echo htmlspecialchars($review['end_date']); ?></td>
                                                <td><?php echo htmlspecialchars($review['review']); ?></td>
                                                <td><?php echo htmlspecialchars(ucwords($review['review_rating'])); ?></td>
                                                <td><?php echo htmlspecialchars($review['review_by_name']); ?></td>
                                                <td><?php echo htmlspecialchars($review['created_at']); ?></td>
                                                <td>
                                                    <button class="btn btn-warning edit-btn" data-toggle="modal" data-target="#editReviewModal" data-id="<?php echo $review['id']; ?>" data-review="<?php echo htmlspecialchars($review['review']); ?>" data-rating="<?php echo htmlspecialchars($review['review_rating']); ?>" data-review-by="<?php echo htmlspecialchars($review['review_by_name']); ?>">Edit</button>
                                                </td>

                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <!-- Edit Review Modal -->
    <div class="modal fade" id="editReviewModal" tabindex="-1" role="dialog" aria-labelledby="editReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editReviewForm" method="POST">
                        <input type="hidden" id="review_id" name="review_id">
                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea class="form-control" id="review" name="review" rows="4"></textarea>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Task Review Rating <span style="color: red;">*</span></label><br>
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
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include '../include/importjs.php'; ?>

    <script>
    $(document).ready(function() {
        // When the edit button is clicked, pre-fill the modal form with the review data
        $('.edit-btn').on('click', function() {
            var reviewId = $(this).data('id');
            var reviewText = $(this).data('review');
            var rating = $(this).data('rating'); // This is a text value, not a numeric value
            
            // Fill the form with the existing data
            $('#review_id').val(reviewId);
            $('#review').val(reviewText);

            // Set the correct radio button for the rating
            $("input[name='review_rating']").each(function() {
                if ($(this).val() === rating) {
                    $(this).prop('checked', true);
                }
            });
        });

        // Handle form submission
        $('#editReviewForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            // Make an AJAX request to update the review
            $.ajax({
                url: 'update_review.php',  // The PHP script to handle the update
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Close the modal and reload the page to reflect changes
                    $('#editReviewModal').modal('hide');
                    location.reload();  // Reload the page to show updated review
                },
                error: function() {
                    alert('Error updating review');
                }
            });
        });
    });
</script>



</body>

</html>