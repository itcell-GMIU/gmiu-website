<!-- Footer Area section -->
<style>
    /* Professional Global Enhancements */
    :root {
        --brand-red: #ba2a21;
        --brand-navy: #323a52;
        --soft-gray: #f8f9fa;
    }

    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #ba2a21;
        color: white;
        padding: 16px 24px;
        font-size: 16px;
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        opacity: 1;
        transition: all 0.5s ease;
        z-index: 9999;
    }

    .toast.success {
        background-color: #2e7d32;
    }

    /* Premium University Footer Styling */
    .modern-footer {
        background: radial-gradient(circle at 20% 150%, var(--brand-red) 0%, transparent 40%),
            radial-gradient(circle at 80% -50%, var(--brand-navy) 0%, #050a18 100%);
        color: #e2e8f0;
        padding: 50px 0 0;
        font-family: 'Inter', sans-serif;
        position: relative;
        overflow: hidden;
    }

    /* Subtle Glass Texture */
    .modern-footer::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        opacity: 0.08;
        pointer-events: none;
    }

    .footer-top {
        position: relative;
        z-index: 1;
        /*padding-bottom: 70px;*/
    }

    .footer-logo {
        max-width: 220px;
        margin-bottom: 35px;
        display: block;
        filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
    }

    .footer-col h3 {
        color: #ffffff;
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 35px;
        position: relative;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .footer-col h3::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 0;
        width: 35px;
        height: 4px;
        background: var(--brand-red);
        border-radius: 2px;
    }

    .footer-col p {
        line-height: 1.8;
        margin-bottom: 30px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 16px;
        font-size: 14px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.65);
        text-decoration: none;
        transition: 0.3s;
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .footer-links a:hover {
        color: #ffffff;
        transform: translateX(5px);
    }

    .footer-links i {
        font-size: 14px;
        width: 28px;
        color: #ffffff;
        opacity: 0.9;
    }

    .footer-contact-info {
        list-style: none;
        padding: 0;
        margin-bottom: 40px;
    }

    .footer-contact-info li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }

    .footer-contact-info i {
        color: #ffffff;
        margin-right: 18px;
        font-size: 16px;
        margin-top: 4px;
        width: 20px;
        text-align: center;
    }

    .footer-contact-info a {
        color: #ffffff !important;
        text-decoration: none;
        transition: 0.3s;
    }

    .footer-contact-info a:hover {
        opacity: 0.8;
    }

    /* Integrated Newsletter Bar */
    .newsletter-section {
        margin-top: 50px;
    }

    .newsletter-section h3 {
        font-size: 14px;
        color: #fff;
        text-transform: uppercase;
        margin-bottom: 20px;
        font-weight: 800;
    }

    .newsletter-form-wrap {
        display: flex;
        max-width: 450px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 5px;
        border-radius: 50px;
        transition: 0.3s;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
    }

    .newsletter-form-wrap:focus-within {
        border-color: var(--brand-red);
        background: rgba(255, 255, 255, 0.08);
    }

    .newsletter-form-wrap input {
        flex: 1;
        background: transparent;
        border: none;
        padding: 10px 25px;
        color: #fff;
        font-size: 14px;
        outline: none;
    }

    .newsletter-form-wrap button {
        background: var(--brand-red);
        color: #ffffff;
        border: none;
        padding: 10px 30px;
        border-radius: 50px;
        font-weight: 800;
        cursor: pointer;
        transition: 0.3s;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
    }

    .newsletter-form-wrap button:hover {
        background: #96221a;
        transform: scale(1.02);
    }

    /* Horizontal Newsletter Bar */
    .footer-newsletter-bar {
        /*border-top: 1px solid rgba(255, 255, 255, 0.15);*/
        /*padding-top: 40px;*/
        margin-top: 20px;
    }

    .newsletter-horizontal {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
        flex-wrap: wrap;
        padding: 15px 0;
    }

    .newsletter-horizontal h3 {
        margin: 0 !important;
        white-space: nowrap;
        color: #ffffff !important;
        font-size: 18px !important;
        font-weight: 800 !important;
        letter-spacing: 1px;
        padding-bottom: 0 !important;
    }

    .newsletter-horizontal h3::after {
        display: none;
        /* Hide the red line for horizontal view */
    }

    /* Footer Bottom Layout */
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding: 30px 0;
        position: relative;
        z-index: 1;
    }

    .footer-bottom-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .copyright-text {
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
    }

    .it-cell-highlight {
        color: #ba2a21;
        font-weight: 700;
        text-decoration: none;
    }

    .social-links-wrap {
        display: flex;
        gap: 12px;
    }

    .social-box {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 15px;
        text-decoration: none;
        transition: 0.3s;
    }

    .social-box:hover {
        background: #1e293b;
        border-color: #ba2a21;
        color: #ba2a21;
        transform: translateY(-3px);
    }

    @media (max-width: 991px) {
        .footer-col {
            margin-bottom: 50px;
        }

        .footer-bottom-inner {
            flex-direction: column-reverse;
            text-align: center;
            gap: 30px;
        }

        .newsletter-form-wrap {
            max-width: 100%;
        }

        .newsletter-horizontal {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .footer-newsletter-bar {
            padding-top: 30px;
        }

        @media (max-width: 480px) {
            .newsletter-form-wrap {
                flex-direction: row !important;
                /* Keep one line */
                border-radius: 50px !important;
            }

            .newsletter-form-wrap input {
                padding: 8px 15px !important;
                font-size: 12px !important;
            }

            .newsletter-form-wrap button {
                padding: 8px 15px !important;
                font-size: 10px !important;
            }
        }
    }

    /* Entrance Animation */
    @keyframes fadeInUpRight {
        from {
            opacity: 0;
            transform: translate3d(-30px, 40px, 0);
        }

        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    .footer-col {
        animation: fadeInUpRight 0.8s ease-out both;
    }

    .footer-col:nth-child(1) {
        animation-delay: 0.1s;
    }

    .footer-col:nth-child(2) {
        animation-delay: 0.2s;
    }

    .footer-col:nth-child(3) {
        animation-delay: 0.3s;
    }

    .footer-col:nth-child(4) {
        animation-delay: 0.4s;
    }

    .footer-newsletter-bar {
        animation: fadeInUpRight 0.8s ease-out 0.5s both;
    }
</style>

<footer class="modern-footer">
    <div class="container">
        <div class="row footer-top">
            <!-- Column 1: Brand & Contact -->
            <div class="col-lg-3 col-md-12 footer-col">
                <a href="https://gmiu.edu.in/gmiu/website/" target="_blank" title="Visit GMIU Website">
                    <img src="https://admission.gmiu.edu.in/assets/home/images/gmiulogo-white.png"
                        alt="GMIU Logo"
                        class="footer-logo">
                </a>
                <p>Gyanmanjari Innovative University is a leading institution dedicated to industry-oriented education through our unique Proficient Learning Method (PLM).</p>

                <ul class="footer-contact-info">
                    <li><i class="fa fa-phone"></i><a href="tel:+919099951160">+91 90999 51160</a></li>
                    <li><i class="fa fa-envelope"></i><a href="mailto:info@gmiu.edu.in">info@gmiu.edu.in</a></li>
                    <li><i class="fa fa-map-marker"></i><span>Sidsar Road, Bhavnagar, Gujarat 364060</span></li>
                </ul>
            </div>

            <!-- Column 2: Students / Parents -->
            <div class="col-lg-3 col-md-4 footer-col">
                <h3>Students / Parents</h3>
                <ul class="footer-links">
                    <li><a href="https://admission.gmiu.edu.in/premium/index.php"><i class="fa fa-crown"></i> PLM Excellence</a></li>
                    <li><a href="https://gmiu.edu.in/gmiu/website/admission/scholarships.php"><i class="fa fa-graduation-cap"></i> Scholarship</a></li>
                    <li><a href="https://gujacpc.admissions.nic.in/"><i class="fa fa-globe"></i> ACPC Website</a></li>
                    <li><a href="https://gujdiploma.admissions.nic.in/"><i class="fa fa-globe"></i> ACPDC Website</a></li>
                    <li><a href="https://www.iep.gtu.ac.in/"><i class="fa fa-plane"></i> IEP Program</a></li>
                    <li><a href="https://nptel.ac.in/"><i class="fa fa-book"></i> NPTEL</a></li>
                    <li><a href="http://www.aicte.gov.in/"><i class="fa fa-university"></i> AICTE</a></li>
                    <li><a href="https://gmiu.edu.in/gmiu/website/campus/FAQ.php"><i class="fa fa-question-circle"></i> FAQ</a></li>
                </ul>
            </div>

            <!-- Column 3: Quick Links -->
            <div class="col-lg-3 col-md-4 footer-col">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="<?php echo $base_url_website_campus; ?>career.php"><i class="fa fa-briefcase"></i> Careers</a></li>
                    <li><a href="<?php echo $base_url_website_campus; ?>committee.php"><i class="fa fa-users"></i> Committees</a></li>
                    <li><a href="<?php echo $base_url_website_campus; ?>whpcell.php"><i class="fa fa-female"></i> Women Cell</a></li>
                    <li><a href="<?php echo $base_url_website_campus ?>ugc_perfoma.php"><i class="fa fa-file-text"></i> UGC Performa</a></li>
                    <li><a href="<?php echo $base_url_website_campus; ?>anti-ragging.php"><i class="fa fa-ban"></i> Anti-Ragging</a></li>
                    <li><a href="<?php echo $base_url_website_campus; ?>innovation_cell.php"><i class="fa fa-lightbulb-o"></i> Innovation Cell</a></li>
                    <li><a href="https://mentorship.gmiu.edu.in/"><i class="fa fa-handshake-o"></i> Mentoring</a></li>
                </ul>
            </div>

            <!-- Column 4: Legal Resources -->
            <div class="col-lg-3 col-md-4 footer-col">
                <h3>Legal Resources</h3>
                <ul class="footer-links">
                    <li><a href="<?php echo $base_url_website_campus; ?>mandatory_disclosure.php"><i class="fa fa-file-text"></i> Mandatory Disclosure</a></li>
                    <li><a href="https://nad.gov.in/"><i class="fa fa-database"></i> National NAD</a></li>
                    <li><a href="https://nad.digilocker.gov.in/"><i class="fa fa-database"></i> DigiLocker NAD</a></li>
                    <li><a href="<?php echo $base_url_website_campus; ?>grievances.php"><i class="fa fa-users"></i> Grievances Committee</a></li>
                    <li><a href="<?php echo $base_url_website; ?>public_self_disclosure.php"><i class="fa fa-file-text"></i> Public Self Disclosure</a></li>
                    <li><a href="https://samadhaan.ugc.ac.in/"><i class="fa fa-commenting"></i> e-Samadhaan (UGC)</a></li>
                    <li><a href="https://gmiu.edu.in/gmiu/website_assets/Institutional-Development-Plan.pdf"><i class="fa fa-file-pdf-o"></i> Development Plan</a></li>
                </ul>
            </div>
        </div>

        <!-- Horizontal Newsletter Section -->
        <div class="footer-newsletter-bar">
            <div class="newsletter-horizontal">
                <h3>Subscribe Now</h3>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="newsletter-form-wrap">
                    <input name="email" placeholder="Enter your email" type="email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </div>

    <!-- PHP Subscription Logic -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
        include $base_url . 'database/connect.php';
        try {
            $email = trim($_POST['email']);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $stmt = $con->prepare('INSERT INTO tbl_subscribers (email) VALUES (?)');
                if ($stmt) {
                    $stmt->bind_param('s', $email);
                    if ($stmt->execute()) {
                        $msg = 'Subscription successful!';
                        $type = 'success';
                    } else {
                        throw new Exception('Already subscribed.');
                    }
                    $stmt->close();
                }
            } else {
                throw new Exception('Invalid email.');
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $type = 'error';
        }
        $con->close();
        if (isset($msg)) {
            echo "<script>window.onload = function() { 
                var t = document.createElement('div'); 
                t.className = 'toast " . ($type == 'success' ? 'success' : '') . "'; 
                t.innerText = '$msg'; 
                document.body.appendChild(t);
                setTimeout(function(){ t.style.opacity = '0'; setTimeout(function(){ t.remove(); }, 500); }, 3000);
            }</script>";
        }
    }
    ?>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p class="copyright-text">
                    &copy; <?php echo date('Y'); ?> Gyanmanjari Innovative University. All Rights Reserved.
                    <br>
                    Developed by <a href="<?php echo $base_url_website_common; ?>it_cell_team.php" class="it-cell-highlight">IT-CELL GMIU</a>
                </p>
                <div class="social-links-wrap">
                    <a href="https://www.facebook.com/GyanmanjariColleges" class="social-box" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/GMGC_Bhavnagar" class="social-box" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/gyanmanjari_innovative_u" class="social-box" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://whatsapp.com/channel/0029VaAlQDCJP217g55N1h2B" class="social-box" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.youtube.com/channel/UCzsun63TTJoLySLIWWaA8AQ" class="social-box" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>