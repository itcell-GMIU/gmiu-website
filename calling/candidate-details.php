<?php
include './include/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// FETCH INQUIRY DETAILS
// $sql = "SELECT 
//             tis.inq_student_id, 
//             tis.admission_student_id, 
//             tis.first_name, 
//             tis.middle_name, 
//             tis.last_name, 
//             tis.gender, 
//             tis.dob, 
//             tis.mobile_number, 
//             tis.mobile_number2, 
//             tis.email, 
//             tis.faculty_id, 
//             tis.level_id, 
//             tis.program_id, 
//             tis.last_school_name, 
//             tis.last_exam, 
//             tis.specify_degree, 
//             tis.last_exam_status, 
//             tis.last_exam_marks, 
//             tis.is_online, 
//             tis.staff_id, 
//             tis.assign_by, 
//             tis.is_admission_confirm, 
//             tis.admission_remark, 
//             tis.confirm_by, 
//             tis.call_count,
//             tf.name AS faculty_name,
//             tl.name AS level_name,
//             tp.name AS program_name,
//             ts.name AS staff_name,
//             ts2.name AS assign_by_name,
//             ts3.name AS confirm_by_name,
//             (SELECT COUNT(*) FROM tbl_inquiry_call_logs AS ticl WHERE ticl.inq_student_id = tis.inq_student_id) AS total_calls
//         FROM tbl_inquiry_student AS tis 
//         JOIN tbl_faculty AS tf ON tis.faculty_id = tf.id 
//         JOIN tbl_level AS tl ON tis.level_id = tl.id 
//         JOIN tbl_program AS tp ON tis.program_id = tp.id
//         JOIN tbl_staff AS ts ON tis.staff_id = ts.id
//         JOIN tbl_staff AS ts2 ON tis.assign_by = ts2.id
//         JOIN tbl_staff AS ts3 ON tis.confirm_by = ts3.id
//         WHERE tis.id = $id AND tis.is_delete = 0 LIMIT 1";

$sql = "SELECT 
    tis.inq_student_id, 
    tis.admission_student_id, 
    tis.first_name, 
    tis.middle_name, 
    tis.last_name, 
    tis.gender, 
    tis.dob, 
    tis.mobile_number, 
    tis.mobile_number2, 
    tis.email, 
    tis.faculty_id, 
    tis.level_id, 
    tis.program_id, 
    tis.last_school_name, 
    tis.last_exam, 
    tis.specify_degree, 
    tis.last_exam_status, 
    tis.last_exam_marks, 
    tis.is_online, 
    tis.staff_id, 
    tis.assign_by, 
    tis.is_admission_confirm, 
    tis.admission_remark, 
    tis.confirm_by, 
    tis.call_count,

    tf.name  AS faculty_name,
    tl.name  AS level_name,
    tp.name  AS program_name,
    ts.name  AS staff_name,
    ts2.name AS assign_by_name,
    ts3.name AS confirm_by_name,

    (
        SELECT COUNT(*) 
        FROM tbl_inquiry_call_logs ticl 
        WHERE ticl.inq_student_id = tis.inq_student_id
    ) AS total_calls

FROM tbl_inquiry_student AS tis

LEFT JOIN tbl_faculty AS tf 
    ON tis.faculty_id = tf.id 
   AND tis.faculty_id IS NOT NULL 
   AND tis.faculty_id <> ''

LEFT JOIN tbl_level AS tl 
    ON tis.level_id = tl.id 
   AND tis.level_id IS NOT NULL 
   AND tis.level_id <> ''

LEFT JOIN tbl_program AS tp 
    ON tis.program_id = tp.id 
   AND tis.program_id IS NOT NULL 
   AND tis.program_id <> ''

LEFT JOIN tbl_staff AS ts 
    ON tis.staff_id = ts.id 
   AND tis.staff_id IS NOT NULL 
   AND tis.staff_id <> ''

LEFT JOIN tbl_staff AS ts2 
    ON tis.assign_by = ts2.id 
   AND tis.assign_by IS NOT NULL 
   AND tis.assign_by <> ''

LEFT JOIN tbl_staff AS ts3 
    ON tis.confirm_by = ts3.id 
   AND tis.confirm_by IS NOT NULL 
   AND tis.confirm_by <> ''

WHERE tis.id = $id
  AND tis.is_delete = 0
LIMIT 1;
";

$result = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($result);

