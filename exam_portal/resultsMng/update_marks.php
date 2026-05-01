<?php
// Include the checklogin.php file
include '../include/checklogin.php';


if (isset($_GET['assid'])) {

    $std_er = mysqli_real_escape_string($con, $_GET['assid']);
    $std_er = validate_data($std_er);
} else {
    $std_er = "";
}

if (isset($_POST['update'])) {
    extract($_POST);

    $subjectsNew = explode(",", $subject_code);
    $i = 0;
    // Loop through each subject
    foreach ($subjectsNew as $sbj) {
        // Insert the JSON data into the database
        $stmt = $con->prepare("UPDATE tbl_exam_results SET Mtheory = ? WHERE exam_id = ? AND enrollnment_no = ? AND subject_code = ? ");
        $stmt->bind_param("iiss", $newmark[$i],$exam_id, $er_no, $sbj);
        $result1 = $stmt->execute();
        $i++;
    }
    // Error handling if insertion fails
    if ($result1 == 1) {
        $_SESSION['status'] = "Mark Locked Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='view_assesment.php?exam_id=$exam_id&report_type='},100)</script>";
    } else {
        $_SESSION['status'] = "Marks Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_assesment.php?exam_id=$exam_id&report_type='},100)</script>";
    }
    exit;
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
                            <h1 class="m-0">Marks Updation</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Marks Updation</li>
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
                                    <h5><b><i class="fa fa-check-square-o"></i> Marks Updation</b></h5>
                                </center>
                            </span>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" class="form" method="post">
                                <table class="table table-bordered">
                                    <tbody class="tbody">
                                        <tr class="bg-dark">
                                            <th>Seat No</th>
                                            <th>Subject Code</th>
                                            <th>Barcode</th>
                                            <th>Old Marks</th>
                                            <th>New Marks</th>
                                        </tr>
                                        <?php
                                        $query = "SELECT id, enrollnment_no, status, is_pass, total_backlog , exam_sgpa, exam_cgpa, subject_code, assesment_type, exam_id FROM tbl_exam_reassement WHERE id = ?";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("i", $std_er);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $enrollnment_no = $row['enrollnment_no'];
                                            $id = $row['id'];
                                            $exam_id = $row['exam_id'];
                                            $exam_status = $row['is_pass'];
                                            $backlog = $row['total_backlog'];
                                            $subject_code = $row['subject_code'];
                                            $assesment_type = $row['assesment_type'];
                                        ?>
                                            <input type="hidden" name="subject_code" value="<?= $subject_code ?>">
                                            <input type="hidden" name="exam_id" value="<?= $exam_id ?>">
                                            <input type="hidden" name="er_no" value="<?= $enrollnment_no ?>">
                                            <?php
                                            // Split the string into an array using comma as the delimiter
                                            $subjects = explode(",", $subject_code);

                                            // Loop through each subject
                                            foreach ($subjects as $subject) {
                                                $query22 = "SELECT * FROM tbl_exam_results WHERE enrollnment_no = ? AND exam_id = ? AND subject_code = ?";
                                                $stmt22 = $con->prepare($query22);
                                                $stmt22->bind_param("iis", $enrollnment_no, $exam_id, $subject);
                                                $stmt22->execute();
                                                $result22 = $stmt22->get_result();

                                                while ($row22 = $result22->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?= $row22['seat_no'] ?></td>
                                                        <td><?= $row22['subject_code'] ?></td>
                                                        <td><?= $row22['barcode'] ?></td>
                                                        <td><?= $row22['Mtheory'] ?></td>
                                                        <td><input type="text" name="newmark[]" class="form-control" placeholder="Enter New Marks"></td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success" name="update"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
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