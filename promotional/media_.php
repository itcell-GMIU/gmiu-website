<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Social Media</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('back.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
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
            background: rgba(0, 0, 0, 0.5);
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
            text-align: center;
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
            width: 100%;
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

        .mt-100 {
            margin-top: 60px;
        }
        @media (min-width: 1400px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
                max-width: 960px;
            }
        }
        @media (max-width: 800px) {
            .qr-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 8px;
            }
        }
        .header-body{
                position: relative;
                text-align: center;
        }
        .qr-card p {
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        a {
            text-decoration: none;
        }

    </style>
</head>

<body>
    <header id="header">
        <div class="header-body">
            <!--<nav class="navbar edu-navbar">-->
                <!--<div class="container-fluid">-->
                    <div class="navbar-header">
                        <img id="nav-logo" src="GMIU White logo.png" alt="" style="width: 200px;">
                    </div>
                <!--</div>-->
                <!-- /.container -->
            <!--</nav>-->
        </div>
    </header>
    <div class="mt-100">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <h1>Connect With Gyanmanjari Innovative University</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Instagram QR Card 1 -->
              <div class="col-12 col-sm-3 mb-4">
    <div class="qr-card">
        <a href="https://www.facebook.com/GyanmanjariColleges" target="_blank">
            <div>
                <img src="images/facebook.png" alt="Facebook QR Code">
            </div>
            <p>Join Facebook</p>
        </a>
    </div>
</div>

<div class="col-12 col-sm-3 mb-4">
    <div class="qr-card">
        <a href="https://www.instagram.com/gyanmanjari_innovative_u/" target="_blank">
            <div>
                <img src="images/Insta.webp" alt="Instagram QR Code">
            </div>
            <p>Follow on Instagram</p>
        </a>
    </div>
</div>

<div class="col-12 col-sm-3 mb-4">
    <div class="qr-card">
        <a href="https://www.linkedin.com/in/gmiu-promotions-9633a12a4/" target="_blank">
            <div>
                <img src="images/LinkedIn.webp" alt="LinkedIn QR Code">
            </div>
            <p>Connect on LinkedIn</p>
        </a>
    </div>
</div>

<div class="col-12 col-sm-3 mb-4">
    <div class="qr-card">
        <a href="https://x.com/GMGC_Bhavnagar" target="_blank">
            <div>
                <img src="images/twitter.jpg" alt="Twitter QR Code">
            </div>
            <p>Follow on Twitter</p>
        </a>
    </div>
</div>

<div class="col-12 col-sm-3 mb-4">
    <div class="qr-card">
        <a href="https://t.me/GMIU_bhavnagar" target="_blank">
            <div>
                <img src="images/telegram.jpg" alt="Telegram QR Code">
            </div>
            <p>Join on Telegram</p>
        </a>
    </div>
</div>

<div class="col-12 col-sm-3 mb-4">
    <div class="qr-card">
        <a href="https://www.youtube.com/channel/UCzsun63TTJoLySLIWWaA8AQ" target="_blank">
            <div>
                <img src="images/yt.png" alt="YouTube QR Code">
            </div>
            <p>Subscribe on YouTube</p>
        </a>
    </div>
</div>

<div class="col-12 col-sm-3 mb-4">
    <div class="qr-card">
        <a href="https://www.facebook.com/groups/3124817927749262/?ref=share" target="_blank">
            <div>
                <img src="images/fbgroup.png" alt="Facebook Group QR Code">
            </div>
            <p>Join Facebook Group</p>
        </a>
    </div>
</div>

<div class="col-12 col-sm-3 mb-4">
    <div class="qr-card">
        <a href="https://whatsapp.com/channel/0029VaAlQDCJP217g55N1h2B" target="_blank">
            <div>
                <img src="images/wbgroup.jpg" alt="WhatsApp QR Code">
            </div>
            <p>Join WhatsApp</p>
        </a>
    </div>
</div>

            </div>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
