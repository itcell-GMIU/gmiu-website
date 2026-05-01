<?php
include '../../common/importwebsitefile.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    header('Content-Type: application/json');

    $response = ["status" => "error"];

    $form_type = 14;

    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $standard = trim($_POST['standard'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');

    $dates = $_POST['dates'] ?? [];
    $workshops = $_POST['workshops'] ?? [];
    $career = $_POST['career'] ?? [];

    $dates = implode(',', $dates);
    $workshops = implode(',', $workshops);
    $career = implode(',', $career);

    if ($full_name && $email && $standard && $mobile) {

        $stmt = $con->prepare("
            INSERT INTO tbl_promotional_form_data
            (form_type, full_name, email, standard, mobile, extra_column1, extra_column2, extra_column3)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "isssssss",
            $form_type,
            $full_name,
            $email,
            $standard,
            $mobile,
            $dates,
            $workshops,
            $career
        );

        if ($stmt->execute()) {
            $response["status"] = "success";
        }
    }

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vacation Workshop</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico">
    <style>
        .header-cta {
            text-align: center;
            margin-top: 8px;
        }

        .workshop-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, #631212, #b91c1c);
            color: white;
            padding: 10px 18px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            font-size: 14px;
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
            animation: workshopPulseRed 1.35s infinite;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .workshop-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 30px rgba(220, 38, 38, 0.6);
        }

        .workshop-btn__logo {
            width: 24px;
            height: 24px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex: 0 0 auto;
        }

        .workshop-btn__logo img {
            width: 16px;
            height: 16px;
            object-fit: contain;
            display: block;
        }

        .workshop-btn--sticky {
            position: relative;
        }

        /* Red Pulse Animation */
        @keyframes workshopPulseRed {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.6);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(220, 38, 38, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e264a',
                        accent: '#bc2823',
                        accentLight: '#fee2e2'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 sm:p-8">

    <div class="w-full max-w-xl bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200">

        <div class="bg-white p-6 border-b-4 border-primary">

            <!-- Row 1: Logos -->
            <div class="flex flex-row items-center justify-center gap-6 sm:gap-12">
                <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" class="h-12 sm:h-16">
                <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" class="h-12 sm:h-16">
            </div>

            <!-- Row 2: Button -->
            <div class="flex justify-center mt-4">
                <div class="header-cta">
                    <a href="https://gmiu.edu.in/gmiu/website/forms/plm-entrance-test-registration.php" target="_blank"
                        class="workshop-btn workshop-btn--sticky">
                        <span>GMCET 2026</span>
                    </a>
                </div>
            </div>

        </div>

        <div class="p-8">

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-primary">Free One Day Vacation Workshop Registration Form</h2>
                <p class="text-slate-500 text-sm mt-1">Please fill in your details accurately.</p>
            </div>

            <form id="admissionForm" class="space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-primary mb-1">Full Name</label>
                    <input type="text" name="full_name" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-accent">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-primary mb-1">Email ID</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-accent">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-primary mb-1">Given Exam</label>

                    <select name="standard" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-accent bg-white">

                        <option value="" disabled selected>Select your exam</option>
                        <option value="10th">10th</option>
                        <option value="10th (Gyanmanjari Girl's College)">10th (Gyanmanjari Girl's College)</option>
                        <option value="12th General">12th (General Stream)</option>
                        <option value="12th General (Gyanmanjari Girl's College)">12th (General Stream) (Gyanmanjari
                            Girl's College)</option>
                        <option value="12th Science A">12th (Science A-Group)</option>
                        <option value="12th Science B">12th (Science B-Group)</option>

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">Select Workshop Date</label>

                    <div id="dateList" class="grid grid-cols-2 gap-2 text-sm"></div>
                    <!--<div class="grid grid-cols-2 gap-2 text-sm">-->

                    <!--    <label><input type="checkbox" name="dates[]" value="21-03-2026"> 21-03-2026</label>-->
                    <!--    <label><input type="checkbox" name="dates[]" value="28-03-2026"> 28-03-2026</label>-->
                    <!--    <label><input type="checkbox" name="dates[]" value="04-04-2026"> 04-04-2026</label>-->
                    <!--    <label><input type="checkbox" name="dates[]" value="11-04-2026"> 11-04-2026</label>-->
                    <!--    <label><input type="checkbox" name="dates[]" value="18-04-2026"> 18-04-2026</label>-->

                    <!--</div>-->
                </div>

                <div id="workshopSection" class="hidden">

                    <label class="block text-sm font-semibold text-primary mb-2">
                        Select Workshops
                    </label>

                    <div id="workshopList" class="grid gap-2 text-sm"></div>

                </div>

                <div>
                    <label class="block text-sm font-semibold text-primary mb-2">
                        Mobile Number
                    </label>

                    <div class="relative">

                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-sm">+91</span>

                        <input type="tel" name="mobile" pattern="[0-9]{10}" required
                            class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-accent">

                    </div>
                </div>

                <div>

                    <label class="block text-sm font-semibold text-primary mb-2">
                        In which Field you will make your career?
                    </label>

                    <div class="grid grid-cols-2 gap-2 text-sm">

                        <label>
                            <input type="checkbox" name="career[]" value="Engineering">
                            Engineering - એન્જિનિયરિંગ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Medical">
                            Medical - મેડિકલ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Paramedical">
                            Paramedical - પેરા મેડીકલ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Computer Applications">
                            Computer Applications - કમ્પ્યુટર એપ્લિકેશન
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Management">
                            Management - મેનેજમેન્ટ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Design">
                            Design - ડિઝાઇન
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Social Work">
                            Social Work - સામાજિક કાર્ય
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Health Care">
                            Health Care - હેલ્થ કેર
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Science">
                            Science - સાયન્સ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Hotel Management">
                            Hotel Management - હોટલ મેનેજમેન્ટ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Vocational Course">
                            Vocational Course - વોકેશનલ કોર્સ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Arts">
                            Arts - આર્ટ્સ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Commerce">
                            Commerce - વાણિજ્ય
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Diploma Engineering">
                            Diploma Engineering - ડિપ્લોમા એન્જિનિયરિંગ
                        </label>

                        <label>
                            <input type="checkbox" name="career[]" value="Higher Secondary">
                            Higher Secondary - 11th & 12th
                        </label>

                    </div>

                </div>

                <button type="submit"
                    class="w-full bg-primary hover:bg-slate-800 text-white font-bold py-4 rounded-xl shadow-lg mt-4">
                    Submit Application
                </button>

            </form>

        </div>

        <div class="bg-slate-50 p-4 text-center border-t border-slate-100">
            <p class="text-xs text-slate-400">
                © 2026 Gyanmanjari Admission Portal • Secure Registration
            </p>
        </div>

    </div>

    <script>
        const examDates = {

            "10th": [
                "18-04-2026",
                "25-04-2026",
                "02-05-2026"
            ],

            "10th (Gyanmanjari Girl's College)": [
                "18-04-2026",
                "25-04-2026",
                "02-05-2026"
            ],

            "12th Science A": [
                "18-04-2026",
                "25-04-2026",
                "02-05-2026"
            ],

            "12th Science B": [
                "18-04-2026",
                "25-04-2026",
                "02-05-2026"
            ],

            "12th General": [
                "18-04-2026",
                "25-04-2026",
                "02-05-2026"
            ],

            "12th General (Gyanmanjari Girl's College)": [
                "18-04-2026",
                "25-04-2026",
                "02-05-2026"
            ]

        };
        const workshops = {

            "10th": [
                "Spoken English (સ્પોકન અંગ્રેજી)",
                "Electro Spark (ઇલેક્ટ્રો સ્પાર્ક)",
                "Autocad Design Pro (ઓટોકેડ ડિઝાઇન પ્રો)",
                "Web Design And Development (વેબ ડિઝાઇન એન્ડ ડેવલપમેન્ટ)",
                "AI Commander (એઆઈ કમાંડર)",
                "CAD Solutions (કેડ સોલ્યુશન્સ)",
                "Robotics Workshop (રોબોટિક્સ વર્કશોપ)",
                "Cyber Warrior (સાયબર વોરિયર)",
                "Wastewater Management (વેસ્ટ વોટર મેનેજમેન્ટ)",
                "3D PrintX (થ્રીડી પ્રિન્ટએક્સ)",
                "Spark X (સ્પાર્ક એક્સ)",
                "Fashion Design & Textile Design(ફેશન ડિઝાઇન & ટેક્સટાઇલ ડિઝાઇન )"
            ],

            "12th Science A": [
                "Spoken English (સ્પોકન અંગ્રેજી)",
                "Electro Spark (ઇલેક્ટ્રો સ્પાર્ક)",
                "Autocad Design Pro (ઓટોકેડ ડિઝાઇન પ્રો)",
                "Web Design And Development (વેબ ડિઝાઇન એન્ડ ડેવલપમેન્ટ)",
                "AI Commander (એઆઈ કમાંડર)",
                "CAD Solutions (કેડ સોલ્યુશન્સ)",
                "Robotics Workshop (રોબોટિક્સ વર્કશોપ)",
                "Cyber Warrior (સાયબર વોરિયર)",
                "Wastewater Management (વેસ્ટ વોટર મેનેજમેન્ટ)",
                "3D PrintX (થ્રીડી પ્રિન્ટએક્સ)",
                "Spark X (સ્પાર્ક એક્સ)",
                "Fashion Design & Textile Design(ફેશન ડિઝાઇન & ટેક્સટાઇલ ડિઝાઇન )"
            ],

            "12th General": [
                "Spoken English (સ્પોકન અંગ્રેજી)",
                "Low Barrier Hackathon (લો બેરિયર હેકાથોન)",
                "Art-Tech (આર્ટ-ટેક)",
                "Tally with GST (ટેલી વિથ જી.એસ.ટી.)",
                "Startup Showdown (સ્ટાર્ટઅપ શોડાઉન)",
                "Home Science Tie-Dye Workshop (હોમ સાયન્સ ટાઈ-ડાય વર્કશોપ)",
                "Home Decor Workshop (હોમ ડેકોર વર્કશોપ)",
                "Block Printing (બ્લોક પ્રિન્ટિંગ)",
                "Fashion Design & Textile Design(ફેશન ડિઝાઇન & ટેક્સટાઇલ ડિઝાઇન )"
            ],

            "12th Science B": [
                "Spoken English (સ્પોકન અંગ્રેજી)",
                "DNA Demonstration (ડીએનએ ડેમોન્સ્ટ્રેશન)",
                "Preparation of Balm (બામ બનાવવાનો પ્રક્રિયા)",
                "Science Treasure Hunt (સાયન્સ ટ્રેઝર હન્ટ)",
                "Advance Technique Chromatography (એડવાન્સ ટેકનિક ક્રોમેટોગ્રાફી)",
                "Capsule Filling Challenge (કેપ્સ્યુલ ફિલિંગ ચેલેન્જ)",
                "Fashion Design & Textile Design(ફેશન ડિઝાઇન & ટેક્સટાઇલ ડિઝાઇન )"
            ],

            "10th (Gyanmanjari Girl's College)": [
                "Bandhani Dots",
                "Circular Patterns",
                "Natural Dye",
                "Different Folding Methods",
                "Tie - Dye"
            ],

            "12th General (Gyanmanjari Girl's College)": [
                "Bandhani Dots",
                "Circular Patterns",
                "Natural Dye",
                "Different Folding Methods",
                "Tie - Dye"
            ]

        };

        const examSelect = document.querySelector('[name="standard"]');
        const workshopSection = document.getElementById("workshopSection");
        const workshopList = document.getElementById("workshopList");
        const dateList = document.getElementById("dateList");

        // ✅ ON CHANGE
        examSelect.addEventListener("change", function () {

            const selected = this.value;

            workshopList.innerHTML = "";
            dateList.innerHTML = "";

            // DATES
            if (examDates[selected]) {
                examDates[selected].forEach(date => {
                    dateList.innerHTML += `
                        <label>
                            <input type="checkbox" name="dates[]" value="${date}">
                            ${date}
                        </label>
                    `;
                });
            }

            // WORKSHOPS
            if (workshops[selected]) {
                workshopSection.classList.remove("hidden");

                workshops[selected].forEach(item => {
                    workshopList.innerHTML += `
                        <label>
                            <input type="checkbox" name="workshops[]" value="${item}">
                            ${item}
                        </label>
                    `;
                });
            }

        });

        // ✅ SUBMIT
        const form = document.getElementById('admissionForm');

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            const formData = new FormData(form);

            fetch("free-one-day-vacation-workshop-form.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(data => {

                    if (data.status === "success") {

                        Swal.fire({
                            title: 'Success',
                            text: 'Registration Submitted',
                            icon: 'success'
                        });

                        form.reset();
                        workshopList.innerHTML = "";
                        dateList.innerHTML = "";

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Try Again'
                        });

                    }

                });

        });

    </script>

</body>

</html>