<?php
function validateQRAndFetchData($qrText, $pdo)
{
    if (strpos($qrText, "gmiu.edu.in/") !== 0) {
        return ["error" => "Invalid QR Code. Please scan a valid GMIU vehicle QR."];
    }

    $parts = explode("/", $qrText);
    if (count($parts) < 2)
        return ["error" => "Invalid QR Code. Please scan a valid GMIU vehicle QR."];
    $dataText = $parts[1];

    $pattern = '/^(GMIU\d+)-([A-Z]{2,5})-([A-Z]+)-(2|4|H)-\((GJ\d{2}-[A-Z]{2}-\d{4})\)$/';
    if (!preg_match($pattern, $dataText, $matches)) {
        return ["error" => "Invalid QR Code. Please scan a valid GMIU vehicle QR."];
    }

    $sr = $matches[1];
    $shortName = $matches[2];
    $department = $matches[3];

    $stmt = $pdo->prepare("SELECT * FROM tbl_staff_vehicle_data WHERE short_name=? AND is_delete=0");
    $stmt->execute([$shortName]);
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff)
        return ["error" => "Invalid QR Code. Please scan a valid GMIU vehicle QR."];
    if (strcasecmp(trim($staff["department"]), trim($department)) !== 0) {
        return ["error" => "Invalid QR Code. Please scan a valid GMIU vehicle QR."];
    }

    // ✅ Check if scanned QR matches main vehicle
    $mainQr = $sr . "-" . $shortName . "-" . $department . "-" .
        (($staff["vehicle_type"] == "TWO-WHEELER") ? "2" :
            (($staff["vehicle_type"] == "FOUR-WHEELER") ? "4" :
                (($staff["vehicle_type"] == "HEAVY-VEHICLE") ? "H" : ""))) .
        "-(" . $staff["vehicle_no"] . ")";

    if ($mainQr === $dataText) {
        return [
            "success" => true,
            "data" => $staff,
            "matched_vehicle" => [
                "vehicle_type" => $staff["vehicle_type"],
                "vehicle_no" => $staff["vehicle_no"]
            ],
            "qr_extracted" => [ // ✅ Added
                "sr" => $sr,
                "short_name" => $shortName,
                "department" => $department,
                "vehicleType" => ($matches[4] == "2") ? "TWO-WHEELER" : "FOUR-WHEELER",
                "vehicleNo" => $matches[5]
            ]
        ];
    }


    // ✅ Check if scanned QR matches any extra vehicle
    if (!empty($staff["extra_vehicle_info"])) {
        $extraVehicles = json_decode($staff["extra_vehicle_info"], true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($extraVehicles)) {
            foreach ($extraVehicles as $v) {
                if (isset($v["qr_code"]) && $v["qr_code"] === $dataText) {
                    return [
                        "success" => true,
                        "data" => $staff,
                        "matched_vehicle" => [
                            "vehicle_type" => $v["vehicle_type"],
                            "vehicle_no" => $v["vehicle_no"]
                        ],
                        "qr_extracted" => [ // ✅ Added
                            "sr" => $sr,
                            "short_name" => $shortName,
                            "department" => $department,
                            "vehicleType" => ($matches[4] == "2") ? "TWO-WHEELER" : "FOUR-WHEELER",
                            "vehicleNo" => $matches[5]
                        ]
                    ];

                }
            }
        }
    }

    return ["error" => "Invalid QR Code. Please scan a valid GMIU vehicle QR."];
}


try {
    $pdo = new PDO("mysql:host=localhost;dbname=gmiu;charset=utf8mb4", "root", "");
    // $pdo = new PDO("mysql:host=localhost;dbname=u977112581_gmiutest;charset=utf8mb4", "u977112581_gmiutest", "Test@123?");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Error: " . htmlspecialchars($e->getMessage()));
}

