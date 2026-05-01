<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php
    $pageTitle = "GMIU Newsletters";
    $meta_description = "Access GMIU newsletters—find updates, articles, and departmental news conveniently in one place.";
    ?>

    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        .red-background {
            background-color: #ba2a21;
            color: white;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border-radius: 10px;
            padding: 10px;
        }

        th {
            background-color: #ba2a21;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #ba2a2126;
        }

        td,
        th {
            border: none;
            padding: 8px;
            text-align: left;
            height: 50px;
            width: auto;
        }

        .row {
            margin-right: 10px;
            margin-left: -15px;
        }

        a {
            color: #1a1a1a;
        }
    </style>
</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>GMIU Newsletters</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">Newsletters</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- Left Content -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <section class="events-list-03">
                            <div class="row card">
                                <?php
                                // Manually define the files (instead of reading from filenames.txt)
                                $files = [
                                    "CE-CSENewsletter.pdf",
                                    "ArtsNewsletter.pdf",
                                    "CivilNewsletter.pdf",
                                    "EcNewsLetter.pdf",
                                    "ElectricalNewsLetter.pdf",
                                    "ItNewsletter.pdf",
                                    "LawNewsletter.pdf",
                                    "ManagementDepartmentNewsletter.pdf",
                                    "MechanicalNewsletter.pdf",
                                    "NewsLetterDesign.pdf",
                                    "PharmacyNewsletter.pdf",
                                    "ScienceNewsletter.pdf"
                                ];

                                // Define the base URL path
                                $basePath = $website_assets_url . 'newsletter/';
                                ?>
                                <table>
                                    <thead class="red-background">
                                        <tr>
                                            <th style="border-radius: 25px 0px 0px 0px;">Name</th>
                                            <th style="border-radius: 0px 25px 0px 0px;">Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($files as $file): ?>
                                            <?php
                                            // Remove .pdf extension
                                            $displayName = pathinfo($file, PATHINFO_FILENAME);

                                            // Insert a space before capital letters (e.g., "ArtsNewsletter" -> "Arts Newsletter")
                                            $displayName = preg_replace('/(?<!^)([A-Z])/', ' $1', $displayName);

                                            // Ensure consistent spacing
                                            $displayName = trim($displayName);
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($displayName); ?></td>
                                                <td>
                                                    <a target="_blank" href="<?php echo $website_assets_url . 'newsletter/' . urlencode($file); ?>">
                                                        <?php echo htmlspecialchars($displayName); ?> <i class="fa fa-external-link"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </section>

                    </div>
                </div>
                <!-- Left Content End -->

                <!-- Sidebar -->
                <div style="width: 350px;" class="sideBar">
                    <div class="sticky">
                        <div>
                            <ul>
                                <li>Admission</li>
                                <li><a href="<?php echo $base_url_admission; ?>" class=""><i class="fa-solid fa-arrow-right"></i> Apply Online</a></li>
                                <li><a href="why_gmiu.php" class=""><i class="fa-solid fa-arrow-right"></i> Why GMIU</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php" class=""><i class="fa-solid fa-arrow-right"></i> Courses Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php" class=""><i class="fa-solid fa-arrow-right"></i> e-Brochure & Scope Documents</a></li>
                                <li><a href="importantlink.php" class=""><i class="fa-solid fa-arrow-right"></i> Important Link</a></li>
                                <li><a href="newsletter.php" class="active"><i class="fa-solid fa-arrow-right"></i> Newsletters</a></li>
                                <li><a href="education_loan.php" class=""><i class="fa-solid fa-arrow-right"></i> Education Loan Facilities</a></li>
                                <li><a href="scholarships.php" class=""><i class="fa-solid fa-arrow-right"></i> Scholarships</a></li>
                                <li><a href="transportation.php" class=""><i class="fa-solid fa-arrow-right"></i> Transportation Facilities</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Sidebar End -->

            </div>
        </div>
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php'; ?>
</body>

</html>