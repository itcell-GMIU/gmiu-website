<?php
include('../include/config.php');

// Security Check: Only ADMIN and SUPER ADMIN can export data
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] == 3) {
    die("Unauthorized Access");
}

$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

// Validating dates to ensure they aren't empty for the title
$date_string = "";
if (!empty($from_date) && !empty($to_date)) {
    $date_string = date('d/m/Y', strtotime($from_date)) . " to " . date('d/m/Y', strtotime($to_date));
    $filename = "Practical_Exam_Bill_" . $from_date . "_to_" . $to_date . ".xls";
} else {
    $date_string = "All Dates";
    $filename = "Practical_Exam_Bill_" . date('Y-m-d_H-i-s') . ".xls";
}

$where_clause = "WHERE is_active = 1 AND is_delete = 0";
if (!empty($from_date) && !empty($to_date)) {
    $where_clause .= " AND form_date BETWEEN '$from_date' AND '$to_date'";
}

$sql = "SELECT id, full_name, form_date, subject_code, subject_name, duty_type, phone_no, 
        gross_total_amount, total_da_amount_b, total_honorarium_amount_c, total_accommodation_amount_d
        FROM tbl_tada_form_data 
        $where_clause
        ORDER BY id ASC";
$result = $con->query($sql);

$dutyInternalList = ["Center-in-charge", "Squad Member / Sr Supervisor", "Jr. Supervisor", "Assessment (100 marks)", "Assessment (50 marks)", "OMR sheet Assessment", "Internal Examiner (Practical/Viva)", "Internal Examiner (PG Dissertation)", "Supervisor (Ph.D. Review)"];
$dutyExternalList = ["Manuscript (Diploma & UG)", "Manuscript (PG & Ph.D)", "External Examiner (Practical/Viva)", "External Examiner (PG Dissertation)", "External Expert (Ph.D. Review)", "Thesis Evaluator (National)", "Thesis Evaluator (International)"];
$dutyLabList = ["Lab supportive staff (Practical/Viva)"];

$data = [
    'EXTERNAL EXAMINER' => [],
    'INTERNAL EXAMINER' => [],
    'LAB ASSISTANT' => []
];

// Helper to determine group
function getGroup($dutyType, $extList, $intList, $labList) {
    if (in_array($dutyType, $extList)) return 'EXTERNAL EXAMINER';
    if (in_array($dutyType, $intList)) return 'INTERNAL EXAMINER';
    if (in_array($dutyType, $labList)) return 'LAB ASSISTANT';
    // Fallback based on text match if missing from lists
    if (stripos($dutyType, 'external') !== false) return 'EXTERNAL EXAMINER';
    if (stripos($dutyType, 'internal') !== false || stripos($dutyType, 'assessment') !== false || stripos($dutyType, 'squad') !== false || stripos($dutyType, 'supervisor') !== false || stripos($dutyType, 'center-in') !== false) return 'INTERNAL EXAMINER';
    if (stripos($dutyType, 'lab ') !== false) return 'LAB ASSISTANT';
    return 'EXTERNAL EXAMINER'; // Default fallback
}

$totals = [
    'EXTERNAL EXAMINER' => 0,
    'INTERNAL EXAMINER' => 0,
    'LAB ASSISTANT' => 0
];

