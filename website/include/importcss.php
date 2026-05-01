<!-- ✅ Google Fonts (with display=swap) -->
<!--<link rel="preload" href="'.$website_assets_url.'google_fonts.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">-->
<!--<noscript><link rel="stylesheet" href="/gmiu/website_assets/google_fonts.css"></noscript>-->

<?php
echo '
<!-- ✅ Preconnect Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>




<!-- ✅ Bootstrap -->
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/bootstrap.min.css" >


<link rel="stylesheet" href="'.$website_assets_url.'css/assets/revolution/settings.css?v=' . time() . '">

<!-- ✅ Style.css -->
<link rel="stylesheet" href="'.$website_assets_url.'css/style.css?v=' . time() . '" >



<!-- ✅ Lazy load remaining CSS -->
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/font-awesome.min.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/magnific-popup.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/revolution/layers.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/revolution/navigation.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/slick.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/slick-theme.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/meanmenu.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/responsive.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/website.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/course_offered.css" media="print" onload="this.media=\'all\'">
<link rel="stylesheet" href="'.$website_assets_url.'css/assets/swiper-bundle.min.css" media="print" onload="this.media=\'all\'">

<!-- ✅ Font Awesome CDN (use only one version) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" media="print" onload="this.media=\'all\'">

<!-- ⛔ REMOVE: Duplicated version -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->

<!-- ❌ FIX: JS is in CSS folder! Move to script section and defer -->
<!-- <script src="'.$website_assets_url.'css/assets/swiper-bundle.min.js"></script> -->
';
?>
