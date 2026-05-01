<?php
include './include/checklogin.php';
if (isset($_GET['url_level_id'])) {
    $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id);
    $query = "SELECT name as level_name FROM tbl_level WHERE id= $url_level_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $level_name = $row['level_name'];
    } else {
        $level_name = "";
    }
} else {
    $url_level_id = "";
    $level_name = "";
}

if (isset($_GET['url_for'])) {
    $url_for = mysqli_real_escape_string($con, $_GET['url_for']);
    $url_for = validate_data($url_for);
} else {
    $url_for = "";
}

if (isset($_GET['url_faculty_id'])) {

    $url_faculty_id = mysqli_real_escape_string($con, $_GET['url_faculty_id']);
    $url_faculty_id = validate_data($url_faculty_id);

    $query = "SELECT name as faculty_name FROM tbl_faculty WHERE id= $url_faculty_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_name = "";
    $url_faculty_id = "";
}

//comment by clusteradmin
if (isset($_POST['comment_btn'])) {
    $comment = $_POST['comment'];
    $student_id = $_POST['stu_id'];
    $update = $con->prepare("UPDATE tbl_admission_student SET comment = ? WHERE id = ?");
    $update->bind_param("si", $comment, $student_id);
    if ($update->execute()) {
        $_SESSION['status'] = "Comment Added Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>window.location='$(location).attr('href');</script>";
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        $_SESSION['status_code'] = "error";
        echo "<script>window.location='$(location).attr('href');</script>";
    }
}

//approve student admission
if (isset($_POST['approved_btn'])) {
    $update = $con->prepare(
        "UPDATE tbl_admission_student SET `admission_status` = ? WHERE id = ?"
    );
    $admission_status = $_POST['admission_status'];
    $student_id = $_POST['student_id'];


    $update->bind_param(
        "si",
        $admission_status,
        $student_id
    );
    $result = $update->execute();
    if ($update->execute()) {
        if ($admission_status == "approved") {
            $_SESSION['status'] = "Approved Successfully";
        } else {
            $_SESSION['status'] = "Rejected Successfully";
        }

        $_SESSION['status_code'] = "success";
        echo "<script>window.location='$(location).attr('href');</script>";
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        $_SESSION['status_code'] = "error";
        echo "<script>window.location='$(location).attr('href');</script>";
    }
}


//reject admission student
if (isset($_POST['rejected_btn'])) {
    $update = $con->prepare(
        "UPDATE tbl_admission_student SET `admission_status` = ? WHERE id = ?"
    );
    $admission_status = $_POST['admission_status'];
    $student_id = $_POST['student_id'];


    $update->bind_param(
        "si",
        $admission_status,
        $student_id
    );
    $result = $update->execute();
    if ($update->execute()) {
        if ($admission_status == "approved") {
            $_SESSION['status'] = "Approved Successfully";
        } else {
            $_SESSION['status'] = "Rejected Successfully";
        }

        $_SESSION['status_code'] = "success";
        echo "<script>window.location='$(location).attr('href');</script>";
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        $_SESSION['status_code'] = "error";
        echo "<script>window.location='$(location).attr('href');</script>";
    }
}




