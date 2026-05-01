<?php include './include/checklogin.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pacid = $_POST['pacid']; // Ensure you have this field in your form
    $sql = "UPDATE tbl_pac_form SET is_active = 0, is_delete = 1  WHERE pacid = ?";

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $pacid); // Assuming pacid is an integer

        if ($stmt->execute()) {
            $_SESSION['status'] = "PAC Form Deleted Successfully !!!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "PAC form is Not Deleted Successfully !!!";
            $_SESSION['status_code'] = "error";
        }

        $stmt->close();
    } else {
        $_SESSION['status'] = "Something Went Wrong !!!";
        $_SESSION['status_code'] = "error";
    }
}
?>

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
                                <div class="card-header">
                                    <h3 class="card-title">PAC Form Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>PAC ID</th>
                                                <th>PAC Form No </th>
                                                <th>Student ID</th>
                                                <th>Student Name</th>
                                                <th>Program ID</th>
                                                <th>Level</th>
                                                <th>Student Email</th>
                                                <th>PAC REMARKS</th>
                                                <th>PAC Create Date</th>
                                                <th>PAC Edit Date</th>
                                                <th>View</th>
                                                <th>Edit</th>
                                                <!-- <th>Delete</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch data
                                            function convertToISTManual($utc_datetime) {
                                                        if (empty($utc_datetime) || $utc_datetime == '0000-00-00 00:00:00') {
                                                            return '-';
                                                        }
                                                        
                                                        $timestamp = strtotime($utc_datetime);
                                                        if ($timestamp === false) {
                                                            return '-';
                                                        }
                                                    
                                                        // Add IST offset (5 hours 30 mins)
                                                        $timestamp += (5 * 3600) + (30 * 60);
                                                    
                                                        return date('Y-m-d H:i:s', $timestamp);
                                                    }
                                            $sql = "SELECT * FROM tbl_pac_form WHERE is_active = 1 AND is_delete = 0";
                                            $result = $con->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($row['pacid']) . "</td>"; ?>
                                                    <td>
                                                        <?php
                                                            $formno = $row['formno'];
                                                            $pacid = $row['pacid'];
                                                    
                                                            if ($formno != $pacid) {
                                                                // formno is different → show it as-is
                                                                echo htmlspecialchars($formno);
                                                            } else {
                                                                // formno equals pacid → show formatted PACID
                                                                echo "2025 / " . str_pad(htmlspecialchars($pacid), 4, '0', STR_PAD_LEFT);
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php

                                                    echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";

                                                    echo "<td>" . htmlspecialchars($row['studentName']) . "</td>";
                                                    $result1 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        echo "<td>" . htmlspecialchars($row1['name']) . "</td>";
                                                    }
                                                    // echo "<td>" . htmlspecialchars($row['program_id']) . "</td>";
                                                    $result2 = $con->query("SELECT name FROM tbl_level WHERE id = " . $row['level_id']);
                                                    while ($row2 = $result2->fetch_assoc()){
                                                        echo "<td>" . htmlspecialchars($row2['name']) . "</td>";
                                                    }
                                                    echo "<td>" . htmlspecialchars($row['studentEmail']) . "</td>";
                                                    echo "<td>" . $row['remarks'] . "</td>";
                                                    
                                                    echo "<td>" . convertToISTManual($row['created_at']) . "</td>";
                                                    echo "<td>" . convertToISTManual($row['updated_at']) . "</td>";


                                                    // echo "<td>" . $row['created_at'] . "</td>";
                                                    // echo "<td>" . $row['updated_at'] . "</td>";
                                                    echo "<td><a href='show_pac.php?id=" . htmlspecialchars($row['pacid']) . "' target='_blank' class='btn btn-outline-primary'><i class='fa-solid fa-eye'></i></a></td>";
                                                    echo "<td><a href='edit_pac.php?id=" . htmlspecialchars($row['pacid']) . "' class='btn btn-outline-success'><i class='fa-solid fa-pen-to-square'></i></a></td>";
                                                    // echo "<td><button type='button' class='btn btn-outline-danger' data-toggle='modal' data-target='#deleteModal" . $row['pacid'] . "'><i class='fa-solid fa-trash'></i></button></td>";
                                                    ?>
                                                    <!-- Modal -->
                                                    <!-- <div class="modal fade" id="deleteModal<?php echo $row['pacid']; ?>"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete
                                                                        ???</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Do you want to Delete this data with the PACID
                                                                    <?php echo $row['pacid']; ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form method="POST">
                                                                        <input type="text" hidden
                                                                            value="<?php echo $row['pacid']; ?>" name="pacid">
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <?php
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='9'>No records found</td></tr>";
                                            }
                                            $con->close();
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>PAC ID</th>
                                                <th>PAC Form No </th>
                                                <th>Student ID</th>
                                                <th>Student Name</th>
                                                <th>Program ID</th>
                                                <th>Level</th>
                                                <th>Student Email</th>
                                                <th>PAC REMARKS</th>
                                                <th>PAC Create Date</th>
                                                <th>PAC Edit Date</th>
                                                <th>View</th>
                                                <th>Edit</th>
                                                <!-- <th>Delete</th> -->
                                            </tr>
                                        </tfoot>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- ./wrapper -->
 <?php include 'include/importjs.php'; ?>
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

   
</body>

</html>