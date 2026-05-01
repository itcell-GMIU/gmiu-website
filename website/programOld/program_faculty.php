<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../common/importwebsitefile.php';

if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>"; 
        }
    // fetch program details
    $cmd = $con->prepare("SELECT program.name as program_name from tbl_program as program WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
    } else {
        $program_name = "";
    }
} else {
    $program_id = "";
    $program_name = "";
}

if (isset($_GET['faculty_id']) && !empty($_GET['faculty_id'])) {
    $faculty_id = mysqli_real_escape_string($con, $_GET['faculty_id']);
    $faculty_id = only_digits($faculty_id);
    if ($faculty_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>"; 
        }
    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.name as faculty_name from tbl_faculty as faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
}


?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url;?>css/program.css">
</head>

<body class="courses">
    <!-- Preloader-->
    <!--   <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> -->
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Faculty</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a
                            href="program.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><?php echo $program_name; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">Faculty<a href=""></a></span>
                </p>
                <hr>
            </div>
        </div>

    </section>
    <div class="single-courses-area">
        <div class="container">
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="teachers-area">
                            <div class="row teachers-wapper-01">
                                <div class="faculty-card-container">
                                    <!--   fetch staff details -->
                                    <?php
                                    $cmd = $con->prepare("SELECT staff.id as staff_id,staff.image as staff_image, staff.total_experience as staff_total_experience, staff.name as staff_name, staff.position as staff_position,staff.work_since as staff_work_since FROM tbl_staff as staff WHERE  FIND_IN_SET('$program_id', program_id) > 0 AND is_delete= 0 AND role_id != 3");
                                    //$cmd->bind_param("i", $program_id);
                                    $cmd->execute();
                                    $result = $cmd->get_result();
                                    if ($result->num_rows != 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $staff_id = $row['staff_id'];
                                            $staff_name = $row['staff_name'];
                                            $staff_position = $row['staff_position'];
                                            $staff_total_experience = $row['staff_total_experience'];
                                            $staff_image = $row['staff_image'];
                                            // get only year 
                                            $staff_work_since = $row['staff_work_since'];
                                            $staff_year = date('Y', strtotime($staff_work_since));

                                    ?>
                                    <div class="col-sm-6 teacher-single">
                                        <div class="teacher-body" style="padding-top: 20px;">
                                            <img src="<?php echo  $upload_website_admin_url."profile/". $staff_image; ?>"
                                                alt="" class="img-responsive">
                                            <div class="teachars-info">
                                                <h3>
                                                    <?php echo $staff_name; ?>
                                                </h3>
                                                <span class="color-gmiu">
                                                    <?php echo $staff_position; ?>
                                                </span>
                                                <hr>
                                                <p
                                                    style="height :auto; display: flex;align-items: center;justify-content: center;">
                                                    <?php
                                                            $cmd1 = $con->prepare("SELECT staff_quali.qualification as staff_quali_qualification, staff_quali.branch as staff_quali_branch from tbl_staff_qualification as staff_quali where staff_id = ? ");
                                                            $cmd1->bind_param("i", $staff_id);
                                                            $cmd1->execute();
                                                            $result1 = $cmd1->get_result();
                                                            if ($result1->num_rows != 0) {
                                                                while ($row = $result1->fetch_assoc()) {
                                                                    $staff_quali_qualification = $row['staff_quali_qualification'];
                                                                    $staff_quali_branch = $row['staff_quali_branch'];

                                                                    echo $staff_quali_qualification . '(' . $staff_quali_branch . ')
                                                                    <br>';
                                                                }
                                                            } else {
                                                                echo "Not Available";
                                                            }
                                                            ?>
                                                </p>
                                                <hr>
                                                <div>Total Experience :
                                                    <span class="color-gmiu">
                                                        <?php echo $staff_total_experience; ?>
                                                    </span>

                                                </div>
                                                <div>Working Since :
                                                    <span class="color-gmiu">
                                                        <?php echo $staff_year; ?>
                                                    </span>
                                                </div>
                                                <hr>
                                                <a
                                                    href="program_faculty_profile.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>&staff_id=<?php echo $staff_id ?>">View
                                                    Profile <i class="fa-solid fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    } else {
                                        $staff_id = "";
                                        $staff_name = "";
                                        $staff_position = "";
                                        $staff_work_since = "";
                                        $staff_total_exprience = "";
                                        $staff_image = "";
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- left bar end  -->

                <!-- right bar start  -->
                <?php include '../include/importrightsidebar.php' ?>
                <!-- right bar end  -->
            </div>
        </div>
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>