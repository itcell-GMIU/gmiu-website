

<style>
/* ============================================
   GLOBAL LAYOUT & STICKY FOOTER
   ============================================ */
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Inter', sans-serif;
    color: #334155;
    background-color: #f8fafc;
}

body {
    display: flex !important;
    flex-direction: column !important;
}

/* Base theme container fixes to ensure footer stays at bottom */
.main-container {
    padding-left: 0 !important;
    margin-left: 0 !important;
    padding-top: 72px !important;
    display: flex !important;
    flex-direction: column !important;
    flex: 1 0 auto !important;
    width: 100% !important;
    background: transparent !important;
}

.pd-ltr-20 {
    display: flex !important;
    flex-direction: column !important;
    flex: 1 0 auto !important;
    padding: 20px !important;
}

/* This pushes the footer down */
.min-height-200px {
    flex: 1 0 auto !important;
    padding-bottom: 60px !important;
}

.left-side-bar {
    display: none !important;
}

/* ============================================
   PROFESSIONAL NAVBAR STYLES
   ============================================ */
.pro-navbar {
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 72px;
    z-index: 1200;
    background: #ffffff;
    border-bottom: 2px solid #f1f5f9;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    box-sizing: border-box;
}

/* ----- LOGO (Left) ----- */
.pro-navbar__logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    flex: 0 0 240px; /* Exact width to balance the right side */
}
.pro-navbar__logo img {
    height: 48px;
    width: auto;
    transition: transform 0.2s;
}
.pro-navbar__logo img:hover {
    transform: scale(1.02);
}

/* ----- NAV LINKS (Center) ----- */
.pro-navbar__center {
    flex: 1;
    display: flex;
    justify-content: center;
}
.pro-navbar__nav {
    display: flex;
    align-items: center;
    gap: 12px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.pro-navbar__nav > li > a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    color: #64748b;
    text-decoration: none;
    transition: all 0.25s ease;
}
.pro-navbar__nav > li > a:hover,
.pro-navbar__nav > li > a.active,
.pro-navbar__nav > li .dropdown-toggle[aria-expanded="true"] {
    background-color: #f1f5f9;
    color: #2563eb;
}
.pro-navbar__nav > li > a i { font-size: 16px; opacity: 0.8; }

/* Custom Dropdown for TADA */
.pro-navbar__nav .dropdown-menu {
    top: 100%;
    margin-top: 12px;
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 10px;
    min-width: 220px;
    animation: proFadeUp 0.2s ease-out;
}
@keyframes proFadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.pro-navbar__nav .dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #475569;
    transition: all 0.2s;
}
.pro-navbar__nav .dropdown-item i { flex: 0 0 20px; text-align: center; font-size: 14px; }
.pro-navbar__nav .dropdown-item:hover,
.pro-navbar__nav .dropdown-item.active {
    background-color: #eff6ff;
    color: #2563eb;
    transform: translateX(5px);
}

/* ----- RIGHT: User Info ----- */
.pro-navbar__right {
    flex: 0 1 auto;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 15px;
}
@media (min-width: 992px) {
    .pro-navbar__right { min-width: 240px; }
}


.pro-navbar__user-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 5px 16px 5px 5px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 50px;
    transition: all 0.2s;
    cursor: default;
}
.pro-navbar__user-card:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.pro-navbar__avatar {
    width: 32px; height: 32px;
    background: #2563eb;
    color: #ffffff;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    font-size: 13px;
    font-weight: 800;
}
.pro-navbar__username {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
}

.pro-navbar__logout {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background-color: #fff1f2;
    color: #e11d48;
    border: 1.5px solid #fda4af;
    border-radius: 14px;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none !important;
    transition: all 0.2s;
}
.pro-navbar__logout:hover {
    background-color: #e11d48;
    color: #ffffff;
    box-shadow: 0 5px 15px rgba(225, 29, 72, 0.2);
}

/* MOBILE TOGGLE */
.pro-navbar__toggle {
    display: none;
    font-size: 26px;
    color: #475569;
    cursor: pointer;
    background: none; border: none;
}

