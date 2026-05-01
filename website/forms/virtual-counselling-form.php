<?php
include '../../common/importwebsitefile.php';

// =================================================================
// HELPER FUNCTION FOR SWEETALERT
// =================================================================
function show_alert($icon, $title, $text)
{
    // We use die() to stop the script and only output the alert.
    // The alert includes a script to redirect back to the form page after the user clicks "OK".
    die(get_alert_html($icon, $title, $text, true));
}

function get_alert_html($icon, $title, $text, $redirect)
{
    // Get the current script's name to redirect back to it.
    $redirect_script = $redirect ? "window.location.href = '" . basename($_SERVER['PHP_SELF']) . "';" : "";
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Submission Status</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '{$icon}',
                title: '{$title}',
                text: '{$text}',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) { {$redirect_script} }
            });
        </script>
    </body>
    </html>
HTML;
}


// =================================================================
// FORM SUBMISSION HANDLING
// =================================================================


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data safely
    $full_name = isset($_POST['name']) ? strtoupper(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
    $faculty_id = isset($_POST['faculty_id']) ? trim($_POST['faculty_id']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $time_slot = isset($_POST['time_slot']) ? trim($_POST['time_slot']) : '';

    $form_type = 3; // Default form type

    // --- Check if email already exists ---
    $check_sql = "SELECT id FROM tbl_promotional_form_data 
                  WHERE email = ? AND form_type = ? AND is_active = 1 AND is_delete = 0
                  LIMIT 1";
    if ($check_stmt = $con->prepare($check_sql)) {
        $check_stmt->bind_param("si", $email, $form_type);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            show_alert('error', 'Duplicate Email', 'This email has already been registered.');
            $check_stmt->close();
            $con->close();
            exit;
        }
        $check_stmt->close();
    }

    // --- Insert new record ---
    $insert_sql = "INSERT INTO tbl_promotional_form_data 
        (form_type, faculty_id, full_name, email, mobile, description, start_date, time_slot)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $con->prepare($insert_sql)) {
        $stmt->bind_param(
            "iissssss",
            $form_type,
            $faculty_id,
            $full_name,
            $email,
            $mobile,
            $description,
            $date,
            $time_slot
        );

        if ($stmt->execute()) {
            show_alert('success', 'Appointment Booked!', 'Your virtual counselling session has been successfully scheduled.');
        } else {
            show_alert('error', 'Database Error', 'Could not submit the form. Please try again later. Error: ' . $stmt->error);
        }

        $stmt->close();
    } else {
        show_alert('error', 'Server Error', 'Failed to prepare the database statement.');
    }

    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Counselling Form | GMIU</title>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container .form-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
            position: relative;
        }

        .form-container .form-title::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            border-radius: 2px;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #8e44ad;
            box-shadow: 0 0 0 0.25rem rgba(155, 89, 182, 0.25);
        }

        .submit-btn {
            background: linear-gradient(-135deg, #71b7e6, #9b59b6);
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 0.8rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            background: linear-gradient(-135deg, #61a6d6, #8e44ad);
        }
    </style>
</head>

<body>

    <div class="form-container">
        <div class="text-center mb-4">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Company Logo"
                style="height: 80px; width: auto;">
        </div>
        <h2 class="form-title">Book an <span class="text-primary">Appointment</span></h2>
        <h4 class="form-title">for <span class="text-primary">Virtual Counselling</span></h4>

        <form id="appointmentForm" method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                    required>
            </div>

            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="tel" class="form-control" id="mobile" name="mobile"
                    placeholder="Enter 10-digit mobile number" pattern="[0-9]{10}" maxlength="10" required>
            </div>

            <div class="form-group mb-3">
                <label for="faculty_id" class="form-label">Select Faculty<span style="color: red;"> *</span></label>
                <select class="form-control" name="faculty_id" required id="faculty_id">
                    <option value="">---Select Faculty---</option>
                    <?php
                    $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                    $stmt_faculty = $con->prepare($cmd);
                    $stmt_faculty->execute();
                    $result = $stmt_faculty->get_result();
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>">
                            <?php echo $row['name']; ?>
                        </option>
                    <?php }
                    $stmt_faculty->close();
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Extra (Description)</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Any additional details..."></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">Select Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="time_slot" class="form-label">Time Slot</label>
                    <select class="form-select" id="time_slot" name="time_slot" required>
                        <option selected disabled value="">Choose a slot</option>
                        <option value="10:00 AM - 10:30 AM">10:00 AM - 10:30 AM</option>
                        <option value="10:30 AM - 11:00 AM">10:30 AM - 11:00 AM</option>
                        <option value="11:00 AM - 11:30 AM">11:00 AM - 11:30 AM</option>
                        <option value="11:30 AM - 12:00 PM">11:30 AM - 12:00 PM</option>
                        <option value="12:00 PM - 12:30 PM">12:00 PM - 12:30 PM</option>
                        <option value="12:30 PM - 1:00 PM">12:30 PM - 1:00 PM</option>
                        <option value="1:00 PM - 1:30 PM">1:00 PM - 1:30 PM</option>
                        <option value="1:30 PM - 2:00 PM">1:30 PM - 2:00 PM</option>
                        <option value="2:00 PM - 2:30 PM">2:00 PM - 2:30 PM</option>
                        <option value="2:30 PM - 3:00 PM">2:30 PM - 3:00 PM</option>
                        <option value="3:00 PM - 3:30 PM">3:00 PM - 3:30 PM</option>
                        <option value="3:30 PM - 4:00 PM">3:30 PM - 4:00 PM</option>
                        <option value="4:00 PM - 4:30 PM">4:00 PM - 4:30 PM</option>
                        <option value="4:30 PM - 5:00 PM">4:30 PM - 5:00 PM</option>
                        <option value="5:00 PM - 5:30 PM">5:00 PM - 5:30 PM</option>
                    </select>
                    <p class="text-danger"><small>* Each meeting is of 30 minutes</small></p>
                </div>
            </div>

            <button type="submit" class="btn submit-btn">Book Now</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('date');

            // Set the minimum date to today to prevent booking past dates
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });
    </script>
</body>

</html>