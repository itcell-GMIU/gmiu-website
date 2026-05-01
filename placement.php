<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// $dbuser = "root";
// $dbpass = "";
// $host = "localhost";
// $db = "gmiu";
$dbuser="u977112581_gmiutest";
$dbpass="Test@123?";
$host="localhost";
$db="u977112581_gmiutest"; 
$con = new mysqli($host, $dbuser, $dbpass, $db);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$base_url_website_faculty = "https://gmiu.edu.in/gmiu/website/faculty/";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <title>Placement of Gyanmanjari Innovative University | Bhavnagar</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .inner-container {
            border-radius: 10px;
            padding: 40px 30px;
        }

        .logo {
            max-height: 100px;
        }

        .tagline {
            font-size: 1.25rem;
            color: #555;
            margin-left: 15px;
            white-space: wrap;
        }

        .placement-img {
            width: 100%;
            /* aspect-ratio: 1 / 1; */
            /* Keeps square aspect */
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .featured-img {
            /* Slightly larger than normal, but still square */
            /* aspect-ratio: 1 / 1; */
        }

        .placement-section {
            padding: 40px 20px;
        }

        .stats-box {
            position: relative;
            padding: 20px;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            transition: background 0.3s ease;
        }

        .stats-box:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .stats-box:last-child {
            border-right: none;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
        }

        .stats-suffix {
            font-size: 1.5rem;
        }

        .stats-label {
            font-size: 1.1rem;
            color: #eee;
        }

        @media (max-width: 768px) {
            .stats-box {
                border-right: none !important;
                border-bottom: 0px;
            }

            .stats-box:last-child {
                border-bottom: none;
            }

            .stats-number {
                font-size: 2rem;
            }

            .stats-suffix {
                font-size: 1.2rem;
            }

            .stats-label {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .tagline {
                white-space: normal;
                margin-left: 0;
                text-align: center;
            }
        }

        .card-img-top {
            object-fit: cover;
            height: 180px;
            /* match YouTube thumbnail height */
            width: 100%;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }

        .swiper {
            padding-bottom: 40px;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .swiper-slide img {
            height: 220px;
            /* Fixed height */
            width: auto;
            /* Width adjusts based on image ratio */
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        a:hover .shadow-sm {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
        }

        .program-card {
            transition: all 0.3s ease-in-out;
            border-radius: 12px;
        }

        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background-color: #fffbe6;
        }

        .program-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ba2a21;
            text-align: center;
            text-transform: capitalize;
        }

        .program-subtext {
            font-size: 0.9rem;
            color: #666;
            text-align: center;
        }

        .program-badge {
            font-size: 0.75rem;
            background-color: #ba2a21;
            color: white;
            padding: 3px 8px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 6px;
        }
    </style>
</head>

<body>

    <div class="container-fluid min-vh-100 bg-light">
        <div class="container bg-white shadow inner-container h-100 px-0 px-sm-3">

            <!-- Centered Logo and Tagline -->
            <div class="row justify-content-center align-items-center mb-4 text-center">
                <div class="col-md-6">
                    <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Logo" class="logo">
                </div>
                <div class="col-md-6 mt-5 mt-sm-0">
                    <!--<div class="fs-4"><span class="fw-bold">Skills</span> और <span class="fw-bold">Innovations</span> का-->
                    <!--    मेल <span class="fw-bold text-danger">Gyanmanjari Innovative-->
                    <!--        University</span> से बनेगा करियर-->
                    <!--    <span class="fw-bold">Very Well...</span>-->
                    <!--</div>-->
                     <div class="fs-4">
                        <span class="fw-bold">Placement</span> से 
                        <span class="fw-bold">Dream Job</span> चाहिए, तो 
                        <span class="fw-bold text-danger">PLM</span> अपनाईए...
                    </div>
                </div>
            </div>

            <div class="placement-section">
                <!-- Section Heading -->
                <div class="text-center mb-4">
                    <h1 class="fw-bold">🎓 Placement Highlights</h1>
                    <p class="text-muted">Our top recruiters and successful students</p>
                </div>

                <!-- First 2 slightly larger featured images -->
                <div class="row g-3 mb-4">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="col-6 col-md-3">
                            <img src="./website_assets/placements-image/<?php echo $i; ?>.jpg"
                                class="shadow placement-img featured-img previewable" alt="Featured <?php echo $i; ?>" />
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Remaining 14 smaller images -->
                <div class="row g-3">
                    <?php for ($i = 5; $i <= 16; $i++): ?>
                        <div class="col-6 col-sm-4 col-md-2">
                            <img src="./website_assets/placements-image/<?php echo $i; ?>.jpg"
                                class="placement-img shadow previewable" alt="Logo <?php echo $i; ?>" />
                        </div>
                    <?php endfor; ?>
                </div>

                <h2 class="text-center fw-bold mt-5 mb-3">
                    🤝 GMIU Placement Associates
                </h2>

                <!-- Swiper Container with max width -->
                <div class="container" style="max-width: 1140px;">
                    <div class="swiper mySwiper py-4">
                        <div class="swiper-wrapper text-center">

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/1.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/2.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/3.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/4.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/6.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/7.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/8.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/9.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/11.png"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                            <div class="swiper-slide d-flex justify-content-center align-items-center shadow">
                                <img src="https://gmiu.edu.in/gmiu/website_assets/images/associates/12.jpg"
                                    alt="GMIU Recruiter" loading="lazy"
                                    style="height: 80px; width: auto; max-width: 100%;" />
                            </div>

                        </div>
                    </div>
                </div>


                <?php
                $stats = [
                    ['id' => 'TotalCompanyVisited', 'count' => 583, 'label' => 'Total Company Visited', 'suffix' => '+'],
                    ['id' => 'HighestPackage', 'count' => 42, 'label' => 'Highest Package', 'suffix' => '+LAC'],
                    ['id' => 'TotalPlacementOffers', 'count' => 972, 'label' => 'Total Placement Offers', 'suffix' => '+'],
                    ['id' => 'TotalStudentPlaced', 'count' => 98, 'label' => 'Total Student Placed', 'suffix' => '%']
                ];
                ?>

                <!-- ONE single row -->
                <!-- Styled Stats Row -->
                <div class="row bg-danger text-white text-center mt-5 py-4">
                    <?php foreach ($stats as $index => $stat): ?>
                        <div class="col-6 col-md-3 stats-box">
                            <h2 class="stats-number">
                                <span id="<?php echo $stat['id']; ?>">0</span><span
                                    class="fs-2"><?php echo $stat['suffix']; ?></span>
                            </h2>
                            <p class="stats-label mb-0"><?php echo $stat['label']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="container my-5">
                    <h2 class="text-center fw-bold mb-4">🎥 Media Highlights</h2>
                    <div class="row g-4">

                        <?php
                        $youtubeLinks = [
                            'https://youtu.be/wef9BG7_Wl0',
                            'https://youtu.be/P-I7cdu8LUA',
                            'https://youtube.com/shorts/xSyS9fSV_Co',
                            'https://youtube.com/shorts/GH-dnQEIgLo',
                            'https://youtube.com/shorts/nA8UqqfM2Zs'
                        ];

                        function extractYoutubeID($url)
                        {
                            // Handle Shorts or regular YouTube video
                            if (strpos($url, 'shorts/') !== false) {
                                $parts = explode('/', $url);
                                return end($parts); // Get ID from /shorts/ID
                            }

                            parse_str(parse_url($url, PHP_URL_QUERY), $query);
                            return $query['v'] ?? basename(parse_url($url, PHP_URL_PATH));
                        }

                        function getYoutubeThumbnail($id)
                        {
                            return "https://img.youtube.com/vi/$id/sddefault.jpg"; // better reliability for Shorts
                        }

                        foreach ($youtubeLinks as $yt):
                            $id = extractYoutubeID($yt);
                            $thumb = getYoutubeThumbnail($id);
                            ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="<?= $yt ?>" target="_blank" class="text-decoration-none text-dark">
                                    <div class="card shadow-sm border-0 h-100">
                                        <img src="<?= $thumb ?>" class="card-img-top" alt="YouTube Thumbnail">
                                        <div class="card-body p-2">
                                            <p class="small text-center mb-0">Watch on YouTube</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>

                        <!-- Instagram Reel (manual thumbnail or Instagram-style card) -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="https://www.instagram.com/reel/DLrXI7ETYFj/" target="_blank"
                                class="text-decoration-none text-dark">
                                <div class="card shadow-sm border-0 h-100">
                                    <img src="./website_assets/placements-image/instaThumb.jpg" class="card-img-top"
                                        alt="Instagram Reel Thumbnail">
                                    <div class="card-body text-center p-2">
                                        <p class="small mb-0 fw-bold">View Instagram Reel</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="container my-5">
                    <h2 class="text-center fw-bold mb-4">📰 GMIU Press Notes</h2>

                    <!-- Swiper -->
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <div class="swiper-slide shadow rounded">
                                    <img src="./website_assets/placements-image/Press-note/Pressnote <?php echo $i; ?>.jpg"
                                        class="img-fluid previewable" alt="Press Note <?php echo $i; ?>">
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                </div>

                <div class="container my-5">
                    <h2 class="text-center fw-bold mb-4">🎓 Explore Our Placed Programs</h2>
                    <div class="row g-4">

                        <?php
                        $colors = ['#fdfdfd', '#f8f9fa'];
                        $index = 0;

                        $query = "SELECT program.id AS program_id, program.name AS program_name, program.intake AS program_intake, program.duration AS program_duration,
                    program.program_slug AS program_slug, LEVEL.name AS level_name, faculty.name AS faculty_name, faculty.faculty_slug 
                    FROM tbl_program AS program 
                    JOIN tbl_level AS LEVEL ON program.level_id = LEVEL.id 
                    JOIN tbl_faculty AS faculty ON program.faculty_id = faculty.id 
                    WHERE program.faculty_id IN (
                        SELECT faculty.id FROM tbl_faculty AS faculty 
                        WHERE is_active = 1 AND is_delete = 0 AND EXISTS (
                            SELECT 1 FROM tbl_program program 
                            INNER JOIN tbl_placement p ON p.program_id = program.id 
                            WHERE program.faculty_id = faculty.id AND p.is_active = 1 AND p.is_delete = 0
                        )
                    ) 
                    AND program.level_id IN (
                        SELECT LEVEL.id FROM tbl_level AS LEVEL 
                        WHERE EXISTS (
                            SELECT 1 FROM tbl_program program 
                            INNER JOIN tbl_placement p ON p.program_id = program.id 
                            WHERE program.level_id = LEVEL.id 
                            AND program.faculty_id IN (
                                SELECT faculty.id FROM tbl_faculty AS faculty 
                                WHERE is_active = 1 AND is_delete = 0 AND EXISTS (
                                    SELECT 1 FROM tbl_program program 
                                    INNER JOIN tbl_placement p ON p.program_id = program.id 
                                    WHERE program.faculty_id = faculty.id AND p.is_active = 1 AND p.is_delete = 0
                                )
                            ) 
                            AND program.is_active = 1 AND program.is_delete = 0 
                            AND p.is_active = 1 AND p.is_delete = 0
                        )
                    ) 
                    AND program.is_active = 1 
                    AND program.is_delete = 0 
                    AND EXISTS (
                        SELECT 1 FROM tbl_placement p 
                        WHERE p.is_active = 1 AND p.is_delete = 0 
                        AND p.program_id = program.id 
                        AND p.faculty_id = program.faculty_id
                    ) 
                    ORDER BY 
                     FIELD(program.id, 119, 90 , 6 , 4) DESC,
                     program.faculty_id ASC";

                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_assoc($result)):
                            $link = $base_url_website_faculty . $row['faculty_slug'] . '/' . $row['program_slug'] . '/placement';
                            $bgColor = $colors[$index % 2];
                            ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <a href="<?= $link ?>" class="text-decoration-none">
                                    <div class="p-4 shadow h-100 program-card" style="background-color: <?= $bgColor ?>;">
                                        <div class="program-name"><?= $row['program_name'] ?></div>
                                        <div class="program-subtext"><?= $row['level_name'] ?> –
                                            <?= $row['faculty_name'] ?>
                                        </div>
                                        <div class="text-center">
                                            <span class="program-badge">Placement</span>
                                            <p class="text-danger fs-6 mt-3">Click to Get More Info...</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                            $index++;
                        endwhile;
                        ?>

                        <?php if ($index === 0): ?>
                            <div class="col-12 text-center">
                                <p class="text-muted">No programs found with placement data.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">

                <!-- Brand or Logo -->
                <div class="col-12 col-md-3 mb-4">
                    <h5 class="fs-4 fw-bold text-danger">Gyanmanjari Innovative University</h5>
                    <p class="small pe-md-3">
                        The Gyanmanjari Innovative University has been found with sole purpose to
                        create world class engineers for converting global challenges into opportunities through
                        “Value Embedded Quality Technical Education”
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-6 col-sm-6 col-md-3 mb-4">
                    <h6 class="fs-5 text-uppercase fw-semibold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="https://gmiu.edu.in" class="text-white text-decoration-none small">➜ GMIU
                                Website</a></li>
                        <li><a href="https://gmiu.edu.in/gmiu/website/common/website_contact_us.php"
                                class="text-white text-decoration-none small">➜ Contact</a></li>
                        <li><a href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php"
                                class="text-white text-decoration-none small">➜ 360 Virtual Tour</a></li>
                        <li><a href="tel:+91 90999 51160" class="text-white text-decoration-none small">➜ +91 90999
                                51160</a></li>
                        <li><a href="mailto:info@gmiu.edu.in" class="text-white text-decoration-none small">➜
                                info@gmiu.edu.in</a></li>
                    </ul>
                </div>

                <!-- Admissions -->
                <div class="col-6 col-sm-6 col-md-3 mb-4">
                    <h6 class="fs-5 text-uppercase fw-semibold">Admissions</h6>
                    <ul class="list-unstyled">
                        <li><a href="https://gmiu.edu.in/gmiu/admission/"
                                class="text-white text-decoration-none small">➜ Apply Online/Now</a></li>
                        <li><a href="https://gmiu.edu.in/gmiu/website/admission/admission_brochure.php"
                                class="text-white text-decoration-none small">➜ E-Brochure & Scope Document</a>
                        </li>
                        <li><a href="https://gmiu.edu.in/gmiu/website/admission/importantlink.php"
                                class="text-white text-decoration-none small">➜ Important Links</a></li>
                        <li><a href="https://gmiu.edu.in/gmiu/website/admission/scholarships.php"
                                class="text-white text-decoration-none small">➜ Scholarships</a></li>
                    </ul>
                </div>

                <!-- Other -->
                <div class="col-12 col-md-3 mb-4">
                    <h6 class="fs-5 text-uppercase fw-semibold">Other</h6>
                    <ul class="list-unstyled">
                        <li><a href="https://admission.gmiu.edu.in/premium/index.php"
                                class="text-white text-decoration-none small">➜ Premium</a></li>
                        <li><a href="https://gmiu.edu.in/gmiu/website/admission/phd_notification.php"
                                class="text-white text-decoration-none small">➜ Ph.D Admission</a></li>
                        <li><a href="https://admission.gmiu.edu.in/admission/girlscollege.php"
                                class="text-white text-decoration-none small">➜ Girl's College</a></li>
                        <li><a href="https://gmiu.edu.in/gmiu/website/admission/uni_transfer.php"
                                class="text-white text-decoration-none small">➜ University Transfer</a></li>
                    </ul>
                </div>

            </div>

            <hr class="border-secondary" />

            <!-- Footer Bottom -->
            <div class="row text-center text-md-start">
                <div class="col-12 col-md-6 mb-2 mb-md-0 small">
                    Design & Developed by <a href="https://gmiu.edu.in/gmiu/website/common/it_cell_team.php"
                        class="text-decoration-none text-danger fw-bold">IT-CELL</a>
                </div>
                <div class="col-12 col-md-6 text-md-end small">
                    &copy; <?= date("Y") ?> GMIU. All rights reserved.
                </div>
            </div>
        </div>
    </footer>



    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down" style='max-width: fit-content;'>
            <div class="modal-content border-0 bg-transparent p-0 m-0">
                <div class="modal-body d-flex justify-content-center align-items-center p-0 m-0 position-relative">

                    <!-- Close Button on top of image -->
                    <button type="button" class="btn-close position-absolute"
                        style="top: 1rem; right: 1rem; z-index: 10; width: 2.5rem; height: 2.5rem; background-color: white; border-radius: 50%; opacity: 1;"
                        data-bs-dismiss="modal" aria-label="Close">
                    </button>

                    <!-- Bigger image style -->
                    <img id="modalImage" src="" class="img-fluid rounded shadow"
                        style="max-height: 90vh; max-width: 95vw; object-fit: contain;" alt="Preview" />

                </div>
            </div>
        </div>
    </div>
    
    <style>
   /* Modal Header */
    .modal-header {
      background: #ba2a21;
      color: white;
      padding: 18px 25px;
      border-bottom: none;
    }

    .modal-title {
      font-size: 20px;
      font-weight: 600;
    }

    .btn-close {
      filter: invert(1);
    }

    /* Card Layout */
    .program-card {
      border: none;
      border-radius: 18px;
      padding: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
      background: white;
      position: relative;
      overflow: hidden;
      box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.08);
    }

    /* Top Accent Gradient */
    .program-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      height: 6px;
      width: 100%;
      background: linear-gradient(to right, #ba2a21, #ff6b5c);
    }

    /* Hover Effect */
    .program-card:hover {
      transform: translateY(-8px);
      box-shadow: 0px 12px 28px rgba(186, 42, 33, 0.25);
    }

    /* Program Title */
    .program-name {
      font-size: 28px;
      font-weight: 800;
      color: #ba2a21;
    }

    /* Badge */
    .program-badge {
      display: inline-block;
      padding: 5px 12px;
      border-radius: 30px;
      background: rgba(186, 42, 33, 0.12);
      color: #ba2a21;
      font-size: 13px;
      font-weight: 600;
      margin-top: 5px;
    }

    /* Institute Text */
    .program-inst {
      font-size: 14px;
      color: #555;
      margin-top: 12px;
      min-height: 45px;
    }

    /* Button Style */
    .program-btn {
      margin-top: 15px;
      display: inline-block;
      padding: 8px 16px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      color: white;
      background: #ba2a21;
      text-decoration: none;
      transition: 0.3s;
    }

    .program-btn:hover {
      background: #911f19;
    }
    </style>
