<?php include '../../common/importwebsitefile.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $mobile = $_POST['mobile'];

    $form_type = 15;

    $ip = $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $referrer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

    $utm_source = $_POST['utm_source'] ?? '';
    $utm_campaign = $_POST['utm_campaign'] ?? '';

    $video_completed = 0;

    $stmt = $con->prepare("INSERT INTO tbl_promotional_form_data
        (form_type, full_name, mobile, video_completed, ip_address, browser, referrer, utm_source, utm_campaign)
        VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param(
        "ississsss",
        $form_type,
        $name,
        $mobile,
        $video_completed,
        $ip,
        $browser,
        $referrer,
        $utm_source,
        $utm_campaign
    );

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}
?>
<?php
$faculty_ids = [1, 3, 2]; // B.Tech, B.Sc, B.Pharm
$level_id = 1;

$faculty_programs = [];

foreach ($faculty_ids as $faculty_id) {

    $query = "SELECT 
                program.id AS program_id,
                program.name AS program_name,
                program.duration AS program_duration,
                program.program_slug,
                faculty.faculty_slug,
                faculty.name AS faculty_name
            FROM tbl_program AS program
            JOIN tbl_faculty AS faculty ON faculty.id = program.faculty_id
            WHERE 
                program.faculty_id = $faculty_id
                AND program.level_id = $level_id
                AND program.is_active = 1
                AND program.is_delete = 0
            ORDER BY 
                CASE 
                    WHEN program.name LIKE '%premium%' THEN 1 
                    ELSE 2 
                END,
                CASE 
                    WHEN program.short_no = 0 THEN 2  
                    ELSE 1  
                END,
                program.short_no ASC,  
                program.name ASC";

    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $faculty_name = $row['faculty_name'];
        if (!isset($faculty_programs[$faculty_name])) {
            $faculty_programs[$faculty_name] = [];
        }
        $faculty_programs[$faculty_name][] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GUJCET Model Paper set — Free PDF | GMIU</title>
    <meta name="description"
        content="Download the free GUJCET 2025 Information Booklet — Syllabus, Exam Pattern, Eligibility & College Guide.">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --red: #b91c1c;
            --red2: #dc2626;
            --bg: #f8f9fb;
            --white: #ffffff;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --soft: #fef2f2;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── HEADER ─────────────────────── */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .header .logos {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header img {
            height: 46px;
        }

        .wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #25d366;
            color: #fff;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .wa-btn:hover {
            opacity: .9;
        }

        /* ── MAIN LAYOUT ────────────────── */
        .page-wrap {
            max-width: 960px;
            margin: 0 auto;
            padding: 40px 20px 60px;
        }

        /* ── TOP HERO TEXT ──────────────── */
        .hero-text {
            text-align: center;
            margin-bottom: 36px;
        }

        .hero-text .kicker {
            display: inline-block;
            background: var(--soft);
            border: 1px solid #fecaca;
            color: var(--red);
            padding: 5px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 14px;
        }

        .hero-text h1 {
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .hero-text h1 span {
            color: var(--red2);
        }

        .hero-text p {
            font-size: 15px;
            color: var(--muted);
            max-width: 540px;
            margin: 0 auto;
            line-height: 1.65;
        }

        /* ── STATS ──────────────────────── */
        .stats-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 36px;
        }

        .stat-chip {
            display: flex;
            align-items: center;
            gap: 7px;
            background: var(--white);
            border: 1px solid var(--border);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        .stat-chip i {
            color: var(--red2);
        }

        /* ── CARD GRID ──────────────────── */
        /*.card-grid {*/
        /*    display: grid;*/
        /*    grid-template-columns: 1fr 1fr;*/
        /*    gap: 28px;*/
        /*    align-items: start;*/
        /*}*/

        .card-grid {
            display: flex;
            justify-content: center;
        }

        /* ── PDF PREVIEW CARD ───────────── */
        .pdf-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .07);
            position: sticky;
            top: 90px;
        }

        .pdf-card-top {
            background: linear-gradient(135deg, #7f1d1d, var(--red2));
            padding: 22px 22px 18px;
            color: white;
            text-align: center;
        }

        .pdf-card-top .big-icon {
            font-size: 42px;
            margin-bottom: 8px;
        }

        .pdf-card-top h3 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .pdf-card-top p {
            font-size: 12px;
            opacity: .8;
        }

        .inside-list {
            padding: 18px 20px;
        }

        .inside-list h4 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--muted);
            margin-bottom: 12px;
        }

        .inside-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 6px;
            background: var(--bg);
            border: 1px solid var(--border);
        }

        .inside-item i {
            color: var(--red2);
            width: 16px;
            text-align: center;
        }

        .locked-notice {
            margin: 0 20px 20px;
            background: var(--soft);
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 600;
            color: var(--red);
            text-align: center;
        }

        /* ── FORM CARD ──────────────────── */
        .form-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .07);
        }

        .form-card-top {
            background: var(--soft);
            border-bottom: 1px solid #fecaca;
            padding: 16px 22px;
        }

        .form-card-top h2 {
            font-size: 17px;
            font-weight: 800;
            color: var(--red);
            margin-bottom: 2px;
        }

        .form-card-top p {
            font-size: 12px;
            color: var(--muted);
        }

        .form-body {
            padding: 24px 22px;
        }

        .inp-group {
            margin-bottom: 16px;
        }

        .inp-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .inp-group input {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: var(--bg);
            transition: border-color .2s, box-shadow .2s;
        }

        .inp-group input::placeholder {
            color: #9ca3af;
        }

        .inp-group input:focus {
            outline: none;
            border-color: var(--red2);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, .12);
            background: #fff;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #7f1d1d, var(--red2));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: transform .15s, box-shadow .2s;
            box-shadow: 0 6px 18px rgba(185, 28, 28, .3);
            font-family: 'Inter', sans-serif;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(185, 28, 28, .4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .trust-note {
            text-align: center;
            font-size: 11px;
            color: var(--muted);
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .trust-note i {
            color: #16a34a;
        }

        /* ── SUCCESS ────────────────────── */
        .success-box {
            display: none;
            text-align: center;
            padding: 32px 20px;
        }

        .success-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
            animation: popIn .45s cubic-bezier(.175, .885, .32, 1.275);
        }

        @keyframes popIn {
            from {
                transform: scale(0);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-box h3 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .success-box p {
            font-size: 13px;
            color: var(--muted);
        }

        /* ── ADMISSION BOX ──────────────── */
        .admission-box {
            background: linear-gradient(135deg, #7f1d1d, #1e3a8a);
            border-radius: 16px;
            padding: 20px 22px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .admission-box h4 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .admission-box p {
            font-size: 13px;
            opacity: .85;
        }

        .apply-btn {
            background: white;
            color: #7f1d1d;
            padding: 10px 22px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            white-space: nowrap;
            transition: transform .18s;
        }

        .apply-btn:hover {
            transform: translateY(-2px);
            color: #7f1d1d;
        }

        /* ── WA FLOAT ───────────────────── */
        .wa-float {
            position: fixed;
            bottom: 22px;
            right: 22px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 6px 20px rgba(37, 211, 102, .45);
            text-decoration: none;
            z-index: 999;
        }

        .wa-float:hover {
            transform: scale(1.08);
        }

        /* ── RESPONSIVE ─────────────────── */
        @media (max-width: 700px) {
            .card-grid {
                grid-template-columns: 1fr;
            }

            .pdf-card {
                position: static;
            }
        }

        .header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 10px 20px;

            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;

            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        /* logos */
        .logo-left img,
        .logo-right img {
            height: 46px;
        }

        /* center slogan */
        .header-center-text {
            text-align: center;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.4;
        }

        /* highlight second line */
        .header-center-text br+span,
        .header-center-text {
            color: #7f1d1d;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 600px) {
            .header {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 6px;
            }

            .logo-left,
            .logo-right {
                justify-self: center;
            }

            .header-center-text {
                font-size: 13px;
            }
        }

        /* ── PROGRAMS CONTAINER ─────────────────── */
        .programs-container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .programs-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .programs-header h2 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
        }

        .programs-header p {
            font-size: 14px;
            color: var(--muted);
        }

        .faculty-group {
            margin-bottom: 30px;
            background: #ffffff;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border);
        }

        .faculty-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .faculty-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1e3a8a;
            white-space: normal;
            word-break: break-word;
            letter-spacing: -0.01em;
            line-height: 1.3;
        }

        .faculty-divider {
            flex-grow: 1;
            height: 1px;
            background: linear-gradient(to right, #e2e8f0, transparent);
        }

        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
        }

        .program-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px 20px;
            text-decoration: none;
            color: var(--text);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
        }

        .program-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--red2);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .program-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            border-color: #fca5a5;
            background: #ffffff;
        }

        .program-card:hover::before {
            opacity: 1;
        }

        .program-icon-wrapper {
            background: #fef2f2;
            color: var(--red2);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .program-card:hover .program-icon-wrapper {
            background: var(--red2);
            color: white;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
        }

        .program-info {
            flex-grow: 1;
        }

        .program-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .program-duration {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .program-arrow {
            color: #cbd5e1;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .program-card:hover .program-arrow {
            color: var(--red2);
            transform: translateX(4px);
        }

        @media (max-width: 600px) {
            .faculty-group {
                padding: 16px;
            }

            .program-grid {
                grid-template-columns: 1fr;
            }
            
            .faculty-header {
                gap: 12px;
            }
            
            .faculty-header h3 {
                font-size: 16px;
            }
            
            .program-card {
                padding: 14px 16px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header">

        <!-- LEFT LOGO -->
        <div class="logo-left">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo">
        </div>

        <!-- CENTER TEXT -->
        <div class="header-center-text">
            रट्टा अभ्यास छोड़ो,<br>
            कौशल्यलक्षी शिक्षा से जुड़ो ।
        </div>

        <!-- RIGHT LOGO -->
        <div class="logo-right">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" alt="PLM Logo">
        </div>

    </header>

    <div class="page-wrap">

        <!-- HERO TEXT -->
        <div class="hero-text">
            <div class="kicker"><i class="fas fa-file-pdf"></i>&nbsp; Free Download</div>
            <h1>GUJCET <span>Model Paper set</span></h1>
            <p>Get GUJCET — Model Paper Set. Free for all students.</p>
        </div>

        <!-- STATS ROW -->
        <div class="stats-row">
            <div class="stat-chip"><i class="fas fa-users"></i> 5,000+ Downloads</div>
            <div class="stat-chip"><i class="fas fa-star"></i> 4.9 / 5 Rating</div>
            <div class="stat-chip"><i class="fas fa-shield-halved"></i> 100% Free</div>
            <!--<div class="stat-chip"><i class="fas fa-calendar-check"></i> 2025 Updated</div>-->
        </div>

        <!-- CARD GRID -->
        <div class="card-grid">

            <!-- RIGHT: Form -->
            <div id="get-pdf">
                <div class="form-card">
                    <div class="form-card-top">
                        <h2>🎓 Get Your Free PDF</h2>
                        <p>Enter your details — the PDF opens instantly.</p>
                    </div>

                    <div class="form-body">
                        <div id="formSection">
                            <div class="inp-group">
                                <label for="name"><i class="fas fa-user"></i>&nbsp; Full Name</label>
                                <input type="text" id="name" placeholder="e.g. Riya Patel" autocomplete="name">
                            </div>
                            <div class="inp-group">
                                <label for="mobile"><i class="fas fa-phone"></i>&nbsp; Mobile Number</label>
                                <input type="tel" id="mobile" placeholder="10-digit mobile number" maxlength="10"
                                    autocomplete="tel">
                            </div>

                            <button class="submit-btn" onclick="submitForm()" id="mainBtn">
                                <i class="fas fa-file-arrow-down"></i> Unlock & Download PDF
                            </button>

                            <div class="trust-note">
                                <i class="fas fa-lock"></i> Secure &amp; Private &nbsp;·&nbsp;
                                <i class="fas fa-check-circle"></i> No Spam &nbsp;·&nbsp;
                                <i class="fas fa-bolt"></i> Instant Access
                            </div>
                        </div>

                        <!-- Success -->
                        <div id="successBox" class="success-box">
                            <div class="success-icon">✅</div>
                            <h3>Download Started! 🎉</h3>
                            <p>Your GUJCET PDF is opening in a new tab.<br>All the best for your exam!</p>
                            <button class="submit-btn" style="margin-top:18px;"
                                onclick="window.open('https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/GUJCET.pdf','_blank')">
                                <i class="fas fa-file-pdf"></i> Open PDF Again
                            </button>
                        </div>
                    </div>
                </div>
                <div class="programs-container">
                    <div class="programs-header">
                        <h2>🎓 Choose Your Program</h2>
                        <p>Explore our wide range of disciplines</p>
                    </div>

                    <?php foreach ($faculty_programs as $faculty_name => $programs): ?>
                        <div class="faculty-group">
                            <div class="faculty-header">
                                <h3><?php echo $faculty_name; ?></h3>
                                <div class="faculty-divider"></div>
                            </div>

                            <div class="program-grid">
                                <?php foreach ($programs as $p): ?>
                                    <a href="<?php echo $base_url_website_faculty . $p['faculty_slug'] . '/' . $p['program_slug']; ?>"
                                        class="program-card" target="_blank">
                                        <div class="program-icon-wrapper">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div class="program-info">
                                            <div class="program-name">
                                                <?php echo $p['program_name']; ?>
                                            </div>
                                            <div class="program-duration">
                                                <i class="far fa-clock"></i>
                                                <?php echo htmlspecialchars($p['program_duration']); ?>years
                                            </div>
                                        </div>
                                        <div class="program-arrow">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Admission CTA -->
                <div class="admission-box">
                    <div>
                        <h4><i class="fas fa-graduation-cap"></i>&nbsp; Admissions 2026-27 Open!</h4>
                        <p>Engineering · Design · Science at GMIU</p>
                    </div>
                    <a href="https://gmiu.edu.in/gmiu/admission" target="_blank" class="apply-btn">
                        Apply Now →
                    </a>
                </div>
            </div>

        </div><!-- /card-grid -->
    </div><!-- /page-wrap -->

    <!-- WhatsApp Float -->
    <a href="https://api.whatsapp.com/send?phone=917574949494&text=Hello%20I%20want%20GUJCET%20PDF%202025"
        class="wa-float" target="_blank" aria-label="WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script>
        function submitForm() {
            const name = document.getElementById('name').value.trim();
            const mobile = document.getElementById('mobile').value.trim();

            if (!name) { shake('name'); return; }
            if (!mobile || !/^\d{10}$/.test(mobile)) {
                shake('mobile');
                alert('Please enter a valid 10-digit mobile number.');
                return;
            }

            const btn = document.getElementById('mainBtn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;

            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `name=${encodeURIComponent(name)}&mobile=${encodeURIComponent(mobile)}&utm_source=website&utm_campaign=gujcet_pdf`
            })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('formSection').style.display = 'none';
                        document.getElementById('successBox').style.display = 'block';
                        setTimeout(() => {
                            window.open('https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/GUJCET.pdf', '_blank');
                        }, 600);
                    } else {
                        btn.innerHTML = '<i class="fas fa-file-arrow-down"></i> Unlock & Download PDF';
                        btn.disabled = false;
                        alert('Something went wrong. Please try again.');
                    }
                })
                .catch(() => {
                    btn.innerHTML = '<i class="fas fa-file-arrow-down"></i> Unlock & Download PDF';
                    btn.disabled = false;
                    alert('Network error. Please try again.');
                });
        }

        function shake(id) {
            const el = document.getElementById(id);
            el.style.animation = 'none';
            el.offsetHeight;
            el.style.animation = 'inputShake 0.35s ease';
            el.focus();
        }
    </script>

    <style>
        @keyframes inputShake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-6px);
            }

            40% {
                transform: translateX(6px);
            }

            60% {
                transform: translateX(-4px);
            }

            80% {
                transform: translateX(4px);
            }
        }
    </style>

</body>

</html>