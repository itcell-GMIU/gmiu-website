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
                            <h1 class="m-0">View IKSVE List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View IKSVE</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i> View IKSVE</b></h5>
                                </center>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a class="btn btn-primary" style="margin-left: 90%;" href="activitie_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Participants</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Report</b></th>
                                            <th scope="row" style="color:black;"><b>Images</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT iksve.id as iksve_id, iksve.name as iksve_title, iksve.type_id as iksve_type, iksve.participants as iksve_participants, iksve.description as iksve_description, iksve.report as report FROM tbl_iksve_cell as iksve WHERE iksve.is_delete = ?");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $iksve_id = $row['iksve_id'];
                                                $iksve_title = !empty($row['iksve_title']) ? $row['iksve_title'] : "<b>N/A</b>";
                                                $iksve_type = !empty($row['iksve_type']) ? $row['iksve_type'] : "<b>N/A</b>";
                                                $iksve_participants = !empty($row['iksve_participants']) ? $row['iksve_participants'] : "<b>N/A</b>";
                                                $iksve_description = !empty($row['iksve_description']) ? $row['iksve_description'] : "<b>N/A</b>";
                                                $report_thumbnail = !empty($row['report_thumbnail']) ? $row['report_thumbnail'] : "<b>N/A</b>";
                                                $report = !empty($row['report']) ? $row['report'] : "<b>N/A</b>";
                                                $type = '';
                                                // Determine the type based on type_id
                                                switch ($iksve_type) {
                                                    case 1:
                                                       $type ="FDP";
                                                        break;
                                                    case 2:
                                                        $type ="SDP";
                                                        break;
                                                    case 3:
                                                         $type ="Workshops&Seminars";
                                                        break;
                                                    case 4:
                                                         $type ="Other Activities";
                                                         break;
                                                    default:
                                                       $type ="<b>Unknown</b>";
                                                        break;
                                                        
                                                    }


                                                // Fetch related images
                                                $img_cmd = $con->prepare("SELECT image FROM tbl_iksve_cell_images WHERE iksve_cell_id = ?");
                                                $img_cmd->bind_param("i", $iksve_id);
                                                $img_cmd->execute();
                                                $img_result = $img_cmd->get_result();
                                                $images = [];
                                                while ($img_row = $img_result->fetch_assoc()) {
                                                    $images[] = $img_row['image'];
                                                }
                                        ?>
                                        <tr align="center">
                                            <td scope="row"><?php echo htmlspecialchars($iksve_id); ?></td>
                                            <td scope="row"><?php echo htmlspecialchars($iksve_title); ?></td>
                                            <td scope="row"><?php echo htmlspecialchars( $type); ?></td>
                                            <td scope="row"><?php echo htmlspecialchars($iksve_participants); ?></td>
                                            <td scope="row"><?php echo $iksve_description; ?></td>
                                            
                                            <td scope="row">
                                                <a href="<?php echo "../uploads/iksve_cell/" . $report; ?>" target="_blank"><?php echo $report; ?></a>
                                            </td>
                                            <td scope="row">
                                                <div class="image-container">
                                                    <?php
                                                        foreach ($images as $image) {
                                                            $imagePath = "../uploads/iksve_cell/" . htmlspecialchars($image);
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
                                               
                                                <a href="activitie_edit.php?id=<?php echo $iksve_id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                  <?php if($role_id == 11) { ?>
                                                <a href="activities_delete.php?ic_id=<?php echo $iksve_id; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                 <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Participants</b></th>
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
