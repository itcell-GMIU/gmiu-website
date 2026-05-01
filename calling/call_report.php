<?php
include './include/config.php';

/* ===========================
   FILTER PARAMS (OLD LOGIC)
=========================== */
$url_faculty_id = $url_level_id = $url_program_id = $url_staff_id = "";
$url_call_status =
    // $url_call_rating = 
    "";

function fetchName($con, $table, $field, $idField, $id)
{
    if (!$id)
        return "";
    $q = $con->query("SELECT $field FROM $table WHERE $idField = '$id'");
    return ($q && $q->num_rows) ? $q->fetch_assoc()[$field] : "";
}

if (!empty($_GET['url_faculty_id'])) {
    $url_faculty_id = (mysqli_real_escape_string($con, $_GET['url_faculty_id']));
    $faculty_name = fetchName($con, 'tbl_faculty', 'name', 'id', $url_faculty_id);
}

if (!empty($_GET['url_level_id'])) {
    $url_level_id = (mysqli_real_escape_string($con, $_GET['url_level_id']));
    $level_name = fetchName($con, 'tbl_level', 'name', 'id', $url_level_id);
}

if (!empty($_GET['url_program_id'])) {
    $url_program_id = (mysqli_real_escape_string($con, $_GET['url_program_id']));
    $program_name = fetchName($con, 'tbl_program', 'name', 'id', $url_program_id);
}

if (!empty($_GET['staff_id'])) {
    $url_staff_id = (mysqli_real_escape_string($con, $_GET['staff_id']));
    $staff_name = fetchName($con, 'tbl_staff', 'name', 'id', $url_staff_id);
}

if (!empty($_GET['url_call_status'])) {
    $url_call_status = (mysqli_real_escape_string($con, $_GET['url_call_status']));
}

