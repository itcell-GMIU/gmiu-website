<?php
session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/helpers/database.php';

// Generate CSRF token
$csrf_token = generateCSRFToken();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        die('CSRF token validation failed.');
    }

    // Collect and sanitize form data
    $formData = [
        'team_member_1' => sanitize($_POST['team_member_1'] ?? ''),
        'team_member_2' => sanitize($_POST['team_member_2'] ?? ''),
        'team_member_3' => sanitize($_POST['team_member_3'] ?? ''),
        'college_name' => sanitize($_POST['college_name'] ?? ''),
        'mobile' => sanitize($_POST['mobile'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'side' => sanitize($_POST['side'] ?? '')
    ];

    // Server-side validation
    $errors = [];
    if (empty($formData['team_member_1']) || strlen($formData['team_member_1']) < 2) {
        $errors[] = 'Team member 1 name is required and must be at least 2 characters.';
    }
    if (empty($formData['team_member_2']) || strlen($formData['team_member_2']) < 2) {
        $errors[] = 'Team member 2 name is required and must be at least 2 characters.';
    }
    if (empty($formData['team_member_3']) || strlen($formData['team_member_3']) < 2) {
        $errors[] = 'Team member 3 name is required and must be at least 2 characters.';
    }
    if (empty($formData['college_name']) || strlen($formData['college_name']) < 3) {
        $errors[] = 'College name is required and must be at least 3 characters.';
    }
    if (!validateMobile($formData['mobile'])) {
        $errors[] = 'Please enter a valid 10-digit mobile number starting with 6-9.';
    }
    if (!validateEmail($formData['email'])) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (!in_array($formData['side'], ['plaintiff', 'defendant'])) {
        $errors[] = 'Please select a valid side (Plaintiff or Defendant).';
    }

    // Check for existing registration
    $existingRegistration = checkExistingRegistration($formData['email']);
    $allowPayment = false;
    $paymentMessage = '';

    if ($existingRegistration) {
        if ($existingRegistration['status'] === 'SUCCESS') {
            // Block successful registrations completely
            $paymentMessage = 'This email is already registered for a successful payment. Each email can only be used for one successful registration.';
        } elseif ($existingRegistration['status'] === 'PENDING') {
            // Allow payment for pending registration
            $allowPayment = true;
            $paymentMessage = 'You have a pending registration with this email. Click "Proceed to Payment" to complete your existing registration.';
        } elseif ($existingRegistration['status'] === 'FAILED') {
            // Allow payment for failed registration
            $allowPayment = true;
            $paymentMessage = 'Your previous payment failed. Click "Proceed to Payment" to retry with your existing registration details.';
        }
    } else {
        // No existing registration, allow new registration
        $allowPayment = true;
    }

    if (empty($errors)) {
        $db = getDB();

        // Handle registration creation/update
        if ($existingRegistration && in_array($existingRegistration['status'], ['PENDING', 'FAILED'])) {
            // Update existing registration with new data
            $receipt_token = $existingRegistration['receipt_token'] ?? bin2hex(random_bytes(32));
            $stmt = mysqli_prepare($db, "UPDATE m_registrations SET team_member_1 = ?, team_member_2 = ?, team_member_3 = ?, college_name = ?, mobile = ?, side = ?, csrf_token = ?, receipt_token = ?, status = 'PENDING', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssssssssi", $formData['team_member_1'], $formData['team_member_2'], $formData['team_member_3'], $formData['college_name'], $formData['mobile'], $formData['side'], $csrf_token, $receipt_token, $existingRegistration['id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $registration_id = $existingRegistration['id'];
            logActivity('registration_updated', $formData['email'], "Updated existing registration ID: $registration_id");
        } elseif (!$existingRegistration) {
            // Insert new registration
            $receipt_token = bin2hex(random_bytes(32)); // Generate secure random token
            $stmt = mysqli_prepare($db, "INSERT INTO m_registrations (team_member_1, team_member_2, team_member_3, college_name, mobile, email, side, csrf_token, receipt_token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssssssss", $formData['team_member_1'], $formData['team_member_2'], $formData['team_member_3'], $formData['college_name'], $formData['mobile'], $formData['email'], $formData['side'], $csrf_token, $receipt_token);
            mysqli_stmt_execute($stmt);
            $registration_id = mysqli_insert_id($db);
            mysqli_stmt_close($stmt);
            logActivity('registration_started', $formData['email'], "New registration ID: $registration_id");
        } else {
            // This should not happen due to earlier validation, but just in case
            $errors[] = 'Unable to process registration. Please contact support.';
        }

        if (empty($errors) && isset($registration_id)) {
            // Redirect to payment
            header("Location: controllers/process_payment.php?reg_id=" . $registration_id);
            exit;
        }

    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMIU - Moot Court Registration</title>
    <link rel="shortcut icon" href="<?php echo BASE_DOMAIN; ?>/gmiu/website_assets/images/favicon.ico"
        type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Inter:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-legal {
            font-family: 'Cinzel', serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .font-legal {
            font-family: 'Cinzel', serif;
        }

        .gmiu-navy {
            background-color: #1a2a47;
        }

        .gmiu-red {
            background-color: #b91c1c;
        }

        .text-gmiu-navy {
            color: #1a2a47;
        }

        .border-gmiu-red {
            border-color: #b91c1c;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden border-t-8 border-gmiu-red my-5">

        <!-- HEADER -->
        <div
            class="p-6 md:p-10 flex flex-col md:flex-row items-center justify-between border-b border-gray-200 bg-white">
            <div class="flex items-center space-x-6 mb-4 md:mb-0">
                <img src="<?php echo BASE_DOMAIN; ?>/gmiu/website_assets/images/logo-single.jpg" alt="GMIU Logo"
                    class="h-24 w-auto">
                <div class="h-16 w-px bg-gray-300 hidden md:block"></div>
            </div>
            <div class="text-center md:text-right">
                <h1 class="text-2xl md:text-3xl font-bold text-gmiu-navy uppercase leading-tight">
                    Gyanmanjari Innovative University
                </h1>
                <h2 class="text-xl font-semibold text-red-700 mt-1">
                    Gyanmanjari Institute of Law
                </h2>
                <p class="text-gray-500 font-legal tracking-widest text-sm mt-2">
                    Registration Form: Moot Court Competition
                </p>
            </div>
        </div>

        <!-- RULEBOOK BUTTON (AFTER HEADER) -->
        <div class="px-6 md:px-10 py-4 border-b border-gray-200 bg-gray-50 text-center">
            <a href="rulebook.docx"
               download="rulebook.docx"
               class="inline-flex items-center gap-2
                      bg-white border border-gmiu-navy text-gmiu-navy
                      px-6 py-3 rounded-md
                      text-sm font-bold uppercase tracking-widest
                      shadow-sm transition">
        
                <!-- Book Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v12m6-6H6"/>
                </svg>
        
                View Rulebook
            </a>
        
            <p class="mt-2 text-xs text-gray-500">
                Please read the rulebook carefully before proceeding with registration.
            </p>
        </div>


        <!-- FORM -->
        <form id="registrationForm" method="POST" action="" class="p-8 md:p-12 space-y-10">

            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <!-- TEAM COMPOSITION -->
            <section>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-2 h-8 gmiu-navy"></div>
                    <h3 class="text-lg font-bold text-gmiu-navy uppercase tracking-wider">
                        Team Composition
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="team_member_1" class="block text-xs font-bold text-gray-600 uppercase mb-1">
                            Team Member 1 *
                        </label>
                        <input type="text" id="team_member_1" name="team_member_1" required placeholder="Full Name"
                            class="w-full px-4 py-3 border-b-2 border-gray-300 focus:border-gmiu-navy outline-none transition-colors bg-gray-50">
                    </div>

                    <div>
                        <label for="team_member_2" class="block text-xs font-bold text-gray-600 uppercase mb-1">
                            Team Member 2 *
                        </label>
                        <input type="text" id="team_member_2" name="team_member_2" required placeholder="Full Name"
                            class="w-full px-4 py-3 border-b-2 border-gray-300 focus:border-gmiu-navy outline-none transition-colors bg-gray-50">
                    </div>

                    <div>
                        <label for="team_member_3" class="block text-xs font-bold text-gray-600 uppercase mb-1">
                            Team Member 3 *
                        </label>
                        <input type="text" id="team_member_3" name="team_member_3" required placeholder="Full Name"
                            class="w-full px-4 py-3 border-b-2 border-gray-300 focus:border-gmiu-navy outline-none transition-colors bg-gray-50">
                    </div>
                </div>
            </section>

            <!-- INSTITUTION DETAILS -->
            <section>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-2 h-8 gmiu-navy"></div>
                    <h3 class="text-lg font-bold text-gmiu-navy uppercase tracking-wider">
                        Institutional & Contact Details
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label for="college_name" class="block text-xs font-bold text-gray-600 uppercase mb-1">
                            College / University Name *
                        </label>
                        <input type="text" id="college_name" name="college_name" required
                            placeholder="Enter Full Name of College/University"
                            class="w-full px-4 py-3 border-b-2 border-gray-300 focus:border-gmiu-navy outline-none transition-colors bg-gray-50">
                    </div>

                    <div>
                        <label for="mobile" class="block text-xs font-bold text-gray-600 uppercase mb-1">
                            Mobile No. *
                        </label>
                        <input type="tel" id="mobile" name="mobile" required pattern="[6-9][0-9]{9}"
                            placeholder="10-digit mobile number"
                            class="w-full px-4 py-3 border-b-2 border-gray-300 focus:border-gmiu-navy outline-none transition-colors bg-gray-50">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-600 uppercase mb-1">
                            Mail ID *
                        </label>
                        <input type="email" id="email" name="email" required placeholder="your.email@example.com"
                            class="w-full px-4 py-3 border-b-2 border-gray-300 focus:border-gmiu-navy outline-none transition-colors bg-gray-50">

                        <p class="mt-1 text-xs text-amber-600 font-medium">
                            ⚠️ Ensure this email ID is correct. Payment confirmation could be sent here.
                        </p>
                    </div>
                </div>
            </section>

            <!-- SIDE -->
            <section class="bg-slate-50 p-6 rounded-lg border border-gray-200">
                <label class="block text-sm font-bold text-gmiu-navy uppercase mb-4 text-center md:text-left">
                    Representation on behalf of:
                </label>

                <div
                    class="flex flex-col md:flex-row justify-center md:justify-start items-center space-y-4 md:space-y-0 md:space-x-12">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="side" value="plaintiff" required
                            class="w-5 h-5 text-red-600 focus:ring-red-500">
                        <span class="text-gray-700 font-semibold uppercase">Plaintiff</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="side" value="defendant" required
                            class="w-5 h-5 text-red-600 focus:ring-red-500">
                        <span class="text-gray-700 font-semibold uppercase">Defendant</span>
                    </label>
                </div>
            </section>
            
            <!-- TERMS & CONDITIONS -->
            <section class="mt-6">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="agree_terms"
                        required
                        class="mt-1 w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                    >
            
                    <span class="text-sm text-gray-700 leading-relaxed">
                        Yes, I have read the
                        <a href="rule-book.pdf" target="_blank"
                           class="text-gmiu-navy font-semibold underline hover:text-red-600">
                            Rule Book
                        </a>
                        and I agree to the
                        <a href="terms-and-conditions.pdf" target="_blank"
                           class="text-gmiu-navy font-semibold underline hover:text-red-600">
                            Terms &amp; Conditions
                        </a>.
                    </span>
                </label>
            </section>

            <!-- SUBMIT -->
            <div class="text-center space-y-2">
                <p class="text-sm text-gray-600">
                    Registration Fee: <span class="font-bold text-gmiu-navy">₹300 per team</span>
                </p>

                <button type="submit"
                    class="gmiu-navy hover:bg-slate-800 text-white font-bold py-4 px-12 rounded shadow-lg transition-transform active:scale-95 uppercase tracking-widest">
                    Proceed to Payment ₹300
                </button>
            </div>
        </form>

        <!-- FOOTER -->
        <div class="gmiu-navy p-4 text-center">
            <p class="text-white text-[10px] uppercase tracking-widest opacity-80">
                © 2026 Gyanmanjari Institute of Law | All Rights Reserved
            </p>
        </div>
    </div>


    <script>
        // Show server-side errors with SweetAlert
        <?php if (!empty($errors)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<?php echo addslashes(implode("<br>", $errors)); ?>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#1e3a8a'
            });
        <?php endif; ?>

        // Show payment status messages
        <?php if (!empty($paymentMessage)): ?>
            <?php if ($allowPayment): ?>
                Swal.fire({
                    icon: 'info',
                    title: 'Existing Registration Found',
                    html: '<?php echo addslashes($paymentMessage); ?>',
                    confirmButtonText: 'Proceed to Payment',
                    confirmButtonColor: '#1e3a8a',
                    showCancelButton: true,
                    cancelButtonText: 'Update Details First'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Auto-submit form to proceed to payment
                        document.getElementById('registrationForm').submit();
                    }
                });
            <?php else: ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Registration Not Allowed',
                    html: '<?php echo addslashes($paymentMessage); ?>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#b91c1c'
                });
            <?php endif; ?>
        <?php endif; ?>

        // Client-side validation and confirmation
        document.getElementById('registrationForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent immediate submission

            const mobile = document.getElementById('mobile').value;
            const email = document.getElementById('email').value;

            // Mobile validation
            if (!/^[6-9]\d{9}$/.test(mobile)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Mobile Number',
                    text: 'Please enter a valid 10-digit mobile number starting with 6-9.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1e3a8a'
                });
                return;
            }

            // Email validation
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email Address',
                    text: 'Please enter a valid email address.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1e3a8a'
                });
                return;
            }

            // Show confirmation dialog
            Swal.fire({
                title: 'Confirm Registration',
                html: `
                    <div class="text-left">
                        <p class="mb-4"><strong>Registration Fee: ₹300</strong></p>
                        <p class="mb-2">Please confirm your details:</p>
                        <ul class="text-sm space-y-1">
                            <li><strong>Team Member 1:</strong> ${document.getElementById('team_member_1').value}</li>
                            <li><strong>Team Member 2:</strong> ${document.getElementById('team_member_2').value}</li>
                            <li><strong>Team Member 3:</strong> ${document.getElementById('team_member_3').value}</li>
                            <li><strong>College:</strong> ${document.getElementById('college_name').value}</li>
                            <li><strong>Email:</strong> ${email}</li>
                            <li><strong>Mobile:</strong> ${mobile}</li>
                        </ul>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Proceed to Payment',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#6b7280',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we process your registration.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form
                    this.submit();
                }
            });
        });

        // Auto-format mobile number
        document.getElementById('mobile').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 10) value = value.slice(0, 10);
            e.target.value = value;
        });
    </script>
</body>

</html>