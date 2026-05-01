<?php
  include '../../common/importwebsitefile.php';
  ?>
<!doctype html>
<html class="no-js" lang="zxx">
  <head>
      <?php 
      $pageTitle = "Project At Gyanmanjari Innovative University";
          $meta_description = "Explore GMIU’s student projects showcasing innovative research, creative initiatives, and hands-on learning that highlight academic excellence.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
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
            <h1>Project</h1>
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
                                            <a data-toggle="collapse" data-parent="#accordion" href="#c<?php echo $i; ?>" id="font-course" class="color-gmiu"><?php echo $faculty_name; ?></a>
                                        </h4>
                                    </div>
                                    <div id="c<?php echo $i; ?>" class="panel-collapse collapse out">
                                        <div class="panel-body">

                                            <?php

                                            $query = "SELECT program.level_id,level.name as level_name from tbl_program as program
                               LEFT JOIN tbl_level level ON program.level_id = level.id
                               WHERE program.faculty_id=$faculty_id AND program.is_active=1 AND program.is_delete=0 GROUP BY level_id ORDER BY level_id";
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

                                                            $query2 = "SELECT program.id as program_id,program.name as program_name,program.intake as program_intake,program.duration as program_duration, program.program_slug as program_slug from tbl_program as program
                           WHERE program.faculty_id=$faculty_id AND program.level_id = $level_id AND program.is_active=1 AND program.is_delete=0";
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


                                                                        <a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-our-project">
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
      <!-- right ber start -->
      <div class="col-sm-4 sidebar-right">
        <div class="sidebar-content">
          <div class="sideBar">
            <div class="sticky">
              <div>
                <ul>
                  <li>
                    Latest Updates
                  </li>
                  <li>
                    <!----><a href="<?php echo $base_url_website_home; ?>circular.php"> <i class="fa fa-long-arrow-right"></i> Circular / event </a><!----><!----><!---->
                  </li>
                  <li>
                    <!----><a href="<?php echo $base_url_website_home; ?>workshop.php" > <i class="fa fa-long-arrow-right"></i> Seminar / workshop </a><!----><!----><!---->
                  </li>
                  <li>
                    <!----><a href="<?php echo $base_url_website_home; ?>project.php" class="active"> <i class="fa fa-long-arrow-right"></i> Project - Social impact project </a><!----><!----><!---->
                  </li>
                  <li>
                    <!----><a href="<?php echo $base_url_website_home; ?>placement.php"> <i class="fa fa-long-arrow-right"></i> Regular update of placement </a><!----><!----><!---->
                  </li>
                  <li>
                    <!----><a href="<?php echo $base_url_website_home; ?>industrial_visit.php"> <i class="fa fa-long-arrow-right"></i> Industrial visit </a><!----><!----><!---->
                  </li>
                  <!-- <li> -->
                  <!-- <a href="/iepprogram"> <i class="fa fa-long-arrow-right"></i> IEP </a> -->
                  <!-- </li> -->
                  <li>
                    <!----><a href="<?php echo $base_url_website_home; ?>sdp.php"> <i class="fa fa-long-arrow-right"></i> SDP </a><!----><!----><!---->
                  </li>
                  <!-- <li>
                    <a href="/mastermind"> <i class="fa fa-long-arrow-right"></i> Mastermind </a>
                    </li>
                    <li>
                    <a href="/sports"> <i class="fa fa-long-arrow-right"></i> Sports </a>
                    </li>
                    <li>
                    <a href="/cwp"> <i class="fa fa-long-arrow-right"></i> Parent connect </a>
                    </li> -->
                </ul>
              </div>
            </div>
          </div>
        </div>
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