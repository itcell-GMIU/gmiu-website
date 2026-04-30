<?php
include('../include/config.php');

// Security Check: Only ADMIN and SUPER ADMIN can export data
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] == 3) {
    die("Unauthorized Access");
}

// Capture date filters
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

$where_clause = "WHERE is_active = 1 AND is_delete = 0";
if (!empty($from_date) && !empty($to_date)) {
    $where_clause .= " AND form_date BETWEEN '$from_date' AND '$to_date'";
    $filename = "TADA_Report_" . $from_date . "_to_" . $to_date . ".xls";
} else {
    $filename = "TADA_Report_All_" . date('Y-m-d_H-i-s') . ".xls";
}

// Fetch data
$sql = "SELECT id, full_name, bank_name, account_no, ifsc_code, gross_total_amount,
        (SELECT SUM(distance_km) FROM tbl_tada_form_travelling_allowance WHERE tada_form_id = tbl_tada_form_data.id) as total_distance
        FROM tbl_tada_form_data 
        $where_clause
        ORDER BY id DESC";
$result = $con->query($sql);

$data = [];
$grandTotal = 0;
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
        $grandTotal += floatval($row['gross_total_amount']);
    }
}

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
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
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
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
  <Style ss:ID="sDataCenter">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11"/>
  </Style>
  <Style ss:ID="sDataLeft">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11"/>
  </Style>
  <Style ss:ID="sDataBold">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="11" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sTitle">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="14" ss:Bold="1"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="TADA Report">
  <Table>
   <Column ss:AutoFitWidth="0" ss:Width="40"/>
   <Column ss:AutoFitWidth="0" ss:Width="200"/>
   <Column ss:AutoFitWidth="0" ss:Width="100"/>
   <Column ss:AutoFitWidth="0" ss:Width="150"/>
   <Column ss:AutoFitWidth="0" ss:Width="150"/>
   <Column ss:AutoFitWidth="0" ss:Width="120"/>
   <Column ss:AutoFitWidth="0" ss:Width="120"/>

   <Row ss:Height="25">
    <Cell ss:MergeAcross="6" ss:StyleID="sTitle"><Data ss:Type="String">TADA REPORT</Data></Cell>
   </Row>
   <Row ss:Height="20">
    <Cell ss:MergeAcross="6" ss:StyleID="sDataCenter"><Data ss:Type="String"><?php echo (!empty($from_date) && !empty($to_date)) ? "Filtered By Date: " . date('d-m-Y', strtotime($from_date)) . " to " . date('d-m-Y', strtotime($to_date)) : "All Records"; ?></Data></Cell>
   </Row>
   <Row ss:Height="10"/>

   <!-- Header Row -->
   <Row ss:Height="20">
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">SR. NO.</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">NAME</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">DISTANCE (KM)</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">BANK NAME</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">A/C NO.</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">IFSC CODE</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">AMOUNT (INR)</Data></Cell>
   </Row>

<?php
$srNo = 1;
foreach ($data as $row) {
    echo "   <Row>\n";
    echo "    <Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"Number\">" . $srNo++ . "</Data></Cell>\n";
    echo "    <Cell ss:StyleID=\"sDataLeft\"><Data ss:Type=\"String\">" . htmlspecialchars($row['full_name']) . "</Data></Cell>\n";
    echo "    <Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"Number\">" . number_format($row['total_distance'], 2, '.', '') . "</Data></Cell>\n";
    echo "    <Cell ss:StyleID=\"sDataLeft\"><Data ss:Type=\"String\">" . htmlspecialchars($row['bank_name']) . "</Data></Cell>\n";
    echo "    <Cell ss:StyleID=\"sDataLeft\"><Data ss:Type=\"String\">" . htmlspecialchars($row['account_no']) . "</Data></Cell>\n";
    echo "    <Cell ss:StyleID=\"sDataLeft\"><Data ss:Type=\"String\">" . htmlspecialchars($row['ifsc_code']) . "</Data></Cell>\n";
    echo "    <Cell ss:StyleID=\"sDataCenter\"><Data ss:Type=\"Number\">" . floatval($row['gross_total_amount']) . "</Data></Cell>\n";
    echo "   </Row>\n";
}
?>

   <!-- Total Row -->
   <Row>
    <Cell ss:MergeAcross="5" ss:StyleID="sHeaderRight"><Data ss:Type="String">TOTAL</Data></Cell>
    <Cell ss:StyleID="sDataBold"><Data ss:Type="Number"><?= $grandTotal ?></Data></Cell>
   </Row>
  </Table>
 </Worksheet>
</Workbook>
