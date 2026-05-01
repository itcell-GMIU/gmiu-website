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

    /* Cyan blink – GIMCA */
    @keyframes blink-cyan {
        0% {
            background-color: transparent;
            box-shadow: none;
        }

        50% {
            background-color: #c62828;
            box-shadow: 0 0 14px rgba(198, 40, 40, 0.7);
        }

        100% {
            background-color: transparent;
            box-shadow: none;
        }
    }

    .blink-cyan {
        animation: blink-cyan 1.3s ease-in-out infinite;
        border-radius: 6px;
        padding: 6px 10px;
        color: #ffffff !important;
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
        background: #1F2A44 !important;
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
        <div class="container-fluid">
            <ul>
                <li><a href="https://ggc.gmiu.edu.in/">
                        <i class="fa fa-university top-icon"></i>
                        <span style="font-weight: bold;">Girls' College</span>
                    </a>
                </li>
                <li><a href="https://admission.gmiu.edu.in/" class="blink-cyan">
                        <i class="fa fa-globe top-icon"></i>
                        <span style="font-weight: bold;">Admission 2026-27</span>
                    </a>
                </li>
                <li><a href="https://gmiu.edu.in/gmiu/website/admission/uni_transfer.php">
                        <i class="fa fa-graduation-cap top-icon"></i>
                        <span style="font-weight: bold;">University Transfer</span>
                    </a>
                </li>
                <li><a href="https://erp.gmiu.edu.in/admission/student-registration">
                        <i class="fa fa-edit top-icon"></i>
                        <span style="font-weight: bold;">Apply Now</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="tel:+91 90999 51160"><i class="fa fa-phone top-icon"></i><span style="font-weight: bold;">+91 90999 51160</span></a>
                </li> -->
                <!-- <li>
                    <a href="https://gmiu.edu.in/gmiu/website/forms/virtual-counselling-form.php">
                        <i class="fa fa-video-camera top-icon"></i>
                        <span style="font-weight: bold;">Virtual Counseling</span></a>
                </li> -->
                <!-- <li><a href="<?php  // echo $base_url_website_campus;
                                    ?>360_virtual_tour.php">
                        <i class="fa fa-street-view top-icon"></i>
                        <span style="font-weight: bold;">Virtual Tour</span>
                    </a>
                </li>
                <li><a href="https://admission.gmiu.edu.in/premium/index.php">
                        <i class="fa fa-crown top-icon"></i>
                        <span style="font-weight: bold;">PLM</span>
                    </a>
                </li> -->


                <!--  <li><a href="https://gmiu.edu.in/gmiu/website/admission/phd_notification.php">
                        <i class="fa fa-globe top-icon"></i>
                        <span style="font-weight: bold;">Ph.D Admission</span>
                    </a>
                </li> -->

            </ul>
        </div>
    </div><!-- Ends: .header-top -->


    <div class="header-body">
        <nav class="navbar edu-navbar">
            <div class="container-fluid">
                <div class="navbar-header text-center">
                    <a href="https://gmiu.edu.in/gmiu/website/" title="Go to Homepage">
                        <img id="nav-logo"
                            src="<?php echo $website_assets_url; ?>images/gmiulogo.png"
                            fetchpriority="high"
                            alt="Gyanmanjari Innovative University Logo">
                    </a>
                </div>

                <div class="collapse edu-nav main-menu" id="bs-example-navbar-collapse-1">
                    <?php
                    $current_page = basename($_SERVER['PHP_SELF']);
                    $is_home = ($current_page == 'index.php' || $current_page == '');
                    $is_about = (strpos($current_page, 'about_') === 0);
                    $is_admission = (strpos($current_page, 'admission_') === 0 || strpos($current_page, 'newsletter.php') !== false || strpos($current_page, 'scholarships.php') !== false || strpos($current_page, 'transportation.php') !== false);
                    $is_placement = (strpos($current_page, 'training_') === 0 || strpos($current_page, 'placement_') === 0 || $current_page == 'geps.php');
                    $is_campus = (strpos($current_page, '360_virtual_tour.php') !== false || strpos($current_page, 'gallery.php') !== false || strpos($current_page, 'modern_class_room.php') !== false || strpos($current_page, 'advance-laboratories.php') !== false || strpos($current_page, 'library.php') !== false || strpos($current_page, 'wi-fi_campus.php') !== false || strpos($current_page, 'cafeteria.php') !== false || strpos($current_page, 'box-cricket.php') !== false || strpos($current_page, 'industryvisit.php') !== false || strpos($current_page, 'experttalk.php') !== false || strpos($current_page, 'iepprogram.php') !== false || strpos($current_page, 'project_exhibition.php') !== false || $current_page == 'mastermind.php' || $current_page == 'sports.php' || $current_page == 'culture.php' || $current_page == 'fdp.php' || $current_page == 'cwp.php' || $current_page == 'academic_system.php');
                    $is_career = ($current_page == 'career.php');
                    $is_contact = ($current_page == 'website_contact_us.php');
                    $is_programs = ($current_page == 'programs_list.php' || $current_page == 'all_programs.php' || $current_page == 'program.php');
                    ?>
                    <style>
                        @media (min-width: 992px) {
                            .edu-navbar .container {
                                display: flex !important;
                                align-items: center;
                                justify-content: space-between !important;
                                position: relative;
                            }

                            .edu-nav {
                                flex-grow: 1;
                                display: flex !important;
                                justify-content: flex-end !important;
                            }

                            .navbar-nav {
                                float: none !important;
                                display: flex !important;
                                margin: 0 !important;
                                flex-wrap: nowrap !important;
                            }

                            .navbar-nav>li {
                                margin-left: 20px !important;
                            }

                            .navbar-nav>li>a {
                                /* font-size: 13px !important; */
                                white-space: nowrap !important;
                            }

                            .navbar-header {
                                flex-shrink: 0;
                                z-index: 5;
                            }
                        }
                    </style>
                    <ul class="nav navbar-nav">
                        <li class="<?php echo $is_home ? 'active' : ''; ?>"><a href="<?php echo $base_url_website; ?>">Home</a></li>
                        <li class="<?php echo $is_about ? 'active' : ''; ?>"><a href="<?php echo $base_url_website_about; ?>about_university.php">About Us</a>
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
                        <li class="<?php echo $is_admission ? 'active' : ''; ?>"><a href="https://erp.gmiu.edu.in/admission/student-registration">Admission</a>
                            <ul class="list-unstyled dropdown">
                                <li><a href="https://erp.gmiu.edu.in/admission/student-registration">Apply Online</a></li>
                                <li><a href="https://admission.gmiu.edu.in/key-features-of-plm">Why PLM</a></li>
                                <li><a href="https://gmiu.edu.in/gmiu/website/faculty/all_programs.php">Courses
                                        Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php">e-Brochure
                                        &
                                        Scope Documents</a></li>
                                <!-- <li class="dropdown-list-box-02">
                                    <a href="#">Model Paperset<i class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="https://gmiu.edu.in/gmiu/modal_question_paper/gseb/">Gujarat Board paperset</a>
                                        </li>
                                    </ul>
                                </li>

                                <li><a href="<?php echo $base_url_website_admission; ?>importantlink.php">Important Links</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>newsletter.php">Newsletter</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>education_loan.php">Education Loan
                                        Facilities</a></li> -->
                                <li><a href="<?php echo $base_url_website_admission; ?>scholarships.php">Scholarship/EMI/Bank Loan</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>transportation.php">Hostel And Transportation</a></li>
                                <!-- <li><a href="<?php echo $base_url_website_admission; ?>admission-merit.php">Admission Merit</a></li> -->
                            </ul>
                        </li>
                        <li class="<?php echo $is_programs ? 'active' : ''; ?>"><a href="<?php echo $base_url_website_faculty; ?>all_programs.php">Programs</a>
                            <!-- dropdown start -->
                            <ul class="dropdown list-unstyled">
                                <?php
                                $level_query = 'SELECT id, name, short_name FROM tbl_level WHERE id not in (13,17,14,10,11,8,9,12,15) and is_active=1 ORDER BY FIELD(id,5,1,2,7,4,6)';
                                $level_res = mysqli_query($con, $level_query);
                                while ($nav_level_row = mysqli_fetch_assoc($level_res)) {
                                    $nav_level_name = $nav_level_row['name'];
                                    $nav_level_slug = strtolower($nav_level_row['short_name']);
                                ?>
                                    <li><a href="<?php echo $base_url_website_faculty . $nav_level_slug . '/'; ?>"><?php echo $nav_level_name; ?></a></li>
                                <?php
                                }
                                ?>
                                <li style="border-top: 1px solid #f1f5f9; margin-top: 5px;"><a href="<?php echo $base_url_website_faculty; ?>all_programs.php">View All Programs</a></li>
                            </ul>
                            <!-- dropdown end -->
                        </li>

                        <li class="<?php echo $is_placement ? 'active' : ''; ?>"><a href="<?php echo $base_url_website_placement; ?>training_and_placement_cell.php">Placement</a>
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
                        <li class="<?php echo $is_campus ? 'active' : ''; ?>"><a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">Campus</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">Campus Virtual Tour</a></li>
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
                                <!--<li><a href="<?php  // echo $base_url_website_campus
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
                                        <!--<li><a href="<?php  // $base_url_website
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
                                            <!--<li><a href="<?php  // echo $base_url_website
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
                        <li class="<?php echo $is_career ? 'active' : ''; ?>"><a href="https://gmiu.edu.in/gmiu/website/campus/career.php">Career </a></li>
                        <!--<li><a data-scroll href="https://gmiu.edu.in/alumni">Alumni</a></li>-->
                        <li class="<?php echo $is_contact ? 'active' : ''; ?>"><a href="<?php echo $base_url_website; ?>common/website_contact_us.php">Contact
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
        const parentLi = document.querySelector('.gmiu-cell');
        const megaMenu = document.querySelector('.mega-menu');

        if (parentLi && megaMenu) {
            parentLi.addEventListener('mouseenter', function() {
                megaMenu.style.display = 'block';
            });

            parentLi.addEventListener('mouseleave', function() {
                megaMenu.style.display = 'none';
            });
        }
    });
</script>