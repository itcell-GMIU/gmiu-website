<?php
include 'include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../admin_assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../admin_assets/dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>

                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#personal_info" data-toggle="tab">Personal Information</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#Academic_Information" data-toggle="tab">Academic Information</a></li>

                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="card">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="personal_info">
                                                <div class="card-header">
                                                    <h3 class="card-title">

                                                        <ion-icon name="person-outline"></ion-icon>
                                                        Personal Information
                                                    </h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">Name</div>
                                                        <div class="col-sm"><?php echo $name; ?></div>
                                                        <!--<div class="col-sm"><a href="editProfile.php"><i class="fas fa-edit"></i></a></div>-->
                                                        <div class="col-6">Enrollmnet Number</div>
                                                        <div class="col-sm"><?php echo $er_no; ?></div>
                                                        <div class="col-6">DOB</div>
                                                        <div class="col-sm"><?php echo $dob; ?></div>
                                                        <!--<div class="col-sm"><a href="editProfile.php"><i class="fas fa-edit"></i></a></div>-->
                                                        <div class="col-6">Gender</div>
                                                        <div class="col-sm"><?php echo $gender; ?></div>
                                                        <!--<div class="col-sm"><a href="editProfile.php"><i class="fas fa-edit"></i></a></div>-->
                                                        <div class="col-6">Phone</div>
                                                        <div class="col-sm"><?php echo $mobile_number; ?></div>
                                                        <!--<div class="col-sm"><a href="editProfile.php"><i class="fas fa-edit"></i></a></div>-->
                                                        <div class="col-6">Address</div>
                                                        <div class="col-sm"><?php echo $address; ?></div>
                                                        <!--<div class="col-sm"><a href="editProfile.php"><i class="fas fa-edit"></i></a></div>-->
                                                        <div class="col-6">Email</div>
                                                        <div class="col-sm"><?php echo $email; ?></div>
                                                        <!--<div class="col-sm"><a href="editProfile.php"><i class="fas fa-edit"></i></a></div>-->
                                                        <div class="col-6">Parent's Phone</div>
                                                        <div class="col-sm"><?php echo $parent_mobile_number; ?></div>
                                                        <div class="col-6">Parent's Email</div>
                                                        <div class="col-sm"><?php echo $parent_email_id; ?></div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>

                                            <div class="tab-pane" id="Academic_Information">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">

                                                            <ion-icon name="person-outline"></ion-icon>
                                                            Academic Information
                                                        </h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <dl class="row">
                                                            <dt class="col-sm-4">Faculty</dt>
                                                            <dd class="col-sm-8"><?php echo $faculty_name; ?></dd>
                                                            <dt class="col-sm-4">Level</dt>
                                                            <dd class="col-sm-8"><?php echo $level_name; ?></dd>
                                                            <dt class="col-sm-4">Program</dt>
                                                            <dd class="col-sm-8"><?php echo $program_name; ?></dd>
                                                            <dt class="col-sm-4">Last Appeard Exam</dt>
                                                            <dd class="col-sm-8"></dd>
                                                            <dt class="col-sm-4">CPI</dt>
                                                            <dd class="col-sm-8"></dd>
                                                            <dt class="col-sm-4">CGPA</dt>
                                                            <dd class="col-sm-8"></dd>
                                                            <dt class="col-sm-4">Final Sem</dt>
                                                            <dd class="col-sm-8"></dd>
                                                            <dt class="col-sm-4">Term End</dt>
                                                            <dd class="col-sm-8"></dd>



                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>

        <?php
        include 'include/importfooter.php';
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <!-- ./wrapper -->

    <!-- jQuery -->

    <?php include 'include/importjs.php'; ?>
    <!-- jQuery -->
    <script src="../admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../admin_assets/dist/js/adminlte.min.j"></script>
    <!-- AdminLTE for demo purposes -->

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js">
    </script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js">
    </script>

</body>

</html>