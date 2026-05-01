<?php
include './include/config.php';

/* ---------------------------------------
   FETCH CATEGORIES
---------------------------------------- */
$categoryResult = $con->query("SELECT id, title FROM gallery_images_category WHERE is_active = 1 AND is_delete = 0 ORDER BY title ASC");

/* ---------------------------------------
   MULTIPLE IMAGE UPLOAD HANDLING
---------------------------------------- */
if (isset($_POST['submit'])) {

    $category = intval($_POST['category']);
    $altBase  = trim($_POST['alt_keyword']);
    $ac_level_id = intval($_POST['ac_level_id']);
    $ed_level_id = intval($_POST['ed_level_id']);
    $branch_id = isset($_POST['branch_id']) ? $_POST['branch_id'] : [];
    $branch_id_csv = implode(",", $branch_id);
    $files    = $_FILES['images'];

    $totalFiles = count($files['name']);

    /* Maximum 10 images allowed */
    if ($totalFiles > 10) {
        $_SESSION['status'] = "You can upload maximum 10 images at once!";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_redirect'] = "upload-images.php";
    } else {

        /* Check total size (max 2500 KB) */
        $totalSizeKB = 0;
        for ($i = 0; $i < $totalFiles; $i++) {
            $totalSizeKB += ($files['size'][$i] / 1024);
        }

        if ($totalSizeKB > 2500) {
            $_SESSION['status'] = "Total upload size must be less than 2500 KB!";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_redirect'] = "upload-images.php";
        } else {

            $uploadDir = "uploads/gallery/";

            for ($i = 0; $i < $totalFiles; $i++) {

                $imgName = $files['name'][$i];
                $tmpName = $files['tmp_name'][$i];

                if ($imgName == "") continue;

                /* Unique file name */
                $newName = time() . "_" . rand(1000, 9999) . "_" . $imgName;

                /* Upload image */
                move_uploaded_file($tmpName, $uploadDir . $newName);

                /* Auto Alt Text Numbering */
                $finalAlt = $altBase !== "" ? $altBase . " " . ($i + 1) : "";

                /* Insert to DB */
                $stmt = $con->prepare("INSERT INTO gallery_images (ac_level_id, ed_level_id, branch_id, category, image, alt_keyword) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iisiss", $ac_level_id, $ed_level_id, $branch_id_csv, $category, $newName, $finalAlt);
                $stmt->execute();
                $stmt->close();
            }

            $_SESSION['status'] = "Images Uploaded Successfully!";
            $_SESSION['status_code'] = "success";
            $_SESSION['status_redirect'] = "upload-images.php";
        }
    }
}

/* ---------------------------------------
   FILTER HANDLING
---------------------------------------- */
$filterCategory = isset($_GET['filter_category']) ? intval($_GET['filter_category']) : 0;

if ($filterCategory > 0) {
    $imgQuery = "SELECT gi.*, gc.title AS category_name 
                 FROM gallery_images gi
                 LEFT JOIN gallery_images_category gc ON gc.id = gi.category
                 WHERE gi.category = $filterCategory AND gi.is_active = 1 AND gi.is_delete = 0
                 ORDER BY gi.id DESC";
} else {
    $imgQuery = "SELECT gi.*, gc.title AS category_name 
                 FROM gallery_images gi
                 LEFT JOIN gallery_images_category gc ON gc.id = gi.category
                 WHERE gi.is_active = 1 AND gi.is_delete = 0
                 ORDER BY gi.id DESC";
}

$imageResult = $con->query($imgQuery);

