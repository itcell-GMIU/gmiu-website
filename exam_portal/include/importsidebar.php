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
        if ($role_id == 51) {
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
                        <a href="#" class="nav-link">
                            <i class="fa fa-file-text-o"></i>
                            <p>Manage Exam Form<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../exam_form/exam_form_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Exam Forms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../exam_form/exam_form_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Exam Forms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../subject/import_student_subject.php" class="nav-link">
                                    <i class="fa-solid fa-upload nav-icon"></i>
                                    <p>Upload Student Subject</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-file-text-o"></i>
                                    <p> Exam Form Actions<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../exam_form/exam_form_actions.php" class="nav-link">
                                            <i class="fa-solid fa-times nav-icon"></i>
                                            <p>Reject Exam Forms</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!--<li class="nav-item">-->
                    <!--    <a href="#" class="nav-link">-->
                    <!--        <i class="fas fa-book"></i>-->
                    <!--        <p>Manage Subjects<i class="right fas fa-angle-left"></i></p>-->
                    <!--    </a>-->
                    <!--    <ul class="nav nav-treeview">-->
                    <!--        <li class="nav-item">-->
                    <!--            <a href="../subject/student_corner_insert.php" class="nav-link">-->
                    <!--                <i class="fa-solid fa-plus nav-icon"></i>-->
                    <!--                <p>Add Subject</p>-->
                    <!--            </a>-->
                    <!--        </li>-->
                    <!--        <li class="nav-item">-->
                    <!--            <a href="../students/student_view.php" class="nav-link">-->
                    <!--                <i class="fa-solid fa-eye nav-icon"></i>-->
                    <!--                <p>View Subject</p>-->
                    <!--            </a>-->
                    <!--        </li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-graduation-cap"></i>
                            <p>Student Info<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../student_info/student_credential.php" class="nav-link">
                                    <i class="fas fa-lock nav-icon"></i>
                                    <p>Student Info</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../student_info/student_credential.php" class="nav-link">
                                    <i class="fas fa-file nav-icon"></i>
                                    <p>Student Exam Info</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-calendar"></i>
                            <p>Manage Time Table<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../time_table/time_table_insert.php" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Add Time Table</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../time_table/upload_schedule.php" class="nav-link">
                                    <i class="fas fa-upload nav-icon"></i>
                                    <p>Upload Time Table</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-file"></i>
                            <p>Manage Hall Ticket<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../time_table/publish_hall_ticket.php" class="nav-link">
                                    <i class="fas fa-bullhorn nav-icon"></i>
                                    <p>Publish Hall Ticket</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../exam_form/insert_ht_info.php" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Add/Update Hall Ticket</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-graduation-cap"></i>
                            <p>Manage Course Name<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../short_name/short_name_insert.php" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Add Short Name</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-building"></i>
                            <p>Manage Block Arrangement<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../management/block_arrangement.php" class="nav-link">
                                    <i class="fas fa-download nav-icon"></i>
                                    <p>Generate Block</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../management/barcode_data.php" class="nav-link">
                                    <i class="fas fa-barcode nav-icon"></i>
                                    <p>Barcode Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-users"></i>
                            <p>Manage Exam Staff<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../management/add_exam_staff.php" class="nav-link">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>Exam Staff</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../management/add_hod_staff.php" class="nav-link">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>Add HOD Roles</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-pencil-square"></i>
                            <p>Manage Marks<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../resultsMng/add_marks.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Add Theory Marks</p>
                                </a>
                            </li>
                        </ul>
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../resultsMng/add_marks.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Add Practical Marks</p>
                                </a>
                            </li>
                        </ul> -->
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-edit"></i>
                            <p>Internal Marks<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../excel/generate_excel.php" class="nav-link">
                                    <i class="fas fa-download nav-icon"></i>
                                    <p>Export Excel</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-file"></i>
                            <p>Manage Result<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../resultsMng/publish_result.php" class="nav-link">
                                    <i class="fas fa-bullhorn nav-icon"></i>
                                    <p>Publish Result</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/import_miMarks.php" class="nav-link">
                                    <i class="fas fa-upload nav-icon"></i>
                                    <p>Upload Mid Internal</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/import_external_marks.php" class="nav-link">
                                    <i class="fas fa-upload nav-icon"></i>
                                    <p>Upload ESE Marks</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="../exam_form/insert_ht_info.php" class="nav-link">
                                    <i class="fas fa-edit nav-icon"></i>
                                    <p>Theory Hall Ticket</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../exam_form/insert_ht_info.php" class="nav-link">
                                    <i class="fas fa-edit nav-icon"></i>
                                    <p>Practical Hall Ticket</p>
                                </a>
                            </li> -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-file"></i>
                            <p>Exam Reports<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../resultsMng/overall_report.php" class="nav-link">
                                    <i class="fas fa-file nav-icon"></i>
                                    <p>Overall Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/subject_overall_report.php" class="nav-link">
                                    <i class="fas fa-file nav-icon"></i>
                                    <p>Subject Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-users"></i>
                            <p>Recheck/Reassessment<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../resultsMng/view_assesment.php" class="nav-link">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>Manage Reassessment</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-pencil-square"></i>
                            <p>Manage MI Marks<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../resultsMng/report_pending_mi_marks.php" class="nav-link">
                                    <i class="fas fa-upload nav-icon"></i>
                                    <p>Pending Report (MI Marks)</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/import_mi_master.php" class="nav-link">
                                    <i class="fas fa-upload nav-icon"></i>
                                    <p>Upload Marks Data Sheet</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/mi_mark_settings.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Mid Marks Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/add_mid_marks.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Add Mid Marks</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/add_rmid_marks.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Add Re-Mid Marks</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/add_ala_marks.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Add ALA Marks</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/add_viva_marks.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Add VIVA Marks</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../resultsMng/add_pr_marks.php" class="nav-link">
                                    <i class="fas fa-pencil-square nav-icon"></i>
                                    <p>Add Practical Marks</p>
                                </a>
                            </li>
                        </ul>
                    </li>
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
        <?php } elseif ($role_id == 53) {
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
                        <a href="#" class="nav-link">
                            <i class="fa fa-pencil-square"></i>
                            <p>Manage MI Marks<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php
                            if ($mid_status == 1) {
                            ?>
                                <li class="nav-item">
                                    <a href="../resultsMng/add_mid_marks.php" class="nav-link">
                                        <i class="fas fa-pencil-square nav-icon"></i>
                                        <p>Add Mid Marks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../resultsMng/add_rmid_marks.php" class="nav-link">
                                        <i class="fas fa-pencil-square nav-icon"></i>
                                        <p>Add Re-Mid Marks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../resultsMng/add_ala_marks.php" class="nav-link">
                                        <i class="fas fa-pencil-square nav-icon"></i>
                                        <p>Add ALA Marks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../resultsMng/add_viva_marks.php" class="nav-link">
                                        <i class="fas fa-pencil-square nav-icon"></i>
                                        <p>Add VIVA Marks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../resultsMng/add_pr_marks.php" class="nav-link">
                                        <i class="fas fa-pencil-square nav-icon"></i>
                                        <p>Add Practical Marks</p>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>

                        </ul>
                    </li>
                </ul>
            </nav>
        <?php
        } ?>
    </div>
    <!-- /.sidebar -->
</aside>