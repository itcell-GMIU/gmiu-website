<?php


include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Workshop List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Workshop</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Faculty list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i> View Workshop</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- + ADD Button -->
                                <a class="btn btn-primary" style="margin-left: 90%;" href="workshop_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                                <!-- + ADD Button End -->
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Workshop Date </b></th>
                                            <th scope="row" style="color:black;"><b>Workshop Name</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        if ($role_id == 8) {
                                              // Explode the $level_id string into an array of individual level IDs
                                              $level_ids_array = explode(',', $level_id);

                                              // Create a placeholder string for the IN clause in SQL
                                              $level_placeholder = str_repeat('?,', count($level_ids_array) - 1) . '?';
                                              $cmd = $con->prepare("SELECT workshop.faculty_id as faculty_id, workshop.level_id as level_id, 
                                              workshop.program_id as program_id,workshop.id as workshop_id,workshop.title as workshop_title,workshop.date as date,
                                                 workshop.year as workshop_year, faculty.name as faculty_name, level.name as level_name, program.name as program_name FROM tbl_workshop as workshop
                                                LEFT JOIN tbl_faculty faculty ON workshop.faculty_id = faculty.id 
                                                LEFT JOIN tbl_level level ON workshop.level_id = level.id
                                                LEFT JOIN tbl_program program ON workshop.program_id = program.id  WHERE workshop.is_delete = ?
                                                AND workshop.faculty_id = ? and workshop.level_id  in($level_placeholder) and workshop.program_id IN ($program_id)");
                                                
                                                
                                        //     $cmd = $con->prepare("SELECT faculty.name as faculty_name,level.name as level, program.name as program_name,workshop.id as workshop_id,workshop.title as workshop_title,workshop.date as date,workshop.year as workshop_year FROM tbl_workshop as workshop
                                        //         LEFT JOIN tbl_faculty faculty ON workshop.faculty_id = faculty.id 
                                        //         LEFT JOIN tbl_level level ON workshop.level_id = level.id
                                        //         LEFT JOIN tbl_program program ON workshop.program_id = program.id  WHERE workshop.is_delete = ? AND Workshop.faculty_id = ? and workshop.level_id  in($level_id) and workshop.program_id =? ");
                                        //    // $cmd->bind_param("iis", $status, $faculty_id, $program_id);
                                              // Bind parameters with the IN clause using a loop
                                              $params = array_merge([$status , $faculty_id], $level_ids_array);
                                              $types = str_repeat('i', count($params));
                                              $bind_params = [$types];
  
                                              foreach ($params as &$param) {
                                                  $bind_params[] = &$param; // Pass each parameter by reference
                                              }
  
                                              call_user_func_array([$cmd, 'bind_param'], $bind_params);

                                            // $cmd->bind_param("ssi", $enrollnment_no, $seat_no, $exam_id);
                                            // $cmd->execute();
                                            // $result = $cmd->get_result();
  
                                        } else {
                                            $cmd = $con->prepare("SELECT workshop.faculty_id as faculty_id, workshop.level_id as level_id,
                                            workshop.program_id as program_id, faculty.name as faculty_name,level.name as level, program.name as 
                                            program_name,workshop.id as workshop_id,workshop.title as workshop_title,workshop.date as date,
                                            workshop.year as workshop_year FROM tbl_workshop as workshop
                                            LEFT JOIN tbl_faculty faculty ON workshop.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON workshop.level_id = level.id
                                            LEFT JOIN tbl_program program ON workshop.program_id = program.id  WHERE workshop.is_delete = ?");
                                             $cmd->bind_param("i", $status);
                                        }
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $workshop_id = $row['workshop_id'];
                                            $report = !empty($row['report']) ? $row['report'] : "<b>N/A</b>";
                                            $date = !empty($row['date']) ? $row['date'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level = !empty($row['level']) ? $row['level'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";

                                            $workshop_title = !empty($row['workshop_title']) ? $row['workshop_title'] : "<b>N/A</b>";
                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $workshop_id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $faculty_name; ?>
                                                </td>
                                                <td scope="row">
                                                <?php
                                                    // Split the level IDs into an array
                                                    $level_ids = explode(',', $row['level_id']);

                                                    // Initialize an empty array to store level names
                                                    $level_names = array();

                                                    // Loop through each level ID and fetch its name
                                                    foreach ($level_ids as $level_id) {
                                                        // Fetch the level name from the database using $level_id
                                                        $level_name_query = $con->prepare("SELECT name FROM tbl_level WHERE id = ?");
                                                        $level_name_query->bind_param("i", $level_id);
                                                        $level_name_query->execute();
                                                        $level_name_result = $level_name_query->get_result();

                                                        // Fetch the level name from the result
                                                        if ($level_name_row = $level_name_result->fetch_assoc()) {
                                                            // Store the level name in the array
                                                            $level_names[] = $level_name_row['name'];
                                                        }
                                                    }

                                                    // Output the level names separated by commas
                                                    echo implode(', ', $level_names);
                                                    ?>
                                                </td>

                                                 <td scope="row">
                                                    <?php
                                                    // Split the program IDs into an array
                                                    $program_ids = explode(',', $row['program_id']);

                                                    // Initialize an empty array to store program names
                                                    $program_names = array();

                                                    // Loop through each program ID and fetch its name
                                                    foreach ($program_ids as $program_id) {
                                                        // Fetch the program name from the database using $program_id
                                                        $program_name_query = $con->prepare("SELECT name FROM tbl_program WHERE id = ?");
                                                        $program_name_query->bind_param("i", $program_id);
                                                        $program_name_query->execute();
                                                        $program_name_result = $program_name_query->get_result();

                                                        // Fetch the program name from the result
                                                        if ($program_name_row = $program_name_result->fetch_assoc()) {
                                                            // Store the program name in the array
                                                            $program_names[] = $program_name_row['name'];
                                                        }
                                                    }

                                                    // Output the program names separated by commas
                                                    echo implode(', ', $program_names);
                                                    ?>
                                                    <!-- <?php echo $program_name; ?> -->
                                                </td>

                                                </td>


                                                <td scope="row">
                                                    <?php echo $date; ?>
                                                </td>


                                                <td scope="row">
                                                    <?php echo $workshop_title; ?>
                                                </td>

                                                <td scope="row">
                                                    <a href="workshop_edit.php?workshop_id=<?php echo $row['workshop_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="workshop_delete.php?workshop_id=<?php echo $row['workshop_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Workshop Date </b></th>
                                            <th scope="row" style="color:black;"><b>Workshop Name</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
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
</body>

</html>