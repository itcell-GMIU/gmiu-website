<?php include '../../common/importwebsitefile.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- Collect form data ---
    $full_name = strtoupper($_POST['fullName']);
    $mobile_number = $_POST['mobileNumber'];
    $standard = $_POST['standard'];
    $district = $_POST['district'];
    $school_name = $_POST['schoolName'];
    $email_id = $_POST['email'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $timing_slot = $_POST['timingSlot'];
    $course_type = $_POST['course_type']; // Hidden field, e.g., "AI-ML Program"

    // --- Basic Validation ---
    if (empty($full_name) || empty($mobile_number) || empty($district) || empty($school_name) || empty($email_id) || empty($timing_slot) || empty($standard) || empty($start_date)) {
        exit; // You can replace this with an alert if desired
    }

    if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
        exit;
    }

    // --- Fixed values for new table ---
    $form_type = 1;
    $other_type = $course_type;

    // --- Insert into new table ---
    $sql = "INSERT INTO tbl_promotional_form_data 
        (form_type, other_type, full_name, email, mobile, school_name, standard, district, start_date, end_date, time_slot)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    // Bind parameters (s for string, i for integer)
    $stmt->bind_param(
        "issssssssss",
        $form_type,
        $other_type,
        $full_name,
        $email_id,
        $mobile_number,
        $school_name,
        $standard,
        $district,
        $start_date,
        $end_date,
        $timing_slot
    );

    if ($stmt->execute()) {
        $safe_full_name = htmlspecialchars($full_name);
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
                        text: 'Thank you, {$safe_full_name}. We have received your details for the AI/ML Program.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#6A4BA2'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = window.location.href;
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AI-ML Foundation Program</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <meta name="keywords"
        content="AI/ML Program, Artificial Intelligence, Machine Learning, GMIU AI Program, AI Admission, Tech Career, AI Classes, ML Coaching, Register AI/ML">
    <meta name="description"
        content="Register now for the AI/ML Foundation Program at GMIU. Limited seats available. Join top educators and boost your career in technology. Easy and quick registration form.">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://gmiu.edu.in/gmiu/modal_question_paper/gseb/hero.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.4);
            position: fixed;
            inset: 0;
            z-index: -1;
        }
    </style>
</head>

