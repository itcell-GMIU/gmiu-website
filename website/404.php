<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 - Gyanmanjari Innovative University</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../website_assets/images/favicon.ico">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Lottie Web CDN -->
    <script src="https://unpkg.com/lottie-web@5.12.0/build/player/lottie.min.js"></script>
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 text-center">

    <div class="container px-3">
        <!-- Card with responsive width -->
        <div class="card shadow-lg border-0 p-4 mx-auto w-100" style="max-width: 700px;">
            <div class="card-body">
                <!-- University Name -->
                <h1 class="text-danger fw-bold mb-3 fs-2 fs-md-1">Gyanmanjari Innovative University</h1>

                <!-- Lottie Animation -->
                <div id="lottie-404" class="mx-auto mb-4" style="max-width: 300px; height: 300px;"></div>

                <!-- 404 Message -->
                <h4 class="text-danger fw-semibold mb-2">404 - Page Not Found</h4>
                <p class="text-secondary mb-3">
                    The page you’re trying to reach doesn’t exist or has been moved.
                </p>

                <!-- Action Button -->
                <a href="https://gmiu.edu.in/gmiu/website/index.php" class="btn btn-primary px-4">Go to Homepage</a>
            </div>

            <!-- Footer -->
            <div class="card-footer bg-transparent border-0 mt-3">
                <p class="text-muted small mb-0">
                    Need help? Contact our IT Support.<br>
                    &copy; <span id="year"></span> Gyanmanjari Innovative University
                </p>
            </div>
        </div>
    </div>

    <script>
        // Pick one of the two animations randomly
        const animationPaths = [
            '../website_assets/404/404.json',
            '../website_assets/404/404-2.json'
        ];
        const randomPath = animationPaths[Math.floor(Math.random() * animationPaths.length)];

        // Load selected Lottie animation
        lottie.loadAnimation({
            container: document.getElementById('lottie-404'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: randomPath
        });

        // Set current year
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>

</body>

</html>