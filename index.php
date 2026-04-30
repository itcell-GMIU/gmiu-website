<?php 
include('include/config.php'); 

// Security Check: HOD (Role 3) cannot access dashboard metrics
if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 3) {
    header("Location: tada-form-view.php");
    exit();
}

// Fetch Dashboard Metrics
$sql = "SELECT 
    COUNT(id) as total_forms, 
    SUM(gross_total_amount) as total_amount,
    SUM(total_da_amount_b) as total_da,
    SUM(total_honorarium_amount_c) as total_honorarium,
    SUM(total_accommodation_amount_d) as total_accommodation,
    COUNT(DISTINCT pan_card) as unique_users,
    SUM(CASE WHEN Date(form_date) = CURDATE() THEN 1 ELSE 0 END) as forms_today,
    COUNT(DISTINCT faculty_id) as total_faculties,
    MAX(gross_total_amount) as max_claim,
    (SELECT SUM(distance_km) FROM tbl_tada_form_travelling_allowance) as total_distance
    FROM tbl_tada_form_data 
    WHERE is_active = 1 AND is_delete = 0";

$result = $con->query($sql);
$row = $result->fetch_assoc();

$total_forms = $row['total_forms'] ?: 0;
$total_amount = $row['total_amount'] ?: 0;
$total_da = $row['total_da'] ?: 0;
$total_honorarium = $row['total_honorarium'] ?: 0;
$total_accommodation = $row['total_accommodation'] ?: 0;
// TA is derived from Gross - DA - Honorarium - Accommodation
$total_ta = $total_amount - ($total_da + $total_honorarium + $total_accommodation);

$unique_users = $row['unique_users'] ?: 0;
$forms_today = $row['forms_today'] ?: 0;
$total_faculties = $row['total_faculties'] ?: 0;
$max_claim = $row['max_claim'] ?: 0;
$total_distance = $row['total_distance'] ?: 0;
$avg_amount = $total_forms > 0 ? ($total_amount / $total_forms) : 0;

// Chart Data Query (Amounts over time)
$chart_sql = "SELECT DATE(form_date) as date_lbl, SUM(gross_total_amount) as amount 
              FROM tbl_tada_form_data 
              WHERE is_active = 1 AND is_delete = 0 
              GROUP BY DATE(form_date) 
              ORDER BY DATE(form_date) ASC LIMIT 30";
