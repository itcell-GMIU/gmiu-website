<?php include './include/checklogin.php'; ?>
<?php $id = $_GET['id']; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">



        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View All Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View All Details</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">PAC Form Details</h3>
                                    <div class="d-flex ml-auto">
                                        <a href="pac_print.php?id=<?php echo $id; ?>"
                                            class="btn btn-sm btn-primary mr-1">Print</a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch data
                                            $sql = "SELECT * FROM tbl_pac_form WHERE pacid = $id";
                                            $result = $con->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr><td>Student Name</td><td>" . htmlspecialchars($row['studentName']) . "</td></tr>";
                                                    echo "<tr><td>Mobile Number (Student)</td><td>" . htmlspecialchars($row['studentMobile']) . "</td></tr>";
                                                    echo "<tr><td>Student Email ID</td><td>" . htmlspecialchars($row['studentEmail']) . "</td></tr>";
                                                    echo "<tr><td>WhatsApp Number</td><td>" . htmlspecialchars($row['whatsappNumber']) . "</td></tr>";
                                                    echo "<tr><td>Mobile Number (Parents)</td><td>" . htmlspecialchars($row['parentMobile']) . "</td></tr>";
                                                    echo "<tr><td>Mode</td><td>" . htmlspecialchars($row['mode']) . "</td></tr>";
                                                    $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = " . $row['faculty_id']);
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        echo "<tr><td>Select Faculty</td><td>" . $row1['name'] . "</td></tr>";
                                                    }
                                                    $result2 = $con->query("SELECT name FROM tbl_level WHERE id = " . $row['level_id']);
                                                    while ($row2 = $result2->fetch_assoc()) {
                                                        echo "<tr><td>Select Level</td><td>" . $row2['name'] . "</td></tr>";
                                                    }
                                                    $result3 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                                    while ($row3 = $result3->fetch_assoc()) {
                                                        echo "<tr><td>Select Program</td><td>" . $row3['name'] . "</td></tr>";
                                                    }
                                                    echo "<tr><td>Admission Type</td><td>" . (!empty($row['admissionType']) ? htmlspecialchars(str_replace(",", ", ", $row['admissionType'])) : "N/A") . "</td></tr>";
                                                    echo "<tr><td>Branch / Specialization</td><td>" . htmlspecialchars($row['branchSpecialization']) . "</td></tr>";
                                                    echo "<tr><td>Quota</td><td>" . htmlspecialchars($row['quota']) . "</td></tr>";
                                                    echo "<tr><td>Category</td><td>" . htmlspecialchars($row['category']) . "</td></tr>";
                                                    echo "<tr><td>Date of Provisional Admitted</td><td>" . htmlspecialchars($row['dateProvisional']) . "</td></tr>";
                                                    echo "<tr><td>Date of Admission</td><td>" . htmlspecialchars($row['dateAdmission']) . "</td></tr>";
                                                    echo "<tr><td>CBPA Status</td><td>" . htmlspecialchars($row['cbpaStatus']) . "</td></tr>";
                                                    echo "<tr><td>Token Fees Amount</td><td>" . htmlspecialchars($row['tokenFeesAmount']) . "</td></tr>";
                                                    echo "<tr><td>Token Fees Paid Date</td><td>" . htmlspecialchars($row['tokenFeesPaidDate']) . "</td></tr>";
                                                    echo "<tr><td>Remaining Semester Fees</td><td>" . htmlspecialchars($row['remainingFees']) . "</td></tr>";
                                                    echo "<tr><td>Remaining Semester Fees Pay Date</td><td>" . htmlspecialchars($row['remainingPayDate']) . "</td></tr>";
                                                    echo "<tr><td>Photo Submitted Status</td><td>" . htmlspecialchars($row['photoStatus']) . "</td></tr>";
                                                    echo "<tr><td>One Time Scholarship</td><td>" . htmlspecialchars($row['one_time_scholarship']) . "</td></tr>";
                                                    echo "<tr><td>Mode of Payment</td><td>" . htmlspecialchars($row['mode_of_payment']) . "</td></tr>";
                                                    echo "<tr><td>T-Shirt Size</td><td>" . htmlspecialchars($row['tshirt_size']) . "</td></tr>";
                                                    echo "<tr><td>Remarks</td><td>" . htmlspecialchars($row['remarks']) . "</td></tr>";
                                                    echo "<tr><td>Level</td><td>" . (!empty($row['level2']) ? htmlspecialchars(str_replace(",", ", ", $row['level2'])) : "N/A") . "</td></tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='2'>No records found</td></tr>";
                                            }
                                            $con->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- ./wrapper -->

        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <?php include 'include/importjs.php'; ?>
</body>

</html>