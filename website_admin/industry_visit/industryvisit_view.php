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
                            <h1 class="m-0"> View Industry Visit</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active"> View Industry Visit</li>
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
                    <div class="card mb-3">
                        <div class="card">
                            <div class="card-header">
                                <span>
                                    <center>
                                        <h5><b><i class="fas fa-book-reader"></i> View Industry Visit</b></h5>
                                    </center>
                                </span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">


                                <div class="table-responsive">  
                                    <a class="btn btn-primary" style="margin-left: 90%;" href="indvisit_insert.php"><i class="fa-solid fa-plus"></i> Add </a>
                                    <!-- + ADD Button End -->
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                                <th scope="row" style="color:black;"><b>Level</b></th>
                                                <th scope="row" style="color:black;"><b>Program Name</b></th>
                                                <th scope="row" style="color:black;"><b>Visit Date </b></th>
                                                <th scope="row" style="color:black;"><b>Visit Name</b></th>

                                                <th scope="row" style="color:black;"><b>Report</b></th>
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
                                                // Output the contents of the array
                                                // print_r($level_ids_array);
                                                // print_r($level_placeholder);
                                
                                                $sql= "SELECT visit.faculty_id as faculty_id, 
                                                visit.level_id as level_id, 
                                                visit.program_id as program_id, 
                                                level.name as level, 
                                                program.name as program_name, 
                                                visit.id as visit_id, 
                                                visit.date as date, 
                                                visit.visit_name as visit_name, 
                                                visit.report as report, 
                                                visit.visit_year as visit_year, 
                                                faculty.name as faculty_name 
                                                FROM tbl_industry_visit as visit 
                                                LEFT JOIN tbl_faculty faculty ON visit.faculty_id = faculty.id 
                                                LEFT JOIN tbl_level level ON visit.level_id = level.id 
                                                LEFT JOIN tbl_program program ON visit.program_id = program.id 
                                                WHERE visit.is_delete = ?
                                                AND visit.faculty_id = ?
                                                AND visit.level_id IN ($level_placeholder) 
                                                AND visit.program_id IN ($program_id)";
                                                $cmd = $con->prepare($sql);
                                                // Debugging: Print the SQL statement and parameters

                                                // Bind parameters with the IN clause using a loop
                                                $params = array_merge([$status, $faculty_id], $level_ids_array);
                                                $types = str_repeat('i', count($params));
                                                $bind_params = [$types];

                                                foreach ($params as &$param) {
                                                    $bind_params[] = &$param; // Pass each parameter by reference
                                                }
                                                call_user_func_array([$cmd, 'bind_param'], $bind_params);
                                                //  echo "SQL: $sql\n";
                                                //  echo "Parameters: $status, $faculty_id, $level_id, $program_id\n";
                                            } else {
                                              $cmd = $con->prepare("
    SELECT 
        level.name as level,
        GROUP_CONCAT(DISTINCT program.name ORDER BY program.short_no ASC SEPARATOR ', ') as program_name,
        visit.id as visit_id,
        visit.date as date,
        visit.visit_name as visit_name,
        visit.report as report,
        visit.visit_year as visit_year,
        faculty.name as faculty_name,
        visit.faculty_id as faculty_id,
        visit.level_id as level_id,
        visit.program_id as program_id

    FROM tbl_industry_visit as visit 

    LEFT JOIN tbl_faculty faculty 
        ON visit.faculty_id = faculty.id 

    LEFT JOIN tbl_level level 
        ON visit.level_id = level.id

    LEFT JOIN tbl_program program 
        ON FIND_IN_SET(program.id, visit.program_id)

    WHERE visit.is_delete = ?

    GROUP BY visit.id
");

$cmd->bind_param("i", $status);
                                            }
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $visit_id = $row['visit_id'];
                                                $report = !empty($row['report']) ? $row['report'] : "<b>N/A</b>";
                                                $date = !empty($row['date']) ? $row['date'] : "<b>N/A</b>";
                                                $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                                $level = !empty($row['level']) ? $row['level'] : "<b>N/A</b>";
                                                $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                                $visit_name = !empty($row['visit_name']) ? $row['visit_name'] : "<b>N/A</b>";
                                            ?>   
                                                <tr align="center">
                                                    <td scope="row">
                                                        <?php echo $visit_id; ?>
                                                    </td>

                                                    <td scope="row">
                                                        <?php echo $faculty_name; ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php
                                                        // Split the level IDs into an array
                                                        $level_ids = explode(',', $row['level_id']);
                                                        // print_r($level_ids);   
                                                        // Initialize an empty array to store level names
                                                        $level_names = array();

                                                        // Loop through each level ID and fetch its name
                                                        foreach ($level_ids as $level_id) {
                                                            // Fetch the level name from the database using $level_id
                                                            $level_name_query = $con->prepare("SELECT name FROM tbl_level WHERE id = ?");
                                                            $level_name_query->bind_param("i", $level_id);
                                                            $level_name_query->execute();
                                                            $level_name_result = $level_name_query->get_result();

                                                            // Debugging: Output the SQL query and parameters
                                                            // echo "SQL Query: " . $level_name_query->queryString . "<br>";
                                                            // echo "Parameters: $level_id<br>";
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
                                                        <?php echo $program_name; ?>

                                                    </td>

                                                    <td scope="row">
                                                        <?php echo $date; ?>
                                                    </td>


                                                    <td scope="row">
                                                        <?php echo $visit_name; ?>
                                                    </td>

                                                    <td scope="row">
                                                        <a href='../uploads/industry_visit/report/<?php echo $report ?>' target="_blank"> <?php echo $report; ?></a>
                                                    </td>

                                                    <td scope="row">
                                                        <a href="industryvisit_edit.php?visit_id=<?php echo $row['visit_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                           <?php if($role_id == 11) { ?>
                                                        <a href="industryvisit_delete.php?visit_id=<?php echo $row['visit_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                                                <th scope="row" style="color:black;"><b>Visit Date </b></th>
                                                <th scope="row" style="color:black;"><b>Visit Name</b></th>
                                                <th scope="row" style="color:black;"><b>Report</b></th>
                                                <th scope="row" style="color:black;"><b>Manage</b></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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