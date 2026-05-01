<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html lang="en">

<head>
    <?php
    $pageTitle = "Frequently Asked Questions - GMIU University";
    $meta_description = 'Get answers to your questions about GMIU admissions, programs, campus life, placements, and hostel facilities.'
    ?>

    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php  
    include '../include/importhead.php'; 
    include '../include/importcss.php'; ?>

    <style>
        .courses-cards {
            display: block;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 15px;
        }

        .card-for-course {
            margin-bottom: 50px;
        }
    </style>

    <!-- Schema FAQ JSON-LD -->
<!-- <script type="application/ld+json"> {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [ -->
                <?php
                // $firstEntry = true;
                // $faqSchema = "";

                // $cmd = $con->prepare("SELECT DISTINCT faculty.id AS faculty_id, faculty.name AS faculty_name
                //   FROM tbl_faculty AS faculty
                //   JOIN tbl_faq_management AS faq ON faq.faculty_id = faculty.id
                //   WHERE faculty.is_active = 1 AND faculty.is_delete = 0 AND faq.is_delete = 0");
                // $cmd->execute();
                // $result = $cmd->get_result();
                // if ($result->num_rows != 0) {
                //     while ($row = $result->fetch_assoc()) {
                //         $faculty_id = $row['faculty_id'];

                //         $query = $con->prepare("SELECT level.id AS level_id, level.name AS level_name, faq.faq_description AS level_description
                //             FROM tbl_level AS level
                //             JOIN tbl_faq_management AS faq ON faq.level_id = level.id
                //             WHERE faq.faculty_id = ? AND faq.is_delete = 0
                //             GROUP BY level.id");
                //         $query->bind_param("i", $faculty_id);
                //         $query->execute();
                //         $result2 = $query->get_result();

                //         while ($row2 = $result2->fetch_assoc()) {
                //             if (!$firstEntry) {
                //                 $faqSchema .= ",";
                //             }
                //             $faqSchema .= '{
                //         "@type": "Question",
                //         "name": "' . htmlspecialchars($row2['level_name']) . '",
                //         "acceptedAnswer": {
                //             "@type": "Answer",
                //             "text": "' . strip_tags($row2['level_description']) . '"
                //         }
                //     }';
                //             $firstEntry = false;
                //         }
                //     }
                //     echo $faqSchema;
                // }
                ?>
       <!--      ]      } -->
    </script>

</head>

<body class="courses">

    <?php include '../include/importheader.php'; ?>

    <section class="hero">
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Frequently Asked Questions (FAQ)</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="curriculum-text-box">
            <div class="curriculum-section">
                <div class="panel-group" id="accordion">

                    <?php
                    $cmd = $con->prepare("SELECT DISTINCT faculty.id AS faculty_id, faculty.name AS faculty_name
                              FROM tbl_faculty AS faculty
                              JOIN tbl_faq_management AS faq ON faq.faculty_id = faculty.id
                              WHERE faculty.is_active = 1 AND faculty.is_delete = 0 AND faq.is_delete = 0");
                    $cmd->execute();
                    $result = $cmd->get_result();
                    if ($result->num_rows != 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            $faculty_name = $row['faculty_name'];
                            $faculty_id = $row['faculty_id'];
                    ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#c<?php echo $i; ?>" class="color-gmiu"><?php echo $faculty_name; ?></a>
                                    </h2>
                                </div>
                                <div id="c<?php echo $i; ?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <section class="courses-cards">
                                            <?php
                                            $query = $con->prepare("SELECT level.id AS level_id, level.name AS level_name, faq.faq_description AS level_description
                                                        FROM tbl_level AS level
                                                        JOIN tbl_faq_management AS faq ON faq.level_id = level.id
                                                        WHERE faq.faculty_id = ? AND faq.is_delete = 0
                                                        GROUP BY level.id");
                                            $query->bind_param("i", $faculty_id);
                                            $query->execute();
                                            $result2 = $query->get_result();
                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                $level_name = $row2['level_name'];
                                                $level_description = $row2['level_description'];
                                            ?>
                                                <div class="card-for-course">
                                                    <h3 class="course-name"><?php echo $level_name; ?></h3>
                                                    <div><?php echo $level_description; ?></div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </section>
                                    </div>
                                </div>
                            </div>
                    <?php
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include '../include/importfooter.php' ?>
    <?php include '../include/importjs.php'; ?>

</body>

</html>