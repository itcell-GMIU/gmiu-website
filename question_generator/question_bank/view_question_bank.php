<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>
<?php
// Initialize the base query
$query = "SELECT
            corner.id,
            corner.sem,
            corner.subject_code,
            corner.subject_name,
            f.name AS faculty_name,
            l.name AS level_name,
            p.name AS program_name,
            COUNT(que.id) AS total_questions,
            que.create_at
        FROM tbl_questions AS que
        LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
        LEFT JOIN tbl_faculty AS f ON corner.faculty_id = f.id
        LEFT JOIN tbl_level AS l ON corner.level_id = l.id
        LEFT JOIN tbl_program AS p ON corner.program_id = p.id
        WHERE que.is_delete = 0";

// Add filters if set
$params = [];

if (!empty($_GET['faculty_id'])) {
    $query .= " AND corner.faculty_id = ?";
    $params[] = $_GET['faculty_id'];
}

if (!empty($_GET['level_id'])) {
    $query .= " AND corner.level_id = ?";
    $params[] = $_GET['level_id'];
}

if (!empty($_GET['program_id'])) {
    $query .= " AND corner.program_id = ?";
    $params[] = $_GET['program_id'];
}

if (!empty($_GET['sem'])) {
    $query .= " AND corner.sem = ?";
    $params[] = $_GET['sem'];
}

// Grouping
$query .= " GROUP BY corner.id, corner.sem, corner.subject_code, corner.subject_name, f.name, l.name, p.name";

// Prepare statement
$cmd = $con->prepare($query);

// Dynamically bind parameters
if (!empty($params)) {
    $types = str_repeat('i', count($params)); // All are integers
    $cmd->bind_param($types, ...$params);
}

$cmd->execute();
$result = $cmd->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <!-- wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Question Bank</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Question Bank</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>Add Filter</b></h5>
                                </center>
                            </span>
                        </div>
                        <div class="card-body">
                            <!-- Filter Form Section -->
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Select Faculty<span style="color: red;"> *</span></label>
                                        <select class="form-control" name="faculty_id" required id="faculty_id">
                                            <option value="">---Select Faculty---</option>
                                            <?php
                                            $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result1 = $stmt->get_result();
                                            while ($row = $result1->fetch_assoc()) {
                                                $faculty_id = $row['faculty_id'];
                                            ?>

                                                <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                echo "selected";
                                                                                            } ?>>
                                                    <?php echo $row['name'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Select Level<span style="color: red;"> *</span></label>
                                        <select name="level_id" id="level_id" class="form-control">
                                            <option value="">---Select Level---</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Select Program<span style="color: red;"> *</span></label>
                                        <select name="program_id" id="program_id" class="form-control">
                                            <option value="">---Select Program---</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Select sem<span style="color: red;"> *</span></label>
                                        <select name="sem" id="sem" class="form-control">
                                            <option value=""> --- Semester--- </option>
                                            <option value="1"> Semester 1</option>
                                            <option value="2"> Semester 2</option>
                                            <option value="3"> Semester 3</option>
                                            <option value="4"> Semester 4</option>
                                            <option value="5"> Semester 5</option>
                                            <option value="6"> Semester 6</option>
                                            <option value="7"> Semester 7</option>
                                            <option value="8"> Semester 8</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Filter</button>
                                        <!-- Clear Filter Button -->
                                        <a href="view_question_bank.php" class="btn btn-secondary" style="margin-top: 25px; margin-left: 10px;">Clear Filter</a>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>


                    <!--   Program list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Question Bank</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="insert_question_bank.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Faculty</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program</b></th>
                                            <th scope="row" style="color:black;"><b>Sem</b></th>
                                            <th scope="row" style="color:black;"><b>Subject Code</b></th>
                                            <th scope="row" style="color:black;"><b>subject_name</b></th>
                                            <th scope="row" style="color:black;"><b>Total question</b></th>
                                            <th scope="row" style="color:black;"><b>Upload Time</b></th>
                                            <?php
                                            if ($role_id == 8 || $role_id == 51 || $role_id == 54) { ?>
                                                <th scope="row" style="color:black;"><b>Action</b></th>
                                            <?php } ?>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                        while ($row = $result->fetch_assoc()) {

                                            $id = !empty($row['id']) ? $row['id'] : "<b>N/A</b>";
                                            $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $subject_code = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                            $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                            $question = !empty($row['total_questions']) ? $row['total_questions'] : "<b>N/A</b>";
                                            $create_at = !empty($row['create_at']) ? date('d-m-Y', strtotime($row['create_at']))  : "<b>N/A</b>";


                                        ?>
                                            <td scope="row">
                                                <?php echo $faculty_name; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $level_name; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $program_name; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $sem; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $subject_code; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $subject_name; ?>

                                            </td>

                                            <td scope="row">
                                                <?php echo $question; ?>
                                            </td>
                                             <td scope="row">
                                                <?php echo $create_at; ?>
                                            </td>


                                            <?php
                                            if ($role_id == 8 || $role_id == 51 || $role_id == 54) { ?>

                                                <td scope="row">
                                                    <a href="view_question.php?id=<?php echo $id ?>" class="btn btn-success"><i class="fas fa-eye"></i></a>
                                                    <!-- <a href="edit_question.php?id=<?php //echo $id 
                                                                                        ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="delete_question.php?id=<?php //echo $id 
                                                                                    ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a> -->
                                                </td>
                                            <?php }
                                            ?>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Faculty</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program</b></th>
                                            <th scope="row" style="color:black;"><b>Sem</b></th>
                                            <th scope="row" style="color:black;"><b>Subject Code</b></th>
                                            <th scope="row" style="color:black;"><b>subject_name</b></th>
                                            <th scope="row" style="color:black;"><b>Total question</b></th>
                                            <th scope="row" style="color:black;"><b>Upload Time</b></th>
                                            <?php
                                            if ($role_id == 8 || $role_id == 51 || $role_id == 54) { ?>
                                                <th scope="row" style="color:black;"><b>Action</b></th>
                                            <?php } ?>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- footer -->
    <?php include '../include/importjs.php'; ?>
</body>
<script type="text/javascript">
    $('#faculty_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        // alert("hii");
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

</html>