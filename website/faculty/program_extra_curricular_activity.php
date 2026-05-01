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
    } elseif ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
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
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <style>
        .ex-card .card-body {
            background-color: #90241dd4;
            height: 80px;
            border-radius: 10px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ba2a21;
        }
        .text-white{
            color: white;
        }
    </style>
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
                    <h1>Extra Curricular Activities</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="<?php echo $base_url_website_faculty?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>"><?php echo $program_name.' ('.$level_name .')'; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">Extra Curricular Activities<a href=""></a></span>
                </p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="des" style="margin-top: 20px;">
                            <?php
                            //code for getting year buttons by grouping year in placement table
                            $cmd2 = "SELECT title, link FROM tbl_extra_curricular_activity WHERE is_active = 1 AND is_delete = 0 ";
                            $stmt2 = $con->prepare($cmd2);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();

                            while ($row2 = $result2->fetch_assoc()) {
                                $link = $row2['link'];
                                $title = $row2['title'];
                            ?>
                            <a target="_blank" href="<?php echo $link; ?>" class="hover-up">
                                    <div class="card ex-card">
                                        <div class="card-body" style="padding: 0;">
                                                <h3 class="text-white" style="margin-top: 0; font-size:30px;"><?php echo $title; ?> <i class="fa fa-external-link"></i></h3>
                                        </div>
                                    </div>
                                </a>
                            <?php
                            }
                            ?>
                        </section>
                      
                      
                      <div class="card-for-course" style="margin-bottom: 20px; cursor: pointer; transition: transform 0.3s ease; " onmouseover="this.style.transform = 'translateY(-10px)'" onmouseout="this.style.transform = 'translateY(0px)';">
                             <a _ngcontent-udh-c72="" href="https://kalaamanjari.gmiu.edu.in/" target="_blank">
                               <div _ngcontent-udh-c72="" class="card backColor" align="center">
                                 <h4 _ngcontent-udh-c72="" class="gradText" style="align-items: center; text-align: center;"> KALAMANJARI <i _ngcontent-udh-c72="" class="fa fa-external-link"></i></h4>
                               </div>
                             </a>
                      </div>

                      <div class="card-for-course" style="margin-bottom: 20px; cursor: pointer; transition: transform 0.3s ease; " onmouseover="this.style.transform = 'translateY(-10px)'" onmouseout="this.style.transform = 'translateY(0px)';">
                             <a _ngcontent-udh-c72="" href="#" target="_blank">
                               <div _ngcontent-udh-c72="" class="card backColor" align="center">
                                 <h4 _ngcontent-udh-c72="" class="gradText" style="align-items: center; text-align: center;"> RASMANJARI <i _ngcontent-udh-c72="" class="fa fa-external-link"></i></h4>
                               </div>
                             </a>
                      </div>

                      <div class="card-for-course" style="margin-bottom: 20px; cursor: pointer; transition: transform 0.3s ease; " onmouseover="this.style.transform = 'translateY(-10px)'" onmouseout="this.style.transform = 'translateY(0px)';">
                             <a _ngcontent-udh-c72="" href="https://techmanjari.gmiu.edu.in/" target="_blank">
                               <div _ngcontent-udh-c72="" class="card backColor" align="center">
                                 <h4 _ngcontent-udh-c72="" class="gradText" style="align-items: center; text-align: center;"> TECHMANJARI  <i _ngcontent-udh-c72="" class="fa fa-external-link"></i></h4>
                               </div>
                             </a>
                      </div>
                      
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