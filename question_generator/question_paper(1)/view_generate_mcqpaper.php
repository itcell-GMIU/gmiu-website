<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if ($role_id == 51) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include '../include/importhead.php'; ?>
        <?php include '../include/importcss.php'; ?>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Navbar -->
            <?php include '../include/importnav.php'; ?>
            <!-- Sidebar -->
            <?php include '../include/importsidebar.php'; ?>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Header -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">View MCQ Paper</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">View MCQ Paper</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header text-center">
                                <h5><b><i class="fas fa-book-reader"></i> View MCQ Paper</b></h5>
                            </div>
                            <div class="card-body">
                                <!-- + ADD Button  -->
                                <a class="btn btn-primary mb-2 float-right" href="generate_mcq_paper.php">
                                    <i class="fa-solid fa-plus"></i> Add
                                </a>
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                        <thead>
                                            <tr align="center">
                                                <th>Faculty</th>
                                                <th>Level</th>
                                                <th>Program</th>
                                                <th>Sem</th>
                                                <th>Subject Name</th>
                                                <th>Total Marks</th>
                                                <th>Paper</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 0;

                                            // ✅ Fetch only active, non-deleted papers
                                            $cmd = $con->prepare("
                                            SELECT pm.paper_id, pm.faculty_id, pm.level_id, pm.program_id, pm.sem, 
                                                   pm.subject_code, pm.t_marks, pm.created_at,
                                                   f.name AS faculty_name, 
                                                   l.name AS level_name, 
                                                   p.name AS program_name, 
                                                   s.subject_name
                                            FROM tbl_paper_mcq pm
                                            
                                            LEFT JOIN tbl_faculty f ON pm.faculty_id = f.id
                                            LEFT JOIN tbl_level l ON pm.level_id = l.id
                                            LEFT JOIN tbl_program p ON pm.program_id = p.id
                                            LEFT JOIN tbl_std_corner_exam s ON pm.subject_code = s.id
                                            WHERE pm.is_delete = ?
                                            ORDER BY pm.created_at DESC
                                        ");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();

                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['paper_id'];
                                                $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                                $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                                $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                                $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                                $subject_code = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                                $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                $marks = !empty($row['t_marks']) ? $row['t_marks'] : "<b>N/A</b>";
                                            ?>
                                                <tr align="center">
                                                    <td><?php echo $faculty_name; ?></td>
                                                    <td><?php echo $level_name; ?></td>
                                                    <td><?php echo $program_name; ?></td>
                                                    <td><?php echo $sem; ?></td>
                                                    <td><?php echo $subject_name; ?></td>
                                                    <td><?php echo $marks; ?></td>
                                                    <td>
                                                        <a href="mcq_paper.php?id=<?php echo $id ?>" target="_blank" class="btn btn-success btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <!-- <a href="without-co-bl-level.php?id=<?php echo $id ?>" target="_blank" class="btn btn-primary btn-sm">
                                                            Without CO
                                                        </a> -->
                                                    </td>
                                                    <td>
                                                        <a href="edit_generate_mcqpaper.php?id=<?php echo $id ?>" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="delete_mcqpaper.php?id=<?php echo $id ?>" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr align="center">
                                                <th>Faculty</th>
                                                <th>Level</th>
                                                <th>Program</th>
                                                <th>Sem</th>
                                                <th>Subject Name</th>
                                                <th>Total Marks</th>
                                                <th>Paper</th>
                                                <th>Action</th>
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
            <?php include '../include/importjs.php'; ?>
        </div>
    </body>

    </html>
<?php } ?>