$chart_result = $con->query($chart_sql);
$chart_dates = [];
$chart_amounts = [];
while($crow = $chart_result->fetch_assoc()){
    $chart_dates[] = date('d-M', strtotime($crow['date_lbl']));
    $chart_amounts[] = $crow['amount'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
    <title>TADA Dashboard</title>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .dashboard-card {
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            padding: 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .dashboard-card .icon-wrap {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        /* Color Variations */
        .card-blue .icon-wrap { background: #eff6ff; color: #3b82f6; }
        .card-green .icon-wrap { background: #f0fdf4; color: #22c55e; }
        .card-orange .icon-wrap { background: #fff7ed; color: #f97316; }
        .card-purple .icon-wrap { background: #faf5ff; color: #a855f7; }
        .card-red .icon-wrap { background: #fef2f2; color: #ef4444; }
        .card-teal .icon-wrap { background: #f0fdfa; color: #14b8a6; }
        
        .dashboard-info {
            flex-grow: 1;
        }

        .dashboard-title {
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dashboard-count {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.2;
        }

        .chart-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            padding: 20px;
            border: 1px solid #f1f5f9;
            margin-top: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>

    <?php include('include/header.php'); ?>

    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>TADA Dashboard</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard Metrics</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <a href="tada-form-fill.php" class="btn btn-outline-primary shadow-sm"><i class="fa fa-plus mr-2"></i> New Form</a>
                        </div>
                    </div>
                </div>

                <!-- 10+ Metric Cards Grid -->
                <div class="row">
                    <!-- Row 1 -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-blue">
                            <div class="icon-wrap"><i class="fa fa-file-text-o"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Total Forms</div>
                                <div class="dashboard-count"><?= $total_forms ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-green">
                            <div class="icon-wrap"><i class="fa fa-money"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Gross Claimed</div>
                                <div class="dashboard-count">₹ <?= number_format($total_amount) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-orange">
                            <div class="icon-wrap"><i class="fa fa-bus"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">TA Allowance</div>
                                <div class="dashboard-count">₹ <?= number_format($total_ta) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-purple">
                            <div class="icon-wrap"><i class="fa fa-calendar-check-o"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">DA & Rate</div>
                                <div class="dashboard-count">₹ <?= number_format($total_da) ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-red">
                            <div class="icon-wrap"><i class="fa fa-gift"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Honorarium</div>
                                <div class="dashboard-count">₹ <?= number_format($total_honorarium) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-teal">
                            <div class="icon-wrap"><i class="fa fa-bed"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Accommodation</div>
                                <div class="dashboard-count">₹ <?= number_format($total_accommodation) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-blue">
                            <div class="icon-wrap"><i class="fa fa-pie-chart"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Avg Per Form</div>
                                <div class="dashboard-count">₹ <?= number_format($avg_amount) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-green">
                            <div class="icon-wrap"><i class="fa fa-users"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Unique Applicants</div>
                                <div class="dashboard-count"><?= $unique_users ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-orange">
                            <div class="icon-wrap"><i class="fa fa-calendar-plus-o"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Forms Today</div>
                                <div class="dashboard-count"><?= $forms_today ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-purple">
                            <div class="icon-wrap"><i class="fa fa-university"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Faculties</div>
                                <div class="dashboard-count"><?= $total_faculties ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-red">
                            <div class="icon-wrap"><i class="fa fa-trophy"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Max Claim</div>
                                <div class="dashboard-count">₹ <?= number_format($max_claim) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-teal">
                            <div class="icon-wrap"><i class="fa fa-road"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">KM Travelled</div>
                                <div class="dashboard-count"><?= number_format($total_distance) ?> km</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-purple">
                            <div class="icon-wrap"><i class="fa fa-university"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Faculties Involved</div>
                                <div class="dashboard-count"><?= $total_faculties ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-red">
                            <div class="icon-wrap"><i class="fa fa-line-chart"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Max Single Claim</div>
                                <div class="dashboard-count">₹ <?= number_format($max_claim) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="dashboard-card card-teal">
                            <div class="icon-wrap"><i class="fa fa-check-circle"></i></div>
                            <div class="dashboard-info">
                                <div class="dashboard-title">Active Data Status</div>
                                <div class="dashboard-count text-success" style="font-size: 18px; margin-top:3px;"><i class="fa fa-circle"></i> Live</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="chart-container">
                            <h5 class="mb-4 text-primary fw-bold"><i class="fa fa-bar-chart mr-2"></i> Amount Claimed Over Time</h5>
                            <div style="position: relative; height: 350px; width: 100%;">
                                <canvas id="amountChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="chart-container">
                            <h5 class="mb-4 text-primary fw-bold"><i class="fa fa-pie-chart mr-2"></i> Amount Distribution</h5>
                            <div style="position: relative; height: 350px; width: 100%;">
                                <canvas id="distributionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('amountChart').getContext('2d');
            
            var chartData = {
                labels: <?= json_encode($chart_dates) ?>,
                datasets: [{
                    label: 'Gross Amount Claimed (₹)',
                    data: <?= json_encode($chart_amounts) ?>,
                    backgroundColor: 'rgba(5b, 130, 246, 0.2)', /* card-blue bg */
                    borderColor: 'rgba(37, 99, 235, 1)', /* primary blue */
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: 'rgba(37, 99, 235, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3
                }]
            };

            var amountChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: { font: { family: "'Inter', sans-serif", size: 13 } }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { family: "'Inter', sans-serif", size: 14 },
                            bodyFont: { family: "'Inter', sans-serif", size: 14 },
                            callbacks: {
                                label: function(context) {
                                    return '  ₹ ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { 
                                font: { family: "'Inter', sans-serif" }, 
                                color: '#64748b',
                                callback: function(value, index, values) {
                                    return '₹' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: "'Inter', sans-serif" }, color: '#64748b' }
                        }
                    }
                }
            });

            // Distribution Chart
            var ctx2 = document.getElementById('distributionChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['TA Allowance', 'DA Allowance', 'Honorarium', 'Accommodation'],
                    datasets: [{
                        data: [<?= $total_ta ?>, <?= $total_da ?>, <?= $total_honorarium ?>, <?= $total_accommodation ?>],
                        backgroundColor: [
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(20, 184, 166, 0.8)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { family: "'Inter', sans-serif", size: 12 }, padding: 20 }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>

</html>