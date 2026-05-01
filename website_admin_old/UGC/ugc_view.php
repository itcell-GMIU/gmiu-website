<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="../../admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../admin_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">UGC Records</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">UGC Records</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="recordTypeTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="schedule-tab" data-toggle="tab" href="#schedule"
                                role="tab">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="advertisement-tab" data-toggle="tab" href="#advertisement"
                                role="tab">Advertisement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="merit_list-tab" data-toggle="tab" href="#merit_list"
                                role="tab">Merit List</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content">
                        <?php
                        $types = ['schedule', 'advertisement', 'merit_list'];
                        foreach ($types as $index => $type) {
                            $active = $index === 0 ? 'show active' : '';
                            echo '<div class="tab-pane fade ' . $active . '" id="' . $type . '" role="tabpanel">';
                            echo '<div class="row"><div class="col-12"><div class="card">
                        <div class="card-header">
                            <h3 class="card-title">' . ucfirst(str_replace('_', ' ', $type)) . ' Records</h3>
                            <div class="float-right">
                                <a href="ugc_insert.php" class="btn btn-primary">Add New Record</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Year</th>
                                        <th>Images</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>';

                            // Debug: Add error reporting for this section
                            try {
                                // Fetch records for this type
                                $query = "SELECT m.*, GROUP_CONCAT(mi.image_path) as additional_images 
                             FROM tbl_admission_merit m 
                             LEFT JOIN tbl_admission_merit_images mi ON m.id = mi.merit_id AND mi.is_delete = '0'
                             WHERE m.type = ? AND m.is_delete = '0'
                             GROUP BY m.id 
                             ORDER BY m.year DESC, m.id DESC";

                                $stmt = $con->prepare($query);
                                if (!$stmt) {
                                    echo "<tr><td colspan='4'>Query preparation failed: " . $con->error . "</td></tr>";
                                    continue;
                                }

                                $stmt->bind_param("s", $type);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Debug: Check if we have results
                                if ($result->num_rows == 0) {
                                    echo "<tr><td colspan='4'>No records found for type: " . htmlspecialchars($type) . "</td></tr>";
                                }

                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                                    echo "<td class='text-center'>
                                <button type='button' class='btn btn-info btn-sm view-images' data-toggle='modal' data-target='#viewAllImages" . $row['id'] . "'>
                                    <i class='fas fa-images'></i> View Images
                                </button>";

                                    // Create modal for this record
                                    echo "<div class='modal fade' id='viewAllImages" . $row['id'] . "' tabindex='-1' role='dialog' aria-hidden='true'>
                                <div class='modal-dialog modal-xl'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>" . ucfirst(str_replace('_', ' ', $type)) . " Images - " . htmlspecialchars($row['year']) . "</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <div class='row'>";

                                    // Show all images for this record
                                    if (!empty($row['additional_images'])) {
                                        $images = explode(',', $row['additional_images']);
                                        foreach ($images as $img) {
                                            $img = trim($img); // Remove any whitespace
                                            if (!empty($img)) {
                                                echo "<div class='col-md-4 mb-3'>
                                            <div class='image-card' data-src='../../uploads/ugc/" . htmlspecialchars($img) . "'>
                                                <img src='../../uploads/ugc/" . htmlspecialchars($img) . "' alt='Image' class='img-fluid' onerror='this.src=\"../../uploads/placeholder.jpg\"'>
                                            </div>
                                          </div>";
                                            }
                                        }
                                    } else {
                                        echo "<div class='col-12'><p class='text-center'>No images available for this record.</p></div>";
                                    }

                                    echo "          </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>";

                                    echo "</td>";
                                    echo "<td>
                                <a href='ugc_edit.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'><i class='fas fa-edit'></i> Edit</a>
                                <button type='button' class='btn btn-danger btn-sm' onclick='deleteRecord(" . $row['id'] . ")'><i class='fas fa-trash'></i> Delete</button>
                            </td>";
                                    echo "</tr>";
                                }

                                $stmt->close();

                            } catch (Exception $e) {
                                echo "<tr><td colspan='4'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                            }

                            echo '</tbody></table>
                        </div>
                    </div></div></div>
                </div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Add some debugging JavaScript -->
                <script>
                    $(document).ready(function () {
                        // Debug: Check if tabs are working
                        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                            console.log('Tab switched to:', e.target.getAttribute('href'));
                        });

                        // Initialize DataTables for each tab
                        $('.datatable').DataTable({
                            "responsive": true,
                            "autoWidth": false,
                        });
                    });

                    // Debug function to check database records
                    function debugMeritList() {
                        console.log('Checking merit list records...');
                        // You can add AJAX call here to check database directly
                    }
                </script>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>
    <!-- DataTables & Plugins -->
    <script src="../../admin_assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../admin_assets/plugins/jszip/jszip.min.js"></script>
    <script src="../../admin_assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../admin_assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <style>
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #007bff;
            font-weight: 600;
        }

        .modal-body img {
            object-fit: cover;
            width: 100%;
            height: 250px;
            border-radius: 8px;
        }

        .image-card {
            position: relative;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            cursor: pointer;
        }

        .image-card:hover {
            transform: scale(1.02);
        }

        .modal-dialog.modal-xl {
            max-width: 90%;
        }
    </style>

    <script>
        $(function () {
            // Initialize DataTables for each table
            $('.datatable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Handle image click to show full size
            $(document).on('click', '.image-card', function () {
                var imgSrc = $(this).data('src');
                Swal.fire({
                    imageUrl: imgSrc,
                    imageAlt: 'Full size image',
                    width: '90%',
                    padding: '3em',
                    showConfirmButton: false,
                    showCloseButton: true
                });
            });
        });

        function deleteRecord(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'ugc_delete.php?id=' + id;
                }
            });
        }
    </script>

    <?php if (isset($_SESSION['status'])): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: '<?php echo $_SESSION['status_code'] == 'success' ? 'Success!' : 'Error!'; ?>',
                text: '<?php echo $_SESSION['status']; ?>',
                icon: '<?php echo $_SESSION['status_code']; ?>',
                confirmButtonText: 'OK'
            });
        </script>
        <?php unset($_SESSION['status']);
        unset($_SESSION['status_code']); ?>
    <?php endif; ?>
</body>

</html>