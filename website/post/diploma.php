<?php
session_start();
$message = "";
$success = false;
include '../../database/connect.php';
include '../../common/validation.php';
include '../../common/globalvariable.php';

function generateInquiryStudentId(mysqli $con, int $completed_study, int $is_online = 1): string
{
    // Exam code mapping
    $examMap = [
        1 => "10",
        2 => "12C",
        3 => "12A",
        4 => "12B",
        5 => "12AR",
        6 => "UG",
        7 => "PG",
        8 => "D",
        9 => "ITI",
        10 => "DP",
    ];

    $inqPrefix = "WB";
    $examCode = $examMap[$completed_study] ?? "NA";
    $datePart = date("dmy");

    // Count existing records
    $stmt = $con->prepare("
        SELECT COUNT(*) AS total 
        FROM tbl_inquiry_student 
        WHERE is_online = ? AND last_exam = ?
    ");

    $stmt->bind_param("ii", $is_online, $completed_study);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc() ?? ['total' => 0];
    $stmt->close();

    // Generate serial
    $serial = str_pad(((int) $row['total']) + 1, 5, "0", STR_PAD_LEFT);

    return "{$inqPrefix}-{$examCode}-{$datePart}-{$serial}";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Validate input
    $name   = filter_var($_POST['name']);
    $email  = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mobile = filter_var($_POST['mobile']);

    $completed_study = 1; // 10th
    $is_online = 3;

    // Generate inquiry student ID
    $inq_student_id_final = generateInquiryStudentId($con, $completed_study, $is_online);

    // Check duplicate email or mobile
    $stmt = $con->prepare("
        SELECT id 
        FROM tbl_inquiry_student 
        WHERE (email = ? OR mobile_number = ?) 
        AND is_delete = 0
    ");

    $stmt->bind_param("ss", $email, $mobile);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        $message = "Similar Data or the Number is Already Exist !!! <br> Please Choose Another One ...";
    } else {

        $stmt = $con->prepare("
            INSERT INTO tbl_inquiry_student (
                inq_student_id,
                first_name,
                mobile_number,
                email,
                is_online,
                last_exam
            ) VALUES (?,?,?,?,?,?)
        ");

        $admission_student_id = NULL;
        $middle_name = NULL;
        $last_name = NULL;

        $faculty_id = NULL;
        $level_id = NULL;
        $program_id = NULL;

        $stmt->bind_param(
            "ssssii",
            $inq_student_id_final,
            $name,
            $mobile,
            $email,
            $is_online,
            $completed_study
        );

        if ($stmt->execute()) {

            $success = true;

            echo '<script>
                sessionStorage.setItem("formSubmitted","true");
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon:"success",
                        title:"Success!",
                        text:"New record created successfully",
                        confirmButtonColor:"#dc2626"
                    });
                });
            </script>';
        } else {
            $message = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMIU Admissions 2026-27</title>
    <link href="page.css?v=1" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="header">

        <div class="header-logos">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo">

            <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" alt="GMIU PLM Logo">
        </div>

        <div class="header-tagline">
            रट्टा अभ्यास छोड़ो,<br>
            कौशल्यलक्षी शिक्षा से जुड़ो ।
        </div>
        <div class="header-cta">
            <a href="https://gmiu.edu.in/gmiu/website/forms/free-one-day-vacation-workshop-form.php"
                target="_blank"
                class="workshop-btn workshop-btn--sticky">
                <!--<span class="workshop-btn__logo" aria-hidden="true">-->
                <!--    <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" alt="">-->
                <!--</span>-->
                <span>Vacation Free Workshop</span>
            </a>
        </div>

    </div>
   
    <div class="floating-elements">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>
    <div class="floating-elements">
        <div class="floating-shape" style="width: 70px; height: 70px; top: 10%; left: 15%; "></div>
        <div class="floating-shape" style="width: 90px; height: 90px; top: 70%; left: 25%; "></div>
        <div class="floating-shape" style="width: 50px; height: 50px; top: 50%; left: 10%; "></div>
    </div>
    <!-- <div class="floating-elements">
        <div class="floating-shape" style="width: 80px; height: 80px; top: 30%; left: 80%; animation-duration: 8s; animation-delay: 2s;"></div>
        <div class="floating-shape" style="width: 60px; height: 60px; top: 80%; left: 70%; animation-duration: 11s; animation-delay: 4s;"></div>
        <div class="floating-shape" style="width: 100px; height: 100px; top: 15%; left: 90%; animation-duration: 9s; animation-delay: 6s;"></div>
    </div> -->

    <main class="main-content">
        <!-- Compact Image Section -->
        <!-- <section class="compact-image-section">
            <img
                src="https://gmiu.edu.in/gmiu/website_assets/images/admission/diplomaafter10th.jpg"
                alt="GMIU Diploma After 10th - University Admissions"
                class="compact-image">
        </section> -->
        <div class="content-wrapper">

            <section class="content-section text-center faq-section">

                <h2 class="section-title text-red-600 font-bold">
                    આપના પ્રશ્નોના જવાબ
                </h2>

                <div class="pdf-download-card">
                    <div class="pdf-download-card__icon" aria-hidden="true">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="pdf-download-card__meta">
                        <div class="pdf-download-card__title">Diploma FAQ</div>
                        <div class="pdf-download-card__subtitle">Quick answers to common admission questions</div>
                    </div>

                    <a href="<?php echo $website_assets_url; ?>images/leaflet/diploma-faq.pdf"
                        download
                        class="pdf-download-btn">
                        <i class="fas fa-file-arrow-down"></i>
                        <span>Download PDF</span>
                    </a>
                </div>

            </section>
            <section class="content-section text-center reveal">
                <h2 class="section-title text-red-600 font-bold ">
                    ધોરણ 10 પછી ડિપ્લોમા જ શા માટે ?...
                </h2>

                <div class="bg-white p-6 rounded-xl shadow-lg mt-6 text-left">
                    <ul class="space-y-3 text-lg">
                        <li>✔️ ફક્ત 3 વર્ષનો કોર્સ એ પણ 12 સમકક્ષ સર્ટિફિકેટ સાથે</li>
                        <li>✔️ ગુજરાતી / અંગ્રેજી માધ્યમમાં સંપૂર્ણ અભ્યાસ</li>
                        <li>✔️ D2D ડિપ્લોમા થી ડિગ્રી બાદ સારા પ્લેસમેન્ટ વિપુલ તક</li>
                        <li>✔️ ધોરણ 11-12 ની સરખામણીમાં ઓછા સમયમાં ચોઇસ મુજબ નોકરી / ધંધાની તક</li>
                        <li>✔️ ધોરણ 11-12 પછી આપવી પડતી JEE/NEET જેવી પ્રવેશ પરીક્ષા થી છુટકારો</li>
                        <li>✔️ ડિપ્લોમા કર્યા બાદ વિદ્યાર્થી પોતાનો વ્યવસાય પણ સરળતાથી કરી શકે છે</li>
                        <li>✔️ ડિપ્લોમા પછી ડિગ્રી એન્જિનિયરિંગ માં સીધો બીજા વર્ષમાં પ્રવેશ</li>
                    </ul>
                </div>
            </section>

            <section class="content-section text-center reveal">

                <h2 class="section-title text-red-600 font-bold ">
                    ધોરણ - 11 & 12 કે ડિપ્લોમા એન્જિનિયરિંગ??
                </h2>

                <div class="mt-6 max-w-xl mx-auto">
                    <img src="../Diploma-Benifites.jpg"
                        alt="Diploma vs 11 12"
                        class="mx-auto rounded-lg shadow-lg">

                    <div class="mt-4">
                        <a href="../Diploma-Benifites.jpg" download class="see-more-btn">
                            Download Image
                        </a>
                    </div>
                </div>

            </section>
            <section class="content-section">
                <div class="plm-highlight">
                    <h3>
                        🚀 Proficient Learning Method (PLM)
                    </h3>
                    <p>
                        Experience GMIU’s unique teaching methodology designed to build
                        <strong>practical knowledge, industry skills, and innovation mindset</strong>.
                    </p>
                    <a href="https://gmiu.edu.in/gmiu/promotional/key-feature-of-plm.php"
                        class="plm-btn">
                        Explore PLM Method
                    </a>
                </div>
            </section>

            <section class="content-section text-center reveal">
                <div class="section-head">
               
                    <h2 class="section-title section-title--clean">Diploma Programs</h2>
                    <p class="section-subtitle">Explore career-focused programs designed for skill and industry readiness.</p>
                </div>

                <div class="diploma-grid">
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-computer-science-and-engineering">
                        <div class="diploma-card__icon"><i class="fas fa-laptop-code"></i></div>
                        <div class="diploma-card__title">Computer Science Engineering</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-computer-engineering">
                        <div class="diploma-card__icon"><i class="fas fa-microchip"></i></div>
                        <div class="diploma-card__title">Computer Engineering</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-information-technology">
                        <div class="diploma-card__icon"><i class="fas fa-network-wired"></i></div>
                        <div class="diploma-card__title">Information Technology</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-chemical-engineering">
                        <div class="diploma-card__icon"><i class="fas fa-flask"></i></div>
                        <div class="diploma-card__title">Chemical Engineering</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-electrical-engineering">
                        <div class="diploma-card__icon"><i class="fas fa-bolt"></i></div>
                        <div class="diploma-card__title">Electrical Engineering</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-electronics-amp-communication-engineering">
                        <div class="diploma-card__icon"><i class="fas fa-broadcast-tower"></i></div>
                        <div class="diploma-card__title">Electronics and Communication Engineering</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-interior-design">
                        <div class="diploma-card__icon"><i class="fas fa-couch"></i></div>
                        <div class="diploma-card__title">Interior Design</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-design/diploma-diploma-in-fashion-design-after-12th-">
                        <div class="diploma-card__icon"><i class="fas fa-shirt"></i></div>
                        <div class="diploma-card__title">Fashion Design</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-mechanical-engineering">
                        <div class="diploma-card__icon"><i class="fas fa-gears"></i></div>
                        <div class="diploma-card__title">Mechanical Engineering</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                
                    <div class="diploma-card" data-link="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma/diploma-civil-engineering">
                        <div class="diploma-card__icon"><i class="fas fa-building"></i></div>
                        <div class="diploma-card__title">Civil Engineering</div>
                        <div class="diploma-card__cta">View details <i class="fas fa-arrow-right"></i></div>
                    </div>
                </div>

            </section>

            <section class="content-section text-center reveal">
                <h2 class="section-title ">SHORTS COVERAGE</h2>
                <?php $stmt = $con->prepare("SELECT file FROM tbl_post 
                                WHERE field_name = ? 
                                AND is_active = ? 
                                AND is_delete = ? ORDER BY id DESC
                       LIMIT 3");
                $file_type = 'after10th';
                $is_active = 1;
                $is_delete = 0;
                $stmt->bind_param("sii", $file_type, $is_active, $is_delete);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                <div class="reel-wrapper">
                    <div class="video-grid">
                        <?php while ($row = $result->fetch_assoc()) {
                            $videoUrl = trim($row['file']);
                        ?>
                            <div class="video-card interactive-card">
                                <iframe src="https://www.youtube.com/embed/<?php echo $videoUrl; ?>?autoplay=0&mute=0&rel=0" title="YouTube video player" allowfullscreen loading="lazy"></iframe>

                            </div>
                        <?php  } ?>
                    </div>

                    <div class="text-center">
                        <a href="diploma_reel.php" class="see-more-btn">
                            <i class="fas fa-play-circle mr-2"></i>View More Videos
                        </a>
                    </div>
                </div>
            </section>

            <section class="content-section text-center reveal">
                <h2 class="section-title ">Download Brochures</h2>
                <div class="brochure-grid">

                    <div class="brochure-card interactive-card">
                        <a href="<?php echo $website_assets_url; ?>images/leaflet/8-Leaflet.pdf" target="_blank">
                            <img src="<?php echo $website_assets_url; ?>images/leaflet/d1.png" alt="University Brochure">
                            <div class="brochure-content">
                                <h4>University Brochure</h4>
                                <p>Complete information about our programs and facilities</p>
                            </div>
                            <div class="download-overlay">
                                <i class="fas fa-download fa-2x"></i>
                            </div>
                        </a>
                    </div>

                    <div class="brochure-card interactive-card">
                        <a href="<?php echo $website_assets_url; ?>images/leaflet/4-Leaflet.pdf" target="_blank">
                            <img src="<?php echo $website_assets_url; ?>images/leaflet/1.jpg" alt="Academic & Placement Activities">
                            <div class="brochure-content">
                                <h4>Academic & Placement Activities</h4>
                                <p>Explore our academic programs and placement opportunities</p>
                            </div>
                            <div class="download-overlay">
                                <i class="fas fa-download fa-2x"></i>
                            </div>
                        </a>
                    </div>

                    <div class="brochure-card interactive-card">
                        <a href="<?php echo $website_assets_url; ?>images/leaflet/LEAFLET6.pdf" target="_blank">
                            <img src="<?php echo $website_assets_url; ?>images/leaflet/d2.png" alt="Why GMIU?">
                            <div class="brochure-content">
                                <h4>Why GMIU?</h4>
                                <p>Discover what makes us the right choice for your education</p>
                            </div>
                            <div class="download-overlay">
                                <i class="fas fa-download fa-2x"></i>
                            </div>
                        </a>
                    </div>

                </div>
            </section>

            <!-- Admission Information Box -->
            <section class="admission-box">
                <div class="admission-content">
                    <div class="admission-info">
                        <h3><i class="fas fa-graduation-cap mr-2"></i><b>ADMISSION 2026-27</b></h3>
                        <hr style="border-color: rgba(255, 255, 255, 0.3); margin-bottom: 1rem;">
                        <h4 style="margin-bottom: 0.5rem;">For admission regarding query:</h4>
                        <p>
                            <i class="fa-solid fa-phone mr-2"></i>
                            <span class="phone-number">+91 90999 51160</span>,
                            <span class="phone-number">+91 75749 49494</span>
                        </p>
                    </div>
                    <div class="admission-action">
                        <a href="<?php echo isset($base_url_admission) ? $base_url_admission : '#'; ?>" class="apply-btn">
                            <i class="fas fa-arrow-right mr-2"></i>Apply Now
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <a href="https://api.whatsapp.com/send?phone=917574949494&text=Hello%20I%20Am%20Interested%20in%20Admission" class="whatsapp-float" target="_blank" aria-label="Contact via WhatsApp">
        <i class="fab fa-whatsapp fa-lg"></i>
    </a>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 class="text-2xl font-bold text-red-600 text-center mb-6">
                <i class="fas fa-clock mr-2"></i>Admissions Now Open for Diploma Programs 2026-27
            </h3>

            <?php if (!empty($message)): ?>
                <div class="error-message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form id="popupForm" method="post" action="" onsubmit="return validateForm()" class="space-y-4">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="tel" id="mobile" name="mobile" required>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Inquiry
                </button>
            </form>
        </div>
    </div>
    <!--<div class="mobile-cta">-->
    <!--    <a href="https://gmiu.edu.in/gmiu/website/forms/free-one-day-vacation-workshop-form.php" target="_blank">-->
    <!--        🎯 Register Workshop-->
    <!--    </a>-->
    <!--</div>-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script>
        // Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('myModal');
            const closeBtn = document.getElementsByClassName('close')[0];

            // Show modal after 30 seconds if not submitted before and no PHP message
            <?php if (empty($message) && !$success): ?>
                if (!sessionStorage.getItem('formSubmitted')) {
                    setTimeout(() => {
                        modal.style.display = 'block';
                    }, 30000);
                }
            <?php endif; ?>

            // Show modal immediately if there's a PHP message
            <?php if (!empty($message)): ?>
                modal.style.display = 'block';
            <?php endif; ?>

            closeBtn.onclick = () => {
                modal.style.display = 'none';
            };

            window.onclick = (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            };

            // Handle form submission
            document.getElementById('popupForm').addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }

                // Let the PHP handle the submission
                sessionStorage.setItem('formSubmitted', 'true');
            });
        });
    </script> -->
    <script src="page.js"></script>
    <script>
        document.querySelectorAll('.diploma-card').forEach(card => {
            card.addEventListener('click', () => {
                const link = card.getAttribute('data-link');
                if (link) {
                    window.open(link, '_blank');
                }
            });
        });
        const reveals = document.querySelectorAll(".reveal");

        window.addEventListener("scroll", () => {
            reveals.forEach(el => {
                const top = el.getBoundingClientRect().top;
                if (top < window.innerHeight - 100) {
                    el.classList.add("active");
                }
            });
        });
    </script>
</body>

</html>