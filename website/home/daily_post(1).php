<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
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
                    <h1>DAILY POSTS</h1>
                    <!-- <p style="font-size: 14px; text-transform: capitalize;">By Department Of Computer Engineering</p> -->
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a><i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Daily Posts</a></span>
                    <!-- <span class="b-active"><a href="#">Placement</a></span> -->
                </p>
                <hr>
            </div>

        </div>

    </section>

    <!-- <div class="single-courses-area"> -->
    <div class="container">
        <div class="row">
            <section class="placed-students">
                <div class="buttons-container-flex">

                    <?php
                    //code for getting year buttons by grouping year in placement table
                    $cmd = "SELECT DISTINCT YEAR FROM tbl_daily_post WHERE is_active = 1 AND is_delete = 0 ORDER BY `year` DESC";
                    $stmt = $con->prepare($cmd);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $year = $row['YEAR'];
                    ?>
                    <button class="tabBtn"
                        onclick="placement_overview(<?php echo $year ?>)"><?php echo $year; ?></button>

                    <?php
                    }
                    ?>
                </div>
                <?php
                //code for getting year wise div of placement-cards-container

                $cmd1 = "SELECT DISTINCT YEAR, file_type FROM tbl_daily_post WHERE is_active = 1 AND is_delete = 0 GROUP BY year  ORDER BY year  DESC";
                $stmt1 = $con->prepare($cmd1);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $i = 0;
                while ($row1 = $result1->fetch_assoc()) {
                    $year1 = $row1['YEAR'];

                    if ($i == 0) {
                        //code for showing first year div
                ?>
                <div class="placement-cards-containerx" id="<?php echo $year1; ?>" style="margin-top : 10px;">
                    <?php
                            //code for getting year wise student

                            $cmd2 = "SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as dp_file_type FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 AND daily_post.is_delete=0 AND year = ? GROUP BY daily_post.date DESC ";
                            $stmt2 = $con->prepare($cmd2);
                            $stmt2->bind_param('s', $year1);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();

                            while ($row2 = $result2->fetch_assoc()) {
                                //code for showing first year div
                                $date = $row2['dp_date'];

                                echo '<div class="row" style="width:100%; padding-left:0;">
                                <p class="daily-post-p">Date : ' . $date . '</p>
                            </div>
                            
                    <div class="daily-post-area" style="">
                            ';

                                $cmd3 = $con->prepare("SELECT daily_post.file_type as dp_file_type,daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 AND daily_post.is_delete=0 AND date = '$date' AND daily_post.faculty_id = '0' ");
                                $cmd3->execute();
                                $result3 = $cmd3->get_result();
                                if ($result3->num_rows > 0) {
                                    while ($row3 = $result3->fetch_assoc()) {
                                        $file_type =  $row3['dp_file_type'];
                                        $dp_id =  $row3['dp_id'];

                                        // for video 
                                        if ($file_type == "video") {

                                            $file = $row3['dp_file'];
                                            echo '<a href="' . $file . '" target="_blank">
                                            <iframe src="' . $file . '" frameborder="0" class="daily-posts-files unclickable"></iframe> </a>';
                                        }
                                        //for image
                                        if ($file_type == "image") {
                                            $type = "daily_post";
                                            $cmd4 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0");
                                            $cmd4->bind_param("is", $dp_id, $type);
                                            $cmd4->execute();
                                            $result4 = $cmd4->get_result();
                                            // if ($result2->num_rows > 0) {
                                            while ($row4 = $result4->fetch_assoc()) {
                                                $file_name = $row4['sp_file_name'];
                                                echo '<img src="' . $upload_website_admin_url . 'daily_post/' . $file_name . '"
                                         alt="daily post" class="daily-posts-files" onclick="onClick(this)">';
                                            }
                                        }
                                    }
                                }
                                echo '</div>';
                            }
                            ?>

                </div>
                <?php
                    } else {
                        //code for hiding the other div
                    ?>
                <div class="placement-cards-containerx" id="<?php echo $year1; ?>"
                    style="display:none; margin-top : 10px;">
                    <?php
                            //code for getting year wise student

                            $cmd5 = "SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as dp_file_type FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 AND daily_post.is_delete=0 AND faculty_id = '0' AND year = ? GROUP BY daily_post.date DESC ";
                            $stmt5 = $con->prepare($cmd5);
                            $stmt5->bind_param('s', $year1);
                            $stmt5->execute();
                            $result5 = $stmt5->get_result();

                            while ($row5 = $result5->fetch_assoc()) {
                                //code for showing first year div
                                $date = $row5['dp_date'];

                                echo '<div class="row" style="width:100%; padding-left:0;">
                                <p class="daily-post-p">Date : ' . $date . '</p>
                            </div>
                            
                    <div class="daily-post-area" style="">
                            ';

                                $cmd6 = $con->prepare("SELECT daily_post.file_type as dp_file_type,daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 AND daily_post.is_delete=0 AND date = '$date' AND daily_post.faculty_id = '0' ");
                                $cmd6->execute();
                                $result6 = $cmd6->get_result();
                                if ($result6->num_rows > 0) {
                                    while ($row6 = $result6->fetch_assoc()) {
                                        $file_type =  $row6['dp_file_type'];
                                        $dp_id =  $row6['dp_id'];

                                        // for video 
                                        if ($file_type == "video") {

                                            $file = $row3['dp_file'];
                                            echo '<a href="' . $file . '" target="_blank">
                                            <iframe src="' . $file . '" frameborder="0" class="daily-posts-files unclickable"></iframe> </a>';
                                        }
                                        //for image
                                        if ($file_type == "image") {
                                            $type = "daily_post";
                                            $cmd2 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0");
                                            $cmd2->bind_param("is", $dp_id, $type);
                                            $cmd2->execute();
                                            $result2 = $cmd2->get_result();
                                            // if ($result2->num_rows > 0) {
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $file_name = $row2['sp_file_name'];
                                                echo '<img src="' . $upload_website_admin_url . 'daily_post/' . $file_name . '"
                                         alt="daily post" class="daily-posts-files" onclick="onClick(this)">';
                                            }
                                        }
                                    }
                                }
                                echo '</div>';
                            }
                            ?>

                </div>
                <?php
                    }
                    //incrementing the counter
                    $i++;
                }
                ?>

                <!-- <div class="buttons-container-flex">
                </div>
                    <div class="date-row">
                        <p class="daily-post-p">Date : 23/23/23</p>
                    </div>
                    <div class="daily-post-area" style="display: flex;">
                        <img src="<?php echo $website_assets_url; ?>images/Pranjal Parmar.jpg" class="daily-posts-files">
                        <img src="<?php echo $website_assets_url; ?>images/Pranjal Parmar.jpg" class="daily-posts-files">
                        <iframe src="https://www.youtube.com/embed/GXWfue9VhTY" frameborder="0" class="daily-posts-files"></iframe>
                    </div> -->

                <!-- Test  -->
                <div id="modal01" class="modal-ns" onclick="this.style.display='none'">
                    <span class="close">&times;</span>
                    <div class="modal-ns-content">
                        <img id="img01" style="max-width:100%">
                    </div>
                </div>

            </section>


        </div>
    </div>
    <!-- </div> -->


    <script>
    //popup modal news slide js
    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
    }
    </script>

    <!-- jQuery -->
    <script>
    //script for hide and show on year button click
    function placement_overview(year) {
        var i;
        var x = document.getElementsByClassName("placement-cards-containerx");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        var id = document.getElementById(year) /* .style.display = "block"; */

        $(id).show();

    }
    </script>


    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
    <script>
    //popup modal news slide js
    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
    }
    </script>
</body>

</html>
<style>
.placement-cards-containerx {
    padding-left: 15px;
}

.unclickable {
    pointer-events: none;
}

.modal-ns img {
    width: auto;
    height: 80vh;
}

@media only screen and (max-width: 767px) {

    /* Styles for mobile devices */
    .modal-ns img {
        width: 90vw;
        height: auto;
    }
}
</style>