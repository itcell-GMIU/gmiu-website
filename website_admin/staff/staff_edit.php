<?php
// Include the checklogin.php file
include '../include/checklogin.php';

//  fetch staff details from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $staff_id = mysqli_real_escape_string($con, $_GET['id']);
    $staff_id = only_digits($staff_id);
    if ($staff_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='staff_view.php'},1000)</script>";
    }

    $cmd = $con->prepare("SELECT staff.id as staff_id, staff.faculty_id as faculty_id,staff.level_id as level_id,staff.program_id as program_id, staff.name as staff_name, staff.mobile_number as staff_mobile_number, staff.email as staff_email, staff.work_since as staff_work_since,staff.position as staff_position, staff.location as staff_location,staff.total_experience as staff_total_experience,  staff.shortname as staff_shortname, staff.description as staff_description, staff.image as image, staff.is_active as staff_is_active FROM tbl_staff as staff WHERE staff.id = ? ");
    $cmd->bind_param("i", $staff_id);
    $cmd->execute();
    $result = $cmd->get_result();

    if ($result->num_rows != 0) {

        // Fetch data from database
        $row = $result->fetch_assoc();
        $staff_name = $row['staff_name'];
        $staff_mobile_number = $row['staff_mobile_number'];
        $staff_email = $row['staff_email'];
        $staff_work_since = $row['staff_work_since'];
        $staff_position = $row['staff_position'];
        $staff_location = $row['staff_location'];
        $staff_total_experience = $row['staff_total_experience'];
        $staff_shortname = $row['staff_shortname'];
        $staff_description = $row['staff_description'];
        $image = $row['image'];
        $staff_is_active = $row['staff_is_active'];
        $staff_program_id = $row['program_id'];
        $staff_program_id = explode(",", $staff_program_id);
    } else {

        $staff_name = "";
        $staff_mobile_number = "";
        $staff_email = "";
        $staff_work_since = "";
        $staff_position = "";
        $staff_location = "";
        $staff_total_experience = "";
        $staff_shortname = "";
        $staff_description = "";
        $image = "";
        $staff_is_active = "";
        $staff_program_id = "";
    }
} else {

    $staff_name = "";
    $staff_mobile_number = "";
    $staff_email = "";
    $staff_work_since = "";
    $staff_position = "";
    $staff_location = "";
    $staff_total_experience = "";
    $staff_shortname = "";
    $staff_description = "";
    $image = "";
    $staff_is_active = "";
    $staff_program_id = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>


    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <style>
        #row-form {
            display: grid;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #000000;
        }
    </style>
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
                            <h1 class="m-0">Edit Staff Details</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Staff Details</li>
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
                                    <h3 class="card-title">Edit Staff Details</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" action="staff_update.php"
                                    enctype="multipart/form-data">

                                    <!-- card-body -->
                                    <div class="card-body">
                                        <!-- hidden staff_id -->
                                        <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">
                                        <div class="form-group">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <!-- <div class="multi-select"> -->
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="program_id[]"
                                                multiple="multiple">
                                                <option value="<?php echo $program_id; ?>"> </option>
                                                <?php
                                                $cmd = "SELECT pro.id,pro.name,level.name as level_name ,faculty.name as staff_faculty FROM tbl_program as pro 
                                                LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
                                                LEFT JOIN tbl_level level ON pro.level_id = level.id 
                                                WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                while ($row = $result->fetch_assoc()) {
                                                    $program_id = $row['id'];
                                                    $program_name = $row['name'];
                                                    $level_name = $row['level_name'];
                                                    $staff_faculty = $row['staff_faculty'];
                                                    ?>

                                                    <option value="<?php echo $program_id; ?>" <?php if (in_array($program_id, $staff_program_id)) {
                                                           echo "selected";
                                                       } ?>>
                                                        <?php echo $program_name . "(" . $level_name . ")" . "(" . $staff_faculty . ")"; ?>
                                                    </option>

                                                <?php }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label>Name<span style="color: red;"> *</span></label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                value="<?php echo $staff_name; ?>" placeholder="Enter Name">
                                        </div>

                                        <div class="form-group">
                                            <label>Contact<span style="color: red;"> *</span></label>
                                            <input type="text" name="mobile_number" class="form-control"
                                                id="mobile_number" value="<?php echo $staff_mobile_number; ?>"
                                                placeholder="Enter Mobile Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Email <span style="color: red;"> *</span></label>
                                            <input type="text" name="email" class="form-control" id="email"
                                                value="<?php echo $staff_email; ?>" placeholder="Enter Email" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Work Since <span style="color: red;">*</span></label>
                                            <input type="date" name="work_since" class="form-control" id="work_since"
                                                value="<?php echo $staff_work_since; ?>"
                                                placeholder="Enter Program Name " required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Position <span style="color: red;">*</span></label>
                                            <input type="text" name="position" class="form-control" id="position"
                                                value="<?php echo $staff_position; ?>" placeholder="Enter Position"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Location <span style="color: red;">*</span></label>
                                            <input type="text" name="location" class="form-control" id="location"
                                                value="<?php echo $staff_location; ?>" placeholder="Enter  Location "
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Total Experience(Mention years i.e(10 years))<span
                                                    style="color: red;">*</span></label>
                                            <input type="text" name="total_experience" class="form-control"
                                                id="total_exp" value="<?php echo $staff_total_experience; ?>"
                                                placeholder="Enter Total Experience" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Short Name <span style="color: red;">*</span></label>
                                            <input type="text" name="shortname" class="form-control" id="location"
                                                value="<?php echo $staff_shortname; ?>" placeholder="Enter Short Name "
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="text_editor">About </label>
                                            <textarea id="text_editor"
                                                name="description"><?php echo htmlspecialchars_decode($staff_description); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Status<span style="color: red;">*</span></label>
                                            <select class="form-control" name="staff_is_active">
                                                <option value="1" <?php if ($staff_is_active == "1") {
                                                    echo "selected";
                                                } ?>>Active
                                                </option>
                                                <option value="0" <?php if ($staff_is_active == "0") {
                                                    echo "selected";
                                                } ?>>
                                                    InActive</option>

                                            </select>
                                        </div>

                                        <div name="image" id="image" class="form-group">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Image</label><span
                                                    style="color: red;"> *</span>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="file_input"
                                                            id="file_input">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php

                                        $cmd = $con->prepare("SELECT staff.image as image FROM `tbl_staff` as staff where id = ?");
                                        $cmd->bind_param("i", $staff_id);
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $image = !empty($row['image']) ? $row['image'] : "";
                                            ?>
                                            <input type="hidden" name="oldImage" value="<?php echo $image; ?>">
                                            <div class="input-group" id="imgPrev">
                                                <img src="<?php echo "../uploads/profile/" . "$image"; ?>" width="150"
                                                    height="150">
                                            </div>
                                            <?php
                                        } ?>

                                        <br />

                                        <!-- hidden inpout field for the qualification delet ids   -->
                                        <input type="hidden" name="deleted_ids" id="deleted_ids" value="">

                                        <div class="form-group">
                                            <h4>Qualification Details(Start With Last Qualification)</h4>
                                            <hr>
                                            <input type="button" class="form-control col-sm-3 btn btn-info"
                                                id="add-quali-field" value="Add More Qualification Details"> <br />
                                            <br />
                                            <?php
                                            $cmd = 'SELECT qualification.id as id, qualification.qualification as qualification, qualification.branch as branch, qualification.passing_year as year FROM tbl_staff_qualification as qualification WHERE staff_id = ?';
                                            $cmd = $con->prepare($cmd);
                                            $cmd->bind_param('i', $staff_id);
                                            $cmd->execute();
                                            $result = $cmd->get_result();

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $qualification = $row['qualification'];
                                                    $branch = $row['branch'];
                                                    $year = $row['year'];
                                                    $id = $row['id'];
                                                    ?>
                                                    <div class="row" id="multi-qualification-details">
                                                        <div class="form-group col-sm-3">
                                                            <label for="qualification">Enter Qualification</label>
                                                            <input type="text" name="qualification[]" id="qualification"
                                                                class="form-control" placeholder="Enter Qualification"
                                                                value="<?php echo $qualification; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-3">
                                                            <label for="branch">Enter Branch</label>
                                                            <input type="text" name="branch[]" id="branch" class="form-control"
                                                                placeholder="Enter Branch" value="<?php echo $branch; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-3">
                                                            <label for="year">Enter Passing Year</label>
                                                            <select id="ddlYears" name="passing_year[]" id="year"
                                                                class="form-control">
                                                                <option value="<?php echo $year; ?>"><?php echo $year; ?>
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <!-- hidden inout field   -->
                                                        <input type="hidden" name="qualification_ids[]"
                                                            value="<?php echo $id; ?>">

                                                        <div class="form-group col-sm-3">
                                                            <button type="button"
                                                                class="form-control btn btn-danger remove-quali-field"
                                                                data-id="<?php echo $id; ?>"
                                                                style="margin-top: 32px;">Remove</button>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>

                                                <!-- row -->
                                                <div class="row" id="multi-qualification-details">
                                                    <div class="form-group col-sm-3">
                                                        <label for="qualification">Enter Qualification</label>
                                                        <input type="text" name="qualification[]" id="qualification"
                                                            class="form-control" placeholder="Enter Qualification">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="branch">Enter Branch</label>
                                                        <input type="text" name="branch[]" id="branch" class="form-control"
                                                            placeholder="Enter Branch">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="year">Enter Passing Year</label>
                                                        <select id="ddlYears" name="passing_year[]" id="year"
                                                            class="form-control">
                                                            <option value="">--Select Passing Year--</option>
                                                        </select>
                                                        <!-- <input type="text" placeholder="Enter Passing Year"> -->
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <button type="button" id="remove-quali-field"
                                                            class="form-control btn btn-danger"
                                                            style="margin-top: 32px;">Remove</button>
                                                    </div>
                                                </div> <!-- /.row -->

                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <br />

                                        <div class="form-group">
                                            <h4>Experience Details(Start With Last Experience)</h4>
                                            <hr>
                                            <input type="button" class="form-control col-sm-3 btn btn-info"
                                                id="add-exp-field" value="Add More Experience Details"> <br /> <br />
                                            <?php
                                            $cmd = 'SELECT experience.join_date as join_date, experience.till_date as till_date, experience.role as role, experience.organization as organization FROM tbl_staff_experience as experience WHERE staff_id = ?';
                                            $cmd = $con->prepare($cmd);
                                            $cmd->bind_param('i', $staff_id);
                                            $cmd->execute();
                                            $result = $cmd->get_result();

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $join_date = $row['join_date'];
                                                    $till_date = $row['till_date'];
                                                    $role = $row['role'];
                                                    $organization = $row['organization'];
                                                    ?>
                                                    <div class="row" id="multi-experience-details">

                                                        <div class="form-group col-sm-3">
                                                            <label for="organization">Enter Organization</label>
                                                            <input type="text" name="organization[]" id="organization"
                                                                class="form-control" placeholder="Enter organization"
                                                                value="<?php echo $organization; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-3">
                                                            <label for="role">Enter Position/Role</label>
                                                            <input type="text" name="role[]" id="role" class="form-control"
                                                                placeholder="Enter Position/Role" value="<?php echo $role; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-3">
                                                            <label for="join_date">Enter Joining Date</label>
                                                            <input type="date" name="join_date[]" id="join_date"
                                                                class="form-control" value="<?php echo $join_date; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-3">
                                                            <label for="till_date">Experience Till Date</label>
                                                            <input type="date" name="till_date[]" id="till_date"
                                                                class="form-control" value="<?php echo $till_date; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-3">
                                                            <button type="button" id="remove-exp-field"
                                                                class="form-control btn btn-danger">Remove</button>
                                                        </div>

                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>

                                                <!-- row -->
                                                <div class="row" id="multi-experience-details">

                                                    <div class="form-group col-sm-3">
                                                        <label for="organization">Enter Organization</label>
                                                        <input type="text" name="organization[]" id="organization"
                                                            class="form-control" placeholder="Enter organization">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="role">Enter Position/Role</label>
                                                        <input type="text" name="role[]" id="role" class="form-control"
                                                            placeholder="Enter Position/Role">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="join_date">Enter Joining Date</label>
                                                        <input type="date" name="join_date[]" id="join_date"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="till_date">Experience Till Date</label>
                                                        <input type="date" name="till_date[]" id="till_date"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <button type="button" id="remove-exp-field"
                                                            class="form-control btn btn-danger">Remove</button>
                                                    </div>
                                                </div> <!-- /.row -->

                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <!-- card-footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <!-- /.card-footer -->

                                    </div> <!-- /.card-body -->
                                </form>
                            </div> <!-- /.card -->
                        </div> <!--/.col (left) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include '../include/importfooter.php'; ?>
        <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>


