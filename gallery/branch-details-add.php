<?php
include './include/config.php';

// (Optional for debugging — remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle form submission
if (isset($_POST['submit'])) {

    // ============================
    // Fetch form values
    // ============================
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    $ac_level_id = $_POST['ac_level_id'];
    $ed_level_id = $_POST['ed_level_id'];
    $branch_id = $_POST['branch_id'];
    $about = $_POST['about'];
    $registered_students = $_POST['registered_students'];
    $placed_students = $_POST['placed_students'];
    $placement_rate = $_POST['placement_rate'];
    $highest_package = $_POST['highest_package'];
    $average_package = $_POST['average_package'];
    $companies_visited = $_POST['companies_visited'];

    // ============================
    // Handle Image Upload
    // ============================
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/branch-img/" . $image);
    }

    // ============================
    // Decide Insert or Update
    // ============================
    if ($id > 0) {
        // ---------------- UPDATE ----------------
        $query = "UPDATE gallery_branch_details SET 
                    ac_level_id=?, 
                    ed_level_id=?, 
                    branch_id=?, 
                    about=?, 
                    registered_students=?, 
                    placed_students=?, 
                    placement_rate=?, 
                    highest_package=?, 
                    average_package=?, 
                    companies_visited=?";

        // Add image only if new one is uploaded
        if ($image) {
            $query .= ", image=?";
            $types = "iiisiiiddds" . "i"; // last one for ID
            $params = [
                $ac_level_id,
                $ed_level_id,
                $branch_id,
                $about,
                $registered_students,
                $placed_students,
                $placement_rate,
                $highest_package,
                $average_package,
                $companies_visited,
                $image,
                $id
            ];
        } else {
            // No new image
            $types = "iiisiiiddd" . "i";
            $params = [
                $ac_level_id,
                $ed_level_id,
                $branch_id,
                $about,
                $registered_students,
                $placed_students,
                $placement_rate,
                $highest_package,
                $average_package,
                $companies_visited,
                $id
            ];
        }

        $query .= " WHERE id=?";  // final WHERE clause

        $action = "Updated";

    } else {
        // ---------------- INSERT ----------------
        $query = "INSERT INTO gallery_branch_details 
            (ac_level_id, ed_level_id, branch_id, about, 
            registered_students, placed_students, placement_rate, 
            highest_package, average_package, companies_visited, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $types = "iiisiiiddds";
        $params = [
            $ac_level_id,
            $ed_level_id,
            $branch_id,
            $about,
            $registered_students,
            $placed_students,
            $placement_rate,
            $highest_package,
            $average_package,
            $companies_visited,
            $image
        ];

        $action = "Added";
    }

    // ============================
    // Run Prepared Statement
    // ============================
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['status'] = "Details $action Successfully";
            $_SESSION['status_code'] = "success";
            $_SESSION['status_redirect'] = "branch-details-add.php";
        } else {
            $_SESSION['status'] = "Database Error: " . mysqli_stmt_error($stmt);
            $_SESSION['status_code'] = "error";
            $_SESSION['status_redirect'] = "branch-details-add.php";
        }

        mysqli_stmt_close($stmt);

    } else {
        $_SESSION['status'] = "Query Preparation Failed: " . mysqli_error($con);
        $_SESSION['status_code'] = "error";
        $_SESSION['status_redirect'] = "branch-details-add.php";
    }
}

