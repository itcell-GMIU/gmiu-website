<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMIU Extracurricular Activities</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .hero-section {
            background: linear-gradient(rgb(0 0 0 / 48%), rgb(0 0 0 / 63%)), url(https://gmiu.edu.in/gmiu/website_assets/images/clg%20bg%20new.webp) center / cover no-repeat;
            padding: 80px 20px;
            color: white;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }
       
        .section {
            padding: 50px 20px;
            max-width: 1100px;
            margin: auto;
        }
        .section h2 {
            font-size: 30px;
            color: #003e80;
            margin-bottom: 15px;
            border-left: 5px solid #003e80;
            padding-left: 10px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
         /* HEADER MAIN WRAPPER */
        header {
            width: 100%;
            background: #ffffff;
            padding: 15px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            position: sticky;
            z-index: 9999;
             top: 0;
        }
        
        /* LOGO CENTER ALIGN */
        header .navbar-header {
            text-align: center;
            width: 100%;
        }
        
        header #nav-logo {
            height: 85px;
            width: auto;
        }
        
        /* REMOVE UNWANTED BACKGROUND COLORS */
        header .edu-navbar,
        header .container-fluid {
            background: #ffffff !important;
            box-shadow: none !important;
            border: 0 !important;
        }
        
        /* FIX STICKY WRAPPER */
        #sticky-wrapper {
            width: 100% !important;
            height: auto !important;
        }
        
        /* REMOVE EXTRA WIDTH FROM NAVBAR */
        header .edu-navbar {
            width: 100% !important;
        }
        
        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            #nav-logo {
                height: 65px;
            }
        }

        #nav-logo {
            /* width: 86%; */
            /*position: relative;*/
            right: -35px;
            height: auto;
            width: 200px;
            max-height: 72px;
            max-width: 250px;
            transition: .3s;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin-top: 0;
            color: #0056a3;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-body">
            <div id="sticky-wrapper" class="sticky-wrapper" style="height: 87px;"><nav class="navbar edu-navbar" style="background-color: rgb(255, 255, 255) !important; width: 1430px;">
                <div class="container-fluid" style="background-color: #fff;">
                    <div class="row ml-auto">
                        <div class="col-lg-12 text-center">
                            <div class="navbar-header col-lg-12 text-center">


                                <a href="https://gmiu.edu.in/gmiu/admission/"> <img id="nav-logo" src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt=""></a>
                            </div>
                        </div>
                    </div>

                </div>
            </nav></div>
            <!-- Only we have to show this slider in the girlscollege.php  -->
        </div>

    </header>

    <div class="hero-section">
        <h1>Extracurricular Activities at GMIU</h1>
        <p>Explore creativity, innovation, leadership, and more.</p>
    </div>

  <div class="section">
<h2>Cultural & Creative Activities</h2>
<div class="grid">
<div class="card">
<h3>Raasmanjari</h3>
<p>A vibrant cultural festival featuring music, dance, drama and traditional performances.</p>
</div>
<div class="card">
<h3>Kalamanjari</h3>
<p>A creative platform showcasing art, culture, and student talent.</p>
</div>
<div class="card">
<h3>Techmanjari</h3>
<p>An event dedicated to technical innovation, coding, robotics, and engineering skills.</p>
</div>
<div class="card">
<h3>Media Production</h3>
<p>Opportunities in journalism, broadcasting, and student media activities.</p>
</div>
</div>
</div>
    <div class="section">
        <h2>Sports & Physical Activities</h2>
        <div class="grid">
            <div class="card">
                <h3>Sports Tournaments</h3>
                <p>Includes football, cricket, volleyball, badminton, chess, and more.</p>
            </div>
            <div class="card">
                <h3>Indoor & Outdoor Facilities</h3>
                <p>Well-equipped sports areas to promote fitness, fun, and teamwork.</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Technical & Professional Development</h2>
        <div class="grid">
            <div class="card">
                <h3>Workshops & Seminars</h3>
                <p>Regular sessions to upgrade academic and professional skills.</p>
            </div>
            <div class="card">
                <h3>Expert Talks</h3>
                <p>Interactive sessions with industry and academic experts.</p>
            </div>
            <div class="card">
                <h3>Industrial Visits</h3>
                <p>Exposure to real-world environments through company visits.</p>
            </div>
            <div class="card">
                <h3>Project Exhibitions</h3>
                <p>Showcase innovative student project work.</p>
            </div>
            <div class="card">
                <h3>Skill Development Programs</h3>
                <p>Training programs to build essential career-oriented skills.</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Other Activities</h2>
        <div class="grid">
            <div class="card">
                <h3>Masterminds Program</h3>
                <p>Engaging competitions and intellectual challenges.</p>
            </div>
            <div class="card">
                <h3>Startup Incubation</h3>
                <p>Students can build and launch startups with university support.</p>
            </div>
            <div class="card">
                <h3>Alumni Association</h3>
                <p>Strong networking and mentorship through GMIU's alumni community.</p>
            </div>
        </div>
    </div>

</body>
</html>
