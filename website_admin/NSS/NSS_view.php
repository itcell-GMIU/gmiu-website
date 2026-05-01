<?php
include '../include/checklogin.php';
error_reporting(E_ALL); 
error_reporting(-1);
ini_set('error_reporting', E_ALL); 
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
                            <h1 class="m-0">View NSS List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View NSS</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i> View NSS</b></h5>
                                </center>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a class="btn btn-primary" style="margin-left: 90%;" href="NSS_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
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
                                            $cmd = $con->prepare("SELECT NSS.id as NSS_id, NSS.report_title as NSS_title, NSS.description as NSS_description, NSS.report as report, NSS.report_thumbnail as report_thumbnail FROM tbl_NSS as NSS WHERE NSS.is_delete = ?");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $NSS_id = $row['NSS_id'];
                                                $NSS_title = !empty($row['NSS_title']) ? $row['NSS_title'] : "<b>N/A</b>";
                                                $NSS_description = !empty($row['NSS_description']) ? $row['NSS_description'] : "<b>N/A</b>";
                                                $report_thumbnail = !empty($row['report_thumbnail']) ? $row['report_thumbnail'] : "<b>N/A</b>";
                                                $report = !empty($row['report']) ? $row['report'] : "<b>N/A</b>";

                                                // Fetch related images
                                                $img_cmd = $con->prepare("SELECT image FROM tbl_nss_images WHERE nss_id = ?");
                                                $img_cmd->bind_param("i", $NSS_id);
                                                $img_cmd->execute();
                                                $img_result = $img_cmd->get_result();
                                                $images = [];
                                                while ($img_row = $img_result->fetch_assoc()) {
                                                    $images[] = $img_row['image'];
                                                }
                                        ?>
                                        <tr align="center">
                                            <td scope="row"><?php echo htmlspecialchars($NSS_id); ?></td>
                                            <td scope="row"><?php echo htmlspecialchars($NSS_title); ?></td>
                                            <td scope="row"><?php echo htmlspecialchars_decode($NSS_description); ?></td>
                                            
                                            <td scope="row">
                                                <a href="<?php echo "../uploads/NSS/report/" . htmlspecialchars($report); ?>" target="_blank"><?php echo htmlspecialchars($report); ?></a>
                                            </td>
                                            <td scope="row">
                                                <div class="image-container">
                                                    <?php
                                                        foreach ($images as $image) {
                                                            $imagePath = "../uploads/NSS/report_thumbnail/" . htmlspecialchars($image);
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
                                                  <?php if($role_id == 11) { ?>
                                                <a href="NSS_delete.php?NSS_id=<?php echo urlencode($row['NSS_id']) ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                <?php } ?>
                                                <a href="NSS_edit.php?NSS_id=<?php echo urlencode($row['NSS_id']) ?>" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
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
