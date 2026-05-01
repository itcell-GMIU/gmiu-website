<?php
include('include/config.php');

$formData = null;
$travelRows = [];
$form_id = 0;
$error_message = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $form_id = (int) $_GET['id'];

    $sql = "SELECT t.*, f.name as faculty_name, p.name as program_name 
            FROM tbl_tada_form_data t
            LEFT JOIN tbl_faculty f ON t.faculty_id = f.id
            LEFT JOIN tbl_program p ON t.program_id = p.id
            WHERE t.id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $formData = $result->fetch_assoc();

        $travel_sql = "SELECT * FROM tbl_tada_form_travelling_allowance WHERE tada_form_id = ?";
        $travel_stmt = $con->prepare($travel_sql);
        $travel_stmt->bind_param("i", $form_id);
        $travel_stmt->execute();
        $travel_result = $travel_stmt->get_result();
        while ($row = $travel_result->fetch_assoc()) {
            $travelRows[] = $row;
        }
    } else {
        $error_message = "Error: TADA Form ID $form_id not found.";
    }
} else {
    $error_message = "Error: Invalid or missing form ID in the URL.";
}

function pcv($val, $is_amount = false) {
    if ($is_amount) return number_format((float)($val ?? 0), 2);
    if (empty($val) || $val === '0000-00-00' || $val === '0' || $val === 0) return '—';
    return htmlspecialchars($val);
}