$qrParam = isset($_GET['qrText']) ? $_GET['qrText'] : null;
$qrText = $qrParam ? "gmiu.edu.in/" . $qrParam : null;
$result = $qrText ? validateQRAndFetchData($qrText, $pdo) : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QR Code Validation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            height: 100vh;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            padding: 20px;
        }

        .card {
            max-width: 400px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #reader {
            max-width: 300px;
            margin: auto;
        }

        /* ✅ Stop scroll in web and mobile */
        html,
        body {
            overflow: hidden;
            height: 100%;
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div id="loader"
        style="position:fixed;top:0;left:0;width:100%;height:100%;background:#fff;z-index:9999;display:flex;align-items:center;justify-content:center;">
        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="mainContent" style="display: none;">
        <div class="text-center mb-4">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Logo" style="height: 80px;">
        </div>

        <div class="center-container">
            <h3 class="text-center mb-3">Valid Upto 01-09-2025</h3>

            <?php if (!$qrText) { ?>
                <div class="card p-4 text-center">
                    <h5>📷 Scan Your QR Code</h5>
                    <div id="reader" style="width: 300px;"></div>
                    <button class="btn btn-secondary mt-3" onclick="scanFile()">📁 Upload QR Code</button>
                    <p class="mt-2 text-muted">Allow camera access or upload a QR image.</p>
                </div>

                <script src="https://unpkg.com/html5-qrcode"></script>
                <script>
                    const html5QrCode = new Html5Qrcode("reader");

                    // ✅ File Upload Scanning
                    function scanFile() {
                        const input = document.createElement("input");
                        input.type = "file";
                        input.accept = "image/*";
                        input.onchange = (e) => {
                            const file = e.target.files[0];
                            if (!file) return;

                            html5QrCode.scanFile(file, true)
                                .then(decodedText => {
                                    decodedText = decodeURIComponent(decodedText);
                                    console.log("Decoded:", decodedText);

                                    // ✅ FIXED: Always take only the last part
                                    const qrPart = decodedText.split("/").pop();

                                    window.location.href = "qr-code/" + encodeURIComponent(qrPart);

                                })
                                .catch(err => alert("Scan Error: " + err));
                        };
                        input.click();
                    }


                    // ✅ Camera Scanning
                    function onScanSuccess(decodedText) {
                        try {
                            decodedText = decodeURIComponent(decodedText);
                        } catch (e) { }
                        console.log("Scanned Raw:", decodedText);
                        // ✅ Extract only the last part after the last slash
                        const qrPart = decodedText.substring(decodedText.lastIndexOf("/") + 1);
                        // ✅ Redirect properly
                        window.location.href = "qr-code/" + encodeURIComponent(qrPart);

                    }


                    new Html5QrcodeScanner("reader", {
                        fps: 10,
                        qrbox: 250
                    }).render(onScanSuccess);
                </script>


            <?php } elseif (isset($result["error"])) { ?>
                <div class="card border-danger text-center p-4">
                    <h4 class="text-danger">❌ <?= htmlspecialchars($result["error"]) ?></h4>
                    <a href="qr-code.php" class="btn btn-outline-danger mt-3">🔄 Try Again</a>
                </div>

            <?php } else {
                $qrData = $result["qr_extracted"]; // ✅ Use returned extracted data
            
                $sr = $qrData["sr"];
                $shortName = $qrData["short_name"];
                $department = $qrData["department"];
                $vehicleType = $qrData["vehicleType"];
                $vehicleNo = $qrData["vehicleNo"];

                $status = "Active ✅";
                $statusClass = "text-success";
                ?>
                <div class="card border-success p-4">
                    <h4 class="text-success mb-3 text-center">✅ Vehicle Verified</h4>

                    <table class="table table-bordered text-center">
                        <tbody>
                            <tr>
                                <th>Serial No</th>
                                <td><?= htmlspecialchars($sr) ?></td>
                            </tr>
                            <tr>
                                <th>Short Name</th>
                                <td><?= htmlspecialchars($shortName) ?></td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td><?= htmlspecialchars($department) ?></td>
                            </tr>
                            <tr>
                                <th>Vehicle Type</th>
                                <td><?= htmlspecialchars($vehicleType) ?></td>
                            </tr>
                            <tr>
                                <th>Vehicle No</th>
                                <td><?= htmlspecialchars($vehicleNo) ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="<?= $statusClass ?>"><?= $status ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-3">
                        <a href="https://gmiu.edu.in/gmiu/qr-code.php" class="btn btn-outline-success">🔄 Scan Another</a>
                    </div>
                </div>
            <?php } ?>


        </div>
    </div>


    <!-- ✅ Add Geolocation Check Script Here -->
    <script>
        const GMIU_LAT = 21.718961465761673;
        const GMIU_LNG = 72.12206352031774;
        const ALLOWED_RADIUS = 150; // meters

        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3;
            const φ1 = lat1 * Math.PI / 180;
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) ** 2 +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) ** 2;
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c;
        }

        function checkAllowedArea(lat, lng) {
            const distance = getDistance(lat, lng, GMIU_LAT, GMIU_LNG);

            // Hide loader regardless
            document.getElementById("loader").style.display = "none";

            if (distance <= ALLOWED_RADIUS) {
                document.getElementById("mainContent").style.display = "block";
                // document.write(lat);  // Optional
                // document.write(lng);  // Optional
            } else {
                document.body.innerHTML = "";
                document.write("<div style='text-align:center;padding:2rem'><h3>❌ Access Denied</h3><p>You are not within the allowed GMIU location.</p></div>");
                document.write("<div style='text-align:center;padding:2rem'>Retry with the Location On.</p></div>");
            }
        }

        function checkLocationAndScan() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    pos => {
                        checkAllowedArea(pos.coords.latitude, pos.coords.longitude);
                    },
                    err => {
                        console.warn("GPS denied, using IP...");
                        fallbackToIPLocation();
                    }
                );
            } else {
                fallbackToIPLocation();
            }
        }

        function fallbackToIPLocation() {
            fetch("https://ipapi.co/json/")
                .then(res => res.json())
                .then(data => {
                    checkAllowedArea(data.latitude, data.longitude);
                })
                .catch(() => {
                    document.body.innerHTML = "";
                    document.write("<h3>❌ Unable to determine your location.</h3>");
                });
        }

        function startScanning() {
            const html5QrCode = new Html5Qrcode("reader");
            new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 })
                .render(onScanSuccess);
        }

        function scanFile() {
            checkLocationAndScan();
        }

        window.onload = () => {
            checkLocationAndScan();
        };
    </script>

</body>

</html>