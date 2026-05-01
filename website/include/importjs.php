<?php 
echo '<!-- Bootstrap JS -->
<script src="'.$website_assets_url.'js/jquery.js"></script>

<script src="'.$website_assets_url.'js/vendor/jquery-1.12.4.min.js"></script>
<script src="'.$website_assets_url.'js/assets/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
    integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- owl carousel -->
<script src="'.$website_assets_url.'js/assets/owl.carousel.min.js"></script>
<!-- Revolution Slider -->
<script src="'.$website_assets_url.'js/assets/revolution/jquery.themepunch.revolution.min.js"></script>
<script src="'.$website_assets_url.'js/assets/revolution/jquery.themepunch.tools.min.js"></script>
<!-- Popup -->
<script src="'.$website_assets_url.'js/assets/jquery.magnific-popup.min.js"></script>
<!-- Sticky JS -->
<script src="'.$website_assets_url.'js/assets/jquery.sticky.js"></script>
<!-- Counter Up -->
<!-- <script src="'.$website_assets_url.'js/assets/jquery.counterup.min.js"></script> -->
<script src="'.$website_assets_url.'js/assets/waypoints.min.js"></script>
<!-- Slick Slider-->
<script src="'.$website_assets_url.'js/assets/slick.min.js"></script>
<!-- Main Menu -->
<script src="'.$website_assets_url.'js/assets/jquery.meanmenu.min.js"></script>
<!-- Revolution Extensions -->
<script type="text/javascript"
    src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript"
    src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript"
    src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript"
    src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.layeranimation.min.js">
</script>
<script type="text/javascript"
    src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.migration.min.js">
</script>
<script type="text/javascript"
    src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.navigation.min.js">
</script>
<script type="text/javascript"
    src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript"
    src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.slideanims.min.js">
</script>
<!-- <script type="text/javascript" src="'.$website_assets_url.'js/assets/revolution/extensions/revolution.extension.video.min.js"></script> -->
<script type="text/javascript" src="'.$website_assets_url.'js/assets/revolution/revolution.js"></script>

<!-- Custom JS -->
<script src="'.$website_assets_url.'js/custom.js"></script>
';

?>
<?php

if (isset($_SESSION['status']) && $_SESSION['status'] != '') {

    ?>
   
<script>
swal({
    title: "<?php echo $_SESSION['status']; ?>",
    // text: "You clicked the button!",
    icon: "<?php echo $_SESSION['status_code']; ?>",
    // button: "Ok!",
});
</script>

<?php
    unset($_SESSION['status']);
}
?>