function numberToWords($number) {
    if ($number == 0) return "Zero";
    $hyphen = '-'; $conjunction = ' and '; $separator = ', '; $negative = 'negative '; $decimal = ' point ';
    $dictionary = array(0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety', 100 => 'hundred', 1000 => 'thousand', 100000 => 'lakh', 10000000 => 'crore');
    if (!is_numeric($number)) return false;
    if ($number < 0) return $negative . numberToWords(abs($number));
    $string = $fraction = null;
    if (strpos($number, '.') !== false) { list($number, $fraction) = explode('.', $number); }
    switch (true) {
        case $number < 21: $string = $dictionary[$number]; break;
        case $number < 100: $tens = ((int)($number / 10)) * 10; $units = $number % 10; $string = $dictionary[$tens]; if ($units) { $string .= $hyphen . $dictionary[$units]; } break;
        case $number < 1000: $hundreds = $number / 100; $remainder = $number % 100; $string = $dictionary[$hundreds] . ' ' . $dictionary[100]; if ($remainder) { $string .= $conjunction . numberToWords($remainder); } break;
        case $number < 100000: $thousands = (int)($number / 1000); $remainder = $number % 1000; $string = numberToWords($thousands) . ' ' . $dictionary[1000]; if ($remainder) { $string .= $separator . numberToWords($remainder); } break;
        case $number < 10000000: $lakhs = (int)($number / 100000); $remainder = $number % 100000; $string = numberToWords($lakhs) . ' ' . $dictionary[100000]; if ($remainder) { $string .= $separator . numberToWords($remainder); } break;
        default: $crores = (int)($number / 10000000); $remainder = $number % 10000000; $string = numberToWords($crores) . ' ' . $dictionary[10000000]; if ($remainder) { $string .= $separator . numberToWords($remainder); } break;
    }
    return strtoupper($string);
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('include/head.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* ===== BASE OVERRIDES ===== */
        .details-page,
        .details-page *:not(i):not([class*="fa"]):not([class*="icon"]) {
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        /* ===== HERO BANNER ===== */
        .form-hero {
            background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 28px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(13,110,253,0.25);
            position: relative;
            overflow: hidden;
        }
        .form-hero::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .form-hero::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -20px;
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .form-hero .form-id-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 50px;
            padding: 5px 16px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
            backdrop-filter: blur(4px);
            color: #fff !important;
        }
        .form-hero h2 {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0 0 4px 0;
            letter-spacing: -0.5px;
            color: #fff !important;
            font-family: Georgia, 'Times New Roman', serif;
        }
        .form-hero .hero-subtitle {
            font-size: 0.95rem;
            opacity: 1;
            margin: 0;
            color: #fff !important;
        }
        .form-hero .hero-actions { position: relative; z-index: 1; }
        .form-hero .btn-hero-back {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.35);
            color: #fff;
            backdrop-filter: blur(4px);
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
        }
        .form-hero .btn-hero-back:hover { background: rgba(255,255,255,0.28); color: #fff; }
        .form-hero .btn-hero-edit {
            background: #ffc107; color: #212529;
            border: none; border-radius: 8px;
            padding: 8px 20px; font-weight: 700;
            text-decoration: none;
            transition: all 0.2s; box-shadow: 0 4px 12px rgba(255,193,7,0.4);
        }
        .form-hero .btn-hero-edit:hover { background: #ffca2c; transform: translateY(-1px); }
        .form-hero .btn-hero-print {
            background: #fff; color: #0d6efd;
            border: none; border-radius: 8px;
            padding: 8px 20px; font-weight: 700;
            text-decoration: none;
            transition: all 0.2s; box-shadow: 0 4px 12px rgba(255,255,255,0.25);
        }
        .form-hero .btn-hero-print:hover { background: #e7effd; transform: translateY(-1px); }

        /* ===== INFO CARDS ===== */
        .det-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            margin-bottom: 24px;
            overflow: hidden;
            transition: box-shadow 0.2s;
        }
        .det-card:hover { box-shadow: 0 4px 28px rgba(13,110,253,0.12); }
        .det-card-header {
            background: linear-gradient(90deg, #0d6efd 0%, #3d8bfd 100%);
            padding: 14px 22px;
            display: flex; align-items: center; gap: 12px;
        }
        .det-card-header .header-icon {
            width: 34px; height: 34px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.95rem; color: #fff;
            flex-shrink: 0;
        }
        .det-card-header h5 {
            margin: 0; font-weight: 700; color: #fff;
            font-size: 1rem; letter-spacing: 0.3px;
        }
        .det-card-body { padding: 24px; background: #fff; }

        /* ===== DATA FIELDS ===== */
        .field-row { margin-bottom: 20px; }
        .field-row:last-child { margin-bottom: 0; }
        .field-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
            display: block;
        }
        .field-value {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a2e;
            word-break: break-word;
        }
        .field-sub {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
            margin-top: 2px;
            display: block;
        }
        .field-icon { color: #0d6efd; margin-right: 6px; font-size: 0.85rem; }

        /* ===== DIVIDERS ===== */
        .section-divider {
            border: none;
            border-top: 2px solid #f1f3f5;
            margin: 20px 0;
        }
        .section-mini-title {
            font-size: 0.7rem;
            font-weight: 800;
            color: #0d6efd;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 14px;
            display: block;
            padding-bottom: 6px;
            border-bottom: 2px solid #e7f1ff;
        }

        /* ===== DUTY BADGES ===== */
        .duty-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #e7f1ff;
            color: #0d6efd;
            border: 1px solid #c6dbfe;
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            margin: 3px 4px 3px 0;
        }

        /* ===== JOURNEY TABLE ===== */
        .journey-table { width: 100%; border-collapse: collapse; }
        .journey-table thead tr {
            background: linear-gradient(90deg, #f8faff, #eef3ff);
        }
        .journey-table thead th {
            font-size: 0.72rem;
            font-weight: 800;
            color: #4a6fa5;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 12px 16px;
            border-bottom: 2px solid #d0e0ff;
        }
        .journey-table tbody tr { border-bottom: 1px solid #f0f4ff; transition: background 0.15s; }
        .journey-table tbody tr:hover { background: #f9fbff; }
        .journey-table tbody td { padding: 13px 16px; font-size: 0.9rem; color: #2d3748; vertical-align: middle; }
        .journey-table .date-cell { font-weight: 700; color: #0d6efd; white-space: nowrap; }
        .journey-table .city-from { font-weight: 700; color: #1a1a2e; }
        .journey-table .city-to { color: #495057; font-weight: 500; }
        .journey-table .mode-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: #e9ecef; color: #495057;
            border-radius: 6px; padding: 4px 10px;
            font-size: 0.8rem; font-weight: 600;
        }
        .journey-table .fare-cell { font-weight: 800; color: #198754; text-align: right; font-size: 1rem; }
        .journey-table .dist-cell { text-align: center; color: #6c757d; font-weight: 500; }
        .journey-table .total-row { background: linear-gradient(90deg, #e7f1ff, #eef3ff); }
        .journey-table .total-row td { font-weight: 700; color: #0d6efd; padding: 12px 16px; border-top: 2px solid #c6dbfe; }
        .journey-table .total-row .total-amt { font-size: 1.1rem; font-weight: 900; color: #0d6efd; text-align: right; }

        /* ===== SUMMARY STAT BOXES ===== */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        @media (max-width: 991px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 575px) { .stat-grid { grid-template-columns: 1fr; } }
        .stat-box {
            border-radius: 14px;
            padding: 20px;
            display: flex; align-items: center; gap: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            background: #fff;
            border: 1px solid #eef0f5;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-box:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
        .stat-box .stat-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .stat-box .stat-body { flex: 1; min-width: 0; }
        .stat-box .stat-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6c757d; margin-bottom: 4px; }
        .stat-box .stat-value { font-size: 1.35rem; font-weight: 800; line-height: 1; }
        .stat-box .stat-sub { font-size: 0.75rem; color: #6c757d; margin-top: 4px; }

        .stat-ta .stat-icon { background: #e7f1ff; color: #0d6efd; }
        .stat-ta .stat-value { color: #0d6efd; }
        .stat-da .stat-icon { background: #e8f9ef; color: #198754; }
        .stat-da .stat-value { color: #198754; }
        .stat-hon .stat-icon { background: #fff4e5; color: #fd7e14; }
        .stat-hon .stat-value { color: #fd7e14; }
        .stat-gross {
            background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
            border: none;
        }
        .stat-gross .stat-icon { background: rgba(255,255,255,0.2); color: #fff; }
        .stat-gross .stat-label { color: rgba(255,255,255,0.8); }
        .stat-gross .stat-value { color: #fff; font-size: 1.5rem; }
        .stat-gross .stat-sub { color: rgba(255,255,255,0.7); }

        /* ===== BANK & DECLARATION ===== */
        .bank-item { display: flex; align-items: flex-start; gap: 14px; padding: 12px 0; border-bottom: 1px solid #f1f3f5; }
        .bank-item:last-child { border-bottom: none; padding-bottom: 0; }
        .bank-item .bank-icon { width: 36px; height: 36px; border-radius: 8px; background: #e7f1ff; color: #0d6efd; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; }
        .bank-item .bank-info .bank-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #6c757d; margin-bottom: 2px; }
        .bank-item .bank-info .bank-value { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; }
        .bank-item .bank-info .bank-sub { font-size: 0.78rem; color: #6c757d; }

        .decl-item { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px dashed #e9ecef; }
        .decl-item:last-child { border-bottom: none; padding-bottom: 0; }
        .decl-icon { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; flex-shrink: 0; }
        .decl-icon.check { background: #d1f0de; color: #198754; }
        .decl-icon.car { background: #e9ecef; color: #495057; }
        .decl-icon.info { background: #fff4e5; color: #fd7e14; }
        .decl-text { font-size: 0.9rem; color: #495057; line-height: 1.5; padding-top: 4px; }
        .decl-text strong { color: #1a1a2e; }

        /* ===== PAN CHIP ===== */
        .pan-chip {
            display: inline-flex; align-items: center; gap: 8px;
            background: #1a1a2e;
            color: #fff;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 2px;
            font-family: monospace;
        }

        /* ===== ACCOUNT NUMBER ===== */
        .acc-chip {
            font-family: monospace;
            font-size: 1.05rem;
            font-weight: 800;
            color: #0d6efd;
            letter-spacing: 2px;
        }
    </style>
</head>
<body class="details-page">
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>
    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">

                <?php if ($formData): ?>
                <?php
                    // Pre-compute totals
                    $tTotal = 0;
                    foreach ($travelRows as $tr) { $tTotal += $tr['fare_paid']; }
                    $ta_amount = ($formData['total_ta_amount_a'] ?? 0) ?: $tTotal;
                    $da_amount = $formData['total_da_amount_b'] ?? 0;
                    $hon_amount = $formData['total_honorarium_amount_c'] ?? 0;
                    $acc_amount = $formData['total_accommodation_amount_d'] ?? 0;
                    $gross = $formData['gross_total_amount'] ?? 0;
                ?>

                <!-- HERO BANNER -->
                <div class="form-hero">
                    <div class="row align-items-center">
                        <div class="col-md-7 mb-3 mb-md-0" style="position:relative;z-index:1;">
                            <div class="form-id-badge">
                                <i class="fas fa-file-alt"></i>
                                <?= htmlspecialchars($formData['unique_id'] ?? ('FORM #' . $formData['id'])) ?>
                            </div>
                            <h2><?= htmlspecialchars($formData['title'] . ' ' . strtoupper($formData['full_name'])) ?></h2>
                            <p class="hero-subtitle">
                                <i class="fas fa-id-badge mr-2 opacity-75"></i><?= htmlspecialchars($formData['designation']) ?>
                                &nbsp;|&nbsp;
                                <i class="fas fa-calendar-alt mr-2 opacity-75"></i>Submitted: <?= date('d M Y', strtotime($formData['form_date'])) ?>
                            </p>
                        </div>
                        <div class="col-md-5 text-md-right hero-actions">
                            <div class="d-inline-flex flex-wrap gap-2" style="gap: 10px;">
                                <a href="tada-form-view.php" class="btn-hero-back mr-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                                <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] != 3): ?>
                                    <a href="tada-form-edit.php?id=<?= $formData['id'] ?>" class="btn-hero-edit mr-2">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                <?php endif; ?>
                                <a href="tada-form-print.php?id=<?= $formData['id'] ?>" target="_blank" class="btn-hero-print">
                                    <i class="fas fa-print mr-1"></i> Print A4
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 1: Personal | Academic & Duties -->
                <div class="row">
                    <!-- Personal Info -->
                    <div class="col-lg-4 mb-4">
                        <div class="det-card h-100 mb-0">
                            <div class="det-card-header">
                                <div class="header-icon"><i class="fas fa-user"></i></div>
                                <h5>Personal Information</h5>
                            </div>
                            <div class="det-card-body">
                                <div class="field-row">
                                    <span class="field-label">Full Name & Designation</span>
                                    <span class="field-value"><?= htmlspecialchars(strtoupper($formData['full_name'])) ?></span>
                                    <span class="field-sub"><?= htmlspecialchars($formData['designation']) ?></span>
                                </div>
                                <div class="field-row">
                                    <span class="field-label">Contact Details</span>
                                    <span class="field-value"><i class="fas fa-phone-alt field-icon"></i><?= htmlspecialchars($formData['phone_no']) ?></span>
                                    <span class="field-value d-block mt-1"><i class="fas fa-envelope field-icon"></i><?= htmlspecialchars($formData['email_id']) ?></span>
                                </div>
                                <div class="field-row">
                                    <span class="field-label">PAN Number</span>
                                    <span class="pan-chip"><i class="fas fa-id-card"></i><?= htmlspecialchars($formData['pan_card']) ?></span>
                                </div>
                                <div class="field-row mb-0">
                                    <span class="field-label">Institute</span>
                                    <span class="field-value"><?= htmlspecialchars(strtoupper($formData['institute_name'])) ?></span>
                                    <span class="field-sub"><i class="fas fa-map-marker-alt mr-1"></i><?= htmlspecialchars($formData['institute_address']) ?: 'N/A' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic & Duties -->
                    <div class="col-lg-8 mb-4">
                        <div class="det-card h-100 mb-0">
                            <div class="det-card-header">
                                <div class="header-icon"><i class="fas fa-graduation-cap"></i></div>
                                <h5>Academic & Duty Details</h5>
                            </div>
                            <div class="det-card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="field-row">
                                            <span class="field-label">Form Date</span>
                                            <span class="field-value"><?= date('d F Y', strtotime($formData['form_date'])) ?></span>
                                        </div>
                                        <div class="field-row">
                                            <span class="field-label">Branch & Semester</span>
                                            <span class="field-value"><?= htmlspecialchars($formData['branch']) ?></span>
                                            <span class="field-sub">Semester: <?= htmlspecialchars($formData['semester']) ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="field-row">
                                            <span class="field-label">Faculty & Program</span>
                                            <span class="field-value"><?= htmlspecialchars($formData['faculty_name'] ?: $formData['faculty_id']) ?></span>
                                            <span class="field-sub"><?= htmlspecialchars($formData['program_name'] ?: $formData['program_id']) ?></span>
                                        </div>
                                        <div class="field-row">
                                            <span class="field-label">Subject Code & Name</span>
                                            <span class="field-value" style="font-size:0.88rem;"><?= htmlspecialchars($formData['subject_code']) ?></span>
                                            <span class="field-sub"><?= htmlspecialchars($formData['subject_name']) ?></span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="section-divider">
                                <span class="section-mini-title"><i class="fas fa-briefcase mr-1"></i> Assigned Responsibilities</span>
                                <div>
                                    <?php if ($formData['duty_type'] && $formData['duty_type'] !== $formData['duty_category']): ?>
                                        <span class="duty-badge"><i class="fas fa-user-tie"></i><?= htmlspecialchars($formData['duty_type']) ?></span>
                                    <?php elseif ($formData['duty_type']): ?>
                                        <span class="duty-badge"><i class="fas fa-user-tie"></i><?= htmlspecialchars($formData['duty_type']) ?></span>
                                    <?php endif; ?>
                                    <?php if ($formData['internal_examiner_name']): ?>
                                        <span class="duty-badge" style="background:#fff4e5;color:#fd7e14;border-color:#fdd6a0;"><i class="fas fa-user-check"></i><?= htmlspecialchars($formData['internal_examiner_name']) ?></span>
                                    <?php endif; ?>
                                    <?php if ($formData['lab_examiner_name']): ?>
                                        <span class="duty-badge" style="background:#e8f9ef;color:#198754;border-color:#a3ddb9;"><i class="fas fa-flask"></i><?= htmlspecialchars($formData['lab_examiner_name']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!$formData['duty_type'] && !$formData['internal_examiner_name'] && !$formData['lab_examiner_name']): ?>
                                        <span class="field-sub">—</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: Journey Table -->
                <?php if (!empty($travelRows)): ?>
                <div class="det-card">
                    <div class="det-card-header">
                        <div class="header-icon"><i class="fas fa-route"></i></div>
                        <h5>Travelling Allowance — Section A</h5>
                    </div>
                    <div class="det-card-body p-0">
                        <div class="table-responsive">
                            <table class="journey-table">
                                <thead>
                                    <tr>
                                        <th>Journey Date</th>
                                        <th>Route (From → To)</th>
                                        <th>Mode & Specs</th>
                                        <th class="text-center">Distance</th>
                                        <th class="text-right" style="padding-right:20px;">Fare Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($travelRows as $tr): ?>
                                    <tr>
                                        <td class="date-cell"><?= date('d-M-Y', strtotime($tr['journey_date'])) ?></td>
                                        <td>
                                            <span class="city-from"><?= pcv($tr['journey_from']) ?></span>
                                            <span class="field-sub"><i class="fas fa-long-arrow-alt-right mr-1 text-muted"></i>To: <?= pcv($tr['journey_to']) ?></span>
                                        </td>
                                        <td>
                                            <span class="mode-badge">
                                                <?php
                                                $mode = $tr['mode_of_journey'];
                                                $modeIcons = ['Car'=>'fas fa-car','Bus'=>'fas fa-bus','Train'=>'fas fa-train','Flight'=>'fas fa-plane','Taxi'=>'fas fa-taxi','Scooter/Motorcycle'=>'fas fa-motorcycle','Local Conveyance'=>'fas fa-walking'];
                                                $icon = $modeIcons[$mode] ?? 'fas fa-truck';
                                                ?>
                                                <i class="<?= $icon ?>"></i>
                                                <?= htmlspecialchars($mode) ?>
                                                <?= $tr['class_of_travel'] ? ' (' . htmlspecialchars($tr['class_of_travel']) . ')' : '' ?>
                                            </span>
                                        </td>
                                        <td class="dist-cell"><?= $tr['distance_km'] > 0 ? number_format($tr['distance_km']) . ' km' : '—' ?></td>
                                        <td class="fare-cell" style="padding-right:20px;">₹<?= number_format($tr['fare_paid'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="4" style="font-size:0.85rem;letter-spacing:0.5px;"><i class="fas fa-calculator mr-2"></i>TOTAL TRAVELLING ALLOWANCE (A)</td>
                                        <td class="total-amt" style="padding-right:20px;">₹<?= number_format($ta_amount, 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ROW 3: Financial Summary Boxes -->
                <div class="stat-grid">
                    <div class="stat-box stat-ta">
                        <div class="stat-icon"><i class="fas fa-plane"></i></div>
                        <div class="stat-body">
                            <div class="stat-label">Total T.A. (A)</div>
                            <div class="stat-value">₹<?= number_format($ta_amount, 2) ?></div>
                            <div class="stat-sub"><?= count($travelRows) ?> Journey Leg<?= count($travelRows) != 1 ? 's' : '' ?></div>
                        </div>
                    </div>
                    <div class="stat-box stat-da">
                        <div class="stat-icon"><i class="fas fa-sun"></i></div>
                        <div class="stat-body">
                            <div class="stat-label">Daily Allowance (B)</div>
                            <div class="stat-value">₹<?= number_format($da_amount, 2) ?></div>
                            <div class="stat-sub"><?= pcv($formData['da_no_of_days']) ?> Day(s) @ ₹<?= number_format($formData['da_rate_per_day'] ?? 0) ?>/day</div>
                        </div>
                    </div>
                    <div class="stat-box stat-hon">
                        <div class="stat-icon"><i class="fas fa-award"></i></div>
                        <div class="stat-body">
                            <div class="stat-label">Honorarium (C)</div>
                            <div class="stat-value">₹<?= number_format($hon_amount, 2) ?></div>
                            <div class="stat-sub"><?= pcv($formData['honorarium_no_of_days']) ?> Day(s) @ ₹<?= number_format($formData['honorarium_rate_per_day'] ?? 0) ?>/day</div>
                        </div>
                    </div>
                    <div class="stat-box stat-gross">
                        <div class="stat-icon"><i class="fas fa-rupee-sign"></i></div>
                        <div class="stat-body">
                            <div class="stat-label">Gross Total (A+B+C+D)</div>
                            <div class="stat-value">₹<?= number_format($gross, 2) ?></div>
                            <div class="stat-sub">Incl. Accommodation: ₹<?= number_format($acc_amount, 2) ?></div>
                        </div>
                    </div>
                </div>

                <!-- ROW 4: Bank & Declarations -->
                <div class="row">
                    <!-- Bank Details -->
                    <div class="col-md-6 mb-4">
                        <div class="det-card h-100 mb-0">
                            <div class="det-card-header">
                                <div class="header-icon"><i class="fas fa-university"></i></div>
                                <h5>Bank Account Details</h5>
                            </div>
                            <div class="det-card-body">
                                <div class="bank-item">
                                    <div class="bank-icon"><i class="fas fa-building"></i></div>
                                    <div class="bank-info">
                                        <div class="bank-label">Bank Name & Branch</div>
                                        <div class="bank-value"><?= htmlspecialchars(strtoupper($formData['bank_name'])) ?></div>
                                        <div class="bank-sub"><?= htmlspecialchars(strtoupper($formData['bank_branch'])) ?></div>
                                    </div>
                                </div>
                                <div class="bank-item">
                                    <div class="bank-icon"><i class="fas fa-credit-card"></i></div>
                                    <div class="bank-info">
                                        <div class="bank-label">Account Number</div>
                                        <div class="bank-value acc-chip"><?= htmlspecialchars($formData['account_no']) ?></div>
                                        <div class="bank-sub">Type: <?= htmlspecialchars(strtoupper($formData['bank_acc_type'])) ?> Account</div>
                                    </div>
                                </div>
                                <div class="bank-item">
                                    <div class="bank-icon"><i class="fas fa-code-branch"></i></div>
                                    <div class="bank-info">
                                        <div class="bank-label">IFSC Code</div>
                                        <div class="bank-value" style="font-family: monospace; letter-spacing: 1.5px;"><?= htmlspecialchars(strtoupper($formData['ifsc_code'])) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Declarations -->
                    <div class="col-md-6 mb-4">
                        <div class="det-card h-100 mb-0">
                            <div class="det-card-header">
                                <div class="header-icon"><i class="fas fa-shield-alt"></i></div>
                                <h5>Declarations & Validation</h5>
                            </div>
                            <div class="det-card-body">
                                <div class="decl-item">
                                    <div class="decl-icon check"><i class="fas fa-check"></i></div>
                                    <div class="decl-text">
                                        Amount in words: <strong><?= numberToWords($gross) ?> RUPEES ONLY</strong>
                                    </div>
                                </div>
                                <?php if ($formData['vehicle_no']): ?>
                                <div class="decl-item">
                                    <div class="decl-icon car"><i class="fas fa-car"></i></div>
                                    <div class="decl-text">
                                        Self-driven vehicle: <strong><?= htmlspecialchars(strtoupper($formData['vehicle_no'])) ?></strong>
                                        &nbsp;|&nbsp; Fuel: <strong><?= htmlspecialchars(strtoupper($formData['fuel_type'])) ?></strong>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if ($formData['cert_rail_bus']): ?>
                                <div class="decl-item">
                                    <div class="decl-icon check"><i class="fas fa-bus"></i></div>
                                    <div class="decl-text">Rail / Bus ticket certified for travel</div>
                                </div>
                                <?php endif; ?>
                                <?php if ($formData['cert_air']): ?>
                                <div class="decl-item">
                                    <div class="decl-icon check"><i class="fas fa-plane"></i></div>
                                    <div class="decl-text">Air travel boarding pass certified</div>
                                </div>
                                <?php endif; ?>
                                <div class="decl-item">
                                    <div class="decl-icon info"><i class="fas fa-info"></i></div>
                                    <div class="decl-text" style="font-size:0.8rem;">
                                        "I confirm that this amount is not claimed elsewhere and if found, I undertake to refund the same to the University."
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php else: ?>
                    <div class="alert alert-danger border-0 rounded-14 shadow-sm" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <?= htmlspecialchars($error_message) ?>
                        <div class="mt-2">
                            <a href="tada-form-view.php" class="btn btn-sm btn-outline-danger">Return to List</a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>