$examMap = [
    1 => "10th",    // 10th
    2 => "12 Commerce",   // 12th Commerce
    3 => "12th Science (A Group)",   // 12th Science (A Group)
    4 => "12th Science (B Group)",   // 12th Science (B Group)
    5 => "12th Arts",  // 12th Arts
    6 => "Graduate",    // Graduate
    7 => "Post Graduate",     // Post Graduate
    8 => "Diploma",     // Diploma
    9 => "ITI",     // ITI
    10 => "Diploma Pharmacy",     // Diploma Pharmacy
];
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
        <div class="pd-ltr-20 height-100-p">

            <!-- ================= PAGE HEADER ================= -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Called Student List</h4>
                        </div>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Called Student List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- ================= FILTER CARD ================= -->
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <form method="GET">
                    <div class="row">

                        <div class="col-md-2">
                            <select name="url_faculty_id" id="faculty_id" class="form-control">
                                <option value="">Faculty</option>
                                <?php
                                $q = $con->query("SELECT id,name FROM tbl_faculty WHERE is_active=1 AND is_delete=0");
                                while ($r = $q->fetch_assoc()) {
                                    $sel = ($url_faculty_id == $r['id']) ? 'selected' : '';
                                    echo "<option value='{$r['id']}' $sel>{$r['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="url_level_id" id="level_id" class="form-control">
                                <option value="">Level</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="url_program_id" id="program_id" class="form-control">
                                <option value="">Program</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="url_call_status" class="form-control">
                                <option value="">Call Status</option>
                                <option value="HOT">HOT</option>
                                <option value="COLD">COLD</option>
                                <option value="CLOSE">CLOSE</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="staff_id" class="form-control">
                                <option value="">Staff</option>
                                <?php
                                if ($role_id == 14) {

    if (!empty($u_staff_id) && $u_staff_id != 'NA') {

        $stmt = $con->prepare("
            SELECT id, name 
            FROM tbl_staff 
            WHERE is_delete = '0' 
            AND is_active = '1' 
            AND role_id IN ('15') 
            AND id IN($u_staff_id)
        ");

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['name']; ?>
            </option>
            <?php
        }
    }

    // ❌ If NA → nothing happens (no options shown)

} elseif ($role_id == 16 || $role_id == 15) {

    $stmt = $con->prepare("
        SELECT id, name 
        FROM tbl_staff 
        WHERE is_delete = '0' 
        AND is_active = '1' 
        AND role_id IN ('15', '16') 
        AND id = $staff_id
    ");

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        ?>
        <option value="<?php echo $row['id']; ?>">
            <?php echo $row['name']; ?>
        </option>
        <?php
    }

} else {

    $stmt = $con->prepare("
        SELECT id, name 
        FROM tbl_staff 
        WHERE is_delete = '0' 
        AND is_active = '1' 
        AND role_id IN ('15', '16')
    ");

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        ?>
        <option value="<?php echo $row['id']; ?>">
            <?php echo $row['name']; ?>
        </option>
        <?php
    }
} ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block">Filter</button>
                        </div>

                    </div>
                </form>
            </div>

            <!-- ================= TABLE ================= -->
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="table-responsive table-sm">

                    <table class="table table table-bordered table-striped" id="acedemic">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Faculty</th>
                                <th>Level</th>
                                <th>Program</th>
                                <th>Mobile 1</th>
                                <th>Mobile 2</th>
                                <th>Last Exam</th>
                                <th>Caller</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Other Rem.</th>
                                <th>Followup Date</th>
                                <!-- <th>View</th> -->
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $sql = "SELECT
                                        tis.id,
                                        tis.inq_student_id,
                                        tis.first_name,
                                        tis.middle_name,
                                        tis.last_name,
                                        tis.mobile_number,
                                        tis.mobile_number2,
                                        tis.last_exam,
                                        tf.shortname AS fsn,
                                        tl.short_name AS lsn,
                                        tp.name AS program_name,
                                        ticl.call_by,
                                        ticl.call_status,
                                        ticl.remark,
                                        ticl.other_remark,
                                        ticl.created_at,
                                        ts.name AS staff_name
                                    FROM tbl_inquiry_student AS tis
                                    LEFT JOIN tbl_faculty AS tf
                                    ON tis.faculty_id = tf.id
                                    LEFT JOIN tbl_level AS tl
                                    ON tis.level_id = tl.id
                                    LEFT JOIN tbl_program AS tp
                                    ON tis.program_id = tp.id
                                    LEFT JOIN tbl_inquiry_call_logs AS ticl
                                    ON tis.id = ticl.tis_id
                                    JOIN tbl_staff AS ts
                                    ON ticl.call_by = ts.id
                                    WHERE tis.is_active = 1 
                                    AND tis.is_delete = 0 
                                    AND ticl.is_active = 1 
                                    AND ticl.is_delete = 0";
                            if ($role_id == "14") {
                                if (!empty($u_staff_id) && $u_staff_id != 'NA') {
                                    $sql .= " AND ts.id IN($u_staff_id) ";
                                } else {
                                    // 🔴 Force no results
                                    $sql .= " AND 1 = 0 ";
                                }
                            }
                            elseif ($role_id == "16" || $role_id == "15")
                                $sql .= " AND ts.id='$staff_id' ";
                            if ($url_faculty_id)
                                $sql .= " AND tis.faculty_id='$url_faculty_id'";
                            if ($url_level_id)
                                $sql .= " AND tis.level_id='$url_level_id'";
                            if ($url_program_id)
                                $sql .= " AND tis.program_id='$url_program_id'";
                            if ($url_call_status)
                                $sql .= " AND ticl.call_status='$url_call_status'";
                            if ($url_staff_id)
                                $sql .= " AND ts.id='$url_staff_id'";

                            $res = $con->query($sql);
                            while ($row = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['inq_student_id'] ?></td>
                                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                    <td><?= !empty($row['fsn']) ? $row['fsn'] : '-' ?></td>
                                    <td><?= !empty($row['lsn']) ? $row['lsn'] : '-' ?></td>
                                    <td><?= !empty($row['program_name']) ? $row['program_name'] : '-' ?></td>
                                    <td><?= (isset($role_id) && ($role_id == 14)) ? '-' : $row['mobile_number'] ?></td>
                                    <td><?= (isset($role_id) && ($role_id == 14)) ? '-' : $row['mobile_number2'] ?></td>
                                    <td><?= $examMap[$row['last_exam']] ?></td>
                                    <td><?= $row['staff_name'] ?></td>
                                    <td><?= $row['call_status'] ?></td>
                                    <td><?= $row['remark'] ?></td>
                                    <td><?= $row['other_remark'] ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <!-- <td>
                                        <a class="btn btn-sm btn-primary" href="candidate-details.php?id=<?= $row['id'] ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {
            //call for listing the dropdown and select by default
            load_level();
            load_program();
        });

        function load_level() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $url_faculty_id; ?>;
            var level_id = <?php echo $url_level_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: api_for
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            });

        }

        function load_program() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $url_faculty_id; ?>;
            var level_id = <?php echo $url_level_id; ?>;
            var program_id = <?php echo $url_program_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_data: level_id,
                    program_id: program_id,
                    api_for: api_for
                },
                success: function (result) {
                    $('#program_id').html(result);
                }
            });

        }
    </script>
    <script type="text/javascript">
        $('#faculty_id').on('change', function () {
            var path = '<?php echo "$base_url_api"; ?>';
            var faculty_id = this.value;
            // alert("hii");
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function (result) {
                    $('#level_id').html(result);

                    // console.log(result);
                }
            })
        });
        $('#level_id').on('change', function () {
            var path = '<?php echo "$base_url_api"; ?>';
            var level_id = this.value;
            var faculty_id = $("select#faculty_id option:checked").val();
            /*  alert(level_id); */

            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    level_data: level_id,
                    faculty_data: faculty_id
                },
                cache: false,
                success: function (data) {
                    $('#program_id').html(data);
                    // console.log(data);
                }
            })
        });
    </script>

    <script>
        $(document).ready(function () {
            var table = $('#acedemic').DataTable({
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