<?php
include '../../common/importwebsitefile.php'; 
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Courses Offered | Gyanmanjari Innovative University Admission | GMIU"; 
        $meta_description = "Explore GMIU’s courses – undergraduate, postgraduate, and professional programs crafted to promote academic growth and prepare you for career success.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>

<style>
 a.rgsBtn {
            display: inline-block;
            position: relative;

            color: #fff;
            min-width: 25rem !important;
            padding: 1rem;
            border-radius: 0.5rem;
            margin: 1rem;
            text-align: center;
        }
          .red-background {
            background-color: #ba2a21;
            color: white;
        }
</style>
    <!--   -->
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include '../include/importheader.php'; ?>



    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Courses Offered</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="flexContainer container">
        <div class="cont">
            <div class="curriculum-text-box">
                <div class="curriculum-section">

                    <div class="panel-group" id="accordion">

                        <?php
                        $cmd = $con->prepare("SELECT faculty.name as faculty_name ,faculty.id as faculty_id, faculty.faculty_slug as faculty_slug from tbl_faculty as faculty
                        WHERE is_active=1 AND is_delete=0");
                        $cmd->execute();
                        $result = $cmd->get_result();
                        if ($result->num_rows != 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                $faculty_name = $row['faculty_name'];
                                $faculty_id = $row['faculty_id'];
                                 $faculty_slug = $row['faculty_slug'];
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title click">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#c<?php echo $i; ?>"
                                        id="font-course" class="color-gmiu"><?php echo $faculty_name; ?></a>
                                </h4>
                            </div>
                            <div id="c<?php echo $i; ?>" class="panel-collapse collapse out">
                                <div class="panel-body">

                                    <?php
                 
                   $query = "SELECT program.level_id,level.name as level_name from tbl_program as program
                               LEFT JOIN tbl_level level ON program.level_id = level.id
                               WHERE program.faculty_id=$faculty_id AND program.is_active=1 AND program.is_delete=0 
                               AND NOT (program.faculty_id = 27 AND program.level_id = 15)
                               GROUP BY level_id ORDER BY FIELD(program.level_id,5,7,3,1,2,8,4,6,9,10,12,13,14,15,17)
                               ";
                   $result1 = mysqli_query($con, $query);

                   if (mysqli_num_rows($result1) > 0) {
                       // output data of each row
                       while ($row1 = mysqli_fetch_assoc($result1)) {
                           $level_name = $row1['level_name'];
                           $level_id = $row1['level_id'];

                   ?>
                                    <section class="two-column-cards">
                                        <h3 class="title gradText">
                                            <?php echo $level_name; ?>
                                        </h3>
                                        <hr>

                                        <div class="courses-cards">
                                             <?php

                                                            $query2 = "SELECT 
                                                                            program.id AS program_id,
                                                                            program.name AS program_name,
                                                                            program.intake AS program_intake,
                                                                            program.regular AS regular,
                                                                            program.duration AS program_duration,
                                                                            program_slug 
                                                                        FROM tbl_program AS program 
                                                                        WHERE 
                                                                            program.faculty_id = $faculty_id 
                                                                            AND program.level_id = $level_id 
                                                                            AND program.is_active = 1 
                                                                            AND program.is_delete = 0 
                                                                        ORDER BY 
                                                                            CASE 
                                                                                WHEN program.name LIKE '%premium%' THEN 1 
                                                                                ELSE 2 
                                                                            END,
                                                                            CASE 
                                                                                WHEN program.short_no = 0 THEN 2  
                                                                                ELSE 1  
                                                                            END,
                                                                            program.short_no ASC,  
                                                                            program.name ASC; ";
                                                            $result2 = mysqli_query($con, $query2);
                                                            if (mysqli_num_rows($result2) > 0) {
                                                                // output data of each row
                                                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                                                    $program_name = $row2['program_name'];
                                                                    $program_id = $row2['program_id'];
                                                                    $program_intake = $row2['program_intake'];
                                                                    $program_duration = $row2['program_duration'];
                                                                     $program_slug = $row2['program_slug'];
                                                            ?>
                                            <div class="card-for-course">


                                                <a
                                                    href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/">
                                                    <h3 class="course-name">
                                                        <?php echo $program_name; ?>
                                                    </h3>
                                                    <div class="duration-intake">
                                                        <p>Duration: <b>
                                                                <?php echo $program_duration; ?> Years
                                                            </b> </p>
                                                        <p>Intake: <b>
                                                                <?php echo $program_intake; ?>
                                                            </b> </p>
                                                    </div>
                                                </a>
                                            </div>

                                            <?php
                                       }
                                   }
                                   ?>
                                        </div>
                                    </section>
                                    <?php
                       }}
                   ?>

                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                            }
                        }
                        ?>
                    </div> <!-- .curriculum-section-text END -->
                </div>
            </div>
             <div>
                    
                    <a href="<?php echo $website_assets_url; ?>/pdf/ALL-COURSES.pdf" target="_blank" rel="noopener noreferrer" class="rgsBtn red-background">Eligibility Criteria</a>
            </div>
        </div>
        <div style="width: 350px;" class="sideBar">
            <div class="sticky">
                <div>
                             <ul>
                                <li>Admission</li>
                                <li><a href="<?php echo $base_url_admission; ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                                        Apply Online</a></li>
                                <li><a href="why_gmiu.php" class=""><i class="fa-solid fa-arrow-right"></i> Why GMIU</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php" class="active"><i class="fa-solid fa-arrow-right"></i> Courses Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php"><i class="fa-solid fa-arrow-right"></i> e-Brochure & Scope Documents</a>
                                </li>
                                <li><a href="importantlink.php" class=""><i class="fa-solid fa-arrow-right"></i> Important Links</a></li>
                                <li><a href="education_loan.php" class=""><i class="fa-solid fa-arrow-right"></i> Education Loan Facilites</a>
                                </li>
                                <li><a href="scholarships.php" class=""><i class="fa-solid fa-arrow-right"></i> Scholarships</a></li>
                                <li><a href="transportation.php" class=""><i class="fa-solid fa-arrow-right"></i> Transportation Facilities</a></li>
                            </ul>
                </div>
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