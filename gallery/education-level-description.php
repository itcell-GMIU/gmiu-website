<?php
include './include/config.php';

// Fetch Academic Levels for Dropdown
$acLevels = $con->query("SELECT id, name FROM gallery_academic_level WHERE is_delete = 0 AND is_active = 1 ORDER BY name ASC");

// Fetch Education Levels for Dropdown
$edLevels = $con->query("SELECT id, name FROM gallery_education_level WHERE is_delete = 0 AND is_active = 1 ORDER BY name ASC");

// Handle Add or Update
if (isset($_POST['submit'])) {
    $ac_level_id = (int) $_POST['ac_level_id'];
    $ed_level_id = (int) $_POST['ed_level_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    // Handle Image Upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/education-img/" . $image);
    }

    if ($title !== '' && $ac_level_id > 0 && $ed_level_id > 0) {
        if ($id > 0) {
            // Update existing
            $query = "UPDATE gallery_education_level_description 
                      SET ac_level_id=?, ed_level_id=?, title=?, description=?, 
                          updated_at=NOW()" . ($image ? ", image=?" : "") . " WHERE id=?";
            $types = $image ? "iisssi" : "iissi";
            $params = $image
                ? [$ac_level_id, $ed_level_id, $title, $description, $image, $id]
                : [$ac_level_id, $ed_level_id, $title, $description, $id];
            $action = "Updated";
        } else {
            // Insert new
            $query = "INSERT INTO gallery_education_level_description 
                      (ac_level_id, ed_level_id, title, description, image) 
                      VALUES (?, ?, ?, ?, ?)";
            $types = "iisss";
            $params = [$ac_level_id, $ed_level_id, $title, $description, $image];
            $action = "Added";
        }

        $stmt = $con->prepare($query);
        $stmt->bind_param($types, ...$params);
        $success = $stmt->execute();
        $stmt->close();

        $_SESSION['status'] = $success ? "Record {$action} Successfully" : "{$action} Failed";
        $_SESSION['status_code'] = $success ? "success" : "error";
        $_SESSION['status_redirect'] = "education-level-description.php";
    }
}

