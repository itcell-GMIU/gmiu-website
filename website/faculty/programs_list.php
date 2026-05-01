<?php
include '../../common/importwebsitefile.php';

$level_id = isset($_GET['level_id']) ? intval($_GET['level_id']) : 0;
$level_short = isset($_GET['level_short']) ? mysqli_real_escape_string($con, $_GET['level_short']) : '';
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : 0;
$faculty_slug = isset($_GET['faculty_slug']) ? mysqli_real_escape_string($con, $_GET['faculty_slug']) : '';

if ($level_id == 0 && empty($level_short) && $faculty_id == 0) {
    header('Location: ' . $base_url_website);
    exit();
}

// Fetch level info
if (!empty($level_short)) {
    $level_query = "SELECT id, name, short_name FROM tbl_level WHERE short_name = '$level_short' OR LOWER(short_name) = LOWER('$level_short') LIMIT 1";
} else {
    $level_query = "SELECT id, name, short_name FROM tbl_level WHERE id = $level_id";
}

$level_res = mysqli_query($con, $level_query);
$level_data = mysqli_fetch_assoc($level_res);


$level_name = ($level_data) ? $level_data['name'] : '';
$level_id = ($level_data) ? $level_data['id'] : 0;
$level_short = ($level_data && !empty($level_data['short_name'])) ? strtolower($level_data['short_name']) : $level_short;

if (!empty($faculty_slug) && $faculty_id == 0) {
    $fac_slug_query = "SELECT id, name FROM tbl_faculty WHERE LOWER(shortname) = LOWER('$faculty_slug') OR faculty_slug = '$faculty_slug' LIMIT 1";
    $fac_slug_res = mysqli_query($con, $fac_slug_query);
    $fac_slug_data = mysqli_fetch_assoc($fac_slug_res);
    if ($fac_slug_data) {
        $faculty_id = $fac_slug_data['id'];
    }
}

$faculty_name = '';
if ($faculty_id > 0) {
    $fac_query = "SELECT name FROM tbl_faculty WHERE id = $faculty_id";
    $fac_res = mysqli_query($con, $fac_query);
    $fac_data = mysqli_fetch_assoc($fac_res);
    $faculty_name = ($fac_data) ? $fac_data['name'] : '';
}

