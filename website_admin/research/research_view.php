<?php
include '../include/checklogin.php';
$type = $_GET['id'];
if ($type == 1) {
    $heading = "GMRDC";
} else if ($type == 2) {
    $heading = "SSIP";
} else if ($type == 3) {
    $heading = "Ph.D Programs";
} else if ($type == 4) {
    $heading = "Report(Activities)";
} else if ($type == 5) {
    $heading = "Project(Activities)";
} else if ($type == 6) {
    $heading = "Publication(Activities)";
} else if ($type == 7) {
    $heading = "Event(Activities)";
} else if ($type == 8) {
    $heading = "Collaboration(Activities)";
} else if ($type == 9) {
    $heading = "Patent & IPR(Activities)";
} else if ($type == 10) {
    $heading = "Infrastructure";
} else if ($type == 11) {
    $heading = "Conatct Us";
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
                            <h1 class="m-0">View <?php echo $heading; ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View <?php echo $heading; ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- International Cell list code -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-globe"></i> View <?php echo $heading; ?></b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="research_insert.php"><i
                                    class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="international_cell"
                                    class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>img_name</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT id, title, img_name, description FROM tbl_research WHERE is_delete = ? AND type_id= ?");
                                        $cmd->bind_param("ii", $status, $type);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $ic_id = $row['id'];
                                            $title = !empty($row['title']) ? $row['title'] : "<b>N/A</b>";
                                            $img_name = !empty($row['img_name']) ? $row['img_name'] : "<b>N/A</b>";
                                            $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
                                            ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $ic_id; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $title; ?>
                                                </td>

                                                <td scope="row">

                                                    <a href="<?php echo "../uploads/international_cell/" . $img_name; ?>"
                                                        target="_blank">
                                                        <img src='<?php echo "../uploads/international_cell/" . $img_name; ?>'
                                                            alt="" style="width: 200px;">
                                                    </a>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $description; ?>
                                                </td>

                                                <td scope="row">
                                                    <a href="research_edit.php?id=<?php echo $type; ?>&ic_id=<?php echo $ic_id; ?>"
                                                        class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    <?php if ($role_id == 11) { ?>
                                                        <a href="research_delete.php?ic_id=<?php echo $ic_id; ?>"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>img_name</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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

    <?php include '../include/importjs.php'; ?>
</body>

</html>