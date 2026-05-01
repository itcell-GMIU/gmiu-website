<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// Get the record ID
if (!isset($_GET['id'])) {
    $_SESSION['status'] = "Invalid Request";
    $_SESSION['status_code'] = "error";
    header("Location: ugc_view.php");
    exit();
}

$id = mysqli_real_escape_string($con, $_GET['id']);

// Fetch the record with all images
$query = "SELECT m.*, GROUP_CONCAT(mi.id) as image_ids, GROUP_CONCAT(mi.image_path) as additional_images 
          FROM tbl_admission_merit m 
          LEFT JOIN tbl_admission_merit_images mi ON m.id = mi.merit_id AND mi.is_delete = '0'
          WHERE m.id = ? AND m.is_delete = '0'
          GROUP BY m.id";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc()) {
    $_SESSION['status'] = "Record Not Found";
    $_SESSION['status_code'] = "error";
    header("Location: ugc_view.php");
    exit();
}

// Store current values
$current_type = $row['type'];
$current_year = $row['year'];
$current_image = $row['image'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
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
                            <h1 class="m-0">Edit UGC </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit UGC</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <form method="POST" action="ugc_update.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-gmiu">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit UGC </h3>
                                    </div>

                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Type<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="type" required>
                                                <option value="">---Select Type---</option>
                                                <option value="schedule" <?php echo ($row['type'] == 'schedule') ? 'selected' : ''; ?>>Schedule</option>
                                                <option value="advertisement" <?php echo ($row['type'] == 'advertisement') ? 'selected' : ''; ?>>Advertisement</option>
                                                <option value="merit_list" <?php echo ($row['type'] == 'merit_list') ? 'selected' : ''; ?>>Merit List</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Year<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="year" required>
                                                <option value="">---Select Year---</option>
                                                <?php
                                                $current_year = date('Y');
                                                for($year = $current_year + 1; $year >= $current_year - 5; $year--) {
                                                    $selected = ($year == $row['year']) ? 'selected' : '';
                                                    echo "<option value='$year' $selected>$year</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                            
                                        <div class="form-group">
                                            <label>Current Images</label>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#viewAllImages">
                                                        <i class="fas fa-images"></i> View All Images
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                            
                                                <?php 
                                                if (!empty($row['additional_images'])) {
                                                    $image_ids = explode(',', $row['image_ids']);
                                                    $additional_images = explode(',', $row['additional_images']);
                                                    echo '<div class="col-md-12 mt-3"><p>Additional Images:</p><div class="row">';
                                                    foreach ($additional_images as $key => $img) {
                                                        echo '<div class="col-md-3 mb-3">
                                                                <div class="image-container">
                                                                    <img src="../../uploads/ugc/' . $img . '" alt="Additional Image" style="max-width: 150px;">
                                                                    <div class="image-actions mt-2">
                                                                        <button type="button" class="btn btn-danger btn-sm delete-image" data-image-id="' . $image_ids[$key] . '">
                                                                            <i class="fas fa-trash"></i> Delete
                                                                        </button>
                                                                        <button type="button" class="btn btn-primary btn-sm replace-image" data-image-id="' . $image_ids[$key] . '">
                                                                            <i class="fas fa-sync"></i> Replace
                                                                        </button>
                                                                        <input type="file" class="d-none replace-image-input" 
                                                                               data-image-id="' . $image_ids[$key] . '" 
                                                                               accept="image/*">
                                                                    </div>
                                                                </div>
                                                            </div>';
                                                    }
                                                    echo '</div></div>';
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Upload Additional Images<br>
                                                <small class="text-muted">Upload new images to add to the existing ones.</small>
                                            </label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="file_input[]" 
                                                           id="file_input" accept="image/*" multiple>
                                                    <label class="custom-file-label" for="file_input">Choose files</label>
                                                </div>
                                            </div>
                                            <small class="text-muted">You can select multiple images. Maximum file size: 5MB per image. Allowed formats: jpg, jpeg, png, gif, webp</small>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                            <a href="ugc_view.php" class="btn btn-default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                        </form>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>

    <!-- View All Images Modal -->
    <div class="modal fade" id="viewAllImages" tabindex="-1" role="dialog" aria-labelledby="viewAllImagesLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAllImagesLabel">All Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="imageTypeTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="schedule-tab" data-toggle="tab" href="#schedule" role="tab">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="advertisement-tab" data-toggle="tab" href="#advertisement" role="tab">Advertisement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="merit-list-tab" data-toggle="tab" href="#merit-list" role="tab">Merit List</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-3">
                        <!-- Schedule Images -->
                        <div class="tab-pane fade show active" id="schedule" role="tabpanel">
                            <div class="row">
                                <?php 
                                if (!empty($row['additional_images'])) {
                                    $image_ids = explode(',', $row['image_ids']);
                                    $additional_images = explode(',', $row['additional_images']);
                                    foreach ($additional_images as $key => $img) {
                                        if ($current_type == 'schedule') {
                                            echo '<div class="col-md-4 mb-3">
                                                    <div class="image-card">
                                                        <img src="../../uploads/ugc/' . $img . '" alt="Schedule Image" class="img-fluid">
                                                    </div>
                                                </div>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Advertisement Images -->
                        <div class="tab-pane fade" id="advertisement" role="tabpanel">
                            <div class="row">
                                <?php 
                                if (!empty($row['additional_images'])) {
                                    $image_ids = explode(',', $row['image_ids']);
                                    $additional_images = explode(',', $row['additional_images']);
                                    foreach ($additional_images as $key => $img) {
                                        if ($current_type == 'advertisement') {
                                            echo '<div class="col-md-4 mb-3">
                                                    <div class="image-card">
                                                        <img src="../../uploads/ugc/' . $img . '" alt="Advertisement Image" class="img-fluid">
                                                    </div>
                                                </div>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Merit List Images -->
                        <div class="tab-pane fade" id="merit-list" role="tabpanel">
                            <div class="row">
                                <?php 
                                if (!empty($row['additional_images'])) {
                                    $image_ids = explode(',', $row['image_ids']);
                                    $additional_images = explode(',', $row['additional_images']);
                                    foreach ($additional_images as $key => $img) {
                                        if ($current_type == 'merit_list') {
                                            echo '<div class="col-md-4 mb-3">
                                                    <div class="image-card">
                                                        <img src="../../uploads/ugc/' . $img . '" alt="Merit List Image" class="img-fluid">
                                                    </div>
                                                </div>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
    .image-container {
        position: relative;
        display: inline-block;
        margin: 10px;
    }
    .image-actions {
        text-align: center;
    }
    .modal-body img {
        object-fit: contain;
        width: 100%;
    }
    .blur-effect {
        filter: blur(4px);
        opacity: 0.5;
        transition: all 0.3s ease;
    }
    .image-container.replacing {
        pointer-events: none;
    }
    .image-container.deleting {
        pointer-events: none;
    }
    .image-card {
        position: relative;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        cursor: pointer;
    }
    .image-card:hover {
        transform: scale(1.02);
    }
    .image-info {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(0,0,0,0.7);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    .modal-dialog.modal-xl {
        max-width: 90%;
    }
    .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .preview-container {
        position: relative;
        width: 100%;
        height: 100%;
    }
    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preview-buttons {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        text-align: center;
        z-index: 2;
    }
    .preview-active .preview-overlay {
        opacity: 1;
    }
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
    }
    .nav-tabs .nav-link.active {
        color: #007bff;
        font-weight: 600;
    }
    .tab-content {
        padding: 20px 0;
    }
    .modal-body {
        padding: 20px;
    }
    </style>

    <script>
    $(document).ready(function() {
        // Show selected file names
        $('#file_input').on('change', function() {
            var files = this.files;
            var fileNames = [];
            
            if (files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > 5 * 1024 * 1024) {
                        alert('File ' + files[i].name + ' is too large. Maximum size is 5MB');
                        $(this).val('');
                        $(this).next('.custom-file-label').text('Choose files');
                        return;
                    }
                    fileNames.push(files[i].name);
                }
                $(this).next('.custom-file-label').text(fileNames.join(', '));
            } else {
                $(this).next('.custom-file-label').text('Choose files');
            }
        });

        // Delete image
        $('.delete-image').on('click', function() {
            var imageId = $(this).data('image-id');
            var container = $(this).closest('.image-container');
            var img = container.find('img');
            
            if (confirm('Are you sure you want to delete this image?')) {
                // Add blur effect immediately
                container.addClass('deleting');
                img.addClass('blur-effect');
                
                $.ajax({
                    url: 'delete_image.php',
                    type: 'POST',
                    data: { image_id: imageId },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            container.fadeOut(300, function() {
                                $(this).remove();
                            });
                        } else {
                            // Remove blur if delete failed
                            container.removeClass('deleting');
                            img.removeClass('blur-effect');
                            alert('Error deleting image: ' + result.message);
                        }
                    },
                    error: function() {
                        // Remove blur if request failed
                        container.removeClass('deleting');
                        img.removeClass('blur-effect');
                        alert('Error deleting image');
                    }
                });
            }
        });

        // Replace image button click
        $('.replace-image').on('click', function() {
            $(this).siblings('.replace-image-input').click();
        });

        // Handle replace image file selection
        $('.replace-image-input').on('change', function() {
            var imageId = $(this).data('image-id');
            var file = this.files[0];
            var container = $(this).closest('.image-container');
            var img = container.find('img').first();
            
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('File is too large. Maximum size is 5MB');
                    return;
                }

                // Create preview overlay if it doesn't exist
                if (!container.find('.preview-overlay').length) {
                    container.append(`
                        <div class="preview-overlay">
                            <div class="preview-container">
                                <img class="preview-image" src="" alt="Preview">
                                <div class="preview-buttons">
                                    <button type="button" class="btn btn-success btn-sm confirm-replace">
                                        <i class="fas fa-check"></i> Confirm
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm cancel-replace">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    `);
                }

                // Show preview of new image
                var reader = new FileReader();
                reader.onload = function(e) {
                    container.find('.preview-image').attr('src', e.target.result);
                    container.addClass('preview-active');
                };
                reader.readAsDataURL(file);

                // Handle confirm button click
                container.find('.confirm-replace').off('click').on('click', function() {
                    // Add blur effect
                    container.addClass('replacing');
                    img.addClass('blur-effect');
                    container.removeClass('preview-active');
                    
                    var formData = new FormData();
                    formData.append('image_id', imageId);
                    formData.append('new_image', file);
                    
                    $.ajax({
                        url: 'replace_image.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                // Quick fade transition
                                img.fadeOut(150, function() {
                                    img.attr('src', result.new_path + '?t=' + new Date().getTime())
                                       .fadeIn(150);
                                    // Remove blur effect after fade
                                    setTimeout(function() {
                                        container.removeClass('replacing');
                                        img.removeClass('blur-effect');
                                    }, 200);
                                });
                            } else {
                                // Remove blur if replace failed
                                container.removeClass('replacing');
                                img.removeClass('blur-effect');
                                alert('Error replacing image: ' + result.message);
                            }
                        },
                        error: function() {
                            // Remove blur if request failed
                            container.removeClass('replacing');
                            img.removeClass('blur-effect');
                            alert('Error replacing image');
                        }
                    });
                });

                // Handle cancel button click
                container.find('.cancel-replace').off('click').on('click', function() {
                    container.removeClass('preview-active');
                    $('.replace-image-input').val(''); // Clear the file input
                });
            }
        });

        // Add click handler for image cards to show full size image
        $('.image-card').on('click', function() {
            var imgSrc = $(this).find('img').attr('src');
            Swal.fire({
                imageUrl: imgSrc,
                imageAlt: 'Full size image',
                width: '90%',
                padding: '3em',
                showConfirmButton: false,
                showCloseButton: true
            });
        });

        // Show the tab corresponding to the current type
        $('#imageTypeTabs a[href="#<?php echo $current_type; ?>"]').tab('show');

        // Add click handler for image cards in modal
        $('.modal').on('click', '.image-card', function() {
            var imgSrc = $(this).find('img').attr('src');
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
    <?php unset($_SESSION['status']); unset($_SESSION['status_code']); ?>
    <?php endif; ?>
</body>

</html>
