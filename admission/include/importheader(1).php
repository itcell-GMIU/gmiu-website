<?php
//login code
include '../common/globalvariable.php';
?>
<style>
html, body {
  overflow-x: hidden;
}

</style>
<header id="header">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-12 header-top-left">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone top-icon"></i><a style="color:white;" href="tel:+91 7574949494">+91
                                7574949494</a></li>
                        <li><i class="fa fa-envelope top-icon"></i><a style="color:white;"
                                href="mailto:admissions@gmiu.edu.in"> admissions@gmiu.edu.in</a></li>
                    </ul>
                </div>
                <!-- <div class="col-sm-6 col-xs-12 header-top-right">
					<ul class="list-unstyled">
						<li><a href="register.html"><i class="fa fa-user-plus top-icon"></i> Sing up</a></li>
						<li><a href="login.html"><i class="fa fa-lock top-icon"></i>Login</a></li>
					</ul>
				</div> -->
            </div>
        </div>
    </div><!-- Ends: .header-top -->


    <div class="header-body">
        <nav class="navbar edu-navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img id="nav-logo" src="../website_assets/images/gmiulogo.png" alt="">
                </div>

                <div class="collapse navbar-collapse edu-nav main-menu" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav pull-right">

                        <?php
                        if (!empty($student_id)) {
                        ?>
                        <li class="active"><a data-scroll="" href="../admission/dashboard.php">Home</a>

                        </li>
                        <li><a data-scroll href="#">Hi,
                                <?php if (isset($stu_first_name)) {
                                        echo $stu_first_name . " " . $stu_last_name;
                                    } else {
                                        echo "";
                                    }  ?></a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <!--  <li><a href="#">My Dashboard</a></li> -->
                                <?php
                                if($stu_cluster_status!="pending")
                                {
                                    ?>
                                <li><a href="../admission/application_status.php">My Application Status</a></li>
                                <?php  }
                                ?>

                                <?php
                                if($payment_status == 'success')
                                {
                                    ?>
                                <li><a href="../admission/cancel_admission.php">Cancel Admission</a></li>
                                <?php  }
                                ?>
                                <li><a href="../admission/change_password.php">Change Password</a></li>
                                <li><a href="../admission/logout.php">Logout</a></li>
                                <!--    <li><a data-scroll href="https://gmiu.edu.in/contact-us"></a></li> -->
                                <li><a data-scroll
                                        href="<?php echo $base_url_website_common; ?>website_contact_us.php">Contact
                                        Us</a></li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <?php
                        } else {
                        ?>
                        <li class="active"><a data-scroll="" href="<?php echo $base_url_website;?>">Home</a></li>
                        <li><a data-scroll="" href="<?php echo $base_url_website_about;?>about_university.php">About</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_about; ?>about_university.php">About
                                        University</a></li>
                                <li><a
                                        href="<?php echo $base_url_website_about; ?>about_gyanmudra_education_foundation.php">About
                                        Gyanmudra Education Foundation</a></li>
                                <li><a href="<?php echo $base_url_website_about; ?>about_leadership.php">Leadership</a>
                                </li>
                                <li><a href="<?php echo $base_url_website_about;?>about_chairman_message.php">President
                                        Message</a></li>
                                <li><a href="<?php echo $base_url_website_about;?>about_provost_message.php">Provost
                                        Message</a></li>
                                <li><a href="<?php echo $base_url_website_about;?>about_recognition.php">Recognition</a>
                                </li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="#">Institute</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled scroll-y-faculty">
                                 <li>
                                    <a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma" target="_blank">
                                        INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)
                                    </a>
                                </li>
                                <?php
                                $cmd = "SELECT `name` as faculty_name,`id` as faculty_id,faculty_slug FROM `tbl_faculty` Where is_active=1 AND is_delete=0";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                       $faculty_name = ($row['faculty_id'] == 1) ? strtoupper($row['faculty_name']) . " (DEGREE)" : strtoupper($row['faculty_name']);
                                  
                                  
                                    ?>
                                <li><a
                                        href="<?php echo $base_url_website_faculty; ?><?php echo $row['faculty_slug']; ?>"><?php echo $faculty_name; ?></a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="<?php echo $base_url_admission;?>">Admission</a>
                            <ul class="list-unstyled dropdown">
                                <li><a href="<?php echo $base_url_admission;?>">Apply Online</a></li>
                                <!--<li><a href="https://gmiu.edu.in/admission/why-gmiu">Why GMIU</a></li>-->
                                 <li><a href="<?php echo $base_url_website_admission; ?>why_gmiu.php">Why GMIU</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php ">Courses
                                        Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php">e-Brochure
                                        &
                                        Scope Documents</a></li>
                                <!--<li><a href="https://gmiu.edu.in/admission/important-links">Important Links</a></li>-->
                                <!--<li><a href="https://gmiu.edu.in/admission/education-loan-facility">Education Loan-->
                                <!--        Facilities</a></li>-->
                                <!--<li><a href="https://gmiu.edu.in/admission/scholarships">Scholarship</a></li>-->
                                <!--<li><a href="https://gmiu.edu.in/campus/transportation">Transportation Facilities</a>-->
                                <!--</li>-->
                                 <li><a href="<?php echo $base_url_website_admission; ?>importantlink.php">Important Links</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>education_loan.php">Education Loan
                                        Facilities</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>scholarships.php">Scholarship</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>transportation.php">Transportation Facilities</a>
                                </li>
                            </ul>
                        </li>
                        <li><a data-scroll href="<?php echo $base_url_website_placement; ?>training_and_placement_cell.php">Placement</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_placement; ?>training_and_placement_cell.php">Training
                                        and
                                        Placement Cell</a></li>
                                <li><a href="<?php echo $base_url_website_placement; ?>placement_overview_and_statistics.php">Placement
                                        Overview & Statistics</a></li>
                                <li><a href="placement/geps.php">GMIU Employability Performance Scale</a></li>
                                <!--<li><a href="https://gmiu.edu.in/placement/placement-overview-and-statistics">Placement-->
                                <!--        Overview & Statistics</a></li>-->
                                <!--<li><a href="https://gmiu.edu.in/placement/about-geps">About GEPS</a></li>-->
                                <li><a href="<?php echo $base_url_website_placement; ?>student_testimonial.php">Student
                                        Testimonial</a>
                                <li><a href="<?php echo $base_url_website_placement; ?>corporate_testimonial.php">Corporate
                                        Testimonial</a></li>
                                <!--<li><a href="https://gmiu.edu.in/placement/innovation-and-research">Innovation &-->
                                <!--        Research</a></li>-->
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">Campus</a>
                            <!-- dropdwon start -->
                            <!--<ul class="dropdown list-unstyled">-->
                            <!--    <li><a href="https://gmiu.edu.in/campus/virtualtour">360 Virtual Tour</a></li>-->
                            <!--    <li><a href="<?php //echo $base_url_website_campus; ?>gallery.php">Gallery</a></li>-->
                            <!--    <li class="dropdown-list-box-02"><a href="#">Infrastructure<i-->
                            <!--                class="fa fa-angle-right menu-icon"></i></a>-->
                            <!--        <ul class="dropdown-list_2 list-unstyled">-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/modern-classroom">Modern Class Room</a>-->
                            <!--            </li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/advance-laboratories">Advance-->
                            <!--                    Laboratories</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/library">Library</a></li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <li class="dropdown-list-box-02"><a href="">Facilities<i-->
                            <!--                class="fa fa-angle-right menu-icon"></i></a>-->
                            <!--        <ul class="dropdown-list_2 list-unstyled">-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/wifi">Wi-Fi Campus</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/cafeandfirstaid">Cafeteria & First Aid-->
                            <!--                    Room</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/transportation">Transportation-->
                            <!--                    Facilities</a></li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <li class="dropdown-list-box-02"><a href="">Curriculum Activities<i-->
                            <!--                class="fa fa-angle-right menu-icon"></i></a>-->
                            <!--        <ul class="dropdown-list_2 list-unstyled">-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/industryvisit">Industry Visit</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/experttalk">Expert Talk</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/internship-program">Internship-->
                            <!--                    Program</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/iepprogram">IEP Program</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/projectexhibition">Project-->
                            <!--                    Exhibition</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/sdp">Skill development Program (SDP)</a>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <li class="dropdown-list-box-02"><a href="">Extra Curriculum Activities<i-->
                            <!--                class="fa fa-angle-right menu-icon"></i></a>-->
                            <!--        <ul class="dropdown-list_2 list-unstyled">-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/studentclub">Student Club</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/socialconnect">Social Connect</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/mastermind">Mastermind</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/sports">Sport Activities</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/cultural">Cultural Program</a></li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/fdp">Faculty Development Program</a>-->
                            <!--            </li>-->
                            <!--            <li><a href="https://gmiu.edu.in/campus/cwp">Connect With Parents</a></li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <li><a href="https://gmiu.edu.in/campus/nationalinternationalactivities">National /-->
                            <!--            International Association</a></li>-->
                            <!--    <li><a href="https://gmiu.edu.in/campus/nss">NSS</a></li>-->
                            <!--    <li><a href="https://gmiu.edu.in/campus/academic-system">Academic System</a></li>-->
                            <!--</ul>-->
                            
                            
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">360 Virtual Tour</a></li>
                                <li><a href="<?php echo $base_url_website_campus; ?>gallery.php">Gallery</a></li>
                                <li class="dropdown-list-box-02"><a href="#">Infrastructure<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website_campus; ?>modern_class_room.php">Modern Class Room</a>
                                        </li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>advance-laboratories.php">Advance
                                                Laboratories</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>library.php">Library</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="">Facilities<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website_campus; ?>wi-fi_campus.php">Wi-Fi Campus</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>cafeteria.php">Cafeteria & First Aid
                                                Room</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>transportation.php">Transportation
                                                Facilities</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="">Curriculum Activities<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website_campus; ?>industryvisit.php">Industry Visit</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>experttalk.php">Expert Talk</a></li>
                                        <!--<li><a href="https://gmiu.edu.in/campus/internship-program">Internship-->
                                        <!--        Program</a></li>-->
                                        <li><a href="<?php echo $base_url_website_campus; ?>iepprogram.php">IEP Program</a></li>
                                        <!--<li><a href="https://gmiu.edu.in/campus/projectexhibition">Project-->
                                        <!--        Exhibition</a></li>-->
                                        <!--<li><a href="https://gmiu.edu.in/campus/sdp">Skill development Program (SDP)</a>-->
                                        <!--</li>-->
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="">Extra Curriculum Activities<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <!--<li><a href="https://gmiu.edu.in/campus/studentclub">Student Club</a></li>-->
                                        <!--<li><a href="https://gmiu.edu.in/campus/socialconnect">Social Connect</a></li>-->
                                        <!--<li><a href="https://gmiu.edu.in/campus/mastermind">Mastermind</a></li>-->
                                        <li><a href="<?php echo $base_url_website_campus; ?>sports.php">Sport Activities</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>culture.php">Cultural Program</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>fdp.php">Faculty Development Program</a>
                                        </li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>cwp.php">Connect With Parents</a></li>
                                    </ul>
                                </li>
                                <!--<li><a href="https://gmiu.edu.in/campus/nationalinternationalactivities">National /-->
                                <!--        International Association</a></li>-->
                                <li><a href="<?php echo $base_url_website_campus?>about_nss.php">NSS</a></li>
                                <li><a href="<?php echo $base_url_website_campus; ?>academic_system.php">Academic System</a></li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="<?php echo $base_url_website ?>startup/about_startup.php">Startup</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <!--<li><a href="https://gmiu.edu.in/startup/about-startup">About Startup</a></li>-->
                                <!--<li><a href="https://gmiu.edu.in/startup/our-startup">Our Startup</a></li>-->
                                <!--<li><a href="https://gmiu.edu.in/startup/about-ssip-and-ipr">About SSIP & IPR</a></li>-->
                                <!--<li><a href="https://gmiu.edu.in/startup/about-ced">About CED</a></li>-->
                                 <li><a href="<?php echo $base_url_website ?>startup/about_startup.php">About GMSEC</a></li>
                                <li><a href="<?php echo $base_url_website ?>startup/our_startup.php">Our Startup</a></li>
                                <li><a href="<?php echo $base_url_website ?>startup/ssip.php">About SSIP & IPR</a></li>
                                 <li><a href="<?php echo $base_url_website ?>startup/event.php">GMSEC Event list</a></li>
                                <li><a href="<?php echo $base_url_website ?>startup/startupclub.php">GMSEC Incubation and startup club policy</a></li>
                                <li><a href="<?php echo $base_url_website ?>startup/startup_gallery.php">GMSEC Gallery</a></li>
                                <li><a href="<?php echo $base_url_website ?>startup/event_report.php">GMGC Event Report </a><li>
                                 <!--<li><a href="<?php echo $base_url_website ?>startup/about_ced.php">About CED</a></li>-->
                            </ul>
                            <!-- dropdown end -->
                        </li>
                         <li><a data-scroll href="<?php echo $base_url_website; ?>international_cell/about_irc.php">International</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website; ?>international_cell/about_irc.php">GMIU International Relation Cell</a></li>
                                <li><a href="<?php echo $base_url_website; ?>international_cell/about_icm.php">International Initiatives & Collaboration Modes</a></li>
                                <li><a href="<?php echo $base_url_website; ?>international_cell/about_admission.php">International Admission</a></li>
                                 <li><a href="<?php echo $base_url_website; ?>international_cell/about_irc_connection.php">Global Connection</a></li>
                                <li><a href="<?php echo $base_url_website; ?>international_cell/about_explosure.php">Global Exposure</a></li>
                                <li><a data-scroll href="<?php echo $base_url_website; ?>international_cell/contact_us.php">Contact us</a></li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <!--<li><a data-scroll href="https://gmiu.edu.in/alumni">Alumni</a></li>-->
                          <li><a data-scroll href="<?php echo $base_url_website_common; ?>website_contact_us.php">Contact
                                Us</a></li>
                        <!--<li><a data-scroll href="https://gmiu.edu.in/contact-us">Contact Us</a></li>-->

                        </li>
                        <?php  }
                        ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>
    </div>

</header>
<!--  End header section-->