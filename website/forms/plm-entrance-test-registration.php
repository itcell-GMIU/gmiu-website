<?php
// Including your database connection and website files
include '../../common/importwebsitefile.php';

/**
 * BACKEND LOGIC: AJAX FORM HANDLER
 * This part only runs when the form is submitted via AJAX
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'submit_registration') {
    header('Content-Type: application/json');

    // Data Preparation
    $form_type = 11;

    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $standard = mysqli_real_escape_string($con, $_POST['standard']);

    $graduation = isset($_POST['graduation'])
        ? mysqli_real_escape_string($con, $_POST['graduation'])
        : '';

    $exam_date = mysqli_real_escape_string($con, $_POST['exam_date']);
    $time_slot = mysqli_real_escape_string($con, $_POST['time_slot']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $district = mysqli_real_escape_string($con, $_POST['district']);
    $exam_mode = mysqli_real_escape_string($con, $_POST['exam_mode']);

    // Server-side validation
    if (empty($full_name) || empty($email) || empty($mobile) || empty($standard)) {
        echo json_encode(['status' => 'error', 'message' => 'Please complete all required fields.']);
        exit;
    }

    if (empty($exam_mode)) {
        echo json_encode(['status' => 'error', 'message' => 'Please select exam mode.']);
        exit;
    }

    // Database Insertion
    $query = "INSERT INTO tbl_promotional_form_data 
    (
        form_type, full_name, email, mobile, standard, graduation_details,
        start_date, time_slot, school_name, district, other_type
    )
    VALUES
    (
        '$form_type', '$full_name', '$email', '$mobile', '$standard', '$graduation',
        '$exam_date', '$time_slot', '$school', '$district', '$exam_mode'
    )";

    if (mysqli_query($con, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Thank you! Your registration has been recorded.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . mysqli_error($con)]);
    }
    exit; // Stop further HTML execution for AJAX calls
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLM Entrance Registration | GMIU</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            background-image: radial-gradient(#cbd5e1 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }

        .prof-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .input-prof {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-prof:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-prof {
            background-color: #0f172a;
            transition: all 0.2s ease;
        }

        .btn-prof:hover {
            background-color: #1e293b;
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-xl prof-card rounded-lg overflow-hidden">

        <div class="bg-slate-900 px-8 py-10 text-white relative">
            <div class="absolute top-4 right-6 opacity-10">
                <i class="fa-solid fa-building-columns text-6xl"></i>
            </div>
            <div class="relative z-10">
                <span class="text-blue-400 text-xs font-bold uppercase tracking-[0.3em] mb-2 block">For Profficient
                    Learning Method</span>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight">GMCET 2026</h1>
                <p class="text-slate-400 text-sm mt-2 font-medium">Gyanmanjari Common Entrance Test</p>
            </div>
        </div>

        <div class="p-8 md:p-10">
            <form id="registrationForm" class="space-y-6">
                <input type="hidden" name="action" value="submit_registration">

                <div class="flex items-center gap-3 pb-2 border-b border-slate-100 mb-6">
                    <span
                        class="flex items-center justify-center w-6 h-6 rounded bg-blue-50 text-blue-600 text-[10px] font-bold">01</span>
                    <h2 class="text-xs font-bold uppercase tracking-widest text-slate-500">Personal Information</h2>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Candidate Full Name</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user-tie text-xs"></i>
                        </div>
                        <input type="text" name="full_name" required placeholder="As per secondary school certificate"
                            class="input-prof w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium text-slate-900 placeholder:text-slate-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Mobile Number</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-phone-flip text-xs"></i>
                            </div>
                            <input type="tel" name="mobile" required maxlength="10" placeholder="10 Digit Number"
                                class="input-prof w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium text-slate-900 placeholder:text-slate-300">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">E-mail Address</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-envelope text-xs"></i>
                            </div>
                            <input type="email" name="email" required placeholder="john.doe@example.com"
                                class="input-prof w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium text-slate-900 placeholder:text-slate-300">
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Current Academic
                        Standard</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-graduation-cap text-xs"></i>
                        </div>
                        <select name="standard" required
                            class="input-prof w-full pl-10 pr-10 py-3 bg-white border border-slate-200 rounded-md outline-none appearance-none text-sm font-medium text-slate-900">
                            <option value="">Select your standard</option>
                            <option value="10th Standard">10th Standard</option>
                            <option value="12th – General Stream">12th – General Stream</option>
                            <option value="12th – Science (A Group)">12th – Science (A Group)</option>
                            <option value="12th – Science (B Group)">12th – Science (B Group)</option>
                            <option value="Graduation">Graduation</option>
                        </select>
                        <div
                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5 hidden" id="graduationWrapper">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">
                            Graduation Details
                        </label>
                        <input type="text" name="graduation" placeholder="e.g. B.Sc, B.Com, B.A"
                            class="input-prof w-full px-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium">
                    </div>
                </div>

                <div class="flex items-center gap-3 pb-2 border-b border-slate-100 mt-10 mb-6">
                    <span
                        class="flex items-center justify-center w-6 h-6 rounded bg-blue-50 text-blue-600 text-[10px] font-bold">02</span>
                    <h2 class="text-xs font-bold uppercase tracking-widest text-slate-500">
                        Exam & School Details
                    </h2>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">
                        Mode of Exam
                    </label>
                    <select name="exam_mode" required
                        class="input-prof w-full px-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium text-slate-900">
                        <option value="">Select Mode</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Preferred Exam
                            Date</label>
                        <select name="exam_date" required id="exam_date"
                            class="input-prof w-full px-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium text-slate-900">
                            <option value="">Select Exam Date</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">
                            Preferred Exam Time
                        </label>
                        <input type="time" name="time_slot" required
                            class="input-prof w-full px-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">School / College
                            Name</label>
                        <input type="text" name="school" required placeholder="School / College Name"
                            class="input-prof w-full px-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">District</label>
                        <input type="text" name="district" required placeholder="District Name"
                            class="input-prof w-full px-4 py-3 bg-white border border-slate-200 rounded-md outline-none text-sm font-medium">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" id="submitBtn"
                        class="btn-prof w-full text-white py-4 rounded-md font-bold text-xs uppercase tracking-[0.2em] shadow-lg flex items-center justify-center gap-3">
                        Submit Registration
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </button>

                    <div
                        class="mt-6 flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <!-- <span class="flex items-center gap-1.5"><i class="fa-solid fa-lock text-emerald-500"></i>
                            Encrypted</span> -->
                        <span>GMCET 2026</span>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#registrationForm').on('submit', function (e) {
                e.preventDefault();

                const submitBtn = $('#submitBtn');
                const originalBtnText = submitBtn.html();

                // UI Feedback
                submitBtn.prop('disabled', true).html('<i class="fa-solid fa-circle-notch fa-spin"></i> Processing...');

                $.ajax({
                    type: 'POST',
                    url: window.location.href, // Submit back to this same file
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Registration Successful',
                                text: response.message,
                                confirmButtonColor: '#0f172a',
                            });
                            $('#registrationForm')[0].reset(); // Clear the form
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Registration Failed',
                                text: response.message,
                                confirmButtonColor: '#0f172a',
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'System Error',
                            text: 'Something went wrong on the server. Please try again later.',
                            confirmButtonColor: '#0f172a',
                        });
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });
        });

        $('select[name="standard"]').on('change', function () {
            if ($(this).val() === 'Graduation') {
                $('#graduationWrapper').removeClass('hidden');
            } else {
                $('#graduationWrapper').addClass('hidden');
                $('#graduationWrapper input').val('');
            }
        });


        const examDates = {
            "10th Standard": ["2026-04-19", "2026-04-26", "2026-05-03"],
            "12th – Science (A Group)": ["2026-04-19", "2026-04-26", "2026-05-03"],
            "12th – Science (B Group)": ["2026-04-19", "2026-04-26", "2026-05-03"],
            "12th – General Stream": ["2026-04-19", "2026-04-26", "2026-05-03"],
            "Graduation": ["2026-04-19", "2026-04-26", "2026-05-03"]
        };

        $('select[name="standard"]').on('change', function () {
            const selectedStandard = $(this).val();
            const dateSelect = $('#exam_date');

            dateSelect.html('<option value="">Select Exam Date</option>');

            if (examDates[selectedStandard]) {
                examDates[selectedStandard].forEach(function (date) {
                    dateSelect.append(`<option value="${date}">${date}</option>`);
                });
            }

            // Graduation field toggle
            if (selectedStandard === 'Graduation') {
                $('#graduationWrapper').removeClass('hidden');
            } else {
                $('#graduationWrapper').addClass('hidden');
                $('#graduationWrapper input').val('');
            }
        });
    </script>

</body>

</html>