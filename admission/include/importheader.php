<?php
//login code
include '../common/globalvariable.php';?>

<style>
    /* General mega-menu styling */
    .mega-menu {
        display: none;
        position: fixed;
        /*position: absolute;*/
        /* left: 0; */
        background-color: #fff;
        padding: 20px;
        right: 0%;
        width: 1000px;
        box-shadow: 0px 0px 8px rgb(0 0 0 / 84%);
        z-index: 9999;
    }

    .mega-menu {
        margin-right: 45px;
        width: 1200px;
        /* Adjust as needed */

    }

    /* dg d*/
    .mega-menu-column {
        position: relative;
        padding-right: 20px;
    }

    .mega-menu-column:not(:last-child) {
        border-right: 1px solid #ccc;
        padding-right: 20px;
    }



    .mega-menu-content {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        /* 3 columns */
        gap: 35px;
    }

    /*.mega-menu-column h4 {*/
    /*  font-size: 20px;*/
    /*    margin-bottom: 10px;*/
    /*    color: #ba2a21;*/
    /*    font-weight: 900;*/
    /*}*/

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
    header .header-body .is-sticky .edu-navbar .edu-nav .nav li a {
        color: black !important;
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

    @media (max-width: 480px) {
        header .header-top .header-top-left ul {
            padding: 15px 0 0 0;
        }

        header .header-top .header-top-right ul {
            padding: 0 0 15px 0;
        }
    }

    @media (max-width: 1024px) {
        .gmiu-cell {
            display: none !important;
        }
    }

    @media (min-width: 1024px) {
        .gmiu-cel {
            display: none !important;
        }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .header-top .container {
            flex-direction: column;
            gap: 10px;
        }

        .header-top ul {
            flex-direction: column;
            align-items: center;
            flex-direction: row;
            align-content: stretch;
        }

        .header-top li {
            justify-content: center;
        }


    }

    @media (max-width: 480px) {

        .header-top .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            /* Adds space between elements */
        }

    }

    .header-top {
        background: #000;
        /* Keeping the original black background */
        padding: 10px 0;
        width: 100%;
    }

    .header-top .container {
        /*display: flex;*/
        /*justify-content: center;*/
        align-items: center;
        /*flex-wrap: wrap;*/
        /*gap: 20px; */
        /* Adds space between elements */
        text-align: center;
    }

    .header-top ul {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
        width: 100%;
        gap: 15px;
        /* Space between list items */
    }



    .header-top li {
        display: flex;
        align-items: center;
    }

    .header-top a {
        color: white;
        text-decoration: none;
        transition: color 0.3s ease-in-out;
    }

    .header-top a:hover {
        color: #ba2a21;
        /* Change color on hover */
    }

    .top-icon {
        margin-right: 5px;
    }

    @media (max-width: 768px) {
        .header-top .container {
            flex-direction: column;
        }

        .header-top ul {
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* 2 equal columns */
            gap: 10px;
            /* Space between items */
            width: 100%;
            padding: 0;
            margin: 0;
            list-style: none;
            justify-content: start;
            /* Start from the left */
        }

        .header-top ul li {
            text-align: left;
            /* Align text to the left */
            padding: 5px;
            width: 100%;
        }

        .header-top li {
            align-items: unset;
            justify-content: unset;
        }
    }
