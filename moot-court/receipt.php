<?php
// receipt.php - Generates and displays payment receipt

session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/helpers/database.php';

// Prevent direct access without registration ID and token
if (!isset($_GET['reg_id']) || !is_numeric($_GET['reg_id']) || !isset($_GET['token']) || empty($_GET['token'])) {
    header("Location: index.php");
    exit;
}

$registration_id = (int) $_GET['reg_id'];
$receipt_token = trim($_GET['token']);

// Validate token format (64 character hex string)
if (!preg_match('/^[a-f0-9]{64}$/', $receipt_token)) {
    header("Location: index.php");
    exit;
}

// Fetch registration and transaction details
$db = getDB();
$stmt = mysqli_prepare($db, "
    SELECT r.*, t.transaction_id, t.easepay_id, t.payment_status, t.payment_amount, t.payment_method, t.payment_time
    FROM m_registrations r
    LEFT JOIN m_transactions t ON r.id = t.registration_id
    WHERE r.id = ? AND r.receipt_token = ?
    ORDER BY t.created_at DESC
    LIMIT 1
");
mysqli_stmt_bind_param($stmt, "is", $registration_id, $receipt_token);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$data) {
    header("Location: index.php");
    exit;
}

// Check if payment was successful
if ($data['payment_status'] !== 'SUCCESS') {
    header("Location: controllers/payment_failure.php");
    exit;
}

