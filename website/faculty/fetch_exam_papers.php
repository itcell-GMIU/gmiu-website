<?php
if (isset($_POST['filter'])) {
    include '../../database/connect.php'; // Make sure this file contains the database connection code

    $year = mysqli_real_escape_string($con, $_POST['year']);
    $session = mysqli_real_escape_string($con, $_POST['session']);
    // $program_id = isset($_GET['program_id']) ? mysqli_real_escape_string($con, $_GET['program_id']) : '';
    // $faculty_id = isset($_GET['faculty_id']) ? mysqli_real_escape_string($con, $_GET['faculty_id']) : '';

    // Validate Data
    $year = validate_data($year);
    $session = validate_data($session);
    $program_id = validate_data($program_id);
    $faculty_id = validate_data($faculty_id);

    // Prepare and execute SQL statement to fetch filtered data
    $query = "SELECT * FROM tbl_exam_paper WHERE year = ? AND session = ?";

    // Append conditions for program_id and faculty_id if they are provided
    if (!empty($program_id)) {
        $query .= " AND program_id = ?";
    }
    if (!empty($faculty_id)) {
        $query .= " AND faculty_id = ?";
    }

    $stmt = $con->prepare($query);
    if (!empty($program_id) && !empty($faculty_id)) {
        $stmt->bind_param("ssss", $year, $session, $program_id, $faculty_id);
    } elseif (!empty($program_id)) {
        $stmt->bind_param("sss", $year, $session, $program_id);
    } elseif (!empty($faculty_id)) {
        $stmt->bind_param("sss", $year, $session, $faculty_id);
    } else {
        $stmt->bind_param("ss", $year, $session);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered table-hover">';
        echo '<thead><th>Subject Name</th><th>Document</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td><a href="'. $upload_website_admin_url . 'exam_paper/document/' . htmlspecialchars($row['document']) . '" target="_blank">View Document</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p>No exam papers found for the selected filters.</p>';
    }
}
?>