<script>
    //alert("Script Loaded");
    $(document).ready(function () {
        $('.select2option').select2();
    });
</script>
<!-- Script for year dropdown -->
<script type="text/javascript">
    window.onload = function () {
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
    // const addButton = document.getElementById('add-quali-field');

    // addButton.addEventListener('click', function () {
    //     const rowDiv = document.getElementById('multi-qualification-details');
    //     const clonedRow = rowDiv.cloneNode(true);
    //     const removeButton = clonedRow.querySelector('#remove-quali-field');

    //     removeButton.addEventListener('click', function () {
    //         const rowToRemove = this.parentNode.parentNode;
    //         rowToRemove.parentNode.removeChild(rowToRemove);
    //     });

    //     rowDiv.parentNode.appendChild(clonedRow);
    // });
   
document.addEventListener("DOMContentLoaded", function () {
    const addButton = document.getElementById('add-quali-field');

    if (addButton) { // check if element exists
        addButton.addEventListener('click', function () {
            const rowDiv = document.getElementById('multi-qualification-details');
            if (!rowDiv) return; // safeguard if template not present

            const clonedRow = rowDiv.cloneNode(true);

            // find remove button inside clone
            const removeButton = clonedRow.querySelector('.remove-quali-field'); 
            if (removeButton) {
                removeButton.addEventListener('click', function () {
                    this.closest(".row").remove();
                });
            }

            rowDiv.parentNode.appendChild(clonedRow);
        });
    }
});


</script>




<!-- Script for add multiple Experience fields -->
<script>
    const addExpBtn = document.getElementById('add-exp-field');

    addExpBtn.addEventListener('click', function () {
        const rowDiv = document.getElementById('multi-experience-details');
        const clonedRow = rowDiv.cloneNode(true);
        const removeButton = clonedRow.querySelector('#remove-exp-field');

        removeButton.addEventListener('click', function () {
            const rowToRemove = this.parentNode.parentNode;
            rowToRemove.parentNode.removeChild(rowToRemove);
        });

        rowDiv.parentNode.appendChild(clonedRow);
    });
</script>


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

    document.addEventListener("DOMContentLoaded", function () {
        // Select all remove buttons
        document.querySelectorAll("#remove-exp-field").forEach(function (button) {
            button.addEventListener("click", function () {
                this.disabled = true; // Disable the button
                this.closest(".row").classList.add("pending-delete"); // Mark for deletion
            });
        });

        // Handle form submission
        document.querySelector("form").addEventListener("submit", function () {
            document.querySelectorAll(".pending-delete").forEach(function (row) {
                row.remove(); // Remove rows marked for deletion
            });
        });
    });

</script>

<!-- qualification delete script   -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let deletedIds = [];

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-quali-field')) {
                const id = e.target.getAttribute('data-id');
                if (id) {
                    deletedIds.push(id);
                    document.getElementById('deleted_ids').value = deletedIds.join(',');
                }
                // Remove the parent row
                e.target.closest('.row').remove();
            }
        });
    });
</script>