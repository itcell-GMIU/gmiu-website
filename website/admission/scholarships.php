<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Scholarships at Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Explore GMIU’s scholarships offering financial support to deserving students, ensuring access to quality education and empowering academic success.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/about.css">
   
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
                    <h1>Scholarships</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Scholarships</a></span>
                </p>

            </div>
        </div>
    </section>
    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">

                        <section class="des">
                            <h1 class="title gradText">Goverment Scholarships</h1>

                        </section>
                        <br>

                        <!-- Motto of University card  -->
                        <div class="about-card">
                            <h4 class="gradText">MYSY<a href="https://mysy.guj.nic.in/" target="_blank"><b>(Mukhyamantri Yuva Swavalamban Yojana)</b><i class="fa fa-external-link" aria-hidden="true"></i></h4></a>
                            <ul>
                                <li>
                                    MYSY scholarship, also popularly known as the Mukhyamantri Yuva Swavalamban Yojana, is an initiative by the state government of Gujarat. They offer financial assistance to the economically weaker students domiciled in the Gujarat state for their higher education.
                                </li>
                                <li><b>Eligibility</b></li>
                                <ul>
                                    <li type="circle">Student must have secured 80 or more Percentile in 10th / 12th exam and family income must be less than Rs. 6 lakh/annum.</li>
                                </ul>
                                <li><b>List of Documents</b></li>
                                <ul>
                                    <li type="circle">Formate Self Declaration Form</li>
                                    <li type="circle">Format of IT Return</li>
                                    <li type="circle">Cast Certificate</li>
                                    <li type="circle">Fees Receipt</li>
                                    <li type="circle">Aadhar Card</li>
                                    <li type="circle">Previous 2 Semester Marksheet</li>
                                    <li type="circle">Income Certificate</li>

                                </ul>
                            </ul>
                        </div>
                        <div class="about-card">
                            <h4 class="gradText">NSP<a href="https://mysy.guj.nic.in/" target="_blank"><b>(National Scholarship Portal)</b><i class="fa fa-external-link" aria-hidden="true"></i></h4></a>
                            <ul>
                                <li><b>Eligibility</b></li>
                                <ul>
                                    <li type="circle">Minority</li>
                                </ul>
                                <li><b>List of Documents</b></li>
                                <ul>
                                    <li type="circle">Cast Certificate</li>
                                    <li type="circle">Fees Receipt</li>
                                    <li type="circle">ID Card</li>
                                    <li type="circle">Previous Semester Marksheet</li>
                                    <li type="circle">Income Certificate</li>
                                    <li type="circle">Bonafide Certificate</li>

                                </ul>
                            </ul>
                        </div>
                        <div class="about-card">
                            <h4 class="gradText"> OTHER
                                <a href="<?php echo $website_assets_url?>pdf/SCHOLARSHIP-BOOKLET.pdf" target="_blank"><b>(SCHOLARSHIP BOOKLET)</b><i class="fa fa-external-link" aria-hidden="true"></i>
                                </a>
                            </h4>
                            
                        </div>
                        <!--<img src="<?php //echo $website_assets_url?>images/scholarship.webp" alt="" style="width: 100%; padding: 10px; margin: bottom 30px; ;"></a>-->
                        
                    </section>
                </div>
            </div>
                <!-- left bar end  -->
                <!-- right bar start  -->
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <div>
                                    <ul>
                                        <li>Admission</li>
                                        <li><a href="<?php echo $base_url_admission; ?>" class=""><i class="fa-solid fa-arrow-right"></i>
                                                Apply Online</a></li>
                                        <li><a href="why_gmiu.php" class=""><i class="fa-solid fa-arrow-right"></i> Why GMIU</a></li>
                                        <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php" class=""><i class="fa-solid fa-arrow-right"></i> Courses Offered</a></li>
                                        <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php"><i class="fa-solid fa-arrow-right"></i> e-Brochure & Scope Documents</a>
                                        </li>
                                        <li><a href="importantlink.php" class=""><i class="fa-solid fa-arrow-right"></i> Important Links</a></li>
                                        <li><a href="education_loan.php" class=""><i class="fa-solid fa-arrow-right"></i> Education Loan Facilites</a>
                                        </li>
                                        <li><a href="scholarships.php" class="active"><i class="fa-solid fa-arrow-right"></i> Scholarships</a></li>
                                        <li><a href="transportation.php" class=""><i class="fa-solid fa-arrow-right"></i> Transportation Facilities</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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