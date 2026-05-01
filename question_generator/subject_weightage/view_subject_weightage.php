<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $subjectId = $_GET['id'];
    $subjectId = only_digits($subjectId); // Corrected variable name

    if ($subjectId === false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_weightage.php'},1000)</script>";
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
                            <h1 class="m-0">View Subject Weightage</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Subject Weightage</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Program list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Subject Weightage</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="insert_weightage.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->

                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>subject_name</b></th>
                                            <th scope="row" style="color:black;"><b>Remembering</b></th>
                                            <th scope="row" style="color:black;"><b>Understanding</b></th>
                                            <th scope="row" style="color:black;"><b>Applying</b></th>
                                            <th scope="row" style="color:black;"><b>Analyzing</b></th>
                                            <th scope="row" style="color:black;"><b>Evaluating</b></th>
                                            <th scope="row" style="color:black;"><b>Creating</b></th>
                                            <th scope="row" style="color:black;"><b>action</b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT * FROM tbl_bl_level WHERE subject_code = ? and is_delete = ? ");
                                        $cmd->bind_param("ii", $subjectId, $status);
                                        $cmd->execute();
                                        $result1 = $cmd->get_result();
                                        while ($row1 = $result1->fetch_assoc()) {
                                            $id = $row1['id'];
                                            $subjectCode = $row1['subject_code'];
                                            $remembering = $row1['remembering'];
                                            $understanding = $row1['understanding'];
                                            $applying = $row1['applying'];
                                            $analyzing = $row1['analyzing'];
                                            $evaluating = $row1['evaluating'];
                                            $creating = $row1['creating'];


                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php
                                                    $cmd2 = $con->prepare("SELECT subject_code , subject_name from tbl_std_corner_exam where id = $subjectCode and is_delete= 0 ");
                                                    $cmd2->execute();
                                                    $result1 = $cmd2->get_result();
                                                    while ($row = $result1->fetch_assoc()) {
                                                        $subject_code1 = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                                        $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                        echo $subject_code1;
                                                    }
                                                    ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $remembering; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $understanding ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $applying ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $analyzing; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $evaluating; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $creating ?>
                                                </td>
                                                 <td scope="row">
                                                    <a href="bl_level_edit.php?id=<?php echo $subjectCode ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                </td>


                                            <?php } ?>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                            <thead>
                                <tr align="center">
                                    <th scope="row" style="color:black;"><b>Id</b></th>
                                    <th scope="row" style="color:black;"><b>Sem</b></th>
                                    <th scope="row" style="color:black;"><b>Subject Code</b></th>
                                    <th scope="row" style="color:black;"><b>subject_name</b></th>
                                    <th scope="row" style="color:black;"><b>Chapter</b></th>
                                    <th scope="row" style="color:black;"><b>Chapter Weightage</b></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $status = 0;


                                $cmd = $con->prepare("SELECT std.id as id,                                           
                                corner.sem as sem, 
                                std.subject_code as subject_code, 
                                std.chapter as chapter, 
                                std.chapter_weight as chapter_weight 
                                FROM tbl_weightage as std
                                LEFT JOIN tbl_std_corner_exam AS corner ON std.subject_code = corner.id
                                WHERE std.is_delete = ?  and std.subject_code= ? 
                                ORDER BY std.chapter ASC");
    
                                $cmd->bind_param("ii", $status, $subjectId);

                                $cmd->execute();
                                $result = $cmd->get_result();
                                while ($row = $result->fetch_assoc()) {

                                    $id = $row['id'];
                                    $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                    $subject_code = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                    $chapter = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                                    $chapter_weight = !empty($row['chapter_weight']) ? $row['chapter_weight'] : "<b>N/A</b>";


                                ?>
                                    <tr align="center">
                                        <td scope="row">
                                            <?php echo $id; ?>
                                        </td>
                                        <td scope="row">
                                            <?php echo $sem; ?>
                                        </td>

                                        <td scope="row">
                                            <?php
                                            $cmd2 = $con->prepare("SELECT subject_code , subject_name from tbl_std_corner_exam where id = $subject_code ");
                                            $cmd2->execute();
                                            $result1 = $cmd2->get_result();
                                            while ($row = $result1->fetch_assoc()) {
                                                $subject_code1 = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                                $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                echo $subject_code1; ?>
                                        </td>

                                        <td scope="row">

                                        <?php

                                                $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                echo $subject_name;
                                            } ?>

                                        </td>

                                        <td scope="row">
                                            <?php echo $chapter;
                                            ?>
                                        </td>

                                        <td scope="row">
                                            <?php echo $chapter_weight;
                                            ?>
                                        </td>




                                    </tr>

                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr align="center">
                                    <th scope="row" style="color:black;"><b>Id</b></th>
                                    <th scope="row" style="color:black;"><b>Sem</b></th>
                                    <th scope="row" style="color:black;"><b>Subject Code</b></th>
                                    <th scope="row" style="color:black;"><b>subject_name</b></th>
                                    <th scope="row" style="color:black;"><b>Chapter</b></th>
                                    <th scope="row" style="color:black;"><b>Chapter Weightage</b></th>
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

</html>