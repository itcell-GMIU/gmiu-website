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
        <div class="pd-ltr-20  height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Summary</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Summary</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Table Start -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h5 class="text-blue">Admission Inquiry Report</h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-striped " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th>Total Assigned Inq.</th>
                                    <th>Total Completed Call</th>
                                    <th>Total Confirm Inq.</th>
                                    <th>Today's Confirm Inq.</th>
                                    <th>Total Closed Inq.</th>
                                    <th>Total Rejected Inq.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $staff_query = mysqli_query($con, "SELECT id as staff_id, name FROM tbl_staff WHERE role_id in ('15', '16') AND is_active=1 AND is_delete=0");
                                while ($staff_row = mysqli_fetch_array($staff_query)) {
                                    $staff_id = $staff_row['staff_id'];

                                    // Total Assigned Inquiries
                                    $total_assigned_query = mysqli_query($con, "SELECT COUNT(*) AS total_assigned FROM tbl_inquiry_student WHERE staff_id='$staff_id'");
                                    $total_assigned_row = mysqli_fetch_array($total_assigned_query);
                                    $total_assigned = $total_assigned_row['total_assigned'];

                                    // Total Completed Calls
                                    $total_completed_query = mysqli_query($con, "SELECT COUNT(*) AS total_completed FROM tbl_inquiry_call_logs WHERE call_by='$staff_id'");
                                    $total_completed_row = mysqli_fetch_array($total_completed_query);
                                    $total_completed = $total_completed_row['total_completed'];

                                    // Total Confirmed Inquiries
                                    $total_confirmed_query = mysqli_query($con, "SELECT COUNT(*) AS total_confirmed FROM tbl_inquiry_student WHERE confirm_by ='$staff_id' AND is_admission_confirm = '1'");
                                    $total_confirmed_row = mysqli_fetch_array($total_confirmed_query);
                                    $total_confirmed = $total_confirmed_row['total_confirmed'];

                                    // Today's Confirmed Inquiries
                                    $today_date = date('Y-m-d');
                                    $todays_confirmed_query = mysqli_query($con, "SELECT COUNT(*) AS todays_confirmed FROM tbl_inquiry_student WHERE confirm_by ='$staff_id' AND is_admission_confirm = '1' AND DATE(confirm_on) = '$today_date' ");
                                    $todays_confirmed_row = mysqli_fetch_array($todays_confirmed_query);
                                    $todays_confirmed = $todays_confirmed_row['todays_confirmed'];

                                    // Total Closed Inquiries
                                    $total_closed_query = mysqli_query($con, "SELECT COUNT(*) AS total_closed FROM tbl_inquiry_call_logs WHERE call_by = '$staff_id' AND call_status = 'CLOSE'");
                                    $total_closed_row = mysqli_fetch_array($total_closed_query);
                                    $total_closed = $total_closed_row['total_closed'];

                                    // Total Rejected Inquiries
                                    $total_rejected_query = mysqli_query($con, "SELECT COUNT(*) AS total_rejected FROM tbl_inquiry_logs WHERE staff_id='$staff_id' AND action='reject'");
                                    $total_rejected_row = mysqli_fetch_array($total_rejected_query);
                                    $total_rejected = $total_rejected_row['total_rejected'];
                                    ?>
                                    <tr>
                                        <td><?php echo $staff_row['name']; ?></td>
                                        <td><?php echo $total_assigned; ?></td>
                                        <td><?php echo $total_completed; ?></td>
                                        <td><?php echo $total_confirmed; ?></td>
                                        <td><?php echo $todays_confirmed; ?></td>
                                        <td><?php echo $total_closed; ?></td>
                                        <td><?php echo $total_rejected; ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Table End -->

            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {

            var table = $('.data-table').DataTable({
                processing: true,

                /* ===== Layout ===== */
                dom: 'Blfrtip',

                /* ===== Scrolling ===== */
                // scrollX: true,
                // scrollCollapse: true,

                /* ===== Behavior ===== */
                responsive: false,     // pure horizontal scroll
                autoWidth: false,
                lengthChange: true,
                order: [],

                /* ===== Column Control ===== */
                columnDefs: [
                    {
                        targets: 'datatable-nosort',
                        orderable: false
                    },
                    {
                        targets: [],        // example: [3,5] if you want to hide columns
                        visible: false
                    }
                ],

                /* ===== Length Menu ===== */
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],

                /* ===== Language ===== */
                language: {
                    info: "_START_ - _END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },

                /* ===== Buttons ===== */
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    'pdf',
                    'print',
                    {
                        extend: 'colvis',
                        text: 'Columns'
                    }
                ]
            });

            /* ===== Move buttons to custom position ===== */
            table.buttons().container()
                .appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');

        });
    </script>

</body>

</html>