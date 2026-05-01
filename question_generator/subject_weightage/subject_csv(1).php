<?php
// Include the checklogin.php file
include '../include/checklogin.php';


// if (isset($_POST["import"])) {
//     // Get the uploaded file's temporary name
//     $filename = $_FILES["file"]["tmp_name"];

//     // Check if the file is not empty
//     if ($_FILES["file"]["size"] > 0) {
//         // Open the CSV file for reading
//         $file = fopen($filename, "r");

//         // Flag to skip the first row (headers)
//         $skipFirstRow = true;

//         // Loop through each row in the CSV file
//         while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
//             // Skip the first row (header row)
//             if ($skipFirstRow) {
//                 $skipFirstRow = false;
//                 continue;
//             }
//             // Extract form data
//             $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
//             $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
//             $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
//              // Extract other data from the CSV
//             $sem = mysqli_real_escape_string($con, $getData[0]);
//             $subject_code = mysqli_real_escape_string($con, $getData[1]);
//             $subject_name = mysqli_real_escape_string($con, $getData[2]);
           

//             // Insert data into the tbl_std_corner_exam table
//             $stmt = $con->prepare("INSERT INTO `tbl_std_corner_exam` (subject_code, sem, subject_name, faculty_id, level_id, program_id) VALUES (?, ?, ?, ?, ?, ?)");
//             $stmt->bind_param("ssssss", $subject_code, $sem, $subject_name, $faculty_id, $level_id, $program_id);

//             // Execute the statement
//             $result = $stmt->execute();

//             // Error handling if insertion fails
//             if (!$result) {
//                 $_SESSION['status'] = "Failed to import data.";
//                 $_SESSION['status_code'] = "error";
//                 break; // Exit the loop if an error occurs
//             }
//         }

//         // Close the file
//         fclose($file);

//         // Check if data was successfully imported
//         if ($result) {
//             $_SESSION['status'] = "Imported Successfully";
//             $_SESSION['status_code'] = "success";
//         }

