<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $id = $_POST['id'];
    $sem = $_POST['sem'];
    $subject_code = $_POST['subject_code'];

    // Retrieve chapter data (assuming they are submitted as arrays)
    $chapters = $_POST['chapter'];
    $chapter_weights = $_POST['chapter_weight'];

    // Connect to the database
    // (Assuming $con is your database connection)

    // Retrieve existing chapters from the database
    $getExistingChaptersStmt = $con->prepare("SELECT id, chapter FROM tbl_weightage WHERE subject_code = ?");
    $getExistingChaptersStmt->bind_param("i", $subject_code);
    $getExistingChaptersStmt->execute();
    $existingChaptersResult = $getExistingChaptersStmt->get_result();

    // Create an array to store existing chapters
    $existingChapters = array();
    while ($row = $existingChaptersResult->fetch_assoc()) {
        $existingChapters[$row['chapter']] = $row['id'];
    }

    // Loop through the submitted chapters
    foreach ($chapters as $key => $chapter) {
        // Retrieve the chapter weight for the current chapter
        $chapter_weight = $chapter_weights[$key];
        // Check if the chapter already exists in the submitted chapters
        if (array_count_values($chapters)[$chapter] > 1) {
            // If the chapter exists more than once, it's a duplicate
            // You can handle this error, for example, by redirecting back with an error message
            // Subject code already exists, show error message
            $_SESSION['status'] = "Weightage for the selected Chapter already exists.";
            $_SESSION['status_code'] = "error";
            header("Location: edit_weightage.php?id=$subject_code&error=duplicate_chapter");
            exit();
        }
        // Check if the chapter already exists in the database
        if (array_key_exists($chapter, $existingChapters)) {

            // Update chapter weight
            $existingChapterId = $existingChapters[$chapter];
            $updateStmt = $con->prepare("UPDATE tbl_weightage SET chapter_weight = ? WHERE id = ?");
            $updateStmt->bind_param("ii", $chapter_weight, $existingChapterId);
            $updateStmt->execute();

            // Remove the chapter from the existing chapters array to mark it as processed
            unset($existingChapters[$chapter]);
        } else {
            // Insert the new chapter into the database
            $insertStmt = $con->prepare("INSERT INTO tbl_weightage (subject_code, chapter, chapter_weight,create_by) VALUES (?, ?, ?,?)");
            $insertStmt->bind_param("iiii", $subject_code, $chapter, $chapter_weight, $web_admin_id);
            $insertStmt->execute();
        }
    }

    // Check for deleted chapters
    // Loop through remaining chapters in the existing chapters array
    foreach ($existingChapters as $chapter => $chapterId) {
        // Mark the chapter as deleted by setting is_delete = 1
        $deleteStmt = $con->prepare("UPDATE tbl_weightage SET is_delete = 1 and delete_by = ? WHERE id = ?");
        $deleteStmt->bind_param("ii", $web_admin_id, $chapterId);
        $deleteStmt->execute();
    }

    // Redirect to the page after processing
    header("Location: view_weightage.php");
    exit();
} else {
    // If the form is not submitted, redirect to the appropriate page
    // Redirect to the edit page with the subject code ID
    header("Location: edit_weightage.php?id=$subject_code");
    exit();
}
