
<?php
include '../../common/importwebsitefile.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $faculty_id = intval($_GET['id']);
   
    // Fetch the slug for the given ID
    $cmd = $con->prepare("SELECT faculty_slug FROM tbl_faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_slug = $row['faculty_slug'];

        // Redirect to the slug-based URL
        header("Location: /gmiu/website/faculty/" . $faculty_slug);
        exit;
    } else {
        // Handle case where ID does not exist
        header("Location: /gmiu/website/faculty/no-found");
        exit;
    }
} else {
    // Handle case where ID is missing or invalid
    header("Location: /gmiu/website/faculty/not-found");
    exit;
}
?>