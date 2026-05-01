<?php
include '../include/checklogin.php';

$chapters = array(
    1 => 'Chapter 1',
    2 => 'Chapter 2',
    3 => 'Chapter 3',
    4 => 'Chapter 4',
    5 => 'Chapter 5',
    6 => 'Chapter 6',
    7 => 'Chapter 7',
    8 => 'Chapter 8',
    9 => 'Chapter 9',
    10 => 'Chapter 10'
);

if (isset($_POST['submit'])) {
    // Extract data from the form
    $subject_code = mysqli_real_escape_string($con, $_POST['subject_code']);

    // Check if the subject code already exists in tbl_bl_level
    $stmt_check_subject = $con->prepare("SELECT * FROM `tbl_bl_level` WHERE subject_code = ? AND is_delete = 0 ");
    $stmt_check_subject->bind_param("s", $subject_code);
    $stmt_check_subject->execute();
    $result_check_subject = $stmt_check_subject->get_result();

    if ($result_check_subject->num_rows > 0) {
        // Subject code already exists, show error message
        $_SESSION['status'] = "Weightage for the selected subject code already exists.";
        $_SESSION['status_code'] = "error";
        header("Location: view_weightage.php");
        exit();
    } else {
        $chapter_count = count($_POST['chapter']);
        $remembering = mysqli_real_escape_string($con, $_POST['remembering']);
        $understanding = mysqli_real_escape_string($con, $_POST['understanding']);
        $applying = mysqli_real_escape_string($con, $_POST['applying']);
        $analyzing = mysqli_real_escape_string($con, $_POST['analyzing']);
        $evaluating = mysqli_real_escape_string($con, $_POST['evaluating']);
        $creating = mysqli_real_escape_string($con, $_POST['creating']);

        $unique_chapters = array();

        // Validate unique chapters
        for ($i = 0; $i < $chapter_count; $i++) {
            $chapter = mysqli_real_escape_string($con, $_POST['chapter'][$i]);

            if (in_array($chapter, $unique_chapters)) {
                // Duplicate chapter found, show error and stop further execution
                $_SESSION['status'] = "Duplicate chapters found. Please ensure each chapter is unique.";
                $_SESSION['status_code'] = "error";
                header("Location: view_weightage.php");
                exit();
            }

            $unique_chapters[] = $chapter;
        }

        // If all chapters are unique, proceed with insertion
        foreach ($unique_chapters as $index => $chapter) {
            $chapter_weight = mysqli_real_escape_string($con, $_POST['chapter_weight'][$index]);

            // Insert the data into tbl_weightage
            $stmt_insert = $con->prepare("INSERT INTO `tbl_weightage` (subject_code, chapter, chapter_weight, create_by) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssii", $subject_code, $chapter, $chapter_weight, $web_admin_id);
            $result_insert = $stmt_insert->execute();

            if (!$result_insert) {
                // Insertion failed, show error message and stop further execution
                $_SESSION['status'] = "Weightage insertion failed.";
                $_SESSION['status_code'] = "error";
                header("Location: view_weightage.php");
                exit();
            }
        }

        // Insert Bloom's level data into tbl_bl_level
        $stmt_insert_bl = $con->prepare("INSERT INTO `tbl_bl_level` (subject_code, remembering, understanding, applying, analyzing, evaluating, creating, create_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert_bl->bind_param("iiiiiiii", $subject_code, $remembering, $understanding, $applying, $analyzing, $evaluating, $creating, $web_admin_id);
        $result_insert_bl = $stmt_insert_bl->execute();

        if ($result_insert_bl) {
            // Redirect to view_weightage.php after successful insertion
            $_SESSION['status'] = "Weightage inserted successfully.";
            $_SESSION['status_code'] = "success";
            header("Location: view_weightage.php");
        } else {
            // Insertion failed, show error message
            $_SESSION['status'] = "Weightage insertion failed.";
            $_SESSION['status_code'] = "error";
            header("Location: view_weightage.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <!-- /.CKeditor custom script -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Subject Weightage</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Subject Weightage</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- <div class="btn-group" style="display: flex; justify-content: space-between; margin-right: 80%;"> -->
                <!-- <a class="btn btn-primary" href="import_subject_insert.php" style="margin-right: 20px;">
                <i class="fa-solid fa-plus"></i> import</a> -->
                <!-- <a class="btn btn-primary" href="subject_insert.php">
                            <i class="fa-solid fa-plus"></i> Add Subject</a>
                    </div> -->
                <!-- <hr> -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Add Subject Weightage</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="form-group col-md-4">
                                                <label>Select Faculty<span style="color: red;"> *</span></label>
                                                <select class="form-control" name="faculty_id" required id="faculty_id">
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $faculty_id = $row['faculty_id'];
                                                    ?>

                                                        <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                <label>Select Level<span style="color: red;"> *</span></label>
                                                <select name="level_id" id="level_id" class="form-control" required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                <label>Select Program<span style="color: red;"> *</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6 ">
                                                <label>Select sem<span style="color: red;"> *</span></label>
                                                <select name="sem" id="sem" class="form-control" required>
                                                    <option value=""> --- Semester--- </option>
                                                    <option value="1"> Semester 1</option>
                                                    <option value="2"> Semester 2</option>
                                                    <option value="3"> Semester 3</option>
                                                    <option value="4"> Semester 4</option>
                                                    <option value="5"> Semester 5</option>
                                                    <option value="6"> Semester 6</option>
                                                    <option value="7"> Semester 7</option>
                                                    <option value="8"> Semester 8</option>
                                                </select>
                                            </div>

                                            <!-- Add this inside your form -->
                                            <div class="form-group col-md-6 ">
                                                <label for="subject_code_id">Subject Code<span style="color: red;">*</span></label>
                                                <select class="form-control" name="subject_code" required id="subject_code_id">
                                                    <option value="">---Select subject Code---</option>
                                                </select>
                                            </div>


                                        </div>
                                        <div id="blcontainer" style="display: none;">
                                            <h4>Chapter Weightage Details</h4>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="form-group col-md-2">
                                                    <label for="remembering">Remembering(R)<span style="color: red;">*</span></label>
                                                    <input type="text" name="remembering" class="form-control bl-level" placeholder="Enter Weightage" required>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="understanding">Understanding(U)<span style="color: red;">*</span></label>
                                                    <input type="text" name="understanding" class="form-control bl-level" placeholder="Enter Weightage" required>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="applying">Applying(A)<span style="color: red;">*</span></label>
                                                    <input type="text" name="applying" class="form-control bl-level" placeholder="Enter Weightage" required>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="analyzing">Analyzing(N)<span style="color: red;">*</span></label>
                                                    <input type="text" name="analyzing" class="form-control bl-level" placeholder="Enter Weightage" required>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="evaluating">Evaluating(E)<span style="color: red;">*</span></label>
                                                    <input type="text" name="evaluating" class="form-control bl-level" placeholder="Enter Weightage" required>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="creating">Creating(C)<span style="color: red;">*</span></label>
                                                    <input type="text" name="creating" class="form-control bl-level" placeholder="Enter Weightage" required>
                                                </div>
                                            </div>
                                            <div id="bl-error" style="color: red; display: none;">BL Levels weightage must be 100% or less than 100%</div>
                                        </div>

                                        <script>
                                            // Validate BL Levels weightage
                                            function validateBLLevels() {
                                                var totalWeight = 0;
                                                $('.bl-level').each(function() {
                                                    totalWeight += parseFloat($(this).val()) || 0;
                                                });
                                                if (totalWeight != 100) {
                                                    $('#bl-error').show();
                                                    return false;
                                                }
                                                return true;
                                            }

                                            // Validate BL Levels on form submission
                                            $('form').submit(function(event) {
                                                if (!validateBLLevels()) {
                                                    event.preventDefault(); // Prevent form submission
                                                    return false;
                                                }
                                            });
                                        </script>


                                        <div class="form-group col-md-3">
                                            <button type="submit" id="showAdditionalFieldsBtn" name="showAdditionalFieldsBtn" class="btn btn-primary">Show</button>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <button type="submit" id="add_container" name="add_container" class="btn btn-primary" style="display: none;"> <i class="fa-solid fa-plus"></i>Add </button>
                                        </div>


                                        <div id="additional_fields_container" style="display: none;">
                                            <!-- Your four fields go here -->
                                            <div class="form-group row">

                                                <div class="form-group col">
                                                    <label for="chapter">Chapter<span style="color: red;">*</span></label>
                                                    <select name="chapter[]" class="form-control" id="chapter" required>
                                                        <?php foreach ($chapters as $key => $chapter) { ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $chapter; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col">
                                                    <label for="chapter_weight">Chapter Weight (%)<span style="color: red;">*</span></label>
                                                    <input type="text" name="chapter_weight[]" class="form-control" id="chapter_weight" placeholder="Enter Chapter Weight" required>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>


                                </form>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
    </div>
    <!-- /.content-wrapper -->
    <?php include '../include/importfooter.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>
</body>

</html>
<?php //} 
?>

<script>
    $(document).ready(function() {
        //call for listing the dropdown and select by default
        load_level();
        load_program();
    });

    function load_level() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;

        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        });

    }

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id
            },
            success: function(result) {
                $('#program_id').html(result);

                // console.log(result);
            }
        });

    }
