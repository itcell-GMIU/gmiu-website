<?php
include '../../common/importwebsitefile.php';

// Fetch available years from the database
$query = "SELECT DISTINCT YEAR(created_at) AS year FROM `tbl_media_coverage` WHERE file_type = 'image' AND is_active = 1 AND faculty_id='0' AND is_delete = 0   AND YEAR(created_at) != 0 ORDER BY year DESC";
$result = $con->query($query);
$years = [];
while ($row = $result->fetch_assoc()) {
    $years[] = $row['year'];
}
$latestYear = !empty($years) ? $years[0] : date('Y');

?>

<!doctype html>
<html lang="en">

<head>
    <?php $pageTitle = "Gyanmanjari Innovative University in Newspaper."; ?>
    <?php $meta_description = "Read about GMIU in the news. Explore media coverage and newspaper highlights of our achievements, events, and announcements."; ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">

    <style>
        #galleryGrid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .gallery-item {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2);
            transition: all ease-in-out 0.2s;
            padding: 10px;
            /* Padding inside each gallery item for spacing */
        }

        .gallery-item:hover {
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
            /* Slightly enlarge the item on hover */
        }

        /* Image wrapper to position date */
        .image-wrapper {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
        }


        /* Image itself */
        .image-wrapper img {
            width: 100%;
            height: 220px;
            object-fit: contain;
            display: block;
            cursor: pointer;
        }

        /* Date label on the image */
        .date-label {
            position: absolute;
            top: 10px;
            left: 10px;
            /* background: rgba(0, 0, 0, 0.7); */
            background: #ba2a21;
            color: #fff;
            /* color: #000; */
            font-size: 12px;
            padding: 5px 8px;
            border-radius: 5px;
        }

        /* Hover effect */
        .gallery-item:hover {
            transform: scale(1.03);
        }

        /* For iframe (video) */
        .gallery-item iframe {
            width: 100%;
            height: 220px;
            border: none;
            border-radius: 8px;
        }

        .year-selector {
            /* text-align: center; */
            margin-bottom: 20px;
        }

        .year-btn {
            background: #727272;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 0 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .year-btn:hover {
            background: #ba2a21;
        }

        #loadMoreBtn {
            margin-top: 20px;
            display: block;
            width: 200px;
            padding: 10px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 10px;
            background: #ba2a21;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #loadMoreBtn:hover {
            background: #9f2d26;
        }

        .img-modal {
            max-height: 90vh;

        }

        .modal-ns img {
            width: auto;
            height: 90vh;
        }

        @media(max-width:480px) {

            .modal-ns img {
                width: 90vw;
                height: auto;
            }
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
                    <h1>Newspaper</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">Newspaper</span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="container">
        <!-- Year selection buttons -->
        <div class="year-selector">
            <?php foreach ($years as $year): ?>
                <button class="year-btn" onclick="changeYear(<?php echo $year; ?>)"><?php echo $year; ?></button>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="gallery-grid" id="galleryGrid">
                <!-- Initial 30 images will be loaded here -->
            </div>

            <button id="loadMoreBtn">Load More</button>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div id="modal01" class="modal-ns" onclick="this.style.display='none'">
        <span class="close">&times;</span>
        <div class="modal-ns-content">
            <img id="img01">
        </div>
    </div>

    <?php include '../include/importfooter.php'; ?>

    <?php include '../include/importjs.php'; ?>

    <script>
    const latestYear = <?php echo json_encode($latestYear); ?>;
    let start = 0;
    const limit = 15;
    let selectedYear = latestYear;

    function changeYear(year) {
        selectedYear = year;
        start = 0;
        $('#galleryGrid').empty();
        loadPosts();
    }

    function loadPosts() {
        $.ajax({
            url: 'fetch_media.php',
            method: 'POST',
            data: {
                start: start,
                limit: limit,
                year: selectedYear
            },
            success: function(response) {
                if (response.trim() !== '') {
                    $('#galleryGrid').append(response);
                    start += limit;
                } else {
                    $('#loadMoreBtn').hide();
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Load first posts
    loadPosts();

    $('#loadMoreBtn').click(function() {
        setTimeout(function() {
            loadPosts();
            console.log("helloo");
        }, 1000);
    });

    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
    }
</script>


</body>

</html>