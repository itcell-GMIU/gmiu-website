<?php

include '../../common/importwebsitefile.php';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php 
    $pageTitle = "Circular of Gyanmanjari Innovative University";
        $meta_description = "Stay informed with GMIU circulars—latest announcements, notices, and updates for students, faculty, and staff to support smooth academic operations.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../admin_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .des p {
            margin: 10px 0px 0px 0px !important;
        }

        .card-shadow {
            box-shadow: rgba(0, 0, 0, 0.20) 0px 3px 8px;
            border-radius: 5px;
        }

        .card-shadow .table {
            text-align: center;
        }

        .hover-up {
            color: #ba2a21;
            font-size: 15px;
        }

        .hover-up:hover {
            transform: translateY(-20px);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 12px;
            margin-right: 5px;
            color: #000;
            background-color: #f2f2f2;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .pagination a.active {
            background-color: #ff0000;
            color: #fff;
        }

        .hidden {
            display: none;
            padding: 20px;
            background-color: #f0f0f0;
        }
    </style>
</head>

<body class="courses">
    <!--   Preloader -->
    <!-- <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> -->
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Circular</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active">Latest Circular</span>
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
                        <section class="placed-students">
                            <h3 class="title gradText">SYLLABUS & TEACHING SCHEME</h3>
                            <hr>
                            <div class="buttons-container-flex">
                                <button class="tabBtn tabBtn-active" id="showDiv1Button">All</button>
                                <button class="tabBtn" id="showDiv2Button">Exam Circular</button>
                                <button class="tabBtn" id="showDiv3Button">Academic Circular</button>

                            </div>
                        </section>
                        <!-- Faculty about  -->
                        <div class="pagination" id="pagination1"></div>
                        <section class="des circular" style="margin-top: 40px;" id="div1">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Sr No.</b></th>
                                                <th scope="row" style="color:black;"><b>Title</b></th>
                                                <th scope="row" style="color:black;"><b>Date</b></th>
                                                <th scope="row" style="color:black;"><b>Link</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //code for getting year buttons by grouping year in placement table
                                            $cmd2 = "SELECT title,YEAR(date),MONTH(date),DAY(date),file_name FROM tbl_circular WHERE is_active = 1 AND is_delete = 0 ORDER BY date DESC";
                                            $stmt2 = $con->prepare($cmd2);
                                            $stmt2->execute();
                                            $result2 = $stmt2->get_result();
                                            $srno = 0;

                                            while ($row2 = $result2->fetch_assoc()) {
                                                $monthNames = array(
                                                    1 => 'January',
                                                    2 => 'February',
                                                    3 => 'March',
                                                    4 => 'April',
                                                    5 => 'May',
                                                    6 => 'June',
                                                    7 => 'July',
                                                    8 => 'August',
                                                    9 => 'September',
                                                    10 => 'October',
                                                    11 => 'November',
                                                    12 => 'December'
                                                );
                                                $title = $row2['title'];
                                                $date = "{$row2['DAY(date)']} {$monthNames[$row2['MONTH(date)']]} {$row2['YEAR(date)']}";
                                                $file_name = $row2['file_name'];
                                                $srno++;
                                                ?>
                                                <tr>
                                                    <td scope="row"><?php echo $srno; ?></td>
                                                    <td scope="row"><?php echo $title; ?></td>
                                                    <td scope="row"><?php echo $date; ?></td>
                                                    <td scope="row"> <a
                                                            href="<?php echo $upload_website_admin_url . 'circular/' . $file_name; ?>"
                                                            class="hover-up"><?php echo $title; ?> <i
                                                                class="fa fa-external-link"></i></a></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Sr No.</b></th>
                                                <th scope="row" style="color:black;"><b>Title</b></th>
                                                <th scope="row" style="color:black;"><b>Date</b></th>
                                                <th scope="row" style="color:black;"><b>Link</b></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <div class="pagination" id="pagination1"></div>
                        <section class="des2 circular" style="margin-top: 20px; display:none;" id="div2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Sr No.</b></th>
                                                <th scope="row" style="color:black;"><b>Title</b></th>
                                                <th scope="row" style="color:black;"><b>Date</b></th>
                                                <th scope="row" style="color:black;"><b>Link</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //code for getting year buttons by grouping year in placement table
                                            $cmd2 = "SELECT title,YEAR(date),MONTH(date),DAY(date),file_name FROM tbl_circular WHERE is_active = 1 AND is_delete = 0 AND type = 'Exam' ORDER BY date DESC";
                                            $stmt2 = $con->prepare($cmd2);
                                            $stmt2->execute();
                                            $result2 = $stmt2->get_result();
                                            $srno = 0;

                                            while ($row2 = $result2->fetch_assoc()) {
                                                $monthNames = array(
                                                    1 => 'January',
                                                    2 => 'February',
                                                    3 => 'March',
                                                    4 => 'April',
                                                    5 => 'May',
                                                    6 => 'June',
                                                    7 => 'July',
                                                    8 => 'August',
                                                    9 => 'September',
                                                    10 => 'October',
                                                    11 => 'November',
                                                    12 => 'December'
                                                );
                                                $title = $row2['title'];
                                                $date = "{$row2['DAY(date)']} {$monthNames[$row2['MONTH(date)']]} {$row2['YEAR(date)']}";
                                                $file_name = $row2['file_name'];
                                                $srno++;
                                                ?>
                                                <tr>
                                                    <td scope="row"><?php echo $srno; ?></td>
                                                    <td scope="row"><?php echo $title; ?></td>
                                                    <td scope="row"><?php echo $date; ?></td>
                                                    <td scope="row"> <a
                                                            href="<?php echo $upload_website_admin_url . 'circular/' . $file_name; ?>"
                                                            class="hover-up"><?php echo $title; ?> <i
                                                                class="fa fa-external-link"></i></a></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Sr No.</b></th>
                                                <th scope="row" style="color:black;"><b>Title</b></th>
                                                <th scope="row" style="color:black;"><b>Date</b></th>
                                                <th scope="row" style="color:black;"><b>Link</b></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <div class="pagination" id="pagination2"></div>

                        <section class="des3 circular" style="margin-top: 20px; display:none;" id="div3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Sr No.</b></th>
                                                <th scope="row" style="color:black;"><b>Title</b></th>
                                                <th scope="row" style="color:black;"><b>Date</b></th>
                                                <th scope="row" style="color:black;"><b>Link</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch academic circulars
                                            $cmd2 = "SELECT title, YEAR(date) AS year, MONTH(date) AS month, DAY(date) AS day, file_name 
                                     FROM tbl_circular 
                                     WHERE is_active = 1 AND is_delete = 0 AND type = 'Academic' 
                                     ORDER BY date DESC";
                                            $stmt2 = $con->prepare($cmd2);
                                            $stmt2->execute();
                                            $result2 = $stmt2->get_result();
                                            $srno = 0;

                                            while ($row2 = $result2->fetch_assoc()) {
                                                $monthNames = array(
                                                    1 => 'January',
                                                    2 => 'February',
                                                    3 => 'March',
                                                    4 => 'April',
                                                    5 => 'May',
                                                    6 => 'June',
                                                    7 => 'July',
                                                    8 => 'August',
                                                    9 => 'September',
                                                    10 => 'October',
                                                    11 => 'November',
                                                    12 => 'December'
                                                );
                                                $title = $row2['title'];
                                                $date = "{$row2['day']} {$monthNames[$row2['month']]} {$row2['year']}";
                                                $file_name = $row2['file_name'];
                                                $srno++;
                                                ?>
                                                <tr>
                                                    <td scope="row"><?php echo $srno; ?></td>
                                                    <td scope="row"><?php echo $title; ?></td>
                                                    <td scope="row"><?php echo $date; ?></td>
                                                    <td scope="row"> <a
                                                            href="<?php echo $upload_website_admin_url . 'circular/' . $file_name; ?>"
                                                            class="hover-up"><?php echo $title; ?> <i
                                                                class="fa fa-external-link"></i></a></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Sr No.</b></th>
                                                <th scope="row" style="color:black;"><b>Title</b></th>
                                                <th scope="row" style="color:black;"><b>Date</b></th>
                                                <th scope="row" style="color:black;"><b>Link</b></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="pagination" id="pagination3"></div>
                </div>
                <!-- left bar end  -->

                <!-- right bar start  -->
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <div>
                                    <ul>
                                        <li>
                                            Latest Updates
                                        </li>
                                        <li>
                                            <!----><a href="<?php echo $base_url_website_home; ?>circular.php"
                                                class="active"> <i class="fa fa-long-arrow-right"></i> Circular / event
                                            </a><!----><!----><!---->
                                        </li>
                                        <li>
                                            <!----><a href="<?php echo $base_url_website_home; ?>workshop.php"> <i
                                                    class="fa fa-long-arrow-right"></i> Seminar / workshop
                                            </a><!----><!----><!---->
                                        </li>
                                        <li>
                                            <!----><a href="<?php echo $base_url_website_home; ?>project.php"> <i
                                                    class="fa fa-long-arrow-right"></i> Project - Social impact project
                                            </a><!----><!----><!---->
                                        </li>
                                        <li>
                                            <!----><a href="<?php echo $base_url_website_home; ?>placement.php"> <i
                                                    class="fa fa-long-arrow-right"></i> Regular update of placement
                                            </a><!----><!----><!---->
                                        </li>
                                        <li>
                                            <!----><a href="<?php echo $base_url_website_home; ?>industrial_visit.php">
                                                <i class="fa fa-long-arrow-right"></i> Industrial visit
                                            </a><!----><!----><!---->
                                        </li>
                                        <!-- <li> -->
                                        <!-- <a href="/iepprogram"> <i class="fa fa-long-arrow-right"></i> IEP </a> -->
                                        <!-- </li> -->
                                        <li>
                                            <!----><a href="<?php echo $base_url_website_home; ?>sdp.php"> <i
                                                    class="fa fa-long-arrow-right"></i> SDP </a><!----><!----><!---->
                                        </li>
                                        <!-- <li>
                    <a href="/mastermind"> <i class="fa fa-long-arrow-right"></i> Mastermind </a>
                    </li>
                    <li>
                    <a href="/sports"> <i class="fa fa-long-arrow-right"></i> Sports </a>
                    </li>
                    <li>
                    <a href="/cwp"> <i class="fa fa-long-arrow-right"></i> Parent connect </a>
                    </li> -->
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

    <!-- jQuery (Load first) -->
    <script src="../../admin_assets/plugins/jquery/jquery.min.js"></script>

    <!-- DataTables -->
    <script src="../../admin_assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../admin_assets/plugins/jszip/jszip.min.js"></script>
    <script src="../../admin_assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../admin_assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cardsPerPage = 10;

            function showPage(container, page) {
                const cards = container.querySelectorAll('.circular-card');
                const startIndex = (page - 1) * cardsPerPage;
                const endIndex = startIndex + cardsPerPage;

                cards.forEach((card, index) => {
                    if (index >= startIndex && index < endIndex) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            function renderPagination(container, paginationContainer, currentPage) {
                const totalCards = container.querySelectorAll('.circular-card').length;
                const totalPages = Math.ceil(totalCards / cardsPerPage);

                paginationContainer.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const link = document.createElement('a');
                    link.href = '#';
                    link.textContent = i;
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        currentPage = i;
                        showPage(container, currentPage);
                        updatePagination(paginationContainer, currentPage);
                    });

                    if (i === currentPage) {
                        link.classList.add('active');
                    }

                    paginationContainer.appendChild(link);
                }
            }

            function updatePagination(paginationContainer, currentPage) {
                const paginationLinks = paginationContainer.querySelectorAll('a');

                paginationLinks.forEach((link, index) => {
                    if (index + 1 === currentPage) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }

            // Add event listeners for your tab buttons
            document.getElementById("showDiv1Button").addEventListener("click", () => {
                switchSection('#div1', '#pagination1');
            });

            document.getElementById("showDiv2Button").addEventListener("click", () => {
                switchSection('#div2', '#pagination2');
            });

            document.getElementById("showDiv3Button").addEventListener("click", () => {
                switchSection('#div3', '#pagination3');
            });

            function switchSection(sectionSelector, paginationSelector) {
                const sections = ['#div1', '#div2', '#div3'];
                const paginations = ['#pagination1', '#pagination2', '#pagination3'];

                sections.forEach((selector) => {
                    document.querySelector(selector).style.display = selector === sectionSelector ? 'block' : 'none';
                });

                paginations.forEach((selector) => {
                    document.querySelector(selector).style.display = selector === paginationSelector ? 'block' : 'none';
                });

                const container = document.querySelector(sectionSelector);
                const paginationContainer = document.querySelector(paginationSelector);
                let currentPage = 1;

                showPage(container, currentPage);
                renderPagination(container, paginationContainer, currentPage);
            }

            // Initialize the first section
            switchSection('#div1', '#pagination1');
        });

    </script>
    <script>
        const showDiv1Button = document.getElementById("showDiv1Button");
        const showDiv2Button = document.getElementById("showDiv2Button");
        const showDiv3Button = document.getElementById("showDiv3Button");
        const div1 = document.getElementById("div1");
        const div2 = document.getElementById("div2");
        const div3 = document.getElementById("div3");

        showDiv1Button.addEventListener("click", () => {
            div1.style.display = "block";
            div2.style.display = "none";
            div3.style.display = "none";

            showDiv1Button.classList.add("tabBtn-active");
            showDiv2Button.classList.remove("tabBtn-active");
            showDiv3Button.classList.remove("tabBtn-active");
        });

        showDiv2Button.addEventListener("click", () => {
            div1.style.display = "none";
            div2.style.display = "block";
            div3.style.display = "none";

            showDiv2Button.classList.add("tabBtn-active");
            showDiv1Button.classList.remove("tabBtn-active");
            showDiv3Button.classList.remove("tabBtn-active");
        });
        showDiv3Button.addEventListener("click", () => {
            div1.style.display = "none";
            div2.style.display = "none";
            div3.style.display = "block";

            showDiv3Button.classList.add("tabBtn-active");
            showDiv2Button.classList.remove("tabBtn-active");
            showDiv1Button.classList.remove("tabBtn-active");
        });
    </script>

    <!-- DataTable - copy, csv, excel, pdf, print, colvis -->
    <script>
        $(document).ready(function () {
            var table = $('.dataTableLoad').DataTable({
                "dom": 'Blfrtip',
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": []
            }).buttons().container().appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>