<?php
// Include the checklogin.php file
include '../include/checklogin.php';


$subject_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($subject_id <= 0) {
    die('Invalid subject ID.');
}

// Fetch subject info (optional, if you want to display subject name/code above the question list)
$subjectInfo = $con->prepare("SELECT subject_code, subject_name FROM tbl_std_corner_exam WHERE id = ?");
$subjectInfo->bind_param("i", $subject_id);
$subjectInfo->execute();
$subjectResult = $subjectInfo->get_result()->fetch_assoc();

// Fetch question list
$query = $con->prepare("SELECT id, chapter, question, mcq_choice_a, mcq_choice_b, mcq_choice_c, mcq_choice_d, marks FROM tbl_questions WHERE subject_code = ? AND marks IN ('1', '2')AND is_delete = 0");
$query->bind_param("i", $subject_id);
$query->execute();
$questions = $query->get_result();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Questions</title>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <!-- wrapper -->
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
                            <h1 class="m-0">View MCQ Question Bank</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View MCQ Question Bank</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3>MCQ Question List for:
                                <span class="text-danger"><?= isset($subjectResult['subject_code']) ? $subjectResult['subject_code'] : 'N/A' ?></span>
                                <?= isset($subjectResult['subject_name']) ? $subjectResult['subject_name'] : '' ?>
                            </h3>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Chapter</th>
                                            <th>Question</th>
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>D</th>
                                            <th>Marks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sr = 1;
                                        while ($row = $questions->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="text-center"><?= $sr++ ?></td>
                                                <td class="text-center"><?= $row['chapter'] ?></td>
                                                <td><?= $row['question'] ?></td>
                                                <td class="text-center"><?= $row['mcq_choice_a'] ?></td>
                                                <td class="text-center"><?= $row['mcq_choice_b'] ?></td>
                                                <td class="text-center"><?= $row['mcq_choice_c'] ?></td>
                                                <td class="text-center"><?= $row['mcq_choice_d'] ?></td>
                                                <td class="text-center"><?= $row['marks'] ?></td>
                                                <?php
                                                if ($role_id == 8 || $role_id == 51 || $role_id == 54) { ?>

                                                    <td scope="row">
                                                        <a href="edit_mcq_question.php?id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="delete_question.php?id=<?php echo $row['id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                <?php }
                                                ?>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($sr === 1) { ?>
                                            <tr>
                                                <td colspan="4" class="text-center"><b>No questions found for this subject.</b></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Chapter</th>
                                            <th>Question</th>
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>D</th>
                                            <th>Marks</th>
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

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <?php include '../include/importjs.php'; ?>
</body>

</html>