/* ---------------------------------------
   DELETE IMAGE (Soft Delete + Remove File)
---------------------------------------- */
if (isset($_GET['delete_image'])) {
    $id = intval($_GET['delete_image']);

    // Fetch image name
    $stmt = $con->prepare("SELECT image FROM gallery_images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $imgData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($imgData) {
        $filePath = "uploads/gallery/" . $imgData['image'];

        // Remove file from folder
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Soft delete (update flags)
        $stmt2 = $con->prepare("UPDATE gallery_images SET is_active = 0, is_delete = 1 WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        $_SESSION['status'] = "Image deleted successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_redirect'] = "upload-images.php";
    }
}

// Handle Edit Prefill
$editData = null;

?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
    <style>
        #preview-container img {
            height: 120px;
            width: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 2px;
        }
    </style>
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
                                <h4>Manage Gallery Images</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Gallery Images</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- UPLOAD FORM -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20">Upload Gallery Images</h5>

                    <form method="POST" enctype="multipart/form-data">

                     <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Academic Level</label>
                                <select id="ac_level_id" name="ac_level_id" class="form-control">
                                    <option value="">Select Academic Level</option>
                                    <?php
                                    $ac_result = $con->query("SELECT id, name FROM gallery_academic_level WHERE is_active = 1 AND is_delete = 0 ORDER BY name ASC");
                                    while ($ac = $ac_result->fetch_assoc()):
                                        ?>
                                        <option value="<?= $ac['id'] ?>"><?= htmlspecialchars($ac['name']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Education Level</label>
                                <select id="ed_level_id" name="ed_level_id" class="form-control">
                                    <option value="">Select Education Level</option>
                                </select>
                            </div>
                            </div>
                              <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select class="form-control myMultiSelect" name="branch_id[]" id="branch_id" multiple>
                                        <option value="">-- Select Branch --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <!-- CATEGORY -->
                            <div class="col-md-4 mb-3">
                                <label>Category <span style="color:red">*</span></label>
                                <select name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php while ($cat = $categoryResult->fetch_assoc()): ?>
                                        <option value="<?php echo $cat['id']; ?>">
                                            <?php echo htmlspecialchars($cat['title']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- ALT TEXT -->
                            <div class="col-md-4 mb-3">
                                <label>Alt Text (Base) <span style="color:red">*</span></label>
                                <input type="text" name="alt_keyword" class="form-control"
                                       placeholder="Eg: Campus Image" required>
                            </div>

                            <!-- MULTIPLE IMAGES -->
                            <div class="col-md-4 mb-3">
                                <label>Select Images (Max 10, Total 2500 KB)</label>
                                <input type="file" name="images[]" id="image-input" class="form-control" multiple required>

                                <!-- LIVE PREVIEW -->
                                <div id="preview-container" class="mt-3" style="display:flex; flex-wrap:wrap; gap:10px;"></div>
                            </div>

                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Upload Images</button>
                    </form>
                </div>

                <!-- FILTER SECTION -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20">Filter Images</h5>

                    <form method="GET">
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label>Category</label>
                                <select name="filter_category" class="form-control">
                                    <option value="0">All Categories</option>

                                    <?php
                                    $categoryResult2 = $con->query("SELECT id, title FROM gallery_images_category WHERE is_active = 1 AND is_delete = 0 ORDER BY title ASC");
                                    while ($fc = $categoryResult2->fetch_assoc()):
                                    ?>
                                        <option value="<?php echo $fc['id']; ?>" 
                                            <?php if ($filterCategory == $fc['id']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($fc['title']); ?>
                                        </option>
                                    <?php endwhile; ?>

                                </select>
                            </div>

                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button class="btn btn-primary">Submit</button>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- IMAGE LIST TABLE -->
                <div class="pd-20 bg-white border-radius-4 box-shadow">
                    <h5 class="mb-20">Images List</h5>

                    <div class="table-responsive table-sm">
                        <table class="data-table table-striped table-hover nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Category</th>
                                    <th width="30%">Image</th>
                                    <th width="25%">Alt Text</th>
                                    <th width="15%">Status</th>
                                    <th width="15%">Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php if ($imageResult && $imageResult->num_rows > 0): ?>
                                    <?php while ($img = $imageResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $img['id']; ?></td>

                                            <td><?php echo htmlspecialchars($img['category_name']); ?></td>

                                            <td>
                                                <img src="uploads/gallery/<?php echo $img['image']; ?>"
                                                     style="height: 80px; border-radius: 5px;">
                                            </td>

                                            <td><?php echo htmlspecialchars($img['alt_keyword']); ?></td>

                                            <td>
                                                <?php if ($img['is_active'] == 1 && $img['is_delete'] == 0): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($img['is_active'] == 1 && $img['is_delete'] == 0): ?>
                                                    <a href="?delete_image=<?php echo $img['id']; ?>" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this image? This will remove file permanently!');">
                                                        Delete
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Deleted</span>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php endwhile; ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No images found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <!-- RUNTIME IMAGE PREVIEW SCRIPT -->
    <script>
        document.getElementById("image-input").addEventListener("change", function (event) {
            const container = document.getElementById("preview-container");
            container.innerHTML = ""; // Clear previous

            const files = event.target.files;

            if (files.length > 10) {
                alert("You can upload a maximum of 10 images!");
                event.target.value = "";
                return;
            }

            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                if (!file.type.startsWith("image/")) continue;

                let reader = new FileReader();
                reader.onload = function (e) {
                    let img = document.createElement("img");
                    img.src = e.target.result;
                    container.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.data-table').DataTable({
                scrollX: true,          // ✅ Enables horizontal scrolling
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,      // ✅ Turn off collapsing mode for full control
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "info": "_START_-_END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },
                dom: '<"d-flex justify-content-between"lBf>rtip',
                buttons: [
                    'copy', 'csv', 'pdf', 'print'
                ]
            });
        });
    </script>

        <script>
        // ✅ Function to load education levels dynamically
        function load_level(acId, selectedEduId = '') {
            const eduSelect = document.getElementById('ed_level_id');
            eduSelect.innerHTML = '<option value="">Loading...</option>';

            if (!acId) {
                eduSelect.innerHTML = '<option value="">Select Education Level</option>';
                return;
            }

            fetch(`./extra/get_education_level.php?ac_level_id=${acId}`)
                .then(res => res.text())
                .then(optionsHTML => {
                    eduSelect.innerHTML = optionsHTML;

                    // ✅ Preselect when in edit mode
                    if (selectedEduId) {
                        eduSelect.value = selectedEduId;
                    }
                })
                .catch(() => {
                    eduSelect.innerHTML = '<option value="">Error Loading Data</option>';
                });
        }

        // ✅ Trigger when user manually changes Academic Level
        document.getElementById('ac_level_id').addEventListener('change', function () {
            load_level(this.value);
        });


        // ✅ Function to load education levels dynamically
        function load_branch(acId, edId, selectedBranch = '') {
            const branchSelect = document.getElementById('branch_id');
            branchSelect.innerHTML = '<option value="">Loading...</option>';

            if (!acId || !edId) {
                branchSelect.innerHTML = '<option value="">Select Branch</option>';
                return;
            }

            fetch(`./extra/get_branch.php?ac_level_id=${acId}&ed_level_id=${edId}`)
                .then(res => res.text())
                .then(optionsHTML => {
                    branchSelect.innerHTML = optionsHTML;

                    // ✅ Preselect when in edit mode
                    if (selectedBranch) {
                        branchSelect.value = selectedBranch;
                    }
                })
                .catch(() => {
                    branchSelect.innerHTML = '<option value="">Error Loading Data</option>';
                });
        }

        // ✅ Trigger when user manually changes Academic Level
        document.getElementById('ed_level_id').addEventListener('change', function () {
            const acId = document.getElementById('ac_level_id').value;
            load_branch(acId, this.value);
        });

        // ✅ Auto-run on edit (prefill mode)
        <?php if ($editData): ?>
                document.addEventListener("DOMContentLoaded", function () {
                    const existingAc = "<?php echo $editData['ac_level_id']; ?>";
                    const existingEd = "<?php echo $editData['ed_level_id']; ?>";
                    const existingBranch = "<?php echo $editData['branch_id']; ?>";

                    // Set academic level dropdown
                    document.getElementById('ac_level_id').value = existingAc;

                    // Load education levels and preselect the right one
                    load_level(existingAc, existingEd);
                    load_branch(existingAc, existingEd, existingBranch);
                });
            <?php endif; ?>
        </script>

        <script>
           $(document).ready(function () {
                $('.myMultiSelect').select2({
                    placeholder: "Select options",
                    allowClear: true
                });
            });
        </script>
</body>

</html>
