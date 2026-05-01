<?php
include './include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>

    <?php
    // Function to get total count from a table
    function getCount($con, $table, $idColumn, $extra_where = '')
    {
        $sql = "SELECT COUNT($idColumn) AS cnt FROM $table WHERE is_active=1 AND is_delete=0 $extra_where";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = ($row = $result->fetch_assoc()) ? (int) $row['cnt'] : 0;
        $stmt->close();
        return $count;
    }

    // Get counts
    $registered_students_count = getCount($con, 'tbl_admission_student', 'id');
    $pac = getCount($con, 'tbl_pac_form', 'pacid');
    $transfer = getCount($con, 'tbl_branch_transfer_requests', 'id');
    $inquiry_students_count = getCount($con, 'tbl_inquiry_student', 'id');
    $cancellation = getCount($con, 'tbl_cancellation_requests', 'id');

    $year = 2025; // change as needed
    
    // Function to get monthly data
    function getMonthlyData($con, $table, $extra_where = '', $year = null)
    {
        $year = $year ?? date('Y');
        $counts = array_fill(1, 12, 0);

        $sql = "
        SELECT MONTH(created_at) AS month_number, COUNT(*) AS total_count
        FROM {$table}
        WHERE YEAR(created_at) = ? {$extra_where}
        GROUP BY month_number
        ORDER BY month_number
    ";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $year);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_assoc()) {
            $m = (int) $row['month_number'];
            if ($m >= 1 && $m <= 12) {
                $counts[$m] = (int) $row['total_count'];
            }
        }
        $stmt->close();

        // Month names
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('F', mktime(0, 0, 0, $i, 1));
        }

        // Zero-indexed counts
        $counts_zero_indexed = array_values($counts);

        return [$months, $counts_zero_indexed];
    }

    // Usage
    [$months, $admissions] = getMonthlyData($con, 'tbl_pac_form', '', $year);
    [, $total_students] = getMonthlyData($con, 'tbl_admission_student', '', $year);
    [, $total_approved_students] = getMonthlyData($con, 'tbl_admission_student', "AND admission_status = 'approved'", $year);
    ?>



</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$registered_students_count"; ?></h3>
                                    <p>Total Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_student.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$inquiry_students_count"; ?></h3>
                                    <p>Total Inquiry Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="student_list.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo "$pac"; ?></h3>
                                    <p>Total PAC Forms</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_pac.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$transfer"; ?></h3>
                                    <p>Total Branch Transfer Request</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_branch_request.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo "$cancellation"; ?></h3>
                                    <p>Cancellation Request</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view_cancellation_requests.php" class="small-box-footer">More
                                    info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <canvas id="combinedChart"></canvas>
                    </div>
                </div>
            </section>
        </div>

        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <?php include 'include/importjs.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctxCombined = document.getElementById('combinedChart');

        new Chart(ctxCombined, {
            type: 'bar',
            data: {
                // Single source of truth for months (always Jan–Dec)
                labels: <?php echo json_encode($months); ?>,
                datasets: [
                    {
                        label: 'Number of Registered Students',
                        data: <?php echo json_encode($total_students); ?>,
                        backgroundColor: '#1cc88a', // Green
                        borderWidth: 1
                    },
                    {
                        label: 'Number of PAC Form',
                        data: <?php echo json_encode($admissions); ?>,
                        backgroundColor: '#4e73df', // Blue
                        borderWidth: 1
                    },
                    {
                        label: 'Number of Approved Students',
                        data: <?php echo json_encode($total_approved_students); ?>,
                        backgroundColor: '#36b9cc', // Teal
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Monthly Registrations, PAC Forms, and Approvals'
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        },
                        stacked: false
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    </script>


</body>

</html>