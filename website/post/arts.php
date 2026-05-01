<?php
session_start();
$message = "";
$success = false;
include '../../database/connect.php';
include '../../common/validation.php';
include '../../common/globalvariable.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cmd = $con->prepare("SELECT COUNT(*) FROM tbl_inquiry_student ");
    $cmd->execute();
    $result = $cmd->get_result();
    $row = $result->fetch_row();
    $inq_student_id = $row[0] + 1;
    $inq_student_id_padded = str_pad($inq_student_id, 3, '0', STR_PAD_LEFT);

    $inq_student_id_final = "INQ" . "$inq_student_id_padded";

    // Validate and sanitize input
    $name = filter_var($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mobile = filter_var($_POST['mobile']);
    $course = '6';
    $is_online = '3';

    // Check if email or mobile number already exists in the database
    $stmt = $con->prepare("SELECT id FROM tbl_inquiry_student WHERE email = ? OR mobile_number = ? and is_delete=0");
    $stmt->bind_param("ss", $email, $mobile);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Record already exists
        $message = "Similar Data or the Number is Already Exist !!! <br> Please Choose Another One ...";
    } else {
        // Prepare and bind
        $stmt = $con->prepare("INSERT INTO tbl_inquiry_student (inq_student_id, first_name, email, mobile_number, last_exam,  is_online) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $inq_student_id_final, $name, $email, $mobile, $course, $is_online); // Adjust if adding qualification and course

        if ($stmt->execute()) {
            $success = true;
            echo '<script>
                   sessionStorage.setItem("formSubmitted", "true");
                   // Using SweetAlert instead of regular alert for better UX
                   document.addEventListener("DOMContentLoaded", function() {
                       Swal.fire({
                           icon: "success",
                           title: "Success!",
                           text: "New record created successfully",
                           confirmButtonColor: "#dc2626"
                       });
                   });
                  </script>';
            exit(); // Important to prevent further execution
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
    // Close statement
    $stmt->close();
    // Close connection
    $con->close();
}
?>

<!doctype html>
<html class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMIU Admissions 2025-26</title>
    <link href="page.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="header">
        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo">
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
        <section class="compact-image-section">
            <img
                src="https://gmiu.edu.in/gmiu/website_assets/images/admission/1.jpg"
                alt="University Admissions"
                class="compact-image">
        </section>

        <div class="content-wrapper">
            <section class="content-section">
                <h2 class="section-title">SHORTS COVERAGE</h2>
                <?php $stmt = $con->prepare("SELECT file FROM tbl_post 
                                WHERE field_name = ? 
                                AND is_active = ? 
                                AND is_delete = ? ORDER BY id ASC 
                       LIMIT 3");
                $file_type = 'afterGraduation';
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
                        <a href="arts_reel.php" class="see-more-btn">
                            <i class="fas fa-play-circle mr-2"></i>View More Videos
                        </a>
                    </div>
            </section>

            <section class="content-section">
                <h2 class="section-title">Download Brochures</h2>
                <div class="brochure-grid">

                    <div class="brochure-card interactive-card">
                        <a href="<?php echo $website_assets_url; ?>images/leaflet/8_page_Leaflet.pdf" target="_blank">
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
                        <a href="<?php echo $website_assets_url; ?>images/leaflet/TPA_CTL-2.pdf" target="_blank">
                            <img src="<?php echo $website_assets_url; ?>images/leaflet/ctl_activity.jpg" alt="Academic & Placement Activities">
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
                        <h3><i class="fas fa-graduation-cap mr-2"></i><b>ADMISSION 2025-26</b></h3>
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
                <i class="fas fa-clock mr-2"></i>Hurry Up! Admissions Closing Soon
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
    </script>
    <script src="page.js"></script>
</body>

</html>