<?php
include '../database/connect.php';
include '../common/validation.php';
include '../common/globalvariable.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
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

        .red-background {
            background-color: #ba2a21;
            color: white;
        }

        /* Add CSS for the table */
        table {
            border-collapse: collapse;
            /* Collapse border spacing */
            width: 100%;
            /* Make table width 100% */
            border-radius: 10px;
            /* Apply border radius of 10% */
            padding: 10px;
        }

        /* Style table headers */
        th {
            /* background-color: #ba2a21; */
            /* Apply background color to header cells */
            color: white;
            font-size: 17px;
            /* Set text color for header cells */

        }

        /* Style table cells */
        td,
        th {
            border: 1px solid #000;
            /* Remove borders from table cells */
            padding: 8px;
            /* Add padding to table cells */
            text-align: left;
            /* Align text to left in table cells */
            height: 25px;
            width: auto;

        }
        table td, table th {
    vertical-align: top;
}

        .row {
            margin-right: 10px;
            margin-left: -15px;
        }

        a {
            color: #1a1a1a;
        }
        .tbl-container {
            overflow-x: auto;
        }
    </style>
    <!--   -->
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include 'include/importheader.php'; ?>



    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Public Self Disclosure</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Public Self Disclosure</a></span>
                </p>
            </div>
        </div>
    </section>

    <div _ngcontent-kps-c41="" class="container tbl-container">
        <section _ngcontent-kps-c41="" style="margin-bottom: 20px;">
       
            <hr _ngcontent-kps-c41="">
            <div class="row" class="card">
                <table>
                    <thead class="red-background">
                        <tr>
                            <th style="border-radius: 0px 0px 0px 0px;">Sr. No</th>
                            <th style="border-radius: 0px 0px 0px 0px;">Title</th>
                            <th style="border-radius: 0px 0px 0px 0px;">Subtitle</th>
                            <th style="border-radius: 0px 0px 0px 0px;">Links on Website</th>
                        </tr>
                    </thead>
                    <tbody>
                <tr>
                    <td rowspan="9">1</td>
                    <td rowspan="9" style="background-color:#ff383857;font-size: 15px;font-weight: 600;">About HEI</td>
                    <td style="background-color:#ff383857">About Us-Overview:</td>
                    <td style="background-color:#ff383857"><a href="https://gmiu.edu.in/gmiu/website/about/about_university.php">https://gmiu.edu.in/gmiu/website/about/about_university.php</a></td>
                </tr>
                <tr>
                    <td>Act and Statutes or MOA</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/Act_and_Statutes.pdf"><?php echo $website_assets_url; ?>public-disclosure/Act_and_Statutes.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Institutional Development Plan</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/1-institutional-development-plan.pdf"><?php echo $website_assets_url; ?>public-disclosure/1-institutional-development-plan.pdf</a></td>
                </tr>
                <tr>
                    <td>Constituent Units/ Affiliated Colleges, Affiliating University (In case of Colleges) Off-Campus/Off-Shore Campus/Learning Support Centers Under ODL Mode (Wherever Applicable)</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology">https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Accreditation/ Ranking Status (NAAC, NBA, NIRF)</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/NIRF Report GMIU Engineering.pdf">NIRF</a></td>
                </tr>
                <tr>
                    <td>Recognition/Approval (2(f), 12B, etc. as applicable)</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/2-section-2f-and-22.pdf"><?php echo $website_assets_url; ?>public-disclosure/2-section-2f-and-22.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Annual Reports</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/AnnualReport.pdf"><?php echo $website_assets_url; ?>public-disclosure/AnnualReport.pdf</a></td>
                </tr>
                <tr>
                    <td>Annual Accounts Including Balance Sheet, Income and Expenditure Account, Receipts and Payments Account Along with Audit Report</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/3-audit-report.pdf"><?php echo $website_assets_url; ?>public-disclosure/3-audit-report.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Sponsoring Body Details, if any</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/4-sponsoring-body.pdf"><?php echo $website_assets_url; ?>public-disclosure/4-sponsoring-body.pdf</a></td>
                </tr>
                <tr>
                    <td rowspan="36">2</td>
                    <td rowspan="36" style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Administration (Profiles with Photographs and Contact Details)</td>
                    <td rowspan="4">Chancellor</td>
                    <td>Name: Mr. Avinashbhai B. Patel</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Email: president@gmiu.edu.in</td>
                </tr>
                <tr>
                    <td>Mobile: 9099951160</td>
                </tr>
                <tr>
                    <!--<td style="background-color:#ff383857">Profile: NA</td>-->
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/Mr.Avinashsir.pdf">Profile: Avinashsir profile </a></td>
                    
                </tr>
                <!--<tr>-->
                <!--    <td rowspan="4" style="background-color:#ff383857">Pro Chancellor</td>-->
                <!--    <td>Name: NA</td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td style="background-color:#ff383857">Email: NA</td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td>Mobile: NA</td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td style="background-color:#ff383857">Profile: NA</td>-->
                <!--</tr>-->
                <tr>
                    <td rowspan="4"  style="background-color:#ff383857">Vice-Chancellor</td>
                    <td>Name: Dr. H.M. Nimbark</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Email: provost@gmiu.edu.in</td>
                </tr>
                <tr>
                    <td>Mobile: 9662207005</td>
                </tr>
                <tr>
                    <!--<td style="background-color:#ff383857">Profile: NA</td>-->
                     <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/Nimbarksirprofile.pdf">Profile: Nimbarksir profile </a></td>
                </tr>
                <!--<tr>-->
                <!--    <td rowspan="4" style="background-color:#ff383857">Pro Vice-Chancellor</td>-->
                <!--    <td>Name: NA</td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td style="background-color:#ff383857">Email: NA</td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td>Mobile: NA</td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td style="background-color:#ff383857">Profile: NA</td>-->
                <!--</tr>-->
                <tr>
                    <td rowspan="4">Registrar</td>
                    <td>Name: Dr. Nikunj N. Dave</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Email: registrar@gmiu.edu.in</td>
                </tr>
                <tr>
                    <td>Mobile: 7984614184</td>
                </tr>
                <tr>
                    <!--<td style="background-color:#ff383857">Profile: NA</td>-->
                     <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/Dr-Nikunj-Dave.pdf">Profile: Nikunj Dave profile </a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Principal (wherever applicable)</td>
                    <td style="background-color:#ff383857"></td>
                </tr>
                <tr>
                    <td rowspan="4">Finance Officer</td>
                    <td>Name: CA Dinesh A Mangatramani</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Email: accounts@gmiu.edu.in</td>
                </tr>
                <tr>
                    <td>Mobile: 9824980364</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Profile: NA</td>
                </tr>
                <tr>
                    <td rowspan="4" style="background-color:#ff383857">Controller Of Examination</td>
                    <td>Name: Dr Vinodrai Ujjeniya</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Email: exam@gmiu.edu.in</td>
                </tr>
                <tr>
                    <td>Mobile: 9426461304</td>
                </tr>
                <tr>
                    <!--<td style="background-color:#ff383857">Profile: NA</td>-->
                      <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/VinodraiUjjeniya.pdf">Profile: Vinodsir profile </a></td>
                </tr>
                <tr>
                    <td rowspan="4">Chief Vigilance Officer</td>
                    <td>Name: Mr. Sandeepsinh Vala</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Email: sjvala@gmiu.edu.in</td>
                </tr>
                <tr>
                    <td>Mobile: 8200551742</td>
                </tr>
                <tr>
                    <!--<td style="background-color:#ff383857">Profile: NA</td>-->
                     <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/Valasirprofile.pdf">Profile: Sandipsir profile </a></td>
                </tr>
                <tr>
                    <td rowspan="4" style="background-color:#ff383857">Ombudsperson  </td>
                    <td>Name: Dr. K.R. Zanzrukiya</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Email: drzanzrukiya@gmiu.edu.in</td>
                </tr>
                <tr>
                    <td>Mobile: 9909970295</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Profile: NA</td>
                </tr>
                <tr>
                    <td>Executive Council/Board of Governors by whatever name called</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/BOG.pdf"><?php echo $website_assets_url; ?>public-disclosure/BOG.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Board of Management</td>
                    <td style="background-color:#ff383857">
                        <a href="<?php echo $website_assets_url; ?>public-disclosure/Board_of_Management_Formation.pdf">
                        <?php echo $website_assets_url; ?>public-disclosure/Board_of_Management_Formation.pdf</a></td>
                </tr>
                <tr>
                    <td>Academic Council </td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/Academic_Council_Formation.pdf"><?php echo $website_assets_url; ?>public-disclosure/Academic_Council_Formation.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Board of Studies </td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/Board_of_Studies_Formation.pdf"><?php echo $website_assets_url; ?>public-disclosure/Board_of_Studies_Formation.pdf</a></td>
                </tr>
                <tr>
                    <td>Finance Committee — Composition and Members with Particulars</td>
                 <td><a href="<?php echo $website_assets_url; ?>public-disclosure/financecommittee_0001.pdf"><?php echo $website_assets_url; ?>public-disclosure/financecommittee_0001.pdf</a></td>
                </tr>
                 <tr>
                    <td style="background-color:#ff383857">Internal Complaint Committee</td>
                 <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/Internal-Complaints-Committee.pdf"><?php echo $website_assets_url; ?>public-disclosure/Internal-Complaints-Committee.pdf</a></td>
                </tr>
                
                <!--<tr>-->
                <!--    <td style="background-color:#ff383857">Internal Complaint Committee</td>-->
                <!--    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/ICWEC.pdf"><?php echo $website_assets_url; ?>public-disclosure/ICWEC.pdf</a></td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td style="background-color:#ff383857">Internal Complaint Committee</td>-->
                <!--    <td style="background-color:#ff383857"><a href="<?php //echo $website_assets_url; ?>public-disclosure/9-internal-compliant-and-women-empowerment-committee.pdf"><?php // echo $website_assets_url; ?>public-disclosure/9-internal-compliant-and-women-empowerment-committee.pdf</a></td>-->
                <!--</tr>-->
                <tr>
                    <td>Academic Leadership (Dean/Hod of Schools/Departments/Centers)</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/Academic-Leadership.pdf">
                        <?php echo $website_assets_url; ?>public-disclosure/Academic-Leadership.pdf</a></td>
                </tr>
                <tr>
                    <td rowspan="14">3</td>
                    <td rowspan="14" style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Academics</td>
                    <td rowspan="6" style="background-color:#ff383857;">Details of Academic Programs</td>
                    <td style="background-color:#ff383857;"><a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology">https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology</a></td>
                </tr>
                <tr>
                    <td><a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology">Undergraduate: https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857;"><a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-science">Postgraduate: https://gmiu.edu.in/gmiu/website/faculty/faculty-of-science</a></td>
                </tr>
                <tr>
                    <td><a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology">Postgraduate Diploma: https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857;"><a href="https://gmiu.edu.in/gmiu/website/faculty/ph-d-min-3-years-">Doctoral:               https://gmiu.edu.in/gmiu/website/faculty/ph-d-min-3-years-</a> </td>
                </tr>
                <tr>
                    <td>Any other:</td>
                </tr>
                <tr>
                    <td>Academic Calendar</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/10-academic-calendar-2024-25.pdf"><?php echo $website_assets_url; ?>public-disclosure/10-academic-calendar-2024-25.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Statutes/Ordinances Pertaining to Academics/Examinations</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/11-statutes2023-final-9.pdf"><?php echo $website_assets_url; ?>public-disclosure/11-statutes2023-final-9.pdf</a></td>
                </tr>
                <tr>
                    <td>Schools /Departments/ Centres</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-science">https://gmiu.edu.in/gmiu/website/faculty/faculty-of-science</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Department/ School/ Centre Wise Faculty/Staff Details with Photographs</td>
                    <td style="background-color:#ff383857">
                        <a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology/diploma-computer-engineering/program-faculty">https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology/diploma-computer-engineering/program-faculty</a><hr>
                    <a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-science/under-graduation-b-sc-microbiology/program-faculty">https://gmiu.edu.in/gmiu/website/faculty/faculty-of-science/under-graduation-b-sc-microbiology/program-faculty</a><hr>
                    <a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-pharmacy/under-graduation-bachelor-of-pharmacy/program-faculty">https://gmiu.edu.in/gmiu/website/faculty/faculty-of-pharmacy/under-graduation-bachelor-of-pharmacy/program-faculty</a><hr>
                    <a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology/under-graduation-mechanical-engineering/program-faculty">https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology/under-graduation-mechanical-engineering/program-faculty</a>
                    
                    </td>
                </tr>
                <tr>
                    <td>List of UGC-Recognized ODL/Online Programs, if any</td>
                    <td>NA</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Internal Quality Assurance Cell (IQAC)</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/IQAC.pdf"><?php echo $website_assets_url; ?>public-disclosure/IQAC.pdf</a></td>
                </tr>
                <tr>
                    <td>Library</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/campus/library.php">https://gmiu.edu.in/gmiu/website/campus/library.php</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Academic Collaborations</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/AcademicCollaboration(MoU-with-List).pdf">
                        <?php echo $website_assets_url;?>public-disclosure/AcademicCollaboration(MoU-with-List).pdf</a></td>
                </tr>
                <tr>
                    <td rowspan="3">4</td>
                    <td rowspan="3" style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Admissions & fee</td>
                    <td>Prospectus (including fee structure for various programs)</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology">https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Admission Process and Guidelines</td>
                    <td style="background-color:#ff383857"><a href="https://gmiu.edu.in/gmiu/admission/">https://gmiu.edu.in/gmiu/admission/</a></td>
                </tr>
                <tr>
                    <td>Fee Refund Policy</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website_admin/uploads/mandatory_disclosure/Feerefund.pdf">https://gmiu.edu.in/gmiu/website_admin/uploads/mandatory_disclosure/Feerefund.pdf</a></td>
                </tr>
                <tr>
                    <td rowspan="3">5</td>
                    <td rowspan="3" style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Research</td>
                    <td style="background-color:#ff383857">Research And Development Cell
                        (Including Research and Consultancy 
                        Projects, Foreign Collaboration Industry Collaborations)</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/ReseachAdvisoryCouncil.pdf"><?php echo $website_assets_url; ?>public-disclosure/ReseachAdvisoryCouncil.pdf</a></td>
                </tr>
                <tr>
                    <td>Incubation Centre/Start-Ups/ Entrepreneurship Cell</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/startup/about_startup.php">https://gmiu.edu.in/gmiu/website/startup/about_startup.php</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Central Facilities</td>
                    <td style="background-color:#ff383857">Separate lab facility Available</td>
                </tr>
                <tr>
                    <td rowspan="14">6</td>
                    <td rowspan="14" style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Student Life</td>
                    <td>Sports Facilities</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/campus/sports.php">https://gmiu.edu.in/gmiu/website/campus/sports.php</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">NCC/NSS-Details</td>
                    <td style="background-color:#ff383857"><a href="https://gmiu.edu.in/gmiu/website/campus/about_nss.php">https://gmiu.edu.in/gmiu/website/campus/about_nss.php</a></td>
                </tr>
                <tr>
                    <td>Hostel Details (Wherever Applicable)</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/common/hostel.php">https://gmiu.edu.in/gmiu/website/common/hostel.php</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Placement Cell and Its Activities</td>
                    <td style="background-color:#ff383857"><a href="https://gmiu.edu.in/gmiu/website/placement/training_and_placement_cell.php">https://gmiu.edu.in/gmiu/website/placement/training_and_placement_cell.php</a></td>
                </tr>
                <tr>
                    <td rowspan="4">Details Of Student Grievance
                        Redressal Committee (SGRC) And Ombudsperson</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website_assets/public-disclosure/SGRC.pdf">https://gmiu.edu.in/gmiu/website_assets/public-disclosure/SGRC.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Name: Dr. K.R. Zanzrukiya</td>
                </tr>
                <tr>
                    <td>Email: drzanzrukiya@gmail.com</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Mobile: 9909970295</td>
                </tr>
                <tr>
                    <td>Health Facilities</td>
                    <td>First Aid Facility Available</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Internal Complaint Committee</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/Internal-Complaints-Committee.pdf"><?php echo $website_assets_url; ?>public-disclosure/Internal-Complaints-Committee.pdf</a></td>
                </tr>
                <tr>
                    <td>Anti-Ragging Cell</td>
                    <td>
                        <a href="<?php echo $website_assets_url; ?>public-disclosure/Anti-Ragging-Committee.pdf"><?php echo $website_assets_url; ?>public-disclosure/Anti-Ragging-Committee.pdf</a>
                        <!--<a href="https://gmiu.edu.in/gmiu/website/campus/anti-ragging.php">https://gmiu.edu.in/gmiu/website/campus/anti-ragging.php</a></td>-->
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Equal Opportunity Cell</td>
                    <td style="background-color:#ff383857"><a href="<?php echo $website_assets_url; ?>public-disclosure/Equalopportunitycell.pdf">
                        <?php echo $website_assets_url; ?>public-disclosure/Equalopportunitycell.pdf</a></td>
                </tr>
                <tr>
                    <td>Socio-Economically Disadvantaged Groups Cell (SEDG)</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/Socio-Economically-Disadvanced-Group-Cell.pdf">
                        <?php echo $website_assets_url; ?>public-disclosure/Socio-Economically-Disadvanced-Group-Cell.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Facilities for Differently Abled (e.g., Barrier-Free Environment)</td>
                    <td style="background-color:#ff383857">Available</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Alumni</td>
                    <td>Alumni Association with Details</td>
                      <td><a href="<?php echo $website_assets_url; ?>public-disclosure/AlumniCommittee.pdf"><?php echo $website_assets_url; ?>public-disclosure/AlumniCommittee.pdf</a></td>
                </tr>
                <tr>
                    <td rowspan="9">8</td>
                    <td rowspan="9" style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Information Corner</td>
                    <td style="background-color:#ff383857">RTI: Details of Central Public
                        Information Officer (CPIO) and Appellate Authority (wherever
                        applicable)</td>
                    <td style="background-color:#ff383857">NA</td>
                </tr>
                <tr>
                    <td>Circulars and Notices</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/home/circular.php">https://gmiu.edu.in/gmiu/website/home/circular.php</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Announcements</td>
                    <td style="background-color:#ff383857"><a href="https://gmiu.edu.in/gmiu/website/home/circular.php">https://gmiu.edu.in/gmiu/website/home/circular.php</a></td>
                </tr>
                <tr>
                    <td>Newsletters</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/17-newsletter-2024.pdf">
                        <?php echo $website_assets_url; ?>public-disclosure/17-newsletter-2024.pdf</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">News, Recent Events & Achievements</td>
                    <td style="background-color:#ff383857"><a href="https://gmiu.edu.in/gmiu/website/">https://gmiu.edu.in/gmiu/website/</a></td>
                </tr>
                <tr>
                    <td>Job Openings</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/campus/career.php">https://gmiu.edu.in/gmiu/website/campus/career.php</a></td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Reservation Roster (wherever applicable)</td>
                    <td style="background-color:#ff383857">NA</td>
                </tr>
                <tr>
                    <td>Study in India</td>
                    <td>NA</td>
                </tr>
                <tr>
                    <td style="background-color:#ff383857">Admission procedure and facilities provided to International Students</td>
                    <td style="background-color:#ff383857"><a href="https://gmiu.edu.in/gmiu/admission/">https://gmiu.edu.in/gmiu/admission/</a></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Picture Gallery</td>
                    <td>Picture Gallery</td>
                    <td><a href="https://gmiu.edu.in/gmiu/website/campus/gallery.php">https://gmiu.edu.in/gmiu/website/campus/gallery.php</a></td>
                </tr>
                <tr>
                    <td rowspan="2">10</td>
                    <td rowspan="2" style="background-color:#ff383857;font-size: 15px;font-weight: 600;">Contact Us</td>
                    <td style="background-color:#ff383857">Details with Phone Number, Official Email ID and Address, Location Map</td>
                    <td style="background-color:#ff383857"><a href="https://gmiu.edu.in/gmiu/website/common/website_contact_us.php">https://gmiu.edu.in/gmiu/website/common/website_contact_us.php</a></td>
                </tr>
                <tr>
                    <td>Telephone Directory</td>
                    <td><a href="<?php echo $website_assets_url; ?>public-disclosure/TelephoneDirectory.pdf">
                        <?php echo $website_assets_url; ?>public-disclosure/TelephoneDirectory.pdf</a></td>
                </tr>
            </tbody>

                </table>
            </div>
        </section>
    </div>


    <!-- Footer Area section -->
    <?php include 'include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include 'include/importjs.php'; ?>
</body>

</html>