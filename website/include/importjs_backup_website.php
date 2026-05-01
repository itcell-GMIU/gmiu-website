<?php
echo '
<script src="' . $website_assets_url . 'js/jquery.js"></script>
<!-- jQuery (Minified Only) -->
<script src="' . $website_assets_url . 'js/vendor/jquery-1.12.4.min.js"></script>

<!-- Bootstrap -->
<script src="' . $website_assets_url . 'js/assets/bootstrap.min.js" defer></script>

<!-- jQuery Validate -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
    integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>

<!-- Owl Carousel -->
<script src="' . $website_assets_url . 'js/assets/owl.carousel.min.js" defer></script>

<!-- Revolution Slider -->
<script src="' . $website_assets_url . 'js/assets/revolution/jquery.themepunch.revolution.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/revolution/jquery.themepunch.tools.min.js" defer></script>

<!-- Popup & Sticky -->
<script src="' . $website_assets_url . 'js/assets/jquery.magnific-popup.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/jquery.sticky.js" defer></script>

<!-- Waypoints & Slick Slider -->
<script src="' . $website_assets_url . 'js/assets/waypoints.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/slick.min.js" defer></script>

<!-- Main Menu -->
<script src="' . $website_assets_url . 'js/assets/jquery.meanmenu.min.js" defer></script>

<!-- Revolution Extensions -->
<script src="' . $website_assets_url . 'js/assets/revolution/extensions/revolution.extension.actions.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/revolution/extensions/revolution.extension.carousel.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/revolution/extensions/revolution.extension.kenburn.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/revolution/extensions/revolution.extension.layeranimation.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/revolution/extensions/revolution.extension.migration.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/revolution/extensions/revolution.extension.navigation.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/revolution/extensions/revolution.extension.parallax.min.js" defer></script>
<script src="' . $website_assets_url . 'js/assets/revolution/extensions/revolution.extension.slideanims.min.js" defer></script>

<!-- Revolution Core JS -->
<script src="' . $website_assets_url . 'js/assets/revolution/revolution.js" defer></script>

<!-- Custom JS -->
<script src="' . $website_assets_url . 'js/custom.js" defer></script>
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