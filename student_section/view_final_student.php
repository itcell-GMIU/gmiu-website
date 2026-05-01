<?php
include './include/checklogin.php';
if (isset($_GET['url_level_id']) && $_GET['url_level_id'] != "") {
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

if (isset($_GET['url_for']) && $_GET['url_for'] != "") {
    $url_for = mysqli_real_escape_string($con, $_GET['url_for']);
    $url_for = validate_data($url_for);
} else {
    $url_for = "";
}
if (isset($_GET['url_admission_quota']) && $_GET['url_admission_quota'] != "") {
    $url_admission_quota = mysqli_real_escape_string($con, $_GET['url_admission_quota']);
    $url_admission_quota = validate_data($url_admission_quota);
} else {
    $url_admission_quota = "";
}
if (isset($_GET['url_faculty_id'])  && $_GET['url_faculty_id'] != "") {

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
if (isset($_GET['url_program_id']) && $_GET['url_program_id'] != "") {

    $url_program_id = mysqli_real_escape_string($con, $_GET['url_program_id']);
    $url_program_id = validate_data($url_program_id);

    $query = "SELECT name as program_name FROM tbl_program WHERE id= $url_program_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
    } else {
        $program_name = "";
    }
} else {
    $program_name = "";
    $url_program_id = "";
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

                            <h1 class="m-0">View Student List

                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Student List</li>
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
                                        <div class="col-md-3">
                                            <div class="form-label-group">

                                                <input type="hidden" name="url_for" value="<?php echo $url_for; ?>">
                                                <select id="faculty_id" name="url_faculty_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
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
                                        <div class="col-md-3">
                                            <div class="form-label-group">
                                                <select name="url_level_id" id="level_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-label-group">
                                                <select name="url_program_id" id="program_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>
                                        </div>
                                        

                                        <div class="col-md-3">
                                           
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
                                <table id="acedemic1" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Student ER Number</b></th>
                                            <th scope="row" style="color: black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color: black;"><b>Level Name</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>Sem</b></th>
                                            <th scope="row" style="color: black;"><b>First Name</b></th>
                                            <th scope="row" style="color: black;"><b>Middle Name</b></th>
                                            <th scope="row" style="color: black;"><b>Last Name</b></th>
                                            <th scope="row" style="color: black;"><b>Mobile No.</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>View</b></th>
                                            <!--   <th scope="row" style="color:black;"><b>Admission Status</b></b> -->
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cmd = "Select stu.semester, stu.password,stu.id,stu.enrollnment_no,stu.program_id,stu.first_name,stu.middle_name,stu.last_name,stu.email,stu.mobile_number,stu.created_at,pro.name as program_name,level.name as level_name,faculty.name as faculty_name from tbl_students_2023 as stu LEFT JOIN tbl_program pro
                                                    ON stu.program_id = pro.id LEFT JOIN tbl_faculty faculty
                                                    ON stu.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                    ON stu.level_id = level.id Where stu.is_active=1 AND stu.is_delete=0";
                                        if ($url_faculty_id != "") {
                                            $cmd = $cmd . " AND stu.faculty_id = '$url_faculty_id' ";
                                        }
                                        if ($url_level_id != "") {
                                            $cmd = $cmd . " AND stu.level_id = '$url_level_id' ";
                                        }

                                        if ($url_program_id != "") {
                                            $cmd = $cmd . " AND stu.program_id = '$url_program_id' ";
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
                                                $stu_er_number = $row['enrollnment_no'];
                                                $stu_program_id = $row['program_id'];
                                                $stu_first_name = $row['first_name'];
                                                $stu_middle_name = $row['middle_name'];
                                                $stu_last_name = $row['last_name'];
                                                $stu_email = $row['email'];
                                                $stu_mobile_number = $row['mobile_number'];
                                                $register_date = $row['created_at'];
                                                $sem = $row['semester'];
                                               
                                                $stu_program_name = $row['program_name'];
                                                $stu_level_name = $row['level_name'];
                                                $stu_faculty_name = $row['faculty_name'];
                                       
                                                $password = $row['password'];
                                        ?>
                                                <tr align="center">
                                                    <td scope="row"><?php echo $stu_id; ?></td>
                                                    <td scope="row"><?php echo $stu_er_number; ?></td>
                                                    <td scope="row"><?php echo  $stu_faculty_name; ?></td>
                                                    <td scope="row"><?php echo  $stu_level_name; ?></td>
                                                    <td scope="row"><?php echo  $stu_program_name; ?></td>
                                                    <td scope="row"><?php echo  $sem; ?></td>
                                                    <td scope="row"><?php echo  $stu_first_name; ?></td>
                                                    <td scope="row"><?php echo $stu_middle_name; ?></td>
                                                    <td scope="row"><?php echo $stu_last_name; ?></td>
                                                    <td scope="row"><?php echo $stu_mobile_number; ?></td>
                                                    <td scope="row"><?php echo $stu_email; ?></td>
                                                  
                                                    <td scope="row"><a href="final_full_student_detail.php?stu_id=<?php echo $stu_id; ?>" style="color:blue;" target="_blank"><button type="button" class="btn btn-success">View</button></a></td>

                                                    <!--        <td scope="row">
                                                <?php
                                                /*                                                         if ($stu_admission_status == "approved") {
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
 */
                                                ?>
                                            </td> -->

                                                    <!-- <td scope="row">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="student_id1" value="<?php //echo $stu_id; ?>">
                                                            <button type="submit" name="delete_btn" value="delete_btn" class="btn btn-danger remove"><i class="fas fa-trash"></i></button>
                                                            <br><br>

                                                        </form>

                                                    </td> -->
                                                    <!-- basic_detail -->
                                                    <td scope="row">
                                                        <a href="final_student_edit.php?id=<?php echo $stu_id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
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
                                            <th scope="row" style="color:black;"><b>Student ER Number</b></th>
                                            <th scope="row" style="color: black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color: black;"><b>Level Name</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>Sem</b></th>
                                            <th scope="row" style="color: black;"><b>First Name</b></th>
                                            <th scope="row" style="color: black;"><b>Middle Name</b></th>
                                            <th scope="row" style="color: black;"><b>Last Name</b></th>
                                            <th scope="row" style="color: black;"><b>Mobile No.</b></th>
                                            <th scope="row" style="color:black;"><b>Email</b></th>
                                            <th scope="row" style="color:black;"><b>View</b></th>
                                            <!--   <th scope="row" style="color:black;"><b>Admission Status</b></b> -->
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
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
    <script type="text/javascript">
        $(".remove").click(function() {

            var id = $(this).parents("tr").attr("id");



            if (confirm('Are you sure to remove this record ?'))

            {

                $.ajax({

                    url: 'view_student.php',

                    type: 'GET',

                    data: {
                        id: id
                    },

                    error: function() {

                        alert('Something is wrong');

                    },

                    success: function(data) {

                        $("#" + id).remove();

                        // alert("Record removed successfully");

                    }

                });

            }

        });
    </script>
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
    $('#level_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var level_id = this.value;
        var faculty_id = $("select#faculty_id option:checked").val();
        /*  alert(level_id); */

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                level_data: level_id,
                faculty_data: faculty_id
            },
            cache: false,
            success: function(data) {
                $('#program_id').html(data);
                // console.log(data);
            }
        })
    });
</script>