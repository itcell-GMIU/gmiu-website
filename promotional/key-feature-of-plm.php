<?php
include '../database/connect.php';

$sql = "
SELECT
    p.id AS program_id,
    p.name AS program_name,
    sc.*
FROM tbl_program p
INNER JOIN tbl_std_corner sc
    ON sc.program_id = p.id
WHERE p.name LIKE '%premium%'
ORDER BY p.id, sc.sem, sc.subject_name
";

$res = mysqli_query($con, $sql);

$programs = [];

while ($row = mysqli_fetch_assoc($res)) {
    $programs[$row['program_id']]['name'] = $row['program_name'];
    $programs[$row['program_id']]['subjects'][] = $row;
}
?>


<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMIU - Profficient Learning Method</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <style>
        :root {
            --gmiu-red: #bd2725;
            --gmiu-navy: #1e264a;
            --gmiu-gray: #808080;
            /* --bg-soft: #f4f6f9; */
            --bg-soft: #dfdfdf;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-soft);
            color: var(--gmiu-navy);
        }

        /* Institutional Header */
        header {
            background-color: white;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* border-bottom: 4px solid var(--gmiu-navy); */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .logo-container img {
            height: 70px;
            /* Adjusted for your specific GMIU horizontal logo */
            width: auto;
        }

        .usp-badge {
            background: var(--gmiu-red);
            color: white;
            padding: 8px 20px;
            font-weight: bold;
            border-radius: 50px;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 60px 20px;
            /* background: linear-gradient(135deg, var(--gmiu-navy) 0%, #2c386d 100%); */
            background: linear-gradient(135deg, #1e264a 0%, #2a2f63 40%, #bd2725 100%);
            color: white;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);
            margin-bottom: 40px;
        }

        .hero h1 {
            font-size: 2.8rem;
            margin: 0;
            font-weight: 800;
        }

        .hero p {
            color: #ccc;
            font-size: 1.2rem;
            margin-top: 10px;
        }

        /* Grid Layout */
        .main-content {
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .feature-box {
            background: white;
            border-radius: 0 20px 0 20px;
            /* Elegant asymmetric corners */
            padding: 30px;
            position: relative;
            overflow: hidden;
            /* border: 1px solid #e1e1e1; */
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 15px 30px rgba(30, 38, 74, 0.10);
        }

        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(30, 38, 74, 0.20);
            border-color: var(--gmiu-red);
        }

        /* Decorative Number/Icon */
        .feature-box i {
            color: var(--gmiu-red);
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .eng-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gmiu-navy);
            margin-bottom: 8px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .hindi-title {
            font-size: 1.05rem;
            color: var(--gmiu-gray);
            font-weight: 500;
        }

        /* Side Accent Bar */
        .feature-box::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 5px;
            background: var(--gmiu-navy);
        }

        .feature-box:hover::before {
            background: var(--gmiu-red);
        }

        /* Footer Decoration */
        footer {
            text-align: center;
            padding: 60px;
            color: var(--gmiu-gray);
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 1.8rem;
            }

            header {
                flex-direction: column;
                gap: 15px;
            }
        }

        /* Credit Section */
        .credit-footer {
            margin-top: 80px;
            background: var(--gmiu-navy);
            padding: 40px 20px;
            text-align: center;
            color: #bdc3c7;
        }

        .credit-footer p {
            margin: 5px 0;
            font-size: 0.9rem;
        }

        .credit-brand {
            color: white;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .red-dot {
            color: var(--gmiu-red);
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 1.8rem;
            }

            .main-content {
                grid-template-columns: 1fr;
                padding: 15px;
            }
        }

        /* infrastructure section  */
        /* =========================
   INFRASTRUCTURE STRIP
========================= */
        .infrastructure-strip {
            position: relative;
            width: 100%;
            margin: 60px 0;
            overflow: hidden;
        }

        .infrastructure-strip img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Overlay */
        .infrastructure-strip::after {
            /* content: '';
            position: absolute;
            inset: 0;
            background: rgba(30, 38, 74, 0.55); */
            /* navy overlay */
        }

        /* Title */
        .infrastructure-title {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            text-align: center;
        }

        .infrastructure-title h2 {
            color: #fff;
            font-size: 3rem;
            letter-spacing: 4px;
            font-weight: 800;
            text-transform: uppercase;
            border-bottom: 4px solid var(--gmiu-red);
            padding-bottom: 10px;
        }

        @media (max-width: 768px) {
            .infrastructure-title h2 {
                font-size: 1.8rem;
                letter-spacing: 2px;
            }
        }


        /* Syllabus section    */
        /* =========================
   PROGRAM ACCORDION
========================= */
        /* =========================
   PROGRAM SYLLABUS SECTION
========================= */
        .program-section {
            max-width: 1300px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .program-heading {
            text-align: center;
            margin-bottom: 50px;
        }

        .program-heading h2 {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--gmiu-navy);
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
        }

        .program-heading h2::after {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 0;
            width: 90px;
            height: 4px;
            background: linear-gradient(90deg,
                    var(--gmiu-navy),
                    var(--gmiu-red));
            border-radius: 5px;
        }

        .program-heading p {
            margin-top: 15px;
            font-size: 1.05rem;
            color: var(--gmiu-gray);
        }

        /* =========================
   PROGRAM ACCORDION (PREMIUM)
========================= */
        .program-accordion {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .program-item {
            background: #fff;
            border-radius: 0 20px 0 20px;
            /* same asymmetry */
            box-shadow: 0 15px 30px rgba(30, 38, 74, 0.12);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .program-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(30, 38, 74, 0.18);
        }

        /* Header */
        .program-header {
            background: linear-gradient(135deg,
                    var(--gmiu-navy) 0%,
                    #2a2f63 60%,
                    var(--gmiu-red) 100%);
            color: #fff;
            padding: 20px 28px;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            letter-spacing: 0.5px;
        }

        .program-header i {
            font-size: 1.2rem;
            transition: transform 0.35s ease;
        }

        .program-header.active i {
            transform: rotate(180deg);
        }

        /* Body */
        .program-body {
            display: none;
            padding: 25px 30px;
            background: #fafafa;
        }

        /* Subject row */
        .subject-row {
            display: grid;
            grid-template-columns: 1.2fr 3fr 1fr;
            gap: 18px;
            padding: 14px 0;
            align-items: center;
            border-bottom: 1px solid #e5e5e5;
        }

        .subject-row:last-child {
            border-bottom: none;
        }

        .subject-code {
            font-weight: 700;
            color: var(--gmiu-navy);
            font-size: 0.95rem;
        }

        .subject-name {
            font-size: 1rem;
            color: #333;
        }

        .subject-name small {
            display: block;
            color: var(--gmiu-gray);
            margin-top: 4px;
        }

        /* Syllabus button */
        .subject-syllabus a {
            background: var(--gmiu-red);
            color: #fff;
            padding: 7px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .subject-syllabus a:hover {
            background: #9e1f1c;
            transform: translateY(-2px);
        }

        /* Mobile */
        @media (max-width: 768px) {
            .program-heading h2 {
                font-size: 1.8rem;
            }

            .subject-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .subject-syllabus {
                margin-top: 6px;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo-container">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo">
        </div>
        <div class="logo-container">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" alt="GMIU Logo">
        </div>
        <!-- <div class="usp-badge">PLM USP</div> -->
    </header>

    <section class="hero">
        <h1>Key Features of the <br>Proficient Learning Method</h1>
        <p>Empowering Innovation through Excellence</p>
    </section>
    <section class="hero-after"></section>

    <section class="infrastructure-strip">
        <img src="infrastructure.jpg" alt="Infrastructure">
        <!-- <div class="infrastructure-title">
            <h2>Infrastructure</h2>
        </div> -->
    </section>


    <main class="main-content">

        <div class="feature-box">
            <i class="fa-solid fa-file-pen"></i>
            <span class="eng-title">Skill-Based Examination</span>
            <span class="hindi-title">कौशल-आधारित परीक्षा</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-face-smile"></i>
            <span class="eng-title">Stress-Free Teaching & Learning</span>
            <span class="hindi-title">तनावमुक्त शिक्षण एवं अधिगम</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-industry"></i>
            <span class="eng-title">Industry-Based Curriculum</span>
            <span class="hindi-title">उद्योग-आधारित पाठ्यक्रम</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-clock"></i>
            <span class="eng-title">Two-Hour Sessions</span>
            <span class="hindi-title">दो घंटे की कक्षाएँ</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-microchip"></i>
            <span class="eng-title">AI-Enabled Infrastructure</span>
            <span class="hindi-title">एआई-सक्षम अवसंरचना</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-vr-cardboard"></i>
            <span class="eng-title">Latest Simulation Tools</span>
            <span class="hindi-title">नवीनतम सिमुलेशन उपकरण</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-rocket"></i>
            <span class="eng-title">Research, Startup & Placement Orientation</span>
            <span class="hindi-title">शोध, स्टार्टअप एवं प्लेसमेंट उन्मुखता</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-laptop-code"></i>
            <span class="eng-title">Cutting-Edge Technologies</span>
            <span class="hindi-title">अत्याधुनिक प्रौद्योगिकियाँ</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-award"></i>
            <span class="eng-title">Minor, Honour & Specialization</span>
            <span class="hindi-title">माइनर, ऑनर्स एवं विशेषीकरण</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-globe"></i>
            <span class="eng-title">International Study Opportunities</span>
            <span class="hindi-title">अंतरराष्ट्रीय अध्ययन के अवसर</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-building-columns"></i>
            <span class="eng-title">Government / CA Examination Alignment</span>
            <span class="hindi-title">सरकारी / सीए परीक्षाओं के अनुरूप पाठ्यक्रम</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-lightbulb"></i>
            <span class="eng-title">Critical & Creative Thinking Approach</span>
            <span class="hindi-title">आलोचनात्मक एवं सृजनात्मक चिंतन दृष्टिकोण</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-laptop-house"></i>
            <span class="eng-title">Hybrid (Online/Offline) Teaching</span>
            <span class="hindi-title">हाइब्रिड (ऑनलाइन/ऑफलाइन) शिक्षण</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-flask-vial"></i>
            <span class="eng-title">Research-Oriented Laboratories</span>
            <span class="hindi-title">शोध-उन्मुख प्रयोगशालाएँ</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-om"></i>
            <span class="eng-title">Indian Cultural Environment</span>
            <span class="hindi-title">भारतीय सांस्कृतिक वातावरण</span>
        </div>

        <div class="feature-box">
            <i class="fa-solid fa-dumbbell"></i>
            <span class="eng-title">Sports & Physical Exercise</span>
            <span class="hindi-title">खेलकूद एवं शारीरिक व्यायाम</span>
        </div>

    </main>

    <section class="program-section">
        <div class="program-heading">
            <h2>PLM Curriculum Syllabus</h2>
            <p>Detailed subject syllabus aligned with Profficient Learning Method</p>
        </div>


        <?php foreach ($programs as $programId => $program): ?>
            <div class="program-item" style="margin-bottom: 5px;">

                <div class="program-header">
                    <?= ($program['name']) ?>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <div class="program-body">

                    <?php foreach ($program['subjects'] as $subject): ?>
                        <div class="subject-row">
                            <div class="subject-code">
                                <?= ($subject['subject_code']) ?>
                            </div>

                            <div class="subject-name">
                                <?= ($subject['subject_name']) ?>
                                <br>
                                <small>Semester:
                                    <?= $subject['sem'] ?>
                                </small>
                            </div>

                            <div class="subject-syllabus">
                                <?php if (!empty($subject['Syllabus'])): ?>
                                    <a href="https://gmiu.edu.in/gmiu/website_admin/uploads/Syllabus/<?= ($subject['Syllabus']) ?>"
                                        target="_blank">
                                        View PDF
                                    </a>
                                <?php else: ?>
                                    <span style="color:#999;">N/A</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        <?php endforeach; ?>

    </section>

    <!-- =========================
     PREMIUM TESTIMONIALS
========================= -->
    <section class="bg-white py-28">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-20">
                <h2 class="text-4xl font-extrabold text-[#1e264a]">
                    What Our Students Say
                </h2>
                <div class="w-24 h-1 bg-[#bc2823] mx-auto mt-6 rounded"></div>
            </div>

            <div class="relative overflow-hidden">

                <div id="testimonialSlider" class="flex transition-transform duration-700 ease-in-out w-full">

                    <!-- CLONE LAST (for smooth loop) -->
                    <div class="slide min-w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/sparsh-nimbark.png"
                                class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “Here,we have adopted the Proficient Learning Method and eliminated all rote-learning
                                theory examinations. My career has gained true momentum through the university’s strong
                                association with international universities.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Sparsh Nimbark</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                CSE Hons. Ai & ML
                            </span>
                        </div>
                    </div>

                    <!-- Slife 1 -->
                    <div class="slide min-w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/sparsh-nimbark.png"
                                class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “Here,we have adopted the Proficient Learning Method and eliminated all rote-learning
                                theory examinations. My career has gained true momentum through the university’s strong
                                association with international universities.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Sparsh Nimbark</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                CSE Hons. Ai & ML
                            </span>
                        </div>
                    </div>

                    <div class="slide min-w-full w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/mann-punjabi.png" class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “All the theory is converted into case studies, and all faculties teach us with a
                                research and practical-oriented approach aligned with future industrial demands.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Mann Punjabi</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                CSE Hons. AI & ML
                            </span>
                        </div>
                    </div>

                    <div class="slide min-w-full w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/piyush-kumar.png" class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “Here we have 2 hours of practical classes. There is no hard bifurcation between theory
                                and practical classes. We do case studies and practicals directly in the classroom.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Piyush Kumar</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                CSE Hons. AI & ML
                            </span>
                        </div>
                    </div>

                    <div class="slide min-w-full w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/salot-hitanga.png"
                                class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “My experience at GMIU has been truly enriching. The university provides a supportive
                                learning environment with knowledgeable faculties who are always ready to guide and
                                motivate students.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Salot Hitanga</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                BBA Hons. Innovation & Entrepreneurship
                            </span>
                        </div>
                    </div>

                    <div class="slide min-w-full w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/satramani-himesh.png"
                                class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “In the Proficient Learning Method, module-wise exams were well-structured and
                                concept-based. It encourages practical thinking and real-world business applications.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Satramani Himesh</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                BBA Hons. Innovation & Entrepreneurship
                            </span>
                        </div>
                    </div>

                    <div class="slide min-w-full w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/katariya-dhruv.png"
                                class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “The BBA Entrepreneurship and Innovation course through PLM is a remarkable initiative
                                that goes beyond traditional learning. The curriculum is case-study based and highly
                                engaging.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Katariya Dhruv</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                BBA Hons. Innovation & Entrepreneurship
                            </span>
                        </div>
                    </div>

                    <div class="slide min-w-full w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/devangi-gadhvi.png"
                                class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “The practical exposure is incredible — case-based learning, lab experiments, mock
                                diagnostics, and hands-on embryology work give us real-world experience.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Devangi Gadhavi</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                M.Sc. in Clinical Embryology
                            </span>
                        </div>
                    </div>

                    <div class="slide min-w-full w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/reeva-sutariya.png"
                                class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “Embryology at this institute is an industry-oriented program designed to provide
                                advanced theoretical knowledge and practical exposure in human developmental biology.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Reeva Sutaria</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                B.Sc. Microbiology Hons. – Clinical Embryology
                            </span>
                        </div>
                    </div>

                    <div class="slide min-w-full w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/dhanani-heer.png" class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “This type of teaching through well-organised conferences, seminars, and academic events
                                allows us to interact with professionals and gain practical insights into the field of
                                Forensic Science.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Dhanani Heer</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                B.Sc. Hons. Forensic Science
                            </span>
                        </div>
                    </div>



                    <!-- CLONE FIRST -->
                    <div class="slide min-w-full flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="../website_assets/images/testimonials/sparsh-nimbark.png"
                                class="w-80 md:w-[420px]">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <p class="text-xl text-gray-600 mb-8">
                                “Here,we have adopted the Proficient Learning Method and eliminated all rote-learning
                                theory examinations. My career has gained true momentum through the university’s strong
                                association with international universities.”
                            </p>
                            <h4 class="text-2xl font-bold text-[#1e264a]">Sparsh Nimbark</h4>
                            <span class="text-[#bc2823] font-semibold text-lg">
                                CSE Hons. Ai & ML
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <div class="video-section" style="margin-top: 80px; max-width: 1000px; margin-left: auto; margin-right: auto;">
        <div class="video-container"
            style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 30px; box-shadow: var(--card-hover-shadow); border: 8px solid #fff; background: #000;">
            <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                src="https://www.youtube.com/embed/8tmBEQPrMxQ" title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
    </div>

    <footer class="credit-footer">
        <p class="credit-brand">GYANMANJARI INNOVATIVE UNIVERSITY <span class="red-dot">•</span> BHAVNAGAR</p>
        <p>Profficient Learning Method (PLM)</p>
        <p>Website <a href="https://gmiu.edu.in"
                style="color: #ffffff; font-weight: 500; text-decoration: none;">GMIU</a></p>
        <p style="font-size: 0.75rem; margin-top: 20px;">Designed by <a href="https://aksharrathod.netlify.app"
                target="_blank" style="color: #ffffff; font-weight: 500; text-decoration: none;">Akshar Rathod</a>
        </p>
    </footer>

    <script>
        document.querySelectorAll('.program-header').forEach(header => {
            header.addEventListener('click', () => {
                header.classList.toggle('active');
                const body = header.nextElementSibling;
                body.style.display = body.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>


</body>

</html>