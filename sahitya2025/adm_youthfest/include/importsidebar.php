<style>
    .os-viewport {
        bottom: 22px;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link" style="background-color : #fff; display: flex; align-items: center; justify-content: center;">
    <h4 class="text-dark font-weight-bold">Youthfest <?= date('Y') ?></h4>
        <!-- <img src="../../website_assets/images/logo3.png" alt="logo" style="width : 70%; position: relative; left: -6px;"> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!--   <img src="../admin_assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            <div class="info" style="color:darkgrey;">
                <i class="fa-solid fa-user"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $name; ?>
            </div>
        </div>
        <?php
        // Inquiry Main Admin
        if ($role_id == 1) {
        ?>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="../common/dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../common/reports.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../mng_comp/brochure_insert.php" class="nav-link">
                            <i class="nav-icon fas fa-plus"></i>
                            <p>Add Compitition</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../mng_comp/brochure_view.php" class="nav-link">
                            <i class="nav-icon fas fa-eye"></i>
                            <p>View Compitition</p>
                        </a>
                    </li>
                    
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <p>Registrations<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../student_info/student_credential.php" class="nav-link">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>View Registrations</p>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        <?php
        } elseif ($role_id == 52) { ?>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="../common/dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-users"></i>
                            <p>Manage Marks<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <?php
                        if ($ex_role == 1 || $ex_role == 3) {
                        ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../resultsMng/add_marks.php" class="nav-link">
                                        <i class="fas fa-pencil-square nav-icon"></i>
                                        <p>Add Theory Marks</p>
                                    </a>
                                </li>
                            </ul>
                        <?php } ?>
                        <?php
                        if ($ex_role == 2 || $ex_role == 3) {
                        ?>
                            <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../resultsMng/add_marks.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Add Practical Marks</p>
                                </a>
                            </li>
                        </ul> -->
                        <?php } ?>
                    </li>
                </ul>
            </nav>
        <?php } ?>
    </div>
    <!-- /.sidebar -->
</aside>