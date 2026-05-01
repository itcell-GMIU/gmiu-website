<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
      <?php $pageTitle = "FAQ at Gyanmanjari Innovative University | GMIU";
    include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>

    <style>
/*        .two-column-cards {*/
/*    display: grid;*/
/*    grid-template-columns: repeat(2, 1fr);*/
/*    gap: 20px; */
    
/*}*/

.courses-cards {
    display: block;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 15px;
}
.card-for-course {
    margin-bottom: 50px;
}

    </style>
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
                    <h1>FAQ</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="cont">
            <div class="curriculum-text-box">
                <div class="curriculum-section">

                    <div class="panel-group" id="accordion">

                        <?php
                        $cmd = $con->prepare("SELECT DISTINCT faculty.id AS faculty_id, faculty.name AS faculty_name
                                  FROM tbl_faculty AS faculty
                                  JOIN tbl_faq_management AS faq ON faq.faculty_id = faculty.id
                                  WHERE faculty.is_active = 1 AND faculty.is_delete = 0 AND faq.is_delete = 0");
                        $cmd->execute();
                        $result = $cmd->get_result();
                        if ($result->num_rows != 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                $faculty_name = $row['faculty_name'];
                                $faculty_id = $row['faculty_id'];

                        ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title click">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#c<?php echo $i; ?>" id="font-course" class="color-gmiu"><?php echo $faculty_name; ?></a>
                                        </h4>
                                    </div>
                                    <div id="c<?php echo $i; ?>" class="panel-collapse collapse out">
                                        <div class="panel-body">
                                                    <section class="two-column-cards">
                                                        
                                                        <div class="courses-cards">
                                                            <?php

                                                            $query = $con->prepare("SELECT level.id AS level_id, level.name AS level_name, faq.faq_description AS level_description
                                                                        FROM tbl_level AS level
                                                                        JOIN tbl_faq_management AS faq ON faq.level_id = level.id
                                                                        WHERE faq.faculty_id = ? AND faq.is_delete = 0
                                                                        GROUP BY level.id");
                                                            $query->bind_param("i", $faculty_id);
                                                            $query->execute();
                                                            $result2 = $query->get_result();
                                                            if (mysqli_num_rows($result2) > 0) {
                                                                // output data of each row
                                                                while ($row2 = mysqli_fetch_assoc($result2)) {   
                                                                    $level_name = $row2['level_name'];
                                                                    $level_description = $row2['level_description'];                                                            
                                                            ?>
                                                                    <div class="card-for-course">
                                                                           <h3 class="course-name">
                                                                                <?php echo $level_name; ?>
                                                                            </h3>
                                                                            <div>
                                                                           <?php echo $level_description; ?>
                                                                           </div>
                                                                       
                                                                    </div>

                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </section>
                                           

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