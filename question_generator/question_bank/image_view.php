<?php
include '../include/checklogin.php';

// Fetch all uploaded images
$query = $con->prepare("SELECT id, file_name, file_url FROM tbl_question_images ORDER BY uploaded_at DESC");
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Uploaded Images</title>
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
                            <h1 class="m-0">View Uploaded Images</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Upload Images</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-gmiu">
                        <div class="card-header">
                            <h3 class="card-title">Uploaded Images List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="imageTable" class="dataTableLoad table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Preview</th>
                                            <th>File Name</th>
                                            <th>Image Tag For CSV(Click to Copy)</th>
                                            <th>Image Tag For Edit(Click to Copy)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sr = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            $imgTag = "<img>" . htmlspecialchars($row['file_name']) . "</img>";
                                        ?>
                                            <tr>
                                                <td><?= $sr++ ?></td>
                                                <td>
                                                    <img src="<?= $row['file_url'] ?>"
                                                        style="width:80px;height:auto;border:1px solid #ccc;border-radius:5px;cursor:pointer;"
                                                        onclick="showImageModal('<?= $row['file_url'] ?>')">

                                                </td>
                                                <td><?= $row['file_name'] ?></td>
                                                <td>
                                                    <input type="text" class="form-control text-center copyText" value="<?= $imgTag ?>" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control text-center copyText" 
                                                           value="<?= 'https://gmiu.edu.in/gmiu/question_generator/question_bank/uploads/' . $row['file_name'] ?>" readonly>
                                                </td>

                                            </tr>
                                        <?php } ?>
                                        <?php if ($sr === 1) { ?>
                                            <tr>
                                                <td colspan="4" class="text-center"><b>No images uploaded yet.</b></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Preview</th>
                                            <th>File Name</th>
                                             <th>Image Tag For CSV(Click to Copy)</th>
                                            <th>Image Tag For Edit(Click to Copy)</th>
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

    <script>
        document.querySelectorAll('.copyText').forEach(input => {
            input.addEventListener('click', function() {
                this.select();
                document.execCommand("copy");
                alert("✅ Copied: " + this.value);
            });
        });
    </script>
    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" style="width:100%;height:auto;border-radius:5px;">
                </div>
            </div>
        </div>
    </div>
    <script>
        function showImageModal(url) {
            document.getElementById("modalImage").src = url;
            $('#imageModal').modal('show');
        }
    </script>

</body>

</html>