// Handle Edit Prefill
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $stmt = $con->prepare("SELECT
                                    gbd.id,
                                    gbd.ac_level_id,
                                    gal.name AS academic_name,
                                    gbd.ed_level_id,
                                    gel.name AS education_name,
                                    gbd.branch_id,
                                    gb.branch_name,
                                    gbd.about,
                                    gbd.image,
                                    gbd.registered_students,
                                    gbd.placed_students,
                                    gbd.placement_rate,
                                    gbd.highest_package,
                                    gbd.average_package,
                                    gbd.companies_visited,
                                    gbd.is_active,
                                    gbd.is_delete
                                FROM
                                    gallery_branch_details AS gbd
                                JOIN gallery_academic_level AS gal
                                ON
                                    gbd.ac_level_id = gal.id
                                JOIN gallery_education_level AS gel
                                ON
                                    gbd.ed_level_id = gel.id
                                JOIN gallery_branches AS gb
                                ON
                                    gbd.branch_id = gb.id
                                    WHERE gbd.id = ?");
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

    $stmt = $con->prepare("UPDATE gallery_branch_details SET is_active=?, is_delete=? WHERE id=?");
    $stmt->bind_param("iii", $isActive, $isDelete, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['status'] = "Record {$action} Successfully";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "branch-details-add.php";
}

// Fetch All Records
$query = "SELECT
            gbd.id,
            gbd.ac_level_id,
            gal.name AS academic_name,
            gbd.ed_level_id,
            gel.name AS education_name,
            gbd.branch_id,
            gb.branch_name,
            gbd.about,
            gbd.image,
            gbd.registered_students,
            gbd.placed_students,
            gbd.placement_rate,
            gbd.highest_package,
            gbd.average_package,
            gbd.companies_visited,
            gbd.is_active,
            gbd.is_delete
        FROM
            gallery_branch_details AS gbd
        JOIN gallery_academic_level AS gal
        ON
            gbd.ac_level_id = gal.id
        JOIN gallery_education_level AS gel
        ON
            gbd.ed_level_id = gel.id
        JOIN gallery_branches AS gb
        ON
            gbd.branch_id = gb.id";
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
                                <h4>Placement Overview</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Placement Overview</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- FORM CARD -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

                        <div class="row">
                            <div class="col-md-4 mb-3">
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

                            <div class="col-md-4 mb-3">
                                <label>Education Level <span class="text-danger">*</span></label>
                                <select id="ed_level_id" name="ed_level_id" class="form-control" required>
                                    <option value="">Select Education Level</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch <span class="text-danger">*</span></label>
                                    <select class="form-control" name="branch_id" id="branch_id" required>
                                        <option value="">-- Select Branch --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><strong>About</strong></label>
                            <textarea class="form-control" name="about" id="about" rows="4"
                                placeholder="Write about placement overview..."><?php echo htmlspecialchars($editData['about'] ?? ''); ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><strong>Image</strong></label>
                            <input type="file" name="image" class="form-control">
                            <?php if (!empty($editData['image'])): ?>
                                <a href="uploads/branch-img/<?php echo $editData['image']; ?>" target="_blank">
                                    <img src="uploads/branch-img/<?php echo $editData['image']; ?>"
                                        style="height: 200px; width: auto; object-fit: contain; border: 1px solid #ccc;margin-top: 10px;">
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Registered Students</strong></label>
                                    <input type="number" class="form-control" name="registered_students"
                                        value="<?php echo htmlspecialchars($editData['registered_students'] ?? ''); ?>"
                                        placeholder="e.g. 120" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Placed Students</strong></label>
                                    <input type="number" class="form-control" name="placed_students"
                                        value="<?php echo htmlspecialchars($editData['placed_students'] ?? ''); ?>"
                                        placeholder="e.g. 95" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Placement Rate (%)</strong></label>
                                    <input type="number" step="0.01" class="form-control" name="placement_rate"
                                        value="<?php echo htmlspecialchars($editData['placement_rate'] ?? ''); ?>"
                                        placeholder="e.g. 79.16" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Highest Package (LPA)</strong></label>
                                    <input type="number" step="0.01" class="form-control" name="highest_package"
                                        value="<?php echo htmlspecialchars($editData['highest_package'] ?? ''); ?>"
                                        placeholder="e.g. 12.50" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Average Package (LPA)</strong></label>
                                    <input type="number" step="0.01" class="form-control" name="average_package"
                                        value="<?php echo htmlspecialchars($editData['average_package'] ?? ''); ?>"
                                        placeholder="e.g. 6.25" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Companies Visited</strong></label>
                                    <input type="number" class="form-control" name="companies_visited"
                                        value="<?php echo htmlspecialchars($editData['companies_visited'] ?? ''); ?>"
                                        placeholder="e.g. 30" required>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" name="submit"
                                class="btn btn-primary"><?php echo $editData ? "Update" : "Add"; ?></button>

                            <?php if ($editData): ?>
                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary ml-2">Cancel</a>
                            <?php else: ?>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            <?php endif; ?>

                        </div>
                    </form>
                </div>
                <!-- END FORM CARD -->

                <!-- Table Card   -->
                <div class="pd-20 bg-white border-radius-4 box-shadow">
                    <h5 class="mb-20">Branches Details</h5>
                    <div class="table-responsive table-sm">
                        <table class="data-table table-striped table-hover nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Academic</th>
                                    <th>Education</th>
                                    <th>Branch</th>
                                    <th>About</th>
                                    <th>Image</th>
                                    <th title="Registered Students">RS</th>
                                    <th title="Placed Students">PS</th>
                                    <th title="Placement Rate (in %)">PR</th>
                                    <th title="Highest Package (in LPA)">HP</th>
                                    <th title="Average Package (in LPA)">AP</th>
                                    <th title="Companies Visited">CV</th>

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
                                            <td>
                                                <?php
                                                echo nl2br(wordwrap(htmlspecialchars($row['branch_name']), 35, "\n", true));
                                                ?>
                                            </td>
                                            <td><small><?php echo ($row['about']); ?></small></td>
                                            <td>
                                                <?php if (!empty($row['image'])): ?>
                                                    <a href="uploads/branch-img/<?php echo $row['image']; ?>" target="_blank">
                                                        <img src="uploads/branch-img/<?php echo $row['image']; ?>">
                                                    </a>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['registered_students']); ?></td>
                                            <td><?php echo htmlspecialchars($row['placed_students']); ?></td>
                                            <td><?php echo htmlspecialchars($row['placement_rate']); ?></td>
                                            <td><?php echo htmlspecialchars($row['highest_package']); ?></td>
                                            <td><?php echo htmlspecialchars($row['average_package']); ?></td>
                                            <td><?php echo htmlspecialchars($row['companies_visited']); ?></td>
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
                                                        onclick="return confirm('Deactivate this branch?');">Deactivate</a>
                                                <?php else: ?>
                                                    <a href="?delete=<?php echo $row['id']; ?>&status=1"
                                                        class="btn btn-sm btn-success"
                                                        onclick="return confirm('Activate this branch?');">Activate</a>
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
        $(document).ready(function () {
            $('.data-table').DataTable({
                scrollX: true,        // ✅ Enables horizontal scrolling
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,    // ✅ Turn off collapsing mode for full control
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
        document.addEventListener("DOMContentLoaded", function () {
            const descriptionField = document.querySelector('#about');
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
</body>

</html>