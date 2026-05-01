<?php
include './include/config.php';
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
                                <h4>Registered Students</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Registered Students</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h5 class="text-blue">List of the Registered Student</h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Team Member 1</th>
                                    <th>Team Member 2</th>
                                    <th>Team Member 3</th>
                                    <th>College Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Side</th>
                                    <th>Status</th>
                                    <th>Transaction ID</th>
                                    <th>Payment Status</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Payment Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT 
                                            reg.id,
                                            reg.team_member_1 AS mem1,
                                            reg.team_member_2 AS mem2,
                                            reg.team_member_3 AS mem3,
                                            reg.college_name,
                                            reg.mobile,
                                            reg.email,
                                            reg.side,
                                            reg.status,
                                            trans.transaction_id,
                                            trans.payment_status,
                                            trans.payment_amount,
                                            trans.payment_method,
                                            trans.payment_time
                                        FROM m_registrations AS reg
                                        LEFT JOIN m_transactions AS trans 
                                            ON reg.id = trans.registration_id
                                        WHERE 
                                            reg.is_active = 1 
                                            AND reg.is_delete = 0";
                                $query = mysqli_query($con, $sql);

                                while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $row['id']; ?>
                                        </td>
                                        <td>
                                            <?= $row['mem1']; ?>
                                        </td>
                                        <td>
                                            <?= $row['mem2']; ?>
                                        </td>
                                        <td>
                                            <?= $row['mem3']; ?>
                                        </td>
                                        <td>
                                            <?= $row['college_name']; ?>
                                        </td>
                                        <td>
                                            <?= $row['mobile']; ?>
                                        </td>
                                        <td>
                                            <?= $row['email']; ?>
                                        </td>
                                        <td>
                                            <?= ucfirst($row['side']); ?>
                                        </td>
                                        <td>
                                            <span
                                                class="badge <?= $row['status'] == 'SUCCESS' ? 'bg-success' : 'bg-danger'; ?>">
                                                <?= $row['status'] == 'SUCCESS' ? 'Success' : 'Failed'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= $row['transaction_id'] ?? '—'; ?>
                                        </td>
                                        <td>
                                            <?= $row['payment_status'] ?? 'Pending'; ?>
                                        </td>
                                        <td>₹
                                            <?= $row['payment_amount'] ?? '0'; ?>
                                        </td>
                                        <td>
                                            <?= $row['payment_method'] ?? '—'; ?>
                                        </td>
                                        <td>
                                            <?= $row['payment_time'] ?? '—'; ?>
                                        </td>
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
                var table = $('.data-table').DataTable({
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