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
        }

        .nav-tabs>li:last-child {
            margin-right: 0;
        }

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

        .img-thumbnail {
            margin-bottom: 15px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        .modal-xl {
            max-width: 90%;
            margin: 1.75rem auto;
        }

        .modal-content {
            background-color: transparent;
            border: none;
        }

        .modal-header {
            border: none;
        }

        .modal-body img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Admission Merit</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Admission Merit</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <?php
    // Get unique years from the database
    $years_query = "SELECT DISTINCT year FROM tbl_admission_merit WHERE is_delete = '0' ORDER BY year DESC";
    $years_result = $con->query($years_query);
    $years = [];
    while ($year_row = $years_result->fetch_assoc()) {
        $years[] = $year_row['year'];
    }

    // If no years found, add current and next year
    if (empty($years)) {
        $current_year = date('Y');
        $years = [$current_year, $current_year + 1];
    }
    ?>

    <div class="single-courses-area">
        <div class="container">
            <div style="padding: 20px 0;" class="row two-colum-section">
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <section class="events-list-03">
                            <div class="container">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php
                                    foreach ($years as $index => $year) {
                                        $activeClass = $index === 0 ? 'active' : '';
                                        echo '<li role="presentation" class="' . $activeClass . '">
                                            <a href="#tab' . $year . '" aria-controls="tab' . $year . '" role="tab" data-toggle="tab">Admission ' . $year . '</a>
                                        </li>';
                                    }
                                    ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content" style="margin-top: 20px;">
                                    <?php
                                    $types = ['schedule', 'advertisement', 'merit_list'];
                                    foreach ($years as $index => $year) {
                                        $activeClass = $index === 0 ? 'in active' : '';
                                        echo '<div role="tabpanel" class="tab-pane fade ' . $activeClass . '" id="tab' . $year . '">
                                            <div class="container-fluid">';

                                        foreach ($types as $type) {
                                            // Get images for this year and type
                                            $query = "SELECT m.*, GROUP_CONCAT(DISTINCT mi.image_path) as images 
                                                    FROM tbl_admission_merit m 
                                                    LEFT JOIN tbl_admission_merit_images mi ON m.id = mi.merit_id 
                                                    WHERE m.year = ? AND m.type = ? 
                                                    AND m.is_delete = '0' AND (mi.is_delete = '0' OR mi.is_delete IS NULL)
                                                    GROUP BY m.id 
                                                    ORDER BY m.id DESC";
                                            $stmt = $con->prepare($query);
                                            $stmt->bind_param("is", $year, $type);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            // if ($result->num_rows > 0) {
                                            //     echo '<h4 class="text-uppercase" style="margin-top: 30px; color: #ba2a21; font-weight: bolder; margin-bottom: 20px; ">'
                                            //         . ucfirst(str_replace('_', ' ', $type)) . '</h4>
                                            //         <div class="row">';

                                            //     while ($row = $result->fetch_assoc()) {
                                            //         // Include both main image and additional images
                                            //       $all_images = array();
                                            //         if (!empty($row['image'])) {
                                            //             $all_images[] = $row['image'];
                                            //         }
                                            //         if (!empty($row['images'])) {
                                            //             $additional_images = explode(',', $row['images']);
                                            //             $all_images = array_merge($all_images, $additional_images);
                                            //         }
                                                    
                                            //         // Remove duplicates and empty values
                                            //         $all_images = array_unique(array_filter($all_images));
                                                    
                                            //         // ✅ Sort images by name
                                            //         sort($all_images, SORT_NATURAL | SORT_FLAG_CASE);
                                                    
                                            //         $count = 0;
                                            //         foreach ($all_images as $img) {
                                            //             if ($count % 4 == 0) echo '<div class="row">';
                                                    
                                            //             echo '<div class="col-6 col-md-3">
                                            //                     <img src="' . $base_url . '/uploads/ugc/' . $img . '" 
                                            //                         alt="' . ucfirst($type) . ' Image" 
                                            //                         class="img-responsive img-thumbnail"
                                            //                         onclick="showFullImage(this.src)">
                                            //                   </div>';
                                                    
                                            //             $count++;
                                                    
                                            //             if ($count % 4 == 0) echo '</div>';
                                            //         }
                                                    
                                            //         if ($count % 4 != 0) echo '</div>';


                                            //     }
                                            //     echo '</div>';
                                            // }
                                        }
                                        echo '</div></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="fullImage" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <?php include '../include/importfooter.php' ?>
    <?php include '../include/importjs.php'; ?>

    <script>
        function showFullImage(src) {
            document.getElementById('fullImage').src = src;
            $('#imageModal').modal('show');
        }
    </script>
</body>

</html>