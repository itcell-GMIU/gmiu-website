<?php
include '../../common/importwebsitefile.php';

$limit = 8; // Number of items per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count of active, non-deleted media
$totalQuery = "SELECT COUNT(*) as total FROM `tbl_media_coverage` WHERE file_type = 'image' AND is_active = 1 AND faculty_id='0' AND is_delete = 0 ";
$totalResult = $con->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $limit);

// Fetch paginated data
$cmd = "SELECT `file`, `alt_text`, `created_at` FROM `tbl_media_coverage` 
        WHERE file_type = 'image' AND is_active = 1 AND is_delete = 0 AND faculty_id='0'
        ORDER BY id DESC LIMIT $limit OFFSET $offset";
$stmt = $con->prepare($cmd);
$stmt->execute();
$result = $stmt->get_result();

$cards = "";
$counter = 1;

while ($row = $result->fetch_assoc()) {
    $imageUrl = "{$upload_website_admin_url}media_coverage/{$row['file']}";
    $cards .= "
    <div class='col-lg-3 col-md-4 col-sm-6 col-6'>
        <div class='card shadow-sm' style='border-radius: 10px; padding: 10px; border: 1px solid red; margin-top: 10px; margin-bottom: 10px;'>
            <div class='card-img-container' style='height: 250px; overflow: hidden; display: flex; justify-content: center; align-items: center;'>
                <img src='{$imageUrl}' alt='{$row['alt_text']}' class='card-img-top' 
                    style='width: 100%; height: 100%; object-fit: cover; cursor: pointer; border-radius: 8px;'
                    data-bs-toggle='modal' data-bs-target='#imageModal{$counter}'>
            </div>
        </div>
    </div>

    <div class='modal fade' id='imageModal{$counter}' tabindex='-1' aria-labelledby='imageModalLabel{$counter}' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='col-md-12 d-flex justify-content-end'>
                  <button type='button' class='btn btn-danger btn-close' data-bs-dismiss='modal' aria-label='Close'>
                    <i class='fa-solid fa-xmark'></i>
                </button>


                </div>
                <div class='modal-body text-center'>
                    <img src='{$imageUrl}' class='img-fluid' alt='{$row['alt_text']}'>
                </div>
            </div>
        </div>
    </div>";
    $counter++;
}

// Pagination HTML
$pagination = '<li class="page-item ' . ($page == 1 ? 'disabled' : '') . '">
                    <a class="page-link" href="#" data-page="' . ($page - 1) . '">Previous</a>
               </li>';
for ($i = 1; $i <= $totalPages; $i++) {
    $pagination .= '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                        <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
                    </li>';
}
$pagination .= '<li class="page-item ' . ($page == $totalPages ? 'disabled' : '') . '">
                    <a class="page-link" href="#" data-page="' . ($page + 1) . '">Next</a>
               </li>';

echo json_encode(['cards' => $cards, 'pagination' => $pagination]);
?>