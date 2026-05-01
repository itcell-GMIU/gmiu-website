<style>
    .os-viewport {
        bottom: 22px;
    }

    .nav-treeview .nav-link {
        padding-left: 35px !important;
        /* or adjust as per design */
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
        if ($role_id == '8' || $role_id == '54') {
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
                            <p>Image<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../question_bank/image_upload.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Upload Image for csv</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../question_bank/image_view.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>View Image</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Add Subject<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../subject_weightage/subject_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add subject</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../subject_weightage/subject_csv.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Upload subject CSV</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../subject_weightage/subject_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View subject</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Add Subject Weightage<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../subject_weightage/insert_weightage.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add subject Weightage</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../subject_weightage/view_weightage.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View subject Weightage</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Add Question Bank<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="../question_bank/insert_question_bank.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Question Bank CSV</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../question_bank/view_question_bank.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Question Bank</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../question_bank/insert_mcq_question_bank.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add MCQ Question Bank CSV</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../question_bank/view_mcq_question_bank.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View MCQ Question Bank</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->

        <?php } elseif ($role_id == '51') { ?>

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
                            <p>Image<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../question_bank/image_upload.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Upload Image for csv</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../question_bank/image_view.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>View Image</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-book-open"></i>
                            <p>Add Subject<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../subject_weightage/subject_insert.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add subject</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../subject_weightage/subject_csv.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Upload subject CSV</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../subject_weightage/subject_view.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View subject</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <p>Add Subject Weightage<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../subject_weightage/insert_weightage.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add subject Weightage</p>
                                </a>
                            </li>
                            <!--<li class="nav-item">-->
                            <!--    <a href="../subject_weightage/weightage_csv.php" class="nav-link">-->
                            <!--        <i class="fa-solid fa-plus nav-icon"></i>-->
                            <!--        <p>subject Weightage CSV</p>-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li class="nav-item">
                                <a href="../subject_weightage/view_weightage.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View subject Weightage</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Add Question Bank<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="../question_bank/insert_question_bank.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add Question Bank CSV</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../question_bank/view_question_bank.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Question Bank</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../question_bank/insert_mcq_question_bank.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Add MCQ Question Bank CSV</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../question_bank/view_mcq_question_bank.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View MCQ Question Bank</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Generate Question Paper<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../question_paper/generate_paper.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Generate Paper</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../question_paper/view_generate_paper.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View Question Paper</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-layer-group"></i>
                            <p>Generate MCQ Question Paper<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../question_paper/generate_mcq_paper.php" class="nav-link">
                                    <i class="fa-solid fa-plus nav-icon"></i>
                                    <p>Generate MCQ Paper</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../question_paper/view_generate_mcqpaper.php" class="nav-link">
                                    <i class="fa-solid fa-eye nav-icon"></i>
                                    <p>View MCQ Question Paper</p>
                                </a>
                            </li>

                        </ul>
                    </li>


                </ul>
            </nav>

        <?php } ?>

    </div>
    <!-- /.sidebar -->

</aside>