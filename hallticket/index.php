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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        body {
            background-color: #f0f2f5;
            font-family: 'Inter', sans-serif;
            color: #000;
            font-size: 13px;
        }

        .a4-container {
            width: 210mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .a4-page {
            width: 210mm;
            min-height: 297mm;
            padding: 6mm;
            box-sizing: border-box;
            background: white;
            border: 1px solid #ddd;
            position: relative;
        }

        @media print {
            body {
                background: none;
                padding: 0;
                font-size: 13px;
            }

            @page {
                size: A4;
                margin: 0;
            }

            .a4-container {
                margin: 0;
                box-shadow: none;
                width: 100%;
            }

            .a4-page {
                border: none;
                padding: 6mm;
                page-break-after: always;
            }

            .d-print-none {
                display: none !important;
            }

            /* Ensure backgrounds are printed */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .ht-outer-border,
            .ht-student-info,
            .ht-centre-section,
            .ht-instructions,
            .ht-declaration-row {
                page-break-inside: avoid !important;
            }
        }

        /* Hall Ticket Exact Clone Styles */
        .ht-outer-border {
            border: 2px solid #000;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .ht-header {
            display: grid;
            grid-template-columns: 250px 1fr 250px;
            align-items: center;
            text-align: center;
            border-bottom: 2px solid #000;
            padding: 5px 0;
        }

        .ht-logo {
            max-width: 200px;
            max-height: 70px;
            object-fit: contain;
        }

        .ht-title h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            color: #000;
            letter-spacing: 1px;
        }

        .ht-title h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            /* text-decoration: underline; */
        }

        .ht-red-tagline {
            color: #cc0000;
            font-weight: 700;
            font-size: 14px;
            margin-top: 2px;
        }

        .ht-student-info {
            display: grid;
            grid-template-columns: 180px 1fr;
            border-bottom: 2px solid #000;
        }

        .ht-photo-box {
            width: 100%;
            height: 200px;
            border-right: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666;
            background: #fff;
        }

        .ht-info-table {
            display: grid;
            grid-template-columns: 120px 1fr 140px 1fr;
            width: 100%;
        }

        .ht-info-table div {
            border: 0.5px solid #000;
            padding: 12px 8px;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .ht-info-label {
            background: #f2f2f2;
            font-weight: 700;
        }

        .ht-info-value {
            font-weight: 600;
        }

        .ht-centre-section {
            display: grid;
            grid-template-columns: 180px 1fr;
            border-bottom: 2px solid #000;
            min-height: auto;
        }

        .ht-invigilator {
            border-right: 2px solid #000;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 15px;
            text-align: center;
            font-weight: 800;
            font-size: 14px;
        }

        .ht-centre-details {
            display: grid;
            grid-template-columns: 1fr 160px;
            padding: 10px;
            align-items: flex-start;
        }

        .ht-centre-text h5 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        .ht-centre-text p {
            margin-bottom: 8px;
            font-size: 14px;
            line-height: 1.4;
        }

        .ht-qr-box {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            background: #fff;
        }

        .ht-qr-img {
            width: 120px;
            height: 120px;
            margin-top: 5px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .ht-section-header {
            background: #cfe2f3;
            color: #000;
            padding: 8px;
            text-align: center;
            font-weight: 800;
            font-size: 16px;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }

        .ht-instructions {
            padding: 8px 12px 8px 30px;
        }

        .instruction-list {
            margin: 0;
            padding: 0;
            list-style-type: decimal;
            font-size: 13px;
            line-height: 1.4;
        }

        .instruction-list li {
            margin-bottom: 3px;
        }

        .ht-declaration-row {
            display: grid;
            grid-template-columns: 1fr 240px;
            border-top: 2px solid #000;
            min-height: 100px;
            /* margin-top: auto; */
        }

        .ht-declaration-text {
            padding: 10px;
            font-size: 12px;
            font-weight: 700;
            border-right: 2px solid #000;
            display: flex;
            align-items: center;
        }

        .ht-cand-sig {
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            text-align: center;
            font-weight: 800;
            font-size: 14px;
        }

        .ht-footer-tagline {
            text-align: center;
            padding: 10px;
            font-size: 20px;
            font-weight: 800;
            color: #cc0000;
        }

        /* Page 2 Styles */
        .px-4-custom {
            padding: 0 40px;
        }

        .ht-row-qr-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
        }

        .ht-qr-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .ht-footer-qr-center {
            text-align: center;
            flex-grow: 1;
        }

        .blue-text {
            color: #004085;
            font-weight: 700;
        }

        .red-text {
            color: #cc0000;
            font-weight: 700;
        }

        .sub-instruction-header {
            font-weight: 800;
            font-size: 14px;
            margin-top: 15px;
            margin-bottom: 5px;
            text-decoration: underline;
        }

        /* Login Page Styles */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f0f2f5 0%, #e1e4e8 100%);
        }

        .login-header {
            background: #fff;
            padding: 15px 0;
            border-bottom: 2px solid #004085;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .login-logo-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .login-card {
            background: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-top: 4px solid #004085;
        }

        .login-card-header {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .login-card-header h2 {
            font-size: 24px;
            font-weight: 800;
            color: #004085;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .login-alert {
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <?php
    $mobile = trim($_GET['mobile'] ?? '');
    if (!preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
        $mobile = '';
    }

    require_once 'hallticket-data.php';

    $student = null;
    $district = '';

    foreach ($students as $dist => $list) {
        if (isset($list[$mobile])) {
            $student = $list[$mobile];

            // if multiple entries → take first one
            if (isset($student[0])) {
                $student = $student[0];
            }
            $district = $dist;
            break;
        }
    }

    if ($student) {
        $name = $student['name'] ?? '';
        $seat_no = $student['seat_no'] ?? $student['courseId'] ?? '';

        $districtConfig = [
            "amreli" => [
                "qr" => "assets/Amreli QR.png",
                "address" => "Pathak School,<br>Near S.T. Bus Stand,<br>Lathi Road,<br>Amreli, Gujarat 365601",
                "phone" => "90999 51160, 7574949494"
            ],
            "mahuva" => [
                "qr" => "assets/Mahuva QR.png",
                "address" => "Gyanmanjari Education,<br>Near Devaliya Village,<br>Mahuva-Rajula NH, Mahuva 364290",
                "phone" => "90999 51160, 7574949494"
            ],
            "surat" => [
                "qr" => "assets/Surat QR.png",
                "address" => "110, Astha Medicare, Abrama Road,<br>Mota Varachha, Surat",
                "phone" => "90999 51160, 7574949494"
            ],
            "bhavnagar" => [
                "qr" => "assets/Bhavnagar QR.png",
                "address" => "Gyanmanjari Innovative University,<br>Sidsar Road,<br>Bhavnagar, Gujarat 364060",
                "phone" => "90999 51160, 7574949494"
            ]
        ];

        $config = $districtConfig[$district] ?? $districtConfig['bhavnagar'];
    ?>

        <div class="d-print-none text-center my-3">
            <button class="btn btn-primary btn-lg" onclick="window.print()">
                <i class="bi bi-printer-fill me-2"></i> Print Admit Card
            </button>
            <a href="index.php" class="btn btn-secondary btn-lg">Back</a>
        </div>

        <div class="a4-container">
            <!-- PAGE 1 -->
            <div class="a4-page">
                <div class="ht-outer-border">
                    <div class="ht-header">
                        <div><img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" class="ht-logo"
                                alt="GMIU Logo"></div>
                        <div class="ht-title">
                            <h1>MOCK DDCET</h1>
                            <h2>ADMIT CARD</h2>
                            <!-- <div class="ht-red-tagline">रट्टा अभ्यास छोड़ो, कौशल्यલક્ષી શિક્ષા સે જોડો ।</div> -->
                        </div>
                        <div><img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" class="ht-logo"
                                alt="PLM Logo"></div>
                    </div>

                    <div class="ht-student-info">
                        <div class="ht-photo-box">
                            Paste your passport<br>size photograph here
                        </div>
                        <div class="ht-info-table">
                            <div class="ht-info-label">Seat No</div>
                            <div class="ht-info-value"><?php echo $seat_no; ?></div>
                            <div class="ht-info-label">Date</div>
                            <div class="ht-info-value">12/04/2026</div>

                            <div class="ht-info-label">Name</div>
                            <div class="ht-info-value" style="grid-column: span 1;"><?php echo $name; ?></div>
                            <div class="ht-info-label">Day</div>
                            <div class="ht-info-value">Sunday</div>

                            <div class="ht-info-label">Exam</div>
                            <div class="ht-info-value">MOCK DDCET 2026</div>
                            <div class="ht-info-label">Reporting Time</div>
                            <div class="ht-info-value">10:15 AM</div>
                        </div>
                    </div>

                    <div class="ht-centre-section">
                        <div class="ht-invigilator">
                            Invigilator Signature
                        </div>
                        <div class="ht-centre-details">
                            <div class="ht-centre-text">
                                <h5 class="text-center">Examination Centre:</h5>
                                <p>
                                    <strong class="text-primary text-decoration-underline">Address:</strong><br>
                                    <strong><?php echo str_replace('<br>', ' ', explode('<br>', $config['address'])[0]); ?></strong><br>
                                    <?php
                                    $addr_parts = explode('<br>', $config['address']);
                                    array_shift($addr_parts);
                                    echo implode('<br>', $addr_parts);
                                    ?>
                                </p>
                                <p>
                                    <strong class="text-primary text-decoration-underline">Phone:</strong>
                                    <?php echo $config['phone']; ?>
                                </p>
                                <p>
                                    <strong class="text-primary text-decoration-underline">Website:</strong> <a
                                        href="http://www.gmiu.edu.in" target="_blank"
                                        style="color: blue; text-decoration: none;">www.gmiu.edu.in</a>
                                </p>
                            </div>
                            <div class="ht-qr-box">
                                Scan QR Code for Location
                                <img src="<?php echo $config['qr']; ?>" class="ht-qr-img" alt="Location QR">
                            </div>
                        </div>
                    </div>

                    <div class="ht-section-header">Instruction to the Candidate</div>
                    <div class="ht-instructions">
                        <ol class="instruction-list">
                            <li>The candidates shall take entry in the examination hall at 10:45 AM.</li>
                            <li>After commencement of examination, no candidate will be allowed to enter the examination
                                hall under any circumstances.</li>
                            <li>For getting admission in the examination hall, the Admit Card issued by the authority shall
                                have to be shown to the Supervisor of the respective examination hall. Without Admit Card,
                                no entry will be given in the examination hall.</li>
                            <li>Except the respective candidate, no other person will be allowed to enter in the examination
                                hall.</li>
                            <li>Any type of material such as textbook, any reference literature, slide rules, printed or
                                handwritten log table, photocopied writing, chits, cellular phone (mobile), pager or any
                                type of instrument or literature will not be allowed in the examination hall.</li>
                            <li><strong>Only Admit Card, black/blue pen, Original Photo ID Proof and Non-Programmable
                                    Calculator will be allowed in the examination hall.</strong></li>
                            <li>Candidate has to enter the required information on question booklet and OMR sheet legibly as
                                per the instructions. Take care to avoid any issue which may arise in future on account of
                                wrong/incomplete/unclear information.</li>
                            <li>The candidate will not be allowed to leave the examination hall unless and until the
                                examination is over.</li>
                            <li>The candidate will have to bring good quality of black/blue pen for filling the information
                                and answers in the answer-sheet.</li>
                        </ol>
                    </div>

                    <div class="ht-declaration-row">
                        <div class="ht-declaration-text">
                            I hereby acknowledge that I have read, understood and agree to follow the above-mentioned
                            instructions.
                        </div>
                        <div class="ht-cand-sig">
                            Signature of the Candidate
                        </div>
                    </div>
                </div>
                <hr>
                <div class="ht-footer-tagline">
                    रट्टा अभ्यास छोड़ो, कौशल्यलक्षी शिक्षा से जुड़ो ।
                </div>
            </div>

            <!-- PAGE 2 -->
            <div class="a4-page">
                <div class="ht-outer-border">
                    <div class="ht-section-header">ઉમેદવારને સૂચના</div>
                    <div class="ht-instructions">
                        <ol class="instruction-list">
                            <li>ઉમેદવારોએ સવારે ૧૦:૪૫ વાગ્યે પરીક્ષા ખંડમાં પ્રવેશ મેળવવો.</li>
                            <li>પરીક્ષા શરૂ થયા પછી, કોઈપણ ઉમેદવારને કોઈપણ સંજોગોમાં પરીક્ષા ખંડમાં પ્રવેશવાની મંજૂરી
                                આપવામાં આવશે નહીં</li>
                            <li>પરીક્ષા હોલમાં પ્રવેશ મેળવવા માટે, સત્તાધિકારી દ્વારા જારી કરાયેલ એડમિટ કાર્ડ સંબંધિત
                                પરીક્ષા ખંડના સુપરવાઈઝરને બતાવવાનું રહેશે. એડમિટ કાર્ડ વિના પરીક્ષા ખંડમાં પ્રવેશ આપવામાં
                                આવશે નહીં.</li>
                            <li>સંબંધિત ઉમેદવાર સિવાય, અન્ય કોઈ વ્યક્તિને પરીક્ષા ખંડમાં પ્રવેશવાની મંજૂરી આપવામાં આવશે
                                નહીં.</li>
                            <li>કોઈપણ પ્રકારની સામગ્રી જેમ કે પાઠ્યપુસ્તક, કોઈપણ સંદર્ભ સાહિત્ય, મુદ્રિત અથવા હસ્તલિખિત લોગ
                                ટેબલ,</li>
                            <li>પરીક્ષા ખંડમાં ફોટોકોપી કરેલ લેખન, ચિટ્સ, સેલ્યુલર ફોન (મોબાઇલ), પેજર અથવા કોઈપણ પ્રકારના
                                સાધન અથવા સાહિત્યને મંજૂરી આપવામાં આવશે નહીં.</li>
                            <li>પરીક્ષા ખંડમાં માત્ર એડમિટ કાર્ડ, કાળી/ભૂરી પેન, ફોટો આઈડી પ્રૂફ અને નોન-પ્રોગ્રામેબલ
                                કેલ્ક્યુલેટરને મંજૂરી આપવામાં આવશે.</li>
                            <li>ઉમેદવારે સૂચનો મુજબ સુવાચ્યપણે પ્રશ્ન પુસ્તિકા અને OMR શીટ પર જરૂરી માહિતી દાખલ કરવાની
                                રહેશે. ખોટી/અધૂરી/અસ્પષ્ટ માહિતીના કારણે ભવિષ્યમાં ઉભી થતી કોઈપણ સમસ્યાને ટાળવા માટે કાળજી
                                લો.</li>
                            <li>જ્યાં સુધી પરીક્ષા પૂરી ન થાય ત્યાં સુધી ઉમેદવારને પરીક્ષા હોલ છોડવા દેવામાં આવશે નહીં.</li>
                            <li>ઉમેદવારે ઉત્તરવહીમાં માહિતી અને જવાબો ભરવા માટે સારી ગુણવત્તાની કાળી/ભૂરી પેન લાવવાની રહેશે.
                            </li>
                        </ol>

                        <div class="sub-instruction-header">Instructions Related DDCET Paper:</div>
                        <ul class="instruction-list" style="list-style-type: disc;">
                            <li>Every Question carries two marks.</li>
                            <li>Paper (BE-01) and Paper (BE-02) carries 100 marks each.</li>
                            <li>For each wrong answer to the multiple-choice question, 0.5 marks will be deducted (negative
                                marking).</li>
                            <li>0.5 marks will be deducted (negative marking) if two or more options (answers) are opted for
                                one multiple choice question.</li>
                            <li>Unattempt answers will have 0 (Zero) marks. For answers to questions A, B, C, D, and E
                                options are given in OMR Sheet. The "E" option is for "Not Attempted" If the candidate does
                                not wish to answer the questions, he/she should select the "E" option (Not Attempted) to
                                avoid negative marks.</li>
                        </ul>

                        <div class="sub-instruction-header">DDCET પેપર સંબંધિત સૂચનાઓ:</div>
                        <ul class="instruction-list" style="list-style-type: disc;">
                            <li>દરેક પ્રશ્ના બે ગુણ છે.</li>
                            <li>પેપર (BE-01) અને પેપર (BE-02) દરેકના 100 - 100 ગુણ છે.</li>
                            <li>MCQ પ્રશ્ના દરેક ખોટા જવાબ માટે, 0.5 માર્કસ કાપવામાં આવશે (નેગેટિવ માર્કિંગ).</li>
                            <li>જો બે કે તેથી વધુ વિકલ્પો (જવાબો) પસંદ કરવામાં આવશે તો 0.5 ગુણ કાપવામાં આવશે (નેગેટિવ
                                માર્કિંગ).</li>
                            <li>પ્રયાસ વિનાના જવાબોમાં 0 (શૂન્ય) ગુણ હશે. પ્રશ્નોના જવાબો માટે A, B, C, D અને E OMR શીટમાં
                                વિકલ્પો આપવામાં આવ્યા છે. "E" વિકલ્પ "Not Attempted" માટે છે જો ઉમેદવાર પ્રશ્નોના જવાબ આપવા
                                માંગતા ન હોય, તો તેણે નકારાત્મક ગુણ (નેગેટિવ માર્કિંગ) ટાળવા માટે "E" વિકલ્પ ("Not
                                Attempted") પસંદ કરવાનો રહેશે.</li>
                        </ul>
                    </div>

                    <div class="ht-declaration-row">
                        <div class="ht-declaration-text">
                            હું આથી સ્વીકારું છું કે મેં ઉપરોક્ત સૂચનાઓ વાંચી, સમજી અને તેનું પાલન કરવા માટે સંમત છું.
                        </div>
                        <div class="ht-cand-sig">
                            ઉમેદવારની સહી
                        </div>
                    </div>
                </div>

                <div class="ht-row-qr-footer">
                    <div class="ht-qr-item">
                        <img src="assets/PLM.png" style="width: 100px; height: 100px; border: 1px solid #000;" alt="PLM QR">
                        <span class="red-text">&larr; To know more about PLM</span>
                    </div>

                    <div class="ht-qr-item">
                        <span class="blue-text">For Admission &rarr;</span>
                        <img src="assets/admission.png" style="width: 100px; height: 100px; border: 1px solid #000;"
                            alt="Admission QR">
                    </div>
                </div>
                <hr>
                <div class="ht-footer-tagline">
                    रट्टा अभ्यास छोड़ो, कौशल्यलक्षी शिक्षा से जुड़ो ।
                </div>
            </div>
        </div>

    <?php } else { ?>
        <!-- LOGIN PAGE -->
        <div class="login-wrapper print-none">
            <header class="login-header">
                <div class="login-logo-row">
                    <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" height="50" alt="GMIU Logo">
                    <div class="text-center">
                        <h5 class="m-0 fw-bold" style="color: #004085;">Gyanmanjari Innovative University</h5>
                        <p class="m-0 small text-muted">Mock DDCET 2026 Examination Portal</p>
                    </div>
                    <img src="https://gmiu.edu.in/gmiu/website_assets/images/plm.png" height="50" alt="PLM Logo">
                </div>
            </header>

            <div class="container d-flex flex-column align-items-center justify-content-center flex-grow-1 py-5">
                <div class="login-card p-0 mb-4" style="max-width: 450px; width:100%;">
                    <div class="login-card-header">
                        <h2>Hall Ticket</h2>
                        <p class="text-muted m-0">Download your Admit Card for Mock DDCET</p>
                    </div>

                    <div class="p-5">
                        <?php if ($mobile != '' && !isset($student)) { ?>
                            <div class="alert alert-danger login-alert text-center mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Mobile number not found in our records.
                            </div>
                        <?php } ?>

                        <form method="GET" action="">
                            <div class="mb-4">
                                <label for="mobile" class="form-label fw-bold small text-uppercase">Registered Mobile
                                    Number</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="form-control" id="mobile" name="mobile" minlength="10"
                                        maxlength="10" pattern="\d{10}" required placeholder="e.g. 9876543210"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                                <div class="form-text mt-2">Enter the mobile number used during registration.</div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 shadow-sm"
                                    style="background: #004085; border: none;">
                                    DOWNLOAD ADMIT CARD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center text-muted small mt-2">
                    <p>&copy; 2026 Gyanmanjari Innovative University. All Rights Reserved.</p>
                    <div class="ht-red-tagline d-block mb-3" style="font-size: 16px;">
                        रट्टा अभ्यास छोड़ो, कौशल्यलक्षी शिक्षा से जुड़ो ।
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>