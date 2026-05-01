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


?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url;?>css/program.css">
    
    <style>
    .wel-text-box {
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.13);
    padding: 25px 25px 30px;
    transition: all 0.3s ease-in-out;
}

.wel-text-box  p {
    padding-bottom: 10px;
    margin: 
0;
    font-size: 13px;
    text-align: justify;
    /* height: 140px; */
}
    </style>
</head>

<body class="courses">
    <!-- Preloader-->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Program Outcome</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a
                            href="program.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><?php echo $program_name.' ('.$level_name .')'; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Program Outcome</a></span>
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
                        <section>
                            <div class="outcome-cards-container-for-card">
                                <?php
                           $cmd = $con->prepare("SELECT program_outcome.title as program_outcome_title, program_outcome.content as program_outcome_content,program_outcome.id as  program_outcome_id from tbl_program_outcome as program_outcome WHERE program_id=? AND is_active=1 AND is_delete=0");
                           $cmd->bind_param("i", $program_id);
                           $cmd->execute();
                           $result = $cmd->get_result();
                           if ($result->num_rows != 0) {
                               while ($row = $result->fetch_assoc()) {
                                    $program_outcome_title = $row['program_outcome_title'];
                               $program_outcome_content = $row['program_outcome_content'];
                           
                       echo' 
                                <div class="wel-text-box">
                                    <div class="prog-card-logo">
                                        <i id="arrow-set" class="fa-solid fa-arrow-right"></i>
                                        <h5>'. $program_outcome_title .'</h5>
                                    </div>
                                    <hr>
                                    <div class="">
                                        '.
                                         htmlspecialchars_decode($program_outcome_content) .'
                                    
                                    </div>
                                </div>';
                             }
                             
                            } 
                            
                                ?>
                               
                               
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