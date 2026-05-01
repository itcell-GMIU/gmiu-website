<style>

/* General mega-menu styling */
.mega-menu {
  display: none;
    position: absolute;
    /* left: 0; */
    background-color: #fff;
    padding: 20px;
    right: 0%;
    width: 1000px;
    box-shadow: 0px 0px 8px rgb(0 0 0 / 84%);
    z-index: 9999;
}

.mega-menu-content {
  display: grid;
  grid-template-columns: repeat(4, 1fr); /* 3 columns */
  gap: 20px;
}

.mega-menu-column h4 {
  font-size: 20px;
    margin-bottom: 10px;
    color: #ba2a21;
    font-weight: 900;
}

.mega-menu-column ul {
  list-style: none;
  padding: 0;
}

.mega-menu-column ul li {
  margin-bottom: 5px;
}

.mega-menu-column ul li a {
  text-decoration: none;
  color: #333;
  font-size: 14px;
}

.mega-menu-column ul li a:hover {
  color: #007bff;
}

header .header-body .is-sticky .edu-navbar .edu-nav .mega-menu li a {
  color: #000 !important;
}
header .header-body .edu-navbar .edu-nav .mega-menu li a:before {
  content: none !important;
}
header .header-body .edu-navbar .edu-nav .mega-menu li a {
  padding: 0 !important;
}
header .header-body .edu-navbar .edu-nav .mega-menu li a {
  font-family: "Open Sans", sans-serif;
  font-weight: normal;
  color: black;
  font-size: 12px;
  padding: 14px 0;
  margin-bottom: 15px;
  display: flex;
  transition: .3s;
  position: relative;
  text-decoration: none;
}
header .header-body .edu-navbar .edu-nav .mega-menu li a i {
  font-size: 10px;
    margin-right: 10px;
}
header .header-body .edu-navbar .edu-nav .mega-menu li {
  margin-left: 0px;
  position: relative;
}
.mega-men {
  border-right: 1px solid #66666654;
    padding-left: 10px;
    padding-right: 10px;
}

 @media (max-width: 1024px) {
  .gmiu-cell{
  display: none !important;
  }   
  }
  
 @media (min-width: 1024px) {
  .gmiu-cel{
   display: none !important;
  }   
}

