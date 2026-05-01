<?php
include '../../common/importwebsitefile.php';
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 30;
$year = isset($_POST['year']) ? intval($_POST['year']) : date('Y');  // Use 'year' from AJAX

// Fetch posts for the selected year
$stmt = $con->prepare("SELECT `file`, `alt_text`, `created_at` FROM `tbl_media_coverage` 
                       WHERE file_type = 'image' AND is_active = 1 AND is_delete = 0 AND faculty_id='0' 
                       AND YEAR(created_at) = ? 
                       ORDER BY created_at DESC 
                       LIMIT ?, ?");
$stmt->bind_param("iii", $year, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $url = "https://gmiu.edu.in/gmiu/website_admin/uploads/";

    echo '<div class="gallery-item shadow">
            <div class="image-wrapper">
                <img src="' . $url . 'media_coverage/' . $row['file'] . '"
                     alt="' . $row['alt_text'] . '" onclick="onClick(this)">
               <div class="date-label">' . date('d M Y', strtotime($row['created_at'])) . '</div>
            </div>
          </div>';
}
