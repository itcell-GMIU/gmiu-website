<?php
// Include the checklogin.php file
include '../include/checklogin.php';

    $status = 0;

    $faculty_filter = isset($_GET['faculty_id']) ? $_GET['faculty_id'] : '';
    $level_filter = isset($_GET['level_id']) ? $_GET['level_id'] : '';
    $program_filter = isset($_GET['program_id']) ? $_GET['program_id'] : '';
    $sem = isset($_GET['sem']) ? $_GET['sem'] : '';

    // Base query
    $sql = "SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.sem as sem, std.subject_code as subject_code, std.subject_name as subject_name, 
    faculty.name as faculty_name, level.name as level_name, program.name as program_name 
    FROM tbl_std_corner_exam as std
    LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id
    LEFT JOIN tbl_level level ON std.level_id = level.id
    LEFT JOIN tbl_program program ON std.program_id = program.id 
    WHERE std.is_active ='1' AND std.is_delete = ?";

    // Add filters to the query
    $filters = array($status);
    if (!empty($faculty_filter)) {
        $sql .= " AND std.faculty_id = ?";
        $filters[] = $faculty_filter;
    }
    if (!empty($level_filter)) {
        $sql .= " AND std.level_id = ?";
        $filters[] = $level_filter;
    }
    if (!empty($program_filter)) {
        $sql .= " AND std.program_id = ?";
        $filters[] = $program_filter;
    }
    if (!empty($sem)) {
        $sql .= " AND std.sem = ?";
        $filters[] = $sem;
    }

    // Prepare and execute the query
    $cmd = $con->prepare($sql);
    $types = str_repeat("i", count($filters)); // Determine the type of the parameters (assuming they are integers)
    $cmd->bind_param($types, ...$filters);
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
                                <h1 class="m-0">View Subject</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">View Subject</li>
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
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Select Program<span style="color: red;"> *</span></label>
                                            <select name="program_id" id="program_id" class="form-control" required>
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                                <label>Select sem<span style="color: red;"> *</span></label>
                                                <select name="sem" id="sem" class="form-control" required>
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
                                            <a href="subject_view.php" class="btn btn-secondary" style="margin-top: 25px; margin-left: 10px;">Clear Filter</a>
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
                                        <h5><b><i class="fas fa-book-reader"></i>View Subject</b></h5>
                                    </center>
                                </span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- + ADD Button  -->
                                <a class="btn btn-primary" style="margin-left: 90%;" href="subject_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                                <!-- + ADD Button End -->
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Id</b></th>
                                                <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                                <th scope="row" style="color:black;"><b>Level Name</b></th>
                                                <th scope="row" style="color:black;"><b>Program Name</b></th>
                                                <th scope="row" style="color:black;"><b>Sem</b></th>
                                                <th scope="row" style="color:black;"><b>Subject Code</b></th>
                                                <th scope="row" style="color:black;"><b>subject_name</b></th>
                                                <th scope="row" style="color:black;"><b>action</b></th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()) { ?>
                                                <tr align="center">
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['faculty_name']; ?></td>
                                                    <td><?php echo $row['level_name']; ?></td>
                                                    <td><?php echo $row['program_name']; ?></td>
                                                    <td><?php echo $row['sem']; ?></td>
                                                    <td><?php echo $row['subject_code']; ?></td>
                                                    <td><?php echo $row['subject_name']; ?></td>
                                                    <td>
                                                        <a href="subject_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="subject_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                        <tfoot>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Id</b></th>
                                                <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                                <th scope="row" style="color:black;"><b>Level Name</b></th>
                                                <th scope="row" style="color:black;"><b>Program Name</b></th>
                                                <th scope="row" style="color:black;"><b>Sem</b></th>
                                                <th scope="row" style="color:black;"><b>Subject Code</b></th>
                                                <th scope="row" style="color:black;"><b>subject_name</b></th>
                                                <th scope="row" style="color:black;"><b>action</b></th>
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