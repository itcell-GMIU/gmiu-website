
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include '../../common/importwebsitefile.php';
include('smtp/PHPMailerAutoload.php');

if (isset($_POST['submit'])) {
    if (!empty($_POST['honeypot'])) {
        die("Bot detected");
    }
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($con, $_POST['email']);

// Check for malicious patterns (e.g., SQL injection, script tags)
$malicious_patterns = "/['\";]+|(\b(SELECT|UNION|INSERT|UPDATE|DELETE|DROP|ALTER|SCRIPT|ONERROR|ONLOAD)\b)/i";
if (preg_match($malicious_patterns, $name . $subject . $message)) {
    $_SESSION['status'] = "Invalid input detected. Please remove any special characters or code.";
    $_SESSION['status_code'] = "warning";
    echo "<script>setTimeout(function(){window.location='website_contact_us.php'},2000)</script>";
    exit;
}

     // Check if email already exists in the database
    $email_check_query = "SELECT * FROM tbl_website_contact_us WHERE email = ?";
    $email_check_stmt = $con->prepare($email_check_query);
    $email_check_stmt->bind_param("s", $email);
    $email_check_stmt->execute();
    $result = $email_check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['status'] = "This email is already in use. Please use a different email.";
        $_SESSION['status_code'] = "warning";
        echo "<script>setTimeout(function(){window.location='website_contact_us.php'},2000)</script>";
        exit;
    }

    $stmt = $con->prepare("INSERT INTO tbl_website_contact_us (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        
        // Sending acknowledgment email to the user
        $user_subject = "Thank you for contacting Gyanmanjari Innovative University";
        $user_message = "
            <p>Dear $name,</p>
            <p>Thank you for reaching out to Gyanmanjari Innovative University. We have received your inquiry and will get back to you shortly.</p>
            <p><b>Your Inquiry Details:</b></p>
            <ul>
                <li><b>Subject:</b> $subject</li>
                <li><b>Message:</b> $message</li>
            </ul>
            <p>Best regards,<br>Admissions Team<br>Gyanmanjari Innovative University</p>
        ";
        smtp_mailer($email, $user_subject, $user_message);

        $_SESSION['status'] = "Submitted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='website_contact_us.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Something Went Wrong.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='website_contact_us.php'},2000)</script>";
    }
}

// SMTP Mailer Function
function smtp_mailer($to, $subject, $msg)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "admissions@gmiu.edu.in";
    $mail->Password = "uhna gbjn dtee tsfy";
    // $mail->Password = "zxbs mqtb godu jcmf";
    $mail->SetFrom("admissions@gmiu.edu.in", "GMIU Admissions");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    if (!$mail->Send()) {
        error_log("Email Error: " . $mail->ErrorInfo);
        return false;
    }
    return true;
}

