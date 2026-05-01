<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
// include '../../common/function.php';
// include '../../common/validation.php';

/**
 * Handles the server-side logic for reassigning all inquiries from one faculty member to another.
 *
 * - Validates POST data and user session.
 * - Uses a MySQLi transaction to ensure all database operations succeed or none do.
 * - Fetches all inquiries from the source faculty.
 * - Updates the inquiries to the new faculty.
 * - Creates a log entry for the bulk assignment.
 * - Creates pivot table entries for each individual inquiry that was reassigned.
 * - Returns a JSON response indicating success, failure, or specific states like 'no_inquiries'.
 */

// Set the content type of the response to JSON
header('Content-Type: application/json');

// Initialize the response array that will be sent back as JSON
$response = ['status' => 'error', 'message' => 'An unknown error occurred.'];

// 2. Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// 3. Get and sanitize input from the form
$old_staff_id = isset($_POST['old_staff_id']) ? (int) $_POST['old_staff_id'] : 0;
$new_staff_id = isset($_POST['new_staff_id']) ? (int) $_POST['new_staff_id'] : 0;
$assign_by = (int) $_SESSION['staff_id']; // The admin/user performing the action

// 4. Validate the input
if ($old_staff_id <= 0 || $new_staff_id <= 0) {
    $response['message'] = 'Invalid selection. Please choose both a source and a destination faculty.';
    echo json_encode($response);
    exit;
}

if ($old_staff_id === $new_staff_id) {
    $response['message'] = 'Error: The source and destination faculty cannot be the same.';
    echo json_encode($response);
    exit;
}

// --- Database Transaction ---
// A transaction ensures that if any single query fails, all previous queries are rolled back,
// preventing partial data updates and maintaining database integrity.
$con->begin_transaction();

try {
    // Step 1: Find all active inquiries assigned to the old staff member
    $selectStmt = $con->prepare("SELECT id, inq_student_id FROM tbl_inquiry_student WHERE staff_id = ? AND is_admission_confirm = 0 AND is_closed = 0 AND is_active = 1 AND is_delete = 0 ORDER BY id ASC");
    $selectStmt->bind_param("i", $old_staff_id);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $first_inq_id = null;
    $last_inq_id = null;
    $inquiry_ids_to_update = [];
    while ($row = $result->fetch_assoc()) {
        if ($first_inq_id === null) {
            $first_inq_id = $row['inq_student_id'];
        }
        $inquiry_ids_to_update[] = $row['inq_student_id'];
        $last_inq_id = $row['inq_student_id'];
    }
    $total_inquiries = count($inquiry_ids_to_update);
    $selectStmt->close();

    // Step 2: If there are no inquiries, inform the user and stop.
    if ($total_inquiries === 0) {
        $con->rollback(); // Although no changes were made, it's good practice to end the transaction.
        $response['status'] = 'no_inquiries';
        $response['message'] = 'The selected source faculty has no inquiries to reassign.';
        echo json_encode($response);
        exit;
    }

    // Step 3: Reassign all found inquiries to the new staff member
    // I have corrected 'is-delete' to 'is_delete' as it was likely a typo.
    $updateStmt = $con->prepare("UPDATE tbl_inquiry_student SET staff_id = ?, assign_by = ? WHERE staff_id = ? AND is_admission_confirm = 0 AND is_closed = 0 AND is_active = 1 AND is_delete = 0");
    $updateStmt->bind_param("iii", $new_staff_id, $assign_by, $old_staff_id);
    $updateStmt->execute();

    // Integrity Check: ensure the number of updated rows matches our count
    if ($updateStmt->affected_rows !== $total_inquiries) {
        throw new Exception("Data consistency error. Expected to update {$total_inquiries} inquiries, but {$updateStmt->affected_rows} were changed. The operation has been cancelled.");
    }
    $updateStmt->close();

    // Step 4: Create a master log entry for this bulk reassignment action
    // This now logs both the source (old_staff_id) and destination (staff_id).
    $logStmt = $con->prepare("INSERT INTO tbl_inquiry_assign_log (assign_by, staff_id, old_staff_id, starting_id, ending_id, total, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $logStmt->bind_param("iiissi", $assign_by, $new_staff_id, $old_staff_id, $first_inq_id, $last_inq_id, $total_inquiries);
    $logStmt->execute();
    $log_id = $con->insert_id; // Get the ID of this new log entry
    $logStmt->close();

    if ($log_id <= 0) {
        throw new Exception('Failed to create the main assignment log entry.');
    }

    // Step 5: Create a pivot table entry for each individual inquiry that was moved.
    $pivotStmt = $con->prepare("INSERT INTO tbl_inquiry_assign_log_pivot (log_id, inq_student_id, created_at) VALUES (?, ?, NOW())");
    foreach ($inquiry_ids_to_update as $inq_id) {
        $pivotStmt->bind_param("is", $log_id, $inq_id);
        $pivotStmt->execute();
    }
    $pivotStmt->close();

    // If all steps succeeded without throwing an exception, commit the changes to the database.
    $con->commit();
    $response['status'] = 'success';
    $response['message'] = 'All inquiries were successfully reassigned.';

} catch (Exception $e) {
    // If any error occurred at any step, roll back all database changes.
    $con->rollback();
    $response['message'] = 'A database error occurred during the transaction: ' . $e->getMessage();
}

// Close the database connection
$con->close();

// Send the final JSON response to the JavaScript AJAX call
echo json_encode($response);
