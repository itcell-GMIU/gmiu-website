<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall Ticket | Admit Card | Gyanmanjari Innovative University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">

    <style>
        body {
            background-color: #f4f4f4;
            padding-top: 20px;
        }

        /* MOBILE + DEFAULT VIEW */
        .a4-wrapper {
            overflow-x: auto;
            /* Scroll horizontally on phones */
            padding: 15px;
        }

        /* MOBILE + DEFAULT VIEW */
        /* SAME A4 LOOK ON MOBILE AND PC */
        .a4-page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 10mm;
            border: 1px solid #aaa;
            box-sizing: border-box;
        }


        /* DESKTOP VIEW: FIXED A4 SIZE */
        @media (min-width: 992px) {
            /*.a4-page {*/
            /*    width: 210mm;*/
            /*    min-height: 297mm;*/
            /*    margin: 0 auto;*/
                /* Center */
            /*    padding: 15mm;*/
                /* Realistic A4 inner padding */
            /*    border: 1px solid #000;*/
            /*    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);*/
            /*}*/

           .a4-wrapper {
                overflow-x: auto;
                padding: 10px;
            }
            body {
                background: #e8e8e8;
            }
        }

        /* FORCE TRUE A4 PRINTING */
        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }

            .d-print-none {
                display: none !important;
            }

            /* FIX: REMOVE BOOTSTRAP PADDING */
            .container {
                margin: 0 !important;
                padding: 0 !important;
                max-width: none !important;
                /* prevents width squeezing */
            }

            .a4-wrapper {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }

            .a4-page {
                width: 210mm !important;
                height: 297mm !important;
                padding: 12mm 15mm !important;
                border: 3px solid black !important;
                box-shadow: none !important;
                margin: 0 auto !important;
                page-break-after: always;
            }

            .print-none {
                display: none !important;
            }
        }



        /* Photograph box */
        .photograph-box {
            width: 135px;
            height: 172px;
            flex-shrink: 0;
            font-size: 0.8em;
        }

        /* Table Border Fix */
        .table-bordered {
            border: 1px solid #000 !important;
        }

        .table-bordered td {
            border-color: #000 !important;
        }
    </style>

</head>

