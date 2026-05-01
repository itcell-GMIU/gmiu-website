UPDATE tbl_program
SET 
    meta_description = CASE id
        WHEN 363 THEN 'Explore pharmacy university programs, M. Pharmacy colleges in Bhavnagar and Gujarat, and online admission for pharmacy degrees. Learn about pharmaceutical science and medical science education.'
        WHEN 119 THEN 'Explore top pharmacy courses, undergraduate degree programs, and the best B. Pharmacy colleges in Bhavnagar, Gujarat, and nearby cities. Apply online for university degrees and pharmacy studies.'
        WHEN 21 THEN 'Explore comprehensive civil engineering courses, including diplomas and degree programs, at our engineering university. Learn about construction engineering, structural engineering, and the skills needed for a successful career in civil engineering.'
        WHEN 22 THEN 'Discover our Mechanical Engineering program, offering comprehensive courses including diplomas and degrees. Join our mechanical engineering university to explore manufacturing engineering, mechanical engineering programs, and pursue your career in engineering.'
        WHEN 23 THEN 'Explore our Information Technology program, offering diploma courses, degree programs, and certificate courses. Join our university to gain essential skills in IT, including business information technology and hands-on training in the latest technologies.'
        WHEN 24 THEN 'Discover our Electrical Engineering program, featuring comprehensive courses, diplomas, and specialized certificate courses. Join our electrical engineering university to learn about electrical systems, circuits, and the latest technologies in the field.'
        WHEN 25 THEN 'Explore our Computer Engineering program, offering comprehensive courses, diplomas, and online degrees. Join our software engineering university to gain expertise in software development, computer systems, and cutting-edge technologies.'
        WHEN 118 THEN 'Discover our Chemical Engineering program, offering a range of courses, bachelor''s degrees, and certificate programs. Join our chemical engineering university to explore environmental engineering and gain the knowledge needed for a successful career in chemical processes.'
        WHEN 189 THEN 'Explore our Costume Design courses, including diploma and degree programs in fashion designing. Join our design university to learn about computer-aided design and the latest trends in fashion.'
        WHEN 190 THEN 'Join our Interior Design diploma course to gain skills in interior design, decoration, and space planning. Explore our interior design bachelor degree and certificate programs at our design university.'
        WHEN 213 THEN 'Discover our Electronics and Communication Engineering program, featuring comprehensive courses in electronics and communication. Join our engineering classes to explore career opportunities in this dynamic field.'
        WHEN 365 THEN 'Discover GMIU''s program offerings in the Faculty of Management, designed to prepare students for leadership roles in the business world with practical skills.'
        WHEN 185 THEN 'Learn about the GMIU program offered under the Faculty of [Faculty Name] – providing in-depth knowledge, hands-on experience, and career-focused education.'
        WHEN 341 THEN 'Explore the GMIU program under the Faculty of [Faculty Name] – designed to offer specialized knowledge, practical skills, and excellent career opportunities for students.'
        WHEN 362 THEN 'Explore the GMIU program under the Faculty of [Faculty Name] – offering specialized education, practical skills, and career opportunities in [Program Field].'
        WHEN 346 THEN 'Discover the GMIU program under the Faculty of [Faculty Name] – providing expert knowledge, hands-on experience, and career opportunities in [Program Field].'
        WHEN 337 THEN 'Learn about GMIU''s program under the Faculty of [Faculty Name] – offering specialized courses designed to equip students with industry-relevant skills and knowledge.'
        WHEN 180 THEN 'Explore GMIU''s program under the Faculty of [Faculty Name] – offering cutting-edge courses designed to provide students with skills for success in their careers.'
        WHEN 358 THEN 'Discover the program details for the course under Faculty of [Faculty Name] at GMIU. Enhance your skills with academic excellence and practical knowledge.'
        WHEN 355 THEN 'Explore the program offered under the Faculty of [Faculty Name] at GMIU. Gain valuable skills and knowledge for a successful career in your field.'
        ELSE meta_description
    END,

    meta_keywords = CASE id
        WHEN 363 THEN 'pharmacy university, pharmacy program, university admission, university program, pharmacy degree programs, education university, health care colleges, university apply online, university degree, teaching university, pharmacy bachelor degree, pharmacy study, medical science, pharmaceutical science degree, pharmacy course, science research, colleges and universities, education colleges, degree in pharmacy, student university, pharmaceutical course, best M. Pharmacy college in Bhavnagar, best M. Pharmacy college in Gujarat, best M. Pharmacy college near me, best M. Pharmacy college in my city, top pharmacy college, top pharmacy college in Bhavnagar, top pharmacy college in Gujarat, top pharmacy college near me, top pharmacy college in my city, top M. Pharmacy college in Bhavnagar, top M. Pharmacy college in Gujarat, top M. Pharmacy college near me, top M. Pharmacy college in my city'
        WHEN 119 THEN 'pharmacy course, undergraduate degree, university course, pharmacy study, bachelor degree programs, undergraduate program, bachelor degree courses, undergraduate degree programs, university apply online, degree online, education university, best pharmacy college, best pharmacy college in Bhavnagar, best pharmacy college in Gujarat, best pharmacy college near me, best pharmacy college in my city, best B. Pharmacy college in Bhavnagar, best B. Pharmacy college in Gujarat, best B. Pharmacy college near me, best B. Pharmacy college in my city, top pharmacy college, top pharmacy college in Bhavnagar, top pharmacy college in Gujarat, top pharmacy college near me, top pharmacy college in my city, top B. Pharmacy college in Bhavnagar, top B. Pharmacy college in Gujarat, top B. Pharmacy college near me, top B. Pharmacy college in my city'
        WHEN 21 THEN 'civil engineering, construction engineering, civil engineering diploma, civil engineering course, engineering diploma, engineering university, structural engineering, best civil engineering colleges, civil engineering education, civil engineering programs, online civil engineering courses, civil engineering degree, top civil engineering college in Bhavnagar, top civil engineering college in Gujarat, civil engineering near me'
        WHEN 22 THEN 'mechanical engineering, mechanical engineering degree, mechanical engineering diploma, degree courses, mechanical engineering university, mechanical engineering programs, mechanical degree, mechanical university, manufacturing engineering, mechanical engineering degree programs, mechanical engineering bachelor degree, B.Tech mechanical engineering, top mechanical engineering colleges, mechanical engineering education, mechanical engineering near me'
        WHEN 23 THEN 'information technology, information technology diploma, diploma course, degree courses, university information, information technology program, business information technology, information technology course, information technology certificate course, IT information technology, information technology university, information technology certificate programs, top IT universities, IT education, information technology career opportunities'
        WHEN 24 THEN 'electrical engineering, electrical engineering course, engineering diploma, electrical engineering program, electrical engineering diploma, electrical engineering university, electrical engineering curriculum, electrical certificate course, electrical engineering education, top electrical engineering colleges, electrical engineering career opportunities, electrical engineering near me'
        WHEN 25 THEN 'computer engineering, computer engineering course, engineering diploma, software engineering, computer engineer programs, software engineering program, software engineer diploma, computer engineering diploma, software engineer university, software engineering course, computer programs, computer engineering degree online, computer engineering certificate programs, top computer engineering colleges, computer engineering education, software development'
        WHEN 118 THEN 'chemical engineering, chemical engineering degree, university certificate programs, chemical engineering course, environmental engineering, bachelor degree programs, chemical engineering programs, engineering curriculum, chemical engineering curriculum, bachelor degree in engineering, chemical engineering university, chemical engineering bachelor degree, top chemical engineering colleges, chemical engineering education, chemical process engineering'
        WHEN 189 THEN 'costume design courses, fashion designing course, fashion designing, diploma course, computer aided design, design university, degree courses, fashion design education, fashion design diploma, top fashion design colleges'
        WHEN 190 THEN 'interior design diploma course, interior design, interior design diploma, interior design course, interior design bachelor degree, interior design certificate course, interior design certificate programs, design diploma, interior design university, interior design course university, interior design class, interior design study, interior design degree programs, degree in interior design, certificate in interior design, designing courses, diploma programs, diploma in fashion designing'
        WHEN 213 THEN 'electronics and communication engineering, communication course, electronic engineering, electronics courses, electronic engineering courses, communication engineering, electronics engineering degree programs, engineering class, top electronics engineering colleges, electronics education'
        WHEN 365 THEN 'university admission, degree courses, university program, university study, faculty of law, top law college in bhavnagar, top law college in gujarat, top llb college in bhavnagar, top llb college in gujarat, best law college in bhavnagar, best law college in gujarat, best llb college in bhavnagar, best llb college in gujarat'
        ELSE meta_keywords
    END,

    pageTitle = CASE id
        WHEN 185 THEN 'Diploma + B.Tech (6-Years) - Gyanmanjari Innovative University | GMIU'
        WHEN 341 THEN 'BBA + B.Com (Dual Degree) - Gyanmanjari Innovative University | GMIU'
        WHEN 362 THEN 'B.Pharm + Fashion Designing (Dual Degree) - Gyanmanjari Innovative University | GMIU'
        WHEN 346 THEN 'B.Com + Fashion Designing (Dual Degree) - Gyanmanjari Innovative University | GMIU'
        WHEN 337 THEN 'B.Sc + Bio Tech Dual Degree - Gyanmanjari Innovative University (GMIU)'
        WHEN 180 THEN 'BBA + MBA (UG + PG) - Gyanmanjari Innovative University | GMIU'
        WHEN 358 THEN 'B.Pharm + BA (Archaeology, Public Admin, Journalism) - GMIU'
        WHEN 355 THEN 'BA + Fashion Designing Dual Degree - Gyanmanjari Innovative University'
        WHEN 363 THEN 'M. Pharmacy (Postgraduate) - Gyanmanjari Innovative University | GMIU'
        WHEN 119 THEN 'B. Pharmacy (Undergraduate) - Gyanmanjari Innovative University | GMIU'
        ELSE pageTitle
    END
