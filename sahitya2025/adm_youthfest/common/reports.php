<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- /.login-logo -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div>
    </div>
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
                            <h1 class="m-0">Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Reports</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <?php
                    if ($role_id == 1) {
                    ?>
                        <div class="card card-gmiu m-0">
                            <div class="card-header">
                                <div class="card-title">
                                    YOUTHFEST REGISTRATIONS REPORTS
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="comp-filter">Filter by Competition:</label>
                                        <select id="comp-filter" class="form-control text-uppercase">
                                            <option value="">All</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="acedemic1" class="dataTableLoad table table-bordered table-striped table-responsive">
                                        <thead>
                                            <tr align="center">
                                                <th>Sr.No.</th>
                                                <th>Name</th>
                                                <th>Competitions</th>
                                                <th>Contact No.</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th>Payment Status</th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 1;
                                            $cmd2 = $con->prepare("SELECT * FROM `tbl_participants` WHERE `is_active` = ?");
                                            $cmd2->bind_param("i", $status);
                                            $cmd2->execute();
                                            $result2 = $cmd2->get_result();
                                            $in = 1;
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $id = $row2['user_id'];
                                                $compid = $row2['competition_id'];
                                                $getUserDetail = array("is_active" => 1, "id" => $id);
                                                $recUser = $crud->readRecordsWithConditions("tbl_registers", $getUserDetail);
                                                if (is_array($recUser)) {
                                                    foreach ($recUser as $user) {
                                                        $crud->readSingleRecordColumn("tbl_competetion", "name", ["id" => $compid, "is_active" => 1], $compname);
                                            ?>
                                                        <tr>
                                                            <td><?= $in ?></td>
                                                            <td><?= $user['name'] ?></td>
                                                            <td class="text-nowrap text-left"><?= $compname ?></td>
                                                            <td><?= $user['mobile'] ?></td>
                                                            <td><?= $user['email'] ?></td>
                                                            <td><?= $user['deptname'] ?></td>
                                                            <td><?= $user['payment_status'] ?></td>
                                                            <td><?= $user['payment_date'] ?></td>
                                                        </tr>
                                            <?php
                                                        $in++;
                                                    }
                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>

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
    <script>
        $(document).ready(function() {
            var table = $('#acedemic1').DataTable();

            // Function to add dropdown filter for a specific column
            function addDropdownFilter(columnIndex, selectId) {
                table.column(columnIndex).data().unique().sort().each(function(value, index) {
                    $('#' + selectId).append('<option value="' + value + '">' + value + '</option>');
                });

                // Set the previous value if it exists in localStorage
                var storedValue = localStorage.getItem(selectId);
                if (storedValue) {
                    $('#' + selectId).val(storedValue);
                    table.column(columnIndex).search(storedValue).draw();
                }

                $('#' + selectId).on('change', function() {
                    var selectedValue = $(this).val();
                    localStorage.setItem(selectId, selectedValue); // Store the selected value
                    table.column(columnIndex).search(selectedValue).draw();
                });
            }

            // Call the function for each filter
            addDropdownFilter(2, 'comp-filter');
        });
    </script>
</body>

</html>