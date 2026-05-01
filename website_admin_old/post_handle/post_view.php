<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
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
                            <h1 class="m-0">View Posts</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Posts</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5><b><i class="fas fa-book"></i> View Posts</b></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a class="btn btn-primary mb-3" href="post_insert.php" style="float: right;"><i
                                        class="fa-solid fa-plus"></i> Add Post</a>
                                <table class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th>ID</th>
                                            <th>View</th>
                                            <th>File Type</th>
                                            <th>Field Name</th>
                                            <th>Date</th>
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT id, file, file_type, field_name, date FROM tbl_post WHERE is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $post_id = $row['id'];
                                            $file = $row['file'];
                                            $file_type = $row['file_type'];
                                            $field_name = $row['field_name'];
                                            $date = $row['date'];
                                            ?>
                                            <tr align="center">
                                                <td><?php echo $post_id; ?></td>
                                                <td>
                                                    <?php if ($file_type == "image") { ?>
                                                        <img src="../uploads/post/<?php echo $file; ?>" alt="Image"
                                                            style="height: 100px; width: 150px;">
                                                    <?php } else { ?>
                                                        <a href="<?php echo $file; ?>" target="_blank">View Video</a>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo ucfirst($file_type); ?></td>
                                                <td><?php echo str_replace('_', ' ', ucfirst($field_name)); ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td>
                                                    <a href="post_delete.php?post_id=<?php echo $post_id ?>"
                                                        class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <a href="post_edit.php?post_id=<?php echo $post_id ?>"
                                                        class="btn btn-danger"><i class="fas fa-edit"></i></a>

                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th>ID</th>
                                            <th>View</th>
                                            <th>File Type</th>
                                            <th>Field Name</th>
                                            <th>Date</th>
                                            <th>Manage</th>
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
    </div>
    <?php include '../include/importjs.php'; ?>
</body>

</html>