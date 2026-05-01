<?php
include 'include/checklogin.php';

if (isset($_POST['exam_id'])) {
    $exam_id = $_POST['exam_id'];
    $output = "";

    $query = "SELECT id, enrollnment_no, account_status FROM tbl_exam_student WHERE exam_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $enrollnment_no = $row['enrollnment_no'];
        $id = $row['id'];
        $exam_status = $row['account_status'];

        // Sanitize $exam_status and $enrollnment_no if necessary

        if ($exam_status == 0) {
            $echo_status = '<span class="badge badge-info">Pending</span>';
        } elseif ($exam_status == 1) {
            $echo_status = '<span class="badge badge-success">Approved</span>';
            $btn_action = '<a href="exam_form_ac_rej.php?rej_id=' . $id . '" class="btn btn-danger"><i class="fa fa-times"></i></a>';
        } elseif ($exam_status == 2) {
            $echo_status = '<span class="badge badge-danger">Rejected</span>';
            $btn_action = '<a href="exam_form_ac_rej.php?ac_id=' . $id . '" class="btn btn-primary"><i class="fa fa-check"></i></a>';
        } elseif ($exam_status == 3) {
            $echo_status = '<span class="badge badge-success">Form Filled</span>';
            $btn_action = '<a href="exam_form_ac_rej.php?rej_id=' . $id . '" class="btn btn-danger"><i class="fa fa-times"></i></a>';
        }

        $query2 = "SELECT id, first_name, middle_name, last_name FROM tbl_students_2023 WHERE enrollnment_no = ?";
        $stmt2 = $con->prepare($query2);
        $stmt2->bind_param("s", $enrollnment_no);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($row2 = $result2->fetch_assoc()) {
            $std_name = $row2['first_name'] . ' ' . $row2['middle_name'] . ' ' . $row2['last_name'];
        }

        $query3 = "SELECT semester FROM tbl_exam_form WHERE id = ?";
        $stmt3 = $con->prepare($query3);
        $stmt3->bind_param("i", $exam_id);
        $stmt3->execute();
        $result3 = $stmt3->get_result();

        if ($row3 = $result3->fetch_assoc()) {
            $sem = $row3['semester'];
        }

        $output .= '<tr align="center">
            <td scope="row">' . $id . '</td>
            <td scope="row">' . $enrollnment_no . '</td>
            <td scope="row">' . $std_name . '</td>
            <td scope="row">' . $sem . '</td>
            <td scope="row">' . $echo_status . '</td>
            <td scope="row">' . $btn_action . '</td>
        </tr>';
    }
}
echo $output;
