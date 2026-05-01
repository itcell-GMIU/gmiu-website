<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Receipt - Infinite Global Career</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
    body {
        background-color: #e9ecef;
        /* font-family: "Times New Roman", serif; */
    }

    .receipt-container {
        background-color: #fff;
        border: 2px solid #000;
        /* padding: 25px 30px; */
        padding: 10px 15px;
        margin: 20px auto;
        max-width: 800px;
    }

    .gst-no {
        font-weight: bold;
        text-align: right;
        font-size: 13px;
    }

    .header-section {
        text-align: center;
        position: relative;
        margin-bottom: 15px;
    }

    .header-section img {
        position: absolute;
        top: 0;
        left: 0;
        width: 160px;
        height: auto;
    }

    .header-section h2 {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
        text-transform: uppercase;
    }

    .header-section h3 {
        font-size: 14px;
        font-weight: bold;
        margin: 2px 0 4px;
    }

    .header-section p {
        font-size: 13px;
        margin: 0;
        line-height: 1.4;
    }

    .info-box {
        border: 1px solid #000;
        padding: 10px 15px;
        font-size: 14px;
        margin-top: 10px;
    }

    .info-box table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-box td {
        /* padding: 4px 5px; */
        padding: 1px 3px;
        vertical-align: top;
    }

    .info-box .title {
        text-align: center;
        font-weight: bold;
        text-decoration: underline;
        font-size: 16px;
        padding-bottom: 5px;
    }

    .underline {
        display: inline-block;
        min-width: 180px;
        border-bottom: 1px solid #000;
    }

    .section-title {
        font-weight: bold;
        margin-top: 12px;
        font-size: 16px;
    }

    p {
        font-size: 14px;
        color: black;
    }

    .amount-table {
        border: 1.5px solid #000;
        margin-top: 10px;
        font-size: 14px;
    }

    .amount-table td {
        border: 1px solid #000;
        padding: 8px;
        vertical-align: middle;
    }

    .amount-table .header {
        text-align: left;
        font-weight: bold;
        font-size: 16px;
        background-color: #f8f9fa;
    }

    .footer-notes {
        font-size: 12px;
        margin-top: 15px;
        line-height: 1.3;
    }

    .tnc {
        font-size: 11px;
        color: black;
    }

    @media print {
        body {
            background: #fff;
        }

        .btn {
            display: none !important;
        }

        .receipt-container {
            margin: 0;
            border: 1px solid #000;
            width: 100%;
            max-width: 100%;
            box-shadow: none;
        }

        @page {
            size: A4;
            margin: 20mm 14mm;
        }
    }
    </style>
</head>

<body>

    <div class="container text-center my-3 d-print-none">
        <button onclick="window.print()" class="btn btn-dark">🖨️ Print Receipt</button>
    </div>

    <div class="receipt-container">
        <div class="gst-no">GST No. : 24BOXPP4375K1Z2</div>

        <header class="header-section">
            <img src="igclogo.png" alt="Logo">
            <h3>Operated By AKSHAR SCIENCE ACADEMY</h3>
            <h2>INFINITE GLOBAL CAREER</h2>
            <p><b>E-Mail :</b> Info@igcareer.org</p>
            <p><b>Contact us :</b> 8799268633 | <b>Website :</b> www.igcareer.org</p>
            <p>Ground Floor, Plot No 279 to 282/C, Iscon Mega City,<br> Nr. Victoriya Park, Vidya Nagar,
                Bhavnagar-364002</p>
        </header>

        <div class="info-box">
            <table>
                <tr>
                    <td style="width: 55%;"></td>
                    <td style="text-align:right;"><b>Receipt No. :</b> ___________________</td>
                </tr>
                <tr>
                    <td colspan="2" class="title">RECEIPT</td>
                </tr>
                <tr>
                    <td><b>Student ID No.</b> </td>
                    <td><b>Date :</b> ____ / ____ / ______</td>
                </tr>
                <tr>
                    <td><b>Membership Type :</b> </td>
                    <td><b>Fee Type :</b> Fees</td>
                </tr>
                <tr>
                    <td><b>Duration &nbsp;&nbsp;&nbsp;:</b> </td>
                    <td><b>TRANSACTION ID :</b> </td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>PAYMENT ID :</b> </td>
                </tr>
            </table>
        </div>

        <p class="section-title">Received With Thanks From</p>
        <p><b>Student Name :</b>
            __________________________________________________________________________________________</p>
        <p><b>Father Name &nbsp;&nbsp;:</b>
            ___________________________________________________________________________________________</p>

        <p><b>Contact No.&nbsp;&nbsp;&nbsp; :</b>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
            <span style="display:inline-block; border:1px solid #000; width:20px; height:20px;"></span>
        </p>

        <table class="table amount-table">
            <tbody>
                <tr>
                    <td colspan="2" class="header">AMOUNT RECEIVED</td>
                </tr>
                <tr>
                    <td style="width:50%;"><b>In Words :</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Fee Type :</b></td>
                    <td class="text-left">Enrollment Fees</td>
                </tr>
                <tr>
                    <td><b>Payment Mode :</b></td>
                    <td class="text-left">Online</td>
                </tr>
                <tr>
                    <td class="text-left" colspan="2">
                        <b>&nbsp;&nbsp;All disputes to Bhavnagar Jurisdiction Only.</b><br>
                        <b>&nbsp;&nbsp;Fees once Paid, Will Not Be Refundable.</b><br>
                        <b>&nbsp;&nbsp;Fees are including GST.</b>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="footer-notes">

            <p class="tnc"><b>*T & C Apply:</b> Student Career Counseling services & enrollment fees</p>
            <ol class="tnc">
                <li>Enrollment Fees & Membership fees will not refund once paid.</li>
                <li>Student can transfer membership to basic/premium/elite after paying upgrade fees.</li>
                <li>We provide tailor-made services as per student/parent requirements for extra services.</li>
                <li>Virtual & personal sessions are advance based on mutual availability.</li>
                <li>We provide best guidance & available information but no guaranteed outcome (college/job).</li>
                <li>Psychometric test result suggests as per personality; not exact job-role guarantee.</li>
            </ol>
        </div>
    </div>

</body>

</html>