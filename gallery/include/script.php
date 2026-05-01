<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- js -->
<script src="vendors/scripts/script.js"></script>

<!-- Datatable scripts !  -->
<script src="src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="src/plugins/datatables/media/js/dataTables.bootstrap4.js"></script>
<script src="src/plugins/datatables/media/js/dataTables.responsive.js"></script>
<script src="src/plugins/datatables/media/js/responsive.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<!-- buttons for Export datatable -->
<script src="src/plugins/datatables/media/js/button/dataTables.buttons.js"></script>
<script src="src/plugins/datatables/media/js/button/buttons.bootstrap4.js"></script>
<script src="src/plugins/datatables/media/js/button/buttons.print.js"></script>
<script src="src/plugins/datatables/media/js/button/buttons.html5.js"></script>
<script src="src/plugins/datatables/media/js/button/buttons.flash.js"></script>
<script src="src/plugins/datatables/media/js/button/pdfmake.min.js"></script>
<script src="src/plugins/datatables/media/js/button/vfs_fonts.js"></script>
<!-- Datatable scripts ends   -->

<!-- add sweet alert js & css in footer -->
<script src="src/plugins/sweetalert2/sweetalert2.all.js"></script>
<link rel="stylesheet" type="text/css" href="src/plugins/sweetalert2/sweetalert2.css">
<script src="src/plugins/sweetalert2/sweet-alert.init.js"></script>
<!-- end sweet alert js & css in footer -->

<!-- select 2 option   -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.2/dist/js/bootstrap-multiselect.min.js"></script>

<!-- ✅ CKEditor 5 Classic build (latest CDN) -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    $redirectPage = isset($_SESSION['status_redirect']) && !empty($_SESSION['status_redirect'])
        ? $_SESSION['status_redirect']
        : $_SERVER['REQUEST_URI'];

    // store session variables if needed, then unset after
    $status = $_SESSION['status'];
    $statusCode = $_SESSION['status_code'];
    unset($_SESSION['status'], $_SESSION['status_code'], $_SESSION['status_redirect']);
    ?>
    <script>
        $(function () {
            swal({
                title: '<?php echo $statusCode; ?>',
                text: '<?php echo $status; ?>',
                type: '<?php echo $statusCode; ?>', // success, error, warning, info
                showCancelButton: false,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'OK'
            }).then((result) => {
                // Redirect after clicking OK
                window.location.href = '<?php echo $redirectPage; ?>';
            });
        });
    </script>
    <?php
}
?>

<!-- logout button script   -->
<script>
    $(function () {
        $('#logout-btn').click(function (e) {
            e.preventDefault();

            swal({
                title: 'Are you sure?',
                text: "You will be logged out!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success margin-5',
                cancelButtonClass: 'btn btn-danger margin-5',
                confirmButtonText: 'Yes, log me out!',
                cancelButtonText: 'No, stay logged in',
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    // Confirm clicked → redirect
                    window.location.href = 'logout.php';
                } else if (result.dismiss === 'cancel') {
                    // Cancel clicked → show message
                    swal(
                        'Cancelled',
                        'You are still logged in :)',
                        'error'
                    );
                }
                // overlay, close, timer → do nothing
            });
        });
    });
</script>