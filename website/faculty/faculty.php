<?php
include '../../common/importwebsitefile.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the id
    $faculty_id = intval($_GET['id']);

    // Fetch the corresponding slug from the database
    $cmd = $con->prepare("SELECT faculty_slug FROM tbl_faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_slug = $row['faculty_slug'];

        // Redirect to the slug-based URL
        header("Location: /gmiu/website/faculty/" . $faculty_slug, true, 301);
        exit;
    }  else {
        header("Location: https://gmiu.edu.in/gmiu/website/", true, 301);
        exit;
    }
} elseif (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
    // Process slug as usual
    $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
    $faculty_slug = validate_data($faculty_slug);

    // Fetch faculty details using the slug
    $cmd = $con->prepare("SELECT faculty.id as faculty_id, 
                                 faculty.description as faculty_description,
                                 faculty.meta_description , 
                                 faculty.meta_keywords, faculty.pageTitle, 
                                 faculty.name as faculty_name 
    from tbl_faculty as faculty WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0");
    $cmd->bind_param("s", $faculty_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_id = $row['faculty_id'];
        $institute_name = $row['faculty_name'];
        $faculty_description = $row['faculty_description'];
        $meta_description = $row['meta_description'];
        $meta_keywords = $row['meta_keywords'];
        $pageTitle = $row['pageTitle'];
    } elseif ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
        // Fetch faculty_description from the database where id = 1
        $query = $con->prepare("SELECT description, meta_description, meta_keywords, pageTitle FROM tbl_faculty WHERE id = 1");
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        $faculty_id = '1';
        $institute_name = 'INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)';
        $faculty_description = $row['description'];
        $meta_description = 'Explore Diploma Engineering at GMIU Bhavnagar – practical learning, skilled faculty, modern labs, and strong career support for aspiring engineers.';
        $meta_keywords = $row['meta_keywords'];
        $pageTitle = "Diploma Engineering in Gyanmanjari Innovative University";
    } else {
        $faculty_id = "";
        $institute_name = "";
        $faculty_description = "";
        $meta_description = "";
        $meta_keywords = "";
        $pageTitle = "";
    }
}

