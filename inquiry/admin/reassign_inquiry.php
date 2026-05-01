<?php
// Include necessary files
include '../include/checklogin.php';
// include '../include/importsidebar.php';

// Query to get inquiry assignments from tbl_faculty_assign_log
$cmd = $con->prepare("
    SELECT 
        log.id, 
        log.old_staff_id, 
        log.new_staff_id, 
        log.inquiry_ids, 
        log.total_reassigned, 
        log.assign_by, 
        log.created_at,
        old.name AS old_staff_name,
        new.name AS new_staff_name,
        assigner.name AS assign_by_name
    FROM tbl_inquiry_reassignment_log log
    LEFT JOIN tbl_staff old ON log.old_staff_id = old.id
    LEFT JOIN tbl_staff new ON log.new_staff_id = new.id
    LEFT JOIN tbl_staff assigner ON log.assign_by = assigner.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div id="preloader"><div id="status">&nbsp;</div></div>
<div class="wrapper">

    <?php include '../include/importnav.php'; ?>
    <?php include '../include/importsidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1 class="m-0">Reassigned Inquiries</h1></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Reassigned Inquiries</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
        <div class="card">
            <div class="card-header">
                <center><h5><b><i class="fas fa-random"></i> Inquiry Reassignment Log</b></h5></center>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                        <thead>
                            <tr align="center">
                                <th>SN</th>
                                <th>Old Staff</th>
                                <th>New Staff</th>
                                <th>Inquiry IDs</th>
                                <th>Total Reassigned</th>
                                <th>Assigned By</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sr = 0;
                            $cmd->execute();
                            $result = $cmd->get_result();
                            while ($row = $result->fetch_assoc()) {
                                $sr++;
                               echo "<tr align='center'>
                                    <td>{$sr}</td>
                                    <td>" . ($row['old_staff_name'] ?? "<b>N/A</b>") . "</td>
                                    <td>" . ($row['new_staff_name'] ?? "<b>N/A</b>") . "</td>
                                    <td>";
                                
                                    $inquiryIds = explode(',', $row['inquiry_ids']);
                                    $inqStudentIds = [];
                                    
                                    if (!empty($inquiryIds)) {
                                        $placeholders = implode(',', array_fill(0, count($inquiryIds), '?'));
                                        $stmt = $con->prepare("SELECT inq_student_id FROM tbl_inquiry_student WHERE id IN ($placeholders)");
                                        $stmt->bind_param(str_repeat('i', count($inquiryIds)), ...$inquiryIds);
                                        $stmt->execute();
                                        $result_inq = $stmt->get_result();
                                        while ($inqRow = $result_inq->fetch_assoc()) {
                                            $inqStudentIds[] = $inqRow['inq_student_id'];
                                        }
                                        $stmt->close();
                                    }
                                    
                                        // Split into visible and hidden chunks
                                        $visibleIds = array_slice($inqStudentIds, 0, 50);
                                        $hiddenIds = array_slice($inqStudentIds, 50);
                                        
                                        // Create a unique ID for JS toggle
                                        $uniqueId = "inq_more_{$sr}";
                                        
                                        echo implode(', ', $visibleIds);
                                        if (count($hiddenIds) > 0) {
                                            echo '<span id="' . $uniqueId . '" style="display:none;">, ' . implode(', ', $hiddenIds) . '</span>';
                                            echo '<br><a href="javascript:void(0);" onclick="toggleInquiries(\'' . $uniqueId . '\', this)">Show More</a>';
                                        }

                                
                                echo "</td>
                                    <td>" . ($row['total_reassigned'] ?? "<b>N/A</b>") . "</td>
                                    <td>" . ($row['assign_by_name'] ?? "<b>N/A</b>") . "</td>
                                    <td>" . ( !empty($row['created_at'])  ? (new DateTime($row['created_at'], 
                                              new DateTimeZone('UTC'))) ->setTimezone(new DateTimeZone('Asia/Kolkata')) ->format('d-m-Y h:i A') : "<b>N/A</b>" ) .
                                    "</td>
                                </tr>";

                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr align="center">
                                <th>SN</th>
                                <th>Old Staff</th>
                                <th>New Staff</th>
                                <th>Inquiry IDs</th>
                                <th>Total Reassigned</th>
                                <th>Assigned By</th>
                                <th>Created At</th>
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
<script>
function toggleInquiries(id, link) {
    var el = document.getElementById(id);
    if (el.style.display === "none") {
        el.style.display = "inline";
        link.innerText = "Show Less";
    } else {
        el.style.display = "none";
        link.innerText = "Show More";
    }
}
</script>

</body>
</html>