<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>`

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
            CKEDITOR.replace('text_editor1');
            CKEDITOR.replace('text_editor2');
            CKEDITOR.replace('text_editor3');
        });
    </script>
    <!-- /.CKeditor custom script -->

</head>

<?php


// Fetch faculty id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $faculty_id = mysqli_real_escape_string($con, $_GET['id']);
    $faculty_id = only_digits($faculty_id);
    if ($faculty_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faculty_view.php'},1000)</script>";
    }

    $cmd = $con->prepare("SELECT faculty.shortname as faculty_shortname, 
                                 faculty.name as faculty_name, 
                                 faculty.description as faculty_description, 
                                 faculty.meta_description, 
                                 faculty.meta_keywords, 
                                 faculty.pageTitle,
                                 faculty.is_active as faculty_is_active 
                                 FROM tbl_faculty as faculty WHERE id = ?");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();

    while ($row = $result->fetch_assoc()) {
        // Fetch data from database
        $faculty_shortname = !empty($row['faculty_shortname']) ? $row['faculty_shortname'] : 'N/A';
        $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : 'N/A';
        // $faculty_short_description = !empty($row['faculty_short_description']) ? $row['faculty_short_description'] : 'N/A';
        $faculty_description = !empty($row['faculty_description']) ? $row['faculty_description'] : 'N/A';
        $meta_description = !empty($row['meta_description']) ? $row['meta_description'] : 'N/A';
        $meta_keywords = !empty($row['meta_keywords']) ? $row['meta_keywords'] : 'N/A';
        $pageTitle = !empty($row['pageTitle']) ? $row['pageTitle'] : 'N/A';
        $faculty_is_active = $row['faculty_is_active'];
    }
}
?>

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
                            <h1 class="m-0">Edit Faculty</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Faculty</li>

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
                                    <h3 class="card-title">Edit Faculty</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" action="faculty_update.php">
                                    <!-- card-body -->
                                    <div class="card-body">

                                        <!-- hidden faulty_id -->
                                        <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">

                                        <div class="form-group">
                                            <label for="name">Name <span style="color: red;">*</span></label>
                                            <input type="text" name="faculty_name" class="form-control" id="name" placeholder="Enter Name" value="<?php echo $faculty_name; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="shortname">Short Name <span style="color: red;">*</span></label>
                                            <input type="text" name="faculty_shortname" class="form-control" id="shortname" placeholder="Enter Shortname" value="<?php echo $faculty_shortname; ?>" required>
                                        </div>

                                        <!-- <div class="form-group">
                                            <label for="shortdes">Short Description <span style="color: red;">*</span></label>
                                            <textarea id="shortdes" class="ckeditor" name="shortdes" required><?php echo htmlspecialchars($faculty_short_description); ?></textarea>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="text_editor">Description <span style="color: red;">*</span></label>
                                            <textarea id="text_editor" name="faculty_description" required><?php echo htmlspecialchars_decode($faculty_description); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="text_editor">Meta Description <span style="color: red;">*</span></label>
                                            <textarea id="text_editor1" name="meta_description" required><?php echo htmlspecialchars_decode($meta_description); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="text_editor">Meta Keywords <span style="color: red;">*</span></label>
                                            <textarea id="text_editor2" name="meta_keyword" required><?php echo htmlspecialchars_decode($meta_keywords); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="text_editor">Page Title <span style="color: red;">*</span></label>
                                            <textarea id="text_editor3" name="page_title" required><?php echo htmlspecialchars_decode($pageTitle); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Select Level</label>
                                            <?php
                                            $cmd1 = "SELECT level_id FROM tbl_faculty_level WHERE is_delete = '0' and is_active='1' and faculty_id=$faculty_id";
                                            $stmt1 = $con->prepare($cmd1);
                                            $stmt1->execute();
                                            $result1 = $stmt1->get_result();
                                            // $selected_level_array = $result1->fetch_assoc();
                                            $selected_level_array = array();
                                            while ($row1 = $result1->fetch_assoc()) {
                                                array_push($selected_level_array, $row1['level_id']);
                                            }

                                            $cmd = "SELECT id,name FROM tbl_level WHERE is_delete = '0' and is_active='1'";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            while ($row = $result->fetch_assoc()) {

                                            ?>
                                                <div class="form-check">

                                                    <input <?php if (in_array($row['id'], $selected_level_array)) echo "checked='checked'"; ?> value="<?php echo $row['id'] ?>" name="level_id[]" class="form-check-input" type="checkbox" id="<?php echo $row['name'] ?>">
                                                    <label class="form-check-label" for="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></label>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <label>Status <span style="color: red;">*</span></label>
                                            <select class="form-control" name="faculty_is_active" required>
                                                <option value="1" <?php if ($faculty_is_active == "1") {
                                                                        echo "selected";
                                                                    } ?>>Active
                                                </option>
                                                <option value="0" <?php if ($faculty_is_active == "0") {
                                                                        echo "selected";
                                                                    } ?>>
                                                    InActive</option>
                                            </select>
                                        </div>

                                        <!-- card-footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div> <!-- /.card-footer -->
                                    </div> <!-- /.card-body -->
                                </form>
                            </div>
                            <!-- /.card -->
                        </div> <!--/.col (left) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include '../include/importfooter.php'; ?>
        <!-- /.footer -->

    </div>
    <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>