<?php
// Include the checklogin.php file
include '../include/checklogin.php';


$status = 0;
// Check if a program filter has been applied
if (isset($_GET['programFilter']) &&  $_GET['programFilter'] != "") {
    $programFilter = $_GET['programFilter'];

    // Modify your SQL query to include the program filter
    $cmd2 = $con->prepare("SELECT staff.id as staff_id, staff.name as staff_name, staff.email as staff_email, staff.mobile_number as staff_mobile_number, staff.shortname as staff_shortname, staff.is_active as staff_is_active, 
                                            faculty.name as faculty_name, level.name as level_name, program.name as program_name, level.id as level_id FROM tbl_staff as staff
                                            LEFT JOIN tbl_faculty faculty ON staff.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON staff.level_id = level.id LEFT JOIN tbl_program program ON staff.program_id = program.id  
                                            WHERE staff.is_delete = ? AND program.id = ? ");
    $cmd2->bind_param("ii", $status, $programFilter);
} else {
    // If no program filter is applied, use the original query
    $cmd2 = $con->prepare("SELECT staff.id as staff_id, staff.name as staff_name, staff.email as staff_email, staff.mobile_number as staff_mobile_number, staff.shortname as staff_shortname, staff.is_active as staff_is_active, 
                                            faculty.name as faculty_name, level.name as level_name, program.name as program_name, level.id as level_id FROM tbl_staff as staff
                                            LEFT JOIN tbl_faculty faculty ON staff.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON staff.level_id = level.id LEFT JOIN tbl_program program ON staff.program_id = program.id  
                                            WHERE staff.is_delete = ? ");
    $cmd2->bind_param("i", $status);
}
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
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->
   

    <!-- wrapper -->
    <div class="wrapper">

         <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php';
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
         ?>
        <!-- Navbar -->
        

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
                            <h1 class="m-0">View Staff Details</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Staff Details</li>
                            </ol>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">

                <!-- container-fluid -->
                <div class="container-fluid">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="far fa-hand-pointer"></i>
                            <span><b>Select Program for Staff</b></span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <!-- Filter by Program -->
                                    <div style="display: flex; align-items: center;">
                                        <label for="programFilter" style="display: block; margin-bottom: 5px; width:200px">Filter by Program:</label>

                                        <select id="programFilter" name="programFilter" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px; margin-right: 10px;">
                                            <option value="">All Programs</option>
                                            <?php
                                            $cmd = "SELECT pro.id,pro.name,level.name as level_name FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                                ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $program_id = $row['program_id'];
                                                $program_name = $row['name'];
                                                $level_name = $row['level_name'];

                                            ?>

                                                <option value="<?php echo $row['id'] ?>" <?php if ($program_id == $row['id']) {
                                                                                                echo "selected";
                                                                                            } ?>>
                                                    <?php  echo $program_name . "(" . $level_name . ")"; ?></option>
                                            <?php } ?>
                                        </select>
                                        
                                <button style="width: 200px;" type="button" class="btn btn-primary" id="applyFilter">Apply Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- card -->
                <div class="card">

                    <!-- card-header -->
                    <div class="card-header">
                        <span>
                            <center>
                                <h5><b><i class="fas fa-book-reader"></i>View Staff Details</b></h5>
                            </center>
                        </span>
                    </div>
                    <!-- /.card-header -->

                    <!-- card-body -->
                    <div class="card-body">

                        <!-- + ADD Button  -->
                        <a class="btn btn-primary" style="margin-left: 90%;" href="staff_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                        <!-- + ADD Button End -->

                        <!-- table-responsive -->
                        <div class="table-responsive">

                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                <thead>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Name</b></th>
                                        <th scope="row" style="color:black;"><b>Program Name</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Contact</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Email</b></th>
                                        <th scope="row" style="color: black;"><b>Short Name</b></th>
                                        <th scope="row" style="color:black;"><b>Status</b></th>
                                        <th scope="row" style="color:black;"><b>Manage</b></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $cmd2->execute();
                                    $result = $cmd2->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $staff_id = $row['staff_id'];
                                        $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                        $staff_name = !empty($row['staff_name']) ? $row['staff_name'] : "<b>N/A</b>";
                                        $staff_email = !empty($row['staff_email']) ? $row['staff_email'] : "<b>N/A</b>";
                                        $staff_mobile_number = !empty($row['staff_mobile_number']) ? $row['staff_mobile_number'] : "<b>N/A</b>";
                                        $staff_shortname = !empty($row['staff_shortname']) ? $row['staff_shortname'] : "<b>N/A</b>";
                                        $staff_is_active = $row['staff_is_active'];

                                    ?>
                                        <tr align="center">
                                            <td scope="row">
                                                <?php echo $staff_id; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $staff_name; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $program_name; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $staff_mobile_number; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $staff_email; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $staff_shortname; ?>
                                            </td>
                                            </td>
                                            <td scope="row">
                                                <?php if ($staff_is_active) {
                                                    echo "Active";
                                                } else {
                                                    echo "Inactive";
                                                } ?>
                                            </td>
                                            <td scope="row">
                                                <a href="staff_edit.php?id=<?php echo $row['staff_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                  <?php if($role_id == 11) { ?>
                                                <a href="staff_delete.php?id=<?php echo $row['staff_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>

                                <tfoot>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Name</b></th>
                                        <th scope="row" style="color:black;"><b>Program Name</b></th>
                                        <th scope="row" style="color: black;"><b>Staff Contact</b></th>
                                        <th scope="row" style="color: black;"><b>Staff Email</b></th>
                                        <th scope="row" style="color: black;"><b>Short Name</b></th>
                                        <th scope="row" style="color:black;"><b>Status</b></th>
                                        <th scope="row" style="color:black;"><b>Manage</b></th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div> <!-- /.table-responsove -->
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
        </div><!-- /.container-fluid -->
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->

    <!-- footer -->
    <?php include '../include/importfooter.php'; ?>
    <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>
<script>
    document.getElementById("applyFilter").addEventListener("click", function() {
        // Get the selected program filter value
        var programFilter = document.getElementById("programFilter").value;

        // Redirect to the current page with the program filter as a query parameter
        window.location.href = "staff_view.php?programFilter=" + programFilter;
    });
</script>