/* ============================================
   RESPONSIVENESS
   ============================================ */
@media (max-width: 1200px) {
    .pro-navbar { padding: 0 20px; }
    .pro-navbar__logo, .pro-navbar__right { flex: 0 0 auto; }
}

@media (max-width: 991px) {
    .pro-navbar__center { display: none; }
    .pro-navbar__toggle { display: block; }
    .pro-navbar__user-card { display: none; }
}

@media (max-width: 576px) {
    .pro-navbar__logout span { display: none; }
    .pro-navbar__logout { padding: 10px 14px; }
    .pro-navbar { padding: 0 15px; }
}

/* MOBILE SLIDE MENU */
.pro-mobile-nav {
    display: none;
    position: fixed;
    top: 72px; left: 0;
    width: 100%;
    background: #ffffff;
    border-bottom: 2px solid #e2e8f0;
    z-index: 1100;
    padding: 15px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
}
.pro-mobile-nav.open { display: block; }
.pro-mobile-nav a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 20px;
    color: #475569;
    font-weight: 700;
    text-decoration: none;
    border-radius: 12px;
}
.pro-mobile-nav a:hover,
.pro-mobile-nav a.active {
    background-color: #f1f5f9;
    color: #2563eb;
}
</style>

<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<header class="pro-navbar">
    <!-- LEFT -->
    <a href="index.php" class="pro-navbar__logo">
        <img src="src/images/logowithbg.png" alt="University Home">
    </a>

    <!-- CENTER -->
    <div class="pro-navbar__center">
        <ul class="pro-navbar__nav">
            <?php 
                $is_hod = (isset($role_name) && $role_name === 'HOD');
            ?>

            <?php if (!$is_hod && isset($_SESSION['role_id']) && $_SESSION['role_id'] != 3): ?>
            <li>
                <a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </li>
            <?php endif; ?>

            <li class="dropdown">
                <?php 
                    $tada_pages = ['tada-form-fill.php', 'tada-form-view.php', 'tada-form-edit.php', 'tada-form-history.php', 'tada-form-details.php'];
                    $is_tada_active = in_array($current_page, $tada_pages);
                ?>
                <a href="#" class="dropdown-toggle <?= $is_tada_active ? 'active' : '' ?>" data-toggle="dropdown" id="tadaBtn">
                    <i class="fa fa-file-text-o"></i> TADA Form
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item <?= $current_page == 'tada-form-fill.php' ? 'active' : '' ?>" href="tada-form-fill.php"><i class="fa fa-pencil-square-o"></i> <span>Fill New Form</span></a>
                    <a class="dropdown-item <?= $current_page == 'tada-form-view.php' ? 'active' : '' ?>" href="tada-form-view.php"><i class="fa fa-list-alt"></i> <span>View Submission List</span></a>
                </div>
            </li>

            <?php if (!$is_hod && isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2)): ?>
            <li class="dropdown">
                <?php 
                    $report_pages = ['tada-report.php', 'tada-practical-exam-report.php', 'tada-pan-report.php'];
                    $is_report_active = in_array($current_page, $report_pages);
                ?>
                <a href="#" class="dropdown-toggle <?= $is_report_active ? 'active' : '' ?>" data-toggle="dropdown">
                    <i class="fa fa-bar-chart"></i> Reports
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item <?= $current_page == 'tada-report.php' ? 'active' : '' ?>" href="tada-report.php"><i class="fa fa-file-excel-o"></i> <span>TADA Report</span></a>
                    <a class="dropdown-item <?= $current_page == 'tada-practical-exam-report.php' ? 'active' : '' ?>" href="tada-practical-exam-report.php"><i class="fa fa-file-text-o"></i> <span>Practical Exam Bill</span></a>
                    <a class="dropdown-item <?= $current_page == 'tada-pan-report.php' ? 'active' : '' ?>" href="tada-pan-report.php"><i class="fa fa-id-card-o"></i> <span>Practical Exam Bill (PAN)</span></a>
                </div>
            </li>
            <?php endif; ?>

            <?php if (isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2)): ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle <?= ($current_page == 'create-user.php' || $current_page == 'user-list.php' || $current_page == 'user-edit.php') ? 'active' : '' ?>" data-toggle="dropdown">
                    <i class="fa fa-users"></i> Users
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item <?= $current_page == 'create-user.php' ? 'active' : '' ?>" href="create-user.php"><i class="fa fa-user-plus"></i> <span>Create User</span></a>
                    <a class="dropdown-item <?= $current_page == 'user-list.php' ? 'active' : '' ?>" href="user-list.php"><i class="fa fa-list"></i> <span>User List</span></a>
                </div>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- RIGHT -->
    <div class="pro-navbar__right">
        <button class="pro-navbar__toggle" id="proNavToggle">
            <i class="fa fa-bars"></i>
        </button>
        <?php 
            $disp_name = $_SESSION['name'] ?? 'User';
            $role_id = $_SESSION['role_id'] ?? 0;
            $role_name = '';
            if($role_id == 1) $role_name = 'Super Admin';
            elseif($role_id == 2) $role_name = 'EXAM ADMIN';
            elseif($role_id == 3) $role_name = 'HOD';

            // Generate Initials
            $words = explode(" ", trim($disp_name));
            $initials = "";
            if (count($words) >= 2) {
                $initials = strtoupper(substr($words[0], 0, 1) . substr($words[count($words)-1], 0, 1));
            } else {
                $initials = strtoupper(substr($disp_name, 0, 1));
            }
        ?>
        <div class="pro-navbar__user-card">
            <div class="pro-navbar__avatar">
                <?= $initials ?>
            </div>
            <div class="d-flex flex-column text-left" style="line-height: 1.1;">
                <span class="pro-navbar__username" style="display: block; margin-bottom: 2px;">
                    <?= htmlspecialchars($disp_name) ?>
                </span>
                <small class="text-muted" style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                    <?= $role_name ?>
                </small>
            </div>
        </div>

        
        <a href="javascript:void(0);" id="logout-btn" class="pro-navbar__logout">
            <i class="fa fa-sign-out"></i>
            <span>Logout</span>
        </a>
    </div>

