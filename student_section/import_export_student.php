<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include the checklogin.php file
include 'include/checklogin.php';
if(isset($_POST["import"])){
    
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
             // Flag to skip the first row
             $skipFirstRow = true;
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {
             // Skip the first row
             if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }
            $faculty_id = $getData[0];
            $level_id = $getData[1];
            $program_id = $getData[2];
            $semester = $getData[3];
            $admission_quota = $getData[4];
            $mode = $getData[5];
            $first_name = $getData[6];
            $middle_name = $getData[7];
            $last_name = $getData[8];
            $email = $getData[9];
            $mobile_number = $getData[10];
            $admission_year = $getData[11];
            $password = $getData[12];
            $status = $getData[13];
            $admission_status = $getData[14];
            $account_office_status = $getData[15];
            $step = $getData[16];
            $basic_detail_status = $getData[17];
            $payment_detail_status = $getData[18];
            $education_detail_status = $getData[19];
            $document_detail_status = $getData[20];
            $token_amount = $getData[21];
            $payment_status = $getData[22];
            $payment_mode = $getData[23];
            $created_by = $getData[24];
            $updated_by = $getData[25];
            //admission student table entry
            $stmt = $con->prepare("INSERT INTO tbl_admission_student (faculty_id, level_id, program_id, semester, admission_quota, mode, first_name, middle_name, last_name, email, mobile_number, admission_year, password, status, admission_status,account_office_status, step, basic_detail_status, payment_detail_status, education_detail_status, document_detail_status, token_amount, payment_status, payment_mode, created_by, updated_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");

            $stmt->bind_param("iiiissssssssssssssssssssss", $faculty_id, $level_id, $program_id, $semester, $admission_quota, $mode, $first_name, $middle_name, $last_name, $email, $mobile_number, $admission_year, $password, $status, $admission_status,$account_office_status,$step, $basic_detail_status, $payment_detail_status, $education_detail_status, $document_detail_status, $token_amount, $payment_status, $payment_mode, $created_by, $updated_by);

               if ($stmt->execute()) {
                $student_id = $con->insert_id;
              
                //code for getting faculty id inserted
                $cmd = "SELECT faculty_id FROM tbl_admission_student where id=$student_id";
                $result_cmd = $con->query($cmd);
                $row_cmd = $result_cmd->fetch_assoc();
                $stu_faculty_id=$row_cmd['faculty_id'];

                 //code for getting faculty shortname
                 $sql = "SELECT shortname FROM tbl_faculty where id=$stu_faculty_id";
                 $result = $con->query($sql);
                 $row = $result->fetch_assoc();
                 $stu_faculty_shortname=$row['shortname'];
                 $transaction_id = 'GMIU-SQ' . rand(1, 10000000);
                 //code for generating gr number
                    $gr_number = generate_gr_number($stu_faculty_shortname,$student_id);
                    $payment_date_time = date('Y-m-d');
                    $sql_query = "UPDATE tbl_admission_student SET `payment_date_time`='$payment_date_time' ,`gr_number`='$gr_number' , `transaction_id`='$transaction_id' WHERE id=$student_id";
                 /*    print_r($sql_query);
                    exit(); */
                    $result=$con->query($sql_query);    
                    if (!$result) {
                        echo "error";
                            exit();
                        }
                      
                }else {
                    echo "error";
                    exit();
                }
          // fclose($file);  
     }
     $_SESSION['status'] = "Imported Successfully";
                            $_SESSION['status_code'] = "success";
                            echo "<script>setTimeout(function(){window.location='view_student.php'},2000)</script>"; 
  }   }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
   
</head>

<body class="hold-transition sidebar-mini layout-fixed">
 <!-- Preloader -->   
<div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <div class="wrapper">

        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Import Student in Software</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Student in Software</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Import Student-<a href="admission_sq.csv" download="admission_sq.csv">Click Here to download Sample to upload .csv file</a></h3>
                                    <br>
                                <span><a href="admission_all_relation.xlsx" download="admission_all_relation.xlsx">Click here to download Relational table excel.</a></span>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                    <div class="form-group">
                                            <label for="name">Select CSV<span style="color: red;">*</span></label>
                                            <input type="file" name="file" class="form-control" id="file" accept=".csv" required>
                                        </div>
                                        <div class="card-footer">
                                            <input type="submit" name="import" value="Import" class="btn btn-primary">
                                        </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>
</body>

</html>