if (!$level_data && $faculty_id == 0) {
    header('Location: ' . $base_url_website);
    exit();
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php
    $displayTitle = $level_name;
    if (!empty($faculty_name)) {
        $displayTitle = !empty($displayTitle) ? $displayTitle . ' - ' . $faculty_name : $faculty_name;
    }
    $pageTitle = $displayTitle . ' | Programs | Gyanmanjari Innovative University';
    ?>
    <meta name="description" content="Explore various <?php echo strtolower($displayTitle); ?> programs offered at GMIU.">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/font-awesome.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
        body.courses {
            background-color: #f1f3f6;
            /* Slightly darker background for the whole page */
        }

        .program-section-title {
            background: #ba2a21;
            color: #fff;
            padding: 10px 20px;
            margin: 30px 0 20px 0;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .program-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .row.flex-row {
            display: flex;
            flex-wrap: wrap;
        }

        .row.flex-row>[class*='col-'] {
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
        }

        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: #ba2a21;
        }

        .program-card h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
            min-height: 50px;
        }

        .program-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .program-info b {
            color: #ba2a21;
        }

        .btn-view {
            background: #ba2a21;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            text-align: center;
            transition: 0.3s;
        }

        .btn-view:hover {
            background: #323a52;
            color: #fff;
        }

        .btn-apply {
            background: #323a52;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            text-align: center;
            transition: 0.3s;
            margin-right: 10px;
            font-weight: 600;
        }

        .btn-apply:hover {
            background: #ba2a21;
            color: #fff;
            text-decoration: none;
        }

        .no-programs {
            padding: 40px;
            text-align: center;
            background: #f9f9f9;
            border-radius: 10px;
            margin: 20px 0;
        }

        .search-container {
            margin-bottom: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 20px 30px 20px 60px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            font-size: 18px;
            transition: all 0.3s ease;
            outline: none;
            box-shadow:
                0 2px 6px rgba(0, 0, 0, 0.08),
                0 8px 20px rgba(0, 0, 0, 0.12);
            background: #fff;
        }

        .search-input:focus {
            border-color: #ba2a21;
            box-shadow:
                0 4px 10px rgba(186, 42, 33, 0.15),
                0 10px 25px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .search-input {
                box-shadow:
                    0 2px 8px rgba(0, 0, 0, 0.12);
            }

            .search-container {
                padding: 0 15px;
            }

            .search-icon {
                left: 30px !important;
                /* move slightly inside */
                font-size: 18px;
            }

            .search-input {
                padding: 14px 15px 14px 45px;
                /* reduce height + adjust icon space */
                font-size: 14px;
            }
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #323a52;
            font-size: 24px;
        }

        /* Amity Style Redesign */
        .programs-layout {
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        .sidebar {
            flex: 0 0 280px;
            position: sticky;
            top: 100px;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #eee;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .sidebar h4 {
            font-size: 13px;
            text-transform: uppercase;
            color: #323a52;
            margin-bottom: 25px;
            letter-spacing: 2px;
            font-weight: 800;
            border-bottom: 2px solid #ba2a21;
            padding-bottom: 10px;
            display: inline-block;
        }

        .discipline-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .discipline-item {
            padding: 12px 15px;
            cursor: pointer;
            font-weight: 600;
            color: #555;
            transition: all 0.3s;
            border-radius: 5px;
            margin-bottom: 8px;
            display: block;
            text-decoration: none;
            font-size: 14px;
            line-height: 1.4;
            background: #fdfdfd;
            border: 1px solid #f0f0f0;
        }

        .discipline-item:hover,
        .discipline-item.active {
            color: #fff;
            background: #323a52;
            border-color: #323a52;
            text-decoration: none;
            transform: translateX(5px);
        }

        .sidebar {
            background: #f7f7f9;
            /* soft container background */
        }

        .discipline-item {
            background: linear-gradient(90deg, #ffffff, #f9f9f9);
            border-left: 3px solid transparent;
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 12px 15px;
            display: block;
            margin-bottom: 8px;
            color: #444;
            transition: all 0.3s ease;
        }

        /* Hover effect */
        .discipline-item:hover {
            border-left: 3px solid #ba2a21;
            background: #fff5f5;
            /* light red tint */
            border-color: #ba2a21;
            color: #ba2a21;
            transform: translateX(5px);
        }

        /* Active state */
        .discipline-item.active {
            background: #ba2a21;
            color: #fff;
            border-color: #ba2a21;
        }

        .main-content {
            flex: 1;
        }

        .faculty-section {
            margin-bottom: 60px;
        }

        .faculty-header {
            font-size: 26px;
            font-weight: 800;
            color: #323a52;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .faculty-header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 80px;
            height: 3px;
            background: #ba2a21;
        }

        .hero {
            background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('https://gmiu.edu.in/gmiu/website_assets/images/campus.png') !important;
            background-size: cover !important;
            background-position: center !important;
            padding: 120px 0 80px !important;
            color: #fff !important;
            text-align: center !important;
            position: relative !important;
            height: auto !important;
        }

        .hero .cont {
            width: 100% !important;
            max-width: 100% !important;
            text-align: center !important;
            transform: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .hero .cont h1 {
            font-size: 56px !important;
            font-weight: 900 !important;
            color: #fff !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .hero .cont p {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .hero .cont p span a,
        .hero .cont p span {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 14px;
            text-decoration: none;
        }

        .hero .cont p span.b-active a {
            color: #fff !important;
            font-weight: 700;
        }

        .hero hr {
            display: none;
        }

        .method-header {
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 40px 0 20px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-left: 6px solid #ba2a21;
        }

        .program-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 25px;
            background: #fff;
            border: 1px solid #eef0f2;
            margin-bottom: 15px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .program-row:hover {
            background: #fff;
            box-shadow: 0 10px 30px rgba(50, 58, 82, 0.12);
            z-index: 1;
            position: relative;
            border-color: #323a52;
            transform: translateY(-3px);
        }

        .program-name {
            font-size: 17px;
            font-weight: 700;
            color: #333;
            flex: 1;
            padding-right: 20px;
        }

        .program-row:hover .program-name {
            color: #ba2a21;
        }

        .program-meta {
            color: #777;
            font-size: 13px;
            margin-right: 35px;
            white-space: nowrap;
            font-weight: 500;
        }

        .program-meta i {
            margin-right: 10px;
            color: #323a52;
            font-size: 16px;
            width: 20px;
            text-align: center;
            display: inline-block;
        }

        @media (max-width: 991px) {
            .search-container {
                padding: 0 20px;
                margin-bottom: 30px;
            }

            .programs-layout {
                flex-direction: column;
                padding: 0 15px;
            }

            .sidebar {
                position: relative;
                top: 0;
                width: 100%;
                flex: none;
                margin-bottom: 30px;
                box-shadow: none;
            }

            .program-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                margin-left: 5px;
                margin-right: 5px;
            }

            .program-meta {
                margin-right: 0;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
        }

        @media (max-width: 768px) {
            .faculty-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .faculty-header span {
                display: block;
                font-size: 13px;
                color: #999;
            }

            .faculty-header span {
                background: #f5f5f5;
                padding: 3px 10px;
                border-radius: 20px;
                font-size: 12px;
            }
        }

        .courses header .header-body {

            min-height: 0 !important;
        }

        body:before {
            display: none !important;
        }
    </style>
</head>

<body class="courses">
    <!--   Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <?php include '../include/importheader.php'; ?>

    <section class="hero">
        <div class="container">
            <div class="cont">
                <h1><?php echo !empty($level_name) ? $level_name : $faculty_name; ?></h1>
                <p>
                    <span><a href="<?php echo $base_url_website; ?>">Home</a> <i class='fa fa-angle-right' style="font-size: 12px; opacity: 0.6;"></i></span>
                    <span class="b-active"><a href="#"><?php echo !empty($level_name) ? $level_name : $faculty_name; ?></a></span>
                </p>
            </div>
        </div>
    </section>
    <div class="container" style="padding: 60px 0;">
        <div class="search-container">
            <i class="fa fa-search search-icon"></i>
            <input type="text" id="programSearch" class="search-input" placeholder="Find Your <?php echo strtoupper($level_short); ?> Program..." onkeyup="filterPrograms()">
        </div>

        <?php
        // Fetch programs grouped by faculty
        $initial_faculty_id = $faculty_id; // Store for initial filter
        if ($level_id > 0) {
            $where_clauses[] = "p.level_id = $level_id";
        }
        // Removed faculty_id filter from SQL to fetch all programs for dynamic filtering
        $where_sql = implode(" AND ", $where_clauses);

        $query = "SELECT p.*, f.name as faculty_name, f.faculty_slug 
                  FROM tbl_program p 
                  JOIN tbl_faculty f ON p.faculty_id = f.id
                  WHERE $where_sql
                  ORDER BY 
                      CASE 
                          WHEN $level_id = 1 AND f.id = 1 THEN 1
                          WHEN $level_id = 1 AND f.id = 8 THEN 2
                          WHEN $level_id = 1 AND f.id = 5 THEN 3
                          WHEN $level_id = 1 THEN 4
                          ELSE 1 
                      END, 
                      f.id ASC, p.short_no ASC, p.name ASC";
        $result = mysqli_query($con, $query);

        $faculty_programs = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $faculty_programs[$row['faculty_name']][] = $row;
        }

        // Fetch all relevant faculties for the sidebar (all faculties for this level)
        $fac_list_where = "p.level_id = $level_id AND p.is_active = 1 AND p.is_delete = 0 AND f.is_active = 1 AND f.is_delete = 0";
        // Removed faculty_id filter here as well to show full sidebar

        $fac_list_query = "SELECT DISTINCT f.id, f.name, f.faculty_slug 
                          FROM tbl_faculty f
                          JOIN tbl_program p ON f.id = p.faculty_id
                          WHERE $fac_list_where
                          ORDER BY 
                              CASE 
                                  WHEN $level_id = 1 AND f.id = 1 THEN 1
                                  WHEN $level_id = 1 AND f.id = 8 THEN 2
                                  WHEN $level_id = 1 AND f.id = 5 THEN 3
                                  WHEN $level_id = 1 THEN 4
                                  ELSE 1 
                              END, 
                              f.id ASC";
        $fac_list_res = mysqli_query($con, $fac_list_query);
        $all_faculties = [];
        while ($f_row = mysqli_fetch_assoc($fac_list_res)) {
            $all_faculties[] = $f_row;
        }

        if (empty($faculty_programs) && empty($all_faculties)) {
            echo '<div class="no-programs"><h3>No programs found for this level.</h3></div>';
        } else {
        ?>
            <div class="programs-layout">
                <!-- Sidebar -->
                <aside class="sidebar">
                    <h4>Disciplines</h4>
                    <nav class="discipline-list">
                        <a href="javascript:void(0)" onclick="filterByDiscipline(0, this)" class="discipline-item <?php echo ($initial_faculty_id == 0) ? 'active' : ''; ?>">All Disciplines</a>

                        <?php
                        foreach ($all_faculties as $fac) {
                            $f_name = $fac['name'];
                            $f_id = $fac['id'];
                            $f_short = !empty($fac['shortname']) ? strtolower($fac['shortname']) : $fac['faculty_slug'];
                            $active_class = ($initial_faculty_id == $f_id) ? 'active' : '';
                        ?>
                            <a href="javascript:void(0)" onclick="filterByDiscipline(<?php echo $f_id; ?>, this)" class="discipline-item <?php echo $active_class; ?>" data-f-id="<?php echo $f_id; ?>"><?php echo $f_name; ?></a>
                        <?php
                        }
                        ?>
                    </nav>
                </aside>

                <!-- Main Content -->
                <main class="main-content">
                    <?php
                    $counter = 0;
                    foreach ($faculty_programs as $f_name => $programs) {
                        $f_id = 'faculty-' . $counter;
                        $f_slug = $programs[0]['faculty_slug'];

                        // Split into PLM and RLM
                        $f_plm = [];
                        $f_rlm = [];
                        foreach ($programs as $p) {
                            if (strpos($p['name'], '(PLM)') !== false)
                                $f_plm[] = $p;
                            else
                                $f_rlm[] = $p;
                        }
                    ?>
                        <?php 
                            $section_faculty_id = $programs[0]['faculty_id'];
                            $is_hidden = ($initial_faculty_id != 0 && $initial_faculty_id != $section_faculty_id) ? 'style="display:none;"' : '';
                        ?>
                        <section id="<?php echo $f_id; ?>" class="faculty-section" data-faculty-id="<?php echo $section_faculty_id; ?>" <?php echo $is_hidden; ?>>
                            <h2 class="faculty-header">
                                <!-- <a href="<?php //echo $base_url_website_faculty . $f_slug; 
                                                ?>" -->
                                <a href="" style="color: inherit; text-decoration: none;"><?php echo $f_name; ?></a>
                                <span style="font-size: 14px; font-weight: normal; color: #999;"><?php echo count($programs); ?> Programs</span>
                            </h2>

                            <?php if (!empty($f_plm)) { ?>
                                <h3 class="method-header">Proficient Learning Method (PLM)</h3>
                                <div class="program-rows">
                                    <?php
                                    foreach ($f_plm as $prog) {
                                        $display_name = str_replace(['(' . strtoupper($level_short) . ')', '(PLM)', '(RLM)'], '', $prog['name']);
                                    ?>
                                        <div class="program-row">
                                            <div class="program-name"><?php echo trim($display_name); ?></div>
                                            <div class="program-meta">
                                                <span><i class="fa fa-clock-o"></i> <?php echo $prog['duration']; ?> Years</span>
                                                <span style="margin-top: 5px;"><i class="fa fa-users"></i> Intake: <?php echo $prog['intake']; ?></span>
                                            </div>
                                            <a href="https://erp.gmiu.edu.in/admission/student-registration" class="btn-apply" target="_blank">Apply Now</a>
                                            <a href="<?php echo $base_url_website_faculty . $prog['faculty_slug'] . '/' . $prog['program_slug'] . '/'; ?>" class="btn-view">View Details</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <?php if (!empty($f_rlm)) { ?>
                                <h3 class="method-header">Regular Learning Method (RLM)</h3>
                                <div class="program-rows">
                                    <?php
                                    foreach ($f_rlm as $prog) {
                                        $display_name = str_replace(['(' . strtoupper($level_short) . ')', '(PLM)', '(RLM)'], '', $prog['name']);
                                    ?>
                                        <div class="program-row">
                                            <div class="program-name"><?php echo trim($display_name); ?></div>
                                            <div class="program-meta">
                                                <span><i class="fa fa-clock-o"></i> <?php echo $prog['duration']; ?> Years</span>
                                                <span style="margin-top: 5px;"><i class="fa fa-users"></i> Intake: <?php echo $prog['intake']; ?></span>
                                            </div>
                                            <a href="https://erp.gmiu.edu.in/admission/student-registration" class="btn-apply" target="_blank">Apply Now</a>
                                            <a href="<?php echo $base_url_website_faculty . $prog['faculty_slug'] . '/' . $prog['program_slug'] . '/'; ?>" class="btn-view">View Details</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </section>
                    <?php
                        $counter++;
                    }
                    ?>
                </main>
            </div>
        <?php } ?>
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
        let currentDisciplineId = <?php echo $initial_faculty_id; ?>;

        function filterByDiscipline(facultyId, element) {
            currentDisciplineId = facultyId;

            // Update active state in sidebar
            document.querySelectorAll('.discipline-item').forEach(item => {
                item.classList.remove('active');
            });
            element.classList.add('active');

            // Filter sections
            const sections = document.querySelectorAll('.faculty-section');
            sections.forEach(section => {
                const sectionId = parseInt(section.getAttribute('data-faculty-id'));
                if (facultyId === 0 || sectionId === facultyId) {
                    section.style.display = "";
                } else {
                    section.style.display = "none";
                }
            });

            // Re-run search filter to ensure consistency
            filterPrograms();

            // Smooth scroll to top of content on mobile
            if (window.innerWidth < 992) {
                document.querySelector('.main-content').scrollIntoView({ behavior: 'smooth' });
            }
        }

        function filterPrograms() {
            const filter = document.getElementById('programSearch').value.toLowerCase();
            const sections = document.querySelectorAll('.faculty-section');
            const sidebarItems = document.querySelectorAll('.discipline-item');
            let totalMatches = 0;

            sections.forEach((section) => {
                const sectionId = parseInt(section.getAttribute('data-faculty-id'));
                
                // If we have a discipline filter active, skip sections that don't match
                if (currentDisciplineId !== 0 && sectionId !== currentDisciplineId) {
                    section.style.display = "none";
                    return;
                }

                const rows = section.querySelectorAll('.program-row');
                const methodHeaders = section.querySelectorAll('.method-header');
                const rowContainers = section.querySelectorAll('.program-rows');
                let sectionMatches = 0;

                methodHeaders.forEach((header, hIndex) => {
                    const container = rowContainers[hIndex];
                    const cRows = container.querySelectorAll('.program-row');
                    let containerMatches = 0;

                    cRows.forEach(row => {
                        const title = row.querySelector('.program-name').textContent.toLowerCase();
                        if (title.includes(filter)) {
                            row.style.display = "flex";
                            containerMatches++;
                            sectionMatches++;
                            totalMatches++;
                        } else {
                            row.style.display = "none";
                        }
                    });

                    if (containerMatches > 0) {
                        header.style.display = "flex";
                        container.style.display = "block";
                    } else {
                        header.style.display = "none";
                        container.style.display = "none";
                    }
                });

                if (sectionMatches > 0) {
                    section.style.display = "";
                } else {
                    section.style.display = "none";
                }
            });

            // Handle No Results state
            let noRes = document.getElementById('noResultsMsg');
            if (totalMatches === 0 && filter !== "") {
                if (!noRes) {
                    noRes = document.createElement('div');
                    noRes.id = 'noResultsMsg';
                    noRes.className = 'no-programs';
                    noRes.innerHTML = '<h3>No matching programs found.</h3>';
                    document.querySelector('.main-content').appendChild(noRes);
                }
                noRes.style.display = "";
            } else if (noRes) {
                noRes.style.display = "none";
            }
        }
    </script>

</body>

</html>