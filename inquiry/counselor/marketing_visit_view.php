<?php
include '../include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if the request is a POST request
    if (isset($_POST['deleteDate'], $_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);
        $sql = 'UPDATE `tbl_marketing_visit` SET is_delete = 1, is_active = 0 WHERE id = ?';

        $stmt = $con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                $_SESSION['status'] = "Record deleted successfully !!!";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Error: " . $stmt->error;
                $_SESSION['status_code'] = "error";
            }
            $stmt->close();
        } else {
            $_SESSION['status'] = "Prepare Error: " . $con->error;
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "Invalid ID.";
        $_SESSION['status_code'] = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Marketing Visit Data</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Marketing Visit Data</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-tasks"></i> View Marketing Visit List</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="marketing_visit_add.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                             <div class="table-responsive">
                            <table class="dataTableLoad table table-bordered table-striped" >
                                <thead>
                                    <tr>
                                          <th scope="row" style="color:black;">Id</th>
                                        <th scope="row" style="color:black;">Date of Visit</th>
                                        <th scope="row" style="color:black;">Name of Person</th>
                                        <th scope="row" style="color:black;">Purpose</th>
                                         <th scope="row" style="color:black;">Point Of Discussion</th>
                                        <th scope="row" style="color:black;">Details</th>
                                        <th scope="row" style="color:black;">Update</th>
                                        <th scope="row" style="color:black;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = 'SELECT * FROM tbl_marketing_visit where is_delete = 0 ';

                                   if ($role_id != 23 && $role_id != 11 && $role_id != 12) {
                                     
                                        $sql .= ' AND staff_id = ?';
                                    }

                                    $stmt = $con->prepare($sql);
                                    if ($stmt) {
                                        if ($role_id != 23 && $role_id != 11 && $role_id != 12) {
                                            // Bind parameter for staff_id
                                            $stmt->bind_param('i', $staff_id);
                                        }
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result === false) {
                                            die('Error: ' . $con->error);
                                        }

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                             ?>
                                            <tr>
                                                 <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                <td scope="row"><?php echo htmlspecialchars($row['date_of_visit']); ?></td>
                                                <td scope="row"><?php echo htmlspecialchars($row['name_of_person']); ?></td>
                                                <td scope="row"><?php echo htmlspecialchars($row['purpose']); ?></td>
                                                <td scope="row"><?php echo htmlspecialchars($row['point_discussion']); ?></td>
                                                <td scope="row">
                                                    <a href="marketing_visit_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a></td>
                                                <td scope="row"><a href="marketing_visit_update.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                                <td scope="row">
                                                    <!-- Trigger the modal with the delete button -->
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deleteMarketingData<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteMarketingData<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Confirm Deletion</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Do you want to delete the data with Name: <strong><?php echo htmlspecialchars($row['name_of_person']); ?></strong> & Date of Visit: <strong><?php echo htmlspecialchars($row['date_of_visit']); ?></strong>?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <!-- The delete form is now only inside the modal -->
                                                            <form action="marketing_visit_view.php" method="POST">
                                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                                <button type="submit" name="deleteDate" class="btn btn-danger">Delete</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }
                                        }
                                                } ?>
                                </tbody>
                                    
                                <tfoot>
                                    <tr >
                                    <th scope="row" style="color:black;">Date of Visit</th>
                                                 <th scope="row" style="color:black;">Id</th>
                                                <th scope="row" style="color:black;">Name of Person</th>
                                                <th scope="row" style="color:black;">Purpose</th>
                                                   <th scope="row" style="color:black;">Point Of Discussion</th>
                                                <th scope="row" style="color:black;">Details</th>
                                                <th scope="row" style="color:black;">Update</th>
                                                <th scope="row" style="color:black;">Delete</th>
                                    </tr>
                                </tfoot>
                            </table>
                             </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
    <?php include '../include/importjs.php'; ?>



</body>

</html>