// Handle PDF download
if (isset($_GET['download']) && $_GET['download'] === 'pdf') {
    require_once __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php'; // TCPDF installed via Composer

    // Generate PDF receipt
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('GMIU Moot Court');
    $pdf->SetTitle('Payment Receipt - ' . $data['transaction_id']);

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(20, 20, 20);
    $pdf->SetAutoPageBreak(true, 20);

    // Add custom font for rupee symbol support
    $pdf->AddPage();

    // Set font for Unicode support (rupee symbol)
    $pdf->SetFont('dejavusans', '', 12); // Use DejaVu Sans which supports Unicode

    // Header Section
    $pdf->SetY(30);

    // Logo placeholder (since we can't embed images easily, use text)
    $pdf->SetFont('dejavusans', 'B', 18);
    $pdf->Cell(0, 15, 'GYANMANJARI INNOVATIVE UNIVERSITY', 0, 1, 'C');
    $pdf->SetFont('dejavusans', 'B', 16);
    $pdf->Cell(0, 12, 'Gyanmanjari Institute of Law', 0, 1, 'C');
    $pdf->SetFont('dejavusans', '', 12);
    $pdf->Cell(0, 10, 'Payment Receipt - Moot Court Competition', 0, 1, 'C');

    $pdf->Ln(15);

    // Receipt Information Section
    $pdf->SetFont('dejavusans', 'B', 14);
    $pdf->Cell(0, 10, 'Receipt Information', 0, 1, 'L');
    $pdf->SetFont('dejavusans', '', 11);

    $pdf->Cell(40, 8, 'Receipt No:', 0, 0);
    $pdf->Cell(0, 8, $data['transaction_id'], 0, 1);

    $pdf->Cell(40, 8, 'Date:', 0, 0);
    $pdf->Cell(0, 8, date('d-m-Y H:i:s', strtotime($data['payment_time'])), 0, 1);

    $pdf->Cell(40, 8, 'Status:', 0, 0);
    $pdf->SetFont('dejavusans', 'B', 11);
    $pdf->SetTextColor(0, 128, 0); // Green color
    $pdf->Cell(0, 8, 'PAID', 0, 1);
    $pdf->SetTextColor(0, 0, 0); // Reset to black
    $pdf->SetFont('dejavusans', '', 11);

    $pdf->Ln(10);

    // Team Details Section
    $pdf->SetFont('dejavusans', 'B', 14);
    $pdf->Cell(0, 10, 'Team Details', 0, 1, 'L');
    $pdf->SetFont('dejavusans', '', 11);

    $pdf->Cell(40, 8, 'College:', 0, 0);
    $pdf->Cell(0, 8, $data['college_name'], 0, 1);

    $pdf->Cell(40, 8, 'Email:', 0, 0);
    $pdf->Cell(0, 8, $data['email'], 0, 1);

    $pdf->Cell(40, 8, 'Sr. Advocate:', 0, 0);
    $pdf->Cell(0, 8, $data['team_member_1'], 0, 1);

    $pdf->Cell(40, 8, 'Jr. Advocate:', 0, 0);
    $pdf->Cell(0, 8, $data['team_member_2'], 0, 1);

    $pdf->Cell(40, 8, 'Researcher:', 0, 0);
    $pdf->Cell(0, 8, $data['team_member_3'], 0, 1);

    $pdf->Cell(40, 8, 'Side:', 0, 0);
    $pdf->Cell(0, 8, ucfirst($data['side']), 0, 1);

    $pdf->Ln(15);

    // Payment Details Section (Box style like HTML)
    $pdf->SetFillColor(245, 245, 245); // Light gray background
    $pdf->Rect(20, $pdf->GetY(), 170, 35, 'F'); // Draw filled rectangle

    $pdf->SetFont('dejavusans', 'B', 14);
    $pdf->Cell(0, 12, 'Payment Details', 0, 1, 'L');

    // Amount Paid (centered in its section)
    $pdf->SetFont('dejavusans', 'B', 20);
    $pdf->SetTextColor(26, 42, 71); // Navy color
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->SetXY(25, $y); // Position for amount
    $pdf->Cell(35, 10, '₹' . $data['payment_amount'], 0, 0, 'C');
    $pdf->SetXY(25, $y + 10);
    $pdf->SetFont('dejavusans', '', 8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35, 6, 'Amount Paid', 0, 0, 'C');

    // Payment Method
    $pdf->SetXY(65, $y);
    $pdf->SetFont('dejavusans', '', 10);
    $pdf->Cell(35, 8, $data['payment_method'], 0, 0, 'C');
    $pdf->SetXY(65, $y + 8);
    $pdf->SetFont('dejavusans', '', 8);
    $pdf->Cell(35, 6, 'Payment Method', 0, 0, 'C');

    // Transaction ID
    $pdf->SetXY(105, $y);
    $pdf->SetFont('dejavusans', '', 9);
    $pdf->Cell(35, 8, $data['transaction_id'], 0, 0, 'C');
    $pdf->SetXY(105, $y + 8);
    $pdf->SetFont('dejavusans', '', 8);
    $pdf->Cell(35, 6, 'Transaction ID', 0, 0, 'C');

    // Easepay ID
    $pdf->SetXY(145, $y);
    $pdf->SetFont('dejavusans', '', 9);
    $pdf->Cell(35, 8, $data['easepay_id'] ?? 'N/A', 0, 0, 'C');
    $pdf->SetXY(145, $y + 8);
    $pdf->SetFont('dejavusans', '', 8);
    $pdf->Cell(35, 6, 'Easepay ID', 0, 0, 'C');

    // Output the PDF
    $pdf->Output('Payment_Receipt_' . $data['transaction_id'] . '.pdf', 'D');
    exit;
}

