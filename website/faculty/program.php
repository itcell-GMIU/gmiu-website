<?php
include '../../common/importwebsitefile.php';

if (isset($_GET['program_slug']) && !empty($_GET['program_slug'])) {
    $program_slug = mysqli_real_escape_string($con, $_GET['program_slug']);

    // fetch program details
    $cmd = $con->prepare("SELECT level.name as level_name, 
     REPLACE(REPLACE(REPLACE(program.name,'premium', 'PLM'),'Premium', 'PLM'),'PREMIUM', 'PLM') AS program_name,
    program.id as program_id,
    program.description as program_description, 
    program.intake as program_intake,
    program.duration as program_duration,
    program.code as program_code,
    program.meta_description, 
    program.meta_keywords,
    program.pageTitle as ppageTitle,
    program.program_slug,
    program.level_id as program_level
    from tbl_program as program 
    LEFT JOIN tbl_level as level ON program.level_id = level.id
    WHERE program.program_slug=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param('s', $program_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
        $program_id = $row['program_id'];
        $program_description = $row['program_description'];
        $program_intake = $row['program_intake'];
        $program_duration = $row['program_duration'];
        $program_code = $row['program_code'];
        $meta_description = $row['meta_description'];
        $meta_keywords = $row['meta_keywords'];
        $pageTitle = $row['ppageTitle'];
        $level_name = $row['level_name'];
        $program_level = $row['program_level'];
    } else {
        header('Location: https://gmiu.edu.in/');
        exit;
    }
} else {
    header('Location: https://gmiu.edu.in/');
    exit;
}

if (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
    $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
    $cmd = $con->prepare('SELECT faculty.name as faculty_name, faculty.id as faculty_id from tbl_faculty as faculty 
                          WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0');
    $cmd->bind_param('s', $faculty_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_id = $row['faculty_id'];
        $faculty_name = $row['faculty_name'];
    } elseif ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
        $faculty_id = '1';
        $faculty_name = 'INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)';
    } else {
        $faculty_name = '';
    }
} else {
    $faculty_id = '';
    $faculty_name = '';
}

// Logic for Right Sidebar Menus & Lab Count
if ($faculty_id == '1' && $program_id == '7') {
    $program_slug = 'under-graduation-information-technology';
}

$showLaboratories = false;
$stmt_lab = $con->prepare('SELECT COUNT(*) FROM tbl_laboratories WHERE FIND_IN_SET(?, program_id) AND is_active = 1 AND is_delete = 0');
$stmt_lab->bind_param('i', $program_id);
$stmt_lab->execute();
$stmt_lab->bind_result($labCount);
$stmt_lab->fetch();
$stmt_lab->close();
if ($labCount > 0) {
    $showLaboratories = true;
}

// Data validation for Resource Cards
function checkDataExists($con, $table, $program_id)
{
    $stmt = $con->prepare("SELECT COUNT(*) FROM $table WHERE FIND_IN_SET(?, program_id) AND is_active = 1 AND is_delete = 0");
    $stmt->bind_param('i', $program_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

$showAchievement = checkDataExists($con, 'tbl_achievement', $program_id);
$showProject = checkDataExists($con, 'tbl_our_project', $program_id);
$showExpertTalk = checkDataExists($con, 'tbl_expert_talk', $program_id);
$showIndustryVisit = checkDataExists($con, 'tbl_industry_visit', $program_id);
$showWorkshop = checkDataExists($con, 'tbl_workshop', $program_id);
$showSDP = checkDataExists($con, 'tbl_sdp', $program_id);

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php
    echo '<meta name="description" content="' . htmlspecialchars($meta_description) . '">' . "\n";
    echo '<meta name="keywords" content="' . htmlspecialchars($meta_keywords) . '">' . "\n";
    ?>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/assets/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">

    <style>
        :root {
            --primary: #dc2626;
            --primary-dark: #b91c1c;
            --navy: #0f172a;
            --text-main: #334155;
            --text-light: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .courses header .header-body {
            min-height: 0 !important;
        }

        body:before {
            display: none !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--white);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .container {
            width: 80% !important;
            max-width: 80% !important;
            margin: 0 auto !important;
        }

        header .header-body {
            min-height: 0 !important;
        }

        /* Gradient Hero Section - No Image */
        .premium-hero {
            position: relative;
            height: 45vh;
            min-height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--navy) 0%, var(--primary) 100%) !important;
            color: var(--white);
            overflow: hidden;
            text-align: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 0 20px;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-label {
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-content h1 {
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 15px;
            color: var(--white);
        }

        .hero-content p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            max-width: 800px;
            margin: 0 auto 30px;
            font-weight: 400;
            line-height: 1.6;
        }

        .hero-btns {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-premium {
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: 0.3s;
            text-decoration: none !important;
            display: inline-block;
            font-size: 14px;
        }

        .btn-primary-p {
            background: linear-gradient(135deg, var(--white) 0%, #f1f5f9 100%);
            color: var(--primary) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary-p:hover {
            background: var(--white);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-p {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: var(--white) !important;
        }

        .btn-outline-p:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--white);
            transform: translateY(-2px);
        }

        /* Page Content */
        .page-content-wrapper {
            padding: 60px 0;
            background: var(--white);
        }

        .section-header-p {
            margin-bottom: 30px;
        }

        .section-header-p h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--navy);
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .section-header-p h2::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }

        .stats-grid-p {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        /* Premium Redesign: Infrastructure & Quick Access */
        .section-header-p {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
        }

        .section-header-p h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            position: relative;
            padding-bottom: 15px;
        }

        .section-header-p h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        .view-all-p {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .view-all-p:hover {
            gap: 10px;
            color: #ba2a21;
        }

        /* Infrastructure Card */
        .infra-card-p {
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            display: grid;
            grid-template-columns: 45% 1fr 20%;
            overflow: hidden;
            margin-bottom: 50px;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .infra-img-wrapper-p {
            position: relative;
            height: 100%;
            min-height: 350px;
        }

        .infra-img-p {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .infra-content-p {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        .infra-title-p {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .infra-icon-p {
            width: 45px;
            height: 45px;
            background: rgba(186, 42, 33, 0.1);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .infra-title-p h3 {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .infra-desc-p {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .btn-infra-p {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary);
            color: var(--white);
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none !important;
            width: fit-content;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(186, 42, 33, 0.2);
        }

        .btn-infra-p:hover {
            background: #0f172a;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.2);
        }

        .infra-stats-p {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            gap: 40px;
            background: #fafafa;
        }

        .stat-item-p {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon-p {
            width: 45px;
            height: 45px;
            background: var(--white);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .stat-info-p h4 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .stat-info-p p {
            font-size: 12px;
            color: #64748b;
            margin: 0;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Quick Access Redesign */
        .quick-access-grid-p {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 50px;
        }

        .access-card-p {
            background: var(--white);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            gap: 30px;
            border: 1px solid rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }

        .access-card-p:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
        }

        .access-header-p {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .access-icon-p {
            width: 55px;
            height: 55px;
            background: rgba(186, 42, 33, 0.05);
            color: var(--primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .access-header-p h3 {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .access-list-p {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .access-link-p {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-radius: 14px;
            color: #475569;
            text-decoration: none !important;
            transition: all 0.2s ease;
            font-weight: 600;
            font-size: 15px;
            background: #f8fafc;
        }

        .access-link-p:hover {
            background: var(--primary);
            color: var(--white);
        }

        .access-link-content-p {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .access-link-icon-p {
            font-size: 16px;
            opacity: 0.8;
            color: var(--primary);
            transition: color 0.2s ease;
        }

        .access-link-p:hover .access-link-icon-p {
            color: var(--white);
        }

        .access-chevron-p {
            font-size: 12px;
            opacity: 0.3;
            transition: transform 0.2s ease;
        }

        .access-link-p:hover .access-chevron-p {
            opacity: 1;
            transform: translateX(3px);
        }

        @media (max-width: 1200px) {
            .infra-card-p {
                grid-template-columns: 40% 1fr;
            }
            .infra-stats-p {
                grid-column: span 2;
                flex-direction: row;
                justify-content: space-around;
                padding: 30px;
            }
        }

        @media (max-width: 992px) {
            .quick-access-grid-p {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .section-header-p h2 { font-size: 24px; }
            .infra-card-p { grid-template-columns: 1fr; }
            .infra-stats-p { flex-direction: column; gap: 30px; }
            .quick-access-grid-p { grid-template-columns: 1fr; }
            .access-card-p { padding: 25px; }
        }

        .infra-section-p {
            margin-top: 100px !important;
        }

        .infra-swiper {
            padding: 20px 10px 80px 10px !important;
            margin-top: 80px !important;
            position: relative;
        }
        .infra-swiper .swiper-pagination-bullet-active {
            background: var(--primary) !important;
        }
        .swiper-button-next, .swiper-button-prev {
            width: 50px !important;
            height: 50px !important;
            background: var(--white);
            border-radius: 50%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            z-index: 10;
            top: 50% !important;
            transform: translateY(-50%);
            color: var(--primary) !important;
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 18px !important;
            font-weight: bold;
        }
        .swiper-button-next { right: 20px !important; }
        .swiper-button-prev { left: 20px !important; }

        /* Sports Activity Section */
        .sports-grid-p {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .sports-card-p {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            height: 220px;
            cursor: pointer;
        }

        .sports-img-p {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .sports-card-p:hover .sports-img-p {
            transform: scale(1.1);
            filter: brightness(0.8);
        }

        @media (max-width: 992px) {
            .sports-grid-p {
                grid-template-columns: repeat(2, 1fr);
            }

            .sports-card-p {
                height: 180px;
            }
        }

        @media (max-width: 768px) {
            .stats-grid-p {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px;
            }

            .stat-card-p {
                padding: 15px 10px !important;
            }
        }

        .stat-card-p {
            background: var(--bg-light);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: 0.3s;
        }

        .stat-card-p:hover {
            background: var(--white);
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-card-p i {
            font-size: 24px;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .stat-card-p h4 {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .stat-card-p p {
            font-size: 20px;
            font-weight: 800;
            color: var(--navy);
            margin: 0;
            text-align: center !important;
        }

        /* Syllabus Table */
        .curriculum-section {
            margin-top: 50px;
        }

        .syllabus-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .syllabus-tabs::-webkit-scrollbar {
            display: none;
        }

        .sem-btn {
            padding: 10px 20px;
            background: var(--bg-light);
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            transition: 0.3s;
            font-size: 14px;
            color: var(--text-main);
            white-space: nowrap;
        }

        .sem-btn.active {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .semester-table {
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #1e293b;
            color: var(--white);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            border: none;
            padding: 18px 15px;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            font-size: 15px;
            color: var(--text-main);
            border-top: 1px solid #f1f5f9;
        }

        .subject-link {
            color: var(--navy) !important;
            text-decoration: none !important;
            transition: 0.3s;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            white-space: normal;
            line-height: 1.4;
        }

        .subject-link i {
            color: var(--primary);
            font-size: 14px;
            margin-top: 4px;
        }

        .subject-link:hover {
            color: var(--primary) !important;
            transform: translateX(5px);
        }

        /* Thinner Scrollbar */
        .syllabus-tabs::-webkit-scrollbar,
        .table-responsive::-webkit-scrollbar {
            height: 4px;
            width: 4px;
        }

        .syllabus-tabs::-webkit-scrollbar-track,
        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .syllabus-tabs::-webkit-scrollbar-thumb,
        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .syllabus-tabs::-webkit-scrollbar-thumb:hover,
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Placement Section */
        .placement-section {
            margin-top: 60px;
        }

        .placement-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        @media (max-width: 1200px) {
            .placement-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 992px) {
            .placement-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 600px) {
            .placement-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 15px;
            }
        }

        .placement-card {
            background: var(--white);
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .placement-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .student-img-wrapper {
            width: 100%;
            height: 160px;
            overflow: hidden;
            background: #f8fafc;
        }

        .student-profile-img {
            width: 100%;
            height: 100%;
            object-fit: scale-down;
            transition: 0.5s;
        }

        .placement-card:hover .student-profile-img {
            transform: scale(1.08);
        }

        .placement-info {
            padding: 12px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .student-name-p {
            font-size: 12px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 10px !important;
            line-height: 1.3;
            text-align: center !important;
        }

        .company-logo-badge {
            max-width: 90px;
            height: 35px;
            object-fit: contain;
            margin: 0 auto;
            display: block;
            opacity: 0.85;
            transition: 0.3s;
        }

        .placement-card:hover .company-logo-badge {
            opacity: 1;
            transform: scale(1.05);
        }

        /* Quick Links Grid */
        .quick-links-section {
            margin-top: 60px;
            margin-bottom: 80px;
        }

        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        /* Mobile view (force 2 columns) */
        @media (max-width: 768px) {
            .quick-links-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }

            .quick-link-card {
                padding: 15px 8px !important;
                flex-direction: column !important;
                text-align: center !important;
                gap: 5px !important;
                min-height: 110px;
                justify-content: center;
            }

            .quick-link-card i {
                width: 35px !important;
                height: 35px !important;
                font-size: 15px !important;
                margin: 0 auto;
            }

            .quick-link-card span {
                /* font-size: 11px !important; */
                line-height: 1.2;
                display: block;
                width: 100%;
                word-wrap: break-word;
            }
        }

        .quick-link-card {
            background: var(--white);
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--navy);
        }

        .quick-link-card i {
            width: 45px;
            height: 45px;
            background: rgba(220, 38, 38, 0.05);
            color: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: 0.3s;
        }

        .quick-link-card span {
            font-weight: 700;
            font-size: 16px;
        }

        .quick-link-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            background: var(--bg-light);
        }

        .quick-link-card:hover i {
            background: var(--primary);
            color: var(--white);
        }

        /* Accordion in Cards */
        .quick-link-group {
            grid-column: 1 / -1;
            margin-top: 10px;
        }

        /* Admission Banner */
        .admission-banner {
            background: linear-gradient(135deg, #7f1d1d 0%, var(--primary) 100%);
            border-radius: 20px;
            padding: 35px 50px;
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 50px 0;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.2);
            position: relative;
            overflow: hidden;
        }



        .admission-content h3 {
            font-size: 26px;
            font-weight: 900;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: var(--white);
        }

        .admission-content .query-text {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 5px;
            color: #fff !important;
            text-align: center !important;
        }

        .admission-content .contact-numbers {
            font-size: 20px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-admission-apply {
            background: var(--white);
            color: #7f1d1d !important;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-admission-apply:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .admission-banner {
                flex-direction: column;
                text-align: center;
                gap: 25px;
                padding: 30px;
            }

            .admission-content h3 {
                justify-content: center;
            }

            .admission-content .contact-numbers {
                flex-direction: column;
                justify-content: center;
                font-size: 16px;
                gap: 5px;
            }
        }

        /* PLM Features Section */
        .plm-features-p {
            margin: 40px 0 60px;
        }

        .features-grid-p {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 30px;
        }

        @media (max-width: 600px) {
            .features-grid-p {
                grid-template-columns: 2fr;
                gap: 15px;
            }
        }

        .feature-item-p {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .feature-icon-box {
            width: 45px;
            height: 45px;
            background: #fff1f1;
            color: #ba2a21;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .feature-text-p {
            font-size: 16px;
            font-weight: 700;
            color: #1F2A44;
        }

        .btn-plm-more {
            background: #ba2a21;
            color: #fff !important;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 800;
            display: inline-block;
            margin-top: 40px;
            text-decoration: none !important;
            box-shadow: 0 10px 20px rgba(186, 42, 33, 0.2);
            transition: 0.3s;
            text-transform: uppercase;
            font-size: 14px;
        }

        .btn-plm-more:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(186, 42, 33, 0.3);
            background: #a1241c;
        }

        /* Infrastructure Slider */
        .infra-slider-container {
            margin-top: 30px;
            padding-bottom: 50px;
        }

        .infra-slide {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: 0.5s;
            height: 350px;
        }

        .infra-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .infra-slide:hover img {
            transform: scale(1.1);
        }

        .infra-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 25px 20px;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
            color: var(--white);
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .infra-slide:hover .infra-caption {
            transform: translateY(0);
        }

        .infra-caption span {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }

        .swiper-pagination-progressbar {
            background: rgba(0, 0, 0, 0.1) !important;
            height: 6px !important;
            border-radius: 10px;
            bottom: 0 !important;
            top: auto !important;
        }

        .swiper-pagination-progressbar-fill {
            background: var(--primary) !important;
            border-radius: 10px;
        }

        .infra-footer-note {
            text-align: center;
            font-size: 14px;
            color: var(--text-light);
            margin-top: 15px;
            font-style: italic;
        }

        /* NEP Section */
        .nep-section {
            background: #f8fafc;
            padding: 80px 0;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .nep-container {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .nep-subtitle {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            display: block;
        }

        .nep-title {
            font-size: clamp(24px, 4vw, 40px);
            font-weight: 900;
            color: var(--navy);
            line-height: 1.2;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        .nep-description {
            font-size: 17px;
            line-height: 1.8;
            color: var(--text-main);
            margin-bottom: 45px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .nep-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .nep-card {
            background: var(--white);
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-decoration: none !important;
            transition: all 0.4s ease;
            border: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .nep-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(186, 42, 33, 0.1);
            border-color: var(--primary-light);
        }

        .nep-card i {
            font-size: 32px;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .nep-card h4 {
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .nep-card span {
            font-size: 14px;
            color: var(--text-light);
            font-weight: 500;
        }

        .nep-footer-text {
            font-size: 16px;
            color: var(--text-light);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Daily Post Grid */
        .daily-post-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .daily-post-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 1;
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease;
        }

        .daily-post-item:hover {
            transform: scale(1.02);
            box-shadow: var(--shadow-md);
        }

        .daily-post-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .daily-post-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
        }

        /* Image Modal (Lightbox) */
        .img-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content-img {
            max-width: 90%;
            max-height: 75vh;
            border-radius: 12px;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
            animation: modalZoom 0.3s ease-out;
        }

        @keyframes modalZoom {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .close-modal {
            position: absolute;
            top: 30px;
            right: 30px;
            color: var(--white);
            font-size: 40px;
            cursor: pointer;
            transition: 0.3s;
        }

        .close-modal:hover {
            color: var(--primary);
            transform: rotate(90deg);
        }
    </style>
</head>

<body class="courses">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <?php include '../include/importheader.php'; ?>

    <!-- Gradient Hero Section -->
    <section class="premium-hero">
        <div class="hero-content">
            <span class="hero-label"><?php echo $level_name; ?> Level</span>
            <h1><?php echo $program_name; ?></h1>
            <br> <!-- <p>Empowering students with industry-relevant skills and practical learning through our unique Proficient Learning Method (PLM).</p> -->
            <div class="hero-btns">
                <a href="https://erp.gmiu.edu.in/admission/student-registration" class="btn-premium btn-primary-p">Apply Online</a>
                <a href="tel:+917574949494" class="btn-premium btn-outline-p"><i class="fa fa-phone"></i> +91 75749 49494</a>
            </div>
        </div>
    </section>

    <div class="page-content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <?php
                    // Faculty Links Mapping
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

                    // Fetch Video & FAQ
                    $video_link = '';
                    $faq_link = '';
                    if (isset($faculty_links[$faculty_id][$program_level])) {
                        $video_link = $faculty_links[$faculty_id][$program_level]['video'];
                        $faq_link = $faculty_links[$faculty_id][$program_level]['faq'];
                    } elseif (isset($faculty_links[$faculty_id]['faq'])) {
                        $faq_link = $faculty_links[$faculty_id]['faq'];
                    }

                    // DB FAQ Priority
                    $faq_path = "https://gmiu.edu.in/gmiu/website_admin/uploads/faculty_FAQ/document/";
                    $sql_faq = "SELECT document FROM tbl_faculty_faq WHERE faculty_id = ? AND level_id = ? AND is_active = 1 AND is_delete = 0 ORDER BY id DESC LIMIT 1";
                    $stmt_faq = $con->prepare($sql_faq);
                    $stmt_faq->bind_param("ii", $faculty_id, $program_level);
                    $stmt_faq->execute();
                    $res_faq = $stmt_faq->get_result();
                    if ($row_faq = $res_faq->fetch_assoc()) {
                        if (!empty($row_faq['document'])) {
                            $faq_link = $faq_path . $row_faq['document'];
                        }
                    }

                    // Fetch Brochure
                    $brochure_link = '';
                    $query_b = "SELECT `document` FROM `tbl_faculty_brochure` WHERE faculty_id = $faculty_id AND level_id = $program_level LIMIT 1";
                    $res_b = mysqli_query($con, $query_b);
                    if ($row_b = mysqli_fetch_assoc($res_b)) {
                        $brochure_link = $upload_website_admin_url . 'faculty_brochure/document/' . $row_b['document'];
                    }

                    // Special Brochure Override for MBA
                    if ($faculty_id == 5 && $program_level == 2) {
                        $brochure_link = $website_assets_url . "gmiu_doc/FACULTY OF MANAGEMENT/MBA/MBA.pdf";
                    }

                    $hostel_faq = "https://admission.gmiu.edu.in/assets/common/single-page-leaflet/hostel-transportation-leaflet.webp";
                    ?>

                    <!-- Overview Section -->
                    <section class="section-p" data-aos="fade-up">
                        <div class="section-header-p">
                            <h2>About the Program</h2>
                        </div>

                        <div class="stats-grid-p">
                            <div class="stat-card-p">
                                <i class="fa fa-clock-o"></i>
                                <h4>Duration</h4>
                                <p><?php echo $program_duration; ?> Years</p>
                            </div>
                            <div class="stat-card-p">
                                <i class="fa fa-users"></i>
                                <h4>Annual Intake</h4>
                                <p><?php echo $program_intake; ?> Seats</p>
                            </div>

                        </div>

                        <div class="description-text-p" style="font-size: 16px; line-height: 1.8; color: var(--text-main); margin-bottom: 20px;">
                            <?php echo htmlspecialchars_decode($program_description); ?>
                        </div>
                    </section>

                    <!-- Key Features of PLM Section -->
                    <section class="plm-features-p" data-aos="fade-up">
                        <div class="section-header-p">
                            <h2>Key Features of PLM</h2>
                        </div>
                        <div class="features-grid-p">
                            <div class="feature-item-p">
                                <div class="feature-icon-box"><i class="fa fa-clipboard-check"></i></div>
                                <div class="feature-text-p">Skill-Based Examination</div>
                            </div>
                            <div class="feature-item-p">
                                <div class="feature-icon-box"><i class="fa fa-heart"></i></div>
                                <div class="feature-text-p">Stress-Free Teaching & Learning</div>
                            </div>
                            <div class="feature-item-p">
                                <div class="feature-icon-box"><i class="fa fa-industry"></i></div>
                                <div class="feature-text-p">Industry-Based Curriculum</div>
                            </div>
                            <div class="feature-item-p">
                                <div class="feature-icon-box"><i class="fa fa-clock-o"></i></div>
                                <div class="feature-text-p">Two-Hour Sessions</div>
                            </div>
                            <div class="feature-item-p">
                                <div class="feature-icon-box"><i class="fa fa-microchip"></i></div>
                                <div class="feature-text-p">AI-Enabled Infrastructure</div>
                            </div>
                            <div class="feature-item-p">
                                <div class="feature-icon-box"><i class="fa fa-laptop"></i></div>
                                <div class="feature-text-p">Latest Simulation Tools</div>
                            </div>
                        </div>
                        <a href="https://admission.gmiu.edu.in/key-features-of-plm" target="_blank" class="btn-plm-more">
                            VIEW MORE <i class="fa fa-arrow-right" style="margin-left: 10px;"></i>
                        </a>
                    </section>

                    <!-- Admission CTA Banner -->
                    <div class="admission-banner" data-aos="zoom-in">
                        <div class="admission-content">
                            <h3><i class="fa fa-graduation-cap"></i> ADMISSION 2026-27</h3>
                            <p class="query-text">For admission regarding query:</p>
                            <div class="contact-numbers">
                                <i class="fa fa-phone"></i>
                                <span>+91 90999 51160</span>
                                <span class="d-none d-md-inline">,</span>
                                <span>+91 75749 49494</span>
                            </div>
                        </div>
                        <a href="https://erp.gmiu.edu.in/admission/student-registration" class="btn-admission-apply">
                            Apply Now <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    <!-- Syllabus Section -->
                    <section class="curriculum-section" data-aos="fade-up">
                        <div class="section-header-p">
                            <h2>Curriculum & Syllabus</h2>
                        </div>

                        <div class="syllabus-tabs">
                            <?php
                            $cmd_sem = $con->prepare('SELECT sem FROM tbl_std_corner WHERE is_active = 1 AND is_delete = 0 and FIND_IN_SET(?, program_id) > 0 and faculty_id = ? GROUP BY sem ORDER BY sem');
                            $cmd_sem->bind_param('si', $program_id, $faculty_id);
                            $cmd_sem->execute();
                            $res_sem = $cmd_sem->get_result();
                            $firstSem = 0;
                            $sems = [];
                            while ($row_sem = $res_sem->fetch_assoc()) {
                                if ($firstSem == 0)
                                    $firstSem = $row_sem['sem'];
                                $sems[] = $row_sem['sem'];
                                echo '<button class="sem-btn ' . ($row_sem['sem'] == $firstSem ? 'active' : '') . '" onclick="showSemester(event, ' . $row_sem['sem'] . ')">Sem ' . $row_sem['sem'] . '</button>';
                            }
                            ?>
                        </div>

                        <?php
                        foreach ($sems as $curr_sem) {
                        ?>
                            <div class="semester-table" id="sem-<?php echo $curr_sem; ?>" style="display: <?php echo ($curr_sem == $firstSem ? 'block' : 'none'); ?>">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="20%">Code</th>
                                                <th>Subject Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cmd_sub = $con->prepare('SELECT subject_code, subject_name, lectures, tutorial, practical, credit, syllabus FROM tbl_std_corner WHERE sem = ? AND is_active = 1 AND is_delete = 0 and FIND_IN_SET(?, program_id) > 0 AND faculty_id = ?');
                                            $cmd_sub->bind_param('isi', $curr_sem, $program_id, $faculty_id);
                                            $cmd_sub->execute();
                                            $res_sub = $cmd_sub->get_result();
                                            while ($sub = $res_sub->fetch_assoc()) {
                                                $syllabus_link = !empty($sub['syllabus']) ? $upload_website_admin_url . 'Syllabus/' . $sub['syllabus'] : '#';
                                                echo '<tr>
                                                <td><span style="color: var(--primary); font-weight: 700;">' . $sub['subject_code'] . '</span></td>
                                                <td style="font-weight: 600;">
                                                    ' . (!empty($sub['syllabus']) ? '<a href="' . $syllabus_link . '" target="_blank" class="subject-link"><i class="fa fa-file-pdf-o"></i> ' . $sub['subject_name'] . '</a>' : $sub['subject_name']) . '
                                                </td>
                                            </tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </section>
                    <!-- Video About Department -->
                    <?php if (!empty($video_link)): ?>
                        <section class="section-p" data-aos="fade-up" style="margin-top: 40px;">
                            <div class="section-header-p">
                                <h2 style="color: #ba2a21;">Video About Department</h2>
                            </div>
                            <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 20px; box-shadow: var(--shadow-lg);">
                                <iframe src="<?php echo $video_link; ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe>
                            </div>
                            <div style="margin-top: 20px; text-align: right;">
                                <a href="<?php echo str_replace('embed/', 'watch?v=', $video_link); ?>" target="_blank" style="color: var(--primary); font-weight: 700; text-decoration: none;">
                                    Watch on YouTube <i class="fa fa-youtube-play"></i>
                                </a>
                            </div>
                        </section>
                    <?php endif; ?>
                    <!-- Placement Section (Dynamic Hide) -->
                    <?php
                    $cmd_p = $con->prepare('SELECT student_name, student_image, company_logo FROM tbl_placement WHERE FIND_IN_SET(?, program_id) AND is_active=1 AND is_delete=0 ORDER BY id DESC LIMIT 6');
                    $cmd_p->bind_param('i', $program_id);
                    $cmd_p->execute();
                    $res_p = $cmd_p->get_result();
                    if ($res_p->num_rows > 0) {
                    ?>
                        <section class="placement-section" data-aos="fade-up">
                            <div class="section-header-p">
                                <h2>Campus Placements</h2>
                            </div>
                            <div class="placement-grid">
                                <?php
                                while ($row_p = $res_p->fetch_assoc()) {
                                    $student_img = !empty($row_p['student_image']) ? $upload_website_admin_url . 'placement/student_image/' . $row_p['student_image'] : $website_assets_url . 'images/student-avatar.jpg';
                                ?>
                                    <div class="placement-card">
                                        <div class="student-img-wrapper">
                                            <img src="<?php echo $student_img; ?>" alt="Student" class="student-profile-img">
                                        </div>
                                        <div class="placement-info">
                                            <p class="student-name-p"><?php echo $row_p['student_name']; ?></p>
                                            <img src="<?php echo $upload_website_admin_url; ?>placement/company_logo/<?php echo $row_p['company_logo']; ?>" alt="Company" class="company-logo-badge">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div style="margin-top: 30px; text-align: center;">
                                <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/placement'; ?>" class="btn-premium btn-outline-p" style="color: var(--primary) !important; border-color: var(--primary);">View All Placements</a>
                            </div>
                        </section>
                    <?php } ?>

                    <!-- Sports Activity Section (Conditional) -->
                    <?php if (!in_array((int)$faculty_id, [1, 2, 3])): ?>
                        <section class="sports-section" data-aos="fade-up" style="margin-top: 50px;">
                            <div class="section-header-p">
                                <h2>Sports Activities</h2>
                            </div>
                            <div class="sports-grid-p">
                                <?php
                                $query_sports = "SELECT sp.file_name FROM tbl_site_photos sp 
                                                 JOIN tbl_campus c ON sp.type_id = c.id
                                                 WHERE sp.type = 'sports' AND c.type_id = 1 
                                                 AND sp.is_active = 1 AND sp.is_delete = 0 
                                                 AND c.is_active = 1 AND c.is_delete = 0
                                                 ORDER BY c.date DESC, sp.id DESC LIMIT 4";
                                $res_sports = mysqli_query($con, $query_sports);
                                if (mysqli_num_rows($res_sports) > 0) {
                                    while ($row_s = mysqli_fetch_assoc($res_sports)) {
                                        $sports_img = $upload_website_admin_url . 'sports/' . $row_s['file_name'];
                                ?>
                                        <div class="sports-card-p">
                                            <img src="<?php echo $sports_img; ?>" alt="Sports Activity" class="sports-img-p">
                                        </div>
                                <?php
                                    }
                                } else {
                                    // Placeholder if no photos found
                                    for ($i = 1; $i <= 4; $i++) {
                                        echo '<div class="sports-card-p"><div style="background:#eee; height:100%; display:flex; align-items:center; justify-content:center; color:#999;">Sports Photo</div></div>';
                                    }
                                }
                                ?>
                            </div>
                            <div style="margin-top: 30px; text-align: center;">
                                <a href="<?php echo $base_url_website; ?>campus/sports.php" class="btn-premium btn-outline-p" style="color: var(--primary) !important; border-color: var(--primary);">Explore All Sports <i class="fas fa-external-link-alt" style="font-size: 12px; margin-left: 5px;"></i></a>
                            </div>
                        </section>
                    <?php endif; ?>






                    <!-- State-of-the-Art Infrastructure (Laboratories) -->
                    <?php
                    $lab_images = [];
                    $cmd_labs = $con->prepare("SELECT id FROM tbl_laboratories WHERE FIND_IN_SET(?, program_id) AND is_active = 1 AND is_delete = 0");
                    $cmd_labs->bind_param('i', $program_id);
                    $cmd_labs->execute();
                    $res_labs = $cmd_labs->get_result();
                    $lab_ids = [];
                    while ($l = $res_labs->fetch_assoc()) {
                        $lab_ids[] = $l['id'];
                    }

                    if (!empty($lab_ids)) {
                        $ids_str = implode(',', $lab_ids);
                        $query_photos = "SELECT sp.file_name, l.title as lab_name, l.description as lab_desc 
                                         FROM tbl_site_photos sp 
                                         JOIN tbl_laboratories l ON sp.type_id = l.id 
                                         WHERE sp.type = 'lab' AND sp.type_id IN ($ids_str) 
                                         AND sp.is_active = 1 AND sp.is_delete = 0
                                         GROUP BY sp.type_id";
                        $res_photos = mysqli_query($con, $query_photos);
                        while ($p = mysqli_fetch_assoc($res_photos)) {
                            $lab_images[] = [
                                'url' => $upload_website_admin_url . 'laboratory/' . $p['file_name'],
                                'name' => $p['lab_name'],
                                'desc' => $p['lab_desc']
                            ];
                        }
                    }
                    ?>

                    <!-- Infrastructure Section -->
                    <?php if (!empty($lab_images)): ?>
                        <section class="infra-section-p" data-aos="fade-up">
                            <div class="section-header-p">
                                <h2>State-of-the-Art Infrastructure (Laboratories)</h2>
                            </div>
                            
                            <div class="swiper swiper-container infra-swiper">
                                <div class="swiper-wrapper">
                                    <?php foreach ($lab_images as $lab): ?>
                                        <div class="swiper-slide">
                                            <div class="infra-card-p">
                                                <div class="infra-img-wrapper-p">
                                                    <img src="<?php echo $lab['url']; ?>" alt="<?php echo $lab['name']; ?>" class="infra-img-p">
                                                </div>
                                                <div class="infra-content-p">
                                                    <div class="infra-title-p">
                                                        <div class="infra-icon-p"><i class="fas fa-flask"></i></div>
                                                        <h3><?php echo $lab['name']; ?></h3>
                                                    </div>
                                                    <p class="infra-desc-p">
                                                        <?php 
                                                            $desc = strip_tags(htmlspecialchars_decode($lab['desc']));
                                                            echo (strlen($desc) > 150) ? substr($desc, 0, 150) . '...' : $desc;
                                                        ?>
                                                    </p>
                                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-laboratories'; ?>" class="btn-infra-p">
                                                        Explore Laboratories <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                                <div class="infra-stats-p">
                                                    <div class="stat-item-p">
                                                        <div class="stat-icon-p"><i class="fas fa-microscope"></i></div>
                                                        <div class="stat-info-p">
                                                            <h4><?php echo $labCount; ?>+</h4>
                                                            <p>Laboratories</p>
                                                        </div>
                                                    </div>
                                                    <div class="stat-item-p">
                                                        <div class="stat-icon-p"><i class="fas fa-laptop-code"></i></div>
                                                        <div class="stat-info-p">
                                                            <h4>200+</h4>
                                                            <p>Equipment</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-pagination"></div>
                                <!-- Add Navigation -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </section>
                    <?php endif; ?>

                    <!-- Quick Access Section -->
                    <section class="quick-access-section-p" data-aos="fade-up">
                        <div class="section-header-p">
                            <h2>Quick Access</h2>
                            <a href="#" class="view-all-p">View All <i class="fas fa-chevron-right"></i></a>
                        </div>
                        
                        <div class="quick-access-grid-p">
                            <!-- Card 1: News & Activities -->
                            <?php if ($showExpertTalk || $showIndustryVisit || $showSDP || $showWorkshop || $showAchievement): ?>
                            <div class="access-card-p">
                                <div class="access-header-p">
                                    <div class="access-icon-p"><i class="fas fa-bullhorn"></i></div>
                                    <h3>News & Activities</h3>
                                </div>
                                <div class="access-list-p">
                                    <?php if ($showExpertTalk): ?>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-expert-talk'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-comment-dots access-link-icon-p"></i> Expert Talks</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($showIndustryVisit): ?>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-industry-visit'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-industry access-link-icon-p"></i> Industry Visits</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($showSDP): ?>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-sdp'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-lightbulb access-link-icon-p"></i> SDP Sessions</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($showWorkshop): ?>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-workshop'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-tools access-link-icon-p"></i> Workshops</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($showAchievement): ?>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-achievement'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-trophy access-link-icon-p"></i> Achievements</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Card 2: Program Resources -->
                            <div class="access-card-p">
                                <div class="access-header-p">
                                    <div class="access-icon-p"><i class="fas fa-folder-open"></i></div>
                                    <h3>Program Resources</h3>
                                </div>
                                <div class="access-list-p">
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-mission-vision'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-bullseye access-link-icon-p"></i> Mission & Vision</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-outcome'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-chart-line access-link-icon-p"></i> Program Outcomes</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <?php if ($showProject): ?>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-our-project'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-project-diagram access-link-icon-p"></i> Projects</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-faculty'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-users-cog access-link-icon-p"></i> Program Faculty</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/program-laboratories'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-vial access-link-icon-p"></i> More Resources</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Card 3: Important Links -->
                            <div class="access-card-p">
                                <div class="access-header-p">
                                    <div class="access-icon-p"><i class="fas fa-link"></i></div>
                                    <h3>Important Links</h3>
                                </div>
                                <div class="access-list-p">
                                    <a href="<?php echo $faq_link; ?>" target="_blank" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-question-circle access-link-icon-p"></i> Program FAQ</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <a href="<?php echo $brochure_link; ?>" target="_blank" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-file-pdf access-link-icon-p"></i> Brochure</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/placement'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-user-graduate access-link-icon-p"></i> Placements</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug . '/student-corner'; ?>" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-graduation-cap access-link-icon-p"></i> Student Corner</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <a href="<?php echo $hostel_faq; ?>" target="_blank" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-bus access-link-icon-p"></i> Hostel & Transport</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                    <a href="https://erp.gmiu.edu.in/admission/student-registration" target="_blank" class="access-link-p">
                                        <div class="access-link-content-p"><i class="fas fa-check-square access-link-icon-p"></i> Admission Process</div>
                                        <i class="fas fa-chevron-right access-chevron-p"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Daily Post Section -->
                    <?php
                    $dp_images = [];
                    // Limit to 4 daily posts
                    $cmd_dp = $con->prepare("SELECT id FROM tbl_daily_post WHERE FIND_IN_SET(?, program_id) AND is_active = 1 AND is_delete = 0 ORDER BY date DESC LIMIT 4");
                    $cmd_dp->bind_param('i', $program_id);
                    $cmd_dp->execute();
                    $res_dp = $cmd_dp->get_result();
                    $dp_ids = [];
                    while ($d = $res_dp->fetch_assoc()) {
                        $dp_ids[] = $d['id'];
                    }

                    if (!empty($dp_ids)) {
                        $dp_ids_str = implode(',', $dp_ids);
                        // Fetch one photo per post to keep it to 4 small images
                        $query_dp_photos = "SELECT file_name FROM tbl_site_photos WHERE type = 'daily_post' AND type_id IN ($dp_ids_str) AND is_active = 1 AND is_delete = 0 GROUP BY type_id LIMIT 4";
                        $res_dp_photos = mysqli_query($con, $query_dp_photos);
                        while ($dp_p = mysqli_fetch_assoc($res_dp_photos)) {
                            $dp_images[] = $upload_website_admin_url . 'daily_post/' . $dp_p['file_name'];
                        }
                    }

                    if (!empty($dp_images)): ?>
                        <section class="section-p" data-aos="fade-up" style="margin-top: 40px;">
                            <div class="section-header-p">
                                <h2>Daily Updates</h2>
                            </div>
                            <div class="daily-post-grid">
                                <?php foreach ($dp_images as $img): ?>
                                    <div class="daily-post-item" onclick="openModal('<?php echo $img; ?>')" style="cursor: pointer;">
                                        <img src="<?php echo $img; ?>" alt="Daily Update">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- NEP-2020 Based Academic Structure Section -->
    <div class="nep-section">
        <div class="container">
            <div class="nep-container" data-aos="fade-up">
                <span class="nep-subtitle">NEP-2020 BASED ACADEMIC STRUCTURE</span>
                <h2 class="nep-title">Transforming Education with <br>Multidisciplinary Excellence</h2>

                <p class="nep-description">
                    Aligned with the National Education Policy (NEP-2020), GMIU offers a revolutionary academic framework designed to provide students with unparalleled flexibility. Our multidisciplinary approach empowers learners to customize their educational journey through Minor specializations, Honours programs, and Dual Degree options, fostering holistic development and global employability.
                </p>

                <div class="nep-cards-grid">
                    <a href="https://admission.gmiu.edu.in/assets/home/docs/Minor%20Poster.pdf" target="_blank" class="nep-card">
                        <i class="fa fa-certificate"></i>
                        <h4>Minor Program</h4>
                        <span>Broaden your horizons with cross-disciplinary skills</span>
                    </a>
                    <a href="https://admission.gmiu.edu.in/assets/home/docs/Honours%20Programme%20Poster%20design.pdf" target="_blank" class="nep-card">
                        <i class="fa fa-star"></i>
                        <h4>Honours Program</h4>
                        <span>Deep dive into advanced research & specialization</span>
                    </a>
                    <a href="https://admission.gmiu.edu.in/assets/home/docs/Dual%20Degree%20Programs.pdf" target="_blank" class="nep-card">
                        <i class="fa fa-clone"></i>
                        <h4>Dual Degree</h4>
                        <span>Accelerate your career with integrated master's options</span>
                    </a>
                </div>

                <p class="nep-footer-text">Bridging Nations with World-Class Education</p>
            </div>
        </div>
    </div>


    <!-- Image Modal Structure -->
    <div id="imageModal" class="img-modal" onclick="closeModal()">
        <span class="close-modal">&times;</span>
        <img class="modal-content-img" id="modalImg">
    </div>

    <?php include '../include/importfooter.php' ?>
    <?php include '../include/importjs.php'; ?>
    <script src="<?php echo $website_assets_url; ?>css/assets/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Infrastructure Swiper
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Swiper library status:", typeof Swiper);
            if (typeof Swiper !== 'undefined') {
                var infraSwiper = new Swiper('.infra-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: <?php echo (count($lab_images) > 1) ? 'true' : 'false'; ?>,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.infra-swiper .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.infra-swiper .swiper-button-next',
                        prevEl: '.infra-swiper .swiper-button-prev',
                    },
                    observer: true,
                    observeParents: true
                });
                console.log("Infrastructure Swiper initialized successfully.");
            } else {
                console.error("Swiper library is not loaded!");
            }
        });



        function showSemester(evt, semId) {
            var i, semcontent, sembtns;
            semcontent = document.getElementsByClassName("semester-table");
            for (i = 0; i < semcontent.length; i++) {
                semcontent[i].style.display = "none";
            }
            sembtns = document.getElementsByClassName("sem-btn");
            for (i = 0; i < sembtns.length; i++) {
                sembtns[i].classList.remove("active");
            }
            document.getElementById('sem-' + semId).style.display = "block";
            evt.currentTarget.classList.add("active");
        }

        // Image Modal Logic
        function openModal(imgSrc) {
            document.getElementById('imageModal').style.display = 'flex';
            document.getElementById('modalImg').src = imgSrc;
            document.body.style.overflow = 'hidden'; // Prevent scroll
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scroll
        }
    </script>
</body>

</html>