<?php
include '../../common/importwebsitefile.php';
?>
<html class="no-js" lang="zxx">

<head>
      <?php 
    $meta_description = "Explore the diverse range of activities offered by GMIU’s IKSVE program, designed to enhance students’ learning experiences and provide holistic development.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    
    <?php include "../include/importhead.php"; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">


    <style>
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            /* Allows horizontal scrolling on small screens */
        }

        /* Table Container */

        #iksve_cell {
            border-collapse: separate;
            /* To allow rounded corners */
            border-spacing: 0;
            /* Optional: to prevent gaps between cells */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Adds a subtle shadow */
        }

        /* Table Header Cells */
        #iksve_cell th {
            background-color: #BA2A22;
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 16px;

            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Table Cells */
        #iksve_cell td {
            padding: 10px;
            text-align: left;
            /* border: 1px solid; */
            font-size: 14px;
            background-color: white;
        }

        /* Top-left corner */


        /* Bottom-left corner */
        #iksve_cell tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        /* Bottom-right corner */
        #iksve_cell tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }



        hr {
            margin-bottom: 20px;
            border: 0;
            border-top-width: 0px;
            border-top-style: none;
            border-top-color: currentcolor;
            border-top: 1px solid #eee;
        }

        @media screen and (max-width: 768px) {
            .flexContainer .cont {
                flex-direction: column;
            }

            .flexContainer .cont .container {
                margin-left: 0;
            }

            /* .sideBar {
                width: 100%;
            } */
        }

        @media screen and (max-width: 480px) {
            .hero .container .cont .top {
                width: 100%;
                margin-left: 0;
                text-align: center;
            }

            .flexContainer .cont .container .mySlides img {
                width: 100%;
                height: auto;
            }

            .sticky {
                width: 330px;
                height: auto;
                justify-content: center;
                align-items: center;
            }

            .sideBar {
                width: 370px;
                display: flex;
                padding-left: 20;
                padding-top: 20;
                justify-content: center;
                align-items: center;
            }

            #iksve_cell {
                box-shadow: none;
                /* Remove shadow on small screens */
            }

            /* Smaller font and padding for small screens */
            #iksve_cell th {
                padding: 15px;
                font-size: 10px;
            }

            #iksve_cell td {
                padding: 10px;
                font-size: 12px;
            }

        }
    </style>
</head>

<body class="courses">
    <?php include "../include/importheader.php"; ?>
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Activities  Of BKSVE Cell </h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">About BKSVE Cell</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <section class="about-cards">
                            <div class="about-card">
                                <div class="table-resposive">
                                    <table id="iksve_cell">
                                        <thead>
                                            <tr align="center text-white">
                                                <th scope="row" style="border-top-left-radius: 10px;"><b>ID</b></th>
                                                <th scope="row" ><b>Name</b></th>
                                                <th scope="row" ><b>Type</b></th>
                                                <th scope="row" ><b>Date</b></th>
                                                <th scope="row" style="border-top-right-radius: 10px;"><b>Participants</b></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 0;
                                            $type_id = 4;
                                            $cmd = $con->prepare("SELECT id,name,type_id,date,participants FROM tbl_iksve_cell WHERE is_delete = ? AND type_id = ?");
                                            $cmd->bind_param("ii", $status, $type_id); // type_id should be passed as a parameter
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $type = '';
                                                    if ($type_id == 4) {
                                                        $type = "Other Activities";
                                                    }


                                            ?>
                                                    <tr align="center">
                                                        <td scope="row">
                                                            <?php echo $row['id']; ?>
                                                        </td>

                                                        <td scope="row">
                                                            <?php echo $row['name']; ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $type; ?> <!-- Display the type here -->
                                                        </td>


                                                        <td scope="row">
                                                            <?php echo  $row['date']; ?>
                                                        </td>

                                                        <td scope="row">
                                                            <?php echo $row['participants']; ?>
                                                        </td>




                                                    </tr>


                                            <?php }
                                            } ?>


                                        </tbody>
                                    </table>
                                </div>



                            </div>
                        </section>
                    </div>
                </div>
                <!-- right bar start  -->
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <ul>
                                    <li>BKSVE CELL</li>
                                    <li><a href="about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                    <li><a href="vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                                   <li><a data-toggle="collapse" target="#collapse2" href="#collapse2" class="borAct collapsed" aria-expanded="false">
                                         <i class="fa fa-long-arrow-right"></i>Activities
                                         <span class="icon">
                                         <i class="fa fa-angle-down"> </i>
                                         </span>
                                         </a>  
                                         <div routerlinkactive="in" class="navSubDiv collapse"
                                            id="collapse2" aria-expanded="false" style="height: 0px;">
                                            <ul class="navSub">
                                               <li style="padding: 0px 0px;"><a href="fdp.php" ><i class="fa fa-long-arrow-right"></i>FDP</a></li>
                                               <li style="padding: 0px 0px;"><a href="sdp.php" ><i class="fa fa-long-arrow-right"></i>SDP</a></li>
                                               <li><a href="workshop_seminars.php"><i class="fa fa-long-arrow-right"></i>Workshop</a></li>
                                               <li><a href="other_activities.php" > <i class="fa fa-long-arrow-right"></i>Other Activity</a></li>
                                              </ul>
                                         </div>
                                    </li>   
                                    <li><a href="bksve_gallery_report.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                                    <li><a href="contact_us_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right bar end  -->
            </div>
        </div>
    </div>

    <?php include "../include/importfooter.php"; ?>

    <?php include "../include/importjs.php"; ?>
</body>

</html>