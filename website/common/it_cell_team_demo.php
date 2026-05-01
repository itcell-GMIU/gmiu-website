<?php
include '../../common/importwebsitefile.php'; 

$itCellTeam = [
    "Head of IT Cell" => [
        ["name" => "Prof. Prashant Viradiya", "image" => "prashant_viradiya.png", "role" => "IT Cell Head", "since" => "2016", "linkedin" => "https://www.linkedin.com/in/prashant-j-viradiya", "website" => "https://prashantviradiya.co.in/"],
        ["name" => "Prof. Pruthviraj Parmar", "image" => "pruthviraj_parmar1.jpg", "role" => "IT Cell Head", "since" => "2016", "linkedin" => "https://www.linkedin.com/in/pruthvirajparmar", "website" => "https://www.linkedin.com/in/pruthvirajparmar"],
    ],
    "IT Cell Staff" => [
        ["name" => "Vidhi Rathod", "image" => "vidhi.jpg", "role" => "Team Leader", "since" => "2024", "linkedin" => "https://in.linkedin.com/in/vidhi-rathod-737a74233", "website" => null],
        ["name" => "Om Bhatt", "image" => "om_bhatt.jpg", "role" => "PHP Developer", "since" => "2023", "linkedin" => "https://www.linkedin.com/in/bhatt-om-577010224/", "website" => "http://ombhatt.42web.io/"],
        // ["name" => "Bhumit Jograna", "image" => "bhumit.jpg", "role" => "Developer", "since" => "2023", "linkedin" => null, "website" => "http://jograna.duckdns.org"],
        ["name" => "Romit Keshwani", "image" => "romit.jfif", "role" => "Developer", "since" => "2024", "linkedin" => "https://in.linkedin.com/in/romit-keshvani-a96480264", "website" => null],
        ["name" => "Akshar Rathod", "image" => "akki.jpg", "role" => "Developer", "since" => "2025", "linkedin" => "https://in.linkedin.com/in/akshar-rathod", "website" => "https://aksharrathod.netlify.app/"],
        ["name" => "Dev Dholakiya", "image" => "dev.jpg", "role" => "Developer", "since" => "2025", "linkedin" => "https://www.linkedin.com/in/dev-dholakiya-0b885a220", "website" => "https://dholakiyadev.netlify.app/"],
        ["name" => "Chirag Parmar", "image" => "chirag.jpg", "role" => "Developer", "since" => "2026", "linkedin" => "https://www.linkedin.com/in/chirag-parmar-a7b19a247/", "website" => null],
    ],
    "IT Cell Official Interns" => [
    [
        "name" => "Gopal Chudasama",
        "image" => "gopal.jpeg",
        "role" => "Intern Developer",
        "since" => "2025",
        "linkedin" => "https://www.linkedin.com/in/gopalcudasama062",
        "website" => null
    ],
    [
        "name" => "Deep Joshi",
        "image" => "deep.jpg",
        "role" => "Intern Developer",
        "since" => "2025",
        "linkedin" => "https://www.linkedin.com/in/deep-joshi-068484311/",
        "website" => null
    ],
    [
        "name" => "Rudra Dodiya",
        "image" => "rudra.jpg",
        "role" => "Intern Developer",
        "since" => "2025",
        "linkedin" => "https://www.linkedin.com/in/rudra-dodiya/",
        "website" => null
    ],
    [
        "name" => "Harshrajsinh Gohil",
        "image" => "harshraj.jpg",
        "role" => "Intern Developer",
        "since" => "2026",
        "linkedin" => null,
        "website" => null
    ],
]
];
?>

