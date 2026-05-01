<?php
include '../database/connect.php';
include '../common/globalvariable.php';
include '../common/function.php';
include '../common/validation.php';

$api_for = isset($_POST['api_for']) ? $_POST['api_for'] : "";
$api_for = mysqli_real_escape_string($con,$api_for);
if ($api_for == "token_fee") {
    $program_id = isset($_POST['program_id']) ? $_POST['program_id'] : "";
    $program_id = mysqli_real_escape_string($con,$program_id);
    $admission_mode = isset($_POST['admission_mode']) ? $_POST['admission_mode'] : "";
    $admission_mode = mysqli_real_escape_string($con,$admission_mode);
   /*  echo $admission_mode;
    exit(); */
    $is_active=1;
    $is_delete=0;
    if($admission_mode=="regular")
    {
        $cmd = "Select pro.id as program_id,pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    }
    else if($admission_mode=="genius")
    {
        $cmd = "Select pro.id as program_id,pro.token_genius as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    }
    else if($admission_mode=="minor")
    {
        $cmd = "Select pro.id as program_id,pro.token_minor as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    }
 /*    else if($admission_mode=="international")
    {
        $cmd = "Select pro.id as program_id,pro.international_token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    }
    else if($admission_mode=="integrated")
    {
        $cmd = "Select pro.id as program_id,pro.integrated_token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    } */
    else
    {
        $cmd = "Select pro.id as program_id,pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    }
    
    $stmt = $con->prepare($cmd);
    $stmt->bind_param("iii",$program_id,$is_active,$is_delete);
    
    $stmt->execute();
    $result = $stmt->get_result();
    $count= $result->num_rows;
  
    if ($count > 0) {
       $fetch= $result->fetch_assoc();
      
       $cmd1 = "Select pro.token_genius as genius_token,pro.token_minor as minor_token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
     
       
       $stmt1 = $con->prepare($cmd1);
       $stmt1->bind_param("iii",$program_id,$is_active,$is_delete);
       
       $stmt1->execute();
       $result1 = $stmt1->get_result();
       $fetch11= $result1->fetch_assoc();
       if(empty($fetch11['genius_token']) || $fetch11['genius_token'] == "" || $fetch11['genius_token'] ==0 || $fetch11['genius_token'] == null)
       {
            $fetch["genius_mode_status"]="no";
       }
       else
       {
            $fetch["genius_mode_status"]="yes";
       }
       if(empty($fetch11['minor_token']) || $fetch11['minor_token'] == "" || $fetch11['minor_token'] ==0 || $fetch11['genius_token'] == null)
       {
            $fetch["minor_mode_status"]="no";
       }
       else
       {
            $fetch["minor_mode_status"]="yes";
       }

      if(empty($fetch['token']) || $fetch['token'] == "" || $fetch['token'] ==0 || $fetch['token'] == null )
       {
        
            $cmd1 = "Select pro.id as program_id,pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
       
        
                    $stmt1 = $con->prepare($cmd1);
                    $stmt1->bind_param("iii",$program_id,$is_active,$is_delete);
                    
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();
                    $count1=$result1->num_rows;
                
                    if ($count1 > 0) {
                        $fetch1= $result1->fetch_assoc();
                        $fetch1["genius_mode_status"]="no";
                        $fetch1["minor_mode_status"]="no";

                        print_r(json_encode($fetch1));  
                    }
       }
       else
       { 
           print_r(json_encode($fetch));  
       }
    }
    else
    {
        echo "ss";
    }
}