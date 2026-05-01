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
    <style>
    .contact-area {
        background-color: white;
    }

    .contact-area .contact-info h2 {
        font-size: 30px;
        text-align: left;
        padding-bottom: 10px;
    }

    h2 {
        margin: 0;
        text-align: center;
        color: #333;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 35px;
        position: relative;
    }

    .contact-area .contact-info .content-sub_p {
        font-size: 15px;
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }

    p {
        font-family: Montserrat, sans-serif;
        font-size: 13px;
        color: #727272;
        line-height: 22px;
        text-align: justify;
    }

    .contact-area .contact-info .content-sub_p:before {
        transition: all .3s ease-in-out;
        position: absolute;
        height: 2px;
        width: 50px;
        content: "";
        background: linear-gradient(130deg, #ba2a21 0%, #ba2a21 100%);
        bottom: 0;
        left: 0;
    }

    .contact-area .contact-info .contact-box .single-address-box {
        padding: 30px 0;
        border-top: 1px solid #ba2a21;
    }

    /* .contact-area .contact-info .contact-box .single-address-box .single-address.d-flex {
            display: flex;
        } */


    .contact-area .contact-info .contact-box .single-address-box .single-address i {
        float: left;
        font-size: 25px;
        height: 40px;
        line-height: 30px;
        width: 30px;
        color: #ba2a21;
        margin-right: 15px;
    }

    .contact-area .contact-info .contact-box .single-address-box .single-address {
        display: flex;
    }

    .contact-area .contact-info .contact-box .single-address-box .single-address h4 {
        margin: 0;
        padding-bottom: 5px;
    }

    a {
        color: unset;
        display: inline-block;
        transition: all .3s;
        text-decoration: none !important;
    }

    .contact-area .contact-info .contact-box .single-address-box .single-address .getDirections {
        padding: 10px;
        background: #ba2a21;
        color: #fff;
        font-weight: 500;
        text-transform: uppercase;
        margin-top: 20px;
    }

    .contact-area .contact-info .contact-box .single-address-box ul {
        margin: 0;
    }

    .list-unstyled {
        padding-left: 0;
        list-style: none;
    }

    .contact-area .contact-info .contact-box .single-address-box ul li {
        margin: 0 5px;
        display: inline-block;
    }

    .contact-area .contact-info .contact-box .single-address-box ul li i {
        background: #f9f9f9;
        border: 1px solid #ba2a21;
        border-radius: 100%;
        color: #ba2a21;
        height: 40px;
        padding: 10px;
        width: 40px;
        font-size: 18px;
        text-align: center;
        transition: all .3s ease-in-out;
    }

    .fa {
        display: inline-block;
        font: 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .contact-area .contact-form .contact-title-btm h2 {
        font-size: 30px;
        text-align: left;
        padding-bottom: 10px;
    }

    .contact-area .contact-form .contact-title-btm .content-sub_p {
        font-size: 15px;
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
        text-align: left;
    }

    .contact-area .contact-form .contact-title-btm .content-sub_p:before {
        position: absolute;
        height: 2px;
        width: 50px;
        content: "";
        background: linear-gradient(130deg, #ba2a21 0%, #ba2a21 100%);
        bottom: 0;
        left: 0;
        transition: all .3s ease-in-out;
    }

    @media (min-width: 768px) {
        .col-sm-6 {
            width: 50%;
        }
    }

    .form-group {
        margin-bottom: 15px;
    }

    .contact-area .contact-form .input-contact-form form input,
    .contact-area .contact-form .input-contact-form form textarea {
        background-color: transparent;
        border-radius: 0;
        box-shadow: none;
        font-size: 15px;
        margin: 10px 0;
        padding: 10px 20px;
        outline: none;
        resize: none;
        border-color: #ba2a21;
    }

    .contact-area .contact-form .input-contact-form form input {
        height: 40px;
        border-color: #ba2a21;
    }

    .contact-area .contact-form .input-contact-form {
        margin-top: 40px;
    }

    form {
        display: block;
        margin-top: 0em;
    }

    .contact-area .contact-form .input-contact-form form input[type=submit] {
        background: #ba2a21;
        border-radius: 0;
        color: #fff;
        border: none;
        font-size: 15px;
        font-weight: 500;
        margin-top: 20px;
        height: 40px;
        text-transform: uppercase;
        transition: all .3s ease-in-out;
    }
    </style>
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
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
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a><i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Contact Us </a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
            <!-- <div class="row two-colum-section"> -->
            <!-- left bar start  -->
            <!-- <div class="col-sm-8 sidebar-left"> -->
            <section class="contact-area">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-5 contact-info">
                            <div class="col-sm-12 contact-title" style="margin-bottom: 50px;">
                                <h2>Contact Info</h2>
                                <p class="content-sub_p"> Welcome to our Website. We are glad to have you around. </p>
                            </div>
                            <div class="col-sm-12 contact-box">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 single-address-box">
                                        <div class="single-address d-flex"><i class="fa fa-phone"></i>
                                            <div>
                                                <h4>Phone</h4><a href="tel:919099951160">+91 90999 51160</a><br><a
                                                    href="tel:917574949494">+91 75749 49494</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 single-address-box">
                                        <div class="single-address"><i class="fa fa-envelope"></i>
                                            <div class="">
                                                <h4>Email</h4>
                                                <a href="mailto:info@gmiu.edu.in">info@gmiu.edu.in</a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 single-address-box">
                                        <div class="single-address d-flex"><i class="fa fa-map-marker"></i>
                                            <div>
                                                <h4>Location:</h4><a href="https://goo.gl/maps/Rew9anmSejXpQ2ucA"
                                                    target="_blank"> Survey No. 30, Sidsar Road,
                                                    Bhavnagar Gujarat(India), 364060</a><a
                                                    href="https://goo.gl/maps/Rew9anmSejXpQ2ucA" target="_blank"
                                                    class="getDirections"> get direction </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 single-address-box">
                                        <ul class="list-unstyled">
                                            <li><a href="https://www.facebook.com/GyanmanjariColleges"><i
                                                        class="fa-brands fa-facebook"></i></a></li>
                                            <li><a href="https://x.com/GMGC_Bhavnagar"><i
                                                        class="fa-brands fa-twitter"></i></a></li>

                                            <li><a href="https://www.linkedin.com/company/gyanmanjari/"><i
                                                        class="fa-brands fa-linkedin"></i></a></li>
                                            <li><a href="https://www.instagram.com/gyanmanjari_innovative_u?igsh=b2hodnd6YmNld3lj"><i
                                                        class="fa-brands fa-instagram"></i></a></li>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sm-offset-1 contact-form">
                            <div class="row">
                                <div class="col-sm-12 contact-title-btm">
                                    <h2>Send A Message</h2>
                                    <p class="content-sub_p"> Welcome to our Website. We are glad to have you around.
                                    </p>
                                </div>
                            </div>
                            <div class="input-contact-form">
                                <div id="contact">
                                    <div id="message"></div>
                                    <form id="" class="" method="POST">
                                        <div class="row">
                                            <input type="text" name="honeypot" style="display:none;">

                                            <div class="col-sm-6">
                                                <div class="form-group"><input type="text" placeholder="Name"
                                                        name="name" formcontrolname="name" id="name"
                                                        class="form-control" required></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group"><input type="email" placeholder="Email"
                                                        name="email" formcontrolname="email" id="email"
                                                        class="form-control" required></div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group"><input type="text" placeholder="Subject"
                                                        name="subject" formcontrolname="subject" id="subject"
                                                        class="form-control" required></div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group"><textarea rows="6" placeholder="Message"
                                                        name="message" formcontrolname="message" id="comments"
                                                        class="form-control" required></textarea></div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="full-width">
                                                    <input type="submit" name="submit" value="submit" id="submit">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- </div> -->
            <!-- left bar end  -->

            <!-- right bar start  -->
            <!-- <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <div>
                                    <ul>
                                        <li>ABOUT</li>
                                        <li><a href="about_university.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> About University</a></li>
                                        <li><a href="about_gyanmudra_education_foundation.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> About Gyanmudra Education
                                                Foundation</a></li>
                                        <li><a href="about_leadership.php" class="active"><i
                                                    class="fa-solid fa-arrow-right"></i> Leadership</a></li>
                                        <li><a href="about_chairman_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Chairman Message</a></li>
                                        <li><a href="about_provost_message.php" class=""><i
                                                    class="fa-solid fa-arrow-right"></i> Provost Message</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <!-- right bar end  -->
        </div>
    </div>
    </div>





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