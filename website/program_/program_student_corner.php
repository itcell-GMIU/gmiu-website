<?php
include '../../common/importwebsitefile.php';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
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
                    <h1>Student Corner</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href=""></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#"></a></span>
                </p>
                <hr>
            </div>

        </div>

    </section>


    <div class="single-courses-area">
        <div class="container">
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <h4 style="padding-bottom: 20px;" class="color-gmiu">TIME TABLE
                            <div id="java-btn">
                                <button id="show2" class="java-btn-button">
                                    <span>
                                        DEGREE
                                    </span>
                                </button>
                                <button id="show1" class="java-btn-button">
                                    <span>
                                        DIPLOMA
                                    </span>
                                </button>
                            </div>
                        </h4>
                        <hr>

                        <div style="display: none;" class="diploma">
                            <div id="java-btn">
                                <button id="dsem2" class="java-btn-button">
                                    <span>
                                        Sem - 2
                                    </span>
                                </button>
                                <button id="dsem4" class="java-btn-button">
                                    <span>
                                        Sem - 4
                                    </span>
                                </button>
                                <button id="dsem6" class="java-btn-button">
                                    <span>
                                        Sem - 6
                                    </span>
                                </button>
                            </div>
                            <img id="dsem-2" class="time-table"
                                src="<?php echo $website_assets_url; ?>images/student-corner/dt-1.jpg"
                                alt="No Time-Table available for this semester">
                            <img style="display: none;" id="dsem-4" class="time-table"
                                src="<?php echo $website_assets_url; ?>images/student-corner/dt-2.jpg"
                                alt="No Time-Table available for this semester">
                            <img style="display: none;" id="dsem-6" class="time-table"
                                src="<?php echo $website_assets_url; ?>images/student-corner/dt-3.jpg"
                                alt="No Time-Table available for this semester">
                            <h4 style="padding-bottom: 20px;" class="color-gmiu">SYLLABUS & TEACHING SCHEME</h4>
                            <hr>
                            <div id="java-btn">
                                <button id="diplo-sub-tb1" class="java-btn-button">
                                    <span>
                                        Sem - 1
                                    </span>
                                </button>
                                <button id="diplo-sub-tb2" class="java-btn-button">
                                    <span>
                                        Sem - 2
                                    </span>
                                </button>
                                <button id="diplo-sub-tb3" class="java-btn-button">
                                    <span>
                                        Sem - 3
                                    </span>
                                </button>
                                <button id="diplo-sub-tb4" class="java-btn-button">
                                    <span>
                                        Sem - 4
                                    </span>
                                </button>
                                <button id="diplo-sub-tb5" class="java-btn-button">
                                    <span>
                                        Sem - 5
                                    </span>
                                </button>
                                <button id="diplo-sub-tb6" class="java-btn-button">
                                    <span>
                                        Sem - 6
                                    </span>
                                </button>
                            </div>
                            <div class="stu-subject-table">
                                <div id="diplo-sub-tb-1">
                                    <h4 class="color-gmiu">SEMESTER 1
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>ETC</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="diplo-sub-tb-2">
                                    <h4 class="color-gmiu">SEMESTER 2
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>DSA</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="diplo-sub-tb-3">
                                    <h4 class="color-gmiu">SEMESTER 3
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>OSV</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="diplo-sub-tb-4">
                                    <h4 class="color-gmiu">SEMESTER 4
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>IC</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="diplo-sub-tb-5">
                                    <h4 class="color-gmiu">SEMESTER 5
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>DE</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="diplo-sub-tb-6">
                                    <h4 class="color-gmiu">SEMESTER 6
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>DE</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <h4 style="padding-bottom: 20px; padding-top: 30px;" class="color-gmiu">STUDY MATERIALS
                            </h4>
                            <hr>
                            <div id="java-btn">
                                <button id="diplo-sub-sm1" class="java-btn-button">
                                    <span>
                                        Sem - 1
                                    </span>
                                </button>
                                <button id="diplo-sub-sm2" class="java-btn-button">
                                    <span>
                                        Sem - 2
                                    </span>
                                </button>
                                <button id="diplo-sub-sm3" class="java-btn-button">
                                    <span>
                                        Sem - 3
                                    </span>
                                </button>
                                <button id="diplo-sub-sm4" class="java-btn-button">
                                    <span>
                                        Sem - 4
                                    </span>
                                </button>
                                <button id="dsiplo-sub-sm5" class="java-btn-button">
                                    <span>
                                        Sem - 5
                                    </span>
                                </button>
                                <button id="diplo-sub-sm6" class="java-btn-button">
                                    <span>
                                        Sem - 6
                                    </span>
                                </button>
                            </div>
                            <div class="stu-subject-table">
                                <div id="diplo-sub-sm-1">
                                    <h4 class="color-gmiu">SEMESTER 1
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-001
                                        </span>
                                    </button>
                                    <h4>SUBJECT 01</h4>
                                </div>
                                <div style="display: none;" id="diplo-sub-sm-2">
                                    <h4 class="color-gmiu">SEMESTER 2
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-002
                                        </span>
                                    </button>
                                    <h4>SUBJECT 02</h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-002-1
                                        </span>
                                    </button>
                                    <h4>SUBJECT 02-1</h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-002-2
                                        </span>
                                    </button>
                                    <h4>SUBJECT 02-2</h4>
                                </div>
                                <div style="display: none;" id="diplo-sub-sm-3">
                                    <h4 class="color-gmiu">SEMESTER 3
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-003
                                        </span>
                                    </button>
                                    <h4>SUBJECT 03</h4>
                                </div>
                                <div style="display: none;" id="diplo-sub-sm-4">
                                    <h4 class="color-gmiu">SEMESTER 4
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-004
                                        </span>
                                    </button>
                                    <h4>SUBJECT 04</h4>
                                </div>
                                <div style="display: none;" id="diplo-sub-sm-5">
                                    <h4 class="color-gmiu">SEMESTER 5
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-005
                                        </span>
                                    </button>
                                    <h4>SUBJECT 05</h4>
                                </div>
                                <div style="display: none;" id="diplo-sub-sm-6">
                                    <h4 class="color-gmiu">SEMESTER 6
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-006
                                        </span>
                                    </button>
                                    <h4>SUBJECT 06</h4>
                                </div>
                            </div>
                        </div>

                        <div class="degree">
                            <div id="java-btn">
                                <button id="sem1" class="java-btn-button">
                                    <span>
                                        Sem - 1
                                    </span>
                                </button>
                                <button id="sem3" class="java-btn-button">
                                    <span>
                                        Sem - 3
                                    </span>
                                </button>
                                <button id="sem5" class="java-btn-button">
                                    <span>
                                        Sem - 5
                                    </span>
                                </button>
                                <button id="sem7" class="java-btn-button">
                                    <span>
                                        Sem - 7
                                    </span>
                                </button>
                            </div>
                            <img id="sem-1" class="time-table"
                                src="<?php echo $website_assets_url; ?>images/student-corner/t-1.jpg"
                                alt="No Time-Table available for this semester">
                            <img style="display: none;" id="sem-3" class="time-table"
                                src="<?php echo $website_assets_url; ?>images/student-corner/t-2.jpg"
                                alt="No Time-Table available for this semester">
                            <img style="display: none;" id="sem-5" class="time-table"
                                src="<?php echo $website_assets_url; ?>images/student-corner/t-3.jpg"
                                alt="No Time-Table available for this semester">
                            <img style="display: none;" id="sem-7" class="time-table"
                                src="<?php echo $website_assets_url; ?>images/student-corner/t-1.jpg"
                                alt="No Time-Table available for this semester">
                            <h4 style="padding-bottom: 20px;" class="color-gmiu">SYLLABUS & TEACHING SCHEME</h4>
                            <hr>
                            <div id="java-btn">
                                <button id="diplo-sub-tb1" class="java-btn-button">
                                    <span>
                                        Sem - 1
                                    </span>
                                </button>
                                <button id="deg-sub-tb2" class="java-btn-button">
                                    <span>
                                        Sem - 2
                                    </span>
                                </button>
                                <button id="deg-sub-tb3" class="java-btn-button">
                                    <span>
                                        Sem - 3
                                    </span>
                                </button>
                                <button id="deg-sub-tb4" class="java-btn-button">
                                    <span>
                                        Sem - 4
                                    </span>
                                </button>
                                <button id="deg-sub-tb5" class="java-btn-button">
                                    <span>
                                        Sem - 5
                                    </span>
                                </button>
                                <button id="deg-sub-tb6" class="java-btn-button">
                                    <span>
                                        Sem - 6
                                    </span>
                                </button>
                                <button id="deg-sub-tb7" class="java-btn-button">
                                    <span>
                                        Sem - 7
                                    </span>
                                </button>
                                <button id="deg-sub-tb8" class="java-btn-button">
                                    <span>
                                        Sem - 8
                                    </span>
                                </button>
                            </div>
                            <div class="stu-subject-table">
                                <div id="deg-sub-tb-1">
                                    <h4 class="color-gmiu">SEMESTER 1
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>ETC</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="deg-sub-tb-2">
                                    <h4 class="color-gmiu">SEMESTER 2
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>DSA</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="deg-sub-tb-3">
                                    <h4 class="color-gmiu">SEMESTER 3
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>OSV</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="deg-sub-tb-4">
                                    <h4 class="color-gmiu">SEMESTER 4
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>IC</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="deg-sub-tb-5">
                                    <h4 class="color-gmiu">SEMESTER 5
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>DE</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="deg-sub-tb-6">
                                    <h4 class="color-gmiu">SEMESTER 6
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>DE</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="deg-sub-tb-7">
                                    <h4 class="color-gmiu">SEMESTER 7
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>DE</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="display: none;" id="deg-sub-tb-8">
                                    <h4 class="color-gmiu">SEMESTER 8
                                        <hr>
                                    </h4>
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Short Name</th>
                                            <th>Subject</th>
                                        </tr>
                                        <tr>
                                            <td>3130002</td>
                                            <td>ADE</td>
                                            <td>Effective Technical Communication</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <h4 style="padding-top:30px; padding-bottom: 20px;" class="color-gmiu">STUDY MATERIALS
                            </h4>
                            <hr>
                            <div id="java-btn">
                                <button id="deg-sub-sm1" class="java-btn-button">
                                    <span>
                                        Sem - 1
                                    </span>
                                </button>
                                <button id="deg-sub-sm2" class="java-btn-button">
                                    <span>
                                        Sem - 2
                                    </span>
                                </button>
                                <button id="deg-sub-sm3" class="java-btn-button">
                                    <span>
                                        Sem - 3
                                    </span>
                                </button>
                                <button id="deg-sub-sm4" class="java-btn-button">
                                    <span>
                                        Sem - 4
                                    </span>
                                </button>
                                <button id="deg-sub-sm5" class="java-btn-button">
                                    <span>
                                        Sem - 5
                                    </span>
                                </button>
                                <button id="deg-sub-sm6" class="java-btn-button">
                                    <span>
                                        Sem - 6
                                    </span>
                                </button>
                                <button id="deg-sub-sm7" class="java-btn-button">
                                    <span>
                                        Sem - 7
                                    </span>
                                </button>
                                <button id="deg-sub-sm8" class="java-btn-button">
                                    <span>
                                        Sem - 8
                                    </span>
                                </button>
                            </div>
                            <div class="stu-subject-table">
                                <div id="deg-sub-sm-1">
                                    <h4 class="color-gmiu">SEMESTER 1
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-001
                                        </span>
                                    </button>
                                    <h4>SUBJECT 01</h4>
                                </div>
                                <div style="display: none;" id="deg-sub-sm-2">
                                    <h4 class="color-gmiu">SEMESTER 2
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-002
                                        </span>
                                    </button>
                                    <h4>SUBJECT 02</h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-002-1
                                        </span>
                                    </button>
                                    <h4>SUBJECT 02-1</h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-002-2
                                        </span>
                                    </button>
                                    <h4>SUBJECT 02-2</h4>
                                </div>
                                <div style="display: none;" id="deg-sub-sm-3">
                                    <h4 class="color-gmiu">SEMESTER 3
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-003
                                        </span>
                                    </button>
                                    <h4>SUBJECT 03</h4>
                                </div>
                                <div style="display: none;" id="deg-sub-sm-4">
                                    <h4 class="color-gmiu">SEMESTER 4
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-004
                                        </span>
                                    </button>
                                    <h4>SUBJECT 04</h4>
                                </div>
                                <div style="display: none;" id="deg-sub-sm-5">
                                    <h4 class="color-gmiu">SEMESTER 5
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-005
                                        </span>
                                    </button>
                                    <h4>SUBJECT 05</h4>
                                </div>
                                <div style="display: none;" id="deg-sub-sm-6">
                                    <h4 class="color-gmiu">SEMESTER 6
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-006
                                        </span>
                                    </button>
                                    <h4>SUBJECT 06</h4>
                                </div>
                                <div style="display: none;" id="deg-sub-sm-7">
                                    <h4 class="color-gmiu">SEMESTER 7
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-007
                                        </span>
                                    </button>
                                    <h4>SUBJECT 07</h4>
                                </div>
                                <div style="display: none;" id="deg-sub-sm-8">
                                    <h4 class="color-gmiu">SEMESTER 8
                                        <hr>
                                    </h4>
                                    <button class="java-btn-button">
                                        <span>
                                            SUB-008
                                        </span>
                                    </button>
                                    <h4>SUBJECT 08</h4>
                                </div>
                            </div>
                        </div>

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
                                        <li>COMPUTER ENGINEERING</li>
                                        <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>
                                                Overview</a></li>
                                        <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>
                                                Mission
                                                Vision</a></li>
                                        <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i> Program
                                                Outcome</a></li>
                                        <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>
                                                Laboratories</a>
                                        </li>
                                        <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>
                                                Faculty</a>
                                        </li>
                                        <li><a href="#" class="active"><i class="fa-solid fa-arrow-right"></i> Student
                                                Corner</a></li>
                                        <li>
                                            <!-- <a data-toggle="collapse" href="#news-activities" role="button" aria-expanded="false" aria-controls="news-activities"><i class="fa-solid fa-arrow-right"></i> News and Activities</a>
                                            <div class="collapse" id="news-activities">
                                                <ul class="accordion-menu custom-ul">
                                                    <li><a href="#">News</a></li>
                                                    <li><a href="#">Activities</a></li>
                                                </ul>
                                            </div> -->
                                            <div class="accordion">
                                                <a class="accordion-toggle" data-toggle="collapse"
                                                    href="#news-activities" role="button" aria-expanded="false"
                                                    aria-controls="news-activities" style="text-decoration-line: none;">
                                                    <i class="fa-solid fa-arrow-right"></i> News and Activities
                                                </a>
                                                <div class="collapse" id="news-activities"
                                                    style="width: 90%; margin-left:auto;">
                                                    <a
                                                        href="<?php echo $base_url_website_program; ?>program_expert_talk.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i
                                                            class="fa-solid fa-arrow-right"></i> Expert Talk</a>
                                                    <a
                                                        href="<?php echo $base_url_website_program; ?>program_industry_visit.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i
                                                            class="fa-solid fa-arrow-right"></i> Industry Visit</a>
                                                    <a
                                                        href="<?php echo $base_url_website_program; ?>program_workshop.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i
                                                            class="fa-solid fa-arrow-right"></i> Workshop</a>
                                                    <a
                                                        href="<?php echo $base_url_website_program; ?>program_sdp.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i
                                                            class="fa-solid fa-arrow-right"></i> SDP</a>
                                                    <a
                                                        href="<?php echo $base_url_website_program; ?>program_extra_curricular_activity.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><i
                                                            class="fa-solid fa-arrow-right"></i> Extra Curricular
                                                        Activity</a>
                                                </div>
                                            </div>

                                        </li>
                                        <li><a href="https://gmiu.edu.in/placement/placement-overview-and-statistics"
                                                class=""><i class="fa-solid fa-arrow-right"></i>
                                                Placement </a>
                                        </li>
                                        <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i>
                                                Achievement</a>
                                        </li>
                                        <li><a href="#" class=""><i class="fa-solid fa-arrow-right"></i> Our
                                                Projects</a>
                                        </li>

                                        <div class="contactInfo">
                                            <h3 class="gradText">Contact Details</h3>
                                            <hr>
                                            <h5>HOD Office</h5>
                                            <a href="#"><i class="fa fa-long-arrow-right"></i> +91 123456789</a>
                                            <h5>TPO Office</h5>
                                            <a href="#"><i class="fa fa-long-arrow-right"></i> +91 123456789</a>
                                            <h5>Email ID</h5>
                                            <a href="mailto:demo@gmail.com"><i class="fa fa-long-arrow-right"></i>
                                                demo@gmail.com</a>
                                        </div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#show1").click(function() {
            $(".diploma").show();
            $(".degree").hide();
        });
        $("#show2").click(function() {
            $(".degree").show();
            $(".diploma").hide();
        });
    });
    $(document).ready(function() {
        $("#sem1").click(function() {
            $("#sem-1").show();
            $("#sem-3").hide();
            $("#sem-5").hide();
            $("#sem-7").hide();
        });
        $("#sem3").click(function() {
            $("#sem-1").hide();
            $("#sem-3").show();
            $("#sem-5").hide();
            $("#sem-7").hide();
        });
        $("#sem5").click(function() {
            $("#sem-1").hide();
            $("#sem-3").hide();
            $("#sem-5").show();
            $("#sem-7").hide();
        });
        $("#sem7").click(function() {
            $("#sem-1").hide();
            $("#sem-3").hide();
            $("#sem-5").hide();
            $("#sem-7").show();
        });
        $("#dsem2").click(function() {
            $("#dsem-2").show();
            $("#dsem-4").hide();
            $("#dsem-6").hide();
        });
        $("#dsem4").click(function() {
            $("#dsem-2").hide();
            $("#dsem-4").show();
            $("#dsem-6").hide();
        });
        $("#dsem6").click(function() {
            $("#dsem-2").hide();
            $("#dsem-4").hide();
            $("#dsem-6").show();
        });
    });
    $(document).ready(function() {
        $("#deg-sub-tb1").click(function() {
            $("#deg-sub-tb-1").show();
            $("#deg-sub-tb-2").hide();
            $("#deg-sub-tb-3").hide();
            $("#deg-sub-tb-4").hide();
            $("#deg-sub-tb-5").hide();
            $("#deg-sub-tb-6").hide();
            $("#deg-sub-tb-7").hide();
            $("#deg-sub-tb-8").hide();
        });
        $("#deg-sub-tb2").click(function() {
            $("#deg-sub-tb-2").show();
            $("#deg-sub-tb-1").hide();
            $("#deg-sub-tb-3").hide();
            $("#deg-sub-tb-4").hide();
            $("#deg-sub-tb-5").hide();
            $("#deg-sub-tb-6").hide();
            $("#deg-sub-tb-7").hide();
            $("#deg-sub-tb-8").hide();
        });
        $("#deg-sub-tb3").click(function() {
            $("#deg-sub-tb-2").hide();
            $("#deg-sub-tb-1").hide();
            $("#deg-sub-tb-3").show();
            $("#deg-sub-tb-4").hide();
            $("#deg-sub-tb-5").hide();
            $("#deg-sub-tb-6").hide();
            $("#deg-sub-tb-7").hide();
            $("#deg-sub-tb-8").hide();
        });
        $("#deg-sub-tb4").click(function() {
            $("#deg-sub-tb-2").hide();
            $("#deg-sub-tb-1").hide();
            $("#deg-sub-tb-3").hide();
            $("#deg-sub-tb-4").show();
            $("#deg-sub-tb-5").hide();
            $("#deg-sub-tb-6").hide();
            $("#deg-sub-tb-7").hide();
            $("#deg-sub-tb-8").hide();
        });
        $("#deg-sub-tb5").click(function() {
            $("#deg-sub-tb-2").hide();
            $("#deg-sub-tb-1").hide();
            $("#deg-sub-tb-3").hide();
            $("#deg-sub-tb-4").hide();
            $("#deg-sub-tb-5").show();
            $("#deg-sub-tb-6").hide();
            $("#deg-sub-tb-7").hide();
            $("#deg-sub-tb-8").hide();
        });
        $("#deg-sub-tb6").click(function() {
            $("#deg-sub-tb-2").hide();
            $("#deg-sub-tb-1").hide();
            $("#deg-sub-tb-3").hide();
            $("#deg-sub-tb-4").hide();
            $("#deg-sub-tb-5").hide();
            $("#deg-sub-tb-6").show();
            $("#deg-sub-tb-7").hide();
            $("#deg-sub-tb-8").hide();
        });
        $("#deg-sub-tb7").click(function() {
            $("#deg-sub-tb-2").hide();
            $("#deg-sub-tb-1").hide();
            $("#deg-sub-tb-3").hide();
            $("#deg-sub-tb-4").hide();
            $("#deg-sub-tb-5").hide();
            $("#deg-sub-tb-6").hide();
            $("#deg-sub-tb-7").show();
            $("#deg-sub-tb-8").hide();
        });
        $("#deg-sub-tb8").click(function() {
            $("#deg-sub-tb-2").hide();
            $("#deg-sub-tb-1").hide();
            $("#deg-sub-tb-3").hide();
            $("#deg-sub-tb-4").hide();
            $("#deg-sub-tb-5").hide();
            $("#deg-sub-tb-6").hide();
            $("#deg-sub-tb-7").hide();
            $("#deg-sub-tb-8").show();
        });
    });
    $(document).ready(function() {
        $("#deg-sub-sm1").click(function() {
            $("#deg-sub-sm-1").show();
            $("#deg-sub-sm-2").hide();
            $("#deg-sub-sm-3").hide();
            $("#deg-sub-sm-4").hide();
            $("#deg-sub-sm-5").hide();
            $("#deg-sub-sm-6").hide();
            $("#deg-sub-sm-7").hide();
            $("#deg-sub-sm-8").hide();
        });
        $("#deg-sub-sm2").click(function() {
            $("#deg-sub-sm-2").show();
            $("#deg-sub-sm-1").hide();
            $("#deg-sub-sm-3").hide();
            $("#deg-sub-sm-4").hide();
            $("#deg-sub-sm-5").hide();
            $("#deg-sub-sm-6").hide();
            $("#deg-sub-sm-7").hide();
            $("#deg-sub-sm-8").hide();
        });
        $("#deg-sub-sm3").click(function() {
            $("#deg-sub-sm-2").hide();
            $("#deg-sub-sm-1").hide();
            $("#deg-sub-sm-3").show();
            $("#deg-sub-sm-4").hide();
            $("#deg-sub-sm-5").hide();
            $("#deg-sub-sm-6").hide();
            $("#deg-sub-sm-7").hide();
            $("#deg-sub-sm-8").hide();
        });
        $("#deg-sub-sm4").click(function() {
            $("#deg-sub-sm-2").hide();
            $("#deg-sub-sm-1").hide();
            $("#deg-sub-sm-3").hide();
            $("#deg-sub-sm-4").show();
            $("#deg-sub-sm-5").hide();
            $("#deg-sub-sm-6").hide();
            $("#deg-sub-sm-7").hide();
            $("#deg-sub-sm-8").hide();
        });
        $("#deg-sub-sm5").click(function() {
            $("#deg-sub-sm-2").hide();
            $("#deg-sub-sm-1").hide();
            $("#deg-sub-sm-3").hide();
            $("#deg-sub-sm-4").hide();
            $("#deg-sub-sm-5").show();
            $("#deg-sub-sm-6").hide();
            $("#deg-sub-sm-7").hide();
            $("#deg-sub-sm-8").hide();
        });
        $("#deg-sub-sm6").click(function() {
            $("#deg-sub-sm-2").hide();
            $("#deg-sub-sm-1").hide();
            $("#deg-sub-sm-3").hide();
            $("#deg-sub-sm-4").hide();
            $("#deg-sub-sm-5").hide();
            $("#deg-sub-sm-6").show();
            $("#deg-sub-sm-7").hide();
            $("#deg-sub-sm-8").hide();
        });
        $("#deg-sub-sm7").click(function() {
            $("#deg-sub-sm-2").hide();
            $("#deg-sub-sm-1").hide();
            $("#deg-sub-sm-3").hide();
            $("#deg-sub-sm-4").hide();
            $("#deg-sub-sm-5").hide();
            $("#deg-sub-sm-6").hide();
            $("#deg-sub-sm-7").show();
            $("#deg-sub-sm-8").hide();
        });
        $("#deg-sub-sm8").click(function() {
            $("#deg-sub-sm-2").hide();
            $("#deg-sub-sm-1").hide();
            $("#deg-sub-sm-3").hide();
            $("#deg-sub-sm-4").hide();
            $("#deg-sub-sm-5").hide();
            $("#deg-sub-sm-6").hide();
            $("#deg-sub-sm-7").hide();
            $("#deg-sub-sm-8").show();
        });
    });
    $(document).ready(function() {
        $("#diplo-sub-tb1").click(function() {
            $("#diplo-sub-tb-1").show();
            $("#diplo-sub-tb-2").hide();
            $("#diplo-sub-tb-3").hide();
            $("#diplo-sub-tb-4").hide();
            $("#diplo-sub-tb-5").hide();
            $("#diplo-sub-tb-6").hide();
        });
        $("#diplo-sub-tb2").click(function() {
            $("#diplo-sub-tb-2").show();
            $("#diplo-sub-tb-1").hide();
            $("#diplo-sub-tb-3").hide();
            $("#diplo-sub-tb-4").hide();
            $("#diplo-sub-tb-5").hide();
            $("#diplo-sub-tb-6").hide();
        });
        $("#diplo-sub-tb3").click(function() {
            $("#diplo-sub-tb-2").hide();
            $("#diplo-sub-tb-1").hide();
            $("#diplo-sub-tb-3").show();
            $("#diplo-sub-tb-4").hide();
            $("#diplo-sub-tb-5").hide();
            $("#diplo-sub-tb-6").hide();
        });
        $("#diplo-sub-tb4").click(function() {
            $("#diplo-sub-tb-2").hide();
            $("#diplo-sub-tb-1").hide();
            $("#diplo-sub-tb-3").hide();
            $("#diplo-sub-tb-4").show();
            $("#diplo-sub-tb-5").hide();
            $("#diplo-sub-tb-6").hide();
        });
        $("#diplo-sub-tb5").click(function() {
            $("#diplo-sub-tb-2").hide();
            $("#diplo-sub-tb-1").hide();
            $("#diplo-sub-tb-3").hide();
            $("#diplo-sub-tb-4").hide();
            $("#diplo-sub-tb-5").show();
            $("#diplo-sub-tb-6").hide();
        });
        $("#diplo-sub-tb6").click(function() {
            $("#diplo-sub-tb-2").hide();
            $("#diplo-sub-tb-1").hide();
            $("#diplo-sub-tb-3").hide();
            $("#diplo-sub-tb-4").hide();
            $("#diplo-sub-tb-5").hide();
            $("#diplo-sub-tb-6").show();
        });
    });
    $(document).ready(function() {
        $("#diplo-sub-sm1").click(function() {
            $("#diplo-sub-sm-1").show();
            $("#diplo-sub-sm-2").hide();
            $("#diplo-sub-sm-3").hide();
            $("#diplo-sub-sm-4").hide();
            $("#diplo-sub-sm-5").hide();
            $("#diplo-sub-sm-6").hide();
        });
        $("#diplo-sub-sm2").click(function() {
            $("#diplo-sub-sm-2").show();
            $("#diplo-sub-sm-1").hide();
            $("#diplo-sub-sm-3").hide();
            $("#diplo-sub-sm-4").hide();
            $("#diplo-sub-sm-5").hide();
            $("#diplo-sub-sm-6").hide();
        });
        $("#diplo-sub-sm3").click(function() {
            $("#diplo-sub-sm-2").hide();
            $("#diplo-sub-sm-1").hide();
            $("#diplo-sub-sm-3").show();
            $("#diplo-sub-sm-4").hide();
            $("#diplo-sub-sm-5").hide();
            $("#diplo-sub-sm-6").hide();
        });
        $("#diplo-sub-sm4").click(function() {
            $("#diplo-sub-sm-2").hide();
            $("#diplo-sub-sm-1").hide();
            $("#diplo-sub-sm-3").hide();
            $("#diplo-sub-sm-4").show();
            $("#diplo-sub-sm-5").hide();
            $("#diplo-sub-sm-6").hide();
        });
        $("#diplo-sub-sm5").click(function() {
            $("#diplo-sub-sm-2").hide();
            $("#diplo-sub-sm-1").hide();
            $("#diplo-sub-sm-3").hide();
            $("#diplo-sub-sm-4").hide();
            $("#diplo-sub-sm-5").show();
            $("#diplo-sub-sm-6").hide();
        });
        $("#diplo-sub-sm6").click(function() {
            $("#diplo-sub-sm-2").hide();
            $("#diplo-sub-sm-1").hide();
            $("#diplo-sub-sm-3").hide();
            $("#diplo-sub-sm-4").hide();
            $("#diplo-sub-sm-5").hide();
            $("#diplo-sub-sm-6").show();
        });
    });
    </script>

    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>