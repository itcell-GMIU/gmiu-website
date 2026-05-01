<?php
include '../../common/importwebsitefile.php';

$message = '';
$message_type = '';
$form_type = 12;

function sendMail($to, $subject, $message)
{
    $from = "communication@gmiu.edu.in";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $check = mail($to, $subject, $message, $headers);

    if ($check) {
        return true;
    } else {
        $error = error_get_last();
        $error_message = $error['message'];
        //echo "An error occurred while sending the email: $error_message";
        return $error_message;
    }
}

$mailMessage = '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family: Arial, sans-serif; color: #333333; background-color: #f9f9f9; padding: 20px;">
    <tr>
        <td align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border: 1px solid #dddddd; border-radius: 8px; overflow: hidden;">
                
                <tr>
                    <td style="background-color: #1a5f7a; padding: 30px; text-align: center;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 22px;">🎉 Mock DDCET Registration Successful</h1>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 30px; line-height: 1.6; font-size: 15px;">
                        <p>Dear Student,</p>
                        <p>Greetings from <strong>Gyanmanjari Innovative University, Bhavnagar</strong> 🎓</p>
                        <p>We are pleased to inform you that your Registration for the <strong>Mock DDCET Examination</strong> has been completed successfully ✅✨</p>
                        
                        <div style="margin: 25px 0; padding: 20px; border-left: 4px solid #1a5f7a; background-color: #f0f7f9;">
                            <p style="margin-top: 0; font-weight: bold; color: #1a5f7a;">📢 Please regularly check our website for:</p>
                            <ul style="margin-bottom: 0; padding-left: 20px;">
                                <li>Admit Card Details 🎫</li>
                                <li>Exam Schedule 📅</li>
                                <li>Important Instructions 📌</li>
                            </ul>
                        </div>

                        <p style="font-size: 14px; color: #666666; border-top: 1px solid #eeeeee; padding-top: 15px;">
                            📝 The admit card will be available online, and all updates will be published on the official website.
                        </p>

                        <p>If you have any questions, feel free to contact us at 📞 <strong>7984152493</strong>.</p>
                        
                        <p style="margin-top: 25px;">We wish you all the best 🌟 for your examination and your future academic journey 🚀</p>

                        <p style="text-align: center; margin: 30px 0;">
                            <a href="https://gmiu.edu.in/gmiu/promotional/key-feature-of-plm.php" style="background-color: #1a5f7a; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;">🔗 Know More About PLM</a>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="background-color: #f4f4f4; padding: 25px; text-align: center; font-size: 13px; color: #555555;">
                        <p style="margin: 0; font-weight: bold; color: #333333;">Sincere Thanks 🙏</p>
                        <p style="margin: 5px 0 15px 0;">Mock DDCET – Exam Committee</p>
                        
                        <p style="margin: 0;"><strong>Gyanmanjari Innovative University, Bhavnagar 🎓</strong></p>
                        <p style="margin: 3px 0;">📞 Contact: 7574949494 / 9099951160</p>
                        
                        <p style="margin-top: 20px; font-size: 16px; color: #1a5f7a;"><strong>“रट्टा अभ्यास छोड़ो, कौशल्यलक्षी शिक्षा से जुड़ो।” ✨</strong></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

$mailSubject = "🎉 Mock DDCET Registration Successfully Completed ✅";

