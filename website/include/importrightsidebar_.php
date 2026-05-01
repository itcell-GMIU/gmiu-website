<!-- right bar start  -->
<div class="col-sm-4 sidebar-right">

<div class="sidebar-content">
    <div class="sideBar">
        <div class="sticky">
            <div>
                <ul>
                    <li>
                        <?php echo $program_name.' ('.$level_name .')'; ?>
                    </li>
                    <li><a href="<?php echo $base_url_website_program; ?>program.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                            Overview</a></li>
                    <li><a href="<?php echo $base_url_website_program; ?>program_mission_vision.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i> Mission
                            Vision</a></li>
                    <li><a href="<?php echo $base_url_website_program; ?>program_outcome.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i> Program
                            Outcome</a></li>
                    <li><a href="<?php echo $base_url_website_program; ?>program_laboratories.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                            Laboratories</a>
                    </li>
                    <li><a href="<?php echo $base_url_website_program; ?>program_faculty.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i> Faculty</a>
                    </li>
                    <li><a href="<?php echo $base_url_website;?>student_corner/student_corner.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i>Student
                            Corner</a></li>
                    <li>
                        <!-- <a data-toggle="collapse" href="#news-activities" role="button" aria-expanded="false" aria-controls="news-activities"><i class="fa-solid fa-arrow-right"></i> News and Activities</a>
                        <div class="collapse" id="news-activities">
                            <ul class="accordion-menu custom-ul">
                                <li><a href="#">News</a></li>
                                <li><a href="#">Activities</a></li>
                            </ul>
                        </div> -->
                        <div class="accordion">
                            <a class="accordion-toggle" data-toggle="collapse" href="#news-activities" role="button" aria-expanded="false" aria-controls="news-activities" style="text-decoration-line: none;">
                                <i class="fa-solid fa-arrow-right"></i> News and Activities
                            </a>
                            <div class="collapse" id="news-activities" style="width: 90%; margin-left:auto;">
                                <a href="<?php echo $base_url_website_program; ?>program_expert_talk.php?program_id=<?= $program_id ?>&faculty_id=<?= $faculty_id ?>"><i class="fa-solid fa-arrow-right"></i> Expert Talk</a>
                                <a href="<?php echo $base_url_website_program; ?>program_industry_visit.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i class="fa-solid fa-arrow-right"></i> Industry Visit</a>
                                <a href="<?php echo $base_url_website_program; ?>program_workshop.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i class="fa-solid fa-arrow-right"></i> Workshop</a>
                                <a href="<?php echo $base_url_website_program; ?>program_sdp.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i class="fa-solid fa-arrow-right"></i> SDP</a>
                                <a href="<?php echo $base_url_website_program; ?>program_extra_curricular_activity.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i class="fa-solid fa-arrow-right"></i> Extra Curricular
                                    Activity</a>
                            </div>
                        </div>

                    </li>
                      <?php if ($faculty_id != 26) { ?>
                       <li><a href="<?php echo $base_url_website_placement;?>placement.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                            Placement </a>
                    </li>
                    <li><a href="<?php echo $base_url_website_program; ?>program_achievement.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                            Achievement</a>
                    </li>
                    <li><a href="<?php echo $base_url_website_program; ?>program_our_project.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>" class=""><i class="fa-solid fa-arrow-right"></i> Our
                            Projects</a>
                    </li>
                         <?php }
                         else if ($faculty_id == 26) { ?>
                             
                     <li><a href="" class=""><i class="fa-solid fa-arrow-right"></i>
                            Placement </a>
                    </li>
                    <li><a href="" class=""><i class="fa-solid fa-arrow-right"></i>
                            Achievement</a>
                    </li>
                    <li><a href="" class=""><i class="fa-solid fa-arrow-right"></i> Our
                            Projects</a>
                    </li>
                             
                   <?php  } ?>
                   

                    <!--   <div class="contactInfo">
                        <h3 class="gradText">Contact Details</h3>
                        <hr>
                        <h5>HOD Office</h5>
                        <a href="#"><i class="fa fa-long-arrow-right"></i> +91 123456789</a>
                        <h5>TPO Office</h5>
                        <a href="#"><i class="fa fa-long-arrow-right"></i> +91 123456789</a>
                        <h5>Email ID</h5>
                        <a href="mailto:demo@gmail.com"><i class="fa fa-long-arrow-right"></i>
                            demo@gmail.com</a>
                    </div> -->
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<!-- right bar end  -->