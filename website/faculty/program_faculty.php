<?php


include '../../common/importwebsitefile.php';

if (isset($_GET['program_slug']) && !empty($_GET['program_slug'])) {
    $program_slug = mysqli_real_escape_string($con, $_GET['program_slug']);
    // $program_slug = only_digits($program_slug);
    if ($program_slug == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>";
    }

    //fetch program details
    $cmd = $con->prepare("SELECT level.name as level_name, 
     REPLACE(
        REPLACE(
            REPLACE(
                program.name,
                'premium', 'PLM'
            ),
            'Premium', 'PLM'
        ),
        'PREMIUM', 'PLM'
    ) AS program_name,
    program.id as program_id, program.description as program_description from tbl_program as program LEFT JOIN tbl_level as level ON program.level_id = level.id
    WHERE program.program_slug=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("s", $program_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
        $program_id = $row['program_id'];
        $program_description = $row['program_description'];
        $level_name = $row['level_name'];
    } else {
        $program_name = "";
        $program_description = "";
    }
} else {
    $program_id = "";
    $program_name = "";
    $program_description = "";
}

if (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
    $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
    // $faculty_slug = only_digits($faculty_slug);
    if ($faculty_slug == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=https://gmiu.edu.in/'},1000)</script>";
    }

    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.id as faculty_id, faculty.name as faculty_name from tbl_faculty as faculty WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0");
    $cmd->bind_param("s", $faculty_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
        $faculty_id = $row['faculty_id'];
    }
    elseif ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
        // Fetch faculty_description from the database where id = 1
        $query = $con->prepare("SELECT description FROM tbl_faculty WHERE id = 1");
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        $faculty_id = '1';
        $faculty_name = 'INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)';
        $faculty_description = $row['description'];
    }else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
}
if (!isset($program_slug) || empty($program_slug) || empty($program_name)) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $base_url_website_faculty . $faculty_slug);
    exit;
}


?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url;?>css/program.css">
    <style>
        .teachers-area .teacher-body .teachars-info {
            text-align: center;
            padding: 5px 20px 12px;
            height: 315px;
        }
        .teachers-area .teacher-body .img {
            min-height: 200px;
            width: 200px;
            border-radius: 50%;
            padding: 3px;
            background: #ba2a21;
            margin-bottom: 14px;
        }
        .teachers-area .teacher-body .img img {
            min-height: 200px;
            width: 100%;
            border: 3px solid #ffff;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
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
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                            <span class="b-active"><a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a
                            href="<?php echo $base_url_website_faculty?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>"><?php echo $program_name.' ('.$level_name .')'; ?></a>
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
                                   $cmd = $con->prepare("SELECT staff.id as staff_id, staff.image as staff_image, staff.email as staff_email, staff.total_experience as staff_total_experience, staff.name as staff_name, staff.position as staff_position, staff.work_since as staff_work_since FROM tbl_staff as staff WHERE FIND_IN_SET('$program_id', program_id) > 0 AND is_delete= 0 AND is_active = 1 AND role_id IN(4,8) ORDER BY 
                                    CASE 
                                        WHEN staff.position = 'Director' THEN 0
                                        WHEN staff.position = 'Principal' THEN 1
                                        WHEN staff.position = 'HOD' THEN 2
                                        WHEN staff.position = 'HEAD OF DEPARTMENT' THEN 3
                                        ELSE 4
                                    END, role_id, staff_work_since ASC");

                                    //$cmd->bind_param("i", $program_id);
                                    $cmd->execute();
                                    $result = $cmd->get_result();
                                    if ($result->num_rows != 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $staff_id = $row['staff_id'];
                                            $staff_email = $row['staff_email'];
                                            $staff_name = $row['staff_name'];
                                            $staff_position = $row['staff_position'];
                                            $staff_total_experience = $row['staff_total_experience'];
                                            $staff_image = $row['staff_image'];
                                            // get only year 
                                            $staff_work_since = $row['staff_work_since'];
                                            $staff_year = date('Y', strtotime($staff_work_since));
                                         $email_username = explode('@', $staff_email)[0];
                                    ?>
                                    <div class="col-sm-6 teacher-single">
                                        <div class="teacher-body" style="padding-top: 20px;text-align: -webkit-center;">
                                            <div class="img">
                                                <img src="<?php echo  $upload_website_admin_url."profile/". $staff_image; ?>" alt="" class="img-responsive">
                                            </div>
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
                                                            $cmd1 = $con->prepare("SELECT staff_quali.qualification as staff_quali_qualification, staff_quali.branch as staff_quali_branch from tbl_staff_qualification as staff_quali where staff_id = ? LIMIT 3 ");
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
                                                    href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program_faculty/<?php echo $email_username; ?>">View
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