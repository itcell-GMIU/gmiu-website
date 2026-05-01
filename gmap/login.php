<?php
$pageTitle = "GMAP - Login";
include './layout/auth/head.php';

// Handle Login
if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($email) || empty($password)) {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Missing Fields',
            'text' => 'Please enter email and password.'
        ];
    }

    // Check user
    $stmt = $con->prepare("SELECT id, surname, student_name, email, password FROM tbl_gmap_students WHERE email = ? AND is_delete = 0 LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        // Plain text password check (as requested)
        if ($password === $user['password']) {

            $_SESSION['student_id'] = $user['id'];
            $_SESSION['student_name'] = $user['surname'] . ' ' . $user['student_name'];
            $_SESSION['student_email'] = $user['email'];

            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Login Successful',
                'text' => 'Welcome back!',
                'redirect' => 'index.php'
            ];

        } else {

            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Invalid Password',
                'text' => 'Please enter correct password.'
            ];

        }

    } else {

        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Account Not Found',
            'text' => 'No account exists with this email.'
        ];

    }
}
?>

<div class="container">
    <!-- Logo -->
    <div class="admin-logo">
        <img src="gmap-logo.png" alt="GMAP Logo">
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">

            <div class="card shadow-lg border-0 rounded p-4 position-relative overflow-hidden form-card">

                <!-- Heading -->
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark">
                        <span style="color:#1e264a;">Gyanmanjari Admission Portal</span>
                        <span style="color:#bc2823;"> (GMAP)</span>
                    </h4>
                    <p class="text-muted mb-2">Login to Your Account</p>
                    <div class="mx-auto rounded-pill" style="width:70px;height:4px;background:#bc2823;"></div>
                </div>

                <!-- Notice Download Buttons -->
                <div class="text-center mb-4">
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-2">
                        <a href="gmap-notice.pdf" target="_blank" class="btn btn-sm text-white fw-semibold px-3 py-2 shadow-sm" style="background:#bc2823; border-radius: 50px; min-width: 180px;">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Download Notice
                        </a>
                        <a href="gmap-schedule.pdf" target="_blank" class="btn btn-sm btn-outline-dark fw-semibold px-3 py-2 shadow-sm" style="border-radius: 50px; min-width: 180px;">
                            <i class="bi bi-calendar-date me-1"></i> Download Schedule
                        </a>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="gmap-admission-procedure.pdf" target="_blank" class="btn btn-sm btn-outline-dark fw-semibold px-3 py-2 shadow-sm" style="border-radius: 50px; min-width: 180px;">
                            <i class="bi bi-info-circle me-1"></i> Admission Procedure
                        </a>
                        <a href="gmap-pg-admission-notice.pdf" target="_blank" class="btn btn-sm btn-outline-dark fw-semibold px-3 py-2 shadow-sm" style="border-radius: 50px; min-width: 180px;">
                            <i class="bi bi-megaphone me-1"></i> PG Admission Notice
                        </a>
                    </div>
                </div>

                <!-- Login Form -->
                <form method="POST" action="">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter registered email"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password"
                            required>
                    </div>

                    <button type="submit" name="login" class="btn w-100 fw-semibold text-white"
                        style="background:#bc2823;">
                        LOGIN
                    </button>

                    <!-- Register + Forgot Password Links -->
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <!-- Forgot Password -->
                        <small>
                            <a href="forgot-password.php" class="text-decoration-none" style="color:#bc2823;">
                                <i class="bi bi-key"></i> Forgot Password?
                            </a>
                        </small>

                        <!-- Register -->
                        <small class="text-muted">
                            New User?
                            <a href="registration.php" class="fw-semibold text-decoration-none" style="color:#1e264a;">
                                <i class="bi bi-person-plus"></i> Register Here
                            </a>
                        </small>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<?php include './layout/auth/endlink.php'; ?>