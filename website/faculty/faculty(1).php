<?php
include '../../common/importwebsitefile.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the id
    $faculty_id = intval($_GET['id']);
   
    // Fetch the corresponding slug from the database
    $cmd = $con->prepare("SELECT faculty_slug FROM tbl_faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_slug = $row['faculty_slug'];

        // Redirect to the slug-based URL
        header("Location: /gmiu/website/faculty/" . $faculty_slug, true, 301);
        exit;
    } else {
        // Handle invalid or non-existent ID
        echo "Invalid faculty ID.";
        exit;
    }
} elseif (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
    // Process slug as usual
    $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
    $faculty_slug = validate_data($faculty_slug);

    // Fetch faculty details using the slug
       $cmd = $con->prepare("SELECT faculty.id as faculty_id, faculty.description as faculty_description, faculty.name as faculty_name from tbl_faculty as faculty WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0");
    $cmd->bind_param("s", $faculty_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_id = $row['faculty_id'];
        $faculty_name = $row['faculty_name'];
        $faculty_description = $row['faculty_description'];
        
    }elseif ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
        // Fetch faculty_description from the database where id = 1
        $query = $con->prepare("SELECT description FROM tbl_faculty WHERE id = 1");
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        $faculty_id = '1';
        $faculty_name = 'INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)';
        $faculty_description = $row['description'];
    }else {
        $faculty_id = "";
        $faculty_name = "";
        $faculty_description = "";
    }
}



// if (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
//     $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
//     $faculty_slug = validate_data($faculty_slug);



//     //  fetch faculty details
    // $cmd = $con->prepare("SELECT faculty.id as faculty_id, faculty.description as faculty_description, faculty.name as faculty_name from tbl_faculty as faculty WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0");
