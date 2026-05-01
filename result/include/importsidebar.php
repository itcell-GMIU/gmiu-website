<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="dashboard.php" class="brand-link">
        <img src="../../admin_assets/images/Logo with BG@3x.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">Student Profile</span> 
    </a> -->
    <a href="dashboard.php" class="brand-link" style="background-color : #fff; display: flex; align-items: center; justify-content: center;">
        <img src="../website_assets/images/logo3.png" alt="logo" style="width : 70%; position: relative; left: -6px;">
    </a>

    <!-- Sidebar -->


    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <div class="user-panel">
                    <div class="text-center">
                        <?php
                        if ($pr_image == "N/A") {
                        ?>
                            <div class="profile-user-img img-fluid img-circle" style="height: 130px; width: 130px; background-color: white; display:flex; align-items :center; justify-content:center;">
                                <h3>N/A</h3>
                            </div>
                        <?php
                        } else {
                        ?>
                            <img class="profile-user-img img-fluid img-circle" style="height: 130px; width: 130px;" src="../website_assets/images/std_profile/<?=$pr_image ?>">
                        <?php
                        }
                        ?>
                        <h4 class="profile-username text-wrap" style="color: white;"><?php echo $first_name . ' ' . $middle_name.' '.$last_name; ?></h4>
                        <!--<a href="profileEdit.php"><i class="fas fa-edit" style="color: #ffffff;"></i></a>-->
                    </div>
                    <li class="nav-item">
                        <a href="editProfile.php" class="nav-link">
                            <i class="fa-solid fas fa-edit"></i>
                            <p>Edit Profile</p>
                        </a>
                    </li>
                </div>

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="fa-solid fas fa-house-user"></i>
                        <p>Home</p>
                    </a>
                </li>
                <!--<li class="nav-item">-->
                <!--    <a href="editProfile.php" class="nav-link">-->
                <!--        <i class="fa-solid fas fa-user"></i>-->
                <!--        <p>Edit Profile</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="circular.php" class="nav-link">-->
                <!--        <i class="fa-regular fas fa-book-open"></i>-->
                <!--        <p>Circular</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="certificateRequest.php" class="nav-link">-->
                <!--        <i class="fa-solid fas fa-certificate"></i>-->
                <!--        <p>Certificate Request</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="hundredPoints.php" class="nav-link">-->
                <!--        <i class="fa-solid fas fa-circle-check"></i>-->
                <!--        <p>100 Activity Points</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="" class="nav-link" onclick="alert('Currently Under Maintanance for Sometime, Try after 24 Hour!');">-->
                <!--        <i class="fa fa-file-alt"></i>-->
                <!--        <p>Examform</p>-->
                <!--    </a>-->
                <!--</li>-->
                <li class="nav-item">
                    <a href="examform.php" class="nav-link">
                        <i class="fa fa-file-alt"></i>
                        <p>Examform</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="exam_schedule.php" class="nav-link">
                        <i class="fa fa-calendar"></i>
                        <p>Exam Schedule</p>
                    </a>
                </li>
                <!--<li class="nav-item">-->
                <!--    <a href="ansSheet.php" class="nav-link">-->
                <!--        <i class="fa-sharp fa-solid fa-list"></i>-->
                <!--        <p>Answer Sheet View</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="convocation.php" class="nav-link">-->
                <!--        <i class="fas fa-graduation-cap"></i>-->
                <!--        <p>Convocation</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="recheckHistory.php" class="nav-link">-->
                <!--        <i class="fas fa-check-double"></i>-->
                <!--        <p>Recheck/Reassess </p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="degreeVerification.php" class="nav-link">-->
                <!--        <i class="fas fa-check-square"></i>-->
                <!--        <p>Degree Verification</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="marksheetTrack.php" class="nav-link">-->
                <!--        <i class="fas fa-clock"></i>-->
                <!--        <p>Marksheet Tracker</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="certificateTrack.php" class="nav-link">-->
                <!--        <i class="far fa-clock"></i>-->
                <!--        <p>Certificate Tracking </p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="resultDisplay.php" class="nav-link">-->
                <!--        <i class="far fa-check-circle" aria-hidden="true"></i>-->
                <!--        <p>My Results</p>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                <!--    <a href="gradeHistory.php" class="nav-link">-->
                <!--        <i class="fa fa-book" aria-hidden="true"></i>-->
                <!--        <p>Grade History</p>-->
                <!--    </a>-->
                <!--</li>-->
                <li class="nav-item">
                    <a href="paymentStatus.php" class="nav-link">
                        <i class="fas fa-credit-card" aria-hidden="true"></i>
                        <p>Check Payment Status </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="change_password.php" class="nav-link">
                        <i class="fas fa-key" aria-hidden="true"></i>
                        <p>Change Password </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php.php" class="nav-link">
                        <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- </div> -->

    <!-- /.sidebar -->
</aside>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>