<?php
// 1. Process Logic FIRST
include '../database/connect.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
  die("Invalid request. Receipt ID is required.");
}

$id = intval($_GET['id']);
$session_student_id = $_SESSION['student_id'] ?? null;
$session_role_id = $_SESSION['role_id'] ?? null;

// Check if user is logged in
if (!$session_student_id && !$session_role_id) {
  die("Access denied. Please login first.");
}

// Fetch Payment and Student Details
// If student is logged in (not admin), we restrict query to their student_id
$sql = "
    SELECT p.*, s.application_id, s.surname, s.student_name, s.mobile, s.email,
           s.faculty_id, s.level_id,
           f.name as faculty_name, l.name as level_name, pr.name as program_name
    FROM tbl_gmap_payments p
    JOIN tbl_gmap_students s ON p.student_id = s.id
    LEFT JOIN tbl_faculty f ON s.faculty_id = f.id
    LEFT JOIN tbl_level l ON s.level_id = l.id
    LEFT JOIN tbl_program pr ON s.program_id = pr.id
    WHERE p.id = ? AND p.payment_status = 'success'
";

if ($session_student_id && !$session_role_id) {
  $sql .= " AND p.student_id = ?";
}

$query = $con->prepare($sql);

if ($session_student_id && !$session_role_id) {
  $query->bind_param("ii", $id, $session_student_id);
} else {
  $query->bind_param("i", $id);
}

$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
  die("Receipt not found, payment not confirmed, or unauthorized access.");
}

$data = $result->fetch_assoc();

// Helper function to convert numeric amount to words
function amountInWords($number)
{
  $decimal = round($number - ($no = floor($number)), 2) * 100;
  $hundred = null;
  $digits_length = strlen($no);
  $i = 0;
  $str = array();
  $words = array(
    0 => '',
    1 => 'one',
    2 => 'two',
    3 => 'three',
    4 => 'four',
    5 => 'five',
    6 => 'six',
    7 => 'seven',
    8 => 'eight',
    9 => 'nine',
    10 => 'ten',
    11 => 'eleven',
    12 => 'twelve',
    13 => 'thirteen',
    14 => 'fourteen',
    15 => 'fifteen',
    16 => 'sixteen',
    17 => 'seventeen',
    18 => 'eighteen',
    19 => 'nineteen',
    20 => 'twenty',
    30 => 'thirty',
    40 => 'forty',
    50 => 'fifty',
    60 => 'sixty',
    70 => 'seventy',
    80 => 'eighty',
    90 => 'ninety'
  );
  $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
  while ($i < $digits_length) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += $divider == 10 ? 1 : 2;
    if ($number) {
      $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
      $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
      $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
    } else
      $str[] = null;
  }
  $Rupees = implode('', array_reverse($str));
  $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
  return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

$amountInWords = ucwords(amountInWords($data['amount']));

// Determine College Name based on Faculty and Level
$faculty_id = $data['faculty_id'] ?? 0;
$level_id = $data['level_id'] ?? 0;

$college_mappings = [
  6 => "GYANMANJARI INSTITUTE OF ARTS",
  4 => "GYANMANJARI INSTITUTE OF COMMERCE",
  8 => "GYANMANJARI COLLEGE OF COMPUTER APPLICATION ICAT",
  2 => "GYANMANJARI PHARMACY COLLEGE",
  5 => "GYANMANJARI INSTITUTE OF MANAGEMENT STUDIES",
  3 => "GYANMANJARI SCIENCE COLLEGE",
  26 => "GYANMANJARI INSTITUTE OF LAW",
  9 => "GYANMANJARI INSTITUTE OF DESIGN",
];

