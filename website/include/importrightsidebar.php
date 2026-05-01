<!-- right bar start  -->

<?php
if ($faculty_id == '1' && $program_id == '7') {
 $program_slug = 'under-graduation-information-technology';
}

$showLaboratories = false;

$stmt = $con->prepare("
    SELECT COUNT(*) 
    FROM tbl_laboratories 
    WHERE FIND_IN_SET(?, program_id)
      AND is_active = 1
      AND is_delete = 0
");
$stmt->bind_param("i", $program_id);
$stmt->execute();
$stmt->bind_result($labCount);
$stmt->fetch();
$stmt->close();

if ($labCount > 0) {
    $showLaboratories = true;
}
?>
<div class="col-sm-4 sidebar-right">

<div class="sidebar-content">
    <div class="sideBar">
        <div class="sticky">
            <div>
                <ul>
                    <li>
                        <?php echo $program_name.' ('.$level_name .')'; ?>
                    </li>
                    <li><a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                            Overview</a></li>
                    <li>
                        <a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-mission-vision" class="">
                            <i class="fa-solid fa-arrow-right"></i> Mission Vision
                        </a>
                    </li>
                    <li><a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-outcome" class=""><i class="fa-solid fa-arrow-right"></i> Program
                            Outcome</a></li>
                    <?php if ($showLaboratories): ?>
                    <li><a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-laboratories" class=""><i class="fa-solid fa-arrow-right"></i>
                            Laboratories</a>
                    </li>
                    <?php endif; ?>
                    <li><a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-faculty" class=""><i class="fa-solid fa-arrow-right"></i> Faculty</a>
                    </li>
                    <!--<li><a href="<?php //echo $base_url_website_faculty; ?><?php //echo $faculty_slug; ?>/<?php //echo $program_slug; ?>/student-corner" class=""><i class="fa-solid fa-arrow-right"></i>Student-->
                    <!--        Corner</a></li>-->
                    <!--<li>-->
                    <li>
                        <?php //if (stripos($program_name, 'premium') === false): ?>
                            <!--<a href="<?php //echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug; ?>/student-corner" class="">-->
                            <!--    <i class="fa-solid fa-arrow-right"></i> Student Corner-->
                            <!--</a>-->
                        <?php //else: ?>
                            <!--<a href="#" class=""> <i class="fa-solid fa-arrow-right"></i> Student Corner </a>-->
                        <?php //endif; ?>
                        <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug; ?>/student-corner" class="">
                                <i class="fa-solid fa-arrow-right"></i> Student Corner
                        </a>
                    </li>
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
                            <?php if ($program_id != 117 && $program_id != 28) { ?>
                            <div class="collapse" id="news-activities" style="width: 90%; margin-left:auto;">
                                <a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-expert-talk"><i class="fa-solid fa-arrow-right"></i> Expert Talk</a>
                                <a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-industry-visit"><i class="fa-solid fa-arrow-right"></i> Industry Visit</a>
                                <a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-workshop"><i class="fa-solid fa-arrow-right"></i> Workshop</a>
                                <a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-sdp"><i class="fa-solid fa-arrow-right"></i> SDP</a>
                                <a href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-extra-curricular-activity"><i class="fa-solid fa-arrow-right"></i> Extra Curricular
                                    Activity</a>
                            </div>
                            <?php } ?>
                            
                        </div>

                    </li>
                    
                    <li><a href="<?php if ($program_id != 9 && $program_id != 28 && $program_id != 3  && $program_id != 117 && $program_id != 212 && $program_id != 213) 
                    { echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/placement<?php } ?>" class="">
                        <i class="fa-solid fa-arrow-right"></i> Placement </a>
                    </li>
                    <li><a href="<?php if ($program_id != 117 && $program_id != 212 && $program_id != 213 && $program_id != 28) 
                    { echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-achievement<?php } ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                            Achievement</a>
                    </li>
                    <li><a href="<?php if ($program_id != 212 && $program_id != 213) { 
                    echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>/program-our-project<?php } ?>" class=""><i class="fa-solid fa-arrow-right"></i> Our
                            Projects</a>
                    </li>

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