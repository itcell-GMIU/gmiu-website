<?php
include '../../common/importwebsitefile.php';
$upload_website_admin_url = 'https://gmiu.edu.in/gmiu/website_admin/uploads/';
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 30;
$year = isset($_POST['year']) ? intval($_POST['year']) : date('Y');  // Use 'year' from AJAX

// Fetch posts for the selected year
$stmt = $con->prepare("SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as dp_file_type, daily_post.file as dp_file 
                       FROM tbl_daily_post as daily_post 
                       WHERE daily_post.is_active=1 AND daily_post.is_delete=0 AND daily_post.faculty_id=0 AND daily_post.file_type = 'image' AND YEAR(daily_post.date) = ? 
                       ORDER BY daily_post.date DESC 
                       LIMIT ?, ?");
$stmt->bind_param("iii", $year, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $file_type = $row['dp_file_type'];
    $dp_file = $row['dp_file'];
    $dp_id = $row['dp_id'];

    if ($file_type == 'image') {
        // Fetch image from tbl_site_photos
        $type = 'daily_post';
        $stmt2 = $con->prepare("SELECT sp.file_name FROM tbl_site_photos as sp WHERE sp.type_id = ? AND sp.type = ? AND sp.is_active = 1 AND sp.is_delete = 0");
        $stmt2->bind_param("is", $dp_id, $type);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        while ($img = $result2->fetch_assoc()) {
            echo '<div class="gallery-item shadow">
            <div class="image-wrapper">
                <img src="' . $upload_website_admin_url . 'daily_post/' . $img['file_name'] . '" alt="Daily Post" onclick="onClick(this)">
                <div class="date-label">' . date('d M Y', strtotime($row['dp_date'])) . '</div>
            </div>
          </div>';
        }
     } 
    // else if ($file_type == 'video') {
    //     echo '<div class="gallery-item">
    //             <iframe src="' . $dp_file . '" frameborder="0" class="daily-posts-files" style="width:100%;height:250px;"></iframe>
    //           </div>';
    // }
}
