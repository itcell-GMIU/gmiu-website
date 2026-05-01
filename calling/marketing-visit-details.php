<?php
include './include/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = 'SELECT * FROM tbl_marketing_visit WHERE id = ?';
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
?>


<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
    <style>
        @media print {
            .print {
                display: block;
            }

            footer {
                display: none;
            }

            .noprint {
                display: none;
            }
        }
    </style>
</head>

<body>

    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>

    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">

            <div class="page-header noprint">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Marketing Visit Details</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Marketing Visit Details</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-md-6 col-sm-12 text-right">
                        <button class="btn btn-primary" onclick="window.print();">
                            <i class="fa fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>

            <div class="pd-20 bg-white border-radius-4 box-shadow print">

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Date of Visit</th>
                            <td><?= htmlspecialchars($data['date_of_visit']) ?></td>
                        </tr>
                        <tr>
                            <th>Name of Person</th>
                            <td><?= htmlspecialchars($data['name_of_person']) ?></td>
                        </tr>
                        <tr>
                            <th>Purpose</th>
                            <td><?= htmlspecialchars($data['purpose']) ?></td>
                        </tr>
                        <tr>
                            <th>Timing of Departure</th>
                            <td><?= htmlspecialchars($data['timing_of_departure']) ?></td>
                        </tr>
                        <tr>
                            <th>Timing of Arrival</th>
                            <td><?= htmlspecialchars($data['timing_of_arrival']) ?></td>
                        </tr>
                        <tr>
                            <th>Travelling Timing</th>
                            <td><?= htmlspecialchars($data['travelling_timing']) ?></td>
                        </tr>
                        <tr>
                            <th>Visit Time</th>
                            <td><?= htmlspecialchars($data['visit_time']) ?></td>
                        </tr>
                        <tr>
                            <th>Contact Info</th>
                            <td><?= htmlspecialchars($data['contact_info']) ?></td>
                        </tr>
                        <tr>
                            <th>Points of Discussion</th>
                            <td><?= htmlspecialchars($data['point_discussion']) ?></td>
                        </tr>
                        <tr>
                            <th>Material Given</th>
                            <td><?= htmlspecialchars($data['material_given']) ?></td>
                        </tr>
                        <tr>
                            <th>Response</th>
                            <td><?= htmlspecialchars(strtoupper($data['response'])) ?></td>
                        </tr>

                        <tr class="noprint">
                            <th>Images</th>
                            <td>
                                <div class="row">
                                    <?php
                                    if (!empty($data['image'])) {
                                        $images = explode(',', $data['image']);
                                        foreach ($images as $index => $image) {
                                            ?>
                                            <div class="col-md-4 mb-3">
                                                <img src="./uploads/marketing_visit/<?= htmlspecialchars($image) ?>"
                                                    class="img-fluid" alt="Marketing Visit Image" style="max-width: 400px;">
                                            </div>
                                            <?php
                                            if (($index + 1) % 3 == 0 && $index + 1 != count($images)) {
                                                echo '</div><div class="row">';
                                            }
                                        }
                                    } else {
                                        echo "No image uploaded";
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>
</body>

</html>