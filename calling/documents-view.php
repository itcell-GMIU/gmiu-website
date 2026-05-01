<?php
include './include/config.php';

/* FETCH ONLY ACTIVE & NOT DELETED DOCUMENTS */
$sql = "SELECT * 
        FROM tbl_inquiry_documents
        WHERE is_active = 1
          AND is_delete = 0
        ORDER BY id DESC";

$result = mysqli_query($con, $sql);

/* -----------------------------------
   HANDLE ACTIONS (DELETE / DEACTIVATE)
------------------------------------ */
if (isset($_GET['action'], $_GET['id']) && is_numeric($_GET['id'] && ($role_id == 60 || $role_id == 11))) {

    $id = (int) $_GET['id'];

    if ($role_id == 60) {
        if ($_GET['action'] === 'delete') {

            /* 1️⃣ Fetch file path & type first */
            $fetchSql = "SELECT file, file_type 
                 FROM tbl_inquiry_documents 
                 WHERE id = $id 
                   AND is_delete = 0";

            $fetchRes = mysqli_query($con, $fetchSql);

            if ($fetchRes && mysqli_num_rows($fetchRes) === 1) {

                $doc = mysqli_fetch_assoc($fetchRes);

                /* 2️⃣ Remove physical file (only for image/file, NOT url) */
                if (in_array($doc['file_type'], ['image', 'file'])) {

                    $filePath = $doc['file'];

                    if ($filePath && file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                /* 3️⃣ Hard delete in DB */
                $sql = "DELETE FROM tbl_inquiry_documents WHERE id = $id";

                if (mysqli_query($con, $sql)) {
                    $_SESSION['status'] = 'Document deleted successfully';
                    $_SESSION['status_code'] = 'success';
                    $_SESSION['status_redirect'] = 'documents-view.php';
                } else {
                    $_SESSION['status'] = 'Failed to delete document';
                    $_SESSION['status_code'] = 'error';
                    $_SESSION['status_redirect'] = 'documents-view.php';
                }

            } else {
                $_SESSION['status'] = 'Document not found or already deleted';
                $_SESSION['status_code'] = 'error';
                $_SESSION['status_redirect'] = 'documents-view.php';
            }
        }
    } else {
        $_SESSION['status'] = 'You do not have permission to perform this action';
        $_SESSION['status_code'] = 'error';
        $_SESSION['status_redirect'] = 'documents-view.php';
    }

    if ($_GET['action'] === 'deactivate') {
        // DEACTIVATE ONLY
        $sql = "UPDATE tbl_inquiry_documents
                SET is_active = 0, is_delete = 1
                WHERE id = $id AND is_delete = 0";

        if (mysqli_query($con, $sql)) {
            $_SESSION['status'] = 'Document deactivated successfully';
            $_SESSION['status_code'] = 'success';
            $_SESSION['status_redirect'] = 'documents-view.php';
        } else {
            $_SESSION['status'] = 'Failed to deactivate document';
            $_SESSION['status_code'] = 'error';
            $_SESSION['status_redirect'] = 'documents-view.php';
        }

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
            <div class="min-height-200px">

                <!-- PAGE HEADER -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>View Documents</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        View Documents
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Title</th>
                                    <th>Document</th>
                                    <th>Type</th>
                                    <?php if ($role_id == 60 || $role_id == 11) { ?>
                                        <th width="25%">Actions</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (mysqli_num_rows($result) > 0) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>

                                            <td><?= htmlspecialchars($row['title']); ?></td>

                                            <td>
                                                <?php if ($row['file_type'] === 'url') { ?>
                                                    <a href="<?= htmlspecialchars($row['file']); ?>" target="_blank">
                                                        Open URL
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="<?= htmlspecialchars($row['file']); ?>" target="_blank">
                                                        View File
                                                    </a>
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <span class="badge badge-info">
                                                    <?= ucfirst($row['file_type']); ?>
                                                </span>
                                            </td>

                                            <?php if ($role_id == 60 || $role_id == 11) { ?>
                                                <td>
                                                    <!-- DEACTIVATE -->
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning btn-deactivate"
                                                        data-id="<?= $row['id']; ?>">
                                                        Deactivate
                                                    </a>

                                                    <?php if ($role_id == 60) { ?>
                                                        <!-- DELETE -->
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete"
                                                            data-id="<?= $row['id']; ?>">
                                                            Delete
                                                        </a>
                                                        <?php } ?>
                                                </td>
                                            <?php } ?>

                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No documents found
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
    <script>
        $(function () {

            /* ===============================
               DELETE CONFIRMATION
            ================================ */
            $('.btn-delete').click(function (e) {
                e.preventDefault();

                let docId = $(this).data('id');

                swal({
                    title: 'Are you sure?',
                    text: 'This document will be permanently deleted!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-danger margin-5',
                    cancelButtonClass: 'btn btn-secondary margin-5',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel',
                    buttonsStyling: false
                }).then(function (result) {

                    if (result.value) {
                        // redirect after confirmation
                        window.location.href =
                            'documents-view.php?action=delete&id=' + docId;
                    } else if (result.dismiss === 'cancel') {
                        swal(
                            'Cancelled',
                            'Your document is safe 🙂',
                            'error'
                        );
                    }
                });
            });

            /* ===============================
               DEACTIVATE CONFIRMATION
            ================================ */
            $('.btn-deactivate').click(function (e) {
                e.preventDefault();

                let docId = $(this).data('id');

                swal({
                    title: 'Deactivate document?',
                    text: 'This document will be hidden but not deleted.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-warning margin-5',
                    cancelButtonClass: 'btn btn-secondary margin-5',
                    confirmButtonText: 'Yes, deactivate',
                    cancelButtonText: 'No, cancel',
                    buttonsStyling: false
                }).then(function (result) {

                    if (result.value) {
                        window.location.href =
                            'documents-view.php?action=deactivate&id=' + docId;
                    } else if (result.dismiss === 'cancel') {
                        swal(
                            'Cancelled',
                            'Document is still active 🙂',
                            'error'
                        );
                    }
                });
            });

        });
    </script>

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

<!-- jtti metl uguy nahe -->