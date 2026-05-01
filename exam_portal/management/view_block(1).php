<?php
include '../include/checklogin.php';


if (isset($_GET['dt'])) {
    $ex_dt = $_GET['dt'];

    $dateTime2 = new DateTime($ex_dt);
    $formattedExDate = $dateTime2->format("d-m-Y");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <!-- /.CKeditor custom script -->

    <style>
        /* Custom CSS for Receipt */
        .receipt-container {
            /* border: 1px solid #ccc; */
            padding: 20px;
            margin: 20px;
        }

        .logo {
            /* Add your logo image here */
            width: 130px;
            height: 115px;
        }

        @media print {
            .print-btn {
                display: none;
            }

            body * {
                visibility: hidden;
            }

            .bg-dark {
                background-color: black;
            }

            .printable-div,
            .printable-div * {
                visibility: visible;
                -webkit-print-color-adjust: exact;
            }

            .printable-div {
                margin-left: -20px;
                margin-right: -20px;
            }
        }

        .row-border {
            border: 1px solid black !important;
            border-collapse: collapse !important;
        }

        .bg-dark {
            background-color: #e3e1e1 !important;
            color: black !important;
            margin-top: 10px;
            padding-top: 5px;
        }

        .p-h {
            height: 45px;
            display: flex;
            align-items: center;
        }

        .printable-div {
            page-break-before: always;
            /* Add a page break before each div */
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Exam Block Arrangement [<?= $formattedExDate ?>]</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Exam Block Arrangement</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row ">
                        <!-- left column -->
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-body">
                                    <?php
                                    $status = 0;
                                    $cmd = $con->prepare("SELECT * FROM tbl_exam_timetable WHERE is_delete = ? AND date = ?");
                                    $cmd->bind_param("is", $status, $ex_dt);
                                    $cmd->execute();
                                    $result = $cmd->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $exam_id = $row['exam_id'];
                                        $sub_code = $row['subject_code'];
                                        $sub_name = $row['subject_name'];


                                        $cmd11 = $con->prepare("SELECT std.type as type, std.year as year, std.semester as sem, std.session as session ,std.faculty_id, std.level_id, std.program_id,faculty.name as faculty_name, program.name as program_name, 
                                        level.name as level_name FROM tbl_exam_form as std
                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id
                                        LEFT JOIN tbl_level level ON std.level_id = level.id
                                        LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.id = ?");
                                        $cmd11->bind_param("i", $exam_id);
                                        $cmd11->execute();
                                        $result11 = $cmd11->get_result();
                                        while ($row11 = $result11->fetch_assoc()) {

                                    ?>
                                            <div class="printable-div">
                                            <?php
                                            $semester_ex = $row11['sem'];
                                            $session = $row11['session'];
                                            $type = $row11['type'];
                                            $year = $row11['year'];
                                            $level_name = $row11['level_name'];
                                            $program_name = $row11['program_name'];

                                            $program_id = $row11['program_id'];
                                            $faculty_id = $row11['faculty_id'];
                                            $level_id = $row11['level_id'];

                                            // $status = 0;
                                            // $cmd12 = $con->prepare("SELECT short_name FROM tbl_short_name WHERE level_id = ? AND faculty_id = ? AND is_delete = ?");
                                            // $cmd12->bind_param("iii", $level_id, $faculty_id, $status);
                                            // $cmd12->execute();
                                            // $result12 = $cmd12->get_result();
                                            // while ($row12 = $result12->fetch_assoc()) {
                                            //     $short_name = $row12['short_name'];
                                            // }

                                            $examName = $level_name . ' ' . $program_name . ' semester-' . $semester_ex . ' ' . $type . ' ' . $session . '-' . $year;
                                        }

                                            ?>
                                            <div class="row mt-3 row-border">
                                                <div class="col-2 text-center row-border">
                                                    <img src="<?= $website_assets_url ?>images/logo-single.jpg" alt="Logo" class="logo mt-1 mb-1 ml-auto" style="z-index: 1;">
                                                </div>
                                                <div class="col-10 text-center">
                                                    <div class="row row-border">
                                                        <h4 class="mx-auto">Gyanmanjari Innovative University</h4>
                                                    </div>
                                                    <div class="row row-border">
                                                        <h5 class="mx-auto">-:: BLOCK ARRANGEMENT ::-</h5>
                                                    </div>
                                                    <div class="row row-border">
                                                        <div class="col-2 text-center border-right border-dark border-bottom ">
                                                            <h6>Exam : </h6>
                                                        </div>
                                                        <div class="col-10 text-center border-bottom border-dark">
                                                            <h6 class="text-uppercase"><?= $examName ?></h6>
                                                        </div>
                                                        <div class="col-2 text-center border-right border-dark">
                                                            <h6>Center : </h6>
                                                        </div>
                                                        <div class="col-10 text-center border-dark">
                                                            <h6 class="text-uppercase">Gyanmanjari Innovative University</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <?php

                                                $cmd2 = $con->prepare("SELECT * FROM tbl_exam_results WHERE is_delete = ? AND exam_id = ? AND subject_code = ? AND block_id IS NOT NULL");
                                                $cmd2->bind_param("iis", $status, $exam_id, $sub_code);
                                                $cmd2->execute();
                                                $result2 = $cmd2->get_result();
                                                $in = 1;
                                                $srCount = 0;
                                                $blockNo = 0;
                                                $prevSubCode = null;
                                                while ($row2 = $result2->fetch_assoc()) {
                                                    $sub_code = $row['subject_code'];
                                                    $enr_no = $row2['enrollnment_no'];
                                                    $seat_no = $row2['seat_no'];
                                                    $blockNo = $row2['block_id'];
                                                    // echo $in . ' ' . $enr_no . '---' . $blockNo;
                                                    // echo "<br>";
                                                    $prevSubCode = $sub_code;
                                                    if ($sub_code != $prevSubCode || $srCount % 30 == 0) {
                                                        $status = 0;
                                                        $cmd44 = $con->prepare("SELECT * FROM tbl_exam_timetable WHERE is_delete = ? AND exam_id = ? AND date = ? AND subject_code = ?");
                                                        $cmd44->bind_param("isss", $status, $exam_id, $ex_dt, $sub_code);
                                                        $cmd44->execute();
                                                        $result44 = $cmd44->get_result();

                                                        while ($row44 = $result44->fetch_assoc()) {
                                                            $subject_code = $row44['subject_code'];
                                                            $date = $row44['date'];
                                                            $dateTime = new DateTime($date);
                                                            $formattedDate = $dateTime->format("d-m-Y");
                                                            $time = $row44['start_time'];
                                                            $time = date("h:i A", strtotime($time));
                                                        }
                                                ?>
                                                        <div class="bg-dark col-3 border text-center border-dark">
                                                            <h6 class="text-uppercase">Subject Code : <?= $sub_code ?></h6>
                                                        </div>
                                                        <div class="bg-dark col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Date : <?= $formattedDate ?></h6>
                                                        </div>
                                                        <div class="bg-dark col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Time : <?= $time ?></h6>
                                                        </div>
                                                        <div class="bg-dark col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Block No. : <?= $blockNo ?></h6>
                                                        </div>
                                                        <div class="bg-dark col-3 border text-center border-dark">
                                                            <h6 class="text-uppercase">Class Room No. : ______</h6>
                                                        </div>
                                                        <div class="col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Seat No.</h6>
                                                        </div>
                                                        <div class="col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Bench No.</h6>
                                                        </div>
                                                        <div class="col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Seat No.</h6>
                                                        </div>
                                                        <div class="col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Bench No.</h6>
                                                        </div>
                                                        <div class="col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Seat No.</h6>
                                                        </div>
                                                        <div class="col-2 border text-center border-dark">
                                                            <h6 class="text-uppercase">Bench No.</h6>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="col-2 border text-center border-dark">
                                                        <h6 class="text-uppercase"><?= $seat_no ?></h6>
                                                    </div>
                                                    <div class="col-2 border text-center border-dark">
                                                        <h6 class="text-uppercase"><?= $in ?></h6>
                                                    </div>
                                            <?php
                                                    $srCount++;
                                                    $in++;
                                                    if ($in > 30) {
                                                        $in = 1;
                                                    }
                                                }
                                                echo "
                                            </div>
                                            </div>";
                                            }
                                            ?>
                                            </div>
                                            </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                        <div class="row text-center m-3">
                            <button class="btn btn-info mx-auto" onclick="printSelectedDivs()"><i class="fa fa-print"></i> Print</button>
                        </div>

                    </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>

    <!-- print js  -->
    <script>
        function printSelectedDivs() {
            // Hide non-printable content
            document.body.querySelectorAll('*').forEach(element => {
                element.style.visibility = 'hidden';
            });

            // Show only printable divs
            document.body.querySelectorAll('.printable-div, .printable-div *').forEach(element => {
                element.style.visibility = 'visible';
            });

            // Trigger the print functionality
            window.print();

            // Restore visibility after printing
            document.body.querySelectorAll('*').forEach(element => {
                element.style.visibility = '';
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.select2option').select2();
        });
    </script>


    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        document.getElementById('add_entry').addEventListener('click', function() {
            const lateFeeEntries = document.getElementById('late_fee_entries');
            const newEntry = document.querySelector('.late_fee_entry').cloneNode(true);

            // Reset input values in the new entry
            newEntry.querySelectorAll('input').forEach(input => {
                input.value = '';
            });

            lateFeeEntries.appendChild(newEntry);
        });
    </script>
</body>

</html>