<?php include '../../common/importwebsitefile.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Conclave 1.0 - GMIU</title>

    <meta name="description"
        content="Join the HR Conclave 1.0 at GMIU. The premier networking event for corporate leaders, HR experts, and students.">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Tailwind CDN for rapid styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            500: '#0ea5e9',
                            600: '#0284c7',
                        },
                        corporate: {
                            500: '#6366f1',
                            600: '#4f46e5',
                        },
                        student: {
                            500: '#ec4899',
                            600: '#db2777',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            overflow-x: hidden;
        }

        .header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            padding: 12px 24px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .logo-left img,
        .logo-right img {
            height: 48px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .logo-left img:hover,
        .logo-right img:hover {
            transform: scale(1.05);
        }

        .header-center-text {
            text-align: center;
            font-size: 15px;
            font-weight: 700;
            color: #334155;
            line-height: 1.4;
            letter-spacing: -0.01em;
        }

        .header-center-text .highlight {
            color: #db2777; /* student brand color */
        }

        @media (max-width: 600px) {
            .header {
                grid-template-columns: 1fr;
                gap: 12px;
                padding: 16px;
            }
            .logo-left,
            .logo-right {
                justify-self: center;
            }
            .logo-left img,
            .logo-right img {
                height: 42px;
            }
            .header-center-text {
                font-size: 14px;
            }
        }

        /* Animated ambient background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(99, 102, 241, 0.08) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(236, 72, 153, 0.06) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(14, 165, 233, 0.04) 0%, transparent 60%);
            z-index: 0;
            pointer-events: none;
        }

        .main-container {
            z-index: 10;
            width: 100%;
            max-width: 1100px;
            padding: 24px;
        }

        /* Glassmorphism card */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.05),
                0 0 40px rgba(99, 102, 241, 0.05);
            border-radius: 28px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 768px) {
            .glass-card {
                flex-direction: row;
            }
        }

        .role-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none !important;
        }

        .role-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            transition: left 0.7s ease;
            z-index: 20;
            pointer-events: none;
        }

        .role-btn:hover::before {
            left: 100%;
        }

        .role-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px -10px rgba(99, 102, 241, 0.15);
        }

        .hero-img-container {
            position: relative;
            overflow: hidden;
        }

        .hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 280px;
            transition: transform 0.8s ease;
        }

        .glass-card:hover .hero-img {
            transform: scale(1.05);
        }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <!-- LEFT LOGO -->
        <a href="https://gmiu.edu.in/" class="logo-left block" target="_blank">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo">
        </a>

        <!-- CENTER TEXT -->
        <div class="header-center-text">
            रट्टा अभ्यास छोड़ो,<br>
            <span class="highlight">कौशल्यलक्षी शिक्षा से जुड़ो ।</span>
        </div>

        <!-- RIGHT LOGO -->
        <div class="logo-right">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" alt="PLM Logo">
        </div>
    </header>

    <div class="flex-grow flex items-center justify-center w-full py-10 md:py-0">
        <div class="main-container">
        <div class="glass-card">

            <!-- Left Side: Image Banner -->
            <div class="w-full md:w-1/2 hero-img-container relative bg-slate-100 border-r border-slate-200/60">
                <div
                    class="absolute inset-0 bg-gradient-to-t via-transparent to-transparent opacity-80 z-10 transition-opacity">
                </div>

                <img src="img/hr-conclave-banner.jpg" alt="HR Conclave 1.0" class="hero-img z-0">


            </div>

            <!-- Right Side: Content & Buttons -->
            <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center relative bg-white/40">

                <!-- Glow effects behind content -->
                <div
                    class="absolute top-0 right-0 w-48 h-48 bg-corporate-500/5 rounded-full blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-48 h-48 bg-student-500/5 rounded-full blur-3xl pointer-events-none">
                </div>

                <div class="relative z-10">
                    <!--<h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight tracking-tight text-slate-900">-->
                    <!--    HR <span class="gradient-text">Conclave 1.0</span>-->
                    <!--</h1>-->
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight tracking-tight text-slate-900">
                    HR 
                    <span style="color : #ec265c">Conclave</span> 
                    <span class="text-black">1.0</span>
                    </h1>

                    <p class="text-slate-600 text-base md:text-lg mb-10 leading-relaxed max-w-md">
                        The ultimate gathering of thought leaders, industry experts, and future talent. Register now to
                        secure your spot at this premier event.
                    </p>

                    <div class="space-y-6">
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-400 font-bold mb-3 pl-1">
                            Choose Your Category
                        </div>

                        <!-- Corporate Button -->
                        <a href="https://forms.gle/izRkQV4C2u9n6XHJA" target="_blank"
                            class="role-btn block w-full group rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-corporate-300">
                            <div
                                class="px-6 py-5 flex items-center justify-between transition duration-300 group-hover:bg-slate-50/50">
                                <div class="flex items-center gap-5">
                                    <div
                                        class="w-14 h-14 rounded-full bg-indigo-50 flex items-center justify-center text-2xl text-corporate-500 border border-indigo-100 group-hover:scale-110 group-hover:bg-corporate-500 group-hover:text-white transition-all duration-300">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <div
                                            class="font-bold text-xl text-slate-800 mb-1 group-hover:text-corporate-700 transition-colors">
                                            Corporate</div>
                                        <div class="text-sm text-slate-500 font-medium">HRs & Industry Leaders</div>
                                    </div>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-corporate-100 group-hover:text-corporate-600 transition-all duration-300">
                                    <i
                                        class="fas fa-arrow-right opacity-70 group-hover:opacity-100 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </a>

                        <!-- Student Button -->
                        <a href="https://forms.gle/wfBjGivNXi1sq4bZ7" target="_blank"
                            class="role-btn block w-full group mt-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-rose-300">
                            <div
                                class="px-6 py-5 flex items-center justify-between transition duration-300 group-hover:bg-slate-50/50">
                                <div class="flex items-center gap-5">
                                    <div
                                        class="w-14 h-14 rounded-full bg-rose-50 flex items-center justify-center text-2xl text-rose-500 border border-rose-100 group-hover:scale-110 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div>
                                        <div
                                            class="font-bold text-xl text-slate-800 mb-1 group-hover:text-rose-600 transition-colors">
                                            Student</div>
                                        <div class="text-sm text-slate-500 font-medium">University Participants</div>
                                    </div>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-rose-100 group-hover:text-rose-600 transition-all duration-300">
                                    <i
                                        class="fas fa-arrow-right opacity-70 group-hover:opacity-100 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div
                        class="mt-12 pt-6 border-t border-slate-200 flex flex-wrap items-center justify-between gap-4 text-slate-500 text-sm font-semibold">
                        <div class="flex items-center gap-2 hover:text-slate-800 transition-colors">
                            <i class="fas fa-map-marker-alt text-brand-500"></i> GMIU Campus
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-300">|</span>
                        </div>
                        <div class="flex items-center gap-2 hover:text-slate-800 transition-colors">
                            <i class="fas fa-clock text-rose-500"></i> Limited Seats
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

</body>

</html>