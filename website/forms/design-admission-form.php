<?php include '../../common/importwebsitefile.php';

$message = '';
$message_type = '';

if (isset($_POST['submit_gdast'])) {

    $full_name = trim($_POST['full_name']);
    $school_name = trim($_POST['school_name']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $other_type = trim($_POST['other_type']);
    $form_type = 10;

    // Validation
    if ($full_name === '' || $school_name === '' || $mobile === '' || $email === '' || $other_type === '') {
        $message = "All fields are required.";
        $message_type = "error";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $message = "Please enter a valid 10-digit mobile number.";
        $message_type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $message_type = "error";
    } else {

        $stmt = $con->prepare("
            INSERT INTO tbl_promotional_form_data 
            (full_name, school_name, mobile, email, other_type, form_type, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "sssssi",
            $full_name,
            $school_name,
            $mobile,
            $email,
            $other_type,
            $form_type
        );

        if ($stmt->execute()) {
            $message = "Your application has been submitted successfully.";
            $message_type = "success";
        } else {
            $message = "Something went wrong. Please try again.";
            $message_type = "error";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GMCET Test Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
            --accent-color: #1cc88a;
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --text-main: #2d3436;
        }

        body {
            font-family: 'Poppins', sans-serif;
            /*background: var(--bg-gradient);*/
            background-image: url('https://gmiu.edu.in/gmiu/modal_question_paper/gseb/hero.webp');
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
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

        .form-header {
            background: #f8f9fc;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .form-header h1 {
            margin: 0;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 28px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            margin: 10px 0 0;
            color: #ff0000;
            font-size: 18px;
        }

        form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #636e72;
            margin-bottom: 8px;
            margin-left: 2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #b2bec3;
            transition: 0.3s;
        }

        input,
        select {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #edeff2;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            box-sizing: border-box;
            transition: all 0.3s;
            background-color: #fdfdfd;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        }

        input:focus+i,
        select:focus+i {
            color: var(--primary-color);
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            background: var(--primary-color);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        button:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        /* Styling the dropdown specifically */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23b2bec3' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: calc(100% - 15px) center;
        }

        @media (max-width: 480px) {
            .container {
                border-radius: 0;
            }

            body {
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-header">
            <h1>GMCET</h1>
            <p>Gyanmanjari Common Entrance Test</p>
        </div>

        <form method="POST" autocomplete="off">

            <div class="form-group">
                <label>Student Full Name</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="full_name" placeholder="Enter your full name" required>
                </div>
            </div>

            <div class="form-group">
                <label>School Name</label>
                <div class="input-wrapper">
                    <i class="fas fa-school"></i>
                    <input type="text" name="school_name" placeholder="Name of your current school" required>
                </div>
            </div>

            <div class="form-group">
                <label>Mobile Number</label>
                <div class="input-wrapper">
                    <i class="fas fa-phone"></i>
                    <input type="tel" name="mobile" maxlength="10" placeholder="10-digit mobile number" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="example@email.com" required>
                </div>
            </div>

            <div class="form-group">
                <label>Exam Mode Preference</label>
                <div class="input-wrapper">
                    <i class="fas fa-laptop-code"></i>
                    <select name="other_type" required>
                        <option value="" disabled selected>Select Mode</option>
                        <option value="Online">Online Mode</option>
                        <option value="Offline">Offline Mode</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="form_type" value="10">

            <button type="submit" name="submit_gdast">
                <span>Submit Application</span>
                <i class="fas fa-paper-plane"></i>
            </button>

        </form>
    </div>

    <?php if (!empty($message)) { ?>
        <script>
            Swal.fire({
                icon: '<?= $message_type === "success" ? "success" : "error"; ?>',
                title: '<?= $message_type === "success" ? "Success!" : "Wait..." ?>',
                text: '<?= addslashes($message); ?>',
                confirmButtonColor: '#4e73df',
                background: '#fff',
                customClass: {
                    popup: 'rounded-popup'
                }
            }).then((result) => {
                /* Only redirect if the message type was successful */
                <?php if ($message_type === "success") { ?>
                    if (result.isConfirmed || result.isDismissed) {
                        // Redirects to the current page without the POST data
                        window.location.href = window.location.pathname;
                    }
                <?php } ?>
            });
        </script>
    <?php } ?>

</body>

</html>