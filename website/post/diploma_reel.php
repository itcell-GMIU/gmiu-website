<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reel Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        /* Sticky Header */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #ffffff;
            padding: 15px 0;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header img {
            height: 60px;
            transition: transform 0.3s ease;
        }

        .header img:hover {
            transform: scale(1.05);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .reel-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            margin-top: 20px;
        }

        .reel-container {
            position: relative;
            flex: 0 0 calc(33.333% - 20px);
            max-width: calc(33.333% - 20px);
            height: 280px;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            background: #000;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .reel-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        /* Play Button */
        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.4s ease, background 0.3s ease;
            animation: pulse 2s infinite;
        }

        .play-button::before {
            content: '';
            display: block;
            width: 0;
            height: 0;
            border-left: 24px solid white;
            border-top: 14px solid transparent;
            border-bottom: 14px solid transparent;
        }

        /* Hover Effects */
        .reel-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        }

        .reel-container:hover img {
            transform: scale(1.1);
            filter: brightness(0.8);
        }

        .reel-container:hover .play-button {
            transform: translate(-50%, -50%) scale(1.2);
            background: rgba(255, 0, 100, 0.6);
        }

        /* Floating animation for play button */
        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(-50%, -50%) scale(1.1);
            }

            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @media (max-width: 991px) {
            .reel-container {
                flex: 0 0 calc(50% - 20px);
                max-width: calc(50% - 20px);
            }
        }

        @media (max-width: 600px) {
            .reel-container {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .header img {
                height: 45px;
            }
        }
    </style>
</head>

<body>
    <!-- Sticky Header -->
    <div class="header">
        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo">
    </div>

    <div class="container">
        <div class="reel-wrapper">
            <?php
            include '../../database/connect.php';
            $stmt2 = $con->prepare("SELECT file FROM tbl_post 
                            WHERE field_name = 'after10th' 
                            AND is_active = 1 
                            AND is_delete = 0 
                            ");
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            while ($row2 = $result2->fetch_assoc()) {
                $videoUrl = trim($row2['file']);

                // Extract the YouTube video ID
                if (preg_match('/(?:v=|\/embed\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                    $videoId = $matches[1];
                } else {
                    $videoId = $videoUrl;
                }

                // Thumbnail URL
                $thumbUrl = "https://img.youtube.com/vi/$videoId/hqdefault.jpg";
                $youtubeLink = "https://www.youtube.com/watch?v=$videoId";

                echo '<a href="' . $youtubeLink . '" target="_blank" class="reel-container">
                <img src="' . $thumbUrl . '" alt="YouTube Thumbnail">
                <div class="play-button"></div>
              </a>';
            }
            ?>
        </div>
    </div>
</body>

</html>