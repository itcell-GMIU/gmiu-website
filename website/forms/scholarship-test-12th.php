<?php
include '../../common/importwebsitefile.php'; // DB connection ($con)

$swal = ""; // For SweetAlert status

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // Collect & sanitize form data
    $full_name = strtoupper(mysqli_real_escape_string($con, $_POST['student_name']));
    $mobile = mysqli_real_escape_string($con, $_POST['student_mobile']);
    $email = mysqli_real_escape_string($con, $_POST['student_email']);
    $mobile2 = mysqli_real_escape_string($con, $_POST['parent_mobile']);
    $school_name = mysqli_real_escape_string($con, $_POST['school_name']); // NEW
    $district = mysqli_real_escape_string($con, $_POST['district']);       // NEW

    // Insert query - NOTE: 'district' stores the ID from the dropdown, 'school_name' stores the name.
    $sql = "INSERT INTO tbl_promotional_form_data 
                (form_type, full_name, email, mobile, mobile2, school_name, district) 
            VALUES 
                (7, '$full_name', '$email', '$mobile', '$mobile2', '$school_name', '$district')";

    if (mysqli_query($con, $sql)) {
        $swal = "success";
    } else {
        $swal = "error";
        // Optionally log error: error_log(mysqli_error($con));
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>12th Scholarship Test — Gyanmanjari Innovative University</title>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent: #6ea0ff;
            --accent-2: #e783b7;
            --muted: #6b6b80;
            --card-radius: 14px;
            --page-padding: 20px;
        }

        /* Reset */
        *,
        *::before,
        *::after {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%;
            margin: 0
        }

        /* Page background wrapper (body already has class="page-bg") */
        .page-bg {
            min-height: 100vh;
            width: 100%;
            display: grid;
            place-items: center;
            /* center form vertically + horizontally */
            position: relative;
            padding: var(--page-padding);
            background-color: #f5f7fb;
            background-image: url('bg.png');
            /* change path if needed */
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            overflow: auto;
        }

        /* translucent overlay on background to keep contrast */
        .page-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.56);
            z-index: 1;
            backdrop-filter: blur(1px);
        }

        /* form-wrapper sits above overlay */
        .form-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 920px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 36px rgba(17, 24, 39, 0.12);
            display: flex;
            gap: 0;
            overflow: hidden;
            /* Allow internal scroll if viewport too short (prevents clipping when zoomed) */
            max-height: calc(100vh - 48px);
        }

        /* left panel */
        .left-panel {
            flex: 0 0 320px;
            min-width: 220px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            justify-content: center;
            background: linear-gradient(180deg, rgba(110, 160, 255, 0.08) 0%, rgba(231, 131, 183, 0.04) 100%);
            overflow: auto;
        }

        .left-panel>div {
            max-width: 100% !important;
            width: 100% !important;
        }

        /* right panel */
        .right-panel {
            flex: 1 1 480px;
            padding: 24px;
            overflow: auto;
        }

        /* visuals */
        .brand-logo {
            width: 110px;
            display: block;
            border-radius: 8px;
            background: #fff;
            padding: 8px;
            box-shadow: 0 6px 18px rgba(17, 24, 39, 0.06);
        }

        .eyebrow {
            color: var(--muted);
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.6px;
        }

        h2.title {
            font-size: 20px;
            margin: 6px 0 0;
            color: #13203a;
            line-height: 1.05;
        }

        p.lead {
            color: var(--muted);
            margin: 8px 0 0;
            font-size: 14px;
        }

        /* form controls */
        .form-label {
            font-weight: 600;
            color: #1f2b45;
            font-size: 14px;
            display: block;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #e6e9f0;
            font-size: 15px;
            padding: 10px 12px;
        }

        .input-group-text {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e6e9f0;
            padding: 8px 10px;
            font-weight: 600;
        }

        /* submit */
        .btn-primary-gradient {
            width: 100%;
            height: 50px;
            border-radius: 10px;
            font-weight: 700;
            background: linear-gradient(90deg, #2956ab, #b33e7b);
            color: #fff;
            box-shadow: 0 8px 24px rgba(110, 160, 255, 0.18);
            border: none;
        }

        /* small screens */
        @media (max-width: 767.98px) {
            .page-bg {
                place-items: start;
                padding: 16px;
                background-image: none;
            }

            .page-bg::before {
                display: none;
            }

            .form-wrapper {
                flex-direction: column;
                max-width: 420px;
                width: 100%;
                border-radius: 12px;
                max-height: none;
            }

            .left-panel {
                padding: 14px;
                text-align: center;
                align-items: center;
                min-height: auto;
            }

            .right-panel {
                padding: 16px;
            }

            .brand-logo {
                width: 92px;
            }

            h2.title {
                font-size: 18px;
            }

            .form-control,
            .form-select {
                height: 44px;
            }

            .input-group-text {
                display: none;
            }

            /* hide +91 on narrow */
        }

        /* defensive overrides for inline styles */
        .left-panel>div[style] {
            max-width: 100% !important;
            width: 100% !important;
        }

        /* accessibility focus */
        .form-control:focus,
        .form-select:focus {
            outline: 3px solid rgba(110, 160, 255, 0.18);
            box-shadow: none;
        }
    </style>

</head>

<body class="page-bg" data-bg="bg.png">

    <?php if ($swal == "success") { ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Submitted',
                text: 'Your registration has been received. We will contact you shortly.',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    <?php } elseif ($swal == "error") { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Submission failed',
                text: 'Something went wrong. Please try again later or contact support.',
            });
        </script>
    <?php } ?>
    <!--<div class="page-bg" data-bg="bg.png">-->
    <div class="bg-overlay"></div>
    <div class="form-wrapper">
        <div class="left-panel">
            <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GMIU" class="brand-logo" />
            <div style="margin-top:6px; max-width:280px;">
                <div class="eyebrow">Gyanmanjari Innovative University</div>
                <h2 class="title">12th Scholarship Test — Science, Arts & Commerce</h2>
                <p class="lead">Register now for a scholarship test and get course & scholarship guidance from our
                    admissions team. Fill out the form and our team will reach you.</p>
                <p class="small-muted" style="margin-top:10px">Fields with <span style="color:#d97706">*</span> are
                    required.</p>
            </div>
        </div>

        <div class="right-panel">
            <form method="POST" novalidate>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="student_name" class="form-label">Student Name <span
                                class="text-danger">*</span></label>
                        <input id="student_name" name="student_name" type="text" class="form-control"
                            placeholder="Full name" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="student_mobile" class="form-label">Student Mobile <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">+91</span>
                            <input id="student_mobile" name="student_mobile" type="tel" pattern="[0-9]{10}"
                                maxlength="10" class="form-control" placeholder="8429446729" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="parent_mobile" class="form-label">Parent's Mobile <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">+91</span>
                            <input id="parent_mobile" name="parent_mobile" type="tel" pattern="[0-9]{10}" maxlength="10"
                                class="form-control" placeholder="Parent's mobile" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="student_email" class="form-label">Student Email</label>
                        <input id="student_email" name="student_email" type="email" class="form-control"
                            placeholder="name@example.com">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                        <select id="district" name="district" class="form-select" required>
                            <option value="" selected disabled>Select District</option>
                            <?php
                            $result = $con->query("SELECT id, district_name FROM tbl_districts ORDER BY district_name ASC");
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['district_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="school_name" class="form-label">School Name <span
                                class="text-danger">*</span></label>
                        <input id="school_name" name="school_name" type="text" class="form-control" placeholder="School"
                            required>
                    </div>

                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary-gradient">Submit
                                Application</button>
                        </div>
                    </div>

                    <div class="col-12">
                        <p class="small-muted mb-0">By submitting you agree to be contacted by the university for
                            admission and scholarship information. We respect your privacy.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--</div>-->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function () {
            document.addEventListener('focusin', function (e) {
                var el = e.target;
                if (!el || ['INPUT', 'SELECT', 'TEXTAREA'].indexOf(el.tagName) === -1) return;
                // scroll focused element into center to avoid virtual keyboard/zoom clipping
                setTimeout(function () {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 120);
            }, false);
        })();
    </script>

</body>

</html>