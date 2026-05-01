<?php
include './include/config.php';
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
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>View Daily Task</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">View Daily Task</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <div class="dropdown">
                                <a class="btn btn-primary" href="dailytask-add.php">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h5 class="text-blue">Daily Task List</h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Task Date</th>
                                    <th>Time Slot</th>
                                    <th>Description</th>
                                    <th>File(s)</th>
                                    <?php if ($role_id == 12 || $role_id == 13 || $role_id == 16 || $role_id == 57 || $role_id == 59 || $role_id == 25) { ?>
                                        <th>Action</th><?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $status = 0;
                                $task_id = isset($_GET['task_id']) ? intval($_GET['task_id']) : null;

                                // Base query
                                $query = "SELECT id, task_date, time_slot, task_description FROM tbl_daily_task WHERE is_delete = ?";

                                // Modify query based on role_id and task_id
                                if ($task_id) {
                                    $query .= " AND id = ?";
                                } elseif ($role_id == 11 || $role_id == 22) {
                                    // Admin-level users: show all
                                    $query .= "";
                                } else {
                                    // Show only specific staff’s data
                                    $query .= " AND staff_id = ?";
                                }

                                $cmd = $con->prepare($query);
                                if ($task_id) {
                                    $cmd->bind_param("ii", $status, $task_id);
                                } elseif ($role_id == 11 || $role_id == 22) {
                                    $cmd->bind_param("i", $status);
                                } else {
                                    $cmd->bind_param("ii", $status, $staff_id);
                                }
                                $cmd->execute();
                                $result = $cmd->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $task_date = $row['task_date'];
                                    $time_slot = $row['time_slot'];
                                    $task_description = $row['task_description'];
                                    ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?= htmlspecialchars($task_date) ?></td>
                                        <td><?= htmlspecialchars($time_slot) ?></td>
                                        <td><?= htmlspecialchars($task_description) ?></td>
                                        <td>
                                            <?php
                                            $type = "dailytask_add";
                                            $photo_cmd = $con->prepare("SELECT file_name, file_type FROM tbl_inquiry_photos WHERE type = ? AND type_id = ?");
                                            $photo_cmd->bind_param("si", $type, $id);
                                            $photo_cmd->execute();
                                            $photo_result = $photo_cmd->get_result();

                                            if ($photo_result->num_rows > 0) {
                                                while ($photo = $photo_result->fetch_assoc()) {
                                                    $file_name = $photo['file_name'];
                                                    $file_type = $photo['file_type'];
                                                    $file_path = "uploads/task_images/" . $file_name;

                                                    if ($file_type === 'image') {
                                                        echo "<a href='$file_path' target='_blank'><img src='$file_path' style='width:80px; border-radius:6px; margin:5px;'></a>";
                                                    } else {
                                                        $ext = strtoupper(pathinfo($file_name, PATHINFO_EXTENSION));
                                                        echo "<a href='$file_path' target='_blank'>Download $ext</a><br>";
                                                    }
                                                }
                                            } else {
                                                echo "<span class='text-muted'>No files</span>";
                                            }
                                            ?>
                                        </td>
                                        <?php if ($role_id == 12 || $role_id == 13 || $role_id == 16 || $role_id == 57 || $role_id == 59 || $role_id == 25) { ?>
                                            <td>
                                                <a href="dailytask-edit.php?id=<?= $id ?>" class="btn btn-sm btn-info"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="dailytask-delete.php?id=<?= $id ?>" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this task?');"><i
                                                        class="fa fa-trash"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <!-- <script>
        $('document').ready(function () {
            $('.data-table').DataTable({
                scrollCollapse: true,
                autoWidth: false,
                responsive: true,
                columnDefs: [{ targets: "datatable-nosort", orderable: false }],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "info": "_START_-_END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },
                dom: '<"d-flex justify-content-between"lBf>rtip',
                buttons: ['copy', 'csv', 'pdf', 'print']
            });
        });
    </script> -->

    <script>
        $(document).ready(function () {
            var table = $('.data-table').DataTable({
                "dom": 'Blfrtip',
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>