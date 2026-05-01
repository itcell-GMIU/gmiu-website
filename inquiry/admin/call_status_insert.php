<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {

    //Fetch data from HTML Form

    $call_type = mysqli_real_escape_string($con, $_POST['call_type']);
    $call_title = mysqli_real_escape_string($con, $_POST['call_title']);


    $call_type = validate_data($call_type);
    $call_title = validate_data($call_title);


    if (!empty($call_type) && !empty($call_title)) {
        $stmt = $con->prepare("INSERT INTO `tbl_call_status`(call_type,call_title) VALUES (?,?)");
        $stmt->bind_param("is", $call_type, $call_title);
        $result = $stmt->execute();
    } else {
        $stmt = $con->prepare("INSERT INTO `tbl_call_status`(call_type,call_title) VALUES (?,?)");
        $stmt->bind_param("is", $call_type, $call_title);
        $result = $stmt->execute();
    }
    if ($result) {
        //Sweet Alert of Success Message
        $_SESSION['status'] = "Call Status Inserted Successfully  ";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='call_status_view.php'},1000);</script>";
    } else {

        //Sweet Alert of Error Message
        $_SESSION['status'] = "Call Status Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='call_status_view.php'},1000)</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <!-- /.header -->

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

    <!--  <style>
        #row-form {
            column-gap: 16px;
            margin-top: 20px;
        }

        .multi-select {
            position: relative;
            display: inline-block;
        }

        .selected-items {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            min-height: 30px;
            cursor: text;
        }

        .selected-items>span {
            display: inline-block;
            background-color: #e0e0e0;
            color: #333;
            padding: 3px 8px;
            margin: 2px;
            border-radius: 20px;
        }

        .selection-input {
            font-size: 14px;
            padding: 5px;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .selection-input[multiple] {
            height: auto;
        }

        .selection-input[multiple] option:checked {
            background-color: #f5f5f5;
        }
    </style> -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

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
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">

                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Call Status</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Call Status</li>
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
                                    <h3 class="card-title">Add Call Status</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">

                                    <!-- card-body -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Type<span style="color: red;"> *</span></label>
                                            <select name="call_type" id="call_type" class="form-control" required>
                                                <option value="">---Select Type Of Call---</option>
                                                <option value="1">Call Status</option>
                                                <option value="2">Call Ranking</option>



                                            </select>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label>Select Faculty(only for head)<span style="color: red;"></span></label>
                                            <select class="form-control" name="faculty_id"  id="faculty_id">
                                                <option value="">---Select Faculty---</option>
                                                <?php /*
                                                $cmd = "SELECT id,name FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
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
                                                <?php }*/ ?>

                                            </select>

                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label>Select Level(only for head)<span style="color: red;"> </span></label>
                                            <select name="level_id" id="level_id" class="form-control"  >
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label>Select Program(only for head)<span style="color: red;"> </span></label>
                                            <select name="program_id" id="program_id" class="form-control"  >
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div> -->


                                        <div class="form-group">
                                            <label>Title<span style="color: red;"> *</span></label>
                                            <input type="text" name="call_title" class="form-control" id="call_title" placeholder="Enter Name" required>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label>Contact<span style="color: red;"> *</span></label>
                                            <input type="text" name="mobile_number" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" required>
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label for="name">Email <span style="color: red;"> *</span></label>
                                            <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email" required>
                                        </div> -->


                                        <!-- <div class="form-group">
                                            <label for="name">Password<span style="color: red;">*</span></label>
                                            <input type="text" name="password" class="form-control" id="password" placeholder="Enter password" required>
                                        </div> -->

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </div> <!-- /.card-body -->
                                </form>
                            </div> <!-- /.card -->
                        </div> <!--/.col (left) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- footer -->
    <?php include '../include/importfooter.php'; ?>
    <!-- /.footer -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>











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






<!-- Library for image preview -->
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


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

        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        });

    }

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#program_id').html(result);

                // console.log(result);
            }
        });

    }
</script>