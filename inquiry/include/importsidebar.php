<style>
    .os-viewport {
        bottom: 22px;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link" style="background-color : #fff; display: flex; align-items: center; justify-content: center;">
        <img src="../../website_assets/images/logo3.png" alt="logo" style="width : 70%; position: relative; left: -6px;">
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
        if ($role_id == 12 || $role_id == 11) {
        ?>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="../common/dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <?php if ($role_id == 12) { ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-layer-group"></i>
                                <p>Manage Inquiry Student<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../students/student_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Students</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../students/upload_csv.php" class="nav-link">
                                        <i class="fa-solid fa-upload nav-icon"></i>
                                        <p>Upload CSV</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($role_id == 11) { ?>
                        <li class="nav-item">
                            <a href="../admin/assign_inquiry.php" class="nav-link">
                                <i class="fas fa-layer-group"></i>
                                <p>View Assign Data</p>
                            </a>
                           
                        </li>
                         <li class="nav-item">
                            <a href="../admin/reassign_inquiry.php" class="nav-link">
                                <i class="fas fa-layer-group"></i>
                                <p>View Reassign Data</p>
                            </a>
                           
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a href="../students/student_view.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>View Students</p>
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Manage Calling Script & Policy<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../admin/doc_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Calling Script & Policy</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../admin/doc_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Calling Script & Policy</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="../staff/call_report.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>Calls Report</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../admin/daily_call_report.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>Calls Summery</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-address-card"></i>
                            <p>Manage Staff Details<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($role_id == 12) { ?>
                                <li class="nav-item">
                                    <a href="../admin/staff_insert.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Staff Details</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a href="../admin/staff_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Staff Details</p>
                                </a>
                            </li>
                            <?php if ($role_id == 12) { ?>
                                <li class="nav-item">
                                    <a href="../staff/upload_csv.php" class="nav-link">
                                        <i class="fa-solid fa-upload nav-icon"></i>
                                        <p>Upload CSV</p>
                                    </a>
                                </li>
                                 <?php if ($name == 'INQUIRY ADMIN') { ?>
                                 <li class="nav-item">
                                    <a href="../admin/staff.php" class="nav-link">
                                       <i class="far fa-circle nav-icon"></i>
                                        <p>Multi Staff Delete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../admin/staff_view_hod.php" class="nav-link">
                                       <i class="far fa-circle nav-icon"></i>
                                        <p>INQUIRY HEAD Details</p>
                                    </a>
                                </li>
                                
                            <?php }
                            } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Manage Call Status<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($role_id == 12) { ?>
                                <li class="nav-item">
                                    <a href="../admin/call_status_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Call Status</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a href="../admin/call_status_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Call Status</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>View Student Inquiry<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../students/student_status_remarks.php?url_for=inq" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Inquiry Remarks</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-handshake-angle"></i>
                            <p>Manage Marketing Visit<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../inquiry_head/visit_report.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>Marketing Visit Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../counselor/marketing_visit_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Marketing Visit</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-tasks"></i>
                            <p>Manage Task<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../inquiry_head/dailytask_report.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>Daily Task Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../inquiry_head/daily_remark.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>Task Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../counselor/dailytask_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Daily Task</p>
                                </a>
                            </li>
                            
                             <?php if ($role_id == 11) { ?>
                                <li class="nav-item">
                                    <a href="../inquiry_head/add-week-review.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>Add Weekly Remark</p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="../inquiry_head/week_review.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>View Weekly Remark</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="../common/logout.php" class="nav-link">
                            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
                            <p>Log out</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        <?php
        }elseif ($role_id == 15) {
        ?>
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
                    <!--  <li class="nav-item">-->
                    <!--    <a href="../counselor/student_list.php" class="nav-link">-->
                    <!--        <i class="fa-solid fa-eye nav-icon"></i>-->
                    <!--        <p>View Inquiry Students list</p>-->
                    <!--    </a>-->
                    <!--</li>-->
                    <li class="nav-item">
                        <a href="../staff/view_assign_student.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>View Assign Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../staff/completed_calls.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>View called Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../common/logout.php" class="nav-link">
                            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
                            <p>Log out</p>
                        </a>
                    </li>


                </ul>
            </nav>
        <?php
        } 
        elseif ($role_id == 31)  {
         ?>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="../common/dashboard.php" class="nav-link">
                   <i class="nav-icon fas fa-tachometer-alt"></i>
                   <p>Dashboard</p>
                </a>
            </li>
             <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa-solid fa-handshake-angle"></i>
                                <p>Manage Marketing Visit<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../counselor/marketing_visit_add.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>Add Marketing Visit</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../counselor/marketing_visit_view.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>View Marketing Visit</p>
                                    </a>
                                </li>
                            </ul>
            </li>
            <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-tasks"></i>
                                <p>Manage Task<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../counselor/dailytask_add.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Daily Task </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../counselor/dailytask_view.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>View Daily Task</p>
                                    </a>
                                </li>
                            </ul>
            </li>
             </ul>
        </nav>
        <?php
        }
        elseif ($role_id == 14|| $role_id == 22 || $role_id == 23) {
        ?>
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
                    <!-- <li class="nav-item">
                        <a href="../inquiry_head/assign_student.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>Assign Students</p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                          <?php if ($role_id == 23) {   ?> 
                               <a href="../staff/call_report.php" class="nav-link">
                           <?php   } else { ?>
                           <a href="../inquiry_head/staff_call_report.php" class="nav-link">
                           <?php   }  ?>
                           
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>Calls Report</p>
                        </a>
                    </li>

                    </li>
                   
                     <?php if ($role_id == 22) {   ?> 
                       <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa-solid fa-handshake-angle"></i>
                                <p>Manage Marketing Visit<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../counselor/marketing_visit_add.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>Add Marketing Visit</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../counselor/marketing_visit_view.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>View Marketing Visit</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                        <a href="../inquiry_head/visit_report.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>Marketing Visit Report</p>
                        </a>
                         </li>
                    <?php   } elseif ($role_id == 23) { ?>
                    <!--Kedar Sir Outreach role-->
                         <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-address-card"></i>
                            <p>Manage Staff Details<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                           
                                <li class="nav-item">
                                    <a href="../admin/staff_insert.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Staff Details</p>
                                    </a>
                                </li>
                           
                            <li class="nav-item">
                                <a href="../admin/staff_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Staff Details</p>
                                </a>
                            </li>
                           
                        </ul>
                    </li>
                        <li class="nav-item">
                        <a href="../inquiry_head/visit_report.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>Marketing Visit Report</p>
                        </a>
                         </li>
                      <li class="nav-item">
                        <a href="../inquiry_head/dailytask_report.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>Daily Task Report</p>
                        </a>
                        </li>
                    <?php }  elseif ($role_id == 23 || $role_id ==  22) { ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-tasks"></i>
                            <p>Manage Task<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../inquiry_head/dailytask_report.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>Daily Task Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../counselor/dailytask_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Daily Task</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                     <?php } ?>

                     <li class="nav-item">
                        <a href="../common/logout.php" class="nav-link">
                            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
                            <p>Log out</p>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
        } elseif ($role_id == 16 || $role_id == 20 || $role_id == 21 || $role_id == 25 || $role_id == 26 || $role_id == 28 || $role_id == 30 ) { ?>
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
                    <!--<li class="nav-item">-->
                    <!--    <a href="../counselor/student_list.php" class="nav-link">-->
                    <!--        <i class="fa-solid fa-eye nav-icon"></i>-->
                    <!--        <p>View Inquiry Students list</p>-->
                    <!--    </a>-->
                    <!--</li>-->
                    <li class="nav-item">
                        <a href="../counselor/conform_admission_list.php" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>View confirm Admission list</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Manage Inquiry Calls<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../inquiry/staff/view_assign_student.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Assign Students</p>
                                </a>
                            </li>




                            <li class="nav-item">
                                <a href="../inquiry/staff/completed_calls.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View called Students</p>
                                </a>

                            </li>
                        </ul>
                    </li>

                     <?php if ( $role_id == 16 || $role_id == 20 ||$role_id == 21 || $role_id == 26 || $role_id == 28 || $role_id == 30 ) {   ?>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa-solid fa-handshake-angle"></i>
                                <p>Manage Marketing Visit<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../counselor/marketing_visit_add.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>Add Marketing Visit</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../counselor/marketing_visit_view.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>View Marketing Visit</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if ( $role_id == 16 || $role_id == 20 || $role_id == 21 || $role_id == 25 || $role_id == 26 || $role_id == 28 || $role_id == 30) {   ?>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-tasks"></i>
                                <p>Manage Task<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../counselor/dailytask_add.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Daily Task </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../counselor/dailytask_view.php" class="nav-link">
                                        <i class="fa-solid fa-eye nav-icon"></i>
                                        <p>View Daily Task</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    
                    

                    <li class="nav-item">
                        <a href="../common/logout.php" class="nav-link">
                            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
                            <p>Log out</p>
                        </a>
                    </li>


                </ul>
            </nav>
        <?php

        } elseif ($role_id == 13) {
        ?>
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
                        <a href="../students/student_insert.php" class="nav-link">
                            <i class="fa-solid fa-plus nav-icon"></i>
                            <p>Add Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../students/student_view.php?url_for=inq" class="nav-link">
                            <i class="fa-solid fa-eye nav-icon"></i>
                            <p>View Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../common/logout.php" class="nav-link">
                            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
                            <p>Log out</p>
                        </a>
                    </li>
                </ul>
            </nav>
         <?php } elseif ($role_id == 59) { ?>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-tasks"></i>
                            <p>Manage Task<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../counselor/dailytask_add.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Daily Task </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../counselor/dailytask_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Daily Task</p>
                                </a>
                            </li>
                        </ul>
                    </li>
            </nav>
        <?php } ?>
    </div>
    <!-- /.sidebar -->
</aside>