//     $cmd->bind_param("s", $faculty_slug);
//     $cmd->execute();
//     $result = $cmd->get_result();
//     if ($result->num_rows != 0) {
//         $row = $result->fetch_assoc();
//         $faculty_id = $row['faculty_id'];
//         $faculty_name = $row['faculty_name'];
//         $faculty_description = $row['faculty_description'];
//     } else {
//         $faculty_id = "";
//         $faculty_name = "";
//         $faculty_description = "";
//     }
// } else {
//     $faculty_id = "";
//     $faculty_name = "";
//     $faculty_description = "";
// }

   
        if ($faculty_id == 2) {
            $meta_description = "Learn about the GMIU faculty member – their academic qualifications, areas of expertise, and commitment to providing students with a high-quality educational experience.";
            
            $meta_keywords = "pharmacy course, pharm d, d pharma, diploma in pharmacy, d pharma course, d pharma fees, pharm d course, d pharmacy admission, d pharma course fees, best d2d pharmacy college in bhavnagar, best d2d pharmacy college in gujarat, best d2d pharmacy college near me, best d2d pharmacy college in my city, top d2d pharmacy college, top d2d pharmacy college in bhavnagar, top d2d pharmacy college in gujarat, top d2d pharmacy college near me, top d2d pharmacy college in my city, bachelor of pharmacy, b pharma, pharmacy course, b pharma fees, b pharmacy admission, pharmacy degree, pharmacy programs, pharmacy courses online, pharmacy degree online, pharmacy university, b pharma course fees, bachelor of pharmacy online, pharmacy bachelor degree, pharmacy degree programs, bachelor of science in pharmacy, pharmacy program online, pharmacy bachelor degree online, master of pharmacy online, online d pharma course, bpharm admission, b pharma online course, online pharmacology programs, master of pharmacology, pharmacy technology course, b pharma university in delhi, pharmacy course in delhi, bachelor's degree in pharmaceutical sciences";
            
            $pageTitle = "Excellence in Pharmaceutical Education | Gyanmanjari University | GMIU";
        }elseif ($faculty_id == 1) {
            $meta_description = "Meet the faculty member at GMIU – explore their academic expertise, research interests, and contributions to enhancing the learning experience for students.";
            
            $meta_keywords = "Engineering courses, Engineering degree, B.Tech course, Engineering university, Online engineering courses, Engineering courses list, Engineering program, Engineering degree near me, B.Tech courses list, Engineering education, University engineering courses, Best engineering colleges, Engineering specializations, Distance learning engineering";
            
             $pageTitle = "Faculty of Engineering & Technology | Gyanmanjari University | GMIU";
        }
        elseif ($faculty_id == 26) { // Assuming faculty_id 3 is for Law
            $meta_description = "Learn more about the esteemed faculty member at GMIU, dedicated to providing high-quality education and mentorship to students for their academic and professional growth.";
            
            $meta_keywords = "law course, university admission, ba llb course, llb admission, ba llb, llb degree, university of law, llb law, law university, bachelor's degree in law, university of law courses, bachelors in law, the law university, university of law application, llb degree online, llb law degree, university of law apply, law studies, law admission, law education, llb admission process, law degree university, educational law degree, llb fees, law course after graduation, university of law llb, careers in law, law degree course, law at university, foundation law degree, law admission process, llb admission fees, law studies degree";
            
             $pageTitle = "BA LLB & Law Courses at Gyanmanjari Innovative University | LLB Admission";
        }
        elseif ($faculty_id == 3) { // Adjust program_id and faculty_id as needed
            $meta_description = "Meet the GMIU faculty member – explore their academic qualifications, teaching expertise, and dedication to enhancing the student learning experience at GMIU.";
        
            $meta_keywords = "science degrees, bsc courses, bsc degree, science courses, bsc admission, science majors, msc courses, bachelor of science courses, science university, science subject, science courses in university, study science, bsc university, bsc subjects, bsc study, faculty of education, university of the sciences degrees, education courses in university, faculty of science, msc courses list, msc university, apply for bsc, online science university, bsc admission process, university of sciences, science online course, bsc science courses, master of science courses list, msc admission process, msc faculty";
            
             $pageTitle = "Faculty of Science | Advanced Learning at Gyanmanjari University | GMIU";
        }
        elseif ($faculty_id == 4) {
            $meta_description = "Discover the profile of GMIU faculty member – learn about their academic background, research interests, and commitment to providing quality education for students.";
            
            $meta_keywords = "bachelor of commerce, commerce courses, master of commerce, bcom courses, bachelor of commerce online, bcom subjects, online bcom, online bcom course, courses for commerce students, after graduation courses in commerce, bcom admission, mcom admission, bcom course details, courses after bcom, bcom university, online courses for commerce students, after 12 commerce courses, bcom colleges near me, bachelor of commerce accounting, b commerce, commerce university, bachelor of commerce subjects, online courses for bcom students, study commerce, study bcom online, bcom general, university for commerce students, courses to do after bcom, commerce graduation courses, bcom courses list, bcom hons colleges, bachelor of commerce courses, bcom course fees, commerce courses list, bcom admission fees, bcomm online, courses for bcom students, colleges for bcom near me, mcom colleges near me, apply for bcom, bcom related courses, mcom course duration, online certificate course for commerce students, commerce all courses list, courses for commerce students after graduation";
            
             $pageTitle = "Faculty of Commerce - Gyanmanjari Innovative University | GMIU";
        }
        elseif ($faculty_id == 5) {
            $meta_description = "Meet the GMIU faculty member – discover their qualifications, expertise, and contributions to creating an enriching academic environment for student growth and success.";
        
            $meta_keywords = "bba course, bba course details, bba course fees, bba subjects, mba courses list, mba course, mba fees, mba university, mba in digital marketing, mba course details, mba in management, school for business management, business colleges, mba study, mba in marketing, mba course fees, mba subjects, mba degree, bba admission, bba online, bba program, mba studies, mba in education, bba fees, mba management courses, mba institute, online mba it management, bba course duration, local mba programs, mba brochure, admission for mba, mba information, mba programmes";
            
             $pageTitle = "Faculty of Management - Gyanmanjari Innovative University | GMIU";
        }
        elseif ($faculty_id == 6) {
         $meta_description = "Meet the faculty member at GMIU – learn about their qualifications, expertise, and dedication to delivering a high-quality academic experience for students.";

    $meta_keywords = "university admission, university study, degree programs, faculty of arts, ba programs, ba university, activities for students, ma in administration, ma university, university for ba, college information, ba subject, university of arts, good universities, ba programme, bachelor of arts courses, ba admission fees, arts university, ba in administration, university study, master in arts, ba study, ba course fees, ba bachelor of arts, ba arts, faculty of arts, ba graduation, ba course subjects, admission ba, ba arts subjects";
    
     $pageTitle = "Faculty of Arts | Gyanmanjari Innovative University | GMIU";
    }elseif ($faculty_id == 8) {
        $meta_description = "Discover the profile of GMIU faculty member – learn about their qualifications, research interests, and commitment to fostering academic growth and student success.";
    
        $meta_keywords = "bca course, bca course fees, mca course, bca admission, online bca course, bca subjects, mca course fees, online bca, mca course duration, online mca, bca fees, mca online course, mca admission, online bca course fees, mca degree, bca degree, bca course information, mca online degree, bca course subjects, mca college, online bca degree, online mca degree, it degree courses, bca apply online, mca in data science, computer science degree courses, bca admission process, computer application course, bca computer course, mca online admission, computer science subjects, computing courses, mca data science, it course fees, bca university, online bca admission, bca course apply online, mca subjects, bca computer science, colleges for computer science near me, mca qualification, mca university, bca information, apply for bca course, mca course duration and fees, bca data science, mca in cyber security, mca in cloud computing, computer science course near me, bca admission fees";
        
         $pageTitle = "BCA & MCA Courses, Fees, Admission at Gyanmanjari University | GMIU";
    }elseif ($faculty_id == 9) {
        $meta_description = "Meet the faculty member at GMIU – explore their academic background, expertise, and contributions to providing students with a rich and engaging learning experience.";
    
        $meta_keywords = "fashion designing course, fashion designing course fees, diploma in fashion designing, fashion designing courses after 12th, fashion designing course near me, fashion design online course,bachelor of fashion design, fashion designing, university of fashion, fashion course, diploma in fashion designing after 10th, interior design courses, fashion design university, 
            fashion design online course with certificate, bachelor of design, fashion design certificate, college classes, online college courses, interior design diploma, interior design course near me, 
            fashion design online, interior designing course fees, courses after 12th, designing courses after 12th, online fashion designing course with certificate, apply for university, 
            interior design courses after 12th, design university, diploma courses, design courses, fashion technology course, study fashion, interior design study, fashion design certificate online, 
            fashion design courses for beginners, dress designing course, study fashion design, degree courses, study fashion design online, diploma in fashion designing after 12th, online fashion course, 
            interior design diploma course, fashion designing courses after 12th fees, diploma fashion designing course, food technology course, fashion and design course";
            
             $pageTitle = "Bachelor's of Fashion Designing Course | Fees | Gyanmanjari University";
    }elseif ($faculty_id == 11) {
        $meta_description = "Explore the profile of GMIU faculty member – Learn about their academic expertise, research interests, and contributions to enriching the student learning experience at GMIU.";
    
        $meta_keywords = "Health Science Courses, Medical Courses, Diploma Of Health Science, College Online, Online Healthcare Programs, Online Universities, Public Health Courses, Universities In Usa, 
            College Application, Us Colleges, University Courses, Degree Courses, Health Science Programs, Uni Courses, Health Science Online, Online Health Courses, Pg Diploma Courses, 
            Online Health Programs, Science Courses, Management Diploma, Medical Science, Online Health Science Programs, University Programs, Diploma Of Health Science Online, Diploma Of Health,
            Health Science Online Courses, American Universities, Health Care Programs Online, Diploma In Medical Laboratory Technology, Medical Technology Course, Public Health Course Requirements, 
            Public Universities, Courses In Medical Field, University Global, Healthcare Administration Courses Near Me, Admission Science, Pharmacy Study, Medical Science Courses, Diploma Courses In Medical Field,Health Science Certificate, Diploma In Health Administration, Online University Biology, Home University, Management And Science University, Health Science Certificate Online, Health Diploma Courses, Medical Program Online, Application University, University On Line";
             $pageTitle = "Faculty of Medical Science and Health Care at Gyanmanjari University";
             
    }elseif ($faculty_id == 12) {
        $meta_description = "Meet the faculty at GMIU – Learn about the expertise, academic background, and contributions of our esteemed faculty member, enhancing the learning experience at GMIU.";
    
        $meta_keywords = "Social Work Program, Social Work Schools Near Me, Schools For Social Work, Online Bsw, Social Worker Online Courses, Bachelor In Social Work Online, College Online, Online Universities, Social Work Course, Online Social Work Program, Universities In Usa, Social Work Masters Programs, Us Colleges, College Application, Master's Degree In Social Work Online,
        Master In Social Work, Online Social Work Masters Programs, Bachelor Of Science In Social Work, Msw Schools, Social Work Schooling, Online Social Work Degree Programs, 
        Colleges For Social Work Near Me, Online Master's In Social Work, Social Work, Online Msw Program, Online Bsw Program, Online Social Worker, Bachelor Degree Programs,
        Online University For Social Work, Bachelor Of Social Work, Bsw Social Work, Social Work University, Online Schools For Bachelor's Degree In Social Work, Become A Social Worker, Msw Program, 
        Social Work Bsw Online, Undergraduate Degree, Social Work Program Near Me, Master In Education, Becoming A Social Worker Online,Masters Degrees In Social Work, Apply University, Social Work Msw, Schools To Become A Social Worker, Social Worker Education Requirements, Social Worker Education, Online Schools For Education, American Universities, Master's Program Social Work, Online Master Degree Programs In Social Work, 2 Year Online Msw Programs, Online Master In Education, University Post";
        
         $pageTitle = "Faculty of Social Work at Gyanmanjari Innovative University | GMIU";
    }elseif ($faculty_id == 15) {
        $meta_description = "Discover the profile of GMIU faculty member – Learn about their qualifications, expertise, and dedication to providing an excellent academic experience at GMIU.";
    
        $meta_keywords = "Hotel Management Course, Hotel Management Course Fees, Hotel Management, Diploma In Hotel Management, Hospitality Management Course, Hotel Management Certificate, Diploma In Hospitality Management, Hospitality Course, Hospitality Management, Hotel Management Course Near Me, Hotel Management University, Hotel Management Courses Online, Hm Course, International Institute Of Hotel Management, Hospitality Programs, Best Online Courses For Hospitality Management, Bhm Course, Hospitality Management Courses Online, Hospitality Management Certificate, Hotel Management Training, Hotel Management Courses In Uk For International Students, Hotel Management Fees, Hotel And Hospitality Management, Hospitality University, Online Hospitality Management Certificate, Hospitality Certificate Online, Hotel Management Certificate Courses, Hospitality Management Online, Institute Of Hotel Management, Hospitality Management Programs, Hotel Management Course Duration, International Hospitality Management, College School, International Hotel Management, College Online School, Hotel Management Admission, College Classes, School College, Hotel And Hospitality Management Courses, Diploma In Management, Hospitality And Management Course, Online College Courses, College Programs, Apply For College, College Online, College Application, Us Colleges";
        
         $pageTitle = "Faculty of Hotel Management at Gyanmanjari Innovative University";
    }elseif ($faculty_id == 16) {
        $meta_description = "Discover the profile of GMIU faculty member – Explore their academic qualifications, expertise, and contributions to fostering an exceptional learning environment at GMIU.";
    
        $meta_keywords = "Vocational Courses, University Courses, Get A Bachelor's Degree In 6 Months, 6 Months It Courses, Degree In 6 Months, Photography Degree Courses, Vocational Degree, 
            Safety Degree Course, 6 Months Degree Course, Digital Marketing Course Degree, Vocational Courses For International Students, International Courses, Vocational Certificate, 
            Vocational Program, Digital Marketing Course In University, Undergraduate Degree Program, Vocational It Courses, Bachelor College, Vocational Computer Science, Cloud Technology Degree 
            Popular Degrees, Cloud Computing Course University, Courses For Undergraduate Students, 6 Months Technical Courses";
            
             $pageTitle = "Vocational/Certificate Courses at Gyanmanjari Innovative University";
    }elseif ($faculty_id == 18) {
        $meta_description = "Explore the BBA MBA Integrated Course at Gyanmanjari Innovative University. Learn about integrated MBA programs, fees, and more after 12th with flexible options.";
    
        $meta_keywords = "BBA Mba Integrated Course, Integrated Mba, Mba Integrated Course, BBA And Mba Integrated Course, Integrated BBA Mba, Integrated Mba After 12th, BBA Integrated Course, 
            Integrated Courses After 12th, Integrated Mba Fees, Bca Mca Integrated Course, Online Integrated Mba, Integrated Mba Online, Integrated Course BBA Mba, 5 Year Integrated Courses After 12th,
            Integrated B Tech After 10th, Integrated Degree, Integrated Degree Courses, Integrated Ug Courses, Integrated Ug And Pg, Integrated Courses, Integrated Degree Courses After 12th, 
            Integrated Course For Commerce Students, Integrated 5 Years Course, Best Integrated Courses After 12th, Integrated Course For Commerce";
            
             $pageTitle = "Integrated MBA at GMIU: Earn a BBA and MBA in One Program";
    }elseif ($faculty_id == 19) {
        $meta_description = "Meet the esteemed faculty member at GMIU, bringing expertise and a commitment to academic excellence, shaping students' futures with knowledge and guidance.";
    
        $meta_keywords = "Phd In Management, Phd Degree, Phd Programs, Phd Course, Phd Admission, College Degrees, Bachelor Degree Years, Apply For Phd, Phd Application, Phd In Engineering, Phd In Mathematics, Phd University, Phd In Commerce, Degree Program, Phd Course Fees, Phd Certificate, Phd In 2 Years, Phd By Research, Phd Research, Phd Degree Courses, 2 Year Phd Program, Professional Phd, Phd Degree Program, Phd Course List, Phd Syllabus, Phd Subject List, Phd Fee Structure, Phd List, Phd Admission In Us, Phd After Degree, Phd Admission In, Phd Ugc, Phd From Us Universities, Ugc On Phd, Ugc For Phd";
        
         $pageTitle = "Ph.D. (Minimum 3 Years) - Gyanmanjari Innovative University | GMIU";
    }elseif ($faculty_id == 22) {
        $meta_description = "Explore dual degree programs at Gyanmanjari Innovative University. Offering a wide range of college programs, including IT, Cyber Security, and Political Science degrees.";
    
        $meta_keywords = "Dual Degree Programs, College Programs, Bachelor Degree, Science Degrees, It Degree Programs, College Degrees, Cyber Security University, Technology Degrees, It Tech Degree, 
            Political Science Degree, Technical Degree, Technology Programs, Business Degree, Bachelor Programs, Dual Degree, Cybersecurity Programs, Degree Courses, Ba Degree, Cyber Security Degree Programs, Education Degree, Business Technology Degree, Ba In Business Administration, Administration Degree, Public Administration Degree, Computer It Degree, Digital Marketing Degree, 
            Technical Degree Programs, It Security Degree, Commerce Degree, Public Administration Course, Degree Programs, Ba Course, University Degrees, Business And Administration Degree,
            Computer Degree, University Programs, Degrees From Home, Degree Program, Bachelor's In Political Science, Marketing Degree Programs, Business It Degree, Security Degree, Undergraduate Program";
            
             $pageTitle = "Dual Degree & IT Programs at Gyanmanjari Innovative University | Tech & Science";
    }elseif ($faculty_id == 27) {
        $meta_description = "Apply to GMIU's Commerce programs for comprehensive education in Bachelor and Master of Commerce, including online BCom courses. Ideal for aspiring commerce students.";
    
        $meta_keywords = "College Application, Arts University, Education Study, Faculty In University, Bachelor Of Commerce, Commerce Courses, Master Of Commerce, Bcom Courses, Bachelor Of Commerce Onlin, Bcom Subjects, Online Bcom, Online Bcom Course, Courses For Commerce Students, After Graduation Courses In Commerce, Bcom Admission, Mcom Admission, Bcom Course Details, Courses After Bcom, Bcom University, Online Courses For Commerce Students, After 12 Commerce Courses, Bcom Colleges Near Me, Bachelor Of Commerce Accounting, B Commerce, Commerce University, Bachelor Of Commerce Subjects,Online Courses For Bcom Students, Study Commerce, University Admission, University Study, Degree Programs, Faculty Of Arts, Ba Programs, Ba University, Activities For Students,Ma In Administration, Ma University, University For Ba, College Information, Ba Subject, University Of Arts, Good Universities, Ba Programme, Bachelor Of Arts Courses, Ba Admission Fees, Arts University, Ba In Administration, University Study, Master In Arts, Ba Study, Ba Course Fees, Ba Bachelor Of Arts, Ba Arts, Faculty Of Arts";
        
         $pageTitle = "Gyanmanjari Arts/Commerce Girls College | Empowering Women Students";
    }