</header>

<!-- Mobile Navigation Menu -->
<div class="pro-mobile-nav" id="proMobileNav">
    <?php 
        $is_hod = (isset($role_name) && $role_name === 'HOD');
    ?>
    <?php if (!$is_hod && isset($_SESSION['role_id']) && $_SESSION['role_id'] != 3): ?>
    <a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>"><i class="fa fa-home"></i> Dashboard</a>
    <?php endif; ?>
    <a href="tada-form-fill.php" class="<?= $current_page == 'tada-form-fill.php' ? 'active' : '' ?>"><i class="fa fa-pencil-square-o"></i> Fill TADA Form</a>
    <a href="tada-form-view.php" class="<?= $current_page == 'tada-form-view.php' ? 'active' : '' ?>"><i class="fa fa-list-alt"></i> View Submissions</a>
    
    <?php if (!$is_hod && isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2)): ?>
    <a href="tada-report.php" class="<?= $current_page == 'tada-report.php' ? 'active' : '' ?>"><i class="fa fa-file-excel-o"></i> TADA Report</a>
    <a href="tada-practical-exam-report.php" class="<?= $current_page == 'tada-practical-exam-report.php' ? 'active' : '' ?>"><i class="fa fa-file-text-o"></i> Practical Exam Bill</a>
    <a href="tada-pan-report.php" class="<?= $current_page == 'tada-pan-report.php' ? 'active' : '' ?>"><i class="fa fa-id-card-o"></i> Practical Exam Bill (PAN)</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2)): ?>
    <a href="user-list.php" class="<?= $current_page == 'user-list.php' ? 'active' : '' ?>"><i class="fa fa-users"></i> User List</a>
    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('proNavToggle');
    const menu = document.getElementById('proMobileNav');
    
    if (toggle) {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('open');
        });
    }
    
    document.addEventListener('click', function() {
        if (menu && menu.classList.contains('open')) {
            menu.classList.remove('open');
        }
    });

    if (menu) {
        menu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
