<?php
// controllers/payment_failure.php - Handles failed payment response

session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/database.php';

// Log failed payment attempt
logActivity('payment_failure_page_accessed', '', 'User accessed payment failure page');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - GMIU Moot Court</title>
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

        .gmiu-navy {
            background-color: #1a2a47;
        }

        .gmiu-red {
            background-color: #b91c1c;
        }

        .text-gmiu-navy {
            color: #1a2a47;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen py-10 px-4">
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Payment Failed',
            html: `
                <div class="text-left">
                    <p class="mb-4">Your payment could not be processed. Please try again.</p>
                    <p class="text-sm text-gray-600 mb-3">Possible reasons:</p>
                    <ul class="text-sm text-gray-600 text-left max-w-md mx-auto space-y-1">
                        <li>• Insufficient funds</li>
                        <li>• Invalid card details</li>
                        <li>• Network issues</li>
                        <li>• Payment cancelled</li>
                    </ul>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Try Again',
            cancelButtonText: 'Contact Support',
            confirmButtonColor: '#1e3a8a',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to registration form
                window.location.href = '../index.php';
            } else {
                // Open email client
                window.location.href = 'mailto:<?php echo SUPPORT_EMAIL; ?>?subject=Payment%20Failure%20Support&body=Please%20help%20with%20my%20payment%20issue.';
            }
        });
    </script>
</body>

</html>