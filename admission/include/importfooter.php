<!-- Footer Area section -->
<style>
    .toast {
        position: fixed;
        top: 10px;
        left: 80%;
        transform: translateX(-50%);
        background-color: #f44336;
        /* Red for error */
        color: white;
        padding: 16px;
        font-size: 16px;
        border-radius: 4px;
        opacity: 1;
        transition: opacity 0.5s ease;
        z-index: 9999;
    }
    .toast.success {
        background-color: #4CAF50;
        /* Green for success */
    }
</style>
<footer>
    <div class="container">
        <div class="row">
            <div class=" col-sm-12 footer-content-box">
                <div class="col-sm-3">
                    <h3><span>WHO WE ARE ?</span></h3>
                    <p>The Gyanmanjari Innovative University has been found with sole purpose to create world class
                        engineers for converting global challenges into opportunities through “Value Embedded
                        Quality Technical Education”</p>
                    <ul class="list-unstyled">
                        <li><span><i class="fa fa-phone footer-icon"></i></span><a href="tel:+91 90999 51160">+91
                                90999 51160</a></li>
                        <li><span><i class="fa fa-phone footer-icon"></i></span><a href="tel:+91 75749 49494">+91
                                75749 49494</a></li>
                        <li><span><i class="fa fa-envelope footer-icon"></i></span><a
                                href="mailto:info@gmiu.edu.in">info@gmiu.edu.in</a></li>
                        <li><span><i class="fa fa-map-marker footer-icon"></i></span><a
                                href="https://www.google.com/maps/place/Gyanmanjari+Group+of+Colleges/@21.718607,72.121905,15z/data=!4m6!3m5!1s0x395f574ba735c539:0x387d9b85bd2cd04e!8m2!3d21.7186066!4d72.1219048!16s%2Fg%2F11b7snn6_4?hl=en-GB">
                                Survey No. 30, Sidsar Road,
                                Bhavnagar Gujarat(India)</a></li>
                    </ul>
                </div>

                <div class="col-sm-3">
                    <h3>FOR STUDENTS / PARENTS</h3>
                    <ul class="list-unstyled">
                        <!--  <li><a href="https://www.payumoney.com/webfronts/#/index/gmiu"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Pay
                                Fees</a></li>
                        <li><a href="https://play.google.com/store/apps/details?id=com.jsd.knowmybranch"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Know Your
                                Branch</a></li> -->
                        <li><a href="https://gmiu.edu.in/gmiu/website/admission/scholarships.php"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Scholarship</a></li>
                        <!--<li><a href="https://gmgc.edu.in/mmchs.html"><span><i-->
                        <!--                class="fa fa-long-arrow-right footer-icon"></i></span>Mastermind</a></li>-->
                        <li><a href="https://gujacpc.admissions.nic.in/"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>ACPC Website</a></li>
                        <li><a href="https://gujdiploma.admissions.nic.in/"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>ACPDC Website</a></li>
                        <li><a href="http://gtu.ac.in/"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>GTU Website</a></li>
                        <li><a href="https://student.gtu.ac.in/Login.aspx"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>GTU Student Login</a></li>
                        <li><a href="https://www.100points.gtu.ac.in/"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>100 Activity Point
                                Login</a></li>
                        <li><a href="https://pmms.gtu.ac.in/GTULoginPage"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>PMMS Portal</a></li>
                        <li><a href="https://www.iep.gtu.ac.in/"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>IEP</a></li>
                        <li><a href="https://nptel.ac.in/"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>NPTEL</a></li>
                        <li>
    <a href="https://gmiu.edu.in/gmiu/website/campus/FAQ.php">
        <span><i class="fa fa-long-arrow-right footer-icon"></i></span>FAQ
    </a>
