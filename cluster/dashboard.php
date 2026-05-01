<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include './include/checklogin.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>

    <?php
    // Step 1: Get data from tbl_staff
    $cmd = "SELECT `faculty_id`, `level_id`, `program_id` FROM `tbl_staff` WHERE `id` = ?";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Step 2: Handle multiple IDs
    $faculty_ids = array_map('intval', explode(',', $row['faculty_id']));
    $program_ids = array_map('intval', explode(',', $row['program_id']));
    $level_id = $row['level_id'];
    
    // Step 3: Function to get student count by status
    function getStudentCount($con, $faculty_ids, $program_ids, $level_id, $status_condition = "") {
        $where = "is_active = 1 AND is_delete = 0";
    
        if (!empty($faculty_ids)) {
            $faculty_placeholders = implode(',', array_fill(0, count($faculty_ids), '?'));
            $where .= " AND faculty_id IN ($faculty_placeholders)";
        }
    
        if (!empty($program_ids)) {
            $program_placeholders = implode(',', array_fill(0, count($program_ids), '?'));
            $where .= " AND program_id IN ($program_placeholders)";
        }
    
        if (!empty($level_id)) {
            $where .= " AND level_id = ?";
        }
    
        if (!empty($status_condition)) {
            $where .= " AND $status_condition";
        }
    
        $sql = "SELECT id FROM tbl_admission_student WHERE $where";
        $stmt = $con->prepare($sql);
    
        $bind_values = array_merge($faculty_ids, $program_ids);
        if (!empty($level_id)) {
            $bind_values[] = $level_id;
        }
    
        $types = str_repeat('i', count($bind_values));
        $stmt->bind_param($types, ...$bind_values);
    
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows;
    }
    
    // Step 4: Get all counts
    $registered_students_count = getStudentCount($con, $faculty_ids, $program_ids, $level_id);
    $approved_students_count   = getStudentCount($con, $faculty_ids, $program_ids, $level_id, "status = 'approved'");
    $pending_students_count    = getStudentCount($con, $faculty_ids, $program_ids, $level_id, "status != 'approved' AND status != 'rejected'");
    $rejected_students_count   = getStudentCount($con, $faculty_ids, $program_ids, $level_id, "status = 'rejected'");
    ?>


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
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>

                            </ol>
                        </div><!-- /.col -->



                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div id="accordion" class="col-md-12">
                    <div class="card">

                        <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link pl-0">
                                    <h3 class="mb-0">Faculty List</h3>
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body">
                                <?php
                                        
                                        $query = "SELECT * FROM tbl_faculty WHERE `id` IN ($list_faculty_id) AND is_active = 1 and is_delete=0;";
                                        $result = $con->query($query);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                            }
                                        }
                                        ?>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3><?php echo "$registered_students_count"; ?></h3>

                                        <p>Total Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="view_student.php?url_for=all" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3><?php echo "$pending_students_count"; ?></h3>

                                        <p>Pending Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="view_student.php?url_for=pending_student" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3><?php echo "$approved_students_count"; ?>
                                            <!-- <sup style="font-size: 20px">%</sup> -->
                                        </h3>

                                        <p>Approved Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="view_student.php?url_for=approved_student" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->

                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3><?php echo "$rejected_students_count"; ?></h3>

                                        <p>Rejected Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="view_student.php?url_for=rejected_student" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>


                            <!-- ./col -->
                        </div>
                        <!-- /.row -->

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