<?php
include '../include/checklogin.php';

$status = 0;

// Prepare program and level name maps for quick lookup
$programMap = [];
$programResult = $con->query("SELECT id, name FROM tbl_program");
while ($p = $programResult->fetch_assoc()) {
    $programMap[$p['id']] = $p['name'];
}

$levelMap = [];
$levelResult = $con->query("SELECT id, name FROM tbl_level");
while ($l = $levelResult->fetch_assoc()) {
    $levelMap[$l['id']] = $l['name'];
}

// Query staff data (no GROUP_CONCAT on programs/levels)
$cmd2 = $con->prepare("SELECT 
        role.name AS role_name,
        staff.password AS pass, 
        staff.id AS staff_id, 
        staff.name AS staff_name, 
        staff.email AS staff_email, 
        staff.mobile_number AS staff_mobile_number, 
        staff.is_active AS staff_is_active, 
        faculty.name AS faculty_name, 
        staff.program_id,
        staff.level_id,
        staff.under_staff_id
    FROM tbl_staff AS staff
    LEFT JOIN tbl_faculty faculty ON staff.faculty_id = faculty.id 
    LEFT JOIN tbl_role role ON staff.role_id = role.id
    WHERE staff.is_delete = ? AND staff.role_id = '14'
");

$cmd2->bind_param("i", $status);
$cmd2->execute();
$result = $cmd2->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">

                        <div class="col-sm-6">
                            <h1 class="m-0">View Staff Details</h1>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Staff Details</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <center>
                            <h5><b><i class="fas fa-book-reader"></i> View Staff Details</b></h5>
                        </center>
                    </div>

                    <div class="card-body">
                        <a class="btn btn-primary" style="margin-left: 90%;" href="staff_insert.php"><i class="fa-solid fa-plus"></i> Add</a>

                        <div class="table-responsive">
                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                <thead>
                                    <tr align="center">
                                        <th>SN</th>
                                        <th>Staff ID</th>
                                        <th>Faculty Name</th>
                                        <th>Level Name</th>
                                        <th>Program Name</th>
                                        <th>Staff Name</th>
                                        <!--<th>Under Staff Name</th>-->
                                        <!--<th>Staff Contact</th>-->
                                        <th>Staff Email</th>
                                        <!--<th>Staff Role</th>-->
                                        <th>Password</th>
                                        <!--<th>Status</th>-->
                                        <!--<th>Manage</th>-->
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $sr = 0;
                                    // Prepare program and level maps

                                        // Step 1: Get all programs with their level_ids
                                        $programMap = []; // program_id => ['name' => ..., 'level_id' => ...]
                                        $programResult = $con->query("SELECT id, name, level_id FROM tbl_program WHERE is_delete=0");
                                        while ($p = $programResult->fetch_assoc()) {
                                            $programMap[$p['id']] = [
                                                'name' => $p['name'],
                                                'level_id' => $p['level_id']
                                            ];
                                        }
                                        
                                        // Step 2: Get all level names
                                        $levelMap = []; // level_id => level name
                                        $levelResult = $con->query("SELECT id, name FROM tbl_level WHERE is_delete=0");
                                        while ($l = $levelResult->fetch_assoc()) {
                                            $levelMap[$l['id']] = $l['name'];
                                        }

                                    while ($row = $result->fetch_assoc()) {
                                        $staff_id = $row['staff_id'];
                                        $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                        $staff_name = !empty($row['staff_name']) ? $row['staff_name'] : "<b>N/A</b>";
                                        $staff_email = !empty($row['staff_email']) ? $row['staff_email'] : "<b>N/A</b>";
                                        $staff_mobile_number = !empty($row['staff_mobile_number']) ? $row['staff_mobile_number'] : "<b>N/A</b>";
                                        $pass = !empty($row['pass']) ? $row['pass'] : "<b>N/A</b>";
                                        $role_name = !empty($row['role_name']) ? $row['role_name'] : "<b>N/A</b>";
                                        $staff_is_active = $row['staff_is_active'];

                                        // Explode CSV fields
                                        $programIds = array_filter(array_map('trim', explode(',', $row['program_id'])));
                                        // $levelIds = array_filter(array_map('trim', explode(',', $row['level_id'])));
                                        $underStaffIds = array_filter(array_map('trim', explode(',', $row['under_staff_id'])));

                                        // Get under staff names (multiple)
                                        $underStaffNames = [];
                                        if (!empty($underStaffIds)) {
                                            // Prepare placeholder marks for IN query
                                            $placeholders = implode(',', array_fill(0, count($underStaffIds), '?'));
                                            $types = str_repeat('i', count($underStaffIds));
                                            $stmtUnder = $con->prepare("SELECT name FROM tbl_staff WHERE id IN ($placeholders) AND is_delete=0");
                                            $stmtUnder->bind_param($types, ...$underStaffIds);
                                            $stmtUnder->execute();
                                            $resultUnder = $stmtUnder->get_result();
                                            while ($us = $resultUnder->fetch_assoc()) {
                                                $underStaffNames[] = $us['name'];
                                            }
                                            $stmtUnder->close();
                                        }
                                        $under_staff_name = !empty($underStaffNames) ? implode(', ', $underStaffNames) : "<b>N/A</b>";

                                        // Now print one row per program
                                      
                                        foreach ($programIds as $programId) {
                                            if (isset($programMap[$programId])) {
                                                $program_name = $programMap[$programId]['name'];
                                                $levelId = $programMap[$programId]['level_id'];
                                                $level_name = isset($levelMap[$levelId]) ? $levelMap[$levelId] : "<b>N/A</b>";
                                            } else {
                                                $program_name = "<b>N/A</b>";
                                                $level_name = "<b>N/A</b>";
                                            }

                                            $sr++;
                                            echo "<tr align='center'>";
                                            echo "<td>{$sr}</td>";
                                            echo "<td>" . htmlspecialchars($staff_id) . "</td>";
                                            echo "<td>" . htmlspecialchars($faculty_name) . "</td>";
                                            echo "<td>" . htmlspecialchars($level_name) . "</td>";
                                            echo "<td>" . htmlspecialchars($program_name) . "</td>";
                                            echo "<td>" . htmlspecialchars($staff_name) . "</td>";
                                            // echo "<td>" . htmlspecialchars($under_staff_name) . "</td>";
                                            // echo "<td>" . htmlspecialchars($staff_mobile_number) . "</td>";
                                            echo "<td>" . htmlspecialchars($staff_email) . "</td>";
                                            // echo "<td>" . htmlspecialchars($role_name) . "</td>";
                                            echo "<td>" . htmlspecialchars($pass) . "</td>";
                                            // echo "<td>" . ($staff_is_active ? "Active" : "Inactive") . "</td>";
                                            // echo "<td>
                                            //         <a href='staff_edit.php?id={$staff_id}' class='btn btn-primary'><i class='fas fa-pencil-alt'></i></a>
                                            //         <a href='staff_delete.php?id={$staff_id}' class='btn btn-danger'><i class='fas fa-trash'></i></a>
                                            //       </td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>

                                <tfoot>
                                    <tr align="center">
                                        <th>SN</th>
                                        <th>Staff ID</th>
                                        <th>Faculty Name</th>
                                        <th>Level Name</th>
                                        <th>Program Name</th>
                                        <th>Staff Name</th>
                                        <!--<th>Under Staff Name</th>-->
                                        <!--<th>Staff Contact</th>-->
                                        <th>Staff Email</th>
                                        <!--<th>Staff Role</th>-->
                                        <th>Password</th>
                                        <!--<th>Status</th>-->
                                        <!--<th>Manage</th>-->
                                    </tr>
                                </tfoot>

                            </table>
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
