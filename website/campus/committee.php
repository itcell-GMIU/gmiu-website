<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php 
    $pageTitle = "University Committees | Gyanmanjari Innovative University (GMIU)";
    $meta_description = "View official GMIU university committee documents, including regulatory, advisory, grievance, anti-ragging, and student welfare committee reports.";
    $meta_keywords = "GMIU university committees, GMIU anti-ragging, grievance redressal, student welfare committee, internal complaints, tobacco control, food safety, Gyanmanjari committees";

    ?>

    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
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

        /* Add CSS for the table */
        table {
            border-collapse: collapse;
            /* Collapse border spacing */
            width: 100%;
            /* Make table width 100% */
            border-radius: 10px;
            /* Apply border radius of 10% */
            padding: 10px;
        }

        /* Style table headers */
        th {
            background-color: #ba2a21;
            /* Apply background color to header cells */
            color: white;
            /* Set text color for header cells */

        }

        /* Style table rows */
        tr:nth-child(even) {
            background-color: #ba2a2126;
            /* Apply alternate background color to even rows */
        }

        /* Style table cells */
        td,
        th {
            border: none;
            /* Remove borders from table cells */
            padding: 8px;
            /* Add padding to table cells */
            text-align: left;
            /* Align text to left in table cells */
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
                    <h1>University Committees</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">University Committees</a></span>
                </p>
                <hr>

            </div>
        </div>
    </section>


    <div class="single-courses-area">
        <div class="container">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="events-list-03">
                            <h3 style="color:#ba2a21;" class="text-uppercase">University Committees</h3>
                            <br>
                            <div class="card"  style="margin-bottom: 50px;">
                                <table>
                                    <thead class="red-background">
                                        <tr>
                                            <th style="border-radius: 25px 0px 0px 0px;">Sr. No.</th>
                                            <th>Committee Name</th>
                                            <th style="border-radius: 0px 25px 0px 0px;">PDF Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $pdfs = [
                                            "Admission-Committee.pdf" => "Admission Committee",
                                            "Alumni-Committee.pdf" => "Alumni Committee",
                                            "Anti-Ragging-Committee.pdf" => "Anti-Ragging Committee",
                                            "Anti-Ragging-Squad.pdf" => "Anti-Ragging Squad",
                                            "Equal-Opportunity-Cell.pdf" => "Equal Opportunity Cell",
                                            "Finance-Committee.pdf" => "Finance Committee",
                                            "Internal-Complaints-and-Women-Empowerment.pdf" => "Internal Complaints and Women Empowerment",
                                            "Socio-Economically-Disadvantaged-Group-Cell.pdf" => "Socio-Economically Disadvantaged Group Cell",
                                            "Student-Grievance-Redressal-Cell.pdf" => "Student Grievance Redressal Cell",
                                            "SC-ST-Committee.pdf" => "SC/ST Committee",
                                            "IKS-Committee.pdf" => "IKS Committee",
                                            "Tobacco-Control-Committee.pdf" => "Tobacco Control Committee",
                                            "Research-Advisory-Council.pdf" => "Research Advisory Council",
                                            "Student-Service-Centre.pdf" => "Student Service Centre",
                                            "Ombudsman-Committee.pdf" => "Ombudsman Committee",
                                            "Food-Safety-Committee.pdf" => "Food Safety Committee"
                                        ];
                                        $sr = 1;
                                        foreach ($pdfs as $file => $title) {
                                            echo "<tr>
                                                    <td style='text-align:center'>$sr</td>
                                                    <td>$title</td>
                                                    <td><a href='../committee/$file' target='_blank'>$file <i class='fa fa-external-link'></i></a></td>
                                                </tr>";
                                            $sr++;
                                        }
                                        ?>
                                    </tbody>
                                  
                                </table>
                            </div>
                        </section>

                    </div>
        </div>
    </div>


    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

</body>

</html>