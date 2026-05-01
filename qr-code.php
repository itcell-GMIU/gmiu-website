<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=u977112581_gmiutest;charset=utf8mb4", "u977112581_gmiutest", "Test@123?");
    // $pdo = new PDO("mysql:host=localhost;dbname=gmiu;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Error: " . htmlspecialchars($e->getMessage()));
}

function validateQRAndFetchData($qrText, $pdo)
{
    if (strpos($qrText, "gmiu.edu.in/") !== 0)
        return ["error" => "Invalid QR Code."];

    $parts = explode("/", $qrText);
    if (count($parts) < 2)
        return ["error" => "Invalid QR Code."];

    $dataText = $parts[1];
    // echo "<pre>";
    // echo "dataText: ";
    // print_r($dataText);
    // echo "</pre>";

    $pattern = '/^(GMIU\d+)-([A-Z]{2,5})-([A-Z_]+)-(2|4|H|E)-\((GJ\d{2}-[A-Z]{1,2}-\d{4}|ELECTRIC)\)$/';

    if (!preg_match($pattern, $dataText, $matches))
        return ["error" => "Invalid QR Code."];

    $_ = $matches[0]; // full match
    $sr = $matches[1];
    $shortName = $matches[2];
    $department = $matches[3];
    $typeCode = $matches[4];
    $vehicleNo = $matches[5];


    // ✅ Modified query to fetch all matching rows by qr_code OR containing extra_vehicle_info
    $stmt = $pdo->prepare("SELECT * FROM tbl_staff_vehicle_data WHERE (qr_code = ? OR extra_vehicle_info IS NOT NULL) AND is_delete = 0 AND is_active = 1");
    $stmt->execute([$dataText]);
    $allStaff = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($allStaff as $staff) {
        
        // ✅ First: check if main QR matches
        if ($staff['qr_code'] === $dataText && strcasecmp(trim($staff["department"]), trim($department)) === 0) {
           
           $prefix = "";
            switch ($staff["vehicle_type"]) {
                case "TWO-WHEELER":
                    $prefix = "2";
                    break;
                case "FOUR-WHEELER":
                    $prefix = "4";
                    break;
                case "HEAVY-VEHICLE":
                    $prefix = "H";
                    break;
                case "ELECTRIC-VEHICLE":
                    $prefix = "E";
                    break;
                default:
                    $prefix = "";
            }

            $mainQr = "$sr-$shortName-$department-$prefix-(" . $staff["vehicle_no"] . ")";
            $vehicleTypeMap = ["2" => "TWO-WHEELER", "4" => "FOUR-WHEELER", "H" => "HEAVY-VEHICLE", "E" => "ELECTRIC"];
            $matchedVehicleType = $vehicleTypeMap[$typeCode] ?? "UNKNOWN";

            if ($mainQr === $dataText) {
                return [
                    "success" => true,
                    "data" => $staff,
                    "matched_vehicle" => ["vehicle_type" => $staff["vehicle_type"], "vehicle_no" => $staff["vehicle_no"]],
                    "qr_extracted" => compact("sr", "shortName", "department") + [
                        "vehicleType" => $matchedVehicleType,
                        "vehicleNo" => $vehicleNo
                    ]
                ];
            }
        }

        // ✅ Second: check inside extra_vehicle_info
        if (!empty($staff["extra_vehicle_info"])) {
            $extras = json_decode($staff["extra_vehicle_info"], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($extras)) {
                foreach ($extras as $v) {
                    if (!empty($v["qr_code"]) && $v["qr_code"] === $dataText && strcasecmp(trim($staff["department"]), trim($department)) === 0) {
                        $vehicleTypeMap = ["2" => "TWO-WHEELER", "4" => "FOUR-WHEELER", "H" => "HEAVY-VEHICLE", "E" => "ELECTRIC"];
                        $matchedVehicleType = $vehicleTypeMap[$typeCode] ?? "UNKNOWN";

                        return [
                            "success" => true,
                            "data" => $staff,
                            "matched_vehicle" => ["vehicle_type" => $v["vehicle_type"], "vehicle_no" => $v["vehicle_no"]],
                            "qr_extracted" => compact("sr", "shortName", "department") + [
                                "vehicleType" => $matchedVehicleType,
                                "vehicleNo" => $vehicleNo
                            ]
                        ];
                    }
                }
            }
        }
    }

    return ["error" => "Invalid QR Codee."];
}

