<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Expert Talks at Gyanmanjari Innovative University | GMIU";
    include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>

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
                    <h1>Expert Talk</h1>
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
                        $cmd = $con->prepare(" SELECT 
                                faculty.name as faculty_name, 
                                faculty.faculty_slug as faculty_slug, 
                                faculty.id as faculty_id
                            FROM 
                                tbl_faculty as faculty
                            JOIN 
                                tbl_expert_talk as expert_talk 
                                ON expert_talk.faculty_id = faculty.id
                            WHERE 
                                faculty.is_active = 1 
                                AND faculty.is_delete = 0
                                AND expert_talk.is_active = 1
                                AND expert_talk.is_delete = 0
                            GROUP BY 
                                faculty.id;
                            ");
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
                                            <a data-toggle="collapse" data-parent="#accordion" href="#c<?php echo $i; ?>" id="font-course" class="color-gmiu"><?php echo $faculty_name; ?></a>
                                        </h4>
                                    </div>
                                    <div id="c<?php echo $i; ?>" class="panel-collapse collapse out">
                                        <div class="panel-body">

                                            <?php

                                            $query = "SELECT 
                                                        program.level_id, 
                                                        level.name as level_name
                                                    FROM 
                                                        tbl_program as program
                                                    LEFT JOIN 
                                                        tbl_level level ON program.level_id = level.id
                                                    JOIN 
                                                        tbl_expert_talk as expert_talk 
                                                        ON FIND_IN_SET(program.id, expert_talk.program_id) > 0
                                                    WHERE 
                                                        program.faculty_id = $faculty_id 
                                                        AND program.is_active = 1 
                                                        AND program.is_delete = 0 
                                                        AND program.level_id NOT IN (15)
                                                        AND NOT (program.faculty_id = '27' AND program.level_id = '15')
                                                        AND expert_talk.is_active = 1
                                                        AND expert_talk.is_delete = 0
                                                    GROUP BY 
                                                        program.level_id 
                                                    ORDER BY 
                                                        FIELD(program.level_id, 5, 7, 3, 1, 2, 8, 4, 6, 9, 10, 12, 13, 14, 15, 17);
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

                                                            $query2 = "SELECT DISTINCT 
                                                                            program.id as program_id,
                                                                            program.name as program_name,
                                                                            program.intake as program_intake,
                                                                            program.program_slug as program_slug, 
                                                                            program.duration as program_duration 
                                                                        FROM 
                                                                            tbl_program as program
                                                                        JOIN 
                                                                            tbl_expert_talk as expert_talk 
                                                                            ON FIND_IN_SET(program.id, expert_talk.program_id) > 0
                                                                        WHERE 
                                                                            program.faculty_id = $faculty_id 
                                                                            AND program.level_id = $level_id 
                                                                            AND program.is_active = 1 
                                                                            AND program.is_delete = 0 
                                                                            AND expert_talk.is_active = 1 
                                                                            AND expert_talk.is_delete = 0;";
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
                                                                        <a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-expert-talk">
                                                                            <h3 class="course-name">
                                                                                <?php echo $program_name; ?>
                                                                            </h3>
                                                                            <!--<div class="duration-intake">-->
                                                                            <!--    <p>Duration: <b>-->
                                                                            <!--            <?php //echo $program_duration; 
                                                                                            ?> Years-->
                                                                            <!--        </b> </p>-->
                                                                            <!--    <p>Intake: <b>-->
                                                                            <!--            <?php //echo $program_intake; 
                                                                                            ?>-->
                                                                            <!--        </b> </p>-->
                                                                            <!--</div>-->
                                                                        </a>
                                                                    </div>


                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </section>
                                            <?php
                                                }
                                            }
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
        </div>
        <div>
            <!-- right ber start -->
            <?php include "../campus/campussidebar.php"; ?>
        </div>
        <!--  right bar end -->
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
<script>
    // jQuery for toggling expert talk section
    $(document).ready(function() {
        // Hide all expert talk sections initially
        $('.expert-talk-section').hide();

        // Show expert talk when a program is clicked
        $('.card-for-course').click(function() {
            // Hide all expert talks
            $('.expert-talk-section').hide();

            // Find the expert talk section within the clicked program card and show it
            $(this).find('.expert-talk-section').show();
        });
    });
</script>