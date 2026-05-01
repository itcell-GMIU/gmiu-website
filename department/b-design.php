<?php include '../database/connect.php';
$facultu_id = 9;
$result = $con->query("SELECT * FROM tbl_faculty WHERE id = $facultu_id");
$data = $result->fetch_all(MYSQLI_ASSOC);
foreach ($data as $row) {
    $aboutFaculty = $row['description'];
}

$query = "SELECT 
            f.id AS faculty_id,
            l.id AS level_id,
            p.id AS program_id,
            f.faculty_slug,
            l.name AS level_name,
            p.name AS program_name,
            p.program_slug,
            p.duration
        FROM tbl_faculty AS f
        JOIN tbl_program AS p ON p.faculty_id = f.id
        JOIN tbl_level AS l ON l.id = p.level_id
        WHERE f.id = 9
        AND l.id NOT IN (15,16)
        AND p.is_active = 1
        AND p.is_delete = 0
        ORDER BY 
            FIELD(l.id, 2, 1, 5) DESC,
            l.id
";

$result = $con->query($query);
$programs = $result->fetch_all(MYSQLI_ASSOC);

$query = "
SELECT
    staff.id AS staff_id,
    staff.image AS staff_image,
    staff.email AS staff_email,
    staff.total_experience AS staff_total_experience,
    staff.name AS staff_name,
    staff.position AS staff_position,
    staff.work_since AS staff_work_since,

    GROUP_CONCAT(
        CONCAT(staff_quali.qualification, ' - ', staff_quali.branch)
        ORDER BY staff_quali.id ASC
        SEPARATOR ' | '
    ) AS staff_qualifications

FROM tbl_staff AS staff
LEFT JOIN tbl_staff_qualification AS staff_quali
    ON staff_quali.staff_id = staff.id

WHERE
    staff.is_delete = 0
    AND staff.is_active = 1
    AND staff.role_id IN (4, 8)
    AND EXISTS (
        SELECT 1
        FROM tbl_program p
        WHERE p.faculty_id = 9
        AND FIND_IN_SET(p.id, staff.program_id)
    )

GROUP BY staff.id

ORDER BY
    CASE
        WHEN staff.position = 'Director' THEN 0
        WHEN staff.position = 'Principal' THEN 1
        WHEN staff.position = 'HOD' THEN 2
        WHEN staff.position = 'HEAD OF DEPARTMENT' THEN 3
        ELSE 4
    END,
    staff.work_since ASC
";

$result = $con->query($query);
$staffs = $result->fetch_all(MYSQLI_ASSOC);

$hod = null;
$faculty = [];

