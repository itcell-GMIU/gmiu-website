<?php
// Include the necessary files
include '../include/checklogin.php';


// Prepare the SQL query to fetch feedback data
$cmd2 = $con->prepare("SELECT `id`, `name`, `email`, `subject`, `message`, `created_at` FROM `tbl_website_contact_us`");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header and CSS Includes -->
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <!-- Wrapper -->
    <div class="wrapper">

        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Feedback</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Feedback</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Feedback Table Card -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h5><b><i class="fas fa-book-reader"></i> View Feedback</b></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="feedbackTable" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Feedback At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cmd2->execute();
                                        $result = $cmd2->get_result();
                                        $sn = 1;
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr align="center">
                                                <td><?php echo $sn++; ?></td>
                                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                                <td><?php echo htmlspecialchars($row['message']); ?></td>
                                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Feedback At</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </div>

        <!-- Footer -->
        <?php include '../include/importfooter.php'; ?>
    </div>

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>