</script>
<script type="text/javascript">
    $('#faculty_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        // alert("hii");
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        })
    });

    $('#level_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var level_id = this.value;
        var faculty_id = $("select#faculty_id option:checked").val();
        /*  alert(level_id); */

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                level_data: level_id,
                faculty_data: faculty_id
            },
            cache: false,
            success: function(data) {
                $('#program_id').html(data);
                // console.log(data);
            }
        })
    });
</script>


<script type="text/javascript">
    var path = '<?php echo $base_url_question_paper; ?>';
    $(document).ready(function() {
        // Function to load subject codes based on selected parameters
        function loadSubjectCodes() {
            var faculty_id = $('#faculty_id').val();
            var level_id = $('#level_id').val();
            var program_id = $('#program_id').val();
            var sem = $('#sem').val();

            $.ajax({
                url: path + 'get_subject_codes.php',
                type: 'POST',
                data: {
                    faculty_id: faculty_id,
                    level_id: level_id,
                    program_id: program_id,
                    sem: sem
                },
                success: function(response) {
                    // Populate the subject code dropdown with the fetched options
                    $('#subject_code_id').html(response);


                }
            });
        }

        // Call the function initially and whenever any of the selection changes
        loadSubjectCodes();

        $('#faculty_id, #level_id, #program_id, #sem').on('change', function() {
            loadSubjectCodes();
        });

    });