<body>

    <?php

    // Get mobile from GET
    $mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';

    // Include student data
    require_once 'student_scholarship_data.php';

    // Check condition
    if (array_key_exists($mobile, $students)) {

        // FOUND
        $name = $students[$mobile];

        // } else {
    
        //     // NOT FOUND
        //     $name = "";
        //     $error = "Mobile number not found.";
        // }
    
        ?>


        <div class="container my-4">

            <div class="d-flex justify-content-evenly align-items-center mb-4 d-print-none">
                <div class="form-check form-switch me-2">
                    <input class="form-check-input" type="checkbox" id="langSwitch" onchange="toggleLanguage()">
                    <label class="form-check-label" for="langSwitch" id="langLabel">English</label>
                </div>
                <div class="form-check form-switch me-2">
                    <button class="btn btn-primary" onclick="location.href='scholarship-hall-ticket.php'">Reset</button>
                </div>
                <button class="btn btn-primary btn-lg" onclick="window.print()">
                    <i class="bi bi-printer-fill me-2"></i>
                    <span id="printText">Print This Hall Ticket</span>
                </button>
            </div>
            <div class="a4-wrapper">
                <div class="a4-page">

                    <header class="text-center mb-4">
                        <h2 class="text-primary fw-bold mb-1">GYANMANJARI INNOVATIVE UNIVERSITY</h2>
                        <p class="mb-4">10<sup>th</sup>/12<sup>th</sup> Standard Scholarship Examination – 2025-26</p>
                        <h3 class="bg-light p-2 border-bottom border-top border-dark">HALL TICKET / ADMIT CARD</h3>
                    </header>

                    <div class="row align-items-start">
                        <div class="col-9">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold" style="width: 30%;">Name of Student</td>
                                            <td><?php echo $name; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">School Name</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Exam Centre</td>
                                            <td>Gyanmanjari Innovative University, Sidsar Road, Bhavnagar</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Exam Date</td>
                                            <td>Sunday, 28th December 2025</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Exam Time</td>
                                            <td>Morning 10:00 AM</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Reporting Time</td>
                                            <td>09:30 AM</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Subjects</td>
                                            <td>Mathematics, Science, GK, IQ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <div
                                class="photograph-box border border-dark d-flex align-items-center justify-content-center text-secondary fw-bold">
                                PHOTOGRAPH
                            </div>
                        </div>
                    </div>

                    <div class="mt-4" id="instructionsBlock">
                        <p class="fw-bold text-decoration-underline" id="instTitle">
                            Important Instructions:
                        </p>
                        <ol class="ms-3" id="instList">
                            <li>Candidate must bring this Hall Ticket to the examination hall.</li>
                            <li>Entry will not be allowed without this Admit Card and valid School ID.</li>
                            <li>Candidates must reach the centre 45 minutes before the exam time.</li>
                            <li>Use of calculators, mobile phones, or any electronic gadgets is strictly prohibited.</li>
                            <li>Answers must be written only in the provided OMR sheet or answer booklet.</li>
                            <li>Any kind of malpractice will lead to disqualification.</li>
                            <li>Preserve this card for future reference or result verification.</li>
                        </ol>
                    </div>

                    <div class="row mt-5 pt-5 text-center">
                        <div class="col-6">
                            <div class="border-bottom border-dark mx-auto" style="width: 80%; height: 1px;"></div>
                            <p class="mt-2 fw-bold">Student signature</p>
                        </div>
                        <div class="col-6">
                            <div class="border-bottom border-dark mx-auto" style="width: 80%; height: 1px;"></div>
                            <p class="mt-2 fw-bold">Parents signature</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <?php } else {

        if (isset($_GET['mobile']) ? $_GET['mobile'] : '') {
            echo '<div class="container d-flex justify-content-center mt-4">
                    <div class="alert alert-danger text-center" role="alert">
                        Mobile number not found. Please try with the correct number.
                    </div>
                </div>';
        }
        ?>

        <div class="container d-flex justify-content-center print-none">
            <div class="shadow-lg bg-white p-5 border border-dark rounded my-5" style="max-width: 450px; width:100%;">
                <h4 class="text-center mb-4 fw-bold">Check Hall Ticket</h4>
                <form method="GET">
                    <div class="mb-3">
                        <label for="mobile" class="form-label fw-semibold">Mobile Number</label>
                        <input type="text" class="form-control form-control-lg" id="mobile" name="mobile" minlength="10"
                            maxlength="10" pattern="\d{10}" required placeholder="Enter 10-digit mobile number"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <div class="form-text text-danger d-none" id="mobileError">
                            Please enter a valid 10-digit mobile number.
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleLanguage() {
            let isGujarati = document.getElementById("langSwitch").checked;

            if (isGujarati) {
                document.getElementById("langLabel").innerText = "ગુજરાતી";
                // Button
                document.getElementById("printText").innerText = "હોલ ટિકિટ પ્રિન્ટ કરો";

                // Title
                document.getElementById("instTitle").innerText = "મહત્વપૂર્ણ સૂચનાઓ:";

                // Gujarati Instructions
                document.getElementById("instList").innerHTML = `
                <li>ઉમેદવારે પરીક્ષા ખંડમાં આ હોલ ટિકિટ લાવવી આવશ્યક છે.</li>
                <li>આ પ્રવેશપત્ર અને માન્ય શાળા ઓળખપત્ર વિના પ્રવેશ આપવામાં આવશે નહીં.</li>
                <li>ઉમેદવારોએ પરીક્ષાના સમય કરતાં 30 મિનિટ પહેલાં કેન્દ્ર પર પહોંચવું આવશ્યક છે.</li>
                <li>કેલ્ક્યુલેટર, મોબાઇલ ફોન અથવા કોઈપણ ઇલેક્ટ્રોનિક ગેજેટ્સનો ઉપયોગ સખત પ્રતિબંધિત છે.</li>
                <li>જવાબો ફક્ત આપેલ OMR શીટ અથવા ઉત્તર પુસ્તિકામાં જ લખવાના રહેશે.</li>
                <li>કોઈપણ પ્રકારની ગેરરીતિ ગેરલાયક ઠેરવવામાં આવશે.</li>
                <li>ભવિષ્યના સંદર્ભ અથવા પરિણામ ચકાસણી માટે આ કાર્ડ સાચવો.</li>
                `;

            } else {
                document.getElementById("langLabel").innerText = "English";
                // Button
                document.getElementById("printText").innerText = "Print This Hall Ticket";

                // Title
                document.getElementById("instTitle").innerText = "Important Instructions:";

                // English Instructions
                document.getElementById("instList").innerHTML = `
                <li>Candidate must bring this Hall Ticket to the examination hall.</li>
                <li>Entry will not be allowed without this Admit Card and valid School ID.</li>
                <li>Candidates must reach the centre 45 minutes before the exam time.</li>
                <li>Use of calculators, mobile phones, or any electronic gadgets is strictly prohibited.</li>
                <li>Answers must be written only in the provided OMR sheet or answer booklet.</li>
                <li>Any kind of malpractice will lead to disqualification.</li>
                <li>Preserve this card for future reference or result verification.</li>
                `;
            }
        }
    </script>

    <script>
        document.getElementById("mobile").addEventListener("input", function () {
            const error = document.getElementById("mobileError");
            if (this.value.length === 10) {
                error.classList.add("d-none");
            } else {
                error.classList.remove("d-none");
            }
        });
    </script>

</body>

</html>