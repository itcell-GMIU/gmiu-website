<?php
include '../../common/globalvariable.php';
include '../../database/connect.php';
include '../../common/function.php';
include '../../common/validation.php';
// Fetch the current URL
$currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// Extract the last segment of the URL and remove the .php extension
$urlSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
$lastSegment = end($urlSegments);
$lastSegmentName = basename($lastSegment, '.php');
// Output the current URL and last segment name
$cmd = $con->prepare('SELECT id FROM tbl_bitly_post WHERE name = ?');
$cmd->bind_param('s', $lastSegmentName);
$cmd->execute();
$photo_result = $cmd->get_result();
$row1 = $photo_result->fetch_assoc(); 
$type_id = $row1['id'];
$imageFile = '../../website_admin/uploads/bitly_post/';
$imagetype = 'Bitly Multiple Post';
$cmd = $con->prepare('SELECT photos.file_name AS file_name FROM `tbl_site_photos` AS photos WHERE photos.type_id = ? AND photos.type = ?');
$cmd->bind_param('is', $type_id, $imagetype);
$cmd->execute();
$photo_result = $cmd->get_result();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Centered Images</title>
<style>
.body {
  margin: 0;
  padding: 0;
  overflow-x: hidden;
}
.image-container {
   width: 100%;
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-sizing: border-box;
}
.image-container img {
  max-width: 100%;
  margin: 10px 0;
}
@media (max-width: 768px) {
  .image-container {
    max-width: 100%;
  }
}
</style>
</head>
<body>
 
<div class='image-container'>
<?php
while ($row = $photo_result->fetch_assoc()) {
$file_name = $row['file_name'];
echo '<img src="' . $imageFile . $file_name . '"  alt="Image">';
}
?>
</div>
</body>
</html>