// Display HTML receipt
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - GMIU Moot Court</title>
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

        .gmiu-navy {
            background-color: #1a2a47;
        }

        .gmiu-red {
            background-color: #b91c1c;
        }

        .text-gmiu-navy {
            color: #1a2a47;
        }

        .bg-gmiu-navy {
            background-color: #1a2a47;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                min-height: auto !important;
            }

            body.bg-gray-100 {
                background: white !important;
            }

            @page {
                margin: 1cm !important;
                size: A4;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden border-t-8 border-gmiu-red">
        <div class="p-8 md:p-12">
            <!-- Header -->
            <div class="text-center mb-8">
                <img src="<?php echo BASE_DOMAIN; ?>/gmiu/website_assets/images/logo-single.jpg" alt="GMIU Logo"
                    class="h-20 w-auto mx-auto mb-4">
                <h1 class="text-3xl font-bold text-gmiu-navy uppercase">Gyanmanjari Innovative University</h1>
                <h2 class="text-xl font-semibold text-red-700 mt-1">Gyanmanjari Institute of Law</h2>
                <p class="text-gray-500 font-legal tracking-widest text-sm mt-2">Payment Receipt - Moot Court
                    Competition</p>
            </div>

            <!-- Receipt Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gmiu-navy mb-4">Receipt Information</h3>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Receipt No:</span>
                            <?php echo htmlspecialchars($data['transaction_id']); ?></p>
                        <p><span class="font-semibold">Date:</span>
                            <?php echo date('d-m-Y H:i:s', strtotime($data['payment_time'])); ?></p>
                        <p><span class="font-semibold">Status:</span> <span class="text-green-600 font-bold">PAID</span>
                        </p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gmiu-navy mb-4">Team Details</h3>
                    <div class="space-y-2">
                        <p><span class="font-semibold">College:</span>
                            <?php echo htmlspecialchars($data['college_name']); ?></p>
                        <p><span class="font-semibold">Email:</span>
                            <?php echo htmlspecialchars($data['email']); ?></p>
                        <p><span class="font-semibold">Sr. Advocate:</span>
                            <?php echo htmlspecialchars($data['team_member_1']); ?></p>
                        <p><span class="font-semibold">Jr. Advocate:</span>
                            <?php echo htmlspecialchars($data['team_member_2']); ?></p>
                        <p><span class="font-semibold">Researcher:</span>
                            <?php echo htmlspecialchars($data['team_member_3']); ?></p>
                        <p><span class="font-semibold">Side:</span>
                            <?php echo ucfirst(htmlspecialchars($data['side'])); ?></p>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <h3 class="text-lg font-bold text-gmiu-navy mb-4">Payment Details</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gmiu-navy">
                            ₹<?php echo htmlspecialchars($data['payment_amount']); ?></p>
                        <p class="text-sm text-gray-600">Amount Paid</p>
                    </div>
                    <div class="text-center">
                        <p class="text-lg font-semibold text-gray-700">
                            <?php echo htmlspecialchars($data['payment_method']); ?>
                        </p>
                        <p class="text-sm text-gray-600">Payment Method</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-mono text-gray-700">
                            <?php echo htmlspecialchars($data['transaction_id']); ?>
                        </p>
                        <p class="text-sm text-gray-600">Transaction ID</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-mono text-gray-700">
                            <?php echo htmlspecialchars($data['easepay_id'] ?? 'N/A'); ?>
                        </p>
                        <p class="text-sm text-gray-600">Easepay ID</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 no-print">
                <button onclick="window.print()"
                    class="gmiu-navy hover:bg-slate-800 text-white font-bold py-3 px-6 rounded shadow-lg transition-transform active:scale-95 uppercase tracking-widest">
                    Print Receipt
                </button>
                <a href="?reg_id=<?php echo $registration_id; ?>&token=<?php echo $receipt_token; ?>&download=pdf"
                    class="border border-gmiu-navy text-gmiu-navy font-bold py-3 px-6 rounded shadow-lg transition-transform active:scale-95 uppercase tracking-widest text-center">
                    Download PDF
                </a>
                <a href="index.php"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded shadow-lg transition-transform active:scale-95 uppercase tracking-widest text-center">
                    Register Another Team
                </a>
            </div>

            <!-- Footer Note -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>This is a computer generated receipt. No signature required.</p>
                <p>For any queries, contact: <?php echo CONTACT_EMAIL; ?></p>
            </div>
        </div>

        <div class="gmiu-navy p-4 text-center">
            <p class="text-white text-[10px] uppercase tracking-widest opacity-80">© 2026 Gyanmanjari Institute of Law |
                All Rights Reserved</p>
        </div>
    </div>

    <script>
        // Show success message on page load
        <?php if (isset($_SESSION['payment_success']) && $_SESSION['payment_success']): ?>
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                text: '<?php echo addslashes($_SESSION['success_message'] ?? 'Your registration has been confirmed.'); ?>',
                confirmButtonText: 'View Receipt',
                confirmButtonColor: '#1e3a8a',
                timer: 3000,
                timerProgressBar: true
            });
            <?php
            // Clear the session variables after showing
            unset($_SESSION['payment_success']);
            unset($_SESSION['success_message']);
            ?>
        <?php endif; ?>

        // Add confirmation for PDF download
        document.querySelectorAll('a[href*="download=pdf"]').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const href = this.href;

                Swal.fire({
                    title: 'Download Receipt',
                    text: 'Do you want to download the PDF receipt?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Download',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#1e3a8a',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
</body>

</html>