// Handle Edit Prefill
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $stmt = $con->prepare("SELECT * FROM gallery_education_level_description WHERE id=? AND is_delete=0");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Handle Soft Delete / Activate
if (isset($_GET['delete'], $_GET['status'])) {
    $id = (int) $_GET['delete'];
    $status = (int) $_GET['status'];
    $isActive = $status === 1 ? 1 : 0;
    $isDelete = $status === 1 ? 0 : 1;
    $action = $status === 1 ? "Activated" : "Deactivated";

    $stmt = $con->prepare("UPDATE gallery_education_level_description SET is_active=?, is_delete=? WHERE id=?");
    $stmt->bind_param("iii", $isActive, $isDelete, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['status'] = "Record {$action} Successfully";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "education-level-description.php";
}

// Fetch All Records
$query = "SELECT d.*, 
          ac.name AS academic_name, 
          ed.name AS education_name 
          FROM gallery_education_level_description d
          LEFT JOIN gallery_academic_level ac ON d.ac_level_id = ac.id
          LEFT JOIN gallery_education_level ed ON d.ed_level_id = ed.id
          ORDER BY d.id DESC";
$result = $con->query($query);
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
                                <h4>Education Level Description</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Education Level Description
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- FORM SECTION -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20">
                        <?php echo $editData ? "Edit Description" : "Add New Description"; ?>
                    </h5>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Academic Level <span class="text-danger">*</span></label>
                                <select id="ac_level_id" name="ac_level_id" class="form-control" required>
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
                                <label>Education Level <span class="text-danger">*</span></label>
                                <select id="ed_level_id" name="ed_level_id" class="form-control" required>
                                    <option value="">Select Education Level</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                    value="<?php echo htmlspecialchars($editData['title'] ?? ''); ?>" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control" rows="6"
                                    placeholder="Enter Description">
                                    <?php echo htmlspecialchars($editData['description'] ?? ''); ?>
                                </textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control">
                                <?php if (!empty($editData['image'])): ?>
                                    <img src="uploads/education-img/<?php echo $editData['image']; ?>" class="mt-2"
                                        width="100" height="70">
                                <?php endif; ?>
                            </div>

                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">
                            <?php echo $editData ? "Update" : "Add"; ?>
                        </button>
                        <?php if ($editData): ?>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary ml-2">Cancel</a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- TABLE SECTION -->
                <div class="pd-20 bg-white border-radius-4 box-shadow">
                    <h5 class="mb-20">Description List</h5>
                    <div class="table-responsive table-sm">
                        <table class="data-table table-striped table-hover nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Academic</th>
                                    <th>Education</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['academic_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['education_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                                            <td>
                                                <?php
                                                $desc = $row['description'];
                                                if (preg_match('/<\s*(ul|li)\b/i', $desc)) {
                                                    echo $desc;
                                                } else {
                                                    $safeText = htmlspecialchars(strip_tags($desc)); // prevent HTML injection
                                                    echo nl2br(wordwrap($safeText, 60, "\n", true));
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?php if (!empty($row['image'])): ?>
                                                    <img src="uploads/education-img/<?php echo $row['image']; ?>" width="70"
                                                        height="50">
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['is_active'] == 1 && $row['is_delete'] == 0): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                                <?php if ($row['is_active'] == 1 && $row['is_delete'] == 0): ?>
                                                    <a href="?delete=<?php echo $row['id']; ?>&status=0"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Deactivate this record?');">Deactivate</a>
                                                <?php else: ?>
                                                    <a href="?delete=<?php echo $row['id']; ?>&status=1"
                                                        class="btn btn-sm btn-success"
                                                        onclick="return confirm('Activate this record?');">Activate</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No records found.</td>
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const descriptionField = document.querySelector('#description');
            if (descriptionField) {
                ClassicEditor
                    .create(descriptionField, {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'strikethrough', '|',
                            'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                            'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify', '|',
                            'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent', '|',
                            'link', 'blockQuote', 'codeBlock', 'insertTable', 'imageUpload', 'mediaEmbed', '|',
                            'undo', 'redo', 'removeFormat'
                        ],
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                            ]
                        },
                        ui: {
                            poweredBy: {
                                forceVisible: false // 👈 This hides the watermark
                            }
                        }
                    })
                    .then(editor => {
                        console.log('CKEditor initialized successfully');
                    })
                    .catch(error => {
                        console.error('CKEditor initialization error:', error);
                    });
            } else {
                console.error('Description field not found.');
            }
        });
    </script>
    <script>
        // ✅ Reusable loader function
        function load_level(acId, selectedEduId = '') {
            const eduSelect = document.getElementById('ed_level_id');

            eduSelect.innerHTML = '<option value="">Loading...</option>';

            if (!acId) {
                eduSelect.innerHTML = '<option value="">Select Education Level</option>';
                return;
            }

            // Fetch dependent options
            fetch(`./extra/get_education_level.php?ac_level_id=${acId}`)
                .then(res => res.text())
                .then(optionsHTML => {
                    eduSelect.innerHTML = optionsHTML;

                    // ✅ Preselect value in edit mode
                    if (selectedEduId) {
                        eduSelect.value = selectedEduId;
                    }
                })
                .catch(() => {
                    eduSelect.innerHTML = '<option value="">Error Loading Data</option>';
                });
        }

        // ✅ Run this when user manually changes Academic Level
        document.getElementById('ac_level_id').addEventListener('change', function () {
            load_level(this.value);
        });

        // ✅ Auto-run on edit (prefill mode)
        <?php if ($editData): ?>
            document.addEventListener("DOMContentLoaded", function () {
                const existingAc = "<?php echo $editData['ac_level_id']; ?>";
                const existingEd = "<?php echo $editData['ed_level_id']; ?>";

                // Set academic level dropdown
                document.getElementById('ac_level_id').value = existingAc;

                // Load education levels and preselect the right one
                load_level(existingAc, existingEd);
            });
        <?php endif; ?>
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

</body>

</html>