$grandSums = [
    'ta' => 0,
    'da' => 0,
    'honorarium' => 0,
    'accommodation' => 0
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $group = getGroup($row['duty_type'], $dutyExternalList, $dutyInternalList, $dutyLabList);
        
        $ta = floatval($row['gross_total_amount']) - (floatval($row['total_da_amount_b']) + floatval($row['total_honorarium_amount_c']) + floatval($row['total_accommodation_amount_d']));
        if ($ta < 0) $ta = 0; // sanity check

        $f_date = (!empty($row['form_date']) && $row['form_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($row['form_date'])) : '';

        $data[$group][] = [
            'date' => $f_date,
            'subject_code' => $row['subject_code'],
            'subject_name' => $row['subject_name'],
            'name' => $row['full_name'],
            'ta' => $ta,
            'da' => $row['total_da_amount_b'],
            'honorarium' => $row['total_honorarium_amount_c'],
            'accommodation' => $row['total_accommodation_amount_d'],
            'total' => $row['gross_total_amount'],
            'contact' => $row['phone_no']
        ];
        
        $totals[$group] += floatval($row['gross_total_amount']);
        $grandSums['ta'] += $ta;
        $grandSums['da'] += floatval($row['total_da_amount_b']);
        $grandSums['honorarium'] += floatval($row['total_honorarium_amount_c']);
        $grandSums['accommodation'] += floatval($row['total_accommodation_amount_d']);
    }
}

// Content Type declaration to export to CSV
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=\"" . str_replace('.xls', '.csv', $filename) . "\"");
header("Pragma: no-cache");
header("Expires: 0");

$grandTotal = $totals['EXTERNAL EXAMINER'] + $totals['INTERNAL EXAMINER'] + $totals['LAB ASSISTANT'];

// Content Type for XML Spreadsheet
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

$grandTotal = $totals['EXTERNAL EXAMINER'] + $totals['INTERNAL EXAMINER'] + $totals['LAB ASSISTANT'];

