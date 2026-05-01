<?php
session_start();
require_once '../database/connect.php'; // must define $con (mysqli)
/* ✅ LOAD OLD FORM DATA AFTER REDIRECT */
$old = $_SESSION['old'] ?? [];
/* --------------------------------
   HANDLE FORM SUBMISSION
---------------------------------*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];
    $old = [];

    // Collect fields
    $fields = [
        'first_name',
        'middle_name',
        'last_name',
        'mobile_number',
        'qualification',
        'address',
        'referral_code'
    ];

    foreach ($fields as $field) {
        $old[$field] = trim($_POST[$field] ?? '');
    }

    // Required validation
    if (
        empty($old['first_name']) ||
        empty($old['middle_name']) ||
        empty($old['last_name']) ||
        empty($old['mobile_number']) ||
        empty($old['qualification']) ||
        empty($old['address'])
    ) {
        $errors[] = 'All required fields must be filled.';
    }

    // Mobile validation
    if (!preg_match('/^[6-9][0-9]{9}$/', $old['mobile_number'])) {
        $errors[] = 'Invalid mobile number.';
    }

    // Referral code validation (if present)
    if (!empty($old['referral_code'])) {
        $stmt = $con->prepare("
            SELECT id FROM tbl_referral_master
            WHERE referral_code = ?
              AND is_active = 1
              AND is_delete = 0
            LIMIT 1
        ");
        $stmt->bind_param("s", $old['referral_code']);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 0) {
            $errors[] = 'Invalid referral code.';
        }
    }

    // File validation
    if (
        empty($_FILES['aadhaar_card']['name']) ||
        empty($_FILES['mark_sheet']['name'])
    ) {
        $errors[] = 'Aadhaar Card and Mark Sheet are required.';
    }

    // If validation fails
    if (!empty($errors)) {
        $_SESSION['form_status'] = 'error';
        $_SESSION['form_message'] = implode(' ', $errors);
        $_SESSION['old'] = $old;

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // File upload helper
    function uploadFile($file, $folder)
    {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed, true)) {
            return false;
        }

        $name = uniqid('doc_', true) . '.' . $ext;
        $path = $folder . '/' . $name;

        return move_uploaded_file($file['tmp_name'], $path) ? $name : false;
    }

    // Upload files
    $aadhaarFile = uploadFile($_FILES['aadhaar_card'], 'uploads/aadharcard');
    $marksheetFile = uploadFile($_FILES['mark_sheet'], 'uploads/marksheet');

    if (!$aadhaarFile || !$marksheetFile) {
        $_SESSION['form_status'] = 'error';
        $_SESSION['form_message'] = 'File upload failed. Please try again.';
        $_SESSION['old'] = $old;

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Insert into DB
    $stmt = $con->prepare("
        INSERT INTO tbl_gmap_registrations
        (
            first_name,
            middle_name,
            last_name,
            mobile_number,
            qualification,
            address,
            aadhaar_card,
            marksheet,
            referral_code
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssssss",
        $old['first_name'],
        $old['middle_name'],
        $old['last_name'],
        $old['mobile_number'],
        $old['qualification'],
        $old['address'],
        $aadhaarFile,
        $marksheetFile,
        $old['referral_code']
    );

    if ($stmt->execute()) {
        unset($_SESSION['old']);

        $_SESSION['form_status'] = 'success';
        $_SESSION['form_message'] = 'Registration submitted successfully.';

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['form_status'] = 'error';
        $_SESSION['form_message'] = 'Database error. Please try again.';
        $_SESSION['old'] = $old;

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMAP | Admission Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gmiuNavy: '#1e264a',
                        gmiuRed: '#bc2823',
                        gmiuGold: '#f4a21d',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-0 md:p-10">

    <div
        class="max-w-6xl w-full flex flex-col md:flex-row shadow-2xl md:rounded-3xl overflow-hidden bg-white min-h-screen md:min-h-0">

        <div
            class="md:w-1/3 bg-gmiuNavy p-6 md:p-8 text-white flex flex-col justify-center md:justify-between relative overflow-hidden">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-gmiuRed rounded-full opacity-20"></div>

            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="bg-white p-2 rounded-xl mb-6 shadow-lg inline-block">
                    <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo"
                        class="h-16 md:h-20 mx-auto mb-2">
                </div>
                <div class="bg-white p-2 rounded-xl mb-6 shadow-lg inline-block">
                    <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" alt="GMIU Logo"
                        class="h-16 md:h-20 mx-auto mb-2">
                </div>

                <h1 class="text-2xl md:text-3xl font-bold leading-tight">GMAP 2026</h1>
                <p class="text-gmiuGold font-semibold mt-1 tracking-widest uppercase text-xs md:text-sm">Gyanmanjari
                    Admission Portal</p>
                <p class="text-white font-semibold mt-1 tracking-widest uppercase text-xs md:text-sm">रट्टा अभ्यास
                    छोडो, कौशल्यलक्षी शिक्षा से जुडो ।</p>

                <div class="hidden md:block mt-10 space-y-6 text-left">
                    <div class="flex items-start gap-4">
                        <div class="bg-gmiuRed p-2 rounded-lg"><i class="fas fa-graduation-cap"></i></div>
                        <p class="text-sm text-gray-300">Fast-track your career with industry-aligned courses.</p>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-gmiuGold p-2 rounded-lg text-gmiuNavy"><i class="fas fa-file-invoice"></i></div>
                        <p class="text-sm text-gray-300">Keep your Aadhaar and Marksheets ready for upload.</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-6 md:mt-10 hidden md:block">
                <p class="text-xs text-gray-400">© 2026 Gyanmanjari Innovative University <br> Bhavnagar, Gujarat.</p>
            </div>
        </div>

        <div class="md:w-2/3 p-6 md:p-12">
            <header class="mb-8 text-center md:text-left">
                <h2 class="text-2xl font-bold text-gmiuNavy">Student Registration</h2>
                <div class="h-1 w-20 bg-gmiuRed mx-auto md:mx-0 mt-2 rounded-full"></div>
                <p class="text-gray-500 mt-3 text-sm">Please provide your details accurately for the admission process.
                </p>
            </header>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-600 uppercase mb-1">Surname</label>
                        <input type="text" name="last_name" placeholder="Surname"
                            value="<?= htmlspecialchars($old['last_name'] ?? '') ?>"
                            class="border-2 border-gray-200 rounded-xl p-3 focus:border-gmiuNavy outline-none transition-all placeholder:text-gray-300"
                            required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-600 uppercase mb-1">Student Name</label>
                        <input type="text" name="first_name" placeholder="Student Name"
                            value="<?= htmlspecialchars($old['first_name'] ?? '') ?>"
                            class="border-2 border-gray-200 rounded-xl p-3 focus:border-gmiuNavy outline-none transition-all placeholder:text-gray-300"
                            required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-600 uppercase mb-1">Father Name</label>
                        <input type="text" name="middle_name" placeholder="Father Name"
                            value="<?= htmlspecialchars($old['middle_name'] ?? '') ?>"
                            class="border-2 border-gray-200 rounded-xl p-3 focus:border-gmiuNavy outline-none transition-all placeholder:text-gray-300"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-600 uppercase mb-1">Mobile Number</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400 text-sm font-semibold">+91</span>
                            <input type="tel" name="mobile_number" placeholder="00000 00000"
                                value="<?= htmlspecialchars($old['mobile_number'] ?? '') ?>"
                                class="w-full border-2 border-gray-200 rounded-xl p-3 pl-12 focus:border-gmiuNavy outline-none transition-all"
                                required>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-600 uppercase mb-1">Qualification</label>
                        <select name="qualification"
                            class="border-2 border-gray-200 rounded-xl p-3 focus:border-gmiuNavy outline-none transition-all bg-white"
                            required>
                            <option value="">Select Level</option>
                            <?php
                            $levels = ['10th Standard', '12th Science', '12th Commerce', 'Diploma Graduate'];
                            foreach ($levels as $lvl) {
                                $sel = (($old['qualification'] ?? '') === $lvl) ? 'selected' : '';
                                echo "<option $sel>$lvl</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs font-bold text-gray-600 uppercase mb-1">Residential Address</label>
                    <textarea name="address" rows="2" placeholder="Street, City, Pincode..."
                        class="border-2 border-gray-200 rounded-xl p-3 focus:border-gmiuNavy outline-none transition-all"
                        required><?= htmlspecialchars($old['address'] ?? '') ?></textarea>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-600 uppercase mb-1">Aadhaar Card</label>
                        <input type="file" name="aadhaar_card"
                            class="text-xs block w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gmiuNavy file:text-white hover:file:bg-gmiuRed cursor-pointer bg-gray-50 p-2 rounded-lg border border-dashed border-gray-300"
                            required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs font-bold text-gray-600 uppercase mb-1">Mark Sheet</label>
                        <input type="file" name="mark_sheet"
                            class="text-xs block w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gmiuNavy file:text-white hover:file:bg-gmiuRed cursor-pointer bg-gray-50 p-2 rounded-lg border border-dashed border-gray-300"
                            required>
                    </div>
                    <div class="flex flex-col lg:col-span-1">
                        <label class="text-xs font-bold text-gray-600 uppercase mb-2">
                            have a Referral Code? <span class="text-yellow-500">(Optional)</span>
                        </label>

                        <label class="inline-flex items-center cursor-pointer mb-3 group">
                            <input type="checkbox" id="refToggle" class="sr-only peer" <?= !empty($old['referral_code']) ? 'checked' : '' ?>>

                            <div class="relative w-12 h-6 bg-gray-300 rounded-full 
                    peer-checked:bg-gmiuRed transition-colors duration-300 ease-in-out
                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                    after:bg-white after:border-gray-300 after:border after:rounded-full 
                    after:h-5 after:w-5 after:transition-all after:duration-300
                    peer-checked:after:translate-x-6 peer-checked:after:border-white">
                            </div>

                            <span
                                class="ml-3 text-sm text-gray-600 font-medium group-hover:text-gmiuNavy transition-colors">
                                Yes, I have a code
                            </span>
                        </label>

                        <div id="referralWrapper" class="hidden transition-all duration-300 overflow-hidden">
                            <input type="text" name="referral_code" id="referralInput" placeholder="Enter Referral Code"
                                value="<?= htmlspecialchars($old['referral_code'] ?? '') ?>"
                                class="w-full border-2 border-gray-200 rounded-xl p-3 focus:border-gmiuNavy outline-none transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-gmiuNavy hover:bg-gmiuRed text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-red-200 transform hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                            SUBMIT APPLICATION <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>

                    <p class="text-center text-[10px] text-gray-400 md:hidden pt-4 uppercase tracking-widest">
                        Gyanmanjari
                        Innovative University</p>
            </form>
        </div>
    </div>

    <!-- REFERRAL TOGGLE (UNCHANGED LOGIC) -->
    <script>
        const refToggle = document.getElementById('refToggle');
        const referralWrapper = document.getElementById('referralWrapper');

        refToggle.addEventListener('change', function () {
            referralWrapper.classList.toggle('hidden', !this.checked);
        });
    </script>

    <!-- SWEETALERT HANDLER -->
    <?php if (isset($_SESSION['form_status'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['form_status'] ?>',
                title: '<?= $_SESSION['form_status'] === "success" ? "Success" : "Error" ?>',
                text: '<?= addslashes($_SESSION['form_message']) ?>',
                confirmButtonColor: '#1e264a'
            }).then(() => {
                <?php if ($_SESSION['form_status'] === 'success'): ?>
                    window.location.href = window.location.pathname;
                <?php endif; ?>
            });
        </script>
        <?php
        unset($_SESSION['form_status'], $_SESSION['form_message']);
    endif;
    ?>
</body>

</html>