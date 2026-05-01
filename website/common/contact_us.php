<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/contact_us.css?v=<?php echo time(); ?>">

    <script src="<?php echo $website_assets_url; ?>js/share.js"></script>
    <style>
        .social-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            /* Responsive grid */

            justify-content: center;
            max-width: 600px;
            /* Adjust max width if needed */
            margin: auto;
        }

        .social-card {
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* width: 150px; */
            text-align: center;
            /* margin: 10px 5px; */
            font-family: Arial, sans-serif;
        }

        .social-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center !important;
            margin-bottom: 8px;
        }

        .social-icon {
            padding: 7px 12px 7px 7px;
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 8px;
            font-size: 18px;
            color: white;
        }

        .instagram {
            background-color: #e1306c;
        }

        .facebook {
            background-color: #4267b2;
        }

        /* Media query for 3 columns in larger screens */
        @media (min-width: 768px) {
            .social-container {
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
            }

        }

        /* Media query for 2 columns in mobile view */
        @media (max-width: 767px) {
            .social-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 5px 5px;

            }
        }
    </style>
    <!--   -->
</head>

<body class="courses">
    <section class="background">

    </section>

    <section class="contact_us">
        <div class="card-contact_us">
            <div class="header-section container-card">
                <img src="<?php echo $website_assets_url; ?>images/Logo with BG@2x.png" alt="">
                <h2 class="text-white">Gyanmanjari Innovative University-GMIU</h2>
                <div class="three-contact">
                    <a href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                        <div class="small-card" style="border-right: 1px solid rgba(255,255,255,0.15);">
                            <i class="fa-solid fa-phone text-white margin-icon"></i>
                            <p class="text-white">360 Virtual Tour</p>
                        </div>
                    </a>

                    <a href="https://gmiu.edu.in/gmiu/admission/">
                        <div class="small-card" style="border-right: 1px solid rgba(255,255,255,0.15);">
                            <i class="fa-solid fa-university text-white margin-icon"></i>
                            <p class="text-white">APPLY NOW</p>
                        </div>
                    </a>

                    <a href="https://gmiu.edu.in/gmiu/website/">
                        <div class="small-card">
                            <i class="fa-solid fa-globe text-white margin-icon"></i>
                            <p class="text-white">Website</p>
                        </div>
                    </a>

                </div>
            </div>
            <div class="card-contant-contact container-card slogan-container">
                <div class="content-data">
                    <h1 class="promo-title">
                        रट्टा अभ्यास छोडो, <br> कौशल्यलक्षी शिक्षा से जुडो ।
                    </h1>
                </div>
            </div>

            <div class="card-contant-contact container-card">
                <div class="icon">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="content-data">
                    <div class="phone-wrapper">
                        <div class="phone-item">
                            <a href="tel:+917574949494">7574949494</a>
                            <p>Mobile</p>
                        </div>
                        <div class="phone-item">
                            <a href="tel:+919099951160">9099951160</a>
                            <p>Telephone</p>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="card-contant-contact container-card">
                <div class="icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="content-data">
                    <a href="mailto:info@gmiu.edu.in">info@gmiu.edu.in</a>
                    <p>Email</p>
                </div>
            </div>

            <div class="card-contant-contact container-card">
                <div class="icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="content-data">
                    <p style="margin-bottom: 23px;">Gyanmanjari Innovative University Bhavnagar - Sidsar Road 30
                        bhavnagar, Gujarat 364060
                        India</p>
                    <a href="https://goo.gl/maps/Rew9anmSejXpQ2ucA" class="map-btn">SHOW ON MAP</a>
                    <hr>
                </div>
            </div>

            <div class="card-contant-contact container-card">
                <div class="icon" style="padding-top: 10px;">
                    <i class="fa-light fa-solid fa-globe "></i>
                </div>
                <div class="content-data">
                    <a href="https://www.gmiu.edu.in">Gyanmanjari Innovative University</a>
                    <p>Website</p>
                    <hr>
                </div>
            </div>
           <div class="card-contant-contact container-card plm-side-layout">
                <div class="icon" style="padding-top: 10px;">
                    <i class="fa-light fa-solid fa-crown"></i>
                </div>
                <div class="content-data">
                    <a href="https://admission.gmiu.edu.in/premium/index.php" class="plm-flex-wrapper">
                        <span class="plm-short-text">PLM</span>
                        <div class="plm-logo-inline">
                            <img src="plmlogo.png" alt="PLM Logo">
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="card-contant-contact container-card">
                <div class="icon" style="padding-top: 10px;">
                    <i class="fa-light fa-solid fa-university"></i>
                </div>
                <div class="content-data">
                    <a href="https://admission.gmiu.edu.in/admission/girlscollege.php">Gyanmanjari Girls' College</a>
                    <p>Website</p>
                    <hr>
                </div>
            </div>

           <div class="promo-section">
                <h3 class="section-heading">
                    <i class="fa-solid fa-headset"></i> Connect Course-wise Counsellors
                </h3>

                <div class="counsellor-grid">

                    <a href="tel:+918780049651" class="counsellor-link">
                        <span class="c-course">Diploma</span>
                        <span class="c-num">87800 49651</span>
                    </a>

                    <a href="tel:+918780089802" class="counsellor-link">
                        <span class="c-course">B.Tech</span>
                        <span class="c-num">87800 89802</span>
                    </a>

                    <a href="tel:+918799248026" class="counsellor-link">
                        <span class="c-course">M.Tech</span>
                        <span class="c-num">87992 48026</span>
                    </a>

                    <a href="tel:+919023667260" class="counsellor-link extra-card">
                        <span class="c-course">B.Com / M.Com</span>
                        <span class="c-num">90236 67260</span>
                    </a>

                    <a href="tel:+917016816678" class="counsellor-link extra-card">
                        <span class="c-course">BBA / MBA</span>
                        <span class="c-num">70168 16678</span>
                    </a>

                    <a href="tel:+919106434014" class="counsellor-link extra-card">
                        <span class="c-course">BA / MA</span>
                        <span class="c-num">91064 34014</span>
                    </a>

                    <a href="tel:+918799675586" class="counsellor-link extra-card">
                        <span class="c-course">BCA / MCA / IT</span>
                        <span class="c-num">87996 75586</span>
                    </a>

                    <a href="tel:+916354202519" class="counsellor-link extra-card">
                        <span class="c-course">Science / Pharma / Bio-Tech</span>
                        <span class="c-num">63542 02519</span>
                    </a>

                    <a href="tel:+917984152493" class="counsellor-link extra-card">
                        <span class="c-course">D2D</span>
                        <span class="c-num">79841 52493</span>
                    </a>

                    <a href="tel:+919016817031" class="counsellor-link extra-card">
                        <span class="c-course">Diploma</span>
                        <span class="c-num">90168 17031</span>
                    </a>

                    <a href="tel:+919016834945" class="counsellor-link extra-card">
                        <span class="c-course">GGC</span>
                        <span class="c-num">90168 34945</span>
                    </a>

                    <a href="tel:+919099951018" class="counsellor-link extra-card">
                        <span class="c-course">GGC</span>
                        <span class="c-num">90999 51018</span>
                    </a>

                </div>
                <button id="toggleBtn" class="view-more-btn">View More</button>
            </div>

            <div class="promo-section">
                <h3 class="section-heading"><i class="fa-solid fa-file-pdf"></i> Information Leaflets</h3>
                <div class="download-grid">
                    <div class="leaflet-card">
                        <div class="leaflet-preview">
                            <img src="4-page.jpg" alt="4 Page Preview">
                            <div class="leaflet-overlay">
                                <a href="https://gmiu.edu.in/gmiu/website_assets/images/leaflet/4-Leaflet.pdf" target="_blank" class="preview-btn">View PDF</a>
                            </div>
                        </div>
                        <div class="leaflet-info">
                            <p>4 Page Leaflet</p>
                            <a href="https://gmiu.edu.in/gmiu/website_assets/images/leaflet/4-Leaflet.pdf" download class="dl-icon-btn"><i class="fa-solid fa-download"></i></a>
                        </div>
                    </div>

                    <div class="leaflet-card">
                        <div class="leaflet-preview">
                            <img src="8-page.jpg" alt="8 Page Preview">
                            <div class="leaflet-overlay">
                                <a href="https://gmiu.edu.in/gmiu/website_assets/images/leaflet/8-Leaflet.pdf" target="_blank" class="preview-btn">View PDF</a>
                            </div>
                        </div>
                        <div class="leaflet-info">
                            <p>8 Page Leaflet</p>
                            <a href="https://gmiu.edu.in/gmiu/website_assets/images/leaflet/8-Leaflet.pdf" download class="dl-icon-btn"><i class="fa-solid fa-download"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="promo-section highlight-bg">
                <h3 class="section-heading">Choose Your Path</h3>
                <div class="path-grid">
                    <a href="https://gmiu.edu.in/gmiu/website/post/diploma.php" class="path-card">
                        <div class="path-badge">After 10th</div>
                        <p>Diploma Programs</p>
                    </a>
                    <a href="https://gmiu.edu.in/gmiu/website/post/arts.php" class="path-card">
                        <div class="path-badge">After 12th</div>
                        <p>Arts & Commerce</p>
                    </a>
                    <a href="https://gmiu.edu.in/gmiu/website/post/post.php" class="path-card">
                        <div class="path-badge">After 12th</div>
                        <p>Science (A Group)</p>
                    </a>
                    <a href="https://gmiu.edu.in/gmiu/website/post/b_group.php" class="path-card">
                        <div class="path-badge">After 12th</div>
                        <p>Science (B Group)</p>
                    </a>
                </div>
            </div>

            <div class="promo-section placement-box">
                <div class="placement-content">
                    <h3>Placement & Career Support</h3>
                    <p>Strong industry tie-ups and dedicated placement cell to kickstart your career.</p>
                    <a href="https://gmiu.edu.in/gmiu/placement.php" class="view-btn">View Placement Details <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="card-contant-contact container-card">
                <div class="content-data">
                    <p>Social Media</p>

                    <div class="social-icons">
                        <a
                            href="https://whatsapp.com/channel/0029VaAlQDCJP217g55N1h2B"
                            target="_black"
                            class="icon-social"
                            style="background-color: #25d366">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>

                        <a
                            href="http://www.gmiu.edu.in"
                            class="icon-social"
                            target="_black"
                            style="background-color: #939393">
                            <i class="fa-light fa-solid fa-globe"></i>
                        </a>

                        <a
                            href="https://www.facebook.com/GyanmanjariColleges"
                            class="icon-social"
                            target="_black"
                            style="background-color: #4267b2">
                            <i class="fa-brands fa-facebook"></i>
                        </a>

                        <a
                            href="https://www.instagram.com/gyanmanjari_innovative_u?igsh=b2hodnd6YmNld3lj"
                            class="icon-social"
                            target="_black"
                            style="background-color: #e1306c">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a
                            href="https://x.com/GMGC_Bhavnagar"
                            class="icon-social"
                            target="_black"
                            style="background-color: RGB(29, 155, 240)">
                            <i class="fa-brands fa-twitter"></i>
                        </a>

                        <a
                            href="https://www.linkedin.com/company/gyanmanjari/"
                            class="icon-social"
                            target="_black"
                            style="background-color: #0e76a8">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <!--href="https://t.me/GMGC_bhavnagar"-->
                        <a
                            href="https://t.me/cD2ShKeSlyRlMTM1"
                            class="icon-social"
                            target="_black"
                            style="background-color: #0088cc">
                            <i class="fa-brands fa-telegram"></i>
                        </a>

                        <a
                            href="https://www.youtube.com/channel/UCzsun63TTJoLySLIWWaA8AQ"
                            class="icon-social"
                            target="_black"
                            style="background-color: #c4302b; padding: 4.2px 10px">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                    <p style="margin-top:20px; text-align:center !important">Connect With our Counseling Center</p>
                    <div class="social-container">
                        <div class="social-card">
                            <p class="social-title">Amreli</p>
                            <a href="https://www.instagram.com/gmiu_amreli" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/gmiu.amreli" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>

                        <div class="social-card">
                            <p class="social-title">Botad</p>
                            <a href="https://www.instagram.com/gmiu_botad" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61564619023427" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>

                        <div class="social-card">
                            <p class="social-title">Dahod</p>
                            <a href="https://www.instagram.com/gmiu_dahod" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61564463717811" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>

                        <div class="social-card">
                            <p class="social-title">Godhra</p>
                            <a href="https://www.instagram.com/gmiu_godhra" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61565610170314" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>

                        <div class="social-card">
                            <p class="social-title">Mahuva</p>
                            <a href="https://www.instagram.com/gmiu_mahuva" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61565341670553" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>

                        <div class="social-card">
                            <p class="social-title">Modasa</p>
                            <a href="https://www.instagram.com/gmiu_modasa" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61564823978799" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>

                        <div class="social-card">
                            <p class="social-title">Porbandar</p>
                            <a href="https://www.instagram.com/gmiu_porbandar" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61565094338022" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>

                        <div class="social-card">
                            <p class="social-title">Surendrenagar</p>
                            <a href="https://www.instagram.com/gmiu_surendranagar" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61564680311025" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>

                        <div class="social-card">
                            <p class="social-title">Surat</p>
                            <a href="https://www.instagram.com/gmiu_surat" target="_blank" class="social-icon instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61564968482733" target="_blank" class="social-icon facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="buttons-two">
                <button class="share-btn">
                    <a href="<?php echo $base_url_website_common; ?>contact_v_card.php"> <i
                            class="fa-solid fa-download"></i></a>
                </button>

                <!-- <div class="container"> -->
                <button class="share-btn" id="share-btn">
                    <i class="fas fa-share-alt"></i>
                </button>
                <div class="share-options">
                    <div class="social-media">
                        <!--    <button class="social-media-btn sharer" data-sharer="whatsapp"
                            data-url="https://gmiu.edu.in/gmiu/website/contact_us.php"><i
                                class="fab fa-whatsapp"></i></button> -->
                        <button class="social-media-btn sharer" data-sharer="email"
                            data-url="https://gmiu.edu.in/gmiu/website/contact_us.php"><i
                                class="fa-solid fa-envelope"></i></button>
                        <button class="social-media-btn sharer" data-sharer="twitter"
                            data-url="https://gmiu.edu.in/gmiu/website/contact_us.php"><i
                                class="fab fa-twitter"></i></button>
                        <button class="social-media-btn sharer" data-sharer="facebook"
                            data-url="https://gmiu.edu.in/gmiu/website/contact_us.php"><i
                                class="fab fa-facebook-f"></i></button>
                        <button class="social-media-btn sharer" data-sharer="linkedin"
                            data-url="https://gmiu.edu.in/gmiu/website/contact_us.php"><i
                                class="fab fa-linkedin-in"></i></button>
                    </div>

                </div>
                <!-- </div> -->
            </div>
        </div>
    </section>
    <?php include '../include/importfooter.php' ?>
    <script>
        const shareBtn = document.querySelector('#share-btn');
        const shareOptions = document.querySelector('.share-options');

        shareBtn.addEventListener('click', () => {
            shareOptions.classList.toggle('active');
        })
    </script>
    <script id="toggle-script">
        const btn = document.getElementById("toggleBtn");
        const extraCards = document.querySelectorAll(".extra-card");

        let expanded = false;

        btn.addEventListener("click", () => {
            expanded = !expanded;

            extraCards.forEach(card => {
                card.style.display = expanded ? "flex" : "none";
            });

            btn.innerText = expanded ? "View Less" : "View More";
        });
    </script>

    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>