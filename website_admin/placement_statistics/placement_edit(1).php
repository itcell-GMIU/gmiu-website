<?php
include '../include/checklogin.php';
if (isset($_GET['placement_id']) && !empty($_GET['placement_id'])) {
    $placement_id = mysqli_real_escape_string($con, $_GET['placement_id']);
    $placement_id = validate_data($placement_id);


    //  fetch staff details
    $status = 0;
    $cmd = $con->prepare("SELECT placement.id as placement_id, placement.faculty_id as faculty_id,placement.level_id as level_id,placement.program_id as program_id,placement.student_name as placement_student_name,placement.year as placement_year,placement.is_active as placement_is_active FROM tbl_placement as placement
LEFT JOIN tbl_faculty faculty ON placement.faculty_id = faculty.id 
 LEFT JOIN tbl_level level ON placement.level_id = level.id
 LEFT JOIN tbl_program program ON placement.program_id = program.id  WHERE placement.is_delete = ? and placement.id = ?");
    $cmd->bind_param("ii", $status, $placement_id);
    $cmd->execute();
    $result = $cmd->get_result();

    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $placement_year = $row['placement_year'];
        $placement_student_name = $row['placement_student_name'];
        $placement_is_active = $row['placement_is_active'];
        $faculty_id = $row['faculty_id'];
        $level_id = $row['level_id'];
        $program_id = $row['program_id'];
    } else {



        $placement_year = "";
        $placement_student_name = "";
        $placement_is_active = "";
        $faculty_id = "";
        $level_id = "";
        $program_id = "";
    }
} else {
    $placement_id = "";
    $placement_id = "";
    $placement_id = "";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;

        </div>
    </div>
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
                            <h1 class="m-0">Edit Placement Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Placement Details</li>

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
                                    <h3 class="card-title">Edit Placement Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" action="placement_update.php" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <?php if ($role_id != 8) { ?>
                                            <div class="form-group">

                                                <label>Select Faculty<span style="color: red;">*</span></label>
                                                <select class="form-control" name="faculty_id" id="faculty_id" required>
                                                    <?php
                                                    $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {

                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Select Level<span style="color: red;">*</span></label>
                                                <select name="level_id" id="level_id" class="form-control" required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>Select Program<span style="color: red;"> *</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>
                                        <?php } elseif ($role_id == 8) {
                                        ?>
                                            <div class="form-group">
                                                <label>Select level<span style="color: red;"> *</span></label>
                                                <select class="form-control" name="level_id" required id="level_id">
                                                    <option value="">---Select level---</option>
                                                    <?php
                                                    $cmd = "SELECT id,name FROM tbl_level WHERE id IN($level_id) and is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $level_id = $row['level_id'];
                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($level_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>

                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <input type="hidden" name="placement_id" value="<?php echo $placement_id; ?>">


                                        <div class="form-group">
                                            <label for="intake">Student Name <span style="color: red;">*</span></label>
                                            <input type="text" name="student_name" class="form-control" id="name" value="<?php echo $placement_student_name; ?>" placeholder="Enter Student Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Upload Student Image</label><span style="color: red;"> *</span>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="student_image" id="file_input">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                        <?php

                                        $cmd = $con->prepare("SELECT placement.student_image as placement_student_image FROM `tbl_placement` as placement where id = ?");
                                        $cmd->bind_param("i", $placement_id);
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $placement_student_image  = !empty($row['placement_student_image']) ? $row['placement_student_image'] : "";
                                        ?>
                                            <input type="hidden" name="old_student_image" value="<?php echo $placement_student_image; ?>">
                                            <div class="form-group" id="imgPrev">
                                                <img src="<?php echo "../uploads/placement/student_image/" . "$placement_student_image"; ?>" width="150" height="150">
                                            </div>
                                        <?php
                                        } ?>


                                        <div class="form-group">
                                            <label for="year">Enter Passing Year <span style="color: red;"> *</span></label>
                                            <select id="ddlYears" name="year" id="ddlYears" class="form-control">
                                                <option value="<?php echo $placement_year; ?>"><?php echo $placement_year; ?></option>
                                            </select>
                                            <!-- <input type="text" placeholder="Enter Passing Year"> -->
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Upload Company Logo</label><span style="color: red;"> *</span>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="company_logo" id="file_input1">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php

                                        $cmd = $con->prepare("SELECT placement.company_logo as placement_company_logo FROM `tbl_placement` as placement where id = ?");
                                        $cmd->bind_param("i", $placement_id);
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $placement_company_logo  = !empty($row['placement_company_logo']) ? $row['placement_company_logo'] : "";
                                        ?>
                                            <input type="hidden" name="old_company_logo" value="<?php echo $placement_company_logo; ?>">
                                            <div class="form-group" id="imgPrev1">
                                                <img src="<?php echo "../uploads/placement/company_logo/" . "$placement_company_logo"; ?>" width="150" height="150">
                                            </div>
                                        <?php
                                        } ?>




                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6">

                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
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

    <?php include '../include/importjs.php'; ?>
</body>

</html>

<!-- Script for year dropdown -->
<script type="text/javascript">
    window.onload = function () {

        // Reference the DropDownList
        var ddlYears = document.getElementById("ddlYears");

        // Determine the Current Year
        var currentYear = (new Date()).getFullYear();

        // Allow up to 5 years in advance
        var futureYear = currentYear + 5;

        // Loop and add Year values
        for (var i = 1950; i <= futureYear; i++) {
            var option = document.createElement("option");
            option.text = i;
            option.value = i;
            ddlYears.appendChild(option);
        }
    };
</script>


<script>
    $(document).ready(function() {
        //call for listing the dropdown and select by default
        load_level();
        load_program();
    });

    function load_level() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;
        var api_for = "dashboard";
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id,
                api_for: api_for
            },
            success: function(result) {
                $('#level_id').html(result);
            }
        });

    }

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;
        var program_id = <?php echo $program_id; ?>;
        var api_for = "dashboard";
        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_data: level_id,
                program_id: program_id,
                api_for: api_for
            },
            success: function(result) {
                $('#program_id').html(result);
            }
        });

    }
</script>
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
            }
        })
    });
</script>
<script>
    const input = document.getElementById('file_input');
    const preview = document.getElementById('imgPrev');

    input.addEventListener('change', () => {
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        const files = input.files;
        if (!files) {
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = () => {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.marginLeft = '20px';
                img.style.marginTop = '10px';
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
</script>
<script>
    const input1 = document.getElementById('file_input1');
    const preview1 = document.getElementById('imgPrev1');

    input1.addEventListener('change', () => {
        while (preview1.firstChild) {
            preview1.removeChild(preview1.firstChild);
        }

        const files = input1.files;
        if (!files) {
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = () => {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.marginLeft = '20px';
                img.style.marginTop = '10px';
                preview1.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
</script>