<?php
include('include/config.php');

$formData      = null;
$form_id       = 0;
$error_message = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $form_id = (int) $_GET['id'];

    $sql  = "SELECT t.*, f.name as faculty_name, l.name as level_name, p.name as program_name 
             FROM tbl_tada_form_data t
             LEFT JOIN tbl_faculty f ON t.faculty_id = f.id
             LEFT JOIN tbl_level l ON t.level_id = l.id
             LEFT JOIN tbl_program p ON t.program_id = p.id
             WHERE t.id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $travelSql  = "SELECT journey_date, journey_from, journey_to, mode_of_journey,
                          fare_paid, distance_km, class_of_travel
                   FROM tbl_tada_form_travelling_allowance WHERE tada_form_id = ?";
    $travelStmt = $con->prepare($travelSql);
    $travelStmt->bind_param("i", $form_id);
    $travelStmt->execute();
    $travelResult = $travelStmt->get_result();

    $travelRows = [];
    while ($row = $travelResult->fetch_assoc()) {
        $travelRows[] = $row;
    }

    if ($result->num_rows > 0) {
        $formData = $result->fetch_assoc();
    } else {
        $error_message = "Error: TADA Form ID $form_id not found.";
    }
} else {
    $error_message = "Error: Invalid or missing form ID in the URL.";
}

function output_data($d) { return htmlspecialchars(strtoupper($d ?? '')); }

function pcv($val, $is_amount = false) {
    if ($is_amount) return $val > 0 ? number_format((float)$val, 2) : '';
    if (empty($val) || $val === '0000-00-00' || $val === '0' || $val === 0) return '';
    return htmlspecialchars($val);
}

function fmt_amt($val) {
    return (float)$val > 0 ? number_format((float)$val, 2) : '';
}


