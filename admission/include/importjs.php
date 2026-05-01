<!-- jQuery -->
<!-- cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"> </script>

<!-- <script src="../admin_assets/js/jquery.min.js">
</script> -->
<script src="../website_assets/js/jquery.js">
</script>

<script src="../website_assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="../website_assets/js/assets/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<!-- local cdn -->
<!-- <script src="../admin_assets/js/jquery.validate.min.js"> -->
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<!-- local cdn -->
<!-- <script src = "../admin_assets/js/additional-methods.min.js" > -->
</script>
<!-- owl carousel -->
<script src="../website_assets/js/assets/owl.carousel.min.js"></script>
<!-- Revolution Slider -->
<script src="../website_assets/js/assets/revolution/jquery.themepunch.revolution.min.js"></script>
<script src="../website_assets/js/assets/revolution/jquery.themepunch.tools.min.js"></script>
<!-- Popup -->
<script src="../website_assets/js/assets/jquery.magnific-popup.min.js"></script>
<!-- Sticky JS -->
<script src="../website_assets/js/assets/jquery.sticky.js"></script>
<!-- Counter Up -->
<script src="../website_assets/js/assets/jquery.counterup.min.js"></script>
<script src="../website_assets/js/assets/waypoints.min.js"></script>
<!-- Slick Slider-->
<script src="../website_assets/js/assets/slick.min.js"></script>
<!-- Main Menu -->
<script src="../website_assets/js/assets/jquery.meanmenu.min.js"></script>
<!-- Revolution Extensions -->
<script type="text/javascript"
    src="../website_assets/js/assets/revolution/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript"
    src="../website_assets/js/assets/revolution/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript"
    src="../website_assets/js/assets/revolution/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript"
    src="../website_assets/js/assets/revolution/extensions/revolution.extension.layeranimation.min.js">
</script>
<script type="text/javascript"
    src="../website_assets/js/assets/revolution/extensions/revolution.extension.migration.min.js">
</script>
<script type="text/javascript"
    src="../website_assets/js/assets/revolution/extensions/revolution.extension.navigation.min.js">
</script>
<script type="text/javascript"
    src="../website_assets/js/assets/revolution/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript"
    src="../website_assets/js/assets/revolution/extensions/revolution.extension.slideanims.min.js">
</script>
<!-- <script type="text/javascript" src="../website_assets/js/assets/revolution/extensions/revolution.extension.video.min.js"></script> -->
<script type="text/javascript" src="../website_assets/js/assets/revolution/revolution.js"></script>

<!-- Custom JS -->
<script src="../website_assets/js/custom.js"></script>
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

<!--Dashboard Page Js-->