</script>
<script>
    // Add an event listener to the subject code select dropdown
    document.getElementById('subject_code_id').addEventListener('change', function() {
        // Toggle the visibility of the additional fields container based on selection
        var container = document.getElementById('blcontainer');
        if (this.value !== '') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    });
</script>
<script>
    // Add an event listener to the "Submit" button
    document.querySelector('button[name="showAdditionalFieldsBtn"]').addEventListener('click', function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Check if a subject code is selected
        var subjectCode = document.querySelector('#subject_code_id').value;
        if (subjectCode !== '') {
            // Show the additional fields container
            document.getElementById('additional_fields_container').style.display = 'block';
        } else {
            // Optionally, you can show an alert or handle the case where no subject code is selected
            alert('Please select a subject code.');
        }

    });
</script>

<script>
    // Add an event listener to the "Show" button
    // Add an event listener to the "Show" button
    document.querySelector('button[name="showAdditionalFieldsBtn"]').addEventListener('click', function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Toggle the visibility of the "Add" button
        var addButton = document.getElementById('add_container');
        if (addButton.style.display === 'none') {
            addButton.style.display = 'block';
        } else {
            addButton.style.display = 'none';
        }

        // Disable selected chapter options based on selections in previous containers
        var containers = document.querySelectorAll('.additional-fields-container');
        var selectedChapters = [];
        containers.forEach(function(container) {
            var selectedChapter = container.querySelector('.chapter').value;
            selectedChapters.push(selectedChapter);
        });
        var chapterOptions = document.querySelectorAll('.chapter option');
        chapterOptions.forEach(function(option) {
            if (selectedChapters.includes(option.value)) {
                option.disabled = true;
            } else {
                option.disabled = false;
            }
        });
    });
</script>
<script>
    document.querySelector('button[name="add_container"]').addEventListener('click', function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Clone the additional fields container
        var additionalFieldsContainer = document.getElementById('additional_fields_container');
        var clonedContainer = additionalFieldsContainer.cloneNode(true);

        // Clear the values in the cloned container
        clonedContainer.querySelectorAll('input, select').forEach(function(element) {
            if (element.tagName === 'INPUT') {
                element.value = ''; // Clear input field value
            } else if (element.tagName === 'SELECT') {
                element.selectedIndex = 0; // Reset select dropdown to default option
            }
        });

        // Append the cloned container to the parent element
        additionalFieldsContainer.parentNode.appendChild(clonedContainer);

        // Disable selected chapter options based on selections in previous containers
        var containers = document.querySelectorAll('.additional-fields-container');
        var selectedChapters = [];
        containers.forEach(function(container) {
            var selectedChapter = container.querySelector('.chapter').value;
            selectedChapters.push(selectedChapter);
        });
        var chapterOptions = clonedContainer.querySelectorAll('.chapter option');
        chapterOptions.forEach(function(option) {
            if (selectedChapters.includes(option.value)) {
                option.disabled = true;
            }
        });

        // Add a remove button to the cloned container
        var removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.classList.add('btn', 'btn-danger');
        removeButton.addEventListener('click', function() {
            clonedContainer.parentNode.removeChild(clonedContainer);
        });
        clonedContainer.appendChild(removeButton);
    });
</script>

<script>
    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)

    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    })

    myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file)
        }
    })

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    })

    myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    })

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
    })

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
    }
    // DropzoneJS Demo Code End
</script>
<script>
    // Validate BL Levels weightage
    function validateBLLevels() {
        var totalWeight = 0;
        $('.bl-level').each(function() {
            totalWeight += parseFloat($(this).val()) || 0;
        });
        if (totalWeight != 100) {
            $('#bl-error').show();
            return false;
        }
        return true;
    }

    // Validate BL Levels on form submission
    $('form').submit(function() {
        return validateBLLevels();
    });
</script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>