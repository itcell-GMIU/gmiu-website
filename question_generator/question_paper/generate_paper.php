<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- ClockPicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="js/question.css">

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

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
                            <h1 class="m-0">Generate Question Paper</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Generate Question Paper</li>
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
                                <div class="card-header">
                                    <h3 class="card-title">Generate Question Paper</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <!--<div class="form-group col-md-4">-->
                                            <!--    <label for="clg_name">college Name <span style="color: red;">*</span></label>-->
                                            <!--    <input type="text" name="clg_name" class="form-control" id="clg_name" placeholder="ex. GYANMANJARI INSTITUTE OF TECHNOLOGY" required>-->
                                            <!--</div>-->
                                            <div class="form-group col-md-4">
                                                <label for="clg_name">College Name <span
                                                        style="color: red;">*</span></label>
                                                <select name="clg_name" class="form-control" id="clg_name" required>
                                                    <option value="" disabled selected>Select a College</option>
                                                    <option value="Gyanmanjari Institute of Technology">Gyanmanjari
                                                        Institute of Technology</option>
                                                    <option value="Gyanmanjari Diploma Engineering College">Gyanmanjari
                                                        Diploma Engineering College</option>
                                                    <option value="Gyanmanjari Pharmacy College">Gyanmanjari Pharmacy
                                                        College</option>
                                                    <option value="Gyanmanjari Science College">Gyanmanjari Science
                                                        College</option>
                                                    <option value="Gyanmanjari Institute of Commerce">Gyanmanjari
                                                        Institute of Commerce</option>
                                                    <option value="Gyanmanjari Institute of Management Studies">
                                                        Gyanmanjari Institute of Management Studies</option>
                                                    <option value="Gyanmanjari Institute of Arts">Gyanmanjari Institute
                                                        of Arts</option>
                                                    <option value="Gyanmanjari College of Computer Application">
                                                        Gyanmanjari College of Computer Application</option>
                                                    <option value="Gyanmanjari Institute of Design">Gyanmanjari
                                                        Institute of Design</option>
                                                    <option value="Gyanmanjari Institute of Home Science">Gyanmanjari
                                                        Institute of Home Science</option>
                                                    <option
                                                        value="Gyanmanjari Institute of Medical Science and Health Care">
                                                        Gyanmanjari Institute of Medical Science and Health Care
                                                    </option>
                                                    <option value="Gyanmanjari Institute of Social Work">Gyanmanjari
                                                        Institute of Social Work</option>
                                                    <option value="Gyanmanjari Institute of Hotel Management">
                                                        Gyanmanjari Institute of Hotel Management</option>
                                                        <option value="Institute of Law">
                                                        Institute of Law</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="exam_name">Exam Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" name="exam_name" class="form-control" id="exam_name"
                                                    placeholder="ex. B.Tech.- End Semester Examination (ESE)-Summer-2024"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exam_time">Start Time <span
                                                        style="color: red;">*</span></label>
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="exam_time" class="form-control"
                                                        id="exam_time" placeholder="Enter time" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="end_time">End Time <span
                                                        style="color: red;">*</span></label>
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="end_time" class="form-control"
                                                        id="end_time" placeholder="Enter time" required>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="exam_date">Exam Date <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" name="exam_date" class="form-control" id="exam_date"
                                                    placeholder="Enter Date" required>
                                            </div>

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

                                            <div class="form-group col-md-4 ">
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
                                            <div class="form-group col-md-4 ">
                                                <label for="subject_code_id">Subject Code<span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" name="subject_code" required
                                                    id="subject_code_id">
                                                    <option value="">---Select subject Code---</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 ">
                                                <label for="t_marks">Total Marks <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" name="t_marks" required id="t_marks">
                                                    <option value="0">---Select Total Marks---</option>
                                                    <option value="90">50</option>
                                                    <option value="100">60</option>
                                                    <option value="180"> 100</option>
                                                    <option value="175"> 100 (175)</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <button name="show" class="btn btn-primary">show </button>
                                            </div>

                                            <div class="form-group col-md-12" id="questionContainer"></div>

                                            <!-- Hidden fields for saving original weightage -->
                                            <input type="hidden" id="blWeightageData" name="blWeightageData">
                                            <input type="hidden" id="chapterWeightageData" name="chapterWeightageData">

                                            <input type="hidden" id="checkboxID" name="checkboxID" value="">

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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Bootstrap JS for ClockPicker -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- ClockPicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
<script>
$(function() {
    // Attach datepicker to exam_date input
    $("#exam_date").datepicker({
        dateFormat: "yy-mm-dd", // format YYYY-MM-DD
        minDate: 0 // 0 = today, no past dates
    });
});
</script>
<!-- Config FIRST -->
<script>
window.apiConfig = {
    apiUrl: "<?php echo $base_url_api; ?>",
    questionUrl: "<?php echo $base_url_question_paper; ?>"

};
window.examConfig = {
    chapterLimits: <?php echo json_encode($limits ?? []); ?>,
    totalMarks: <?= (int)($totalMarks ?? 0) ?>
};
</script>
<script src="js/form_ui.js"></script>

<script>
var path = '<?php echo $base_url_question_paper; ?>';
$(document).ready(function() {
    // Event listener for "Show" button click
    $('button[name="show"]').on('click', function(event) {
        event.preventDefault(); // Prevent form submission

        var subjectCode = $('#subject_code_id').val(); // Fetch selected subject code
        var totalMarks = $('#t_marks').val(); // Fetch total marks


        // Check if subject code is selected
        if (subjectCode === '') {
            alert('Please select a subject code.');
            return;
        }
        // AJAX request to fetch questions based on selected subject code
        $.ajax({
            url: path + 'fetch_questions.php', // Update the URL with the correct path
            method: 'POST',
            data: {
                subject_code: subjectCode,
                t_marks: totalMarks // Include total marks in the data
            },
            success: function(response) {
                // Display fetched questions
                $('#questionContainer').html(response);

                var returnedValue =
                    response; // Assuming response contains the returned value
                // console.log("Returned value:", returnedValue);

            },
            error: function(xhr, status, error) {
                console.error("Error fetching questions:", error);
            }
        });
    });

});
</script>


<script>
$(document).ready(function() {
    // Function to capture selected checkbox IDs and update the hidden field
    $('form#quickForm').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();
        // Check if the checkbox is checked
        if ($('#confirmCheckbox').is(':checked')) {
            // Collect all form data


            var formData = $(this).serialize();
            console.log(formData);
            // AJAX request to send form data to js.php
            $.ajax({
                url: 'js.php', // Update with correct path to js.php
                type: 'POST',
                data: formData,
                success: function(response) {
                    // console.log("Response from server:", response); // Log the response
                    response = response.trim();
                    // Check if the response indicates success
                    if (response.trim() === 'Data inserted successfully!') {
                        // Redirect to view_generate_paper.php after successful insertion
                        window.location.href = 'view_generate_paper.php';
                    } else {
                        // Display error message if insertion fails
                        // alert(response);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error("Error:", error);
                    // Optionally, show an error message here
                }
            });
        } else {
            alert("Please Check The Confirm Box");
        }
    });
});
</script>