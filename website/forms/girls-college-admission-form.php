<?php include '../../common/importwebsitefile.php'; ?>
<?php

$response = ["status" => "", "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_type = 9;
    $full_name = $con->real_escape_string($_POST['full_name']);
    $email = $con->real_escape_string($_POST['email']);
    $mobile = $con->real_escape_string($_POST['mobile']);
    $school_name = $con->real_escape_string($_POST['school_name']);
    $address = $con->real_escape_string($_POST['address']);
    $start_date = $con->real_escape_string($_POST['start_date']);
    $time_slot = $con->real_escape_string($_POST['time_slot']);

    // Logic for Course (Standard)
    $standard = $con->real_escape_string($_POST['courseId']);
    if ($standard == 'other') {
        $standard = $con->real_escape_string($_POST['otherCourse']);
    }

    $sql = "INSERT INTO tbl_promotional_form_data (form_type, full_name, email, mobile, school_name, standard, address, start_date, time_slot) 
            VALUES ('$form_type', '$full_name', '$email', '$mobile', '$school_name', '$standard', '$address', '$start_date', '$time_slot')";

    if ($con->query($sql) === TRUE) {
        $response["status"] = "success";
        $response["message"] = "Application Submitted Successfully!";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error: " . $con->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Form | Gyanmanjari Girls' College</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <style>
        :root {
            --primary-pink: #f8bbd0;
            --dark-pink: #ad1457;
            --soft-lavender: #f3e5f5;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8bbd08f;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.96);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 550px;
            border-top: 8px solid var(--primary-pink);
        }

        h2 {
            color: var(--dark-pink);
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 25px;
            font-size: 22px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 13px;
            color: #555;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .hidden-field {
            display: none;
            margin-top: 10px;
            animation: fadeIn 0.3s;
        }

        button {
            width: 100%;
            padding: 12px;
            background: var(--dark-pink);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Gyanmanjari Girls' College Admission Form</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label>Student Full Name</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="form-group">
                <label>School Name</label>
                <input type="text" name="school_name" required>
            </div>

            <div class="form-group">
                <label>Mobile Number</label>
                <input type="tel" name="mobile" pattern="[0-9]{10}" required>
            </div>

            <div class="form-group">
                <label>E-mail Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="2" required></textarea>
            </div>

            <div class="form-group">
                <label>Course Interested (Standard)</label>
                <select id="courseId" name="courseId" onchange="toggleOtherInput()" required>
                    <option value="" disabled selected>Select Course</option>
                    <option value="BA">BA</option>
                    <option value="MA">MA</option>
                    <option value="B.COM">B.COM</option>
                    <option value="M.COM">M.COM</option>
                    <option value="BBA">BBA</option>
                    <option value="BCA">BCA</option>
                    <option value="Diploma in Fashion Design">Diploma in Fashion Design</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div id="otherCourseGroup" class="form-group hidden-field">
                <label>Specify Other Course</label>
                <input type="text" id="otherCourse" name="otherCourse">
            </div>

            <div class="form-group">
                <label>Preferred Date for Counselling</label>
                <input type="date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="time_slot">Preferred Time for Counselling</label>
                <input type="time" id="time_slot" name="time_slot" class="form-control" min="10:45" max="18:00"
                    step="900" required>
            </div>


            <button type="submit">Submit Application</button>
        </form>
    </div>

    <script>
        function toggleOtherInput() {
            const select = document.getElementById('courseId');
            const otherGroup = document.getElementById('otherCourseGroup');
            const otherInput = document.getElementById('otherCourse');

            if (select.value === 'other') {
                otherGroup.style.display = 'block';
                otherInput.setAttribute('required', 'required');
            } else {
                otherGroup.style.display = 'none';
                otherInput.removeAttribute('required');
            }
        }

        // Handle SweetAlert Notifications from PHP
        <?php if ($response["status"] == "success"): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $response["message"]; ?>',
                icon: 'success',
                confirmButtonColor: '#ad1457'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Refresh the page after clicking "OK"
                    window.location.href = window.location.pathname;
                }
            });
        <?php elseif ($response["status"] == "error"): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo $response["message"]; ?>',
                icon: 'error',
                confirmButtonColor: '#ad1457'
            });
        <?php endif; ?>
    </script>

</body>

</html>