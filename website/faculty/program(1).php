<?php

include '../../common/importwebsitefile.php';

if (isset($_GET['program_slug']) && !empty($_GET['program_slug'])) {
    $program_slug = mysqli_real_escape_string($con, $_GET['program_slug']);
    // $program_slug = only_digits($program_slug);
    if ($program_slug == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>";
    }

    //fetch program details
    $cmd = $con->prepare("SELECT level.name as level_name, program.name as program_name ,program.id as program_id,program.description as program_description from tbl_program as program LEFT JOIN tbl_level as level ON program.level_id = level.id
    WHERE program.program_slug=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("s", $program_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
        $program_id = $row['program_id'];
        $program_description = $row['program_description'];
        $level_name = $row['level_name'];
        
    } else {
        $program_name = "";
        $program_description = "";
    }
} else {
    $program_id = "";
    $program_name = "";
    $program_description = "";
}

if (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
    $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
    // $faculty_slug = only_digits($faculty_slug);
    if ($faculty_slug == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=https://gmiu.edu.in/'},1000)</script>";
    }

    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.name as faculty_name, faculty.id as faculty_id from tbl_faculty as faculty WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0");
    $cmd->bind_param("s", $faculty_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_id = $row['faculty_id'];
        $faculty_name = $row['faculty_name'];
    }elseif ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
        // Fetch faculty_description from the database where id = 1
        $query = $con->prepare("SELECT description FROM tbl_faculty WHERE id = 1");
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        $faculty_id = '1';
        $faculty_name = 'INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)';
        $faculty_description = $row['description'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
}


// Generate dynamic meta tags based on program_id and faculty_id
if (!empty($program_name)) {
   
    if ($program_id == 363 && $faculty_id == 2) {
        // Set meta tags for M. Pharmacy (Postgraduate) program
        $meta_description = "Explore pharmacy university programs, M. Pharmacy colleges in Bhavnagar and Gujarat, and online admission for pharmacy degrees. Learn about pharmaceutical science and medical science education.";
        $meta_keywords = "pharmacy university, pharmacy program, university admission, university program, pharmacy degree programs, education university, health care colleges, university apply online, university degree, teaching university, pharmacy bachelor degree, pharmacy study, medical science, pharmaceutical science degree, pharmacy course, science research, colleges and universities, education colleges, degree in pharmacy, student university, pharmaceutical course, best M. Pharmacy college in Bhavnagar, best M. Pharmacy college in Gujarat, best M. Pharmacy college near me, best M. Pharmacy college in my city, top pharmacy college, top pharmacy college in Bhavnagar, top pharmacy college in Gujarat, top pharmacy college near me, top pharmacy college in my city, top M. Pharmacy college in Bhavnagar, top M. Pharmacy college in Gujarat, top M. Pharmacy college near me, top M. Pharmacy college in my city";
    } elseif ($program_id == 119 && $faculty_id == 2) {
        // Set meta tags for B. Pharmacy (Undergraduate) program
        $meta_description = "Explore top pharmacy courses, undergraduate degree programs, and the best B. Pharmacy colleges in Bhavnagar, Gujarat, and nearby cities. Apply online for university degrees and pharmacy studies.";
        $meta_keywords = "pharmacy course, undergraduate degree, university course, pharmacy study, bachelor degree programs, undergraduate program, bachelor degree courses, undergraduate degree programs, university apply online, degree online, education university, best pharmacy college, best pharmacy college in Bhavnagar, best pharmacy college in Gujarat, best pharmacy college near me, best pharmacy college in my city, best B. Pharmacy college in Bhavnagar, best B. Pharmacy college in Gujarat, best B. Pharmacy college near me, best B. Pharmacy college in my city, top pharmacy college, top pharmacy college in Bhavnagar, top pharmacy college in Gujarat, top pharmacy college near me, top pharmacy college in my city, top B. Pharmacy college in Bhavnagar, top B. Pharmacy college in Gujarat, top B. Pharmacy college near me, top B. Pharmacy college in my city";
    }elseif ($program_id == 21 && $faculty_id == 1) {
    // Set meta tags for Civil Engineering program
    $meta_description = "Explore comprehensive civil engineering courses, including diplomas and degree programs, at our engineering university. Learn about construction engineering, structural engineering, and the skills needed for a successful career in civil engineering.";
    $meta_keywords = "civil engineering, construction engineering, civil engineering diploma, civil engineering course, engineering diploma, engineering university, structural engineering, best civil engineering colleges, civil engineering education, civil engineering programs, online civil engineering courses, civil engineering degree, top civil engineering college in Bhavnagar, top civil engineering college in Gujarat, civil engineering near me";
}
elseif ($program_id == 22 && $faculty_id == 1) {
    // Set meta tags for Mechanical Engineering program
    $meta_description = "Discover our Mechanical Engineering program, offering comprehensive courses including diplomas and degrees. Join our mechanical engineering university to explore manufacturing engineering, mechanical engineering programs, and pursue your career in engineering.";
    $meta_keywords = "mechanical engineering, mechanical engineering degree, mechanical engineering diploma, degree courses, mechanical engineering university, mechanical engineering programs, mechanical degree, mechanical university, manufacturing engineering, mechanical engineering degree programs, mechanical engineering bachelor degree, B.Tech mechanical engineering, top mechanical engineering colleges, mechanical engineering education, mechanical engineering near me";
}
elseif ($program_id == 23 && $faculty_id == 1) {
    // Set meta tags for Information Technology program
    $meta_description = "Explore our Information Technology program, offering diploma courses, degree programs, and certificate courses. Join our university to gain essential skills in IT, including business information technology and hands-on training in the latest technologies.";
    $meta_keywords = "information technology, information technology diploma, diploma course, degree courses, university information, information technology program, business information technology, information technology course, information technology certificate course, IT information technology, information technology university, information technology certificate programs, top IT universities, IT education, information technology career opportunities";
}
elseif ($program_id == 24 && $faculty_id == 1) {
    // Set meta tags for Electrical Engineering program
    $meta_description = "Discover our Electrical Engineering program, featuring comprehensive courses, diplomas, and specialized certificate courses. Join our electrical engineering university to learn about electrical systems, circuits, and the latest technologies in the field.";
    $meta_keywords = "electrical engineering, electrical engineering course, engineering diploma, electrical engineering program, electrical engineering diploma, electrical engineering university, electrical engineering curriculum, electrical certificate course, electrical engineering education, top electrical engineering colleges, electrical engineering career opportunities, electrical engineering near me";
}
elseif ($program_id == 25 && $faculty_id == 1) {
    // Set meta tags for Computer Engineering program
    $meta_description = "Explore our Computer Engineering program, offering comprehensive courses, diplomas, and online degrees. Join our software engineering university to gain expertise in software development, computer systems, and cutting-edge technologies.";
    $meta_keywords = "computer engineering, computer engineering course, engineering diploma, software engineering, computer engineer programs, software engineering program, software engineer diploma, computer engineering diploma, software engineer university, software engineering course, computer programs, computer engineering degree online, computer engineering certificate programs, top computer engineering colleges, computer engineering education, software development";
}
elseif ($program_id == 118 && $faculty_id == 1) {
    // Set meta tags for Chemical Engineering program
    $meta_description = "Discover our Chemical Engineering program, offering a range of courses, bachelor's degrees, and certificate programs. Join our chemical engineering university to explore environmental engineering and gain the knowledge needed for a successful career in chemical processes.";
    $meta_keywords = "chemical engineering, chemical engineering degree, university certificate programs, chemical engineering course, environmental engineering, bachelor degree programs, chemical engineering programs, engineering curriculum, chemical engineering curriculum, bachelor degree in engineering, chemical engineering university, chemical engineering bachelor degree, top chemical engineering colleges, chemical engineering education, chemical process engineering";
}
elseif ($program_id == 189 && $faculty_id == 1) {
    // Set meta tags for Costume Design program
    $meta_description = "Explore our Costume Design courses, including diploma and degree programs in fashion designing. Join our design university to learn about computer-aided design and the latest trends in fashion.";
    $meta_keywords = "costume design courses, fashion designing course, fashion designing, diploma course, computer aided design, design university, degree courses, fashion design education, fashion design diploma, top fashion design colleges";
}
elseif ($program_id == 190 && $faculty_id == 1) {
    // Set meta tags for Interior Design program
    $meta_description = "Join our Interior Design diploma course to gain skills in interior design, decoration, and space planning. Explore our interior design bachelor degree and certificate programs at our design university.";
    $meta_keywords = "interior design diploma course, interior design, interior design diploma, interior design course, interior design bachelor degree, interior design certificate course, interior design certificate programs, design diploma, interior design university, interior design course university, interior design class, interior design study, interior design degree programs, degree in interior design, certificate in interior design, designing courses, diploma programs, diploma in fashion designing";
}
elseif ($program_id == 213 && $faculty_id == 1) {
    // Set meta tags for Electronics and Communication Engineering program
    $meta_description = "Discover our Electronics and Communication Engineering program, featuring comprehensive courses in electronics and communication. Join our engineering classes to explore career opportunities in this dynamic field.";
    $meta_keywords = "electronics and communication engineering, communication course, electronic engineering, electronics courses, electronic engineering courses, communication engineering, electronics engineering degree programs, engineering class, top electronics engineering colleges, electronics education";
}

elseif ($program_id == 365 && $faculty_id == 26) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU's program offerings in the Faculty of Management, designed to prepare students for leadership roles in the business world with practical skills.";
    
    $meta_keywords = "university admission, degree courses, university program, university study, faculty of law, top law college in bhavnagar, top law college in gujarat, top llb college in bhavnagar, top llb college in gujarat, best law college in bhavnagar, best law college in gujarat, best llb college in bhavnagar, best llb college in gujarat";
}

elseif ($program_id == 185 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Learn about the GMIU program offered under the Faculty of [Faculty Name] – providing in-depth knowledge, hands-on experience, and career-focused education.";
   $pageTitle ="Diploma + B.Tech (6-Years) - Gyanmanjari Innovative University | GMIU";
}

elseif ($program_id == 341 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore the GMIU program under the Faculty of [Faculty Name] – designed to offer specialized knowledge, practical skills, and excellent career opportunities for students.";
   $pageTitle ="BBA + B.Com (Dual Degree) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 362 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore the GMIU program under the Faculty of [Faculty Name] – offering specialized education, practical skills, and career opportunities in [Program Field].";
   $pageTitle ="B.Pharm + Fashion Designing (Dual Degree) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 346 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover the GMIU program under the Faculty of [Faculty Name] – providing expert knowledge, hands-on experience, and career opportunities in [Program Field].";
   $pageTitle ="B.Com + Fashion Designing (Dual Degree) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 337 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Learn about GMIU's program under the Faculty of [Faculty Name] – offering specialized courses designed to equip students with industry-relevant skills and knowledge.";
   $pageTitle ="B.Sc + Bio Tech Dual Degree - Gyanmanjari Innovative University (GMIU)";
}
elseif ($program_id == 180 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's program under the Faculty of [Faculty Name] – offering cutting-edge courses designed to provide students with skills for success in their careers.";
   $pageTitle ="BBA + MBA (UG + PG) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 358 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover the program details for the course under Faculty of [Faculty Name] at GMIU. Enhance your skills with academic excellence and practical knowledge.";
   $pageTitle ="B.Pharm + BA (Archaeology, Public Admin, Journalism) - GMIU";
}
elseif ($program_id == 355 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore the program offered under the Faculty of [Faculty Name] at GMIU. Gain valuable skills and knowledge for a successful career in your field.";
   $pageTitle ="BA + Fashion Designing Dual Degree - Gyanmanjari Innovative University";
}
elseif ($program_id == 334 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore the details of the program under the Faculty of [Faculty Name] at GMIU. Learn about the curriculum and opportunities to advance your career.";
   $pageTitle ="B.Sc + BBA (Fintech, Digital Marketing, Agri Business) - GMIU";
}
elseif ($program_id == 339 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover the program offerings under the Faculty of [Faculty Name] at GMIU. Learn about course details, career prospects, and how to apply.";
   $pageTitle ="BBA + BA (Archaeology, Public Admin, Journalism) - Gyanmanjari University";
}
elseif ($program_id == 176 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore the [Program Name] offered by the Faculty of [Faculty Name] at GMIU. Get details on curriculum, career opportunities, and the admission process.";
   $pageTitle ="B.Com + M.Com (UG + PG) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 208 && $faculty_id == 19) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover the [Program Name] at GMIU, designed to provide in-depth knowledge and practical skills in [Faculty Name]. Elevate your career with quality education.";
   $pageTitle ="PhD in Arts - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 344 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover the detailed program offered by GMIU, designed to provide students with comprehensive knowledge and skills in their respective fields of study.";
   $pageTitle ="B.Com + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU";
}
elseif ($program_id == 349 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover the program offerings at GMIU, designed to provide comprehensive education and practical knowledge in various fields for a successful career.";
   $pageTitle ="BCA + B.Com (Finance, Banking, Marketing & Management) - GMIU";
}
elseif ($program_id == 350 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's program details for specialized courses under the faculty of engineering, designed to equip students with the skills for successful careers.";
   $pageTitle ="BCA + Fashion Designing Dual Degree - Gyanmanjari University | GMIU";
}
elseif ($program_id == 365 && $faculty_id == 26) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU's program offerings in the Faculty of Management, designed to prepare students for leadership roles in the business world with practical skills.";
   $pageTitle ="LL.B. Undergraduate Program - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 210 && $faculty_id == 19) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's comprehensive program designed to enhance practical skills, foster industry connections, and prepare students for a successful career in their chosen field.";
   $pageTitle ="PhD in Management - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 183 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover the innovative program at GMIU designed to enrich student learning with industry visits, providing practical insights and fostering professional skills development.";
   $pageTitle ="B.Tech + MBA (UG + PG) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 179 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Enhance your academic journey with GMIU's program, combining in-depth learning, industry exposure, and skill-building opportunities to prepare students for future success.";
   $pageTitle ="BCA + MCA (UG + PG) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 348 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's program offering focused on skill development, industry insights, and real-world applications, designed to enhance students' academic and professional growth.";
   $pageTitle ="BCA + BBA (Fintech, Digital Marketing, Agri Business) - GMIU";
}
elseif ($program_id == 330 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU's program designed to enhance students' skills with practical learning experiences, industry insights, and opportunities for career advancement.";
   $pageTitle ="B.Tech + B.Com (Finance, Banking, Marketing & Management) - GMIU";
}
elseif ($program_id == 360 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's program offering valuable industry insights, fostering skill development, and enhancing students' practical knowledge to boost their career readiness.";
    
   $pageTitle ="B.Pharm + B.Com (Finance, Banking, Marketing & Management) - GMIU";
}
elseif ($program_id == 351 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's program designed to provide students with comprehensive academic and practical insights, fostering skill development and industry readiness for career success.";
    
   $pageTitle ="BBA + BA (Archaeology, Public Admin, Journalism) - GMIU";
}
elseif ($program_id == 347 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's program focused on providing students with industry exposure and practical learning opportunities, bridging the gap between academia and professional environments.";
    
   $pageTitle ="BCA + BA (Archaeology, Public Admin, Journalism) - GMIU";
}
elseif ($program_id == 332 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's specialized program, designed to bridge academic learning with real-world industry applications. Enhance your skills, gain practical insights, and prepare for success.";
   $pageTitle ="B.Tech + Fashion Designing Dual Degree - Gyanmanjari University | GMIU";
}
elseif ($program_id == 184 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's comprehensive program focused on academic excellence and industry exposure. Led by experienced faculty, this program prepares students for a successful career.";
    
   $pageTitle ="B.Tech + M.Tech (All Branches) UG + PG - Gyanmanjari University | GMIU";
}
elseif ($program_id == 178 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Enhance your learning experience with GMIU's program led by experienced faculty. Gain in-depth knowledge and practical skills that are essential for your career growth.";
    
   $pageTitle ="BA + MSW (UG + PG) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 331 && $faculty_id == 22)    { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's program that focuses on skill-building, industry exposure, and practical learning to prepare students for successful careers. Learn more about the curriculum.";
    
   $pageTitle ="B.Tech + B.Sc (Physics, Chemistry, Zoology, Microbiology) - GMIU";
}
elseif ($program_id == 353 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU's program focusing on developing critical skills, hands-on experiences, and industry insights, empowering students for successful professional careers.";
    
   $pageTitle ="BBA + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU";
}
elseif ($program_id == 352 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's program offering a comprehensive curriculum focused on skill-building, practical knowledge, and industry expertise to shape your professional growth.";
    
   $pageTitle ="BBA + B.Com (Finance, Banking, Marketing & Startup) - GMIU";
}
elseif ($program_id == 177 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU's innovative program designed to enhance learning with a strong focus on practical application, industry insights, and skill development.";
   $pageTitle ="B.Com + M.Com (Special Program) UG + PG - Gyanmanjari University | GMIU";
}
elseif ($program_id == 333 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover the diverse programs offered at GMIU under the guidance of expert faculty. Enhance your knowledge and skills to excel in your career with industry-relevant courses.";
   $pageTitle ="B.Sc + BA (Archaeology, Public Admin, Journalism) - GMIU";
}
elseif ($program_id == 354 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s specialized programs under expert faculty guidance, designed to enhance skills and prepare students for a successful career in their chosen fields.";
   $pageTitle ="BBA + Fashion Designing Dual Degree - Gyanmanjari University | GMIU";
}
elseif ($program_id == 241 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's academic program designed by expert faculty to provide comprehensive knowledge and skills. Join us to advance your career in this specialized field.";
   $pageTitle ="BSW + MSW (UG + PG) - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 345 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU’s program offering under the guidance of experienced faculty. Equip yourself with the knowledge and skills needed for a successful career in your field.";
   $pageTitle ="B.Com + BBA (Fintech, Business Analysis, Agri Business) - GMIU";
}
elseif ($program_id == 340 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s specialized program, offering students expert guidance and practical knowledge to enhance their skills and prepare them for career success.";
   $pageTitle ="BBA + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU";
}
elseif ($program_id == 361 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU’s specialized program offering students in-depth knowledge and practical skills, guided by expert faculty, for successful career advancement.";
   $pageTitle ="B.Pharm + Bio Tech Dual Degree - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 211 && $faculty_id == 19) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s program designed to offer students specialized knowledge and skills, guided by expert faculty, preparing them for success in their careers.";
   $pageTitle ="PhD in Computer Application - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 359 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s program offering specialized knowledge and skills under expert faculty guidance, preparing students for a successful career in their chosen field.";
   $pageTitle ="B.Pharm + BBA (Fintech, Business Analysis, Agri Business) - GMIU";
}
elseif ($program_id == 262 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU's program designed to enhance student expertise with practical skills, fostering professional growth and academic excellence under expert faculty guidance.";
   $pageTitle ="B.Tech + BBA (Fintech, Business Analysis, Agri Business) - GMIU";
}
elseif ($program_id == 338 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s tailored program designed to equip students with vital skills and knowledge, guided by expert faculty to prepare them for successful careers.";
   $pageTitle ="B.Sc + Fashion Designing Dual Degree - Gyanmanjari University | GMIU";
}
elseif ($program_id == 209 && $faculty_id == 19) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU’s specialized program offering key skills and practical insights, guided by expert faculty to ensure students’ success in their chosen careers.";
   $pageTitle ="PhD in Commerce - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 181 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s specialized program designed to provide students with key skills, knowledge, and real-world exposure, guided by expert faculty for career success.";
   $pageTitle ="BBA + MBA (Special Program) UG + PG - Gyanmanjari University | GMIU";
}
elseif ($program_id == 261 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU’s specialized program, designed to equip students with essential skills and knowledge for a successful career, guided by expert faculty.";
   $pageTitle ="B.Tech + BA (Archaeology, Public Admin, Journalism) - GMIU";
}
elseif ($program_id == 274 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s specialized program offering essential skills and knowledge for career success, guided by expert faculty to prepare students for the professional world.";
   $pageTitle ="B.Tech + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU";
}
elseif ($program_id == 207 && $faculty_id == 19) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Discover GMIU’s specialized program, offering in-depth knowledge and practical skills, guided by expert faculty to ensure your success in a competitive career field.";
   $pageTitle ="PhD in Science - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 335 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s specialized program designed to equip students with essential skills and knowledge, led by expert faculty to prepare them for successful careers.";
   $pageTitle ="B.Sc + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU";
}
elseif ($program_id == 356 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s specialized program, providing students with essential skills and knowledge to succeed in their field, guided by expert faculty for career growth.";
   $pageTitle ="Bio Tech + B.Sc (Physics, Chemistry, Zoology, Micro) - GMIU";
}
elseif ($program_id == 343 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's specialized program, offering students expert-led training and skills to succeed in their field, preparing them for a bright career ahead.";
   $pageTitle ="B.Com + BA (Archaeology, Public Admin, Journalism) - GMIU";
}
elseif ($program_id == 174 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU's specialized program designed to equip students with essential skills and knowledge, guided by expert faculty for a successful career in the field.";
   $pageTitle ="BA + MA (Special Program) UG + PG - Gyanmanjari University | GMIU";
}
elseif ($program_id == 342 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s program offering specialized knowledge and skills, led by expert faculty, designed to prepare students for successful careers in their field of study.";
   $pageTitle ="BBA + Fashion Designing Dual Degree - Gyanmanjari University | GMIU";
}
elseif ($program_id == 206 && $faculty_id == 19) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s specialized program designed to provide students with essential skills and knowledge, guided by expert faculty for successful career growth.";
   $pageTitle ="PhD in Engineering - Gyanmanjari Innovative University | GMIU";
}
elseif ($program_id == 336 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s specialized program, offering in-depth knowledge and practical skills, led by expert faculty to prepare students for successful careers in their field.";
   $pageTitle ="B.Sc + B.Com (Finance, Banking, Marketing & Startup) - GMIU";
}
elseif ($program_id == 357 && $faculty_id == 22) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore GMIU’s program led by expert faculty, designed to provide students with specialized knowledge and practical skills, preparing them for successful careers.";
   $pageTitle ="Bio Tech + Fashion Designing Dual Degree - Gyanmanjari University | GMIU";
}
elseif ($program_id == 173 && $faculty_id == 18) { // Assuming faculty_id 26 is for the relevant program
    $meta_description = "Explore the details of the specialized program at GMIU, led by expert faculty, designed to equip students with industry-relevant knowledge and skills for success.";
   $pageTitle ="BA + MA (UG + PG) - Gyanmanjari Innovative University | GMIU";
}

}





