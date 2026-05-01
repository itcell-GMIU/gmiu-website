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
                <?php echo "$name"; ?>
            </div>
        </div>

        <?php
        if ($role_id == '6') {
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
                            <i class="fas fa-layer-group"></i>
                            <p>Course<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Manage Level<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../level/level_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Level</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../level/level_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Level</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <p>Manage Faculty<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../faculty/faculty_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Faculty</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../faculty/faculty_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Faculty</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-laptop-code"></i>
                                    <p>Manage Program<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../program/program_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Program</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../program/program_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Program</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Faculty Brochure<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../faculty_brochure/faculty_brochure_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Faculty Brochure</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../faculty_brochure/faculty_brochure_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Faculty Brochure</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                           <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Faculty FAQ<i class="right fas fa-angle-left"></i></p>
                           </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../faculty_FAQ/faculty_FAQ_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Faculty FAQ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../faculty_FAQ/faculty_FAQ_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Faculty FAQ</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                            
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Staff<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-address-card"></i>
                                    <p>Manage Staff Details<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../staff/staff_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Staff Details</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../staff/staff_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Staff Details</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Department<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                           
                             <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <p>Manage Exam Paper<i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../exam_paper/paper_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Exam Paper </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="../exam_paper/paper_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Exam Paper</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-sharp fa-solid fa-laptop-file"></i>
                                    <p>Manage Laboratories<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../laboratories/laboratories_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add laboratory</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../laboratories/laboratories_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View laboratories</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-newspaper"></i>
                                    <p>Manage News & Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-microphone"></i>
                                            <p>Manage Expert Talk <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../expert_talk/expert_talk_insert.php" class="nav-link">
                                                    <i class="fa-solid fa-plus nav-icon"></i>
                                                    <p>Add Expert Talk</p>
                                                </a>
                                                <a href="../expert_talk/expert_talk_view.php" class="nav-link">
                                                    <i class="fa-solid fa-eye nav-icon"></i>
                                                    <p>View Expert Talk</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-house"></i>
                                            <p>Manage Industry Visit <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../industry_visit/indvisit_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Industry Visit</p>
                                                </a>
                                                <a href="../industry_visit/industryvisit_view.php" class="nav-link">
                                                    <i class="fa-solid fa-eye nav-icon"></i>
                                                    <p>View Industry Visit</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-tools"></i>
                                            <p>Manage Workshop <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../workshop/workshop_insert.php" class="nav-link">
                                                    <i class="fa-solid fa-plus nav-icon"></i>
                                                    <p>Add Workshop</p>
                                                </a>
                                                <a href="../workshop/workshop_view.php" class="nav-link">
                                                    <i class="fa-solid fa-eye nav-icon"></i>
                                                    <p>View Workshop</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-laptop-code"></i>
                                            <p>Manage SDP <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../sdp/sdp_insert.php" class="nav-link">
                                                    <i class="fa-solid fa-plus nav-icon"></i>
                                                    <p>Add SDP</p>
                                                </a>
                                                <a href="../sdp/sdp_view.php" class="nav-link">
                                                    <i class="fa-solid fa-eye nav-icon"></i>
                                                    <p>View SDP</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fab fa-pied-piper-square"></i>
                                            <p>Manage Extra Curricular Activity <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fa-solid fa-plus nav-icon"></i>
                                                    <p>Add Curricular Activity</p>
                                                </a>
                                                <a href="#" class="nav-link">
                                                    <i class="fa-solid fa-eye nav-icon"></i>
                                                    <p>View Curricular Activity</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <p>Manage Time Table <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../time_table/timetable_insert.php" class="nav-link">
                                                    <i class="fa-solid fa-plus nav-icon"></i>
                                                    <p>Add Time Table </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="../time_table/timetable_view.php" class="nav-link">
                                                    <i class="fa-solid fa-eye nav-icon"></i>
                                                    <p>View Time Table</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                   
                                    
                                </ul>
                            </li>
                            <li class="nav-item"> <a href="#" class="nav-link"> <i class="fas fa-photo-video"></i>
                                    <p>Manage Student Corner<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item"> <a href="../student_corner/student_corner_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                            <p>Add Student Corner</p>
                                        </a> </li>
                                    <li class="nav-item"> <a href="../student_corner/student_corner_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                            <p>View Student Corner</p>
                                        </a> </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-bullseye"></i>
                                    <p>Manage Mission & Vision<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../mission_vision/mission_vision_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Mission & Vision </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../mission_vision/mission_vision_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Mission & Vision</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-trophy"></i>
                                    <p>Manage Achievement<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../achievement/achievement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Achievement</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../achievement/achievement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Achievement</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-play"></i>
                                    <p>Manage Program Outcome<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../program_outcome/program_outcome_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Program Outcome </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../program_outcome/program_outcome_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Program Outcome</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-play"></i>
                                    <p>Manage Time Table<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../time_table/timetable_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Time Table</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../time_table/timetable_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Time Table</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Campus<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fab fa-slideshare"></i>
                                    <p>Manage Gallery<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../gallery/gallery_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p> Add Gallery Image</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../gallery/gallery_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Gallery Image</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <p>Mandatory Disclosure<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../mandatory_disclosure/mandatory_disclosure_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p> Add Mandatory Disclosure</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../mandatory_disclosure/mandatory_disclosure_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Mandatory Disclosure</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-photo-video"></i>
                                    <p>Manage NSS<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../NSS/about_nss_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add About NSS</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/about_nss_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View About NSS</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_unit_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add NSS Units</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_unit_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View NSS Units</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_advisory_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add NSS Advisory committe</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_advisory_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View NSS Advisory committe</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_contact_us_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Contact Us</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_contact_us_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Contact Us</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/NSS_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add NSS</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/NSS_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Media NSS</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss-gallary_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Photo for Gallery</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss-gallary_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Gallery</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Placement<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-industry"></i>
                                    <p>Manage Training and Placement<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../training_and_placement/training_and_placement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Training and Placement</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../training_and_placement/training_and_placement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Training and Placement</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-laptop-code"></i>
                                    <p>Manage GEPS <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../about_geps/about_geps_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add GEPS</p>
                                        </a>
                                        <a href="../about_geps/about_geps_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View GEPS</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>Manage Placement Statistics<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../placement_statistics/placement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Placement Statistics </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../placement_statistics/placement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Placement Statistics</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>Manage Placement Overview<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../placement_overview/placement_overview_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Placement Overview</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../placement_overview/placement_overview_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Placement Overview</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>

                   

                    

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Website<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- testimonial  -->
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-quote-left"></i>
                                    <p>Manage Testimonial<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../testimonials/testimonial_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Testimonial</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../testimonials/testimonial_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Testimonial</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Manage Circular<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../circular/circular_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Circular</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../circular/circular_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Circular</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Assign Role<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../assign_faculty/assign_faculty_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>Add Role</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                        <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-lightbulb"></i>
                            <p>Startup Cell<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-info-circle"></i>
                                    <p>About Startup<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../about_startup/about_startup_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add About Startup</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../about_startup/about_startup_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View About Startup</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-rocket"></i>
                                    <p>Our Startup<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../our_startup/our_startup_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Startup</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/our_startup_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <p>Startup Club<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../our_startup/startupclub_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Club</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/startupclub_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Club</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-calendar-alt"></i>
                                    <p>Startup Event<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../our_startup/event_list_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Event List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/event_list_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Event List</p>
                                        </a>
                                    </li>
        
                                    <li class="nav-item">
                                        <a href="../our_startup/event_report_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Event Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/event_report_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Event Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-image"></i>
                                    <p>Startup Gallary<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../startup_gallery/startup_gallery_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Gallary</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../startup_gallery/startup_gallery_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Gallary</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Startup Event Report<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../event_report/event_report_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Report</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../event_report/event_report_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        <?php
        } elseif ($role_id == '5') { ?>
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
                            <i class="fas fa-address-card"></i>
                            <p>Manage Staff Details<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../staff/staff_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Staff Details</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../staff/staff_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Staff Details</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-sharp fa-solid fa-laptop-file"></i>
                            <p>Manage Laboratories<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../laboratories/laboratories_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add laboratory</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../laboratories/laboratories_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View laboratories</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item"> <a href="#" class="nav-link"> <i class="fas fa-photo-video"></i>
                            <p>Manage Student Corner<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"> <a href="../student_corner/student_corner_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                    <p>Add Student Corner</p>
                                </a> </li>
                            <li class="nav-item"> <a href="../student_corner/student_corner_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                    <p>View Student Corner</p>
                                </a> </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <p>Manage Exam Paper<i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../exam_paper/paper_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Exam Paper </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="../exam_paper/paper_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Exam Paper</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Placement<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-industry"></i>
                                    <p>Manage Training and Placement<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../training_and_placement/training_and_placement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Training and Placement</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../training_and_placement/training_and_placement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Training and Placement</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>Manage Placement Statistics<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../placement_statistics/placement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Placement Statistics </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../placement_statistics/placement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Placement Statistics</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>Manage Placement Overview<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../placement_overview/placement_overview_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Placement Overview</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../placement_overview/placement_overview_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Placement Overview</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-bullseye"></i>
                            <p>Manage Mission & Vision<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../mission_vision/mission_vision_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Mission & Vision </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../mission_vision/mission_vision_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Mission & Vision</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-play"></i>
                            <p>Manage Program Outcome<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../program_outcome/program_outcome_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Program Outcome </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../program_outcome/program_outcome_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Program Outcome</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-calendar-days"></i>
                            <p>Manage Time Table <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../time_table/timetable_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Time Table </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../time_table/timetable_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Time Table</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-newspaper"></i>
                                    <p>Manage News & Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    
                                    <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-address-card"></i>
                                    <p>Manage Mock interview & Alumni<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../interview_alumni/interview_alumni_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Mock interview & Alumni</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../interview_alumni/interview_alumni_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Mock interview & Alumni</p>
                                        </a>
                                    </li>
        
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-microphone"></i>
                                    <p>Manage Expert Talk <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../expert_talk/expert_talk_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Expert Talk</p>
                                        </a>
                                        <a href="../expert_talk/expert_talk_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Expert Talk</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-house"></i>
                                    <p>Manage Industry Visit <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../industry_visit/indvisit_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Industry Visit</p>
                                        </a>
                                        <a href="../industry_visit/industryvisit_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Industry Visit</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-tools"></i>
                                    <p>Manage Workshop <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../workshop/workshop_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Workshop</p>
                                        </a>
                                        <a href="../workshop/workshop_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Workshop</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-laptop-code"></i>
                                    <p>Manage SDP <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../sdp/sdp_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add SDP</p>
                                        </a>
                                        <a href="../sdp/sdp_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View SDP</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-laptop-code"></i>
                                    <p>Manage GEPS <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../about_geps/about_geps_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add GEPS</p>
                                        </a>
                                        <a href="../about_geps/about_geps_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View GEPS</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--<li class="nav-item">-->
                            <!--    <a href="#" class="nav-link">-->
                            <!--        <i class="fab fa-pied-piper-square"></i>-->
                            <!--        <p>Manage Extra Curricular Activity <i class="right fas fa-angle-left"></i></p>-->
                            <!--    </a>-->
                            <!--    <ul class="nav nav-treeview">-->
                            <!--        <li class="nav-item">-->
                            <!--            <a href="#" class="nav-link">-->
                            <!--                <i class="far fa-circle nav-icon"></i>-->
                            <!--                <p>Add Curricular Activity</p>-->
                            <!--            </a>-->
                            <!--            <a href="#" class="nav-link">-->
                            <!--                <i class="far fa-circle nav-icon"></i>-->
                            <!--                <p>View Curricular Activity</p>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--    </ul>-->
                            <!--</li>-->

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-trophy"></i>
                            <p>Manage Achievement<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../achievement/achievement_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Achievement</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../achievement/achievement_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Achievement</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    
                            
                                <!--<li class="nav-item">-->
                                <!--    <a href="#" class="nav-link">-->
                                <!--        <i class="fas fa-layer-group"></i>-->
                                <!--        <p>IKSVE CELL<i class="right fas fa-angle-left"></i></p>-->
                                <!--    </a>-->
                                <!--    <ul class="nav nav-treeview">-->
                                <!--        <li class="nav-item">-->
                                <!--            <a href="../iksve/activities_insert.php" class="nav-link">-->
                                <!--                <i class="fa-solid fa-plus nav-icon"></i>-->
                                <!--                <p>Add IKSVE Activity</p>-->
                                <!--            </a>-->
                                <!--        </li>-->
                                <!--        <li class="nav-item">-->
                                <!--            <a href="../iksve/activities_view.php" class="nav-link">-->
                                <!--                <i class="fa-solid fa-eye nav-icon"></i>-->
                                <!--                <p>View IKSVE Activity</p>-->
                                <!--            </a>-->
                                <!--        </li>-->
    
                                <!--    </ul>-->
                                <!--</li>-->
                                
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-layer-group"></i>
                                        <p>IKSVE CELL<i class="right fas fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="../iksve/activitie_insert.php" class="nav-link">
                                                <i class="fa-solid fa-plus nav-icon"></i>
                                                <p>Add IKSVE Activity</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="../iksve/activitie_view.php" class="nav-link">
                                                <i class="fa-solid fa-eye nav-icon"></i>
                                                <p>View IKSVE Activity</p>
                                            </a>
                                        </li>
    
                                    </ul>
                                </li> 
                         
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-lightbulb"></i>
                            <p>Startup CELL<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-info-circle"></i>
                                    <p>About Startup<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../about_startup/about_startup_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add About Startup</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../about_startup/about_startup_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View About Startup</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-rocket"></i>
                                    <p>Our Startup<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../our_startup/our_startup_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Startup</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/our_startup_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <p>Startup Club<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../our_startup/startupclub_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Club</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/startupclub_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Club</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-calendar-alt"></i>
                                    <p>Startup Event<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../our_startup/event_list_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Event List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/event_list_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Event List</p>
                                        </a>
                                    </li>
        
                                    <li class="nav-item">
                                        <a href="../our_startup/event_report_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Event Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/event_report_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Event Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-image"></i>
                                    <p>Startup Gallary<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../startup_gallery/startup_gallery_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Gallary</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../startup_gallery/startup_gallery_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Gallary</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Startup Event Report<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../event_report/event_report_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Report</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../event_report/event_report_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>
                        
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-school"></i>
                            <p>Manage Campus<i class="right fas fa-angle-left"></i></p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-basketball-ball"></i>
                                    <p>Manage Sports Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../sports/sports_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Sports Activity</p>
                                        </a>
                                        <a href="../sports/sports_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Sports Activity</p>
                                        </a>
                                    </li>
                                </ul>
                                
                            </li>
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-theater-masks"></i>
                                    <p>Manage Activity Report<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../sports/report_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Sports/Culture Report</p>
                                        </a>
                                        <a href="../sports/report_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Sports/Culture Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-theater-masks"></i>
                                    <p>Manage Cultural Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../culture/culture_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Cultural Activity</p>
                                        </a>
                                        <a href="../culture/culture_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Cultural Activity</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-building"></i>
                                    <p>Manage FDP <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../fdp/fdp_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add FDP</p>
                                        </a>
                                        <a href="../fdp/fdp_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View FDP</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-comments"></i>
                                    <p>Manage CWP <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">   
                                        <a href="../cwp/cwp_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add CWP</p>
                                        </a>
                                        <a href="../cwp/cwp_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View CWP</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-puzzle-piece"></i>
                                    <p>Manage Mastermind <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">   
                                        <a href="../mastermind/mastermind_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Mastermind</p>
                                        </a>
                                        <a href="../mastermind/mastermind_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Mastermind</p>
                                        </a>
                                    </li>
                                </ul>
                          </li>
                          <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="fas fa-flask"></i>
                                    <p>Manage Advance Laboratories <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../advance_laboratories/advance_laboratories_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Advance Laboratories</p>
                                        </a>
                                        <a href="../advance_laboratories/advance_laboratories_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Advance Laboratories</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fas fa-project-diagram"></i>
                            <p>Project Exhibition<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../project_exhibition/project_exhibition_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Project Exhibition</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../project_exhibition/project_exhibition_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Project Exhibition</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                           
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-globe"></i>
                            <p>Manage International Cell<i class="right fas fa-angle-left"></i></p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-network-wired"></i>
                                    <p>Manage international relation cell<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../international_cell/international_cell_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add International Cell</p>
                                        </a>
                                        <a href="../international_cell/international_cell_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View International Cell</p>
                                        </a>
                                    </li>
                                </ul>
                             </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-handshake"></i>
                                    <p>Manage Initiatives & Collaboration Modes <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../initiatives_collaboration_modes/initiatives_collaboration_modes_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Initiatives & Collaboration Modes</p>
                                        </a>
                                        <a href="../initiatives_collaboration_modes/initiatives_collaboration_modes_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Initiatives & Collaboration Modes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-graduation-cap"></i>
                                    <p>Manage International Admission <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../international_admission/international_admission_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add International Admission</p>
                                        </a>
                                        <a href="../international_admission/international_admission_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View International Admission</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-binoculars"></i>
                                    <p>Global Exposure <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../global_exposure/global_exposure_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Global Exposure</p>
                                        </a>
                                        <a href="../global_exposure/global_exposure_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Global Exposure</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                    
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-photo-video"></i>
                            <p>Manage NSS<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../NSS/about_nss_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add About NSS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/about_nss_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About NSS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_unit_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add NSS Units</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_unit_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View NSS Units</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_advisory_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add NSS Advisory committe</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_advisory_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View NSS Advisory committe</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_contact_us_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Contact Us</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_contact_us_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Contact Us</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/NSS_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add NSS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/NSS_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Media NSS</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-photo-video"></i>
                            <p>Manage Research<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../research/research_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add About Research</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=1" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About GMRDC</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=2" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About SSIP</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=3" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Ph.d Programs</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=4" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=5" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Projects</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=6" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Publication</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=7" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Event</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=8" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Collaboration</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=9" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Patent & IPR</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=10" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Infrastructure</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../research/research_view.php?id=11" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About Contact Us</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                   <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fas fa-address-card"></i>
                        <p>Manage Our Projects<i class="right fas fa-angle-left"></i>
                        </p>
                        </a> 
                        <ul class="nav nav-treeview"> <li class="nav-item"> <a href="../our_project/our_social_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>Add Social Impact Projects</p> </a> </li> <li class="nav-item"> <a href="../our_project/our_social_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>View Social Impact Projects</p> </a> </li> <li class="nav-item"> <a href="../our_project/our_project_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>Add Projects</p> </a> </li> <li class="nav-item"> <a href="../our_project/our_project_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>View Projects</p> </a> </li> <li class="nav-item"> <a href="../our_project/our_hackathon_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>Add Our Hackathon</p> </a> </li> <li class="nav-item"> <a href="../our_project/our_hackathon_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>View Our Hackathon</p> </a> </li> </li>

            </nav>
            <!-- /.sidebar-menu -->
        <?php
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////hod sidebar-menu start ////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } elseif ($role_id == '8') {
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
                            <i class="fas fa-layer-group"></i>
                            <p>Staff<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-address-card"></i>
                                    <p>Manage Staff Details<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../staff/staff_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Staff Details</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../staff/staff_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Staff Details</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-newspaper"> </i>
                            <p> News & Activity<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                             
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-address-card"></i>
                                            <p>Manage Mock interview & Alumni<i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../interview_alumni/interview_alumni_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Mock interview & Alumni</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="../interview_alumni/interview_alumni_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Mock interview & Alumni</p>
                                                </a>
                                            </li>
                
                                        </ul>
                                    </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-microphone"></i>
                                    <p>Manage Expert Talk <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../expert_talk/expert_talk_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Expert Talk</p>
                                        </a>
                                        <a href="../expert_talk/expert_talk_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Expert Talk</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-house"></i>
                                    <p>Manage Industry Visit <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../industry_visit/indvisit_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Industry Visit</p>
                                        </a>
                                        <a href="../industry_visit/industryvisit_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Industry Visit</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-tools"></i>
                                    <p>Manage Workshop <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../workshop/workshop_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Workshop</p>
                                        </a>
                                        <a href="../workshop/workshop_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Workshop</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-laptop-code"></i>
                                    <p>Manage SDP <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../sdp/sdp_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add SDP</p>
                                        </a>
                                        <a href="../sdp/sdp_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View SDP</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--<li class="nav-item">-->
                            <!--    <a href="#" class="nav-link">-->
                            <!--        <i class="fab fa-pied-piper-square"></i>-->
                            <!--        <p>Manage Extra Curricular Activity <i class="right fas fa-angle-left"></i></p>-->
                            <!--    </a>-->
                            <!--    <ul class="nav nav-treeview">-->
                            <!--        <li class="nav-item">-->
                            <!--            <a href="#" class="nav-link">-->
                            <!--                <i class="far fa-circle nav-icon"></i>-->
                            <!--                <p>Add Curricular Activity</p>-->
                            <!--            </a>-->
                            <!--            <a href="#" class="nav-link">-->
                            <!--                <i class="far fa-circle nav-icon"></i>-->
                            <!--                <p>View Curricular Activity</p>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--    </ul>-->
                            <!--</li>-->
                        </ul>
                    </li>
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-address-card"></i>
                            <p>Manage Our Projects<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../our_project/our_project_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Our Social Impact Projects</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../our_project/our_project_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Our Social Impact Projects</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../our_project/our_hackathon_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Our Hackathon</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../our_project/our_hackathon_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Our Hackathon</p>
                                </a>
                            </li>
                            </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-trophy"> </i>
                            <p>Achievement<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../achievement/achievement_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Achievement</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../achievement/achievement_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Achievement</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>IKSVE CELL<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../iksve/activitie_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add IKSVE Activity</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../iksve/activitie_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View IKSVE Activity</p>
                                </a>
                            </li>

                        </ul>
                    </li> 
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-lightbulb"></i>
                            <p>Startup Cell<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-info-circle"></i>
                                    <p>About Startup<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../about_startup/about_startup_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add About Startup</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../about_startup/about_startup_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View About Startup</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-rocket"></i>
                                    <p>Our Startup<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../our_startup/our_startup_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Startup</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/our_startup_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <p>Startup Club<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../our_startup/startupclub_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Club</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/startupclub_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Club</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-calendar-alt"></i>
                                    <p>Startup Event<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../our_startup/event_list_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Event List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/event_list_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Event List</p>
                                        </a>
                                    </li>
        
                                    <li class="nav-item">
                                        <a href="../our_startup/event_report_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Event Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/event_report_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Event Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-image"></i>
                                    <p>Startup Gallary<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../startup_gallery/startup_gallery_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Gallary</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../startup_gallery/startup_gallery_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Gallary</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Startup Event Report<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../event_report/event_report_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Report</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../event_report/event_report_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-school"></i>
                            <p>Manage Campus<i class="right fas fa-angle-left"></i></p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-basketball-ball"></i>
                                    <p>Manage Sports Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../sports/sports_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Sports Activity</p>
                                        </a>
                                        <a href="../sports/sports_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Sports Activity</p>
                                        </a>
                                    </li>
                                </ul>
                                
                            </li>
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-theater-masks"></i>
                                    <p>Manage Activity Report<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../sports/report_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Sports/Culture Report</p>
                                        </a>
                                        <a href="../sports/report_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Sports/Culture Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-theater-masks"></i>
                                    <p>Manage Cultural Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../culture/culture_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Cultural Activity</p>
                                        </a>
                                        <a href="../culture/culture_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Cultural Activity</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-building"></i>
                                    <p>Manage FDP <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../fdp/fdp_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add FDP</p>
                                        </a>
                                        <a href="../fdp/fdp_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View FDP</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-comments"></i>
                                    <p>Manage CWP <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">   
                                        <a href="../cwp/cwp_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add CWP</p>
                                        </a>
                                        <a href="../cwp/cwp_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View CWP</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-puzzle-piece"></i>
                                    <p>Manage Mastermind <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">   
                                        <a href="../mastermind/mastermind_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Mastermind</p>
                                        </a>
                                        <a href="../mastermind/mastermind_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Mastermind</p>
                                        </a>
                                    </li>
                                </ul>
                          </li>
                          <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="fas fa-flask"></i>
                                    <p>Manage Advance Laboratories <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../advance_laboratories/advance_laboratories_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Advance Laboratories</p>
                                        </a>
                                        <a href="../advance_laboratories/advance_laboratories_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Advance Laboratories</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fas fa-project-diagram"></i>
                            <p>Project Exhibition<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../project_exhibition/project_exhibition_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Project Exhibition</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../project_exhibition/project_exhibition_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Project Exhibition</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                           
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-globe"></i>
                            <p>Manage International Cell<i class="right fas fa-angle-left"></i></p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-network-wired"></i>
                                    <p>Manage international relation cell<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../international_cell/international_cell_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add International Cell</p>
                                        </a>
                                        <a href="../international_cell/international_cell_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View International Cell</p>
                                        </a>
                                    </li>
                                </ul>
                             </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-handshake"></i>
                                    <p>Manage Initiatives & Collaboration Modes <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../initiatives_collaboration_modes/initiatives_collaboration_modes_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Initiatives & Collaboration Modes</p>
                                        </a>
                                        <a href="../initiatives_collaboration_modes/initiatives_collaboration_modes_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Initiatives & Collaboration Modes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-graduation-cap"></i>
                                    <p>Manage International Admission <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../international_admission/international_admission_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add International Admission</p>
                                        </a>
                                        <a href="../international_admission/international_admission_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View International Admission</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-binoculars"></i>
                                    <p>Global Exposure <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../global_exposure/global_exposure_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Global Exposure</p>
                                        </a>
                                        <a href="../global_exposure/global_exposure_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Global Exposure</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                    
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-photo-video"></i>
                            <p>Manage NSS<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../NSS/about_nss_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add About NSS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/about_nss_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View About NSS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_unit_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add NSS Units</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_unit_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View NSS Units</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_advisory_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add NSS Advisory committe</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_advisory_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View NSS Advisory committe</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_contact_us_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Contact Us</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/nss_contact_us_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Contact Us</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/NSS_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add NSS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../NSS/NSS_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Media NSS</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-sharp fa-solid fa-laptop-file"></i>
                            <p>Laboratories<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../laboratories/laboratories_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add laboratory</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../laboratories/laboratories_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View laboratories</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-bullseye"></i>
                            <p>Mission & Vision<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../mission_vision/mission_vision_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Mission & Vision </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../mission_vision/mission_vision_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Mission & Vision</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-play"></i>
                            <p>Program Outcome<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../program_outcome/program_outcome_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Program Outcome </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../program_outcome/program_outcome_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Program Outcome</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-calendar-days"></i>
                            <p>Time Table <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../time_table/timetable_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Time Table </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../time_table/timetable_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Time Table</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Placement<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-industry"></i>
                                    <p>Manage Training and Placement<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../training_and_placement/training_and_placement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Training and Placement</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../training_and_placement/training_and_placement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Training and Placement</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                       
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>Manage Placement Statistics<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../placement_statistics/placement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Placement Statistics </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../placement_statistics/placement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Placement Statistics</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>Manage Placement Overview<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../placement_overview/placement_overview_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Placement Overview</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../placement_overview/placement_overview_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Placement Overview</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    </li>
                    <li class="nav-item"> <a href="#" class="nav-link"> <i class="fas fa-photo-video"></i>
                            <p>Student Corner<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"> <a href="../student_corner/student_corner_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                    <p>Add Student Corner</p>
                                </a> </li>
                            <li class="nav-item"> <a href="../student_corner/student_corner_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                    <p>View Student Corner</p>
                                </a> </li>
                        </ul>
                    </li>
                     <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <p>Manage Exam Paper<i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../exam_paper/paper_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Exam Paper </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="../exam_paper/paper_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Exam Paper</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>





                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        <?php   }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////hod sidebar-menu end //////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////hr sidebar-menu start /////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif ($role_id == '9') { ?>
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
                            <i class="fas fa-layer-group"></i>
                            <p>Manage Circular<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../circular/circular_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Circular</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../circular/circular_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Circular</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-address-card"></i>
                            <p>Manage Staff Details<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../staff/staff_insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Staff Details</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../staff/staff_view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Staff Details</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-bullhorn"></i>
                            <p>Manage Career<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../career_manage/insert.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Job Role</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../career_manage/view.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Job Role</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../career_manage/insert_designation.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Job Designation</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../career_manage/view_designation.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Job Designation</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                     <li class="nav-item">
                        <a href="../career_manage/career_cv.php" class="nav-link">
                            <i class="fa-solid fa-clipboard-list"></i>
                            <p>View Career Applications</p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        <?php
        }
         elseif ($role_id == '10') { ?>
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
                            <i class="fas fa-layer-group"></i>
                            <p>Media<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-newspaper"></i>
                                    <p>Manage Daily Post<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../daily_post/daily_post_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Daily Post</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../daily_post/daily_post_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Daily Post </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-photo-video"></i>
                                    <p>Manage Media Coverage<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../media_coverage/mediacoverage_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Media Coverage</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../media_coverage/mediacoverage_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Media Coverage</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-newspaper"></i>
                                    <p>Manage Bitly Post<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../bitly_post/bitly_post_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Bitly Post</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../bitly_post/bitly_post_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Bitly Post </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-newspaper"></i>
                                    <p>Manage Bitly Multiple Post<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../bitly_multiple_post/bitly_multiple_post_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Bitly Multiple Post</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../bitly_multiple_post/bitly_multiple_post_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Bitly Multiple Post </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fab fa-slideshare"></i>
                                    <p>Manage Homepage Slider<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../homepage_slider/slider_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p> Add Slider Image</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../homepage_slider/slider_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Slider Image</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Course<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Manage Level<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../level/level_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Level</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../level/level_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Level</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <p>Manage Faculty<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../faculty/faculty_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Faculty</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../faculty/faculty_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Faculty</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-laptop-code"></i>
                                    <p>Manage Program<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../program/program_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Program</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../program/program_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Program</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Faculty Brochure<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../faculty_brochure/faculty_brochure_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Faculty Brochure</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../faculty_brochure/faculty_brochure_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Faculty Brochure</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                           <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Faculty FAQ<i class="right fas fa-angle-left"></i></p>
                           </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../faculty_FAQ/faculty_FAQ_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Faculty FAQ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../faculty_FAQ/faculty_FAQ_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Faculty FAQ</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                     <li class="nav-item">
                           <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Manage FAQ Content For SEO<i class="right fas fa-angle-left"></i></p>
                           </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../faq/faq_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add FAQ Content For SEO</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../faq/faq_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View FAQ Content For SEO</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                            
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Admission<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-file-invoice"></i>

                                    <p>Manage E-Brochure<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../brochure/brochure_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add E-Brochure</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../brochure/brochure_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View E-Brochure</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-file-invoice-dollar"></i>

                                    <p>Manage fee Structure<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../fee_structure/fee_structure_upload.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Upload fee Structure</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../fee_structure/view_fee.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>View Fee</p>
                                        </a>
                                    </li>
                                  
                                </ul>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
        
        
         
    <?php }  elseif ($role_id == '11') { ?>
           
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
                            <i class="fas fa-layer-group"></i>
                            <p>Course<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Manage Level<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../level/level_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Level</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../level/level_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Level</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <p>Manage Faculty<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../faculty/faculty_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Faculty</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../faculty/faculty_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Faculty</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-laptop-code"></i>
                                    <p>Manage Program<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../program/program_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Program</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../program/program_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Program</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Faculty Brochure<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../faculty_brochure/faculty_brochure_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Faculty Brochure</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../faculty_brochure/faculty_brochure_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Faculty Brochure</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item">
                           <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Faculty FAQ<i class="right fas fa-angle-left"></i></p>
                           </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../faculty_FAQ/faculty_FAQ_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Faculty FAQ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../faculty_FAQ/faculty_FAQ_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Faculty FAQ</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                            
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Staff<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-address-card"></i>
                                    <p>Manage Staff Details<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../staff/staff_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Staff Details</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../staff/staff_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Staff Details</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Department<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                           
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <p>Manage Exam Paper<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../exam_paper/paper_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Exam Paper </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../exam_paper/paper_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Exam Paper</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                                    
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-sharp fa-solid fa-laptop-file"></i>
                                    <p>Manage Laboratories<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../laboratories/laboratories_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add laboratory</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../laboratories/laboratories_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View laboratories</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        
                            <li class="nav-item"> 
                                <a href="#" class="nav-link"> <i class="fas fa-photo-video"></i>
                                    <p>Manage Student Corner<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item"> <a href="../student_corner/student_corner_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                            <p>Add Student Corner</p>
                                        </a> </li>
                                    <li class="nav-item"> <a href="../student_corner/student_corner_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                            <p>View Student Corner</p>
                                        </a> </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-bullseye"></i>
                                    <p>Manage Mission & Vision<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../mission_vision/mission_vision_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Mission & Vision </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../mission_vision/mission_vision_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Mission & Vision</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-trophy"></i>
                                    <p>Manage Achievement<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../achievement/achievement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Achievement</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../achievement/achievement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Achievement</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-play"></i>
                                    <p>Manage Program Outcome<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../program_outcome/program_outcome_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Program Outcome </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../program_outcome/program_outcome_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Program Outcome</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-play"></i>
                                    <p>Manage Time Table<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../time_table/timetable_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Time Table</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../time_table/timetable_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Time Table</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Campus<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fab fa-slideshare"></i>
                                    <p>Manage Gallery<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../gallery/gallery_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p> Add Gallery Image</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../gallery/gallery_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Gallery Image</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <p>Mandatory Disclosure<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../mandatory_disclosure/mandatory_disclosure_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p> Add Mandatory Disclosure</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../mandatory_disclosure/mandatory_disclosure_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Mandatory Disclosure</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-photo-video"></i>
                                    <p>Manage NSS<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../NSS/about_nss_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add About NSS</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/about_nss_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View About NSS</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_unit_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add NSS Units</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_unit_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View NSS Units</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_advisory_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add NSS Advisory committe</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_advisory_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View NSS Advisory committe</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_contact_us_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Contact Us</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss_contact_us_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Contact Us</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/NSS_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add NSS</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/NSS_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Media NSS</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss-gallary_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Photo for Gallery</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../NSS/nss-gallary_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Gallery</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Placement<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-industry"></i>
                                    <p>Manage Training and Placement<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../training_and_placement/training_and_placement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Training and Placement</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../training_and_placement/training_and_placement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Training and Placement</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                       
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>Manage Placement Statistics<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../placement_statistics/placement_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Placement Statistics </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../placement_statistics/placement_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Placement Statistics</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>Manage Placement Overview<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../placement_overview/placement_overview_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Placement Overview</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../placement_overview/placement_overview_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Placement Overview</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>

                   

                    

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Website<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- testimonial  -->
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-quote-left"></i>
                                    <p>Manage Testimonial<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../testimonials/testimonial_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Testimonial</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../testimonials/testimonial_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Testimonial</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Manage Circular<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../circular/circular_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Circular</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../circular/circular_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Circular</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Assign Role<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../assign_faculty/assign_faculty_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>Add Role</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-lightbulb"></i>
                            <p>Startup Cell<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-info-circle"></i>
                                    <p>About Startup<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../about_startup/about_startup_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add About Startup</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../about_startup/about_startup_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View About Startup</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-rocket"></i>
                                    <p>Our Startup<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../our_startup/our_startup_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Startup</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/our_startup_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <p>Startup Club<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../our_startup/startupclub_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Club</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/startupclub_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Club</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-calendar-alt"></i>
                                    <p>Startup Event<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../our_startup/event_list_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Event List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/event_list_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Event List</p>
                                        </a>
                                    </li>
        
                                    <li class="nav-item">
                                        <a href="../our_startup/event_report_insert.php" class="nav-link">
                                            <i class="fa-solid fa-plus nav-icon"></i>
                                            <p>Add Event Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../our_startup/event_report_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Event Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-image"></i>
                                    <p>Startup Gallary<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../startup_gallery/startup_gallery_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Gallary</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../startup_gallery/startup_gallery_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Gallary</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Startup Event Report<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                   <li class="nav-item">
                                    <a href="../event_report/event_report_insert.php" class="nav-link">
                                        <i class="fa-solid fa-plus nav-icon"></i>
                                        <p>Add Startup Report</p>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../event_report/event_report_view.php" class="nav-link">
                                            <i class="fa-solid fa-eye nav-icon"></i>
                                            <p>View Startup Report</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-newspaper"></i>
                                    <p>Manage News & Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-address-card"></i>
                                            <p>Manage Mock interview & Alumni<i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../interview_alumni/interview_alumni_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Mock interview & Alumni</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="../interview_alumni/interview_alumni_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Mock interview & Alumni</p>
                                                </a>
                                            </li>
                
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-microphone"></i>
                                            <p>Manage Expert Talk <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../expert_talk/expert_talk_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Expert Talk</p>
                                                </a>
                                                <a href="../expert_talk/expert_talk_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Expert Talk</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-house"></i>
                                            <p>Manage Industry Visit <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../industry_visit/indvisit_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Industry Visit</p>
                                                </a>
                                                <a href="../industry_visit/industryvisit_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Industry Visit</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-tools"></i>
                                            <p>Manage Workshop <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../workshop/workshop_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Workshop</p>
                                                </a>
                                                <a href="../workshop/workshop_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Workshop</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-laptop-code"></i>
                                            <p>Manage SDP <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../sdp/sdp_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add SDP</p>
                                                </a>
                                                <a href="../sdp/sdp_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View SDP</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-laptop-code"></i>
                                            <p>Manage GEPS <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../about_geps/about_geps_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add GEPS</p>
                                                </a>
                                                <a href="../about_geps/about_geps_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View GEPS</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                            <!--<li class="nav-item">-->
                            <!--    <a href="#" class="nav-link">-->
                            <!--        <i class="fab fa-pied-piper-square"></i>-->
                            <!--        <p>Manage Extra Curricular Activity <i class="right fas fa-angle-left"></i></p>-->
                            <!--    </a>-->
                            <!--    <ul class="nav nav-treeview">-->
                            <!--        <li class="nav-item">-->
                            <!--            <a href="#" class="nav-link">-->
                            <!--                <i class="far fa-circle nav-icon"></i>-->
                            <!--                <p>Add Curricular Activity</p>-->
                            <!--            </a>-->
                            <!--            <a href="#" class="nav-link">-->
                            <!--                <i class="far fa-circle nav-icon"></i>-->
                            <!--                <p>View Curricular Activity</p>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--    </ul>-->
                            <!--</li>-->

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>IKSVE CELL<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../iksve/activitie_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add IKSVE Activity</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../iksve/activitie_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View IKSVE Activity</p>
                                </a>
                            </li>

                        </ul>
                    </li> 
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-basketball-ball"></i>
                                    <p>Manage Sports Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../sports/sports_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Sports Activity</p>
                                        </a>
                                        <a href="../sports/sports_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Sports Activity</p>
                                        </a>
                                    </li>
                                </ul>
                                
                            </li>
                            
                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-theater-masks"></i>
                                    <p>Manage Activity Report<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../sports/report_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Sports/Culture Report</p>
                                        </a>
                                        <a href="../sports/report_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Sports/Culture Report</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-theater-masks"></i>
                                    <p>Manage Cultural Activity<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../culture/culture_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Cultural Activity</p>
                                        </a>
                                        <a href="../culture/culture_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Cultural Activity</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-building"></i>
                                    <p>Manage FDP <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../fdp/fdp_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add FDP</p>
                                        </a>
                                        <a href="../fdp/fdp_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View FDP</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-comments"></i>
                                    <p>Manage CWP <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">   
                                        <a href="../cwp/cwp_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add CWP</p>
                                        </a>
                                        <a href="../cwp/cwp_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View CWP</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-puzzle-piece"></i>
                                    <p>Manage Mastermind <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">   
                                        <a href="../mastermind/mastermind_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Mastermind</p>
                                        </a>
                                        <a href="../mastermind/mastermind_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Mastermind</p>
                                        </a>
                                    </li>
                                </ul>
                          </li>
                          <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="fas fa-flask"></i>
                                    <p>Manage Advance Laboratories <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../advance_laboratories/advance_laboratories_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Advance Laboratories</p>
                                        </a>
                                        <a href="../advance_laboratories/advance_laboratories_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Advance Laboratories</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                <i class="fas fa-project-diagram"></i>
                                    <p>Project Exhibition<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../project_exhibition/project_exhibition_insert.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add Project Exhibition</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../project_exhibition/project_exhibition_view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View Project Exhibition</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-globe"></i>
                                    <p>Manage International Cell<i class="right fas fa-angle-left"></i></p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-network-wired"></i>
                                            <p>Manage international relation cell<i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../international_cell/international_cell_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add International Cell</p>
                                                </a>
                                                <a href="../international_cell/international_cell_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View International Cell</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-handshake"></i>
                                            <p>Manage Initiatives & Collaboration Modes <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../initiatives_collaboration_modes/initiatives_collaboration_modes_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Initiatives & Collaboration Modes</p>
                                                </a>
                                                <a href="../initiatives_collaboration_modes/initiatives_collaboration_modes_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Initiatives & Collaboration Modes</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p>Manage International Admission <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../international_admission/international_admission_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add International Admission</p>
                                                </a>
                                                <a href="../international_admission/international_admission_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View International Admission</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-binoculars"></i>
                                            <p>Global Exposure <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../global_exposure/global_exposure_insert.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add Global Exposure</p>
                                                </a>
                                                <a href="../global_exposure/global_exposure_view.php" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View Global Exposure</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fas fa-address-card"></i>
                        <p>Manage Our Projects<i class="right fas fa-angle-left"></i>
                        </p>
                        </a> 
                        <ul class="nav nav-treeview">
                             <li class="nav-item"> <a href="../our_project/our_social_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>Add Social Impact Projects</p> </a> </li> 
                             <li class="nav-item"> <a href="../our_project/our_social_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>View Social Impact Projects</p> </a> </li> 
                             <li class="nav-item"> <a href="../our_project/our_project_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>Add Projects</p> </a> </li> 
                             <li class="nav-item"> <a href="../our_project/our_project_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>View Projects</p> </a> </li> 
                             <li class="nav-item"> <a href="../our_project/our_hackathon_insert.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>Add Our Hackathon</p> </a> </li>
                              <li class="nav-item"> <a href="../our_project/our_hackathon_view.php" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>View Our Hackathon</p> </a> </li>
                        </ul>
                    </li>

                </ul>
            </nav>

    <?php }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////hr sidebar-menu end //////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        ?>
    </div>
    <!-- /.sidebar -->

</aside>