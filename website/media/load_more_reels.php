<?php
include '../../database/connect.php';

$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$limit = 3;

$cmd = "SELECT `file` FROM `tbl_media_coverage` WHERE file_type = 'reel' AND is_active = 1 AND is_delete = 0 AND faculty_id='0' ORDER BY id DESC LIMIT ?, ?";
$stmt = $con->prepare($cmd);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="reel-container">';
        echo '<iframe src="' . htmlspecialchars($row['file']) . '" frameborder="0"  ></iframe>';
        echo '</div>';
    }
} else {
    echo "";
}
?>