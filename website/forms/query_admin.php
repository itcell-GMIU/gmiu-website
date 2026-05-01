<?php include '../../common/importwebsitefile.php'; ?>

<?php

// 1. Fetch Dashboard Stats (existing code)
$totalQueries = $pendingQueries = $completedQueries = $rejectedQueries = 0;
$sql_stats = "SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected
            FROM tbl_runtime_query";

if ($result_stats = mysqli_query($con, $sql_stats)) {
    $row_stats = mysqli_fetch_assoc($result_stats);
    $totalQueries = $row_stats['total'] ?? 0;
    $pendingQueries = $row_stats['pending'] ?? 0;
    $completedQueries = $row_stats['completed'] ?? 0;
    $rejectedQueries = $row_stats['rejected'] ?? 0;
}

// 2. Fetch Users for the Users Table (new code)
$users = [];
$sql_users = "SELECT * FROM tbl_runtime_query ORDER BY id DESC";
if ($result_users = mysqli_query($con, $sql_users)) {
    while ($row_users = mysqli_fetch_assoc($result_users)) {
        $users[] = $row_users;
    }
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Admin Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6c757d;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --sidebar-bg: #1f2937;
            --sidebar-link-color: #9ca3af;
            --sidebar-link-hover: #ffffff;
            --sidebar-link-active: var(--primary-color);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            width: 260px;
            min-width: 260px;
            background-color: var(--sidebar-bg);
            color: white;
            transition: all 0.3s ease;
        }

        .sidebar-brand-icon i {
            font-size: 2rem;
            transform: rotate(-15deg);
        }

        .sidebar-brand-text {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .sidebar .nav-link {
            color: var(--sidebar-link-color);
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover {
            color: var(--sidebar-link-hover);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar .nav-link.active {
            color: var(--sidebar-link-hover);
            background-color: var(--sidebar-link-active);
        }

        .sidebar .nav-link .bi {
            margin-right: 0.75rem;
        }

        .main-content {
            flex-grow: 1;
            padding: 2.5rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-weight: 600;
            color: #343a40;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .stat-card {
            border-left: 5px solid;
        }

        .border-left-primary {
            border-left-color: var(--primary-color);
        }

        .border-left-warning {
            border-left-color: var(--warning-color);
        }

        .border-left-success {
            border-left-color: var(--success-color);
        }

        .border-left-danger {
            border-left-color: var(--danger-color);
        }

        .stat-card .text-xs {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .h5 {
            font-weight: 700;
        }

        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.3;
        }

        @media (max-width: 767.98px) {
            body {
                display: block;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -260px;
                height: 100%;
                z-index: 1050;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                padding: 1.5rem;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }

            .overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark d-md-none">
        <div class="container-fluid"><button class="navbar-toggler" type="button" id="sidebarToggleBtn"><span
                    class="navbar-toggler-icon"></span></button><a class="navbar-brand" href="#">Admin Panel</a></div>
    </nav>
    <div class="sidebar d-flex flex-column p-3" id="sidebar"><a href="#"
            class="d-flex align-items-center mb-4 text-white text-decoration-none">
            <div class="sidebar-brand-icon me-2"><i class="bi bi-code-square"></i></div><span
                class="sidebar-brand-text">AdminPro</span>
        </a>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"><a href="#" class="nav-link active" onclick="switchTab('dashboard', this)"><i
                        class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="#" class="nav-link" onclick="switchTab('users', this)"><i class="bi bi-people"></i> Users</a>
            </li>
            <li><a href="#" class="nav-link" onclick="switchTab('settings', this)"><i class="bi bi-gear"></i>
                    Settings</a></li>
        </ul>
        <hr>
        <div><a href="#" class="d-flex align-items-center text-white text-decoration-none"><i
                    class="bi bi-box-arrow-right me-2"></i><strong>Logout</strong></a></div>
    </div>
    <div class="overlay" id="overlay"></div>

    <main class="main-content">
        <div id="dashboard" class="content-tab">
            <div class="page-header">
                <h1>Dashboard</h1>
                <p class="lead">Overview and statistics.</p>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-primary shadow h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs text-primary mb-1">Total Queries</div>
                                    <div class="h5 mb-0 text-gray-800"><?php echo $totalQueries; ?></div>
                                </div>
                                <div class="col-auto"><i class="bi bi-journal-text stat-icon"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-warning shadow h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs text-warning mb-1">Pending</div>
                                    <div class="h5 mb-0 text-gray-800"><?php echo $pendingQueries; ?></div>
                                </div>
                                <div class="col-auto"><i class="bi bi-hourglass-split stat-icon"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-success shadow h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs text-success mb-1">Completed</div>
                                    <div class="h5 mb-0 text-gray-800"><?php echo $completedQueries; ?></div>
                                </div>
                                <div class="col-auto"><i class="bi bi-check2-circle stat-icon"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-danger shadow h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs text-danger mb-1">Rejected</div>
                                    <div class="h5 mb-0 text-gray-800"><?php echo $rejectedQueries; ?></div>
                                </div>
                                <div class="col-auto"><i class="bi bi-x-circle stat-icon"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="users" class="content-tab" style="display:none;">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h1>Manage Users</h1>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="" style="overflow-x: auto;">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Enrollment/Roll No.</th>
                                    <th>Email</th>
                                    <th>College</th>
                                    <th>Branch</th>
                                    <th>Specialization</th>
                                    <th>Sem</th>
                                    <th>HOD</th>
                                    <th>Query</th>
                                    <th>Attachment Type</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <?php
                                    // Determine badge class based on status for better UI
                                    $status = htmlspecialchars($user['status']);
                                    $badgeClass = '';
                                    switch (strtolower($status)) {
                                        case 'completed':
                                            $badgeClass = 'bg-success';
                                            break;
                                        case 'pending':
                                            $badgeClass = 'bg-warning text-dark';
                                            break;
                                        case 'rejected':
                                            $badgeClass = 'bg-danger';
                                            break;
                                        default:
                                            $badgeClass = 'bg-secondary';
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                                        <td><?php echo htmlspecialchars($user['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['enrollment_no']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['college']); ?></td>
                                        <td><?php echo htmlspecialchars($user['branch']); ?></td>
                                        <td><?php echo htmlspecialchars($user['specialization']); ?></td>
                                        <td><?php echo htmlspecialchars($user['sem']); ?></td>
                                        <td><?php echo htmlspecialchars($user['hod_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['query']); ?></td>
                                        <td><?php echo htmlspecialchars($user['attachment_type']); ?></td>
                                        <td>
                                            <?php
                                            $filePath = './uploads/query/' . htmlspecialchars($user['attachment_file']);
                                            $type = strtolower($user['attachment_type']); // normalize to lowercase
                                        
                                            if ($type === 'adhar' || $type === 'icard') {
                                                // show as image
                                                echo "<img src='{$filePath}' alt='Attachment' style='max-width:120px; max-height:120px;'>";
                                            } elseif ($type === 'fees') {
                                                // show as link
                                                echo "<a href='{$filePath}' target='_blank'>View File</a>";
                                            } else {
                                                // fallback
                                                echo htmlspecialchars($user['attachment_file']);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success py-0" title="Approve">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger py-0" title="Reject">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script>
        // Tab switching logic (Unchanged)
        function switchTab(tabId, element) {
            document.querySelectorAll('.content-tab').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
            document.querySelectorAll('.sidebar .nav-link').forEach(link => link.classList.remove('active'));
            element.classList.add('active');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            if (sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Mobile sidebar toggle logic (Unchanged)
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
            sidebarToggleBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Show default tab (Unchanged)
            document.getElementById('dashboard').style.display = 'block';

            // NEW: Initialize DataTables
            // NEW: Initialize DataTables and store it in a variable
            var usersTable = $('#usersTable').DataTable({
                scrollX: true
            });
        });
    </script>
</body>

</html>