$registration_closed = true; // change to false when open
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($registration_closed) {
        $message = "Registration is closed now.";
        $message_type = "warning";
    } else {
        $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
        $school_name = mysqli_real_escape_string($con, $_POST['school_name']); // Student College Name
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
        $other_type = mysqli_real_escape_string($con, $_POST['other_type']); // College Enrolment Number
        $district = mysqli_real_escape_string($con, $_POST['district']); // Exam Center
        $description = mysqli_real_escape_string($con, $_POST['description']); // Exam Center

        if (!empty($full_name) && !empty($school_name) && !empty($email) && !empty($mobile) && !empty($other_type) && !empty($district)) {

            $query = "INSERT INTO tbl_promotional_form_data 
                  (form_type, full_name, school_name, email, mobile, other_type, district, description) 
                  VALUES 
                  ('$form_type', '$full_name', '$school_name', '$email', '$mobile', '$other_type', '$district', '$description')";

            if (mysqli_query($con, $query)) {

                // Confirmation Email
                $subject = "DDCET Registration Confirmation";
                $email_message = "Dear $full_name,\n\nYour Registration is completed.\n\nThank you.\nGMIU Team";
                $headers = "From: noreply@gmiu.edu.in";

                sendMail($email, $mailSubject, $mailMessage);

                $message = "Your Registration is completed.";
                $message_type = "success";
            } else {
                $message = "Something went wrong. Please try again!";
                $message_type = "error";
            }
        } else {
            $message = "All fields are required!";
            $message_type = "warning";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DDCET Registration | GMIU</title>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8fafc;
            background-image: radial-gradient(#2563eb12 1px, transparent 0);
            background-size: 30px 30px;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl p-10 border border-gray-100">

        <div class="flex justify-center mb-4">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU Logo"
                class="h-24 w-auto object-contain">
        </div>

        <!-- Hindi Line Added -->
        <p class="text-center text-gray-700 font-semibold mb-6">
            रट्टा अभ्यास छोडो, कौशल्यलक्षी शिक्षा से जुडो ।
        </p>

        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                DDCET Registration
            </h2>
            <p class="text-gray-500 mt-2">Please fill in your details to secure your spot</p>
            <div class="h-1.5 w-20 bg-blue-600 mx-auto mt-4 rounded-full"></div>
        </div>
        <?php if (!$registration_closed): ?>
            <form action="" method="POST" class="grid grid-cols-1 gap-y-6">

                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="full_name" placeholder="Enter your full name"
                        class="w-full px-5 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:outline-none transition-all placeholder:text-gray-400">
                </div>

                <!-- Student College Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Student College Name</label>
                    <input type="text" name="school_name" placeholder="Enter your college name"
                        class="w-full px-5 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:outline-none transition-all placeholder:text-gray-400">
                </div>

                <!-- Mobile + Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mobile Number</label>
                        <input type="tel" name="mobile" placeholder="9876543210"
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" placeholder="name@example.com"
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:outline-none transition-all">

                        <p class="text-xs text-red-500 mt-2">
                            Note: A confirmation email will be sent to this email address, make sure it is correct.
                        </p>
                    </div>
                </div>

                <!-- College Enrolment + Exam Center -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">College Enrolment Number</label>
                        <input type="text" name="other_type" placeholder="Enter enrolment number"
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Exam Center</label>
                        <select name="district"
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:outline-none transition-all">
                            <option value="">Select Exam Center</option>
                            <option>Bhavnagar</option>
                            <option>Una</option>
                            <option>Mahuva</option>
                            <option>Surendranagar</option>
                            <option>Rajula</option>
                            <option>Junagadh</option>
                            <option>Surat</option>
                            <option>Amreli</option>
                            <option>Botad</option>
                            <option>Vapi</option>
                            <option>Anand</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Language of Examination</label>
                        <select name="description"
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:outline-none transition-all">
                            <option value="">Select Language</option>
                            <option>English</option>
                            <option>Gujarati</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-lg py-4 rounded-xl shadow-lg shadow-blue-200 transform hover:-translate-y-1 active:scale-[0.98] transition-all">
                        Register Now
                    </button>

                    <p class="text-center text-xs text-gray-400 mt-4 italic">
                        By clicking register, you agree to the DDCET terms and conditions.
                    </p>
                </div>

            </form>

        <?php else: ?>

            <div class="text-center py-10">
                <h2 class="text-3xl font-extrabold text-red-600 mb-4">
                    Registration Closed
                </h2>
                <p class="text-gray-600 text-lg">
                    The Mock DDCET registration is now closed.
                </p>
                <p class="text-gray-500 mt-2">
                    Please check the website for further updates.
                </p>
            </div>

        <?php endif; ?>
    </div>

    <?php if (!empty($message)): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: '<?php echo $message_type; ?>',
                    title: '<?php echo $message; ?>',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    window.location.href = window.location.pathname;
                });
            });
        </script>
    <?php endif; ?>

</body>

</html>