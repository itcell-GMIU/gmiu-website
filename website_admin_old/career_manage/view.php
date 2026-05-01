<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Soft delete: set is_active = 0 and is_delete = 1
    $deleteQuery = "UPDATE tbl_career_role SET is_active = 0, is_delete = 1 WHERE id = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Role soft deleted successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Failed to delete role";
        $_SESSION['status_code'] = "error";
    }

    echo "<script>window.location='view.php';</script>";
    exit;
}


// Fetch data from tbl_career
date_default_timezone_set("Asia/Kolkata");
$query = "SELECT r.id, r.name AS role_name, r.is_active as is_active FROM tbl_career_role r ORDER BY r.id ASC";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <title>View Career Post Role</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Career Post Role</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Career Post Role</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Career Post Role</h3>
                        </div>
                        <div class="card-body">

                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="insert.php"><i
                                    class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <!-- table-responsive -->
                            <div class="table-responsive"></div>
                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['role_name']; ?></td>
                                            <td>
                                                <?php echo ($row['is_active'] == 1) 
                                                    ? '<span class="badge badge-success">Active</span>' 
                                                    : '<span class="badge badge-danger">Inactive</span>'; ?>
                                            </td>
                                            <td>
                                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                        
                                                <?php if ($row['is_active'] == 1): ?>
                                                    <a href="view.php?delete_id=<?php echo $row['id']; ?>" 
                                                       class="btn btn-danger btn-sm delete-btn" 
                                                       data-id="<?php echo $row['id']; ?>">Delete</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                        <th scope="row" style="color:black;"><b>role</b></th>
                                        <th scope="row" style="color:black;"><b>Status</b></th>
                                        <th scope="row" style="color:black;"><b>Actions</b></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>

    <?php include '../include/importfooter.php'; ?>
    <?php include '../include/importjs.php'; ?>
</body>

</html>
<script>
    document.getElementById("applyFilter").addEventListener("click", function () {
        // Get the selected program filter value
        var programFilter = document.getElementById("programFilter").value;

        // Redirect to the current page with the program filter as a query parameter
        window.location.href = "staff_view.php?programFilter=" + programFilter;
    });
</script>