<?php
include '../database/connect.php';
include '../common/validation.php';
include '../common/globalvariable.php';
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    $pageTitle = "AICTE Training & Learning Faculty Development Programme - GMIU";
    $meta_description = "Gyanmanjari Innovative University (GMIU) presents AICTE Training & Learning Faculty Development Programme (ATAL FDP) to enhance faculty skills, knowledge and research capabilities.";
    ?>

    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "include/importhead.php"; ?>
    <?php include 'include/importcss.php'; ?>
    <style>
    /* Import attractive Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .register-btn-container {
        text-align: center !important;

    }

    .register-btn {
        display: inline-block;

        background-color: #ba2a21 !important;
        /* Red color */
        color: #fff !important;
        /* White text */
        padding: 14px 40px;
        /* Top/Bottom 14px, Left/Right 40px */
        border-radius: 50px;
        /* Fully rounded (pill shape) */
        font-size: 18px;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(186, 42, 33, 0.3);
        border: none;
    }

    .register-btn:hover {
        background-color: #a1221a !important;
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(186, 42, 33, 0.4);
    }



    /* Hero Image */
    .atal-fdp-hero {
        position: relative;
        width: 100%;
        /* height: 360px; */
        overflow: hidden;
        /* border-radius: 10px; */
        margin-bottom: 45px;
    }

    .atal-fdp-hero img {
        width: 100%;
        /* height: 100%; */
        object-fit: cover;
        /* filter: brightness(70%); */
    }

    .atal-fdp-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        background: rgba(0, 0, 0, 0.3);
        padding: 0 20px;
    }

    .atal-fdp-overlay h1 {
        font-size: 36px;
        font-weight: 700;
        max-width: 900px;
        line-height: 1.4;
    }

    /* Content Section */
    .atal-fdp-content {
        background: #fff;
        padding: 45px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .atal-fdp-content h3 {
        margin-top: 35px;
        font-weight: 600;
        color: #ba2a21;
        font-size: 22px;
    }

    .atal-fdp-content p,
    .atal-fdp-content li {
        font-size: 17px;
        color: #444;
    }

    .atal-fdp-content ul {
        margin-left: 25px;
    }
     .atal-fdp-content ol {
        margin-left: 25px;
    }

    .atal-fdp-content a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .atal-fdp-content a:hover {
        text-decoration: underline;
        color: #0056b3;
    }

    .atal-fdp-content blockquote {
        background: #fdf2f2;
        border-left: 5px solid #ba2a21;
        padding: 18px 22px;
        font-size: 18px;
        margin: 25px 0;
        border-radius: 6px;
        font-style: italic;
    }

    /* Coordinators Box */
    .coordinators {
        margin-top: 40px;
        background: #fff9f9;
        padding: 28px;
        border-radius: 6px;
        border-left: 4px solid #ba2a21;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .coordinators h3 {
        color: #ba2a21;
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {


        .atal-fdp-overlay h1 {
            font-size: 24px;
        }

        .atal-fdp-content {
            padding: 25px;
            font-size: 16px;
        }
    }
    </style>
</head>

<body class="courses">
    <?php include 'include/importheader.php'; ?>

    <!-- Hero Section (Original GMIU CSS) -->
    <section class="hero">
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>AICTE Training & Learning Faculty Development Programme</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active">ATAL FDP</span>
                </p>
            </div>
        </div>
    </section>

    <section class="container atal-fdp-section">
        <div class="atal-fdp-hero">
            <img src="January_2026.jpg" alt="ATAL FDP Banner">

        </div>
        <div class="register-btn-container">
            <a href="https://atalacademy.aicte-india.org/login" target="_blank" class="register-btn">
                Click Here to Register
            </a>
        </div>

        <div class="container atal-fdp-content">
            <p>
                The <strong>Gyanmanjari Institute of Technology</strong> is pleased to host a prestigious
                <strong>AICTE Training and Learning (ATAL) Online Faculty Development Programme (FDP)</strong>
                for the academic year 2025–26.
            </p>



            <blockquote>
                <p>
                    We cordially invite you to participate in this AICTE-sponsored FDP on:
                </p>
                <strong>“Artificial Intelligence & Its Application”</strong><br>
                <b>Date:</b> January 19 – January 24, 2026<br>
                <b>Time:</b> 6:00 PM – 9:00 PM IST<br>
                <b>Mode:</b> Online
            </blockquote>

            <p>
                This FDP is open to faculty members, research scholars, PG students (from AICTE-approved institutions),
                and industry professionals interested in the intersection of AI and technology.
            </p>

            <h3>Registration Link:</h3>
            <p>
                <a href="https://atalacademy.aicte-india.org/login" target="_blank">
                    https://atalacademy.aicte-india.org/login
                </a>
            </p>

           <h3>How to Register:</h3>
           <br>
            <ol>
                <li>Click on <strong>Registration Link</strong>.</li>
                <li>Click on <strong>“Sign up now”</strong>.</li>
                <li>After sign up, check your registered email and click on <strong>“Verify Email”</strong>.</li>
                <li>Sign in as a participant and complete your profile.</li>
                <li>Click on <strong>FDP</strong> menu available on the left-hand side.</li>
                <li>Select <strong>FDP type:</strong> ATAL Online.</li>
                <li>Select <strong>Month:</strong> January.</li>
                <li>Select <strong>Thrust Area:</strong> All.</li>
                <li>Use <strong>Ctrl+F</strong> to search FDP by <strong>Name:</strong> “Gyanmanjari” or by <strong>Application No.:</strong> 1747985127.</li>
                <li>Click the “+” icon to register and then click <strong>“Confirm”</strong>.</li>
            </ol>


            <p>For any queries, please feel free to contact us.</p>

            <div class="coordinators">
                <h3>FDP Coordinators</h3>
                <p><strong>FDP Coordinator:</strong> Prof. Amit Maru</p>
                <p><strong>FDP Co-coordinator:</strong> Prof. Anish Vora</p>
                <p><strong>Email:</strong> <a href="mailto:agmaru@gmiu.edu.in">agmaru@gmiu.edu.in</a></p>
            </div>
        </div>
    </section>


    <?php include 'include/importfooter.php'; ?>
    <?php include 'include/importjs.php'; ?>
</body>

</html>