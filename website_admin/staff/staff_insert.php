<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {

    //Fetch data from HTML Form
   
    $program_id = $_POST['program_id'];
    $program_id = implode(',', $program_id);
 /*  echo $program_id;
  exit(); */
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $work_since = mysqli_real_escape_string($con, $_POST['work_since']);
    $position = mysqli_real_escape_string($con, $_POST['position']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $total_experience = mysqli_real_escape_string($con, $_POST['total_experience']);
    $shortname = mysqli_real_escape_string($con, $_POST['shortname']);
    $description = $_POST['description'];

    // Validate Data
    $role_id = 4;
  
  
    $name = validate_data($name);
    $mobile_number = validate_data($mobile_number);
    $email = validate_data($email);
    $work_since = validate_data($work_since);
    $position = validate_data($position);
    $location = validate_data($location);
    $total_experience = validate_data($total_experience);
    $shortname = validate_data($shortname);
    $description = validate_data($description);

    if (isset($_FILES['file_input'])) {

        // image upload function
        $targetDirectory = "../uploads/profile/";
        $file_upload_status = upload_single_file($_FILES["file_input"], $targetDirectory, 1);

        if ($file_upload_status['status'] == 200) {

            $file_name = $file_upload_status['message'];
         
            $stmt = $con->prepare("INSERT INTO `tbl_staff`(role_id,program_id,name,email,mobile_number,shortname,position,work_since,location,total_experience,description,image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("isssisssssss",$role_id,$program_id, $name, $email, $mobile_number, $shortname, $position, $work_since, $location, $total_experience, $description, $file_name);
            $result = $stmt->execute(); 

            if ($result) {

                // primary ID of recently inserted data
                $staff_id = $con->insert_id;

                // get JSON data from request
                $data = json_decode(file_get_contents("php://input"), true);

                // insert qualification data into database
                if (isset($_POST['qualification']) && !empty($_POST['qualification'])) {
                    foreach ($_POST["qualification"] as $key => $value) {
                        $qualification = mysqli_real_escape_string($con, $value);
                        $branch = mysqli_real_escape_string($con, $_POST["branch"][$key]);
                        $passing_year = mysqli_real_escape_string($con, $_POST["passing_year"][$key]);

                        if (!empty($qualification)) {  // Check if qualification is not empty
                            $sql = "INSERT INTO tbl_staff_qualification (staff_id, qualification, branch, passing_year)
                                    VALUES ('$staff_id', '$qualification', '$branch', '$passing_year')";

                            if ($con->query($sql) !== true) {
                                die("Error: " . $sql . "<br>" . $con->error);
                            }
                        }
                    }
                }

                // get JSON data from request
                $data = json_decode(file_get_contents("php://input"), true);

                // insert experience data into database
                if (isset($_POST['organization']) && !empty($_POST['organization'])) {
                    foreach ($_POST["organization"] as $key => $value) {
                        $organization = mysqli_real_escape_string($con, $value);
                        $role = mysqli_real_escape_string($con, $_POST["role"][$key]);
                        $join_date = mysqli_real_escape_string($con, $_POST["join_date"][$key]);
                        $till_date = mysqli_real_escape_string($con, $_POST["till_date"][$key]);

                        if (!empty($organization)) {  // Check if organization is not empty
                            $sql2 = "INSERT INTO tbl_staff_experience (staff_id, organization, role, join_date, till_date)
                                      VALUES ('$staff_id', '$organization', '$role', '$join_date', '$till_date')";

                            if ($con->query($sql2) !== true) {
                                die("Error: " . $sql2 . "<br>" . $con->error);
                            }
                        }
                    }
                }

                 //Sweet Alert of Success Message
                $_SESSION['status'] = "Faculty Details Inserted Successfully";
                $_SESSION['status_code'] = "success"; 
               echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>"; 
            } else {

                //Sweet Alert of Error Message
                $_SESSION['status'] = "Faculty Details Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='staff_view.php'},1000)</script>";
            }
        } else {

            //Sweet Alert of Error Message
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='staff_insert.php'},1000)</script>";
        }
    } else {

        //Sweet Alert of Error Message
        $_SESSION['status'] = $file_upload_status['message'];
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='staff_insert.php'},1000)</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <!-- /.header -->

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
   
    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
        
    </script>
       <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #000000;
        }
        </style>
    
    <!-- /.CKeditor custom script -->

   <!--  <style>
        #row-form {
            column-gap: 16px;
            margin-top: 20px;
        }

        .multi-select {
            position: relative;
            display: inline-block;
        }

        .selected-items {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            min-height: 30px;
            cursor: text;
        }

        .selected-items>span {
            display: inline-block;
            background-color: #e0e0e0;
            color: #333;
            padding: 3px 8px;
            margin: 2px;
            border-radius: 20px;
        }

        .selection-input {
            font-size: 14px;
            padding: 5px;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .selection-input[multiple] {
            height: auto;
        }

        .selection-input[multiple] option:checked {
            background-color: #f5f5f5;
        }
    </style> -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

    <!-- wrapper -->
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
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">

                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Staff Details</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Staff Details</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- card -->
                            <div class="card card-gmiu">

                                <!-- card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">Add Staff Details</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">

                                    <!-- card-body -->
                                    <div class="card-body">

                                    <div class="form-group">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <!-- <div class="multi-select"> -->
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple" required>

                                                <?php
                                                $cmd = "SELECT pro.id,pro.name,level.name as level_name ,faculty.name as staff_faculty FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                                ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $program_id = $row['id'];
                                                    $program_name = $row['name'];
                                                    $level_name = $row['level_name'];
                                                    $staff_faculty = $row['staff_faculty'];

                                                ?>
                                                    <option value="<?php echo $program_id; ?>">
                                                        <?php echo $program_name . "(" . $level_name . ")" . "(" . $staff_faculty . ")"; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Name<span style="color: red;"> *</span></label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Contact<span style="color: red;"> *</span></label>
                                            <input type="text" name="mobile_number" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Email <span style="color: red;"> *</span></label>
                                            <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email" required >
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Work Since <span style="color: red;">*</span></label>
                                            <input type="date" name="work_since" class="form-control" id="work_since" placeholder="Enter Program Name " required >
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Position <span style="color: red;">*</span></label>
                                            <input type="text" name="position" class="form-control" id="position" placeholder="Enter Position" required >
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Location <span style="color: red;">*</span></label>
                                            <input type="text" name="location" class="form-control" id="location" placeholder="Enter Location(i.e.FF38) " required >
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Total Experience(Mention years i.e(10 years))<span style="color: red;">*</span></label>
                                            <input type="text" name="total_experience" class="form-control" id="position" placeholder="Enter Total Experience" required >
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Short Name <span style="color: red;">*</span></label>
                                            <input type="text" name="shortname" class="form-control" id="location" placeholder="Enter Short Name " required>
                                        </div>

                                        <div class="form-group">
                                            <label for="text_editor">About <span style="color: red;">*</span></label>
                                            <textarea name="description" id="text_editor" ></textarea required>
                                        </div>

                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Image</label><span style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="file_input" id="file_input" >
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group" id="imgPrev">
                                        </div>

                                        <br />

                                        <div class="form-group">
                                            <h4>Qualification Details(Start With Last Qualification)</h4>
                                            <hr>
                                            <input type="button" class="form-control col-sm-3 btn btn-info" id="add-quali-field" value="Add More Qualification Details"> <br /> <br />

                                            <!-- row -->
                                            <div class="row" id="multi-qualification-details">
                                                <div class="form-group col-sm-3">
                                                    <label for="qualification">Enter Qualification</label>
                                                    <input type="text" name="qualification[]" id="qualification" class="form-control" placeholder="Enter Qualification">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="branch">Enter Branch</label>
                                                    <input type="text" name="branch[]" id="branch" class="form-control" placeholder="Enter Branch">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="year">Enter Passing Year</label>
                                                    <select id="ddlYears" name="passing_year[]" id="year" class="form-control">
                                                        <option value="">--Select Passing Year--</option>
                                                    </select>
                                                    <!-- <input type="text" placeholder="Enter Passing Year"> -->
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <button type="button" id="remove-quali-field" class="form-control btn btn-danger" style="margin-top: 32px;">Remove</button>
                                                </div>
                                            </div> <!-- /.row -->
                                        </div>

                                        <br />

                                        <div class="form-group">
                                            <h4>Experience Details(Start With Last Experience)</h4>
                                            <hr>
                                            <input type="button" class="form-control col-sm-3 btn btn-info" id="add-exp-field" value="Add More Experience Details"> <br /> <br />

                                            <!-- row -->
                                            <div class="row" id="multi-experience-details">

                                                <div class="form-group col-sm-3">
                                                    <label for="organization">Enter Organization</label>
                                                    <input type="text" name="organization[]" id="organization" class="form-control" placeholder="Enter organization">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="role">Enter Position/Role</label>
                                                    <input type="text" name="role[]" id="role" class="form-control" placeholder="Enter Position/Role">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="join_date">Enter Joining Date</label>
                                                    <input type="date" name="join_date[]" id="join_date" class="form-control">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="till_date">Experience Till Date</label>
                                                    <input type="date" name="till_date[]" id="till_date" class="form-control">
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <button type="button" id="remove-exp-field" class="form-control btn btn-danger">Remove</button>
                                                </div>
                                            </div> <!-- /.row -->
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </div> <!-- /.card-body -->
                                </form>
                            </div> <!-- /.card -->
                        </div> <!--/.col (left) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- footer -->
    <?php include '../include/importfooter.php'; ?>
    <!-- /.footer -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>


<!-- Script for select2 -->
<script> 
$(document).ready(function() {
    $('.select2option').select2();
});
</script>
<!-- Script for year dropdown -->
<script type="text/javascript">
    window.onload = function() {
        //Reference the DropDownList.
        var ddlYears = document.getElementById("ddlYears");

        //Determine the Current Year.
        var currentYear = (new Date()).getFullYear();

        //Loop and add the Year values to DropDownList.
        for (var i = 1950; i <= currentYear; i++) {
            var option = document.createElement("OPTION");
            option.innerHTML = i;
            option.value = i;
            ddlYears.appendChild(option);
        }
    };
</script>

<!-- Script for add multiple Qualification fields -->
<script>
    const addButton = document.getElementById('add-quali-field');

    addButton.addEventListener('click', function() {
        const rowDiv = document.getElementById('multi-qualification-details');
        const clonedRow = rowDiv.cloneNode(true);
        const removeButton = clonedRow.querySelector('#remove-quali-field');

        removeButton.addEventListener('click', function() {
            const rowToRemove = this.parentNode.parentNode;
            rowToRemove.parentNode.removeChild(rowToRemove);
        });

        rowDiv.parentNode.appendChild(clonedRow);
    });
</script>

<!-- Script for add multiple Experience fields -->
<script>
    const addExpBtn = document.getElementById('add-exp-field');

    addExpBtn.addEventListener('click', function() {
        const rowDiv = document.getElementById('multi-experience-details');
        const clonedRow = rowDiv.cloneNode(true);
        const removeButton = clonedRow.querySelector('#remove-exp-field');

        removeButton.addEventListener('click', function() {
            const rowToRemove = this.parentNode.parentNode;
            rowToRemove.parentNode.removeChild(rowToRemove);
        });

        rowDiv.parentNode.appendChild(clonedRow);
    });
</script>

<!-- send data to server using AJAX -->
<script>
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const response = JSON.parse(this.responseText);
            console.log(response);
        }
    };
    xhttp.open("POST", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify(data));
</script>

<script>
    function submitData() {
        const id = document.getElementById("form-fields");
        const formData = new FormData(form);
        const data = {};

        // convert form data to JSON
        for (const [key, value] of formData.entries()) {
            data[key] = value;
        }

        // send data to server using AJAX
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                const response = JSON.parse(this.responseText);
                console.log(response);
            }
        };
        xhttp.open("POST", true);
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.send(JSON.stringify(data));
    }
</script>

<script>
    function submitData() {
        const id = document.getElementById("form-field");
        const formData = new FormData(form);
        const data = {};

        // convert form data to JSON
        for (const [key, value] of formData.entries()) {
            data[key] = value;
        }

        // send data to server using AJAX
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                const response = JSON.parse(this.responseText);
                console.log(response);
            }
        };
        xhttp.open("POST", true);
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.send(JSON.stringify(data));
    }
</script>

<!-- Script for load levels and programs dynamically -->


<!-- Library for image preview -->
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- Custom script for image preview -->
<script>
    const input = document.getElementById('file_input');
    const preview = document.getElementById('imgPrev');

    input.addEventListener('change', () => {
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        const files = input.files;
        if (!files) {
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = () => {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.marginLeft = '20px';
                img.style.marginTop = '10px';
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
</script>