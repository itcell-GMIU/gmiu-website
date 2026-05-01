<?php
include '../include/checklogin.php';


if (isset($_GET['dt'])) {
    $ex_dt = $_GET['dt'];
    $clgCode = "GMIU";

    $dateTime2 = new DateTime($ex_dt);
    $formattedExDate = $dateTime2->format("d-m-Y");

    $shift = $_GET['st'];

    if ($shift == "am") {
        $shiftQ = "AND start_time BETWEEN '01:00:00' AND '12:01:00'";
    } elseif ($shift == "pm") {
        $shiftQ = "AND start_time BETWEEN '12:01:00' AND '24:00:00'";
    }
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

            /* 
            .printable-div {
                margin-left: -10px;
                margin-right: -10px;
            } */
        }

        .row-border {
            border: 1px solid black !important;
            border-collapse: collapse !important;
        }

        .bg-dark {
            background-color: #e3e1e1 !important;
            color: black !important;
            /* margin-top: 10px; */
            /* padding-top: 5px; */
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

        .form-text {
            font-size: 12px;
        }

        .form-col {
            height: 20px;
        }

        h6 {
            margin: 0 !important;
        }

        .area-col {
            height: 35px;
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
            <div class="col-md-12">
                <div class="card card-gmiu">
                    <div class="card-body">
                        <?php
                        $status = 0;
                        $cmd = $con->prepare("SELECT * FROM tbl_exam_timetable WHERE is_delete = ? AND sub_type = 'Theory' AND date = ? $shiftQ ;");
                        $cmd->bind_param("is", $status, $ex_dt);
                        $cmd->execute();
                        $result = $cmd->get_result();

                        while ($row = $result->fetch_assoc()) {
                            $exam_id = $row['exam_id'];
                            $sub_code = $row['subject_code'];
                            $sub_name = $row['subject_name'];

                            $cmd11 = $con->prepare("SELECT std.type as type, std.year as year, std.semester as sem, std.session as session, std.faculty_id, std.level_id, std.program_id, faculty.name as faculty_name, program.name as program_name, level.name as level_name 
                            FROM tbl_exam_form as std
                            LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id
                            LEFT JOIN tbl_level level ON std.level_id = level.id
                            LEFT JOIN tbl_program program ON std.program_id = program.id 
                            WHERE std.id = ?");
                            $cmd11->bind_param("i", $exam_id);
                            $cmd11->execute();
                            $result11 = $cmd11->get_result();

                            while ($row11 = $result11->fetch_assoc()) {
                                $semester_ex = $row11['sem'];
                                $session = $row11['session'];
                                $type = $row11['type'];
                                $year = $row11['year'];
                                $level_name = $row11['level_name'];
                                $program_name = $row11['program_name'];

                                $program_id = $row11['program_id'];
                                $faculty_id = $row11['faculty_id'];
                                $level_id = $row11['level_id'];

                                $examName = $level_name . ' ' . $program_name . ' semester-' . $semester_ex . ' ' . $type . ' ' . $session . '-' . $year;
                            }
                        ?>
                        <?php
                            $cmd2 = $con->prepare("SELECT * FROM tbl_exam_results WHERE is_delete = ? AND exam_id = ? AND subject_code = ? AND block_id IS NOT NULL AND college_code = ?");
                            $cmd2->bind_param("iiss", $status, $exam_id, $sub_code, $clgCode);
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

                                $prevSubCode = $sub_code;
                                if ($sub_code != $prevSubCode || $srCount % 30 == 0) {
                                    $status = 0;
                                    $cmd44 = $con->prepare("SELECT * FROM tbl_exam_timetable WHERE is_delete = ? AND exam_id = ? AND date = ? AND subject_code = ? AND sub_type = 'Theory'");
                                    $cmd44->bind_param("isss", $status, $exam_id, $ex_dt, $sub_code);
                                    $cmd44->execute();
                                    $result44 = $cmd44->get_result();

                                    while ($row44 = $result44->fetch_assoc()) {
                                        $subject_code = $row44['subject_code'];
                                        $date = $row44['date'];
                                        $time = $row44['start_time'];
                                        $dateTime = new DateTime($date);
                                        $formattedDate = $dateTime->format("d-m-Y");
                                        $time = date("h:i A", strtotime($time));
                                    }
                        ?>
                        <div class="printable-div">
                            <div class="row row-border mt-2">
                                <div class="col-12 text-center">
                                    <div class="row row-border">
                                        <h4 class="mx-auto col-2 "></h4>
                                        <h4 class="mx-auto col-8">Gyanmanjari Innovative University</h4>
                                        <h4 class="mx-auto col-2 ">Form-1 </h4>
                                    </div>
                                    <div class="row row-border">
                                        <div class="col-2 text-center border-right border-dark border-bottom form-col">
                                            <h6 class="form-text">Exam : </h6>
                                        </div>
                                        <div class="col-10 text-center border-bottom border-dark form-col">
                                            <h6 class="text-uppercase form-text"><?= $examName ?></h6>
                                        </div>
                                        <div class="col-2 text-center border-right border-dark form-col">
                                            <h6 class="form-text">Center : </h6>
                                        </div>
                                        <div class="col-10 text-center border-dark form-col">
                                            <h6 class="text-uppercase form-text">Gyanmanjari Innovative University</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-dark col-3 form-col border text-center border-dark">
                                    <h6 class="text-uppercase form-text">Subject Code : <?= $sub_code ?></h6>
                                </div>
                                <div class="bg-dark col-2 form-col border text-center border-dark">
                                    <h6 class="text-uppercase form-text">Date : <?= $formattedDate ?></h6>
                                </div>
                                <div class="bg-dark col-2 form-col border text-center border-dark">
                                    <h6 class="text-uppercase form-text">Time : <?= $time ?></h6>
                                </div>
                                <div class="bg-dark col-2 form-col border text-center border-dark">
                                    <h6 class="text-uppercase form-text">Block No. : <?= $blockNo ?></h6>
                                </div>
                                <div class="bg-dark col-3 form-col border text-center border-dark">
                                    <h6 class="text-uppercase form-text">Class Room No. : ______</h6>
                                </div>
                                <div class="col-2 border text-center border-dark">
                                    <h6 class="text-uppercase form-text">Seat No.</h6>
                                </div>
                                <div class="col-10 border text-center border-dark">
                                    <div class="row">
                                        <div class="col-2 border-right text-center border-dark">
                                            <h6 class="text-uppercase form-text">Answer Book No.</h6>
                                        </div>
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-12 border-right border-bottom text-center border-dark">
                                                    <h6 class="text-uppercase form-text">Supplementary Number</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3 border-right text-center border-dark">
                                                    <h6 class="text-uppercase form-text">[i]</h6>
                                                </div>
                                                <div class="col-3 border-right text-center border-dark">
                                                    <h6 class="text-uppercase form-text">[ii]</h6>
                                                </div>
                                                <div class="col-3 border-right text-center border-dark">
                                                    <h6 class="text-uppercase form-text">[iii]</h6>
                                                </div>
                                                <div class="col-3 border-right text-center border-dark">
                                                    <h6 class="text-uppercase form-text">[iv]</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 border-right text-center border-dark">
                                            <h6 class="text-uppercase form-text">Student Signature</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                                }
                        ?>
                        <div class="row">
                            <div class="col-2 border text-center border-dark">
                                <h6 class="text-uppercase pt-2"><?= $seat_no ?></h6>
                            </div>
                            <div class="col-10 border text-center border-dark">
                                <div class="row">
                                    <div class="col-2 border-right text-center border-dark">
                                        <h6 class="text-uppercase "></h6>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col-3 border-right text-center border-dark area-col">
                                                <h6 class="text-uppercase "></h6>
                                            </div>
                                            <div class="col-3 border-right text-center border-dark">
                                                <h6 class="text-uppercase "></h6>
                                            </div>
                                            <div class="col-3 border-right text-center border-dark">
                                                <h6 class="text-uppercase "></h6>
                                            </div>
                                            <div class="col-3 border-right text-center border-dark">
                                                <h6 class="text-uppercase "></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 border-right text-center border-dark">
                                        <h6 class="text-uppercase "></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                $srCount++;
                            }

                            if ($srCount > 0) {
                                echo '<div class="row mt-3">';
                                echo '<p>I hereby declare that I have verified above mentioned details and also declare that students have returned these answer books and supplementary as mentioned above.</p>';
                                echo '<p>Total Answerbook Used:_______ Total Supplementary Used:_______ Sign of Jr. Supervisor___________ Sign of Sr. Supervisor___________Name of Jr. Sup. ______________ Name of Sr. Sup.______________</p>';
                                echo '</div>';
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center m-3">
            <a class="btn btn-primary ml-auto" href="block_arrangement.php"><i class="fa fa-left-arrow"></i> Back</a>
            <button class="btn btn-info mr-auto" onclick="printSelectedDivs()"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
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