</style>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NMDXN8BH"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header id="header">
    <div class="header-top">
         <?php if (!empty($student_id)) { ?>
        <div class="container-fluid">
            <ul>
                <li>
                    <a href="tel:+91 90999 51160"><i class="fa fa-phone top-icon"></i><span style="font-weight: bold;">+91 90999 51160</span></a>
                </li>
                <li><a href="<?php echo $base_url_admission; ?>" style="animation: highlight-blink 1s infinite;">
                        <i class="fa fa-globe top-icon"></i> <span style="font-weight: bold;">Admission 2025-26</span>
                    </a>
                </li>
            </ul>
        </div>
       <!-- Ends: .header-top -->
         <?php } else { ?>
          <div class="container-fluid">
            <ul>
                <li>
                    <a href="tel:+91 90999 51160"><i class="fa fa-phone top-icon"></i><span style="font-weight: bold;">+91 90999 51160</span></a>
                </li>
                <li>
                    <a href="mailto:info@gmiu.edu.in"><i class="fa fa-envelope top-icon"></i><span style="font-weight: bold;">info@gmiu.edu.in</span></a>
                </li>
                <li><a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">
                        <i class="fa fa-street-view top-icon"></i> 360 Virtual Tour
                    </a>
                </li>
                <li><a href="https://admission.gmiu.edu.in/premium/index.php">
                        <i class="fa fa-crown top-icon"></i>PREMIUM
                    </a>
                </li>
                <li><a href="<?php echo $base_url_admission; ?>" style="animation: highlight-blink 1s infinite;">
                        <i class="fa fa-globe top-icon"></i> <span style="font-weight: bold;">Admission 2025-26</span>
                    </a>
                </li>
                <li><a href="https://admission.gmiu.edu.in/admission/girlscollege.php">
                        <i class="fa fa-university top-icon"></i> Girls' College
                    </a>
                </li>
                <li><a href="https://gmiu.edu.in/gmiu/website/admission/phd_notification.php">
                        <i class="fa fa-globe top-icon"></i> Ph.D Admission
                    </a>
                </li>
                <li><a href="">
                        <i class="fa fa-graduation-cap top-icon"></i> University Transfer
                    </a>
                </li>
            </ul>
        </div>
       
    <?php } ?>
    </div>
    <div class="header-body">
        <nav class="navbar edu-navbar">
            <div class="container">
                <div class="navbar-header text-center">
                    <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"-->
                    <!--    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">-->
                    <!--    <span class="sr-only">Toggle navigation</span>-->
                    <!--    <span class="icon-bar"></span>-->
                    <!--    <span class="icon-bar"></span>-->
                    <!--    <span class="icon-bar"></span>-->
                    <!--</button>-->
                    <img id="nav-logo" src="<?php echo $website_assets_url; ?>images/gmiulogo.png" alt=" Gyanmanjari Innovation University">
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
                        <li class="active"><a data-scroll="" href="<?php echo $base_url_website; ?>">Home</a></li>
                        <li><a data-scroll="" href="<?php echo $base_url_website_about; ?>about_university.php">About</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_about; ?>about_university.php">About
                                        University</a></li>
                                <li><a
                                        href="<?php echo $base_url_website_about; ?>about_gyanmudra_education_foundation.php">About
                                        Gyanmudra Education Foundation</a></li>
                                <li><a href="<?php echo $base_url_website_about; ?>about_leadership.php">Leadership</a>
                                </li>
                                <!--                    <li><a href="<?php /* echo $base_url_website_about; */ ?>about_chairman_message.php">Chairman
                                        Message</a></li> -->
                                <li><a href="<?php echo $base_url_website_about; ?>about_chairman_message.php">President
                                        Message</a></li>
                                <li><a href="<?php echo $base_url_website_about; ?>about_provost_message.php">Provost
                                        Message</a></li>
                                <li><a href="<?php echo $base_url_website_about; ?>about_recognition.php">Recognition</a>
                                </li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="#">Institute</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled scroll-y-faculty"  style="width: 455px; height: 340px;">
                                <li>
                                    <a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma" target="_blank">
                                        INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)
                                    </a>
                                </li>
                                <?php
                                $cmd = "SELECT `name` as faculty_name,`id` as faculty_id,faculty_slug FROM `tbl_faculty` Where is_active=1 AND is_delete=0
                                ORDER BY 
                                CASE 
                                    WHEN id BETWEEN 1 AND 9 THEN 1
                                    WHEN id IN (26, 27) THEN 2
                                    ELSE 3
                                END,
                                id";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                       $faculty_name = ($row['faculty_id'] == 1) ? strtoupper($row['faculty_name']) . " (DEGREE)" : strtoupper($row['faculty_name']);
                                ?>
                                    <li><a href="<?php echo $base_url_website_faculty ?><?php echo $row['faculty_slug']; ?>"><?php echo $faculty_name; ?></a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>


                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="<?php echo $base_url_admission; ?>">Admission</a>
                            <ul class="list-unstyled dropdown">
                                <li><a href="<?php echo $base_url_admission; ?>">Apply Online</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>why_gmiu.php">Why GMIU</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php ">Courses
                                        Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php">e-Brochure
                                        &
                                        Scope Documents</a></li>
                                <li class="dropdown-list-box-02">
                                    <a href="#">Model Paperset<i class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="https://gmiu.edu.in/gmiu/modal_question_paper/gseb/">Gujarat Board paperset</a>
                                        </li>
                                    </ul>
                                </li>

                                <li><a href="<?php echo $base_url_website_admission; ?>importantlink.php">Important Links</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>newsletter.php">Newsletter</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>education_loan.php">Education Loan
                                        Facilities</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>scholarships.php">Scholarship</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>transportation.php">Transportation Facilities</a>
                                </li>
                                 <li><a href="<?php echo $base_url_website_admission; ?>admission-merit.php">Admission Merit</a></li>
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
                                <li><a href="<?php echo $base_url_website_placement; ?>geps.php">GMIU Employability Performance Scale</a></li>
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
                                <!--<li><a href="<?php //echo $base_url_website_campus
                                                    ?>about_nss.php">NSS</a></li>-->
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
                                        <!--<li><a href="<?php // $base_url_website 
                                                            ?>startup/event_report.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>GMGC Event Report</a></li>-->
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
                                <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">GMIU Vibes</a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website ?>campus/about_nss.php"><i class="fa fa-long-arrow-right"></i>About NSS</a> </li>
                                        <li><a href="<?php echo $base_url_website ?>campus/nss_unit.php"><i class="fa fa-long-arrow-right"></i>NSS Units and Program Officers </a></li>
                                        <li><a href="<?php echo $base_url_website ?>campus/nss_advisory.php"><i class="fa fa-long-arrow-right"></i> Advisory committe </a></li>
                                        <li> <a href="<?php echo $base_url_website ?>campus/nss.php"><i class="fa fa-long-arrow-right"> </i> Activities</a></li>
                                        <li> <a href="<?php echo $base_url_website ?>campus/nss-gallary.php"><i class="fa fa-long-arrow-right"></i>NSS Gallery</a></li>
                                        <li><a href="<?php echo $base_url_website ?>campus/contact_us.php"><i class="fa fa-long-arrow-right"></i>Contact Us</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>sports.php"><i class="fa fa-long-arrow-right"> </i> Sport Activities</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>culture.php"><i class="fa fa-long-arrow-right"> </i> Cultural Program</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">BKSVE</a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website ?>bksve/about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                        <li><a href="<?php echo $base_url_website ?>bksve/vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                                        <li><a href="<?php echo $base_url_website ?>bksve/about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Activities</a></li>
                                        <li><a href="<?php echo $base_url_website ?>bksve/bksve_gallery_report.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                                        <li><a href="<?php echo $base_url_website ?>bksve/contact_us_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website ?>research/gmrdc.php">Research</a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website ?>research/gmrdc.php" class=""><i class="fa-solid fa-arrow-right"></i>GM Research & Development Cell (GMRDC)</a></li>
                                        <li><a href="<?php echo $base_url_website ?>research/ssip.php" class=""><i class="fa-solid fa-arrow-right"></i>SSIP</a></li>
                                        <li><a href="<?php echo $base_url_website ?>research/phd_program.php" class=""><i class="fa-solid fa-arrow-right"></i>Ph.D Programs</a></li>
                                        <li><a href="<?php echo $base_url_website ?>research/gmrdc.php" class=""><i class="fa-solid fa-arrow-right"></i>Research Activities</a></li>
                                        <li><a href="<?php echo $base_url_website ?>research/research_Infrastructure.php" class=""><i class="fa-solid fa-arrow-right"></i>Research Infrastructure</a></li>
                                        <li><a href="<?php echo $base_url_website ?>research/contact_us_research_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
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
                                            <!--<li><a href="<?php //echo $base_url_website 
                                                                ?>startup/event_report.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>GMGC Event Report</a></li>-->
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

                                    <!-- Column 3: NSS and bksve -->
                                    <div class="mega-menu-column mega-men">
                                        <h4>GMIU Vibes</h4>
                                        <ul>
                                            <li><a href="<?php echo $base_url_website ?>campus/about_nss.php"><i class="fa fa-long-arrow-right"></i>About NSS</a></li>
                                            <li><a href="<?php echo $base_url_website ?>campus/nss_unit.php"><i class="fa fa-long-arrow-right"></i>NSS Units and Program Officers</a></li>
                                            <li><a href="<?php echo $base_url_website ?>campus/nss_advisory.php"><i class="fa fa-long-arrow-right"></i>Advisory committe</a></li>
                                            <li><a href="<?php echo $base_url_website ?>campus/nss.php"><i class="fa fa-long-arrow-right"></i>Activities </a></li>
                                            <li><a href="<?php echo $base_url_website ?>campus/nss-gallary.php"><i class="fa fa-long-arrow-right"></i> NSS Gallery </a> </li>
                                            <li><a href="<?php echo $base_url_website ?>campus/contact_us.php"><i class="fa fa-long-arrow-right"> </i> Contact Us </a> </li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>sports.php"><i class="fa fa-long-arrow-right"> </i> Sport Activities</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>culture.php"><i class="fa fa-long-arrow-right"> </i> Cultural Program</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-column mega-men">
                                        <h4>BKSVE</h4>
                                        <ul>
                                            <li><a href="<?php echo $base_url_website ?>bksve/about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                            <li><a href="<?php echo $base_url_website ?>bksve/vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                                            <li><a href="<?php echo $base_url_website ?>bksve/about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Activities</a></li>
                                            <li><a href="<?php echo $base_url_website ?>bksve/bksve_gallery_report.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                                            <li><a href="<?php echo $base_url_website ?>bksve/contact_us_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-column mega-men">
                                        <h4>Research</h4>
                                        <ul>
                                            <li><a href="<?php echo $base_url_website ?>research/gmrdc.php"><i class="fa fa-arrow-right"
                                                        aria-hidden="true"></i>GM Research
                                                    & Development Cell
                                                    (GMRDC)</a>
                                            </li>
                                            <li><a href="<?php echo $base_url_website ?>research/ssip.php"> <i class="fa fa-arrow-right"
                                                        aria-hidden="true"></i>SSIP</a>
                                            </li>
                                            <li><a href="<?php echo $base_url_website ?>research/phd_program.php"> <i class="fa fa-arrow-right"
                                                        aria-hidden="true"></i>Ph.D
                                                    Programs</a></li>
                                            <li><a href="<?php echo $base_url_website ?>research/gmrdc.php"> <i class="fa fa-arrow-right"
                                                        aria-hidden="true"></i>Research
                                                    Activities</a></li>
                                            <li><a href="<?php echo $base_url_website ?>research/research_Infrastructure.php"> <i
                                                        class="fa fa-arrow-right" aria-hidden="true"></i>Research
                                                    Infrastructure</a></li>
                                            <li><a href="<?php echo $base_url_website ?>research/contact_us_research_cell.php"> <i
                                                        class="fa fa-arrow-right" aria-hidden="true"></i> Contact
                                                    us</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="https://gmiu.edu.in/gmiu/website/campus/career.php">Career </a></li>
                        <!--<li><a data-scroll href="https://gmiu.edu.in/alumni">Alumni</a></li>-->
                        <li><a data-scroll href="<?php echo $base_url_website_common; ?>website_contact_us.php">Contact
                                Us</a></li>
                                  <?php  }
                        ?>
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