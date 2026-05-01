<?php
$pageTitle = "GMAP - Admin Login";
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

    // Check user (Allow Admin: 61 and Accounting: 2)
    $stmt = $con->prepare("SELECT id, role_id, name, email, password FROM tbl_staff WHERE email = ? AND is_delete = 0 AND is_active = 1 AND role_id IN (61, 2) LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        // Plain text password check (as requested)
        if ($password === $user['password']) {

            $_SESSION['staff_id'] = $user['id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['staff_name'] = $user['name'];
            $_SESSION['staff_email'] = $user['email'];

            $redirect = ($user['role_id'] == 2) ? 'admin-view-transactions.php' : 'admin-index.php';

            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Login Successful',
                'text' => 'Welcome back!',
                'redirect' => $redirect
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
                        <span style="color:#1e264a;">GMAP</span>
                        <span style="color:#bc2823;"> Admin Panel</span>
                    </h4>

                    <span class="badge bg-dark px-3 py-2 mb-2">
                        Administrator Access Only
                    </span>

                    <p class="text-muted mb-2">
                        Secure Login for GMAP Administration
                    </p>

                    <div class="mx-auto rounded-pill" style="width:70px;height:4px;background:#bc2823;"></div>
                </div>

                <!-- Login Form -->
                <form method="POST" action="">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Admin Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter admin email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Admin Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter admin password"
                            required>
                    </div>

                    <button type="submit" name="login" class="btn w-100 fw-semibold text-white"
                        style="background:#bc2823;">
                        <i class="bi bi-shield-lock"></i> ADMIN LOGIN
                    </button>

                    <!-- Only Forgot Password -->
                    <!-- <div class="text-center mt-3">
                        <small>
                            <a href="forgot-password.php" class="text-decoration-none" style="color:#bc2823;">
                                <i class="bi bi-key"></i> Forgot Password?
                            </a>
                        </small>
                    </div> -->

                </form>

            </div>

        </div>
    </div>
</div>

<?php include './layout/auth/endlink.php'; ?>