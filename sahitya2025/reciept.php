<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


include './dbconnect.php';
include './operations.php';


if (isset($_GET['rid'])) {
    $id = $_GET['rid'];
}

// Check if the record already exists
$checkStmt = $con->prepare("SELECT * FROM `tbl_registers` 
WHERE MD5(payment_id) = CONVERT( ? USING utf8mb4) COLLATE utf8mb4_unicode_ci 
AND payment_status COLLATE utf8mb4_unicode_ci = 'success';");
$checkStmt->bind_param("s", $id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    while ($row2 = $checkResult->fetch_assoc()) {
        $rid = $row2['id'];
        $competitions = $row2['competitions'];
        $contact = $row2['mobile'];

        if ($row2['payment_status'] == "success") {
?>
            <!DOCTYPE html>
            <html>

            <head>
                <title>Receipt</title>
                <!-- Include Bootstrap CSS -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

                <style>
                    /* Custom CSS for Receipt */
                    .receipt-container {
                        border: 1px solid #ccc;
                        padding: 20px;
                        margin: 20px;
                    }

                    .logo {
                        /* Add your logo image here */
                        max-width: 80px;
                    }

                    @media print {
                        .print-btn {
                            display: none;
                        }
                    }

                    .borderless table {
                        border-top-style: none;
                        border-left-style: none;
                        border-right-style: none;
                        border-bottom-style: none;
                    }

                    .table-borderless>tbody>tr>td,
                    .table-borderless>tbody>tr>th,
                    .table-borderless>tfoot>tr>td,
                    .table-borderless>tfoot>tr>th,
                    .table-borderless>thead>tr>td,
                    .table-borderless>thead>tr>th {
                        border: none;
                    }

                    .pay-w {
                        width: 200px;
                    }
                </style>
            </head>

            <body>
                <div class="container">
                    <!-- Receipt Container -->
                    <div class="receipt-container">
                        <!-- Logo and Institute Name -->
                        <div class="row w-100 text-center align-self-center p-0 m-0">
                            <img src="logo-single.jpg" alt="Logo" class="logo ml-auto">
                            <h2 class="mr-auto mt-2">Gyanmanjari Innovative University</h2>
                        </div>

                        <table class="table table-bordered text-center">
                            <tbody>
                                <tr>
                                    <th colspan="2"><h3>Gyanmanjari Innovative University & Gujarat Sahitya Academy</h3></th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td class="text-left"><?= $row2['name'] ?></td>
                                </tr>
                                <tr>
                                    <th>Contact No.:</th>
                                    <td class="text-left"><?= $row2['mobile']?></td>
                                </tr>
                                <tr>
                                    <th>Email :</th>
                                    <td class="text-left"><?= $row2['email'] ?></td>
                                </tr>
                                <tr>
                                    <th>Category :</th>
                                    <td class="text-left">

                                        <?php

                                        $crud->readSingleRecordColumn("tbl_registers", "competitions", ["is_active" => 1, "mobile" => $contact], $competitions);
                                        $comps = unserialize($competitions);

                                        foreach ($comps as $compid) {
                                            $crud->readSingleRecordColumn("tbl_competetion", "name", ["id" => $compid, "is_active" => 1], $compname);
                                            echo "⮞ " . $compname . "<br>";
                                        }

                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <div class="text-center mt-4 mb-3">
                        <h5><u>Payment Details</u></h5>
                    </div>
                    <!-- Payment Details -->
                    <table class="table table-borderless text-left">
                        <tbody>
                            <tr>
                                <td class="p-0 pay-w">Payment Id :</td>
                                <td class="p-0"><?= $row2['payment_id'] ?></td>
                            </tr>
                            <tr>
                                <td class="p-0 pay-w">Paid Amount:</td>
                                <td class="p-0 font-weight-bold">Rs. <?= $row2['fee_amount'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                        <!-- <p><b>*Note :</b> Bring This Receipt At The Time Of Competition.</p> -->
                    </div>

                    <!-- Print Button -->
                    <div class="text-center mb-5">
                        <a href="./index.php" class="btn btn-dark print-btn">Home</a>
                        <button class="btn btn-primary print-btn" onclick="window.print()">Print Receipt</button>
                        <hr class="print-btn">
                        <a class="btn btn-success print-btn" href="https://chat.whatsapp.com/KrF4P22kEZmD2YWHtBgpW4">
                            <svg width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg> Join WhatsApp Group</a>
                    </div>
                </div>

                <script>
                    // Disable right-click
                    document.addEventListener('contextmenu', function(e) {
                        e.preventDefault();
                    });

                    // Disable inspect mode
                    document.onkeydown = function(e) {
                        if (
                            (e.key === 'F12' && e.ctrlKey === true) || // Ctrl+Shift+I
                            (e.key === 'U' && e.ctrlKey === true) || (e.key === 'F12' && e.ctrlKey === false) // Ctrl+U
                        ) {
                            return false;
                        }
                    };
                </script>

                <script>
                    // Your encryption key - you should keep this secret.
                    var encryptionKey = "YourSecretKey";

                    // The file path you want to encrypt
                    var originalPath = "/path/to/your/file.txt";

                    // Encrypt the file path
                    var encryptedPath = CryptoJS.AES.encrypt(originalPath, encryptionKey).toString();

                    // Display the encrypted file path
                    document.getElementById("encryptedPath").textContent = encryptedPath;

                    // To decrypt the path later if needed, you can use:
                    // var decryptedPath = CryptoJS.AES.decrypt(encryptedPath, encryptionKey).toString(CryptoJS.enc.Utf8);
                    // console.log(decryptedPath);
                </script>
            </body>

            </html>
        <?php
        }
    }
} else {
    echo "<script>alert('Error : Data Not Found!'); window.location.href='index.php';</script>";
    exit;
}
?>