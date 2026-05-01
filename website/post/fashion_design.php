<?php 
include '../../common/globalvariable.php';

?><!DOCTYPE html>
<html lang="en">
<head>
<?php include '../include/importcss.php'; ?>
<link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">
<link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fashion Design</title>
<style>
 
.image-container {
  max-width: 100%;
  /* padding: 20px; */
  display: flex;
  flex-direction: column;
  align-items: center;
}

.image-container img {
  width: 100%;
  /* height: auto; */
  margin: 10px 0;
}

@media (max-width: 768px) {
  .image-container {
    max-width: 100%;
  }
}
 .reel-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 10px;
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
            width: 95%;
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
     <img src="<?php echo $website_assets_url; ?>images/fashion_design-1.jpeg" alt="Image 4">
    <img src="<?php echo $website_assets_url; ?>images/fashion_design-3.jpeg" alt="Image 4">
    <img src="<?php echo $website_assets_url; ?>images/fashion_design-2.jpeg" alt="Image 4">
   


<h2 class="text-center">Shorts</h2>

  <div class="reel-wrapper">
        <div class="reel-container">
            <iframe src="https://youtube.com/embed/V06Ts64-MOw?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
        <div class="reel-container">
            <iframe src="https://youtube.com/embed/GXsM72_ZX6c?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
          <div class="reel-container">
            <iframe src="https://youtube.com/embed/UoHxFq34D8g?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
       <div class="reel-container">
            <iframe src="https://youtube.com/embed/1bqmfPdwMEU?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
        <div class="reel-container">
            <iframe src="https://youtube.com/embed/cL6ziGSgsd0?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
        <div class="reel-container">
            <iframe src="https://youtube.com/embed/G5ycFNE2hdg?autoplay=0&mute=0&rel=0" title="YouTube video player" frameborder="0"></iframe>
        </div>
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

  <?php include '../include/importjs.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
          
</body>
</html>
