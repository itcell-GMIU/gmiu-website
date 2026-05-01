<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techmanjari 2K26 | Invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f8fafc;
            /* Light gray-white background */
            color: #0f172a;
            /* Dark slate text */
            scroll-behavior: smooth;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            /* Brighter glass for white theme */
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .text-glow {
            /* Glow adjusted for light background */
            text-shadow: 0 0 15px rgba(56, 189, 248, 0.3);
        }

        .feature-tag {
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.2);
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 0.8rem;
            color: #0284c7;
            /* Darker sky blue for readability */
            display: inline-block;
            margin: 4px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
</head>

<body class="overflow-x-hidden">

    <nav class="fixed w-full z-50 glass px-4 md:px-6 py-3 md:py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Left Logo"
                    class="h-10 w-auto md:h-14 md:w-auto object-contain">
            </div>

            <div class="flex items-center">
                <img src="https://techmanjari.gmiu.edu.in/images/speakers/featured-speaker.jpg" alt="Right Logo"
                    class="h-10 w-auto md:h-14 md:w-auto object-contain">
            </div>
        </div>
    </nav>

    <header class="relative min-h-screen w-full flex items-center justify-center overflow-hidden pt-16 bg-white">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?q=80&w=2000" alt="Tech Background"
                class="w-full h-full object-cover opacity-40 scale-110 md:scale-100">

            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[#f8fafc]"></div>
        </div>

        <div class="relative z-10 text-center px-6 md:px-4 animate-fade-up">
            <p
                class="text-sky-600 text-xl md:text-md font-bold tracking-[0.2em] md:tracking-[0.4em] uppercase mb-4 animate-pulse">
                INVITATION
            </p>

            <h1 class="text-4xl sm:text-6xl md:text-8xl font-bold text-slate-900 mb-6 leading-tight">
                TECHMANJARI <br class="block md:hidden">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-purple-600">2K26</span>
            </h1>

            <p class="max-w-xl md:max-w-2xl mx-auto text-slate-600 text-base md:text-xl mb-8 md:mb-10 leading-relaxed">
                Join the Bhavnagar Science & Technology Festival. Innovation, competition, and future-tech all in one
                place.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="https://techmanjari.gmiu.edu.in/" target="_blank"
                    class="w-full sm:w-auto px-10 py-4 bg-sky-600 hover:bg-sky-700 text-white rounded-full font-bold transition-all transform hover:scale-105 shadow-lg shadow-sky-200">
                    Visit Techmanjari
                </a>
                <a href="https://gmiu.edu.in/" target="_blank"
                    class="w-full sm:w-auto px-10 py-4 glass text-slate-700 hover:bg-slate-50 rounded-full font-bold transition-all text-center border border-slate-200">
                    Visit GMIU
                </a>
            </div>
        </div>
    </header>

    <section id="press-notes" class="py-16 md:py-24 px-4 md:px-6 max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-5xl font-bold text-slate-900 tracking-tight mb-4">
                Press <span class="text-sky-600 font-light">Highlights</span>
            </h2>
            <div class="h-1 w-20 bg-sky-500 rounded-full mx-auto"></div>
            <p class="text-slate-500 mt-6 max-w-2xl mx-auto">
                Catch up on the latest news and coverage from the Bhavnagar Science & Technology Festival.
            </p>
        </div>

        <div class="columns-2 sm:columns-3 lg:columns-5 gap-6 space-y-6">

            <div onclick="openModal('./img/press-notes/1000083675.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083675.jpg" alt="Press Note 1"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083677.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083677.jpg" alt="Press Note 2"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083679.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083679.jpg" alt="Press Note 3"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083681.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083681.jpg" alt="Press Note 4"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083683.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083683.jpg" alt="Press Note 5"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083684.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083684.jpg" alt="Press Note 6"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083685.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083685.jpg" alt="Press Note 7"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083687.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083687.jpg" alt="Press Note 8"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083688.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083688.jpg" alt="Press Note 9"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083689.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083689.jpg" alt="Press Note 10"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083690.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083690.jpg" alt="Press Note 11"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div onclick="openModal('./img/press-notes/1000083691.jpg')"
                class="break-inside-avoid glass rounded-2xl overflow-hidden group border-sky-500/20 hover:border-sky-500/50 transition-all duration-300 cursor-pointer">
                <img src="./img/press-notes/1000083691.jpg" alt="Press Note 12"
                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

        </div>
    </section>

    <section id="highlights"
        class="py-16 md:py-24 px-4 md:px-6 max-w-7xl mx-auto bg-white rounded-[3rem] my-10 border border-slate-200 shadow-xl shadow-slate-200/50">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-slate-900 tracking-tight mb-4">
                Techmanjari <span class="text-sky-600 font-light italic">Vibes</span>
            </h2>
            <div class="h-1.5 w-24 bg-gradient-to-r from-sky-400 to-purple-500 rounded-full mx-auto"></div>
            <p class="text-slate-500 mt-6 max-w-2xl mx-auto text-lg">
                Relive the innovation and energy through these quick highlights! 🚀
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">

            <div class="group relative aspect-[9/16] glass rounded-3xl overflow-hidden cursor-pointer"
                onclick="openShort('6Gn-7G-Yric')">
                <img src="https://img.youtube.com/vi/6Gn-7G-Yric/maxresdefault.jpg" alt="Short 1"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13L16 10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative aspect-[9/16] glass rounded-3xl overflow-hidden cursor-pointer"
                onclick="openShort('vQnOzM8x0Bc')">
                <img src="https://img.youtube.com/vi/vQnOzM8x0Bc/hqdefault.jpg" alt="Short 2"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13L16 10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative aspect-[9/16] glass rounded-3xl overflow-hidden cursor-pointer"
                onclick="openShort('M7wRDiJsJKM')">
                <img src="https://img.youtube.com/vi/M7wRDiJsJKM/hqdefault.jpg" alt="Short 3"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13L16 10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative aspect-[9/16] glass rounded-3xl overflow-hidden cursor-pointer"
                onclick="openShort('2O_aISUxisY')">
                <img src="https://img.youtube.com/vi/2O_aISUxisY/maxresdefault.jpg" alt="Short 4"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13L16 10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative aspect-[9/16] glass rounded-3xl overflow-hidden cursor-pointer"
                onclick="openShort('zTSqSAEEDVY')">
                <img src="https://img.youtube.com/vi/zTSqSAEEDVY/maxresdefault.jpg" alt="Short 5"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13L16 10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative aspect-[9/16] glass rounded-3xl overflow-hidden cursor-pointer"
                onclick="openShort('V6zTvmfzKkI')">
                <img src="https://img.youtube.com/vi/V6zTvmfzKkI/maxresdefault.jpg" alt="Short 6"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13L16 10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative aspect-[9/16] glass rounded-3xl overflow-hidden cursor-pointer"
                onclick="openShort('lzT-mNC9G3Q')">
                <img src="https://img.youtube.com/vi/lzT-mNC9G3Q/hqdefault.jpg" alt="Short 7"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13L16 10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group relative aspect-[9/16] glass rounded-3xl overflow-hidden cursor-pointer"
                onclick="openShort('BFJ3LI23-H0')">
                <img src="https://img.youtube.com/vi/BFJ3LI23-H0/maxresdefault.jpg" alt="Full Video"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.5 3.5v13L16 10z" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div id="videoModal"
        class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/90 backdrop-blur-md p-4 cursor-pointer"
        onclick="closeVideoModal()">
        <button class="absolute top-5 right-5 text-white text-5xl hover:text-sky-400">&times;</button>
        <div class="w-full max-w-[350px] aspect-[9/16] relative" onclick="event.stopPropagation()">
            <iframe id="shortsIframe" class="w-full h-full rounded-2xl shadow-2xl bg-black" src="" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
    </div>

    <div id="imageModal"
        class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/95 backdrop-blur-sm p-4 cursor-pointer"
        onclick="closeModal()">
        <button class="absolute top-5 right-5 text-white text-4xl hover:text-sky-400 transition">&times;</button>
        <div class="max-w-4xl max-h-[90vh] flex items-center justify-center" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Full View" class="w-full h-full object-contain rounded-lg shadow-2xl">
        </div>
    </div>

    <footer class="relative mt-20 border-t border-slate-200 bg-white pt-16 pb-8 px-6 overflow-hidden">
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-sky-100 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div class="space-y-4 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3">
                        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU"
                            class="h-10 w-auto">
                        <span class="text-xl font-bold tracking-widest text-sky-600 uppercase">Techmanjari</span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-xs mx-auto md:mx-0">
                        The biggest technical carnival of Bhavnagar. Empowering students through innovation and
                        excellence.
                    </p>
                </div>

                <div class="text-center">
                    <h4 class="text-slate-900 font-bold uppercase tracking-widest text-sm mb-6">Navigation</h4>
                    <ul class="space-y-3 text-slate-500 text-sm">
                        <li><a href="#" class="hover:text-sky-600 transition-colors">Home</a></li>
                        <li><a href="#press-notes" class="hover:text-sky-600 transition-colors">Press Notes</a></li>
                        <li><a href="#highlights" class="hover:text-sky-600 transition-colors">Highlights</a></li>
                    </ul>
                </div>

                <div class="text-center md:text-right">
                    <h4 class="text-slate-900 font-bold uppercase tracking-widest text-sm mb-6">Connect With Us</h4>
                    <div class="flex justify-center md:justify-end gap-4 mb-6">
                        <a href="https://www.instagram.com/gyanmanjari_innovative_u/" target="_blank"
                            class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 hover:text-sky-600 hover:border-sky-400 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="https://techmanjari.gmiu.edu.in/" target="_blank"
                            class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 hover:text-sky-600 hover:border-sky-400 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                </path>
                            </svg>
                        </a>
                    </div>
                    <p class="text-xs text-slate-400 tracking-widest uppercase">info@gmiu.edu.in</p>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[10px] md:text-xs text-slate-400 uppercase tracking-[0.2em]">
                    &copy; 2026 Techmanjari • GMIU Bhavnagar
                </p>
                <p class="text-[10px] md:text-xs text-slate-400 uppercase tracking-[0.2em]">
                    Designed by
                    <a href="https://aksharrathod.netlify.app" target="_blank"
                        class="text-sky-600 font-bold hover:text-sky-800 transition-colors ml-1">
                        Akshar Rathod
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <script>
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            if (modal && modalImg) {
                modalImg.src = imageSrc;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        function openShort(videoId) {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('shortsIframe');
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('shortsIframe');
            iframe.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
                closeVideoModal();
            }
        });
    </script>
</body>

</html>