?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
  
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
     <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/font-awesome.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        .duration-intake p {
            color: #333333;
            margin-top: 4px;
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }
        .sideBar ul:not(.navSub)>li:first-child {
            width: 100%;
            background-image: linear-gradient(#ba2a21, #ba2a21);
            background-color: rgba(0, 0, 0, 0.2);
            background-blend-mode: multiply;
            margin: 3px 0;
            border-radius: 5px;
            padding: 7px 15px;
            color: #fff;
            text-transform: uppercase;
        }
        .sideBar ul li a:hover, .sideBar ul li a.active {
    background: #ba2a21;
    color: #fff !important;
    transform: none;
    padding-left: 25px;
}
    </style>
</head>
  <script>
        document.documentElement.style.setProperty('--main-color', '#ba2a21'); // Change color dynamically
    </script>
    
<body class="courses">
    <!--  Preloader -->
    <!--  <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> -->
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>
                        <?php echo $faculty_name; ?>
                    </h1>
                </div>
                <p style="margin-top:5px;"><span><a href="#" style="color:#727272">Home <i class='fa fa-angle-right'></i></a></span> <span class="b-active">
                       <span class="text-uppercase"> <?php echo $faculty_name ?> </span>
                    </span></p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="des">
                            <h3 class="title gradText">ABOUT FACULTY</h3>
                            <hr>
                            <p>
                                <?php echo htmlspecialchars_decode($faculty_description) ?>
                            </p>
                        </section>
                        <!-- apply now box -->
                        <section class="trausted-stu-area">
                            <!-- <div class="container"> -->
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="trausted-content">
                                        <div class="row border-box-admission">
                                            <div class="col-sm-12 col-md-9">
                                                <h3 class="title gradText" style="font-size : 17px;">ADMISSION 2025-26
                                                </h3>
                                                <hr>
                                                <h3 class="section-h-medium">For admission regarding query:</h3>
                                                <p><i class="fa-solid fa-phone"></i> <span class="mobile-number"> +91
                                                        90999 51160, </span><span class="mobile-number"> +91 75749
                                                        49494</span> </p>
                                            </div>

                                            <div class="col-sm-12 col-md-3">
                                                <div class="trausted-stu-btn">
                                                    <a href="<?php echo $base_url_admission; ?>" class="">Apply Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                        </section>

                        <!-- cource-1 cards  -->
                        <?php
                        /*  $query="SELECT program.level_id,level.name as level_name from tbl_program as program
                                LEFT JOIN tbl_level level ON program.level_id = level.id
                                WHERE program.faculty_id=? AND program.is_active=1 AND program.is_delete=0 GROUP BY level_id ORDER BY level_id";
                                $cmd = $con->prepare($query);
                                $cmd->bind_param("i",$faculty_id);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                $cmd->store_result();
                                $cmd->close(); */

                        /*    if ($result->num_rows != 0) {
                                    while ($row = $result->fetch_assoc()) {
                                
                                    $level_name=$row['level_name'];
                                    $level_id=$row['level_id']; */
                        if ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
                            // Show only level_id = 5
                            $query = "SELECT program.level_id, level.name as level_name 
                                        FROM tbl_program as program
                                        LEFT JOIN tbl_level level ON program.level_id = level.id
                                        WHERE program.faculty_id = $faculty_id 
                                        AND program.is_active = 1 
                                        AND program.is_delete = 0 
                                        AND program.level_id = 5
                                        GROUP BY program.level_id 
                                        ORDER BY FIELD(program.level_id,5)";
                        } elseif($faculty_slug == 'faculty-of-engineering-amp-technology'){
                             $query = "SELECT program.level_id, level.name as level_name 
                                         FROM tbl_program as program
                                         LEFT JOIN tbl_level level ON program.level_id = level.id
                                         WHERE program.faculty_id = $faculty_id 
                                         AND program.is_active = 1 
                                         AND program.is_delete = 0 
                                         AND program.level_id NOT IN (5, 15)
                                         GROUP BY program.level_id 
                                         ORDER BY FIELD(program.level_id,7,3,1,2,8,4,6,9,10,12,13,14,15,17)";
                        } else {
                            // Original query for other faculties
                            $query = "SELECT program.level_id, level.name as level_name 
                                         FROM tbl_program as program
                                         LEFT JOIN tbl_level level ON program.level_id = level.id
                                         WHERE program.faculty_id = $faculty_id 
                                         AND program.is_active = 1 
                                         AND program.is_delete = 0 
                                         AND program.level_id NOT IN ( 15)
                                         AND NOT (program.faculty_id = '27' AND program.level_id = '15')
                                         GROUP BY program.level_id 
                                         ORDER BY FIELD(program.level_id,5,7,3,1,2,8,4,6,9,10,12,13,14,15,17)";
                        }
                        $result = mysqli_query($con, $query);

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                $level_name = $row['level_name'];
                                $level_id = $row['level_id'];
                         //       $brochure = $row['brochure'];


                                $query22 = "SELECT `id`, `faculty_id`, `level_id`, `document` FROM `tbl_faculty_brochure` WHERE faculty_id = $faculty_id AND level_id = $level_id";
                                $result22 = mysqli_query($con, $query22);

                                if (mysqli_num_rows($result22) > 0) {
                                    // output data of each row
                                    while ($row22 = mysqli_fetch_assoc($result22)) {
                                        $brochure = $row22['document'];
                                    }
                                }



                        ?>
                                <section class="two-column-cards">
                                    <h3 class="title gradText">
                                        <?php echo $level_name; ?>
                                    </h3>
                                    <hr>

                                    <div class="courses-cards">
                                        <?php
                                        /*  $query1="SELECT program.name as program_name from tbl_program as program
                                WHERE program.faculty_id=? AND program.is_active=1 AND program.is_delete=0";
                                $cmd1 = $con->prepare($query1);
                                $cmd1->bind_param("i",$faculty_id);
                                $cmd1->execute();
                                $cmd1->store_result();
                                $cmd1->close();
                                $result1 = $cmd->get_result();
                                if ($result1->num_rows != 0) {
                                    while ($row1 = $result->fetch_assoc()) { */
                                        $query1 = "SELECT 
                                                    program.id AS program_id,
                                                    program.name AS program_name,
                                                    program.intake AS program_intake,
                                                    program.regular AS regular,
                                                    program.duration AS program_duration,
                                                    program_slug 
                                                FROM tbl_program AS program 
                                                WHERE 
                                                    program.faculty_id = $faculty_id 
                                                    AND program.level_id = $level_id 
                                                    AND program.is_active = 1 
                                                    AND program.is_delete = 0 
                                                ORDER BY 
                                                    CASE 
                                                        WHEN program.name LIKE '%premium%' THEN 1 
                                                        ELSE 2 
                                                    END,
                                                    CASE 
                                                        WHEN program.short_no = 0 THEN 2  
                                                        ELSE 1  
                                                    END,
                                                    program.short_no ASC,  
                                                    program.name ASC; 
                                                ";
                                        $result1 = mysqli_query($con, $query1);
                                        if (mysqli_num_rows($result1) > 0) {
                                            // output data of each row
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                $program_name = $row1['program_name'];
                                                $program_id = $row1['program_id'];
                                                $program_slug = $row1['program_slug'];
                                                $regfees = $row1['regular'];
                                                $regyear = $row1['program_duration'];
                                                $program_intake = $row1['program_intake'];
                                                $program_duration = $row1['program_duration'];
                                                if ($faculty_id == 16) {
                                                    $fees = $regfees;
                                                } else {
                                                    $fees = $regfees / 2;
                                                }
                                        ?>
                                                <div class="card-for-course">
                                                    <a>
                                                       
                                                                <!--<a href="<?php //echo $base_url_website_faculty?><?php //echo $faculty_slug; ?>/<?php //echo $program_slug; ?>">-->
                                                               <a href="<?php echo $base_url_website_faculty . $faculty_slug . '/' . $program_slug; ?>">

                                                                <h3 class="course-name" style="word-break: auto-phrase;">
                                                                    <?php echo $program_name; ?>
                                                                </h3>
                                                                <div class="duration-intake">
                                                                    <p>Duration: <b>
                                                                            <?php echo $program_duration; ?> <?php
                                                                                                                if ($faculty_id == 22 || $faculty_id == 16) {
                                                                                                                    echo '';
                                                                                                                } else {
                                                                                                                    echo 'Years';
                                                                                                                }
                                                                                                                0
                                                                                                                ?>
                                                                        </b> </p>
                                                                    <p>Intake: <b>
                                                                            <?php echo $program_intake; ?>
                                                                        </b> </p>
                                                                    <?php if ($level_id == 5 &&  $faculty_id == 1) {
                                                                    ?>
                                                                        <p>Fees: <b>
                                                                            <?php
                                                                        } elseif ($level_id == 2 &&  $faculty_id == 8) {
                                                                            ?>
                                                                                <p>Fees: <b>
                                                                                    <?php
                                                                                } elseif ($faculty_id == 2) {
                                                                                    ?>
                                                                                        <p>Fees: <b>
                                                                                            <?php
                                                                                        } elseif ($level_id == 2 &&  $faculty_id == 5) {
                                                                                            ?>
                                                                                                <p>Fees: <b>
                                                                                                    <?php
                                                                                                } elseif ($faculty_id == 22 || $faculty_id == 16) {
                                                                                                    ?>
                                                                                                        <p>Fees: &nbsp;<b>
                                                                                                            <?php
                                                                                                        } else {
                                                                                                            ?>
                                                                                                                <p>Semester Fees: <b>
                                                                                                                    <?php
                                                                                                                }
                                                                                                                    ?>
                                                                                                                    <?php
                                                                                                                    if ($faculty_id == 22) {
                                                                                                                        echo ' As Per Course';
                                                                                                                    } else {
                                                                                                                        echo $fees;
                                                                                                                    } ?>
                                                                                                                    </b> </p>
                                                                </div>
                                                                </a>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </section>
                                <?php if ($level_id == 5 &&  $faculty_id == 1) {
                                ?>
                                    <div class="">
                                        <p>*Semester Fees As Per FRC.</p>
                                    </div>
                                <?php
                                } elseif ($level_id == 2 &&  $faculty_id == 8) {
                                ?>
                                    <div class="">
                                        <p>*Semester Fees As Per FRC.</p>
                                    </div>
                                <?php
                                } elseif ($faculty_id == 2) {
                                ?>
                                    <div class="">
                                        <p>*Semester Fees As Per FRC.</p>
                                    </div>
                                <?php
                                } elseif ($level_id == 2 &&  $faculty_id == 5) {
                                ?>
                                    <div class="">
                                        <p>*Semester Fees As Per FRC.</p>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($faculty_id == 1 && $level_id == 1) {
                                    //engineering and ug
                                    echo '<section class="video-content">
                                    <h3 class="title gradText">Video About Department</h3>
                                    <hr>
                                    <div class="video">
                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/Q09uiWcpCOQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                </section>
                                <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                                <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF ENGINEERING/B.Tech/B.Tech FAQ.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 1 && $level_id == 2) {
                                    //engineering and pg  
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/dPLM06J425w"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                    <div class="card">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                        <p>Admission Process</p>
                                    </div>
                                </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="#">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 1 && $level_id == 5) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/qRtYABFKjxk"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF ENGINEERING/DIPLOMA ENGG/FAQ OF Diploma Engg.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 2 && $level_id == 1) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/AaCo62xqJ54"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <i class="fa-solid fa-graduation-cap"></i>

                                                <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF PHARMACY/FAQ OF PHARMACY E_G FINAL.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 3 && $level_id == 1) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/YZTIEV403OA"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                       <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FECULTY OF SCIENCE/B.Sc/FAQ OF B.Sc.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 3 && $level_id == 2) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/p7esgc9Rz8o"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FECULTY OF SCIENCE/M.Sc/_FAQ OF M.Sc.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 4 && $level_id == 1) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/oRDg6WDFgrM"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF COMMERCE/B.Com/FAQ OF B.COM.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 4 && $level_id == 2) {
                                    echo '<section class="video-content">
                                                    <h3 class="title gradText">Video About Department</h3>
                                                    <hr>
                                                    <div class="video">
                                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/kznjdUAuxJA"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    </div>
                                            </section>
                                            <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF COMMERCE/M.Com/M.Com(1).pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 5 && $level_id == 1) {
                                    echo '<section class="video-content">
                                <h3 class="title gradText">Video About Department</h3>
                                <hr>
                                <div class="video">
                                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/5ZJpU_whx1k"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                </div>
                                </section>
                                <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                            <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/BBA/FAQ BBA.pdf">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                </section>';
                                } else if ($faculty_id == 5 && $level_id == 2) {
                                    echo '<section class="video-content">
                            <h3 class="title gradText">Video About Department</h3>
                            <hr>
                            <div class="video">
                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/e6LuIGooOCA"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            </section>
                            <section class="links-card">
                                <h3 class="title gradText">IMPORTANT LINKS</h3>
                                <hr>
                                <div class="cards-container">
                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                        <div class="card">
                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                            <p>Admission Process</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/MBA/MBA.pdf">
                                        <div class="card">
                                            <i class="fa fa-book"></i>
                                            <p>Brochure</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF MANAGEMENT/MBA/faq MBA.pdf">
                                        <div class="card">
                                            <i class="fa fa-question"></i>
                                            <p>FAQ</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                        <div class="card">
                                            <i class="fa fa-building"></i>
                                            <p>Hostel Facility</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                        <div class="card">
                                            <i class="fa fa-street-view"></i>
                                            <p>360 tour link</p>
                                        </div>
                                    </a>
                                    <a target="_blank" href="' . $base_url_admission . '">
                                        <div class="card">
                                            <i class="fa fa-link"></i>
                                            <p>Apply Online</p>
                                        </div>
                                    </a>
                                </div>
                            </section>';
                                } else if ($faculty_id == 6 && $level_id == 1) {
                                    echo '<section class="video-content">
                        <h3 class="title gradText">Video About Department</h3>
                        <hr>
                        <div class="video">
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/a2roJ1ze3pE"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                        </section>
                        <section class="links-card">
                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                            <hr>
                            <div class="cards-container">
                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                    <div class="card">
                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                        <p>Admission Process</p>
                                    </div>
                                </a>
                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                    <div class="card">
                                        <i class="fa fa-book"></i>
                                        <p>Brochure</p>
                                    </div>
                                </a>
                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF ARTS/B.A/FAQ B.A.pdf">
                                    <div class="card">
                                        <i class="fa fa-question"></i>
                                        <p>FAQ</p>
                                    </div>
                                </a>
                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                    <div class="card">
                                        <i class="fa fa-building"></i>
                                        <p>Hostel Facility</p>
                                    </div>
                                </a>
                                <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                    <div class="card">
                                        <i class="fa fa-street-view"></i>
                                        <p>360 tour link</p>
                                    </div>
                                </a>
                                <a target="_blank" href="' . $base_url_admission . '">
                                    <div class="card">
                                        <i class="fa fa-link"></i>
                                        <p>Apply Online</p>
                                    </div>
                                </a>
                            </div>
                        </section>';
                                } else if ($faculty_id == 6 && $level_id == 2) {
                                    echo '<section class="video-content">
                    <h3 class="title gradText">Video About Department</h3>
                    <hr>
                    <div class="video">
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/Y1esXwLElpU"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>
                    </section>
                    <section class="links-card">
                        <h3 class="title gradText">IMPORTANT LINKS</h3>
                        <hr>
                        <div class="cards-container">
                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                <div class="card">
                                    <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                    <p>Admission Process</p>
                                </div>
                            </a>
                            <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                <div class="card">
                                    <i class="fa fa-book"></i>
                                    <p>Brochure</p>
                                </div>
                            </a>
                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF ARTS/M.A/FAQM.A.2.pdf">
                                <div class="card">
                                    <i class="fa fa-question"></i>
                                    <p>FAQ</p>
                                </div>
                            </a>
                            <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                <div class="card">
                                    <i class="fa fa-building"></i>
                                    <p>Hostel Facility</p>
                                </div>
                            </a>
                            <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                <div class="card">
                                    <i class="fa fa-street-view"></i>
                                    <p>360 tour link</p>
                                </div>
                            </a>
                            <a target="_blank" href="' . $base_url_admission . '">
                                <div class="card">
                                    <i class="fa fa-link"></i>
                                    <p>Apply Online</p>
                                </div>
                            </a>
                        </div>
                    </section>';
                                } else if ($faculty_id == 8 && $level_id == 1) {
                                    echo '<section class="video-content">
                <h3 class="title gradText">Video About Department</h3>
                <hr>
                <div class="video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/cuMltdXFDJU"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
                </section>
                <section class="links-card">
                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                    <hr>
                    <div class="cards-container">
                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                            <div class="card">
                                <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                <p>Admission Process</p>
                            </div>
                        </a>
                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                            <div class="card">
                                <i class="fa fa-book"></i>
                                <p>Brochure</p>
                            </div>
                        </a>
                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF COMPUTER SCIENCE/BCA/BCA FAQs.pdf">
                            <div class="card">
                                <i class="fa fa-question"></i>
                                <p>FAQ</p>
                            </div>
                        </a>
                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                            <div class="card">
                                <i class="fa fa-building"></i>
                                <p>Hostel Facility</p>
                            </div>
                        </a>
                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                            <div class="card">
                                <i class="fa fa-street-view"></i>
                                <p>360 tour link</p>
                            </div>
                        </a>
                        <a target="_blank" href="' . $base_url_admission . '">
                            <div class="card">
                                <i class="fa fa-link"></i>
                                <p>Apply Online</p>
                            </div>
                        </a>
                    </div>
                </section>';
                                } else if ($faculty_id == 8 && $level_id == 2) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/EQAOP5e82Zk"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                    <div class="card">
                                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                        <p>Admission Process</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                    <div class="card">
                                                        <i class="fa fa-book"></i>
                                                        <p>Brochure</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF COMPUTER SCIENCE/MCA/MCA FAQs (1).pdf">
                                                    <div class="card">
                                                        <i class="fa fa-question"></i>
                                                        <p>FAQ</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                    <div class="card">
                                                        <i class="fa fa-building"></i>
                                                        <p>Hostel Facility</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                                    <div class="card">
                                                        <i class="fa fa-street-view"></i>
                                                        <p>360 tour link</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_admission . '">
                                                    <div class="card">
                                                        <i class="fa fa-link"></i>
                                                        <p>Apply Online</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </section>';
                                } else if ($faculty_id == 9 && $level_id == 1) {
                                    echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/xruEuQcOc1M"
                                                    title="YouTube video player" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                            </div>
                                            </section>
                                            <section class="links-card">
                                                <h3 class="title gradText">IMPORTANT LINKS</h3>
                                                <hr>
                                                <div class="cards-container">
                                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                        <div class="card">
                                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                            <p>Admission Process</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                        <div class="card">
                                                            <i class="fa fa-book"></i>
                                                            <p>Brochure</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Bachelor in Design/FAQ- Bachelor Design & Home Science.pdf">
                                                        <div class="card">
                                                            <i class="fa fa-question"></i>
                                                            <p>FAQ</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                        <div class="card">
                                                            <i class="fa fa-building"></i>
                                                            <p>Hostel Facility</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                                        <div class="card">
                                                            <i class="fa fa-street-view"></i>
                                                            <p>360 tour link</p>
                                                        </div>
                                                    </a>
                                                    <a target="_blank" href="' . $base_url_admission . '">
                                                        <div class="card">
                                                            <i class="fa fa-link"></i>
                                                            <p>Apply Online</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </section>';
                                } else if ($faculty_id == 9 && $level_id == 2) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/zL3VgR1A6_c"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                    <div class="card">
                                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                        <p>Admission Process</p>
                                                    </div>
                                                </a>
   
                                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                    <div class="card">
                                                        <i class="fa fa-book"></i>
                                                        <p>Brochure</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Master in Design/FAQ- PG- Master Home Science.pdf">
                                                    <div class="card">
                                                        <i class="fa fa-question"></i>
                                                        <p>FAQ</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                    <div class="card">
                                                        <i class="fa fa-building"></i>
                                                        <p>Hostel Facility</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                                    <div class="card">
                                                        <i class="fa fa-street-view"></i>
                                                        <p>360 tour link</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_admission . '">
                                                    <div class="card">
                                                        <i class="fa fa-link"></i>
                                                        <p>Apply Online</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </section>';
                                } else if ($faculty_id == 9 && $level_id == 5) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/0iCczYv_zcI"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                    <div class="card">
                                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                        <p>Admission Process</p>
                                                    </div>
                                                </a>
   
                                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                    <div class="card">
                                                        <i class="fa fa-book"></i>
                                                        <p>Brochure</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF DESIGN/Diploma in Design/FAQ- Diploma Faculty of Design.pdf">
                                                    <div class="card">
                                                        <i class="fa fa-question"></i>
                                                        <p>FAQ</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                    <div class="card">
                                                        <i class="fa fa-building"></i>
                                                        <p>Hostel Facility</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                                    <div class="card">
                                                        <i class="fa fa-street-view"></i>
                                                        <p>360 tour link</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_admission . '">
                                                    <div class="card">
                                                        <i class="fa fa-link"></i>
                                                        <p>Apply Online</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </section>';
                                } else if ($faculty_id == 10 && $level_id == 1) {
                                    echo '<section class="video-content">
                                    <h3 class="title gradText">Video About Department</h3>
                                    <hr>
                                    <div class="video">
                                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/f1U4A7HUe5o"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                    </div>
                                    </section>
                                    <section class="links-card">
                                    <h3 class="title gradText">IMPORTANT LINKS</h3>
                                    <hr>
                                    <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                                <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                <p>Admission Process</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '"><a target="_blank" href="' . $website_assets_url . 'gmiu_doc/MEDICAL SCIENCE _ HEALTH CARE/(MS_HC)
                                            <div class="card">
                                                <i class="fa fa-book"></i>
                                                <p>Brochure</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="#">
                                            <div class="card">
                                                <i class="fa fa-question"></i>
                                                <p>FAQ</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                                <i class="fa fa-building"></i>
                                                <p>Hostel Facility</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                                <i class="fa fa-street-view"></i>
                                                <p>360 tour link</p>
                                            </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                                <i class="fa fa-link"></i>
                                                <p>Apply Online</p>
                                            </div>
                                        </a>
                                    </div>
                                    </section>';
                                } else if ($faculty_id == 11) {
                                    echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/f1U4A7HUe5o"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen></iframe>
                                            </div>
                                            </section>
                                            <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                                    <div class="card">
                                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                                        <p>Admission Process</p>
                                                    </div>
                                                </a>
   
                                                <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                                    <div class="card">
                                                        <i class="fa fa-book"></i>
                                                        <p>Brochure</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/MEDICAL SCIENCE _ HEALTH CARE/FAQS Of Medical Science 2024-2025.pdf">
                                                    <div class="card">
                                                        <i class="fa fa-question"></i>
                                                        <p>FAQ</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                                    <div class="card">
                                                        <i class="fa fa-building"></i>
                                                        <p>Hostel Facility</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                                    <div class="card">
                                                        <i class="fa fa-street-view"></i>
                                                        <p>360 tour link</p>
                                                    </div>
                                                </a>
                                                <a target="_blank" href="' . $base_url_admission . '">
                                                    <div class="card">
                                                        <i class="fa fa-link"></i>
                                                        <p>Apply Online</p>
                                                    </div>
                                                </a>
                                            </div>
                                            </section>';
                                } else if ($faculty_id == 12 && $level_id == 1) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/x5LHZ9Fhkc8"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                        <h3 class="title gradText">IMPORTANT LINKS</h3>
                                        <hr>
                                        <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                        <div class="card">
                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                        <p>Admission Process</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                        <i class="fa fa-book"></i>
                                        <p>Brochure</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/SOCIAL WORK/BSW/BSW FAQ .pdf">
                                        <div class="card">
                                        <i class="fa fa-question"></i>
                                        <p>FAQ</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                        <div class="card">
                                        <i class="fa fa-building"></i>
                                        <p>Hostel Facility</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                        <div class="card">
                                        <i class="fa fa-street-view"></i>
                                        <p>360 tour link</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                        <div class="card">
                                        <i class="fa fa-link"></i>
                                        <p>Apply Online</p>
                                        </div>
                                        </a>
                                        </div>
                                        </section>';
                                } else if ($faculty_id == 12 && $level_id == 2) {
                                    echo '<section class="video-content">
                                        <h3 class="title gradText">Video About Department</h3>
                                        <hr>
                                        <div class="video">
                                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/jzq7QoGiXDI"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                        </div>
                                        </section>
                                        <section class="links-card">
                                        <h3 class="title gradText">IMPORTANT LINKS</h3>
                                        <hr>
                                        <div class="cards-container">
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                        <div class="card">
                                        <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                        <p>Admission Process</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                        <div class="card">
                                        <i class="fa fa-book"></i>
                                        <p>Brochure</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/SOCIAL WORK/MSW/FAQ MSW final for online.pdf">
                                        <div class="card">
                                        <i class="fa fa-question"></i>
                                        <p>FAQ</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                        <div class="card">
                                        <i class="fa fa-building"></i>
                                        <p>Hostel Facility</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                        <div class="card">
                                        <i class="fa fa-street-view"></i>
                                        <p>360 tour link</p>
                                        </div>
                                        </a>
                                        <a target="_blank" href="' . $base_url_admission . '">
                                        <div class="card">
                                        <i class="fa fa-link"></i>
                                        <p>Apply Online</p>
                                        </div>
                                        </a>
                                        </div>
                                        </section>';
                                } else if ($faculty_id == 15 && $level_id == 1) {
                                    echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/5ZJpU_whx1k"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                            </div>
                                            </section>
                                            <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                            <p>Admission Process</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                            <i class="fa fa-book"></i>
                                            <p>Brochure</p>
                                            </div>
                                            </a>
                                            <a href="#" target="_blank" >
                                            <div class="card">
                                            <i class="fa fa-question"></i>
                                            <p>FAQ</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                            <i class="fa fa-building"></i>
                                            <p>Hostel Facility</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                            <i class="fa fa-street-view"></i>
                                            <p>360 tour link</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                            <i class="fa fa-link"></i>
                                            <p>Apply Online</p>
                                            </div>
                                            </a>
                                            </div>
                                            </section>';
                                } else if ($faculty_id == 15 && $level_id == 5) {
                                    echo '<section class="video-content">
                                            <h3 class="title gradText">Video About Department</h3>
                                            <hr>
                                            <div class="video">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/LyLBT3SaxDM"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                            </div>
                                            </section>
                                            <section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                            <p>Admission Process</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                            <i class="fa fa-book"></i>
                                            <p>Brochure</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/FACULTY OF HOTEL MANAGEMENT/Bachelor of Hotel Managment/8. HM_FAQ.pdf">
                                            <div class="card">
                                            <i class="fa fa-question"></i>
                                            <p>FAQ</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                            <i class="fa fa-building"></i>
                                            <p>Hostel Facility</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                            <i class="fa fa-street-view"></i>
                                            <p>360 tour link</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                            <i class="fa fa-link"></i>
                                            <p>Apply Online</p>
                                            </div>
                                            </a>
                                            </div>
                                            </section>';
                                } else if ($faculty_id == 18) {
                                    echo '<section class="links-card">
                                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                                            <hr>
                                            <div class="cards-container">
                                            <a target="_blank" href="' . $website_assets_url . 'gmiu_doc/online-registration1.pdf">
                                            <div class="card">
                                            <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                            <p>Admission Process</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $upload_website_admin_url . 'faculty_brochure/document/' . $brochure . '">
                                            <div class="card">
                                            <i class="fa fa-book"></i>
                                            <p>Brochure</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="#">
                                            <div class="card">
                                            <i class="fa fa-question"></i>
                                            <p>FAQ</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_website_common . 'hostel.php">
                                            <div class="card">
                                            <i class="fa fa-building"></i>
                                            <p>Hostel Facility</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php">
                                            <div class="card">
                                            <i class="fa fa-street-view"></i>
                                            <p>360 tour link</p>
                                            </div>
                                            </a>
                                            <a target="_blank" href="' . $base_url_admission . '">
                                            <div class="card">
                                            <i class="fa fa-link"></i>
                                            <p>Apply Online</p>
                                            </div>
                                            </a>
                                            </div>
                                            </section>';
                                }
                                ?>
                        <?php
                            }
                        }
                        ?>
                              <div class="row" id="media_coverage">
                            <div class="col-sm-12 section-header-box">
                                <div class="">
                                    <h3 class="title gradText text-uppercase">SHORT REELS</h3>
                                    <hr>
                                </div>
                                <!-- ends: .section-header -->
                            </div>
                        </div>
                        <div class="swiper-container" style="overflow:hidden; margin-left: auto; margin-right: auto; ">
                            <div class="swiper-wrapper">

                                <?php
                                  
                                if ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
                                    $common_reels = [
                                        "https://youtube.com/shorts/w9P20sKv7Sw?feature=share",
                                        "https://youtube.com/shorts/eZmOzwXLcvw?feature=share",
                                        "https://youtube.com/shorts/_MOYM4pkKYM?feature=share",
                                        "https://youtube.com/shorts/wF2iEogNbWs?feature=share",
                                        "https://youtube.com/shorts/GZbkq_s4sng?feature=share",
                                        "https://youtube.com/shorts/2NZ9F_UW8B8?feature=share",
                                        "https://youtube.com/shorts/k70MguUD3K0?feature=share",
                                        "https://youtube.com/shorts/FCRJhxIGzR8?feature=share",
                                        "https://youtube.com/shorts/DcNR2rFFEVY?feature=share",
                                        "https://youtube.com/shorts/JbLtoWw38xU?feature=share",
                                        "https://youtube.com/shorts/5S_Ox1pGjPo?feature=share",
                                        "https://youtube.com/shorts/_eX_oScPBeI?feature=share",
                                        "https://youtube.com/shorts/Pqh8Qm1oGC8?feature=share",
                                        "https://youtube.com/shorts/sWv9w3pLo0o?feature=share"
                                    ];
                                } else {
                                    $common_reels = [
                                        "https://youtu.be/eZmOzwXLcvw?feature=shared",
                                        "https://youtu.be/_MOYM4pkKYM?feature=shared",
                                        "https://youtu.be/k70MguUD3K0?feature=shared",
                                        "https://youtu.be/DcNR2rFFEVY?feature=shared",
                                        "https://youtu.be/5S_Ox1pGjPo?feature=shared",
                                        "https://youtu.be/Pqh8Qm1oGC8?feature=shared",
                                        "https://youtu.be/_eX_oScPBeI?feature=shared",
                                        "https://youtube.com/shorts/vv0vnNlfx0M?feature=share",
                                        "https://youtube.com/shorts/A-K1-_TdqsA?feature=share",
                                        "https://youtube.com/shorts/Ouv7ujMfiIU",
                                        "https://youtube.com/shorts/Oi96_Ksb05k?feature=share"
                                    ];
                                }
                                // Function to extract YouTube video ID
                                function extractYouTubeID($url)
                                {
                                    // Regex patterns to match various YouTube URL formats
                                    $patterns = [
                                        '/youtu\.be\/([a-zA-Z0-9_-]+)/',  // youtu.be/VIDEO_ID
                                        '/youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/', // youtube.com/shorts/VIDEO_ID
                                        '/youtube\.com\/.*[?&]v=([a-zA-Z0-9_-]+)/', // youtube.com/watch?v=VIDEO_ID
                                        '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/' // youtube.com/embed/VIDEO_ID
                                    ];

                                    foreach ($patterns as $pattern) {
                                        if (preg_match($pattern, $url, $matches)) {
                                            return $matches[1]; // Return the extracted video ID
                                        }
                                    }
                                    return null; // Return null if no match found
                                }

                                // Generate Swiper slides for common reels
                                foreach ($common_reels as $url) {
                                    $video_id = extractYouTubeID($url);

                                    if ($video_id) {
                                        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                                        echo '<div class="swiper-slide">';
                                        echo '<a href="' . htmlspecialchars($url) . '" target="_blank">';
                                        echo '<img src="' . $thumbnail_url . '" alt="YouTube Thumbnail" >';
                                        echo '</a>';
                                        echo '</div>';
                                    } else {
                                        echo '<div class="swiper-slide"><p>Invalid video URL</p></div>';
                                    }
                                }
                                ?>

                                <?php
                                  if ($faculty_slug != 'faculty-of-engineering-amp-technology-diploma') {

                                    $cmd =
                                        "SELECT `file_type`, `file` FROM `tbl_media_coverage` WHERE file_type = 'reel' AND is_active = 1 AND is_delete = 0 AND faculty_id = '$faculty_id' ORDER BY id DESC LIMIT 10";
                                    $stmt = $con->prepare($cmd);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
    
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["file_type"] === "reel") {
                                            // Extract the YouTube video ID from the URL.
                                            // This regex works for URLs containing 'embed/'
                                            preg_match(
                                                "/embed\/([^?]+)/",
                                                $row["file"],
                                                $matches
                                            );
                                            $video_id = isset($matches[1])
                                                ? $matches[1]
                                                : "";
    
                                            if (!empty($video_id)) {
                                                $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                                                echo '<div class="swiper-slide">';
                                                echo '<a href="' .
                                                    htmlspecialchars($row["file"]) .
                                                    '" target="_blank">';
                                                echo '<img src="' .
                                                    $thumbnail_url .
                                                    '" alt="YouTube Thumbnail">';
                                                echo "</a>";
                                                echo "</div>";
                                            } else {
                                                // Optional: Handle cases where the video ID couldn't be extracted.
                                                echo '<div class="swiper-slide"><p>Invalid video URL</p></div>';
                                            }
                                        }
                                    }
                                  }
                                ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <section>
                            <h3 class="title gradText text-uppercase">DAILY POST</h3>
                            <hr>
                            <div class="news-slider">
                                <marquee onMouseOver="this.stop()" onMouseOut="this.start()" direction="left" scrollamount="20" loop="infinite">
                                    <?php
                                       if ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
                                             $cmd = $con->prepare("SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as 
                                    dp_file_type, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 
                                    AND daily_post.is_delete=0 AND (daily_post.is_common_reel = 1 OR daily_post.faculty_id = '$faculty_id')  ORDER BY daily_post.date ");
                                       }
                                       else{
                                             $cmd = $con->prepare("SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as 
                                    dp_file_type, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 
                                    AND daily_post.is_delete=0 AND (daily_post.is_common_reel = 1 OR daily_post.faculty_id = '$faculty_id') AND daily_post.id <>'917' ORDER BY daily_post.date ");
                                       }
                                  
                                    $cmd->execute();
                                    $result = $cmd->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $file_type = $row['dp_file_type'];
                                        $dp_id = $row['dp_id'];
                                        $file = $row['dp_file'];

                                        if ($file_type == "image") {
                                            $type = "daily_post";
                                            $cmd2 = $con->prepare("SELECT sp.file_name as sp_file_name FROM tbl_site_photos as sp WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0");
                                            $cmd2->bind_param("is", $dp_id, $type);
                                            $cmd2->execute();
                                            $result2 = $cmd2->get_result();
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $file_name = $row2['sp_file_name'];
                                                echo '<img src="' . $upload_website_admin_url . 'daily_post/' . $file_name . '" 
                                                           alt="daily post" 
                                                           onclick="onClick(this)"
                                                           class="modal-ns-hover-opacity">';
                                            }
                                        }
                                    }
                                    ?>
                                </marquee>
                            </div>

                            <div id="modal01" class="modal-ns" onclick="this.style.display='none'" style="display: none;">
                                <span class="close" style="margin-top: 80px;">&times;</span>
                                <div style="top:55%;" class="modal-ns-content">
                                    <img id="img01" style="max-width: unset;">
                                </div>
                            </div>
                        </section>
                        <!-- cource-2 cards  -->
                        <!-- WHY STUDY AT GMIU? section -->
                        <section>
                            <h3 class="title gradText">WHY STUDY AT GMIU?</h3>
                            <hr>
                            <div class="courses-cards">

                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-user-graduate fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>HIGHEST PLACEMENT</h3>
                                        <p>Placement process GMIU is robust and transparent process which ensures that
                                            all student got equal chance in any placement drive according to their
                                            eligibility and skills expertise which match est with recruiters.</p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-sharp fa-solid fa-arrow-up-right-dots fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>SUPPORT TO START UP</h3>
                                        <p>A startup or start-up is a company or project undertaken by an entrepreneur
                                            to seek, develop, and validate a scalable business model. While
                                            entrepreneurship refers to all new businesses, including self-employment...
                                        </p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-graduation-cap fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>EXCELLENT ACADEMIC SYSTEM</h3>
                                        <p>providing excellent teaching learning process by highly qualified faculties.
                                            GMIU is known for the outstanding calibre of its students, well qualified
                                            faculty dedicated to teaching and research and excellent infrastructure.</p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-lightbulb fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>RESEARCH & INNOVATION (R&I)</h3>
                                        <p>Research and innovation (R&I) plays an essential role in triggering smart and
                                            sustainable growth and job creation. Research is an intrinsic aspect of the
                                            idea development process. Research helps guide numerous decisions that turn
                                            an idea into an innovation.</p>
                                    </div>
                                </div>

                            </div>
                        </section>
                         <div class="swiper-container" style="overflow:hidden; margin-left: auto; margin-right: auto; ">
                    <div class="swiper-wrapper">
                        <?php for ($i = 1; $i <= 15; $i++) { ?>
                            <div class="swiper-slide">
                                <img src="https://www.gmiu.edu.in/gmiu/website_assets/images/associates/p<?php echo $i; ?>.jpg" alt="Associate <?php echo $i; ?>">
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Swiper Pagination and Navigation -->
                    <div class="swiper-pagination"></div>
                </div>
                <style>
                    /* .swiper-container {
                        width: 80%;
                        padding: 20px;
                    } */

                    .swiper-slide img {
                        width: 100%;
                        height: auto;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    }
                    
                   .swiper-pagination {
                    margin-top: 20px !important; /* Adjust this value as needed */
                    position: relative !important; /* Ensure it doesn't overlap images */
                }
                .swiper-container {
                    padding-bottom: 40px !important; /* Adjust as per requirement */
                }


                    /*.swiper-pagination, .swiper-pagination-clickable, .swiper-pagination-bullets, .swiper-pagination-horizontal{*/
                    /*    margin-top: 20px !important;*/
                    /*}*/
                </style>
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
                                        <li>FACULTY</li>
                                        <?php
                                        $cmd = "SELECT `name` as faculty_name, faculty_slug, `id` as faculty_id FROM `tbl_faculty` WHERE is_active=1 AND is_delete=0";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <li><a href="<?php echo $base_url_website_faculty?><?php echo $row['faculty_slug']; ?>"><i class="fa-solid fa-arrow-right"></i>
                                                    <?php echo strtoupper($row['faculty_name']); ?>
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>

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
    <script src="<?php echo $website_assets_url; ?>js/custom.js"></script>
    <script src="<?php echo $website_assets_url; ?>js/home.js"></script>
     <script>
        var swiper = new Swiper('.swiper-container', {
            // slidesPerView: 3, // Show 3 images at a time
            // spaceBetween: 20, // Adjust spacing between slides
            loop: true,
            autoplay: {
                delay: 2000, // Change slide every 2 seconds
                disableOnInteraction: false
            },
            spaceBetween: 10,
            // Parameter for center active slide 
            centeredSlides: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    initialSlide: 1,
                    loopedSlides: 3
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                    initialSlide: 1,
                    loopedSlides: 3
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                    initialSlide: 1,
                    loopedSlides: 3
                }
            },
            on: {
                init: function() {
                    this.slideToLoop(1, 0);
                }
            }
        });
    </script>
</body>

</html>