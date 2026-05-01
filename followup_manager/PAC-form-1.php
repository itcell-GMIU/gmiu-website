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

    <title>PAC Form 1</title>

</head>

<body>
    <?php
    // SQL query to fetch data from the tbl_pac_form table
    $sqlQuery = "SELECT * FROM tbl_pac_form";
    $resultSet = $con->query($sqlQuery);

    // Check if any records are returned
    if ($resultSet->num_rows > 0) {
        // Loop through each row and display the data
        while ($row = $resultSet->fetch_assoc()) { ?>

            <div class="a4-page mx-auto mt-3">
                <div class="col-md-12 d-flex justify-content-between">
                    <div class="logo mt-2" style="margin-left: 10px;">
                        <img src="gmiulogo.jpg" alt="" width="200px">
                    </div>
                    <div class="heading px-3 mt-2 bg-danger d-flex align-items-center rounded" style="height: 50px;">
                        <h5 class="mb-0 text-white">PAC Form - (Part - 1)</h5>
                    </div>
                    <div class="formno p-3">
                        <p>Form No : 2024 /
                            <?php
                            $query = "SELECT pacid  FROM tbl_pac_form";
                            $resultSet = $con->query($query);
                            if ($resultSet) {
                                $data = $resultSet->fetch_assoc();
                                if ($data['pacid']) {
                                    echo $data['pacid'];
                                }
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 p-4 py-0 mt-3">

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="font-weight-bolder text-danger font-weight-bold col-md-4">Student Name</td>
                                <td class="font-weight-bolder text-danger font-weight-bold col-md-8">
                                    <?php echo $row['studentName']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Mobile number (Student)</td>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-8">
                                    <?php echo $row['studentMobile']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Mobile number (Parents)</td>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-8">
                                    <?php echo $row['parentMobile']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Level</td>
                                <td class="font-weight-bold col-md-8">
                                    <div class="d-flex mx-2">
                                        <div class="d-flex">
                                            <input type="checkbox" <?php echo ($row['mode'] == 'Reg') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">R</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['mode'] == 'DLMC') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">D</p>
                                        </div>
                                    </div>
                                </td> <!-- Empty cell for input -->
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Faculty / Program Name</td>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-8"><?php
                                $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = " . $row['faculty_id']);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo $row1['name'] . " / ";
                                }
                                $result3 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                while ($row3 = $result3->fetch_assoc()) {
                                    echo $row3['name'];
                                }
                                ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Level</td>
                                <td class="font-weight-bold col-md-8">
                                    <div class="d-flex">
                                        <div class="d-flex mx-2">
                                            <input type="checkbox">
                                            <p class="mb-0 text-danger mx-1">Diploma</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox">
                                            <p class="mb-0 text-danger mx-1">UG</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox">
                                            <p class="mb-0 text-danger mx-1">PG</p>
                                        </div>
                                    </div>
                                </td> <!-- Empty cell for input -->
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Admission Type</td>
                                <td class="font-weight-bold col-md-8">
                                    <div class="d-flex">
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['admissionType'] == '1st Year') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">1<sup>st</sup> Year</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['admissionType'] == '2nd Year') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">2<sup>nd</sup> Year</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['admissionType'] == 'Dual Degree') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">Dual Degree</p>
                                        </div>
                                    </div>
                                </td> <!-- Empty cell for input -->
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Branch / Specialization</td>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-8"> <?php echo $row['branchSpecialization']; ?></td> 
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Quota (UQ/MQ/VQ/SQ)</td>
                                <td class="font-weight-bold col-md-8">
                                    <div class="d-flex">
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['quota'] == 'UQ') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">UQ</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['quota'] == 'MQ') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">MQ</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['quota'] == 'VQ') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">VQ</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['quota'] == 'SQ') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">SQ</p>
                                        </div>
                                    </div>
                                </td> <!-- Empty cell for input -->
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-danger font-weight-bold col-md-4">Category</td>
                                <td class="font-weight-bold col-md-8">
                                    <div class="d-flex">
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['category'] == 'Open') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">OPEN</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['category'] == 'EWS') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">EWS</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['category'] == 'SEBC') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">SEBC</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['category'] == 'SC/ST') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-danger mx-1">SC/ST</p>
                                        </div>
                                    </div>
                                </td> <!-- Empty cell for input -->
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <td class="text-danger font-weight-bold text-center">Sr. No</td>
                                <td class="text-danger font-weight-bold">Department</td>
                                <td class="text-danger font-weight-bold">Authority Name & Mobile Number</td>
                                <td class="text-danger font-weight-bold">Stemp & Signature with Date</td>
                                <td class="text-danger font-weight-bold">Remark</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-danger font-weight-bold text-center">1</td>
                                <td class="text-danger font-weight-bold">Account Section - 01</td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold text-center">2</td>
                                <td class="text-danger font-weight-bold">Eligibility Section</td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold text-center">3</td>
                                <td class="text-danger font-weight-bold">Account Section - 02</td>
                                <td class="text-danger font-weight-bold" rowspan="3"></td>
                                <td class="text-danger font-weight-bold" rowspan="3"></td>
                                <td class="text-danger font-weight-bold" rowspan="3"></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold text-center">4</td>
                                <td class="text-danger font-weight-bold">Department</td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold text-center">5</td>
                                <td class="text-danger font-weight-bold">Library</td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold text-center">6</td>
                                <td class="text-danger font-weight-bold">Dress Code</td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold text-center">7</td>
                                <td class="text-danger font-weight-bold">Transportation (if needed)</td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                            </tr>
                            <tr>
                                <td class="text-danger font-weight-bold text-center">8</td>
                                <td class="text-danger font-weight-bold">Hostel (if needed)</td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                                <td class="text-danger font-weight-bold"></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="font-weight-bold text-danger mb-0" style="font-size: 13px;">&#8226;&nbsp;&nbsp;Provisional
                        admission will be confirmed after fill and submit this form to eligibility section.</p>
                </div>
                <div class="d-flex p-4 py-0 mt-3 justify-content-between">
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="text-danger font-weight-bold col-md-7">Admission order released by (Name)</td>
                                    <td class="text-danger font-weight-bold col-md-5"></td>
                                </tr>
                                <tr>
                                    <td class="text-danger font-weight-bold col-md-7">Admission order released on (Date)</td>
                                    <td class="text-danger font-weight-bold col-md-5"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <table class="table table-bordered col-md-12">
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-danger font-weight-bold" colspan="2" rowspan="2"><span
                                            style="font-weight: bold;">Stamp</span> <br> (Eligibility
                                        section)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr class="m-0 text-danger" style="height: 2px;">
                <div class="d-flex justify-content-between px-4">
                    <p class="font-weight-bold text-danger mb-0 cfs-13"><span style="font-weight: bolder;">Documents
                            Required:</span> (Please √ tick in the box for the
                        applicable)<span style="font-weight: bolder;">(STUDENT COPY)</span></p>
                    <p class="font-weight-bold text-danger mb-0 cfs-13">Form No : 2024 / 1080</p>
                </div>
                <div class="px-4">
                    <p class="font-weight-bold text-danger mb-0 cfs-10">Documents to be attached : (Please √ tick in the box for
                        the
                        applicable)</p>
                </div>
                <div class="col-md-12 p-4 py-0 d-flex mt-2">
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
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <td class="text-danger font-weight-bold col-md-6 cfs-10">Remaining Semester Fees</td>
                                    <td class="text-danger font-weight-bold col-md-6 cfs-10"></td>
                                </tr>
                                <tr>
                                    <td class="text-danger font-weight-bold col-md-6 cfs-10">Remaining Fees deadline</td>
                                    <td class="text-danger font-weight-bold col-md-6 cfs-10"></td>
                                </tr>
                                <tr>
                                    <td class="text-danger font-weight-bold col-md-6 cfs-10">Documents Submit deadline</td>
                                    <td class="text-danger font-weight-bold col-md-6 cfs-10"></td>
                                </tr>
                                <tr>
                                    <td class="text-danger font-weight-bold col-md-6 cfs-10">Documents Received by <br> (Name
                                        and signature)</td>
                                    <td class="text-danger font-weight-bold col-md-6 cfs-10"></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-between p-4 py-0 mt-2">
                    <div class="col-md-10">
                        <p class="text-danger font-weight-bold cfs-13">
                            <span style="text-decoration: underline;">Note:</span> Provisional admission will be confirmed after
                            filling and submit PAC form (Part-01) to eligibility section. Admission Will be confirmed subject to
                            approval by admission commited of university and goverment
                            concern adission bodies. For update about university activities, visit university website daily or
                            scan QR
                            code.
                        </p>
                    </div>
                    <div class="col-md-2 text-center">
                        <img src="qrcode.jpeg" alt="" height="80" width="80">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center my-4">
                <button class="noprint btn btn-primary" onclick="window.print()">Print</button>
            </div>

            <?php
        }
    } else {
        echo "No records found.";
    }
    ?>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>