if (isset($college_mappings[$faculty_id])) {
  $college_name = $college_mappings[$faculty_id];
} elseif ($faculty_id == 1) {
  if ($level_id == 5) {
    $college_name = "GYANMANJARI DIPLOMA ENGINEERING COLLEGE";
  } else {
    $college_name = "GYANMANJARI INSTITUTE OF TECHNOLOGY";
  }
} else {
  $college_name = $data['faculty_name'] ?? 'GYANMANJARI INSTITUTE';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Receipt - <?= htmlspecialchars($data['surname'] . ' ' . $data['student_name']) ?></title>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
      color: #000;
    }

    /* ================= RECEIPT CONTAINER ================= */
    .receipt-page {
      position: relative;
      width: 100%;
      max-width: 900px;
      margin: auto;
      background: #fff;
      border: 2px solid #000;
      padding: 20px;
    }

    /* ================= WATERMARK ================= */
    .watermark {
      position: absolute;
      top: 55%;
      left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.1;
      width: 400px;
      z-index: 0;
      pointer-events: none;
    }

    /* ================= HEADER SECTION FIX ================= */
    .top-section {
      display: flex;
      align-items: flex-start;
      /* Aligns items to the top */
      margin-bottom: 15px;
    }

    .logo-box {
      width: 80px;
      margin-right: 20px;
      /* Space between logo and text */
      flex-shrink: 0;
    }

    .logo-img {
      width: 100%;
      display: block;
    }

    .header-text {
      flex-grow: 1;
      text-align: left;
      /* Ensures text is left-aligned like the image */
      line-height: 1.2;
    }

    .line-managed {
      font-size: 13px;
      font-weight: normal;
      margin-bottom: 2px;
    }

    .college-name {
      font-size: 22px;
      font-weight: bold;
      margin: 2px 0;
      letter-spacing: 0.5px;
    }

    .contact-info {
      font-size: 13px;
      font-weight: normal;
      margin-top: 2px;
    }

    /* ================= RECEIPT BAR ================= */
    .receipt-bar {
      border-top: 2px solid #000;
      border-bottom: 2px solid #000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 4px 10px;
      font-weight: bold;
      font-size: 15px;
      margin-bottom: 10px;
    }

    .receipt-bar .center-title {
      font-size: 18px;
    }

    /* ================= DETAILS SECTION ================= */
    .details {
      font-size: 14px;
      line-height: 1.6;
      margin-bottom: 15px;
    }

    /* ================= TABLE ================= */
    .fee-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }

    .fee-table th,
    .fee-table td {
      border: 1.5px solid #000;
      padding: 6px 10px;
      font-size: 14px;
    }

    .fee-table th {
      background: #e9e9e9;
      text-align: center;
      text-transform: uppercase;
    }

    .fee-table td:last-child {
      text-align: right;
      width: 35%;
    }

    .total-row td {
      font-weight: bold;
      text-align: center !important;
    }

    .total-row2 td {

      text-align: center !important;
    }

    /* ================= FOOTER ================= */
    .payment-words {
      font-size: 13px;
      margin-bottom: 15px;
    }

    .footer-columns {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      margin-bottom: 20px;
    }

    .website-bar {
      background: #e5e5e5;
      text-align: center;
      padding: 6px;
      font-weight: bold;
      font-size: 14px;
      text-transform: uppercase;
    }

    /* ================= PRINT CONTROLS ================= */
    .controls {
      text-align: center;
      margin-top: 20px;
    }

    .print-btn {
      padding: 10px 25px;
      background: #333;
      color: #fff;
      border: none;
      cursor: pointer;
      font-weight: bold;
      border-radius: 4px;
    }

    @media print {
      body {
        background: none;
        padding: 0;
      }

      .controls {
        display: none;
      }

      .receipt-page {
        border: 2px solid #000;
        width: 100%;
        max-width: 100%;
      }

      .fee-table th,
      .website-bar {
        background-color: #e9e9e9 !important;
        -webkit-print-color-adjust: exact;
      }
    }
  </style>
</head>

<body>

  <div class="receipt-page">
    <!-- Watermark Logo -->
    <img src="https://admission.gmiu.edu.in/assets/home/images/logo-single.jpg" class="watermark" alt="Watermark">

    <div class="top-section">
      <div class="logo-box">
        <img src="https://admission.gmiu.edu.in/assets/home/images/logo-single.jpg" alt="Logo" class="logo-img" />
      </div>

      <div class="header-text">
        <div class="line-managed">MANAGED BY - CONSTITUTE COLLEGE OF GYANMANJARI INNOVATIVE UNIVERSITY</div>
        <div class="college-name"><?= htmlspecialchars($college_name) ?></div>
        <div class="contact-info">
          BHAVNAGAR - 364060<br>
          CONTACT: 0278-2567811<br>
          EMAIL: info@gmiu.edu.in
        </div>
      </div>
    </div>

    <div class="receipt-bar">
      <div>Receipt No - <?= str_pad($data['id'], 6, '0', STR_PAD_LEFT) ?></div>
      <div class="center-title">RECEIPT</div>
      <div>Date - <?= date('d-m-Y', strtotime($data['created_at'])) ?></div>
    </div>

    <div class="details">
      <div>GMAP Receipt (App ID: <?= htmlspecialchars($data['application_id'] ?? 'N/A') ?>)</div>
      <div>Name - <?= htmlspecialchars($data['surname'] . ' ' . $data['student_name']) ?></div>
      <div>Program - <?= htmlspecialchars($data['level_name'] . ' (' . $data['program_name'] . ')') ?></div>
    </div>

    <table class="fee-table">
      <thead>
        <tr>
          <th>PARTICULARS</th>
          <th>AMOUNT</th>
        </tr>
      </thead>
      <tbody>
        <tr class="total-row2">
          <td>Tution Fees</td>
          <td><?= number_format($data['amount'], 2) ?> ₹</td>
        </tr>
        <tr class="total-row">
          <td>TOTAL</td>
          <td><?= number_format($data['amount'], 2) ?> ₹</td>
        </tr>
      </tbody>
    </table>

    <div class="payment-words">
      <div><strong>In Words:</strong> <?= $amountInWords ?> Only.</div>
      <div><strong>Payment Mode:</strong> <?= htmlspecialchars(strtoupper($data['mode'] ?? 'Online')) ?></div>
      <div><strong>Transaction ID:</strong> <?= htmlspecialchars($data['transaction_id']) ?></div>
      <div><strong>Gateway ID:</strong> <?= htmlspecialchars($data['easepay_id'] ?? 'N/A') ?></div>

    </div>

    <div class="footer-columns">
      <div>
        <strong>Terms:</strong><br>
        Receipt valid subject to realization of cheque.
      </div>
      <div>
        <strong>Note:</strong><br>
        This is computer generated receipt. No need of signature.
      </div>
    </div>

    <div class="website-bar">
      WEBSITE - GMIU.EDU.IN
    </div>
  </div>

  <div class="controls">
    <button class="print-btn" onclick="window.print()">Print Receipt</button>
  </div>

</body>

</html>