foreach ($staffs as $staff) {
    if (
        strtoupper($staff['staff_position']) === 'HOD' ||
        strtoupper($staff['staff_position']) === 'HEAD OF DEPARTMENT'
    ) {
        $hod = $staff;
    } else {
        $faculty[] = $staff;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.Design (Bachelor of Design) | Gyanmanjari Innovative University, Gujarat, Bhavnagar</title>
    <meta name="description"
        content="Explore B.Design (Bachelor of Design) at Gyanmanjari Innovative University, Gujarat. Industry-focused curriculum, expert faculty, modern infrastructure & strong career opportunities. Apply now for 2026 admissions.">
    <meta name="keywords"
        content="B.Design, Bachelor of Design, Design Course in Gujarat, Design University India, GMIU B.Design, Fashion Design, Graphic Design, Interior Design">
    <link rel="canonical" href="https://gmiu.edu.in/gmiu/department/b-design.php">

    <!-- Open Graph -->
    <meta property="og:title"
        content="B.Design (Bachelor of Design) | Gyanmanjari Innovative University, Gujrat, Bhavnagar">
    <meta property="og:description"
        content="Build a creative career with B.Design at GMIU. Industry-aligned curriculum, expert mentors, and excellent placement support.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://gmiu.edu.in/gmiu/department/b-design.php">
    <meta property="og:image" content="https://admission.gmiu.edu.in/new/website_assets/images/logo-single.jpg">

    <!-- Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&family=Outfit:wght@300;400;600&display=swap');

        :root {
            --navy: #1e264a;
            --red: #bc2823;
            --dark-grey: #4d4d4d;
            --grey: #808080;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--dark-grey);
            overflow-x: hidden;
        }

        /* ==============================
           Custom Scrollbar – GMIU Theme
           ============================== */

        /* ===== Invisible Premium Scrollbar ===== */

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        body:hover ::-webkit-scrollbar-thumb {
            opacity: 1;
        }


        h1,
        h2,
        h3,
        h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: var(--navy);
        }

        .bg-navy {
            background-color: var(--navy);
        }

        .bg-red {
            background-color: var(--red);
        }

        .text-red {
            color: var(--red);
        }

        .text-navy {
            color: var(--navy);
        }

        .btn-red {
            background-color: var(--red);
            color: white;
            transition: all 0.4s ease;
        }

        .btn-red:hover {
            background-color: var(--navy);
            transform: scale(1.05);
        }

        .border-red {
            border-color: var(--red);
        }

        /* Timeline styles */
        .roadmap-line {
            width: 2px;
            background: linear-gradient(to bottom, var(--red), var(--navy));
        }
    </style>
</head>

<body class="bg-white">

    <nav class="fixed w-full z-[100] bg-white/90 backdrop-blur-md border-b border-gray-100"
        aria-label="Primary Navigation">

        <div class="container mx-auto px-3 py-2 flex justify-between items-center">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" aria-label="Gyanmanjari Innovative University Home">
                    <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png"
                        alt="Gyanmanjari Innovative University Logo" class="h-12 w-auto object-contain">
                </a>
            </div>

            <!-- Desktop Menu -->
            <ul class="hidden lg:flex space-x-8 font-bold text-[11px] uppercase tracking-widest items-center">
                <li><a href="#home" class="hover:text-red transition">Home</a></li>
                <li><a href="#about" class="hover:text-red transition">About</a></li>
                <li><a href="#programs" class="hover:text-red transition">Programs</a></li>
                <li><a href="#hod" class="hover:text-red transition">HOD</a></li>
                <li><a href="#faculty" class="hover:text-red transition">Faculty</a></li>
                <li><a href="#gallery" class="hover:text-red transition">Gallery</a></li>
                <li><a href="#placements" class="hover:text-red transition">Placements</a></li>
                <li>
                    <a href="https://gmiu.edu.in/gmiu/admission/" class="btn-red px-6 py-3 rounded-full" target="_blank"
                        rel="noopener noreferrer">
                        Apply 2026
                    </a>
                </li>
            </ul>

            <!-- Mobile Menu Button -->
            <button id="menuBtn" class="lg:hidden text-navy text-2xl focus:outline-none" aria-label="Open Mobile Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-gray-100">
            <ul class="flex flex-col px-6 py-6 space-y-6 font-bold text-xs uppercase tracking-widest">
                <li><a href="#home" class="hover:text-red transition">Home</a></li>
                <li><a href="#about" class="hover:text-red">About</a></li>
                <li><a href="#programs" class="hover:text-red">Programs</a></li>
                <li><a href="#hod" class="hover:text-red">HOD</a></li>
                <li><a href="#faculty" class="hover:text-red">Faculty</a></li>
                <li><a href="#gallery" class="hover:text-red">Gallery</a></li>
                <li><a href="#placements" class="hover:text-red">Placements</a></li>
                <li>
                    <a href="https://gmiu.edu.in/gmiu/admission/" class="btn-red text-center py-3 rounded-full"
                        target="_blank" rel="noopener noreferrer">
                        Apply 2026
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="relative min-h-screen flex items-center pt-20 bg-navy overflow-hidden" id="home">

        <!-- Background Image -->
        <div class="absolute inset-0 opacity-40">
            <img src="./assets/images/b-design.png" class="w-full h-full object-cover"
                alt="B.Design in Interior and Furniture Design at Gyanmanjari Innovative University">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl">

                <!-- University Name -->
                <p class="text-red font-bold tracking-[0.4em] uppercase text-sm mb-4" data-aos="fade-right">
                    Gyanmanjari Innovative University
                </p>

                <!-- Primary H1 -->
                <h1 class="text-4xl md:text-6xl lg:text-7xl text-white mb-6 leading-tight">
                    B.Design in <span class="text-red italic">Interior & Furniture Design</span>
                </h1>

                <!-- Supporting Line (Marketing) -->
                <h2 class="text-xl md:text-2xl text-gray-200 mb-6 font-light">
                    Design the Future with Creativity, Innovation & Spatial Excellence
                </h2>

                <!-- SEO-Optimized Description -->
                <p class="text-gray-300 text-lg mb-10 max-w-xl font-light">
                    The Bachelor of Design (B.Design) program at GMIU focuses on Interior and Furniture Design,
                    blending spatial logic, material innovation, sustainability, and contemporary design thinking
                    to prepare students for global creative careers.
                </p>

                <!-- CTAs -->
                <div class="flex flex-wrap gap-5" data-aos="fade-up" data-aos-delay="400">
                    <a href="https://gmiu.edu.in/gmiu/admission/"
                        class="btn-red px-10 py-5 rounded font-bold uppercase tracking-widest text-xs" target="_blank"
                        rel="noopener noreferrer">
                        Apply for B.Design 2026
                    </a>

                    <a href="#programs" class="border border-white/20 text-white hover:bg-white hover:text-[var(--navy)]
                          px-10 py-5 rounded font-bold uppercase tracking-widest text-xs transition">
                        Explore Program
                    </a>
                </div>

            </div>
        </div>
    </section>

    <section id="about" class="py-24 bg-white">
        <div class="container mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100">

                <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-4">
                    About the Design Program
                </h6>

                <h2 class="text-4xl text-navy">
                    Design Education at Gyanmanjari Innovative University
                </h2>
            </div>

            <!-- CONTENT GRID -->
            <div class="grid lg:grid-cols-12 gap-16 items-center">

                <!-- TEXT (60%) -->
                <div class="lg:col-span-7" data-aos="fade-right" data-aos-delay="200">

                    <p class="text-grey text-lg leading-relaxed font-light text-justify">
                        <?php echo trim(str_replace('&nbsp;', ' ', strip_tags($aboutFaculty))); ?>
                    </p>
                </div>

                <!-- VIDEO (40%) -->
                <div class="lg:col-span-5" data-aos="fade-left" data-aos-delay="300">

                    <!-- Video Thumbnail -->
                    <div class="group relative aspect-video rounded overflow-hidden
                        shadow-2xl cursor-pointer" onclick="openVideoModal('0iCczYv_zcI')">

                        <img src="https://img.youtube.com/vi/0iCczYv_zcI/maxresdefault.jpg"
                            alt="About the Design Program at Gyanmanjari Innovative University" class="w-full h-full object-cover transition-transform duration-500
                                group-hover:scale-105">

                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black/40
                            flex items-center justify-center
                            opacity-0 group-hover:opacity-100
                            transition-opacity">

                            <div class="w-16 h-16 bg-red rounded-full
                                flex items-center justify-center shadow-xl">
                                <svg class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4.5 3.5v13L16 10z" />
                                </svg>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Video Modal -->
    <div id="videoModal" class="fixed inset-0 z-[200] hidden bg-black/80 backdrop-blur-sm
            flex items-center justify-center">

        <div class="relative w-full max-w-4xl aspect-video rounded-2xl overflow-hidden bg-black">

            <!-- Close Button (VISIBLE & SAFE) -->
            <button onclick="closeVideoModal()" class="absolute top-3 right-3 z-10
                       w-10 h-10 rounded-full
                       bg-black/70 text-white text-2xl
                       flex items-center justify-center
                       hover:bg-red transition">
                &times;
            </button>

            <!-- YouTube Iframe -->
            <iframe id="videoFrame" class="w-full h-full" src="" frameborder="0"
                allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen>
            </iframe>

        </div>
    </div>

    <section class="py-16 bg-navy">
        <div class="container mx-auto px-6">
            <div
                class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-10 text-center md:text-left">

                <!-- Text Content -->
                <div>
                    <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-3" data-aos="fade-up">
                        Admission 2025–2026
                    </h6>

                    <h2 class="text-3xl md:text-4xl text-white mb-4" data-aos="fade-up" data-aos-delay="100">
                        For B.Design Admission Enquiries
                    </h2>

                    <p class="text-gray-300 text-lg font-light" data-aos="fade-up" data-aos-delay="200">
                        <i class="fa-solid fa-phone text-red mr-2"></i>
                        <a href="tel:+919099951160" class="hover:underline">+91 90999 51160</a>,
                        <a href="tel:+917574949494" class="hover:underline">+91 75749 49494</a>
                    </p>
                </div>

                <!-- Button -->
                <div data-aos="fade-up" data-aos-delay="300">
                    <a href="https://gmiu.edu.in/gmiu/admission/" target="_blank" rel="noopener noreferrer"
                        class="btn-red px-10 py-4 rounded-full font-bold uppercase tracking-widest text-xs inline-block">
                        Apply for B.Design 2026
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- <section class="py-12 bg-white border-b">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12 text-center">
                <div data-aos="zoom-in">
                    <span class="block text-4xl font-black text-navy">#1</span>
                    <span class="text-[10px] uppercase tracking-widest text-grey font-bold">Design School Rank</span>
                </div>
                <div data-aos="zoom-in" data-aos-delay="100">
                    <span class="block text-4xl font-black text-red">400+</span>
                    <span class="text-[10px] uppercase tracking-widest text-grey font-bold">Studio Hours/Year</span>
                </div>
                <div data-aos="zoom-in" data-aos-delay="200">
                    <span class="block text-4xl font-black text-navy">25+</span>
                    <span class="text-[10px] uppercase tracking-widest text-grey font-bold">Global Lab Access</span>
                </div>
                <div data-aos="zoom-in" data-aos-delay="300">
                    <span class="block text-4xl font-black text-red">10k+</span>
                    <span class="text-[10px] uppercase tracking-widest text-grey font-bold">Alumni Network</span>
                </div>
            </div>
        </div>
    </section> -->

    <!-- <section id="roadmap" class="py-24 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-4xl text-navy">The 4-Year Journey</h2>
                <div class="w-20 h-1 bg-red mx-auto mt-4"></div>
            </div>

            <div class="relative max-w-4xl mx-auto">
                <div class="absolute left-1/2 transform -translate-x-1/2 h-full roadmap-line hidden md:block"></div>

                <div class="flex flex-col md:flex-row items-center mb-16" data-aos="fade-up">
                    <div class="md:w-1/2 md:pr-12 md:text-right mb-4 md:mb-0">
                        <h4 class="text-red text-xl">Year 01: Foundation</h4>
                        <p class="text-sm text-grey mt-2">Design thinking, basic sketching, and material exploration.
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 bg-navy rounded-full border-4 border-white z-10 flex items-center justify-center text-white text-xs font-bold">
                        01</div>
                    <div class="md:w-1/2 md:pl-12"></div>
                </div>

                <div class="flex flex-col md:flex-row items-center mb-16" data-aos="fade-up">
                    <div class="md:w-1/2 md:pr-12"></div>
                    <div
                        class="w-10 h-10 bg-red rounded-full border-4 border-white z-10 flex items-center justify-center text-white text-xs font-bold">
                        02</div>
                    <div class="md:w-1/2 md:pl-12">
                        <h4 class="text-navy text-xl">Year 02: Space & Form</h4>
                        <p class="text-sm text-grey mt-2">Residential interior design and furniture prototyping basics.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center mb-16" data-aos="fade-up">
                    <div class="md:w-1/2 md:pr-12 md:text-right mb-4 md:mb-0">
                        <h4 class="text-red text-xl">Year 03: Specialization</h4>
                        <p class="text-sm text-grey mt-2">Commercial spaces, lighting design, and advanced CAD/BIM.</p>
                    </div>
                    <div
                        class="w-10 h-10 bg-navy rounded-full border-4 border-white z-10 flex items-center justify-center text-white text-xs font-bold">
                        03</div>
                    <div class="md:w-1/2 md:pl-12"></div>
                </div>

                <div class="flex flex-col md:flex-row items-center" data-aos="fade-up">
                    <div class="md:w-1/2 md:pr-12"></div>
                    <div
                        class="w-10 h-10 bg-red rounded-full border-4 border-white z-10 flex items-center justify-center text-white text-xs font-bold">
                        04</div>
                    <div class="md:w-1/2 md:pl-12">
                        <h4 class="text-navy text-xl">Year 04: Thesis</h4>
                        <p class="text-sm text-grey mt-2">Industry internship and professional graduation project.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <section class="py-24 bg-gray-50" id="programs">
        <div class="container mx-auto px-6">

            <!-- Section Heading -->
            <div class="text-center mb-16">
                <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-4" data-aos="fade-up">
                    About Our Programs
                </h6>

                <h2 class="text-4xl text-navy" data-aos="fade-up" data-aos-delay="100">
                    B.Design Programs at Gyanmanjari Innovative University
                </h2>
            </div>

            <!-- Cards Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-12">
                <?php foreach ($programs as $index => $program): ?>

                    <a href="https://gmiu.edu.in/gmiu/website/faculty/<?= $program['faculty_slug'] ?>/<?= $program['program_slug']; ?>"
                        target="_blank" rel="noopener noreferrer" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>"
                        class="group relative bg-white p-8
                          shadow-sm hover:shadow-2xl
                          transition-all duration-500
                          hover:-translate-y-2">

                        <!-- Top Accent Line -->
                        <span class="absolute top-0 left-0 h-1 w-0 bg-red
                    transition-all duration-500 group-hover:w-full"></span>

                        <!-- Level Badge -->
                        <span class="inline-block mb-6 px-1 py-1 rounded-full text-[10px]
                                 font-bold uppercase tracking-widest
                                 bg-red/10 text-red">
                            <?= $program['level_name']; ?>
                        </span>

                        <!-- Program Name (H3) -->
                        <h3 class="text-xl text-navy mb-4 leading-snug
                               transition-colors duration-300
                               group-hover:text-red">
                            <?= $program['program_name']; ?>
                        </h3>

                        <!-- Meta Info -->
                        <p class="text-sm text-grey mb-10">
                            Duration:
                            <span class="font-semibold">
                                <?= $program['duration']; ?>
                            </span>
                        </p>

                        <!-- CTA -->
                        <div class="flex items-center text-red font-bold text-xs uppercase tracking-widest">
                            <span>View Program Details
                            </span>
                            <i class="fa-solid fa-arrow-right ml-2
                                   transition-transform duration-300
                                   group-hover:translate-x-2"></i>
                        </div>

                    </a>

                <?php endforeach; ?>
            </div>

        </div>
    </section>


    <!-- <section id="faculty" class="py-24">
        <div class="container mx-auto px-6 text-center">
            <h6 class="text-red font-bold uppercase tracking-widest text-xs mb-4">Learn from Experts</h6>
            <h2 class="text-4xl text-navy mb-16">Global Faculty Mentors</h2>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="group" data-aos="fade-up">
                    <div class="relative overflow-hidden mb-6">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=600"
                            class="w-full grayscale hover:grayscale-0 transition duration-500" alt="Faculty 1">
                    </div>
                    <h3 class="text-lg uppercase">Prof. Sarah Jenkins</h3>
                    <p class="text-red text-[10px] font-bold tracking-widest uppercase mt-1">Head of Furniture Design
                    </p>
                </div>
                <div class="group" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative overflow-hidden mb-6">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=600"
                            class="w-full grayscale hover:grayscale-0 transition duration-500" alt="Faculty 2">
                    </div>
                    <h3 class="text-lg uppercase">Dr. Robert Chen</h3>
                    <p class="text-red text-[10px] font-bold tracking-widest uppercase mt-1">Spatial Ergonomics Expert
                    </p>
                </div>
                <div class="group" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative overflow-hidden mb-6">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=600"
                            class="w-full grayscale hover:grayscale-0 transition duration-500" alt="Faculty 3">
                    </div>
                    <h3 class="text-lg uppercase">Elena Moretti</h3>
                    <p class="text-red text-[10px] font-bold tracking-widest uppercase mt-1">Sustainable Material Lead
                    </p>
                </div>
            </div>
        </div>
    </section> -->

    <?php if ($hod): ?>
        <section id="hod" class="py-24 bg-white">
            <div class="container mx-auto px-6">

                <!-- Heading -->
                <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100">

                    <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-4">
                        Head of the Design Department
                    </h6>

                    <h2 class="text-4xl text-navy">
                        Academic Leadership in Design Education
                    </h2>
                </div>

                <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-20 items-center">

                    <!-- Portrait Image -->
                    <div class="flex justify-center" data-aos="fade-right" data-aos-delay="200">

                        <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/profile/<?= $hod['staff_image']; ?>"
                            alt="<?= $hod['staff_name']; ?>, Head of Design Department at Gyanmanjari Innovative University"
                            class="w-[360px] h-[520px] object-cover rounded-2xl
                            shadow-2xl grayscale hover:grayscale-0
                            transition duration-500">
                    </div>

                    <!-- Content -->
                    <div data-aos="fade-left" data-aos-delay="300">

                        <h3 class="text-3xl text-navy mb-2">
                            <?= $hod['staff_name']; ?>
                        </h3>

                        <p class="text-red font-bold uppercase tracking-widest text-xs mb-6">
                            <?= $hod['staff_position']; ?> – Design Department
                        </p>

                        <p class="text-grey text-lg leading-relaxed font-light mb-8">
                            An academic leader in design education at Gyanmanjari Innovative University,
                            with extensive experience in curriculum development, industry collaboration,
                            and mentoring future designers.
                        </p>

                        <ul class="space-y-3 text-sm text-grey mb-8">
                            <li>
                                <strong class="text-navy">Total Experience:</strong>
                                <?= $hod['staff_total_experience']; ?> Years
                            </li>
                            <li>
                                <strong class="text-navy">Working Since:</strong>
                                <?= $hod['staff_work_since']; ?>
                            </li>
                        </ul>

                        <?php if ($hod['staff_qualifications']): ?>
                            <ul class="space-y-2 text-sm text-grey">
                                <?php foreach (array_slice(explode(' | ', $hod['staff_qualifications']), 0, 3) as $q): ?>
                                    <li><?= $q; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="py-24 bg-gray-50" id="faculty" aria-label="Design Faculty at Gyanmanjari Innovative University">

        <div class="container mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100">

                <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-4">
                    Faculty of the Design Department
                </h6>

                <h2 class="text-4xl text-navy">
                    Design Faculty at Gyanmanjari Innovative University
                </h2>
            </div>

            <!-- Faculty Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 justify-items-center">
                <?php
                $delay = 0;
                foreach ($faculty as $staff):
                    $delay += 100;
                    ?>

                    <div data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
                        <div class="group bg-white rounded-2xl overflow-hidden
                                shadow-sm hover:shadow-2xl
                                relative top-0 hover:-top-2
                                transition-[top,box-shadow] duration-300 ease-out">

                            <!-- Portrait Image -->
                            <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/profile/<?= $staff['staff_image']; ?>"
                                loading="lazy"
                                alt="<?= $staff['staff_name']; ?>, <?= $staff['staff_position']; ?>, Design Department at Gyanmanjari Innovative University"
                                class="w-full h-[420px] object-cover
                                    grayscale hover:grayscale-0
                                    transition duration-500">

                            <!-- Content -->
                            <div class="p-6">

                                <h3 class="text-lg text-navy mb-1">
                                    <?= $staff['staff_name']; ?>
                                </h3>

                                <p class="text-red font-bold text-[10px] uppercase tracking-widest mb-3">
                                    <?= $staff['staff_position']; ?> – Design Department
                                </p>

                                <ul class="text-xs text-grey space-y-1 mb-4">
                                    <li>
                                        <strong class="text-navy">Experience:</strong>
                                        <?= $staff['staff_total_experience']; ?> years
                                    </li>
                                    <li>
                                        <strong class="text-navy">Working Since:</strong>
                                        <?= $staff['staff_work_since']; ?>
                                    </li>
                                </ul>

                                <?php if ($staff['staff_qualifications']): ?>
                                    <ul class="text-[11px] text-grey space-y-1 mb-5">
                                        <?php foreach (array_slice(explode(' | ', $staff['staff_qualifications']), 0, 2) as $q): ?>
                                            <li><?= $q; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <section class="py-24 bg-navy overflow-hidden" id="gallery">
        <div class="container mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100">

                <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-4">
                    Student Showcases
                </h6>
                <h2 class="text-4xl text-white">
                    Creative Work by Our Students
                </h2>
            </div>

            <!-- Masonry Grid (4 Columns) -->
            <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6">

                <!-- Image 1 -->
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=80"
                    onclick="openImageModal(this.src)" data-aos="fade-up" data-aos-delay="100" class="w-full rounded-2xl shadow-xl break-inside-avoid
                        cursor-pointer
                        grayscale hover:grayscale-0 hover:scale-[1.02]
                        transition-all duration-300" alt="Student Work">

                <!-- Image 2 -->
                <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=900&q=80"
                    onclick="openImageModal(this.src)" data-aos="fade-up" data-aos-delay="200" class="w-full rounded-2xl shadow-xl break-inside-avoid
                        cursor-pointer
                        grayscale hover:grayscale-0 hover:scale-[1.02]
                        transition-all duration-300" alt="Student Work">

                <!-- Image 3 -->
                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=900&q=80"
                    onclick="openImageModal(this.src)" data-aos="fade-up" data-aos-delay="300" class="w-full rounded-2xl shadow-xl break-inside-avoid
                        cursor-pointer
                        grayscale hover:grayscale-0 hover:scale-[1.02]
                        transition-all duration-300" alt="Student Work">

                <!-- Image 4 -->
                <img src="https://images.unsplash.com/photo-1616046229478-9901c5536a45?auto=format&fit=crop&w=900&q=80"
                    onclick="openImageModal(this.src)" data-aos="fade-up" data-aos-delay="400" class="w-full rounded-2xl shadow-xl break-inside-avoid
                        cursor-pointer
                        grayscale hover:grayscale-0 hover:scale-[1.02]
                        transition-all duration-300" alt="Student Work">

                <!-- Image 5 -->
                <img src="https://images.unsplash.com/photo-1600210492493-0946911123ea?auto=format&fit=crop&w=900&q=80"
                    onclick="openImageModal(this.src)" data-aos="fade-up" data-aos-delay="500" class="w-full rounded-2xl shadow-xl break-inside-avoid
                        cursor-pointer
                        grayscale hover:grayscale-0 hover:scale-[1.02]
                        transition-all duration-300" alt="Student Work">

                <!-- Image 6 -->
                <img src="https://images.unsplash.com/photo-1600121848594-d8644e57abab?auto=format&fit=crop&w=900&q=80"
                    onclick="openImageModal(this.src)" data-aos="fade-up" data-aos-delay="600" class="w-full rounded-2xl shadow-xl break-inside-avoid
                        cursor-pointer
                        grayscale hover:grayscale-0 hover:scale-[1.02]
                        transition-all duration-300" alt="Student Work">

                <!-- Image 7 -->
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=900&q=80"
                    onclick="openImageModal(this.src)" data-aos="fade-up" data-aos-delay="700" class="w-full rounded-2xl shadow-xl break-inside-avoid
                        cursor-pointer
                        grayscale hover:grayscale-0 hover:scale-[1.02]
                        transition-all duration-300" alt="Student Work">

                <!-- Image 8 -->
                <img src="https://images.unsplash.com/photo-1615874694520-474822394e73?auto=format&fit=crop&w=900&q=80"
                    onclick="openImageModal(this.src)" data-aos="fade-up" data-aos-delay="800" class="w-full rounded-2xl shadow-xl break-inside-avoid
                        cursor-pointer
                        grayscale hover:grayscale-0 hover:scale-[1.02]
                        transition-all duration-300" alt="Student Work">

            </div>

        </div>
    </section>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-[300] hidden bg-black/80 backdrop-blur-sm
            flex items-center justify-center" onclick="closeImageModal()">

        <div class="relative max-w-5xl w-full mx-4" onclick="event.stopPropagation()">

            <!-- Close Button -->
            <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white text-3xl
                       hover:text-red transition">
                &times;
            </button>

            <!-- Image -->
            <img id="modalImage" src="" class="w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl"
                alt="Student Work Preview">
        </div>
    </div>

    <section class="py-20 bg-gray-50" aria-label="GMIU Philosophy and Values">
        <div class="container mx-auto px-6">

            <div class="max-w-4xl mx-auto text-center">

                <!-- Sanskrit Tagline -->
                <h2 class="text-3xl md:text-4xl text-navy font-extrabold mb-6 tracking-wide" data-aos="fade-up"
                    data-aos-delay="100">
                    <span lang="sa">दिव्यम् ददाति ते चक्षुः</span>
                </h2>

                <!-- Divider -->
                <div class="w-16 h-1 bg-red mx-auto mb-6" data-aos="zoom-in" data-aos-delay="200"></div>

                <!-- Explanation -->
                <p class="text-grey text-lg font-light leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                    The phrase signifies the bestowal of divine vision — a deeper insight that goes beyond
                    physical sight. At Gyanmanjari Innovative University, education is not limited to
                    acquiring knowledge; it is about nurturing clarity of thought, creative perception,
                    and the ability to envision possibilities that shape the future.
                </p>

            </div>

        </div>
    </section>

    <section class="py-28 bg-gradient-to-b from-gray-50 to-white"
        aria-label="Why Study at Gyanmanjari Innovative University">

        <div class="container mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-20 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">

                <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-4">
                    Why Study at GMIU
                </h6>

                <h2 class="text-4xl md:text-5xl text-navy mb-4">
                    A Learning Ecosystem That Shapes Futures
                </h2>

                <!-- DO NOT CHANGE CONTENT -->
                <p class="text-grey text-lg font-light" data-aos="fade-up" data-aos-delay="200">
                    GMIU combines academic excellence, industry exposure, and innovation-driven learning
                    to prepare students for real-world success.
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid gap-10 md:grid-cols-2">

                <!-- Card 1 -->
                <div data-aos="fade-up" data-aos-delay="100">
                    <article class="group relative bg-white rounded-3xl p-8 border
                                shadow-sm hover:shadow-2xl
                                transition-all duration-300 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red to-navy"></div>

                        <div class="flex gap-5 items-start">
                            <div class="w-14 h-14 rounded-2xl bg-red/10 text-red
                                    flex items-center justify-center text-2xl
                                    group-hover:scale-110 transition">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>

                            <div>
                                <h3 class="text-2xl text-navy mb-3">
                                    Highest Placement
                                </h3>

                                <!-- CONTENT UNCHANGED -->
                                <p class="text-grey text-sm leading-relaxed">
                                    GMIU follows a transparent and structured placement process,
                                    ensuring every student gets equal opportunity aligned with
                                    skills, eligibility, and recruiter expectations.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Card 2 -->
                <div data-aos="fade-up" data-aos-delay="200">
                    <article class="group relative bg-white rounded-3xl p-8 border
                                shadow-sm hover:shadow-2xl
                                transition-all duration-500 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red to-navy"></div>

                        <div class="flex gap-5 items-start">
                            <div class="w-14 h-14 rounded-2xl bg-red/10 text-red
                                    flex items-center justify-center text-2xl
                                    group-hover:scale-110 transition">
                                <i class="fa-solid fa-rocket"></i>
                            </div>

                            <div>
                                <h3 class="text-2xl text-navy mb-3">
                                    Support to Startups
                                </h3>

                                <p class="text-grey text-sm leading-relaxed">
                                    GMIU actively promotes entrepreneurship by helping students
                                    ideate, validate, and scale startups through mentoring,
                                    incubation support, and institutional guidance.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Card 3 -->
                <div data-aos="fade-up" data-aos-delay="300">
                    <article class="group relative bg-white rounded-3xl p-8 border
                                shadow-sm hover:shadow-2xl
                                transition-all duration-500 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red to-navy"></div>

                        <div class="flex gap-5 items-start">
                            <div class="w-14 h-14 rounded-2xl bg-red/10 text-red
                                    flex items-center justify-center text-2xl
                                    group-hover:scale-110 transition">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>

                            <div>
                                <h3 class="text-2xl text-navy mb-3">
                                    Excellent Academic System
                                </h3>

                                <p class="text-grey text-sm leading-relaxed">
                                    A strong academic framework driven by highly qualified faculty,
                                    modern infrastructure, and a research-oriented teaching–learning
                                    process defines the GMIU experience.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Card 4 -->
                <div data-aos="fade-up" data-aos-delay="400">
                    <article class="group relative bg-white rounded-3xl p-8 border
                                shadow-sm hover:shadow-2xl
                                transition-all duration-500 overflow-hidden">

                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red to-navy"></div>

                        <div class="flex gap-5 items-start">
                            <div class="w-14 h-14 rounded-2xl bg-red/10 text-red
                                    flex items-center justify-center text-2xl
                                    group-hover:scale-110 transition">
                                <i class="fa-solid fa-lightbulb"></i>
                            </div>

                            <div>
                                <h3 class="text-2xl text-navy mb-3">
                                    Research &amp; Innovation (R&amp;I)
                                </h3>

                                <p class="text-grey text-sm leading-relaxed">
                                    Research and innovation form the backbone of GMIU’s academic
                                    culture, empowering students to transform ideas into impactful
                                    solutions for sustainable growth.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>

            </div>

        </div>
    </section>

    <section class="py-24 bg-white" id="placements"
        aria-label="Student Placements at Gyanmanjari Innovative University">

        <div class="container mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-16" data-aos="fade-up" data-aos-delay="100">

                <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-4">
                    Placements
                </h6>

                <h2 class="text-4xl text-navy mb-4">
                    Our Students, Our Pride
                </h2>

                <!-- CONTENT UNCHANGED -->
                <p class="text-grey text-lg font-light max-w-2xl mx-auto">
                    Celebrating the success stories of our students placed in leading
                    organizations through GMIU’s strong industry connections.
                </p>
            </div>

            <!-- Image Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">

                <!-- Image 1 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden
                        flex items-center justify-center" data-aos="fade-up" data-aos-delay="100">

                    <img src="https://gmiu.edu.in/gmiu/website_assets/placements-image/1.jpg" loading="lazy"
                        alt="GMIU student placement success in leading organization" class="w-full h-auto object-cover
                            transform scale-100
                            transition-transform duration-500 ease-out
                            hover:scale-105">
                </div>

                <!-- Image 2 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden
                        flex items-center justify-center" data-aos="fade-up" data-aos-delay="200">

                    <img src="https://gmiu.edu.in/gmiu/website_assets/placements-image/2.jpg" loading="lazy"
                        alt="Design student placed through GMIU campus placements" class="w-full h-auto object-cover
                            transform scale-100
                            transition-transform duration-500 ease-out
                            hover:scale-105">
                </div>

                <!-- Image 3 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden
                        flex items-center justify-center" data-aos="fade-up" data-aos-delay="300">

                    <img src="https://gmiu.edu.in/gmiu/website_assets/placements-image/3.jpg" loading="lazy"
                        alt="Successful campus placement at Gyanmanjari Innovative University" class="w-full h-auto object-cover
                            transform scale-100
                            transition-transform duration-500 ease-out
                            hover:scale-105">
                </div>

                <!-- Image 4 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden
                        flex items-center justify-center" data-aos="fade-up" data-aos-delay="400">

                    <img src="https://gmiu.edu.in/gmiu/website_assets/placements-image/4.jpg" loading="lazy"
                        alt="GMIU placement highlight showcasing student achievement" class="w-full h-auto object-cover
                            transform scale-100
                            transition-transform duration-500 ease-out
                            hover:scale-105">
                </div>

            </div>

            <!-- CTA -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="500">

                <a href="https://gmiu.edu.in/gmiu/placement.php" target="_blank" rel="noopener noreferrer" class="inline-block btn-red px-10 py-4 rounded-full
                      font-bold uppercase tracking-widest text-xs">
                    View More Placements
                </a>
            </div>

        </div>
    </section>

    <section class="py-16 bg-gray-50" aria-label="Hostel Facility Enquiries at Gyanmanjari Innovative University">

        <div class="container mx-auto px-6">

            <div class="max-w-4xl mx-auto bg-white rounded-3xl p-10
                    shadow-lg border flex flex-col md:flex-row
                    items-center justify-between gap-10" data-aos="fade-up" data-aos-delay="100">

                <!-- Text Content -->
                <div data-aos="fade-right" data-aos-delay="200">

                    <h6 class="text-red font-bold uppercase tracking-[0.4em] text-xs mb-3">
                        Hostel Facility
                    </h6>

                    <h2 class="text-2xl md:text-3xl text-navy mb-4">
                        Hostel Facility Related Enquiries
                    </h2>

                    <p class="text-grey text-sm mb-4">
                        For information regarding hostel accommodation and facilities,
                        please contact us using the details below.
                    </p>

                    <ul class="space-y-2 text-sm text-grey">
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-red"></i>
                            <a href="tel:+919099951160" class="hover:underline">
                                +91 90999 51160
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-red"></i>
                            <a href="tel:+917574949494" class="hover:underline">
                                +91 75749 49494
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- CTA -->
                <div data-aos="fade-left" data-aos-delay="300">
                    <a href="tel:+919099951160" class="btn-red px-4 py-3 rounded-full
                          font-bold uppercase tracking-widest text-xs inline-block"
                        aria-label="Call GMIU Hostel Enquiry Number">
                        Contact Us
                    </a>
                </div>

            </div>

        </div>
    </section>

    <footer class="bg-navy text-white" aria-label="Gyanmanjari Innovative University Footer">

        <div class="container mx-auto px-6">

            <!-- TOP FOOTER -->
            <div class="grid gap-12 py-20 md:grid-cols-3 border-b border-white/10">

                <!-- WHO WE ARE -->
                <section aria-labelledby="footer-about">
                    <h3 id="footer-about" class="text-lg font-bold mb-4 uppercase tracking-widest text-white">
                        Who We Are?
                    </h3>

                    <p class="text-gray-300 text-sm leading-relaxed mb-6">
                        The Gyanmanjari Innovative University has been founded with the sole
                        purpose of creating world-class professionals by converting global
                        challenges into opportunities through
                        <strong class="text-white">
                            “Value Embedded Quality Technical Education”.
                        </strong>
                    </p>

                    <ul class="space-y-3 text-sm text-gray-300">

                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-phone text-red mt-1" aria-hidden="true"></i>
                            <a href="tel:+919099951160" class="hover:text-white transition">
                                +91 90999 51160
                            </a>
                        </li>

                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-phone text-red mt-1" aria-hidden="true"></i>
                            <a href="tel:+917574949494" class="hover:text-white transition">
                                +91 75749 49494
                            </a>
                        </li>

                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-envelope text-red mt-1" aria-hidden="true"></i>
                            <a href="mailto:info@gmiu.edu.in" class="hover:text-white transition">
                                info@gmiu.edu.in
                            </a>
                        </li>

                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-red mt-1" aria-hidden="true"></i>
                            <a href="https://www.google.com/maps/place/Gyanmanjari+Group+of+Colleges/@21.718607,72.121905,15z/data=!4m6!3m5!1s0x395f574ba735c539:0x387d9b85bd2cd04e!8m2!3d21.7186066!4d72.1219048!16s%2Fg%2F11b7snn6_4?hl=en-GB"
                                target="_blank" rel="noopener noreferrer" class="hover:text-white transition">
                                Survey No. 30, Sidsar Road,<br>
                                Bhavnagar, Gujarat (India) – 364060
                            </a>
                        </li>

                    </ul>
                </section>

                <!-- QUICK LINKS -->
                <nav aria-labelledby="footer-links">
                    <h3 id="footer-links" class="text-lg font-bold mb-4 uppercase tracking-widest">
                        Quick Links
                    </h3>

                    <ul class="space-y-3 text-sm text-gray-300">
                        <li>
                            <a href="https://gmiu.edu.in/" class="hover:text-red transition">
                                GMIU Website
                            </a>
                        </li>
                        <li>
                            <a href="https://gmiu.edu.in/gmiu/website_assets/gmiu_doc/online-registration1.pdf"
                                class="hover:text-red transition">
                                Admission Process
                            </a>
                        </li>
                        <li>
                            <a href="https://gmiu.edu.in/gmiu/website_assets/gmiu_doc/FACULTY%20OF%20DESIGN/Bachelor%20in%20Design/FAQ-%20Bachelor%20Design%20&%20Home%20Science.pdf"
                                class="hover:text-red transition">
                                FAQs
                            </a>
                        </li>
                        <li>
                            <a href="https://gmiu.edu.in/gmiu/admission/" class="hover:text-red transition">
                                Apply Online
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- UNIVERSITY BRAND -->
                <section aria-labelledby="footer-brand">
                    <h3 id="footer-brand" class="text-lg font-bold mb-4 uppercase tracking-widest">
                        GMIU
                    </h3>

                    <p class="text-gray-300 text-sm leading-relaxed mb-6">
                        Empowering students with innovation-driven education,
                        industry exposure, and a future-ready academic ecosystem.
                    </p>

                    <div class="flex space-x-6 text-xl">

                        <a href="https://www.facebook.com/GyanmanjariColleges" aria-label="GMIU on Facebook"
                            class="hover:text-red transition" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a href="https://x.com/GMGC_Bhavnagar" aria-label="GMIU on Twitter"
                            class="hover:text-red transition" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-twitter"></i>
                        </a>

                        <a href="https://www.instagram.com/gyanmanjari_innovative_u?igsh=b2hodnd6YmNld3lj"
                            aria-label="GMIU on Instagram" class="hover:text-red transition" target="_blank"
                            rel="noopener noreferrer">
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <a href="https://whatsapp.com/channel/0029VaAlQDCJP217g55N1h2B"
                            aria-label="GMIU WhatsApp Channel" class="hover:text-red transition" target="_blank"
                            rel="noopener noreferrer">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>

                        <a href="https://www.youtube.com/channel/UCzsun63TTJoLySLIWWaA8AQ" aria-label="GMIU on YouTube"
                            class="hover:text-red transition" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-youtube"></i>
                        </a>

                    </div>
                </section>

            </div>

            <!-- BOTTOM FOOTER -->
            <div class="flex flex-col md:flex-row justify-between items-center
                    py-6 text-xs text-gray-400 gap-4">

                <div class="text-center md:text-left">
                    © Gyanmanjari Innovative University. All Rights Reserved.
                </div>

                <div class="text-center md:text-right">
                    Designed &amp; Developed by
                    <a href="https://gmiu.edu.in/gmiu/website/common/it_cell_team.php" class="text-white font-semibold">
                        IT CELL
                    </a>
                </div>

            </div>

        </div>
    </footer>


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 900,
            once: true,
            easing: 'ease-out-cubic',
            disable: window.innerWidth < 768
        });

    </script>

    </script>
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    </script>

    <script>
        function openVideoModal(videoId) {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoFrame');

            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoFrame');

            iframe.src = '';
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    </script>
    <script>
        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');

            img.src = src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');

            modal.classList.add('hidden');
            img.src = '';
            document.body.style.overflow = '';
        }
    </script>

</body>

</html>