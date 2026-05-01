<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link"
        style="background-color : #fff; display: flex; align-items: center; justify-content: center;">
        <img src="../website_assets/images/logo3.png" alt="logo" style="width : 70%; position: relative; left: -6px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

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
                    <a href="view_student.php" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-import"></i>
                        <p>Fill PAC Form</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="view_pac.php" class="nav-link">
                    <i class="nav-icon fa-solid fa-eye"></i>
                        <p>View PAC Details</p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="branch_transfer.php" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-import"></i>
                        <p>Student Branch Transfer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_branch_request.php" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-import"></i>
                        <p>view Branch Transfer Request</p>
                    </a>
                </li>
                
                   <li class="nav-item">
                    <a href="cancel_admission.php" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-import"></i>
                        <p>Student Cancellation Request</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="view_cancellation_requests.php" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-import"></i>
                        <p>view Cancellation Request</p>
                    </a>
                </li>


                 <li class="nav-item">
                     <a href="student_list.php" class="nav-link">
                        <i class="fa-solid fa-eye nav-icon"></i>
                        <p>Manage Confirm Admission</p>
                      </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>