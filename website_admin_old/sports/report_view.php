<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <style>
        .image-preview {
            width: 100px;
            height: auto;
            margin-right: 5px;
            border-radius: 5px;
        }
        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View sports_report List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View sports_report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i> View sports_report</b></h5>
                                </center>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a class="btn btn-primary" style="margin-left: 90%;" href="report_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Report</b></th>
                                            <th scope="row" style="color:black;"><b>Images</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT ssports.id as ssports_id,ssports.report_type as ssports_type, ssports.report_title as ssports_title, ssports.description as ssports_description, ssports.report as report, ssports.report_thumbnail as report_thumbnail FROM tbl_ssports as ssports WHERE ssports.is_delete = ?");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $ssports_id = $row['ssports_id'];
                                                $ssports_type = !empty($row['ssports_type']) ? $row['ssports_type'] : "<b>N/A</b>";
                                                $ssports_title = !empty($row['ssports_title']) ? $row['ssports_title'] : "<b>N/A</b>";
                                                $ssports_description = !empty($row['ssports_description']) ? $row['ssports_description'] : "<b>N/A</b>";
                                                $report_thumbnail = !empty($row['report_thumbnail']) ? $row['report_thumbnail'] : "<b>N/A</b>";
                                                $report = !empty($row['report']) ? $row['report'] : "<b>N/A</b>";

                                                // Fetch related images
                                                $img_cmd = $con->prepare("SELECT image FROM tbl_ssports_images WHERE ssports_id = ?");
                                                $img_cmd->bind_param("i", $ssports_id);
                                                $img_cmd->execute();
                                                $img_result = $img_cmd->get_result();
                                                $images = [];
                                                while ($img_row = $img_result->fetch_assoc()) {
                                                    $images[] = $img_row['image'];
                                                }
                                        ?>
                                        <tr align="center">
                                            <td scope="row"><?php echo htmlspecialchars($ssports_id); ?></td>
                                            <td scope="row"><?php echo htmlspecialchars($ssports_type); ?></td>
                                            <td scope="row"><?php echo htmlspecialchars($ssports_title); ?></td>
                                            <td scope="row"><?php echo $ssports_description; ?></td>
                                            
                                            <td scope="row">
                                                <a href="<?php echo "../uploads/ssports/report/" . htmlspecialchars($report); ?>" target="_blank"><?php echo htmlspecialchars($report); ?></a>
                                            </td>
                                            <td scope="row">
                                                <div class="image-container">
                                                    <?php
                                                        foreach ($images as $image) {
                                                            $imagePath = "../uploads/ssports/report_thumbnail/" . htmlspecialchars($image);
                                                            if (file_exists($imagePath)) {
                                                                echo '<a href="' . $imagePath . '" target="_blank">
                                                                    <img src="' . $imagePath . '" alt="Image" class="image-preview">
                                                                </a>';
                                                            } else {
                                                                echo '<span>No image found</span>';
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                            <td scope="row">
                                                <a href="report_edit.php?ssports_id=<?php echo urlencode($row['ssports_id']) ?>" class="btn btn-primary"><i class="fas fa-pencil"></i></a>
                                                  <?php if($role_id == 11) { ?>
                                                <a href="report_delete.php?ssports_id=<?php echo urlencode($row['ssports_id']) ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                  <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>type</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Report</b></th>
                                            <th scope="row" style="color:black;"><b>Images</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <?php include '../include/importjs.php'; ?>
</body>

</html>
