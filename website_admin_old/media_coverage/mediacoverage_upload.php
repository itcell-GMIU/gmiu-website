<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include '../include/checklogin.php';

$type_file = isset($_POST['type']) ? mysqli_real_escape_string($con, $_POST['type']) : NULL;
$alt_text = isset($_POST['alt_text']) ? mysqli_real_escape_string($con, $_POST['alt_text']) : NULL;
$faculty = isset($_POST['faculty']) ? mysqli_real_escape_string($con, $_POST['faculty']) : NULL;
$level = isset($_POST['level']) ? mysqli_real_escape_string($con, $_POST['level']) : NULL;
$program = isset($_POST['program']) ? mysqli_real_escape_string($con, $_POST['program']) : NULL;
$is_common = isset($_POST['is_common']) ? mysqli_real_escape_string($con, $_POST['is_common']) : NULL;
$is_common = isset($is_common) && $is_common ? 1 : 0;

if ($type_file == 'video') {
    $video_link = mysqli_real_escape_string($con, $_POST['videolink']);
    if (isset($_POST["submit"])) {
        $stmt = $con->prepare("INSERT INTO `tbl_media_coverage`(file_type,file,alt_text,faculty_id)VALUES (?,?,?,?)");
        $stmt->bind_param("sssi", $type_file, $video_link, $alt_text, $faculty);
        $result = $stmt->execute();
    }
    if ($result) {
        if ($result) {
            $_SESSION['status'] = "Media Coverage Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Media Coverage Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000)</script>";
        }
    }
} elseif ($type_file == 'image') {

    $path = "../uploads/media_coverage/";
    $file_upload_status = upload_single_file($_FILES["file_input"], $path, 1);
    if ($file_upload_status['status'] == 200) {
        $file_name = $file_upload_status['message'];
        $stmt = $con->prepare("INSERT INTO `tbl_media_coverage`(file_type,file,alt_text,faculty_id) VALUES (?,?,?,?)");
        $stmt->bind_param("sssi", $type_file, $file_name, $alt_text, $faculty);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['status'] = "Media Coverage Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Media Coverage Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='mediacoverage_insert.php'},1000)</script>";
        }
    } else {
        $_SESSION['status'] = $file_upload_status['message'];
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='mediacoverage_insert.php'},1000)</script>";
        //error message popup
    }
    // $file_name = $file_array[0]['name'];
    // print_r($file_array[0]['name']);


    // if ($result) {
    //     if ($result) {
    //         $_SESSION['status'] = "Media Coverage Inserted Successfully";
    //         $_SESSION['status_code'] = "success";
    //         echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
    //     } else {
    //         $_SESSION['status'] = "dailypost Insertion Failed";
    //         $_SESSION['status_code'] = "error";
    //         echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000)</script>";
    //     }
    // }

} else if ($type_file == 'reel') {
    $video_link = mysqli_real_escape_string($con, $_POST['videolink']);

    if (isset($_POST["submit"])) {
        $stmt = $con->prepare("INSERT INTO `tbl_media_coverage`(file_type,file,faculty_id, level_id, program_id, is_common_reel)VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssissi", $type_file, $video_link, $faculty, $level, $program, $is_common);
        $result = $stmt->execute();
    }
    if ($result) {
        if ($result) {
            $_SESSION['status'] = "Shorts Coverage Inserted Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Shorts Coverage Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='mediacoverage_view.php'},1000)</script>";
        }
    }
}
