<?php
include '../../common/importwebsitefile.php'; // DB connection ($con)

$swal = ""; // For SweetAlert status

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // Collect & sanitize form data
    $full_name = strtoupper(mysqli_real_escape_string($con, $_POST['student_name']));
    $mobile = mysqli_real_escape_string($con, $_POST['student_mobile']);
    $email = mysqli_real_escape_string($con, $_POST['student_email']);
    $mobile2 = mysqli_real_escape_string($con, $_POST['parent_mobile']);

    // Insert query
    $sql = "INSERT INTO tbl_promotional_form_data 
                (form_type, full_name, email, mobile, mobile2) 
            VALUES 
                (7, '$full_name', '$email', '$mobile', '$mobile2')";

    if (mysqli_query($con, $sql)) {
        $swal = "success";
    } else {
        $swal = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Student Form</title>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            font-family: 'Poppins', sans-serif;
        }

        .glass-card {
            width: 420px;
            padding: 35px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card h3 {
            font-weight: 700;
            color: #fff;
            text-align: center;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .form-control {
            height: 48px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .form-control::placeholder {
            color: #f0f0f0;
        }

        label {
            color: #fff;
            font-size: 15px;
            font-weight: 600;
        }

        .btn-glow {
            width: 100%;
            height: 50px;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            border: none;
            background: linear-gradient(135deg, #ff8800, #ff3e3e);
            color: #fff;
            box-shadow: 0 0 15px #ff7b00;
            transition: 0.3s ease;
        }

        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px #ff5f00;
        }
    </style>
</head>

<body>

    <?php if ($swal == "success") { ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Form submitted successfully.',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php } ?>

    <?php if ($swal == "error") { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again.',
            });
        </script>
    <?php } ?>

    <div class="glass-card">
        <h3>12th Scholarship Test for Science, Arts & Commerce</h3>

        <form method="POST">

            <div class="mb-3">
                <label>Student Name <span class="text-warning">*</span></label>
                <input type="text" name="student_name" class="form-control" placeholder="Enter student name" required>
            </div>

            <div class="mb-3">
                <label>Student Mobile No. <span class="text-warning">*</span></label>
                <input type="tel" name="student_mobile" maxlength="10" class="form-control"
                    placeholder="10-digit mobile" required>
            </div>

            <div class="mb-3">
                <label>Student Email ID</label>
                <input type="email" name="student_email" class="form-control" placeholder="example@email.com">
            </div>

            <div class="mb-3">
                <label>Parents Mobile No. <span class="text-warning">*</span></label>
                <input type="tel" name="parent_mobile" maxlength="10" class="form-control"
                    placeholder="10-digit parent mobile" required>
            </div>

            <button type="submit" class="btn-glow" name="submit">Submit</button>

        </form>
    </div>

</body>

</html>