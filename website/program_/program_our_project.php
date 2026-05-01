<?php

include '../../common/importwebsitefile.php';

if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        redirectHome("Invalid data in url");
    }

    $cmd = $con->prepare("SELECT level.name as level_name, program.name as program_name,
     program.id as program_id, 
    program.description as program_description 
    FROM tbl_program as program 
    LEFT JOIN tbl_level as level ON program.level_id = level.id 
    WHERE program.id=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
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

if (isset($_GET['faculty_id']) && !empty($_GET['faculty_id'])) {
    $faculty_id = mysqli_real_escape_string($con, $_GET['faculty_id']);
    $faculty_id = only_digits($faculty_id);
    if ($faculty_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>";
    }
    // fetch faculty details
    $cmd = $con->prepare("SELECT faculty.name as faculty_name from tbl_faculty as faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
}

$cmd22 = $con->prepare("SELECT our_hackathon.id as our_hackathon_id,our_hackathon.title as our_hackathon_title FROM tbl_our_hackathon as our_hackathon  WHERE program_id=? AND is_active=1 AND is_delete=0 ");
$cmd22->bind_param("i", $program_id);
$cmd22->execute();
$result22 = $cmd22->get_result();
if ($result22->num_rows > 0) {
    $show = 1;
} else {
    $show = 0;
}

?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        .flexContainer .cont section {
            margin: 20px 0;
        }

        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        main,
        menu,
        nav,
        section,
        summary {
            display: block;
        }


        .prImg[_ngcontent-dki-c65] .card.imgCard[_ngcontent-dki-c65] .header[_ngcontent-dki-c65] h3[_ngcontent-dki-c65] {
            padding: 10px 0;
            text-transform: capitalize;
        }

        .card.imgCard .header * {
            text-align: center;
            margin: 0;
            color: #fff;
        }

        h3 {
            line-height: 26px;
            margin: 0;
            padding-bottom: 20px;
            color: #333;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: 600;
            transition: all .3s ease-in-out;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: Nunito, sans-serif !important;
        }

        .h3,
        h3 {
            font-size: 24px;
        }

        .h1,
        .h2,
        .h3,
        h1,
        h2,
        h3 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
            color: inherit;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Your Preferred Font', sans-serif;
            /* Change 'Your Preferred Font' to the desired font family */
        }

        .swiper {
            width: 100%;
            height: 100%;
            margin: 20px;

        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            /* background: #fff; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        .swiper {
            width: 100%;
            height: auto;
            aspect-ratio: 16/10;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 80%;
            width: 100%;
        }

        .mySwiper {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 205%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Add this CSS to set fixed size for the box and images */
        .cool-slide {
            width: 500px;
            height: 200px;
            overflow: hidden;
            border-radius: 0;
            margin-bottom: 10px;
            box-shadow: 0 0 10px #00000021;

        }

        .cool-slide img {
            width: 350px;
            height: 100%;
            object-fit: cover;
            box-shadow: 0 0 10px #00000021;

            /* Maintain aspect ratio while covering the entire box */
        }

        .events-single-box {
            width: 100%;
            /* Adjust width based on your design */
            height: auto;
            /* Adjust height based on your design */
            box-sizing: border-box;
            /* Include padding and border in the element's total width and height */
            background-color: white;
            margin-bottom: 10px;

        }

        .events-single-box img {
            width: 100%;
            height: 100%;

        }

        .events-full-box {
            width: 50%;
            /* Adjust width based on your design */
            box-sizing: border-box;
        }

        hr {
            margin: 0;
            border: none;
            border-top: 1px solid #ddd;
            /* Set your HR color */
        }

        .top {
            background-color: white;
            padding: 20px;
            color: #fff;
            /* Set text color to white */
        }

        .events-list-03 .events-single-box img {
            border-radius: 5px;
        }

        .events-list-03 .event-info {
            padding-top: 0;
        }

        .events-list-03 .events-single-box {
            background-color: white;
        }

        #dwn-btn {
            padding: 5px 10px;
            background-color: #ba2a21;
            color: white;
            border: 1px transparent;
            border-radius: 4px;
        }

        #dwn-btn:hover {
            transform: translateY(-5px);
            transition: all .3s ease-in-out;
        }

        .color-gmiu1 {
            background-color: white;
            color: #ba2a21;
            text-align: center;
            /* Set your text color */
        }

        /* Additional styles specific to your structure */
        .events-list-03 {
            margin-bottom: 0;
            padding-left: 0;
        }

        .semester-content {
            margin-top: 0;
        }

        /* Add this CSS to style the marquee and embedded iframes */
        /* Add this CSS to style the marquee and its container */

        .events-list-031 marquee {
            background: rgba(186, 42, 33, 0.1);
            /* Set your preferred background color */
            box-shadow: 0 0 10px #00000021;
            padding: 0px;
            /* Adjust padding based on your design */
            margin-bottom: 20px;
            border-radius: 5px;
        }

        marquee {
            display: flex;
            overflow: hidden;
        }

        marquee iframe {
            margin-right: 10px;
            /* Adjust margin based on your design */
        }

        /* Additional styling for responsiveness */
        @media (max-width: 600px) {
            marquee {
                flex-direction: column;
            }

            marquee iframe {
                margin-right: 0;
                margin-bottom: 10px;
                /* Adjust margin based on your design */
            }
        }

        #dwn-btn {
            padding: 5px 10px;
            background-color: #ba2a21;
            color: white;
            border: 1px transparent;
            border-radius: 4px;
        }

        #dwn-btn:hover {
            transform: translateY(-5px);
            transition: all .3s ease-in-out;
        }

        /* Style for red table */
        #projects {
            font-family: Arial, Helvetica, sans-serif;
            width: 65%;
            border-radius: 5px;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            border-collapse: collapse;
            border: none;
            box-shadow: 0 0 10px #00000021;
        }


        #projects td {
            padding-top: 20px;
            padding-bottom: 20px;
            padding-right: 30px;
            color: #727272;
        }


        #projects th {
            padding-left: 16px;
            padding-top: 22px;
            padding-bottom: 22px;


            border-collapse: collapse;
            border: none;
        }

        .left-curve {
            border-top-left-radius: 10px;
            padding: 40px;
        }

        .right-curve {
            border-top-right-radius: 10px;
        }


        #projects tr:nth-child(even) {
            background-color: #fceae6;
            border-collapse: collapse;
            border: none;
        }

        #projects th {
            padding-top: 22px;
            padding-bottom: 22px;
            text-align: left;
            background-color: #ba2a21;
            color: white;
            font-size: 18px;
            text-transform: uppercase;
            border-collapse: collapse;
            border: none;
        }

        tr>td>p {
            color: #727272;
            font-size: 15px;
            line-height: 1.7;
            font-family: Arial, Helvetica, sans-serif;

        }

        /* You can continue adding any additional styles here */
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
                    <h1>Our Project</h1>
                    <p style="font-size: 14px; text-transform: capitalize;">BY <?= $faculty_name  ?></p>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <!--<span class="b-active"><a href="program.php?program_id=<?php //echo $program_id ?>&faculty_id=<?php //echo $faculty_id ?>"><?php //echo $program_name; ?></a>-->
                    <!--    <i class='fa fa-angle-right'></i></span>-->
                      <span class="b-active"><a href="<?php echo $base_url_website_faculty; ?>faculty.php?id=<?php echo $faculty_id ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#"><?php echo $program_name.' ('.$level_name .')'; ?></a><i class='fa fa-angle-right'></i></span>
              
                    <span class="b-active">Our Project<a href=""></a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>
    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left" style="box-shadow: 0 0 0px #00000021;">
                    <div class="single-curses-contert">
                        <section class="events-list-031">
                            <div>
                                <?php
                                // Check if there is data in the projects table
                                $cmd_project = "SELECT our_project.id as our_project_id, our_project.title1 as our_project_title1, our_project.description as our_project_description FROM tbl_our_project as our_project WHERE program_id = ? AND faculty_id = ? AND is_active = 1 AND is_delete = 0";
                                $stmt_project = $con->prepare($cmd_project);
                                $stmt_project->bind_param("ii", $program_id, $faculty_id);
                                $stmt_project->execute();
                                $result_project = $stmt_project->get_result();

                                // Check if there is data in the Hackathon table
                                $cmd_hackathon = "SELECT our_hackathon.id as our_hackathon_id, our_hackathon.title as our_hackathon_title, our_hackathon.team_leader as our_hackathon_team_leader, our_hackathon.team_member as our_hackathon_team_member, our_hackathon.location as our_hackathon_location FROM tbl_our_hackathon as our_hackathon WHERE program_id = ? AND faculty_id = ? AND is_active = 1 AND is_delete = 0 ";
                                $stmt_hackathon = $con->prepare($cmd_hackathon);
                                $stmt_hackathon->bind_param("ii", $program_id, $faculty_id);
                                $stmt_hackathon->execute();
                                $result_hackathon = $stmt_hackathon->get_result();

                                // Check if there is data in the Social table
                                $cmd_social = "SELECT our_social.id as our_social_id, our_social.title as our_social_title FROM tbl_our_social as our_social WHERE program_id = ? AND faculty_id = ? AND is_active = 1 AND is_delete = 0 ";
                                $stmt_social = $con->prepare($cmd_social);
                                $stmt_social->bind_param("ii", $program_id, $faculty_id);
                                $stmt_social->execute();
                                $result_social = $stmt_social->get_result();
                                ?>

                                <!-- Display the marquee if there is data in either the projects table or the Hackathon table -->
                                <marquee _ngcontent-irf-c65="" behavior="scroll" direction="left" scrollamount="10" onmouseover="this.stop();" onmouseout="this.start();">
                                    <iframe _ngcontent-irf-c65="" width="300" height="200" src="https://www.youtube.com/embed/PM1I57PwAYk" title="Bumper suit" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                                    <iframe _ngcontent-irf-c65="" width="300" height="200" src="https://www.youtube.com/embed/3CE-4a64TUE" title="ECG machine" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                                </marquee>

                                <div class="row">
                                    <?php
                                    $cmd = $con->prepare("SELECT our_social.id as our_social_id,our_social.title as our_social_title FROM tbl_our_social as our_social  WHERE program_id=? AND is_active=1 AND is_delete=0");
                                    $cmd->bind_param("i", $program_id);
                                    $cmd->execute();
                                    $result = $cmd->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $our_social_title = $row['our_social_title'];
                                            $our_social_id = $row['our_social_id'];
                                    ?>
                                            <div class="col-sm-6" style="width: 50%; padding-bottom: 44%; ">
                                                <div class="card" style="margin-left: 0px; box-shadow: 0 0 10px #00000021;">
                                                    <div class="card-header text-center" style=" background-color:#ba2a21; padding: 15px; color:white; border-radius: 5px 5px 0 0; box-shadow: 0 0 10px #00000021;">
                                                        <h4 class="" style="margin: 0;"><?php echo $our_social_title; ?></h4>
                                                    </div>
                                                    <div class="card-body" style="height:20px; box-shadow: 0 0 10px #00000021;">
                                                        <?php
                                                        $type = "our_social";
                                                        $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                        $cmd1->bind_param("is", $our_social_id, $type);
                                                        $cmd1->execute();
                                                        $result1 = $cmd1->get_result();
                                                        if ($result1->num_rows > 0) {
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                $file_name1 = $row1['sp_file_name'];
                                                        ?>
                                                                <img src="<?php echo $upload_website_admin_url . '../uploads/our_project/image/' . $file_name1; ?>" style="width:100%; height:360px;">
                                                        <?php }
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>

                                <!-- Code for displaying Hackathon details -->
                                <?php
                                if ($show == 1) {
                                ?>

                                    <div class="col-sm-8" style="width: 100%; padding-bottom: 10px; padding-left: 2px">
                                        <h3 _ngcontent-dwi-c65="" class="gradText">Hackathon</h3>
                                        <hr _ngcontent-dwi-c65="">
                                        <div _ngcontent-dwi-c65="" class="flex">
                                            <div _ngcontent-dwi-c65="" class="india">
                                                <h5 _ngcontent-dwi-c65="" class="gradText" style="padding-bottom: 5px;">Smart India Hackathon</h5>
                                                <hr _ngcontent-dwi-c65="" style="padding-bottom: 5px; margin-bottom: 5px;">
                                                <?php
                                                $cmd = $con->prepare("SELECT our_hackathon.id as our_hackathon_id,our_hackathon.title as our_hackathon_title FROM tbl_our_hackathon as our_hackathon  WHERE program_id=? AND is_active=1 AND is_delete=0 ");
                                                $cmd->bind_param("i", $program_id);
                                                $cmd->execute();
                                                $result = $cmd->get_result();
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $our_hackathon_title = $row['our_hackathon_title'];
                                                        $our_hackathon_id = $row['our_hackathon_id'];
                                                ?>
                                                        <div class="events-single-box" style="margin-bottom: 20px; height:100%; box-shadow: 0 0 0px #000;">
                                                            <div class="row">
                                                                <div id="img-slider">
                                                                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; padding-bottom:0;" class="swiper swipermain mySwipers<?php echo $our_hackathon_id; ?>">
                                                                        <div class="swiper-wrapper">
                                                                            <?php
                                                                            $type = "our_hackathon";
                                                                            $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                                            $cmd1->bind_param("is", $our_hackathon_id, $type);
                                                                            $cmd1->execute();
                                                                            $result1 = $cmd1->get_result();
                                                                            if ($result1->num_rows > 0) {
                                                                                while ($row1 = $result1->fetch_assoc()) {
                                                                                    $file_name1 = $row1['sp_file_name'];
                                                                            ?>
                                                                                    <div class="swiper-slide">
                                                                                        <img src="<?php echo $upload_website_admin_url . '../uploads/our_project/image/' . $file_name1; ?>">
                                                                                    </div>
                                                                            <?php }
                                                                            } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div style="height:80px" thumbsSlider="" class="swiper mySwiper<?php echo $our_hackathon_id; ?>">
                                                                        <div class="swiper-wrapper">
                                                                            <?php
                                                                            $type = "our_hackathon";
                                                                            $cmd2 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0");
                                                                            $cmd2->bind_param("is", $our_hackathon_id, $type);
                                                                            $cmd2->execute();
                                                                            $result2 = $cmd2->get_result();
                                                                            if ($result2->num_rows > 0) {
                                                                                while ($row2 = $result2->fetch_assoc()) {
                                                                                    $file_name2 = $row2['sp_file_name'];
                                                                            ?>
                                                                                    <div class="swiper-slide">
                                                                                        <img src="<?php echo $upload_website_admin_url . '../uploads/our_project/image/' . $file_name2; ?>">
                                                                                    </div>
                                                                            <?php }
                                                                            } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <table style="border-collapse: collapse;" style="width: 100%;">
                                            <?php while ($row_hackathon = $result_hackathon->fetch_assoc()) : ?>
                                                <tr style="margin-bottom: 10px;">
                                                    <th style="padding: 8px; border: 1px solid black; margin-top: 10px;" scope="row">Project Title
                                                    </th>
                                                    <td style="padding: 8px; border: 1px solid black;">
                                                        <strong><?= htmlspecialchars_decode($row_hackathon['our_hackathon_title']); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 8px; border: 1px solid black;" scope="row">Team Leader</th>
                                                    <td style="padding: 8px; border: 1px solid black;">
                                                        <?= htmlspecialchars_decode($row_hackathon['our_hackathon_team_leader']); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 8px; border: 1px solid black;" scope="row">Team Member</th>
                                                    <td style="padding: 8px; border: 1px solid black;">
                                                        <?= htmlspecialchars_decode($row_hackathon['our_hackathon_team_member']); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 8px; border: 1px solid black;" scope="row">Location</th>
                                                    <td style="padding: 8px; border: 1px solid black; margin-bottom: 10px;">
                                                        <strong><?= htmlspecialchars_decode($row_hackathon['our_hackathon_location']); ?></strong>
                                                    </td>
                                                </tr>
                                                <!-- Add an empty row with margin or padding here -->
                                                <tr style="height: 20px;"></tr>
                                            <?php endwhile; ?>
                                        </table>
                                    </div>
                                <?php
                                }
                                ?>
                        </section>
                    </div>
                    <!-- Code for displaying project details -->
                    <?php if ($result_project->num_rows > 0) : ?>
                        <table id="projects" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="left-curve">Projects Title</th>
                                    <th class="right-curve">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row_project = $result_project->fetch_assoc()) : ?>
                                    <tr>
                                        <td style="padding-left: 16px; font-family: Arial, Helvetica, sans-serif;">
                                            <h3 class="bottom-left-curve"><?= htmlspecialchars_decode($row_project['our_project_title1']); ?></h3>
                                        </td>
                                        <td style="padding-left: 16px;">
                                            <h4 class="bottom-right-curve"><?= htmlspecialchars_decode($row_project['our_project_description']); ?></h4>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
                <?php include '../include/importrightsidebar.php'; ?>
            </div>
        </div>
    </div>
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->


    <?php
    $cmd = $con->prepare("SELECT our_hackathon.id as our_hackathon_id,our_hackathon.title as our_hackathon_title FROM tbl_our_hackathon as our_hackathon  WHERE program_id=? AND is_active=1 AND is_delete=0 ");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $our_hackathon_id = $row['our_hackathon_id'];

            echo '<script>
                                                        var swiper = new Swiper(".mySwiper' . $our_hackathon_id . '", {
                                                            loop: true,
                                                            spaceBetween: 10,
                                                            slidesPerView: 3,
                                                            freeMode: true,
                                                            watchSlidesProgress: true,
                                                        });
                                                        var swiper2 = new Swiper(".mySwipers' . $our_hackathon_id . '", {
                                                            loop: true,
                                                            spaceBetween: 10,
                                                            navigation: {
                                                                nextEl: ".swiper-button-next",
                                                                prevEl: ".swiper-button-prev",
                                                            },
                                                            thumbs: {
                                                                swiper: swiper,
                                                            },
                                                        });
                                                        </script>';
        }
    }
    ?>

    <script>
        function showSemester(semesterId) {
            var semesterDivs = document.querySelectorAll('.semester-content');
            var semesterButtons = document.querySelectorAll('.tabBtn');

            // Hide all semester divs and remove "active" class from all buttons
            semesterDivs.forEach(function(semesterDiv) {
                semesterDiv.style.display = 'none';
            });

            semesterButtons.forEach(function(button) {
                button.classList.remove('tabBtn-active');
            });

            // Show selected semester div if it exists, otherwise show the first available semester div
            var semesterDiv = document.getElementById('sem-' + semesterId);
            if (!semesterDiv) {
                for (var i = 0; i < semesterDivs.length; i++) {
                    if (semesterDivs[i].style.display !== 'none') {
                        semesterDiv = semesterDivs[i];
                        semesterId = semesterDiv.getAttribute('id').split('-')[1];
                        break;
                    }
                }
            }

            // Show the selected semester div and add "active" class to the clicked button
            if (semesterDiv) {
                semesterDiv.style.display = 'block';
                var clickedButton = document.querySelector('.tabBtn[data-semester="' + semesterId + '"]');
                if (clickedButton) {
                    clickedButton.classList.add('tabBtn-active');
                }
            }
        }

        // Find the first available semester div and show it
        var firstSemesterDiv = document.querySelector('.semester-content');
        if (firstSemesterDiv) {
            var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
            showSemester(firstSemesterId);
        }
    </script>



    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>