//         // Redirect after 2 seconds
//         echo "<script>setTimeout(function(){window.location='subject_view.php'},2000)</script>";
//     }
// }
if (isset($_POST["import"])) {
    // Get the uploaded file's temporary name
    $filename = $_FILES["file"]["tmp_name"];

    // Check if the file is not empty
    if ($_FILES["file"]["size"] > 0) {
        // Open the CSV file for reading
        $file = fopen($filename, "r");

        // Flag to skip the first row (headers)
        $skipFirstRow = true;

        // Initialize a result flag
        $result = true;

        // Loop through each row in the CSV file
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Skip the first row (header row)
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }

            // Extract form data
            $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
            $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
            $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
            $sem = mysqli_real_escape_string($con, $getData[0]);
            $subject_code = mysqli_real_escape_string($con, $getData[1]);
            $subject_name = mysqli_real_escape_string($con, $getData[2]);

            // Check if the subject_code already exists in the database
            // $checkQuery = "SELECT id FROM tbl_std_corner_exam 
            //               WHERE subject_code = ? AND is_active = 1 AND is_delete = 0";
            // $checkStmt = $con->prepare($checkQuery);
            // $checkStmt->bind_param("s", $subject_code);
            // Prepare the query
            $checkQuery = "SELECT id 
                           FROM tbl_std_corner_exam 
                           WHERE subject_code = ? 
                             AND faculty_id = ? 
                             AND program_id = ? 
                             AND level_id = ? 
                             AND is_active = 1 
                             AND is_delete = 0";
            
            // Bind parameters
            $checkStmt = $con->prepare($checkQuery);
            $checkStmt->bind_param("ssss", $subject_code, $faculty_id, $program_id, $level_id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            // If the subject_code exists, set an error message and stop processing
            if ($checkResult->num_rows > 0) {
                $_SESSION['status'] = "Subject code '$subject_code' already exists. In Next CSV please remove subject above this code.";
                $_SESSION['status_code'] = "error";
                $result = false; // Set result to false since the import failed
                break; // Exit the loop
            }

            // Insert data into the tbl_std_corner_exam table
            $stmt = $con->prepare("INSERT INTO tbl_std_corner_exam 
                (subject_code, sem, subject_name, faculty_id, level_id, program_id) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $subject_code, $sem, $subject_name, $faculty_id, $level_id, $program_id);

            // Execute the statement
            $insertResult = $stmt->execute();

            // Error handling if insertion fails
            if (!$insertResult) {
                $_SESSION['status'] = "Failed to import data.";
                $_SESSION['status_code'] = "error";
                $result = false; // Set result to false since the import failed
                break; // Exit the loop if an error occurs
            }
        }

        // Close the file
        fclose($file);

        // Check if data was successfully imported
        if ($result) {
            $_SESSION['status'] = "Imported Successfully";
            $_SESSION['status_code'] = "success";
        }

        // Redirect after 2 seconds
        echo "<script>setTimeout(function(){window.location='subject_view.php'},4000)</script>";
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
    <meta charset="UTF-8">
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
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
                            <h1 class="m-0">Add Subject CSV</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Subject CSV</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">

                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-gmiu">
                                <div class="card-header h-100">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title h-100 mt-1">Add Subject CSV</h3>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <a class="btn btn-dark p-1" href="subject.csv" download="subject.csv"><i class="fa fa-download"></i> Download Sample csv</a>
                                        </div>

                                    </div>
                                </div>
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        
                                  <br>
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
                                            <div class="form-group col-md-6">
                                                <label for="name">Upload CSV<span style="color: red;">*</span></label>
                                                <input type="file" name="file" class="form-control h-100" id="file" accept=".csv" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <button id="previewBtn" class="btn btn-info">Preview</button>
                                            </div>
                                        </div>
                                        <div id="previewTableDiv" class="form-group col-md-12" style="display: none;">
                                            <h4>CSV Preview</h4>
                                            <table class="table table-bordered">

                                                <tbody id="previewTableBody">
                                                    <!-- Preview data will be inserted here -->
                                                </tbody>

                                            </table>

                                            <input type="checkbox" id="confirmCheckbox"> I confirm that I want to submit the subjects.

                                        </div>


                                        <div class="card-footer text-right">
                                            <input type="submit" name="import" value="Import" class="btn btn-primary">
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
<?php // } 
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
 $(document).ready(function() {
    $('#previewBtn').click(function(event) {
        event.preventDefault(); // Prevent form submission

        // Get the file from the input
        var file = $('#file')[0].files[0];
        if (file) {
            var reader = new FileReader();

            // When the file is loaded
            reader.onload = function(e) {
                var rows = e.target.result.split('\n'); // Split into rows
                var tableContent = '';

                // Iterate over rows and build table rows for preview
                rows.forEach((row, index) => {
                    if (row.trim()) { // Ignore empty rows
                        var cells = parseCSVRow(row);
                        tableContent += '<tr>';
                        cells.forEach((cell) => {
                            tableContent += `<td>${cell}</td>`;
                        });
                        tableContent += '</tr>';
                    }
                });

                // Insert content into the preview table body and show the preview section
                $('#previewTableBody').html(tableContent);
                $('#previewTableDiv').show();
            };

            reader.readAsText(file); // Read file as text
        } else {
            alert('Please select a file to preview.');
        }
    });

    // Confirm checkbox before submitting
    $('#quickForm').submit(function(event) {
        if ($('#previewTableDiv').is(':visible')) {
            if ($('#confirmCheckbox').is(':checked')) {
                return true; // Proceed with form submission
            } else {
                event.preventDefault();
                alert('Please confirm before submitting the data.');
                return false;
            }
        } else {
            event.preventDefault();
            alert('Please click the preview button before submitting.');
            return false;
        }
    });

    // Function to parse CSV row (improved to handle CSV formatting)
    function parseCSVRow(row) {
        var cells = row.split(',');
        return cells.map(cell => cell.trim().replace(/^"|"$/g, '')); // Trim and remove surrounding quotes
    }
});


</script>