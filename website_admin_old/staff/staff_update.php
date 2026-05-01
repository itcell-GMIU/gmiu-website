<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// if submit button is clicked then code performs
if (isset($_POST['submit'])) {

    // Fetch data from edit form
    $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
    $program_id = $_POST['program_id'];
    $program_id = implode(',', $program_id);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $work_since = mysqli_real_escape_string($con, $_POST['work_since']);
    $position = mysqli_real_escape_string($con, $_POST['position']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $total_experience = mysqli_real_escape_string($con, $_POST['total_experience']);
    $shortname = mysqli_real_escape_string($con, $_POST['shortname']);
    $description = $_POST['description'];

    // Validate Data
    $staff_id = validate_data($staff_id);
    $name = validate_data($name);
    $mobile_number = validate_data($mobile_number);
    $email = validate_data($email);
    $work_since = validate_data($work_since);
    $position = validate_data($position);
    $location = validate_data($location);
    $total_experience = validate_data($total_experience);
    $shortname = validate_data($shortname);
    $oldImage = $_FILES['file_input'];

    // This code performs if user don't change image when update data
    if (!empty($oldImage['name'])) {

        $targetDirectory = "../uploads/profile/";
        $file_upload_status = upload_single_file($_FILES["file_input"], $targetDirectory, 1);
        $file_name = $file_upload_status['message'];
    } else {

        $file_name = $_POST['oldImage'];
    }

    $stmt = $con->prepare("UPDATE `tbl_staff` SET program_id = ?, `name`=?,`mobile_number`=?,`email`=?,`work_since`=?,`position`=?,`location`=?,`total_experience`=?,`shortname`=?,`description`=?,`image` = ? WHERE id = ?");
    $stmt->bind_param("ssissssssssi", $program_id, $name, $mobile_number, $email, $work_since, $position, $location, $total_experience, $shortname, $description, $file_name, $staff_id);
    $result = $stmt->execute();

    if ($result) {

        $stmt1 = $con->prepare("DELETE FROM `tbl_staff_qualification` WHERE staff_id = ?");
        $stmt1->bind_param("i", $staff_id);
        $result1 = $stmt1->execute();

        if ($result1) {

            // get JSON data from request
            $data = json_decode(file_get_contents("php://input"), true);

            // insert qualification data into database
            if ($_POST['qualification']) {

                foreach ($_POST["qualification"] as $key => $value) {

                    $qualification = mysqli_real_escape_string($con, $value);
                    $branch = mysqli_real_escape_string($con, $_POST["branch"][$key]);
                    $passing_year = mysqli_real_escape_string($con, $_POST["passing_year"][$key]);
                    $sql = "INSERT INTO tbl_staff_qualification (staff_id,qualification, branch, passing_year) VALUES ('$staff_id','$qualification', '$branch', '$passing_year')";

                    if ($con->query($sql) !== true) {
                        die("Error: " . $sql . "<br>" . $con->error);
                    }
                }
            }
        }
    }

    $stmt2 = $con->prepare("DELETE FROM `tbl_staff_experience` WHERE staff_id = ? ");
    $stmt2->bind_param("i", $staff_id);
    $result2 = $stmt2->execute();

    if ($result2) {

        // get JSON data from request
        $data = json_decode(file_get_contents("php://input"), true);

        // insert experience data into database
        if ($_POST['organization']) {

            foreach ($_POST["organization"] as $key => $value) {

                $organization = mysqli_real_escape_string($con, $value);
                $role = mysqli_real_escape_string($con, $_POST["role"][$key]);
                $join_date = mysqli_real_escape_string($con, $_POST["join_date"][$key]);
                $till_date = mysqli_real_escape_string($con, $_POST["till_date"][$key]);
                $sql2 = "INSERT INTO tbl_staff_experience (staff_id,organization, role, join_date,till_date) VALUES ('$staff_id','$organization', '$role', '$join_date','$till_date')";

                if ($con->query($sql2) !== true) {
                    die("Error: " . $sql2 . "<br>" . $con->error);
                }
            }
        }
    }

    //Sweet Alert of Success Message
    $_SESSION['status'] = "Faculty Details Updated Successfully";
    $_SESSION['status_code'] = "success";
    echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>";
} else {

    //Sweet Alert of Error Message
    $_SESSION['status'] = "Faculty Details Update Failed";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='staff_view.php'},1000)</script>";
}


// qualification delete code 
if (isset($_POST['deleted_ids']) && !empty($_POST['deleted_ids'])) {
    $deleted_ids = explode(',', $_POST['deleted_ids']);
    foreach ($deleted_ids as $del_id) {
        $del_id = intval($del_id); // sanitize
        $deleteCmd = $con->prepare("DELETE FROM tbl_staff_qualification WHERE id = ?");
        $deleteCmd->bind_param("i", $del_id);
        $deleteCmd->execute();
    }
}