</li>

                    </ul>
                </div>

                <div class="col-sm-3">
                    <h3>OTHER INFORMATION</h3>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $base_url_website_campus;?>career.php"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Career</a>
                        </li>
                         <li><a href="<?php echo $base_url_website_campus;?>committee.php"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Committees</a>
                        </li>
                        <li><a href="<?php echo $base_url_website_campus;?>whpcell.php"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Women Harassment
                                Prevention Cell</a>
                        <li><a href="<?php echo $base_url_website_campus ?>ugc_perfoma.php"><span><i class="fa fa-long-arrow-right footer-icon"></i></span>UGC Perfoma</a>
                        </li>
                        <li><a href="<?php echo $base_url_website_campus;?>srcell.php"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Social Responsive Cell</a>s
                        </li>
                        <li><a href="<?php echo $base_url_website_campus;?>anti-ragging.php"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Anti-Ragging Committee</a>
                        </li>
                        <li><a href="<?php echo $base_url_website_campus;?>innovation_cell.php"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Innovation Cell</a>
                        </li>
                        <li><a href="https://mentorship.gmiu.edu.in/"><span><i class="fa fa-long-arrow-right footer-icon"></i></span>Mentoring</a>
                        </li>
                        <li><a href="<?php echo $base_url_website_campus;?>mandatory_disclosure.php"><span><i class="fa fa-long-arrow-right footer-icon"></i></span>Mandatory Disclosure</a>
                        </li>
                        <li><a href="https://nad.gov.in/"><span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>National Academic
                                Depository</a></li>
                        <li><a href="https://nad.digilocker.gov.in/"><span><i class="fa fa-long-arrow-right footer-icon"></i></span>DigiLocker NAD</a></li>
                        <li><a href="<?php echo $base_url_website_campus;?>grievances.php"> <span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Grievances Committee</a>
                        </li>
                          <li><a href="<?php echo $base_url_website;?>public_self_disclosure.php"> <span><i
                                        class="fa fa-long-arrow-right footer-icon"></i></span>Self Disclosure</a>
                        </li> 
                        <li><a href="https://samadhaan.ugc.ac.in/"> <span>
                            <i class="fa fa-long-arrow-right footer-icon"></i></span>e-Samadhaan</a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-3">
                    <h3>GET IN TOUCH</h3>
                    <p>Enter your email and we'll send you more information.</p>

                     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <input  name="email" placeholder="Your Email" type="email" required="">
                            <div class="submit-btn">
                                <button type="submit" class="text-center">Subscribe</button>
                            </div>
                        </div>
                    </form>
                    
                       <?php
                   if (isset($_POST['subscribe'])) {
                        // Initialize error message variable
                        $error_message = "";
                        $success_message = "";

                        // Set the flag to check for toast message
                        $show_error_toast = false;
                         include $base_url . 'database/connect.php';

                        try {
                           
                            // Get the email from the form input
                            $email = isset($_POST['email']) ? trim($_POST['email']) : '';

                            // Basic validation for the email (check if not empty and a valid format)
                            if (empty($email)) {
                                $error_message = "Email is required.";
                                $show_error_toast = true;
                            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $error_message = "Invalid email format.";
                                $show_error_toast = true;
                            } else {
                                // Prepare the SQL query to insert the email into the subscribers table
                                $stmt = $con->prepare("INSERT INTO tbl_subscribers (email) VALUES (?)");

                                if ($stmt) {
                                    $stmt->bind_param('s', $email); // 's' means the parameter is a string

                                    // Execute the statement
                                    if ($stmt->execute()) {
                                        $success_message = "Subscription successful.";
                                    } else {
                                        throw new Exception("Error inserting data: " . $stmt->error);
                                    }

                                    // Close the statement
                                    $stmt->close();
                                } else {
                                    throw new Exception("Error preparing the statement: " . $con->error);
                                }
                            }
                        } catch (mysqli_sql_exception $e) {
                            // Handle duplicate entry or any other MySQL errors
                            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                                $error_message = "This email is already subscribed.";
                                $show_error_toast = true;
                            } else {
                                $error_message = "An error occurred. Please try again.";
                                $show_error_toast = true;
                            }
                        } catch (Exception $e) {
                            $error_message = $e->getMessage();
                            $show_error_toast = true;
                        } finally {
                            // Close the database connection
                            $con->close();
                        }
                  
                    ?>
                    <?php if ($show_error_toast) : ?>
                        <script type="text/javascript">
                            window.onload = function() {
                                var toastMessage = "<?php echo $error_message; ?>";
                                var toast = document.createElement('div');
                                toast.classList.add('toast');
                                toast.innerText = toastMessage;
                                document.body.appendChild(toast);

                                setTimeout(function() {
                                    toast.style.opacity = 0;
                                }, 3000); // Hide toast after 3 seconds

                                setTimeout(function() {
                                    toast.remove();
                                }, 3500); // Remove the toast from DOM after fade out
                            }
                        </script>
                    <?php endif; ?>

                    <?php if (!empty($success_message)) : ?>
                        <script type="text/javascript">
                            window.onload = function() {
                                var toastMessage = "<?php echo $success_message; ?>";
                                var toast = document.createElement('div');
                                toast.classList.add('toast', 'success');
                                toast.innerText = toastMessage;
                                document.body.appendChild(toast);

                                setTimeout(function() {
                                    toast.style.opacity = 0;
                                }, 3000); // Hide toast after 3 seconds

                                setTimeout(function() {
                                    toast.remove();
                                }, 3500); // Remove the toast from DOM after fade out
                            }
                        </script>
                    <?php endif; } ?>

                </div>
            </div>
        </div>
    </div>


    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <div class="row">
                    <div class="col-md-6 col-sm-12 footer-no-padding">
                        <p>&copy; Gyanmanjari Innovative University © All Right Reserved.
                            <br>
                            Designed & Developed by
                            <a _ngcontent-caj-c32="" href="<?php echo $base_url_website_common;?>it_cell_team.php"
                                target="_blank" style="font-weight: bold; color:#ba2a21;">IT-CELL GMIU</a>
                        </p>
                    </div>
                    <div class="col-md-6 col-sm-12 footer-no-padding">
                        <ul class="list-unstyled footer-menu text-right">
                            <li>Follow us:</li>
                            <li><a href="https://www.facebook.com/GyanmanjariColleges" target="_blank"><i
                                        class="fa fa-facebook-f"></i></a></li>
                            <li><a href="https://x.com/GMGC_Bhavnagar" target="_blank"><i
                                        class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.instagram.com/gyanmanjari_innovative_u?igsh=b2hodnd6YmNld3lj" target="_blank"><i
                                        class="fa fa-instagram"></i></a></li>
                            <li><a href="https://whatsapp.com/channel/0029VaAlQDCJP217g55N1h2B"
                                    target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                            <li><a href="https://www.youtube.com/channel/UCzsun63TTJoLySLIWWaA8AQ" target="_blank"><i
                                        class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- ./ End footer-bottom -->
</footer><!-- ./ End Footer Area -->