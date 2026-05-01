<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link"
        style="background-color : #fff; display: flex; align-items: center; justify-content: center;">
        <img src="../website_assets/images/logo3.png" alt="logo" style="width : 70%; position: relative; left: -6px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fa-solid fa-user"></i>
                        <p><?php echo "$name"; ?></p>
                    </a>
                    <hr style="background-color: #4f5962;">
                </li>



                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="total_student.php" class="nav-link">
                        <i class="nav-icon fa fa-user-friends"></i>
                        <p>Total Students</p>
                    </a>
                </li>
                <!--<li class="nav-item">-->
                <!--    <a href="view_final_student.php" class="nav-link">-->
                <!--        <i class="nav-icon fas fa-graduation-cap"></i>-->
                <!--        <p>Current Students</p>-->
                <!--    </a>-->
                <!--</li>-->

                <li class="nav-item">
                    <a href="import_ad_student.php" class="nav-link">
                        <i class="nav-icon fa fa-upload"></i>
                        <p>Import Final Students</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="import_student.php" class="nav-link">
                        <i class="nav-icon fa fa-upload"></i>
                        <p>Import Students</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="import_export_student.php" class="nav-link">
                        <i class="nav-icon fa fa-user-friends"></i>
                        <p>Import/Export Students</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_pac_student.php" class="nav-link">
                        <i class="nav-icon fa fa-eye"></i>
                        <p>PAC Details</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                        <p>Log Out</p>
                        </p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="view_student.php" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            View Students
                            <i class="fas fa-angle-left right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="view_student.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Registered Student</p>
                            </a>
                        </li>

                    </ul>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Log Out</p>
                    </a>
                </li> -->


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>