<!doctype html>
<html lang="zxx">
<head>
    <?php 
        $pageTitle = "IT Cell Team | Gyanmanjari Innovative University"; 
        include '../include/importhead.php'; 
        include '../include/importcss.php'; 
    ?>
    <style>
       :root {
            --gmiu-red: #ba2a21;
            --gmiu-dark: #111827;
            --gmiu-light: #f9fafb;
            --card-radius: 18px;
            font-size: 18px;
        }
        
        body {
            background: linear-gradient(to bottom, #f8fafc, #eef2f7);
            font-family: 'Poppins', sans-serif;
        }
        
        .d-flex{
            display: flex;
        }
        
        .justify-content-center{
            justify-content: center;
        }
        
     /* ===========================
           HERO SECTION (Creative + Premium)
        =========================== */
        .hero-section {
            position: relative;
            padding: 130px 0 120px;
            text-align: center;
            color: white;
            overflow: hidden;
        
            background: linear-gradient(135deg, #ba2a21 0%, #7f1d1d 100%);
        }
        
        /* Creative Background Image Overlay */
        .hero-section::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c')
                        center/cover no-repeat;
            opacity: 0.12; /* subtle professional texture */
            z-index: 0;
        }
        
        /* Subtle Gradient Overlay */
        .hero-section::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right,
                        rgba(255,255,255,0.15),
                        transparent 60%);
            z-index: 1;
        }
        
        .hero-section .container {
            position: relative;
            z-index: 2;
        }
        
        .hero-section h1 {
            font-weight: 700;
            font-size: 3rem;
            letter-spacing: 3px;
        }
        
        .hero-section .breadcrumb a {
            color: rgba(255,255,255,0.75);
        }
        
        .hero-section .breadcrumb a:hover {
            color: white;
        }

        
        /* ===========================
           SECTION HEADER
        =========================== */
        .section-header {
            margin: 90px 0 60px;
            text-align: center;
        }
        
        .section-header h2 {
            font-weight: 700;
            font-size: 1.9rem;
            color: #111827;
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
        }
        
        /* Modern Accent Underline */
        .section-header h2::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: #ba2a21;
            border-radius: 10px;
        }

        .section-header::before,
        .section-header::after,
        .section-header h2::before {
            display: none !important;
            content: none !important;
        }

        /* ===========================
           TEAM CARD (Premium Look)
        =========================== */
        .team-card {
            background: #ffffff;
            border-radius: var(--card-radius);
            padding: 35px 25px;
            text-align: center;
            position: relative;
            transition: all 0.35s ease;
            height: 100%;
        
            /* Strong Visible Shadow */
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.08),
                0 20px 40px rgba(0, 0, 0, 0.06);
        }
        
        .team-card:hover {
            transform: translateY(-8px);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.15),
                0 30px 60px rgba(186, 42, 33, 0.18);
        }
        
        /* Top Accent Line */
        .team-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gmiu-red);
            border-top-left-radius: var(--card-radius);
            border-top-right-radius: var(--card-radius);
        }
        
        /* ===========================
           IMAGE STYLE
        =========================== */
        .img-box {
            width: 130px;
            height: 130px;
            margin: 0 auto 25px;
            position: relative;
        }
        
        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #ffffff;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        /* ===========================
           TEXT STYLING
        =========================== */
        .member-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 6px;
        }
        
        .member-role {
            font-size: 0.85rem;
            color: var(--gmiu-red);
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        
        .member-since {
            font-size: 0.75rem;
            color: #6b7280;
            background: #f3f4f6;
            padding: 6px 14px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 22px;
            font-weight: 500;
        }
        
        /* ===========================
           SOCIAL ICONS
        =========================== */
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #f3f4f6;
            color: #444;
            margin: 0 6px;
            transition: 0.3s ease;
            text-decoration: none;
        }
        
        .social-links a:hover {
            background: var(--gmiu-red);
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(186, 42, 33, 0.3);
        }
        
        /* ===========================
           GRID SPACING
        =========================== */
        .row.g-4 {
            margin-bottom: 20px;
        }
        .team-row {
            margin-top: 30px;
        }
        
        .team-row > div {
            margin-bottom: 40px;
        }
        
        @media (max-width: 768px) {
            .team-row > div {
                margin-bottom: 25px;
            }
        }


    </style>
</head>

<body>
    <?php include '../include/importheader.php'; ?>

    <div class="hero-section">
        <div class="container">
            <h1 class="display-3 fw-bold">IT CELL TEAM</h1>
            <!--<nav aria-label="breadcrumb">-->
            <!--    <ol class="breadcrumb justify-content-center bg-transparent">-->
            <!--        <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>-->
                    <!--<li class="breadcrumb-item active text-white" aria-current="page">IT Cell</li>-->
            <!--    </ol>-->
            <!--</nav>-->
        </div>
    </div>

    <div class="container pb-5">
        <?php foreach ($itCellTeam as $sectionTitle => $members): ?>
            
            <div class="section-header text-center">
                <h2><?php echo $sectionTitle; ?></h2>
            </div>

          <?php if(count($members) == 1): ?>
                <div class="row justify-content-center team-row d-flex">
            <?php else: ?>
                <div class="row justify-content-center team-row">
            <?php endif; ?>

                <?php foreach ($members as $member): ?>
                       <?php if(count($members) == 1): ?>
                            <div class="col-lg-4 d-flex justify-content-center">
                        <?php else: ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <?php endif; ?>
                        <div class="team-card">
                            <div class="img-box">
                                <img src="<?php echo $website_assets_url; ?>images/it_cell_team/<?php echo $member['image']; ?>" 
                                     alt="<?php echo $member['name']; ?>"
                                     onerror="this.src='<?php echo $website_assets_url; ?>images/it_cell_team/chirag.jpg'">
                            </div>
                            
                            <div class="member-name"><?php echo $member['name']; ?></div>
                            <!--<div class="member-role"><?php //echo $member['role']; ?></div>-->
                            <div class="member-since">Since <?php echo $member['since']; ?></div>

                            <div class="social-links">
                                <?php if (!empty($member['linkedin'])): ?>
                                    <a href="<?php echo $member['linkedin']; ?>" target="_blank" title="LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($member['website'])): ?>
                                    <a href="<?php echo $member['website']; ?>" target="_blank" title="Portfolio">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endforeach; ?>
    </div>

    <?php include '../include/importfooter.php'?>
    <?php include '../include/importjs.php'; ?>
</body>
</html>