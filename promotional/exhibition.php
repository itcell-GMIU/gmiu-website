<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Design Exhibition</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('back.jpg') no-repeat center center/cover; /* Add your background image */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            position: relative;
        }

        /* Gradient Overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Adjust opacity as needed */
            z-index: 0;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 40px;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        h1::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            animation: spin 6s linear infinite;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .qr-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .qr-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 10px;
            width: 200px;
            text-align: center;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .qr-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff6ec4, #7873f5, #42e695, #3bb2b8);
            background-size: 400%;
            border-radius: 12px;
            z-index: -1;
            transition: 0.5s;
            animation: borderAnimation 3s linear infinite;
        }

        @keyframes borderAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .qr-card:hover::before {
            transform: scale(1.1);
        }

        .qr-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <h1>Fashion Design Exhibition</h1>
    <div class="qr-container">
        <!-- Instagram QR Card 1 -->
        <div class="qr-card">
            <a href="https://www.instagram.com/_vamana__?igsh=dWRhbW1wM2lyOTZx&utm_source=qr" target="_blank">
                <img src="1.jpeg" alt="Instagram QR Code 1">
            </a>
        </div>
        <!-- Instagram QR Card 2 -->
        <div class="qr-card">
            <a href="https://www.instagram.com/stitched_stories__24?igsh=bDU1eG94cDA4dXkw" target="_blank">
                <img src="4.jpeg" alt="Instagram QR Code 2">
            </a>
        </div>
        <!-- Instagram QR Card 3 -->
        <div class="qr-card">
            <a href="https://www.instagram.com/__allure.co__" target="_blank">
                <img src="2.jpeg" alt="Instagram QR Code 3">
            </a>
        </div>
        <!-- Instagram QR Card 4 -->
        <div class="qr-card">
            <a href="https://www.instagram.com/artfulodessy__creations?igsh=NXZtcDQ3Y2U2OW0w" target="_blank">
                <img src="3.jpeg" alt="Instagram QR Code 4">
            </a>
        </div>
         <div class="qr-card">
            <a href="https://www.instagram.com/mansiii_creation08?utm_source=qr&igsh=Zmk2bWdwMGE2Zmd5" target="_blank">
                <img src="5.jpeg" alt="Instagram QR Code 4">
            </a>
        </div>
    </div>
</body>

</html>
