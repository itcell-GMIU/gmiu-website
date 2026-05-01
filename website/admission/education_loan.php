<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Education Loan Options | Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Explore education loan options at GMIU—get financial support and guidance to fund your academic journey and achieve your educational goals.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <style>
        h3 {
            margin-top: 40px;
        }

        h2 {
            margin-top: 40px;
        }

        p {
            text-align: justify;
        }
    </style>
    <!--   -->
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include '../include/importheader.php'; ?>



    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Education Loan Facility</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/admission/education_loan.php" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Education Loan Facility</a></span>
                </p>
            </div>
        </div>
    </section>

    <div class="flexContainer container">
        <div class="cont">
            <div class="curriculum-text-box">
                <div class="curriculum-section">
                    <section class="des">
                        <h1 class="title gradText">LOAN THROUGH VIDYALAKSHMI YOJNA</h1>

                    </section>
                    <!-- .curriculum-section-text END -->

                    <h3><b>About Scheme</b></h3>

                    <p>
                        The Indian Banks' Association (IBA) had formulated a comprehensive model educational loan scheme for adoption by all Banks aimed at providing financial support from the banking system to deserving/meritorious students for pursuing higher education in India and abroad with initiatives of Government of India, RBI, NSDL and IBA, Common portal has been designed name as www.vidyalakshmi.co.in

                        The Government of India has approved a scheme to provide full interest subsidy during the period of moratorium i.e., Course Period plus one year or six months after getting job, whichever is earlier, on loans taken by students belonging to Economically Weaker Sections from scheduled banks under the Educational Loan scheme of the Indian Banks' Association, for pursuing any of the approved courses of studies in technical and professional streams, from recognized institutions in India. The nomenclature of the Scheme is “Central Scheme to provide Interest Subsidy for the period of moratorium on Educational Loans taken by students from Economically Weaker Sections from scheduled banks under the Educational Loan Scheme of the Indian Banks' Association to pursue Technical/Professional Education studies in India”
                    </p>
                    <h3><b>Eligibility of Scheme</b></h3>
                    <div>
                        <p>
                            The Scheme could be adopted by all scheduled Banks and would be applicable only for studies in recognized Technical/Professional Courses in India. The interest subsidy shall be linked with the existing Educational Loan Scheme of IBA and restricted to students enrolled in recognized Technical/Professional Courses (after Class XII) in India in Educational Institutions established by Acts of Parliament, other Institutions recognized by the concerned Statutory Bodies, Indian Institutes of Management (IIMs)and other Institutions set up by the Central/State Government.
                        </p>

                        <p>
                            For the presses of the same candidate has to register on web portal link <a href="http://www.vidyalakshmi.co.in" target="_blank">www.vidyalakshmi.co.in</a>
                        </p>

                        <div class="curriculum-section">
                            <section class="des">
                                <h3 class="title gradText">LOAN THROUGH BANKS</h3>
                            </section>
                            <!-- .curriculum-section-text END -->
                        </div>
                        <p>
                            Students can avail of the Loan facility from any public sector or private sector bank.
                        </p>

                        <div >
                            <img src="<?php echo $website_assets_url?>images/hdfc.webp" alt="..." class="col-sm-3" >
                            <img src="<?php echo $website_assets_url?>images/sbi.webp" alt="..." class="col-sm-3">
                            <img src="<?php echo $website_assets_url?>images/bob.webp"alt="..." class="col-sm-3">
                            <img src="<?php echo $website_assets_url?>images/icici.webp" alt="..." class="col-sm-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Right Sidebar For Addmission -->
        <div style="width: 350px;" class="sideBar">
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
                        <li><a href="education_loan.php" class="active"><i class="fa-solid fa-arrow-right"></i> Education Loan Facilites</a>
                        </li>
                        <li><a href="scholarships.php" class=""><i class="fa-solid fa-arrow-right"></i> Scholarships</a></li>
                        <li><a href="transportation.php" class=""><i class="fa-solid fa-arrow-right"></i> Transportation Facilities</a></li>
                    </ul>
                </div>
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