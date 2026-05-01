<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMIU Cells - Promotional Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
        }
     

        .container {
            max-width: 1300px;
            margin: auto;
            padding: 50px 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 35px;
        }
        /* RESPONSIVE GRID */
        @media (max-width: 1024px) {
        .grid {
        grid-template-columns: repeat(2, 1fr);
        }
        }
        
        
        @media (max-width: 768px) {
        .grid {
        grid-template-columns: repeat(1, 1fr);
        }
        }
        
        
        @media (max-width: 480px) {
        .grid {
        grid-template-columns: 1fr;
        gap: 20px;
        }
        }
        .cell-box {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 25px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .cell-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        }
        .image-slider {
    width: 100%;
    height: 260px;             /* Adjust height as per your need */
    overflow: hidden;
    position: relative;
}

.image-slider img {
    width: 100%;
    height: 100%;
    object-fit: cover;         /* Makes image fill the slide perfectly */
    display: none;             /* Hide all images by default */
}

.image-slider img.active {
    display: block;            /* Show only active image */
}

     

        /* Fix broken / height attributes */
        img[height] {
            height: auto !important;
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
        .content {
            padding: 25px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #0056a3;
            margin-bottom: 12px;
            text-align: center;    /* Add this */
        }
        .desc {
            font-size: 15px;
            color: #444;
            line-height: 1.7;
        }
        .btn {
            display: block;
            margin: 15px auto 0 auto;
            width: fit-content;
            align-content: center;
            margin-top: 15px;
            padding: 10px 20px;
            background: #0056a3;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #003d75;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
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
   

    <div class="container">
        <div class="grid">

            <!-- Startup Cell -->
            <div class="cell-box">
                <div class="image-slider">
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/startup_gallery_image/2024-08-23-33-MoU.jpg" >
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/startup_gallery_image/2024-08-23-100-Icreate%20visit%202.jpeg" >
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/startup_gallery_image/2024-08-23-35-iCreate%20visit%203.jpeg" >
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/startup_gallery_image/2024-08-23-82-Hack4purpose%20participation%20GMIU.jpeg" >
</div>
                <div class="content">
                    <div class="title">Startup & Entrepreneurship Cell</div>
                    <div class="desc">Supports students and faculty in developing startup ventures with mentorship, co-working space, and seed funding.</div>
                    <a href="https://gmiu.edu.in/gmiu/website/startup/about_startup.php" class="btn" target="_blank">View More</a>
                </div>
            </div>

            <!-- IRC -->
            <div class="cell-box">
                <div class="image-slider">
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/international_cell/2024-02-06-30-Students%20PPT%20on%20International%20Relations%20Cell-1.jpg" >
</div>
                <div class="content">
                    <div class="title">International Relations Cell (IRC)</div>
                    <div class="desc">Facilitates international partnerships, student exchange programs, and global academic collaborations.</div>
                    <a href="https://gmiu.edu.in/gmiu/website/international_cell/about_irc.php" class="btn">View More</a>
                </div>
            </div>

            <!-- BKSVE -->
            <div class="cell-box">
                <div class="image-slider">
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/iksve_cell/2024-12-04-72-2024-10-17-42-1.jpg" >
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/iksve_cell/2024-11-13-55-20240906_93452AMByGPSMapCamera%20-%20Copy.jpg" >
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/iksve_cell/2024-11-13-29-WhatsApp%20Image%202024-08-30%20at%202.38.03%20PM%20(1).jpeg" >
</div>
                <div class="content">
                    <div class="title">BKSVE Cell</div>
                    <div class="desc">Focuses on Indian Knowledge System (IKS), value education, cultural learning, and traditional knowledge research.</div>
                    <a href="https://gmiu.edu.in/gmiu/website/bksve/about_bksve_cell.php" class="btn">View More</a>
                </div>
            </div>

            <!-- Research Cell -->
            <div class="cell-box">
                <div class="image-slider"> 
                <img src="https://gmiu.edu.in/gmiu/website_assets/images/360_virtual_tour-img/sl2.webp" > 
                <img src="https://gmiu.edu.in/gmiu/website_assets/images/360_virtual_tour-img/sl1.webp" >
                <img src="https://gmiu.edu.in/gmiu/website_assets/images/360_virtual_tour-img/l2.webp" > 
                </div>
                <div class="content">
                    <div class="title">GMRDC - Research & Development Grant Cell</div>
                    <div class="desc">Supports research grants, innovation, and academic development through structured funding and guidance.</div>
                    <a href="https://gmiu.edu.in/gmiu/website/research/gmrdc.php" class="btn">View More</a>
                </div>
            </div>

        </div>
    </div>
</body>
<script>
document.querySelectorAll('.image-slider').forEach(slider => {
    let images = slider.querySelectorAll("img");
    let index = 0;

    function showImage(i) {
        images.forEach(img => img.classList.remove("active"));
        images[i].classList.add("active");
    }

    showImage(index);

    setInterval(() => {
        index = (index + 1) % images.length;
        showImage(index);
    }, 3000); // 2.5 sec slider
});
</script>

</html>
