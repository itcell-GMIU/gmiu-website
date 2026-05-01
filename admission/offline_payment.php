<?php

include 'include/checklogin.php';

$faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
$level_id = mysqli_real_escape_string($con, $_POST['level_id']);
$program_id = mysqli_real_escape_string($con, $_POST['program_id']);
$mode = mysqli_real_escape_string($con, $_POST['mode']);

// new fields from form
$feedback_source = mysqli_real_escape_string($con, $_POST['feedback_source']);
$referral_code = !empty($_POST['referral_code']) ? mysqli_real_escape_string($con, $_POST['referral_code']) : null;
$admission_year = mysqli_real_escape_string($con, $_POST['admission_year']);
$method = mysqli_real_escape_string($con, $_POST['method']);


$payment_mode = "offline";
$account_office_status = "submitted";
$is_active=1;
$is_delete=0;
if($mode=="regular")
{
    $cmd = "Select pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
}
else if($mode=="genius")
{
    $cmd = "Select pro.token_genius as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
}
else if($mode=="minor")
{
    $cmd = "Select pro.token_minor as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
}
else
{
    $mode="regular";
    $cmd = "Select pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";

}
$stmt = $con->prepare($cmd);
$stmt->bind_param("iii",$program_id,$is_active,$is_delete);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $fetch= $result->fetch_assoc();
    $token_amount = $fetch['token'];
} else {
    echo "error";
    exit();
}

$transaction_id = 'Gmiu' . rand(1, 10000000);
$gr_number = generate_gr_number($stu_faculty_shortname, $student_id);
$payment_id = "";
$payment_status="pending";
$payment_date_time = date('Y-m-d');
$stmt = $con->prepare("UPDATE `tbl_admission_student` SET payment_date_time=?, payment_status=?,gr_number=?,account_office_status=?,payment_mode=?, mode = ? ,token_amount = ?,faculty_id = ?,level_id = ?,program_id= ? ,transaction_id= ? WHERE id = $student_id ");
$stmt->bind_param("ssssssdiiis",$payment_date_time,$payment_status,$gr_number,$account_office_status,$payment_mode,$mode, $token_amount, $faculty_id, $level_id, $program_id, $transaction_id, );
if ($stmt->execute()) {
    
    // Step 1: Soft delete old feedback if exists
    $stmt_check = $con->prepare("SELECT id ,feedback_source, referral_code FROM tbl_admission_feedback WHERE student_id = ? AND is_active = 1 AND is_delete = 0");
    $stmt_check->bind_param("i", $student_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    $skip_insert = false;

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        // ✅ If feedback_source + referral_code are same → skip
        if ($row['feedback_source'] === $feedback_source && $row['referral_code'] === $referral_code) {
            $skip_insert = true;
        } else {
           // Found existing record(s) → mark them inactive
        $stmt_update = $con->prepare("UPDATE tbl_admission_feedback 
                                  SET is_active = 0, is_delete = 1 
                                  WHERE student_id = ?");
        $stmt_update->bind_param("i", $student_id);
        $stmt_update->execute();
        $stmt_update->close();
        }
    }
    $stmt_check->close();
    
    // Step 2: Insert new record only if not skipping
    if (!$skip_insert) {
        // Step 2: Insert fresh feedback entry
        $stmt_fb = $con->prepare("INSERT INTO tbl_admission_feedback 
        (student_id, method, feedback_source, referral_code, admission_year) 
        VALUES (?, ?, ?, ?, ?)");
        $stmt_fb->bind_param(
            "issss",
            $student_id,
            $method,
            $feedback_source,
            $referral_code,
            $admission_year
        );
        $stmt_fb->execute();
    }

    $response = [
        'status' => 200,
        'message' => 'Success',
        'data' =>"Request Submitted Successfully."
   ]; 
    
 
} else {
     
    $response = [
        'status' => 400,
        'message' => 'error',
        'data' =>null
   ]; 
    
}
echo json_encode($response);