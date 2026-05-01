<?php
include '../include/checklogin.php';

// Fetch role & designation data
$query = "
    SELECT d.id, d.name AS designation_name, r.name AS role_name, d.is_active
    FROM tbl_designation d
    INNER JOIN tbl_career_role r ON r.id = d.role_id
    ORDER BY d.id ASC
";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <title>View Designation</title>
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
                        <h1 class="m-0">Designations</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Designations</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Designation List</h3>
                    </div>
                    <div class="card-body">

                        <a href="insert.php" class="btn btn-primary mb-3 float-right"><i class="fa fa-plus"></i> Add Designation</a>

                        <div class="table-responsive">
                            <table id="designationTable" class="dataTableLoad table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['role_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['designation_name']); ?></td>
                                        <td>
                                            <?php echo ($row['is_active'] == 1)
                                                ? '<span class="badge badge-success">Active</span>'
                                                : '<span class="badge badge-danger">Inactive</span>'; ?>
                                        </td>
                                        <td>
                                            <a href="edit_designation.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <!-- You can add delete functionality if needed -->
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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