<!-- Modal -->
<div class="modal fade" id="programModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; overflow:hidden;">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title">Select Your Program</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4">

        <div class="row g-4">

          <!-- MCA Card -->
          <div class="col-md-6">
            <div class="program-card"
                 onclick="window.location.href='https://gmiu.edu.in/gmiu/website/faculty/faculty-of-computer-application-bca-amp-mca-/post-graduation-mca/placement'">
              <div class="program-name">MCA</div>
              <span class="program-badge">Post Graduation</span>

              <div class="program-inst">
                Institute of Computer Application <br>
                (BCA & MCA)
              </div>

              <a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-computer-application-bca-amp-mca-/post-graduation-mca/placement" class="program-btn">
                Explore MCA →
              </a>
            </div>
          </div>

          <!-- MBA Card -->
          <div class="col-md-6">
            <div class="program-card"
                 onclick="window.location.href='https://gmiu.edu.in/gmiu/website_assets/placement-broucher.pdf'">
              <div class="program-name">MBA</div>
              <span class="program-badge">Post Graduation</span>

              <div class="program-inst">
                Institute of Management
              </div>

              <a href="https://gmiu.edu.in/gmiu/website_assets/placement-broucher.pdf" class="program-btn">
                Explore MBA →
              </a>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>
</div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CountUp.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.6.2/dist/countUp.umd.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Auto Open Modal on Page Load -->
<script>
  window.onload = function () {
    let modal = new bootstrap.Modal(document.getElementById("programModal"));
    modal.show();
  };