$lastExamOptions = [
    1 => '10th',
    2 => '12th Commerce',
    3 => '12th Science (A Group)',
    4 => '12th Science (B Group)',
    5 => '12th Arts',
    6 => 'Graduate',
    7 => 'Post Graduate',
    8 => 'Diploma',
    9 => 'ITI',
    10 => 'Diploma Pharmacy',
];

$isOnlineOptions = [
    1 => 'Website',
    2 => 'Whatsapp',
    3 => 'Other',
    4 => 'Walk In',
    5 => 'E-Mail',
    6 => 'Confidential'
];

$isAdmissionConfirmed = [
    1 => 'Confirmed',
    0 => 'Pending',
    -1 => 'Rejected',
];

// Helper function for safe echo
function show($value)
{
    return ($value !== NULL && $value !== '') ? $value : "--";
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
    <style>
        /* ================= SCREEN ================= */
        #print-area {
            position: relative;
            background: #fff;
            padding: 20px;
            max-width: 900px;
            border: 1px solid #000;
            margin: 20px auto;
        }

        /* Header */
        .print-header {
            text-align: center;
            margin-bottom: 12px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }

        .print-header h3 {
            margin: 0;
            font-weight: 700;
            text-transform: uppercase;
        }

        .print-header small {
            font-size: 12px;
            color: #555;
        }

        /* Table */
        .print-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            table-layout: fixed;
        }

        .print-table td {
            padding: 5px 8px;
            vertical-align: top;
            word-wrap: break-word;
            border: 1px solid #000;
        }

        /* Label */
        .print-table td.label {
            font-weight: 600;
            width: 18%;
            background-color: #f2f2f2;
        }

        /* Value */
        .print-table td.value {
            width: 32%;
        }

        /* Footer */
        .print-footer {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            padding: 0 5px 5px 5px;
        }

        #print-area {
            position: relative;
            overflow: hidden;
        }

        /* WATERMARK */
        #print-area::before {
            content: "";
            position: absolute;
            inset: 0;

            background-image: url("https://gmiu.edu.in/gmiu/website_assets/images/logo-single.jpg");
            /* 🔁 CHANGE PATH */
            background-repeat: no-repeat;
            background-position: center;
            background-size: 120mm;
            /* adjust size */

            opacity: 0.1;
            /* 🔥 LOW OPACITY */
            z-index: 0;
        }

        /* Bring content above watermark */
        #print-area>* {
            position: relative;
            z-index: 1;
        }


        /* ================= PRINT ================= */
        @media print {

            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);

                width: 200mm;
                min-height: 140mm; 
                max-height: 148.5mm; /* HALF A4 MAX */

                padding: 8mm 10mm;
                box-sizing: border-box;

                max-width: none !important;
                font-size: 13px;
                border: 2px solid #000;
            }

            @page {
                size: A4;
                margin: 0;
            }

            button {
                display: none !important;
            }

            #print-area::before {
                opacity: 0.1;
                /* Slightly lighter for print */
                background-size: 130mm;
                /* Bigger looks better on paper */
            }

            /* REQUIRED for Chrome */
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>



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
                                <h4>Student Details</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Student Details</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <?php if ($role_id != 13) { ?>
                    <!-- DETAILS CARD -->
                    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                        <h4 class="mb-20">Inquiry Details</h4>

                        <div class="row">
                            <!-- Each field echoing saved DB values -->


                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Inquiry Student ID:</label>
                                <p><?= show($data['inq_student_id']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Admission Student ID:</label>
                                <p><?= show($data['admission_student_id']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">First Name:</label>
                                <p><?= show($data['first_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Middle Name:</label>
                                <p><?= show($data['middle_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Last Name:</label>
                                <p><?= show($data['last_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Gender:</label>
                                <p><?= show($data['gender']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Date of Birth:</label>
                                <p><?= show($data['dob']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Mobile Number:</label>
                                <p><?= show($data['mobile_number']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Alternate Mobile:</label>
                                <p><?= show($data['mobile_number2']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Email:</label>
                                <p><?= show($data['email']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Faculty:</label>
                                <p><?= show($data['faculty_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Level:</label>
                                <p><?= show($data['level_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Program:</label>
                                <p><?= show($data['program_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Last School Name:</label>
                                <p><?= show($data['last_school_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Last Exam:</label>
                                <p><?= show($lastExamOptions[$data['last_exam']]) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Specify Degree:</label>
                                <p><?= show($data['specify_degree']) ?></p>
                            </div>

                            <!-- <div class="col-md-4 mb-3">
                            <label class="font-weight-bold">Last Exam Status:</label>
                            <p><?= show($data['last_exam_status']) ?></p>
                        </div> -->

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Last Exam Marks:</label>
                                <p><?= show($data['last_exam_marks']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Inquiry Type:</label>
                                <p><?= show($isOnlineOptions[$data['is_online']]) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Staff ID:</label>
                                <p><?= show($data['staff_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Assigned By:</label>
                                <p><?= show($data['assign_by_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Admission Confirmed:</label>
                                <p><?= show($isAdmissionConfirmed[$data['is_admission_confirm']]) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Confirmed By:</label>
                                <p><?= show($data['confirm_by_name']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="font-weight-bold">Call Count:</label>
                                <p><?= show($data['total_calls']) ?></p>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="font-weight-bold">Admission Remark:</label>
                                <p><?= show($data['admission_remark']) ?></p>
                            </div>

                        </div>
                    </div>
                <?php } elseif ($role_id == 13) { ?>
                    <!-- DETAILS CARD -->
                    <!-- Print Button -->
                    <button class="btn btn-primary mb-3" onclick="printInquiry()">🖨 Print</button>


                    <div class="mb-30">
                        <div id="print-area">
                            <div class="print-header">
                                <h3>Walking Form</h3>
                                <small>Generated on: <?= date('d-m-Y') ?></small>
                            </div>
                            <table class="print-table">
                                <colgroup>
                                    <col style="width:18%">
                                    <col style="width:32%">
                                    <col style="width:18%">
                                    <col style="width:32%">
                                </colgroup>

                                <tr>
                                    <td class="label">Inquiry ID</td>
                                    <td class="value"><?= show($data['inq_student_id']) ?></td>
                                    <td class="label">Admission ID</td>
                                    <td class="value"><?= show($data['admission_student_id']) ?></td>
                                </tr>

                                <tr>
                                    <td class="label">Student Name</td>
                                    <td class="value" colspan="3">
                                        <?= show($data['first_name']) ?>
                                        <?= show($data['middle_name']) ?>
                                        <?= show($data['last_name']) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label">Gender</td>
                                    <td class="value"><?= show($data['gender']) ?></td>
                                    <td class="label">Mobile</td>
                                    <td class="value"><?= show($data['mobile_number']) ?></td>
                                </tr>

                                <tr>
                                    <td class="label">Email</td>
                                    <td class="value" colspan="3"><?= show($data['email']) ?></td>
                                </tr>

                                <tr>
                                    <td class="label">Faculty</td>
                                    <td class="value"><?= show($data['faculty_name']) ?></td>
                                    <td class="label">Level</td>
                                    <td class="value"><?= show($data['level_name']) ?></td>
                                </tr>

                                <tr>
                                    <td class="label">Program</td>
                                    <td class="value" colspan="3"><?= show($data['program_name']) ?></td>
                                </tr>

                                <tr>
                                    <td class="label">Inquiry Type</td>
                                    <td class="value"><?= show($isOnlineOptions[$data['is_online']]) ?></td>
                                    <td class="label">Admission</td>
                                    <td class="value"><?= show($isAdmissionConfirmed[$data['is_admission_confirm']]) ?></td>
                                </tr>

                                <tr>
                                    <td class="label">Staff</td>
                                    <td class="value"><?= show($data['staff_name']) ?></td>
                                    <td class="label">Assigned By</td>
                                    <td class="value"><?= show($data['assign_by_name']) ?></td>
                                </tr>

                                <tr>
                                    <td class="label">Confirmed By</td>
                                    <td class="value" colspan="3"><?= show($data['confirm_by_name']) ?></td>
                                </tr>

                                <tr>
                                    <td class="label">Remarks</td>
                                    <td class="value" colspan="3" style="height: 40px;"></td>
                                </tr>
                            </table>



                            <div class="print-footer">
                                <div><strong>Signature</strong></div>
                                <div>
                                    <strong>Date & Time:</strong> <?= date('d-m-Y h:i A') ?>
                                </div>

                            </div>
                        </div>

                    </div>


                <?php } ?>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>
    <script>
        function printInquiry() {
            window.print();
        }
    </script>

</body>

</html>