WHERE id IN (363, 119, 21, 22, 23, 24, 25, 118, 189, 190, 213, 365, 185, 341, 362, 346, 337, 180, 358, 355);

UPDATE tbl_program
SET 
    meta_description = CASE 
        WHEN id = 334 THEN 'Explore the details of the program under the Faculty of [Faculty Name] at GMIU. Learn about the curriculum and opportunities to advance your career.'
        WHEN id = 339 THEN 'Discover the program offerings under the Faculty of [Faculty Name] at GMIU. Learn about course details, career prospects, and how to apply.'
        WHEN id = 176 THEN 'Explore the [Program Name] offered by the Faculty of [Faculty Name] at GMIU. Get details on curriculum, career opportunities, and the admission process.'
        WHEN id = 208 THEN 'Discover the [Program Name] at GMIU, designed to provide in-depth knowledge and practical skills in [Faculty Name]. Elevate your career with quality education.'
        WHEN id = 344 THEN 'Discover the detailed program offered by GMIU, designed to provide students with comprehensive knowledge and skills in their respective fields of study.'
        WHEN id = 349 THEN 'Discover the program offerings at GMIU, designed to provide comprehensive education and practical knowledge in various fields for a successful career.'
        WHEN id = 350 THEN 'Explore GMIU\s program details for specialized courses under the faculty of engineering, designed to equip students with the skills for successful careers.'
        WHEN id = 365 THEN 'Discover GMIU\s program offerings in the Faculty of Management, designed to prepare students for leadership roles in the business world with practical skills.'
        WHEN id = 210 THEN 'Explore GMIU\s comprehensive program designed to enhance practical skills, foster industry connections, and prepare students for a successful career in their chosen field.'
        WHEN id = 183 THEN 'Discover the innovative program at GMIU designed to enrich student learning with industry visits, providing practical insights and fostering professional skills development.'
        WHEN id = 179 THEN 'Enhance your academic journey with GMIU\s program, combining in-depth learning, industry exposure, and skill-building opportunities to prepare students for future success.'
        WHEN id = 348 THEN 'Explore GMIU\s program offering focused on skill development, industry insights, and real-world applications, designed to enhance students\ academic and professional growth.'
        WHEN id = 330 THEN 'Discover GMIU\s program designed to enhance students\ skills with practical learning experiences, industry insights, and opportunities for career advancement.'
        WHEN id = 360 THEN 'Explore GMIU\s program offering valuable industry insights, fostering skill development, and enhancing students\ practical knowledge to boost their career readiness.'
        WHEN id = 351 THEN 'Explore GMIU\s program designed to provide students with comprehensive academic and practical insights, fostering skill development and industry readiness for career success.'
        WHEN id = 347 THEN 'Explore GMIU\s program focused on providing students with industry exposure and practical learning opportunities, bridging the gap between academia and professional environments.'
        WHEN id = 332 THEN 'Explore GMIU\s specialized program, designed to bridge academic learning with real-world industry applications. Enhance your skills, gain practical insights, and prepare for success.'
        WHEN id = 184 THEN 'Explore GMIU\s comprehensive program focused on academic excellence and industry exposure. Led by experienced faculty, this program prepares students for a successful career.'
        WHEN id = 178 THEN 'Enhance your learning experience with GMIU\s program led by experienced faculty. Gain in-depth knowledge and practical skills that are essential for your career growth.'
        WHEN id = 331 THEN 'Explore GMIU\s program that focuses on skill-building, industry exposure, and practical learning to prepare students for successful careers. Learn more about the curriculum.'
        WHEN id = 353 THEN 'Discover GMIU\s program focusing on developing critical skills, hands-on experiences, and industry insights, empowering students for successful professional careers.'
        WHEN id = 352 THEN 'Explore GMIU\s program offering a comprehensive curriculum focused on skill-building, practical knowledge, and industry expertise to shape your professional growth.'
        WHEN id = 177 THEN 'Discover GMIU\s innovative program designed to enhance learning with a strong focus on practical application, industry insights, and skill development.'
        WHEN id = 333 THEN 'Discover the diverse programs offered at GMIU under the guidance of expert faculty. Enhance your knowledge and skills to excel in your career with industry-relevant courses.'
        WHEN id = 354 THEN 'Explore GMIU\s specialized programs under expert faculty guidance, designed to enhance skills and prepare students for a successful career in their chosen fields.'
    END,
    pageTitle = CASE 
        WHEN id = 334 THEN 'B.Sc + BBA (Fintech, Digital Marketing, Agri Business) - GMIU'
        WHEN id = 339 THEN 'BBA + BA (Archaeology, Public Admin, Journalism) - Gyanmanjari University'
        WHEN id = 176 THEN 'B.Com + M.Com (UG + PG) - Gyanmanjari Innovative University | GMIU'
        WHEN id = 208 THEN 'PhD in Arts - Gyanmanjari Innovative University | GMIU'
        WHEN id = 344 THEN 'B.Com + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU'
        WHEN id = 349 THEN 'BCA + B.Com (Finance, Banking, Marketing & Management) - GMIU'
        WHEN id = 350 THEN 'BCA + Fashion Designing Dual Degree - Gyanmanjari University | GMIU'
        WHEN id = 365 THEN 'LL.B. Undergraduate Program - Gyanmanjari Innovative University | GMIU'
        WHEN id = 210 THEN 'PhD in Management - Gyanmanjari Innovative University | GMIU'
        WHEN id = 183 THEN 'B.Tech + MBA (UG + PG) - Gyanmanjari Innovative University | GMIU'
        WHEN id = 179 THEN 'BCA + MCA (UG + PG) - Gyanmanjari Innovative University | GMIU'
        WHEN id = 348 THEN 'BCA + BBA (Fintech, Digital Marketing, Agri Business) - GMIU'
        WHEN id = 330 THEN 'B.Tech + B.Com (Finance, Banking, Marketing & Management) - GMIU'
        WHEN id = 360 THEN 'B.Pharm + B.Com (Finance, Banking, Marketing & Management) - GMIU'
        WHEN id = 351 THEN 'BBA + BA (Archaeology, Public Admin, Journalism) - GMIU'
        WHEN id = 347 THEN 'BCA + BA (Archaeology, Public Admin, Journalism) - GMIU'
        WHEN id = 332 THEN 'B.Tech + Fashion Designing Dual Degree - Gyanmanjari University | GMIU'
        WHEN id = 184 THEN 'B.Tech + M.Tech (All Branches) UG + PG - Gyanmanjari University | GMIU'
        WHEN id = 178 THEN 'BA + MSW (UG + PG) - Gyanmanjari Innovative University | GMIU'
        WHEN id = 331 THEN 'B.Tech + B.Sc (Physics, Chemistry, Zoology, Microbiology) - GMIU'
        WHEN id = 353 THEN 'BBA + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU'
        WHEN id = 352 THEN 'BBA + B.Com (Finance, Banking, Marketing & Startup) - GMIU'
        WHEN id = 177 THEN 'B.Com + M.Com (Special Program) UG + PG - Gyanmanjari University | GMIU'
        WHEN id = 333 THEN 'B.Sc + BA (Archaeology, Public Admin, Journalism) - GMIU'
        WHEN id = 354 THEN 'BBA + Fashion Designing Dual Degree - Gyanmanjari University | GMIU'
    END,
    meta_keywords = CASE 
        WHEN id = 334 THEN 'dual degree, BBA, BSc, GMIU, Fintech, Agri Business, Digital Marketing'
        WHEN id = 339 THEN 'BBA, BA, Journalism, Public Administration, Archaeology, GMIU'
            END
