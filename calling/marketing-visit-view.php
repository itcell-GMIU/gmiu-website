<?php
include './include/config.php';

/* ================= DELETE LOGIC (UNCHANGED) ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteDate'], $_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);

        $sql = 'UPDATE tbl_marketing_visit 
                SET is_delete = 1, is_active = 0 
                WHERE id = ?';

        $stmt = $con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                $_SESSION['status'] = "Record deleted successfully !!!";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = $stmt->error;
                $_SESSION['status_code'] = "error";
            }
            $stmt->close();
        } else {
            $_SESSION['status'] = $con->error;
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "Invalid ID.";
        $_SESSION['status_code'] = "error";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
</head>

<body>

    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>

    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">

            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Marketing Visit List</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Marketing Visit</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-md-6 col-sm-12 text-right">
                        <a href="marketing_visit_add.php" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add Marketing Visit
                        </a>
                    </div>
                </div>
            </div>

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="table-responsive">

                    <table class="dataTableLoad table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Date of Visit</th>
                                <th>Name of Person</th>
                                <th>Purpose</th>
                                <th>Point Of Discussion</th>
                                <th>Details</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $sql = "SELECT * FROM tbl_marketing_visit WHERE is_delete = 0 AND is_active = 1";

                            if ($role_id != 23 && $role_id != 11 && $role_id != 12) {
                                $sql .= " AND staff_id = ?";
                            }

                            $stmt = $con->prepare($sql);
                            if ($stmt) {
                                if ($role_id != 23 && $role_id != 11 && $role_id != 12) {
                                    $stmt->bind_param('i', $staff_id);
                                }
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['date_of_visit']) ?></td>
                                        <td><?= htmlspecialchars($row['name_of_person']) ?></td>
                                        <td><?= htmlspecialchars($row['purpose']) ?></td>
                                        <td><?= htmlspecialchars($row['point_discussion']) ?></td>

                                        <td>
                                            <a href="marketing-visit-details.php?id=<?= $row['id'] ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>

                                        <td>
                                            <a href="marketing-visit-edit.php?id=<?= $row['id'] ?>"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                data-target="#deleteModal<?= $row['id'] ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- DELETE MODAL -->
                                    <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    Delete visit for
                                                    <strong><?= htmlspecialchars($row['name_of_person']) ?></strong>
                                                    on
                                                    <strong><?= htmlspecialchars($row['date_of_visit']) ?></strong> ?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <button type="submit" name="deleteDate" class="btn btn-danger">
                                                            Delete
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php }
                            } ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Date of Visit</th>
                                <th>Name of Person</th>
                                <th>Purpose</th>
                                <th>Point Of Discussion</th>
                                <th>Details</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>
</body>

</html>