$qrText = isset($_GET['qrText']) ? "gmiu.edu.in/" . $_GET['qrText'] : null;
$result = $qrText ? validateQRAndFetchData($qrText, $pdo) : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>QR Validation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            height: 100vh;
            overflow: hidden;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        }

        #reader {
            max-width: 300px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div id="loader"
        style="position:fixed;top:0;left:0;width:100%;height:100%;background:#fff;z-index:9999;display:flex;align-items:center;justify-content:center;">
        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;"><span
                class="visually-hidden">Loading...</span></div>
    </div>

    <div id="mainContent" style="display:none">
        <div class="center-container">
            <div class="text-center mb-4">
                <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Logo"
                    style="height:80px;" />
            </div>
            <h3 class="text-center mb-3">Valid Upto 01-01-2026</h3>

            <?php if (!$qrText): ?>
                <div class="card p-4 text-center">
                    <h5>📷 Scan Your QR Code</h5>
                    <div id="reader" style="width:300px"></div>
                    <button class="btn btn-secondary mt-3" onclick="scanFile()">📁 Upload QR</button>
                    <p class="mt-2 text-muted">Allow camera or upload a QR image.</p>
                </div>
                <script src="https://unpkg.com/html5-qrcode"></script>
                <script>
                    const html5QrCode = new Html5Qrcode("reader");

                    function scanFile() {
                        const input = document.createElement("input");
                        input.type = "file";
                        input.accept = "image/*";
                        input.onchange = e => {
                            const file = e.target.files[0];
                            if (!file) return;
                            html5QrCode.scanFile(file, true)
                                .then(result => {
                                    const code = decodeURIComponent(result).split("/").pop();
                                    location.href = "qr-code/" + encodeURIComponent(code);
                                })
                                .catch(err => alert("Scan Error: " + err));
                        };
                        input.click();
                    }

                    function onScanSuccess(result) {
                        const code = decodeURIComponent(result).split("/").pop();
                        location.href = "qr-code/" + encodeURIComponent(code);
                    }

                    new Html5QrcodeScanner("reader", {
                        fps: 10,
                        qrbox: 250
                    }).render(onScanSuccess);
                </script>

            <?php elseif (isset($result["error"])): ?>
                <div class="card border-danger text-center p-4">
                    <h4 class="text-danger">❌ <?= htmlspecialchars($result["error"]) ?></h4>
                    <a href="qr-code.php" class="btn btn-outline-danger mt-3">🔄 Try Again</a>
                </div>

            <?php else:
                extract($result["qr_extracted"]);
                $status = "Active ✅";
            ?>
                <div class="card border-success p-4">
                    <h4 class="text-success mb-3 text-center">✅ Vehicle Verified</h4>
                    <table class="table table-bordered text-center">
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
                            <td class="text-success"><?= $status ?></td>
                        </tr>
                    </table>
                    <div class="text-center mt-3">
                        <a href="https://gmiu.edu.in/gmiu/qr-code.php" class="btn btn-outline-success">🔄 Scan Another</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

   <script>
    const GMIU_LAT = 21.71896146576167;
    const GMIU_LNG = 72.12206352031774;
    const ALLOWED_RADIUS = 150; // meters
    const GPS_TIMEOUT = 20000; // 20 seconds
    const LOCATION_SESSION_KEY = 'gmiu_location_verified';
    const SESSION_DURATION_MS = 15 * 60 * 1000; // 15 minutes

    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371000; // Earth radius in meters
        const toRad = angle => angle * Math.PI / 180;
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a = Math.sin(dLat / 2) ** 2 +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function setLocationSession() {
        localStorage.setItem(LOCATION_SESSION_KEY, JSON.stringify({
            timestamp: Date.now()
        }));
    }

    function isLocationSessionValid() {
        const session = localStorage.getItem(LOCATION_SESSION_KEY);
        if (!session) return false;
        try {
            const { timestamp } = JSON.parse(session);
            return (Date.now() - timestamp) < SESSION_DURATION_MS;
        } catch (e) {
            return false;
        }
    }

    function showAccess(status, distance, accuracy, coords) {
        document.getElementById("loader").style.display = "none";
        if (status) {
            setLocationSession(); // ✅ Set session on successful verification
            document.getElementById("mainContent").style.display = "block";
        } else {
            document.body.innerHTML = `
                <div style='text-align:center;padding:2rem'>
                    <h3>❌ Access Denied ❌</h3>
                    <p>You are not Authorized to scan the QR Code.<br><br>
                    📌 Make sure GPS is enabled and try again.</p>
                </div>`;
        }
    }

    function checkAllowedArea(lat, lng, accuracy, coords) {
        const distance = getDistance(lat, lng, GMIU_LAT, GMIU_LNG);
        // console.log("📍 Distance:", distance.toFixed(2), "m");
        // console.log("🎯 Accuracy: ±" + accuracy + " m");
        showAccess(distance <= ALLOWED_RADIUS, distance, accuracy, coords);
    }

    function tryGeolocation() {
        navigator.geolocation.getCurrentPosition(
            ({ coords }) => checkAllowedArea(coords.latitude, coords.longitude, coords.accuracy, coords),
            error => {
                // console.warn("❌ GPS Error:", error.message);
                document.body.innerHTML = `
                    <div style='text-align:center;padding:2rem'>
                        <h3>📍 Location Access Needed</h3>
                        <p>Please enable your device location (GPS) and refresh the page.<br>Error: ${error.message}</p>
                    </div>`;
            },
            {
                enableHighAccuracy: true,
                timeout: GPS_TIMEOUT,
                maximumAge: 0
            }
        );
    }

    window.onload = () => {
        if (isLocationSessionValid()) {
            // ✅ Skip location scan, directly show content
            // console.log("✅ Location previously verified (within 15 minutes)");
            document.getElementById("loader").style.display = "none";
            document.getElementById("mainContent").style.display = "block";
            return;
        }

        if ('geolocation' in navigator) {
            tryGeolocation();
        } else {
            document.body.innerHTML = "<h3>❌ Your browser does not support location access.</h3>";
        }
    };
</script>
</body>

</html>