<body class="flex justify-center items-center min-h-screen p-4 my-10 sm:my-0">
    <div class="overlay"></div>
    <div
        class="bg-white/90 backdrop-blur-sm p-6 sm:p-10 rounded-2xl shadow-2xl max-w-2xl w-full text-center animate-fadeIn">
        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Company Logo"
            class="w-auto h-24 mx-auto mb-6 p-4 object-cover shadow-lg" />
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">AI-ML Foundation Program</h2>
        <p class="text-gray-600 mb-8">Fill in your details below to register.</p>

        <form method="POST" action="">
            <!-- *** HIDDEN FIELD FOR AIML COURSE *** -->
            <input type="hidden" name="course_type" value="AIML">

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
                        <i class="bi bi-list"></i>
                    </span>
                    <select id="standard" name="standard" required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition appearance-none">
                        <option value="" disabled selected>Select Standard</option>
                        <option value="10">10<sup>th</sup></option>
                        <!-- <option value="12-com">12<sup>th</sup> Commerce</option> -->
                        <!-- <option value="12-arts">12<sup>th</sup> Arts</option> -->
                        <option value="12-sci">12<sup>th</sup> Science</option>
                        <option value="iti">ITI</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                        <i class="bi bi-geo-alt-fill"></i>
                    </span>
                    <select id="district" name="district" required class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg 
                        focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition appearance-none">
                        <option value="">Select District</option>
                        <?php
                        $result = $con->query("SELECT id, district_name FROM tbl_districts ORDER BY district_name ASC");
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['id'] . '">' . $row['district_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </div>

                <div id="school-container">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                            <i class="bi bi-building-fill"></i>
                        </span>
                        <input type="text" id="schoolName" name="schoolName" placeholder="School Name" required
                            class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                    </div>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                    <input type="email" id="email" name="email" placeholder="E-mail ID" required
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                            <i class="bi bi-calendar-event-fill"></i>
                        </span>
                        <input type="date" id="start_date" name="start_date" required placeholder="Start Date" class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg 
                        focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                    </div>
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                            <i class="bi bi-calendar-check-fill"></i>
                        </span>
                        <input type="date" id="end_date" name="end_date" readonly class="w-full pl-12 pr-4 py-3 bg-gray-100 border border-gray-300 rounded-lg 
                        focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
                    </div>
                </div>
                <p class="text-red-500"><small>* Validate dates are only 13, 14, 15 of December,
                        <strong>kindly select
                            only those dates</strong></small></p>

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
                                    <!--<div class="text-sm text-gray-600">Sunday</div>-->
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
                                    <!--<div class="text-sm text-gray-600">Sunday</div>-->
                                </div>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="slot3" name="timingSlot" value="sun-7:30-9:30"
                                class="hidden peer" />
                            <label for="slot3"
                                class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer transition-all duration-300 hover:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:border-indigo-500 peer-checked:shadow-md">
                                <i class="bi bi-clock-history text-2xl text-indigo-500 mr-4"></i>
                                <div>
                                    <div class="font-bold text-gray-800">7:30 PM - 9:30 PM</div>
                                    <!-- <div class="text-sm text-gray-600">Sunday</div> -->
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

    <script>
         const allowedDates = ["2025-12-13", "2025-12-14", "2025-12-15"];

        document.getElementById("start_date").addEventListener("input", function () {
            if (!allowedDates.includes(this.value)) {
                alert("Please select a valid date!");
                this.value = ""; // clear invalid date
            }
        });
    </script>

    <script>
        // --- Date Picker Logic ---
        const startInput = document.getElementById('start_date');
        const endInput = document.getElementById('end_date');
        const pad = n => String(n).padStart(2, '0');
        const iso = d => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
        startInput.addEventListener('change', () => {
            if (startInput.value) {
                let startDate = new Date(startInput.value);
                let endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 2);
                endInput.value = iso(endDate);
            } else {
                endInput.value = '';
            }
        });

        // *** JAVASCRIPT FOR DYNAMIC SCHOOL FIELD ***
        const districtSelect = document.getElementById('district');
        const standardSelect = document.getElementById('standard');
        const schoolContainer = document.getElementById('school-container');
        const schoolSelect = document.getElementById("schoolName");

        const schoolInputHTML = `
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500"><i class="bi bi-building-fill"></i></span>
                <input type="text" id="schoolName" name="schoolName" placeholder="School Name" required class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition" />
            </div>`;

        async function updateSchoolField() {
            const districtId = districtSelect.value;
            const standard = standardSelect.value;
            const specialDistricts = ['2', '7', '8'];

            if (specialDistricts.includes(districtId) && standard) {
                schoolContainer.innerHTML = `
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500"><i class="bi bi-hourglass-split"></i></span>
                        <input type="text" placeholder="Loading schools..." disabled class="w-full pl-12 pr-4 py-3 bg-gray-100 border border-gray-300 rounded-lg" />
                    </div>`;

                try {
                    const response = await fetch(`get_schools.php?district_id=${districtId}&standard=${standard}`);
                    const responseClone = response.clone();
                    const responseText = await responseClone.text();
                    const schools = await response.json();

                    if (schools.error) {
                        console.error('Server-side error:', schools.error);
                        schoolContainer.innerHTML = schoolInputHTML;
                    } else if (schools.length > 0) {
                        let selectHTML = `
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500"><i class="bi bi-building-fill"></i></span>
                                <select id="schoolName" name="schoolName" required class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition appearance-none">
                                    <option value="">Select School</option>
                                    <option value="other">Other School</option>`;

                        schools.forEach(school => {
                            const cleanSchoolName = school.replace(/"/g, "&quot;");
                            selectHTML += `<option value="${cleanSchoolName}">${school}</option>`;
                        });

                        selectHTML += `
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500"><i class="bi bi-chevron-down"></i></span>
                            </div>`;
                        schoolContainer.innerHTML = selectHTML;
                    } else {
                        schoolContainer.innerHTML = schoolInputHTML;
                    }
                } catch (error) {
                    console.error('Failed to parse JSON. This likely means there was a PHP error.');
                    console.error('Server Response:', responseText);
                    schoolContainer.innerHTML = schoolInputHTML;
                }
            } else {
                schoolContainer.innerHTML = schoolInputHTML;
            }
        }

        districtSelect.addEventListener('change', updateSchoolField);
        standardSelect.addEventListener('change', updateSchoolField);

        schoolContainer.addEventListener("change", function (e) {
            if (e.target && e.target.id === "schoolName") {
                if (e.target.value === "other") {
                    console.log("Other school selected");

                    schoolContainer.innerHTML = schoolInputHTML;
                }
            }
        });

    </script>
</body>

</html>