<?php
include '../include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if the request is a POST request
    if (isset($_POST['deleteDate'], $_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $con->prepare("UPDATE `tbl_inquiry_photos` SET is_delete = 1 , is_active = 0 WHERE id = ? and type ='call_doc' ");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        if ($result) {

            $_SESSION['status'] = "Calling Document Delete Successfully";
            $_SESSION['status_code'] = "success";

            echo "<script>setTimeout(function(){window.location='doc_view.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Calling Document Deletion Failed";
            $_SESSION['status_code'] = "error";

            echo "<script>setTimeout(function(){window.location='doc_view.php'},1000);</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Calling Document</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Calling Document</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Faculty list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Calling Document</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <?php if ($role_id == 12){ ?>
                            <a class="btn btn-primary" style="margin-left: 90%;" href="doc_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <?php } ?>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>File Name</b></th>
                                            <th scope="row" style="color:black;"><b>File Type</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Date</b></th> -->
                                            <?php if($role_id == 12) { ?> <th scope="row" style="color:black;"><b>Manage</b></th>  <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT id, file_type , file_name  FROM tbl_inquiry_photos WHERE is_delete = ? and type='call_doc' ");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        if ($result->num_rows >= 1) {

                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id'];
                                                $file_type = !empty($row['file_type']) ? $row['file_type'] : "<b>N/A</b>";
                                                $file_name = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";

                                        ?>
                                                <tr align="center">
                                                    <td scope="row">
                                                        <?php echo $id; ?>
                                                    </td>

                                                    <td scope="row">
                                                        <?php if ($file_type == "image") {
                                                        ?>
                                                            <a href='../uploads/call_script/<?php echo $file_name; ?>' target="_blank"><img src="../uploads/call_script/<?php echo $file_name ?>" alt="Calling Document" width="120px"></a>
                                                        <?php     } else { ?>
                                                            <a href='../uploads/call_script/<?php echo $file_name; ?>' target="_blank"><?php echo $file_name ?></a>

                                                        <?php   }
                                                        ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php echo $file_type; ?>
                                                    </td>

                                                <?php if($role_id == 12) { ?>
                                                    <td scope="row">
                                                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deletedoc<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i></button>
                                                    </td>
                                                <?php } ?>
                                                </tr>
                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deletedoc<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">Confirm Deletion</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Do you want to delete the data ?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!-- The delete form is now only inside the modal -->
                                                                <form action="doc_view.php" method="POST">
                                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                                                    <button type="submit" name="deleteDate" class="btn btn-danger">Delete</button>
                                                                </form>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php }
                                        } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>File Name</b></th>
                                            <th scope="row" style="color:black;"><b>File Type</b></th>
                                            <?php if($role_id == 12) { ?> <th scope="row" style="color:black;"><b>Manage</b></th>  <?php } ?>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>


                    </div>

                    <!-- /.card-body -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
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
</body>

</html>