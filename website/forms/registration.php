<?php include '../../common/importwebsitefile.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['fullName'];
    $mobile_number = $_POST['mobileNumber'];
    $district = $_POST['district'];
    $school_name = $_POST['schoolName'];
    $email_id = $_POST['email'];
    $timing_slot = $_POST['timingSlot'];

    if (empty($full_name) || empty($mobile_number) || empty($district) || empty($school_name) || empty($email_id) || empty($timing_slot)) {
        echo "Error: All fields are required.";
        exit;
    }

    if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format.";
        exit;
    }

    $sql = "INSERT INTO tbl_ca_program_registration (full_name, mobile_number, district, school_name, email_id, preferred_timing_slot) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    $stmt->bind_param("ssssss", $full_name, $mobile_number, $district, $school_name, $email_id, $timing_slot);

    if ($stmt->execute()) {
        $safe_full_name = htmlspecialchars($full_name, ENT_QUOTES, 'UTF-8');
        echo <<<HTML
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    </head>
    <body>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Registration Successful!',
                    text: 'Thank you, {$safe_full_name}. We have received your details.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#6A4BA2'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reset the form
                        window.location.href=window.location.href;
                    }
                });
            });
        </script>
    </body>
HTML;

    } else {
        echo "<div style='font-family: Poppins, sans-serif; text-align: center; padding: 50px; background-color: #fef2f2; color: #991b1b; border: 2px solid #fca5a5; border-radius: 12px; margin: 50px;'>";
        echo "<h2 style='font-weight: 700; font-size: 2em;'>Error!</h2>";
        echo "<p style='font-size: 1.2em;'>Something went wrong. Please try again later.</p>";
        echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
        echo "<a href='#' onclick='window.history.back();' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #dc2626; color: white; text-decoration: none; border-radius: 8px;'>Go Back</a>";
        echo "</div>";
    }

    $stmt->close();
}
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CA Foundation Program Registration</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <meta name="keywords"
        content="CA Foundation, CA Registration, Chartered Accountant, Accounting Course, GMIU CA Program, CA Foundation Admission, Commerce Career, CA Classes, CA Coaching, Register CA Foundation">
    <meta name="description"
        content="Register now for the CA Foundation Program at GMIU. Limited seats available. Join top educators and boost your accounting career. Easy and quick registration form.">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-purple-500 to-indigo-600 flex justify-center items-center min-h-screen p-4 my-10 sm:my-0">
    <div
        class="bg-white/90 backdrop-blur-sm p-6 sm:p-10 rounded-2xl shadow-2xl max-w-2xl w-full text-center animate-fadeIn">
        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Company Logo"
            class="w-auto h-24 mx-auto mb-6 p-4 object-cover shadow-lg" />
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">CA Foundation Program Registration</h2>
        <p class="text-gray-600 mb-8">Fill in your details below to register.</p>

        <form method="POST" action="">
            <div class="space-y-4 text-left">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <input type="text" id="fullName" name="fullName" placeholder="Full Name" required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                        <i class="bi bi-telephone-fill"></i>
                    </span>
                    <input type="tel" id="mobileNumber" name="mobileNumber" placeholder="Mobile Number" required
                        maxlength="10" pattern="\d{10}" title="Please enter a 10-digit mobile number"
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                        <i class="bi bi-geo-alt-fill"></i>
                    </span>
                    <input type="text" id="district" name="district" placeholder="District" required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                        <i class="bi bi-building-fill"></i>
                    </span>
                    <input type="text" id="schoolName" name="schoolName" placeholder="School Name" required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                    <input type="email" id="email" name="email" placeholder="E-mail ID" required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                </div>

                <div class="pt-2">
                    <label class="font-semibold text-gray-700 block mb-3">Preferred Timing Slot</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <input type="radio" id="slot1" name="timingSlot" value="sun-1-3" required
                                class="hidden peer" />
                            <label for="slot1"
                                class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer transition-all duration-300 hover:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:border-indigo-500 peer-checked:shadow-md">
                                <i class="bi bi-clock-fill text-2xl text-indigo-500 mr-4"></i>
                                <div>
                                    <div class="font-bold text-gray-800">1:00 PM - 3:00 PM</div>
                                    <div class="text-sm text-gray-600">Sunday</div>
                                </div>
                            </label>
                        </div>

                        <div>
                            <input type="radio" id="slot2" name="timingSlot" value="sun-4-6" class="hidden peer" />
                            <label for="slot2"
                                class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer transition-all duration-300 hover:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:border-indigo-500 peer-checked:shadow-md">
                                <i class="bi bi-clock-history text-2xl text-indigo-500 mr-4"></i>
                                <div>
                                    <div class="font-bold text-gray-800">4:00 PM - 6:00 PM</div>
                                    <div class="text-sm text-gray-600">Sunday</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    Register Now
                </button>
            </div>
        </form>
    </div>
</body>

</html>