<?php
// Include the checklogin.php file
include '../include/checklogin.php';


if (isset($_GET['std_er'])) {

    $std_er = mysqli_real_escape_string($con, $_GET['std_er']);
    $std_er = validate_data($std_er);
} else {
    $std_er = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <title>Exam Reports</title>
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
                            <h1 class="m-0">Marks Entry</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Marks Entry</li>
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
                                    <h5><b><i class="fa fa-check-square-o"></i> Marks Entry</b></h5>
                                </center>
                            </span>
                        </div>

                        <form method="GET" action="">

                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-9">
                                            <div class="form-label-group">
                                                <input id="myTextInput" autofocus type="text" class="form-control" name="std_er" placeholder="Enter Code Number">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary btn-block" id="export" style="float:center"><i class="fa fa-barcode"></i> Enter Mark</button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (isset($_GET['err'])) {
                                ?>
                                <div class="alert " style="background-color: #f7c994;">Please Enter Valid Marks!</div>
                                <?php
                                }
                                ?>
                            </div>
                        </form>

                        <!-- /.card-header -->  
                        <div class="card-body">
                            <!-- + ADD Button End -->

                            <?php
                            if (isset($_GET['std_er'])) {

                                $query2 = "SELECT * FROM tbl_exam_results WHERE barcode = ?";
                                $stmt2 = $con->prepare($query2);
                                $stmt2->bind_param("s", $std_er);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();

                                if ($row2 = $result2->fetch_assoc()) {

                                    $Mtheory = $row2['Mtheory'];
                                    $sbjCode = $row2['subject_code'];

                            ?>
                                    <div class="row bg-light text-center">
                                        <div class="col-sm-6 border p-3 self-align-center">
                                            <p>Code :<b> <?= $row2['barcode'] ?></b></p>
                                        </div>
                                        <div class="col-sm-6 border p-3">
                                            <?php
                                            $query3 = "SELECT id FROM `tbl_exam_staff` WHERE FIND_IN_SET(?, EXsubject) AND id = ?";
                                            $stmt3 = $con->prepare($query3);
                                            $stmt3->bind_param("si", $sbjCode, $staff_id);
                                            $stmt3->execute();
                                            $result3 = $stmt3->get_result();
                                            if ($row3 = $result3->fetch_assoc()) {
                                                $sbjValid = 1;
                                            }
                                            if ($Mtheory != NULL && $role_id == 52) {
                                                echo '<span class="badge badge-info">Marks Locked Already!</span>';
                                            }elseif($sbjValid != 1 && $role_id == 52){
                                                echo '<span class="badge badge-warning">Subject Code Mismatch!</span>';
                                            } else {
                                            ?>
                                                <form method="post" action="insertMarks.php" class="form ml-auto">
                                                    <div class="form-group">
                                                        <div class="form-row">
                                                            <div class="form-label-group d-flex mx-auto">
                                                                <input id="" type="number" class="form-control" name="marks" value="<?= $Mtheory ?>" placeholder="Enter Mark">

                                                                <input type="text" class="form-control" name="brCode" value="<?= $std_er ?>" hidden>

                                                                <button type="button" class="ml-2 btn btn-success text-nowrap" id="export" style="float:center" data-toggle="modal" data-target="#flipFlop">
                                                                    <i class="fa fa-lock"></i> Lock Marks
                                                                </button>

                                                                <!-- The modal -->
                                                                <div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">

                                                                                <h4 class="modal-title" id="modalLabel">Are You Sure For Locking This Marks ?</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" name="submit" class="btn btn-success" id="export" style="float:center"><i class="fa fa-check"></i> Confirm</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-cancel"></i> No</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="row">
                                        <div class="col-sm-12 bg-warning">No Data Matched !</div>
                                    </div>

                            <?php
                                }
                            }
                            ?>

                        </div>
                        <!-- /.card-body -->
                    </div><!-- /.container-fluid -->
                </div>
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
    <script>
        var input = document.getElementById('myTextInput');
        input.focus();
    </script>
    <script>
        function myFunction() {
            var txt;
            if (confirm("Are You Sure For Locking This Marks!")) {
                txt = "You pressed OK!";
            } else {
                txt = "You pressed Cancel!";
            }
            document.getElementById("demo").innerHTML = txt;
        }
    </script>
</body>

</html>