<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Promotional</title>
    <!-- Favicon (32x32 PNG or ICO recommended) -->
    <link rel="icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-card {
            width: 100%;
            max-width: 700px;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .clickable-card {
            cursor: pointer;
            transition: transform 0.2s;
            background-color: #ba2a21;
            color: white;
        }

        .clickable-card:hover {
            transform: scale(1.03);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .clickable-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .card-title {
            margin-top: 1rem;
            font-size: 1.25rem;
            font-weight: 600;
        }

        a.text-decoration-none:hover {
            text-decoration: none;
        }

        .card img {
            width: 100%;
            max-width: 150px;
            /* adjust this size as you like */
            height: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="card shadow main-card text-center">
        <!-- Header with Centered Logo -->
        <div class="card-header bg-white border-0">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/Logo%20with%20BG@2x.png" alt="Logo"
                class="logo mx-auto d-block" />
            <h1 class="text-danger">Gyanmanjari Innovative University</h1>
        </div>

        <!-- Body with Two Clickable Cards -->
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <a href="https://gmiu.edu.in/gmiu/admission/" class="text-decoration-none">
                        <div class="card clickable-card">
                            <img src="../assets/admission.png" alt="Card 1 Image" />
                            <div class="card-body">
                                <h5 class="card-title">ઓનલાઇન એડમિશન કન્ફર્મ માટે</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <a href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php " class="text-decoration-none">
                        <div class="card clickable-card">
                            <img src="../assets/virtualtour.png" alt="Card 2 Image" />
                            <div class="card-body">
                                <h5 class="card-title">યુનિવર્સિટી કેમ્પસ જોવા માટે </h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>