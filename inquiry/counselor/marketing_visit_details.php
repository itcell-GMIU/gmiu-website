<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>
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

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;
        </div>
    </div>
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Marketing Visit Data</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Marketing Visit Data</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content print">
                <div class="container-fluid">
                    <div class="card">
                        <button class="btn btn-primary m-2 col-md-2 ml-auto noprint" onclick="window.print();">Print</button>
                        <div class="card-header">
                            <?php
                            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                            $sql = 'SELECT * FROM tbl_marketing_visit WHERE id = ?';
                            $stmt = $con->prepare($sql);
                            $stmt->bind_param('i', $id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $data = $result->fetch_assoc();
                            $stmt->close();
                            ?>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Date of Visit</th>
                                        <td><?php echo htmlspecialchars($data['date_of_visit']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name of Person</th>
                                        <td><?php echo htmlspecialchars($data['name_of_person']); ?></td>
                                    </tr>

                                    <tr>
                                        <th>Purpose</th>
                                        <td><?php echo htmlspecialchars($data['purpose']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Timing of Departure</th>
                                        <td><?php echo htmlspecialchars($data['timing_of_departure']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Timing of Arrival</th>
                                        <td><?php echo htmlspecialchars($data['timing_of_arrival']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Travelling Timing</th>
                                        <td><?php echo htmlspecialchars($data['travelling_timing']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Visit Time</th>
                                        <td><?php echo htmlspecialchars($data['visit_time']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Contact Info</th>
                                        <td><?php echo htmlspecialchars($data['contact_info']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Points of Discussion</th>
                                        <td><?php echo htmlspecialchars($data['point_discussion']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Material Given</th>
                                        <td><?php echo htmlspecialchars($data['material_given']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Response</th>
                                        <td><?php echo htmlspecialchars($data['response']); ?></td>
                                    </tr>
                                    <tr class="noprint">
                                        <th>Images</th>
                                        <td>
                                            <div class="row">
                                                <?php
                                                if (!empty($data['image'])) {
                                                    $images = explode(',', $data['image']); // Split the string into an array
                                                    foreach ($images as $index => $image) { // Loop through each image
                                                ?>
                                                        <div class="col-md-4 mb-3"> <!-- Each image takes one-third of the row -->
                                                            <img src="../uploads/marketing_visit/<?php echo htmlspecialchars($image); ?>" alt="Image" style="max-width: 100%; height: auto;">
                                                        </div>
                                                <?php
                                                        // Close the row after every three images
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
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    <?php include '../include/importjs.php'; ?>


</body>

</html>