echo '<?xml version="1.0"?>' . "\n";
echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Center" ss:Horizontal="Center"/>
   <Borders/>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="sTitle1">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="16" ss:Bold="1"/>
   <Interior ss:Color="#F8F9FA" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sTitle2">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="14" ss:Bold="1"/>
   <Interior ss:Color="#EFF6FF" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sTitle3">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="12" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sHeader">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sHeaderRight">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sHeaderGray">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11" ss:Bold="1"/>
   <Interior ss:Color="#F8F9FA" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sDataCenter">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
  </Style>
  <Style ss:ID="sDataLeft">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
  </Style>
  <Style ss:ID="sDataBold">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sSummaryLeft">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sSummaryCenter">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sSignature">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="12"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Practical Exam Bill">
  <Table>
   <!-- Columns widths -->
   <Column ss:Width="40"/>
   <Column ss:Width="130"/>
   <Column ss:Width="80"/>
   <Column ss:Width="90"/>
   <Column ss:Width="150"/>
   <Column ss:Width="130"/>
   <Column ss:Width="70"/>
   <Column ss:Width="70"/>
   <Column ss:Width="80"/>
   <Column ss:Width="80"/>
   <Column ss:Width="80"/>
   <Column ss:Width="90"/>

   <!-- Title Rows -->
   <Row ss:Height="25">
    <Cell ss:MergeAcross="11" ss:StyleID="sTitle1"><Data ss:Type="String">GYANAMNAJARI INNOVATIVE UNIVERSITY</Data></Cell>
   </Row>
   <Row ss:Height="20">
    <Cell ss:MergeAcross="11" ss:StyleID="sTitle2"><Data ss:Type="String">PRACTICAL EXAM BILL SUMMER <?= date('Y') ?></Data></Cell>
   </Row>
   <Row ss:Height="18">
    <Cell ss:MergeAcross="11" ss:StyleID="sTitle3"><Data ss:Type="String">Examination Date:- <?= $date_string ?></Data></Cell>
   </Row>
   
   <!-- Header Format matching exactly the image -->
   <Row ss:Height="20">
    <Cell ss:MergeDown="1" ss:StyleID="sHeader"><Data ss:Type="String">SR. NO.</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="sHeader"><Data ss:Type="String">TYPE OF EXAMINER</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="sHeader"><Data ss:Type="String">DATE</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="sHeader"><Data ss:Type="String">SUBJECT CODE</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="sHeader"><Data ss:Type="String">SUBJECT NAME</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="sHeader"><Data ss:Type="String">NAME OF THE PERSON</Data></Cell>
    <Cell ss:MergeAcross="4" ss:StyleID="sHeaderGray"><Data ss:Type="String">Amounts</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="sHeader"><Data ss:Type="String">Contact No.</Data></Cell>
   </Row>
   <Row ss:Height="30">
    <!-- Col Index 7 -->
    <Cell ss:Index="7" ss:StyleID="sHeader"><Data ss:Type="String">TA</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">DA</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">HON ORA RIUM</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">ACC OMO DATI ON</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">TOTAL</Data></Cell>
   </Row>

   <!-- Data Rows -->
   <?php 
   $srNo = 1;
   $categories = ['EXTERNAL EXAMINER', 'INTERNAL EXAMINER', 'LAB ASSISTANT'];

   foreach ($categories as $categoryName) {
       $rows = $data[$categoryName];
       if (count($rows) > 0) {
           foreach ($rows as $index => $row) {
               $displayCategory = $categoryName;
               if ($categoryName == 'EXTERNAL EXAMINER') $displayCategory = 'EXTERNAL';
               if ($categoryName == 'INTERNAL EXAMINER') $displayCategory = 'INTERNAL';

               echo "<Row>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"Number\">" . $srNo++ . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataLeft\"><Data ss:Type=\"String\">" . htmlspecialchars($displayCategory) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . htmlspecialchars($row['date']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . htmlspecialchars($row['subject_code']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . htmlspecialchars($row['subject_name']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . htmlspecialchars($row['name']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . (empty($row['ta']) ? '-' : $row['ta']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . (empty($row['da']) ? '-' : $row['da']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . (empty($row['honorarium']) ? '-' : $row['honorarium']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . (empty($row['accommodation']) ? '-' : $row['accommodation']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataBold\"><Data ss:Type=\"String\">" . (empty($row['total']) ? '-' : $row['total']) . "</Data></Cell>";
               echo "<Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"String\">" . htmlspecialchars($row['contact']) . "</Data></Cell>";
               echo "</Row>\n";
           }
       }
   }
   ?>

   <!-- Total Row -->
   <Row>
    <Cell ss:MergeAcross="5" ss:StyleID="sHeaderRight"><Data ss:Type="String">TOTAL</Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $grandSums['ta'] ?></Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $grandSums['da'] ?></Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $grandSums['honorarium'] ?></Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $grandSums['accommodation'] ?></Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $grandTotal ?></Data></Cell>
    <Cell ss:StyleID="sDataCenter"/>
   </Row>

   <!-- Blank spacing -->
   <Row></Row>
   <Row></Row>

   <!-- Summary Chart at the bottom left exactly like Image -->
   <Row>
    <Cell ss:Index="4" ss:MergeAcross="1" ss:StyleID="sSummaryLeft"><Data ss:Type="String">EXTERNAL EXAMINER</Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $totals['EXTERNAL EXAMINER'] ?></Data></Cell>
   </Row>
   <Row>
    <Cell ss:Index="4" ss:MergeAcross="1" ss:StyleID="sSummaryLeft"><Data ss:Type="String">INTERNAL EXAMINER</Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $totals['INTERNAL EXAMINER'] ?></Data></Cell>
   </Row>
   <Row>
    <Cell ss:Index="4" ss:MergeAcross="1" ss:StyleID="sSummaryLeft"><Data ss:Type="String">LAB ASSISTANT</Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $totals['LAB ASSISTANT'] ?></Data></Cell>
   </Row>
   <Row>
    <Cell ss:Index="4" ss:MergeAcross="1" ss:StyleID="sSummaryCenter"><Data ss:Type="String">Total Amount</Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $grandTotal ?></Data></Cell>
   </Row>
   
   <!-- Signature block placeholder spacing -->
   <Row></Row>
   <Row></Row>
   <Row></Row>
   
   <Row ss:Height="40">
    <Cell ss:MergeAcross="2" ss:StyleID="sSignature"><Data ss:Type="String">Controller of Examination</Data></Cell>
    <Cell ss:Index="8" ss:MergeAcross="2" ss:StyleID="sSignature"><Data ss:Type="String">Provost</Data></Cell>
   </Row>
  </Table>
 </Worksheet>
</Workbook>
