<?php 
include 'common/globalvariable.php';

?><!DOCTYPE html>
<html lang="en">
<head>
     
<?php include 'website/include/importcss.php'; ?>
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
    <div class="container">
      
        </div>
 
<div class="image-container">
  
  <img src="image/1(1).JPG" alt="Image 1">
  <img src="image/1(2).JPG" alt="Image 2">
  <img src="image/1(3).JPG" alt="Image 3">
  <img src="image/1(4).JPG" alt="Image 4">
  <img src="image/1(5).JPG" alt="Image 5">
  <img src="image/1(6).JPG" alt="Image 6">
  <img src="image/1(7).JPG" alt="Image 7">
  <img src="image/1(8).JPG" alt="Image 8">
  <img src="image/1(9).JPG" alt="Image 9">
   <img src="image/1(10).JPG" alt="Image 10">
</div>
</body>
</html>
