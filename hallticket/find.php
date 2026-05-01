<?php

// File paths
$erp_file = "ERP.csv";
$gmiu_file = "gmiu.csv";

// Function to read CSV and return associative array (key = referral code)
function readCSV($file_path)
{
    $data = [];

    if (($handle = fopen($file_path, "r")) !== FALSE) {
        $header = fgetcsv($handle); // skip header

        while (($row = fgetcsv($handle)) !== FALSE) {

            // Skip empty or invalid rows
            if (count($row) < 3) {
                continue;
            }

            $referral = trim($row[0]);

            // Skip if referral code is empty
            if ($referral == '') {
                continue;
            }

            $data[$referral] = [
                "contact" => isset($row[1]) ? $row[1] : '',
                "name" => isset($row[2]) ? $row[2] : ''
            ];
        }

        fclose($handle);
    }

    return $data;
}
// Read both files
$erp_data = readCSV($erp_file);
$gmiu_data = readCSV($gmiu_file);

// Compare
$only_in_erp = array_diff_key($erp_data, $gmiu_data);
$only_in_gmiu = array_diff_key($gmiu_data, $erp_data);
function renderTable($title, $data)
{
    echo "<h2 style='margin-top:30px;'>$title</h2>";

    if (empty($data)) {
        echo "<p>No records found.</p>";
        return;
    }

    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%; font-family:Arial;'>";
    echo "<tr style='background:#f2f2f2; font-weight:bold;'>
            <th>Referral Code</th>
            <th>Contact</th>
            <th>Name</th>
          </tr>";

    foreach ($data as $ref => $row) {
        echo "<tr>                
                <td>{$row['name']}</td>
                <td>{$ref}</td>
                <td>{$row['contact']}</td>
              </tr>";
    }

    echo "</table>";
}

// Show results
renderTable("Data in ERP but NOT in GMIU", $only_in_erp);
renderTable("Data in GMIU but NOT in ERP", $only_in_gmiu);
