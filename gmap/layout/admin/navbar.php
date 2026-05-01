<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">

            <!-- BRAND -->
            <a class="navbar-brand d-flex align-items-center" href="#">

                <!-- 🔹 Desktop Logo -->
                <img src="gmap-logo.png" alt="GMAP Logo" height="55" class="d-none d-lg-block">

                <!-- 🔹 Mobile Square Logo -->
                <img src="gmap-logo.png" alt="GMAP Logo" height="45" class="me-2 d-lg-none rounded">

                <!-- 🔹 Vertical Divider (Desktop Only) -->
                <div class="vr mx-3 d-none d-lg-block" style="height:50px;"></div>

                <!-- 🔹 Text -->
                <div class="lh-sm">
                    <div class="fw-bold fs-6 fs-lg-5" style="color: #bc2823;">
                        GMAP
                    </div>
                    <small class="fw-semibold d-sm-block" style="color:#1e264a; font-size: 0.8rem;">
                        Gyanmanjari Admission Portal
                    </small>
                </div>

            </a>

            <!-- TOGGLER -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- NAV LINKS -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php
                $currentPage = basename($_SERVER['PHP_SELF']);
                $role_id = $_SESSION['role_id'] ?? 0;

                if ($role_id == 2) {
                    // Accounting Menu
                    $menu = [
                        'admin-view-transactions.php' => 'Successful Transactions'
                    ];
                } else {
                    // Admin Menu (61)
                    $menu = [
                        'admin-index.php' => 'Dashboard',
                        'admin-view-students.php' => 'Students Details',
                        'admin-announcements.php' => 'Announcements',
                        'admin-add-refferal-code.php' => 'Referral Code'
                    ];
                }
                ?>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php foreach ($menu as $file => $label): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link <?= ($currentPage == $file) ? 'active' : ''; ?>" href="<?= $file; ?>">
                                <?= $label; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <li class="nav-item ms-3">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- Do not end the BODY here  -->