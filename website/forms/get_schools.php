<?php
// This script fetches school names based on the district and standard.
// It's called by the JavaScript on the registration form.

// Include your database connection file.
include '../../common/importwebsitefile.php';

// Set the content type to JSON for the response.
header('Content-Type: application/json');

// Get the district ID and standard from the request, ensuring they are the correct type.
$district_id = isset($_GET['district_id']) ? $_GET['district_id'] : 0;
$standard = isset($_GET['standard']) ? $_GET['standard'] : '';

$schools = [];

// Proceed only if a valid district and standard are provided.
if ($district_id > 0 && !empty($standard)) {
    // Prepare a SQL statement to prevent SQL injection.
    // Fetches distinct, active school names for the given district and standard.
    $sql = "SELECT DISTINCT school_name FROM tbl_schools WHERE district_id = ? AND standard = ? AND is_active = 1 ORDER BY school_name ASC";

    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("is", $district_id, $standard);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch all results into an array.
        while ($row = $result->fetch_assoc()) {
            $schools[] = $row['school_name'];
        }
        $stmt->close();
    }
}

// Return the list of schools (or an empty array) as a JSON object.
echo json_encode($schools);
?>