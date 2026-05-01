<?php
include './include/checklogin.php';
// Handle CSV upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); // Skip the header row

        $updates = [];
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $id = intval($data[0]);
            $branch_code = $con->real_escape_string($data[1]);
            $updates[] = "WHEN id = $id THEN '$branch_code'";
        }
        fclose($handle);

        if (!empty($updates)) {
            $sql = "UPDATE tbl_program SET branch_code = CASE " . implode(" ", $updates) . " END WHERE id IN (" .
                implode(",", array_keys($updates)) . ")";
            if ($con->query($sql)) {
                echo "<p style='color: green;'>Branch codes updated successfully!</p>";
            } else {
                echo "<p style='color: red;'>Error updating records: " . $con->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>No valid data found in the CSV.</p>";
        }
    } else {
        echo "<p style='color: red;'>Failed to open the CSV file.</p>";
    }
}

$con->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload CSV & Update Branch Codes</title>
</head>

<body>
    <h2>Upload CSV to Update Branch Codes</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit">Upload & Update</button>
    </form>
</body>

</html>