WHERE (id) IN (
    (334), (339), (176), (208), (344), (349),
    (350), (365), (210), (183), (179), (348),
    (330), (360), (351), (347), (332), (184),
    (178), (331), (353), (352), (177), (333),
    (354)
)

UPDATE tbl_program
SET 
    meta_description = CASE 
        WHEN id = 241 THEN "Explore GMIU's academic program designed by expert faculty to provide comprehensive knowledge and skills. Join us to advance your career in this specialized field."
        WHEN id = 345 THEN "Discover GMIU’s program offering under the guidance of experienced faculty. Equip yourself with the knowledge and skills needed for a successful career in your field."
        WHEN id = 340 THEN "Explore GMIU’s specialized program, offering students expert guidance and practical knowledge to enhance their skills and prepare them for career success."
        WHEN id = 361 THEN "Discover GMIU’s specialized program offering students in-depth knowledge and practical skills, guided by expert faculty, for successful career advancement."
        WHEN id = 211 THEN "Explore GMIU’s program designed to offer students specialized knowledge and skills, guided by expert faculty, preparing them for success in their careers."
        WHEN id = 359 THEN "Explore GMIU’s program offering specialized knowledge and skills under expert faculty guidance, preparing students for a successful career in their chosen field."
        WHEN id = 262 THEN "Discover GMIU's program designed to enhance student expertise with practical skills, fostering professional growth and academic excellence under expert faculty guidance."
        WHEN id = 338 THEN "Explore GMIU’s tailored program designed to equip students with vital skills and knowledge, guided by expert faculty to prepare them for successful careers."
        WHEN id = 209 THEN "Discover GMIU’s specialized program offering key skills and practical insights, guided by expert faculty to ensure students’ success in their chosen careers."
        WHEN id = 181 THEN "Explore GMIU’s specialized program designed to provide students with key skills, knowledge, and real-world exposure, guided by expert faculty for career success."
        WHEN id = 261 THEN "Discover GMIU’s specialized program, designed to equip students with essential skills and knowledge for a successful career, guided by expert faculty."
        WHEN id = 274 THEN "Explore GMIU’s specialized program offering essential skills and knowledge for career success, guided by expert faculty to prepare students for the professional world."
        WHEN id = 207 THEN "Discover GMIU’s specialized program, offering in-depth knowledge and practical skills, guided by expert faculty to ensure your success in a competitive career field."
        WHEN id = 335 THEN "Explore GMIU’s specialized program designed to equip students with essential skills and knowledge, led by expert faculty to prepare them for successful careers."
        WHEN id = 356 THEN "Explore GMIU’s specialized program, providing students with essential skills and knowledge to succeed in their field, guided by expert faculty for career growth."
        WHEN id = 343 THEN "Explore GMIU's specialized program, offering students expert-led training and skills to succeed in their field, preparing them for a bright career ahead."
        WHEN id = 174 THEN "Explore GMIU's specialized program designed to equip students with essential skills and knowledge, guided by expert faculty for a successful career in the field."
        WHEN id = 342 THEN "Explore GMIU's program offering specialized knowledge and skills, led by expert faculty, designed to prepare students for successful careers in their field of study."
        WHEN id = 206 THEN "Explore GMIU’s specialized program designed to provide students with essential skills and knowledge, guided by expert faculty for successful career growth."
        WHEN id = 336 THEN "Explore GMIU’s specialized program, offering in-depth knowledge and practical skills, led by expert faculty to prepare students for successful careers in their field."
        WHEN id = 357 THEN "Explore GMIU’s program led by expert faculty, designed to provide students with specialized knowledge and practical skills, preparing them for successful careers."
        WHEN id = 173 THEN "Explore the details of the specialized program at GMIU, led by expert faculty, designed to equip students with industry-relevant knowledge and skills for success."
        ELSE meta_description
    END,
    
    pageTitle = CASE 
        WHEN id = 241 THEN "BSW + MSW (UG + PG) - Gyanmanjari Innovative University | GMIU"
        WHEN id = 345 THEN "B.Com + BBA (Fintech, Business Analysis, Agri Business) - GMIU"
        WHEN id = 340 THEN "BBA + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU"
        WHEN id = 361 THEN "B.Pharm + Bio Tech Dual Degree - Gyanmanjari Innovative University | GMIU"
        WHEN id = 211 THEN "PhD in Computer Application - Gyanmanjari Innovative University | GMIU"
        WHEN id = 359 THEN "B.Pharm + BBA (Fintech, Business Analysis, Agri Business) - GMIU"
        WHEN id = 262 THEN "B.Tech + BBA (Fintech, Business Analysis, Agri Business) - GMIU"
        WHEN id = 338 THEN "B.Sc + Fashion Designing Dual Degree - Gyanmanjari University | GMIU"
        WHEN id = 209 THEN "PhD in Commerce - Gyanmanjari Innovative University | GMIU"
        WHEN id = 181 THEN "BBA + MBA (Special Program) UG + PG - Gyanmanjari University | GMIU"
        WHEN id = 261 THEN "B.Tech + BA (Archaeology, Public Admin, Journalism) - GMIU"
        WHEN id = 274 THEN "B.Tech + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU"
        WHEN id = 207 THEN "PhD in Science - Gyanmanjari Innovative University | GMIU"
        WHEN id = 335 THEN "B.Sc + BCA (Cyber Security, Data Science, Cloud Tech) - GMIU"
        WHEN id = 356 THEN "Bio Tech + B.Sc (Physics, Chemistry, Zoology, Micro) - GMIU"
        WHEN id = 343 THEN "B.Com + BA (Archaeology, Public Admin, Journalism) - GMIU"
        WHEN id = 174 THEN "BA + MA (Special Program) UG + PG - Gyanmanjari University | GMIU"
        WHEN id = 342 THEN "BBA + Fashion Designing Dual Degree - Gyanmanjari University | GMIU"
        WHEN id = 206 THEN "PhD in Engineering - Gyanmanjari Innovative University | GMIU"
        WHEN id = 336 THEN "B.Sc + B.Com (Finance, Banking, Marketing & Startup) - GMIU"
        WHEN id = 357 THEN "Bio Tech + Fashion Designing Dual Degree - Gyanmanjari University | GMIU"
        WHEN id = 173 THEN "BA + MA (UG + PG) - Gyanmanjari Innovative University | GMIU"
        ELSE pageTitl    END,

    meta_keywords = "GMIU programs, dual degrees, UG PG courses, admission, Gyanmanjari University, career development, innovative university programs"

WHERE (id) IN (
    (241),(345),(340),(361),(211),(359),(262),(338),
    (209),(181),(261),(274),(207),(335),(356),(343),
    (174),(342),(206),(336),(357),(173)
);
