<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- ================= TOP STRIP ================= -->
    <div class="bg-dark py-2 top-strip">
        <div class="container">

            <div class="row text-center small">

                <div class="col-6 col-lg text-white mb-1 mb-lg-0">
                    <a href="https://gmiu.edu.in/gmiu/website/forms/virtual-counselling-form.php"
                        class="text-white text-decoration-none">
                        <i class="bi bi-camera-video-fill me-1"></i> Virtual Counseling
                    </a>
                </div>

                <div class="col-6 col-lg text-white mb-1 mb-lg-0">
                    <a href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php"
                        class="text-white text-decoration-none">
                        <i class="bi bi-globe me-1"></i> 360 Virtual Tour
                    </a>
                </div>

                <div class="col-6 col-lg text-white mb-1 mb-lg-0">
                    <a href="https://admission.gmiu.edu.in/premium/index.php" class="text-white text-decoration-none">
                        <i class="bi bi-award-fill me-1"></i> PLM
                    </a>
                </div>

                <div class="col-6 col-lg mb-1 mb-lg-0">
                    <a href="https://admission.gmiu.edu.in"
                        class="text-white text-decoration-none bg-danger px-2 py-1 rounded-pill d-inline-block">
                        <i class="bi bi-megaphone-fill me-1"></i> Admission 2026-27
                    </a>
                </div>

            </div>

        </div>
    </div>

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

                $menu = [
                    'index.php' => 'Dashboard',
                    'personal-details.php' => 'Personal Details',
                    'program-selection.php' => 'Program Selection',
                    'payment.php' => 'Payment',
                ];
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