</style>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NMDXN8BH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<header id="header">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-12 header-top-left">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone top-icon"></i>
                            <a style="color:white;" href="tel:+91 90999 51160">+91 90999 51160</a>
                        </li>
                        <li><i class="fa fa-envelope top-icon"></i>
                            <a style="color:white;" href="mailto:info@gmiu.edu.in"> info@gmiu.edu.in</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-xs-12 header-top-right">
                    <ul class="list-unstyled">
                        <li><a href="https://gmiu.edu.in/campus/virtualtour"><i class="fa fa-street-view top-icon"></i>
                                360 Virtual Tour</a>
                        </li>
                       <li><a href="<?php echo $base_url_admission; ?>" style="animation: highlight-blink 0.8s infinite; text-shadow: 0px 0px 5px #fff; font-size: 1.2em;"><i class="fa fa-globe top-icon"></i> <span style="font-weight: bold;">Admission 2024-25</span></a></li>
                            <li><a href="https://gmiu.edu.in/gmiu/website/admission/phd_notification.php"><i class="fa fa-globe top-icon"></i>Ph.D Notification</a></li>
                            
                            <style>
                                @keyframes highlight-blink {
                                    0% { background-color: red; }
                                    50% { background-color: transparent; }
                                    100% { background-color: red; }
                                }
                            </style>

                        <!--  <li><a href="login.html"><i class="fa fa-lock top-icon"></i>Login</a></li> -->
                    </ul>
                </div>
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
                    <img id="nav-logo" src="<?php echo $website_assets_url;?>images/gmiulogo.png" alt="">
                </div>

                <div class="collapse navbar-collapse edu-nav main-menu" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav pull-right">
                        <li class="active"><a data-scroll="" href="<?php echo $base_url_website;?>">Home</a></li>
                        <li><a data-scroll="" href="<?php echo $base_url_website_about;?>about_university.php">About</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_about;?>about_university.php">About
                                        University</a></li>
                                <li><a
                                        href="<?php echo $base_url_website_about;?>about_gyanmudra_education_foundation.php">About
                                        Gyanmudra Education Foundation</a></li>
                                <li><a href="<?php echo $base_url_website_about;?>about_leadership.php">Leadership</a>
                                </li>
                                <!--                    <li><a href="<?php /* echo $base_url_website_about; */?>about_chairman_message.php">Chairman
                                        Message</a></li> -->
                                <li><a href="<?php echo $base_url_website_about;?>about_chairman_message.php">President
                                        Message</a></li>
                                <li><a href="<?php echo $base_url_website_about;?>about_provost_message.php">Provost
                                        Message</a></li>
                                <li><a href="<?php echo $base_url_website_about;?>about_recognition.php">Recognition</a>
                                </li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="#">Faculty</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled scroll-y-faculty">
                                <?php
                                $cmd = "SELECT `name` as faculty_name,`id` as faculty_id,faculty_slug FROM `tbl_faculty` Where is_active=1 AND is_delete=0";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                <li><a href="<?php echo $base_url_website_faculty?><?php echo $row['faculty_slug']; ?>"><?php echo strtoupper($row['faculty_name']); ?></a>
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
                                <li><a href="<?php echo $base_url_website_admission; ?>why_gmiu.php">Why GMIU</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php ">Courses
                                        Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php">e-Brochure
                                        &
                                        Scope Documents</a></li><li class="dropdown-list-box-02">
                                            <a href="#">Model Paperset<i class="fa fa-angle-right menu-icon"></i></a>
                                        <ul class="dropdown-list_2 list-unstyled">
                                            <li><a href="../../modal_question_paper/gseb/">Gujarat Board paperset</a>
                                            </li>
                                        </ul>
                                    </li>
                                        
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
                                <li><a href="../placement/placement_overview_and_statistics.php">Placement
                                        Overview & Statistics</a></li>
                                <li><a href="../placement/geps.php">GMIU Employability Performance Scale</a></li>
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
                                        <li><a href="<?php echo $base_url_website_campus; ?>box-cricket.php">Box Cricket</a></li>
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
                                        <li><a href="<?php echo $base_url_website_campus; ?>project_exhibition.php">Project
                                                Exhibition</a></li>
                                        <!--<li><a href="https://gmiu.edu.in/campus/sdp">Skill development Program (SDP)</a>-->
                                        <!--</li>-->
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="">Extra Curriculum Activities<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <!--<li><a href="https://gmiu.edu.in/campus/studentclub">Student Club</a></li>-->
                                        <!--<li><a href="https://gmiu.edu.in/campus/socialconnect">Social Connect</a></li>-->
                                        <li><a href="<?php echo $base_url_website_campus; ?>mastermind.php">Mastermind</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>sports.php">Sport Activities</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>culture.php">Cultural Program</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>fdp.php">Faculty Development Program</a>
                                        </li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>cwp.php">Connect With Parents</a></li>
                                    </ul>
                                </li>
                                <!--<li><a href="https://gmiu.edu.in/campus/nationalinternationalactivities">National /-->
                                <!--        International Association</a></li>-->
                                <!--<li><a href="<?php //echo $base_url_website_campus?>about_nss.php">NSS</a></li>-->
                                <li><a href="<?php echo $base_url_website_campus; ?>academic_system.php">Academic System</a></li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                          <li class="gmiu-cel">
                            <a data-scroll href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">GMIU Cell</a>
                            <ul class="dropdown list-unstyled">
                            <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">Startup</a>
                                <ul class="dropdown-list_2 list-unstyled">
                                    <li><a href="<?php echo $base_url_website ?>startup/about_startup.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> About GMSEC</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/our_startup.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Our Startup</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/ssip.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>About SSIP & IPR</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/event.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Event list</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/startupclub.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Incubation and startup club policy</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/startup_gallery.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Gallery</a></li>
                                    <!--<li><a href="<?php // $base_url_website ?>startup/event_report.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>GMGC Event Report</a></li>-->
                                </ul>
                            </li>
                           
                            <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">International</a>
                                <ul class="dropdown-list_2 list-unstyled">
                                <li><a href="<?php echo $base_url_website ?>international_cell/about_irc.php"><i class="fa fa-arrow-right" aria-hidden="true"></i> GMIU International Relation Cell</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_icm.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> International Initiatives & Collaboration Modes</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_admission.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> International Admission</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_irc_connection.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Global Connection</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_explosure.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Global Exposure</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/contact_us.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Contact us</a></li>
                                </ul>
                             </li>
                            <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">NSS</a>
                                <ul class="dropdown-list_2 list-unstyled">
                                <li><a href="<?php echo $base_url_website ?>campus/about_nss.php"><i class="fa fa-long-arrow-right"></i>About NSS</a> </li>
                                <li><a href="<?php echo $base_url_website ?>campus/nss_unit.php"><i class="fa fa-long-arrow-right"></i>NSS Units and Program Officers </a></li>
                                <li><a href="<?php echo $base_url_website ?>campus/nss_advisory.php"><i class="fa fa-long-arrow-right"></i> Advisory committe </a></li>
                                <li> <a href="<?php echo $base_url_website ?>campus/nss.php"><i class="fa fa-long-arrow-right">  </i> Activities</a></li>
                                <li> <a href="<?php echo $base_url_website ?>campus/nss-gallary.php"><i class="fa fa-long-arrow-right"></i>NSS Gallery</a></li>
                                <li><a href="<?php echo $base_url_website ?>campus/contact_us.php"><i class="fa fa-long-arrow-right"></i>Contact Us</a></li>
                                </ul>
                                </li>
                            <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">IKSVE</a>
                                <ul class="dropdown-list_2 list-unstyled">
                                <li><a href="<?php echo $base_url_website ?>iksve/about_iksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                <li><a href="<?php echo $base_url_website ?>iksve/vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                                <li><a href="<?php echo $base_url_website ?>iksve/about_iksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Activities</a></li>
                                <li><a href="<?php echo $base_url_website ?>iksve/gallery_iksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                                <li><a href="<?php echo $base_url_website ?>iksve/contact_us_iksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                                </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="gmiu-cell">
                            <a data-scroll href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">GMIU Cell</a>
                            
                            <!-- dropdown start -->
                            <div class="mega-menu">
                                <div class="mega-menu-content">
                                <!-- Column 1: Startup Menu -->
                                <div class="mega-menu-column mega-men">
                                    <h4>Startup</h4>
                                    <ul>
                                    <li><a href="<?php echo $base_url_website ?>startup/about_startup.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> About GMSEC</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/our_startup.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Our Startup</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/ssip.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>About SSIP & IPR</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/event.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Event list</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/startupclub.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Incubation and startup club policy</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/startup_gallery.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Gallery</a></li>
                                    <!--<li><a href="<?php //echo $base_url_website ?>startup/event_report.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>GMGC Event Report</a></li>-->
                                    </ul>
                                </div>
                                
                                <!-- Column 2: International Menu -->
                                <div class="mega-menu-column mega-men">
                                    <h4>International</h4>
                                    <ul>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_irc.php"><i class="fa fa-arrow-right" aria-hidden="true"></i> GMIU International Relation Cell</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_icm.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> International Initiatives & Collaboration Modes</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_admission.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> International Admission</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_irc_connection.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Global Connection</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/about_explosure.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Global Exposure</a></li>
                                    <li><a href="<?php echo $base_url_website ?>international_cell/contact_us.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Contact us</a></li>
                                    </ul>
                                </div>
                                
                                <!-- Column 3: NSS and IKSVE -->
                                 <div class="mega-menu-column mega-men">
                                    <h4>NSS</h4>
                                    <ul>  
                                    <li><a href="<?php echo $base_url_website ?>campus/about_nss.php"><i class="fa fa-long-arrow-right"></i>About NSS</a></li>
                                    <li><a href="<?php echo $base_url_website ?>campus/nss_unit.php"><i class="fa fa-long-arrow-right"></i>NSS Units and Program Officers</a></li>
                                    <li><a href="<?php echo $base_url_website ?>campus/nss_advisory.php"><i class="fa fa-long-arrow-right"></i>Advisory committe</a></li>
                                    <li><a href="<?php echo $base_url_website ?>campus/nss.php"><i class="fa fa-long-arrow-right"></i>Activities </a></li>
                                    <li><a href="<?php echo $base_url_website ?>campus/nss-gallary.php"><i class="fa fa-long-arrow-right"></i> NSS Gallery </a> </li>
                                    <li><a href="<?php echo $base_url_website ?>campus/contact_us.php"><i class="fa fa-long-arrow-right"> </i> Contact Us </a> </li>                                            </ul>
                                </div>
                                <div class="mega-menu-column">
                                    <h4>IKSVE</h4>
                                    <ul>
                                    <li><a href="<?php echo $base_url_website ?>iksve/about_iksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                    <li><a href="<?php echo $base_url_website ?>iksve/vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                                    <li><a href="<?php echo $base_url_website ?>iksve/about_iksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Activities</a></li>
                                    <li><a href="<?php echo $base_url_website ?>iksve/about_iksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                                    <li><a href="<?php echo $base_url_website ?>iksve/contact_us_iksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <!-- dropdown end -->
                        </li>
                        <!--<li><a data-scroll href="https://gmiu.edu.in/alumni">Alumni</a></li>-->
                        <li><a data-scroll href="<?php echo $base_url_website_common; ?>website_contact_us.php">Contact
                                Us</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>
    </div>
</header>

<!--  End header section-->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const parentLi = document.querySelector('li');
  const megaMenu = document.querySelector('.mega-menu');

  parentLi.addEventListener('mouseenter', function() {
    megaMenu.style.display = 'block';
  });

  parentLi.addEventListener('mouseleave', function() {
    megaMenu.style.display = 'none';
  });
});
</script>