?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
      <?php
    echo '<meta name="description" content="' . htmlspecialchars($meta_description)  . '">' . "\n";
    echo '<meta name="keywords" content="' . htmlspecialchars($meta_keywords) . '">' . "\n";
    ?>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
      <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
     <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/font-awesome.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        .des p {
            margin: 0px 0px !important;
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
        .modal-ns {
             z-index: 999999;
        }
        .sideBar ul li a:hover, .sideBar ul li a.active {
            background: #ba2a21;
            color: #fff !important;
            transform: none;
            padding-left: 25px;
        }
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
                .sideBar ul li a[data-toggle=collapse]:not(.collapsed) {
    padding-left: 25px;
    border: 1px solid #ba2a21;
    background: rgba(255, 153, 51, 0.15);
    color: unset !important;
}
    </style>
      <script>
        document.documentElement.style.setProperty('--main-color', '#ba2a21'); // Change color dynamically
    </script>
</head>

<body class="courses">
    <!--   Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1><?php echo $program_name.' ('.$level_name .')'; ?></h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="../<?php echo $faculty_slug ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#"><?php echo $program_name.' ('.$level_name .')'; ?></a></span>
                </p>
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
                            <h3 class="title gradText">About <?php echo $program_name.' ('.$level_name .')'; ?></h3>
                            <hr>
                            <p style="margin: 0px 0px;"><?php echo htmlspecialchars_decode($program_description) ?></p>

                        </section>

                        <!--  <section class="video-content">
                            <h3 class="title gradText">Video About Department</h3>
                            <hr>
                            <div class="video">
                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/ZGO5Q8H3pwQ"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                        </section>


                        <section class="links-card">
                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                            <hr>
                            <div class="cards-container">
                                <div class="card">
                                    <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                    <p>Admission Process</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-book"></i>
                                    <p>Brochure</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-question"></i>
                                    <p>FAQ</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-building"></i>
                                    <p>Hostel Facility</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-street-view"></i>
                                    <p>360 tour link</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-link"></i>
                                    <p>Apply Online</p>
                                </div>
                            </div>
                        </section>

                        <section class="links-card" style="margin-bottom : 35px"> 
                        <h3 class="title gradText">UNIQUE FEATURES OF OUR DEPARTMENT</h3>
                        <hr>
                        <div class="cards-container">
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>Advance Laboratories</p>
                            </div>
                            <div class="card">
                                <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px"
                                    class="center">
                                <p>Excellent Academic System</p>
                            </div>
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>SDP</p>
                            </div>
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>National/lnternational Association</p>
                            </div>
                        </div>
                        </section>-->

                        <!-- why study at gmiu -->
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
                    </div>
                    <div class="row" id="media_coverage">
                            <div class="col-sm-12 section-header-box">
                                <div class="">
                                    <h3 class="title gradText" style="color:#921d2d">SHORT REELS</h3>
                                    <hr>
                                </div>
                                <!-- ends: .section-header -->
                            </div>
                        </div>
                        <div class="swiper-container" style="overflow:hidden; margin-left: auto; margin-right: auto; ">
                            <div class="swiper-wrapper">

                                <?php
                                  
                                if ($program_slug == 'under-graduation-computer-engineering') {
                                  
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
                                  $cmd =
                                        "SELECT `file_type`, `file` FROM `tbl_media_coverage` WHERE file_type = 'reel' AND is_active = 1 AND is_delete = 0 AND faculty_id = '$faculty_id' and program_id = '$program_id' ORDER BY id DESC LIMIT 10";
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
                                    AND daily_post.is_delete=0 AND ( daily_post.is_common_reel = 1  OR (daily_post.faculty_id = '$faculty_id' AND daily_post.program_id = '$program_id') )  ORDER BY daily_post.date ");
                                       }
                                       else{
                                             $cmd = $con->prepare("SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as 
                                    dp_file_type, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 
                                    AND daily_post.is_delete=0 AND ( daily_post.is_common_reel = 1  OR (daily_post.faculty_id = '$faculty_id' AND daily_post.program_id = '$program_id') ) AND daily_post.id <>'917' ORDER BY daily_post.date  ");
                                       }
                                   
                                    $cmd->execute();
                                    $result1 = $cmd->get_result();

                                    while ($row = $result1->fetch_assoc()) {
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
                <!-- left bar end  -->

                <!-- right bar start  -->
                
                <?php include '../include/importrightsidebar.php' ?>
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