<?php
include '../include/connect.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$response = [];

// Check if the required GET parameters are set
if (isset($_GET['academicId']) && isset($_GET['educationId'])) {

    $academicId = $_GET['academicId'];
    $educationId = $_GET['educationId'];

    // This query selects all branches matching the IDs and also gets
    // the academic and education level names for the page title.
    $sql = "SELECT 
                b.id,
                b.branch_name,
                b.is_premium,
                ac.name AS academic_name, 
                ed.name AS education_name 
            FROM gallery_branches b
            LEFT JOIN gallery_academic_level ac ON b.academic_level = ac.id
            LEFT JOIN gallery_education_level ed ON b.education_level = ed.id
            WHERE b.academic_level = ? 
              AND b.education_level = ? 
              AND b.is_active = 1 
              AND b.is_delete = 0
            ORDER BY b.is_premium DESC, b.branch_name ASC"; // Order to group premium first

    $stmt = $con->prepare($sql);

    // Bind parameters: 'ii' for two integers
    $stmt->bind_param("ii", $academicId, $educationId);

    try {
        $stmt->execute();
        $result = $stmt->get_result();

        // Prepare the output structure
        $output = [
            'academic_name' => null,
            'education_name' => null,
            'premium' => [],
            'other' => []
        ];

        $is_first_row = true;

        while ($row = $result->fetch_assoc()) {
            // On the first row, set the academic and education names
            if ($is_first_row) {
                $output['academic_name'] = $row['academic_name'];
                $output['education_name'] = $row['education_name'];
                $is_first_row = false;
            }

            // Create the branch item
            $branch_item = [
                'id' => $row['id'],
                'branch_name' => $row['branch_name'],
                'link' => '/courses/' . $academicId . '/' . $educationId . '/branches/' . $row['id']
            ];

            // Sort into 'premium' or 'other' based on the 'is_premium' flag
            if ($row['is_premium'] == 1) {
                $output['premium'][] = $branch_item;
            } else {
                $output['other'][] = $branch_item;
            }
        }

        $response['status'] = 'success';
        $response['data'] = $output;

    } catch (Exception $e) {
        // Handle SQL execution error
        http_response_code(500); // Internal Server Error
        $response['status'] = 'error';
        $response['message'] = 'Database query failed: ' . $e->getMessage();
    }

    $stmt->close();

} else {
    // Missing parameters
    http_response_code(400); // Bad Request
    $response['status'] = 'error';
    $response['message'] = 'Missing required parameters: academicId and educationId.';
}

$con->close();

// Encode the final response object and print it
echo json_encode($response);
?>