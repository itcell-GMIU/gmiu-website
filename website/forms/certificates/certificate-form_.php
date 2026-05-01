<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #ba2a21, #8e1c17);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .card {
            background: #ffffff;
            padding: 35px;
            width: 400px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            text-align: center;
        }

        h2 {
            margin-bottom: 10px;
            color: #ba2a21;
        }

        p {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        select,
        input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 18px;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            background: #ba2a21;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background: #9f231c;
        }

        .note {
            margin-top: 15px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Certificate Generator</h2>
        <p>Select certificate type and verify mobile number.</p>

        <form action="generate-certificate.php" method="post">

            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <!-- Certificate Type -->
            <select name="certificate_type" required>
                <option value="">-- Select Certificate Type --</option>
                <option value="AIML">AI-ML Certificate</option>
                <option value="CA">CA Certificate</option>
            </select>


            <!-- Mobile Number -->
            <input
                type="text"
                name="mobile"
                placeholder="Enter Registered Mobile Number"
                pattern="[0-9]{10}"
                required>

            <button type="submit">Verify & Generate</button>
        </form>

        <div class="note">
            Certificate will be downloaded as JPG after verification
        </div>
    </div>

</body>

</html>