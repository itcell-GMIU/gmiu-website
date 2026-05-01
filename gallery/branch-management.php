<?php
include './include/config.php';

// Handle Add / Update
if (isset($_POST['submit'])) {
    $academic_level = (int) $_POST['ac_level_id'];
    $education_level = (int) $_POST['ed_level_id'];
    $branch_name = trim($_POST['branch_name']);
    $is_premium = isset($_POST['is_premium']) ? 1 : 0;
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($academic_level > 0 && $education_level > 0 && $branch_name !== '') {
        if ($id > 0) {
            // Update existing record
            $query = "UPDATE gallery_branches 
                      SET academic_level = ?, education_level = ?, branch_name = ?, is_premium = ?, updated_at = NOW() 
                      WHERE id = ?";
            $types = "iisii";
            $params = [$academic_level, $education_level, $branch_name, $is_premium, $id];
            $action = "Updated";
        } else {
            // Insert new record
            $query = "INSERT INTO gallery_branches (academic_level, education_level, branch_name, is_premium) 
                      VALUES (?, ?, ?, ?)";
            $types = "iisi";
            $params = [$academic_level, $education_level, $branch_name, $is_premium];
            $action = "Added";
        }

        $stmt = $con->prepare($query);
        $stmt->bind_param($types, ...$params);
        $success = $stmt->execute();
        $stmt->close();

        $_SESSION['status'] = $success
            ? "Branch {$action} Successfully"
            : "Branch {$action} Failed";
        $_SESSION['status_code'] = $success ? "success" : "error";
        $_SESSION['status_redirect'] = "branch-management.php";
    }
}

// Handle Edit (prefill)
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $con->prepare("SELECT * FROM gallery_branches WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Handle Soft Delete / Activate-Deactivate
if (isset($_GET['delete'], $_GET['status'])) {
    $id = (int) $_GET['delete'];
    $status = (int) $_GET['status'];

    $isActive = ($status === 1) ? 1 : 0;
    $isDelete = ($status === 1) ? 0 : 1;
    $action = ($status === 1) ? "Activated" : "Deactivated";

    $stmt = $con->prepare("UPDATE gallery_branches SET is_active = ?, is_delete = ? WHERE id = ?");
    $stmt->bind_param("iii", $isActive, $isDelete, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['status'] = "Branch {$action} Successfully";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_redirect'] = "branch-management.php";
}

// Fetch All Records
$query = "SELECT b.*, 
                 a.name AS academic_name, 
                 e.name AS education_name
          FROM gallery_branches b
          LEFT JOIN gallery_academic_level a ON b.academic_level = a.id
          LEFT JOIN gallery_education_level e ON b.education_level = e.id
          ORDER BY b.id ASC";
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
                                <h4>Branches</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Branches</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h5 class="mb-20"><?php echo $editData ? "Edit Branch" : "Add Branch"; ?></h5>
                    <form method="POST">
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

                            <div class="col-md-4 col-sm-12 mb-3">
                                <label for="branch_name">Branch Name <span class="text-danger">*</span></label>
                                <input type="text" name="branch_name" id="branch_name" class="form-control"
                                    placeholder="Enter Branch Name"
                                    value="<?php echo htmlspecialchars($editData['branch_name'] ?? ''); ?>" required>
                            </div>

                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-check mt-4">
                                    <input type="checkbox" class="form-check-input" id="is_premium" name="is_premium"
                                        value="1" <?php echo (!empty($editData['is_premium'])) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_premium">Is Premium Branch?</label>
                                </div>
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

                <div class="pd-20 bg-white border-radius-4 box-shadow">
                    <h5 class="mb-20">Branches List</h5>
                    <div class="table-responsive table-sm">
                        <table class="data-table table-striped table-hover nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Academic Level</th>
                                    <th>Education Level</th>
                                    <th>Branch Name</th>
                                    <th>Premium</th>
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
                                            <td><?php echo htmlspecialchars($row['branch_name']); ?></td>
                                            <td><?php echo ($row['is_premium'] == 1)
                                                ? '<span class="badge badge-warning">Yes</span>'
                                                : '<span class="badge badge-secondary">No</span>'; ?>
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

        // ✅ Auto-trigger for edit mode (prefill)
        <?php if ($editData): ?>
            document.addEventListener("DOMContentLoaded", function () {
                const existingAc = "<?php echo $editData['academic_level']; ?>";
                const existingEd = "<?php echo $editData['education_level']; ?>";

                // Set the academic dropdown value first
                document.getElementById('ac_level_id').value = existingAc;

                // Then load education levels and preselect correct one
                load_level(existingAc, existingEd);
            });
        <?php endif; ?>
    </script>

</body>

</html>