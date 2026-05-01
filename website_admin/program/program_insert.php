<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {

    //Fetch data from HTML Form
    $program_name = mysqli_real_escape_string($con, $_POST['program_name']);
    $program_shortname = mysqli_real_escape_string($con, $_POST['program_shortname']);
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $program_description = $_POST['program_description'];
    $program_video_link = mysqli_real_escape_string($con, $_POST['program_video_link']);
    $program_code = mysqli_real_escape_string($con, $_POST['program_code']);
    $program_intake = mysqli_real_escape_string($con, $_POST['program_intake']);
    $program_duration = mysqli_real_escape_string($con, $_POST['program_duration']);
    $program_regular = mysqli_real_escape_string($con, $_POST['program_regular']);
  /*   $program_blended_mode = mysqli_real_escape_string($con, $_POST['program_blended_mode']);
    $program_honors = mysqli_real_escape_string($con, $_POST['program_honors']);
    $program_international = mysqli_real_escape_string($con, $_POST['program_international']); */
    $program_genius = mysqli_real_escape_string($con, $_POST['program_genius']);
    $program_minor = mysqli_real_escape_string($con, $_POST['program_minor']);
    $genius_token = mysqli_real_escape_string($con, $_POST['genius_token']);
    
    $minor_token = mysqli_real_escape_string($con, $_POST['minor_token']);

  /*   $international_token = mysqli_real_escape_string($con, $_POST['international_token']);
    $honors_token = mysqli_real_escape_string($con, $_POST['honors_token']);
    $blended_mode_token = mysqli_real_escape_string($con, $_POST['blended_mode_token']); */
    $regular_token = mysqli_real_escape_string($con, $_POST['regular_token']);


    // Validate Data
    $program_name = validate_data($program_name);
    $program_shortname = validate_data($program_shortname);
    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);
    $program_video_link = validate_data($program_video_link);
    $program_code = validate_data($program_code);
    $program_intake = validate_data($program_intake);
    $program_duration = validate_data($program_duration);
    $program_regular = validate_data($program_regular);
  /*   $program_blended_mode = validate_data($program_blended_mode);
    $program_honors = validate_data($program_honors);
    $program_international = validate_data($program_international); */
    $program_genius = validate_data($program_genius);
    $program_minor = validate_data($program_minor); 
    $genius_token = validate_data($genius_token);
   /*  $international_token = validate_data($international_token);
    $honors_token = validate_data($honors_token);
    $blended_mode_token = validate_data($blended_mode_token); */
    $regular_token = validate_data($regular_token); 
    $minor_token = validate_data($minor_token); 


    // Prepare and execute the SQL statement to insert a record in the tbl_program
   /*  $stmt = $con->prepare("INSERT INTO `tbl_program`(faculty_id,level_id,name,description,video_link, shortname, code,intake,duration,regular,blended_mode,honors,international, genius,token,token_genius, token_international, token_honors, token_blended_mode)VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("iisssssisdddddddddd", $faculty_id, $level_id, $program_name, $program_description, $program_video_link, $program_shortname, $program_code, $program_intake, $program_duration, $program_regular, $program_blended_mode, $program_honors, $program_international, $program_genius, $regular_token,$genius_token,$international_token, $honors_token, $blended_mode_token); */
    
    $stmt = $con->prepare("INSERT INTO `tbl_program`(faculty_id,level_id,name,description,video_link, shortname, code,intake,duration,regular,genius,minor,token,token_genius,token_minor)VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("iisssssisdddddd", $faculty_id, $level_id, $program_name, $program_description, $program_video_link, $program_shortname, $program_code, $program_intake, $program_duration, $program_regular,$program_genius,$program_minor,$regular_token,$genius_token,$minor_token);
    $result = $stmt->execute();
    
    if ($result) {
        // Get the last inserted ID
        $program_id = $stmt->insert_id;

        // Fetch the level name from tbl_level
        $query = "SELECT name FROM tbl_level WHERE id = ?";
        $level_stmt = $con->prepare($query);
        $level_stmt->bind_param("i", $level_id);
        $level_stmt->execute();
        $level_result = $level_stmt->get_result();
        $level_row = $level_result->fetch_assoc();
        $level_name = $level_row['name'];

        // Create the slug
        $combined_name = $level_name . ' ' . $program_name;
        $slug = strtolower(
            trim(
                preg_replace('/[\s-]+/', '-', preg_replace('/[^a-zA-Z0-9 ]/', ' ', $combined_name)),
                '-'
            )
        );

        // Update the slug in tbl_program
        $update_query = "UPDATE tbl_program SET program_slug = ? WHERE id = ?";
        $update_stmt = $con->prepare($update_query);
        $update_stmt->bind_param("si", $slug, $program_id);
        $update_stmt->execute();

        // Success message
        $_SESSION['status'] = "Program Inserted Successfully with Slug: $slug";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='program_view.php'},1000);</script>";
    } else {
        // Error message
        $_SESSION['status'] = "Program Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='program_view.php'},1000)</script>";
    }
    
    

    if ($result) {
        //Sweet Alert of Success Message
        $_SESSION['status'] = "Program Inserted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='program_view.php'},1000);</script>";
    } else {

        //Sweet Alert of Error Message
        $_SESSION['status'] = "Program Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='program_view.php'},1000)</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        CKEDITOR.replace('text_editor');
    });
    </script>
    <!-- /.CKeditor custom script -->

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

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
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">
                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Program</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Program</li>

                            </ol>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- card -->
                            <div class="card card-gmiu">
                                <!-- card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">Add Program</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST">

                                    <!-- card-body -->
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Select Faculty<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="faculty_id" required id="faculty_id">
                                                <option value="">---Select Faculty---</option>
                                                <?php
                                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $faculty_id = $row['faculty_id'];
                                                ?>

                                                <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                    <?php echo $row['name'] ?></option>
                                                <?php } ?>

                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label>Select Level<span style="color: red;"> *</span></label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Program Name <span style="color: red;">*</span></label>
                                            <input type="text" name="program_name" class="form-control" id="name"
                                                placeholder="Enter Program Name " required>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="exampleInputEmail1">Short Description <span style="color: red;">*</span></label>
                                            <input type="text" name="short_description" class="form-control" id="shortdes" placeholder="Enter Short Description" required>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="text_editor">Detailed Description </label>
                                            <textarea name="program_description" id="text_editor"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="videolink">Video-Link </label>
                                            <input type="text" name="program_video_link" class="form-control"
                                                id="videolink" placeholder="Enter Video-Link ">
                                        </div>

                                        <div class="form-group">
                                            <label for="shortname">Short Name </label>
                                            <input type="text" name="program_shortname" class="form-control"
                                                id="shortname" placeholder="Enter Short Name ">
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Code </label>
                                            <input type="text" name="program_code" class="form-control" id="code"
                                                placeholder="Enter Code">
                                        </div>

                                        <div class="form-group">
                                            <label for="intake">Intake <span style="color: red;">*</span></label>
                                            <input type="text" name="program_intake" class="form-control" id="intake"
                                                placeholder="Enter Intake" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="duration">Duration <span style="color: red;">*</span></label>
                                            <input type="text" name="program_duration" class="form-control"
                                                id="duration" placeholder="Enter Duration" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="token">Regular Token</label>
                                            <input type="text" name="regular_token" class="form-control"
                                                id="regular_token" placeholder="Enter Regular Token ">
                                        </div>
                                        <div class="form-group">
                                            <label for="token">Genius Token</label>
                                            <input type="text" name="genius_token" class="form-control"
                                                id="genius_token" placeholder="Enter Genius Token ">
                                        </div>
                                        <div class="form-group">
                                            <label for="minor_token">Minor Token</label>
                                            <input type="text" name="minor_token" class="form-control" id="minor_token"
                                                placeholder="Enter Minor Token ">
                                        </div>
                                        <div class="form-group">
                                            <label for="regular">Regular Total Fees</label>
                                            <input type="text" name="program_regular" class="form-control" id="regular"
                                                placeholder="Enter Regular ">
                                        </div>


                                        <!--    <div class="form-group">
                                            <label for="blendedmode">Blended Mode Total Fee</label>
                                            <input type="text" name="program_blended_mode" class="form-control" id="blendedmode" placeholder="Enter Blended Mode ">
                                        </div>

                                        <div class="form-group">
                                            <label for="honors">Honors Total Fee</label>
                                            <input type="text" name="program_honors" class="form-control" id="honors" placeholder="Enter Honor">
                                        </div> -->

                                        <!--   <div class="form-group">
                                            <label for="international">International Total Fee
                                               
                                            </label>
                                            <input type="text" name="program_international" class="form-control"
                                                id="international" placeholder=" Enter International">
                                        </div> -->

                                        <div class="form-group">
                                            <label for="genius">Genius Total Fees

                                            </label>
                                            <input type="text" name="program_genius" class="form-control" id="genius"
                                                placeholder="Enter Total Genius fees">
                                        </div>
                                        <div class="form-group">
                                            <label for="minor">Minor Total Fees

                                            </label>
                                            <input type="text" name="program_minor" class="form-control" id="minor"
                                                placeholder="Enter minor total fees">
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="token">Token<span style="color: red;">*</span></label>
                                            <input type="text" name="program_token" class="form-control" id="token" placeholder="Enter Token " required>
                                        </div> -->



                                        <!--       <div class="form-group">
                                            <label for="token">Blended Mode Token</label>
                                            <input type="text" name="blended_mode_token" class="form-control" id="blended_mode_token" placeholder="Enter Blended Mode Token ">
                                        </div> -->

                                        <!--  <div class="form-group">
                                            <label for="token">Honors Token</label>
                                            <input type="text" name="honors_token" class="form-control" id="honors_token" placeholder="Enter Honors Token ">
                                        </div> -->

                                        <!--  <div class="form-group">
                                            <label for="token">International Token </label>
                                            <input type="text" name="international_token" class="form-control" id="international_token" placeholder="Enter International Token ">
                                        </div> -->


                                        <!-- card-footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div> <!-- /.card-footer -->

                                    </div> <!-- /.card-body -->
                                </form>
                            </div> <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- main-content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include '../include/importfooter.php'; ?>
        <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>

<!-- Script for load levels dynamically -->
<script>
$(document).ready(function() {
    //call for listing the dropdown and select by default
    load_level();
});

function load_level() {
    var path = '<?php echo $base_url_api; ?>';
    var faculty_id = <?php echo $faculty_id; ?>;
    var level_id = <?php echo $level_id; ?>;

    $.ajax({
        url: path + 'level.php',
        type: "POST",
        data: {
            faculty_data: faculty_id,
            level_id: level_id
        },
        success: function(result) {
            $('#level_id').html(result);
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
        }
    })
});
</script>