<?php
include '../include/checklogin.php';

if (isset($_GET['from_date']) && $_GET['from_date'] != "" && isset($_GET['to_date']) && $_GET['to_date'] != "") {
    /* $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id); */
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
} else {
    $from_date = "";
    $to_date = "";
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1 class="m-0">Payment History</h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Marks History</li>
                            </ol>
                        </div><!-- /.col -->
                    </div>

                </div>
            </div>
            <section class="content">
                <div class="card mb-3">
                    <div class="card-header">

                        <i class="far fa-hand-pointer"></i>

                        <span> <b>Select Date</b></span>

                    </div>
                    <form method="GET" action="">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-label-group">
                                            <label for="">From Date:</label>
                                            <input type="date" id="from_date" name="from_date" class="form-control" style="color:black; border-color:#325d88; border-width:1px" value="<?php echo isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-label-group">
                                            <label for="">To Date:</label>
                                            <input type="date" id="to_date" name="to_date" class="form-control" style="color:black; border-color:#325d88; border-width:1px" value="<?php echo isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="text-white">.</label>
                                        <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />
                                    </div>
                                    <!-- <?php

                                            //echo '<div class="col-md-4">
                                            //     <div class="form-label-group">

                                            //         <label for="">From Date :</label>
                                            //         <input type="date" id="from_date" name="from_date" class="form-control"
                                            //             style="color:black; border-color:#325d88; border-width:1px">


                                            //     </div>
                                            // </div>
                                            // <div class="col-md-4">
                                            //     <div class="form-label-group">

                                            //         <label for="">To Date :</label>
                                            //         <input type="date" id="to_date" name="to_date" class="form-control"
                                            //             style="color:black; border-color:#325d88; border-width:1px">


                                            //     </div>
                                            // </div>';


                                            ?> -->
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card">
                    <div class="card-header">
                        <p class="font-weight-bold m-0 p-0">Marks History</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="acedemic" class="dataTableLoad table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Subject Code</th>
                                        <th>Code</th>
                                        <th>Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cmd = "SELECT * FROM tbl_exam_results WHERE examinerID = $staff_id AND Mtheory IS NOT NULL ";

                                    if ($from_date != "" && $to_date != "") {
                                        $cmd .= " AND DATE(MtheoryTime) BETWEEN DATE(?) AND DATE(?)";
                                    }

                                    $cmd = $con->prepare($cmd);

                                    $cmd->execute();
                                    $result1 = $cmd->get_result();
                                    $in = 1;
                                    while ($row1 = $result1->fetch_assoc()) {
                                        // Status and payment status handling using switch statements...

                                        // Access exam form information from the left join
                                        // $session = $row1['session'];
                                        // $year = $row1['year'];
                                        // $program_id = $row1['program_id'];
                                        // $level_id = $row1['level_id'];
                                        // $faculty_id = $row1['faculty_id'];
                                        // $semester = $row1['semester'];

                                    ?>
                                        <tr>
                                            <td><?= $in  ?></td>
                                            <td><?= $row1['subject_code']  ?></td>
                                            <td><?= $row1['barcode']  ?></td>
                                            <td class="text-nowrap"><?= $row1['Mtheory'] ?></td>
                                        </tr>
                                    <?php
                                        $in++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>
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
    </script>

    <script>
        $(document).ready(function() {
            //call for listing the dropdown and select by default
            load_level();
            load_program();
        });

        function load_level() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $url_faculty_id; ?>;
            var level_id = <?php echo $url_level_id; ?>;
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
    </script>

</body>

</html>