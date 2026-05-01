<?php include './include/checklogin.php'; ?>
<?php $id = $_GET['id']; ?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="pac-form.css">

    <title>PAC Form 2</title>
</head>


<body style="line-height: 1;">

    <div class="a4-page mx-auto mt-3">
        <div class="col-md-12 d-flex">
            <div class="logo mt-2" style="margin-left: 10px;">
                <img src="gmiulogo.jpg" alt="" width="150px">
            </div>
            <div class="heading px-3 mt-2 bg-danger d-flex align-items-center rounded mr-auto"
                style="height: 35px; margin-left: 80px;">
                <h5 class="mb-0 text-white">PAC Form - (Part - 2)</h5>
            </div>

        </div>
        <div class="print-hr" style="height: 2px; background-color: #dc3545;"></div>
        <div class="d-flex justify-content-between col-md-12">
            <p class="font-weight-bold text-danger my-2 p-4 py-0" style="font-size: 13px; font-weight: bolder;">
                Eligibility
                Section
                (OFFICE COPY)</p>
            <p class="font-weight-bold text-danger my-2 p-4 py-0">Form No : 2024 / <?php
            $query = "SELECT pacid  FROM tbl_pac_form";
            $resultSet = $con->query($query);
            if ($resultSet) {
                $data = $resultSet->fetch_assoc();
                if ($data['pacid']) {
                    echo $data['pacid'];
                }
            }
            ?></p>
        </div>
        <div class="col-md-12 p-4 py-0">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Date of admission</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student No. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Faculty/Program Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Parents Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Level</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Mode</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Admission Type</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Quota</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Email ID</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Admission order status</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">CBPA status: Yes/NO</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Category</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 p-4 py-0 d-flex mt-0">
            <div class="col-md-4">
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">SSC (10<sup>th</sup>) Mark sheet of all attempt</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Diploma All Mark sheets</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Cast Certificate</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Income Certificate</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">7 Passport Size Photographs</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Registration Slip (ACPC)</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Admission Acknowledgement Slip (ACPC)</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Certificate for Defense Quota</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Medical Report (if any)</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Migration Certificate</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">HSC (12<sup>th</sup>) Mark sheet of all attempt</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">School Leaving Certificate</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Non Creamy Layer Certificate</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Adhar Card (Student & Parents)</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Bank Pass book / Cancel Cheque [Xe</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Fee Receipt for Registration Form</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Certificate for Physically Handicapp</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Anti-ragging Affidavit</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Attempt Certificate</p>
                </div>
                <div class="d-flex">
                    <input type="checkbox" class="ics">
                    <p class="cfs-10 text-danger mx-1 mb-1">Ex - Serviceman Certificate</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border" style="height: 100%; width: 100%;">
                    <p class="cfs-10 text-danger">Remarks :</p>
                    <div class="mt-auto">
                        <p class="cfs-10 text-danger">Name of Staff :</p>
                        <p class="cfs-10 text-danger">Signature of Staff :</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="print-hr" style="height: 2px; background-color: #dc3545;"></div>
        <div class="d-flex justify-content-between col-md-12">
            <p class="font-weight-bold text-danger my-2 p-4 py-0" style="font-size: 13px; font-weight: bolder;">Library
                (OFFICE COPY)</p>
            <p class="font-weight-bold text-danger my-2 p-4 py-0">Form No : 2024 / 1080</p>
        </div>
        <div class="col-md-12 p-4 py-0">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Date of admission</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Faculty/Program Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Parents Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Level</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Admission Type</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Medium (Guj/Eng)</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Birth Date</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Email ID</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Photo Submitted Status</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="print-hr" style="height: 2px; background-color: #dc3545;"></div>
        <div class="d-flex justify-content-between col-md-12">
            <p class="font-weight-bold text-danger my-2 p-4 py-0" style="font-size: 13px; font-weight: bolder;">
                Department
                (OFFICE COPY)</p>
            <p class="font-weight-bold text-danger my-2 p-4 py-0">Form No : 2024 / 1080</p>
        </div>
        <div class="col-md-12 p-4 py-0">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Date of admission</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Faculty/Program Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Parents Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Level</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Admission Type</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Email ID</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Whatsapp Number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="print-hr" style="height: 2px; background-color: #dc3545;"></div>
        <div class="d-flex justify-content-between col-md-12">
            <p class="font-weight-bold text-danger my-2 p-4 py-0" style="font-size: 13px; font-weight: bolder;">
                Account Section - 02
                (OFFICE COPY)</p>
            <p class="font-weight-bold text-danger my-2 p-4 py-0">Form No : 2024 / 1080</p>
        </div>
        <div class="col-md-12 p-4 py-0">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Date of admission</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Faculty/Program Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Parents Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Level</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Admission Type</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Quota</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Token fees amount</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Token fees Paid date</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Whatsapp Number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Remaining Semester fees</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Remaining fees pay date</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Remark</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13" colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="print-hr" style="height: 2px; background-color: #dc3545;"></div>
        <div class="d-flex justify-content-between col-md-12">
            <p class="font-weight-bold text-danger my-2 p-4 py-0" style="font-size: 13px; font-weight: bolder;">
                Account Section - 01
                (OFFICE COPY)</p>
            <p class="font-weight-bold text-danger my-2 p-4 py-0">Form No : 2024 / 1080</p>
        </div>
        <div class="col-md-12 p-4 py-0">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Date of admission</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Student Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Faculty/Program Name</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Parents Mo. number</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Level</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Admission Type</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Token fees amount</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Remaining Semester fees</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Token fees Paid date</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Remaining fees pay date</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13">Remark</td>
                        <td class="text-danger font-weight-bold col-md-3 cfs-13" colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center my-4">
        <button class="noprint btn btn-primary" onclick="window.print()">Print</button>
    </div>
</body>