?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Contact Us - Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Contact GMIU for inquiries – reach out for more information about programs, admissions, campus facilities, and other details to assist your academic journey.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
    <!-- Include FontAwesome globally for robust loading if not in importcss -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
    /* Premium Glassmorphism and Modern Animations */
    :root {
        --primary-gmiu: #ba2a21;
        --primary-gmiu-dark: #8c1e17;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.4);
        --glass-shadow: 0 8px 32px 0 rgba(186, 42, 33, 0.15);
        --text-dark: #333333;
        --text-muted: #727272;
    }

    body.courses {
        background: #f4f6f9;
    }

    /* Redesigned Hero Section */
    .hero-modern {
        position: relative;
        padding: 100px 0 120px;
        text-align: center;
        background: linear-gradient(135deg, var(--primary-gmiu) 0%, var(--primary-gmiu-dark) 100%);
        color: #fff;
        overflow: hidden;
        margin-bottom: -50px;
        z-index: 1;
    }
    .hero-modern::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: -10%;
        width: 120%;
        height: 100px;
        background: #f4f6f9;
        transform: rotate(-3deg);
        z-index: -1;
    }
    .hero-modern h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .hero-modern p {
        font-size: 16px;
        font-weight: 500;
    }
    .hero-modern p a {
        color: rgba(255,255,255,0.8);
        transition: color 0.3s ease;
        text-decoration: none;
    }
    .hero-modern p a:hover {
        color: #fff;
    }
    .hero-modern p span {
        margin: 0 8px;
    }
    .hero-modern .b-active a {
        font-weight: bold;
        color: #fff;
    }

    /* Glassmorphism Contact Section */
    .glass-section {
        padding: 0 0 100px;
        position: relative;
        z-index: 2;
    }
    .glass-container {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: var(--glass-shadow);
        overflow: hidden;
        display: flex;
        flex-wrap: wrap;
        transform: translateY(-40px);
    }

    /* Left Grid: Info area */
    .contact-info-modern {
        flex: 0 0 45%;
        max-width: 45%;
        padding: 60px 50px;
        background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
        position: relative;
    }
    .contact-info-modern h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
        position: relative;
    }
    .contact-info-modern > p {
        color: var(--text-muted);
        font-size: 15px;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 35px;
        transition: transform 0.3s ease;
        text-decoration: none;
    }
    .info-item:hover {
        transform: translateX(10px);
    }
    .info-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        background: rgba(186, 42, 33, 0.08);
        color: var(--primary-gmiu);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-right: 25px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    .info-item:hover .info-icon {
        background: var(--primary-gmiu);
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(186, 42, 33, 0.3);
    }

    .info-content h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-dark);
    }
    .info-content p, .info-content a {
        color: var(--text-muted);
        font-size: 15px;
        line-height: 1.6;
        text-decoration: none;
        transition: color 0.3s ease;
        margin: 0;
    }
    .info-content a:hover {
        color: var(--primary-gmiu);
    }
    .map-link {
        display: inline-block;
        margin-top: 12px;
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-gmiu) !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    .info-item:hover .map-link {
        transform: translateX(5px);
    }

    /* Social Icons */
    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 50px;
    }
    .social-links a {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dark);
        font-size: 18px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
    }
    .social-links a:hover {
        background: var(--primary-gmiu);
        color: #fff;
        border-color: var(--primary-gmiu);
        transform: translateY(-8px) scale(1.1);
        box-shadow: 0 10px 20px rgba(186, 42, 33, 0.25);
    }

    /* Right Grid: Form Area */
    .contact-form-modern {
        flex: 0 0 55%;
        max-width: 55%;
        padding: 60px 70px;
    }
    .contact-form-modern h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
    }
    .contact-form-modern > p {
        color: var(--text-muted);
        font-size: 15px;
        margin-bottom: 40px;
    }

    .modern-form-group {
        position: relative;
        margin-bottom: 25px;
    }
    .modern-form-control {
        width: 100%;
        padding: 16px 20px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 12px;
        font-size: 15px;
        font-family: inherit;
        color: var(--text-dark);
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .modern-form-control:focus {
        outline: none;
        background: #ffffff;
        border-color: var(--primary-gmiu);
        box-shadow: 0 0 0 4px rgba(186, 42, 33, 0.15);
        transform: translateY(-2px);
    }
    textarea.modern-form-control {
        resize: vertical;
        min-height: 150px;
    }

    .submit-btn-modern {
        background: linear-gradient(135deg, var(--primary-gmiu) 0%, var(--primary-gmiu-dark) 100%);
        color: #fff;
        border: none;
        border-radius: 30px;
        padding: 16px 45px;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(186, 42, 33, 0.2);
        width: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .submit-btn-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(186, 42, 33, 0.35);
    }
    .submit-btn-modern i {
        transition: transform 0.3s ease;
    }
    .submit-btn-modern:hover i {
        transform: translateX(5px);
    }

    @media(max-width: 991px) {
        .contact-info-modern {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 50px 30px;
            border-right: none;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .contact-form-modern {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 50px 30px;
        }
    }
    @media(max-width: 767px) {
        .hero-modern {
            padding: 80px 0 100px;
        }
        .hero-modern h1 {
            font-size: 36px;
        }
        .glass-container {
            border-radius: 16px;
        }
    }
    </style>
</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Contact Us For Admission</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Contact Us</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <!-- Glassmorphism Section -->
    <section class="glass-section">
        <div class="container">
            <div class="glass-container">
                <!-- Left Details -->
                <div class="contact-info-modern">
                    <h2>Contact Info</h2>
                    <p>Welcome to our Website. We are glad to have you around. Reach out to us through any of the following channels.</p>
                    
                    <div class="info-item">
                        <div class="info-icon"><i class="fa fa-phone"></i></div>
                        <div class="info-content">
                            <h4>Phone</h4>
                            <p>
                                <a href="tel:919099951160">+91 90999 51160</a><br>
                                <a href="tel:917574949494">+91 75749 49494</a>
                            </p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fa fa-envelope"></i></div>
                        <div class="info-content">
                            <h4>Email</h4>
                            <p><a href="mailto:info@gmiu.edu.in">info@gmiu.edu.in</a></p>
                        </div>
                    </div>

                    <a href="https://goo.gl/maps/Rew9anmSejXpQ2ucA" target="_blank" class="info-item">
                        <div class="info-icon"><i class="fa fa-map-marker"></i></div>
                        <div class="info-content">
                            <h4>Location</h4>
                            <p>Survey No. 30, Sidsar Road,<br>Bhavnagar Gujarat(India), 364060</p>
                            <span class="map-link">Get Direction <i class="fa fa-arrow-right"></i></span>
                        </div>
                    </a>

                    <div class="social-links">
                        <a href="https://www.facebook.com/GyanmanjariColleges" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://x.com/GMGC_Bhavnagar" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/gyanmanjari/" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/gyanmanjari_innovative_u?igsh=b2hodnd6YmNld3lj" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Right Form -->
                <div class="contact-form-modern">
                    <h2>Send A Message</h2>
                    <p>We would love to hear from you. Fill out the form below and we will get back to you shortly.</p>
                    
                    <form method="POST" id="contactForm">
                        <input type="text" name="honeypot" style="display:none;">
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="modern-form-group">
                                    <input type="text" placeholder="Name" name="name" id="name" class="modern-form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="modern-form-group">
                                    <input type="email" placeholder="Email" name="email" id="email" class="modern-form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="modern-form-group">
                                    <input type="text" placeholder="Subject" name="subject" id="subject" class="modern-form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="modern-form-group">
                                    <textarea placeholder="Message" name="message" id="comments" class="modern-form-control" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" name="submit" class="submit-btn-modern">
                                    Submit Message <i class="fa fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>