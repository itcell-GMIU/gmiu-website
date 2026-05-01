<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// if submit button is clicked then code performs
if (isset($_POST['submit'])) {

    // Fetch data from edit form
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $faculty_name = mysqli_real_escape_string($con, $_POST['faculty_name']);
    $faculty_shortname = mysqli_real_escape_string($con, $_POST['faculty_shortname']);
    // $faculty_shortdes = $_POST['faculty_shortdes'];
    $faculty_description = $_POST['faculty_description'];
    $meta_description = $_POST['meta_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $page_title = $_POST['page_title'];
    $faculty_is_active = mysqli_real_escape_string($con, $_POST['faculty_is_active']);

    // Validate Data
    $faculty_id = validate_data($faculty_id);
    $faculty_name = validate_data($faculty_name);
    $faculty_shortname = validate_data($faculty_shortname);
    $faculty_is_active = validate_data($faculty_is_active);

    // Prepare and execute the SQL statement to update a record in the tbl_faculty
    $stmt = $con->prepare("UPDATE `tbl_faculty` SET shortname = ? , name = ? ,
                           description = ?, meta_description = ?,
                           meta_keywords = ? , pageTitle = ?,
                           is_active = ? WHERE id = ? ");
    $stmt->bind_param(
        "ssssssii",
        $faculty_shortname,
        $faculty_name,
        $faculty_description,
        $meta_description,
        $meta_keyword,
        $page_title,
        $faculty_is_active,
        $faculty_id
    );
    $result = $stmt->execute();
    if ($result) {

        // Delete data from relational table
        $stmt1 = $con->prepare("DELETE FROM `tbl_faculty_level` WHERE faculty_id = ? ");
        $stmt1->bind_param("i", $faculty_id);
        $result1 = $stmt1->execute();

        if ($result1) {

            // insert new entry in relational table
            foreach ($_POST['level_id'] as $level_id) {
                $stmt2 = $con->prepare("INSERT INTO `tbl_faculty_level`(`faculty_id`, `level_id`) VALUES (?,?)");
                $stmt2->bind_param("is", $faculty_id, $level_id);
                $result2 = $stmt2->execute();

                if ($result2) {

                    //Sweet Alert of Success Message
                    $_SESSION['status'] = "Faculty Updated Successfully";
                    $_SESSION['status_code'] = "success";
                    echo "<script>setTimeout(function(){window.location='faculty_view.php'},1000);</script>";
                } else {

                    //Sweet Alert of Error Message
                    $_SESSION['status'] = "Faculty Updation Failed";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='faculty_view.php'},1000)</script>";
                }
            }
        }
    }
}