//delete student
if (isset($_POST['delete_btn'])) {
    $student_id1 = $_POST['student_id1'];

    $stmt1 = $con->prepare("UPDATE `tbl_admission_student` SET is_delete = 1 WHERE id = ? ");
    $stmt1->bind_param("i", $student_id1);
    $result1 = $stmt1->execute();
    if ($result1) {

        $_SESSION['status'] = "Student Details Delete Successfully";
        $_SESSION['status_code'] = "success";

        echo "<script>window.location='$(location).attr('href');</script>";
    } else {
        $_SESSION['status'] = "Student Details Deletion Failed";
        $_SESSION['status_code'] = "error";

        echo "<script>window.location='$(location).attr('href');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
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

                            <h1 class="m-0">View <?php
                                                    if ($url_for == 'payment_completed') {
                                                        echo "Payment Completed";
                                                    } elseif ($url_for == 'all') {
                                                        echo " Total ";
                                                    } elseif ($url_for == 'payment_pending') {
                                                        echo " Payment Pending";
                                                    } elseif ($url_for == 'cluster_pending_student') {
                                                        echo "Cluster Pending";
                                                    } elseif ($url_for == 'cluster_approved_student') {
                                                        echo "Cluster Approved";
                                                    } elseif ($url_for == 'cluster_rejected_student') {
                                                        echo "Cluster Rejected";
                                                    } elseif ($url_for == 'admission_pending_student') {
                                                        echo "Admission Pending";
                                                    } elseif ($url_for == 'admission_approved_student') {
                                                        echo "Admission Approved";
                                                    } elseif ($url_for == 'admission_rejected_student') {
                                                        echo "Admission Rejected";
                                                    }

                                                    ?>
                                Student

                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View <?php
                                                                        if ($url_for == 'payment_completed') {
                                                                            echo "Payment Completed";
                                                                        } elseif ($url_for == 'all') {
                                                                            echo " Total ";
                                                                        } elseif ($url_for == 'payment_pending') {
                                                                            echo " Payment Pending";
                                                                        } elseif ($url_for == 'cluster_pending_student') {
                                                                            echo "Cluster Pending";
                                                                        } elseif ($url_for == 'cluster_approved_student') {
                                                                            echo "Cluster Approved";
                                                                        } elseif ($url_for == 'cluster_rejected_student') {
                                                                            echo "Cluster Rejected";
                                                                        } elseif ($url_for == 'admission_pending_student') {
                                                                            echo "Admission Pending";
                                                                        } elseif ($url_for == 'admission_approved_student') {
                                                                            echo "Admission Approved";
                                                                        } elseif ($url_for == 'admission_rejected_student') {
                                                                            echo "Admission Rejected";
                                                                        }

                                                                        ?>
                                    Student</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Default box -->
                    <div class="card mb-3">
                        <div class="card-header">

                            <i class="far fa-hand-pointer"></i>

                            <span> <b>Select Faculty to View Students</b></span>

                        </div>
                        <form method="GET" action="">

                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-label-group">

                                                <input type="hidden" name="url_for" value="<?php echo $url_for; ?>">
                                                <select id="faculty_id" name="url_faculty_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px" required>
                                                    <option value="">---Select Faculty---</option>

                                                    <?php
                                                    $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                                                    $result = $con->query($query);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-label-group">
                                                <select name="url_level_id" id="level_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px" required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    <!--   student list code  -->


                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>
                                            <?php echo $faculty_name . "-" . $level_name; ?>
                                            Students </b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Student Gr Number</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>First Name</b></th>
                                            <th scope="row" style="color: black;"><b>Middle Name</b></th>
                                            <th scope="row" style="color: black;"><b>Last Name</b></th>
                                            <th scope="row" style="color: black;"><b>Mobile No.</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Register Date</b></th>
                                            <th scope="row" style="color:black;"><b>View</b></th>
                                            <th scope="row" style="color:black;"><b>View Full Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Cluster Status</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Mode</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Status</b></th>
                                            <th scope="row" style="color:black;"><b>Account Status</b></th>
                                            <th scope="row" style="color:black;"><b>Admission Accept/Reject</b></th>
                                            <th scope="row" style="color:black;"><b>Admission Status</b></th>
                                            <th scope="row" style="color:black;"><b>Comment</b></th>
                                            <th scope="row" style="color:black;"><b>Add Comment</b></th>
                                            <th scope="row" style="color:black;"><b>Password</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                            <th scope="row" style="color:black;"><b>Edit Basic Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Edit Education Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Edit Documents</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cmd = "Select stu.password,stu.admission_status,stu.id,stu.gr_number,stu.comment,stu.program_id,stu.first_name,stu.middle_name,stu.last_name,stu.email,stu.mobile_number,stu.status,stu.payment_status,stu.payment_mode,stu.account_office_status,stu.created_at,pro.name as program_name,level.name as level_name,faculty.name as faculty_name from tbl_admission_student as stu LEFT JOIN tbl_program pro
                                                    ON stu.program_id = pro.id LEFT JOIN tbl_faculty faculty
                                                    ON stu.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                    ON stu.level_id = level.id Where stu.is_active=1 AND stu.is_delete=0";
                                        if ($url_for != "") {
                                            if ($url_for == "payment_completed") {
                                                $status = "success";
                                                $cmd = $cmd . " AND stu.payment_status ='$status' AND stu.account_office_status='approved'";
                                            } elseif ($url_for == "payment_pending") {
                                                $cmd = $cmd . " AND stu.payment_status !='success' AND stu.account_office_status!='approved' ";
                                            } elseif ($url_for == "cluster_pending_student") {

                                                $cmd = $cmd . " AND stu.status != 'approved' AND stu.status!='rejected' ";
                                            } elseif ($url_for == "cluster_approved_student") {
                                                $status = "approved";
                                                $cmd = $cmd . " AND stu.status = '$status' ";
                                            } elseif ($url_for == "cluster_rejected_student") {
                                                $status = "rejected";
                                                $cmd = $cmd . " AND stu.status = '$status' ";
                                            } elseif ($url_for == "admission_pending_student") {

                                                $cmd = $cmd . " AND stu.admission_status != 'rejected' AND stu.admission_status!='approved' ";
                                            } elseif ($url_for == "admission_approved_student") {
                                                $status = "approved";
                                                $cmd = $cmd . " AND stu.admission_status = '$status' ";
                                            } elseif ($url_for == "admission_rejected_student") {
                                                $status = "rejected";
                                                $cmd = $cmd . " AND stu.admission_status = '$status' ";
                                            }
                                        }
                                        if ($url_faculty_id != "") {
                                            $cmd = $cmd . " AND stu.faculty_id = '$url_faculty_id' ";
                                        }
                                        if ($url_level_id != "") {
                                            $cmd = $cmd . " AND stu.level_id = '$url_level_id' ";
                                        }

                                        $stmt = $con->prepare($cmd);



                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $rows = $result->num_rows;
                                        /*  echo $rows;
                                                exit(); */
                                        if ($rows > 0) {


                                            while ($row = $result->fetch_assoc()) {
                                                $stu_id = $row['id'];
                                                $stu_gr_number = $row['gr_number'];
                                                $stu_program_id = $row['program_id'];
                                                $comment = $row['comment'];
                                                $stu_first_name = $row['first_name'];
                                                $stu_middle_name = $row['middle_name'];
                                                $stu_last_name = $row['last_name'];
                                                $stu_email = $row['email'];
                                                $stu_mobile_number = $row['mobile_number'];
                                                $stu_cluster_status = $row['status'];
                                                $register_date = $row['created_at'];
                                                $stu_payment_status = $row['payment_status'];
                                                $stu_account_office_status = $row['account_office_status'];
                                                $stu_payment_mode = $row['payment_mode'];
                                                $stu_program_name = $row['program_name'];
                                                $stu_level_name = $row['level_name'];
                                                $stu_admission_status = $row['admission_status'];
                                                $password = $row['password'];


                                        ?>
                                                <tr align="center">

                                                    <td scope="row"><?php echo $stu_id; ?></td>
                                                    <td scope="row"><?php echo $stu_gr_number; ?></td>
                                                    <td scope="row"><?php echo  $stu_program_name; ?></td>
                                                    <td scope="row"><?php echo  $stu_first_name; ?></td>
                                                    <td scope="row"><?php echo $stu_middle_name; ?></td>
                                                    <td scope="row"><?php echo $stu_last_name; ?></td>
                                                    <td scope="row"><?php echo $stu_mobile_number; ?></td>
                                                    <td scope="row"><?php echo $stu_email; ?></td>

                                                    <td scope="row"><?php echo $register_date; ?></td>
                                                    <td scope="row"><a href="view_student_detail.php?stu_id=<?php echo $stu_id; ?>" style="color:blue;" target="_blank"><button type="button" class="btn btn-success">View</button></a></td>
                                                    <td scope="row"><a href="full_student_detail.php?stu_id=<?php echo $stu_id; ?>" style="color:blue;" target="_blank"><button type="button" class="btn btn-success">View</button></a></td>


                                                    <td scope="row">
                                                        <?php
                                                        if ($stu_cluster_status == "approved") {
                                                            echo '<span
                                                class="badge badge-success">' . $stu_cluster_status . '</span>';
                                                        } else if ($stu_cluster_status == "pending") {
                                                            echo '<span
                                                    class="badge badge-warning">' . $stu_cluster_status . '</span>';
                                                        } else if ($stu_cluster_status == "rejected") {
                                                            echo '<span
                                                    class="badge badge-danger">' . $stu_cluster_status . '</span>';
                                                        } else {
                                                            echo '<span
                                                    class="badge badge-info">' . $stu_cluster_status . '</span>';
                                                        }

                                                        ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php
                                                        if ($stu_payment_mode == "online") {
                                                            echo '<span class="badge badge-success">' . $stu_payment_mode . '</span>';
                                                        } else {
                                                            echo '<span class="badge badge-info">' . $stu_payment_mode . '</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php
                                                        if ($stu_payment_status == "success") {
                                                            echo '<span class="badge badge-success">' . $stu_payment_status . '</span>';
                                                        } else {
                                                            echo '<span class="badge badge-danger">' . $stu_payment_status . '</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php
                                                        if ($stu_account_office_status == "approved") {
                                                            echo '<span
                                                     class="badge badge-success">' . $stu_account_office_status . '</span>';
                                                        } else if ($stu_account_office_status == "rejected") {
                                                            echo '<span
                                                         class="badge badge-danger">' . $stu_account_office_status . '</span>';
                                                        } else {
                                                            echo '<span
                                                         class="badge badge-warning">' . $stu_account_office_status . '</span>';
                                                        }

                                                        ?>

                                                    </td>
                                                    <td scope="row">
                                                        <!-- accept reject button -->
                                                        <?php
                                                        if ($stu_admission_status == 'pending' || $stu_admission_status == 'submitted') {
                                                        ?>
                                                            <form action="" method="POST">
                                                                <input type="hidden" name="student_id" value="<?php echo $stu_id; ?>">
                                                                <input type="hidden" name="admission_status" value="approved">
                                                                <button type="submit" name="approved_btn" value="approved_btn" class="btn btn-success"><i class="fas fa-check"></i></button>
                                                            </form>
                                                            <form action="" method="POST">
                                                                <input type="hidden" name="student_id" value="<?php echo $stu_id; ?>">
                                                                <input type="hidden" name="admission_status" value="rejected">
                                                                <button type="submit" name="rejected_btn" value="rejected_btn" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                                            </form>

                                                        <?php
                                                        } elseif ($stu_admission_status == 'rejected') {
                                                        ?>
                                                            <form action="" method="POST">
                                                                <input type="hidden" name="student_id" value="<?php echo $stu_id; ?>">
                                                                <input type="hidden" name="admission_status" value="approved">
                                                                <button type="submit" name="approved_btn" value="approved_btn" class="btn btn-success"><i class="fas fa-check"></i></button>
                                                            </form>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <form action="" method="POST">
                                                                <input type="hidden" name="student_id" value="<?php echo $stu_id; ?>">
                                                                <input type="hidden" name="admission_status" value="rejected">
                                                                <button type="submit" name="rejected_btn" value="rejected_btn" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                                            </form>
                                                        <?php
                                                        }
                                                        ?>


                                                    </td>
                                                    </td>
                                                    <td scope="row">
                                                        <?php
                                                        if ($stu_admission_status == "approved") {
                                                            echo '<span
                                                class="badge badge-success">' . $stu_admission_status . '</span>';
                                                        } else if ($stu_admission_status == "pending") {
                                                            echo '<span
                                                    class="badge badge-warning">' . $stu_admission_status . '</span>';
                                                        } else if ($stu_admission_status == "rejected") {
                                                            echo '<span
                                                    class="badge badge-danger">' . $stu_admission_status . '</span>';
                                                        } else {
                                                            echo '<span
                                                    class="badge badge-info">' . $stu_admission_status . '</span>';
                                                        }

                                                        ?>
                                                    </td>
                                                    <td scope="row"><?php echo $comment; ?></td>
                                                    <td scope="row">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="stu_id" value="<?php echo $stu_id; ?>">
                                                            <div class="form-group">
                                                                <textarea font-size: 18px; class="form-control" rows="2" id="comment" name="comment" required></textarea>
                                                            </div>
                                                            <button type="submit" name="comment_btn" value="comment" class="btn btn-block btn-primary btn-xs">Submit</button>
                                                        </form>
                                                    </td>
                                                    <td scope="row"><?php echo $password; ?></td>

                                                    <td scope="row">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="student_id1" value="<?php echo $stu_id; ?>">
                                                            <button type="submit" name="delete_btn" value="delete_btn" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                            <br><br>

                                                        </form>

                                                    </td>
                                                    <!-- basic_detail -->
                                                    <td scope="row">
                                                        <a href="student_edit.php?id=<?php echo $stu_id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    </td>
                                                    <!-- education detail  -->
                                                    <td scope="row">
                                                        <a href="student_edu_edit.php?id=<?php echo $stu_id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    </td>
                                                    <!-- document edit  -->
                                                    <td scope="row">
                                                        <a href="student_document_edit.php?id=<?php echo $stu_id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    </td>
                                                </tr>

                                        <?php
                                            }
                                        }
                                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">

                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Student Gr Number</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>First Name</b></th>
                                            <th scope="row" style="color: black;"><b>Middle Name</b></th>
                                            <th scope="row" style="color: black;"><b>Last Name</b></th>
                                            <th scope="row" style="color: black;"><b>Mobile No.</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>Register Date</b></th>
                                            <th scope="row" style="color:black;"><b>View</b></th>
                                            <th scope="row" style="color:black;"><b>View Full Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Cluster Status</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Mode</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Status</b></th>
                                            <th scope="row" style="color:black;"><b>Account Status</b></th>
                                            <th scope="row" style="color:black;"><b>Admission Accept/Reject</b></th>
                                            <th scope="row" style="color:black;"><b>Admission Status</b></th>
                                            <th scope="row" style="color:black;"><b>Comment</b></th>
                                            <th scope="row" style="color:black;"><b>Add Comment</b></th>
                                            <th scope="row" style="color:black;"><b>Password</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                            <th scope="row" style="color:black;"><b>Edit Basic Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Edit Education Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Edit Documents</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                    <?php
                    //  }

                    ?>
                </div>
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
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
<script type="text/javascript">
    $('#faculty_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        })
    });
</script>