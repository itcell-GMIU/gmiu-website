<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Admission Merit of Gyanmanjari Innovative University | GMIU";
    $meta_description = "Explore admission details for 2023 to 2025 including advertisements, merit lists, and schedules. View organized tab-wise images for each academic year to stay updated with the latest information.";
    ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <style>
        .nav-tabs>li {
            margin-right: 8px;
            /* Adjust spacing as needed */
        }

        /* Optional: remove right margin from the last tab */
        .nav-tabs>li:last-child {
            margin-right: 0;
        }

        /* Your previous styling (active/inactive) */
        .nav-tabs>li.active>a,
        .nav-tabs>li.active>a:focus,
        .nav-tabs>li.active>a:hover {
            background-color: #ba2a21;
            color: white;
            border-color: #ba2a21;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            z-index: 1;
            position: relative;
        }

        .nav-tabs>li>a {
            background-color: #eaeaea;
            color: #333;
            border-color: #ddd;
        }

        .nav-tabs>li>a:hover {
            background-color: #dcdcdc;
            color: #000;
        }
        .nav-tabs {
            border-bottom: 0px;
        }
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
                    <h1>Admission Merit</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Admission Merit</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <?php
    $admissions = [
        'Admission 2023-24' => [
            'Schedule' => ['admission process phase 1 2023-24_page-0001.jpg','admission process phase 2 23-24_page-0001.jpg','admission process, PG 23-24_page-0001.jpg'],
            'Advertisement' => ['UG AD Phase 1 2023-24.jpeg','UG AD Phase 2 2023-24.jpeg','PG AD  2023-24.jpeg'],
            'Merit List' => [],
        ],
        'Admission 2024-25' => [
            'Schedule' => ['admission process phase 1 24-25_page-0001.jpg', 'admission process phase 2 24-25_page-0001.jpg','PG admission process 24-25_page-0001.jpg'],
            'Advertisement' => ['UG AD Phase 1 2024-25.jpeg','UG AD Phase 2  2024-25.jpeg','PG AD 2024-25.jpeg'],
            'Merit List' => [],
        ],
        'Admission 2025-26' => [
            'Schedule' => [],
            'Advertisement' => [],
            'Merit List' => [],
        ],
       
       
    ];
    ?>

    <div class="single-courses-area">
        <div class="container">
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <section class="events-list-03">
                            <div class="container">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php
                                    $tabIndex = 1;
                                    foreach ($admissions as $title => $sections) {
                                        $activeClass = $tabIndex === 1 ? 'active' : '';
                                        echo '<li role="presentation" class="' . $activeClass . '">
                                            <a href="#tab' . $tabIndex . '" aria-controls="tab' . $tabIndex . '" role="tab" data-toggle="tab">' . $title . '</a>
                                        </li>';
                                        $tabIndex++;
                                    }
                                    ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content" style="margin-top: 20px;">
                                    <?php
                                    $tabIndex = 1;
                                    foreach ($admissions as $title => $sections) {
                                        $activeClass = $tabIndex === 1 ? 'in active' : '';
                                        echo '<div role="tabpanel" class="tab-pane fade ' . $activeClass . '" id="tab' . $tabIndex . '">
                                                <div class="container-fluid">';
                                        foreach ($sections as $sectionTitle => $images) {
                                            echo '<h4 class="text-uppercase" style="margin-top: 30px; color: #ba2a21; font-weight: bolder; margin-bottom: 20px; ">' . $sectionTitle . '</h4>
                                                <div class="row">';
                                            foreach ($images as $img) {
                                                echo '<div class="col-xs-6 col-sm-3">
                                                <img src="https://gmiu.edu.in/gmiu/website/admission/images/' . $img . '" alt="' . $sectionTitle . '" class="img-responsive img-thumbnail">
                                                </div>';
                                            }
                                            echo '</div>';
                                        }
                                        echo '</div></div>';
                                        $tabIndex++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>


                    </div>
                </div>
                <!-- left bar end -->



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