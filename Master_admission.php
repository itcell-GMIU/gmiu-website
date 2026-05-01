<?php 
include 'common/globalvariable.php';

?><!DOCTYPE html>
<html lang="en">
<head>
    
<?php include 'website/include/importcss.php'; ?>
<link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">
<link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Master Admission</title>
<style>
 
.image-container {
  max-width: 100%;
  padding: 20px;
  display: flex;
  flex-wrap: wrap; /* Allows wrapping to create multiple rows */
  justify-content: space-between; /* Ensures spacing between images */
  gap: 10px; /* Adjust space between images */

}

.image-container1 img{  
  width: 1274px;
  padding: 20px;
  display: flex;
  flex-wrap: wrap; /* Allows wrapping to create multiple rows */
  justify-content: space-between; /* Ensures spacing between images */
  gap: 10px; /* Adjust space between images */

}

.image-container1 img {
  width: 100%; /* 50% width for each image minus the gap */
  margin: 10px 0;
  border: 2px solid #ccc; /* Adds a light gray border */
  border-radius: 10px; /* Rounds the corners */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds a soft shadow */
}

.image-container img {
  width: calc(50% - 10px); /* 50% width for each image minus the gap */
  margin: 10px 0;
  border: 2px solid #ccc; /* Adds a light gray border */
  border-radius: 10px; /* Rounds the corners */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds a soft shadow */
}

@media (max-width: 768px) {
  .image-container {
    max-width: 100%;
  }
  .image-container1 {
    max-width: 100%;
  }
  .image-container img {
    width: 100%; /* Make images full-width on mobile */
    margin: 0; 
  }
}

 .reel-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .reel-container {
            flex: 0 0 calc(25% - 20px); /* Each reel takes up 1/3 of the row minus the gap */
            max-width: calc(25% - 20px);
            height: 250px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .reel-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
         h2{
          margin-top: 50px;
          font-size: 40px;
          color: #c50404;
        }

        @media (max-width: 767px) { /* Mobile screens */
            .reel-container {
                flex: 0 0 100%; /* Each reel takes up 100% of the row */
                max-width: 100%;
            }
        }
          .trausted-stu-area {
            display: flex;
            margin: 50px 20px;
        }
        .trausted-stu-area .row {
            margin: 0 auto;
            width: 100%;
        }
        .trausted-stu-btn {
            text-transform: uppercase;
            margin: 42px 0;
            padding: 5px 0;
            border-radius: 5px;
            background: #ba2a21;
            text-align: center;
            transition: all 0.3s;
        }
        
        .blink-border {
            border: 2px solid red;
            animation: blink 1s infinite;
        }

</style>
</head>
<body>
    
<div class="container">

<a href="https://api.whatsapp.com/send?phone=917574949494&text=Hello%20I%20Am%20Interested%20in%20Admission" class="float" target="_blank">
        <i class="fa-brands fa-whatsapp my-float"></i>
    </a>

<div class="image-container">
    <!--<img src="<?php //echo $upload_website_admin_url; ?>bitly_post/2024-06-27-87-3.jpg" alt="Image 4">-->
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/1.jpg" alt="Image 4">
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/2.jpg" alt="Image 3">
    <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/3.jpg" alt="Image 5">
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/4.jpg" alt="Image 6">
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/5.jpg" alt="Image 7">
   <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/6.jpg" alt="Image 2">
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/7.jpg" alt="Image 8">
  <img src="https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/8.jpg" alt="Image 1">
  
  </div>
  <div class="image-container1">
  <img src="https://gmiu.edu.in/gmiu/website_assets/images/postpressnotes/Degree_leaflet.jpg" alt="Image 1">
    </div>
  <h2 class="text-center">Shorts</h2>

  <div class="reel-wrapper">
        <div class="reel-container">
            <iframe src="https://youtube.com/embed/idQjNB_-HSY?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
        <div class="reel-container">
            <iframe src="https://youtube.com/embed/__G8fdHKzoc?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
          <div class="reel-container">
            <iframe src="https://youtube.com/embed/Z_NO8zc1b2I?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
       <div class="reel-container">
            <iframe src="https://youtube.com/embed/dXPormO_5t8?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
    </div>



  <!-- apply now box -->
  <section class="trausted-stu-area">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="trausted-content">
                        <div class="row border-box-admission blink-border">
                            <div class="col-sm-12 col-md-9">
                                <h3 class="title gradText" style="font-size: 17px;">ADMISSION 2025-26</h3>
                                <hr>
                                <h3 class="section-h-medium">For admission regarding query:</h3>
                                <p><i class="fa-solid fa-phone"></i> <span class="mobile-number"> +91 90999 51160, </span><span class="mobile-number"> +91 75749 49494</span> </p>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="trausted-stu-btn">
                                    <a href="<?php echo $base_url_admission; ?>" class="">Apply Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

</div>

 <?php include 'website/include/importjs.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
          
</body>
</html>