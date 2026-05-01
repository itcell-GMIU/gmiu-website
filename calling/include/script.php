<!-- js -->
<script src="vendors/scripts/script.js"></script>

<!-- Datatable scripts !  -->
<!-- <script src="src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="src/plugins/datatables/media/js/dataTables.bootstrap4.js"></script>
<script src="src/plugins/datatables/media/js/dataTables.responsive.js"></script>
<script src="src/plugins/datatables/media/js/responsive.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script> -->
<!-- buttons for Export datatable -->
<!-- <script src="src/plugins/datatables/media/js/button/dataTables.buttons.js"></script>
<script src="src/plugins/datatables/media/js/button/buttons.bootstrap4.js"></script>
<script src="src/plugins/datatables/media/js/button/buttons.print.js"></script>
<script src="src/plugins/datatables/media/js/button/buttons.html5.js"></script>
<script src="src/plugins/datatables/media/js/button/buttons.flash.js"></script>
<script src="src/plugins/datatables/media/js/button/pdfmake.min.js"></script>
<script src="src/plugins/datatables/media/js/button/vfs_fonts.js"></script> -->
<!-- Datatable scripts ends   -->


<!-- Datatable scripts !  -->
<script src="../admin_assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../admin_assets/plugins/jszip/jszip.min.js"></script>
<script src="../admin_assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../admin_assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../admin_assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- add sweet alert js & css in footer -->
<script src="src/plugins/sweetalert2/sweetalert2.all.js"></script>
<link rel="stylesheet" type="text/css" href="src/plugins/sweetalert2/sweetalert2.css">
<script src="src/plugins/sweetalert2/sweet-alert.init.js"></script>
<!-- end sweet alert js & css in footer -->

<!-- select 2 option   -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                    localStorage.removeItem('otp-flag');
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

<!-- DataTable - copy, csv, excel, pdf, print, colvis -->
<!-- <script>
    $(document).ready(function () {
        var table = $('.dataTableLoad').DataTable({
            "dom": 'Blfrtip',
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');
    });
</script> -->