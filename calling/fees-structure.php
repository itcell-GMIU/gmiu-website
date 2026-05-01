<?php
include './include/config.php';

/* =======================
   FILTER VALUES
======================= */
$faculty_id = $_GET['faculty_id'] ?? '';
$level_id = $_GET['level_id'] ?? '';
$program_id = $_GET['program_id'] ?? '';

$status = 0;

/* =======================
   ROLE LOGIC
======================= */
$allowFetchAll = in_array($role_id, [60, 11]);
$hasSearch = !empty($faculty_id) || !empty($level_id) || !empty($program_id);

$result = null;

/* =======================
   FETCH DATA CONDITIONALLY
======================= */
if ($allowFetchAll || $hasSearch) {

    $query = "
        SELECT 
            pro.id AS program_id,
            pro.name AS program_name,
            pro.token AS program_token,
            pro.remaining_fee,
            pro.yearfee,
            sem1, sem2, sem3, sem4, sem5, sem6, sem7, sem8,
            pro.is_active AS program_is_active,
            faculty.name AS faculty_name,
            level.name AS level_name,
            level.id AS level_id
        FROM tbl_program pro
        LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id
        LEFT JOIN tbl_level level ON pro.level_id = level.id
        WHERE pro.is_delete = ?
    ";

    $params = [$status];
    $types = "i";

    if (!empty($faculty_id)) {
        $query .= " AND pro.faculty_id = ?";
        $params[] = $faculty_id;
        $types .= "i";
    }

    if (!empty($level_id)) {
        $query .= " AND pro.level_id = ?";
        $params[] = $level_id;
        $types .= "i";
    }

    if (!empty($program_id)) {
        $query .= " AND pro.id = ?";
        $params[] = $program_id;
        $types .= "i";
    }

    $stmt = $con->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
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
                        <div class="col-md-6">
                            <h4>Fees Structure</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Fees Structure</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- FILTER CARD -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <form method="GET">
                        <div class="row">

                            <!-- Faculty -->
                            <div class="col-md-3">
                                <label>Faculty</label>
                                <select name="faculty_id" id="faculty_id" class="form-control">
                                    <option value="">Select Faculty</option>
                                    <?php
                                    $f = $con->query("SELECT * FROM tbl_faculty WHERE is_delete=0 AND is_active=1");
                                    while ($row = $f->fetch_assoc()):
                                        ?>
                                        <option value="<?= $row['id']; ?>" <?= ($faculty_id == $row['id']) ? 'selected' : ''; ?>>
                                            <?= $row['name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Level -->
                            <div class="col-md-3">
                                <label>Level</label>
                                <select name="level_id" id="level_id" class="form-control">
                                    <option value="">Select Level</option>
                                </select>
                            </div>

                            <!-- Program -->
                            <div class="col-md-3">
                                <label>Program</label>
                                <select name="program_id" id="program_id" class="form-control">
                                    <option value="">Select Program</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-3" style="margin-top:30px;">
                                <button class="btn btn-primary">Filter</button>
                                <a href="fees-structure.php" class="btn btn-secondary ml-2">Clear</a>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- DATA TABLE -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                    <?php if ($result !== null): ?>

                        <div class="table-responsive">
                            <table class="data-table table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Faculty</th>
                                        <th>Level</th>
                                        <th>Program</th>
                                        <th>Token</th>
                                        <th>Sem 1</th>
                                        <th>Sem 2</th>
                                        <th>Sem 3</th>
                                        <th>Sem 4</th>
                                        <th>Sem 5</th>
                                        <th>Sem 6</th>
                                        <th>Sem 7</th>
                                        <th>Sem 8</th>
                                        <th>Year Fee</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $row['program_id']; ?></td>
                                            <td><?= $row['faculty_name'] ?? 'N/A'; ?></td>
                                            <td><?= $row['level_name'] ?? 'N/A'; ?></td>
                                            <td><?= $row['program_name'] ?? 'N/A'; ?></td>
                                            <td><?= $row['program_token'] ?? 'N/A'; ?></td>
                                            <td><?= $row['sem1'] ?? 'N/A'; ?></td>
                                            <td><?= $row['sem2'] ?? 'N/A'; ?></td>
                                            <td><?= $row['sem3'] ?? 'N/A'; ?></td>
                                            <td><?= $row['sem4'] ?? 'N/A'; ?></td>
                                            <td><?= $row['sem5'] ?? 'N/A'; ?></td>
                                            <td><?= $row['sem6'] ?? 'N/A'; ?></td>
                                            <td><?= $row['sem7'] ?? 'N/A'; ?></td>
                                            <td><?= $row['sem8'] ?? 'N/A'; ?></td>
                                            <td><?= $row['yearfee'] ?? 'N/A'; ?></td>
                                            <td><?= $row['program_is_active'] ? 'Active' : 'Inactive'; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            Please apply filters to view fee structure.
                        </div>
                    <?php endif; ?>

                </div>

            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <!-- AJAX DROPDOWNS -->
    <script>
        $('#faculty_id').change(function () {
            $.post('./level.php', { faculty_data: this.value }, function (res) {
                $('#level_id').html(res);
            });
        });

        $('#level_id').change(function () {
            $.post('./program.php', {
                level_data: this.value,
                faculty_data: $('#faculty_id').val()
            }, function (res) {
                $('#program_id').html(res);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            var table = $('.data-table').DataTable({
                "dom": 'lfrtip',
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>