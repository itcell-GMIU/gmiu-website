<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    
    
    function createSlug($faculty_name) {
        // Replace non-alphanumeric characters with a space
        $faculty_slug = preg_replace('/[^a-zA-Z0-9]/', ' ', $faculty_name);
        // Replace specific characters with a dash
        $faculty_slug = str_replace(['#', '(', ')', '$', '@'], '-', $faculty_slug);
        // Replace multiple spaces or dashes with a single dash
        $faculty_slug = preg_replace('/[\s-]+/', '-', $faculty_slug);
        // Trim leading and trailing dashes
        $faculty_slug = trim($faculty_slug, '-');
        // Convert to lowercase
        $faculty_slug = strtolower($faculty_slug);
        return $faculty_slug;
    }
    

    //Fetch data from HTML Form
    $faculty_name = mysqli_real_escape_string($con, $_POST['faculty_name']);
    $faculty_shortname = mysqli_real_escape_string($con, $_POST['faculty_shortname']);
    // $faculty_short_description =$_POST['short_description'];
    $faculty_description = $_POST['faculty_description'];

    // Validate Data
    $faculty_name = validate_data($faculty_name);
    $faculty_shortname = validate_data($faculty_shortname);
    // $short_description = validate_data($short_description);
    $faculty_description = validate_data($faculty_description);
     
       $faculty_slug = createSlug($faculty_name);
     
    // Prepare and execute the SQL statement to insert a new record in the tbl_faculty
    $stmt = $con->prepare("INSERT INTO `tbl_faculty`(shortname,name, description, faculty_slug) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $faculty_shortname, $faculty_name, $faculty_description, $faculty_slug);
    $result = $stmt->execute();

    if ($result) {

        // primary ID of recently inserted data
        $faculty_id = $con->insert_id;

        // insert data into relational table
        foreach ($_POST['level_id'] as $level_id) {
            $stmt = $con->prepare("INSERT INTO `tbl_faculty_level`(`faculty_id`, `level_id`) VALUES (?,?)");
            $stmt->bind_param("is", $faculty_id, $level_id);
            $result1 = $stmt->execute();

            if ($result1) {

                //Sweet Alert of Success Message
                $_SESSION['status'] = "Faculty Inserted Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='faculty_view.php'},1000);</script>";
            } else {
                
                //Sweet Alert of Error Message
                $_SESSION['status'] = "Faculty Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='faculty_view.php'},1000)</script>";
            }
        }
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
                            <h1 class="m-0">Add Faculty</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Faculty</li>
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
                                    <h3 class="card-title">Add Faculty</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST">

                                    <!-- card-body -->
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="name">Faculty Name <span style="color: red;">*</span></label>
                                            <input type="text" name="faculty_name" class="form-control" id="name" placeholder="Enter Faculty Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="shortname">Short Name <span style="color: red;">*</span></label>
                                            <input type="text" name="faculty_shortname" class="form-control" id="shortname" placeholder="Enter Short Name" required>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="short_description">Short Description <span style="color: red;">*</span></label>
                                            <input type="text" name="short_description" class="form-control" id="short_description" placeholder="Enter Short Description " required>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="text_editor">Detailed Description <span style="color: red;">*</span></label>
                                            <textarea name="faculty_description" id="text_editor" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Select Level</label>
                                            <?php
                                            $cmd = "SELECT * FROM tbl_level WHERE is_delete = '0' and is_active='1'";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <div class="form-check">
                                                    <input value="<?php echo $row['id'] ?>" name="level_id[]" class="form-check-input" type="checkbox" id="<?php echo $row['name'] ?>">
                                                    <label class="form-check-label" for="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></label>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <!-- card-footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div> <!-- /.card-footer -->

                                    </div> <!-- /.card-body -->
                                </form>
                            </div> <!-- /.card -->
                        </div> <!--/.col (right) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.main-content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include '../include/importfooter.php'; ?>
        <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>