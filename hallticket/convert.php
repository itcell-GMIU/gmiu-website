<?php

$inputFile = "data.csv";   // your CSV file
$outputFile = "output.php"; // generated PHP file

$data = [];

if (($handle = fopen($inputFile, "r")) !== FALSE) {

    while (($row = fgetcsv($handle)) !== FALSE) {

        // Expecting: mobile | seat_no | name
        $mobile = trim($row[0]);
        $seat_no = trim($row[1]);
        $name = trim($row[2]);

        // Clean mobile
        $mobile = str_replace([" ", "+91"], "", $mobile);

        if (strlen($mobile) > 10 && substr($mobile, 0, 1) == "0") {
            $mobile = ltrim($mobile, "0");
        }

        // Skip invalid numbers
        if (!preg_match('/^[0-9]{10}$/', $mobile)) {
            continue;
        }

        // Store (handle duplicate numbers)
        $data[$mobile][] = [
            "seat_no" => $seat_no,
            "name" => $name
        ];
    }

    fclose($handle);
}

// Generate PHP file content
$output = "<?php\n\n\$data = [\n";

foreach ($data as $mobile => $entries) {

    // If single entry → simple format
    if (count($entries) == 1) {
        $e = $entries[0];
        $output .= "\"$mobile\" => [\"seat_no\" => \"{$e['seat_no']}\", \"name\" => \"{$e['name']}\"],\n";
    }
    // If duplicate → array format
    else {
        $output .= "\"$mobile\" => [\n";
        foreach ($entries as $e) {
            $output .= "    [\"seat_no\" => \"{$e['seat_no']}\", \"name\" => \"{$e['name']}\"],\n";
        }
        $output .= "],\n";
    }
}

$output .= "];\n";

// Save output
file_put_contents($outputFile, $output);

echo "✅ Conversion done! Check output.php";
