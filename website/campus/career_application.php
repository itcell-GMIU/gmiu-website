<?php
include '../../common/importwebsitefile.php';
// Get slug from URL
$slug = basename($_SERVER['REQUEST_URI']);

// Initialize variables
$role_id = '';
$designation_id = '';
$role_name = '';
$designation_name = '';

if (!empty($slug)) {
    $stmt = $con->prepare("SELECT d.id AS designation_id, d.name AS designation_name,
                                  r.id AS role_id, r.name AS role_name
                          FROM tbl_designation d
                          JOIN tbl_career_role r ON r.id = d.role_id
                          WHERE d.slug = ? AND d.is_active = 1 ");

    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $stmt->bind_result($designation_id, $designation_name, $role_id, $role_name);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection


    // Sanitize and validate inputs
    function clean_input($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    $full_name = clean_input($_POST['full_name']);
    $email = clean_input($_POST['email']);
    $mobile = clean_input($_POST['mobile']);
    $alt_mobile = clean_input($_POST['alt_mobile']);
    $dob = clean_input($_POST['dob']);
    $gender = clean_input($_POST['gender']);
    $role = clean_input($_POST['role']);
    $designation = clean_input($_POST['designation']);
    $address = clean_input($_POST['address']);
    $pin = clean_input($_POST['pin']);
    $degree = clean_input($_POST['degree']);
    $university = clean_input($_POST['university']);
    $cgpa = clean_input($_POST['cgpa']);
    $passing_year = clean_input($_POST['passing_year']);
    $academic_exp = clean_input($_POST['academic_exp']);
    $industry_exp = clean_input($_POST['industry_exp']);
    $research_exp = clean_input($_POST['research_exp']);
    $total_exp = clean_input($_POST['total_exp']);
    $other = clean_input($_POST['other']);
    $join = clean_input($_POST['join']);

    // File upload handling
    $upload_dir ="../../website_admin/uploads/career/cv/";

    $allowed_types = array('pdf', 'doc', 'docx');
    $cv_file = "";

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $file_name = basename($_FILES["attachment"]["name"]);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_size = $_FILES["attachment"]["size"];

        if (!in_array($file_ext, $allowed_types)) {
            die("Invalid file format. Only PDF, DOC, and DOCX files are allowed.");
        }

        if ($file_size > 5 * 1024 * 1024) { // 5MB limit
            die("File size exceeds 5MB limit.");
        }
        $file_name =  time() . "_" . $file_name ; 
        $cv_file = $upload_dir . $file_name;
        if (!move_uploaded_file($_FILES["attachment"]["tmp_name"], $cv_file)) {
            die("Failed to upload file.");
        }
    } else {
        die("File upload is required.");
    }

    // Prepare SQL Query (Using Prepared Statements)
    $stmt = $con->prepare("INSERT INTO tbl_career_applications 
        (full_name, email, mobile, alt_mobile, dob, gender, address, pin, degree, university, cgpa, passing_year, academic_exp, industry_exp, research_exp, total_exp, other, join_availability, cv_file , role , designation) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? , ? )");

    $stmt->bind_param(
        "sssssssssssssssssssss",
        $full_name,
        $email,
        $mobile,
        $alt_mobile,
        $dob,
        $gender,
        $address,
        $pin,
        $degree,
        $university,
        $cgpa,
        $passing_year,
        $academic_exp,
        $industry_exp,
        $research_exp,
        $total_exp,
        $other,
        $join,
        $file_name,
        $role,
        $designation
    );

    // Execute Query
    if ($stmt->execute()) {
        $_SESSION['status'] = "Application submitted successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='../career.php'},1000);</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close(); 
    $con->close();
}


?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Career at GMIU - Gyanmanjari Innovative University | GMIU";
    include "../include/importhead.php"; ?>
    <?php include '../include/importcss.php'; ?>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .career-form-container {
            /* max-width: 800px; */
            margin: 40px auto;
            background: #ede3e3;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }

        .career-form h2 {
            text-align: center;
            color: #ba2a21;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
        }

        .btn-submit {
            background-color: #ba2a21;
            color: white;
            font-weight: bold;
            transition: 0.3s;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #8b1d16;
        }

        #filename {
            padding: 11px 11px;
            float: left;
            width: 75%;
            white-space: nowrap;
            overflow: hidden;
            background: #ba2a21;
            ;
            color: #fff;
            border-right: 1px solid #000;
        }

        label[for="file-upload"] {
            padding: 11px 11px;
            display: inline-block;
            background: #ba2a21;
            ;
            cursor: pointer;
            color: #fff;
            width: 25%;
            text-align: center;
        }

        @media (min-width: 1366px) and (max-width: 1439px) {
            .form-control1 {
                box-shadow: 0 4px 7px 0 #919191;
                height: 36px;
                background: #fff;
                padding: 4px 15px;
                font-size: 16px;
            }
        }

        .form-control1 {
            box-shadow: 0 4px 7px 0 #919191;
            height: 45px;
            background: #fff;
            padding: 11px 15px;
            font-size: 16px;
        }

        #file-upload {
            position: absolute;
            left: -9999px;
        }

        label {
            font-weight: 100 !important;
        }
  

    .gradText {
            background: linear-gradient(90deg, #b71c1c, #880e4f);
            /* Deep Red Gradient */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }

    </style>
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body class="courses">
    <?php include '../include/importheader.php'; ?>

    <section class="hero">
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Apply Now</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Apply Now</a></span>
                </p>
            </div>
        </div>
    </section>

    <div class="container">
        <section class="desSec" style="padding-bottom: 50px;">
          
            <div class="career-form-container">
                <form class="career-form" action="#" method="POST" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <h3 style="padding:unset; margin-top:unset;font-size:25px; color: #ba2a21;">Apply for a Position</h2>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control form-control1" name="full_name" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control form-control1" name="email" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Mobile Number</label>
                        <input type="tel" class="form-control form-control1" name="mobile" pattern="[0-9]{10}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Alternate Mobile Number</label>
                        <input type="tel" class="form-control form-control1" name="alt_mobile" pattern="[0-9]{10}">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" class="form-control form-control1" name="dob" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Gender</label>
                        <select class="form-control form-control1" name="gender" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control form-control1" name="address" required>

                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">PIN Code</label>
                        <input type="text" class="form-control form-control1" name="pin" pattern="[0-9]{6}" required>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label class="form-label" for="role">Role</label>
                       <select name="role" class="form-control form-control1" id="role" required>
                            <?php
                            $role_query = $con->query("SELECT id, name FROM tbl_career_role WHERE is_active = 1 AND is_delete = 0");
                            while ($row = $role_query->fetch_assoc()) {
                                $selected = ($row['id'] == $role_id) ? 'selected' : '';
                                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="designation">Designation</label>
                       <select name="designation" class="form-control form-control1" id="designation">
                                <?php
                                $desig_query = $con->query("SELECT id, name FROM tbl_designation WHERE is_active = 1 ");
                                while ($row = $desig_query->fetch_assoc()) {
                                    $selected = ($row['id'] == $designation_id) ? 'selected' : '';
                                    echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                                }
                                ?>
                            </select>

                    </div>


                    <div class="form-group col-md-12">
                        <h3>Education Details</h3>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Degree</label>
                        <input type="text" class="form-control form-control1" name="degree" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">University/Institute</label>
                        <input type="text" class="form-control form-control1" name="university" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Percentage/CGPA</label>
                        <input type="text" class="form-control form-control1" name="cgpa" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Year of Passing</label>
                        <input type="text" class="form-control form-control1" name="passing_year" required>
                    </div>

                    <div class="form-group col-md-12">
                        <h3>Experience Details</h3>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Academics Experience (Years)</label>
                        <input type="text" class="form-control form-control1" name="academic_exp">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Industry Experience (Years)</label>
                        <input type="text" class="form-control form-control1" name="industry_exp">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Research Experience (Years)</label>
                        <input type="text" class="form-control form-control1" name="research_exp">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Total Experience (Years)</label>
                        <input type="text" class="form-control form-control1" name="total_exp" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Other Information</label>
                        <input type="text" class="form-control form-control1" name="other">
                    </div>



                    <div class="form-group col-md-12">
                        <h3>Other</h3>
                    </div>

                    <div class="form-group col-md-4">
                        <select name="join" id="join" class="form-control form-control1" required="">
                            <option value="">How soon can you join?</option>
                            <option value="Immediately">Immediately</option>
                            <option value="Notice Period">Notice Period</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">

                        <span id="filename">Upload Curriculum Vitae (CV)</span>
                        <label for="file-upload">Browse
                            <input type="file" name="attachment" id="file-upload" accept=".doc, .docx, .pdf" required="">
                        </label>
                    </div>

                    <button type="submit" class="btn btn-submit">Apply Now</button>
                </form>
            </div>

        </section>
    </div>


    <?php include '../include/importfooter.php'; ?>
    <?php include '../include/importjs.php'; ?>
  
  

</body>

</html>