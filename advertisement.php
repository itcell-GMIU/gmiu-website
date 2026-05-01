<?php 
include 'common/globalvariable.php';

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Centered Images</title>
<style>
 
.image-container {
  max-width: 100%;
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.image-container img {
  max-width: 100%;
  /* height: auto; */
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

<div class="image-container">
   
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/placements.jpg" alt="Image 1">
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/results.jpg" alt="Image 2">
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/sports.jpg" alt="Image 3">
   <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/national_awards.jpg" alt="Image 5">
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/irc.jpg" alt="Image 4"> 
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/courses.jpg" alt="Image 6">
 
 
</div>
</body>
</html>
