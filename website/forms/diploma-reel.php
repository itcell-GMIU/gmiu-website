<?php include '../../common/importwebsitefile.php'; ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $video_completed = $_POST['video_completed'];

    $form_type = 13; // diploma_lead id

    $ip = $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $referrer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

    $utm_source = $_POST['utm_source'] ?? '';
    $utm_campaign = $_POST['utm_campaign'] ?? '';

    $stmt = $con->prepare("INSERT INTO tbl_promotional_form_data
    (form_type, full_name, mobile, video_completed,ip_address, browser, referrer, utm_source, utm_campaign)
    VALUES (?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "ississsss",
        $form_type,
        $name,
        $mobile,
        $video_completed,
        $ip,
        $browser,
        $referrer,
        $utm_source,
        $utm_campaign
    );

    if ($stmt->execute()) {

        header("Location: diploma-reel.php?status=success");

        exit;
    } else {

        header("Location: diploma-reel.php?status=error");

        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Diploma Programs | GMIU</title>

    <meta name="description" content="Watch the Diploma introduction reel and explore programs at Gyanmanjari Innovative University.">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {

            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 20px;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background: rgba(255, 255, 255, 0.9); */
            z-index: -1;
        }

        /* Main white container */

        .page-wrapper {
           
            background: #e9e1e1;
            backdrop-filter: blur(6px);
            border-radius: 14px;
            max-width: 650px;
            width: 100%;
            display: flex;
            flex-direction: column;   /* force vertical layout */
            gap: 30px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);

        }

        /* Left content */

        .left-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* centers logo and text */
            text-align: center;
        }

        .logo {
            width: 130px;
            margin-bottom: 20px;
            display: block;
            filter: drop-shadow(0px 4px 6px rgba(0, 0, 0, 0.2));
            border-radius: 5px;
        }

        /* Heading */

        .left-content h3 {

            color: #650a09;
            margin-bottom: 10px;

        }

        .left-content p {

            color: #444;
            line-height: 1.5;

        }

        /* Video section */

        .video-section {

            flex: 1;

        }

        video {

            width: 100%;
            border-radius: 12px;

        }

        /* Modal */

        .modal {

            position: fixed;
            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            display: none;

            align-items: center;
            justify-content: center;

            background: rgba(0, 0, 0, 0.6);

        }

        .modal-content {

            background: white;
            padding: 25px;
            border-radius: 12px;

            width: 90%;
            max-width: 360px;

            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.4);

            animation: fadeIn .4s ease;

        }

        @keyframes fadeIn {

            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }

        }

        .modal h2 {

            color: #1c13b8;
            text-align: center;
            margin-bottom: 15px;

        }

        input {

            width: 100%;
            padding: 12px;

            border: 1px solid #ddd;

            border-radius: 6px;

            margin-bottom: 12px;

        }

        button {

            width: 100%;

            padding: 12px;

            background: #ffe500;

            color: #650a09;

            border: none;

            font-weight: bold;

            font-size: 16px;

            border-radius: 6px;

            cursor: pointer;

        }

        /* Mobile layout */

        @media(max-width:768px) {

            .page-wrapper {

                flex-direction: column;
                padding: 20px;

            }

            .logo {

                margin: auto;
                display: block;

            }

            .left-content {

                text-align: center;

            }

        }
    </style>

</head>

<body>

    <div class="page-wrapper">

        <!-- Left content -->

    <!--  <div class="left-content">-->

        <!--<img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" class="logo" alt="GMIU Logo">-->
    
    <!--    <div style="display:flex; gap:20px; align-items:center; justify-content:center; margin-top:15px;">-->
    <!--        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" style="width:120px;">-->
    <!--        <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" style="width:120px;">-->
    <!--    </div>-->
    <!--    <br>-->
    <!--      <h2 style="color:#650a09; margin-bottom:15px; font-size:24px;">-->
    <!--            रट्टा अभ्यास छोडो,<br>-->
    <!--            कौशल्यलक्षी शिक्षा से जुडो ।-->
    <!--        </h2>-->
    <!--</div>-->

        <!-- Video -->

        <div class="video-section">

            <video
                id="reelVideo"
                controls
                autoplay
                playsinline
                preload="metadata">

                <source src="video/JEE-NEW-Reel.mp4" type="video/mp4">

            </video>

        </div>

    </div>


    <!-- Modal Form -->

    <div class="modal" id="leadModal">

        <div class="modal-content">

            <h2>Enter Details to Continue</h2>

            <form id="leadForm" method="POST">

                <input type="text" name="name" placeholder="Full Name" required>

                <input type="tel" name="mobile" placeholder="Mobile Number" pattern="[0-9]{10}" required>

                <input type="hidden" name="video_completed" id="video_completed" value="0">

                <input type="hidden" name="utm_source" value="<?php echo $_GET['utm_source'] ?? ''; ?>">

                <input type="hidden" name="utm_campaign" value="<?php echo $_GET['utm_campaign'] ?? ''; ?>">

                <button type="submit">Continue</button>

            </form>

        </div>

    </div>


    <script>
        const video = document.getElementById("reelVideo");
        const modal = document.getElementById("leadModal");
        
        setTimeout(function () {
        
            video.pause();   // optional
            modal.style.display = "flex";
            document.getElementById("video_completed").value = 1;
        
        }, 25000);
    </script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('status') === 'success') {

            Swal.fire({
                icon: 'success',
                title: 'Thank You!',
                text: 'Your details have been submitted successfully.',
                confirmButtonColor: '#cb130d'
            }).then(() => {

                window.location.href = "https://gmiu.edu.in/gmiu/website/post/diploma.php";

            });

        }

        if (urlParams.get('status') === 'error') {

            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Something went wrong.',
                confirmButtonColor: '#cb130d'
            });

        }
    </script>
</body>

</html>