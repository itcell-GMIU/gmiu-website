  <!-- jQuery -->
  <script src="../admin_assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../admin_assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Font Awesome -->
  <!--<script src="https://kit.fontawesome.com/8bce78c4e1.js" crossorigin="anonymous"></script>-->
  <script src="../admin_assets/plugins/fontawesome-free/js/all.min.js"></script>
  <!-- Sparkline -->
  <script src="../admin_assets/plugins/sparklines/sparkline.js"></script>

  <!-- jQuery Knob Chart -->
  <script src="../admin_assets/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../admin_assets/plugins/moment/moment.min.js"></script>
  <script src="../admin_assets/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../admin_assets/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../admin_assets/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="../admin_assets/dist/js/demo.js"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../admin_assets/dist/js/pages/dashboard.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../admin_assets/plugins/toastr/toastr.min.css">

  <!-- jQuery -->
  <!-- <script src="../../plugins/jquery/jquery.min.js"></script> -->

  <!-- DataTables  & Plugins -->
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

  <script src="../admin_assets/js/custom.js"></script>
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

  <!-- DataTable - copy, csv, excel, pdf, print, colvis -->
  <script>
   $(document).ready(function() {
      var table = $('.dataTableLoad').DataTable({
        scrollX: true, // Enable horizontal scrolling
        scrollY: '500px', // Set the desired height for the scrollable area
        scrollCollapse: true,
        fixedHeader: {
            header: true,
            footer: false
        },
        "dom": 'Blfrtip',
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('.dataTableLoad_wrapper .col-md-6:eq(0)');
    });
  </script>