?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>

    <meta name="description" content="<?php echo htmlspecialchars(strip_tags($meta_description)); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars(strip_tags($meta_keywords)); ?>">


    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/font-awesome.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        .duration-intake p {
            color: #333333;
            margin-top: 4px;
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }

        .sideBar ul:not(.navSub)>li:first-child {
            width: 100%;
            background-image: linear-gradient(#ba2a21, #ba2a21);
            background-color: rgba(0, 0, 0, 0.2);
            background-blend-mode: multiply;
            margin: 3px 0;
            border-radius: 5px;
            padding: 7px 15px;
            color: #fff;
            text-transform: uppercase;
        }

        .sideBar ul li a:hover,
        .sideBar ul li a.active {
            background: #ba2a21;
            color: #fff !important;
            transform: none;
            padding-left: 25px;
        }

        /* .swiper-container {
                        width: 80%;
                        padding: 20px;
                    } */

        .swiper-slide img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .swiper-pagination {
            margin-top: 20px !important;
            /* Adjust this value as needed */
            position: relative !important;
            /* Ensure it doesn't overlap images */
        }

        .swiper-container {
            padding-bottom: 40px !important;
            /* Adjust as per requirement */
        }


        /*.swiper-pagination, .swiper-pagination-clickable, .swiper-pagination-bullets, .swiper-pagination-horizontal{*/
        /*    margin-top: 20px !important;*/
        /*}*/
    </style>

</head>
<script>
    document.documentElement.style.setProperty('--main-color', '#ba2a21'); // Change color dynamically
</script>

<body class="courses">
    <!--  Preloader -->
    <!--  <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> -->
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>
                        <?php echo $institute_name; ?>
                    </h1>
                </div>
                <p style="margin-top:5px;"><span><a href="#" style="color:#727272">Home <i class='fa fa-angle-right'></i></a></span> <span class="b-active">
                        <span class="text-uppercase"> <?php echo $institute_name ?> </span>
                    </span></p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="des">
                            <h3 class="title gradText">ABOUT FACULTY</h3>
                            <hr>
                            <p>
                                <?php echo htmlspecialchars_decode($faculty_description) ?>
                            </p>
                        </section>
                        <!-- apply now box -->
                        <section class="trausted-stu-area">
                            <!-- <div class="container"> -->
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="trausted-content">
                                        <div class="row border-box-admission">
                                            <div class="col-sm-12 col-md-9">
                                                <h3 class="title gradText" style="font-size : 17px;">ADMISSION 2026-27
                                                </h3>
                                                <hr>
                                                <h3 class="section-h-medium">For admission regarding query:</h3>
                                                <p><i class="fa-solid fa-phone"></i> <span class="mobile-number"> +91
                                                        90999 51160, </span><span class="mobile-number"> +91 75749
                                                        49494</span> </p>
                                            </div>

                                            <div class="col-sm-12 col-md-3">
                                                <div class="trausted-stu-btn">
                                                    <a href="https://admission.gmiu.edu.in" class="">Apply Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                        </section>

                        <!-- cource-1 cards  -->
                        <?php

                        $additionalWhere = "";
                      
                        if ($faculty_id == 11) {
                              $orderField = "FIELD(program.level_id,6,5,7,3,1,2,8,4,6,9,10,12,13,14,15,17)";
                         }
                         else{
                               $orderField = "FIELD(program.level_id,5,7,3,1,2,8,4,6,9,10,12,13,14,15,17)";
                         }
                        $excludedLevels = [15];

                        // Conditions based on slug
                        if ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
                            $additionalWhere = "AND program.level_id = 5";
                            $orderField = "FIELD(program.level_id,5)";
                        } elseif ($faculty_slug == 'faculty-of-engineering-amp-technology') {
                            $excludedLevels[] = 5;
                            $orderField = "FIELD(program.level_id,7,3,1,2,8,4,6,9,10,12,13,14,15,17)";
                        }

                        // Convert excluded levels to string
                        $excludedLevelStr = implode(',', $excludedLevels);

                        // Final query
                        $query = "SELECT program.level_id, level.name as level_name 
                                  FROM tbl_program AS program
                                  LEFT JOIN tbl_level level ON program.level_id = level.id
                                  WHERE program.faculty_id = $faculty_id 
                                  AND program.is_active = 1 
                                  AND program.is_delete = 0 
                                  AND program.level_id NOT IN ($excludedLevelStr)
                                  AND NOT (program.faculty_id = 27 AND program.level_id = 15)
                                  $additionalWhere
                                  GROUP BY program.level_id 
                                  ORDER BY $orderField";

                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $level_name = $row['level_name'];
                            $level_id = $row['level_id'];

                            // Brochure fetch
                            $query22 = "SELECT `document` FROM `tbl_faculty_brochure` WHERE faculty_id = $faculty_id AND level_id = $level_id LIMIT 1";
                            $result22 = mysqli_query($con, $query22);
                            $brochure = '';
                            if ($row22 = mysqli_fetch_assoc($result22)) {
                                $brochure = $row22['document'];
                            }
                            // Now use $level_name, $level_id, and $brochure as needed
                        ?>

                            <section class="two-column-cards">
                                <h3 class="title gradText">
                                    <?php echo $level_name; ?>
                                </h3>
                                <hr>
                                <div class="courses-cards">
                                    <?php
                                    // $query1 = "SELECT 
                                    //                 program.id AS program_id,
                                    //                 program.name AS program_name,
                                    //                 program.intake AS program_intake,
                                    //                 program.regular AS regular,
                                    //                 program.duration AS program_duration,
                                    //                 program_slug 
                                    //             FROM tbl_program AS program 
                                    //             WHERE 
                                    //                 program.faculty_id = $faculty_id 
                                    //                 AND program.level_id = $level_id 
                                    //                 AND program.is_active = 1 
                                    //                 AND program.is_delete = 0 
                                    //             ORDER BY 
                                    //                 CASE 
                                    //                     WHEN program.name LIKE '%premium%' THEN 1 
                                    //                     ELSE 2 
                                    //                 END,
                                    //                 CASE 
                                    //                     WHEN program.short_no = 0 THEN 2  
                                    //                     ELSE 1  
                                    //                 END,
                                    //                 program.short_no ASC,  
                                    //                 program.name ASC; 
                                    //             ";
                                     $query1 = "SELECT 
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
                                                        WHEN program.name LIKE '%PLM%' THEN 1 
                                                        ELSE 2 
                                                    END,
                                                    CASE 
                                                        WHEN program.short_no = 0 THEN 2  
                                                        ELSE 1  
                                                    END,
                                                    program.short_no ASC,  
                                                    program.name ASC; 
                                                ";
                                    $result1 = mysqli_query($con, $query1);

                                    if (mysqli_num_rows($result1) > 0) {
                                        // output data of each row
                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                            $program_name = $row1['program_name'];
                                            $program_id = $row1['program_id'];
                                            $program_slug = $row1['program_slug'];
                                            $regfees = $row1['regular'];
                                            $regyear = $row1['program_duration'];
                                            $program_intake = $row1['program_intake'];
                                            $program_duration = $row1['program_duration'];
                                            if ($faculty_id == 16) {
                                                $fees = $regfees;
                                            } else {
                                                $fees = $regfees / 2;
                                            }
                                    ?>
                                            <div class="card-for-course">
                                                <a  
                                                <?php if ($program_id != 610 && $program_id != 609 && $program_id != 323 && 
                                                $program_id != 256 && $program_id != 259 && $program_id != 244 && $program_id != 252
                                                && $program_id != 247 && $program_id != 248 && $program_id != 220 && $program_id != 192
                                                && $program_id != 223 && $program_id != 79 && $program_id != 245
                                                && $program_id != 246 && $program_id != 620) 
                                                { ?>
                                                    href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug; ?>"
                                                <?php } ?>>
                                                    <h3 class="course-name" style="word-break: auto-phrase;">
                                                        <?php echo $program_name; ?>
                                                    </h3>
                                                    <div class="duration-intake">
                                                        <p>Duration: <b>
                                                                <?php echo $program_duration; ?>
                                                                <?php if ($faculty_id == 22 || $faculty_id == 16 || $level_id == 6 ) {
                                                                    echo '';
                                                                } else {
                                                                    echo 'Years';
                                                                } ?>
                                                            </b> </p>
                                                        <!-- <p>Intake: <b> <?php //echo $program_intake; 
                                                                            ?> </b> </p> -->
                                                        <?php if ($level_id == 5 &&  $faculty_id == 1) { ?>
                                                            <!-- <p>Fees: <b> -->
                                                        <?php } elseif ($level_id == 2 &&  $faculty_id == 8) { ?>
                                                            <!-- <p>Fees: <b> -->
                                                        <?php } elseif ($faculty_id == 2) { ?>
                                                            <!-- <p>Fees: <b> -->
                                                        <?php } elseif ($level_id == 2 &&  $faculty_id == 5) { ?>
                                                            <!-- <p>Fees: <b> -->
                                                        <?php } elseif ($faculty_id == 22 || $faculty_id == 16) { ?>
                                                            <!-- <p>Fees: &nbsp;<b> -->
                                                        <?php } else { ?>
                                                            <!-- <p>Semester Fees: <b> -->
                                                        <?php }
                                                        if ($faculty_id == 22) {
                                                            // echo ' As Per Course';
                                                        } else {
                                                            // echo $fees;
                                                        } ?>
                                                        <!-- </b> </p> -->
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
                            if (
                                ($level_id == 5 && $faculty_id == 1) ||
                                ($level_id == 2 && $faculty_id == 8) ||
                                $faculty_id == 2 ||
                                ($level_id == 2 && $faculty_id == 5)
                            ) {
                            ?>
                                <div class="">
                                    <!-- <p>*Semester Fees As Per FRC.</p> -->
                                </div>
                            <?php
                            }
                            ?>

                            <?php
                            $faculty_links = [
                                1 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/Q09uiWcpCOQ',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF ENGINEERING/B.Tech/B.Tech FAQ.pdf'
                                    ],
                                    2 => [
                                        'video' => 'https://www.youtube.com/embed/dPLM06J425w',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF ENGINEERING/B.Tech/B.Tech FAQ.pdf'
                                    ],
                                    5 => [
                                        'video' => 'https://www.youtube.com/embed/qRtYABFKjxk',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF ENGINEERING/DIPLOMA ENGG/FAQ OF Diploma Engg.pdf'
                                    ],
                                    9 => [
                                        'video' => 'https://www.youtube.com/embed/dPLM06J425w',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF ENGINEERING/DIPLOMA ENGG/FAQ OF Diploma Engg.pdf'
                                    ]
                                ],
                                2 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/AaCo62xqJ54',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF PHARMACY/FAQ OF PHARMACY E_G FINAL.pdf'
                                    ],
                                    9 => [
                                        'video' => 'https://www.youtube.com/embed/AaCo62xqJ54',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF PHARMACY/FAQ OF PHARMACY E_G FINAL.pdf'
                                    ]
                                ],
                                3 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/YZTIEV403OA',
                                        'faq' => $website_assets_url . 'gmiu_doc/FECULTY OF SCIENCE/B.Sc/FAQ OF B.Sc.pdf'
                                    ],
                                    2 => [
                                        'video' => 'https://www.youtube.com/embed/p7esgc9Rz8o',
                                        'faq' => $website_assets_url . 'gmiu_doc/FECULTY OF SCIENCE/M.Sc/_FAQ OF M.Sc.pdf'
                                    ]
                                ],
                                4 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/oRDg6WDFgrM',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF COMMERCE/B.Com/FAQ OF B.COM.pdf'
                                    ],
                                    2 => [
                                        'video' => 'https://www.youtube.com/embed/kznjdUAuxJA',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF COMMERCE/M.Com/M.Com(1).pdf'
                                    ]
                                ],
                                5 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/5ZJpU_whx1k',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/BBA/FAQ BBA.pdf'
                                    ],
                                    2 => [
                                        'video' => 'https://www.youtube.com/embed/e6LuIGooOCA',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/MBA/faq MBA.pdf'
                                    ]
                                ],
                                6 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/a2roJ1ze3pE',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF ARTS/B.A/FAQ B.A.pdf'
                                    ],
                                    2 => [
                                        'video' => 'https://www.youtube.com/embed/Y1esXwLElpU',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/MBA/faq MBA.pdf'
                                    ]
                                ],
                                8 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/cuMltdXFDJU',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF COMPUTER SCIENCE/BCA/BCA FAQs.pdf'
                                    ],
                                    2 => [
                                        'video' => 'https://www.youtube.com/embed/EQAOP5e82Zk',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF COMPUTER SCIENCE/MCA/MCA FAQs (1).pdf'
                                    ]
                                ],
                                9 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/xruEuQcOc1M',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Bachelor in Design/FAQ- Bachelor Design & Home Science.pdf'
                                    ],
                                    2 => [
                                        'video' => 'https://www.youtube.com/embed/zL3VgR1A6_c',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Master in Design/FAQ- PG- Master Home Science.pdf'
                                    ],
                                    5 => [
                                        'video' => 'https://www.youtube.com/embed/0iCczYv_zcI',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Diploma in Design/FAQ- Diploma Faculty of Design.pdf'
                                    ]
                                ],
                                11 => [
                                    5 => [
                                        'video' => 'https://www.youtube.com/embed/f1U4A7HUe5o',
                                        'faq' => $website_assets_url . 'gmiu_doc/MEDICAL SCIENCE _ HEALTH CARE/FAQS Of Medical Science 2024-2025.pdf'
                                    ],
                                    7 => [
                                        'video' => 'https://www.youtube.com/embed/f1U4A7HUe5o',
                                        'faq' => $website_assets_url . 'gmiu_doc/MEDICAL SCIENCE _ HEALTH CARE/FAQS Of Medical Science 2024-2025.pdf'
                                    ]
                                ],
                                12 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/x5LHZ9Fhkc8',
                                        'faq' => $website_assets_url . 'gmiu_doc/SOCIAL WORK/BSW/BSW FAQ .pdf'
                                    ],
                                    2 => [
                                        'video' => 'https://www.youtube.com/embed/jzq7QoGiXDI',
                                        'faq' => $website_assets_url . 'gmiu_doc/SOCIAL WORK/MSW/FAQ MSW final for online.pdf'
                                    ]
                                ],
                                15 => [
                                    1 => [
                                        'video' => 'https://www.youtube.com/embed/5ZJpU_whx1k',
                                        'faq' => '#'
                                    ],
                                    5 => [
                                        'video' => 'https://www.youtube.com/embed/LyLBT3SaxDM',
                                        'faq' => $website_assets_url . 'gmiu_doc/FACULTY OF HOTEL MANAGEMENT/Bachelor of Hotel Managment/8. HM_FAQ.pdf'
                                    ]
                                ],
                                18 => [
                                    'faq' => '#'
                                ],
                                26 => [
                                    'faq' => '#'
                                ]
                            ];

                            // Determine video and FAQ
                            $video = '';
                            $faq = '#';

                            if (isset($faculty_links[$faculty_id][$level_id])) {
                                $video = $faculty_links[$faculty_id][$level_id]['video'];
                                $faq = $faculty_links[$faculty_id][$level_id]['faq'];
                            } elseif (isset($faculty_links[$faculty_id]['faq'])) {
                                $faq = $faculty_links[$faculty_id]['faq'];
                            }

                          
                            
                            // VIDEO SECTION
                            if (!empty($video)) {
                                echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                            <iframe width="100%" height="315" src="' . $video . '" 
                                            title="YouTube video player" frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                            </div>
                                        </section>';
                            }
                            ?>
                            <?php if (isset($faculty_links[$faculty_id][$level_id]) || $faculty_id == 26): 

                              // --- DYNAMIC FAQ FROM DATABASE ---
                            // $faq_path = "https://gmiu.edu.in/gmiu/website_admin/uploads/faculty_FAQ/document/";

                            // $sql = "SELECT document 
                            //         FROM tbl_faculty_faq 
                            //         WHERE faculty_id = ? AND level_id = ? AND is_active = 1 AND is_delete = 0 
                            //         ORDER BY id DESC LIMIT 1";
                            
                            // $stmt = $con->prepare($sql);
                            // $stmt->bind_param("ii", $faculty_id, $level_id);
                            // $stmt->execute();
                            // $resultFaq = $stmt->get_result();
                            
                            // if ($rowFaq = $resultFaq->fetch_assoc()) {
                            //     if (!empty($rowFaq['document'])) {
                            //         $faq1 = $faq_path . $rowFaq['document']; // override static FAQ with DB one
                            //     }
                            // }
                            //  // Step 3: Final FAQ priority → DB > Manual
                            // $finalFaq = !empty($faq1) ? $faq1 : $faq;
                            
                             // --- DYNAMIC FAQ FROM DATABASE ---
                            $faq1 = '';
                            if ($faculty_id != 26) {
                                $faq_path = "https://gmiu.edu.in/gmiu/website_admin/uploads/faculty_FAQ/document/";
                        
                                $sql = "SELECT document 
                                        FROM tbl_faculty_faq 
                                        WHERE faculty_id = ? AND level_id = ? 
                                        AND is_active = 1 AND is_delete = 0 
                                        ORDER BY id DESC LIMIT 1";
                        
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param("ii", $faculty_id, $level_id);
                                $stmt->execute();
                                $resultFaq = $stmt->get_result();
                        
                                if ($rowFaq = $resultFaq->fetch_assoc()) {
                                    if (!empty($rowFaq['document'])) {
                                        $faq1 = $faq_path . $rowFaq['document'];
                                    }
                                }
                            }
                        
                            // Final FAQ priority → DB > Manual
                            $finalFaq = !empty($faq1) ? $faq1 : ($faq ?? '');
                            ?>
                                <!-- IMPORTANT LINKS -->
                                <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="<?= $website_assets_url ?>gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                                <i class="fa-solid fa-graduation-cap"></i>
                                                <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <!-- Brochure (NOT for faculty 26) -->
                                        <?php if ($faculty_id != 26 && !empty($brochure)): ?>
                                            <?php if ($faculty_id == 5 && $level_id == 2) { ?>
                                                <a target="_blank" href="<?= $website_assets_url ?>gmiu_doc/FACULTY OF MANAGEMENT/MBA/MBA.pdf">
                                            <?php } else { ?>
                                                <a target="_blank" href="<?= $upload_website_admin_url ?>faculty_brochure/document/<?= $brochure ?>">
                                            <?php } ?>
                                                <div class="card">
                                                    <i class="fa fa-book"></i>
                                                    <p>Brochure</p>
                                                </div>
                                            </a>
                                        <?php endif; ?>

                                        <!-- FAQ (NOT for faculty 26) -->
                                        <?php if ($faculty_id != 26 && !empty($finalFaq)): ?>
                                            <a target="_blank" href="<?= $finalFaq ?>">
                                                <div class="card">
                                                    <i class="fa fa-question"></i>
                                                    <p>FAQ</p>
                                                </div>
                                            </a>
                                        <?php endif; ?>

                                        <a target="_blank" href="<?= $base_url_website_common ?>hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>

                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>

                                        <a target="_blank" href="<?= $base_url_admission ?>">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>
                            <?php endif; ?>
                        <?php
                        }

                        ?>
                        <div class="row" id="media_coverage">
                            <div class="col-sm-12 section-header-box">
                                <div class="">
                                    <h3 class="title gradText" style="color:#921d2d">SHORT REELS</h3>
                                    <hr>
                                </div>
                                <!-- ends: .section-header -->
                            </div>
                        </div>
                        <div class="swiper-container" style="overflow:hidden; margin-left: auto; margin-right: auto; ">
                            <div class="swiper-wrapper">

                                <?php

                                if ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
                                    $common_reels = [
                                        "https://youtube.com/shorts/w9P20sKv7Sw?feature=share",
                                        "https://youtube.com/shorts/eZmOzwXLcvw?feature=share",
                                        "https://youtube.com/shorts/_MOYM4pkKYM?feature=share",
                                        "https://youtube.com/shorts/wF2iEogNbWs?feature=share",
                                        "https://youtube.com/shorts/GZbkq_s4sng?feature=share",
                                        "https://youtube.com/shorts/2NZ9F_UW8B8?feature=share",
                                        "https://youtube.com/shorts/k70MguUD3K0?feature=share",
                                        "https://youtube.com/shorts/FCRJhxIGzR8?feature=share",
                                        "https://youtube.com/shorts/DcNR2rFFEVY?feature=share",
                                        "https://youtube.com/shorts/JbLtoWw38xU?feature=share",
                                        "https://youtube.com/shorts/5S_Ox1pGjPo?feature=share",
                                        "https://youtube.com/shorts/_eX_oScPBeI?feature=share",
                                        "https://youtube.com/shorts/Pqh8Qm1oGC8?feature=share",
                                        "https://youtube.com/shorts/sWv9w3pLo0o?feature=share"
                                    ];
                                } else {
                                    $common_reels = [
                                        "https://youtu.be/eZmOzwXLcvw?feature=shared",
                                        "https://youtu.be/_MOYM4pkKYM?feature=shared",
                                        "https://youtu.be/k70MguUD3K0?feature=shared",
                                        "https://youtu.be/DcNR2rFFEVY?feature=shared",
                                        "https://youtu.be/5S_Ox1pGjPo?feature=shared",
                                        "https://youtu.be/Pqh8Qm1oGC8?feature=shared",
                                        "https://youtu.be/_eX_oScPBeI?feature=shared",
                                        "https://youtube.com/shorts/vv0vnNlfx0M?feature=share",
                                        "https://youtube.com/shorts/A-K1-_TdqsA?feature=share",
                                        "https://youtube.com/shorts/Ouv7ujMfiIU",
                                        "https://youtube.com/shorts/Oi96_Ksb05k?feature=share"
                                    ];
                                }
                                // Function to extract YouTube video ID
                                function extractYouTubeID($url)
                                {
                                    // Regex patterns to match various YouTube URL formats
                                    $patterns = [
                                        '/youtu\.be\/([a-zA-Z0-9_-]+)/',  // youtu.be/VIDEO_ID
                                        '/youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/', // youtube.com/shorts/VIDEO_ID
                                        '/youtube\.com\/.*[?&]v=([a-zA-Z0-9_-]+)/', // youtube.com/watch?v=VIDEO_ID
                                        '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/' // youtube.com/embed/VIDEO_ID
                                    ];

                                    foreach ($patterns as $pattern) {
                                        if (preg_match($pattern, $url, $matches)) {
                                            return $matches[1]; // Return the extracted video ID
                                        }
                                    }
                                    return null; // Return null if no match found
                                }

                                // Generate Swiper slides for common reels
                                foreach ($common_reels as $url) {
                                    $video_id = extractYouTubeID($url);

                                    if ($video_id) {
                                        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                                        echo '<div class="swiper-slide">';
                                        echo '<a href="' . htmlspecialchars($url) . '" target="_blank">';
                                        echo '<img src="' . $thumbnail_url . '" alt="YouTube Thumbnail" >';
                                        echo '</a>';
                                        echo '</div>';
                                    } else {
                                        echo '<div class="swiper-slide"><p>Invalid video URL</p></div>';
                                    }
                                }
                                ?>

                                <?php
                                if ($faculty_slug != 'faculty-of-engineering-amp-technology-diploma') {

                                    $cmd =
                                        "SELECT `file_type`, `file` FROM `tbl_media_coverage` WHERE file_type = 'reel' AND is_active = 1 AND is_delete = 0 AND faculty_id = '$faculty_id' ORDER BY id DESC LIMIT 10";
                                    $stmt = $con->prepare($cmd);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["file_type"] === "reel") {
                                            // Extract the YouTube video ID from the URL.
                                            // This regex works for URLs containing 'embed/'
                                            preg_match(
                                                "/embed\/([^?]+)/",
                                                $row["file"],
                                                $matches
                                            );
                                            $video_id = isset($matches[1])
                                                ? $matches[1]
                                                : "";

                                            if (!empty($video_id)) {
                                                $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                                                echo '<div class="swiper-slide">';
                                                echo '<a href="' .
                                                    htmlspecialchars($row["file"]) .
                                                    '" target="_blank">';
                                                echo '<img src="' .
                                                    $thumbnail_url .
                                                    '" alt="YouTube Thumbnail">';
                                                echo "</a>";
                                                echo "</div>";
                                            } else {
                                                // Optional: Handle cases where the video ID couldn't be extracted.
                                                echo '<div class="swiper-slide"><p>Invalid video URL</p></div>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <section>
                            <h3 class="title gradText text-uppercase">DAILY POST</h3>
                            <hr>
                            <div class="news-slider">
                                <marquee onMouseOver="this.stop()" onMouseOut="this.start()" direction="left" scrollamount="20" loop="infinite">
                                    <?php
                                    if ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
                                        $cmd = $con->prepare("SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as 
                                    dp_file_type, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 
                                    AND daily_post.is_delete=0 AND (daily_post.is_common_reel = 1 OR daily_post.faculty_id = '$faculty_id')  ORDER BY daily_post.date ");
                                    } else {
                                        $cmd = $con->prepare("SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as 
                                    dp_file_type, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 
                                    AND daily_post.is_delete=0 AND (daily_post.is_common_reel = 1 OR daily_post.faculty_id = '$faculty_id') AND daily_post.id <>'917' ORDER BY daily_post.date ");
                                    }

                                    $cmd->execute();
                                    $result = $cmd->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $file_type = $row['dp_file_type'];
                                        $dp_id = $row['dp_id'];
                                        $file = $row['dp_file'];

                                        if ($file_type == "image") {
                                            $type = "daily_post";
                                            $cmd2 = $con->prepare("SELECT sp.file_name as sp_file_name FROM tbl_site_photos as sp WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0");
                                            $cmd2->bind_param("is", $dp_id, $type);
                                            $cmd2->execute();
                                            $result2 = $cmd2->get_result();
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $file_name = $row2['sp_file_name'];
                                                echo '<img src="' . $upload_website_admin_url . 'daily_post/' . $file_name . '" 
                                                           alt="daily post" 
                                                           onclick="onClick(this)"
                                                           class="modal-ns-hover-opacity">';
                                            }
                                        }
                                    }
                                    ?>
                                </marquee>
                            </div>

                            <div id="modal01" class="modal-ns" onclick="this.style.display='none'" style="display: none;">
                                <span class="close" style="margin-top: 80px;">&times;</span>
                                <div style="top:55%;" class="modal-ns-content">
                                    <img id="img01" style="max-width: unset;">
                                </div>
                            </div>
                        </section>
                        <!-- cource-2 cards  -->
                        <!-- WHY STUDY AT GMIU? section -->

                        <?php
                        $gmiu_features = [
                            [
                                'icon' => 'fa-user-graduate',
                                'title' => 'HIGHEST PLACEMENT',
                                'desc' => 'Placement process GMIU is robust and transparent process which ensures that all student got equal chance in any placement drive according to their eligibility and skills expertise which match est with recruiters.'
                            ],
                            [
                                'icon' => 'fa-arrow-up-right-dots',
                                'title' => 'SUPPORT TO START UP',
                                'desc' => 'A startup or start-up is a company or project undertaken by an entrepreneur to seek, develop, and validate a scalable business model. While entrepreneurship refers to all new businesses, including self-employment...'
                            ],
                            [
                                'icon' => 'fa-graduation-cap',
                                'title' => 'EXCELLENT ACADEMIC SYSTEM',
                                'desc' => 'providing excellent teaching learning process by highly qualified faculties. GMIU is known for the outstanding calibre of its students, well qualified faculty dedicated to teaching and research and excellent infrastructure.'
                            ],
                            [
                                'icon' => 'fa-lightbulb',
                                'title' => 'RESEARCH & INNOVATION (R&I)',
                                'desc' => 'Research and innovation (R&I) plays an essential role in triggering smart and sustainable growth and job creation. Research is an intrinsic aspect of the idea development process. Research helps guide numerous decisions that turn an idea into an innovation.'
                            ]
                        ];
                        ?>
                        <section>
                            <h3 class="title gradText">WHY STUDY AT GMIU?</h3>
                            <hr>
                            <div class="courses-cards">
                                <?php foreach ($gmiu_features as $feature): ?>
                                    <div class="wel-text-box">
                                        <div class="wel-icon">
                                            <i class="fa-solid <?= $feature['icon'] ?> fa-gmiu"></i>
                                        </div>
                                        <div class="wel-text">
                                            <h3><?= $feature['title'] ?></h3>
                                            <br>
                                            <p><?= $feature['desc'] ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>

                        <div class="swiper-container" style="overflow:hidden; margin-left: auto; margin-right: auto; ">
                            <div class="swiper-wrapper">
                                <?php for ($i = 1; $i <= 15; $i++) { ?>
                                    <div class="swiper-slide">
                                        <img src="https://www.gmiu.edu.in/gmiu/website_assets/images/associates/p<?php echo $i; ?>.jpg" alt="Associate <?php echo $i; ?>">
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- Swiper Pagination and Navigation -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
                <!-- left bar end  -->
                <!-- right bar start  -->
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <div>
                                    <ul>
                                        <li>FACULTY</li>
                                        <?php
                                        $cmd = "SELECT `name` as faculty_name, faculty_slug, `id` as faculty_id FROM `tbl_faculty` WHERE is_active=1 AND is_delete=0
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
                                        ?>
                                            <li><a href="<?php echo $base_url_website_faculty ?><?php echo $row['faculty_slug']; ?>"><i class="fa-solid fa-arrow-right"></i>
                                                    <?php echo strtoupper($row['faculty_name']); ?>
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- right bar end  -->
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
    <script src="<?php echo $website_assets_url; ?>js/custom.js"></script>
    <script src="<?php echo $website_assets_url; ?>js/home.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            // slidesPerView: 3, // Show 3 images at a time
            // spaceBetween: 20, // Adjust spacing between slides
            loop: true,
            autoplay: {
                delay: 2000, // Change slide every 2 seconds
                disableOnInteraction: false
            },
            spaceBetween: 10,
            // Parameter for center active slide 
            centeredSlides: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    initialSlide: 1,
                    loopedSlides: 3
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                    initialSlide: 1,
                    loopedSlides: 3
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                    initialSlide: 1,
                    loopedSlides: 3
                }
            },
            on: {
                init: function() {
                    this.slideToLoop(1, 0);
                }
            }
        });
    </script>
</body>

</html>