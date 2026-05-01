<?php
include '../../common/importwebsitefile.php';

if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>"; 
        }
    $cmd = $con->prepare("SELECT level.name as level_name, program.name as program_name ,program.id as program_id,program.description as program_description from tbl_program as program LEFT JOIN tbl_level as level ON program.level_id = level.id
    WHERE program.id=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
        $program_description = $row['program_description'];
        $level_name = $row['level_name'];
    } else {
        $program_name = "";
        $program_description = "";
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



if (isset($_GET['staff_id']) && !empty($_GET['staff_id'])) {
    $staff_id = mysqli_real_escape_string($con, $_GET['staff_id']);
    $staff_id = only_digits($staff_id);
    if ($staff_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>"; 
        }
    // fetch staff details
    $cmd = $con->prepare("SELECT staff.total_experience as staff_total_experience,staff.image as staff_image, staff.name as staff_name, staff.position as staff_position,staff.work_since as staff_work_since, staff.description as staff_description,staff.mobile_number as staff_mobile_number, staff.email as staff_email, staff.location as staff_location FROM tbl_staff as staff WHERE  id= ? AND is_delete= 0");
    $cmd->bind_param("i", $staff_id);
    $cmd->execute();
    $result = $cmd->get_result();
    $row = $result->fetch_assoc();
    if ($row) {
        $staff_name = $row['staff_name'];
        $staff_position = $row['staff_position'];       
        $staff_description = $row['staff_description'];
        $staff_mobile_number = $row['staff_mobile_number'];
        $staff_email = $row['staff_email'];
        $staff_location = $row['staff_location'];
        $staff_total_experience = $row['staff_total_experience'];
        $staff_image = $row['staff_image'];
          // get only year 
          $staff_work_since = $row['staff_work_since'];
          $staff_year = date('Y', strtotime($staff_work_since));
    }
} else {
    $staff_id = "";
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
    <!-- Preloader
<div id="preloader">
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
                            href="program.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><?php echo $program_name.' ('.$level_name .')'; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a
                            href="program_faculty.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>">Faculty</a><i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><?php echo $staff_name; ?><a href="#"></a></span>
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
                            <div class="container">
                                <div class="row teachers-wapper-01">
                                    <div class="col-sm-7 events-full-box">
                                        <h3 class="color-gmiu">PROFILE
                                            <hr>
                                        </h3>
                                        <p>
                                            <?php echo htmlspecialchars_decode($staff_description) ?>
                                        </p>
                                        <h3 class="color-gmiu">QUALIFICATION
                                            <hr>
                                        </h3>
                                        <table>
                                            <tr>
                                                <th>
                                                    Qualification
                                                </th>
                                                <th>
                                                    Specialization / Branch
                                                </th>
                                                <th>
                                                    Passing Year
                                                </th>
                                            </tr>
                                            <!-- fetch qualification details -->
                                            <?php
                                            $cmd1 = $con->prepare("SELECT staff_quali.qualification as staff_quali_qualification,staff_quali.branch as staff_quali_branch, staff_quali.passing_year as staff_quali_passing_year from tbl_staff_qualification as staff_quali where staff_id = ? ");
                                            $cmd1->bind_param("i", $staff_id);
                                            $cmd1->execute();
                                            $result1 = $cmd1->get_result();

                                            if ($result1->num_rows != 0) {
                                                while ($row = $result1->fetch_assoc()) {
                                                    $staff_quali_qualification = $row['staff_quali_qualification'];
                                                    $staff_quali_branch = $row['staff_quali_branch'];
                                                    $staff_quali_passing_year = $row['staff_quali_passing_year'];

                                                    echo ' 
                                                    <tr>
                                                        <td>' . $staff_quali_qualification . '</td>
                                                        <td>' . $staff_quali_branch . '</td>
                                                        <td>' . $staff_quali_passing_year . '</td>
                                                    </tr>';
                                                }
                                            } else {
                                                echo "No Qualification Details Are Available";
                                            }
                                            ?>

                                        </table>
                                        <h3 class="color-gmiu">EXPERIENCE
                                            <hr>
                                        </h3>

                                        <!-- Fetch experience details -->
                                        <?php
                                        $cmd1 = $con->prepare("SELECT staff_exp.join_date as staff_exp_join_date, staff_exp.till_date as staff_exp_till_date, staff_exp.role as staff_exp_role, staff_exp.organization as staff_exp_organization from tbl_staff_experience as staff_exp where staff_id = ? ");
                                        $cmd1->bind_param("i", $staff_id);
                                        $cmd1->execute();
                                        $result1 = $cmd1->get_result();
                                        if ($result1->num_rows != 0) {
                                            while ($row = $result1->fetch_assoc()) {
                                                $staff_exp_join_date = $row['staff_exp_join_date'];
                                                if($row['staff_exp_till_date'] == '0000-00-00'){
                                                    $staff_exp_till_date = "Present";
                                                }else{
                                                    $staff_exp_till_date = $row['staff_exp_till_date'];
                                                }
                                                // $staff_exp_till_date = !empty($row['staff_exp_till_date']) ? $row['staff_exp_till_date'] : 'Present';
                                                $staff_exp_role = $row['staff_exp_role'];
                                                $staff_exp_organization = $row['staff_exp_organization'];

                                                echo ' <ul class="events">
                                                            <li>
                                                                <time>' . $staff_exp_join_date . ' To
                                                                    ' . $staff_exp_till_date . ' </time>
                                                                <span><strong id="text-dark">' . $staff_exp_organization . '</strong>' . $staff_exp_role . '</span>
                                                            </li>
                                                        </ul>';
                                            }
                                        } else {
                                            echo "No Experience Details Are Available";
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- left bar end  -->

                <!-- right bar start  -->
                <section class="teachers-area">
                    <div class="container">
                        <div class="row teachers-wapper-01">
                            <div class="events-full-box">
                                <div class="col-sm-4 teacher-single">

                                    <div class="teacher-body">
                                        <img src="<?php echo  $upload_website_admin_url."profile/". $staff_image; ?>"
                                            alt="" class="img-responsive">
                                        <div class="teachars-info">
                                            <h3><?php echo $staff_name; ?></h3>
                                            <span class="color-gmiu"><?php echo $staff_position; ?></span>
                                            <hr>
                                            <p>
                                                <!-- fetch qualification details -->
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
                                                <span
                                                    class="color-gmiu"><?php echo $staff_total_experience; ?></span>
                                            </div>
                                            <div>Working Since :
                                                <span class="color-gmiu"><?php echo $staff_year; ?></span>
                                            </div>
                                            <hr>
                                            <div class="space">
                                                <i class="fa-solid fa-phone"></i>
                                                <a href="#"><?php echo $staff_mobile_number; ?></a>
                                            </div>
                                            <div class="space">
                                                <i class="fa-solid fa-envelope"></i>
                                                <a href="<?php echo $staff_email; ?>"><?php echo $staff_email; ?></a>
                                            </div>
                                            <div class="space">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <a href="#"><?php echo $staff_location; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
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