</script>

    <!-- CountUp Init Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const options = { duration: 2 };

            const counters = [
                { id: "TotalCompanyVisited", endVal: 583 },
                { id: "HighestPackage", endVal: 42 },
                { id: "TotalPlacementOffers", endVal: 972 },
                { id: "TotalStudentPlaced", endVal: 98 },
            ];

            // Track whether each counter is currently running
            const activeStates = {};

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        counters.forEach(counter => {
                            // Avoid stacking multiple animations
                            if (!activeStates[counter.id]) {
                                const countUp = new window.countUp.CountUp(counter.id, counter.endVal, options);
                                if (!countUp.error) {
                                    countUp.start(() => {
                                        // After animation ends, allow re-trigger next time
                                        activeStates[counter.id] = false;
                                    });
                                    activeStates[counter.id] = true;
                                }
                            }
                        });
                    }
                });
            }, {
                threshold: 0.6 // Trigger when 60% visible
            });

            observer.observe(document.querySelector(".row.bg-danger"));
        });
    </script>

    <!-- Swiper  -->
    <script>
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 2500, // time between slides in ms
                disableOnInteraction: false, // keeps autoplay after user swipes
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 4,
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = new bootstrap.Modal(document.getElementById("imageModal"));
            const modalImage = document.getElementById("modalImage");

            document.body.addEventListener("click", function (e) {
                const target = e.target.closest("img[data-full], img.previewable");

                if (target) {
                    const fullSrc = target.getAttribute("data-full") || target.src;
                    modalImage.src = fullSrc;
                    modal.show();
                }
            });
        });
    </script>

</body>

</html>