function numberToWords($number) {
    if ($number == 0) return "Zero";
    $hyphen      = '-'; $conjunction = ' and '; $separator   = ', '; $negative    = 'negative '; $decimal     = ' point ';
    $dictionary  = array(0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety', 100 => 'hundred', 1000 => 'thousand', 100000 => 'lakh', 10000000 => 'crore');
    if (!is_numeric($number)) return false;
    if ($number < 0) return $negative . numberToWords(abs($number));
    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    switch (true) {
        case $number < 21: $string = $dictionary[$number]; break;
        case $number < 100: $tens   = ((int) ($number / 10)) * 10; $units  = $number % 10; $string = $dictionary[$tens]; if ($units) { $string .= $hyphen . $dictionary[$units]; } break;
        case $number < 1000: $hundreds  = $number / 100; $remainder = $number % 100; $string = $dictionary[$hundreds] . ' ' . $dictionary[100]; if ($remainder) { $string .= $conjunction . numberToWords($remainder); } break;
        case $number < 100000: $thousands   = (int)($number / 1000); $remainder = $number % 1000; $string = numberToWords($thousands) . ' ' . $dictionary[1000]; if ($remainder) { $string .= $separator . numberToWords($remainder); } break;
        case $number < 10000000: $lakhs = (int)($number / 100000); $remainder = $number % 100000; $string = numberToWords($lakhs) . ' ' . $dictionary[100000]; if ($remainder) { $string .= $separator . numberToWords($remainder); } break;
        default: $crores = (int)($number / 10000000); $remainder = $number % 10000000; $string = numberToWords($crores) . ' ' . $dictionary[10000000]; if ($remainder) { $string .= $separator . numberToWords($remainder); } break;
    }
    return strtoupper($string);
}

$dp = $formData ? explode('-', $formData['form_date']) : ['', '', ''];
$dd = $dp[2] ?? '___'; $dm = $dp[1] ?? '___';
$dy = substr($dp[0] ?? '20__', 2, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TADA – Reimbursement Form</title>
<link rel="icon" type="image/png" href="src/images/fav/favicon-32x32.png">
<style>
/* ====================================================
   RESET
   ==================================================== */
*, *::before, *::after { box-sizing: border-box; margin:0; padding:0; }

/* ====================================================
   BASE – same for screen & print
   ==================================================== */
body { font-family: 'Times New Roman', Times, serif; font-size: 9.5pt; color: #000; background: #c1c1c1; }

/* A4 container */
.a4 {
    width: 210mm;
    min-height: 297mm;
    margin: 16px auto;
    padding: 9mm 11mm;
    background: #fff;
    border: 1px solid #aaa;
    box-shadow: 0 4px 18px rgba(0,0,0,.22);
    display: flex;
    flex-direction: column;
}


/* ====================================================
   HEADER
   ==================================================== */
.hdr {
    text-align:center;
    border-bottom: 2px solid #000;
    padding-bottom: 5px;
}
.hdr h3 { font-size:14pt; text-transform:uppercase; margin-bottom:2px; }
.hdr p  { font-size:10pt; font-weight:bold; }

/* ====================================================
   DETAILS TABLE
   ==================================================== */
.det-tbl {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #000;
}
.det-tbl td { border: 1px solid #000; padding: 5px 8px; font-size: 10pt; vertical-align: middle; }
.det-tbl .lbl { font-weight: bold; text-transform: uppercase; font-size: 9.5pt; }
.det-tbl .val { text-transform: uppercase; font-weight: bold; font-size: 10.5pt; }

/* ====================================================
   TRAVELLING ALLOWANCE TABLE
   ==================================================== */
.ta-tbl { width:100%; border-collapse:collapse; table-layout: fixed; }
.ta-tbl th {
    border: 1px solid #000;
    padding: 5px 2px; font-size: 9pt; text-align:center; font-weight:bold;
}
.ta-tbl td {
    border: 1px solid #000;
    padding: 4px 3px; font-size: 10pt; text-align:center;
    text-transform: uppercase;
    font-weight: bold;
    word-break: break-word;
    white-space: normal;
}

/* ====================================================
   SUMMARY / ALLOWANCE TABLES
   ==================================================== */
.sum-tbl { width:100%; border-collapse:collapse; margin-top:-1px; }
.sum-tbl td { border:1px solid #000; padding:5px 8px; font-size:10pt; }
.sum-tbl .lbl { font-weight: bold; }
.sum-tbl .val { font-weight: bold; text-align:center; }

/* ====================================================
   CERTIFICATION BOX
   ==================================================== */
.box {
    border:1px solid #000;
    padding:6px 10px;
    font-size: 9pt;
    margin-top:-1px;
}
.cbrow { margin-bottom:3px; line-height:1.4; }

/* Underlines */
.u {
    display:inline-block; border-bottom:1px solid #000;
    min-width:60px; text-transform: uppercase; font-weight:bold; text-align:center;
}
.u-text { display:inline; border-bottom:1px solid #000; text-transform:uppercase; font-weight:bold; }

/* Signatures */
.sign-area { margin-top:15px; width:100%; }
.sign-box { width:220px; text-align:center; }
.sign-line { border-top:1.5px solid #000; margin-top:35px; padding-top:4px; font-weight:bold; }

/* ====================================================
   PRINT BUTTON
   ==================================================== */
.no-print { text-align:center; margin:24px 0 12px; }

@page { size: A4 portrait; margin: 0; }
@media print {
    body { background: none !important; }
    .no-print { display: none !important; }
    .a4 {
        width: 100%;
        height: 282mm; /* Reduced from 287mm to ensure bottom margin show */
        margin: 0;
        padding: 5mm 10mm;
        border: none;
        box-shadow: none;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 0;
    }
}
</style>
</head>
<body>

<?php if ($formData): ?>
<div class="a4">

    <!-- ============ HEADER ============ -->
    <div class="hdr">
        <h3>Gyanmanjari Innovative University</h3>
        <p>BILL FOR REIMBURSEMENT OF TRAVELLING ALLOWANCE &amp; D.A./ HONORARIUM / ACCOMODATION</p>
    </div>

    <!-- ============ PERSONAL INFO ============ -->
    <table class="det-tbl">
        <tr>
            <td colspan="5" class="lbl" style="border-bottom:none;">FULL NAME: <span class="val"><?= output_data($formData['full_name']) ?></span></td>
            <td class="lbl" style="border-left:none; border-bottom:none; text-align:right; width:180px;">DATE: <span class="val"><?= "$dd / $dm / $dy" ?></span></td>
        </tr>
        <tr>
            <td colspan="6" class="lbl">DESIGNATION: <span class="val"><?= output_data($formData['designation']) ?></span></td>
        </tr>
        <tr>
            <td colspan="6" class="lbl">NAME OF INSTITUTE &amp; ADDRESS: <span class="val"><?= output_data($formData['institute_name']) ?><?php if ($formData['institute_address']): ?> (<?= output_data($formData['institute_address']) ?>)<?php endif; ?></span></td>
        </tr>
        <tr>
            <td colspan="3" class="lbl">PHON NO : <span class="val"><?= output_data($formData['phone_no']) ?></span></td>
            <td colspan="3" class="lbl">EMAIL ID: <span class="val"><?= output_data($formData['email_id']) ?></span></td>
        </tr>

        <tr>
            <td colspan="3" class="lbl">Branch: <span class="val"><?= output_data($formData['program_name'] ?: $formData['branch']) ?></span></td>
            <td colspan="3" class="lbl">Semester: <span class="val"><?= output_data($formData['semester'] ? "Sem ".$formData['semester'] : '') ?></span></td>
        </tr>
        <tr>
            <td colspan="3" class="lbl">Subject Code: <span class="val"><?= output_data($formData['subject_code']) ?></span></td>
            <td colspan="3" class="lbl">Subject: <span class="val"><?= str_replace(',', ', ', output_data($formData['subject_name'])) ?></span></td>
        </tr>

    </table>

    <table class="ta-tbl" style="border-top: none; margin-top: -1px;">
        <thead>
            <tr>
                <th colspan="7" style="text-align: left; padding: 2px 8px; font-size: 9.5pt; background: #fff;">(A) T. A.:</th>
            </tr>
            <tr>
                <th style="width:14%;">Date of journey</th>
                <th style="width:16%;">From</th>
                <th style="width:16%;">To</th>
                <th style="width:12%;">Distance kilometer</th>
                <th style="width:20%;">Mode of journey (Bus, Car, Rail, Air)</th>
                <th style="width:10%;">Class</th>
                <th style="width:12%;">Fare paid</th>
            </tr>
        </thead>
        <tbody>
            <?php $tTotal = 0; foreach ($travelRows as $tr): $tTotal += $tr['fare_paid']; ?>
            <tr>
                <td><?= pcv($tr['journey_date']) ?></td>
                <td><?= pcv($tr['journey_from']) ?></td>
                <td><?= pcv($tr['journey_to']) ?></td>
                <td><?= pcv($tr['distance_km']) ?></td>
                <td><?= pcv($tr['mode_of_journey']) ?></td>
                <td><?= pcv($tr['class_of_travel']) ?></td>
                <td><?= pcv($tr['fare_paid']) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="6" style="text-align:right; font-weight:bold; background:#f9f9f9;">Total Rs. (A)</td>
                <td style="background:#f9f9f9; font-weight:bold;"><?= number_format($tTotal, 2) ?></td>
            </tr>
        </tbody>
    </table>

    <!-- ============ (B)(C)(D) ============ -->
    <table class="sum-tbl">
        <tr>
            <td class="lbl" style="width:50%;">(B) D.A.: (If applicable)</td>
            <td style="width:15%; text-align:center;"><?php if($formData['da_no_of_days'] > 0): ?>No. of days: <span class="val"><?= pcv($formData['da_no_of_days']) ?></span><?php endif; ?></td>
            <td style="width:15%; text-align:center;"><?php if($formData['da_rate_per_day'] > 0): ?>Rate/ Day: <span class="val"><?= pcv($formData['da_rate_per_day']) ?></span><?php endif; ?></td>
            <td style="width:20%; text-align:right;"><?php if($formData['total_da_amount_b'] > 0): ?>Total Rs. <span class="val"><?= fmt_amt($formData['total_da_amount_b']) ?></span><?php endif; ?></td>
        </tr>
        <tr>
            <td class="lbl">(C) Honorarium:</td>
            <td style="text-align:center;"><?php if($formData['honorarium_no_of_days'] > 0): ?>No. of days: <span class="val"><?= pcv($formData['honorarium_no_of_days']) ?></span><?php endif; ?></td>
            <td style="text-align:center;"><?php if($formData['honorarium_rate_per_day'] > 0): ?>Rate/ Day: <span class="val"><?= pcv($formData['honorarium_rate_per_day']) ?></span><?php endif; ?></td>
            <td style="text-align:right;"><?php if($formData['total_honorarium_amount_c'] > 0): ?>Total Rs. <span class="val"><?= fmt_amt($formData['total_honorarium_amount_c']) ?></span><?php endif; ?></td>
        </tr>
        <tr>
            <td class="lbl">(D) Accommodation: (If applicable)</td>
            <td style="text-align:center;"><?php if($formData['accommodation_no_of_days'] > 0): ?>No. of days: <span class="val"><?= pcv($formData['accommodation_no_of_days']) ?></span><?php endif; ?></td>
            <td style="text-align:center;"><?php if($formData['accommodation_rate_per_day'] > 0): ?>Rate/ Day: <span class="val"><?= pcv($formData['accommodation_rate_per_day']) ?></span><?php endif; ?></td>
            <td style="text-align:right;"><?php if($formData['total_accommodation_amount_d'] > 0): ?>Total Rs. <span class="val"><?= fmt_amt($formData['total_accommodation_amount_d']) ?></span><?php endif; ?></td>
        </tr>


        <tr style="background:#f9f9f9; font-weight:bold;">
            <td colspan="3" style="text-align:right;">Gross Total Rs.: (A)+(B)+ (C) +(D)</td>
            <td style="text-align:right;"><?= number_format($formData['gross_total_amount'], 2) ?></td>
        </tr>

    </table>

    <!-- ============ CERTIFICATION ============ -->
    <div class="box">
        <div style="font-weight:bold; margin-bottom:2px;">This is to Certify that: -</div>
        <div class="cbrow">I have travelled by Railway <span class="u" style="min-width:100px;"><?php 
            $railClass = [];
            foreach($travelRows as $tr){
                if(in_array($tr['mode_of_journey'], ['Train','Bus']) && !empty($tr['class_of_travel'])){
                    $railClass[] = $tr['class_of_travel'];
                }
            }
            echo implode(' / ', array_unique($railClass));
        ?></span> class/ Bus-Luxury/ordinary. (Attach copy of Rail Ticket if travelled by AC &amp; upper class or Luxury Bus.)</div>
        <div class="cbrow">I have travelled by Air &amp; the air fare claimed is limited to Economic class air fare. (Please attach copy of air ticket &amp; boarding pass)</div>
        <?php
            $travelledByCar = false;
            foreach($travelRows as $tr){
                if(in_array($tr['mode_of_journey'], ['Car','Taxi','Scooter/Motorcycle'])){
                    $travelledByCar = true; break;
                }
            }
        ?>
        <div class="cbrow">I have travelled by my own car with vehicle No. <span class="u" style="min-width:120px;"><?= output_data($formData['vehicle_no']) ?></span> &amp; it is &nbsp;
            <span style="border:1px solid #000; padding:0 3px;">&nbsp;<?php if($travelledByCar && $formData['fuel_type']=='Petrol') echo '✔'; else echo '&nbsp;'; ?></span> Petrol &nbsp;
            <span style="border:1px solid #000; padding:0 3px;">&nbsp;<?php if($travelledByCar && $formData['fuel_type']=='CNG') echo '✔'; else echo '&nbsp;'; ?></span> CNG &nbsp;
            <span style="border:1px solid #000; padding:0 3px;">&nbsp;<?php if($travelledByCar && $formData['fuel_type']=='Diesel') echo '✔'; else echo '&nbsp;'; ?></span> Diesel vehicle (Attach Copy of R/C book.)
        </div>
        <div class="cbrow">I confirm that this amount is not claimed elsewhere and if it is found at any stage that above claim/part of the claim paid/received to me due to either side by mistake; I undertake to refund same to the University.</div>
    </div>

    <!-- ============ DECLARATION ============ -->
    <div class="box" style="padding:4px 8px;">
        <div style="font-weight:bold; font-size:8.5pt; margin-bottom:5px;">I HEREBY DECLARE THAT THE FACTS/DETAILS PROVIDED ABOVE BY ME ARE TRUE AND CORRECT.</div>
        <div style="display:flex; justify-content:flex-end; margin-bottom:8px;">
            <div class="sign-box">
                <div>Signature: ________________</div>
                <div style="margin-top:2px;">Name: <span class="u" style="min-width:140px;"><?= output_data($formData['full_name']) ?></span></div>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:5px; margin-bottom:10px;">
            Passed for payment Total Rs <span class="u" style="min-width:55px;"><?= pcv($formData['gross_total_amount']) ?></span> (Rupees in words <span class="u-text"><?= numberToWords($formData['gross_total_amount'] ?? 0) ?></span> only).
        </div>
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-top: 10px;">
            <div style="font-weight:bold; padding-top:40px;">HOD</div>
            <div style="font-weight:bold; text-align:center; padding-top:40px;">
                Controller of Examination
            </div>
        </div>
    </div>

    <!-- ============ RECEIPT ============ -->
    <div class="box" style="padding:5px 8px; border-bottom:1.5px solid #000;">
        <div style="text-align:center; font-weight:bold; font-size:10pt; text-decoration:underline; margin-bottom:4px;">RECEIPT</div>
        <div style="margin-bottom:5px;">
            Received Rs. <span class="u" style="min-width:90px;"><?= pcv($formData['gross_total_amount']) ?></span> (Rupees in words <span class="u-text"><?= numberToWords($formData['gross_total_amount'] ?? 0) ?></span> only)
        </div>
        <div style="margin-bottom:6px;">
            From Registrar, Gyanmanjari Innovative University, Bhavnagar towards TA and DA/Honorarium etc.
        </div>
        <div style="text-align:center; font-weight:bold; font-size:8.5pt; text-decoration:underline; margin-bottom:6px;">
            Bank information of receiver for electronic fund transfer (attach copy of cancelled cheque)
        </div>
        <div style="line-height:1.7; font-size:9pt; text-align:justify;">
            <span style="font-weight:bold;">Bank Name:</span> <span class="u" style="min-width:180px;"><?= output_data($formData['bank_name']) ?></span> &nbsp;&nbsp;
            <span style="font-weight:bold;">Branch &amp; Branch Code:</span> <span class="u" style="min-width:150px;"><?= output_data($formData['bank_branch']) ?></span> &nbsp;&nbsp;
            <span style="font-weight:bold;">A/C Type (SB/CB):</span> <span class="u" style="min-width:100px;"><?= output_data($formData['bank_acc_type']) ?></span> &nbsp;&nbsp;
            <span style="font-weight:bold;">A/c No.(Full digits):</span> <span class="u" style="min-width:160px;"><?= output_data($formData['account_no']) ?></span> &nbsp;&nbsp;
            <span style="font-weight:bold;">IFSC Code:</span> <span class="u" style="min-width:140px;"><?= output_data($formData['ifsc_code']) ?></span>
        </div>

        <div style="margin-bottom:4px;">The above information provided by me is correct.</div>
        <div style="display:flex; justify-content:flex-end;">
            <div class="sign-box">
                <div>Signature: ________________</div>
                <div style="margin-top:2px;">Name: <span class="u" style="min-width:140px;"><?= output_data($formData['full_name']) ?></span></div>
            </div>
        </div>
    </div>

    <!-- ============ EXAMINERS ============ -->
    <div style="margin-top:5px;">
        <table style="width:100%; border:1px solid #000; border-collapse:collapse;">
            <tr><td style="padding:4px 6px; border:1px solid #000;">Name of Internal Examiner: <span class="val"><?= output_data($formData['internal_examiner_name']) ?></span></td></tr>
            <tr><td style="padding:4px 6px; border:1px solid #000;">Name of Lab assistant (If applicable): <span class="val"><?= output_data($formData['lab_examiner_name']) ?></span></td></tr>
        </table>
    </div>

</div>

<div class="no-print">
    <button onclick="window.print()">🖨&nbsp; Print TADA Form</button>
</div>

<?php else: ?>
<div style="max-width:600px; margin:40px auto; background:#fff; padding:20px; border:1px solid #ccc;">
    <h4 style="color:red;">Form Error</h4>
    <p><?= htmlspecialchars($error_message) ?></p>
</div>
<?php endif; ?>

</body>
</html>