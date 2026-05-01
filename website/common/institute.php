<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/contact_us.css">

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
            padding: 10px 12px 7px 12px;
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

        .custom-card {
            border: none !important;
            border-radius: 10px !important;
            background: #ba2a21 !important;
            /* Light gray background */
            box-shadow: inset 4px 4px 6px rgba(0, 0, 0, 0.2),
                inset -4px -4px 6px rgba(255, 255, 255, 0.7) !important;
            /* Inner shadow effect */
            overflow: hidden !important;
            margin: 10px 20px !important;
            padding: 10px 20px !important;
            transition: box-shadow 0.5s ease-in-out, transform 0.3s ease-in-out !important;
        }

        .custom-card:hover {
            box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.2),
                -4px -4px 6px rgba(255, 255, 255, 0.7) !important;
            transform: scale(1.05);
            /* Slight zoom effect for a smoother transition */
        }
    </style>
    <!--   -->
</head>

<body class="courses">
    <section class="background" style="background-color: #fff;">

    </section>

    <section class="contact_us">
        <div class="card-contact_us">
            <div class="header-section container-card">
                <img src="<?php echo $website_assets_url; ?>images/Logo with BG@2x.png" alt="">
                <h2 class="text-danger">Gyanmanjari Innovative University-GMIU</h2>
                <div class="three-contact">
                    <a href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                        <div class="small-card" style="border-right: 1px solid rgba(255,255,255,0.15);">
                            <i class="fa-solid fa-globe text-danger margin-icon"></i>
                            <p class="text-danger">Virtual Tour</p>
                        </div>
                    </a>

                    <a href="https://gmiu.edu.in/gmiu/admission/">
                        <div class="small-card" style="border-right: 1px solid rgba(255,255,255,0.15);">
                            <i class="fa-solid fa-university text-danger margin-icon"></i>
                            <p class="text-danger">APPLY NOW</p>
                        </div>
                    </a>

                    <a href="https://goo.gl/maps/Rew9anmSejXpQ2ucA">
                        <div class="small-card">
                            <i class="fa-solid fa-location-dot text-danger margin-icon"></i>
                            <p class="text-danger">DIRECTIONS</p>
                        </div>
                    </a>

                </div>
            </div>
            <?php
                $faculties = [
                    "Diploma" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma",
                    "Engineering" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology",
                    "Science" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-science",
                    "Pharmacy" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-pharmacy",
                    "Commerce" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-commerce",
                    "Arts" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-arts",
                    "Management" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-management",
                    "Computer Applications (BCA/MCA)" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-computer-application-bca-amp-mca-",
                    "Law" => "https://gmiu.edu.in/gmiu/website/faculty/faculty-of-law",
                    "Girls' College" => "https://admission.gmiu.edu.in/admission/girlscollege.php",
                    "Premium Program" => "https://admission.gmiu.edu.in/premium/index.php"
                ];
                
                foreach ($faculties as $name => $link) {
                ?>
                    <a href="<?php echo $link; ?>" target="_blank">
                        <div class="custom-card">
                            <h4 class="text-white"><?php echo $name; ?></h4>
                        </div>
                    </a>
                <?php
                }
            ?>
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

    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>